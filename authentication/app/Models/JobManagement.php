<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobManagement extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id','title','category','sub_category','phone','name','city','address','description','date','time','status'
    ];

    public function status(){

        return $this->belongsTo(JobStatus::class,'job_id');

    }
    
}
