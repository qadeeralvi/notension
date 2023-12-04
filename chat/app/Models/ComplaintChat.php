<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'admin_id',
        'complaint_id',
        'message',
        'date',
        'time',
        'send_by',
    ];
    
}
