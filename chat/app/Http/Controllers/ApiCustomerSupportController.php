<?php

namespace App\Http\Controllers;
use App\Models\CustomerSupportChat;
use App\Models\CustomerSupportQuestion;
use App\Models\CustomerSupportAnswer;

use Illuminate\Http\Request;

class ApiCustomerSupportController extends Controller
{
   
    public function send_msg_cust_support(Request $request) 
    {
        if(!isset($request->sender_id) || !isset($request->message) || !isset($request->send_by)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Some paramter is missing',
            ]);
            
        }
     
        CustomerSupportChat::create([
            
            'sender_id' => $request->sender_id,
            'send_to_id' => $request->send_to_id,
            'send_to' => $request->send_to,
            'message' => $request->message,
            'send_by' => $request->send_by,
            'date' => date("d-M-Y"),
            'time' => date("h:i:s A"),

        ]);


        return response()->json([
            'status'=>200,
            'message'=>'message sent successfully',
        ]); 
    }
    
    public function fetch_messages_cust_support(Request $request) 
    {
        if(!isset($request->sender_id) || !isset($request->receiver)){
            
             return response()->json([
                'status'=>203,
                'message'=>'some paramter is missing',
            ]);
            
        }
        
        $messages = CustomerSupportChat::where('sender_id',$request->sender_id)
                    ->where('send_by',$request->receiver)
                    ->orwhere('send_to_id',$request->sender_id)
                    ->where('send_to',$request->receiver)
                    ->get();
     
         if($messages->count()>0){
            
               foreach ($messages as $key => $value) {
                        
                    $data[] = array(
                            
                                'id' => $value->id,
                                'sender_id' => $value->sender_id,
                                'send_by' =>$value->send_by,
                                'send_to_id' => $value->send_to_id,
                                'send_to' => $value->send_to,
                                'message' =>$value->message,
                                'date' =>$value->date,
                                'time' =>$value->time,
                              
                                'seen' =>$value->seen,
                                'seen_date' =>$value->seen_date,
                                'seen_time' =>$value->seen_time,
                            
                            );
                    }
                    
                return response()->json([
                    'status'=>200,
                    'data'=>$data,
                    'message'=>'message fetch successfully',
                ]);
                
            }
            
            else{
                
                return response()->json([
                    'status'=>404,
                    'message'=>'Message not found',
                ]);
            }
    }
    
    public function question_cust_support(Request $request) 
    {
        
        $data = CustomerSupportQuestion::all();


        return response()->json([
            'status'=>200,
            'data'=>$data,
            'message'=>'data fetch successfully',
        ]); 
    }
    
    public function answer_cust_support(Request $request) 
    {
        if(!isset($request->question_id)){
            
             return response()->json([
                'status'=>203,
                'message'=>'Question ID is missing',
            ]);
            
        }
        
        $data = CustomerSupportAnswer::where('question_id',$request->question_id)->get();

        return response()->json([
            'status'=>200,
            'data'=>$data,
            'message'=>'data fetch successfully',
        ]); 
    }
    
        
        
        
}
