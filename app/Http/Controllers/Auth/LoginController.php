<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use ElaHelper;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/index';

    public function showLoginForm()
    {
        if(Session::has('token'))
        {
            return redirect('/index');
        }

        return view('login.index');
    }

    public function login(Request $request)
    {
        if(Session::has('token'))
        {
            return redirect('/index');
        }

        $urlLogin   = 'login';
        $login      = ElaHelper::myCurl($urlLogin,$request->all());
        
        $data       = json_decode($login,true);

        if(!isset($data["error"]))
        {
            session($data["data"]);
            // $request->session()->flush();
        }
        
        return response()->json($data, 200);
    }

    public function logout(Request $request) {
        $url    = 'logout';
        $logout = ElaHelper::myCurl($url,['token'=>session('token')]);
        $data   = json_decode($logout);

        $request->session()->flush();

        return redirect('/login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($request->ajax()){

            return response()->json([
                'auth' => auth()->check(),
                'intended' => $this->redirectPath(),
            ]);

        }
    }
}