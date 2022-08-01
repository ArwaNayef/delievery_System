<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
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
