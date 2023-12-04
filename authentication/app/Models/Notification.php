<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $fillable = ['sent_to_id','action_id','action_type','sent_to','title', 'message', 'seen','datetime', 'created_at', 'updated_at'];
}
