<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\JobManagement;
use App\Models\JobStatus;
use App\Models\JobActive;
use App\Models\ServiceGiver;

    if(!function_exists('user_email')){

        function user_email(){
            $user = Auth::user();
            return $user->email;
        }
        
    }

    if(!function_exists('job_algo')){

        function job_algo($job_id){
            
                // assigned job to providers who's meet the requirement with our algoithem(search_provider_algo method)
                $providers = search_provider_algo($job_id);

                $total_require_providers =  $providers['maximum_persons'];

                // reset array list and it will start from 0,1,2,...
                $spliced = $providers['providers']->splice(0);

                $loop_limit = (count($spliced)<=$total_require_providers)?count($spliced):$total_require_providers;
                
                          $job = new JobActive();
                        
                        $job->provider_id = 1;
                        $job->job_id = $job_id;
                        $job->save();
                        
                        Http::post('https://authentication.notension.pk/api/sendNotification/',[
                            'id'=>1,
                            'title'=>'Matched job',
                            'message'=>'You have a macthed job',
                            'sent_to'=>'provider'
                        ]);
                        
                for ($i=0; $i < $loop_limit; $i++) {
                    
                    $job->provider_id = $spliced[$i]['id'];
                    $job->job_id = $job_id;
                    $save = $job->save();
                    
                    Http::post('https://authentication.notension.pk/api/sendNotification/',[
                        'id'=>$spliced[$i]['id'],
                        'title'=>'Matched job',
                        'message'=>'You have a macthed job',
                        'send_to'=>'provider',
                        'action_id'=>$job_id,
                        'action_type'=>'job',
                         'route'=>'job'
                    ]);
                
                }
                    
        }
    }

    if(!function_exists('search_provider_algo')){

        function search_provider_algo($id)
            {
                $job = JobManagement::find($id);
                
                $job_detail = JobStatus::where('job_id',$id)->first();
                
                $response = Http::post('https://authentication.notension.pk/api/provider_location/',[
                    'location'=>$job->city,
                ]);

                $prod_info = $response->json();
                
                $collection = collect($prod_info['provider']);
               
                // $collection = ServiceGiver::where('location',$job->city)->get();
                
                // percentage  furmula
                // count($collection)/100 * 50

                $assigned_job_percentage = (count($collection)/100) * 50;

                //maximum assigned job to providers
                $maximum_assigned_jobs = collect($collection->SortByDesc("total_job_assigned")->take($assigned_job_percentage)->toArray());

                //last assigned job to providers
                $last_job_percentage = (count($maximum_assigned_jobs)/100) * 50;

                $last_assigned_jobs = collect($maximum_assigned_jobs->SortByDesc("last_date_job")->take($last_job_percentage)->toArray());

                //maximum rating of providers
                $rating_percentage = (count($last_assigned_jobs)/100) * 50;

                $maximum_rating = collect($last_assigned_jobs->SortByDesc("rating")->take($rating_percentage)->toArray());

                // return $maximum_rating;
                return array(
                    'providers' => $maximum_rating,
                    'maximum_persons' => $job_detail->maximum
                    );
            }
    }

?>