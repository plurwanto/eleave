<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class payrollApproval extends Controller
{
    public $menuID = 34;
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
            'need-approve'];

        $select = '';
        $select .= '<select id="link" style="width:150px; margin-right:10px" class="form-control border-rounded pull-left"  border-rounded" onchange="javascript:handleSelect(this)">';
        $select2 = '';
        for ($i = 0; $i < count($link); $i++) {
            if ($i == 0) {
                $select2 .= '<option value="' . env('APP_URL') . '/hris/finance/payroll/approval">' . $link[$i] . '</option>';
            } else {
                if ($request->get('link') == $link[$i]) {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/finance/payroll/approval?link=' . $link[$i] . '" selected>' . $link[$i] . '</option>';
                } else {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/finance/payroll/approval?link=' . $link[$i] . '">' . $link[$i] . '</option>';
                }
            }

        }
        $select .= $select2;
        $select .= '</select><input type="hidden" id="link" value="' . $request->get('link') . '">';

        if ($data['access']->menu_acc_approve == 1) {
            $data['select'] = $select;
        } else {
            $data['select'] = '';
        }

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
        $data['title'] = 'Payroll Approval';
        $data['subtitle'] = 'List Payroll Approval';
        if ($request->has('link') && $request->get('link') == 'need-approve') {
            return view('HRIS.finance.payrollApproval.approver', $data);
        } else {
            return view('HRIS.finance.payrollApproval.index', $data);

        }
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
            "search_code" => $request['columns'][0]['search']['value'],
            "search_title" => $request['columns'][1]['search']['value'],
            "search_customer" => $request['columns'][2]['search']['value'],
            "search_referance" => $request['columns'][3]['search']['value'],
            "search_currency" => $request['columns'][4]['search']['value'],
            "search_status" => $request['columns'][5]['search']['value'],
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/payroll-approval', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $created_at = $rows->data[$i]->created_at != "0000-00-00 00:00:00" ? date('d-M-Y H:i:s', strtotime($rows->data[$i]->created_at)) : "";

                $nestedData['no'] = $a++;
                $nestedData['app_id'] = $rows->data[$i]->app_id;
                $nestedData['app_code'] = $rows->data[$i]->app_code;
                $nestedData['app_name'] = $rows->data[$i]->app_name;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['reference'] = $rows->data[$i]->reference;
                $nestedData['amount'] = $rows->data[$i]->amount;
                $nestedData['app_status'] = $rows->data[$i]->status;
                $nestedData['created_at'] = $rows->data[$i]->created_at;
                $menu_access = '';
                if ($access) {
                    if ($access->menu_acc_edit == '1' & in_array($rows->data[$i]->app_status, [0, 3, 4])) {
                        $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                    <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';

                    }

                    if ($access->menu_acc_del == '1' && in_array($rows->data[$i]->app_status, [0]) && $rows->data[$i]->isrejected == 'N') {

                        $menu_access .= '
                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                    <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                    }

                    $menu_access .= '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                <i class="fa fa-search-plus" style="
                    font-size: 18px;
                    width: 18px;
                    height: 18px;
                    margin-right: 3px;"></i>
                </a>';
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

    public function listDataApprover(Request $request)
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
            "search_code" => $request['columns'][0]['search']['value'],
            "search_title" => $request['columns'][1]['search']['value'],
            "search_customer" => $request['columns'][2]['search']['value'],
            "search_referance" => $request['columns'][3]['search']['value'],
            "search_currency" => $request['columns'][4]['search']['value'],
            "search_status" => $request['columns'][5]['search']['value'],
            "search_condition" => $request['columns'][6]['search']['value'],
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/payroll-approval/list-approver', $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {

                $created_at = $rows->data[$i]->created_at != "0000-00-00 00:00:00" ? date('d-M-Y H:i:s', strtotime($rows->data[$i]->created_at)) : "";

                $nestedData['no'] = $a++;
                $nestedData['app_id'] = $rows->data[$i]->app_id;
                $nestedData['app_code'] = $rows->data[$i]->app_code;
                $nestedData['app_name'] = $rows->data[$i]->app_name;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['reference'] = $rows->data[$i]->reference;
                $nestedData['amount'] = $rows->data[$i]->amount;
                $nestedData['app_status'] = $rows->data[$i]->status;
                $nestedData['created_at'] = $rows->data[$i]->created_at;
                $nestedData['condition'] = $rows->data[$i]->condition;
                $nestedData['updated_date'] = $rows->data[$i]->updated_date;

                $menu_access = '';
                if ($access) {
                    if ($access->menu_acc_approve == '1') {
                        if ($rows->data[$i]->type == 1) {
                            if ($rows->data[$i]->app_status == 0 or $rows->data[$i]->app_status == 1) {
                                $menu_access .= '
                        <a  title="Upload POP" dataaction="checker" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                            <i class="fa fa-upload" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                            }
                            if ($rows->data[$i]->app_status == 2) {
                                $menu_access .= '
                        <a title="Upload Bankslip" dataaction="upload-bankslip" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                            <i class="fa fa-upload" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                                $menu_access .= '
                        <a title="Reopen" dataaction="reopen" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                            <i class="fa fa-undo" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                            }
                        } else {
                            if ($rows->data[$i]->app_status == 0 or $rows->data[$i]->app_status == 1) {
                                $menu_access .= '
                        <a title="Approve" dataaction="approve" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                            <i class="fa fa-check" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                            }
                        }
                        if ($rows->data[$i]->app_status == 0 or $rows->data[$i]->app_status == 1) {
                            $menu_access .= '
                        <a  title="Reject" dataaction="reject" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                            <i class="fa fa-close" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                        }
                    }
                }

                $menu_access .= '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->app_id . '" onclick="get_modal(this)">
                <i class="fa fa-search-plus" style="
                    font-size: 18px;
                    width: 18px;
                    height: 18px;
                    margin-right: 3px;"></i>
                </a>';

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

    public function detail(Request $request)
    {
        $data['link'] = $request->get('link');

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['request'] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-request', $param));
        $data['title'] = 'Detail Approval (' . $data['request']->result->app_code . ')';
        $data['subtitle'] = 'List Approval';

        return view('HRIS.finance.payrollApproval.detail', $data);

    }

    public function add(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Request Approval';
        $data['subtitle'] = 'List Payroll Approval';
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        $urlMenu = 'master-global';
        $param = [
            "order" => ["menu_name", "ASC"],
            "fields" => ["menu_id", "menu_name"],
            "where" => ["status", "1"],
            "table" => "hris_menu_setting",
        ];
        $data['MenuSetting'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "table" => "_mcurrency",
        ];
        $data['currency'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        return view('HRIS.finance.payrollApproval.add', $data);

    }

    public function bankslip(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Upload bankslip';
        $data['subtitle'] = 'List Payroll Approval';
        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['request'] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-request', $param));
        return view('HRIS.finance.payrollApproval.bankslip', $data);

    }

    public function reject(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Reject List';
        $data['subtitle'] = 'List Payroll Approval';
        $data['id'] = $request->get('id');

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['request'] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-request', $param));
        return view('HRIS.finance.payrollApproval.reject', $data);

    }

    public function getApprover(Request $request)
    {
        $data['response'] = '';
        $type = $request->get('type');
        $customer = $request->get('customer');

        $param = [
            "token" => session("token"),
            "menu_id" => $type,
        ];

        $MenuSetting = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-approver', $param));
        $xx = 1;
        for ($i = 0; $i < count($MenuSetting->result); $i++) {

            if ($MenuSetting->result[$i]->div_id == '18') {
                $class = 'class="form-control select2-multiple" multiple';
            } else {
                $class = 'class="form-control select2"';
            }

            $param = [
                "token" => session("token"),
                "div_id" => $MenuSetting->result[$i]->div_id,
                "customer" => $customer,

            ];
            $user[$i] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-user', $param));

            $data['response'] .= '<div class="form-group validate">
                    <label class="col-md-3 control-label">' . $MenuSetting->result[$i]->level . '. ' . $MenuSetting->result[$i]->div_name . '<font color="red">*</font></label>
                    <div class="col-md-9">
                        <select name="user' . $xx . '[]" id="multi-prepend" ' . $class . '>
                            <option value="">-- Choose a User --</option>';
            for ($a = 0; $a < count($user[$i]->result); $a++) {
                $data['response'] .= '<option value="' . $user[$i]->result[$a]->user_id . '">' . $user[$i]->result[$a]->nama . '</option>';
            }
            $data['response'] .= '</select>
                    </div>
                </div>
                <input type="hidden" name="div' . $xx . '" value="' . $MenuSetting->result[$i]->div_id . '">
                <input type="hidden" name="menu_app_id' . $xx . '" value="' . $MenuSetting->result[$i]->menu_app_id . '">
                <input type="hidden" name="next' . $xx . '" value="' . $MenuSetting->result[$i]->next_menu_app_id . '">
                <input type="hidden" name="dur_auto_app' . $xx . '" value="' . $MenuSetting->result[$i]->dur_auto_app . '">
                <input type="hidden" name="level' . $xx . '" value="' . $MenuSetting->result[$i]->level . '">
                <input type="hidden" name="typeApp' . $xx . '" value="' . $MenuSetting->result[$i]->type . '">
                ';
            $xx++;
        }
        $data['response'] .= '<input type="hidden" name="count_user" value="' . count($MenuSetting->result) . '">';
        return view('HRIS.finance.payrollApproval.getApprover', $data);

    }

    public function getApproverEdit(Request $request)
    {
        $data['response'] = '';
        $type = $request->get('type');
        $customer = $request->get('customer');
        $id = $request->get('id');

        $param = [
            "token" => session("token"),
            "id" => $id,
        ];

        $request = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-request', $param));

        $param = [
            "token" => session("token"),
            "menu_id" => $type,
        ];
        $MenuSetting = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-approver', $param));
        $xx = 1;
        for ($i = 0; $i < count($MenuSetting->result); $i++) {

            if ($MenuSetting->result[$i]->div_id == '18') {
                $class = 'class="form-control select2-multiple" multiple';
            } else {
                $class = 'class="form-control select2"';
            }

            $param = [
                "token" => session("token"),
                "div_id" => $MenuSetting->result[$i]->div_id,
                "customer" => $customer,

            ];
            $user[$i] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-user', $param));

            $data['response'] .= '<div class="form-group validate">
                    <label class="col-md-3 control-label">' . $MenuSetting->result[$i]->level . '. ' . $MenuSetting->result[$i]->div_name . '<font color="red">*</font></label>
                    <div class="col-md-9">
                        <select disabled name="user' . $xx . '[]" id="multi-prepend" ' . $class . '>
                            <option value="">-- Choose a User --</option>';
            for ($a = 0; $a < count($user[$i]->result); $a++) {
                $user_id[$i] = explode(',', $request->flow[$i]->user_id);
                if (in_array($user[$i]->result[$a]->user_id, $user_id[$i])) {
                    $data['response'] .= '<option value="' . $user[$i]->result[$a]->user_id . '" selected>' . $user[$i]->result[$a]->nama . '</option>';
                } else {
                    $data['response'] .= '<option value="' . $user[$i]->result[$a]->user_id . '">' . $user[$i]->result[$a]->nama . '</option>';
                }
            }
            $data['response'] .= '</select>
                    </div>
                </div>
                <input type="hidden" name="div' . $xx . '" value="' . $MenuSetting->result[$i]->div_id . '">
                <input type="hidden" name="menu_app_id' . $xx . '" value="' . $MenuSetting->result[$i]->menu_app_id . '">
                <input type="hidden" name="next' . $xx . '" value="' . $MenuSetting->result[$i]->next_menu_app_id . '">
                <input type="hidden" name="dur_auto_app' . $xx . '" value="' . $MenuSetting->result[$i]->dur_auto_app . '">
                <input type="hidden" name="level' . $xx . '" value="' . $MenuSetting->result[$i]->level . '">
                <input type="hidden" name="typeApp' . $xx . '" value="' . $MenuSetting->result[$i]->type . '">
                ';
            $xx++;
        }
        $data['response'] .= '<input type="hidden" name="count_user" value="' . count($MenuSetting->result) . '">';
        return view('HRIS.finance.payrollApproval.getApprover', $data);

    }

    public function doAdd(Request $request)
    {
        $title = $request->post('title') != null ? $request->post('title') : "";
        $month = $request->post('month') != null ? $request->post('month') : "";
        $year = $request->post('year') != null ? $request->post('year') : "";
        $period = $month . $year;
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $amount = $request->post('amount') != null ? str_replace('.', '', $request->post('amount')) : "";

        $remark = $request->post('remark') != null ? $request->post('remark') : "";
        $customer = $request->post('cus_id') != null ? $request->post('cus_id') : "";
        $type = $request->post('type') != null ? $request->post('type') : "";
        $count_file = $request->post('count_file') != null ? $request->post('count_file') : "";
        $count_user = $request->post('count_user') != null ? $request->post('count_user') : "";

        $param = [
            "token" => session("token"),
            "customer" => $customer,
        ];
        $cus = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-customer', $param));
        $cusCode = $cus->result->cus_code;
        $brCode = $cus->result->br_code;

        $param = [
            "token" => session("token"),
            "customer" => $customer,
        ];
        $last = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-last', $param));

        if ($last) {
            $last = $last->result->app_no + 1;
        } else {
            $last = 1;
        }

        $allfile = '';
        for ($a = 1; $a <= $count_file; $a++) {
            if ($request->hasFile('file' . $a)) {
                $file = $request->file('file' . $a)->getClientOriginalName();
                $ext = $request->file('file' . $a)->getClientOriginalExtension();
                $fileName = $file . '-' . $cusCode . '_' . $period . '_' . sprintf("%02s", $last) . '_' . sprintf("%02s", $a) . '.' . $ext;
                $destinationPath = base_path('public/hris/files/payroll/');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $request->file('file' . $a)->move($destinationPath, $fileName);
                $allfile .= $fileName . ';';
            }

        }
        $allfile = substr($allfile, 0, -1);

        $allUser = [];
        $allDiv = '';
        $allMenuAppId = '';
        $allNext = '';
        $allType = '';
        $allLevel = '';
        $allDuration = '';

        for ($b = 1; $b <= $count_user; $b++) {
            $allUser[] = $request->post('user' . $b);
            $allDiv .= $request->post('div' . $b) . ',';
            $allMenuAppId .= $request->post('menu_app_id' . $b) . ',';
            $allNext .= $request->post('next' . $b) . ',';
            $allType .= $request->post('typeApp' . $b) . ',';
            $allLevel .= $request->post('level' . $b) . ',';
            $allDuration .= $request->post('dur_auto_app' . $b) . ',';

        }
        $allDiv = substr($allDiv, 0, -1);
        $allMenuAppId = substr($allMenuAppId, 0, -1);
        $allNext = substr($allNext, 0, -1);
        $allType = substr($allType, 0, -1);
        $allLevel = substr($allLevel, 0, -1);
        $allDuration = substr($allDuration, 0, -1);
        $value = [
            'cus_code' => strip_tags($cusCode),
            'br_code' => strip_tags($brCode),
            'app_no' => strip_tags($last),
            'title' => strip_tags($title),
            'period' => strip_tags($period),
            'currency' => strip_tags($currency),
            'amount' => strip_tags($amount),
            'remark' => strip_tags($remark),
            'customer' => strip_tags($customer),
            'type' => $type,
            'allfile' => $allfile,
            'allUser' => $allUser,
            'allDiv' => $allDiv,
            'allMenuAppId' => $allMenuAppId,
            'allNext' => $allNext,
            'allType' => $allType,
            'allLevel' => $allLevel,
            'allDuration' => $allDuration,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session("id_hris"),
        ];

        $urlMenu = 'hris/payroll-approval/do-add';
        $param = [
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
            "value" => $value,
            "url" => env('APP_URL'),

        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doEdit(Request $request)
    {
        $app_code = $request->post('app_code') != null ? $request->post('app_code') : "";
        $title = $request->post('title') != null ? $request->post('title') : "";
        $month = $request->post('month') != null ? $request->post('month') : "";
        $year = $request->post('year') != null ? $request->post('year') : "";
        $period = $month . $year;
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $amount = $request->post('amount') != null ? str_replace('.', '', $request->post('amount')) : "";

        $remark = $request->post('remark') != null ? $request->post('remark') : "";
        $customer = $request->post('cus_id') != null ? $request->post('cus_id') : "";
        $count_file = $request->post('count_file') != null ? $request->post('count_file') : "";

        $param = [
            "token" => session("token"),
            "customer" => $customer,
        ];

        $cus = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-customer', $param));
        $cusCode = $cus->result->cus_code;
        $brCode = $cus->result->br_code;

        $param = [
            "token" => session("token"),
            "customer" => $customer,
        ];
        $last = $request->post('app_no');

        $allfile = '';
        for ($a = 1; $a <= $count_file; $a++) {
            if ($request->hasFile('file' . $a)) {
                $file = $request->file('file' . $a)->getClientOriginalName();
                $ext = $request->file('file' . $a)->getClientOriginalExtension();
                $fileName = $file . '-' . $cusCode . '_' . $period . '_' . sprintf("%02s", $last) . '_' . sprintf("%02s", $a) . '.' . $ext;
                $destinationPath = base_path('public/hris/files/payroll/');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $request->file('file' . $a)->move($destinationPath, $fileName);
                $allfile .= $fileName . ';';
            }

        }
        $allfile = substr($allfile, 0, -1);

        $value = [
            'title' => strip_tags($title),
            'currency' => strip_tags($currency),
            'amount' => strip_tags($amount),
            'remark' => strip_tags($remark),
            'allfile' => $allfile,
            'app_code' => strip_tags($app_code),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session("id_hris"),
        ];

        $param = [
            "app_id" => $request->post('id'),
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
            "value" => $value,
            "url" => env('APP_URL'),
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/payroll-approval/do-edit', $param));
        $data['response_code'] = $rows->response->response_code;
        $data['message'] = $rows->response->message;
        echo json_encode($data);
    }

    public function validateNameFile(Request $request)
    {

        foreach ($request->post() as $val => $row) {
            $attach = $request->post($val);
            $filename = pathinfo($attach, PATHINFO_FILENAME); // outputs html
            if (substr(stristr($filename, 'INB'), 0, 3) == 'INB') {
                $response = true;
            } else {
                $response = false;
            }

            echo json_encode($response);
        }
    }

    public function doApprove(Request $request)
    {

        $app_id = $request->post('id');
        $urlMenu = 'hris/payroll-approval/do-approve';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "app_id" => $app_id,
            "url" => env('APP_URL'),
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doReject(Request $request)
    {

        $remark = $request->post('remark');
        $app_id = $request->post('id');
        $urlMenu = 'hris/payroll-approval/do-reject';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "app_id" => $app_id,
            "remark" => $remark,
            "url" => env('APP_URL'),
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function edit(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['id'] = $request->get('id');

        $data['title'] = 'Request Approval';
        $data['subtitle'] = 'List Payroll Approval';
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        $urlMenu = 'master-global';
        $param = [
            "order" => ["menu_name", "ASC"],
            "fields" => ["menu_id", "menu_name"],
            "where" => ["status", "1"],
            "table" => "hris_menu_setting",
        ];
        $data['MenuSetting'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "table" => "_mcurrency",
        ];
        $data['currency'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['request'] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-request', $param));
        return view('HRIS.finance.payrollApproval.edit', $data);

    }

    public function doBankSlip(Request $request)
    {
        $app_id = $request->post('app_id') != null ? $request->post('app_id') : "";
        $app_code = $request->post('app_code') != null ? $request->post('app_code') : "";
        $app_no = $request->post('app_no') != null ? $request->post('app_no') : "";
        $remark = $request->post('remark') != null ? $request->post('remark') : "";
        $customer = $request->post('cus_id') != null ? $request->post('cus_id') : "";
        $count_file = $request->post('count_file') != null ? $request->post('count_file') : "";
        $period = $request->post('period') != null ? $request->post('period') : "";

        $param = [
            "token" => session("token"),
            "customer" => $customer,
        ];
        $cus = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-customer', $param));
        $cusCode = $cus->result->cus_code;

        $param = [
            "app_code" => $app_code,
            "app_no" => $app_no,
        ];
        $last = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-count-bank-slip', $param));

        $allfile = '';
        for ($a = 1; $a <= $count_file; $a++) {

            if ($request->hasFile('file' . $a)) {
                $file = $request->file('file' . $a)->getClientOriginalName();
                $ext = $request->file('file' . $a)->getClientOriginalExtension();

                $fileName = 'BANKSLIP-' . $cusCode . '-' . $period . '-' . sprintf("%02s", $app_no) . '-' . sprintf("%02s", ($last + $a)) . '.' . $ext;
                $destinationPath = base_path('public/hris/files/payroll/');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $request->file('file' . $a)->move($destinationPath, $fileName);
                $allfile .= $fileName . ';';
            }

        }
        $allfile = substr($allfile, 0, -1);

        $value = [
            'remark' => strip_tags($remark),
            'allfile' => $allfile,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $param = [
            "app_id" => $app_id,
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/payroll-approval/do-bankslip', $param));

        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function checker(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Upload POP';
        $data['subtitle'] = 'List Payroll Approval';
        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['request'] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-request', $param));
        return view('HRIS.finance.payrollApproval.checker', $data);

    }

    public function doChecker(Request $request)
    {
        $app_id = $request->post('app_id') != null ? $request->post('app_id') : "";
        $app_code = $request->post('app_code') != null ? $request->post('app_code') : "";
        $app_no = $request->post('app_no') != null ? $request->post('app_no') : "";
        $remark = $request->post('remark') != null ? $request->post('remark') : "";
        $customer = $request->post('cus_id') != null ? $request->post('cus_id') : "";
        $count_file = $request->post('count_file') != null ? $request->post('count_file') : "";
        $period = $request->post('period') != null ? $request->post('period') : "";
        $reference = $request->post('reference') != null ? $request->post('reference') : "";

        $param = [
            "token" => session("token"),
            "customer" => $customer,
        ];
        $cus = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-customer', $param));
        $cusCode = $cus->result->cus_code;

        $param = [
            "app_code" => $app_code,
            "app_no" => $app_no,
        ];
        $last = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-count-pop', $param));

        $allfile = '';
        for ($a = 1; $a <= $count_file; $a++) {

            if ($request->hasFile('file' . $a)) {
                $file = $request->file('file' . $a)->getClientOriginalName();
                $ext = $request->file('file' . $a)->getClientOriginalExtension();

                $fileName = 'POP-' . $cusCode . '-' . $period . '-' . sprintf("%02s", $app_no) . '-' . sprintf("%02s", ($last + $a)) . '.' . $ext;
                $destinationPath = base_path('public/hris/files/payroll/');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $request->file('file' . $a)->move($destinationPath, $fileName);
                $allfile .= $fileName . ';';
            }

        }
        $allfile = substr($allfile, 0, -1);

        $value = [
            'reference' => strip_tags($reference),
            'remark' => strip_tags($remark),
            'allfile' => $allfile,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $param = [
            "app_id" => $app_id,
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "value" => $value,
        ];
        $rows = json_decode(ElaHelper::myCurl('hris/payroll-approval/do-checker', $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function reopen(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Form Re-open';
        $data['subtitle'] = 'List Payroll Approval';
        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['request'] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-request', $param));
        return view('HRIS.finance.payrollApproval.reopen', $data);

    }

    public function doReopen(Request $request)
    {
        $app_id = $request->post('app_id') != null ? $request->post('app_id') : "";
        $app_code = $request->post('app_code') != null ? $request->post('app_code') : "";
        $app_no = $request->post('app_no') != null ? $request->post('app_no') : "";
        $remark = $request->post('remark') != null ? $request->post('remark') : "";
        $customer = $request->post('cus_id') != null ? $request->post('cus_id') : "";
        $count_file = $request->post('count_file') != null ? $request->post('count_file') : "";
        $period = $request->post('period') != null ? $request->post('period') : "";

        $param = [
            "token" => session("token"),
            "customer" => $customer,
        ];
        $cus = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-customer', $param));
        $cusCode = $cus->result->cus_code;

        $param = [
            "app_code" => $app_code,
            "app_no" => $app_no,
        ];
        $last = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-count-refund', $param));

        $allfile = '';
        for ($a = 1; $a <= $count_file; $a++) {

            if ($request->hasFile('file' . $a)) {
                $file = $request->file('file' . $a)->getClientOriginalName();
                $ext = $request->file('file' . $a)->getClientOriginalExtension();

                $fileName = 'REFUND-' . $cusCode . '-' . $period . '-' . sprintf("%02s", $app_no) . '-' . sprintf("%02s", ($last + $a)) . '.' . $ext;
                $destinationPath = base_path('public/hris/files/payroll/');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $request->file('file' . $a)->move($destinationPath, $fileName);
                $allfile .= $fileName . ';';
            }

        }
        $allfile = substr($allfile, 0, -1);

        $value = [
            'remark' => strip_tags($remark),
            'allfile' => $allfile,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $param = [
            "app_id" => $app_id,
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "value" => $value,
            "url" => env('APP_URL'),
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/payroll-approval/do-reopen', $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    function print(Request $request) {
        $data['link'] = $request->get('link');

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['request'] = json_decode(ElaHelper::myCurl('hris/payroll-approval/get-request', $param));

        $pdf = PDF::loadView('HRIS.finance.payrollApproval.print', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('Detail Approval ' . $data['request']->result->app_code . '.pdf');

    }

}
