<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Validator;
use JWTAuth;
use App\Models\User;
use App\Models\ServiceGiver;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\AssignedPermission;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helper\GlobalHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use App\Mail\RegisterGreetingMail;
use App\Mail\ForgetMail;
use File;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;


class ApiController extends Controller
{

    public function sendmail()
    {
        
        $link = 'https://authentication.notension.pk/api/mail-verification';
        $data = array(
            'email'=>'Junaidakhtar1109@gmail.com',
            'name'=>'Junaid',
            'password'=>'123456',
            'link'=>$link
        );
        Mail::to('Junaidakhtar1109@gmail.com')->send(new RegisterMail($data));
        
    }

    public function optForgetUserProvider(Request $request){

        $user_exit = User::where('email',$request->email)->first();
        $provider = ServiceGiver::where('email',$request->email)->first();
        $code = rand(111111,999999);

        if($user_exit){
            if($user_exit->status=='inactive' || $user_exit->status=='suspend' ){
               return response()->json([
                      'status' => 203,
                      'message' => 'you dont allow to login because your account is'.$user_exit->status,
                  ]);
              }

                Mail::to($request->email)->send(new ForgetMail($code));

                User::where('id',$user_exit->id)->update([

                        'forget_email_code'=>$code,
                ]);
               
            }
            elseif($provider){
                if($provider->status=='inactive' || $provider->status=='suspend' ){
                        return response()->json([
                            'status' => 203,
                            'message' => 'you dont allow to login because your account is'.$provider->status,
                        ]);
                }
                $response = Http::post('https://payment.notension.pk/api/wallet/',[
                    'provider_id'=>$provider->id,
                ]);
    
                $data = $response->json();

                Mail::to($request->email)->send(new ForgetMail($code));

                ServiceGiver::where('id',$provider->id)->update([

                        'email_verification_code'=>$code,
                ]);

            }
            else{

                return response()->json([ 
                    'status' => 404 ,
                    'message' =>"Invalid Email"
                ]);

            }


    }

    public function verifyOtpUserProvider(Request $request){

        $user_exit = User::where('email',$request->email)->first();
        $provider = ServiceGiver::where('email',$request->email)->first();

        if($user_exit){
            if ($user_exit->forget_email_code==$request->code) { 

                $input = $request->only('email');
                $jwt_token = null;
                // Custom authentication logic (without password check)
                if ($user = User::where('email', $input['email'])->first()) {
                    $jwt_token = JWTAuth::fromUser($user, ['user']);
                    
                }
                if (!$jwt_token) {
                    return response()->json([
                        'status' => 400,
                        'success' => false,
                        'message' => 'Invalid Email',
                    ]);
                }
                return $this->respondWithToken($jwt_token, 'user',$user_exit->id);
            }
            else{return response()->json([ 'status' => 404,'message'=>'Code not matched' ]);}
        }
        elseif($provider){
            if ($provider->email_verification_code==$request->code) { 
                $creds = $request->only('email');

                if ($serviceGiver = ServiceGiver::where('email', $creds['email'])->first()) {
                    // Generate a token or session for the service provider without checking the password
                    $token = Str::random(60); // Generate a random token, you may customize this according to your needs
                    $serviceGiver->update(['remember_token' => $token]);

                    return response()->json([
                        'status' => 200,
                        'type' => 'provider',
                        'provider_info' => $serviceGiver,
                        'token' => $token,
                    ]);
                }
            }else{return response()->json([ 'status' => 404,'message'=>'Code not matched' ]);}
        }
        else{
            return response()->json([ 'status' => 404,'message'=>'Code not matched' ]);
        }
    }

    protected function  respondWithToken($token,$type,$id=null){

        return response()->json([
            'status' => 200,
            'type' => 'user',
            'access_token' => $token,
            'user_id' => $id,
            'profile_img' => 0,
            'token_type' => 'Bearer',
        
        ]);

    }

    public function send_otp(Request $request)
    {
        
        $check =  GlobalHelper::sendOTP('test007',"message","+923065179114");

        dd($check);
            return response()->json([ 
                'status' => 200,
                'check' =>$check,
                'message' => 'Notification sent Successfully'
            ]);

    }
    
    //admin sIDE Api

    public function adminLogin(Request $request)
    {

        if(!isset($request->email) || !isset($request->password) ){
            
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        $user_exit = Admin::where('email',$request->email)->first();
         
            if(!$user_exit){
              
                    return response()->json([
                        'status'=>404,
                        'message'=>'Admin not found',
                    ]);     
              
            }
        
         $creds = $request->only('email','password');

         if( Auth::guard('admin')->attempt($creds) ){
             
            return response()->json([
                'status' => 200,
                'type' => 'admin',
                'admin_info' => Auth::guard('admin')->user(),
              
        
            ]);
             
         }
         else{
             
                    return response()->json([
                        'status'=>404,
                        'message'=>'Credentials not match',
                    ]);
         }
    }
    
    public function provider_list(Request $request)
    {
        $data = ServiceGiver::orderBy('id','desc')->get();

        if (count($data)>0) { 

                return response()->json([ 
                    'status' => 200,
                    'data' => $data
                    ]);
            }

            else{

                return response()->json([ 'status' => 404 ]);
            }
    }
    
    public function user_list(Request $request)
    {
        $data = User::orderBy('id','desc')->get();

        if (count($data)>0) { 

                return response()->json([ 
                    'status' => 200,
                    'data' => $data
                    ]);
            }

            else{

                return response()->json([ 'status' => 404 ]);
            }
    }
    
    public function delete_user(Request $request)
    {
        $data = User::where('id',$request->id)->first();

        if (!empty($data)) { 
                $data->delete();
                return response()->json([ 
                    'status' => 200,
                    'message' => 'Deleted Successfully'
                    ]);
            }

            else{

                return response()->json([ 'status' => 400 ]);
            }
    }
    
    public function delete_provider(Request $request)
    {
        $data = ServiceGiver::where('id',$request->id)->first();

        if (!empty($data)) { 
                $data->delete();
                return response()->json([ 
                    'status' => 200,
                    'message' => 'Deleted Successfully'
                    ]);
            }

            else{

                return response()->json([ 'status' => 400 ]);
            }
    }
    
    public function saveProviderToken(Request $request)
    {
        $data = ServiceGiver::where('id',$request->id)->first();

        if (!empty($data)) { 
            
                if($request->action=='on'){
                    $data->device_token = $request->device_token;
                    $data->save();
                }
                
                elseif($request->action=='off'){
                    $data->device_token = null;
                    $data->save();
                }
                
                return response()->json([ 
                    'status' => 200,
                    'action' => $request->action,
                    'token' => $request->device_token,
                    'message' => 'action Successfully'
                    ]);
            }

            else{

                    return response()->json([
                        
                        'status' => 400,
                        'message' => 'provider not found' 
                        ]);
                }
    }
    
    public function saveUserToken(Request $request)
    {
        $data = User::where('id',$request->id)->first();

        if (!empty($data)) { 
            
                if($request->action=='on'){
                    $data->device_token = $request->device_token;
                    $data->save();
                }
                
                elseif($request->action=='off'){
                    $data->device_token = null;
                    $data->save();
                }
                
                return response()->json([ 
                    'status' => 200,
                    'token' => $request->device_token,
                    'message' => 'action Successfully'
                    ]);
            }

            else{

                    return response()->json([
                        
                        'status' => 400,
                        'message' => 'provider not found' 
                        ]);
                }
    }
    
    
    public function sendNotification(Request $request)
    {
       
        if($request->sent_to=='user'){
             $data = User::where('id',$request->id)->first();
        }
        
        elseif($request->sent_to=='provider'){
            $data = ServiceGiver::where('id',$request->id)->first();
        }
        
          if (!empty($data)) { 
              
                    $notification = new Notification();
                    $notification->sent_to_id = $request->id;
                    $notification->sent_to = $request->sent_to;
                    $notification->title = $request->title;
                    $notification->message = $request->message;
                    $notification->action_id = (isset($request->action_id)?$request->action_id:'');
                    $notification->action_type = (isset($request->action_type)?$request->action_type:'');
                    $notification->datetime = date('Y-M-d h:i:s a');
                    $notification->save();  
             
             
                    $route = ($request->route=='')?$route='':$request->route;
             
                    $job_id = ($request->job_id=='')?$job_id='':$request->job_id;
                   
                    
                   $check =  GlobalHelper::sendFCM($request->title,$request->message,$data->device_token,$route,$job_id);
                        
                    return response()->json([ 
                        'status' => 200,
                        'message' => 'Notification sent Successfully'
                    ]);
                    
            }else{

                    return response()->json(['message' => 'Not sent', 'status' => 404 ]);
            }
    }
    
    public function userNotification(Request $request)
    {
        
        
        $noti = Notification::orderBy('id','desc')->where('sent_to_id',$request->user_id)->where('sent_to','user')->get();
        
        
         if (count($noti)>0) { 
             
                    $count = 0;
       
                foreach($noti as $key => $val){
                    
                    $count += ($val->seen==0?1:0);
                    
                    $val->seen = 1;
                    $val->save();
                    
                     $name = '';
                     $id = '';
                    
                    if($val->action_type!='' && $val->action_type=='message'){
                        
                        $prod = ServiceGiver::where('id',$val->action_id)->first();
                        $name = $prod->name;
                        $id = $prod->id;
                    }
                    
                    $data[] = array(
                        
                        'title'=>$val->title,
                        'message'=>$val->message,
                        'datetime'=>$val->datetime,
                        'action_type'=>$val->action_type,
                        'id'=>$id,
                        'name'=>$name,
                        
                        );
                    
                }
        
       
           
            return response()->json([ 
                'status' => 200,
                'count' =>$count,
                'data' => $data,
                'message' => 'Fetch Successfully'
            ]);
        }
            
             else{
    
                return response()->json([ 
                    'status' => 404,
                    'message' => 'Not Successfully'
                    
                    ]);
            }
        
    }
    
    public function providerNotification(Request $request)
    {
        
        $noti = Notification::orderBy('id','desc')->where('sent_to_id',$request->provider_id)->where('sent_to','provider')->get();
         
        if (count($noti)>0) { 
                
                $count = 0;
                
            foreach($noti as $key => $val){
                
                 $count += ($val->seen==0?1:0);
                
                $val->seen = 1;
                $val->save();
                
                 $name = '';
                 $id = '';
                
                if($val->action_type!='' && $val->action_type=='message'){
                    
                    $prod = User::where('id',$val->action_id)->first();
                    $name = $prod->name;
                    $id = $prod->id;
                }
                
                if($val->action_type!='' && $val->action_type=='payment'){
                    
                    $name = 'payment';
                }
                
                 if($val->title!='' && $val->title=='Matched job'){
                    
                    $name = 'job';
                    $id = $val->action_id;
                }
                
                $data[] = array(
                    
                    'title'=>$val->title,
                    'message'=>$val->message,
                    'datetime'=>$val->datetime,
                    'action_type'=>$val->action_type,
                    'id'=>$id,
                    'name'=>$name,
                    
                    );
                
            }
            
            return response()->json([ 
                    'status' => 200,
                    'count' =>$count,
                    'data' => $data,
                    'message' => 'Fetch Successfully'
                    ]);
        }
            
        else{
    
            return response()->json([ 
                'status' => 404,
                'message' => 'Not Successfully'
                
                ]);
        }
        
    }
    
    public function providerNotificationCounter(Request $request){
        
            $noti = Notification::orderBy('id','desc')->where('sent_to_id',$request->provider_id)->where('sent_to','provider')->where('seen','0')->get();
         
                return response()->json([ 
                    'status' => 200,
                    'count' => count($noti),
                    'message' => 'Action Successfully'
                ]);
         
    }
    
    public function userNotificationCounter(Request $request){
        
            $noti = Notification::where('sent_to_id',$request->user_id)->where('sent_to','user')->where('seen','0')->get();
         
                return response()->json([ 
                    'status' => 200,
                    'count' => count($noti),
                    'message' => 'Action Successfully'
                ]);
         
    }
    
    public function fetchCounter(Request $request){
        
            $data = DB::select("SELECT * FROM vu_total");
         
                return response()->json([ 
                    'status' => 200,
                    'data' => $data,
                    'message' => 'Action Successfully'
                ]);
         
    }
    
   
}
