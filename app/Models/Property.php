<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    // Define custom primary key
protected $primaryKey = 'propertysid';

    // If the primary key is not auto-incrementing or not an integer, also add:
    // public $incrementing = false;
    // protected $keyType = 'string';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'name',
        'subname',
        'price',
        'category_name',
        'description',
        'address',
        'image',
    ];

    // Tell Laravel to use 'propertysid' for route model binding
    public function getRouteKeyName()
    {
        
       return 'propertysid';
    }

    // Property.php
public function category()
{
    return $this->belongsTo(Category::class, 'category_id', 'categoryid');
}

// App\Models\Property.php

public function city()
{
    return $this->belongsTo(City::class, 'city_id', 'citiesid');
}



public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

public function sliders()
{
    return $this->hasMany(PropertySlider::class, 'property_id', 'propertysid');
}








}
