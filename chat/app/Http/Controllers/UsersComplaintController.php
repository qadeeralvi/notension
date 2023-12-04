<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use App\Models\UsersComplaint;
use App\Models\ComplaintChat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use File;




class UsersComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        
            $user = Auth::user();

            if(!isset($user)&&empty($user)){
                return redirect('/login');
            }

           
        $data = [
            'menu'       => 'menu.v_menu_admin',
            'content'    => 'content.view_user_complaint',
            'title'    => 'Complaint Management',
            'user'=>$user
        ];

        if($user->user_type=="admin"){

            $user_query = UsersComplaint::select('*')->orderByDesc('created_at');

        }

        else{

            $user_query = UsersComplaint::select('*')->orderByDesc('created_at')->where('complainer_id',$user->id)->get();

        }

        if ($request->ajax()) {

            $q_user = $user_query;
            
            if($user->user_type=="admin"){

                return Datatables::of($q_user)
                    ->addIndexColumn()
                    ->addColumn('image', function($row){

                        $url=asset('uploads/').'/'.$row->file;
                        $btn='<img src="'.$url.'" class="form form-control" style="height:100px;width:170px" />';
                         return $btn;

                    })

                    ->addColumn('action', function($row){

                        $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'"   data-original-title="Status" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2  changeStatus-modal"><i class=" fi-rr-stats"></i></div>';
                        $btn = $btn. '<div data-toggle="tooltip"  data-id="'.$row->id.'"   data-original-title="Chat" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2  showChat"><i class=" fi-rr-user"></i></div>';
              
                        $btn = $btn. ' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteCourse"><i class="fi-rr-trash"></i></div>';
 
                         return $btn;

                    })
                    
                    ->rawColumns(['action','image'])
                    ->make(true);

            }else{

                return Datatables::of($q_user)
                ->addIndexColumn()
                ->addColumn('image', function($row){

                    $url=asset('uploads/').'/'.$row->file;
                    $btn='<img src="'.$url.'" class="form form-control" style="height:100px;width:170px" />';
                     return $btn;

                })

                ->addColumn('action', function($row){

                    $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'"   data-val="'.$row.'" data-original-title="Chat" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2  showChat"><i class=" fi-rr-book"></i></div>';
                    $btn = $btn. '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 edit editCourse"><i class=" fi-rr-edit"></i></div>';
                    $btn = $btn.' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteCourse"><i class="fi-rr-trash"></i></div>';

                     return $btn;
                })
                ->rawColumns(['action','image'])
                ->make(true);

            }
            exit;
          
           
        }

        return view('layouts.v_template',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();

        if(isset($request->complaint_status)){

            UsersComplaint::where('id', $request->complaint_id)->update(
            [
                'status'=>$request->complaint_status,
            ]);
            return response()->json(['success'=>'save successfully!']);
        }
        
        if(isset($request->msg) ){

           
                ComplaintChat::Create(
                [
                'user_id'=>   $request->user_id,
                'complaint_id' => $request->complaint_id,
                'message' => $request->msg,
                'date' =>  date("d-M-Y"),
                'time' =>  date("h:i:s A"),
                'send_by' => ($user->user_type=="admin")?"admin":"user",
                ]);

                return response()->json(['success'=>'save successfully!']);

        }

        else{
                
                if($request->hasFile('img')) {

                        $file = $request->file('img');

                        $name = $file->getClientOriginalName().'.'.$file->getClientOriginalExtension();

                        $image['filePath'] = $name;

                        $file_name = time().mt_rand(1,99999).'.'.$file->getClientOriginalExtension();;

                        $file->move(public_path().'/uploads/', $file_name);

                    }

                UsersComplaint::updateOrCreate(['id' => $request->user_complain_id],
                [
                'user_id'=>   Auth::user()->id,
                'complaint_type' => $request->complaint_type,
                'complaint_detail' => $request->complaint_detail,
                'file'=>(!empty($file_name))?$file_name:"",
                
                ]);        

                return response()->json(['success'=>'Complain saved successfully!']);
            }
    }


    public function show($id)
    {
        $UsersComplaint = UsersComplaint::with('complaintChat')->where('id',$id)->first();
        return response()->json($UsersComplaint);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $UsersComplaint = UsersComplaint::find($id);
        return response()->json($UsersComplaint);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaint = UsersComplaint::find($id);
        File::delete(public_path('uploads/').$complaint->file);
             UsersComplaint::find($id)->delete();
        return response()->json(['success'=>'Article deleted!']);
    }
}
