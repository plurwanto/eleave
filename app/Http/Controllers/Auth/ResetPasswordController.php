<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Session;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    public function resetPassword($token)
    {
        if(empty($token)) redirect('login');
        
        return view('login.resetPassword',['token'=>$token]);
    }

    public function changePassword()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('login.changePassword');
    }
}
