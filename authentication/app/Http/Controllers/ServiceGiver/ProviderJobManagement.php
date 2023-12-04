<?php

namespace App\Http\Controllers\ServiceGiver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobManagement;
use App\Models\JobStaus;
use App\Models\ServiceGiver;
use Illuminate\Support\Facades\Auth;

class ProviderJobManagement extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Service Provider | Job List',
            'content' => "admiserviceProvidern/job-management/index",
        );

        return view('serviceProvider/master',$data);
    }

    public function list()
    {
        $jobs = JobManagement::all();
        
        $collection  =  ServiceGiver::all();

        // percentage  furmula
        // count($collection)/100 * 50

        //maximum assigned job to providers
        $assigned_job_percentage = (count($collection)/100) * 50;

        $maximum_assigned_jobs = collect($collection->SortByDesc("total_job_assigned")->take($assigned_job_percentage)->toArray());

        //last assigned job to providers
        $last_job_percentage = (count($maximum_assigned_jobs)/100) * 50;

        $last_assigned_jobs = collect($maximum_assigned_jobs->SortByDesc("last_date_job")->take($last_job_percentage)->toArray());

        //maximum rating of providers
        $rating_percentage = (count($last_assigned_jobs)/100) * 50;

        $maximum_rating = collect($last_assigned_jobs->SortByDesc("rating")->take($rating_percentage)->toArray());

        dd($maximum_rating);

        // JobManagement::where('assigned_to',$user_id->id)->where('status', 'active')->get();

        //  dd($sorted);

        $user_id = Auth::user();

        $jobs = [];

        $page_title = 'Service Provider | Job List';

        $content = 'serviceProvider/job-management/index';

        $assigned_to = JobManagement::where('assigned_to',$user_id->id)->where('status', 'active')->get();

        if(count($assigned_to)>0){
            
                    $jobs = $assigned_to;
            }

        else{
              $jobs =  JobManagement::where('city',$user_id->location)->where('status', 'active')->get();
        }

       return view('serviceProvider/master')->with(['content'=>$content,'title'=>$page_title,'jobs'=>$jobs]);
    }

    public function change_status()
    {
        $content = 'Service Provider/job-management/status';
        $page_title = 'Job status';
        $jobs = JobManagement::where('user_id','1')->get();
       return view('serviceProvider/master')->with(['content'=>$content,'title'=>$page_title,'jobs'=>$jobs]);

    }

   
}
