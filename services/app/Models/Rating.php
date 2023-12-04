<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
     protected $fillable = [
        'job_id',
        'provider_id',
        'user_id',
        'comment',
        'comment_given_by',
        'stars',
        'comment_at',
    ];
    
     public function job(){

        return $this->belongsTo(JobManagement::class,'job_id');

    }
    
}
