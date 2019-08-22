<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;
use App\ElaHelper;

class ForecastController extends Controller
{
    public function index(Request $request)
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('forecast.index');
    }
}