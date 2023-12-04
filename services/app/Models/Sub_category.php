<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'days',
        'end_time',
        'minimum',
        'maximum',
        'less_assign',
        'location',
        'last_assign',
        'maximum_rating',
        'price',
        'image',
    ];

    public function category(){

        return $this->belongsTo(Category::class,'category_id');

    }

}
