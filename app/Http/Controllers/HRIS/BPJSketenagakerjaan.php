<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class BPJSketenagakerjaan extends Controller
{
    public $menuID = 11;

    public function index(Request $request)
    {

        if (!session('token')) {
           echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="'.env('APP_URL').'/index";
                </script>';
        }

        $link = ['iuran',
            'employee'];
        $select = '';
        $select .= '<select style="width:120px; margin-right:10px" class="form-control border-rounded pull-left" onchange="javascript:handleSelect(this)">';
        $select2 = '';
        for ($i = 0; $i < count($link); $i++) {
            if ($request->get('link') == $link[$i]) {
                $select2 .= '<option value="' . $link[$i] . '" selected>' . ucwords($link[$i]) . '</option>';
            } else {
                $select2 .= '<option value="' . $link[$i] . '">' . ucwords($link[$i]) . '</option>';
            }

        }
        $select .= $select2;
        $select .= '</select>';

        $data['select'] = $select;
        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        if ($data['access']) {
            if ($data['access']->menu_acc_view != 1) {
                echo '<script type="text/javascript">
                        window.alert("you don\'t have access");
                        window.location.href="' . env('APP_URL') . '/index";
                      </script>';

            }
        } else {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="'.env('APP_URL').'/index";
                  </script>';
        }

        if ($request->has('month') && $request->has('year')) {
            switch ($request->get('month')) {
                case "01":
                    $month = "January";
                    break;
                case "02":
                    $month = "February";
                    break;
                case "03":
                    $month = "March";
                    break;
                case "04":
                    $month = "April";
                    break;
                case "05":
                    $month = "May";
                    break;
                case "06":
                    $month = "June";
                    break;
                case "07":
                    $month = "July";
                    break;
                case "08":
                    $month = "August";
                    break;
                case "09":
                    $month = "September";
                    break;
                case "10":
                    $month = "October";
                    break;
                case "11":
                    $month = "November";
                    break;
                case "12":
                    $month = "December";
                    break;
                default:
                    $month = "";
            }

            $title = 'REPORT ' . $month . ' ' . $request->get('year') . '';

            $data['period'] = $request->get('year') . '-' . $request->get('month');
        } else {

            switch (date('m')) {
                case "01":
                    $month = "January";
                    break;
                case "02":
                    $month = "February";
                    break;
                case "03":
                    $month = "March";
                    break;
                case "04":
                    $month = "April";
                    break;
                case "05":
                    $month = "May";
                    break;
                case "06":
                    $month = "June";
                    break;
                case "07":
                    $month = "July";
                    break;
                case "08":
                    $month = "August";
                    break;
                case "09":
                    $month = "September";
                    break;
                case "10":
                    $month = "October";
                    break;
                case "11":
                    $month = "November";
                    break;
                case "12":
                    $month = "December";
                    break;
                default:
                    $month = "";
            }
            $title = 'REPORT ' . $month . ' ' . date('Y') . '';
            $data['period'] = date('Y-m');
        }

        $param = [
            "id_hris" => session('id_hris'),
        ];

        if ($request->get('cus_id')) {
            $data['cus_id'] = $request->get('cus_id');
        } else {
            $data['cus_id'] = '';
        }

        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        $data['title'] = 'BPJS ketenagakerjaan';

        if ($request->get('link')) {
            switch ($request->get('link')) {
                case 'log-error':
                    $param = [
                        "order" => ["id_temp", "ASC"],
                        "fields" => ["id_temp", "msg"],
                        "where" => ["id_temp", $request->get('id')],
                        "table" => "_temp_log",
                    ];
                    $temp_log = json_decode(ElaHelper::myCurl('master-global', $param));
                    if ($temp_log) {
                        $data['log_error'] = $temp_log->result[0]->msg;
                    } else {
                        $data['log_error'] = '';
                    }

                    $data['subtitle'] = 'Log Error Upload';
                    return view('HRIS.administration.bpjs.ketenagakerjaan.log', $data);
                    break;
                case 'employee':
                    $data['subtitle'] = 'List Number Existing Employee';
                    $data['subtitle2'] = 'List Number Existing ';
                    return view('HRIS.administration.bpjs.ketenagakerjaan.employee', $data);
                    break;

                default;
                    $data['subtitle'] = $title;
                    $data['subtitle2'] = str_replace('<br>', ' ', $title);
                    return view('HRIS.administration.bpjs.ketenagakerjaan.index', $data);

            }
        } else {
            $data['subtitle'] = $title;
            $data['subtitle2'] = str_replace('<br>', ' ', $title);
            return view('HRIS.administration.bpjs.ketenagakerjaan.index', $data);
        }
    }

    public function listData(Request $request)
    {
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        if ($request->post('start') == 0) {
            $page = 1;
        } else {
            $page = ($request->post('start') / $request->post('length')) + 1;
        }
        $sort_by = $request->post('order')[0]['column'];
        $dir = $request->post('order')[0]['dir'];
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "page" => $page,
            "per_page" => $request->post('length'),
            "search" => $search,
            "sort_by" => $sort_by,
            "dir" => $dir,
            "search_name" => $request['columns'][0]['search']['value'],
            "search_nip" => $request['columns'][1]['search']['value'],
            "search_user" => $request['columns'][2]['search']['value'],
            "search_customer" => $request['columns'][3]['search']['value'],
            "search_month" => $request['columns'][4]['search']['value'],
            "search_year" => $request['columns'][5]['search']['value'],
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/bpjs/ketenagakerjaan', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['bpjs_ket_id'] = $rows->data[$i]->bpjs_ket_id;
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                $nestedData['ket_total'] = $rows->data[$i]->ket_total;
                $nestedData['pen_total'] = $rows->data[$i]->pen_total;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['period'] = $rows->data[$i]->period;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $nestedData['created_date'] = $rows->data[$i]->created_date;

                $menu_access = '';

                $nestedData['action'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->bpjs_ket_id . '" onclick="get_modal(this)">
                            <i class="fa fa-search-plus" style="
                    font-size: 18px;
                    width: 18px;
                    height: 18px;
                    margin-right: 3px;"></i>
                </a>';
                $employee[] = $nestedData;
            }

            $data = array(
                'draw' => $draw,
                'recordsTotal' => $rows->paging->total,
                'recordsFiltered' => $rows->paging->total,
                'data' => $employee,
            );

        } else {
            $data = array(
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => $employee,
            );
        }
        echo json_encode($data);
    }

    public function listDataEmployee(Request $request)
    {
        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        if ($request->post('start') == 0) {
            $page = 1;
        } else {
            $page = ($request->post('start') / $request->post('length')) + 1;
        }
        $sort_by = $request->post('order')[0]['column'];
        $dir = $request->post('order')[0]['dir'];
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "page" => $page,
            "per_page" => $request->post('length'),
            "search" => $search,
            "sort_by" => $sort_by,
            "dir" => $dir,
            "search_name" => $request['columns'][0]['search']['value'],
            "search_nip" => $request['columns'][1]['search']['value'],
            "search_id_number" => $request['columns'][2]['search']['value'],
            "search_bpjs_ket" => $request['columns'][3]['search']['value'],
            "search_bpjs_pen" => $request['columns'][4]['search']['value'],
            "search_created_by" => $request['columns'][5]['search']['value'],
            "search_condition" => $request['columns'][6]['search']['value'],
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/bpjs/ketenagakerjaan/employee', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['idNumber'] = $rows->data[$i]->idNumber;
                $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                $nestedData['mem_jamsostek'] = $rows->data[$i]->mem_jamsostek;
                $nestedData['mem_bpjs_pen'] = $rows->data[$i]->mem_bpjs_pen;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['updated_at'] = date('d-M-Y H:i:s', strtotime($rows->data[$i]->updated_at->date));

                $menu_access = '';

                $nestedData['action'] = '<div class="btn-group">
                        <button class="btn dark btn-outline btn-circle btn-xs border-rounded" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                        <li>
                            <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                            <i class="fa fa-search-plus"></i> Detail </a>
                        </li>
                        ' . $menu_access . '
                        </ul>
                    </div>';
                $employee[] = $nestedData;
            }

            $data = array(
                'draw' => $draw,
                'recordsTotal' => $rows->paging->total,
                'recordsFiltered' => $rows->paging->total,
                'data' => $employee,
            );

        } else {
            $data = array(
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => $employee,
            );
        }
        echo json_encode($data);
    }

    public function filterExcel(Request $request)
    {
        if (!session('token')) {
           echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="'.env('APP_URL').'/index";
                </script>';
        }

        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        if ($request->get('cus_id')) {
            $data['cus_id'] = $request->get('cus_id');
        } else {
            $data['cus_id'] = '0';
        }
        $data['searchMonth'] = $request->get('searchMonth') != 0 ? $request->get('searchMonth') : date('m');
        $data['searchYear'] = $request->get('searchYear') != 0 ? $request->get('searchYear') : date('Y');
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        $data['title'] = 'BPJS Ketenagakerjaan';
        $data['subtitle'] = 'List Report';
        return view('HRIS.administration.bpjs.ketenagakerjaan.filterExcel', $data);
    }

    public function upload(Request $request)
    {

        if (!session('token')) {
           echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="'.env('APP_URL').'/index";
                </script>';
        }

        $data['searchMonth'] = $request->get('searchMonth') != 0 ? $request->get('searchMonth') : date('m');
        $data['searchYear'] = $request->get('searchYear') != 0 ? $request->get('searchYear') : date('Y');

        $data['title'] = 'BPJS Ketenagakerjaan';
        $data['subtitle'] = 'List Report';
        return view('HRIS.administration.bpjs.ketenagakerjaan.upload', $data);
    }

    public function uploadEmployee(Request $request)
    {

        if (!session('token')) {
           echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="'.env('APP_URL').'/index";
                </script>';
        }

        $urlMenu = 'hris/get-access-menu';

        $data['searchMonth'] = $request->get('searchMonth') != 0 ? $request->get('searchMonth') : date('m');
        $data['searchYear'] = $request->get('searchYear') != 0 ? $request->get('searchYear') : date('Y');

        $data['title'] = 'BPJS Ketenagakerjaan';
        $data['subtitle'] = 'List Report';
        return view('HRIS.administration.bpjs.ketenagakerjaan.uploadEmployee', $data);
    }

    public function templateIuran(Request $request)
    {

        return Excel::create('Template BPJS ketenagakerjaan', function ($excel) {
            $excel->sheet('Template BPJS ketenagakerjaan', function ($sheet) {
                $sheet->setCellValue('A1', 'No');
                $sheet->setCellValue('B1', 'BPJS');
                $sheet->setCellValue('C1', 'EMPLOYEE NIP');
                $sheet->cell('C1', function ($cell) {$cell->setBackground('#F08080');});
                $sheet->setCellValue('D1', 'Full Name');
                $sheet->setCellValue('E1', 'Birth Date');
                $sheet->setCellValue('F1', 'No Jamsostek');
                $sheet->setCellValue('G1', 'No BPJS Pensiun');
                $sheet->setCellValue('H1', 'Hire Date');
                $sheet->setCellValue('I1', 'Resign Date');
                $sheet->setCellValue('J1', 'Basic Jamsostek');
                $sheet->setCellValue('K1', 'JHT Comp');
                $sheet->setCellValue('L1', 'JKJKK');
                $sheet->setCellValue('M1', 'JHT Employee');
                $sheet->setCellValue('N1', 'Total Jamsostek');
                $sheet->setCellValue('O1', 'Total Pensiun');
                $sheet->setCellValue('P1', 'Basic Pensiun');
                $sheet->setCellValue('Q1', 'Pensiun Company');
                $sheet->setCellValue('R1', 'Pensiun Employee');
            });

        })->download('xlsx');
    }

    public function templateUpdate(Request $request)
    {

        return Excel::create('Update BPJS ketenagakerjaan', function ($excel) {
            $excel->sheet('Update BPJS ketenagakerjaan', function ($sheet) {

                $sheet->setCellValue('A1', 'Member NIP');
                $sheet->cell('A1', function ($cell) {$cell->setBackground('#F08080');});

                $sheet->setCellValue('B1', 'Name');

                $sheet->setCellValue('C1', 'No BPJS ketenagakerjaan');
                $sheet->cell('C1', function ($cell) {$cell->setBackground('#F08080');});

                $sheet->setCellValue('D1', 'No BPJS pensiun');
                $sheet->cell('D1', function ($cell) {$cell->setBackground('#F08080');});

            });

        })->download('xlsx');
    }

    public function doUpload(Request $request)
    {
        $period = $request->post('year') . '-' . $request->post('month');
        if ($request->hasFile('file')) {
            try {
                $path = $request->file('file')->getRealPath();
                $filename = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
                $excelData = Excel::load($path)->get();
                if ($excelData->count()) {
                    $arr = [];

                    $fieldName = array('employee_nip', 'no_jamsostek', 'no_bpjs_pensiun', 'total_jamsostek', 'total_pensiun', 'basic_pensiun', 'pensiun_company', 'pensiun_employee');
                    $headerRow = $excelData->first()->keys()->toArray();
                    $arr3 = array_diff($fieldName, $headerRow);
                    if (count($arr3) == 0) {

                        foreach ($excelData as $key => $value) {
                            $arr[] = [
                                'id_number' => trim(strip_tags($value["employee_nip"])),
                                'no_jamsostek' => trim(strip_tags($value["no_jamsostek"])),
                                'no_bpjs_pensiun' => trim(strip_tags($value["no_bpjs_pensiun"])),
                                'total_jamsostek' => trim(strip_tags($value["total_jamsostek"])),
                                'total_pensiun' => trim(strip_tags($value["total_pensiun"])),
                                'basic_pensiun' => trim(strip_tags($value["basic_pensiun"])),
                                'pensiun_company' => trim(strip_tags($value["pensiun_company"])),
                                'pensiun_employee' => trim(strip_tags($value["pensiun_employee"])),
                            ];
                        }

                        if (!empty($arr)) {
                            $dataDoc = array(
                                'bpjs_ketenagakerjaan' => $arr,
                                'period' => $period,
                                'token' => session('token'),
                                'id_hris' => session('id_hris'),
                            );

                            $model = ElaHelper::myCurl('hris/bpjs/ketenagakerjaan/do-upload', $dataDoc);
                            $result = json_decode($model, true);
                            $id = rand(1, 100);
                            $data = array(
                                'year' => $request->post('year'),
                                'month' => $request->post('month'),
                                'message' => $result['result']['message'],
                                'response_code' => $result['result']['response_code'],
                                'wrong_id' => $result['wrongListId'],
                            );
                            return response()->json($data, 200);

                        } else {
                            $data = array(
                                'message' => 'There are no request data',
                                'response_code' => 500,
                                'wrong_id' => '',
                            );
                            return response()->json($data, 200);
                        }
                    } else {
                        $data = array(
                            'message' => 'header file format is not appropriate',
                            'response_code' => 500,
                            'wrong_id' => '',
                        );
                        return response()->json($data, 200);
                    }
                } else {
                    $data = array(
                        'message' => 'Empty File',
                        'response_code' => 500,
                        'wrong_id' => '',
                    );
                    return response()->json($data, 200);
                }
            } catch (Exception $e) {
                $data = array(
                    'message' => 'Error!! ' . $e,
                    'response_code' => 500,
                    'wrong_id' => '',
                );
                return response()->json($data, 500);
            }
        } else {
            $data = array(
                'message' => 'There are no request data',
                'response_code' => 500,
                'wrong_id' => '',
            );
            return response()->json($data, 200);
        }

    }

    public function doUploadEmployee(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $path = $request->file('file')->getRealPath();
                $filename = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
                $excelData = Excel::load($path)->get();
                if ($excelData->count()) {
                    $arr = [];

                    foreach ($excelData as $key => $value) {
                        $arr[] = [
                            'member_nip' => trim(strip_tags($value["member_nip"])),
                            'name' => trim(strip_tags($value["name"])),
                            'no_bpjs_ketenagakerjaan' => trim(strip_tags($value["no_bpjs_ketenagakerjaan"])),
                            'no_bpjs_pensiun' => trim(strip_tags($value["no_bpjs_pensiun"])),
                        ];
                    }

                    if (!empty($arr)) {
                        $dataDoc = array(
                            'bpjs_ketenagakerjaan' => $arr,
                            'token' => session('token'),
                            'id_hris' => session('id_hris'),
                            'name' => session('name'),

                        );

                        $model = ElaHelper::myCurl('hris/bpjs/ketenagakerjaan/do-upload-employee', $dataDoc);
                        $result = json_decode($model, true);
                        $id = rand(1, 100);
                        $data = array(
                            'message' => $result['result']['message'],
                            'response_code' => $result['result']['response_code'],
                            'wrong_id' => $result['wrongListId'],
                        );
                        return response()->json($data, 200);

                    } else {
                        $data = array(
                            'message' => 'There are no request data',
                            'response_code' => 500,
                            'wrong_id' => '',
                        );
                        return response()->json($data, 200);
                    }
                } else {
                    $data = array(
                        'message' => 'Empty File',
                        'response_code' => 500,
                        'wrong_id' => '',
                    );
                    return response()->json($data, 200);
                }
            } catch (Exception $e) {
                $data = array(
                    'message' => 'Error!! ' . $e,
                    'response_code' => 500,
                    'wrong_id' => '',
                );
                return response()->json($data, 500);
            }
        } else {
            $data = array(
                'message' => 'There are no request data',
                'response_code' => 500,
                'wrong_id' => '',
            );
            return response()->json($data, 200);
        }

    }

    public function detail(Request $request)
    {
        if (!session('token')) {
           echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="'.env('APP_URL').'/index";
                </script>';
        }

        $param = [
            "token" => session('token'),
            "id" => $request->get('id'),
        ];
        $data['hasil'] = json_decode(ElaHelper::myCurl('hris/bpjs/ketenagakerjaan/detail', $param));
        $data['searchMonth'] = $request->get('searchMonth') != 0 ? $request->get('searchMonth') : date('m');
        $data['searchYear'] = $request->get('searchYear') != 0 ? $request->get('searchYear') : date('Y');

        $data['title'] = 'BPJS Ketenagakerjaan';
        $data['subtitle'] = 'List Report';

        return view('HRIS.administration.bpjs.ketenagakerjaan.detail', $data);
    }

    public function doExcel(Request $request)
    {

        $customer = $request->get('cus_id');
        if ($request->has('month') && $request->has('year') && $request->has('cus_id')) {

            $urlMenu = 'master-global';
            $param = [
                "order" => ["cus_name", "ASC"],
                "fields" => ["cus_id", "cus_name"],
                "table" => "_mcustomer",
                "where" => ["cus_id", $customer],
            ];
            $cus = json_decode(ElaHelper::myCurl('master-global', $param));

            switch ($request->get('month')) {
                case "01":
                    $month = "January";
                    break;
                case "02":
                    $month = "February";
                    break;
                case "03":
                    $month = "March";
                    break;
                case "04":
                    $month = "April";
                    break;
                case "05":
                    $month = "May";
                    break;
                case "06":
                    $month = "June";
                    break;
                case "07":
                    $month = "July";
                    break;
                case "08":
                    $month = "August";
                    break;
                case "09":
                    $month = "September";
                    break;
                case "10":
                    $month = "October";
                    break;
                case "11":
                    $month = "November";
                    break;
                case "12":
                    $month = "December";
                    break;
                default:
                    $month = "";
            }

            $title = 'REPORT ' . $month . ' ' . $request->get('year') . '';
            $period = $request->get('year') . '-' . $request->get('month');
        } else {
            switch (date('m')) {
                case "01":
                    $month = "January";
                    break;
                case "02":
                    $month = "February";
                    break;
                case "03":
                    $month = "March";
                    break;
                case "04":
                    $month = "April";
                    break;
                case "05":
                    $month = "May";
                    break;
                case "06":
                    $month = "June";
                    break;
                case "07":
                    $month = "July";
                    break;
                case "08":
                    $month = "August";
                    break;
                case "09":
                    $month = "September";
                    break;
                case "10":
                    $month = "October";
                    break;
                case "11":
                    $month = "November";
                    break;
                case "12":
                    $month = "December";
                    break;
                default:
                    $month = "";
            }
            $title = 'REPORT ' . $month . ' ' . date('Y') . '';
            $period = '0';
        }

        return Excel::create($title, function ($excel) use ($title, $period, $customer) {
            $excel->sheet($title, function ($sheet) use ($title, $period, $customer) {
                $sheet->setCellValue('A1', 'No');
                $sheet->setCellValue('B1', 'Employee');
                $sheet->setCellValue('C1', 'NIP');
                $sheet->setCellValue('D1', 'Contract Number');
                $sheet->setCellValue('E1', 'Customer');
                $sheet->setCellValue('F1', 'Start Date');
                $sheet->setCellValue('G1', 'End Date');
                $sheet->setCellValue('H1', 'Resign Date');
                $sheet->setCellValue('I1', 'Period');
                $sheet->setCellValue('J1', 'BPJS Ketenagakerjaan No');
                $sheet->setCellValue('K1', 'Ketenagakerjaan Amount');
                $sheet->setCellValue('L1', 'BPJS Pensiun No');
                $sheet->setCellValue('M1', 'Pensiun Amount');
                $sheet->setCellValue('N1', 'Basic Amount');
                $sheet->setCellValue('O1', 'Company Amount');
                $sheet->setCellValue('P1', 'Employee Amount');
                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $customer,
                    "period" => $period,
                ];

                $member = json_decode(ElaHelper::myCurl('hris/bpjs/ketenagakerjaan/get-excel', $param));

                for ($a = 0; $a < count($member->result); $a++) {
                    $sheet->setCellValue('A' . $i, $no);
                    $sheet->setCellValue('B' . $i, $member->result[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $member->result[$a]->mem_nip);
                    $sheet->setCellValue('D' . $i, $member->result[$a]->cont_no_new);
                    $sheet->setCellValue('E' . $i, $member->result[$a]->cus_name);
                    $sheet->setCellValue('F' . $i, $member->result[$a]->cont_start_date);
                    $sheet->setCellValue('G' . $i, $member->result[$a]->cont_end_date);
                    $sheet->setCellValue('H' . $i, $member->result[$a]->cont_resign_date);
                    $sheet->setCellValue('I' . $i, $member->result[$a]->period);
                    $sheet->setCellValue('J' . $i, $member->result[$a]->bpjs_ket_number);
                    $sheet->setCellValue('K' . $i, $member->result[$a]->ket_total);
                    $sheet->setCellValue('L' . $i, $member->result[$a]->bpjs_pen_number);
                    $sheet->setCellValue('M' . $i, $member->result[$a]->pen_total);
                    $sheet->setCellValue('N' . $i, $member->result[$a]->pen_basic);
                    $sheet->setCellValue('O' . $i, $member->result[$a]->pen_company);
                    $sheet->setCellValue('P' . $i, $member->result[$a]->pen_employee);
                    $i++;
                    $no++;
                }
            });

        })->download('xlsx');
    }

}
