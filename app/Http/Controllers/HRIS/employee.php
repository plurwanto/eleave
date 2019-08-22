<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class employee extends Controller
{
    public $menuID = 39;

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
        $link = ['all',
            'active',
            'not-active',
            'resign',
            'not-valid',
            'contract-will-end-soon',
            'passport-will-end-soon',
            'from-recruitment'];

        $name_link = ['All',
            'Active',
            'No Active',
            'Resign',
            'No Valid',
            'Contract will end soon',
            'Passport will end soon',
            'From Recuitment'];
        $select = '';
        $select .= '<select style="width:150px; margin-right:10px" class="form-control border-rounded pull-left"  border-rounded" onchange="javascript:handleSelect(this)">';
        $select2 = '';
        for ($i = 0; $i < count($link); $i++) {
            if ($i == 0) {
                $select2 .= '<option value="' . env('APP_URL') . '/hris/employee/others">' . $name_link[$i] . '</option>';
            } else {
                if ($request->get('link') == $link[$i]) {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/employee/others?link=' . $link[$i] . '" selected>' . $name_link[$i] . '</option>';
                } else {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/employee/others?link=' . $link[$i] . '">' . $name_link[$i] . '</option>';
                }
            }

        }
        $select .= $select2;
        $select .= '</select><input type="hidden" id="link" value="' . $request->get('link') . '">';

        $data['select'] = $select;
        $data['title'] = 'Employee';

        $urlMenu = 'master-global';

        $param = [
            "order" => ["nama", "ASC"],
            "fields" => ["br_id", "nama"],
            "where" => ["user_id", session('id_hris')],
            "table" => "_muser",
        ];
        $profile = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "order" => ["cus_name", "ASC"],
            "fields" => ["cus_id", "cus_name"],
            "where" => ["br_id", $profile->result[0]->br_id],
            "table" => "_mcustomer",
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        if ($request->get('link')) {
            switch ($request->get('link')) {
                case 'active':
                    $data['subtitle'] = 'List Employee Active';
                    return view('HRIS.employee.others.indexActive', $data);
                    break;
                case 'not-active':
                    $data['subtitle'] = 'List Employee No Active';
                    return view('HRIS.employee.others.indexNoActive', $data);
                    break;
                case 'resign':
                    $data['subtitle'] = 'List Employee Resign';
                    return view('HRIS.employee.others.indexResign', $data);
                    break;
                case 'not-valid':
                    $data['subtitle'] = 'List Employee Not Valid';
                    return view('HRIS.employee.others.indexNoValid', $data);
                    break;
                case 'contract-will-end-soon':
                    $data['subtitle'] = 'List Employee Contract Will End Soon';
                    return view('HRIS.employee.others.indexContEnd', $data);
                    break;
                case 'passport-will-end-soon':
                    $data['subtitle'] = 'List Employee Passport Will End Soon';
                    return view('HRIS.employee.others.indexPassportEnd', $data);
                    break;
                case 'from-recruitment':
                    $data['subtitle'] = 'List Employee From Recruitment';
                    return view('HRIS.employee.others.indexRecruitment', $data);
                    break;
                case 'rule-template':
                    $data['subtitle'] = 'Rules Temlplate Upload Member';
                    $urlMenu = 'master-global';
                    $param = [
                        "order" => ["mem_marital_id", "ASC"],
                        "fields" => ["mem_marital_id", "mem_marital_name"],
                        "table" => "_member_marital",
                    ];
                    $data['marital'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    $param = [
                        "order" => ["religi_id", "ASC"],
                        "fields" => ["religi_id", "religi_name"],
                        "table" => "_mreligion",
                    ];
                    $data['religion'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    $param = [
                        "order" => ["nat_id", "ASC"],
                        "fields" => ["nat_id", "nat_name"],
                        "table" => "_mnationality",
                    ];
                    $data['nationality'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    $param = [
                        "order" => ["insr_id", "ASC"],
                        "fields" => ["insr_id", "insr_name"],
                        "table" => "_minsurance",
                    ];
                    $data['insurance'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    $param = [
                        "order" => ["tr_id", "ASC"],
                        "fields" => ["tr_id", "tr_name"],
                        "table" => "_mtax_remark",
                    ];
                    $data['tax_remark'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    $param = [
                        "order" => ["bank_id", "ASC"],
                        "fields" => ["bank_id", "bank_name"],
                        "table" => "_mbank",
                    ];
                    $data['bank'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    $param = [
                        "id_hris" => session('id_hris'),
                    ];
                    $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));
                    return view('HRIS.employee.others.rule', $data);
                    break;
                case 'log-error':

                    $data['subtitle'] = 'Log Error Upload Member';
                    $param = [
                        "id" => $request->get('id'),
                    ];

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

                    return view('HRIS.employee.others.log', $data);
                    break;
                case 'search':
                    if ($request->has('keyword')) {
                        $data['keyword'] = $request->get('keyword');
                        $data['subtitle'] = 'Search Employee';
                        return view('HRIS.employee.others.search', $data);
                    } else {
                        echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index";
                </script>';
                    }
                    break;
                default;
                    $data['subtitle'] = 'List Employee';
                    return view('HRIS.employee.others.index', $data);
            }
        } else {
            $data['subtitle'] = 'List Employee';
            return view('HRIS.employee.others.index', $data);
        }
    }

    public function listData(Request $request)
    {
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/employee';

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
            "search_citizenship" => $request['columns'][3]['search']['value'],
            "search_form" => $request['columns'][4]['search']['value'],
            "search_customer" => $request['columns'][5]['search']['value'],
            "search_user" => $request['columns'][6]['search']['value'],
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $mem_active = $rows->data[$i]->mem_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $cus_name = $rows->data[$i]->cus_name != '' ? '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . "</a>" : '';
                $nestedData['recruitment_flag'] = $rows->data[$i]->recruitment_flag;
                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $recruitment_flag = $rows->data[$i]->recruitment_flag == '1' ? "<br><br><label class='label label-sm border-rounded  label-primary pull-right'>Rec</label>" : "";
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>' . $recruitment_flag;
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = $cus_name;
                $nestedData['mem_active'] = $mem_active;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['mem_resign_date'] = $rows->data[$i]->mem_resign_date;

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->menu_acc_del == '1') {
                    $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->recruitment_position == 'SUPER') {
                    $menu_access .= '

                    <a dataaction="type" title="type" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-flag-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                // if ($access->menu_acc_add == '1') {
                //     $menu_access .= '
                //     <a title="add contract" href="'. env('APP_URL').'/hris/employee/others/contract?employee_id='. md5($rows->data[$i]->mem_id) .'" target="blank">
                //         <i class="fa fa-file-o" style="
                //         font-size: 18px;
                //         width: 18px;
                //         height: 18px;
                //         margin-right: 3px;"></i>
                //     </a>';
                // }

                $nestedData['action'] = $menu_access;
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

    public function listDataActive(Request $request)
    {
        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/employee';

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
            "search_citizenship" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][4]['search']['value'],
            "search_isactive" => 'Y',
            "search_user" => $request['columns'][6]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $mem_active = $rows->data[$i]->mem_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $cus_name = $rows->data[$i]->cus_name != '' ? '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . "</a>" : '';

                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = $cus_name;
                $nestedData['mem_active'] = $mem_active;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['mem_resign_date'] = $rows->data[$i]->mem_resign_date;

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                }
                if ($access->menu_acc_del == '1') {
                    $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                }

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->menu_acc_del == '1') {
                    $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                $nestedData['action'] = $menu_access;
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

    public function listDataNoValid(Request $request)
    {
        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/employee/no-valid';

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
            "search_citizenship" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][4]['search']['value'],
            "search_isactive" => $request['columns'][5]['search']['value'],
            "search_user" => $request['columns'][6]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $mem_active = $rows->data[$i]->mem_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $cus_name = $rows->data[$i]->cus_name != '' ? '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . "</a>" : '';

                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = $cus_name;
                $nestedData['mem_active'] = $mem_active;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['mem_resign_date'] = $rows->data[$i]->mem_resign_date;

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                }
                if ($access->menu_acc_del == '1') {
                    $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                }

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->menu_acc_del == '1') {
                    $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                $nestedData['action'] = $menu_access;
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

    public function listDataNoActive(Request $request)
    {
        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/employee';

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
            "search_citizenship" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][4]['search']['value'],
            "search_isactive" => 'N',
            "search_user" => $request['columns'][6]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $mem_active = $rows->data[$i]->mem_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $cus_name = $rows->data[$i]->cus_name != '' ? '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . "</a>" : '';

                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = $cus_name;
                $nestedData['mem_active'] = $mem_active;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['mem_resign_date'] = $rows->data[$i]->mem_resign_date;

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                }
                if ($access->menu_acc_del == '1') {
                    $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                }

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->menu_acc_del == '1') {
                    $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                $nestedData['action'] = $menu_access;
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

    public function listDataResign(Request $request)
    {
        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/employee/resign';

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
            "search_citizenship" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][4]['search']['value'],
            "search_isactive" => $request['columns'][5]['search']['value'],
            "search_user" => $request['columns'][6]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $mem_active = $rows->data[$i]->mem_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $cus_name = $rows->data[$i]->cus_name != '' ? '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . "</a>" : '';

                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = $cus_name;
                $nestedData['mem_active'] = $mem_active;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['cont_resign_date'] = $rows->data[$i]->cont_resign_date;
                $nestedData['cont_resign_status'] = $rows->data[$i]->cont_resign_status;

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                }
                if ($access->menu_acc_del == '1') {
                    $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                }

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->menu_acc_del == '1') {
                    $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                $nestedData['action'] = $menu_access;
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

    public function listDataContractEnd(Request $request)
    {

        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/employee/contract-end';

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
            "search_citizenship" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][4]['search']['value'],
            "search_isactive" => $request['columns'][5]['search']['value'],
            "search_user" => $request['columns'][7]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $mem_active = $rows->data[$i]->mem_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $cus_name = $rows->data[$i]->cus_name != '' ? '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . "</a>" : '';

                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = $cus_name;
                $nestedData['mem_active'] = $mem_active;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['mem_resign_date'] = $rows->data[$i]->mem_resign_date;
                $nestedData['cont_end_date'] = date('d-M-Y', strtotime($rows->data[$i]->cont_end_date));
                $rows->data[$i]->cont_end_date;
                $nestedData['int_cont_end_date'] = $rows->data[$i]->int_cont_end_date;

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                }
                if ($access->menu_acc_del == '1') {
                    $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                }

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->menu_acc_del == '1') {
                    $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                $nestedData['action'] = $menu_access;
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

    public function listDataPassportEnd(Request $request)
    {

        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/employee/passport-end';

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
            "search_citizenship" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][4]['search']['value'],
            "search_isactive" => $request['columns'][5]['search']['value'],
            "search_user" => $request['columns'][7]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $cus_name = $rows->data[$i]->cus_name != '' ? '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . "</a>" : '';

                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = $cus_name;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['mem_resign_date'] = $rows->data[$i]->mem_resign_date;
                $nestedData['mem_exp_passport'] = date('d-M-Y', strtotime($rows->data[$i]->mem_exp_passport));
                $rows->data[$i]->mem_exp_passport;
                $nestedData['int_mem_exp_passport'] = $rows->data[$i]->int_mem_exp_passport;

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                }
                if ($access->menu_acc_del == '1') {
                    $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                }

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->menu_acc_del == '1') {
                    $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                $nestedData['action'] = $menu_access;
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

    public function listDataRecruitment(Request $request)
    {
        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/employee';

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
            "search_citizenship" => $request['columns'][3]['search']['value'],
            "search_customer" => $request['columns'][4]['search']['value'],
            "search_isactive" => 'Y',
            "search_user" => $request['columns'][6]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $mem_active = $rows->data[$i]->mem_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $cus_name = $rows->data[$i]->cus_name != '' ? '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . "</a>" : '';

                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = $cus_name;
                $nestedData['mem_active'] = $mem_active;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;
                $nestedData['mem_resign_date'] = $rows->data[$i]->mem_resign_date;

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                }
                if ($access->menu_acc_del == '1') {
                    $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                }

                $menu_access = '';
                if ($access->menu_acc_edit == '1') {
                    $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                if ($access->menu_acc_del == '1') {
                    $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }

                $nestedData['action'] = $menu_access;
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

    public function add(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Add Employee';
        $data['subtitle'] = 'List Employee';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["mem_marital_name", "ASC"],
            "fields" => ["mem_marital_id", "mem_marital_name"],
            "table" => "_member_marital",
        ];
        $data['marital'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["religi_name", "ASC"],
            "fields" => ["religi_id", "religi_name"],
            "table" => "_mreligion",
        ];
        $data['religion'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["nat_name", "ASC"],
            "fields" => ["nat_id", "nat_name"],
            "table" => "_mnationality",
        ];
        $data['nationality'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["insr_name", "ASC"],
            "fields" => ["insr_id", "insr_name"],
            "table" => "_minsurance",
        ];
        $data['insurance'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["tr_name", "ASC"],
            "fields" => ["tr_id", "tr_name"],
            "table" => "_mtax_remark",
        ];
        $data['tax_remark'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["bank_name", "ASC"],
            "fields" => ["bank_id", "bank_name"],
            "table" => "_mbank",
        ];
        $data['bank'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));

        switch ($getBranchId->response) {
            case 3:
                return view('HRIS.employee.others.addMal', $data);
                break;
            case 4:
                return view('HRIS.employee.others.addPhi', $data);
                break;
            case 5:
                return view('HRIS.employee.others.addTha', $data);
                break;
            default:
                return view('HRIS.employee.others.addInd', $data);
        }
    }

    public function doAdd(Request $request)
    {
        if ($request->post('dob') != "" && $request->post('dob') != null) {
            $dob = $request->post('dob');
            $dob = str_replace('/', '-', $dob);
            $dob = date('Y-m-d', strtotime($dob));
        } else {
            $dob = "";
        }

    

        if ($request->post('resign_date') != "" && $request->post('resign_date') != null) {
            $resign_date = $request->post('resign_date');
            $resign_date = str_replace('/', '-', $resign_date);
            $resign_date = date('Y-m-d', strtotime($resign_date));
        } else {
            $resign_date = "";
        }

        if ($request->post('passport_date') != "" && $request->post('passport_date') != null) {
            $passport_date = $request->post('passport_date');
            $passport_date = str_replace('/', '-', $passport_date);
            $passport_date = date('Y-m-d', strtotime($passport_date));
        } else {
            $passport_date = "";
        }

        if ($request->post('dob_spouse') != "" && $request->post('dob_spouse') != null) {
            $dob_spouse = $request->post('dob_spouse');
            $dob_spouse = str_replace('/', '-', $dob_spouse);
            $dob_spouse = date('Y-m-d', strtotime($dob_spouse));
        } else {
            $dob_spouse = "";
        }

        if ($request->post('dob_child1') != "" && $request->post('dob_child1') != null) {
            $dob_child1 = $request->post('dob_child1');
            $dob_child1 = str_replace('/', '-', $dob_child1);
            $dob_child1 = date('Y-m-d', strtotime($dob_child1));
        } else {
            $dob_child1 = "";
        }

        if ($request->post('dob_child2') != "" && $request->post('dob_child2') != null) {
            $dob_child2 = $request->post('dob_child2');
            $dob_child2 = str_replace('/', '-', $dob_child2);
            $dob_child2 = date('Y-m-d', strtotime($dob_child2));
        } else {
            $dob_child2 = "";
        }

        if ($request->post('dob_child3') != "" && $request->post('dob_child3') != null) {
            $dob_child3 = $request->post('dob_child3');
            $dob_child3 = str_replace('/', '-', $dob_child3);
            $dob_child3 = date('Y-m-d', strtotime($dob_child3));
        } else {
            $dob_child3 = "";
        }

        $name = $request->post('name') != null ? $request->post('name') : "";
        $alias_name = $request->post('alias_name') != null ? $request->post('alias_name') : "";
        $gender = $request->post('gender') != null ? $request->post('gender') : "";
        $pob = $request->post('pob') != null ? $request->post('pob') : "";
        $marital = $request->post('marital') != null ? $request->post('marital') : "";
        $religion = $request->post('religion') != null ? $request->post('religion') : "";
        $mobile1 = $request->post('mobile1') != null ? $request->post('mobile1') : "";
        // $mobile2 = $request->post('mobile2') != NULL ? $request->post('mobile2'):"";
        // $phone = $request->post('phone') != NULL ? $request->post('phone'):"";
        $address = $request->post('address') != null ? $request->post('address') : "";
        $email1 = $request->post('email1') != null ? $request->post('email1') : "";
        // $email2 = $request->post('email2') != NULL ? $request->post('email2'):"";
        $citizenship = $request->post('citizenship') != null ? $request->post('citizenship') : "";
        $id_card = $request->post('id_card') != null ? $request->post('id_card') : "";
        $passport = $request->post('passport') != null ? $request->post('passport') : "";
        $education = $request->post('education') != null ? $request->post('education') : "";
        $nationality = $request->post('nationality') != null ? $request->post('nationality') : "";
        $mail_address = $request->post('mail_address') != null ? $request->post('mail_address') : "";
        $insurance = $request->post('insurance') != null ? $request->post('insurance') : "";
        $tax_remark = $request->post('tax_remark') != null ? $request->post('tax_remark') : "";
        $tax_number = $request->post('tax_number') != null ? $request->post('tax_number') : "";
        $tax_address = $request->post('tax_address') != null ? $request->post('tax_address') : "";
        $name_bank1 = $request->post('name_bank1') != null ? $request->post('name_bank1') : "";
        $ac_bank1 = $request->post('ac_bank1') != null ? $request->post('ac_bank1') : "";
        $an_bank1 = $request->post('an_bank1') != null ? $request->post('an_bank1') : "";

        $name_bank2 = $request->post('name_bank2') != null ? $request->post('name_bank2') : "";
        $ac_bank2 = $request->post('ac_bank2') != null ? $request->post('ac_bank2') : "";
        $an_bank2 = $request->post('an_bank2') != null ? $request->post('an_bank2') : "";
        $swift = $request->post('swift') != null ? $request->post('swift') : "";

        $name_spouse = $request->post('name_spouse') != null ? $request->post('name_spouse') : "";
        $gender_spouse = $request->post('gender_spouse') != null ? $request->post('gender_spouse') : "";
        $name_child1 = $request->post('name_child1') != null ? $request->post('name_child1') : "";
        $gender_child1 = $request->post('gender_child1') != null ? $request->post('gender_child1') : "";
        $name_child2 = $request->post('name_child2') != null ? $request->post('name_child2') : "";
        $gender_child2 = $request->post('gender_child2') != null ? $request->post('gender_child2') : "";
        $name_child3 = $request->post('name_child3') != null ? $request->post('name_child3') : "";
        $gender_child3 = $request->post('gender_child3') != null ? $request->post('gender_child3') : "";

        //unik dari indonesia
        $bpjs_ket = $request->post('bpjs_ket') != null ? $request->post('bpjs_ket') : "";
        $bpjs_kes = $request->post('bpjs_kes') != null ? $request->post('bpjs_kes') : "";
        $bpjs_pen = $request->post('bpjs_pen') != null ? $request->post('bpjs_pen') : "";

        //unik dari phiiphin
        $tin = $request->post('tin') != null ? $request->post('tin') : "";
        $phic = $request->post('phic') != null ? $request->post('phic') : "";
        $sss = $request->post('sss') != null ? $request->post('sss') : "";
        $hdmf = $request->post('hdmf') != null ? $request->post('hdmf') : "";
        $user_level = $request->post('user_level') != null ? $request->post('user_level') : "";

        //unik dari thailand
        $tha_name = $request->post('tha_name') != null ? $request->post('tha_name') : "";
        $tha_address = $request->post('tha_address') != null ? $request->post('tha_address') : "";
        $homebase = $request->post('homebase') != null ? $request->post('homebase') : "";
        $form_type = $request->post('form_type') != null ? $request->post('form_type') : "";

        // if ($request->hasFile('file')) {
        //     $file = $request->file('file')->getClientOriginalName();
        //     $fileName = date('YmdHis') . str_random(5) . $file;
        //     $destinationPath = base_path('public/hris/files/employee/');
        //     if (!file_exists($destinationPath)) {
        //         mkdir($destinationPath, 0777, true);
        //     }
        //     $request->file('file')->move($destinationPath, $fileName);
        //     $file = $fileName;
        // }else{
        //     $file = "";

        // }

        $param = [
            "token" => session('token'),
        ];
        $nip = json_decode(ElaHelper::myCurl('hris/employee/get-nip', $param));

        $value = ['mem_name' => strip_tags($name),
            'mem_alias' => strip_tags($alias_name),
            'mem_gender' => strip_tags($gender),
            'mem_dob_city' => strip_tags($pob),
            'mem_dob' => strip_tags($dob),
            'mem_marital_id' => strip_tags($marital),
            'religi_id' => strip_tags($religion),
            'mem_mobile' => strip_tags($mobile1),
            // 'mem_mobile2'=>strip_tags($mobile2),
            // 'mem_phone'=>strip_tags($phone),
            'mem_address' => strip_tags($address),
            'mem_email' => strip_tags($email1),
            // 'mem_email2'=>strip_tags($email2),
            'mem_citizenship' => strip_tags($citizenship),
            'mem_ktp_no' => strip_tags($id_card),
            'mem_passport' => strip_tags($passport),
            'mem_exp_passport' => strip_tags($passport_date),
            'insr_deduction' => strip_tags($education),
            'mem_nationality' => strip_tags($nationality),
            'mem_resign_date' => strip_tags($resign_date),
            // 'file'=>strip_tags($file),
            'mem_mail_address' => strip_tags($mail_address),
            'insr_id' => strip_tags($insurance),
            'tr_id' => strip_tags($tax_remark),
            'mem_npwp_no' => strip_tags($tax_number),
            'mem_npwp_address' => strip_tags($tax_address),
            'mem_bank_name' => strip_tags($name_bank1),
            'mem_bank_ac' => strip_tags($ac_bank1),
            'mem_bank_an' => strip_tags($an_bank1),
            'mem_bank_name2' => strip_tags($name_bank2),
            'mem_bank_ac2' => strip_tags($ac_bank2),
            'mem_bank_an2' => strip_tags($an_bank2),
            'swift_no' => strip_tags($swift),
            'mem_spouse_name' => strip_tags($name_spouse),
            'mem_spouse_dob' => strip_tags($dob_spouse),
            'mem_spouse_gender' => strip_tags($gender_spouse),
            'mem_child1_name' => strip_tags($name_child1),
            'mem_child1_dob' => strip_tags($dob_child1),
            'mem_child1_gender' => strip_tags($gender_child1),
            'mem_child2_name' => strip_tags($name_child2),
            'mem_child2_dob' => strip_tags($dob_child2),
            'mem_child2_gender' => strip_tags($gender_child2),
            'mem_child3_name' => strip_tags($name_child3),
            'mem_child3_dob' => strip_tags($dob_child3),
            'mem_child3_gender' => strip_tags($gender_child3),
            'mem_jamsostek' => strip_tags($bpjs_ket),
            'mem_bpjs_kes' => strip_tags($bpjs_kes),
            'mem_bpjs_pen' => strip_tags($bpjs_pen),
            'mem_tin_no' => strip_tags($tin),
            'mem_phic_no' => strip_tags($phic),
            'mem_sss_no' => strip_tags($sss),
            'mem_hdmf_no' => strip_tags($hdmf),
            'mem_security_level' => strip_tags($user_level),
            'mem_name_tha' => strip_tags($tha_name),
            'mem_address_tha' => strip_tags($tha_address),
            'homebase' => strip_tags($homebase),
            'form_type' => strip_tags($form_type),
            'mem_nip' => strip_tags($nip->nip),
        ];

        $urlMenu = 'hris/employee/do-add';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "name" => session('name'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function upload(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Upload Employee';
        $data['subtitle'] = 'List Employee';

        return view('HRIS.employee.others.upload', $data);

    }

    public function edit(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Edit Employee';
        $data['subtitle'] = 'List Employee';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["mem_marital_name", "ASC"],
            "fields" => ["mem_marital_id", "mem_marital_name"],
            "table" => "_member_marital",
        ];
        $data['marital'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["religi_name", "ASC"],
            "fields" => ["religi_id", "religi_name"],
            "table" => "_mreligion",
        ];
        $data['religion'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["nat_name", "ASC"],
            "fields" => ["nat_id", "nat_name"],
            "table" => "_mnationality",
        ];
        $data['nationality'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["insr_name", "ASC"],
            "fields" => ["insr_id", "insr_name"],
            "table" => "_minsurance",
        ];
        $data['insurance'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["tr_name", "ASC"],
            "fields" => ["tr_id", "tr_name"],
            "table" => "_mtax_remark",
        ];
        $data['tax_remark'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["bank_name", "ASC"],
            "fields" => ["bank_id", "bank_name"],
            "table" => "_mbank",
        ];
        $data['bank'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];
        $employee = json_decode(ElaHelper::myCurl('hris/employee/get-employee', $param));
        $data['employee'] = $employee;
        switch ($employee->employee->form_type) {
            case 5:
                return view('HRIS.employee.others.editMal', $data);
                break;
            case 2:
                return view('HRIS.employee.others.editPhi', $data);
                break;
            case 4:
                return view('HRIS.employee.others.editTha', $data);
                break;
            default:
                return view('HRIS.employee.others.editInd', $data);
        }
    }

    public function formType(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Edit Type Employee';
        $data['subtitle'] = 'List Employee';
        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];
        $employee = json_decode(ElaHelper::myCurl('hris/employee/get-employee', $param));
        $data['employee'] = $employee;
        return view('HRIS.employee.others.formType', $data);

    }

    public function doEdit(Request $request)
    {
        if ($request->post('dob') != "" && $request->post('dob') != null) {
            $dob = $request->post('dob');
            $dob = str_replace('/', '-', $dob);
            $dob = date('Y-m-d', strtotime($dob));
        } else {
            $dob = "";
        }

        if ($request->post('resign_date') != "" && $request->post('resign_date') != null) {
            $resign_date = $request->post('resign_date');
            $resign_date = str_replace('/', '-', $resign_date);
            $resign_date = date('Y-m-d', strtotime($resign_date));
        } else {
            $resign_date = "";
        }

        if ($request->post('passport_date') != "" && $request->post('passport_date') != null) {
            $passport_date = $request->post('passport_date');
            $passport_date = str_replace('/', '-', $passport_date);
            $passport_date = date('Y-m-d', strtotime($passport_date));
        } else {
            $passport_date = "";
        }

        if ($request->post('dob_spouse') != "" && $request->post('dob_spouse') != null) {
            $dob_spouse = $request->post('dob_spouse');
            $dob_spouse = str_replace('/', '-', $dob_spouse);
            $dob_spouse = date('Y-m-d', strtotime($dob_spouse));
        } else {
            $dob_spouse = "";
        }

        if ($request->post('dob_child1') != "" && $request->post('dob_child1') != null) {
            $dob_child1 = $request->post('dob_child1');
            $dob_child1 = str_replace('/', '-', $dob_child1);
            $dob_child1 = date('Y-m-d', strtotime($dob_child1));
        } else {
            $dob_child1 = "";
        }

        if ($request->post('dob_child2') != "" && $request->post('dob_child2') != null) {
            $dob_child2 = $request->post('dob_child2');
            $dob_child2 = str_replace('/', '-', $dob_child2);
            $dob_child2 = date('Y-m-d', strtotime($dob_child2));
        } else {
            $dob_child2 = "";
        }

        if ($request->post('dob_child3') != "" && $request->post('dob_child3') != null) {
            $dob_child3 = $request->post('dob_child3');
            $dob_child3 = str_replace('/', '-', $dob_child3);
            $dob_child3 = date('Y-m-d', strtotime($dob_child3));
        } else {
            $dob_child3 = "";
        }

        $active = $request->post('active') != null ? $request->post('active') : "";
        $name = $request->post('name') != null ? $request->post('name') : "";
        $alias_name = $request->post('alias_name') != null ? $request->post('alias_name') : "";
        $gender = $request->post('gender') != null ? $request->post('gender') : "";
        $pob = $request->post('pob') != null ? $request->post('pob') : "";
        $marital = $request->post('marital') != null ? $request->post('marital') : "";
        $religion = $request->post('religion') != null ? $request->post('religion') : "";
        $mobile1 = $request->post('mobile1') != null ? $request->post('mobile1') : "";
        // $mobile2 = $request->post('mobile2') != NULL ? $request->post('mobile2'):"";
        // $phone = $request->post('phone') != NULL ? $request->post('phone'):"";
        $address = $request->post('address') != null ? $request->post('address') : "";
        $email1 = $request->post('email1') != null ? $request->post('email1') : "";
        // $email2 = $request->post('email2') != NULL ? $request->post('email2'):"";
        $citizenship = $request->post('citizenship') != null ? $request->post('citizenship') : "";
        $id_card = $request->post('id_card') != null ? $request->post('id_card') : "";
        $passport = $request->post('passport') != null ? $request->post('passport') : "";
        $education = $request->post('education') != null ? $request->post('education') : "";
        $nationality = $request->post('nationality') != null ? $request->post('nationality') : "";
        $mail_address = $request->post('mail_address') != null ? $request->post('mail_address') : "";
        $insurance = $request->post('insurance') != null ? $request->post('insurance') : "";
        $tax_remark = $request->post('tax_remark') != null ? $request->post('tax_remark') : "";
        $tax_number = $request->post('tax_number') != null ? $request->post('tax_number') : "";
        $tax_address = $request->post('tax_address') != null ? $request->post('tax_address') : "";
        $name_bank1 = $request->post('name_bank1') != null ? $request->post('name_bank1') : "";
        $ac_bank1 = $request->post('ac_bank1') != null ? $request->post('ac_bank1') : "";
        $an_bank1 = $request->post('an_bank1') != null ? $request->post('an_bank1') : "";
        $name_bank2 = $request->post('name_bank2') != null ? $request->post('name_bank2') : "";
        $ac_bank2 = $request->post('ac_bank2') != null ? $request->post('ac_bank2') : "";
        $an_bank2 = $request->post('an_bank2') != null ? $request->post('an_bank2') : "";
        $swift = $request->post('swift') != null ? $request->post('swift') : "";

        $name_spouse = $request->post('name_spouse') != null ? $request->post('name_spouse') : "";
        $gender_spouse = $request->post('gender_spouse') != null ? $request->post('gender_spouse') : "";
        $name_child1 = $request->post('name_child1') != null ? $request->post('name_child1') : "";
        $gender_child1 = $request->post('gender_child1') != null ? $request->post('gender_child1') : "";
        $name_child2 = $request->post('name_child2') != null ? $request->post('name_child2') : "";
        $gender_child2 = $request->post('gender_child2') != null ? $request->post('gender_child2') : "";
        $name_child3 = $request->post('name_child3') != null ? $request->post('name_child3') : "";
        $gender_child3 = $request->post('gender_child3') != null ? $request->post('gender_child3') : "";

        //unik dari indonesia
        $bpjs_ket = $request->post('bpjs_ket') != null ? $request->post('bpjs_ket') : "";
        $bpjs_kes = $request->post('bpjs_kes') != null ? $request->post('bpjs_kes') : "";
        $bpjs_pen = $request->post('bpjs_pen') != null ? $request->post('bpjs_pen') : "";

        //unik dari phiiphin
        $tin = $request->post('tin') != null ? $request->post('tin') : "";
        $phic = $request->post('phic') != null ? $request->post('phic') : "";
        $sss = $request->post('sss') != null ? $request->post('sss') : "";
        $hdmf = $request->post('hdmf') != null ? $request->post('hdmf') : "";
        $user_level = $request->post('user_level') != null ? $request->post('user_level') : "";

        //unik dari thailand
        $tha_name = $request->post('tha_name') != null ? $request->post('tha_name') : "";
        $tha_address = $request->post('tha_address') != null ? $request->post('tha_address') : "";
        $homebase = $request->post('homebase') != null ? $request->post('homebase') : "";

        $form_type = $request->post('form_type') != null ? $request->post('form_type') : "";
        $mem_id = $request->post('mem_id') != null ? $request->post('mem_id') : "";
        // if ($request->hasFile('file')) {

        //     $file = $request->file('file')->getClientOriginalName();
        //     $fileName = date('YmdHis') . str_random(5) . $file;
        //     $destinationPath = base_path('public/hris/files/employee/');
        //     if (!file_exists($destinationPath)) {
        //         mkdir($destinationPath, 0777, true);
        //     }
        //     $request->file('file')->move($destinationPath, $fileName);
        //     $file = $fileName;
        // }else{
        //     $file = $request->post('old_image');
        // }

        $value = ['mem_name' => strip_tags($name),
            'mem_alias' => strip_tags($alias_name),
            'mem_gender' => strip_tags($gender),
            'mem_dob_city' => strip_tags($pob),
            'mem_dob' => strip_tags($dob),
            'mem_marital_id' => strip_tags($marital),
            'religi_id' => strip_tags($religion),
            'mem_mobile' => strip_tags($mobile1),
            // 'mem_mobile2'=>strip_tags($mobile2),
            // 'mem_phone'=>strip_tags($phone),
            'mem_address' => strip_tags($address),
            'mem_email' => strip_tags($email1),
            // 'mem_email2'=>strip_tags($email2),
            'mem_citizenship' => strip_tags($citizenship),
            'mem_ktp_no' => strip_tags($id_card),
            'mem_passport' => strip_tags($passport),
            'mem_exp_passport' => strip_tags($passport_date),
            'insr_deduction' => strip_tags($education),
            'mem_nationality' => strip_tags($nationality),
            'mem_resign_date' => strip_tags($resign_date),
            // 'file'=>strip_tags($file),
            'mem_mail_address' => strip_tags($mail_address),
            'insr_id' => strip_tags($insurance),
            'tr_id' => strip_tags($tax_remark),
            'mem_npwp_no' => strip_tags($tax_number),
            'mem_npwp_address' => strip_tags($tax_address),
            'mem_bank_name' => strip_tags($name_bank1),
            'mem_bank_ac' => strip_tags($ac_bank1),
            'mem_bank_an' => strip_tags($an_bank1),
            'mem_bank_name2' => strip_tags($name_bank2),
            'mem_bank_ac2' => strip_tags($ac_bank2),
            'mem_bank_an2' => strip_tags($an_bank2),
            'swift_no' => strip_tags($swift),
            'mem_spouse_name' => strip_tags($name_spouse),
            'mem_spouse_dob' => strip_tags($dob_spouse),
            'mem_spouse_gender' => strip_tags($gender_spouse),
            'mem_child1_name' => strip_tags($name_child1),
            'mem_child1_dob' => strip_tags($dob_child1),
            'mem_child1_gender' => strip_tags($gender_child1),
            'mem_child2_name' => strip_tags($name_child2),
            'mem_child2_dob' => strip_tags($dob_child2),
            'mem_child2_gender' => strip_tags($gender_child2),
            'mem_child3_name' => strip_tags($name_child3),
            'mem_child3_dob' => strip_tags($dob_child3),
            'mem_child3_gender' => strip_tags($gender_child3),
            'mem_jamsostek' => strip_tags($bpjs_ket),
            'mem_bpjs_kes' => strip_tags($bpjs_kes),
            'mem_bpjs_pen' => strip_tags($bpjs_pen),
            'mem_tin_no' => strip_tags($tin),
            'mem_phic_no' => strip_tags($phic),
            'mem_sss_no' => strip_tags($sss),
            'mem_hdmf_no' => strip_tags($hdmf),
            'mem_security_level' => strip_tags($user_level),
            'mem_name_tha' => strip_tags($tha_name),
            'mem_address_tha' => strip_tags($tha_address),
            'homebase' => strip_tags($homebase),
            'form_type' => strip_tags($form_type),
            'mem_id' => strip_tags($mem_id),
            'mem_active' => strip_tags($active),
        ];

        $urlMenu = 'hris/employee/do-edit';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "name" => session('name'),
            "value" => $value,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doEditType(Request $request)
    {

        $form_type = $request->post('form_type') != null ? $request->post('form_type') : "";
        $mem_id = $request->post('mem_id') != null ? $request->post('mem_id') : "";

        $value = [
            'form_type' => $form_type,
            'mem_id' => $mem_id,
        ];

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "name" => session('name'),
            "value" => $value,
        ];
        $rows = json_decode(ElaHelper::myCurl('hris/employee/do-edit-type', $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function detail(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Detail Employee';
        $data['subtitle'] = 'List Employee';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["mem_marital_name", "ASC"],
            "fields" => ["mem_marital_id", "mem_marital_name"],
            "table" => "_member_marital",
        ];
        $data['marital'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["religi_name", "ASC"],
            "fields" => ["religi_id", "religi_name"],
            "table" => "_mreligion",
        ];
        $data['religion'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["nat_name", "ASC"],
            "fields" => ["nat_id", "nat_name"],
            "table" => "_mnationality",
        ];
        $data['nationality'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["insr_name", "ASC"],
            "fields" => ["insr_id", "insr_name"],
            "table" => "_minsurance",
        ];
        $data['insurance'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["tr_name", "ASC"],
            "fields" => ["tr_id", "tr_name"],
            "table" => "_mtax_remark",
        ];
        $data['tax_remark'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["bank_name", "ASC"],
            "fields" => ["bank_id", "bank_name"],
            "table" => "_mbank",
        ];
        $data['bank'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $employee = json_decode(ElaHelper::myCurl('hris/employee/get-employee', $param));
        $data['employee'] = $employee;
        switch ($employee->employee->form_type) {
            case 5:
                return view('HRIS.employee.others.detailMal', $data);
                break;
            case 2:
                return view('HRIS.employee.others.detailPhi', $data);
                break;
            case 4:
                return view('HRIS.employee.others.detailTha', $data);
                break;
            default:
                return view('HRIS.employee.others.detailInd', $data);
        }
    }

    public function userAccess(Request $request)
    {
        $data['title'] = 'User Access HRIS';
        $data['subtitle'] = 'List Menu HRIS';

        $urlMenu = 'hris/get-menu';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => $request->get('id'),
        ];
        $data['menu'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        return view('HRIS.employee.others.access', $data);
    }

    public function doAccess(Request $request)
    {

        $mem_id = $request->post('mem_id');
        $menu_id = $request->post('menu_id');
        $menu = [];

        for ($i = 0; $i < count($menu_id); $i++) {
            $menu[] = [
                "menu_id" => $menu_id[$i],
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
            "user_access" => $mem_id,
            "menu" => $menu,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doDelete(Request $request)
    {

        $mem_id = $request->post('id');
        $urlMenu = 'hris/employee/do-delete';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "mem_id" => $mem_id,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function checkEmailExisting(Request $request)
    {
        $email = $request->post('email1');
        if (strpos(strtolower($email), '@elabram.com') === false) {
            $urlMenu = 'hris/employee/check-existing';
            $param = [
                "field" => 'mem_email',
                "value" => $email,
            ];
            $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
            if ($rows->response == true) {
                $response = false;
            } else {
                $response = true;
            }
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

    public function checkEmailExistingEdit(Request $request)
    {

        $email1 = $request->post('email1');
        $mem_id = $request->post('mem_id');
        if (strpos(strtolower($email1), '@elabram.com') === false) {

            $urlMenu = 'hris/employee/check-existing-edit';
            $param = [
                "mem_id" => $mem_id,
                "field" => 'mem_email',
                "value" => $email1,
            ];
            $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
            if ($rows->response == true) {
                $response = false;
            } else {
                $response = true;
            }
        } else {
            $response = true;
        }
        echo json_encode($response);
    }
    public function checkBankExisting(Request $request)
    {

        if ($request->has('ac_bank1')) {
            $bank = $request->post('ac_bank1');

        } else {
            $bank = $request->post('ac_bank2');

        }

        if ($bank == 0) {
            $response = true;
        } else {
            $urlMenu = 'hris/employee/check-existing';
            $param = [
                "field" => 'mem_bank_ac',
                "value" => $bank,
            ];
            $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
            if ($rows->response == true) {
                $response = false;
            } else {
                $response = true;
            }
        }

        echo json_encode($response);
    }

    public function checkBankExistingEdit(Request $request)
    {
        if ($request->has('ac_bank1')) {
            $bank = $request->post('ac_bank1');

        } else {
            $bank = $request->post('ac_bank2');

        }

        if ($bank == 0) {
            $response = true;
        } else {

            $mem_id = $request->post('mem_id');

            $urlMenu = 'hris/employee/check-existing-edit';
            $param = [
                "mem_id" => $mem_id,
                "field" => 'mem_bank_ac',
                "value" => $bank,
            ];
            $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
            if ($rows->response == true) {
                $response = false;
            } else {
                $response = true;
            }

        }

        echo json_encode($response);
    }

    public function exportExcelExample(Request $request)
    {

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));
        switch ($getBranchId->response) {
            case 1: //indo
                return redirect(env('PUBLIC_PATH') . 'hris/files/employee/template_input_employee_indonesia.xlsx');
                break;
            case 5: //thailand
                return redirect(env('PUBLIC_PATH') . 'hris/files/employee/template_input_employee_thailand.xlsx');

                break;
            case 4: //phil
                return redirect(env('PUBLIC_PATH') . 'hris/files/employee/template_input_employee_philippines.xlsx');

                break;
            default;
                return redirect(env('PUBLIC_PATH') . 'hris/files/employee/template_input_employee_malaysia.xlsx');

        }

    }

    public function exportExcelExample2(Request $request)
    {
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));
        switch ($getBranchId->response) {
            case 1: //indo
                $name = 'template_employee_indonesia';
                break;
            case 4: //phil
                $name = 'template_employee_philippines';
                break;
            case 5: //tha
                $name = 'template_employee_thailand';
                break;
            default; //mal
                $name = 'template_employee_malaysia';
        }
        return Excel::create($name, function ($excel) {
            $excel->sheet('Employee HRIS', function ($sheet) {
                $sheet->cell('A1', function ($cell) {$cell->setValue('No');});

                $sheet->cell('B1', function ($cell) {$cell->setValue('Name');});
                $sheet->cell('B1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('C1', function ($cell) {$cell->setValue('alias Name');});

                $sheet->cell('D1', function ($cell) {$cell->setValue('Gender');});
                $sheet->cell('D1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('E1', function ($cell) {$cell->setValue('Join Date (dd/mm/yyyy)');});
                $sheet->cell('E1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('F1', function ($cell) {$cell->setValue('Place of Birth');});
                $sheet->cell('G1', function ($cell) {$cell->setValue('Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('G1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('H1', function ($cell) {$cell->setValue('Marital Status');});
                $sheet->cell('H1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('I1', function ($cell) {$cell->setValue('Religion');});
                $sheet->cell('I1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('J1', function ($cell) {$cell->setValue('Address');});
                $sheet->cell('J1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('K1', function ($cell) {$cell->setValue('Mobile 1');});
                $sheet->cell('K1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('L1', function ($cell) {$cell->setValue('Email');});
                $sheet->cell('L1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('M1', function ($cell) {$cell->setValue('ID Card');});
                $sheet->cell('M1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('N1', function ($cell) {$cell->setValue('Nationality');});
                $sheet->cell('N1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('O1', function ($cell) {$cell->setValue('Passport');});
                $sheet->cell('O1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('P1', function ($cell) {$cell->setValue('Date of End Passport (dd/mm/yyyy)');});
                $sheet->cell('P1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('Q1', function ($cell) {$cell->setValue('Last education');});

                $sheet->cell('R1', function ($cell) {$cell->setValue('Bank1 Id');});
                $sheet->cell('R1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('S1', function ($cell) {$cell->setValue('Bank1 Account');});
                $sheet->cell('S1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('T1', function ($cell) {$cell->setValue('Bank1 Account Name');});
                $sheet->cell('T1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('U1', function ($cell) {$cell->setValue('Spouse Name');});
                $sheet->cell('V1', function ($cell) {$cell->setValue('Spouse Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('W1', function ($cell) {$cell->setValue('Spouse Gender');});
                $sheet->cell('X1', function ($cell) {$cell->setValue('Child1 Name');});
                $sheet->cell('Y1', function ($cell) {$cell->setValue('Child1 Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('Z1', function ($cell) {$cell->setValue('Child1 Gender');});
                $sheet->cell('AA1', function ($cell) {$cell->setValue('Child2 Name');});
                $sheet->cell('AB1', function ($cell) {$cell->setValue('Child2 Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('AC1', function ($cell) {$cell->setValue('Child2 Gender');});
                $sheet->cell('AD1', function ($cell) {$cell->setValue('Child3 Name');});
                $sheet->cell('AE1', function ($cell) {$cell->setValue('Child3 Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('AF1', function ($cell) {$cell->setValue('Child3 Gender');});
                $sheet->cell('AG1', function ($cell) {$cell->setValue('Tax Remark');});
                $sheet->cell('AG1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('AH1', function ($cell) {$cell->setValue('Insurance');});
                $sheet->cell('AI1', function ($cell) {$cell->setValue('Citizenship');});
                $sheet->cell('AI1', function ($cell) {$cell->setBackground('#CCCCCC');});
                $sheet->cell('AJ1', function ($cell) {$cell->setValue('Tax Number (general)');});
                $sheet->cell('AK1', function ($cell) {$cell->setValue('Swift Code');});

                $param = [
                    "id_hris" => session('id_hris'),
                ];
                $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));
                switch ($getBranchId->response) {
                    case 1: //indo
                        $sheet->setBorder('A1:AM1');
                        $sheet->cell('AL1', function ($cell) {$cell->setValue('Jamsostek Number (KPJ)');});
                        $sheet->cell('AM1', function ($cell) {$cell->setValue('Virtual Account BPJS Kesehatan');});
                        $sheet->cell('AN1', function ($cell) {$cell->setValue('BPJS Jaminan Pensiun Number');});
                        break;
                    case 5: //thailand
                        $sheet->setBorder('A1:AM1');
                        $sheet->cell('AL1', function ($cell) {$cell->setValue('Name Thailand');});
                        $sheet->cell('AL1', function ($cell) {$cell->setBackground('#CCCCCC');});
                        $sheet->cell('AM1', function ($cell) {$cell->setValue('Address Thailand');});
                        $sheet->cell('AM1', function ($cell) {$cell->setBackground('#CCCCCC');});
                        $sheet->cell('AN1', function ($cell) {$cell->setValue('Homebase');});
                        $sheet->cell('AN1', function ($cell) {$cell->setBackground('#CCCCCC');});
                        break;
                    case 4: //phil
                        $sheet->setBorder('A1:AO1');
                        $sheet->cell('AL1', function ($cell) {$cell->setValue('TIN No');});
                        $sheet->cell('AL1', function ($cell) {$cell->setBackground('#CCCCCC');});

                        $sheet->cell('AM1', function ($cell) {$cell->setValue('PHIC No');});
                        $sheet->cell('AM1', function ($cell) {$cell->setBackground('#CCCCCC');});

                        $sheet->cell('AN1', function ($cell) {$cell->setValue('SSS No');});
                        $sheet->cell('AN1', function ($cell) {$cell->setBackground('#CCCCCC');});

                        $sheet->cell('AO1', function ($cell) {$cell->setValue('HDMF No');});
                        $sheet->cell('AO1', function ($cell) {$cell->setBackground('#CCCCCC');});

                        $sheet->cell('AP1', function ($cell) {$cell->setValue('User Level');});
                        $sheet->cell('AP1', function ($cell) {$cell->setBackground('#CCCCCC');});

                        break;
                    default;
                        $sheet->setBorder('A1:AK1');

                }

            });
        })->download('xls');
    }

    public function doUpload(Request $request)
    {

        if ($request->hasFile('file')) {
            try {
                $path = $request->file('file')->getRealPath();
                $filename = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
                $excelData = Excel::selectSheetsByIndex(0)->load($path)->get();

                $param = [
                    "id_hris" => session('id_hris'),
                ];
                $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));

                if ($excelData->count()) {
                    $arr = [];

                    foreach ($excelData as $key => $value) {

                        if ($value["name"] != "") {

                            
                            if ($value["date_of_birth_ddmmyyyy"] != "") {
                                $date_of_birth = $value["date_of_birth_ddmmyyyy"];
                                $date_of_birth = str_replace('/', '-', $date_of_birth);
                                $date_of_birth = date('Y-m-d', strtotime($date_of_birth));
                            } else {
                                $date_of_birth = "";
                            }

                            if ($value["date_of_end_passport_ddmmyyyy"] != "") {
                                $date_of_end_passport = $value["date_of_end_passport_ddmmyyyy"];
                                $date_of_end_passport = str_replace('/', '-', $date_of_end_passport);
                                $date_of_end_passport = date('Y-m-d', strtotime($date_of_end_passport));
                            } else {
                                $date_of_end_passport = "";
                            }

                            if ($value["spouse_date_of_birth_ddmmyyyy"] != "") {
                                $spouse_date_of_birth = $value["spouse_date_of_birth_ddmmyyyy"];
                                $spouse_date_of_birth = str_replace('/', '-', $spouse_date_of_birth);
                                $spouse_date_of_birth = date('Y-m-d', strtotime($spouse_date_of_birth));
                            } else {
                                $spouse_date_of_birth = "";
                            }

                            if ($value["child1_date_of_birth_ddmmyyyy"] != "") {
                                $child1_date_of_birth = $value["child1_date_of_birth_ddmmyyyy"];
                                $child1_date_of_birth = str_replace('/', '-', $child1_date_of_birth);
                                $child1_date_of_birth = date('Y-m-d', strtotime($child1_date_of_birth));
                            } else {
                                $child1_date_of_birth = "";
                            }

                            if ($value["child2_date_of_birth_ddmmyyyy"] != "") {
                                $child2_date_of_birth = $value["child2_date_of_birth_ddmmyyyy"];
                                $child2_date_of_birth = str_replace('/', '-', $child2_date_of_birth);
                                $child2_date_of_birth = date('Y-m-d', strtotime($child2_date_of_birth));
                            } else {
                                $child2_date_of_birth = "";
                            }

                            if ($value["child3_date_of_birth_ddmmyyyy"] != "") {
                                $child3_date_of_birth = $value["child3_date_of_birth_ddmmyyyy"];
                                $child3_date_of_birth = str_replace('/', '-', $child3_date_of_birth);
                                $child3_date_of_birth = date('Y-m-d', strtotime($child3_date_of_birth));
                            } else {
                                $child3_date_of_birth = "";
                            }

                            switch ($getBranchId->response) {
                                case '1': //indonesia

                                    $arr[] = [
                                        'name' => trim(strip_tags($value["name"])),
                                        'alias_name' => trim(strip_tags($value["alias_name"])),
                                        'gender' => trim(strip_tags($value["gender"])),
                                        'place_of_birth' => trim(strip_tags($value["place_of_birth"])),
                                        'date_of_birth' => strip_tags($date_of_birth),
                                        'marital_status' => trim(strip_tags($value["marital_status"])),
                                        'religion' => trim(strip_tags($value["religion"])),
                                        'address' => trim(strip_tags($value["address"])),
                                        'mobile_1' => trim(strip_tags($value["mobile_1"])),
                                        'email' => trim(strip_tags($value["email"])),
                                        'id_card' => trim(strip_tags($value["id_card"])),
                                        'nationality' => trim(strip_tags($value["nationality"])),
                                        'passport' => trim(strip_tags($value["passport"])),
                                        'date_of_end_passport' => strip_tags($date_of_end_passport),
                                        'last_education' => trim(strip_tags($value["last_education"])),
                                        'bank1_id' => trim(strip_tags($value["bank1_id"])),
                                        'bank1_account' => trim(strip_tags($value["bank1_account"])),
                                        'bank1_name' => trim(strip_tags($value["bank1_account_name"])),
                                        'spouse_name' => trim(strip_tags($value["spouse_name"])),
                                        'spouse_date_of_birth' => strip_tags($spouse_date_of_birth),
                                        'spouse_gender' => trim(strip_tags($value["spouse_gender"])),
                                        'child1_name' => trim(strip_tags($value["child1_name"])),
                                        'child1_date_of_birth' => strip_tags($child1_date_of_birth),
                                        'child1_gender' => trim(strip_tags($value["child1_gender"])),
                                        'child2_name' => trim(strip_tags($value["child2_name"])),
                                        'child2_date_of_birth' => strip_tags($child2_date_of_birth),
                                        'child2_gender' => trim(strip_tags($value["child2_gender"])),
                                        'child3_name' => trim(strip_tags($value["child3_name"])),
                                        'child3_date_of_birth' => strip_tags($child3_date_of_birth),
                                        'child3_gender' => trim(strip_tags($value["child3_gender"])),
                                        'tax_remark' => trim(strip_tags($value["tax_remark"])),
                                        'insurance' => trim(strip_tags($value["insurance"])),
                                        'citizenship' => trim(strip_tags($value["citizenship"])),
                                        'tax_number_general' => trim(strip_tags($value["tax_number_general"])),
                                        'swift_code' => trim(strip_tags($value["swift_code"])),
                                        'jamsostek_number_kpj' => trim(strip_tags($value["jamsostek_number_kpj"])),
                                        'virtual_account_bpjs_kesehatan' => trim(strip_tags($value["virtual_account_bpjs_kesehatan"])),
                                        'bpjs_jaminan_pensiun_number' => trim(strip_tags($value["bpjs_jaminan_pensiun_number"])),
                                    ];
                                    break;
                                case '4': //phi
                                    $arr[] = [
                                        'name' => trim(strip_tags($value["name"])),
                                        'alias_name' => trim(strip_tags($value["alias_name"])),
                                        'gender' => trim(strip_tags($value["gender"])),
                                        'place_of_birth' => trim(strip_tags($value["place_of_birth"])),
                                        'date_of_birth' => $date_of_birth,
                                        'marital_status' => trim(strip_tags($value["marital_status"])),
                                        'religion' => trim(strip_tags($value["religion"])),
                                        'address' => trim(strip_tags($value["address"])),
                                        'mobile_1' => trim(strip_tags($value["mobile_1"])),
                                        'email' => trim(strip_tags($value["email"])),
                                        'id_card' => trim(strip_tags($value["id_card"])),
                                        'nationality' => trim(strip_tags($value["nationality"])),
                                        'passport' => trim(strip_tags($value["passport"])),
                                        'date_of_end_passport' => $date_of_end_passport,
                                        'last_education' => trim(strip_tags($value["last_education"])),
                                        'bank1_id' => trim(strip_tags($value["bank1_id"])),
                                        'bank1_account' => trim(strip_tags($value["bank1_account"])),
                                        'bank1_name' => trim(strip_tags($value["bank1_account_name"])),
                                        'spouse_name' => trim(strip_tags($value["spouse_name"])),
                                        'spouse_date_of_birth' => $spouse_date_of_birth,
                                        'spouse_gender' => trim(strip_tags($value["spouse_gender"])),
                                        'child1_name' => trim(strip_tags($value["child1_name"])),
                                        'child1_date_of_birth' => $child1_date_of_birth,
                                        'child1_gender' => trim(strip_tags($value["child1_gender"])),
                                        'child2_name' => trim(strip_tags($value["child2_name"])),
                                        'child2_date_of_birth' => $child2_date_of_birth,
                                        'child2_gender' => trim(strip_tags($value["child2_gender"])),
                                        'child3_name' => trim(strip_tags($value["child3_name"])),
                                        'child3_date_of_birth' => $child3_date_of_birth,
                                        'child3_gender' => trim(strip_tags($value["child3_gender"])),
                                        'tax_remark' => trim(strip_tags($value["tax_remark"])),
                                        'insurance' => trim(strip_tags($value["insurance"])),
                                        'citizenship' => trim(strip_tags($value["citizenship"])),
                                        'tax_number_general' => trim(strip_tags($value["tax_number_general"])),
                                        'swift_code' => trim(strip_tags($value["swift_code"])),
                                        'tin' => trim(strip_tags($value["tin_no"])),
                                        'phic' => trim(strip_tags($value["phic_no"])),
                                        'sss' => trim(strip_tags($value["sss_no"])),
                                        'hdmf' => trim(strip_tags($value["hdmf_no"])),
                                        'user_level' => trim(strip_tags($value["user_level"])),

                                    ];
                                    break;
                                case '5': //tha
                                    $arr[] = [
                                        'name' => trim(strip_tags($value["name"])),
                                        'alias_name' => trim(strip_tags($value["alias_name"])),
                                        'gender' => trim(strip_tags($value["gender"])),
                                        'place_of_birth' => trim(strip_tags($value["place_of_birth"])),
                                        'date_of_birth' => $date_of_birth,
                                        'marital_status' => trim(strip_tags($value["marital_status"])),
                                        'religion' => trim(strip_tags($value["religion"])),
                                        'address' => trim(strip_tags($value["address"])),
                                        'mobile_1' => trim(strip_tags($value["mobile_1"])),
                                        'email' => trim(strip_tags($value["email"])),
                                        'id_card' => trim(strip_tags($value["id_card"])),
                                        'nationality' => trim(strip_tags($value["nationality"])),
                                        'passport' => trim(strip_tags($value["passport"])),
                                        'date_of_end_passport' => $date_of_end_passport,
                                        'last_education' => trim(strip_tags($value["last_education"])),
                                        'bank1_id' => trim(strip_tags($value["bank1_id"])),
                                        'bank1_account' => trim(strip_tags($value["bank1_account"])),
                                        'bank1_name' => trim(strip_tags($value["bank1_account_name"])),
                                        'spouse_name' => trim(strip_tags($value["spouse_name"])),
                                        'spouse_date_of_birth' => $spouse_date_of_birth,
                                        'spouse_gender' => trim(strip_tags($value["spouse_gender"])),
                                        'child1_name' => trim(strip_tags($value["child1_name"])),
                                        'child1_date_of_birth' => $child1_date_of_birth,
                                        'child1_gender' => trim(strip_tags($value["child1_gender"])),
                                        'child2_name' => trim(strip_tags($value["child2_name"])),
                                        'child2_date_of_birth' => $child2_date_of_birth,
                                        'child2_gender' => trim(strip_tags($value["child2_gender"])),
                                        'child3_name' => trim(strip_tags($value["child3_name"])),
                                        'child3_date_of_birth' => $child3_date_of_birth,
                                        'child3_gender' => trim(strip_tags($value["child3_gender"])),
                                        'tax_remark' => trim(strip_tags($value["tax_remark"])),
                                        'insurance' => trim(strip_tags($value["insurance"])),
                                        'citizenship' => trim(strip_tags($value["citizenship"])),
                                        'tax_number_general' => trim(strip_tags($value["tax_number_general"])),
                                        'swift_code' => trim(strip_tags($value["swift_code"])),
                                        'name_thailand' => trim(strip_tags($value["name_thailand"])),
                                        'address_thailand' => trim(strip_tags($value["address_thailand"])),
                                        'homebase' => trim(strip_tags($value["homebase"])),
                                    ];
                                    break;
                                default;
                                    $arr[] = [
                                        'name' => trim(strip_tags($value["name"])),
                                        'alias_name' => trim(strip_tags($value["alias_name"])),
                                        'gender' => trim(strip_tags($value["gender"])),
                                        'place_of_birth' => trim(strip_tags($value["place_of_birth"])),
                                        'date_of_birth' => $date_of_birth,
                                        'marital_status' => trim(strip_tags($value["marital_status"])),
                                        'religion' => trim(strip_tags($value["religion"])),
                                        'address' => trim(strip_tags($value["address"])),
                                        'mobile_1' => trim(strip_tags($value["mobile_1"])),
                                        'email' => trim(strip_tags($value["email"])),
                                        'id_card' => trim(strip_tags($value["id_card"])),
                                        'nationality' => trim(strip_tags($value["nationality"])),
                                        'passport' => trim(strip_tags($value["passport"])),
                                        'date_of_end_passport' => $date_of_end_passport,
                                        'last_education' => trim(strip_tags($value["last_education"])),
                                        'bank1_id' => trim(strip_tags($value["bank1_id"])),
                                        'bank1_account' => trim(strip_tags($value["bank1_account"])),
                                        'bank1_name' => trim(strip_tags($value["bank1_account_name"])),
                                        'spouse_name' => trim(strip_tags($value["spouse_name"])),
                                        'spouse_date_of_birth' => $spouse_date_of_birth,
                                        'spouse_gender' => trim(strip_tags($value["spouse_gender"])),
                                        'child1_name' => trim(strip_tags($value["child1_name"])),
                                        'child1_date_of_birth' => $child1_date_of_birth,
                                        'child1_gender' => trim(strip_tags($value["child1_gender"])),
                                        'child2_name' => trim(strip_tags($value["child2_name"])),
                                        'child2_date_of_birth' => $child2_date_of_birth,
                                        'child2_gender' => trim(strip_tags($value["child2_gender"])),
                                        'child3_name' => trim(strip_tags($value["child3_name"])),
                                        'child3_date_of_birth' => $child3_date_of_birth,
                                        'child3_gender' => trim(strip_tags($value["child3_gender"])),
                                        'tax_remark' => trim(strip_tags($value["tax_remark"])),
                                        'insurance' => trim(strip_tags($value["insurance"])),
                                        'citizenship' => trim(strip_tags($value["citizenship"])),
                                        'tax_number_general' => trim(strip_tags($value["tax_number_general"])),
                                        'swift_code' => trim(strip_tags($value["swift_code"])),
                                    ];
                            };

                        }
                    }

                    if (!empty($arr)) {
                        $dataDoc = array(
                            'member' => $arr,
                            'token' => session('token'),
                            'id_hris' => session('id_hris'),
                            'name' => session('name'),

                        );

                        switch ($getBranchId->response) {
                            case '1': //indonesia
                                $model = ElaHelper::myCurl('hris/employee/do-upload-ind', $dataDoc);
                                break;
                            case '4': //phi
                                $model = ElaHelper::myCurl('hris/employee/do-upload-phi', $dataDoc);
                                break;
                            case '5': //tha
                                $model = ElaHelper::myCurl('hris/employee/do-upload-tha', $dataDoc);
                                break;
                            default; //mal
                                $model = ElaHelper::myCurl('hris/employee/do-upload-mal', $dataDoc);
                        }
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
                            'msg' => 'There are no request data',
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
                    'msg' => 'Error!! ' . $e,
                    'response_code' => 500,
                    'wrong_id' => '',
                );
                return response()->json($data, 500);
            }
        } else {
            $data = array(
                'msg' => 'There are no request data',
                'response_code' => 500,
                'wrong_id' => '',
            );
            return response()->json($data, 200);
        }

    }

    public function listDataSearch(Request $request)
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
            "keyword" => $request->get('keyword'),

        ];

        $rows = json_decode(ElaHelper::myCurl('hris/employee/search', $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $mem_active = $rows->data[$i]->mem_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";

                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['id_number'] = $rows->data[$i]->id_number;
                $nestedData['cus_name'] = '<a target="blank" href="' . env('APP_URL') . '/hris/administration/contract?link=' . $rows->data[$i]->cus_id . '">' . $rows->data[$i]->cus_name . '</a>';
                $nestedData['mem_active'] = $mem_active;
                $nestedData['mem_citizenship'] = $rows->data[$i]->mem_citizenship;
                $nestedData['form_type'] = $rows->data[$i]->form_type;
                $nestedData['mem_user'] = $rows->data[$i]->mem_user;

                $menu_access = '';
                if ($access) {
                    $menu_access .= '
                    <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                                <i class="fa fa-search-plus" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                }
                $nestedData['action'] = $menu_access;
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

    public function exportExcel(Request $request)
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

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));
        switch ($getBranchId->response) {
            case 1: //indo
                $name = 'employee-ind';
                break;
            case 4: //phil
                $name = 'employee-phi';
                break;
            case 5: //tha
                $name = 'employee-tha';
                break;
            default; //mal
                $name = 'employee-mal';
        }
        $str = 'abcdefghijklmnopqrstuvwxyz01234567891011121314151617181920212223242526';
        $shuffled = substr(str_shuffle($str), 0, 3) . date('hi');
        $title = $name . '-' . $request->get('year') . '-' . $shuffled;

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet('employee all', function ($sheet) use ($request, $title) {
                $sheet->cell('A1', function ($cell) {$cell->setValue('No');});
                $sheet->cell('B1', function ($cell) {$cell->setValue('Name');});
                $sheet->cell('C1', function ($cell) {$cell->setValue('alias Name');});
                $sheet->cell('D1', function ($cell) {$cell->setValue('Gender');});
                $sheet->cell('E1', function ($cell) {$cell->setValue('Join Date (dd/mm/yyyy)');});
                $sheet->cell('F1', function ($cell) {$cell->setValue('Place of Birth');});
                $sheet->cell('G1', function ($cell) {$cell->setValue('Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('H1', function ($cell) {$cell->setValue('Marital Status');});
                $sheet->cell('I1', function ($cell) {$cell->setValue('Religion');});
                $sheet->cell('J1', function ($cell) {$cell->setValue('Address');});
                $sheet->cell('K1', function ($cell) {$cell->setValue('Mobile 1');});
                $sheet->cell('L1', function ($cell) {$cell->setValue('Email');});
                $sheet->cell('M1', function ($cell) {$cell->setValue('NIP');});
                $sheet->cell('N1', function ($cell) {$cell->setValue('ID Card');});
                $sheet->cell('O1', function ($cell) {$cell->setValue('Nationality');});
                $sheet->cell('P1', function ($cell) {$cell->setValue('Passport');});
                $sheet->cell('Q1', function ($cell) {$cell->setValue('Date of End Passport (dd/mm/yyyy)');});
                $sheet->cell('R1', function ($cell) {$cell->setValue('Last education');});
                $sheet->cell('S1', function ($cell) {$cell->setValue('Bank1 Id');});
                $sheet->cell('T1', function ($cell) {$cell->setValue('Bank1 Account');});
                $sheet->cell('U1', function ($cell) {$cell->setValue('Bank1 Account Name');});
                $sheet->cell('V1', function ($cell) {$cell->setValue('Spouse Name');});
                $sheet->cell('W1', function ($cell) {$cell->setValue('Spouse Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('X1', function ($cell) {$cell->setValue('Spouse Gender');});
                $sheet->cell('Y1', function ($cell) {$cell->setValue('Child1 Name');});
                $sheet->cell('Z1', function ($cell) {$cell->setValue('Child1 Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('AA1', function ($cell) {$cell->setValue('Child1 Gender');});
                $sheet->cell('AB1', function ($cell) {$cell->setValue('Child2 Name');});
                $sheet->cell('AC1', function ($cell) {$cell->setValue('Child2 Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('AD1', function ($cell) {$cell->setValue('Child2 Gender');});
                $sheet->cell('AE1', function ($cell) {$cell->setValue('Child3 Name');});
                $sheet->cell('AF1', function ($cell) {$cell->setValue('Child3 Date of Birth (dd/mm/yyyy)');});
                $sheet->cell('AG1', function ($cell) {$cell->setValue('Child3 Gender');});
                $sheet->cell('AH1', function ($cell) {$cell->setValue('Tax Remark');});
                $sheet->cell('AI1', function ($cell) {$cell->setValue('Insurance');});
                $sheet->cell('AJ1', function ($cell) {$cell->setValue('Citizenship');});
                $sheet->cell('AK1', function ($cell) {$cell->setValue('Tax Number (general)');});
                $sheet->cell('AL1', function ($cell) {$cell->setValue('Form Type');});
                $sheet->cell('AM1', function ($cell) {$cell->setValue('From Recruitment');});
                $param = [
                    "id_hris" => session('id_hris'),
                ];
                $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));
                switch ($getBranchId->response) {
                    case 1: //indo
                        $sheet->setBorder('A1:AT1');
                        $sheet->cell('AN1', function ($cell) {$cell->setValue('Jamsostek Number (KPJ)');});
                        $sheet->cell('AO1', function ($cell) {$cell->setValue('Virtual Account BPJS Kesehatan');});
                        $sheet->cell('AP1', function ($cell) {$cell->setValue('BPJS Jaminan Pensiun Number');});
                        $sheet->cell('AQ1', function ($cell) {$cell->setValue('Customer');});
                        $sheet->cell('AR1', function ($cell) {$cell->setValue('Resign Date');});
                        $sheet->cell('AS1', function ($cell) {$cell->setValue('Updated By');});
                        $sheet->cell('AT1', function ($cell) {$cell->setValue('Updated Date');});
                        break;
                    case 5: //thailand
                        $sheet->setBorder('A1:AT1');
                        $sheet->cell('AN1', function ($cell) {$cell->setValue('Name Thailand');});
                        $sheet->cell('AO1', function ($cell) {$cell->setValue('Address Thailand');});
                        $sheet->cell('AP1', function ($cell) {$cell->setValue('Homebase');});
                        $sheet->cell('AQ1', function ($cell) {$cell->setValue('Customer');});
                        $sheet->cell('AR1', function ($cell) {$cell->setValue('Resign Date');});
                        $sheet->cell('AS1', function ($cell) {$cell->setValue('Updated By');});
                        $sheet->cell('AT1', function ($cell) {$cell->setValue('Updated Date');});
                        break;
                    case 4: //phil
                        $sheet->setBorder('A1:AV1');
                        $sheet->cell('AN1', function ($cell) {$cell->setValue('TIN No');});
                        $sheet->cell('AO1', function ($cell) {$cell->setValue('PHIC No');});
                        $sheet->cell('AP1', function ($cell) {$cell->setValue('SSS No');});
                        $sheet->cell('AQ1', function ($cell) {$cell->setValue('HDMF No');});
                        $sheet->cell('AR1', function ($cell) {$cell->setValue('User Level');});
                        $sheet->cell('AS1', function ($cell) {$cell->setValue('Customer');});
                        $sheet->cell('AT1', function ($cell) {$cell->setValue('Resign Date');});
                        $sheet->cell('AU1', function ($cell) {$cell->setValue('Updated By');});
                        $sheet->cell('AV1', function ($cell) {$cell->setValue('Updated Date');});

                        break;
                    default;
                        $sheet->setBorder('A1:AQ1');
                        $sheet->cell('AN1', function ($cell) {$cell->setValue('Customer');});
                        $sheet->cell('AO1', function ($cell) {$cell->setValue('Resign Date');});
                        $sheet->cell('AP1', function ($cell) {$cell->setValue('Updated By');});
                        $sheet->cell('AQ1', function ($cell) {$cell->setValue('Updated Date');});

                }

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "year" => $request->get('year'),
                ];

                $member = json_decode(ElaHelper::myCurl('hris/employee/export-excel', $param));
                for ($a = 0; $a < count($member->employee); $a++) {

                    switch ($member->employee[$a]->form_type) {
                        case "1":
                            $type = "other";
                            break;
                        case "2":
                            $type = "philippines";
                            break;
                        case "3":
                            $type = "indonesia";
                            break;
                        case "4":
                            $type = "thailand";
                            break;
                        case "5":
                            $type = "malaysia";
                            break;
                        default:
                            $type = "";
                    }

                    $sheet->setCellValue('A' . $i, $no);
                    $sheet->setCellValue('B' . $i, $member->employee[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $member->employee[$a]->mem_alias);
                    $sheet->setCellValue('D' . $i, $member->employee[$a]->mem_gender);
                    $sheet->setCellValue('E' . $i, $member->employee[$a]->mem_join_date);
                    $sheet->setCellValue('F' . $i, $member->employee[$a]->mem_dob_city);
                    $sheet->setCellValue('G' . $i, $member->employee[$a]->mem_dob);
                    $sheet->setCellValue('H' . $i, $member->employee[$a]->mem_marital_name);
                    $sheet->setCellValue('I' . $i, $member->employee[$a]->religi_name);
                    $sheet->setCellValue('J' . $i, $member->employee[$a]->mem_address);
                    $sheet->setCellValueExplicit('K' . $i, $member->employee[$a]->mem_mobile);
                    $sheet->setCellValue('L' . $i, $member->employee[$a]->mem_email);
                    $sheet->setCellValueExplicit('M' . $i, $member->employee[$a]->mem_nip);
                    $sheet->setCellValueExplicit('N' . $i, $member->employee[$a]->mem_ktp_no);
                    $sheet->setCellValue('O' . $i, $member->employee[$a]->nat_name);
                    $sheet->setCellValueExplicit('P' . $i, $member->employee[$a]->mem_passport);
                    $sheet->setCellValue('Q' . $i, $member->employee[$a]->mem_exp_passport);
                    $sheet->setCellValue('R' . $i, $member->employee[$a]->mem_last_education);
                    $sheet->setCellValue('S' . $i, $member->employee[$a]->bank_name);
                    $sheet->setCellValueExplicit('T' . $i, $member->employee[$a]->mem_bank_ac);
                    $sheet->setCellValue('U' . $i, $member->employee[$a]->mem_bank_an);
                    $sheet->setCellValue('V' . $i, $member->employee[$a]->mem_spouse_name);
                    $sheet->setCellValue('W' . $i, $member->employee[$a]->mem_spouse_dob);
                    $sheet->setCellValue('X' . $i, $member->employee[$a]->mem_spouse_gender);
                    $sheet->setCellValue('Y' . $i, $member->employee[$a]->mem_child1_name);
                    $sheet->setCellValue('Z' . $i, $member->employee[$a]->mem_child1_dob);
                    $sheet->setCellValue('AA' . $i, $member->employee[$a]->mem_child1_gender);
                    $sheet->setCellValue('AB' . $i, $member->employee[$a]->mem_child2_name);
                    $sheet->setCellValue('AC' . $i, $member->employee[$a]->mem_child2_dob);
                    $sheet->setCellValue('AD' . $i, $member->employee[$a]->mem_child2_gender);
                    $sheet->setCellValue('AE' . $i, $member->employee[$a]->mem_child3_name);
                    $sheet->setCellValue('AF' . $i, $member->employee[$a]->mem_child3_dob);
                    $sheet->setCellValue('AG' . $i, $member->employee[$a]->mem_child3_gender);
                    $sheet->setCellValue('AH' . $i, $member->employee[$a]->tr_name);
                    $sheet->setCellValue('AI' . $i, $member->employee[$a]->insr_name);
                    $sheet->setCellValue('AJ' . $i, $member->employee[$a]->mem_citizenship);
                    $sheet->setCellValueExplicit('AK' . $i, $member->employee[$a]->mem_npwp_no);
                    $sheet->setCellValue('AL' . $i, $type);

                    if ($member->employee[$a]->recruitment_flag == 1) {
                        $rec = 'Yes';
                    } else {
                        $rec = 'No';
                    }
                    $sheet->setCellValue('AM' . $i, $rec);

                    switch ($getBranchId->response) {
                        case 1: //indo
                            $sheet->setCellValue('AN' . $i, $member->employee[$a]->mem_jamsostek);
                            $sheet->setCellValue('AO' . $i, $member->employee[$a]->mem_bpjs_kes);
                            $sheet->setCellValue('AP' . $i, $member->employee[$a]->mem_bpjs_pen);

                            $sheet->setCellValue('AQ' . $i, $member->employee[$a]->cus_name);
                            $sheet->setCellValue('AR' . $i, $member->employee[$a]->cont_resign_date);
                            $sheet->setCellValue('AS' . $i, $member->employee[$a]->mem_user);
                            $sheet->setCellValue('AT' . $i, $member->employee[$a]->updated_at);
                            break;
                        case 5: //thailand
                            $sheet->setCellValue('AN' . $i, $member->employee[$a]->mem_name_tha);
                            $sheet->setCellValue('AO' . $i, $member->employee[$a]->mem_address_tha);
                            $sheet->setCellValue('AP' . $i, $member->employee[$a]->homebase);

                            $sheet->setCellValue('AQ' . $i, $member->employee[$a]->cus_name);
                            $sheet->setCellValue('AR' . $i, $member->employee[$a]->cont_resign_date);
                            $sheet->setCellValue('AS' . $i, $member->employee[$a]->mem_user);
                            $sheet->setCellValue('AT' . $i, $member->employee[$a]->updated_at);
                            break;
                        case 4: //phil
                            $sheet->setCellValue('AN' . $i, $member->employee[$a]->mem_tin_no);
                            $sheet->setCellValue('AO' . $i, $member->employee[$a]->mem_phic_no);
                            $sheet->setCellValue('AP' . $i, $member->employee[$a]->mem_sss_no);
                            $sheet->setCellValue('AQ' . $i, $member->employee[$a]->mem_hdmf_no);
                            $sheet->setCellValue('AR' . $i, $member->employee[$a]->mem_security_level);

                            $sheet->setCellValue('AS' . $i, $member->employee[$a]->cus_name);
                            $sheet->setCellValue('AT' . $i, $member->employee[$a]->cont_resign_date);
                            $sheet->setCellValue('AU' . $i, $member->employee[$a]->mem_user);
                            $sheet->setCellValue('AV' . $i, $member->employee[$a]->updated_at);
                            break;
                        default;
                            $sheet->setCellValue('AN' . $i, $member->employee[$a]->cus_name);
                            $sheet->setCellValue('AO' . $i, $member->employee[$a]->cont_resign_date);
                            $sheet->setCellValue('AP' . $i, $member->employee[$a]->mem_user);
                            $sheet->setCellValue('AQ' . $i, $member->employee[$a]->updated_at);
                    }

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


    public function exportExcelEndSoon(Request $request)
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

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));
        switch ($getBranchId->response) {
            case 1: //indo
                $name = 'employee-ind';
                break;
            case 4: //phil
                $name = 'employee-phi';
                break;
            case 5: //tha
                $name = 'employee-tha';
                break;
            default; //mal
                $name = 'employee-mal';
        }
        $str = 'abcdefghijklmnopqrstuvwxyz01234567891011121314151617181920212223242526';
        $shuffled = substr(str_shuffle($str), 0, 3) . date('hi');
        $title = $name . '-' . $request->get('year') . '-' . $shuffled;

        Excel::create($title, function ($excel) use ($request, $title) {


            $excel->sheet('contract end soon', function ($sheet) use ($request, $title) {
                $sheet->cell('A1', function ($cell) {$cell->setValue('No');});
                $sheet->cell('B1', function ($cell) {$cell->setValue('Name');});
                $sheet->cell('C1', function ($cell) {$cell->setValue('NIP');});
                $sheet->cell('D1', function ($cell) {$cell->setValue('ID Number');});
                $sheet->cell('E1', function ($cell) {$cell->setValue('Citizenship');});
                $sheet->cell('F1', function ($cell) {$cell->setValue('Form Type');});
                $sheet->cell('G1', function ($cell) {$cell->setValue('Customer');});
                $sheet->cell('H1', function ($cell) {$cell->setValue('Contract End Soon');});
                $sheet->cell('I1', function ($cell) {$cell->setValue('Interval End Date');});
                $sheet->cell('J1', function ($cell) {$cell->setValue('Updated By');});

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];

                $member = json_decode(ElaHelper::myCurl('hris/employee/export-excel-endsoon', $param));
                for ($a = 0; $a < count($member->employee); $a++) {

                    $sheet->setCellValue('A' . $i, $no);
                    $sheet->setCellValue('B' . $i, $member->employee[$a]->mem_name);
                    $sheet->setCellValue('C' . $i, $member->employee[$a]->mem_nip);
                    $sheet->setCellValue('D' . $i, $member->employee[$a]->id_number);
                    $sheet->setCellValue('E' . $i, $member->employee[$a]->mem_citizenship);
                    $sheet->setCellValue('F' . $i, $member->employee[$a]->form_type);
                    $sheet->setCellValue('G' . $i, $member->employee[$a]->cus_name);
                    $sheet->setCellValue('H' . $i, date('d-M-Y', strtotime($member->employee[$a]->cont_end_date)));
                    $sheet->setCellValue('I' . $i, $member->employee[$a]->int_cont_end_date);
                    $sheet->setCellValue('J' . $i, $member->employee[$a]->mem_user);

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

    public function checkKtp(Request $request)
    {

        $ktp = $request->post('id_card');

        $urlMenu = 'hris/employee/check-existing';
        $param = [
            "field" => 'mem_ktp_no',
            "value" => $ktp,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->response == true) {
            $response = false;
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

    public function checkKtpEdit(Request $request)
    {

        $ktp = $request->post('id_card');
        $mem_id = $request->post('mem_id');

        $urlMenu = 'hris/employee/check-existing-edit';
        $param = [
            "mem_id" => $mem_id,
            "field" => 'mem_ktp_no',
            "value" => $ktp,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->response == true) {
            $response = false;
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

    public function checkPassport(Request $request)
    {

        $passport = $request->post('passport');

        $urlMenu = 'hris/employee/check-existing';
        $param = [
            "field" => 'mem_passport',
            "value" => $passport,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->response == true) {
            $response = false;
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

    public function checkPassportEdit(Request $request)
    {

        $passport = $request->post('passport');
        $mem_id = $request->post('mem_id');

        $urlMenu = 'hris/employee/check-existing-edit';
        $param = [
            "mem_id" => $mem_id,
            "field" => 'mem_passport',
            "value" => $passport,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->response == true) {
            $response = false;
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

    public function checkSwift(Request $request)
    {

        $swift = $request->post('swift');

        $urlMenu = 'hris/employee/check-existing';
        $param = [
            "field" => 'swift_no',
            "value" => $swift,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->response == true) {
            $response = false;
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

    public function checkSwiftEdit(Request $request)
    {

        $swift = $request->post('swift');
        $mem_id = $request->post('mem_id');

        $urlMenu = 'hris/employee/check-existing-edit';
        $param = [
            "mem_id" => $mem_id,
            "field" => 'swift_no',
            "value" => $swift,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->response == true) {
            $response = false;
        } else {
            $response = true;
        }
        echo json_encode($response);
    }

    public function addContract(Request $request)
    {

        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index"
                </script>';
        }

        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $param = [
            "order" => ["cus_name", "ASC"],
            "fields" => ["cus_id", "cus_name"],
            "where" => ["cus_id", $request->get('link')],
            "table" => "_mcustomer",
        ];
        $cus = json_decode(ElaHelper::myCurl('master-global', $param));

        $data['link'] = $request->get('link');
        $data['title'] = 'Member';

        $data['subtitle'] = 'Create Contract';
        $param = [
            "id" => $request->get('employee_id'),
        ];
        $employee = json_decode(ElaHelper::myCurl('hris/contract/get-employee', $param));
        if ($employee->result) {
            $name = $employee->result->mem_name;
            $data['employee_id'] = $employee->result->mem_id;
        } else {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index"
                </script>';
        }
        $data['subtitle3'] = 'Add';
        $data['subtitle4'] = $name;
        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "table" => "_contract_status",
        ];
        $data['contract_status'] = json_decode(ElaHelper::myCurl('master-global', $param));
        $param = [
            "order" => ["cont_city_name", "ASC"],
            "fields" => ["cont_city_id", "cont_city_name"],
            "where" => ["cus_id", "=", "0"],
            "where2" => ["cont_city_active", "=", "Y"],
            "table" => "_contract_city",
        ];
        $data['contract_city'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "table" => "_mcurrency",
        ];
        $data['currency'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['allowance'] = json_decode(ElaHelper::myCurl('hris/contract/get-master-allowance', $param));

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        return view('HRIS.employee.others.addContract', $data);
    }

    public function filterExport(Request $request)
    {
        $data['id'] = $request->get('id');
        $data['link'] = $request->get('link');
        $data['title'] = 'Export Excel';
        $data['subtitle'] = 'List Employee';

        return view('HRIS.employee.others.filterexport', $data);

    }

}
