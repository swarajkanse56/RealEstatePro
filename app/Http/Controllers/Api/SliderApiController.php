<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PropertySlider;
use Illuminate\Http\Request;

class SliderApiController extends Controller
{
    public function index()
    {
        $sliders = PropertySlider::with(['property' => function($q){
            $q->select('propertysid','name','price','image','city_id');
        }])->get();

        return response()->json([
            "status" => true,
            "message" => "Slider loaded successfully",
            "data" => $sliders
        ], 200);
    }
}
