<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;

    protected $fillable=[
        'job_id','end_date','end_time','maximum','minimum','location','less_assign','last_assign','maximum_rating','providers'
    ];

}
