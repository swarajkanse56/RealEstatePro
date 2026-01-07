<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Property;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * Show the form to schedule a visit.
     */
 

public function create(Request $request)
{
    $properties = Property::with('category')->get();
    $categories = Category::all();
    $selectedProperty = null;

    if ($request->has('property_id')) {
        $selectedProperty = Property::with('category')->find($request->property_id);
    }

    return view('pages.shedulevisit', compact('properties', 'categories', 'selectedProperty'));
}



    /**
     * Store visit data submitted from the form.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,propertysid',
            'category_id' => 'required|exists:category,categoryid',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'required|string',
            'visit_date'  => 'required|date',
        ]);

        // Save visit
        Visit::create([
            'property_id' => $request->property_id,
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'visit_date'  => $request->visit_date,
        ]);

        return redirect()->route('visit.create')->with('success', 'Visit scheduled successfully!');
    }

    /**
     * Display a list of all visits.
     */
    public function index()
    {
        // Eager-load both property and its category
        $visits = Visit::with(['property.category'])->get();
        return view('back.visits', compact('visits'));
    }

    /**
     * Delete a specific visit.
     */
    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();

        return redirect()->route('visit.index')->with('success', 'Visit deleted successfully.');
    }
}
