<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class reportFinal extends Controller
{
    public $menuID = 13;
    public function index(Request $request)
    {

        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index";
                </script>';
        }

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
                    window.location.href="' . env('APP_URL') . '/index";
                  </script>';
        }

        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "table" => "_contract_status",
        ];
        $data['contract_status'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        $data['title'] = 'REPORT FINAL';
        $data['subtitle'] = 'List Report Final';
        $data['subtitle2'] = str_replace('<br>', ' ', 'List Report Final');

        return view('HRIS.report.final.index', $data);
    }

    public function listData(Request $request)
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
            "customer" => $request->post('cus_id'),
            "search_name" => $request['columns'][0]['search']['value'],
            "search_nip" => $request['columns'][1]['search']['value'],
            "search_id_number" => $request['columns'][2]['search']['value'],
            "search_no_contract" => $request['columns'][3]['search']['value'],
            "search_status" => $request['columns'][4]['search']['value'],
            "search_start_date" => $request['columns'][5]['search']['value'],
            "search_end_date" => $request['columns'][6]['search']['value'],
            "search_customer" => $request['columns'][7]['search']['value'],
            "period" => $request['columns'][9]['search']['value'] . $request['columns'][8]['search']['value'],

        ];

        $rows = json_decode(ElaHelper::myCurl('hris/report/final', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['cont_id'] = $rows->data[$i]->cont_id;
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cont_no_new'] = $rows->data[$i]->cont_no_new;
                $nestedData['cont_sta_name'] = $rows->data[$i]->cont_sta_name;
                $nestedData['cont_start_date'] = $rows->data[$i]->cont_start_date;
                $nestedData['cont_end_date'] = $rows->data[$i]->cont_end_date;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;

                $menu_access = '';

                $nestedData['action'] = '<div class="btn-group">
                        <button class="btn dark btn-outline btn-circle btn-xs border-rounded" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                        <li>
                            <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->cont_id . '" onclick="get_modal(this)">
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

        $data['title'] = 'REPORT FINAL';
        $data['subtitle'] = 'List Report Final';
        return view('HRIS.report.final.filterExcel', $data);
    }

    public function doExcel_backup(Request $request)
    {
        $files = glob(base_path('public/hris/files/temp/*')); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file);
            }
            // delete file
        }

        $destinationPath = base_path('public/hris/files/temp/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
        $title = 'Report-' . $request->get('year') . $request->get('month') . '-' . date('dmyHis');

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet($title, function ($sheet) use ($request, $title) {
                $sheet->setCellValue('A1', 'Nip');
                $sheet->setCellValue('B1', 'Name');
                $sheet->setCellValue('C1', 'Position');
                $sheet->setCellValue('D1', 'ID Number');
                $sheet->setCellValue('E1', 'Nationality');
                $sheet->setCellValue('F1', 'Email');
                $sheet->setCellValue('G1', 'Mobile');
                $sheet->setCellValue('H1', 'Address');
                $sheet->setCellValue('I1', 'Customer');
                $sheet->setCellValue('J1', 'Site Location');
                $sheet->setCellValue('K1', 'Marital Status');

                $sheet->setCellValue('L1', 'Bank Name');
                $sheet->setCellValue('M1', 'Bank Account');
                $sheet->setCellValue('N1', 'Bank Account Name');

                $sheet->setCellValue('O1', 'Place of Birth');
                $sheet->setCellValue('P1', 'Date of Birth');
                $sheet->setCellValue('Q1', 'Join Date');
                $sheet->setCellValue('R1', 'No');
                $sheet->setCellValue('S1', 'Date');
                $sheet->setCellValue('T1', 'Start Date');
                $sheet->setCellValue('U1', 'End Date');
                $sheet->setCellValue('V1', 'Resign Date');
                $sheet->setCellValue('W1', 'Status');
                $sheet->setCellValue('X1', 'MEDICAL');
                $sheet->setCellValue('Y1', 'LAPTOP');
                $sheet->setCellValue('Z1', 'MEAL & TRANPORT');
                $sheet->setCellValue('AA1', 'PHONE & PARKING');
                $sheet->setCellValue('AB1', 'POSITION');
                $sheet->setCellValue('AC1', 'ACCOMODATION FOR EXPAT');
                $sheet->setCellValue('AD1', 'OVERTIME');
                $sheet->setCellValue('AE1', 'TOOLS');
                $sheet->setCellValue('AF1', 'RELOCATION');
                $sheet->setCellValue('AG1', 'OTHERS');
                $sheet->setCellValue('AH1', 'Total Allowance');
                $sheet->setCellValue('AI1', 'Basic Sallary');
                $sheet->setCellValue('AJ1', 'THP');
                $sheet->setCellValue('AK1', 'Tax Remark');
                $sheet->setCellValue('AL1', 'Insurance');
                $sheet->setCellValue('AM1', 'Ketenagakerjaan');
                $sheet->setCellValue('AN1', 'Kesehatan');
                $sheet->setCellValue('AO1', 'Pensiun');
                $sheet->setCellValue('AP1', 'Swift Code');

                $sheet->setCellValue('AQ1', 'Bank Name 2');
                $sheet->setCellValue('AR1', 'Bank Account 2');
                $sheet->setCellValue('AS1', 'Bank Account Name 2');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $request->get('cus_id'),
                    "period" => $request->get('year') . $request->get('month'),
                ];

                $contract = json_decode(ElaHelper::myCurl('hris/report/final/get-excel', $param));

                for ($a = 0; $a < count($contract->result); $a++) {
                    $sheet->setCellValue('A' . $i, $contract->result[$a]->mem_nip);
                    $sheet->setCellValue('B' . $i, $contract->result[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $contract->result[$a]->cont_position);
                    $sheet->setCellValueExplicit('D' . $i, $contract->result[$a]->id_number);
                    $sheet->setCellValue('E' . $i, $contract->result[$a]->nat_name);
                    $sheet->setCellValue('F' . $i, $contract->result[$a]->mem_email);
                    $sheet->setCellValue('G' . $i, $contract->result[$a]->mem_mobile);
                    $sheet->setCellValue('H' . $i, $contract->result[$a]->mem_address);
                    $sheet->setCellValue('I' . $i, $contract->result[$a]->cus_name);
                    $sheet->setCellValue('J' . $i, $contract->result[$a]->cont_city_name);
                    $sheet->setCellValue('K' . $i, $contract->result[$a]->mem_marital_name);
                    $sheet->setCellValue('L' . $i, $contract->result[$a]->bank_name);
                    $sheet->setCellValue('M' . $i, $contract->result[$a]->mem_bank_ac);
                    $sheet->setCellValue('N' . $i, $contract->result[$a]->mem_bank_an);
                    $sheet->setCellValue('O' . $i, $contract->result[$a]->mem_dob_city);
                    $sheet->setCellValue('P' . $i, $contract->result[$a]->mem_dob);
                    $sheet->setCellValue('Q' . $i, $contract->result[$a]->mem_join_date);
                    $sheet->setCellValue('R' . $i, $contract->result[$a]->cont_no_new);
                    $sheet->setCellValue('S' . $i, $contract->result[$a]->cont_date);
                    $sheet->setCellValue('T' . $i, $contract->result[$a]->cont_start_date);
                    $sheet->setCellValue('U' . $i, $contract->result[$a]->cont_end_date);
                    $sheet->setCellValue('V' . $i, $contract->result[$a]->cont_resign_date);
                    $sheet->setCellValue('W' . $i, $contract->result[$a]->cont_sta_name);

                    $alfabet = ['X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG'];

                    for ($y = 0; $y < count($contract->allowanceList); $y++) {
                        $allow[$y] = '';
                        for ($x = 0; $x < count($contract->result[$a]->allowance); $x++) {
                            if ($contract->allowanceList[$y]->fix_allow_master_id == $contract->result[$a]->allowance[$x]->fix_allow_master_id) {
                                $allow[$y] = $contract->result[$a]->allowance[$x]->cont_det_tot;
                            } else {
                                $allow[$y] = 0;
                            }
                        }
                        $sheet->setCellValueExplicit($alfabet[$y] . $i, $allow[$y]);
                    }

                    $sheet->setCellValueExplicit('AH' . $i, $contract->result[$a]->allowance_tot);
                    $sheet->setCellValueExplicit('AI' . $i, $contract->result[$a]->cont_basic_salary);
                    $sheet->setCellValue('AJ' . $i, $contract->result[$a]->cont_sta_name);
                    $sheet->setCellValue('AK' . $i, $contract->result[$a]->tr_name);
                    $sheet->setCellValueExplicit('AL' . $i, $contract->result[$a]->mem_npwp_no);
                    $sheet->setCellValueExplicit('AM' . $i, $contract->result[$a]->mem_jamsostek);
                    $sheet->setCellValueExplicit('AN' . $i, $contract->result[$a]->mem_bpjs_kes);
                    $sheet->setCellValueExplicit('AO' . $i, $contract->result[$a]->mem_bpjs_pen);
                    $sheet->setCellValueExplicit('AP' . $i, $contract->result[$a]->swift_no);
                    $sheet->setCellValueExplicit('AQ' . $i, $contract->result[$a]->bank_name2);
                    $sheet->setCellValueExplicit('AR' . $i, $contract->result[$a]->mem_bank_ac2);
                    $sheet->setCellValueExplicit('AS' . $i, $contract->result[$a]->mem_bank_an2);
                    $i++;
                    $no++;
                }

            });

        })->store('xlsx', $destinationPath);

        return [
            "response_code" => 200,
            "path" => env('APP_URL') . '/public/hris/files/temp/' . $title . '.xlsx',
        ];
    }

    public function doExcel(Request $request)
    {
        $files = glob(base_path('public/hris/files/temp/*')); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file);
            }
            // delete file
        }

        $destinationPath = base_path('public/hris/files/temp/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
        $title = 'Report-' . $request->get('year') . $request->get('month') . '-' . date('dmyHis');

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet($title, function ($sheet) use ($request, $title) {
                $sheet->setCellValue('A1', 'Nip');
                $sheet->setCellValue('B1', 'Name');
                $sheet->setCellValue('C1', 'Position');
                $sheet->setCellValue('D1', 'ID Number');
                $sheet->setCellValue('E1', 'Nationality');
                $sheet->setCellValue('F1', 'Email');
                $sheet->setCellValue('G1', 'Mobile');
                $sheet->setCellValue('H1', 'Address');
                $sheet->setCellValue('I1', 'Customer');
                $sheet->setCellValue('J1', 'Site Location');
                $sheet->setCellValue('K1', 'Marital Status');

                $sheet->setCellValue('L1', 'Bank Name');
                $sheet->setCellValue('M1', 'Bank Account');
                $sheet->setCellValue('N1', 'Bank Account Name');

                $sheet->setCellValue('O1', 'Place of Birth');
                $sheet->setCellValue('P1', 'Date of Birth');
                $sheet->setCellValue('Q1', 'Join Date');
                $sheet->setCellValue('R1', 'No Contract');
                $sheet->setCellValue('S1', 'No Letter Number');
                $sheet->setCellValue('T1', 'Date');
                $sheet->setCellValue('U1', 'Start Date');
                $sheet->setCellValue('V1', 'End Date');
                $sheet->setCellValue('W1', 'Resign Date');
                $sheet->setCellValue('X1', 'Status');

                $sheet->setCellValue('Y1', 'Accomodation');
                $sheet->setCellValue('Z1', 'Communication Allowance');
                $sheet->setCellValue('AA1', 'Flexible Allowance');
                $sheet->setCellValue('AB1', 'Laptop');
                $sheet->setCellValue('AC1', 'Meal');
                $sheet->setCellValue('AD1', 'Medical');
                $sheet->setCellValue('AE1', 'Others');
                $sheet->setCellValue('AF1', 'Overtime');
                $sheet->setCellValue('AG1', 'Parking');
                $sheet->setCellValue('AH1', 'Phone');
                $sheet->setCellValue('AI1', 'Position');
                $sheet->setCellValue('AJ1', 'Relocation');
                $sheet->setCellValue('AK1', 'Tools');
                $sheet->setCellValue('AL1', 'Transportation');
                $sheet->setCellValue('AM1', 'Tunjangan Khusus (Lembur)');
                $sheet->setCellValue('AN1', 'Tunjangan Tidak Tetap');
                $sheet->setCellValue('AO1', 'Work Allowance');

                $sheet->setCellValue('AP1', 'Total Allowance');
                $sheet->setCellValue('AQ1', 'Basic Sallary');
                $sheet->setCellValue('AR1', 'Gross Salary');
                $sheet->setCellValue('AS1', 'Tax Remark');
                $sheet->setCellValue('AT1', 'Insurance');
                $sheet->setCellValue('AU1', 'Ketenagakerjaan');
                $sheet->setCellValue('AV1', 'Kesehatan');
                $sheet->setCellValue('AW1', 'Pensiun');
                $sheet->setCellValue('AX1', 'Swift Code');

                $sheet->setCellValue('AY1', 'Bank Name 2');
                $sheet->setCellValue('AZ1', 'Bank Account 2');
                $sheet->setCellValue('BA1', 'Bank Account Name 2');
                $sheet->setCellValue('BB1', 'Condition');
                $sheet->setCellValue('BC1', 'Calendar Days');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $request->get('cus_id'),
                    "period" => $request->get('year') . $request->get('month'),
                ];

                $contract = json_decode(ElaHelper::myCurl('hris/report/final/get-excel', $param));

                for ($a = 0; $a < count($contract->result); $a++) {
                    $sheet->setCellValue('A' . $i, $contract->result[$a]->mem_nip);
                    $sheet->setCellValue('B' . $i, $contract->result[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $contract->result[$a]->cont_position);
                    $sheet->setCellValueExplicit('D' . $i, $contract->result[$a]->id_number);
                    $sheet->setCellValue('E' . $i, $contract->result[$a]->nat_name);
                    $sheet->setCellValue('F' . $i, $contract->result[$a]->mem_email);
                    $sheet->setCellValue('G' . $i, $contract->result[$a]->mem_mobile);
                    $sheet->setCellValue('H' . $i, $contract->result[$a]->mem_address);
                    $sheet->setCellValue('I' . $i, $contract->result[$a]->cus_name);
                    $sheet->setCellValue('J' . $i, $contract->result[$a]->cont_city_name);
                    $sheet->setCellValue('K' . $i, $contract->result[$a]->mem_marital_name);
                    $sheet->setCellValue('L' . $i, $contract->result[$a]->bank_name);
                    $sheet->setCellValue('M' . $i, $contract->result[$a]->mem_bank_ac);
                    $sheet->setCellValue('N' . $i, $contract->result[$a]->mem_bank_an);
                    $sheet->setCellValue('O' . $i, $contract->result[$a]->mem_dob_city);
                    $sheet->setCellValue('P' . $i, $contract->result[$a]->mem_dob);
                    $sheet->setCellValue('Q' . $i, $contract->result[$a]->mem_join_date);
                    $sheet->setCellValue('R' . $i, $contract->result[$a]->cont_no_new);
                    $sheet->setCellValue('S' . $i, $contract->result[$a]->let_no_out);
                    $sheet->setCellValue('T' . $i, $contract->result[$a]->cont_date);
                    $sheet->setCellValue('U' . $i, $contract->result[$a]->cont_start_date);
                    $sheet->setCellValue('V' . $i, $contract->result[$a]->cont_end_date);
                    $sheet->setCellValue('W' . $i, $contract->result[$a]->cont_resign_date);
                    $sheet->setCellValue('X' . $i, $contract->result[$a]->cont_sta_name);

                    for ($x = 0; $x < count($contract->result[$a]->allowance); $x++) {

                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 243) {
                            $sheet->setCellValueExplicit('Y' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 259) {
                            $sheet->setCellValueExplicit('Z' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 256) {
                            $sheet->setCellValueExplicit('AA' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 244) {
                            $sheet->setCellValueExplicit('AB' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 245) {
                            $sheet->setCellValueExplicit('AC' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 247) {
                            $sheet->setCellValueExplicit('AD' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 254) {
                            $sheet->setCellValueExplicit('AE' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 248) {
                            $sheet->setCellValueExplicit('AF' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 250) {
                            $sheet->setCellValueExplicit('AG' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 249) {
                            $sheet->setCellValueExplicit('AH' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 251) {
                            $sheet->setCellValueExplicit('AI' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 252) {
                            $sheet->setCellValueExplicit('AJ' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 253) {
                            $sheet->setCellValueExplicit('AK' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 246) {
                            $sheet->setCellValueExplicit('AL' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 258) {
                            $sheet->setCellValueExplicit('AM' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 257) {
                            $sheet->setCellValueExplicit('AN' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }
                        if ($contract->result[$a]->allowance[$x]->fix_allow_type_id == 255) {
                            $sheet->setCellValueExplicit('AO' . $i, $contract->result[$a]->allowance[$x]->cont_det_tot);
                        }

                    }

                    $sheet->setCellValueExplicit('AP' . $i, $contract->result[$a]->allowance_tot);
                    $sheet->setCellValueExplicit('AQ' . $i, $contract->result[$a]->cont_basic_salary);
                    $sheet->setCellValue('AR' . $i, $contract->result[$a]->cont_tot);
                    $sheet->setCellValue('AS' . $i, $contract->result[$a]->tr_name);
                    $sheet->setCellValueExplicit('AT' . $i, $contract->result[$a]->mem_npwp_no);
                    $sheet->setCellValueExplicit('AU' . $i, $contract->result[$a]->mem_jamsostek);
                    $sheet->setCellValueExplicit('AV' . $i, $contract->result[$a]->mem_bpjs_kes);
                    $sheet->setCellValueExplicit('AW' . $i, $contract->result[$a]->mem_bpjs_pen);
                    $sheet->setCellValueExplicit('AX' . $i, $contract->result[$a]->swift_no);
                    $sheet->setCellValueExplicit('AY' . $i, $contract->result[$a]->bank_name2);
                    $sheet->setCellValueExplicit('AZ' . $i, $contract->result[$a]->mem_bank_ac2);
                    $sheet->setCellValueExplicit('BA' . $i, $contract->result[$a]->mem_bank_an2);
                    $sheet->setCellValueExplicit('BB' . $i, $contract->result[$a]->condition);
                    $sheet->setCellValueExplicit('BC' . $i, $contract->result[$a]->total_hari);


                    $i++;
                    $no++;
                }

            });

        })->store('xlsx', $destinationPath);

        return [
            "response_code" => 200,
            "path" => env('APP_URL') . '/public/hris/files/temp/' . $title . '.xlsx',
        ];
    }

    public function getCustomer(Request $request)
    {
        $cus_id = $request->get('cus_id');

        $param = [
            "order" => ["cus_name", "ASC"],
            "fields" => ["cus_name", "date_cutoff"],
            "where" => ["cus_id", $cus_id],
            "table" => "_mcustomer",
        ];
        $cus = json_decode(ElaHelper::myCurl('master-global', $param));
        if ($cus) {
            if ($cus->result[0]->date_cutoff != '') {
                $data = $cus->result[0]->date_cutoff;

            } else {
                $data = '-';

            }

        } else {
            $data = '-';
        }
        echo $data;
    }

}
