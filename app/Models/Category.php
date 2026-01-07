<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

 
    // Table name if it doesn't follow the Laravel convention
    protected $table = 'category';

    // Primary key of the category table
    protected $primaryKey = 'categoryid';

    // Fillable fields to allow mass assignment
    protected $fillable = ['name', 'image'];

    // Define the relationship to properties
    public function properties()
    {
        return $this->hasMany(Property::class, 'category_id', 'categoryid');  // Specify foreign key and local key
    }


    
}
