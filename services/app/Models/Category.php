<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'days',
        'end_time',
        'minimum',
        'maximum',
        'less_assign',
        'location',
        'last_assign',
        'maximum_rating',
        'status',
        'price',
        'image',
    ];

    
}
