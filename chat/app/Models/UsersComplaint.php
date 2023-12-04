<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersComplaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'complainer_id',
        'complaint_against_id',
        'complaint_type',
        'complaint_detail',
        'complaint_against_type',
        'service_id',
        'file',
    ];



    public function complaintChat(){

        return $this->hasMany(ComplaintChat::class,'complaint_id')->orderBy('created_at','ASC');

    }

}
