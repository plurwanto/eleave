<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Log extends Controller
{
    public $menuID = 35;
    public function index(Request $request)
    {

        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="'.env('APP_URL').'/index";
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
                    window.location.href="'.env('APP_URL').'/index";
                  </script>';
        }

        $urlMenu = 'master-global';
        $param = [
            "order" => ["menu_name", "ASC"],
            "fields" => ["menu_id", "menu_name"],
            "where" => ["parent_id", "!=", "0"],
            "table" => "hris_menu",
        ];
        $data['menu'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "order" => ["menu_name", "DESC"],
            "fields" => ["*", "_mcustomer.cus_name"],
            "join" => ["_mcustomer", "_contract_cus_accept_type_2.cus_id", "_mcustomer.cus_id"],
            "table" => "_contract_cus_accept_type_2",
        ];
        $data['menu'] = json_decode(ElaHelper::myCurl('hris/hris-setting/master-global-join', $param));

        $data['title'] = 'Log Activity';
        $data['subtitle'] = 'List Log Activity';
        $data['subtitle2'] = str_replace('<br>', ' ', 'List Log Activity');

        return view('HRIS.master.log.index', $data);
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

        if ($request['columns'][4]['search']['value'] != "" && $request['columns'][4]['search']['value'] != null) {
            $created_date = $request['columns'][4]['search']['value'];
            $created_date = str_replace('/', '-', $created_date);
            $created_date = date('Y-m-d', strtotime($created_date));
        } else {
            $created_date = "";
        }
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "page" => $page,
            "per_page" => $request->post('length'),
            "search" => $search,
            "sort_by" => $sort_by,
            "dir" => $dir,
            "search_type" => $request['columns'][0]['search']['value'],
            "search_menu" => $request['columns'][1]['search']['value'],
            "search_action" => $request['columns'][2]['search']['value'],
            "search_createBy" => $request['columns'][3]['search']['value'],
            "search_date" => $created_date,
        ];
        $rows = json_decode(ElaHelper::myCurl('hris/log', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['type'] = $rows->data[$i]->type;
                $nestedData['menu_name'] = $rows->data[$i]->menu_name;
                $nestedData['table'] = $rows->data[$i]->action;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $nestedData['created_at'] = $rows->data[$i]->created_at;
                $nestedData['log_id'] = $rows->data[$i]->log_id;

                $menu_access = '';

                $nestedData['action'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->log_id . '" onclick="get_modal(this)">
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

    public function detail(Request $request)
    {
        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="'.env('APP_URL').'/index";
                </script>';
        }

        $param = [
            "order" => ["log_id", "ASC"],
            "fields" => ["log_id", "type", "log_before", "log_after"],
            "where" => ["log_id", $request->get('id')],
            "table" => "_mlog",
        ];
        $log = json_decode(ElaHelper::myCurl('master-global', $param));
        if ($log) {
            $data['log_error'] = $log;
        } else {
            $data['log_error'] = '';
        }

        $data['title'] = 'Detail Activity';

        return view('HRIS.master.log.detail', $data);
    }

}
