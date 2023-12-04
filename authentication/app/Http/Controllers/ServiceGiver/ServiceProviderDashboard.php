<?php

namespace App\Http\Controllers\ServiceGiver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceProviderDashboard extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Service Provider | Dashboard',
            'content' => "serviceProvider/dashboard/index",
        );

        return view('serviceProvider/master',$data);
    }
}
