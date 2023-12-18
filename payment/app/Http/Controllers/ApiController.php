<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\Account;
use App\Models\Coupen;
use App\Models\CoupenUsed;
use Validator;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    public function save_payment(Request $request){
        
                   

            if(!isset($request->provider_id) || !isset($request->payment_type) || !isset($request->amount)){

                    return response()->json([
                        'status'=>404,
                        'message' => 'Someparameters are missing'
                    ]);
            }

            else{
                
                
                 
                    
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
                        file_put_contents(public_path().'/images/'.$file_name, $imageBinaryData);
        
                    } 
            
                
                else if ($request->hasFile('image')) {
                  
                        $file = $request->file('image');

                        $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();

                        $image['filePath'] = $name;

                        $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;

                        $file->move(public_path().'/images/', $file_name);
                }
                
                
               
                

                    $payment = new Payment();

                    $payment->provider_id = $request->provider_id;
                    $payment->payment_type = $request->payment_type;
                    $payment->amount = $request->amount;
                    $payment->reference_id = $request->reference_id;
                    $payment->account_title = $request->account_title;
                    // $payment->image = $request->image;
                    $payment->image = (isset($file_name)?$file_name:'');
                    $payment->date = date('d-M-Y');
                    $payment->time = date('h:i A');
                    $payment->save();

                    return response()->json([
                        'status'=>200,
                        'message' => 'Successfully Added'
                    ]);
            }

        }
        
        
    public function deduct_payment(Request $request){


            if(!isset($request->provider_id) || !isset($request->amount)){

                    return response()->json([
                        'status'=>404,
                        'message' => 'Someparameters are missing'
                    ]);
            }

            else{
                
                $provider_wallet = Wallet::where('provider_id',$request->provider_id)->first();
                
                if($provider_wallet!=''){
                    
                    if($provider_wallet->amount>0){
                    
                            $provider_wallet->amount = $provider_wallet->amount-$request->amount;
                            $provider_wallet->save();
                             
                                return response()->json([
                                    'status'=>200,
                                    'message' => 'Action Successfully'
                                ]);
                    }
                    
                    else{
                        
                            return response()->json([
                                'status'=>403,
                                'message' => 'You do not have sufficient balance.Please recharge your account'
                            ]);
                        
                    }
                }
                else{
                    
                        return response()->json([
                            'status'=>404,
                            'message' => 'Wallet not found'
                        ]);
                    
                }
               

                    return response()->json([
                        'status'=>200,
                        'message' => 'Successfully Added'
                    ]);
            }

        }

    public function provider_payment(Request $request)
        {
            
            
            if(!isset($request->provider_id)){

                return response()->json([
                    'status'=>404,
                    'message' => 'Someparameter is missing'
                ]);
            }
            else{

                $payment = Payment::orderBy('id','DESC')->where('provider_id',$request->provider_id)->get();

                    if($payment->isEmpty()){
                        return response()->json([
                            'status'=>404,
                            'message' => 'This provider dont have any payment'
                        ]);
                    }
                    
                    else{
                            return response()->json([
                                'status'=>200,
                                'message' => 'Successfully Fetch',
                                'data' => $payment
                            ]);
                        }
            }
        }

    public function change_status(Request $request)
    {

          
            if(!isset($request->payment_id) || !isset($request->status)){

                    return response()->json([
                        'status'=>404,
                        'message' => 'Someparameter is missing'
                    ]);
            }

            else{

                    $payment = Payment::where('id',$request->payment_id)->first();

                    if(empty($payment)){
                        return response()->json([
                            'status'=>404,
                            'message' => 'This payment id not found'
                        ]);
                    }
                    
                    else{

                            if($request->status=='accept'){

                                $wallet = Wallet::where('provider_id',$payment->provider_id)->first();

                                if(empty($wallet)){

                                    $wallet = new Wallet();

                                    $wallet->provider_id = $payment->provider_id;
                                    $wallet->amount = $payment->amount;
                                    $wallet->save();
                                }   

                                else{

                                    $amount = $wallet->amount +  $payment->amount;
                                    $wallet->amount = $amount;
                                    $wallet->save();

                                }

                            }
                            
                            $status_=($request->status=='accept'?'approved':$request->status);
                            
                        Http::post('https://authentication.notension.pk/api/sendNotification/',[
                            'id'=>$payment->provider_id,
                            'title'=>'Payment is '.$request->status,
                            'message'=>'Your payment of '.$payment->amount.' is '.$status_,
                            'sent_to'=>'provider',
                            'action_id'=>$request->payment_id,
                            'action_type'=>'payment',
                            'route'=>'payment'
                        ]);
                        
                      
                            $payment->status = $request->status;
                            $payment->note = $request->note;
                            $payment->amount = $request->amount;
                            $payment->status_date = date('d-M-Y');
                            $payment->status_time = date('h:i A');
                            $payment->status_reason = (isset($request->status_reason))?$request->status_reason:'';
                            $payment->save();

                            return response()->json([
                                'status'=>200,
                                'message' => 'Action Successfully',
                               
                            ]);
                        }
            }

    }
    public function payments(Request $request)
    {
            $payment = Payment::orderBy('id','DESC')->get();
            
            foreach ($payment as $value) {
                
                $provider_data = $this->provider_curl($value->provider_id);

                $data[] = array(
                                
                                    'id' => $value->id, 
                                    'provider_id' => $value->provider_id, 
                                    'provider_name' => ($provider_data['status']==403)?'':$provider_data['provider']['name'], 
                                    'provider_location' => ($provider_data['status']==403)?'':$provider_data['provider']['location'], 
                                    'payment_type' => $value->payment_type, 
                                    'amount' => $value->amount, 
                                    'account_title' => $value->account_title, 
                                    'reference_id' => $value->reference_id, 
                                    'image' => $value->image, 
                                    'status' => $value->status, 
                                    'status_date' => $value->status_date, 
                                    'status_time' => $value->status_time, 
                                    'status_reason' => $value->status_reason, 
                                    'date' => $value->date, 
                                    'time' => $value->time, 
                                );
            }

            if(count($data)>0){
                return response()->json([
                    'status'=>200,
                    'message' => 'Successfully Fetch',
                    'data' => $data
                ]);
               
            }

            else{
                
                return response()->json([
                    'status'=>404,
                    'message' => 'Payments not found'
                ]);     

            }
    }
    
    public function single_payment(Request $request)
    {
        
         $validator = Validator::make($request->all(), [
          'id' => 'required',
         
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
            
            $data = Payment::where('id',$request->id)->first();
            
           

            if($data!=''){
                return response()->json([
                    'status'=>200,
                    'message' => 'Successfully Fetch',
                    'data' => $data
                ]);
               
            }

            else{
                
                return response()->json([
                    'status'=>404,
                    'message' => 'Payments not found'
                ]);     

            }
    }

    public function wallet(Request $request)
    {
            $wallet = Wallet::where('provider_id',$request->provider_id)->first();

            if(empty($wallet)){

                return response()->json([
                    'status'=>404,
                    'message' => 'This provider dont have any amount on his/her wallet'
                ]);

            }
            
            else{

                if($wallet->status=='active'){

                    return response()->json([
                        'status'=>200,
                        'message' => 'Successfully Fetch',
                        'data' => $wallet
                    ]);
                }

                else{

                    return response()->json([
                        'status'=>202,
                        'message' => 'Wallet is disable for this Provider',
                    ]);
                }

            }
    }
    
    public function providerWallet(Request $request)
    {
            $wallet = Wallet::all();

            if(count($wallet)>0){
                
                foreach($wallet as $val){
                    
                    
                    $provider_data = $this->provider_curl($val->provider_id);
                    
                     $data[] = array(
                
                            'providerName' => ($provider_data['status']==403)?'':$provider_data['provider']['name'], 
                            'providerEmail' => ($provider_data['status']==403)?'':$provider_data['provider']['email'], 
                            'providerPhone' => ($provider_data['status']==403)?'':$provider_data['provider']['phone_no'], 
                            'amount'=>$val->amount,
                            'status'=>$val->status,
                    );
                    
                }
                
                return response()->json([
                    'status'=>200,
                    'data'=>$data,
                    'message' => 'Fetch Successfully'
                ]);
                

            }
            else{
    
                return response()->json([
                    'status'=>202,
                    'message' => 'Wallet is disable for this Provider',
                ]);
            }

    }
    
    public function payment_filter(Request $request)
    {
            // $s_timestamp = strtotime($request->start_date);
            // $e_timestamp = strtotime($request->end_date);
            // $start_date = date('d-M-Y',$s_timestamp);
            // $end_date = date('d-M-Y',$e_timestamp);
            
            
            // $payments = DB::select("SELECT * FROM payments
            //             WHERE STR_TO_DATE(date, '%d-%b-%Y') BETWEEN '2023-02-01' AND '2023-02-20'
            //             ORDER BY STR_TO_DATE(date, '%d-%b-%Y') DESC");
                        
            $payment = DB::select("SELECT * FROM payments
                        WHERE STR_TO_DATE(date, '%d-%b-%Y') BETWEEN ? AND ?
                        ORDER BY STR_TO_DATE(date, '%d-%b-%Y') DESC",
                        [$request->start_date, $request->end_date]);


                
            // $payment = Payment::orderBy('id','DESC')->whereBetween('date', [$start_date, $end_date])->where('provider_id',$request->provider_id)->get();
            
            

            if(count($payment)==0){

                return response()->json([
                    'status'=>404,
                    'message' => 'This provider dont have any Payment yet'
                ]);

            }
            
            else{
               
                    return response()->json([
                        'status'=>200,
                        'message' => 'Successfully Fetch',
                        'data' => $payment
                    ]);
               }
    }
    
    
    public function accounts(Request $request){
            
            $account = Account::orderBy('id','DESC')->get();
    
            if(count($account)>0){
                
                foreach($account as $acc){
                
                 $data[] = array(
                
                       'account_type'=>$acc->account_type,
                       'title'=>$acc->title,
                       'number'=>$acc->number,
                       'status'=>$acc->status,
                       'image'=>env('APP_URL').'images/account/'.$acc->image,
                    );
                    
                }
                
                return response()->json([
                    'status'=>200,
                    'data'=>$data,
                    'message' => 'Fetch Successfully'
                ]);
                
            }
            
           
            
            else{
                    return response()->json([
                        'status'=>404,
                        'message' => 'unSuccessfully',
                    ]);
                }
    }
    
    public function saveAccount(Request $request){
            
            
            if(!isset($request->account_type) || !isset($request->title) || !isset($request->number)){

                    return response()->json([
                        'status'=>404,
                        'message' => 'Someparameters are missing'
                    ]);
            }
            else{
                
                  
                
                if ($request->hasFile('image')) {
                    
                   
                        $file = $request->file('image');

                        $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();

                        $image['filePath'] = $name;

                        $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;

                        $file->move(public_path().'/images/account/', $file_name);
                }
                
                    $account = new Account();
                    $account->account_type = $request->account_type;
                    $account->title = $request->title;
                    $account->number = $request->number;
                    $account->image = (isset($file_name)?$file_name:'');
                    $account->save();

                    return response()->json([
                        'status'=>200,
                        'message' => 'Successfully Added'
                    ]);
            
            }
    }
    
    
    //Coupen Apis
    
    public function coupenSave(Request $request){
        
                   
            
            if(!isset($request->code) || !isset($request->title) || !isset($request->amount) || !isset($request->start_date)){

                    return response()->json([
                        'status'=>404,
                        'message' => 'Someparameters are missing'
                    ]);
            }
                
            else{
                
                $Ucoupen = new Coupen();
                $Ucoupen->title = $request->title;
                $Ucoupen->code = $request->code;
                $Ucoupen->amount = $request->amount;
                $Ucoupen->isPercentage = ($request->isPercentage===true?'1':0);
                $Ucoupen->start_date = $request->start_date;
                $Ucoupen->end_date = $request->end_date;
                $Ucoupen->save();

                return response()->json([
                        'status'=>200,
                        'message' => 'Action Successfully'
                    ]);
            }
    }
    
    public function coupen(Request $request){
        
                $coupen = Coupen::where('status','active')->get();
                
                if(count($coupen)>0){
                    
                     return response()->json([
                        'status'=>200,
                        'data' =>$coupen,
                        'message' => 'Action Successfully'
                    ]);
                    
                }else{

                    return response()->json([
                        'status'=>404,
                        'message' => 'Action Failed'
                    ]);
            }
    }
    
    public function coupenUsed(Request $request){
            
            if(!isset($request->coupen_code) || !isset($request->provider_id)){

                    return response()->json([
                        'status'=>404,
                        'message' => 'Someparameters are missing'
                    ]);
            }
            
            $coupen = Coupen::where('code',$request->coupen_code)->first();
            
            if($coupen==''){
                
                    return response()->json([
                        'status'=>404,
                        'message' => 'Invalid'
                    ]);
                }
                
            else{
                
                $Ucoupen = new CoupenUsed();
                $Ucoupen->coupen_id = $coupen->id;
                $Ucoupen->provider_id = $request->provider_id;
                $Ucoupen->date = date('d-M-Y');
                $Ucoupen->time = date('h:i A');
                $Ucoupen->save();

                return response()->json([
                        'status'=>200,
                        'amount'=>$coupen->amount,
                        'message' => 'Valid'
                    ]);
            }
    }
    
    public function provider_curl ($id) 
    {
        
        $response = Http::post('https://authentication.notension.pk/api/provider_info/',[
            'id'=>$id,
            ]);

        $data = $response->json();
        
        return $data;
                
    }
    


}
