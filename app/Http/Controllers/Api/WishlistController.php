<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,propertysid'
        ]);

        $user = $request->user();
        $property_id = $request->property_id;

        $existing = Wishlist::where('user_id', $user->id)
                            ->where('property_id', $property_id)
                            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'status' => true, 
                'favorite' => false,
                'message' => 'Removed from wishlist'
            ]);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'property_id' => $property_id
        ]);

        return response()->json([
            'status' => true, 
            'favorite' => true,
            'message' => 'Added to wishlist'
        ]);
    }

    public function list(Request $request)
    {
        $wishlist = Wishlist::with(['property.category', 'property.city'])
                            ->where('user_id', $request->user()->id)
                            ->get();
        
        return response()->json([
            'status' => true, 
            'data' => $wishlist
        ]);
    }

    public function checkWishlistStatus(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,propertysid'
        ]);

        $isFavorite = Wishlist::where('user_id', $request->user()->id)
                             ->where('property_id', $request->property_id)
                             ->exists();

        return response()->json([
            'status' => true,
            'favorite' => $isFavorite
        ]);
    }
}