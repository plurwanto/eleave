<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class userHRIS extends Controller
{
    public $menuID = 6;

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
        $link = ['user',
            'division'];
        $select = '';
        $select .= '<select style="width:150px; margin-right:10px" class="form-control border-rounded pull-left"  border-rounded" onchange="javascript:handleSelect(this)">';
        $select2 = '';
        for ($i = 0; $i < count($link); $i++) {
            if ($i == 0) {
                $select2 .= '<option value="' . env('APP_URL') . '/hris/customer">' . $link[$i] . '</option>';
            } else {
                if ($request->get('link') == $link[$i]) {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/customer?link=' . $link[$i] . '" selected>' . $link[$i] . '</option>';
                } else {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/customer?link=' . $link[$i] . '">' . $link[$i] . '</option>';
                }
            }

        }
        $select .= $select2;
        $select .= '</select><input type="hidden" id="link" value="' . $request->get('link') . '">';

        $data['select'] = $select;

        $data['title'] = 'User HRIS';
        $data['subtitle'] = 'List User HRIS';
        $urlMenu = 'master-global';
        $param = [
            "order" => ["div_name", "ASC"],
            "fields" => ["div_id", "div_name"],
            "table" => "_mdivision",
        ];
        $data['division'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        return view('HRIS.master.userHRIS.index', $data);
    }

    public function listData(Request $request)
    {
        $draw = $request->post('draw');

        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/hris-user';

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
            "search_email" => $request['columns'][1]['search']['value'],
            "search_branch" => $request['columns'][2]['search']['value'],
            "search_position" => $request['columns'][3]['search']['value'],
            "search_isactive" => $request['columns'][4]['search']['value'],
            "search_rec_pos" => $request['columns'][5]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $user_active = $rows->data[$i]->user_active == 'Y' ? "<label class='btn btn-success btn-xs'>Active</label>" : "<label class='btn btn-danger btn-xs'>No Active</label>";

                $nestedData['no'] = $a++;
                $nestedData['user_id'] = $rows->data[$i]->user_id;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $nestedData['br_name'] = $rows->data[$i]->br_name;
                $nestedData['active'] = $user_active;
                $nestedData['div_name'] = $rows->data[$i]->div_name;
                $nestedData['recruitment_position'] = $rows->data[$i]->recruitment_position;
                $nestedData['email'] = $rows->data[$i]->email;
                $nestedData['created_at'] = $rows->data[$i]->username;
                $nestedData['updated_at'] = $rows->data[$i]->username;

                $menu_access = '';
                if ($access) {
                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->user_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>
                                        <li>
                                            <a dataaction="useraccess" dataid="' . $rows->data[$i]->user_id . '" onclick="get_modal(this)">
                                            <i class="icon-tag"></i> User Access </a>
                                        </li>';
                    }
                    if ($access->menu_acc_del == '1') {
                        $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->user_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                    }
                }
                $nestedData['action'] = '<div class="btn-group">
                        <button class="btn dark btn-outline btn-circle btn-xs border-rounded" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                        <li>
                            <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->user_id . '" onclick="get_modal(this)">
                            <i class="fa fa-search-plus"></i> Detail </a>
                        </li>
                        ' . $menu_access . '
                        </ul>
                    </div>';
                $members[] = $nestedData;
            }

            $data = array(
                'draw' => $draw,
                'recordsTotal' => $rows->paging->total,
                'recordsFiltered' => $rows->paging->total,
                'data' => $members,
            );

        } else {
            $data = array(
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => $members,
            );
        }
        echo json_encode($data);
    }

    public function add()
    {
        $data['title'] = 'Add User HRIS';
        $data['subtitle'] = 'List User HRIS';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["div_name", "ASC"],
            "fields" => ["div_id", "div_name"],
            "table" => "_mdivision",
        ];
        $data['division'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["region_name", "ASC"],
            "fields" => ["region_id", "region_name"],
            "table" => "_sales_region",
        ];
        $data['region'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "order" => ["cus_name", "ASC"],
            "fields" => ["cus_id", "cus_name"],
            "where" => ["cus_req", 0],
            "where2" => ["cus_active", "Y"],
            "table" => "_mcustomer",
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        return view('HRIS.master.userHRIS.add', $data);
    }

    public function doAdd(Request $request)
    {

        $nama = $request->post('nama');
        $username = $request->post('email');
        $email = $request->post('email');
        $branch = $request->post('branch');
        $division = '';
        for ($i = 0; $i < count($request->post('division')); $i++) {
            $division .= $request->post('division')[$i] . ',';
        }
        $division = substr($division, 0, -1);

        $accessAssign = '';
        if ($request->post('accessAssign') != '') {
            for ($i = 0; $i < count($request->post('accessAssign')); $i++) {
                $accessAssign .= $request->post('accessAssign')[$i] . ',';
            }
            $accessAssign = substr($accessAssign, 0, -1);
        }
        $salesAccess = $request->post('salesAccess');

        $region = $request->post('region');
        $recruitment_position = $request->post('recruitment_position');
        $customer = $request->post('customer');
        $urlMenu = 'hris/hris-user/do-add';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "username" => $username,
            "nama" => $nama,
            "email" => $email,
            "branch" => $branch,
            "division" => $division,
            "region" => $region,
            "recruitment_position" => $recruitment_position,
            "customer" => $customer,
            "accessAssign" => $accessAssign,
            "salesAccess" => $salesAccess,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function edit(Request $request)
    {
        $data['title'] = 'Edit User HRIS';
        $data['subtitle'] = 'List User HRIS';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["div_name", "ASC"],
            "fields" => ["div_id", "div_name"],
            "table" => "_mdivision",
        ];
        $data['division'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["region_name", "ASC"],
            "fields" => ["region_id", "region_name"],
            "table" => "_sales_region",
        ];
        $data['region'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "order" => ["cus_name", "ASC"],
            "fields" => ["cus_id", "cus_name"],
            "where" => ["cus_req", 0],
            "where2" => ["cus_active", "Y"],
            "table" => "_mcustomer",
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $urlMenu = 'hris/get-profile-hris';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => $request->get('id'),
        ];
        $data['profile'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => $request->get('id'),
        ];

        $data['customeraccess'] = json_decode(ElaHelper::myCurl('hris/get-access-customer-hris', $param));
        return view('HRIS.master.userHRIS.edit', $data);
    }

    public function doEdit(Request $request)
    {

        $active = $request->post('active');
        $user_id = $request->post('user_id');
        $nama = $request->post('nama');
        $username = $request->post('email');
        $email = $request->post('email');
        $branch = $request->post('branch');
        $division = '';
        for ($i = 0; $i < count($request->post('division')); $i++) {
            $division .= $request->post('division')[$i] . ',';
        }
        $division = substr($division, 0, -1);

        $accessAssign = '';
        if ($request->post('accessAssign') != '') {
            for ($i = 0; $i < count($request->post('accessAssign')); $i++) {
                $accessAssign .= $request->post('accessAssign')[$i] . ',';
            }
            $accessAssign = substr($accessAssign, 0, -1);
        }
        $salesAccess = $request->post('salesAccess');

        $region = $request->post('region');
        $recruitment_position = $request->post('recruitment_position');
        $customer = $request->post('customer');
        $kam = $request->post('kam');

        $urlMenu = 'hris/hris-user/do-edit';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "user_access" => $user_id,
            "username" => $username,
            "nama" => $nama,
            "email" => $email,
            "branch" => $branch,
            "division" => $division,
            "region" => $region,
            "recruitment_position" => $recruitment_position,
            "customer" => $customer,
            "kam" => $kam,
            "accessAssign" => $accessAssign,
            "salesAccess" => $salesAccess,
            "active" => $active,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function detail(Request $request)
    {
        $data['title'] = 'Detail User HRIS';
        $data['subtitle'] = 'List User HRIS';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["div_name", "ASC"],
            "fields" => ["div_id", "div_name"],
            "table" => "_mdivision",
        ];
        $data['division'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["region_name", "ASC"],
            "fields" => ["region_id", "region_name"],
            "table" => "_sales_region",
        ];
        $data['region'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "order" => ["cus_name", "ASC"],
            "fields" => ["cus_id", "cus_name"],
            "where" => ["cus_id", "!=", 0],
            "table" => "_mcustomer",
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $urlMenu = 'hris/get-profile-hris';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => $request->get('id'),
        ];
        $data['profile'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $urlMenu = 'hris/get-access-customer-hris';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => $request->get('id'),
        ];

        $data['customeraccess'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        return view('HRIS.master.userHRIS.detail', $data);
    }

    public function userAccess(Request $request)
    {

        $data['title'] = 'User Access HRIS';
        $data['subtitle'] = 'List Menu HRIS';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => $request->get('id'),
        ];
        $data['menu'] = json_decode(ElaHelper::myCurl('hris/get-menu-employee', $param));

        return view('HRIS.master.userHRIS.access', $data);
    }

    public function doAccess(Request $request)
    {
        $user_id = $request->post('user_id');
        $count = $request->post('count');

        $menu = [];

        for ($i = 1; $i <= $count; $i++) {
            $menu[] = [
                "menu_id" => $request->post('menu_id' . $i),
                "menu_acc_view" => $request->post('menu_acc_view' . $i),
                "menu_acc_add" => $request->post('menu_acc_add' . $i),
                "menu_acc_edit" => $request->post('menu_acc_edit' . $i),
                "menu_acc_del" => $request->post('menu_acc_del' . $i),
                "menu_acc_approve" => $request->post('menu_acc_approve' . $i),
            ];
        }
        $urlMenu = 'hris/hris-user/do-user-access';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "user_access" => $user_id,
            "email" => $request->post('email'),
            "nama" => $request->post('nama'),
            "menu" => $menu,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doDelete(Request $request)
    {

        $user_id = $request->post('id');
        $urlMenu = 'hris/hris-user/do-delete';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "user_access" => $user_id,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function checkExisting(Request $request)
    {

        $email = $request->post('email');

        $urlMenu = 'hris/hris-user/check-existing';
        $param = [
            "field" => 'email',
            "value" => $email,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->response == true) {
            $response = false;
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

    public function checkExistingEdit(Request $request)
    {

        $email = $request->post('email');
        $user_id = $request->post('user_id');

        $urlMenu = 'hris/hris-user/check-existing-edit';
        $param = [
            "user_id" => $user_id,
            "field" => 'email',
            "value" => $email,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->response == true) {
            $response = false;
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

}
