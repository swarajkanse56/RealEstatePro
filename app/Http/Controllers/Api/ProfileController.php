<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // ✅ Fetch logged-in user via Sanctum token
 public function getProfile(Request $request)
{
    try {

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please login again.'
            ], 401);
        }

        // ✅ My Properties
        $myProperties = Property::where('user_id', $user->id)
            ->get()
            ->map(function ($property) {
                return [
                    'propertysid' => $property->propertysid,
                    'name'        => $property->name,
                    'price'       => $property->price,
                    'image'       => $property->image,
                    'is_sold'     => $property->is_sold,
                    'created_at' => $property->created_at
                ];
            });

        // ✅ ✅ ✅ FAVORITES — SAFE NULL CHECK ADDED (IMPORTANT FIX)
        $favoriteProperties = Wishlist::with('property')
            ->where('user_id', $user->id)
            ->get()
            ->filter(function ($wishlist) {
                return $wishlist->property != null; // 🔥 NULL property removed
            })
            ->map(function ($wishlist) {

                $property = $wishlist->property;

                return [
                    'propertysid' => $property->propertysid,
                    'name'        => $property->name,
                    'price'       => $property->price,
                    'image'       => $property->image,
                    'is_sold'     => $property->is_sold,
                    'created_at' => $property->created_at
                ];
            });

        // ✅ Counts
        $totalProperties  = $myProperties->count();
        $soldCount        = $myProperties->where('is_sold', 1)->count();
        $favoritesCount  = $favoriteProperties->count();

        return response()->json([
            'status' => true,
            'data' => [
                'id'                 => $user->id,
                'name'               => $user->name,
                'email'              => $user->email,
                'phone'              => $user->phone,
                'created_at'         => $user->created_at,
                'my_properties'      => $myProperties,
                'favorite_properties'=> $favoriteProperties,
                'properties_count'  => $totalProperties,
                'sold_count'        => $soldCount,
                'favorites_count'   => $favoritesCount,
            ],
        ], 200);

    } catch (\Exception $e) {

        // ✅ REAL ERROR RETURN (DEBUG PURPOSE)
        return response()->json([
            'status' => false,
            'message' => 'Profile API Error',
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}


    // ✅ Optional: Update profile
 // app/Http/Controllers/Api/ProfileController.php
public function updateProfile(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $user->id,
        'phone' => 'sometimes|string|max:20', 
    ]);

    // 1. Update the user data
    $user->update($validated);

    // 2. 🔥 FIX: Revoke old token and issue a NEW token (This solves the 401 after update)
    $user->tokens()->delete(); // Revoke all old tokens linked to this session
    $newToken = $user->createToken('api_token')->plainTextToken;

    // 3. Return the new token and user data
    return response()->json([
        'status' => true,
        'message' => 'Profile updated successfully. New token issued.',
        'data' => $user,
        'token' => $newToken // <-- Flutter app MUST save this new token
    ]);
}


    public function deleteProperty($id)
{
    $property = Property::find($id);

    if (!$property) {
        return response()->json([
            'status' => false,
            'message' => 'Property not found'
        ], 404);
    }

    // Delete image file (optional)
    if ($property->image && file_exists(public_path('images/' . $property->image))) {
        unlink(public_path('images/' . $property->image));
    }

    $property->delete();

    return response()->json([
        'status' => true,
        'message' => 'Property deleted successfully'
    ]);
}


public function markAsSold(Request $request)
    {
        $request->validate([
            'propertysid' => 'required'
        ]);

        $property = Property::where('propertysid', $request->propertysid)->first();

        if (!$property) {
            return response()->json([
                'status' => false,
                'message' => 'Property not found'
            ], 404);
        }

        // ✅ Sirf owner hi SOLD kar sakta hai
        if ($property->user_id != auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // 🔥 ONLY update is_sold column
        $property->is_sold = 1;
        $property->save();

        return response()->json([
            'status' => true,
            'message' => 'Property marked as SOLD successfully'
        ]);
    }



}
