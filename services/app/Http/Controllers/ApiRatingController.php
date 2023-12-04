<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use App\Models\Rating;

class ApiRatingController extends Controller
{
    public function save_rating (Request $request) 
    {
           
             $validator = Validator::make($request->all(), [
                'job_id' => 'required',
                'provider_id' => 'required',
                'comment' => 'required',
                'comment_given_by' => 'required',
                'stars' => 'required',
            ]);
       
            if($validator->fails()){
                
                $response = [
                    'success' => false,
                    'message' => 'Validation Error.',
                ];
        
                $code = '404';
                
                $response['data'] = $validator->errors();
                
                return response()->json($response, $code);

            }
            
            Rating::create([
                'job_id'=> $request->job_id,
                'user_id'=> $request->user_id,
                'provider_id'=> $request->provider_id,
                'comment_given_by'=> $request->comment_given_by,
                'stars'=> $request->stars,
                'comment'=> $request->comment,
                'comment_at'=> date('Y-m-d h:i:s a'),
               
            ]);
            
            return response()->json([
                'status'=>200,
                'message'=>'Rating Saved Successfully',
            ]);
    }
    
    public function provider_rating (Request $request) 
    {
        
             $validator = Validator::make($request->all(), [
                'provider_id' => 'required',
            ]);
       
            if($validator->fails()){
                
                $response = [
                    'success' => false,
                    'message' => 'Validation Error.',
                ];
        
                $code = '404';
                
                $response['data'] = $validator->errors();
                
                return response()->json($response, $code);

            }
            
            else{
            
                $ratings =  Rating::where('provider_id',$request->provider_id)->where('comment_given_by','user')->orderBy('id','desc')->get();
                
                    if(count($ratings)>0){
                            
                           
                            
                           foreach ($ratings as $key => $value) {
                               
                                $user = $this->user_curl($value->user_id);
                                
                                $provider = $this->provider_curl($value->provider_id);

                                $data[] = array(
                                            
                                                'id' => $value->id, 
                                                'user_id' => $value->user_id, 
                                                'user_name' => $user['user']['name'],
                                                'provider_name' => $provider['provider']['name'],
                                                'provider_id' => $value->provider_id,
                                                'comment' => $value->comment,
                                                'comment_given_by' => $value->comment_given_by,
                                                'stars' => $value->stars,
                                               
                                                
                                                );
                                   }
                     
                     
                          return response()->json([
                            'status'=>200,
                            'message'=>'Data Successfully Fetch',
                            'data'=>$data
                        ]); 
                    
                    }
                 
                    else{
                     
                        return response()->json([
                            'status'=>404,
                            'message'=>'Job not available',
                        ]); 
                    
                    }
         
         
            }
            
            
    }
    
     public function user_rating (Request $request) 
    {
        
             $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);
       
            if($validator->fails()){
                
                $response = [
                    'success' => false,
                    'message' => 'Validation Error.',
                ];
        
                $code = '404';
                
                $response['data'] = $validator->errors();
                
                return response()->json($response, $code);

            }
            
            else{
            
               $ratings =  Rating::where('user_id',$request->user_id)->where('comment_given_by','provider')->orderBy('id','desc')->get();
                
                    if(count($ratings)>0){
                            
                           
                            
                           foreach ($ratings as $key => $value) {
                               
                                $user = $this->user_curl($value->user_id);
                                
                                $provider = $this->provider_curl($value->provider_id);

                                $data[] = array(
                                            
                                                'id' => $value->id, 
                                                'user_id' => $value->user_id, 
                                                'user_name' => $user['user']['name'],
                                                'provider_name' => $provider['provider']['name'],
                                                'provider_id' => $value->provider_id,
                                                'comment' => $value->comment,
                                                'comment_given_by' => $value->comment_given_by,
                                                'stars' => $value->stars,
                                               
                                                
                                                );
                                   }
                     
                     
                          return response()->json([
                            'status'=>200,
                            'message'=>'Data Successfully Fetch',
                            'data'=>$data
                        ]); 
                    
                    }
                 
                    else{
                     
                        return response()->json([
                            'status'=>404,
                            'message'=>'Job not available',
                        ]); 
                    
                    }
         
         
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
    
    
    //admin side
    public function ratings(Request $request) {
        
          $ratings =  Rating::orderBy('id', 'desc')
                        ->with('job.catDetail')
                        ->get();
                        
                foreach ($ratings as $rating) {
                    
                     $user = $this->user_curl($rating->user_id);
                    
                    $data[] = array(
                        
                            'id'=>$rating->id,
                            'job_id'=>$rating->job_id,
                            'comment'=>$rating->comment,
                            'stars'=>$rating->stars,
                            'job_title'=>$rating->job->title,
                            'category'=>$rating->job->catDetail->name,
                            'user'=>$user['user']['name'],
                            'comment_at'=>$rating->comment_at,
                            
                        ); 
                    
                }

                
                    if(count($data)>0){
                            
                       return response()->json([
                            'status'=>200,
                            'message'=>'Data Successfully Fetch',
                            'data'=>$data
                        ]); 
                    
                    }
                 
                    else{
                     
                        return response()->json([
                            'status'=>404,
                            'message'=>'unsuccessfully',
                        ]); 
                    
                    }

    }
    
    public function job_rating(Request $request) {
        
          $ratings =  Rating::where('job_id',$request->job_id)->first();
                
                    if($ratings!=''){
                            
                       return response()->json([
                            'status'=>200,
                            'message'=>'Data Successfully Fetch',
                            'data'=>$ratings
                        ]); 
                    
                    }
                 
                    else{
                     
                        return response()->json([
                            'status'=>404,
                            'message'=>'unsuccessfully',
                        ]); 
                    
                    }

    }
    
}
