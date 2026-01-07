<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // Display all properties
 
 
 public function index(Request $request)
{
    $query = Property::query();

    // Optional city filter
    if ($request->filled('city_id')) {
        $query->where('city_id', $request->city_id);
    }

    // Optional category filter
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // Optional price range filter (format: "1000000-5000000" or "1000000-" or "-5000000")
    if ($request->filled('price_range')) {
        [$min, $max] = array_pad(explode('-', $request->price_range), 2, null);

        if (is_numeric($min)) {
            $query->where('price', '>=', (int)$min);
        }

        if (is_numeric($max)) {
            $query->where('price', '<=', (int)$max);
        }
    }

    // Eager load relationships and paginate results
    $properties = $query->with(['city', 'category', 'user'])->paginate(12);

    // For dropdown filters
    $cities = City::all();
    $categories = Category::all();

    return view('pages.property', compact('properties', 'cities', 'categories'));
}







    // Store a new property  
 public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'subname' => 'nullable|string|max:255',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:category,categoryid',
        'description' => 'nullable|string',
        'address' => 'nullable|string|max:255',
        'city_id' => 'required|exists:cities,citiesid',
        'phone' => 'required|string|max:20',  // if only one phone expected
        // OR use 'phone' => 'required|array' if multiple phones expected
        // and 'phone.*' => 'string|max:20' for validation of each phone
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'gallery' => 'nullable|array',
        'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $property = new Property();
    $property->name = $validated['name'];
    $property->subname = $validated['subname'] ?? null;
    $property->price = $validated['price'];
    $property->category_id = $validated['category_id'];
    $property->description = $validated['description'] ?? null;
    $property->address = $validated['address'] ?? null;
    $property->city_id = $validated['city_id'];

    // Save phone as string or JSON string if multiple phones expected:
    // For one phone:
    $property->phone = $validated['phone'];

    // If you want to accept multiple phones from form as array:
    // $property->phone = json_encode($validated['phone']);

    // Assign user_id if logged in
    $property->user_id = auth()->check() ? auth()->id() : null;

    // Handle main image upload
    if ($request->hasFile('image')) {
        $mainImage = $request->file('image');
        $imageName = time() . '_main.' . $mainImage->getClientOriginalExtension();
        $mainImage->move(public_path('uploads'), $imageName);
        $property->image = $imageName;
    }

    // Handle gallery images upload
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

    return redirect()->back()->with('success', 'Property has been added successfully!');
}









 

public function create()
{
    $categories = Category::all();
    $cities = City::all();

    return view('pages.postproperty', compact('categories', 'cities'));
}




public function showpropertydata()
{
    $properties = Property::join("category", "properties.category_id", "=", "category.categoryid")
        ->select("category.name as category_name", "properties.*")
        ->get();

    return view('back.propertieslist', compact('properties'));
}





public function destroy($propertyId)
{
    // Find the property by ID
    $property = Property::findOrFail($propertyId);

    // Delete the property (and optionally the image if needed)
    if ($property->image && file_exists(public_path('uploads/' . $property->image))) {
        unlink(public_path('uploads/' . $property->image));  // Delete the image file
    }
    $property->delete();

    // Redirect back with success message
    return redirect()->route('property.list')->with('success', 'Property deleted successfully!');
}



public function edit($id)
{
    $property = Property::findOrFail($id);
    $categories = Category::all();
    $cities = City::all();
    return view('back.propertyedit', compact('property', 'categories', 'cities'));
}



public function update(Request $request, $propertyId)
{
    // Validate the input data
    $request->validate([
        'name' => 'required|string|max:255',
        'subname' => 'nullable|string|max:255',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:category,categoryid',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 👈 main image
        'gallery' => 'nullable|array',
        'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 👈 gallery images
        'description' => 'nullable|string',
        'address' => 'nullable|string',  
        'city_id' => 'required|exists:cities,citiesid',
    ]);

    // Find the property by ID
    $property = Property::findOrFail($propertyId);

    // Update the property attributes
    $property->name = $request->input('name');
    $property->subname = $request->input('subname');
    $property->price = $request->input('price');
    $property->category_id = $request->input('category_id');
    $property->description = $request->input('description');
    $property->address = $request->input('address');
    $property->category_id = $request['category_id'];
    $property->city_id = $request['city_id'];


    // Handle image upload if a new image is uploaded
     // ✅ Handle main image
    if ($request->hasFile('image')) {
        $mainImage = $request->file('image');
        $imageName = time() . '_main.' . $mainImage->getClientOriginalExtension();
        $mainImage->move(public_path('uploads'), $imageName);
        $property->image = $imageName;
    }

    // ✅ Handle gallery images
    if ($request->hasFile('gallery')) {
        $galleryImageNames = [];
        foreach ($request->file('gallery') as $galleryImage) {
            $galleryImageName = time() . '_' . uniqid() . '.' . $galleryImage->getClientOriginalExtension();
            $galleryImage->move(public_path('uploads'), $galleryImageName);
            $galleryImageNames[] = $galleryImageName;
        }
        $property->gallery = json_encode($galleryImageNames);
    }

    // Save the updated property data
    $property->save();

    // Redirect back with success message
    return redirect()->route('property.list')->with('success', 'Property updated successfully!');
}




public function show($propertyId)
{
    // Find the property by ID and join with the category
    $property = Property::join('category', 'properties.category_id', '=', 'category.categoryid')
        ->select('category.name as category_name', 'properties.*')
        ->where('properties.propertysid', $propertyId)
        ->first(); // Get the first matching property

    // Return the view with the property data
    return view('back.viewproperty', compact('property'));
}
public function showpropertylist()
{
    // Get properties and categories
    $properties = Property::with('category')->get();
    $properties = Property::with(['category', 'city'])->get();  // eager load city and category

    $categories = Category::all(); // Fetch all categories
    
    return view('pages.property', compact('properties', 'categories'));
}

public function categoryProperties($id)
{
    $category = Category::findOrFail($id);
    $properties = Property::where('category_id', $id)->get();

    return view('pages.category_propertyshow', compact('properties', 'category'));
    
}


public function showP($id)
    {
        $property = Property::with('category')->findOrFail($id);
        return view('pages.propertyview', compact('property'));
    }
public function propertiesByCity($id)
{
    $city = City::findOrFail($id);
    $categories = Category::all();
    $properties = Property::where('city_id', $id)->with(['category', 'city'])->get();

    return view('pages.property', compact('properties', 'categories', 'city'));
}


    
 
 

 


 
 
 



}
