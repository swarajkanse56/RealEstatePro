<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $primaryKey = 'citiesid'; // Important if not using default 'id'
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['name', 'image'];
}
