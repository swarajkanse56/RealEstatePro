<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Property;

class AdminController extends Controller
{
    // ✅ 1. Notification Form Page (Admin View)
    public function notificationPage()
    {
        // Tumhare project me primary key = propertysid
        $properties = Property::orderBy('propertysid', 'DESC')->get();

        return view('back.Notification.send-notification', compact('properties'));
    }

    // ✅ 2. Send Notification to Users (OneSignal)
    public function sendNotification(Request $request)
    {
        
        // ✅ Final Safe Validation
        if (!$request->filled('title')) {
            return back()->with('error', 'Title is required!');
        }

        if (!$request->filled('property_id')) {
            return back()->with('error', 'Please select a property!');
        }

        $title = $request->title;
        $propertyId = $request->property_id;

        // ✅ IMPORTANT FIX: propertysid ke base pe find
        $property = Property::where('propertysid', $propertyId)->first();

        if (!$property) {
            return back()->with('error', 'Property not found!');
        }

        // ✅ Get all users who have OneSignal ID saved
        $playerIds = User::whereNotNull('onesignal_id')
            ->pluck('onesignal_id')
            ->toArray();

        if (count($playerIds) == 0) {
            return back()->with('error', 'No users found for notification!');
        }

        try {
            // ✅ OneSignal API Call
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . config('onesignal.api_key'),
                'Content-Type'  => 'application/json',
            ])->post('https://onesignal.com/api/v1/notifications', [
                'app_id' => config('onesignal.app_id'),

                // ✅ REAL USER TARGETING
                'include_player_ids' => $playerIds,

                'headings' => [
                    'en' => $title,
                ],
                'contents' => [
                    'en' => $property->name,
                ],

                // ✅ Future use: notification click pe direct property open
                'data' => [
                    'propertysid' => $property->propertysid,
                ],
            ]);

            if ($response->failed()) {
                return back()->with('error', 'Notification OneSignal se fail ho gayi!');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Server Error: ' . $e->getMessage());
        }

        return back()->with('success', 'Notification sent successfully!');
    }

 public function saveOneSignalId(Request $request)
{
    try {
        // ✅ Token se logged-in user lo (MOST IMPORTANT FIX)
        $user = auth()->user();

        // ✅ Agar token invalid ya user login nahi hai
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized user'
            ], 401);
        }

        // ✅ Validation
        $request->validate([
            'onesignal_id' => 'required|string',
        ]);

        // ✅ OneSignal ID save karo
        $user->onesignal_id = $request->onesignal_id;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'OneSignal ID saved successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Server Error',
            'error' => $e->getMessage()
        ], 500);
    }
}




}
