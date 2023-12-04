<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    
     protected $fillable = [ 'sender_id', 'receiver_id','message', 'deliver_date','deliver_time','seen','seen_date','seen_time','send_to'
    
    ];
}
