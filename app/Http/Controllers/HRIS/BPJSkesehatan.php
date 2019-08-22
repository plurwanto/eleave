<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class BPJSkesehatan extends Controller
{

    public $menuID = 10;

    public function index(Request $request)
    {

        // return redirect(env('APP_URL'));
        $link = ['iuran',
            'employee'];
        $select = '';
        $select .= '<select style="width:120px; margin-right:10px" class="form-control border-rounded pull-left"  border-rounded" onchange="javascript:handleSelect(this)">';
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
                    window.location.href="' . env('APP_URL') . '/index"
                  </script>';
        }

        $data['title'] = 'BPJS Kesehatan';

        if ($request->get('cus_id')) {
            $data['cus_id'] = $request->get('cus_id');
        } else {
            $data['cus_id'] = '';
        }

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

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
                    return view('HRIS.administration.bpjs.kesehatan.log', $data);
                    break;
                case 'employee':
                    $data['subtitle'] = 'List BPJS Kesehatan';
                    $data['subtitle2'] = str_replace('<br>', ' ', 'List BPJS Kesehatan');
                    return view('HRIS.administration.bpjs.kesehatan.employee', $data);
                    break;

                default;
                    $data['subtitle'] = 'List BPJS Kesehatan';
                    $data['subtitle2'] = str_replace('<br>', ' ', 'List BPJS Kesehatan');
                    return view('HRIS.administration.bpjs.kesehatan.index', $data);

            }
        } else {
            $data['title'] = 'BPJS Kesehatan';
            $data['subtitle'] = 'List BPJS Kesehatan';
            $data['subtitle2'] = str_replace('<br>', ' ', 'List BPJS Kesehatan');
            return view('HRIS.administration.bpjs.kesehatan.index', $data);
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
            "customer" => $request->post('cus_id'),
            "search_name" => $request['columns'][0]['search']['value'],
            "search_nip" => $request['columns'][1]['search']['value'],
            "search_code" => $request['columns'][2]['search']['value'],
            "search_user" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][4]['search']['value'],
            "search_month" => $request['columns'][5]['search']['value'],
            "search_year" => $request['columns'][6]['search']['value'],

        ];
        $rows = json_decode(ElaHelper::myCurl('hris/bpjs/kesehatan', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['bpjs_kes_id'] = $rows->data[$i]->bpjs_kes_id;
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                $nestedData['bpjs_kes_number'] = $rows->data[$i]->bpjs_kes_number;
                $nestedData['period'] = $rows->data[$i]->period;
                $nestedData['total'] = $rows->data[$i]->total;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;

                $nestedData['created_date'] = $rows->data[$i]->created_date;

                $menu_access = '';

                $nestedData['action'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->bpjs_kes_id . '" onclick="get_modal(this)">
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
            "search_bpjs_kes" => $request['columns'][3]['search']['value'],
            "search_created_by" => $request['columns'][5]['search']['value'],

        ];
        $rows = json_decode(ElaHelper::myCurl('hris/bpjs/kesehatan/employee', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['idNumber'] = $rows->data[$i]->idNumber;
                $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                $nestedData['mem_bpjs_kes'] = $rows->data[$i]->mem_bpjs_kes;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['updated_at'] = date('d-M-Y', strtotime($rows->data[$i]->updated_at->date));

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
                    window.location.href="' . env('APP_URL') . '/index";
                </script>';
            exit;
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

        $data['title'] = 'BPJS Kesehatan';
        $data['subtitle'] = 'List Report';
        return view('HRIS.administration.bpjs.kesehatan.filterExcel', $data);
    }

    public function upload(Request $request)
    {

        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index";
                </script>';
        }

        $data['searchMonth'] = $request->get('searchMonth') != 0 ? $request->get('searchMonth') : date('m');
        $data['searchYear'] = $request->get('searchYear') != 0 ? $request->get('searchYear') : date('Y');

        $data['title'] = 'BPJS Kesehatan';
        $data['subtitle'] = 'List Report';
        return view('HRIS.administration.bpjs.kesehatan.upload', $data);
    }

    public function uploadEmployee(Request $request)
    {

        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index";
                </script>';
        }

        $urlMenu = 'hris/get-access-menu';

        $data['searchMonth'] = $request->get('searchMonth') != 0 ? $request->get('searchMonth') : date('m');
        $data['searchYear'] = $request->get('searchYear') != 0 ? $request->get('searchYear') : date('Y');

        $data['title'] = 'BPJS Kesehatan';
        $data['subtitle'] = 'List Report';
        return view('HRIS.administration.bpjs.kesehatan.uploadEmployee', $data);
    }

    public function templateIuran(Request $request)
    {

        return Excel::create('Template Iuran BPJS Kesehatan', function ($excel) {
            $excel->sheet('Template Iuran BPJS Kesehatan', function ($sheet) {
                $sheet->setCellValue('A1', 'No');
                $sheet->setCellValue('B1', 'Client ID');
                $sheet->setCellValue('C1', 'Client Name');
                $sheet->setCellValue('D1', 'Contract No');
                $sheet->setCellValue('E1', 'Name');
                $sheet->setCellValue('F1', 'NIP');
                $sheet->cell('F1', function ($cell) {$cell->setBackground('#F08080');});

                $sheet->setCellValue('G1', 'No BPJS Kesehatan');
                $sheet->cell('G1', function ($cell) {$cell->setBackground('#F08080');});

                $sheet->setCellValue('H1', 'NIK/KITAS/KITAP');
                $sheet->setCellValue('I1', 'Gaji Pokok');
                $sheet->setCellValue('J1', 'Total');
                $sheet->cell('J1', function ($cell) {$cell->setBackground('#F08080');});

                $sheet->setCellValue('K1', 'Total Additional');
                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];
                $member = json_decode(ElaHelper::myCurl('hris/bpjs/kesehatan/get-template-iuran', $param));
                for ($a = 0; $a < count($member->result); $a++) {
                    $sheet->setCellValue('A' . $i, $no);
                    $sheet->setCellValue('B' . $i, $member->result[$a]->cus_id);
                    $sheet->setCellValue('C' . $i, $member->result[$a]->cus_name);
                    $sheet->setCellValue('D' . $i, $member->result[$a]->cont_no_new);
                    $sheet->setCellValue('E' . $i, $member->result[$a]->mem_name);
                    $sheet->setCellValue('F' . $i, $member->result[$a]->mem_nip);
                    $sheet->setCellValue('G' . $i, $member->result[$a]->mem_bpjs_kes);
                    $sheet->setCellValueExplicit('H' . $i, $member->result[$a]->mem_ktp_no);
                    $sheet->setCellValue('I' . $i, $member->result[$a]->cont_basic_salary);
                    $sheet->setCellValue('J' . $i, '');
                    $sheet->setCellValue('K' . $i, '');
                    $i++;
                    $no++;
                }
            });

        })->download('xlsx');
    }

    public function templateUpdate(Request $request)
    {

        return Excel::create('Template Update BPJS Kesehatan', function ($excel) {
            $excel->sheet('Template Update BPJS Kesehatan', function ($sheet) {

                $sheet->setCellValue('A1', 'Member NIP');
                $sheet->cell('A1', function ($cell) {$cell->setBackground('#F08080');});

                $sheet->setCellValue('B1', 'Name');

                $sheet->setCellValue('C1', 'No BPJS Kesehatan');
                $sheet->cell('C1', function ($cell) {$cell->setBackground('#F08080');});

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
                    $fieldName = array('nikkitaskitap', 'no_bpjs_kesehatan', 'total', 'total_additional');
                    $headerRow = $excelData->first()->keys()->toArray();
                    $arr3 = array_diff($fieldName, $headerRow);
                    if (count($arr3) == 0) {
                        foreach ($excelData as $key => $value) {
                            $arr[] = [
                                'id_number' => trim(strip_tags($value["nikkitaskitap"])),
                                'no_bpjs_kesehatan' => trim(strip_tags($value["no_bpjs_kesehatan"])),
                                'total' => trim(strip_tags($value["total"])),
                                'total_additional' => trim(strip_tags($value["total_additional"])),
                            ];
                        }

                        if (!empty($arr)) {
                            $dataDoc = array(
                                'bpjs_kesehatan' => $arr,
                                'period' => $period,
                                'token' => session('token'),
                                'id_hris' => session('id_hris'),
                            );

                            $model = ElaHelper::myCurl('hris/bpjs/kesehatan/do-upload', $dataDoc);
                            $result = json_decode($model, true);
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

                    $fieldName = array('member_nip', 'name', 'no_bpjs_kesehatan');
                    $headerRow = $excelData->first()->keys()->toArray();
                    $arr3 = array_diff($fieldName, $headerRow);
                    if (count($arr3) == 0) {

                        foreach ($excelData as $key => $value) {
                            $arr[] = [
                                'member_nip' => trim(strip_tags($value["member_nip"])),
                                'name' => trim(strip_tags($value["name"])),
                                'no_bpjs_kesehatan' => trim(strip_tags($value["no_bpjs_kesehatan"])),
                            ];
                        }

                        if (!empty($arr)) {
                            $dataDoc = array(
                                'bpjs_kesehatan' => $arr,
                                'token' => session('token'),
                                'id_hris' => session('id_hris'),
                                'name' => session('name'),

                            );

                            $model = ElaHelper::myCurl('hris/bpjs/kesehatan/do-upload-employee', $dataDoc);

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
                            'message' => 'header file format is not appropriate',
                            'response_code' => 500,
                            'wrong_id' => '',
                        );
                        return response()->json($data, 200);
                    }
                } else {
                    $data = array(
                        'msg' => 'Empty File',
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
                    window.location.href="' . env('APP_URL') . '/index";
                </script>';
        }

        $param = [
            "token" => session('token'),
            "id" => $request->get('id'),
        ];
        $data['hasil'] = json_decode(ElaHelper::myCurl('hris/bpjs/kesehatan/detail', $param));
        $data['searchMonth'] = $request->get('searchMonth') != 0 ? $request->get('searchMonth') : date('m');
        $data['searchYear'] = $request->get('searchYear') != 0 ? $request->get('searchYear') : date('Y');

        $data['title'] = 'BPJS Kesehatan';
        $data['subtitle'] = 'List Report';

        return view('HRIS.administration.bpjs.kesehatan.detail', $data);
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
                $sheet->setCellValue('D1', 'Customer');
                $sheet->setCellValue('E1', 'No BPJS Kesehatan');
                $sheet->setCellValue('F1', 'Period');
                $sheet->setCellValue('G1', 'Amount');
                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $customer,
                    "period" => $period,
                ];
                $member = json_decode(ElaHelper::myCurl('hris/bpjs/kesehatan/get-excel', $param));

                for ($a = 0; $a < count($member->result); $a++) {
                    $sheet->setCellValue('A' . $i, $no);
                    $sheet->setCellValue('B' . $i, $member->result[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $member->result[$a]->mem_nip);
                    $sheet->setCellValue('D' . $i, $member->result[$a]->cus_name);
                    $sheet->setCellValue('E' . $i, $member->result[$a]->bpjs_kes_number);
                    $sheet->setCellValue('F' . $i, $member->result[$a]->period);
                    $sheet->setCellValue('G' . $i, $member->result[$a]->total);
                    $i++;
                    $no++;
                }
            });

        })->download('xlsx');
    }

}
