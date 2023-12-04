<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = array(
            'title' => 'Admin | Dashboard',
            'content' => "admin/dashboard/index",
        );

        return view('admin/master',$data);
    }
}
