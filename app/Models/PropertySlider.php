<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertySlider extends Model
{
    protected $fillable = [
        'property_id',
        'image',
        'title',
        'subtitle',
        'discount'
    ];

    public function property(){
        return $this->belongsTo(Property::class, 'property_id', 'propertysid');
    }
}
