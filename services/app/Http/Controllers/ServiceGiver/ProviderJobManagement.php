<?php

namespace App\Http\Controllers\ServiceGiver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobManagement;
use App\Models\JobStaus;
use App\Models\JobActive;
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

    // public function list($id)
    // {
    //     $job = JobManagement::find($id);
    //     // $collection  =  ServiceGiver::all();
    //     $collection  =  ServiceGiver::where('location',$job->city)->get();
    //     // percentage  furmula
    //     // count($collection)/100 * 50

    //     //maximum assigned job to providers
    //     $assigned_job_percentage = (count($collection)/100) * 50;

    //     $maximum_assigned_jobs = collect($collection->SortByDesc("total_job_assigned")->take($assigned_job_percentage)->toArray());

    //     //last assigned job to providers
    //     $last_job_percentage = (count($maximum_assigned_jobs)/100) * 50;

    //     $last_assigned_jobs = collect($maximum_assigned_jobs->SortByDesc("last_date_job")->take($last_job_percentage)->toArray());

    //     //maximum rating of providers
    //     $rating_percentage = (count($last_assigned_jobs)/100) * 50;

    //     $maximum_rating = collect($last_assigned_jobs->SortByDesc("rating")->take($rating_percentage)->toArray());

    //     return $maximum_rating;

    // }

    // public function active_job_save()
    // {
    //     $active_jobs = JobManagement::where('status','active')->get();
    //     $user_list = '';
    //     foreach ($active_jobs as $key => $value) {
            
    //         $providers = $this->list($value->id);

    //         foreach ($providers as $key => $val) {

    //             $job = new JobActive();
    //             $job->provider_id = $val['id'];
    //             $job->job_id = $value->id;
    //             $save = $job->save();
    //         }
    //     }
    // }

    public function job_list()
    {
        $provider_id = Auth::user()->id;
        $jobs = JobActive::where('provider_id',$provider_id)->get();
        $page_title = 'Service Provider | Job List';
        $content = 'serviceProvider/job-management/index';
        
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
