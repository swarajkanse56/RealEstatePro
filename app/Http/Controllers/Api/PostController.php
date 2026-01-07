<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Property;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
 public function index(Request $request)
{
    $query = Property::query();

    // 🔍 SEARCH FILTER
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('subname', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('address', 'LIKE', "%{$search}%");
        });
    }

    // Filter by city
    if ($request->filled('city_id')) {
        $query->where('city_id', $request->city_id);
    }

    // Filter by category
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // Price range filter
    if ($request->filled('price_range')) {
        [$min, $max] = array_pad(explode('-', $request->price_range), 2, null);

        if (is_numeric($min)) {
            $query->where('price', '>=', (int)$min);
        }
        if (is_numeric($max)) {
            $query->where('price', '<=', (int)$max);
        }
    }

    // ❌❌❌ REMOVE THIS LINE: Don't filter by is_sold ❌❌❌
    // $query->where('is_sold', 0);

    // Load Relations + Pagination
    $properties = $query->with(['city', 'category', 'user'])
                        ->latest()
                        ->paginate(12);

    return response()->json([
        'success' => true,
        'data' => $properties,
        'filters' => [
            'cities' => City::all(),
            'categories' => Category::all(),
        ],
    ]);
}



    // ✅ This is the correct and only show() method you need
    public function show($id)
{
    $property = Property::with(['category', 'city', 'user'])->find($id);

    if (!$property) {
        return response()->json([
            'success' => false,
            'message' => 'Property not found',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $property,
    ]);
}




 public function store(Request $request)
{
    // Force JSON response even if the client forgets the Accept header
    $request->headers->set('Accept', 'application/json');

    // Validate input
    $validated = $request->validate([
        'property_id' => 'required|integer|exists:properties,propertysid',
        'category_id' => 'required|integer|exists:category,categoryid',
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|max:255',
        'phone'       => 'required|string|max:20',
        'visit_date'  => 'required|date|after_or_equal:today',
    ]);

    try {
        $visit = Visit::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Visit scheduled successfully!',
            'data'    => $visit,
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to schedule visit.',
            'error'   => $e->getMessage(),
        ], 400);
    }
}


public function createProperty(Request $request)
{
    try {
        // ✅ Validate all input
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'subname'     => 'nullable|string|max:255',
            'price'       => 'required|numeric',
            'category_id' => 'required|exists:category,categoryid', // 👈 match your DB table name
            'description' => 'nullable|string',
            'address'     => 'nullable|string|max:255',
            'city_id'     => 'required|exists:cities,citiesid',
            'phone'       => 'required|string|max:20', // or 'array' if multiple phones
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery'     => 'nullable|array',
            'gallery.*'   => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ❌ Validation failed
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // ✅ Create new property
        $property = new Property();
        $property->name = $validated['name'];
        $property->subname = $validated['subname'] ?? null;
        $property->price = $validated['price'];
        $property->category_id = $validated['category_id'];
        $property->description = $validated['description'] ?? null;
        $property->address = $validated['address'] ?? null;
        $property->city_id = $validated['city_id'];
        $property->phone = $validated['phone'];
        $property->user_id = $request->user()->id ?? null; // via Sanctum

        // ✅ Handle main image upload
        if ($request->hasFile('image')) {
            $mainImage = $request->file('image');
            $imageName = time() . '_main.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('uploads'), $imageName);
            $property->image = $imageName;
        }

        // ✅ Handle gallery uploads
        if ($request->hasFile('gallery')) {
            $galleryImageNames = [];
            foreach ($request->file('gallery') as $galleryImage) {
                $galleryImageName = time() . '_' . uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                $galleryImage->move(public_path('uploads'), $galleryImageName);
                $galleryImageNames[] = $galleryImageName;
            }
            $property->gallery = json_encode($galleryImageNames);
        }

        $property->save();

        // ✅ Return JSON success response
        return response()->json([
            'success' => true,
            'message' => 'Property added successfully!',
            'data'    => $property,
        ], 201);

    } catch (\Throwable $th) {
        // ✅ Return JSON on any unexpected error
        return response()->json([
            'success' => false,
            'message' => 'Server Error: ' . $th->getMessage(),
        ], 500);
    }
}
public function dropdowns()
{
    $cities = DB::table('cities')->select('citiesid', 'name')->get();
    $categories = DB::table('category')->select('categoryid', 'name')->get();

    return response()->json([
        'cities' => $cities,
        'categories' => $categories,
    ]);
}


public function storeCityApi(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'  => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    $data['name'] = $request->name;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        $file->move(public_path('uploads/cities'), $filename);
        $data['image'] = 'uploads/cities/' . $filename;
    }

    $city = City::create($data);

    return response()->json([
        'success' => true,
        'message' => 'City added successfully!',
        'data'    => $city
    ], 201);
}
public function storeCategoryApi(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'  => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    $category = new Category();
    $category->name = $request->name;

    if ($request->hasFile("image")) {
        $filename = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/categories'), $filename);
        $category->image = 'uploads/categories/' . $filename;
    }

    $category->save();

    return response()->json([
        'success' => true,
        'message' => 'Category added successfully!',
        'data'    => $category
    ], 201);
}


public function cityListApi()
{
    try {
        $cities = City::orderBy('name', 'asc')->get();

        return response()->json([
            'status' => true,
            'message' => 'City list fetched successfully',
            'data' => $cities
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage(),
        ], 500);
    }
}


 public function categoryByCity(Request $request)
{
    if (!$request->citiesid) {
        return response()->json([
            'success' => false,
            'message' => 'citiesid is required'
        ], 400);
    }

    $categories = Category::where('citiesid', $request->citiesid)->get();

    return response()->json([
        'success' => true,
        'data' => $categories
    ]);
}



public function propertyFilter(Request $request)
{
    $query = Property::query();

    if ($request->city_id) {
        $query->where('city_id', $request->city_id);
    }

   
    $properties = $query->get();

    return response()->json([
        'status' => true,
        'data' => $properties
    ]);
}



 public function ownerProperties($userId)
{
    $properties = Property::where('user_id', $userId)->get([
        'propertysid',
        'name', 
        'price',
        'image',
        'is_sold',      // ⬅️ YEH ADD KARO
        'created_at',   
        'updated_at'    
    ]);

    return response()->json([
        'success' => true,
        'properties' => $properties
    ]);
}



 


// API: Get all categories
 





    // Optional: implement these later
     
}
