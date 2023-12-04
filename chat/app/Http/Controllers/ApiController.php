<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\UsersComplaint;
use App\Models\ComplaintChat;
use Illuminate\Support\Facades\Log;


class ApiController extends Controller
{
    public function send_message(Request $request) 
    {

        if(!isset($request->sender_id) || !isset($request->receiver_id) || !isset($request->message) || !isset($request->send_to)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        if($request->send_to=='user'){
            
            $response = Http::post('https://authentication.notension.pk/api/user_info/',[
                'id'=>$request->receiver_id,
                ]);
            $users = $response->json();
            $data = $users['user'];
            
            $reps = Http::post('https://authentication.notension.pk/api/provider_info/',[
                'id'=>$request->sender_id,
                ]);
            $users = $reps->json();
            $data1 = $users['provider'];
            
        }
        
        elseif($request->send_to=='provider'){
            
            $response = Http::post('https://authentication.notension.pk/api/provider_info/',[
                'id'=>$request->receiver_id,
                ]);
            $users = $response->json();
            $data = $users['provider'];
            
            $reps = Http::post('https://authentication.notension.pk/api/user_info/',[
                'id'=>$request->sender_id,
                ]);
            $users = $reps->json();
            $data1 = $users['user'];
            
        }
        
        
            $response = Http::post('https://authentication.notension.pk/api/sendNotification/',[
                'id'=>$request->receiver_id,
                'title'=>'You got msg from '.$data1['name'],
                'message'=>$request->message,
                'action_id'=>$request->sender_id,
                'action_type'=>'message',
                'sent_to'=>$request->send_to,
                'route'=>'message'
                ]);
                
            $users = $response->json();

        
        Chat::create([
            
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'send_to' => $request->send_to,
            'deliver_date' => date("d-M-Y"),
            'deliver_time' => date("h:i:s A"),

        ]);


        return response()->json([
            'status'=>200,
            'message'=>'message sent successfully',
        ]); 
        
    }
    
    public function user_messages (Request $request) 
    {
        if(!isset($request->user_id) || !isset($request->receiver_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        $messages = Chat::where('sender_id',$request->user_id)
                    ->where('receiver_id',$request->receiver_id)
                    ->orwhere('sender_id',$request->receiver_id)
                    ->where('receiver_id',$request->user_id)
                    ->get();
     
         if($messages->count()>0){
             
            $count=0;
                
               foreach ($messages as $key => $value) {
                   
                        if($value->seen=="0"){
                            
                            
                            $messages1 = Chat::where('id',$value->id)->first();
                            $messages1->seen = '1';
                            $messages1->seen_date = date('Y-M-d');
                            $messages1->seen_time = date('h:i:s a');
                            $messages1->save();
                            $count = $count+1;
                            
                        }
                        else{
                            $count = $count;
                        }
                        
                   
                        if($value['send_to']=='provider'){
                            $send = 'send_me';                            
                        }
                        else{
                            $send = 'other';
                        }
                    $data[] = array(
                            
                                'id' => $value->id,
                                'sender_id' => $value->sender_id,
                                'receiver_id' => $value->receiver_id,
                                'message' =>$value->message,
                                'deliver_date' =>$value->deliver_date,
                                'deliver_time' =>$value->deliver_time,
                                'send_to' =>$value->send_to,
                                'seen' =>$value->seen,
                                'seen_date' =>$value->seen_date,
                                'seen_time' =>$value->seen_time,
                                'send' =>$send
                            
                            );
                    }
                    
                    return response()->json([
                        'status'=>200,
                        'unseen'=>$count,
                        'data'=>$data,
                        'message'=>'message fetch successfully',
                    ]);  
                    
                }
                
                
                else{
                        return response()->json([
                            'status'=>404,
                            'message'=>'message not found',
                        ]);  
                }
                
    }
        
    public function provider_mesgs_list (Request $request) 
    {
        
        if(!isset($request->provider_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        $messages = Chat::where('sender_id',$request->provider_id)
                    ->where('send_to','user')
                    ->orwhere('receiver_id',$request->provider_id)
                    ->where('send_to','provider')
                    ->OrderBy('deliver_date','DESC')
                    ->get();
                    
         
        if($messages->count()>0){
            
                    $count = 0;
          
                foreach ($messages as $key => $value) {
                   
                    if($value->receiver_id==$request->provider_id){
                        
                        $count += ($value->seen==0?1:0);
                    }
                    
                    $user_id = ($value->send_to=='user')?$value->receiver_id:$value->sender_id;
                    
                    $user_detail = $this->user_curl($user_id);
                    
                    if($user_detail==NULL){
                    
                        return response()->json([
                            'status'=>404,
                            'message' =>'Please refresh again',
                            'msgs'=>$user_detail,
                        ]);
                    }
                
                   
                    if(count($user_detail)>0){
                        
                        $data[] = array(
                            
                                'id' => $value->id,
                                'type' => gettype($user_detail),
                                'user_id' => $user_detail['user']['id'],
                                'name' => $user_detail['user']['name'],
                                'socialprofile' => $user_detail['user']['socialprofile'],
                                'profile_img' =>$user_detail['user']['profile_img'],
                                'count' =>$count,
                                'seen' =>$value->seen,
                                'message' =>$value->message,
                                'deliver_date' =>$value->deliver_date,
                                'deliver_date' =>$value->deliver_date,
                                'deliver_time' =>$value->deliver_time,
                            
                            );
                    }
                }
                
                $details = $this->unique_multidim_array($data,'user_id');
                
                $collection = array_values($details);
                
                
                $seen_count = array_reduce($collection, function($carry, $item) {
                    return $carry += $item['seen'] == "0" ? 1 : 0;
                }, 0);
             
        
                return response()->json([
                    'status'=>200,
                    'unseen'=>$seen_count,
                    'data'=>$collection,
                    'message'=>'message fetch successfully',
                ]);
        }
        
        else{
                 return response()->json([
                    'status'=>404,
                    'message'=>'This provider dont have any chat',
                ]);
        }
        
    }

    public function user_mesgs_list (Request $request) 
    {
        try{
        
        if(!isset($request->user_id)){
            
            return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        $data = array();
        
          $messages = Chat::where('sender_id', $request->user_id)
                    ->where('send_to', 'provider')
                    ->orWhere('receiver_id', $request->user_id)
                    ->where('send_to', 'user')
                    ->orderBy('deliver_date', 'DESC')
                    ->get();
              
                        
      
                    
        if(count($messages)>0){
                
                $count = 0;
            
                foreach ($messages as $key => $value) {
                    
                        if($value->receiver_id==$request->user_id){
                        
                            $count += ($value->seen==0?1:0);
                        }
                 
                        $provider_id = ($value->send_to=='provider')?$value->receiver_id:$value->sender_id;
                    
                        
                        $provider_detail = $this->provider_curl($provider_id);
                        
                         
                        
                        // $provider_detail = null;
                        
                        // while ($provider_detail === null) {
                        //     $provider_detail = $this->provider_curl($provider_id);
                        // }
                    

                        
                        if($provider_detail==NULL){
                    
                            return response()->json([
                                'status'=>404,
                                'message' =>'Please refresh Again'
                            ]);
                        }
                         
                        if(!empty($provider_detail) && $provider_detail['status']!='403'){
                            
                            $data[] = array(
                                
                                    'id' => $value->id, 
                                    'user_id' =>  $provider_detail['provider']['id'],
                                    'name' => $provider_detail['provider']['name'],
                                    'socialprofile' =>  $provider_detail['provider']['socialprofile'],
                                    'profile_img' => $provider_detail['provider']['profile_img'],
                                    'count' =>$count,
                                    'seen' =>$value->seen,
                                    'message' =>$value->message,
                                    'deliver_date' =>$value->deliver_date,
                                    'deliver_time' =>$value->deliver_time,

                                  );
                        }
   
                }
                
                $details = $this->unique_multidim_array($data,'user_id');
              
                $collection = array_values($details);
                
 
                $seen_count = array_reduce($collection, function($carry, $item) {
                    return $carry += $item['seen'] == "0" ? 1 : 0;
                }, 0);
             
        
                return response()->json([
                    'status'=>200,
                    'unseen'=>$seen_count,
                    'data'=>$collection,
                    'message'=>'message fetch successfully',
                ]);
        }
        
        else{
                return response()->json([
                    'status'=>404,
                    'message'=>'This User dont have any chat',
                ]);
        }
        
        }
        
        catch (\Exception $e) {
            
             return response()->json([
                    'status'=>404,
                    'message'=>$e->getMessage()
                ]);

             
        }
        
    }
    
    public function providerMsgCounter(Request $request) {
        
        if(!isset($request->provider_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        $messages = Chat::where('sender_id',$request->provider_id)
                    ->where('send_to','user')
                    ->orwhere('receiver_id',$request->provider_id)
                    ->where('send_to','provider')
                    ->get();
                    
        $seen = collect($messages)->where('seen', 0)->count();

         
        return response()->json([
                'status'=>200,
                'count'=>$seen,
                'message'=>'Action successfully',
            ]);

    }
    
    public function userMsgCounter(Request $request) {
        
        if(!isset($request->user_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        $messages = Chat::where('sender_id',$request->user_id)
                    ->where('send_to','provider')
                    ->orwhere('receiver_id',$request->user_id)
                    ->where('send_to','user')
                    ->where('seen','0')
                    ->OrderBy('deliver_date','DESC')
                    ->OrderBy('created_at','DESC')
                    ->get();
                    
         
        $seen = collect($messages)->where('seen', 0)->count();
        
        return response()->json([
                'status'=>200,
                'count'=>$seen,
                'message'=>'Action successfully',
            ]);

    }
    
    public function provider_messages (Request $request) 
    {
        
        
         if(!isset($request->provider_id) || !isset($request->receiver_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
        
        $messages = Chat::where('sender_id',$request->provider_id)
                    ->where('receiver_id',$request->receiver_id)
                    ->orwhere('sender_id',$request->receiver_id)
                    ->where('receiver_id',$request->provider_id)
                    ->get();
         $data=[];
         
         
         
       if(count($messages)>0){
           
           $count=0;
           
            foreach ($messages as $key => $value) {
                
                   
                        if($request->provider_id==$value->receiver_id && $value->seen=="0"){
                            
                            $messages1 = Chat::where('id',$value->id)->first();
                            $messages1->seen = '1';
                            $messages1->seen_date = date('Y-M-d');
                            $messages1->seen_time = date('h:i:s a');
                            $messages1->save();
                            $count = $count+1;
                            
                        }
                        
                        else{
                            $count = $count;
                        }
                        
                        
                        if($value['send_to']=='user'){
                            $send = 'send_me';                            
                        }
                        else{
                            $send = 'other';
                        }
                    $data[] = array(
                            
                                'id' => $value->id,
                                'sender_id' => $value->sender_id,
                                'receiver_id' => $value->receiver_id,
                                'message' =>$value->message,
                                'deliver_date' =>$value->deliver_date,
                                'deliver_time' =>$value->deliver_time,
                                'send_to' =>$value->send_to,
                                'seen' =>$value->seen,
                                'seen_date' =>$value->seen_date,
                                'seen_time' =>$value->seen_time,
                                'send' =>$send
                            
                            );
                    }
                    
                    return response()->json([
                        'status'=>200,
                        'unseen'=>$count,
                        'data'=>$data,
                        'message'=>'message fetch successfully',
                    ]);  
                    
                }
                
                
                else{
                        return response()->json([
                            'status'=>404,
                            'message'=>'message not found',
                        ]);  
                }
                
        
        
    }
    
    
    public function user_curl ($id) 
    {
        
        $response = Http::post('https://authentication.notension.pk/api/user_info/',[
            'id'=>$id,
            ]);
            
       
        
        $users = $response->json();
        
        return $users;
                
    }
    
    public function provider_curl ($id) 
    {
    
        $response = Http::post('https://authentication.notension.pk/api/provider_info/',[
            'id'=>$id,
            ]);

        $users = $response->json();
        
        return $users;
                
    }
    
    
    public function unique_multidim_array($array, $key) {
        
        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) {
            
            if (!in_array($val[$key], $key_array)) {
                
                $key_array[$i] = $val[$key];
                
                $temp_array[$i] = $val;
            }
            
            $i++;
        }
        
        return $temp_array;
    }
    
    
    
    
    
    
    //Complaint Management Api's
    
    public function register_complaint (Request $request) 
    {
        
                if($request->hasFile('file')) {

                    $file = $request->file('file');

                    $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();

                    $image['filePath'] = $name;

                    $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;

                    $file->move(public_path().'/uploads/', $file_name);

                }
                
                if (strpos($request->image, 'data:image/') === 0) {

                    $imageData = $request->image; // The base64 string of the image
        
                    // Convert the base64 string to binary data
                    $imageBinaryData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
                                
                    // Get the image information, including its file format
                    $imageInfo = getimagesizefromstring($imageBinaryData);
    
                    $fileExtension = image_type_to_extension($imageInfo[2]);
    
                    // Generate a unique filename
                    $file_name = time().mt_rand(1,99999).$fileExtension;
                    
                    // Save the image to the server
                    file_put_contents(public_path().'/uploads/'.$file_name, $imageBinaryData);
    
                } 
                    
        
            UsersComplaint::create([
                
                'complaint_type' => $request->complaint_type,
                'complainer_id' => $request->complainer_id,
                'complaint_against_id' => ($request->complaint_against_id!=''?$request->complaint_against_id:0),
                'complaint_against_type' => ($request->complaint_against_type!=''?$request->complaint_against_type:0),
                'service_id' => ($request->service_id!=''?$request->service_id:0),
                'complaint_detail' => $request->complain_description,
                'file'=>(!empty($file_name))?$file_name:"",
                ]);
                
                return response()->json([
                    'status'=>200,
                    'message'=>'Complaint Register Succesfully',
                ]);  
        
    }
    
    public function user_complaints (Request $request) 
    {
        
        if( !isset($request->user_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'User Id is missing',
            ]);
            
        }
        
        $complaints =   UsersComplaint::
                        where('complainer_id',$request->user_id)
                         ->where('complaint_type','user')
                        ->OrderBy('id','DESC')
                        ->get();
                        
        if(count($complaints)>0){
            
              
            foreach ($complaints as $key => $value) {
             
                        if($value->file!=''){
                            $file = config('app.url').'uploads/'.$value->file;
                        }
                        else{
                            $file = 'image not uploaded';
                        }
             
             
                    $data[] = array(
                                
                                    'id' => $value->id,
                                    'complainer_id' => $value->complainer_id,
                                    'complaint_against_id' => $value->complaint_against_id,
                                    'complaint_against_type' => $value->complaint_against_type,
                                    'service_id' => $value->service_id,
                                    'complaint_type' => $value->complaint_type,
                                    'complaint_detail' => $value->complaint_detail,
                                    'file' => $file,
                                    'status' => $value->status,
                                    'created_at' => $value->created_at,
                                   
                            );
            }
            return response()->json([
                    'status'=>200,
                    'message'=>'Complaints fetch successfully',
                    'data'=>$data,
                ]);  
             
        }
        
         else{
                
                return response()->json([
                    'status'=>404,
                    'message'=>'Complaints not available',
                ]);  
                
            }
            
    }
    
    public function provider_complaints (Request $request) 
    {
        
        if( !isset($request->provider_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Provider Id is missing',
            ]);
            
        }
        
        $complaints =   UsersComplaint::
                        where('complainer_id',$request->provider_id)
                        ->where('complaint_type','provider')
                        ->OrderBy('id','DESC')
                        ->get();
                        
        if(count($complaints)>0){
            
              
            foreach ($complaints as $key => $value) {
             
                        if($value->file!=''){
                            $file = config('app.url').'uploads/'.$value->file;
                        }
                        else{
                            $file = 'image not uploaded';
                        }
             
             
                    $data[] = array(
                                
                                    'id' => $value->id,
                                    'complainer_id' => $value->complainer_id,
                                    'complaint_against_id' => $value->complaint_against_id,
                                    'complaint_against_type' => $value->complaint_against_type,
                                    'service_id' => $value->service_id,
                                    'complaint_type' => $value->complaint_type,
                                    'complaint_detail' => $value->complaint_detail,
                                    'file' => $file,
                                    'status' => $value->status,
                                    'created_at' => $value->created_at,
                                   
                            );
            }
            
             return response()->json([
                    'status'=>200,
                    'message'=>'Complaints fetch successfully',
                    'data'=>$data,
                ]);  
             
        }
        
         else{
                
                return response()->json([
                    'status'=>404,
                    'message'=>'Complaints not available',
                ]);  
                
            }
            
    }
    
    public function single_complain (Request $request) 
    {
        
        if( !isset($request->complain_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Complain Id is missing',
            ]);
            
        }
        
        $complaint  =   UsersComplaint::where('id',$request->complain_id)->first();
        
        if($complaint!=''){
            
            if($complaint->file!=''){
                $file = config('app.url').'uploads/'.$complaint->file;
            }
            else{
                $file = 'image not uploaded';
            }
            
            $complainerDetails='';
            $complainAgainstDetails='';
            $userAgainstType='';
            
        if($complaint->complaint_against_type=='provider'){
            
            $reps = Http::post('https://authentication.notension.pk/api/provider_info/',[
                'id'=>$complaint->complaint_against_id,
                ]);
            $users = $reps->json();
            $complainAgainstDetails = $users['provider'];
            $userAgainstType = 'provider';
            
            $response1 = Http::post('https://authentication.notension.pk/api/user_info/',[
                'id'=>$complaint->complainer_id,
                ]);
            $users1 = $response1->json();
            $complainerDetails = $users1['user'];
            
        }
        elseif($complaint->complaint_against_type=='user'){
            
            $response = Http::post('https://authentication.notension.pk/api/user_info/',[
                'id'=>$complaint->complaint_against_id,
                ]);
            $users = $response->json();
            $complainAgainstDetails = $users['user'];
            $userAgainstType = 'user';
            
            $reps1 = Http::post('https://authentication.notension.pk/api/provider_info/',[
                'id'=>$complaint->complainer_id,
                ]);
            $users1 = $reps1->json();
            $complainerDetails = $users1['provider'];
        }
        
        elseif($complaint->complaint_against_type=='system'){
            
            if($complaint->complaint_type=='user'){
            
                $response = Http::post('https://authentication.notension.pk/api/user_info/',[
                    'id'=>$complaint->complainer_id,
                    ]);
                $users = $response->json();
                $complainerDetails = $users['user'];
            }
            else{
                
                $reps1 = Http::post('https://authentication.notension.pk/api/provider_info/',[
                'id'=>$complaint->complainer_id,
                ]);
                $users1 = $reps1->json();
                $complainerDetails = $users1['provider'];
                
            }
            
        }
        
        
        
        
        
        $data[] = array(
            
            'id' => $complaint->id,
            'complainer_id' => $complaint->complainer_id,
            'complaint_against_id' => $complaint->complaint_against_id,
            'complaint_against_type' => $complaint->complaint_against_type,
            'service_id' => $complaint->service_id,
            'complaint_type' => $complaint->complaint_type,
            'complaint_detail' => $complaint->complaint_detail,
            'file' => $file,
            'status' => $complaint->status,
            'created_at' => $formattedDate = date('d-M-Y h:i:s a', strtotime($complaint->created_at)),
            'userType' =>$complaint->complaint_type,
            'userAgainstType' =>$userAgainstType,
            'complainerDetails'=>($complainerDetails!=''?$complainerDetails:''),
            'complainAgainstDetails'=>($complainAgainstDetails!=''?$complainAgainstDetails:''),
            
            );
        
        
            
            return response()->json([
                'status'=>200,
                'data'=>$data,
                'message'=>'Complaint fetch successfully',
            ]);  
            
        }
        else{
            
            return response()->json([
                'status'=>404,
                'message'=>'Complain not available',
            ]);  
            
        }
    }
    
    
    
    //admin side
    
    public function all_complaint (Request $request) 
    {
        
    $complain  =   UsersComplaint::orderBy('id','desc')->get();
    
    foreach($complain as $complaint){
        
          if($complaint->file!=''){
                            $file = config('app.url').'uploads/'.$complaint->file;
                        }
                        else{
                            $file = 'image not uploaded';
                        }
        
         $data[] = array(
            
            'id' => $complaint->id,
            'complainer_id' => $complaint->complainer_id,
            'complaint_against_id' => $complaint->complaint_against_id,
            'complaint_against_type' => $complaint->complaint_against_type,
            'service_id' => $complaint->service_id,
            'complaint_type' => $complaint->complaint_type,
            'complaint_detail' => $complaint->complaint_detail,
            'file' => $file,
            'status' => $complaint->status,
            'created_at' => $formattedDate = date('Y-M-d h:i:s a', strtotime($complaint->created_at)),
            
            );

    }
     
    if(count($data)>0){
        
        return response()->json([
                'status'=>200,
                'data'=>$data,
                'message'=>'Fetch successfully',
            ]);  
            
    } 
    else{
        
        return response()->json([
                'status'=>400,
                'message'=>'unsuccessfully',
            ]);  
    }
        
        
    }
    
    
    public function change_status_complaint (Request $request) 
    {
        
        if( !isset($request->complain_id) ||  !isset($request->status)){
            
             return response()->json([
                'status'=>203,
                'message'=>'something is missing',
            ]);
            
        }
        
        $complaint  =   UsersComplaint::where('id',$request->complain_id)->first();
        
         if($complaint!=''){
             
             $complaint->status = $request->status;
             $complaint->save();
            
            return response()->json([
                'status'=>200,
                'message'=>'Action successfully',
            ]);  
            
        }
        else{
            
            return response()->json([
                'status'=>404,
                'message'=>'Complain not available',
            ]);  
            
        }
    }
    
    public function saveComplainChat (Request $request) 
    {
        
        if( !isset($request->complain_id)  || !isset($request->complainer_id)  || !isset($request->admin_id) || !isset($request->message) || !isset($request->send_by)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Some paramter are missing',
                'para'=>$request->all()
            ]);
            
        }
        else{
            
            ComplaintChat::create([
                
                    'user_id' => $request->complainer_id,
                    'complaint_id' => $request->complain_id,
                    'user_type' => $request->complaint_type,
                    'admin_id' => $request->admin_id,
                    'message' => $request->message,
                    'send_by' => $request->send_by,
                    'date' => date("d-M-Y"),
                    'time' => date("h:i:s A"),
    
                ]);
                
                return response()->json([
                    'status'=>200,
                    'message'=>'Sent Succesfully',
                ]);  
            
        }
    }
    
    public function complainChat (Request $request) 
    {
        
            
        if( !isset($request->user_id) || !isset($request->user_type) || !isset($request->complaint_id)){
            
             return response()->json([
                'status'=>203,
                '1'=>$request->user_id,
                '2'=>$request->user_type,
                '3'=>$request->complaint_id,
                'message'=>'Some paramter are missing',
            ]);
            
        }
        
        // $user_type = ($request->user_type=='provider'?'user':'provider');
        
        $chat  =   ComplaintChat::where('user_id',$request->user_id)->where('complaint_id',$request->complaint_id)->where('user_type',$request->user_type)->get();
        
        if(count($chat)>0){
            
            return response()->json([
                'status'=>200,
                'data'=>$chat,
                'message'=>'Fetch successfully',
            ]);  
            
        }
        else{
            
            return response()->json([
                'status'=>404,
                'message'=>'Not Found',
            ]);  
            
        }
    }

    
    
    
}
