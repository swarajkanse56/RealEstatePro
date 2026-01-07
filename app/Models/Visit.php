<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

 class Visit extends Model
{
    protected $fillable = [
        'property_id','category_id', 'name', 'email', 'phone', 'visit_date'
    ];

    // ✅ Define the relationship with Property model
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'propertysid');
    }


    public function category()
{
    return $this->belongsTo(\App\Models\Category::class, 'category_id', 'categoryid');
}
}