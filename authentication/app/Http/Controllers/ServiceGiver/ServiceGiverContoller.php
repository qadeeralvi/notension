<?php

namespace App\Http\Controllers\ServiceGiver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\ServiceGiver;
use Illuminate\Support\Facades\Auth;


class ServiceGiverContoller extends Controller
{
    
    function create(Request $request){
        //Validate Inputs
            $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:5|max:30',
                'cpassword'=>'required|min:5|max:30|same:password',
                'location'=>'required',

            ]);

            $user = new ServiceGiver();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->location = $request->location;
            $user->password = \Hash::make($request->password);
            $save = $user->save();

            if( $save ){
                return redirect()->back()->with('success','You are now registered successfully');
            }else{
                return redirect()->back()->with('fail','Something went wrong, failed to register');
            }
        }

    function check(Request $request){
        
         $request->validate([
            'email'=>'required|email|exists:service_givers,email',
            'password'=>'required|min:5|max:30'
         ],[
             'email.exists'=>'This email is not exists in service_givers table'
         ]);

         $creds = $request->only('email','password');

         if( Auth::guard('servicegiver')->attempt($creds) ){
             return redirect()->route('servicegiver.dashboard');
         }else{
             return redirect()->route('servicegiver.login')->with('fail','Incorrect credentials');
         }
    }

    function logout(){
        Auth::guard('servicegiver')->logout();
        return redirect()->route('servicegiver.login');
    }
}
