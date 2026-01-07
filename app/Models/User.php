<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens; // 👈 ADD THIS
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // 👈 ADD HasApiTokens HERE

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
       'profile_pic',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
