<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all(); // Fetch all categories
        return view('back.ctegoryshow', compact('category'));
    }

    


  



    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create new Category instance
        $category = new Category();
        $category->name = $validated['name'];

        // Handle image upload
        if($request->hasFile("image")){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Category has been added successfully!');
    }



    public function edit($id)
    {
        $category = Category::findOrFail($id);  // Find the category by ID
        return view('back.categoryedit', compact('category')); // Show the edit form
    }

    // Update the specified category in the database
    public function update(Request $request, $id)
    {
        // Validate the form data
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the category to update
        $category = Category::findOrFail($id);
        $category->name = $validated['name'];

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image && file_exists(public_path('uploads/' . $category->image))) {
                unlink(public_path('uploads/' . $category->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        // Redirect with a success message
        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
    
    
    

}
