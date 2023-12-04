<?php
namespace App\Helper;

use App\Helper\GlobalHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class GlobalHelper
{
    
    public static function sendFCM($title, $message, $target,$route,$job_id){
          
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
       $SERVER_API_KEY = env('FCM_SERVER_KEY');
    
        $data = [
            "registration_ids" => [$target],
            "notification" => [
                "title" => $title,
                "body" => $message, 
                "sound" => "default"
            ],
             "data" => [
                     'message'=>$message,
                     'route'=> $route,
                     'job_id'=> $job_id,
                ]
             
        ];
        $dataString = json_encode($data);
      
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
      
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);
        if ($response === FALSE) {
          die('FCM Send Error: ' . curl_error($ch));
        }
         curl_close($ch);
        return $response;
          
      
   }
   
   
   public static function sendOTP($title, $message, $target){
          
        $SERVER_API_KEY = env('FCM_SERVER_KEY');
    
        $data = [
            "to" => $target,
            "notification" => [
                "title" => $title,
                "body" => $message, 
                "sound" => "default"
            ],
             "data" => [
                     'message'=>$message,
                ]
        ];
        $dataString = json_encode($data);
      
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
      
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);
        if ($response === FALSE) {
          die('FCM Send Error: ' . curl_error($ch));
        }
         curl_close($ch);
         return $response;
   }
  

}
