<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use File;

class UserController extends Controller
{

    public function index() 
    {
        return view('welcome');
    }

    public function test()
    {
       dd(123);
    }

    public function loginUsingFacebook()
    {
        // return 123;
        return Socialite::driver('facebook')->redirect();
    }

 
    public function callbackFromFacebook()
    {
            $user = Socialite::driver('facebook')->stateless()->user();
            // dd($user);
            $checkUser = User::where('email',$user->getEmail())->first();
            if(!$checkUser) {
                $saveUser = User::updateOrCreate([
                    'facebook_id' => $user->getId(),
                ],[
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    // 'password' => Hash::make($user->getName().'@'.$user->getId()),
                    // 'role'=>2,
                ]);
            } else {
                $saveUser = User::where('email', $user->getEmail())->update([
                    'facebook_id'=> $user->getId(),
                    'name'=> $user->getName(),
                ]);
            }
            
            return response()->json([
                'status'=>200,
                'message'=>'LOGGED IN WITH FACEBOOK',
            ]);
    }

    public function loginUsingGoogle()
    {
        // return 123;
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
            $user = Socialite::driver('google')->stateless()->user();
            // dd($user);
            $checkUser = User::where('email',$user->getEmail())->first();
            if(!$checkUser) {
                $saveUser = User::updateOrCreate([
                    'google_id' => $user->getId(),
                ],[
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                ]);
            } else {
                $saveUser = User::where('email', $user->getEmail())->update([
                    'google_id'=> $user->getId(),
                    'name'=> $user->getName(),
                ]);
            }

            return response()->json([
                'status'=>200,
                'message'=>'LOGGED IN WITH GOOGLE',
            ]);

    }
}
