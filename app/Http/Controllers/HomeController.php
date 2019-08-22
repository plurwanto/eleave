<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return redirect('/index');
    }

    public function createSession(Request $request)
    {
        if(!empty($request->data))
        {
            session($request->data);

            $data = array(
                            'message'       => 'Session created',
                            'response_code' => 200
            );
        }
        else
        {
            $data = array(
                            'error'         => 1,
                            'message'       => 'Session not created',
                            'response_code' => 500
            );
        }

        return response()->json($data, 200);
    }

    public function portal()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }
        
        return view('portal.index');
    }
}
