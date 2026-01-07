<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the profile of the currently authenticated user.
     */
    public function show()
    {
        $user = Auth::user();
        return view('back.profile.profile', compact('user'));
    }

    /**
     * Show another user's public profile by ID.
     */
 

    /**
     * Show the edit profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('back.profile.profileedit', compact('user'));
    }

    /**
     * Handle profile update for authenticated user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }


    public function view($id)
{
    $user = User::findOrFail($id);
    return view('pages.userprofile', compact('user'));
}


public function showProfile($id)
{
    $user = User::findOrFail($id);

    // Decode phone JSON if possible, else fallback to empty array
    $phones = json_decode($user->phone ?? '[]', true);

    // If decoded value is not array, treat phone as plain string (single number)
    if (!is_array($phones)) {
        $phones = [];
    }

    return view('pages.userprofile', compact('user', 'phones'));
}



}
