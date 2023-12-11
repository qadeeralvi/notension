<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Validator;
use JWTAuth;
use App\Models\User;
use App\Models\ServiceGiver;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\AssignedPermission;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helper\GlobalHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use App\Mail\RegisterGreetingMail;
use App\Mail\ForgetMail;

class AuthApiController extends Controller
{
    public function user_forget(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $code = $request->code;
        if ($user) { 

                Mail::to($user['email'])->send(new ForgetMail($code));

                User::where('id',$user->id)->update([

                        'forget_email_code'=>$code,
                ]);

                return response()->json([ 
                    
                        'status' => 200 ,
                        'message' => 'Check your email' 
                    ]);
            }

            else{

                return response()->json([ 'status' => 404,'message'=>'Provider not found' ]);
            }
    }
}
