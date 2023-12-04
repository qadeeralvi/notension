<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobManagement;
use App\Models\JobStatus;
use App\Models\ServiceGiver;

class AdminJobManagemnet extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Admin | Job List',
            'content' => "admin/job-management/index",
        );

        return view('admin/master',$data);
    }

    public function list()
    {
        $page_title = 'Admin | Job List';
        $content = 'admin/job-management/index';
        $jobs = JobManagement::orderBy('id', 'DESC')->get();
       return view('admin/master')->with(['content'=>$content,'title'=>$page_title,'jobs'=>$jobs]);

    }

    public function change_status($id)
    {
        $jobs = JobManagement::where('id',$id)->first();
        $job_status = JobStatus::where('job_id',$jobs->id)->first();
        if($job_status!=null){
            $content = 'admin/job-management/status';
        }else{
            $content = 'admin/job-management/new_status';
        }
      
        $page_title = 'Job status';
       
       return view('admin/master')->with(['content'=>$content,'title'=>$page_title,'jobs'=>$jobs,'job_status'=>$job_status]);

    }

    public function provider_data(Request $request)
    {
       $provider = ServiceGiver::where('id',$request->id)->first();
       return response()->json($provider);
    }

    public function update_status(Request $request)
    {
        $job = JobManagement::find($request->job_id);
        $job->status = $request->status;
        $job->save();
       
        $data = JobStatus::updateOrCreate([
            'job_id'=>$request->job_id,
        ],[
            'job_id'=>$request->job_id,
            'end_date'=>$request->end_date,
            'end_time'=>$request->end_time,
            'minimum'=>$request->minimum,
            'maximum'=>$request->maximum,
            'location'=>($request->location=='on')?'1':null,
            'less_assign'=>($request->less_assign=='on')?'1':null,
            'last_assign'=>($request->last_assign=='on')?'1':null,
            'maximum_rating'=>($request->maximum_rating=='on')?'1':null,
            // 'provider_id'=>$request->provider_id,
        ]);
        if($request->status=="active"){

            job_algo($request->job_id);

        }
        return redirect()->back()->with('success','Successfully Added');
    }



}
