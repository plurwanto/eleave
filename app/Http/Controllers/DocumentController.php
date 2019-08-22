<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\User;
use App\Http\Model\Approver;
use App\Http\Model\Project;
use App\Http\Model\DeliveryUnit;
use Excel;
use App\ElaHelper;
use PDF;

class DocumentController extends Controller
{
    public function sendSubmitEmail()
    {
        $param = [
                    'from'      => env('MAIL_FROM_ADDRESS'),
                    'from_name' => env('MAIL_FROM_NAME'),
                    'to'        => 'cant_tall@yahoo.co.id',
                    'subject'   => 'Send Email Successfully with sendgrid',
                    'message'   => 'Dhima ganteng melakukan test kirim email ke dhima yahoo dengan sendgrid'
                ];

        $sendEmail = ElaHelper::SendMail($param);

        if($sendEmail)
        {
            $message = 'Email Sent!';
        }
        else
        {
            $message = 'Email not sent';
        }

        return $message;
    }

    public function index(Request $request)
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('document.index');
    }

    public function exportExcel(Request $request)
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        $param  = array('token'=>session('token'), 'role'=>session('user_role'), 'userId'=>session('user_id'), 'type'=>'download');
        $model  = ElaHelper::myCurl('document', $param);
        $result = json_decode($model,true);

        $dataDoc    = $result["data"];

        $mem_name = (session('user_role') == 'member') ? 'Acceptance '.session('name') : 'All Acceptance';
        $filename = str_replace(' ','-',$mem_name.' '.date('dmY'));

        $return = Excel::create($filename,function($excel) use ($dataDoc){
            $excel->sheet('Sheet 1',function($sheet) use ($dataDoc)
            {
                // $sheet->fromArray($dataDoc);
                if(session('user_role') != 'member')
                {
                    $sheet->cell('A1', function($cell) {$cell->setValue('Employee');$cell->setFontWeight(true);   });
                    $sheet->cell('B1', function($cell) {$cell->setValue('Project');$cell->setFontWeight(true);   });
                    $sheet->cell('C1', function($cell) {$cell->setValue('Delivery Unit');$cell->setFontWeight(true);   });
                    $sheet->cell('D1', function($cell) {$cell->setValue('Document Type');$cell->setFontWeight(true);   });
                    $sheet->cell('E1', function($cell) {$cell->setValue('Total Document');$cell->setFontWeight(true);   });
                    $sheet->cell('F1', function($cell) {$cell->setValue('Period');$cell->setFontWeight(true);   });
                    $sheet->cell('G1', function($cell) {$cell->setValue('Status');$cell->setFontWeight(true);   });
                    $sheet->cell('H1', function($cell) {$cell->setValue('Approver');$cell->setFontWeight(true);   });
                    $sheet->cell('I1', function($cell) {$cell->setValue('Approval Date');$cell->setFontWeight(true);   });
                    $sheet->cell('J1', function($cell) {$cell->setValue('Submit Date');$cell->setFontWeight(true);   });
                }
                else
                {
                    $sheet->cell('A1', function($cell) {$cell->setValue('Project');$cell->setFontWeight(true);   });
                    $sheet->cell('B1', function($cell) {$cell->setValue('Delivery Unit');$cell->setFontWeight(true);   });
                    $sheet->cell('C1', function($cell) {$cell->setValue('Document Type');$cell->setFontWeight(true);   });
                    $sheet->cell('D1', function($cell) {$cell->setValue('Total Document');$cell->setFontWeight(true);   });
                    $sheet->cell('E1', function($cell) {$cell->setValue('Period');$cell->setFontWeight(true);   });
                    $sheet->cell('F1', function($cell) {$cell->setValue('Status');$cell->setFontWeight(true);   });
                    $sheet->cell('G1', function($cell) {$cell->setValue('Approver');$cell->setFontWeight(true);   });
                    $sheet->cell('H1', function($cell) {$cell->setValue('Approval Date');$cell->setFontWeight(true);   });
                    $sheet->cell('I1', function($cell) {$cell->setValue('Submit Date');$cell->setFontWeight(true);   });
                }
                

                if (!empty($dataDoc))
                {
                    foreach ($dataDoc as $key => $value)
                    {
                        $i= $key+2;

                        if(session('user_role') != 'member')
                        {
                            $sheet->cell('A'.$i, $value['mem_name']);
                            $sheet->cell('B'.$i, $value['project_name']); 
                            $sheet->cell('C'.$i, $value['du_name']); 
                            $sheet->cell('D'.$i, $value['dd_name']); 
                            $sheet->cell('E'.$i, $value['doc_total']); 
                            $sheet->cell('F'.$i, $value['period']); 
                            $sheet->cell('G'.$i, $value['status']); 
                            $sheet->cell('H'.$i, $value['account_name']); 
                            $sheet->cell('I'.$i, $value['approval_date']); 
                            $sheet->cell('J'.$i, $value['submit_date']);
                        }
                        else
                        {
                            $sheet->cell('A'.$i, $value['project_name']); 
                            $sheet->cell('B'.$i, $value['du_name']); 
                            $sheet->cell('C'.$i, $value['dd_name']); 
                            $sheet->cell('D'.$i, $value['doc_total']); 
                            $sheet->cell('E'.$i, $value['period']); 
                            $sheet->cell('F'.$i, $value['status']); 
                            $sheet->cell('G'.$i, $value['account_name']); 
                            $sheet->cell('H'.$i, $value['approval_date']); 
                            $sheet->cell('I'.$i, $value['submit_date']);
                        }                        
                    }
                }
            });
        })->download('xlsx');

        return $return;
    }

    public function exportPdf(Request $request)
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        $param  = array('token'=>session('token'), 'month'=>$request->month, 'years'=>$request->years, 'dp_id'=>$request->project_id);
        $model  = ElaHelper::myCurl('document-report', $param);
        $result = json_decode($model);

        $dataDoc['data']    = $result->data;

        $mem_name = 'Acceptance Report '.$request->month.$request->years.' '.session('name');
        $filename = str_replace(' ','-',$mem_name.' '.date('dmY')).'.pdf';

        $return = PDF::loadView('export.pdf_acceptance',$dataDoc)->download($filename);
        // $return = PDF::loadView('export.pdf_acceptance',$dataDoc)->stream();

        return $return;
        // return view('export.pdf_acceptance',$dataDoc);
    }

    public function sample()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        $file = public_path('file/import_document_sample.xlsx');

        return response()->download($file, "import_document_sample.xlsx");
    }

    public function import(Request $request)
    {
        if($request->has('token'))
        {
            $user = DB::table('_user_account')->where('token',$request->token)->first();

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
                            $period = date('Y-m-d',strtotime($request->years.'-'.$request->month.'-01'));

                            $arr        = [];

                            foreach ($excelData as $value)
                            {
                                if(!empty($value["du_id"]) && !empty($value["document_type"]) && !empty($value["total"]))
                                {
                                    $arr[] = [
                                                'du_code'       => trim($value["du_id"]),
                                                'dd_code'       => trim($value["document_type"]),
                                                'total'         => trim($value["total"])
                                            ];
                                }
                            }

                            if(!empty($arr))
                            {
                                $dataDoc    = array(
                                                    'data'          => $arr, 
                                                    'token'         => $request->token,
                                                    'mem_id'        => session('user_id'),
                                                    'period'        => trim($period),
                                                    'project_id'    => trim($request->project_id),
                                                    'approve_by'    => trim($request->approve_by)
                                                );

                                $model      = ElaHelper::myCurl('document-validate', $dataDoc);
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
                                                    'message'       => $result["message"],
                                                    'response_code' => 500
                                                );
                                    return response()->json($data, 200);
                                }
                            }
                            else
                            {
                                $data = array(
                                                'error'       => 1,
                                                'message'       => 'The uploaded data is exist in our system',
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
                                    'message'       => 'Your session expired, Please login to continue',
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

    public function docStatus()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('document.statusChart');
    }

    public function docValue()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('document.valueChart');
    }

    public function perfLow()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('document.performLow');
    }

    public function performance()
    {
        if(!Session::has('token'))
        {
            return redirect('/login');
        }

        return view('document.performHigh');
    }
}
