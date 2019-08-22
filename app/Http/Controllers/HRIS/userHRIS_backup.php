<?php

namespace App\Http\Controllers\HRIS;

use App\Http\Controllers\Controller;

class userHRIS extends Controller
{
    public function index()
    {
        $data['title'] = 'User HRIS';
        $data['subtitle'] = 'List User HRIS';

        return view('HRIS\master\userHRIS.index', $data);
    }
}
