<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertySlider;

class SliderController extends Controller
{
    public function index()
    {
       $sliders = PropertySlider::with('property')->get();
return view('slider.index', compact('sliders'));

    }

  public function create()
{
    $properties = Property::with('city')->get();
    return view('slider.create', compact('properties'));
}


    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'nullable|exists:properties,propertysid',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'discount' => 'nullable|string'
        ]);

        $fileName = null;
        if ($request->hasFile('image')) {
            $fileName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $fileName);
        }

        PropertySlider::create([
            'property_id' => $request->property_id,
            'image' => $fileName,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'discount' => $request->discount,
        ]);

        return redirect()->route('sliders.index')->with('success', 'Slider added successfully');
    }

    public function destroy($id)
    {
        $slider = PropertySlider::findOrFail($id);

        if ($slider->image && file_exists(public_path('uploads/' . $slider->image))) {
            unlink(public_path('uploads/' . $slider->image));
        }

        $slider->delete();

        return redirect()->back()->with('success', 'Slider deleted successfully');
    }
}
