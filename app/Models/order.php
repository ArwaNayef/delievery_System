<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'details',
        'from_address',
        'to_address',
        'time_to_deliver',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
