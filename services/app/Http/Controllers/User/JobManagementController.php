<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sub_category;
use App\Models\JobManagement;
use Illuminate\Http\Request;

class JobManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = 'user.job-management.index';
        $page_title = 'Job List';
        $jobs = JobManagement::where('user_id','1')->get();
       return view('master')->with(['content'=>$content,'title'=>$page_title,'jobs'=>$jobs]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content = 'user.job-management.create';
        $page_title = 'Job Post';
        $categoris = Category::all();
       return view('master')->with(['content'=>$content,'title'=>$page_title,'categoris'=>$categoris]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Karachi");
        $doctor=JobManagement::create([

                'user_id' => '1',
                'title' => $request->title,
                'category' => $request->category,
                'sub_category' => $request->sub_category,
                'phone' => $request->phone,
                'name' => $request->name,
                'city' => $request->city,
                'address' => $request->address,
                'description' => $request->description,
                'date' => date("d-M-Y"),
                'time' =>  date("h:i:s a"),
                'status' => 'pending'
            ]);

            return 123;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobManagement  $jobManagement
     * @return \Illuminate\Http\Response
     */
    public function show(JobManagement $jobManagement)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobManagement  $jobManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(JobManagement $jobManagement)
    {
        $data = JobManagement::find($jobManagement->id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobManagement  $jobManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobManagement $jobManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobManagement  $jobManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobManagement $jobManagement)
    {
        //
    }

    public function list()
    {
        $content = 'admin.index';
        $page_title = 'Job List';
        $jobs = JobManagement::where('user_id','1')->get();
       return view('master')->with(['content'=>$content,'title'=>$page_title,'jobs'=>$jobs]);

    }

    public function change_status()
    {
        $content = 'admin.status';
        $page_title = 'Job status';
        $jobs = JobManagement::where('user_id','1')->get();
       return view('master')->with(['content'=>$content,'title'=>$page_title,'jobs'=>$jobs]);

    }

    function fetch_category(Request $request){

        
        dd($request->id);
    }

}
