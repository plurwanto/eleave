<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class travel extends Controller
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

        $data['link'] = $request->get('link');

        $param = [
            "order" => ["trav_company_name", "ASC"],
            "fields" => ["trav_company_id", "trav_company_name"],
            "table" => "_travel_company",
        ];
        $data['travel_company'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["trav_sta_name", "ASC"],
            "fields" => ["trav_sta_id", "trav_sta_name"],
            "table" => "_travel_status",
        ];
        $data['travel_status'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "table" => "_mcurrency",
        ];
        $data['currency'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "id_hris" => session('id_hris'),
        ];

        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        $data['title'] = 'Travel';
        $data['subtitle'] = 'List Travel';

        return view('HRIS.administration.travel.index', $data);
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

        $period = explode('/', $request['columns'][8]['search']['value']);
        if ($request['columns'][8]['search']['value'] != '') {
            $period = $period[1] . '-' . $period[0];
        } else {
            $period = date('Y-m');

        }

        $period2 = explode('/', $request['columns'][9]['search']['value']);
        if ($request['columns'][9]['search']['value'] != '') {
            $period2 = $period2[1] . '-' . $period2[0];
        } else {
            $period2 = date('Y-m');

        }

        $search_date = explode('/', $request['columns'][1]['search']['value']);
        if ($request['columns'][1]['search']['value'] != '') {
            $search_date = $search_date[2] . '-' . $search_date[1] . '-' . $search_date[0];
        } else {
            $search_date = '';

        }

        $search_depart_date = explode('/', $request['columns'][2]['search']['value']);
        if ($request['columns'][2]['search']['value'] != '') {
            $search_depart_date = $search_depart_date[2] . '-' . $search_depart_date[1] . '-' . $search_depart_date[0];
        } else {
            $search_depart_date = '';

        }

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
            "search_date" => $search_date,
            "search_depart_date" => $search_depart_date,
            "search_company" => $request['columns'][3]['search']['value'],
            "search_status" => $request['columns'][4]['search']['value'],
            "search_currency" => $request['columns'][5]['search']['value'],
            "period" => $period,
            "period2" => $period2,
            "link" => $request->post('link'),

        ];

        $rows = json_decode(ElaHelper::myCurl('hris/travel', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['trav_date'] = $rows->data[$i]->trav_date;
                $nestedData['trav_inv'] = $rows->data[$i]->trav_inv;
                $nestedData['trav_det_departure_date'] = $rows->data[$i]->trav_det_departure_date;
                $nestedData['trav_det_departure_time'] = $rows->data[$i]->trav_det_departure_time;
                $nestedData['trav_company_name'] = $rows->data[$i]->trav_company_name;
                $nestedData['trav_class_name'] = $rows->data[$i]->trav_class_name;
                $nestedData['trav_sta_name'] = $rows->data[$i]->trav_sta_name;
                $nestedData['trav_det_flight_no'] = $rows->data[$i]->trav_det_flight_no;
                $nestedData['trav_det_desc'] = $rows->data[$i]->trav_det_desc;
                $nestedData['cur_id'] = $rows->data[$i]->cur_id;
                $nestedData['trav_det_tot'] = $rows->data[$i]->tot_values;
                $nestedData['trav_det_id'] = $rows->data[$i]->trav_det_id;
                $nestedData['action'] = '
                    <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->trav_det_id . '" onclick="get_modal(this)">
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

        $data['period'] = $request->get('period') != 0 ? $request->get('period') : date('m/Y');
        $data['period2'] = $request->get('period2') != 0 ? $request->get('period2') : date('m/Y');

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        $data['link'] = $request->get('link');

        $data['title'] = 'Report Travel';
        return view('HRIS.administration.travel.filterExcel', $data);
    }

    public function filterTemplate(Request $request)
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

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        $data['link'] = $request->get('link');
        $data['title'] = 'Template Travel';
        return view('HRIS.administration.travel.template', $data);
    }

    public function doTemplateExcel(Request $request)
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
        $rand = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTU1234567890", 3)), 0, 3);

        $title = 'Template Travel -' . $rand;

        Excel::create($title, function ($excel) use ($request) {
            $excel->sheet('employee', function ($sheet) use ($request) {
                $sheet->setCellValue('A1', 'No');
                $sheet->setCellValue('B1', 'Name');
                $sheet->setCellValue('C1', 'ID');
                $sheet->setCellValue('D1', 'NIP');
                $sheet->setCellValue('E1', 'Customer');
                $sheet->setCellValue('F1', 'Airlines ID');
                $sheet->setCellValue('G1', 'Class ID');
                $sheet->setCellValue('H1', 'Status ID');
                $sheet->setCellValue('I1', 'Currency');
                $sheet->setCellValue('J1', 'Travel Amount');
                $sheet->setCellValue('K1', 'Issued Date');
                $sheet->setCellValue('L1', 'Departure Date');
                $sheet->setCellValue('M1', 'Departure Time');
                $sheet->setCellValue('N1', 'Flight No');
                $sheet->setCellValue('O1', 'Description');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $request->get('cus_id'),
                ];

                $contract = json_decode(ElaHelper::myCurl('hris/travel/get-template', $param));
                for ($a = 0; $a < count($contract->result); $a++) {
                    $sheet->setCellValue('A' . $i, $no++);
                    $sheet->setCellValue('B' . $i, $contract->result[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $contract->result[$a]->mem_id);
                    $sheet->setCellValue('D' . $i, $contract->result[$a]->mem_nip);
                    $sheet->setCellValue('E' . $i, $contract->result[$a]->cus_name);
                    $sheet->setCellValue('F' . $i, "");
                    $sheet->setCellValue('G' . $i, "");
                    $sheet->setCellValue('H' . $i, "");
                    $sheet->setCellValue('I' . $i, $contract->result[$a]->cur_id);
                    $sheet->setCellValue('J' . $i, "");
                    $sheet->setCellValue('K' . $i, "");
                    $sheet->setCellValue('L' . $i, "");
                    $sheet->setCellValue('M' . $i, "");
                    $sheet->setCellValue('N' . $i, "");
                    $sheet->setCellValue('O' . $i, "");

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
        $rand = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTU1234567890", 3)), 0, 3);
        $title = 'Report Travel -' . $rand;

        Excel::create($title, function ($excel) use ($request) {
            $excel->sheet('employee', function ($sheet) use ($request) {
                $sheet->setCellValue('A1', 'No');
                $sheet->setCellValue('B1', 'Name');
                $sheet->setCellValue('C1', 'Customer');
                $sheet->setCellValue('D1', 'Period');
                $sheet->setCellValue('E1', 'Travel Date');
                $sheet->setCellValue('F1', 'Travel Invoice');
                $sheet->setCellValue('G1', 'Departure Date');
                $sheet->setCellValue('H1', 'Departure Time');
                $sheet->setCellValue('I1', 'Company');
                $sheet->setCellValue('J1', 'Class');
                $sheet->setCellValue('K1', 'Status');
                $sheet->setCellValue('L1', 'Flight No');
                $sheet->setCellValue('M1', 'Description');
                $sheet->setCellValue('N1', 'Currency');
                $sheet->setCellValue('O1', 'Total');

                $i = 2;
                $no = 1;

                $period = explode('/', $request->get('period'));
                if ($request->get('period') != '') {
                    $period = $period[1] . '-' . $period[0];
                } else {
                    $period = date('Y-m');

                }

                $period2 = explode('/', $request->get('period2'));
                if ($request->get('period2') != '') {
                    $period2 = $period2[1] . '-' . $period2[0];
                } else {
                    $period2 = date('Y-m');

                }

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $request->get('cus_id_filt'),
                    "period" => $period,
                    "period2" => $period2,

                ];

                $contract = json_decode(ElaHelper::myCurl('hris/travel/get-excel', $param));
                for ($a = 0; $a < count($contract->result); $a++) {
                    $sheet->setCellValue('A' . $i, $no++);
                    $sheet->setCellValue('B' . $i, $contract->result[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $contract->result[$a]->cus_name);
                    $sheet->setCellValue('D' . $i, $contract->result[$a]->period);
                    $sheet->setCellValue('E' . $i, $contract->result[$a]->trav_date);
                    $sheet->setCellValue('F' . $i, $contract->result[$a]->trav_inv);
                    $sheet->setCellValue('G' . $i, $contract->result[$a]->trav_det_departure_date);
                    $sheet->setCellValue('H' . $i, $contract->result[$a]->trav_det_departure_time);
                    $sheet->setCellValue('I' . $i, $contract->result[$a]->trav_company_name);
                    $sheet->setCellValue('J' . $i, $contract->result[$a]->trav_class_name);
                    $sheet->setCellValue('K' . $i, $contract->result[$a]->trav_sta_name);
                    $sheet->setCellValue('L' . $i, $contract->result[$a]->trav_det_flight_no);
                    $sheet->setCellValue('M' . $i, $contract->result[$a]->trav_det_desc);
                    $sheet->setCellValue('N' . $i, $contract->result[$a]->cur_id);
                    $sheet->setCellValue('O' . $i, $contract->result[$a]->trav_det_tot);

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

    public function detail(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Detail Employee Travel';
        $data['subtitle'] = 'List Employee Travel';

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $employee = json_decode(ElaHelper::myCurl('hris/travel/get-detail', $param));
        $data['employee'] = $employee;
        return view('HRIS.administration.travel.detail', $data);
    }
}
