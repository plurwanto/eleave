<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class reportActivity extends Controller
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
        $link = ['Join',
            'Resign'];

        $select = '';
        $select .= '<select style="width:90px; margin-right:10px" id="link" class="form-control border-rounded pull-left"  border-rounded" onchange="javascript:handleSelect(this)">';
        $select2 = '';
        for ($i = 0; $i < count($link); $i++) {
            if ($i == 0) {
                $select2 .= '<option value="">' . $link[$i] . '</option>';
            } else {
                if ($request->get('link') == $link[$i]) {
                    $select2 .= '<option value="' . $link[$i] . '" selected>' . $link[$i] . '</option>';
                } else {
                    $select2 .= '<option value="' . $link[$i] . '">' . $link[$i] . '</option>';
                }
            }

        }
        $select .= $select2;
        $select .= '</select><input type="hidden" id="link" value="' . $request->get('link') . '">';

        $data['select'] = $select;

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

        $data['title'] = 'Report Activity Contract';

        if ($request->get('link') == 'resign') {
            $data['subtitle'] = 'List Report Activity Resign Contract';
        } else {
            $data['subtitle'] = 'List Report Activity Join Contract';
        }
        return view('HRIS.report.activity.index', $data);
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
        if ($request['columns'][8]['search']['value'] !='') {
            $period = $period[1] . $period[0];
        } else {
            $period = date('Ym');

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
            "search_nip" => $request['columns'][1]['search']['value'],
            "search_id_number" => $request['columns'][2]['search']['value'],
            "search_no_contract" => $request['columns'][3]['search']['value'],
            "search_status" => $request['columns'][4]['search']['value'],
            "search_start_date" => $request['columns'][5]['search']['value'],
            "search_end_date" => $request['columns'][6]['search']['value'],
            "search_customer" => $request['columns'][7]['search']['value'],
            "period" => $period,
            "link" => $request->post('link'),

        ];

        $rows = json_decode(ElaHelper::myCurl('hris/report/activity', $param));

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
       
        $data['period'] = $request->get('period') != 0 ? $request->get('period') : date('m/Y');
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        if ($request->get('link') == 'resign') {
            $data['link'] = $request->get('link');
            $data['title'] = 'Report Activity Resign Contract';
        } else {
            $data['link'] = "";
            $data['title'] = 'Report Activity Create Contract';

        }
        return view('HRIS.report.activity.filterExcel', $data);
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


        $period = explode('/', $request->get('period'));
        if ($period) {
            $period = $period[1] . $period[0];
        } else {
            $period = date('Ym');

        }

        $title = 'Activity Contract-' . $period . '-' . $rand;


        Excel::create($title, function ($excel) use ($request,$period) {
            $excel->sheet('Join', function ($sheet) use ($request,$period) {
                $sheet->setCellValue('A1', 'Nip');
                $sheet->setCellValue('B1', 'Name');
                $sheet->setCellValue('C1', 'Position');
                $sheet->setCellValue('D1', 'Customer');
                $sheet->setCellValue('E1', 'No Contract');
                $sheet->setCellValue('F1', 'Join Date');
                $sheet->setCellValue('G1', 'Date');
                $sheet->setCellValue('H1', 'Start Date');
                $sheet->setCellValue('I1', 'End Date');
                $sheet->setCellValue('J1', 'Resign Date');
                $sheet->setCellValue('K1', 'Status');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $request->get('cus_id'),
                    "period" => $period,
                    "link" => 'start contract',
                ];

                $contract = json_decode(ElaHelper::myCurl('hris/report/activity/get-excel', $param));

                for ($a = 0; $a < count($contract->result); $a++) {
                    $sheet->setCellValue('A' . $i, $contract->result[$a]->mem_nip);
                    $sheet->setCellValue('B' . $i, $contract->result[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $contract->result[$a]->cont_position);
                    $sheet->setCellValue('D' . $i, $contract->result[$a]->cus_name);
                    $sheet->setCellValue('E' . $i, $contract->result[$a]->cont_no_new);
                    $sheet->setCellValue('F' . $i, $contract->result[$a]->mem_join_date);
                    $sheet->setCellValue('G' . $i, $contract->result[$a]->cont_date);
                    $sheet->setCellValue('H' . $i, $contract->result[$a]->cont_start_date);
                    $sheet->setCellValue('I' . $i, $contract->result[$a]->cont_end_date);
                    $sheet->setCellValue('J' . $i, $contract->result[$a]->cont_resign_date);
                    $sheet->setCellValue('K' . $i, $contract->result[$a]->cont_sta_name);
                    $i++;
                    $no++;
                }

            });

            $excel->sheet('Resign', function ($sheet) use ($request,$period) {
                $sheet->setCellValue('A1', 'Nip');
                $sheet->setCellValue('B1', 'Name');
                $sheet->setCellValue('C1', 'Position');
                $sheet->setCellValue('D1', 'Customer');
                $sheet->setCellValue('E1', 'No Contract');
                $sheet->setCellValue('F1', 'Join Date');
                $sheet->setCellValue('G1', 'Date');
                $sheet->setCellValue('H1', 'Start Date');
                $sheet->setCellValue('I1', 'End Date');
                $sheet->setCellValue('J1', 'Resign Date');
                $sheet->setCellValue('K1', 'Status');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $request->get('cus_id'),
                    "period" => $period,
                    "link" => 'Resign',
                ];

                $contract = json_decode(ElaHelper::myCurl('hris/report/activity/get-excel', $param));

                for ($a = 0; $a < count($contract->result); $a++) {
                    $sheet->setCellValue('A' . $i, $contract->result[$a]->mem_nip);
                    $sheet->setCellValue('B' . $i, $contract->result[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $contract->result[$a]->cont_position);
                    $sheet->setCellValue('D' . $i, $contract->result[$a]->cus_name);
                    $sheet->setCellValue('E' . $i, $contract->result[$a]->cont_no_new);
                    $sheet->setCellValue('F' . $i, $contract->result[$a]->mem_join_date);
                    $sheet->setCellValue('G' . $i, $contract->result[$a]->cont_date);
                    $sheet->setCellValue('H' . $i, $contract->result[$a]->cont_start_date);
                    $sheet->setCellValue('I' . $i, $contract->result[$a]->cont_end_date);
                    $sheet->setCellValue('J' . $i, $contract->result[$a]->cont_resign_date);
                    $sheet->setCellValue('K' . $i, $contract->result[$a]->cont_sta_name);
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
}
