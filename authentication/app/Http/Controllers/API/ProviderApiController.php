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

class ProviderApiController extends Controller
{
    public function serviceProviderRegistration (Request $request) 
    {
        
        if(!isset($request->signupmethod)){
            
             return response()->json([
                'status'=>400,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        if($request->signupmethod=="email"){

        
             if(!isset($request->email)  || !isset($request->name) || !isset($request->location) || !isset($request->phone)  || !isset($request->password) ){
                
                return response()->json([
                    'status'=>400,
                    'message'=>'Some paramter is missing',
                ]);
                
            }
        }
        
        
        elseif($request->signupmethod=="google" || $request->signupmethod=="facebook"){
            
              if(!isset($request->email) || !isset($request->password) ){
                
                return response()->json([
                    'status'=>400,
                    'message'=>'Some paramter is missing',
                ]);
                
            }
        }
        
       
   
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status'=>400,
                'message'=>'Invalid email format',
            ]);
        }
        
         $user_exit = ServiceGiver::where('email',$request->email)->first();
            
        if($user_exit){
            
            return response()->json([
                'status'=>400,
                'provider_id' => $user_exit->id,
                'message'=>'Already Service Provider exit',
            ]);
            
        }
        
        else{
            
            $user = ServiceGiver::create([
                'signupmethod' => $request->signupmethod,
                'email' => $request->email,
                'name' => $request->name,
                'category' => $request->category,
                'sub_category' => $request->sub_category,
                'password' =>  Hash::make($request->password),
                'location' => $request->location,
                'phone_no' => $request->phone,
                'mobile_verification' => $request->mobile_verification,
                'socialprofile' => $request->socialprofile,
                'device_token' => (isset($request->device_token)?$request->device_token:''),
            ]);
            
              return response()->json([
                'status'=>200,
                'user' => $user,
                'message'=>'Registered Successfully',
            ]);
        }
      
    }

    public function providerLogin(Request $request)
    {
         if(!isset($request->email) || !isset($request->password) ){
            
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
         $user_exit = ServiceGiver::where('email',$request->email)->first();
            
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
              
            $response = Http::post('https://payment.notension.pk/api/wallet/',[
                'provider_id'=>$user_exit->id,
            ]);

            $data = $response->json();
           
            
        }
        
            $creds = $request->only('email','password');

         if( Auth::guard('service_givers')->attempt($creds) ){
             
            return response()->json([
                'status' => 200,
                'type' => 'provider',
                'provider_info' => Auth::guard('service_givers')->user(),
              
        
            ]);
             
         }
         
          return response()->json([ 
              
              'status' => 404 ,
              'message' =>"Invalid Email or Password"
              ]);
    }
    
     public function check_provider_email(Request $request)
    {
        
        $provider = ServiceGiver::where('email',$request->email)->first();
        
        if($provider==null){
            return response()->json([
                        'status'=>404,
                        'message'=>'email not exits',
                    ]);
        }
        else{
            return response()->json([
                        'status'=>200,
                        'message'=>'Email already exits',
                        'provider_id'=>$provider->id,
                    ]);
        }
    }
        
    public function provider_update(Request $request)
    {
        
        $user = ServiceGiver::findOrFail($request->provider_id);
        
        $provider_name = (isset($request->name))?$request->name:$user->name;
        
        $phone_no = (isset($request->phone_no ))?$request->phone_no :$user->phone_no;
        
        $address = (isset($request->address))?$request->address:$user->location;
        
        $category = (isset($request->category))?$request->category:$user->category;
        
        $sub_category = (isset($request->sub_category))?$request->sub_category:$user->sub_category;
        
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
            
        $user->name = $provider_name;
        
        $user->phone_no = $phone_no;
        
        $user->location = $address;
        
        $user->category = $category;
        
        $user->sub_category = $sub_category;
        
        $user->password = $password;
        
        $user->mobile_verification = $mobile_verification;
        
        $user->socialprofile = $socialprofile;
        
        $user->profile_img =  (!empty($file_name))?$file_name:$user->profile_img;
        
        $user->save();
        
         return response()->json([
            'status'=>200,
            'message'=>'Updated Successfully',
            'provider'=>$user,
        ]);
      
    }

    public function mail_verification(Request $request) 
    {
        date_default_timezone_set("Asia/Karachi");

        $user = ServiceGiver::find($request->user);

        if(empty($user->email_verified_at)){

            if($user->email_verification_code==$request->code){

                ServiceGiver::where('id',$request->user)->update([

                    'email_verified_at'=>date('d-m-Y h:i:s a')
                ]);

            Mail::to($user['email'])->send(new RegisterGreetingMail($user));

            }
            else{

                return 'Something Wrong';
            }

            return 'Successfully Verified';

        }

        return 'Your Account has alredy Verified';
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

    public function forget(Request $request)
    {
        $code = rand(111111,999999);
        
        $user = ServiceGiver::where('email',$request->email)->first();

        if ($user) { 

                Mail::to($user['email'])->send(new ForgetMail($code));

                ServiceGiver::where('id',$user->id)->update([

                        'email_verification_code'=>$code,
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
    
    public function verify_code(Request $request)
    {
       
        $user = ServiceGiver::where('email',$request->email)->first();

        if ($user->email_verification_code==$request->code) { 

                return response()->json([ 
                    
                        'status' => 200 ,
                        'provider_id'=>$user->id,
                        'message' => 'Code matched' 
                    ]);
            }

            else{

                return response()->json([ 'status' => 404,'message'=>'Code not matched' ]);
            }
    }

    public function provider_info(Request $request)
    {
         if(!isset($request->id)){
            
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
         $user_exit = ServiceGiver::where('id',$request->id)->first();
         
          if($user_exit){
              
            return response()->json([
                'status'=>200,
                'provider' => $user_exit,
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
    
    public function change_provider_status(Request $request)
    {
         if(!isset($request->provider_id) || !isset($request->status)){
            
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
         $user_exit = ServiceGiver::where('id',$request->provider_id)->first();
         
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

    public function provider_location(Request $request)
    {
         if(!isset($request->location)){
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
        }
        
         $user_exit = ServiceGiver::where('location',$request->location)->get();
         
          if(count($user_exit)>0){
            return response()->json([
                'status'=>200,
                'provider' => $user_exit,
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
