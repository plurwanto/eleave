<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\User;
use App\Http\Model\Job;
use App\ElaHelper;

class JobController extends Controller
{
    public function index()
    {
        // if(!Session::has('token'))
        // {
        //     return redirect('/login');
        // }

        return view('job.vacancy');
    }
}
