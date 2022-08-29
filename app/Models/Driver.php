<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


class Driver extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $guard = 'driver';
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
    ];
}
