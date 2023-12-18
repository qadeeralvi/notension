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

class UserApiController extends Controller
{
    public function userRegistration (Request $request) 
    {
        if(!isset($request->signupmethod)){
            
             return response()->json([
                'status'=>203,
                'message'=>'signupmethod paramter is missing',
            ]);
        }
        
        if($request->signupmethod=="email"){

                if(!isset($request->email) || !isset($request->name) || !isset($request->phone_no) || !isset($request->address) || !isset($request->password)){
                    
                    return response()->json([
                        'status'=>203,
                        'message'=>'Some paramter is missing',
                    ]);
                    
                }
        }
        
        elseif($request->signupmethod=="google" || $request->signupmethod=="facebook"){
            
              if(!isset($request->email) || !isset($request->password) || !isset($request->socialprofile)){
                
                return response()->json([
                    'status'=>203,
                    'message'=>'Some paramter is missing',
                ]);
                
            }
        }
        
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status'=>203,
                'message'=>'Invalid email format',
            ]);
        }
        
        $user_exit = User::where('email',$request->email)->first();
            
        if($user_exit){
              if($request->device_token!=''){
              
                    $user_exit->device_token=$request->device_token;
                    $user_exit->save();
              }
            return response()->json([
                'status'=>400,
                'message'=>'Already User exit',
                'user_id'=> $user_exit->id,
            ]);
        }else{

        }
       
        $password = Hash::make($request->password);
        $confirmPassword = Hash::make($request->confirm_password);
        $request->merge([ "password"=>$password, 'confirm_password'=>$confirmPassword]);

        $user = User::create($request->all());

        $data = array(
            'name'=>$user->name
        );
        
        Mail::to($request->email)->send(new RegisterGreetingMail($data));

        return response()->json([
            'status'=>200,
            'message'=>'Registered Successfully',
            'user'=>$user,
        ]);
    }

    public function login(Request $request)
    {
        
        if(!isset($request->email) || !isset($request->password) ){
            
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
         $user_exit = User::where('email',$request->email)->first();
         
          if($user_exit){
              
              
              if($user_exit->status=='inactive' || $user_exit->status=='suspend' ){
                
                 return response()->json([
                        'status' => 203,
                        'message' => 'you dont allow to login because your account is'.$user_exit->status,
                    ]);
                }
            
              if($request->device_token!=''){
              
                    $user_exit->device_token=$request->device_token;
                    $user_exit->save();
              }
              
                 if($user_exit->signupmethod=='goolge' || $user_exit->signupmethod=='facebook'){
                    
                     return response()->json([
                            'status'=>201,
                            'message'=>'Already User exit',
                            'user_id'=> $user_exit->id,
                        ]);
                    
                }      
              
            }
        
        $input = $request->only('email', 'password');
        $jwt_token = null;
  
        if (!$jwt_token = JWTAuth::attempt($input, 'users')) {
            return response()->json([
                'status'=>400,
                'success' => false,
                'message' => 'Invalid Email or Password',
            ]);
        }
  
       return $this->respondWithToken($jwt_token,'user');
    }

    protected function  respondWithToken($token,$type){

        return response()->json([
            'status' => 200,
            'type' => ($type!=''?'user':"provider"),
            'access_token' => $token,
            'user_id' => Auth::user()->id,
            'profile_img' => 0,
            'token_type' => 'Bearer',
        
        ]);

    }

    public function user_update(Request $request)
    {
        
        $user = User::findOrFail($request->user_id);
        
        $user_name = (isset($request->name))?$request->name:$user->name;
        
        $phone_no = (isset($request->phone_no ))?$request->phone_no :$user->phone_no;
        
        $address = (isset($request->address))?$request->address:$user->address;
        
        $mobile_verification = (isset($request->mobile_verification))?$request->mobile_verification:$user->mobile_verification;
        
        $socialprofile = (isset($request->socialprofile))?$request->socialprofile:$user->socialprofile;
        
          if(isset($request->old_password)){
            
            $old_password = Hash::make($request->old_password);
            if (!(Hash::check($request->old_password, $user->password))) { 
                
                    return response()->json([
                        'status'=>403,
                        'message'=>'Password not matched',
                    ]);
            }
         }
        
        
        $password = (isset($request->password))?Hash::make($request->password):$user->password;
        
        
        
         if($request->hasFile('image')) {
    
                        $file = $request->file('image');
                        
                        $img_ext = $file->getClientOriginalExtension();
                        
                        if($img_ext=='jpeg' || $img_ext=='png' || $img_ext=='jpg' || $img_ext=='webp'){
                        
                        
                            $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
        
                            $image['filePath'] = $name;
        
                            $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;
        
                            $file->move(public_path().'/user_profile_imgs/', $file_name);
                        }
                        
                        else{
                            return response()->json([
                                'status'=>404,
                                'message'=>'Image is not correct',
                            ]); 
                        }
    
            }
            
        $user->name = $user_name;
        
        $user->phone_no = $phone_no;
        
        $user->address = $address;
        
        $user->password = $password;
        
        $user->mobile_verification = $mobile_verification;
        
        $user->socialprofile = $socialprofile;
        
        $user->profile_img =  (!empty($file_name))?$file_name:$user->profile_img;
         
        $user->save();
        
         return response()->json([
            'status'=>200,
            'message'=>'Updated Successfully',
            'user'=>$user,
        ]);
      
    }

    public function user_forget(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $code = rand(111111,999999);
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

                return response()->json([ 'status' => 404,'message'=>'User not found' ]);
            }
    }
    
    public function use_verify_code(Request $request)
    {
       
        $user = User::where('email',$request->email)->first();

        if ($user->forget_email_code==$request->code) { 

                return response()->json([ 
                    
                        'status' => 200 ,
                        'user_id'=>$user->id,
                        'message' => 'Code matched' 
                    ]);
            }

            else{

                return response()->json([ 'status' => 404,'message'=>'Code not matched' ]);
            }
    }
    
    public function check_user_email(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        
        if($user==null){
                    return response()->json([
                        'status'=>404,
                        'message'=>'email not exits',
                    ]);
        }
        else{
            return response()->json([
                        'status'=>200,
                        'message'=>'Email already exits',
                        'user_id'=>$user->id,
                    ]);
        }
    }

    public function check_user_phone(Request $request)
    {
        
        $user = User::where('phone_no',$request->phone_no)->first();
        
        if($user==null){
            return response()->json([
                        'status'=>404,
                        'message'=>'Phone not exits',
                    ]);
        }
        else{
            return response()->json([
                        'status'=>200,
                        'message'=>'Phone already exits',
                        'user_id'=>$user->id,
                    ]);
        }
    }
    
    public function change_user_status(Request $request)
    {
         if(!isset($request->user_id) || !isset($request->status)){
            
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
         $user_exit = User::where('id',$request->user_id)->first();
         
          if($user_exit){
              
              $user_exit->status = $request->status;
              $user_exit->save();
              
            return response()->json([
                'status'=>200,
                'message'=>'Action Successfully',
            ]);
            
          }
          
          else{
              
               return response()->json([
                'status'=>404,
                'message'=>'not found',
            ]);
            
          }
          
    }
    
    public function user_info(Request $request)
    {
         if(!isset($request->id)){
            
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
         $user_exit = User::where('id',$request->id)->first();
         
          if($user_exit){
              
            return response()->json([
                'status'=>200,
                'user' => $user_exit,
                'message'=>'Fetch Successfully',
            ]);
            
          }
          
          else{
              
               return response()->json([
                'status'=>403,
                'message'=>'UnSuccessfully',
            ]);
            
          }
          
    }

}
