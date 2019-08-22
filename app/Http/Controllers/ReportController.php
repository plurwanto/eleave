<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\User;
use App\Http\Model\Approver;
use App\Http\Model\Project;
use App\Http\Model\DeliveryUnit;
use App\ElaHelper;

class ReportController extends Controller
{
    public function general()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('report.general');
    }

    public function docTotal()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('report.doc-total');
    }
}
