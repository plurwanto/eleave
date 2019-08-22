<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class letterRequest extends Controller
{
    public $menuID = 23;

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

        $param = [
            "order" => ["type_name", "ASC"],
            "fields" => ["let_code", "type_name"],
            "table" => "_letter_type",
        ];
        $data['letter_type'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $data['title'] = 'Letter Request';
        $data['subtitle'] = 'List Letter Request';
        return view('HRIS.administration.letterRequest.index', $data);
    }

    public function listData(Request $request)
    {
        $draw = $request->post('draw');
        $urlMenu = 'hris/get-access-menu';
        $param = [
            "id_hris" => session('id_hris'),

        ];
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/letter-request';

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
            "search_letter_no" => $request['columns'][2]['search']['value'],
            "search_type" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][1]['search']['value'],
            "search_member" => $request['columns'][0]['search']['value'],
            "search_user" => $request['columns'][4]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $updated_at = $rows->data[$i]->updated_at->date != "0000-00-00 00:00:00" ? date('d-M-Y H:i:s', strtotime($rows->data[$i]->updated_at->date)) : "";

                $nestedData['no'] = $a++;
                $nestedData['let_id'] = $rows->data[$i]->let_id;
                $nestedData['let_no_out'] = $rows->data[$i]->let_no_out;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $nestedData['type_name'] = $rows->data[$i]->type_name;
                $nestedData['updated_at'] = $updated_at;

                    $menu_access = '';
                    if ($access) {
                        if ($access->menu_acc_edit == '1') {
                            $menu_access .= '
                        <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->let_id . '" onclick="get_modal(this)">
                            <i class="fa fa-pencil-square-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                        }
    
                        if ($access->menu_acc_del == '1') {
                            $menu_access .= '
    
                        <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->let_id . '" onclick="get_modal(this)">
                            <i class="fa fa-trash-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                        }
                    }


                    $nestedData['action'] = $menu_access;
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

    public function add(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Add Letter Request';
        $data['subtitle'] = 'List Letter Request';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["mem_name", "ASC"],
            "fields" => ["mem_id", "mem_name"],
            "where" => ["mem_active", "Y"],
            "table" => "_member",
        ];
        $data['employee'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        $param = [
            "order" => ["type_name", "ASC"],
            "fields" => ["let_code", "type_name"],
            "where" => ["let_code", "<>", "05"],
            "table" => "_letter_type",
        ];
        $data['letter_type'] = json_decode(ElaHelper::myCurl('master-global', $param));

        return view('HRIS.administration.letterRequest.add', $data);

    }

    public function doAdd(Request $request)
    {
        $member = $request->post('member') != null ? $request->post('member') : "";
        $customer = $request->post('customer') != null ? $request->post('customer') : "";
        $date = $request->post('date') != null ? $request->post('date') : "";
        $type = $request->post('type') != null ? $request->post('type') : "";
        $remark = $request->post('remark') != null ? $request->post('remark') : "";

        if ($date != "") {
            $date = $date;
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d', strtotime($date));
        } else {
            $date = "";
        }

        $value = ['member' => strip_tags($member),
            'customer' => strip_tags($customer),
            'date' => strip_tags($date),
            'type' => strip_tags($type),
            'remark' => strip_tags($remark),
        ];

        $urlMenu = 'hris/letter-request/do-add';
        $param = [
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function edit(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Edit Letter Request';
        $data['subtitle'] = 'List Letter Request';

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];
        $data['letter_request'] = json_decode(ElaHelper::myCurl('hris/letter-request/get-letter', $param));
        return view('HRIS.administration.letterRequest.edit', $data);

    }

    public function doEdit(Request $request)
    {
        $remark = $request->post('remark') != null ? $request->post('remark') : "";
        $id = $request->post('id') != null ? $request->post('id') : "";

        $value = [
            'note' => strip_tags($remark),
            'let_id' => $id,
        ];

        $urlMenu = 'hris/letter-request/do-edit';
        $param = [
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doDelete(Request $request)
    {
        $id = $request->get('id') != null ? $request->get('id') : "";

        $urlMenu = 'hris/letter-request/do-delete';
        $param = [
            "id_hris" => session('id_hris'),
            "id" => $id,
            "username" => session('username'),
            "token" => session('token'),
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

}
