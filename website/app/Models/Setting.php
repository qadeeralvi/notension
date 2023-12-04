<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'number','email','facebook','instagram','linkdin','youtube','twitter','logo','favicon','status'
    ];

}
