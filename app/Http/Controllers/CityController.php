<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

 
class CityController extends Controller
{
public function index()
{
    $cities = City::orderBy('name', 'asc')->get(); // sort alphabetically by city name
    return view('back.citylist', compact('cities'));
}




    public function create()
{
    return view('back.cityform'); // Update this to the correct form view path
}

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:cities,name',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only('name');

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/cities'), $filename);
        $data['image'] = 'uploads/cities/' . $filename;
    }

    City::create($data);

    return redirect()->route('cities.index')->with('success', 'City added successfully!');
}



    public function edit($id)
{
    $city = City::findOrFail($id);
    return view('back.cityedit', compact('city'));
}


 public function update(Request $request, $id)
{
    $city = City::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255|unique:cities,name,' . $id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only('name');

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/cities'), $filename);
        $data['image'] = 'uploads/cities/' . $filename;
    }

    $city->update($data);

    return redirect()->route('cities.index')->with('success', 'City updated successfully!');
}



public function destroy($id)
{
    $city = City::findOrFail($id);

    // Optional: delete image file from disk
    if ($city->image && file_exists(public_path($city->image))) {
        unlink(public_path($city->image));
    }

    $city->delete();

    return redirect()->route('cities.index')->with('success', 'City deleted successfully!');
}



}
