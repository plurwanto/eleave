<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;
use App\ElaHelper;
use Excel;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('project.index');
    }

    public function sample()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        $file = public_path('file/project_import_sample.xlsx');

        return response()->download($file, "project_import_sample.xlsx");
    }

    public function import(Request $request)
    {
        if($request->has('token'))
        {
            $user = User::where('token',$request->token)->first();

            if(!empty($user))
            {
                if($request->hasFile('file'))
                {
                    try {
                        $path       = $request->file('file')->getRealPath();
                        $filename   = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

                        $excelData = Excel::selectSheets('Sheet 1')->load($path)->get();

                        if($excelData->count())
                        {
                            $arr        = [];

                            foreach ($excelData as $value)
                            {
                                $period = date('Y-m-d',strtotime($request->years.'-'.$request->month.'-01'));
                                $arr[] = [
                                            'dp_code'       => $value["project_code"],
                                            'dp_name'      => $value["project_name"],
                                            'da_name'      => $value["account"]
                                        ];
                            }

                            if(!empty($arr))
                            {
                                $dataDoc    = array('data'=>$arr, 'token'=>$request->token);
                                $model      = ElaHelper::myCurl('project-validate', $dataDoc);
                                $result     = json_decode($model,true);
                                
                                if(!isset($result["error"]))
                                {
                                    $data = array(
                                                    'message'       => 'Success',
                                                    'response_code' => 200,
                                                    'data'          => $result["data"]
                                                );
                                    return response()->json($data, 200);
                                }
                                else
                                {
                                    $data = array(
                                                    'error'       => 1,
                                                    'message'       => 'Failed',
                                                    'response_code' => 500
                                                );
                                    return response()->json($data, 200);
                                }
                            }
                            else
                            {
                                $data = array(
                                                'message'       => 'The uploaded data is empty',
                                                'response_code' => 200
                                            );
                                return response()->json($data, 200);
                            }
                        }
                        else
                        {
                            $data = array(
                                            'error'         => 1,
                                            'message'       => 'Empty File',
                                            'response_code' => 500
                                        );
                            return response()->json($data, 200);
                        }
                    } catch (Exception $e) {
                        $data = array(
                                'error'         => 1,
                                'message'       => 'Error!! '.$e,
                                'response_code' => 500
                            );
                        return response()->json($data, 500);
                    }
                }
                else
                {
                    $data = array(
                            'error'         => 1,
                            'message'       => 'There are no request data',
                            'response_code' => 500
                        );
                    return response()->json($data, 200);
                }
            }
            else
            {
                $data = array(
                                    'error'         => 1,
                                    'message'       => 'Your session expired, You\'ll be redirecting to the login page',
                                    'response_code' => 401,
                                    'data'          => array()
                            );

                return response()->json($data, 200);
            }
        }
        else
        {
            $data = array(
                            'error'         => 1,
                            'message'       => 'Please provide your token key',
                            'response_code' => 405
                        );

            return response()->json($data, 200);
        }
    }
}
