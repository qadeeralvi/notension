<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobManagement extends Model
{
    use HasFactory;
    protected $fillable=[
       'user_id','title','category','sub_category','phone','name','email','city','address','description','date','time','status','image','who_you','your_cost','job_start','company_contact_you'
    ];

   
    public function catDetail(){

        return $this->belongsTo(Category::class,'category');

    }
    
    public function subCatDetail(){

        return $this->belongsTo(Sub_category::class,'sub_category');

    }
    
    public function jobActiveDetail(){

        return $this->hasMany(JobActive::class,'job_id');

    }
    
}
