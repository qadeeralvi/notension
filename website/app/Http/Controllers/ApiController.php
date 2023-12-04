<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Setting;


class ApiController extends Controller
{

    // Banner Api's
    
    public function banner(Request $request)
    {
        $banner = Banner::where('status','1')->get();

         if(count($banner)>0){


            foreach($banner as $key => $val){

                $data[] = array(

                    'id'=>$val->id,
                    'title'=>$val->title,
                    'description'=>$val->description,
                    'image'=>(!empty($val->image))?env('APP_URL').'/banner/'.$val->image:NULL,
                    'status'=>$val->status,
                    'created_at'=>$val->created_at,

                );
            }
            return response()->json([
                'status'=>200,
                'data' => $data,
                'message'=>'Fetch Successfully',
            ]);
          }
          
          else{
              
               return response()->json([
                'status'=>404,
                'message'=>'UnSuccessfully',
            ]);
            
          }

    }

    public function delete_banner(Request $request)
    {
        $banner = Banner::where('id',$request->id)->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Deleted Successfully',
            ]);

    }


    public function addBanner(Request $request)
    {


        if(!isset($request->title) || !isset($request->description) ){
                
            return response()->json([
                'status'=>404,
                'message'=>'Some paramter is missing',
            ]);
            
        }else{

            
            if (strpos($request->image, 'data:image/') === 0) {

                $imageData = $request->image; // The base64 string of the image
    
                // Convert the base64 string to binary data
                $imageBinaryData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
                            
                // Get the image information, including its file format
                $imageInfo = getimagesizefromstring($imageBinaryData);

                $fileExtension = image_type_to_extension($imageInfo[2]);

                // Generate a unique filename
                $file_name = time().mt_rand(1,99999).'.'.$fileExtension;

                // Save the image to the server
                file_put_contents(public_path().'/banner/'.$file_name, $imageBinaryData);

            } 

            if($request->hasFile('image')) {

                    $file = $request->file('image');

                    $img_ext = $file->getClientOriginalExtension();
                    
                    if($img_ext=='jpeg' || $img_ext=='png' || $img_ext=='jpg' || $img_ext=='webp'){
                    
                    
                        $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();

                        $image['filePath'] = $name;

                        $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;

                        $file->move(public_path().'/banner/', $file_name);
                    }
                    
                    else{
                        return response()->json([
                            'status'=>404,
                            'message'=>'Image is not correct',
                        ]); 
                    }
                

            }
                Banner::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'image'=>$file_name
                ]);
                
                return response()->json([
                    'status'=>200,
                    'message'=>'Add Successfully',
                ]);
        }

    }


    public function webSetting(Request $request)
    {
        $val = Setting::where('status','1')->first();

         if($val){

                $data = array(

                    'number'=>$val->number,
                    'default_payment'=>$val->default_payment,
                    'email'=>$val->email,
                    'facebook'=>$val->facebook,
                    'instagram'=>$val->instagram,
                    'linkdin'=>$val->linkdin,
                    'youtube'=>$val->youtube,
                    'twitter'=>$val->twitter,
                    'logo'=>(!empty($val->logo))?env('APP_URL').'/images/'.$val->logo:NULL,
                    'favicon'=>(!empty($val->favicon))?env('APP_URL').'/images/'.$val->favicon:NULL,
                    'status'=>$val->status,
                    'created_at'=>$val->created_at,

                );
            return response()->json([
                'status'=>200,
                'data' => $data,
                'message'=>'Fetch Successfully',
            ]);
          }
          
          else{
              
               return response()->json([
                'status'=>404,
                'message'=>'UnSuccessfully',
            ]);
            
          }

    }

    public function addWebSetting(Request $request)
    {
        
          
        if(!isset($request->number) || !isset($request->email)){
                
            return response()->json([
                'status'=>404,
                'message'=>'Some paramter is missing',
            ]);
            
        }else{
            
            if (strpos($request->logo, 'data:image/') === 0) {

                $imageData = $request->logo; // The base64 string of the image
    
                // Convert the base64 string to binary data
                $imageBinaryData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
                            
                // Get the image information, including its file format
                $imageInfo = getimagesizefromstring($imageBinaryData);

                $fileExtension = image_type_to_extension($imageInfo[2]);

                // Generate a unique filename
                $logo_name = time().mt_rand(1,99999).'.'.$fileExtension;

                // Save the image to the server
                file_put_contents(public_path().'/images/'.$logo_name, $imageBinaryData);

            } 
            
            if($request->hasFile('logo')) {

                    $file = $request->file('logo');

                    $img_ext = $file->getClientOriginalExtension();
                    
                    if($img_ext=='jpeg' || $img_ext=='png' || $img_ext=='jpg' || $img_ext=='webp'){
                    
                    
                        $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();

                        $image['filePath'] = $name;

                        $logo_name = 'logo.'.$file->getClientOriginalExtension();;

                        $file->move(public_path().'/images/', $logo_name);
                    }
                    
                    else{
                        return response()->json([
                            'status'=>404,
                            'message'=>'Image is not correct you must upload jpeg,png,jpg,webp format',
                        ]); 
                    }
            }

            if($request->hasFile('favicon')) {

                $file = $request->file('favicon');

                $img_ext = $file->getClientOriginalExtension();
                
                $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();

                $image['filePath'] = $name;

                $favicon_name = 'favicon.'.$file->getClientOriginalExtension();;

                $file->move(public_path().'/images/', $favicon_name);
            }

                Setting::updateOrCreate(['id' => 1],
                [
                    'number'=>$request->number,
                    'email'=>$request->email,
                    'facebook'=>$request->facebook,
                    'instagram'=>$request->instagram,
                    'linkdin'=>$request->linkdin,
                    'youtube'=>$request->youtube,
                    'twitter'=>$request->twitter,
                    'logo'=>!empty($logo_name)?$logo_name:Null,
                    'favicon'=>!empty($favicon_name)?$favicon_name:Null,
                ]);
                
                return response()->json([
                    'status'=>200,
                    'message'=>'Add Successfully',
                ]);
        }

    }





}



?>
