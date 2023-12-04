<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupportChat extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sender_id',
        'send_to_id',
        'send_to',
        'message',
        'send_by',
        'date',
        'time',
        
    ];
    
    
}
