<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Module;
use App\Models\Permission;


class RolesPermissionApiController extends Controller
{
    public function roles(Request $request)
    {
        $data = Role::all();
          if(count($data)>0){
            return response()->json([
                'status'=>200,
                'data' => $data,
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

    public function roleSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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

            Role::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'status'=>200,
                'message'=>'Created Successfully',
            ]);
        }
    }


    public function changeRoleStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
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

        else{

            $role = Role::findOrFail($request->id);

            if(!empty($role)){

                $role->status=  $request->status;
                $role->save();

                return response()->json([
                    'status'=>200,
                    'message'=>'Updated Successfully',
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

    public function fetchRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roleId' => 'required',
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

            $role = Role::findOrFail($request->roleId);

            if(!empty($role)){

               
                return response()->json([
                    'status'=>200,
                    'data'=>$role,
                    'message'=>'Updated Successfully',
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
    
    public function updateRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roleId' => 'required',
            'name' => 'required',
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

            $role = Role::findOrFail($request->roleId);

            if(!empty($role)){
                
                $role->name=  $request->name;
                $role->save();
               
                return response()->json([
                    'status'=>200,
                    'message'=>'Updated Successfully',
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

    public function admins(Request $request)
    {
        
        $data = Admin::with('role')->get();
          if(count($data)>0){
            return response()->json([
                'status'=>200,
                'data' => $data,
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
    
    public function admin_info(Request $request)
    {
        
        $data = Admin::where('id',$request->adminId)->with('role')->first();
          if($data!=''){
                return response()->json([
                    'status'=>200,
                    'data' => $data,
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
    
    public function admin_update(Request $request)
    {
        
        
        
        $user = Admin::where('id',$request->adminId)->first();
        
        $user->name = (isset($request->name))?$request->name:$user->name;

        $user->email = (isset($request->email))?$request->email:$user->email;
        
        $user->phone = (isset($request->phone ))?$request->phone :$user->phone;
        
        $user->location = (isset($request->location))?$request->location:$user->location;
        
        $user->role = (isset($request->role))?$request->role:$user->role;
        
        $user->save();
        
         return response()->json([
            'status'=>200,
            'message'=>'Updated Successfully',
        ]);
      
    }

    public function saveAdmin(Request $request)
    { 
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|unique:admins,phone',
            'password' => 'required',
            'location' => 'required',
            'role' => 'required',
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
                Admin::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'location' => $request->location,
                    'role' => $request->role,
                    'password' => Hash::make($request->password),
                ]);

                return response()->json([
                    'status'=>200,
                    'message'=>'Register Successfully',
                ]);
            }
    }

    public function changeAdminStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
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

        else{

            $data = Admin::findOrFail($request->id);

            if(!empty($data)){

                $data->status=  $request->status;
                $data->save();

                return response()->json([
                    'status'=>200,
                    'message'=>'Updated Successfully',
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


    public function modules(Request $request)
    {
        $data = Module::all();
          if(count($data)>0){
            return response()->json([
                'status'=>200,
                'data' => $data,
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

    public function savePermission(Request $request)
    {
        
        Permission::where('roleId',$request->roleId)->delete();
        foreach ($request->ids as $key => $value) {


            $action = substr($value, 0, strpos($value, '['));

            $module_id = substr(str_replace(['[', ']'], '', $value), strpos($value, '['));

            $module = Module::where('id',$module_id)->first();
            Permission::create([
                'roleId'=>$request->roleId,
                'moduleId'=>$module_id,
                'parentId'=>$module->parentId,
                'action'=>$action,
                'permissionAssignBy'=>'2'
            ]);

        }

        return response()->json([
            'status'=>200,
            'data' => $request->all(),
            'message'=>'Saved Successfully',
        ]);
          
    }

    public function fetchPermisison(Request $request)
    {
       
        $data = Permission::where('roleId',$request->roleId)->get();

        $uniqueParentIds = Permission::where('roleId',$request->roleId)->distinct('parentId')->pluck('parentId');

        $uniqueModuleIds = Permission::where('roleId',$request->roleId)->whereNotNull('moduleId')->distinct('moduleId')->pluck('moduleId');


        if(count($data)>0){
            return response()->json([
                'status'=>200,
                'parentId'=>$uniqueParentIds,
                'moduleId'=>$uniqueModuleIds,
                'data' => $data,
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
