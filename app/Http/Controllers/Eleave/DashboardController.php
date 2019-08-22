<?php
namespace App\Http\Controllers\Eleave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Model\Eleave\User;
use App\Http\Model\Eleave\UserLevel;
use Session;
use DB;
use App\ElaHelper;

class DashboardController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.dashboard.new-dashboard');
    }

}
