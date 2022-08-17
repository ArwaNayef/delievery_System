<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use HasFactory;
    protected $guard = 'driver';
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
    ];
}
