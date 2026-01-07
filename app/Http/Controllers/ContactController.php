<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Contacts;

class ContactController extends Controller
{


    

public function index()
{
    $contacts = Contacts::all(); // Fetch all contacts
    return view('back.contact', compact('contacts'));
}







    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string', // If you add a message field
        ]);

        // Store the data
        Contacts::create($validated);

        // Redirect or return success response
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}

