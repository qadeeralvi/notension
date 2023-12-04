<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Banner;
use App\Models\JobManagement;
use App\Models\JobStatus;
use App\Models\JobActive;

class ApiController extends Controller
{
    
    public function category()
    {
       
        $categories = Category::where('status','Active')->orderBy('id','desc')->get();
        
        foreach($categories as $key => $val){

                $data[] = array(

                    'id'=>$val->id,
                    'name'=>$val->name,
                    'days'=>$val->days,
                    'price'=>$val->price,
                    'end_time'=>$val->end_time,
                    'minimum'=>$val->maximum,
                    'maximum'=>$val->minimum,
                    'price'=>$val->price,
                    'location'=>$val->location,
                    'less_assign'=>$val->less_assign,
                    'last_assign'=>$val->last_assign,
                    'maximum_rating'=>$val->maximum_rating,
                    'image'=>(!empty($val->image))?env('APP_URL').'/images/'.$val->image:NULL,
                    'status'=>$val->status,
                    'created_at'=>$val->created_at,

                );
            }
        
        return response()->json([
                'status_code'=>200,
                'data'=>$data
            ]);
    }
    
    public function category_filter(Request $request)
    {   
        $words = explode(" ",$request->search_values);
        
        
        $categories = Category::all();
        
        foreach($words as  $word){
            
                $results1 = collect($categories)->where('name', ucfirst($word));
                 
                if(count($results1)==0){
                     
                      $results = collect($categories)->where('name', lcfirst($word));
                     
                 
                    if(count($results)>0){

                        return response()->json([
                            'status'=>200,
                            'data'=>$results->values(),

                        ]);
                    }
                }
                
                else{
                    
                     return response()->json([
                            'status'=>200,
                            'data'=>$results1->values(),

                        ]);
                        
                }
        
               
        }
        
         $results = collect($categories)->where('name', 'Other');
                return response()->json([
                    'status'=>200,
                    'data'=>$results->values(),
                ]);
    }
    
    public function category_search(Request $request)
    {
        $q = $request->q;
        
        $categories = Category::where('name', 'LIKE', '%'.$q.'%');
        
        $subCategories = Sub_category::where('name', 'LIKE', '%'.$q.'%');
    
        $data = $categories->union($subCategories)->get();
        
        if($q!='' && count($data)>0){
            
            foreach ($data as $key => $value) {
                
                $table = Category::where('name', $value->name)->first();
            
                if ($table!='') {
                    $table = 'cat';
                } else{
                    $table = 'sub_cat';
                }
        
                    $data1[] = array(
                    
                        'id' => $value->id, 
                        'name' => $value->name, 
                        'table' => $table
                    );
            }
        
                return response()->json([
                    'status'=>200,
                    'data'=>$data1
                ]);
        }
        
        else{
            return response()->json([
                'status'=>404,
            ]);
        }
        
    }
    
    public function categorySearchByWord(Request $request)
    {
        
        $q = $request->q;
        
        $word = explode(" ",$q);
        
        $data = '';
        
        foreach($word as $key => $val){
            
            $category = Category::where('name', $val)->first();
            
            if ($category) {
                
                $data = array(
                        
                        'id'=>$category->id,
                        'name'=>$category->name,
                        'type'=>'category',
                    );
                    
                break;
            }
            
            else{
            
                $subCategory = Sub_category::where('name', $val)->first();
                
                if ($subCategory) {
                    
                    $data = array(
                        
                        'id'=>$subCategory->id,
                        'name'=>$subCategory->name,
                        'type'=>'sub_category',
                    );
                    
                break;
                    
                }
            }
        }
        
            if($data){
        
                return response()->json([
                    'status'=>200,
                    'data'=>$data,
                ]);
            }
            else{
                
                return response()->json([
                    'status'=>400,
                ]);
                
            }
                
    }
    
    
    public function category_Id(Request $request)
    {
        
        $subCategories = Sub_category::where('id', $request->subCat_id)->first();
    
        
        if($subCategories!=''){
            
                    $data = array(
                    
                        'id' => $subCategories->id, 
                        'name' => $subCategories->name, 
                        'category_id' => $subCategories->category_id, 
                    );
        
                return response()->json([
                    'status'=>200,
                    'data'=>$data
                ]);
        }
        
        else{
            return response()->json([
                'status'=>404,
                'para'=> $request->subCat_id,
            ]);
        }
        
    }
    
    public function save_category(Request $request)
    {
        
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
            
        $categories = Category::create([
            
            'name'=>$request->name,
            'days'=>$request->days,
            'end_time'=>$request->end_time,
            'minimum'=>$request->minimum,
            'maximum'=>$request->maximum,
            'less_assign'=>($request->less_assign==true?'1':null),
            'location'=>($request->location==true?'1':''),
            'last_assign'=>($request->last_assign==true?'1':null),
            'price'=>$request->price,
            'maximum_rating'=>($request->maximum_rating==true?'1':null),
            'image'=>$file_name
            
            ]);
        
            return response()->json([
                'status'=>200,
                'data'=>'Data saved successfully'
            ]);
    }
    
    public function save_sub_category(Request $request)
    {
        
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
            
            Sub_category::create([
            
                'name'=>$request->name,
                'category_id'=>$request->category,
                'days'=>$request->days,
                'end_time'=>$request->end_time,
                'minimum'=>$request->minimum,
                'maximum'=>$request->maximum,
                'less_assign'=>($request->less_assign==true?'1':null),
                'location'=>($request->location==true?'1':''),
                'last_assign'=>($request->last_assign==true?'1':null),
                'price'=>$request->price,
                'maximum_rating'=>($request->maximum_rating==true?'1':null),
                'image'=>$file_name
            
            ]);
        
            return response()->json([
                'status'=>200,
                'data'=>'Data saved successfully'
            ]);
    }
    
    public function singleCategory(Request $request)
    {
        
        $data = Category::where('id',$request->id)->first();

        if($data!=''){
            
            return response()->json([
                'status'=>200,
                'data'=>$data,
                'message'=>'Data fetch successfully'
            ]);
        }
        else{
                return response()->json([
                'status'=>404,
              
                'data'=>'Data not found'
            ]);
        }
        
    }
    
    public function singleSubCategory(Request $request)
    {
        
        $data = Sub_category::where('id',$request->id)->first();

        if($data!=''){
            
            return response()->json([
                'status'=>200,
                'data'=>$data,
                'message'=>'Data fetch successfully'
            ]);
        }
        else{
                return response()->json([
                'status'=>404,
                'message'=>'Data not found'
            ]);
        }
        
    }
    
    public function updateCategory(Request $request)
    {
        
      
                
        $data = Category::where('id',$request->id)->first();
        
        if($data!=''){
        
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
                    
                    $img_path = public_path().'/images/'.$request->imageDisplay;
                
                    unlink($img_path);
                
    
                } 
                else{
                    $file_name=$request->imageDisplay;
                }
                
            $data->name = $request->name;
            $data->days = $request->days;
            $data->price = $request->price;
            $data->end_time = $request->end_time;
            $data->minimum = $request->minimum;
            $data->maximum = $request->maximum;
            $data->less_assign = ($request->less_assign===true||$request->less_assign=='1'?'1':null);
            $data->last_assign = ($request->last_assign===true||$request->last_assign=='1'?'1':null);
            $data->location = ($request->location===true||$request->location=='1'?'1':null);
            $data->maximum_rating = ($request->maximum_rating===true||$request->maximum_rating=='1'?'1':null);
            $data->image = $file_name;
            $data->save();
            
                return response()->json([
                    'status'=>200,
                    'data'=>'Data updated successfully'
                ]);
        }
         else{
                return response()->json([
                'status'=>404,
                'message'=>'Data not found'
            ]);
        }
        
        
    }
    
    public function updateSubCategory(Request $request)
    {
        
    
        $data = Sub_category::where('id',$request->id)->first();
        
        if($data!=''){
        
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
                    
                    $img_path = public_path().'/images/'.$request->imageDisplay;
                
                    unlink($img_path);
                
    
                } 
                else{
                    $file_name=$request->imageDisplay;
                }
                
            $data->name = $request->name;
            $data->category_id = $request->category;
            $data->days = $request->days;
            $data->price = $request->price;
            $data->end_time = $request->end_time;
            $data->minimum = $request->minimum;
            $data->maximum = $request->maximum;
            $data->less_assign = ($request->less_assign===true||$request->less_assign=='1'?'1':null);
            $data->last_assign = ($request->last_assign===true||$request->last_assign=='1'?'1':null);
            $data->location = ($request->location===true||$request->location=='1'?'1':null);
            $data->maximum_rating = ($request->maximum_rating===true||$request->maximum_rating=='1'?'1':null);
            $data->image = $file_name;
            $data->save();
            
                return response()->json([
                    'status'=>200,
                    'data'=>'Data updated successfully'
                ]);
        }
         else{
                return response()->json([
                'status'=>404,
                'message'=>'Data not found'
            ]);
        }
        
        
    }
    
    
    public function delete_sub_category(Request $request)
    {
        
        Sub_category::where('id',$request->id)->delete();

        return response()->json([
                'status'=>200,
                'data'=>'Data delete successfully'
            ]);
    }
    
    public function delete_category(Request $request)
    {
        
        Category::where('id',$request->id)->delete();

        return response()->json([
                'status'=>200,
                'data'=>'Data delete successfully'
            ]);
    }
    
    
    public function all_sub_category()
    {
        $sub_categories = Sub_category::orderBy('id','desc')->get();
        
        foreach($sub_categories as $key => $val){
            
             $category = Category::where('id',$val->category_id)->first();

                $data[] = array(

                    'id'=>$val->id,
                    'name'=>$val->name,
                    'category' => $category->name,
                    'days'=>$val->days,
                    'price'=>$val->price,
                    'end_time'=>$val->end_time,
                    'minimum'=>$val->maximum,
                    'maximum'=>$val->minimum,
                    'price'=>$val->price,
                    'location'=>$val->location,
                    'less_assign'=>$val->less_assign,
                    'last_assign'=>$val->last_assign,
                    'maximum_rating'=>$val->maximum_rating,
                    'image'=>(!empty($val->image))?env('APP_URL').'/images/'.$val->image:NULL,
                    'status'=>$val->status,
                    'created_at'=>$val->created_at,

                );
            }
        
            return response()->json([
                'status'=>200,
                'data'=>$data
            ]);
            
        
        
    }
    
    public function sub_category(Request $request)
    {
        
                
         $sub_categories = Sub_category::where('category_id',$request->id)->get();
         
         if(!$sub_categories->isEmpty()){
             
                return response()->json([
                    'status'=>200,
                    'data'=>$sub_categories
                ]);
                
         }
         
         else{
             
              return response()->json([
                    'status'=>404,
                    'id'=>$request->id,
                    'message'=>'Sub Categories not available with this id'
                ]);
                
         }
    } 
    
     public function subCategory(Request $request)
    {
         $sub_categories = Sub_category::where('category_id',$request->id)->get();
         
         if(!$sub_categories->isEmpty()){
             
             return response()->json([
                    'status'=>200,
                    'data'=>$sub_categories
                ]);
                
         }
         
         else{
             
              return response()->json([
                    'status'=>404,
                    'id'=>$request->id,
                    'message'=>'Sub Categories not available with this id'
                ]);
                
         }
    } 
    
    public function banner(Request $request)
    {
         $banner = Banner::all();
         
          foreach ($banner as $key => $value) {
              
                      $data[] = env('APP_URL').'/images/banners/'.$value->image;
                      
                }
         if(count($data)!=0){
             
             return response()->json([
                    'status'=>200,
                    'data'=>$data
                ]);
                
         }
         
         else{
             
              return response()->json([
                    'status'=>404,
                    'message'=>'Not available'
                ]);
                
         }
    }   
    
    
    public function post_job (Request $request) 
    {
        
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'category' => 'required',
                'phone' => 'required',
                'name' => 'required',
                'city' => 'required',
                'address' => 'required',
                'description' => 'required',
                'email' => 'required|email',
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
                    
              if ($request->hasFile('image')) {
                  
                    foreach($request->image as $file) {
                        

                        $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
                
                        $image['filePath'] = $name;
                
                        $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;
                
                        $file->move(public_path().'/job_images/', $file_name);
                        
                        $filenames[] = $file_name;
                        
                    }
                            $filename = implode(',', $filenames);

                }
                
                $user_id = '';
                
        if($request->user_id==0 || $request->user_id=="0"){
            
                 $checkuser = Http::post('https://authentication.notension.pk/api/check_user_email',[
                            'email'=>$request->email,
                            ]);
                            
                    if($checkuser['status']==200){
                        // $user_id = $checkuser['user_id'];
                        
                    }else{
                        
                                $pass  = substr(md5(mt_rand()), 0, 9);
                                $user = Http::post('https://authentication.notension.pk/api/user/signup',[
                                            'name'=>$request->name,
                                            'email'=>$request->email,
                                            'address'=>$request->address,
                                            'phone_no'=>$request->phone,
                                            'password'=>$pass,
                                            'confirm_password'=>$pass,
                                            'signupmethod'=>'email'
                                ]);
                                
                         $user_id = $user;
                    }
        }
                

       $job = JobManagement::create([

                'user_id' => ($request->user_id?$request->user_id:$user_id),
                'title' => $request->title,
                'category' => $request->category,
                'sub_category' => $request->sub_category,
                'phone' => $request->phone,
                'name' => $request->name,
                'city' => $request->city,
                'address' => $request->address,
                'description' => $request->description,
                'company_contact_you' => $request->company_contact_you,
                'who_you' => $request->who_you,
                'your_cost' => $request->your_cost,
                'job_start' => $request->job_start,
                'email' => (isset($request->email)?$request->email:''),
                'image' => (!empty($filename))?$filename:"",
                'date' => date("d-M-Y"),
                'time' =>  date("h:i:s a"),
                'status' => 'pending'
            ]);
        
        
        if(isset($request->sub_category) && $request->sub_category!=0)
            {
                $Sub_category = Sub_category::where('id',$request->sub_category)->first();

                $NewDate=date('Y-m-d', strtotime('+'.$Sub_category->days.' days'));

                JobStatus::create([
                    'job_id' => $job->id,
                    'end_date' => $NewDate,
                    'end_time' => $Sub_category->end_time,
                    'minimum' => $Sub_category->minimum,
                    'maximum' => $Sub_category->maximum,
                    'less_assign' => $Sub_category->less_assign,
                    'location' => $Sub_category->location,
                    'last_assign' => $Sub_category->last_assign,
                    'maximum_rating' => $Sub_category->maximum_rating,
                ]);
            }
            
            else{

                $category = Category::where('id',$request->category)->first();

                $NewDate=date('Y-m-d', strtotime('+'.$category->days.' days'));

                JobStatus::create([
                    'job_id' => $job->id,
                    'end_date' => $NewDate,
                    'end_time' => $category->end_time,
                    'minimum' => $category->minimum,
                    'maximum' => $category->maximum,
                    'less_assign' => $category->less_assign,
                    'location' => $category->location,
                    'last_assign' => $category->last_assign,
                    'maximum_rating' => $category->maximum_rating,
                ]);
            }
            
        return response()->json([
            'status'=>200,
            'message'=>'Job Post Successfully',
        ]); 
            
    }
    
    
    public function check_job(Request $request) {
        
            $job = JobManagement::where('id',$request->job_id)->first();
         
            $imgs= explode(",",$job->image);
            
            $search = "167420099567269.png";
            
            $key = array_search($search, $imgs);
        
           if ($key !== false) {
                   unset($imgs[$key]);
                $res= "{$search} is present in the array at key {$key}";
            } else {
                $res= "{$search} is not present in the array";
            }
            
                return response()->json([
                    'status'=>200,
                    'old'=>$res,
                    'im'=>$imgs,
                ]); 
         
        
    }
        
    public function delete_job_image(Request $request) {
        
            $job = JobManagement::where('id',$request->job_id)->first();
         
            $imgs = explode(",",$job->image);
            
            $req_img = explode("/",$request->image);
            
            $search = $req_img[4];
            
            $key = array_search($search, $imgs);
        
           if ($key !== false) {
               
                $img_path = 'public/job_images/'.$imgs[$key];
                
                unlink($img_path);
                
                unset($imgs[$key]);
                
                $job->image = implode(",",$imgs);
                
                $job->save();
            
                return response()->json([
                    'status'=>200,
                    'message'=>'Image Delete Successfully'
                ]);
                
            } 
            else {
               return response()->json([
                    'status'=>404,
                    'message'=>'Image not found'
                ]);
            }
    }
    
    public function update_job (Request $request) 
    {
        
            $validator = Validator::make($request->all(), [
                'job_id' => 'required',
                'title' => 'required',
                'name' => 'required',
                'description' => 'required',
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
            
            $job = JobManagement::where('id',$request->job_id)->first();
            
            if($job==''){
                return response()->json([
                    'status'=>404,
                    'message'=>'Job not found',
                ]); 
            }
            
                    
                if ($request->hasFile('image')) {
                  
                    foreach($request->image as $file) {
                        

                        $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
                
                        $image['filePath'] = $name;
                
                        $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;
                
                        $file->move(public_path().'/job_images/', $file_name);
                        
                        $filenames[] = $file_name;
                        
                    }
                }
                
                if(isset($filenames) && $job->image!=''){
                    
                    $old_imgs= explode(",",$job->image);
            
                    $final_imgs = array_merge($filenames,$job->image);
                }
                elseif(isset($filenames) && $job->image==''){
                    $final_imgs = implode(",",$filenames);
                }
                else{
                    
                    $final_imgs = $job->image;
                    
                }
                
          
            
        JobManagement::where('id', $request->job_id)->update([

                'user_id' => $job->user_id,
                'title' => $request->title,
                'category' => $job->category,
                'sub_category' => $job->sub_category,
                'phone' => $job->phone,
                'name' => $request->name,
                'city' => $job->city,
                'address' => $job->address,
                'description' => $request->description,
                'company_contact_you' => $job->company_contact_you,
                'who_you' => $job->who_you,
                'your_cost' => $job->your_cost,
                'job_start' => $job->job_start,
                'email' => (isset($request->email)?$request->email:''),
                'image' => $final_imgs,
                'date' => $job->date,
                'time' =>  $job->time,
                'status' => $job->status
            ]);
        
        
         return response()->json([
            'status'=>200,
            'message'=>'Job Updated Successfully',
        ]); 
            
    }
    
    public function save_job_status(Request $request)
    {
        
    
        $job1 = JobManagement::find($request->job_id);
        $job1->status = $request->status;
        $job1->save();
            
        
        $job = JobStatus::where('job_id',$request->job_id)->first();
            
        $job->end_date=$request->end_date;
        $job->end_time=$request->end_time;
        $job->minimum=$request->minimum;
        $job->maximum=$request->maximum;
        $job->less_assign=$request->less_assign;
        $job->location=$request->location;
        $job->last_assign=$request->last_assign;
        $job->maximum_rating=$request->maximum_rating;
        
        $job->save();
        
        
                    $job = new JobActive();
                          
                    $job->provider_id = 1;
                    $job->job_id = $request->job_id;
                    $job->save();
                        
                        Http::post('https://authentication.notension.pk/api/sendNotification/',[
                            'id'=>1,
                            'action_id'=>$request->job_id,
                            'title'=>'Matched job',
                            'message'=>'You have a macthed job',
                            'sent_to'=>'provider'
                        ]);
            
             if($request->status=="active"){
    
                job_algo($request->job_id);
                
                 
             }
            
            return response()->json([
                'status'=>200,
                'data'=>'Data saved successfully'
            ]);
    }
    
    public function all_job_list (Request $request) 
    {
        $job = JobManagement::orderBy('id', 'DESC')->get();
         
         if(count($job)!=0){
             
               foreach ($job as $key => $value) {
                   
                    // $imgs=[];
                    // $images = explode(',',$value['image']);
                     
                    // foreach($images as $key => $img){
                    //     $imgs[$key] = env('APP_URL').'/job_images/'.$img;
                    // }
                   
                        
                    
                     $cat = Category::where('id',$value->category)->first();
                     
                     $sub_cat = Sub_category::where('id',$value->sub_category)->first();
                   
                     $data[] = array(
                                
                                    'id' => $value->id, 
                                    'user_id' => $value->user_id, 
                                    'title' => $value->title, 
                                    'category' => $value->category, 
                                    'category_title' => ($cat!='')?$cat->name:'no', 
                                    'sub_category' => $value->sub_category, 
                                    'sub_category_title' => ($sub_cat!='')?$sub_cat->name:'no',
                                    'phone' => $value->phone, 
                                    'email' => $value->email, 
                                    'name' => $value->name, 
                                    'city' => $value->city, 
                                    'address' => $value->address, 
                                    'postal_code' => $value->postal_code, 
                                    'description' => $value->description, 
                                    'date' => $value->date, 
                                    'time' => $value->time, 
                                    'company_contact_you' => $value->company_contact_you, 
                                    'who_you' => $value->who_you, 
                                    'your_cost' => $value->your_cost, 
                                    'job_start' => $value->job_start, 
                                    // 'image' => $imgs,
                                    'assigned_to' => $value->assigned_to, 
                                    'status' => $value->status, 
                                    
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
    
    public function single_job (Request $request) 
    {
          
           $validator = Validator::make($request->all(), [
                'job_id' => 'required',
               
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
          
        $job = JobManagement::where('id',$request->job_id)->first();
         
        $job_active = JobActive::where('job_id',$request->job_id)->get();
        
        $provider_job_status = 'pending';
        
        $provider_id = '';
        

            if(count($job_active)>0){
                
                $job_active1[]=$job_active;
                
                 foreach ($job_active1 as $innerArray) {
                    foreach ($innerArray as $object) {
                        if ($object['status'] === 'active' || $object['status'] === 'complete' || $object['status'] === 'done' ) {
                            
                            $provider_job_status = $object['status'];
                            $provider_id = $object['provider_id'];
                            $found = 'yes';
                            break 2;
                        }
                       
                        else{
                             $found = 'no';
                        }
                    }
                }
             
               
            }
            
                    $imgs=[];
                    $images = explode(',',$job['image']);
                     
                    foreach($images as $img){
                        $imgs[] = env('APP_URL').'/job_images/'.$img;
                    }    
                    
                   $imgs1 = collect($imgs)->map(function($value) {
                      return (object) [
                        $value
                      ];
                   });
                    
                   
         
         if($job!=''){
             
                    $cat = Category::where('id',$job->category)->first();
                     
                    $sub_cat = Sub_category::where('id',$job->sub_category)->first();
                   
                    $data[] = array(
                                   
                                    'id' => $job->id, 
                                    'user_id' => $job->user_id, 
                                    'title' => $job->title, 
                                    'category' => $job->category, 
                                    'category_title' => ($cat!='')?$cat->name:'no', 
                                    'sub_category' => $job->sub_category, 
                                    'sub_category_title' => ($sub_cat!='')?$sub_cat->name:'no',
                                    'phone' => $job->phone, 
                                    'email' => $job->email, 
                                    'name' => $job->name, 
                                    'city' => $job->city, 
                                    'address' => $job->address, 
                                    'postal_code' => $job->postal_code, 
                                    'description' => $job->description, 
                                    'date' => $job->date, 
                                    'time' => $job->time, 
                                    'company_contact_you' => $job->company_contact_you, 
                                    'who_you' => $job->who_you, 
                                    'your_cost' => $job->your_cost, 
                                    'job_start' => $job->job_start, 
                                    'images'=>$imgs1,
                                    'assigned_to' => $job->assigned_to, 
                                    'status' => $job->status, 
                                    'provider_job_status'=>$provider_job_status,
                                    'provider_id'=>$provider_id
                                    
                                    );
             
                    return response()->json([
                        'status'=>200,
                        'message'=>'Job fetch Successfully',
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
    
    
    public function job_images (Request $request) 
    {
          
           $validator = Validator::make($request->all(), [
                'job_id' => 'required',
               
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
          
        $job = JobManagement::where('id',$request->job_id)->first();
        
        $images = explode(',',$job['image']);
        
              
         
        if($job->image!=null){
         
          foreach($images as $img){
                        $imgs[] = env('APP_URL').'/job_images/'.$img;
                    } 
                return response()->json([
                    'status'=>200,
                    'data'=>$imgs
                ]);
        }
        else{
             
             return response()->json([
                    'status'=>404,
                    'message'=>'images not found'
                ]);
                
         }
 
        
    }
    
      public function provider_single_job (Request $request) 
    {
          
           $validator = Validator::make($request->all(), [
                'job_id' => 'required',
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
          
        $job = JobManagement::where('id',$request->job_id)->first();
         
        $job_active = JobActive::where('job_id',$request->job_id)->where('provider_id',$request->provider_id)->first();
        
            
                    $imgs=[];
                    $images = explode(',',$job['image']);
                     
                    foreach($images as $img){
                        $imgs[] = env('APP_URL').'/job_images/'.$img;
                    }    
                    
                   $imgs1 = collect($imgs)->map(function($value) {
                      return (object) [
                        $value
                      ];
                   });
                    
                   
         
         if($job!=''){
             
                    $cat = Category::where('id',$job->category)->first();
                     
                    $sub_cat = Sub_category::where('id',$job->sub_category)->first();
                   
                    $data[] = array(
                                   
                                    'id' => $job->id, 
                                    'user_id' => $job->user_id, 
                                    'title' => $job->title, 
                                    'category' => $job->category, 
                                    'category_title' => ($cat!='')?$cat->name:'no', 
                                    'sub_category' => $job->sub_category, 
                                    'sub_category_title' => ($sub_cat!='')?$sub_cat->name:'no',
                                    'phone' => $job->phone, 
                                    'email' => $job->email, 
                                    'name' => $job->name, 
                                    'city' => $job->city, 
                                    'address' => $job->address, 
                                    'postal_code' => $job->postal_code, 
                                    'description' => $job->description, 
                                    'date' => $job->date, 
                                    'time' => $job->time, 
                                    'company_contact_you' => $job->company_contact_you, 
                                    'who_you' => $job->who_you, 
                                    'your_cost' => $job->your_cost, 
                                    'job_start' => $job->job_start, 
                                    'images'=>$imgs1,
                                    'assigned_to' => $job->assigned_to, 
                                    'status' => $job->status, 
                                    'provider_job_status'=>($job_active!='')?$job_active->status:'no',
                                    
                                    );
             
                    return response()->json([
                        'status'=>200,
                        'message'=>'Job fetch Successfully',
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
    
    public function user_job_list (Request $request) 
    {
        
        if(!isset($request->user_id))
            
            {
            
                 return response()->json([
                    'status'=>203,
                    'message'=>'User Id is missing',
                ]);
            
            }
            
         $job = JobManagement::where('user_id',$request->user_id)->orderBy('id','desc')->OrderBy('id','DESC')->get();
         
         if(count($job)!=0){
                
               foreach ($job as $key => $value) {
               
                   
                     $cat = Category::where('id',$value->category)->first();
                     
                     $sub_cat = Sub_category::where('id',$value->sub_category)->first();
                     
                     $actives = JobActive::where('job_id',$value->id)->get();
                   
                     $data[] = array(
                                
                                    'id' => $value->id, 
                                    'user_id' => $value->user_id, 
                                    'title' => $value->title, 
                                    'category' => $value->category, 
                                    'category_title' => ($cat!='')?$cat->name:'no',
                                    'sub_category' => $value->sub_category, 
                                    'sub_category_title' => ($sub_cat!='')?$sub_cat->name:'no',
                                    'phone' => $value->phone, 
                                    'email' => $value->email, 
                                    'name' => $value->name, 
                                    'city' => $value->city, 
                                    'address' => $value->address, 
                                    'postal_code' => $value->postal_code, 
                                    'description' => $value->description, 
                                    'date' => $value->date, 
                                    'time' => $value->time, 
                                    'company_contact_you' => $value->company_contact_you, 
                                    'who_you' => $value->who_you, 
                                    'your_cost' => $value->your_cost, 
                                    'job_start' => $value->job_start, 
                                    'assigned_to' => $value->assigned_to, 
                                    'status' => $value->status, 
                                    'provider_jobs'=>$actives
                                    
                                );
               }
             
             
              return response()->json([
                'status'=>200,
                'message'=>'Job fetch Successfully',
                'data'=>$data
            ]); 
            
         }
         else{
             
              return response()->json([
                'status'=>404,
                'message'=>'This user dont have any job',
            ]); 
            
         }
    } 
    
   
    
    public function job_status (Request $request) 
    {
        
        if(!isset($request->job_id))
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Job Id is missing',
                ]);
            
            }
            
         $job = JobStatus::with('user_job')->where('job_id',$request->job_id)->first();
         
         if($job!=''){
             
              return response()->json([
                'status'=>200,
                'message'=>'Job fetch Successfully',
                'data'=>$job
            ]); 
            
         }
         else{
             
              return response()->json([
                'status'=>404,
                'message'=>'This Job Id not available',
            ]); 
            
         }
    }
    
    public function provider_job_list (Request $request) 
    {
        
        if(!isset($request->provider_id))
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Provider Id is missing',
                ]);
            
            }
            
         $job_active = JobActive::orderBy('id','desc')->where('provider_id',$request->provider_id)->get();
         
         if(count($job_active)>0){
             
             foreach ($job_active as $key => $value) {
                 
                $job = JobManagement::where('id',$value->job_id)->first();
                $job_status = JobStatus::where('job_id',$value->job_id)->first();
                
                //  $imgs=[];
                //     $images = explode(',',$job['image']);
                     
                //     foreach($images as $img){
                //         $imgs[] = env('APP_URL').'/job_images/'.$img;
                //     }
                
                $cat = Category::where('id',$job->category)->first();
                     
                $sub_cat = Sub_category::where('id',$job->sub_category)->first();
                   
                $data[] = array(
                                
                                    'id' => $job->id, 
                                    'user_id' => $job->user_id, 
                                    'title' => $job->title, 
                                    'category' => $job->category, 
                                    'category_title' => ($cat!='')?$cat->name:'no',
                                    'sub_category' => $job->sub_category, 
                                    'sub_category_title' => ($sub_cat!='')?$sub_cat->name:'no',
                                    'phone' => $job->phone, 
                                    'email' => $job->email, 
                                    'name' => $job->name, 
                                    'city' => $job->city, 
                                    'address' => $job->address, 
                                    'postal_code' => $job->postal_code, 
                                    'description' => $job->description, 
                                    'date' => $job->date, 
                                    'time' => $job->time, 
                                    'company_contact_you' => $job->company_contact_you, 
                                    'who_you' => $job->who_you, 
                                    'your_cost' => $job->your_cost, 
                                    'job_start' => $job->job_start, 
                                    'price' => ($sub_cat!='')?$sub_cat->price:$cat->price, 
                                    // 'image' => $imgs,
                                    'provider_assign_status' => $value->status, 
                                   
                                    
                                    );
             
            }
             
              return response()->json([
                'status'=>200,
                'message'=>'Job fetch Successfully',
                'data'=>$data
            ]); 
            
         }
         else{
             
              return response()->json([
                'status'=>404,
                'message'=>'This provider dont have any job',
            ]); 
            
         }
    }
    
    
    public function provider_job_status_change (Request $request) 
    {
        
        if(!isset($request->job_id) || !isset($request->status) || !isset($request->provider_id) )
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Some Paramter is missing',
                ]);
            
            }
            
                $job = JobManagement::where('id',$request->job_id)->with('catDetail','subCatDetail')->first();
                
                if($job->sub_cat_detail!=null){
                    
                       $price = $job->subCatDetail->price;
                }
                else{
                    
                    $price = $job->catDetail->price;
                    
                }
                
                
                if($price!=''){
                    $deduct_amount = $price;
                }
                else{
                    
                    $fetchDefaultPayment = Http::post('https://website.notension.pk/api/webSetting/',[]);
                        
                    $defPayment = $fetchDefaultPayment->json();
                    
                     if($defPayment['status']==200){
                         
                         $deduct_amount = $defPayment['data']['default_payment'];
                         
                     }
                }
                
                    
                
                $cat = Category::where('id',$job->category)->first();
                     
                $sub_cat = Sub_category::where('id',$job->sub_category)->first();
                
            
            $job_active = JobActive::where('job_id',$request->job_id)->get();
            
            $coupen_resp['amount'] = 0 ; 
            
            if(isset($request->coupen_code)){
                
                $coupen = Http::post('https://payment.notension.pk/api/coupenUsed/',[
                            'coupen_code'=>$request->coupen_code,
                            'provider_id'=>$request->provider_id,
                        ]);
                        
                $coupen_resp = $coupen->json();
                
                if($coupen_resp['status']==404){
                    
                    return response()->json([
                        'status'=>404,
                        'message' => 'Invalid'
                    ]);
                    
                }
            }
            
           
                    
                    
            $response = Http::post('https://payment.notension.pk/api/wallet/',[
                'provider_id'=>$request->provider_id,
                ]);
            
            $provider_wallet = $response->json();
            
            
            
                
            if($provider_wallet['status']==404){
               
               return response()->json([
                    'status'=>403,
                    'message'=>'You dont have any amount',
                 ]);
            }
           
            if($provider_wallet['data']['amount']=='0'){
                
                 return response()->json([
                    'status'=>403,
                    'message'=>'You dont have any amount',
                 ]);
                 
            }
            
            else if($provider_wallet['data']['amount']<$deduct_amount-$coupen_resp['amount']){
             
             
                    return response()->json([
                        'status'=>402,
                        'message'=>'You balance is less then from this job amount'
                    ]);
                     
            }
            
            else{
            
                   
                
                    $job_status = JobStatus::where('job_id',$request->job_id)->first();
                  
                    $response = Http::post('https://payment.notension.pk/api/deduct_payment/',[
                        'provider_id'=>$request->provider_id,
                        'amount'=>$deduct_amount-$coupen_resp['amount']
                    ]);
                    
                    $wallet_resp = $response->json();
                
                    if($wallet_resp['status']=='404' || $wallet_resp['status']=='403'){
                        
                        return response()->json([
                            'status'=>$wallet_resp['status'],
                            'message'=>$wallet_resp['message']
                         ]);
                        
                    }
                
            }
         
            if(count($job_active)>=1){
                
                    
                        if( $request->status=='active' || $request->status=='done'){
                            $jobManagement = JobManagement::where('id',$request->job_id)->first();
                            $jobManagement->status = $request->status;
                            $jobManagement->save();
                        }
                    
                    $job = JobActive::where('job_id',$request->job_id)->where('provider_id',$request->provider_id)->first();
                  
                    $job->status = $request->status;
                    $job->status_update_at = date('Y-M-d h:i:s a');
                    $job->save();
                    
                 return response()->json([
                    'status'=>200,
                    'message'=>'Updated Successfully',
                 ]);
                 
            }
            
         else{
             
             return response()->json([
                'status'=>404,
                'message'=>'Not found',
            ]);
            
         }
         
    }
    
    
    public function user_job_status_change (Request $request) 
    {
        
        if(!isset($request->job_id) || !isset($request->status) || !isset($request->provider_id) )
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Some Paramter is missing',
                ]);
            
            }
            
            $job_active = JobActive::where('job_id',$request->job_id)->get();
            
            $job_status = JobStatus::where('job_id',$request->job_id)->first();
              
            if(count($job_active)>=1){
                
                        if($request->status=='done'){
                            $jobManagement = JobManagement::where('id',$request->job_id)->first();
                            $jobManagement->status = $request->status;
                            $jobManagement->save();
                        }
                    
                    $job = JobActive::where('job_id',$request->job_id)->where('provider_id',$request->provider_id)->first();
                  
                    $job->status = $request->status;
                    $job->status_update_at = date('Y-M-d h:i:s a');
                    $job->save();
                    
                 return response()->json([
                    'status'=>200,
                    'message'=>'Updated Successfully',
                 ]);
                 
            }
            
         else{
             
             return response()->json([
                'status'=>404,
                'message'=>'Not found',
            ]);
            
         }
         
    }
    
    
    public function provider_job_status_pending(Request $request) 
    {
        
        if(!isset($request->provider_id))
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Some Paramter is missing',
                ]);
            
            }
            
            $job_active = JobActive::orderBy('id','desc')->where('provider_id',$request->provider_id)->where('status','pending')->get();
         
            if(count($job_active)>0){
             
                foreach ($job_active as $key => $value) {
                 
                    $job = JobManagement::where('id',$value->job_id)->first();
                    
                    $cat = Category::where('id',$job->category)->first();
                         
                    $sub_cat = Sub_category::where('id',$job->sub_category)->first();
                       
                    $data[] = array(
                                    
                                        'id' => $job->id, 
                                        'user_id' => $job->user_id, 
                                        'title' => $job->title, 
                                        'category' => $job->category, 
                                        'category_title' => ($cat!='')?$cat->name:'no',
                                        'sub_category' => $job->sub_category, 
                                        'sub_category_title' => ($sub_cat!='')?$sub_cat->name:'no',
                                        'phone' => $job->phone, 
                                        'email' => $job->email, 
                                        'name' => $job->name, 
                                        'city' => $job->city, 
                                        'address' => $job->address, 
                                        'postal_code' => $job->postal_code, 
                                        'description' => $job->description, 
                                        'date' => $job->date, 
                                        'time' => $job->time, 
                                        'company_contact_you' => $job->company_contact_you, 
                                        'who_you' => $job->who_you, 
                                        'your_cost' => $job->your_cost, 
                                        'job_start' => $job->job_start, 
                                        'image' => config('app.url').'/job_images/'.$job->image, 
                                        
                                        'status' => $value->status, 
                                       
                                        
                                        );
             
            }
             
            return response()->json([
                'status'=>200,
                'message'=>'Job fetch Successfully',
                'data'=>$data
            ]); 
            
         }
         else{
             
              return response()->json([
                'status'=>404,
                'message'=>'This provider dont have any job',
            ]); 
            
         }
    }
    
    
    
    public function provider_job_status_ongoing(Request $request) 
    {
        
        if(!isset($request->provider_id))
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Some Paramter is missing',
                ]);
            
            }
            
            $job_active = JobActive::orderBy('id','desc')->orderBy('id','desc')->where('provider_id',$request->provider_id)->where('status','active')->get();
         
            if(count($job_active)>0){
             
                foreach ($job_active as $key => $value) {
                 
                    $job = JobManagement::where('id',$value->job_id)->first();
                    
                    $cat = Category::where('id',$job->category)->first();
                         
                    $sub_cat = Sub_category::where('id',$job->sub_category)->first();
                       
                    $data[] = array(
                                    
                                        'id' => $job->id, 
                                        'user_id' => $job->user_id, 
                                        'title' => $job->title, 
                                        'category' => $job->category, 
                                        'category_title' => ($cat!='')?$cat->name:'no',
                                        'sub_category' => $job->sub_category, 
                                        'sub_category_title' => ($sub_cat!='')?$sub_cat->name:'no',
                                        'phone' => $job->phone, 
                                        'email' => $job->email, 
                                        'name' => $job->name, 
                                        'city' => $job->city, 
                                        'address' => $job->address, 
                                        'postal_code' => $job->postal_code, 
                                        'description' => $job->description, 
                                        'date' => $job->date, 
                                        'time' => $job->time, 
                                        'company_contact_you' => $job->company_contact_you, 
                                        'who_you' => $job->who_you, 
                                        'your_cost' => $job->your_cost, 
                                        'job_start' => $job->job_start, 
                                        'image' => config('app.url').'/job_images/'.$job->image, 
                                        
                                        'status' => $value->status, 
                                       
                                        
                                        );
             
            }
             
            return response()->json([
                'status'=>200,
                'message'=>'Job fetch Successfully',
                'data'=>$data
            ]); 
            
         }
         else{
             
              return response()->json([
                'status'=>404,
                'message'=>'This provider dont have any job',
            ]); 
            
         }
    }
    
    
    
    
    public function provider_job_status_complete(Request $request) 
    {
        
        if( !isset($request->provider_id))
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Some Paramter is missing',
                ]);
            
            }
            
            $job_active = JobActive::orderBy('id','desc')->where('provider_id',$request->provider_id)->where('status','done')->get();
         
            if(count($job_active)>0){
             
                foreach ($job_active as $key => $value) {
                 
                    $job = JobManagement::where('id',$value->job_id)->first();
                    
                    $cat = Category::where('id',$job->category)->first();
                         
                    $sub_cat = Sub_category::where('id',$job->sub_category)->first();
                       
                    $data[] = array(
                                    
                                        'id' => $job->id, 
                                        'user_id' => $job->user_id, 
                                        'title' => $job->title, 
                                        'category' => $job->category, 
                                        'category_title' => ($cat!='')?$cat->name:'no',
                                        'sub_category' => $job->sub_category, 
                                        'sub_category_title' => ($sub_cat!='')?$sub_cat->name:'no',
                                        'phone' => $job->phone, 
                                        'email' => $job->email, 
                                        'name' => $job->name, 
                                        'city' => $job->city, 
                                        'address' => $job->address, 
                                        'postal_code' => $job->postal_code, 
                                        'description' => $job->description, 
                                        'date' => $job->date, 
                                        'time' => $job->time, 
                                        'company_contact_you' => $job->company_contact_you, 
                                        'who_you' => $job->who_you, 
                                        'your_cost' => $job->your_cost, 
                                        'job_start' => $job->job_start, 
                                        'image' => config('app.url').'/job_images/'.$job->image, 
                                        
                                        'status' => $value->status, 
                                       
                                        
                                        );
             
            }
             
            return response()->json([
                'status'=>200,
                'message'=>'Job fetch Successfully',
                'data'=>$data
            ]); 
            
         }
         else{
             
              return response()->json([
                'status'=>404,
                'message'=>'This provider dont have any job',
            ]); 
            
         }
    }
    
    
    public function provider_jobs(Request $request) 
    {
        
        if( !isset($request->job_id))
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Some Paramter is missing',
                ]);
            
            }
            
            $job_active = JobActive::orderBy('id','desc')->where('job_id',$request->job_id)->get();
            
            if(count($job_active)>0){
             
                foreach ($job_active as $key => $value) {
                        
                    $response = Http::post('https://authentication.notension.pk/api/provider_info/',[
                        'id'=>$value->provider_id,
                        ]);
                
                    $provider = $response->json();
            
                       
                    $data[] = array(
                                    
                                        'job_id' => $request->job_id, 
                                        'provider_id' => $provider['provider']['id'], 
                                        'provider_name' => $provider['provider']['name'], 
                                        'provider_email' => $provider['provider']['email'], 
                                        'provider_phone_no' => $provider['provider']['phone_no'], 
                                        
                                        );
             
            }
             
            return response()->json([
                'status'=>200,
                'message'=>'Provider fetch Successfully',
                'data'=>$data
            ]); 
            
         }
         else{
             
              return response()->json([
                    'status'=>404,
                    'message'=>'Not Found',
                ]); 
            
         }
    }
    
    public function providerByJob(Request $request) 
    {
        
        if( !isset($request->jobId) || !isset($request->userId))
            {
                 return response()->json([
                    'status'=>203,
                    'message'=>'Some Paramter is missing',
                ]);
            
            }
            
            $job_active = JobActive::orderBy('id','desc')->where('job_id',$request->jobId)->get();
            
            if(count($job_active)>0){
                
                $unseen = '';
             
                foreach ($job_active as $key => $value) {
                    
                        $chat = Http::post(env('CHAT_URL').'/user_messages/',[
                            'user_id'=>$request->userId,
                            'receiver_id'=>$value->provider_id,
                            ]);
                    
                        $userChat = $chat->json();  
                        
                        if($userChat['status']==200){
                            
                            $unseen = collect($userChat['data'])->where('seen', 0)->count();
                            
                            $response = Http::post(env('AUTH_URL').'/provider_info/',[
                                'id'=>$value->provider_id,
                                ]);
                        
                            $provider = $response->json();
                    
                               
                            $data[] = array(
                                            
                                                'job_id' => $request->jobId, 
                                                'provider_id' => $provider['provider']['id'], 
                                                'provider_name' => $provider['provider']['name'], 
                                                'unseen'=>$unseen
                                                
                                            );
                        }  //end userChat if
             
                    }  //end foreach
             
                    return response()->json([
                        'status'=>200,
                        'message'=>'Provider fetch Successfully',
                        'data'=>$data
                    ]); 
            
            }
             else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Not Found',
                    ]); 
                }
    }
    
    public function providerJobReport(Request $request) 
    {   
        if(isset($request->fromDate) && isset($request->toDate)){
                
                  $results = DB::select("
                      SELECT 
                        provider_id, 
                        SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS status_active,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS status_pending
                      FROM job_actives
                      WHERE created_at BETWEEN '$request->fromDate' AND '$request->toDate'
                      GROUP BY provider_id;
                    ");
            }
            else{
                
                $results = DB::select("
                      SELECT 
                        provider_id, 
                        SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS status_active,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS status_pending
                      FROM job_actives
                      GROUP BY provider_id;
                    ");
            }
            
            if(count($results)>0){
                
             
                foreach ($results as $key => $value) {
                    
                        $response = Http::post(env('AUTH_URL').'/provider_info/',[
                                'id'=>$value->provider_id,
                                ]);
                    
                        $provider = $response->json();  
                        
                        if($provider['status']==200){
                               
                            $data[] = array(
                                            
                                                'providerId' => $provider['provider']['id'], 
                                                'providerName' => $provider['provider']['name'], 
                                                'statusPending'=>$value->status_pending,
                                                'statusActive'=>$value->status_active,
                                                
                                            );
                        }  //end provider if
             
                    }  //end foreach
             
                    return response()->json([
                        'status'=>200,
                        'from'=>$request->fromDate,
                        'message'=>'Fetch Successfully',
                        'data'=>$data
                    ]); 
            
            }
             else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Not Found',
                    ]); 
                }
    }
    
    
    public function userJobProviderList (Request $request) 
    {
        
        if(!isset($request->user_id))
            
            {
            
                 return response()->json([
                    'status'=>203,
                    'message'=>'User Id is missing',
                ]);
            
            }
            
         $job = JobManagement::where('user_id',$request->user_id)->get();
         
         if(count($job)!=0){
                
               foreach ($job as $key => $value) {

                     $actives = JobActive::where('job_id',$value->id)->get();
                   
                    foreach ($actives as $key => $val) {
                        
                        $response = Http::post(env('AUTH_URL').'/provider_info/',[
                                'id'=>$val->provider_id,
                                ]);
                                
                        $provider = $response->json();
                        
                         $data[] = array(
                                    
                                       
                                        'providerId'=>$val->provider_id,
                                        'providerName' => $provider['provider']['name'], 
                                        
                                    );
                    }
               }
               
               $collection = collect($data);
                $uniqueData = $collection->unique('providerId');

             
             
              return response()->json([
                'status'=>200,
                'message'=>'Job fetch Successfully',
                'data'=>$uniqueData
            ]); 
            
         }
         else{
             
              return response()->json([
                'status'=>404,
                'message'=>'This user dont have any job',
            ]); 
            
         }
    } 
    
    public function providerJobUserList (Request $request) 
    {
        
        if(!isset($request->provider_id))
            {
                return response()->json([
                    'status'=>203,
                    'message'=>'User Id is missing',
                ]);
            }
            
         $actives = JobActive::where('provider_id',$request->provider_id)->get();
         
         if(count($actives)!=0){
                
               foreach ($actives as $key => $value) {

                        $job = JobManagement::where('id',$value->job_id)->first();
                        
                        $response = Http::post(env('AUTH_URL').'/user_info/',[
                                'id'=>$job->user_id,
                                ]);
                                
                        $user = $response->json();
                        
                         $data[] = array(
                                        'userId'=>$job->user_id,
                                        'userName' => $user['user']['name'], 
                                    );
                    }
               
                $collection = collect($data);
                
                $uniqueData = $collection->unique('userId');
                
            return response()->json([
                'status'=>200,
                'message'=>'Job fetch Successfully',
                'data'=>$uniqueData
            ]); 

         }
         else{
             
              return response()->json([
                'status'=>404,
                'message'=>'This user dont have any job',
            ]); 
            
         }
    } 
    
    
    public function sendNotificationUser(Request $request) 
    {
            
        $job_active = JobActive::where('status','active')->get();
        
        if(count($job_active)>0){
         
            foreach ($job_active as $key => $value) {
                    
                      $job = JobManagement::where('id',$value->job_id)->first();
                    
                $response = Http::post('https://authentication.notension.pk/api/sendNotification/',[
                    'id'=>$job->user_id,
                    'title'=>'Change job status',
                    'message'=>'Is your job done or not',
                    'sent_to'=>'user',
                    'route'=>'Job Done',
                    'job_id'=>$value->job_id,
                    ]);
                    
                    $data=$response->json();
            }
         
            return response()->json([
                'status'=>200,
                'message'=>'Notification sent Successfully',
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