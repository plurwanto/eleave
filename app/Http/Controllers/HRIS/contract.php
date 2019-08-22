<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;
use PDF;

class contract extends Controller
{
    public $menuID = 8;

    public function index(Request $request)
    {

        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index"
                </script>';
        }
        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        if ($data['access']) {
            if ($data['access']->menu_acc_view != 1) {
                echo '<script type="text/javascript">
                        window.alert("you don\'t have access");
                        window.location.href="' . env('APP_URL') . '/index"
                      </script>';

            }
        } else {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index"
                  </script>';
        }

        $data['link'] = $request->get('link');

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $customer = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        $select = '';
        $select .= '<select id="link" style="width:190px; margin-right:10px" class="form-control border-rounded pull-left" onchange="javascript:handleSelect(this)">';
        $select2 = '';
        for ($i = 0; $i < count($customer); $i++) {
            if ($request->get('link') == $customer[$i]->cus_id) {
                $select2 .= '<option value="' . $customer[$i]->cus_id . '" selected>' . $customer[$i]->cus_name . '</option>';
            } else {
                $select2 .= '<option value="' . $customer[$i]->cus_id . '">' . $customer[$i]->cus_name . '</option>';
            }
        }
        $select .= $select2;
        $select .= '</select>';
        $data['select'] = $select;

        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "where" => ["cont_sta_id", "!=", "1"],
            "table" => "_contract_status",
        ];
        $data['contract_status'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["cont_city_name", "ASC"],
            "fields" => ["cont_city_id", "cont_city_name"],
            "table" => "_contract_city",
        ];
        $data['site'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $data['title'] = 'Contract';

        if ($request->has('link') && $request->get('link') == 'log-error') {

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
            return view('HRIS.administration.contract.log', $data);
        } else {
            $data['subtitle'] = 'List Contract';
            return view('HRIS.administration.contract.index', $data);
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

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => session('id_hris'),
        ];
        $profile = json_decode(ElaHelper::myCurl('hris/get-profile-hris', $param));

        $urlMenu = 'hris/contract';

        if ($request->post('start') == 0) {
            $page = 1;
        } else {
            $page = ($request->post('start') / $request->post('length')) + 1;
        }

        $sort_by = $request->post('order')[0]['column'];
        $dir = $request->post('order')[0]['dir'];

        if ($request['columns'][3]['search']['value'] != "" && $request['columns'][3]['search']['value'] != null) {
            $start_date = $request['columns'][3]['search']['value'];
            $start_date = str_replace('/', '-', $start_date);
            $start_date = date('Y-m-d', strtotime($start_date));
        } else {
            $start_date = "";
        }

        if ($request['columns'][4]['search']['value'] != "" && $request['columns'][4]['search']['value'] != null) {
            $end_date = $request['columns'][4]['search']['value'];
            $end_date = str_replace('/', '-', $end_date);
            $end_date = date('Y-m-d', strtotime($end_date));
        } else {
            $end_date = "";
        }

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "cus_id" => $request->post('cus_id'),
            "page" => $page,
            "per_page" => $request->post('length'),
            "search" => $search,
            "sort_by" => $sort_by,
            "dir" => $dir,
            "search_name" => $request['columns'][0]['search']['value'],
            "search_nip" => $request['columns'][1]['search']['value'],
            "search_contract_no" => $request['columns'][2]['search']['value'],
            "search_start_date" => $start_date,
            "search_end_date" => $end_date,
            "search_status" => $request['columns'][5]['search']['value'],
            "search_site" => $request['columns'][6]['search']['value'],
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $cont_active = $rows->data[$i]->cont_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $cont_resign_status = $rows->data[$i]->cont_resign_status != '' ? $rows->data[$i]->cont_resign_status : 'NA';
                $cont_resign_date = $rows->data[$i]->cont_resign_date != '' ? $rows->data[$i]->cont_resign_date . '<br>(' . $cont_resign_status . ')' : '';
                $nestedData['no'] = $a++;
                $nestedData['cont_id'] = $rows->data[$i]->cont_id;

                $dis = '';
                if ($rows->data[$i]->is_cancel == 1) {
                    $dis = '<br><button class="pull-right btn red btn-xs" disabled>Cancel</button>';

                }
                $nestedData['mem_name'] = '<a dataaction="detail" title="detail" target="blank" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>' . $dis;
                $nestedData['mem_nip'] = $rows->data[$i]->mem_nip;
                $nestedData['cont_no'] = $rows->data[$i]->cont_no;
                $nestedData['cont_start_date'] = $rows->data[$i]->cont_start_date;
                $nestedData['cont_active'] = $cont_active;
                $nestedData['cont_end_date'] = $rows->data[$i]->cont_end_date;

                if (stripos($rows->data[$i]->cont_no, '/12/') == true) {
                    $label = '<br><button class="pull-right btn yellow btn-xs" disabled>Memo</button>';
                } else if (stripos($rows->data[$i]->cont_no, '/05/') == true) {
                    $label = '<br><button class="pull-right btn blue btn-xs" disabled>Addendum</button>';
                } else {
                    $label = '';
                }

                $nestedData['cont_sta_name'] = $rows->data[$i]->cont_sta_name . $label;
                $nestedData['cont_user'] = $rows->data[$i]->cont_user;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['cont_resign_date'] = $cont_resign_date;
                $nestedData['cont_resign_status'] = $rows->data[$i]->cont_resign_status;
                $nestedData['cont_city_name'] = $rows->data[$i]->cont_city_name;
                $nestedData['is_cancel'] = $rows->data[$i]->is_cancel;

                $menu_access = '';
                if ($access) {
                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                    }

                    if ($profile->profile->br_id == 1) {

                        if ($rows->data[$i]->cont_sta_id == '4') {
                            $menu_access .= '<li>
                                                <a dataaction="pdf_eng" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">
                                                <i class="fa fa-file-pdf-o"></i> Contract English </a>
                                            </li>';

                            $menu_access .= '<li>
                                                <a dataaction="pdf_ind" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">
                                                <i class="fa fa-file-pdf-o"></i> Contract Indonesia </a>
                                            </li>';
                        } else if ($rows->data[$i]->cont_sta_id == '3') {

                            $menu_access .= '<li>
                                                <a dataaction="pdf_eng" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">
                                                <i class="fa fa-file-pdf-o"></i> Contract English </a>
                                            </li>';

                            $menu_access .= '<li>
                                                <a dataaction="pdf_ind" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">
                                                <i class="fa fa-file-pdf-o"></i> Contract Indonesia </a>
                                            </li>';
                        } else {
                            $menu_access .= '<li>
                                                <a dataaction="pdf_ind" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">
                                                <i class="fa fa-file-pdf-o"></i> Contract </a>
                                            </li>';

                        }
                    } else if ($profile->profile->br_id == 5) {
                        // $menu_access .= '<li>
                        //                     <a dataaction="pdf_tha" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">
                        //                     <i class="fa fa-file-pdf-o"></i> Contract </a>
                        //                 </li>';
                    } else if ($profile->profile->br_id == 4) {
                        $menu_access .= '<li>
                                        <a dataaction="pdf_phi" dataid="' . md5($rows->data[$i]->cont_id) . '" onclick="get_modal(this)">
                                        <i class="fa fa-file-pdf-o"></i> Contract </a>
                                    </li>';
                    }

                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                                        <li>
                                            <a dataaction="resign" dataid="' . $rows->data[$i]->cont_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Resign </a>
                                        </li>';
                    }

                    if ($rows->data[$i]->flag_upload == '1' || in_array($rows->data[$i]->form_type, array(2, 4, 5))) {
                        $menu_access .= '<li>
                                            <a dataaction="upload" dataid="' . $rows->data[$i]->cont_id . '|' . $rows->data[$i]->mem_name . '" onclick="get_modal(this)">
                                            <i class="fa fa-upload"></i> Upload Letter Contract </a>
                                        </li>';
                    }

                    if ($access->menu_acc_del == '1') {
                        $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="cancel" title="cancel" dataid="' . $rows->data[$i]->cont_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-times"></i> Cancel
                                            </a>
                                        </li>';
                    }

                    if ($access->menu_acc_del == '1') {
                        $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->cont_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </li>';
                    }
                }
                $disabled = '';
                if ($rows->data[$i]->is_cancel == 1) {
                    $disabled = 'disabled';

                }
                $nestedData['action'] = '<div class="btn-group">
                        <button ' . $disabled . ' class="btn dark btn-outline btn-circle btn-xs border-rounded" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
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

    public function add(Request $request)
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
        $data['title'] = 'Contract';

        $data['subtitle'] = 'List Contract';
        $data['subtitle2'] = $cus->result[0]->cus_name;
        $data['subtitle3'] = 'Add';
        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "where" => ["cont_sta_id", "!=", "1"],
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
        return view('HRIS.administration.contract.add', $data);

    }

    public function doAdd(Request $request)
    {
        $employee_id = $request->post('employee_id') != null ? $request->post('employee_id') : "";
        $customer = $request->post('customer') != null ? $request->post('customer') : "";
        $date = $request->post('date') != null ? $request->post('date') : "";
        $sign_contract = $request->post('sign_contract') != null ? $request->post('sign_contract') : "";
        $contract_start = $request->post('contract_start') != null ? $request->post('contract_start') : "";
        $contract_end = $request->post('contract_end') != null ? $request->post('contract_end') : "";
        $position = $request->post('position') != null ? $request->post('position') : "";
        $division = $request->post('division') != null ? $request->post('division') : "";
        $departement = $request->post('departement') != null ? $request->post('departement') : "";
        $project_name = $request->post('project_name') != null ? $request->post('project_name') : "";
        $status = $request->post('status') != null ? $request->post('status') : "";
        $site_location = $request->post('site_location') != null ? $request->post('site_location') : "";
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $basic_salary = $request->post('basic_salary') != null ? str_replace('.', '', $request->post('basic_salary')) : "";
        $note = $request->post('note') != null ? $request->post('note') : "";
        $payday_date = $request->post('payday_date') != null ? $request->post('payday_date') : "";
        $offshore = $request->has('offshore') ? str_replace('.', '', $request->post('offshore')) : "";

        if ($date != "") {
            $date = $date;
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d', strtotime($date));
        } else {
            $date = "";
        }

        if ($sign_contract != "") {
            $sign_contract = $sign_contract;
            $sign_contract = str_replace('/', '-', $sign_contract);
            $sign_contract = date('Y-m-d', strtotime($sign_contract));
        } else {
            $sign_contract = "";
        }

        if ($contract_start != "") {
            $contract_start = $contract_start;
            $contract_start = str_replace('/', '-', $contract_start);
            $contract_start = date('Y-m-d', strtotime($contract_start));
        } else {
            $contract_start = "";
        }

        if ($contract_end != "") {
            $contract_end = $contract_end;
            $contract_end = str_replace('/', '-', $contract_end);
            $contract_end = date('Y-m-d', strtotime($contract_end));
        } else {
            $contract_end = "";
        }

        $allowance = [];
        $allowance = [
            'allowance_type' => $request->post('allowance_type'),
            'amount' => str_replace('.', '', $request->post('amount')),
            'description' => $request->post('description'),
        ];
        $value = [
            'employee_id' => strip_tags($employee_id),
            'customer' => strip_tags($customer),
            'date' => strip_tags($date),
            'sign_contract' => strip_tags($sign_contract),
            'contract_start' => strip_tags($contract_start),
            'contract_end' => strip_tags($contract_end),
            'position' => strip_tags($position),
            'division' => strip_tags($division),
            'departement' => strip_tags($departement),
            'project_name' => strip_tags($project_name),
            'status' => strip_tags($status),
            'site_location' => strip_tags($site_location),
            'currency' => strip_tags($currency),
            'basic_salary' => strip_tags($basic_salary),
            'note' => strip_tags($note),
            'payday_date' => strip_tags($payday_date),
            'allowance' => $allowance,
            'offshore' => strip_tags($offshore),
        ];
        $param = [
            "id_hris" => session('id_hris'),
            "name" => session('name'),
            "token" => session('token'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/contract/do-add', $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        $data['customer'] = $customer;
        $data['cont_id'] = md5($rows->cont_id);

        echo json_encode($data);
    }

    public function edit(Request $request)
    {

        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $select = '';
        $select .= '<select id="link" style="background-color: #444d58; color: #fff;" class="form-control border-rounded" onchange="javascript:handleSelect(this)">';
        if ($request->has('type') & $request->get('type') == 'allowance') {
            $select .= '<option value="contract">Contract</option>';
            $select .= '<option value="allowance" selected>Allowance</option>';
        } else {
            $select .= '<option value="contract" selected>Contract</option>';
            $select .= '<option value="allowance">Allowance</option>';
        }
        $select .= '</select>';

        $data['select'] = $select;

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];
        $data['contract'] = json_decode(ElaHelper::myCurl('hris/contract/get-contract-edit', $param));

        $data['link'] = $request->get('link');
        $data['title'] = 'Contract';
        $data['subtitle'] = 'Edit Contract ';

        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "where" => ["cont_sta_id", "!=", "1"],
            "table" => "_contract_status",
        ];
        $data['contract_status'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["cont_city_name", "ASC"],
            "fields" => ["cont_city_id", "cont_city_name"],
            "where" => ["cus_id", 0],
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
            "cont_id" => $request->get('id'),
        ];
        $data['allowance'] = json_decode(ElaHelper::myCurl('hris/contract/get-master-allowance-edit', $param));

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        return view('HRIS.administration.contract.edit', $data);
    }

    public function doEdit(Request $request)
    {
        $cont_id = $request->post('cont_id') != null ? $request->post('cont_id') : "";
        $employee_id = $request->post('employee_id') != null ? $request->post('employee_id') : "";
        $customer = $request->post('customer') != null ? $request->post('customer') : "";
        $date = $request->post('date') != null ? $request->post('date') : "";
        $sign_contract = $request->post('sign_contract') != null ? $request->post('sign_contract') : "";
        $contract_start = $request->post('contract_start') != null ? $request->post('contract_start') : "";
        $contract_end = $request->post('contract_end') != null ? $request->post('contract_end') : "";
        $position = $request->post('position') != null ? $request->post('position') : "";
        $division = $request->post('division') != null ? $request->post('division') : "";
        $departement = $request->post('departement') != null ? $request->post('departement') : "";
        $project_name = $request->post('project_name') != null ? $request->post('project_name') : "";
        $site_location = $request->post('site_location') != null ? $request->post('site_location') : "";
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $basic_salary = $request->post('basic_salary') != null ? str_replace('.', '', $request->post('basic_salary')) : "";
        $offshore = $request->has('offshore') != null ? str_replace('.', '', $request->post('offshore')) : "";
        $note = $request->post('note') != null ? $request->post('note') : "";
        $payday_date = $request->post('payday_date') != null ? $request->post('payday_date') : "";
        $offshore = $request->has('offshore') ? str_replace('.', '', $request->post('offshore')) : "";

        if ($date != "") {
            $date = $date;
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d', strtotime($date));
        } else {
            $date = "";
        }

        if ($sign_contract != "") {
            $sign_contract = $sign_contract;
            $sign_contract = str_replace('/', '-', $sign_contract);
            $sign_contract = date('Y-m-d', strtotime($sign_contract));
        } else {
            $sign_contract = "";
        }

        if ($contract_start != "") {
            $contract_start = $contract_start;
            $contract_start = str_replace('/', '-', $contract_start);
            $contract_start = date('Y-m-d', strtotime($contract_start));
        } else {
            $contract_start = "";
        }

        if ($contract_end != "") {
            $contract_end = $contract_end;
            $contract_end = str_replace('/', '-', $contract_end);
            $contract_end = date('Y-m-d', strtotime($contract_end));
        } else {
            $contract_end = "";
        }

        $allowance = [];
        if ($request->has('allowance_type')) {
            $allowance = [
                'allowance_type' => $request->post('allowance_type'),
                'amount' => str_replace('.', '', $request->post('amount')),
                'description' => $request->post('description'),
            ];
        }

        $value = [
            'cont_id' => strip_tags($cont_id),
            'employee_id' => strip_tags($employee_id),
            'customer' => strip_tags($customer),
            'date' => strip_tags($date),
            'sign_contract' => strip_tags($sign_contract),
            'contract_start' => strip_tags($contract_start),
            'contract_end' => strip_tags($contract_end),
            'position' => strip_tags($position),
            'division' => strip_tags($division),
            'departement' => strip_tags($departement),
            'project_name' => strip_tags($project_name),
            'site_location' => strip_tags($site_location),
            'currency' => strip_tags($currency),
            'basic_salary' => strip_tags($basic_salary),
            'offshore' => strip_tags($offshore),
            'note' => strip_tags($note),
            'payday_date' => strip_tags($payday_date),
            'allowance' => $allowance,
            'offshore' => strip_tags($offshore),

        ];

        $urlMenu = 'hris/contract/do-edit';
        $param = [
            "id_hris" => session('id_hris'),
            "name" => session('name'),
            "token" => session('token'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        $data['customer'] = $customer;
        echo json_encode($data);
    }

    public function extend(Request $request)
    {

        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $select = '';
        $select .= '<select id="link" style="background-color: #444d58; color: #fff;" class="form-control border-rounded" onchange="javascript:handleSelect(this)">';
        if ($request->has('type') & $request->get('type') == 'allowance') {
            $select .= '<option value="contract">Contract</option>';
            $select .= '<option value="allowance" selected>Allowance</option>';
        } else {
            $select .= '<option value="contract" selected>Contract</option>';
            $select .= '<option value="allowance">Allowance</option>';
        }
        $select .= '</select>';

        $data['select'] = $select;

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['contract'] = json_decode(ElaHelper::myCurl('hris/contract/get-contract-edit', $param));

        $data['id'] = $request->get('id');
        $data['link'] = $request->get('link');
        $data['title'] = 'Contract';
        $data['subtitle'] = 'Extend Contract ';

        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "where" => ["cont_sta_id", "!=", "1"],
            "table" => "_contract_status",
        ];
        $data['contract_status'] = json_decode(ElaHelper::myCurl('master-global', $param));
        $param = [
            "order" => ["cont_city_name", "ASC"],
            "fields" => ["cont_city_id", "cont_city_name"],
            "where" => ["cus_id", 0],
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
            "cont_id" => $request->get('id'),
        ];
        $data['allowance'] = json_decode(ElaHelper::myCurl('hris/contract/get-master-allowance-edit', $param));

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        return view('HRIS.administration.contract.extend', $data);
    }

    public function doExtend(Request $request)
    {
        $cont_id = $request->post('cont_id');
        $param = [
            "token" => session("token"),
            "id" => md5($cont_id),
        ];

        $contract = json_decode(ElaHelper::myCurl('hris/contract/get-contract-edit', $param));
        $cont_no = $contract->contract->cont_no != null ? $contract->contract->cont_no : "";
        $cont_no_new = $contract->contract->cont_no_new != null ? $contract->contract->cont_no_new : "";
        $letter_no = $contract->contract->letter_no != null ? $contract->contract->letter_no : "";
        $cont_cus_code = $contract->contract->cont_cus_code != null ? $contract->contract->cont_cus_code : "";
        $cont_sta_id = $contract->contract->cont_sta_id != null ? $contract->contract->cont_sta_id : "";
        $cont_cus_nip = $contract->contract->cont_cus_nip != null ? $contract->contract->cont_cus_nip : "";
        $cont_id = $contract->contract->cont_id != null ? $contract->contract->cont_id : "";
        $employee_id = $contract->contract->mem_id != null ? $contract->contract->mem_id : "";
        $customer = $contract->contract->cus_id != null ? $contract->contract->cus_id : "";
        $date = $contract->contract->cont_date != null ? $contract->contract->cont_date : "";
        $sign_contract = $contract->contract->cont_return_date != null ? $contract->contract->cont_return_date : "";
        $contract_start = $contract->contract->cont_start_date != null ? $contract->contract->cont_start_date : "";
        $contract_end = $contract->contract->cont_end_date != null ? $contract->contract->cont_end_date : "";
        if ($request->has('date')) {
            $date = $request->post('date') != null ? $request->post('date') : "";
        } else {
            $date = $contract->contract->cont_date != null ? $contract->contract->cont_date : "";
        }
        if ($request->has('contract_start')) {
            $contract_start = $request->post('contract_start') != null ? $request->post('contract_start') : "";
        } else {
            $contract_start = $contract->contract->cont_start_date != null ? $contract->contract->cont_start_date : "";
        }

        if ($request->has('contract_end')) {
            $contract_end = $request->post('contract_end') != null ? $request->post('contract_end') : "";
        } else {
            $contract_end = $contract->contract->cont_end_date != null ? $contract->contract->cont_end_date : "";
        }

        if ($request->has('position')) {
            $position = $request->post('position') != null ? $request->post('position') : "";
        } else {
            $position = $contract->contract->cont_position != null ? $contract->contract->cont_position : "";
        }

        if ($request->has('departement')) {
            $request->post('departement');
            $departement = $request->post('departement') != null ? $request->post('departement') : "";
        } else {
            $departement = $contract->contract->cont_dept != null ? $contract->contract->cont_dept : "";
        }

        if ($request->has('salary')) {
            $basic_salary = $request->post('salary') != null ? str_replace('.', '', $request->post('salary')) : "";
        } else {
            $basic_salary = $contract->contract->cont_basic_salary != null ? str_replace('.', '', $contract->contract->cont_basic_salary) : "";
        }
        $division = $contract->contract->cont_div != null ? $contract->contract->cont_div : "";
        $project_name = $contract->contract->cont_project != null ? $contract->contract->cont_project : "";
        $site_location = $contract->contract->cont_city_id != null ? $contract->contract->cont_city_id : "";
        $currency = $contract->contract->cur_id != null ? $contract->contract->cur_id : "";
        $note = $contract->contract->cont_note != null ? $contract->contract->cont_note : "";
        $payday_date = $contract->contract->ctrx_mem_pay_tgl != null ? $contract->contract->ctrx_mem_pay_tgl : "";

        $effective_date = $request->post('effective_date') != null ? $request->post('effective_date') : "";
        $offshore = $request->has('offshore') ? str_replace('.', '', $request->post('offshore')) : "";

        if ($date != "") {
            $date = $date;
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d', strtotime($date));
        } else {
            $date = "";
        }

        if ($sign_contract != "") {
            $sign_contract = $sign_contract;
            $sign_contract = str_replace('/', '-', $sign_contract);
            $sign_contract = date('Y-m-d', strtotime($sign_contract));
        } else {
            $sign_contract = "";
        }

        if ($contract_start != "") {
            $contract_start = $contract_start;
            $contract_start = str_replace('/', '-', $contract_start);
            $contract_start = date('Y-m-d', strtotime($contract_start));
        } else {
            $contract_start = "";
        }

        if ($contract_end != "") {
            $contract_end = $contract_end;
            $contract_end = str_replace('/', '-', $contract_end);
            $contract_end = date('Y-m-d', strtotime($contract_end));
        } else {
            $contract_end = "";
        }

        if ($effective_date != "") {
            $effective_date = $effective_date;
            $effective_date = str_replace('/', '-', $effective_date);
            $effective_date = date('Y-m-d', strtotime($effective_date));
        } else {
            $effective_date = "";
        }

        $allowance = [];
        if ($request->post('memo') == 'Y') {

            if ($request->post('condition4') == 1) {

                if ($request->has('allowance_type')) {
                    $allowance = [
                        'allowance_type' => $request->post('allowance_type'),
                        'amount' => str_replace('.', '', $request->post('amount')),
                        'description' => $request->post('description'),
                    ];
                }
            } else {

                if ($contract->allowance) {
                    $allowance_type = '';
                    $amount = '';
                    $description = '';

                    for ($i = 0; $i < count($contract->allowance); $i++) {
                        $allowance_type .= $contract->allowance[$i]->fix_allow_type_id . ',';
                        $amount .= str_replace('.', '', $contract->allowance[$i]->cont_det_tot) . ',';
                        $description .= $contract->allowance[$i]->cont_det_desc . ',';
                    }

                    $allowance = [
                        'allowance_type' => explode(',', substr($allowance_type, 0, -1)),
                        'amount' => explode(',', substr($amount, 0, -1)),
                        'description' => explode(',', substr($description, 0, -1)),
                    ];

                }

            }

        } else {
            if ($contract->allowance) {
                $allowance_type = '';
                $amount = '';
                $description = '';

                for ($i = 0; $i < count($contract->allowance); $i++) {
                    $allowance_type .= $contract->allowance[$i]->fix_allow_type_id . ',';
                    $amount .= str_replace('.', '', $contract->allowance[$i]->cont_det_tot) . ',';
                    $description .= $contract->allowance[$i]->cont_det_desc . ',';
                }

                $allowance = [
                    'allowance_type' => explode(',', substr($allowance_type, 0, -1)),
                    'amount' => explode(',', substr($amount, 0, -1)),
                    'description' => explode(',', substr($description, 0, -1)),
                ];

            }
        }

        $value = [
            'cont_cus_nip' => strip_tags($cont_cus_nip),
            'status' => strip_tags($cont_sta_id),
            'cont_cus_code' => strip_tags($cont_cus_code),
            'letter_no' => strip_tags($letter_no),
            'cont_no_new' => strip_tags($cont_no_new),
            'cont_no' => strip_tags($cont_no),
            'employee_id' => strip_tags($employee_id),
            'customer' => strip_tags($customer),
            'date' => strip_tags($date),
            'sign_contract' => strip_tags($sign_contract),
            'contract_start' => strip_tags($contract_start),
            'contract_end' => strip_tags($contract_end),
            'position' => strip_tags($position),
            'division' => strip_tags($division),
            'departement' => strip_tags($departement),
            'project_name' => strip_tags($project_name),
            'site_location' => strip_tags($site_location),
            'currency' => strip_tags($currency),
            'basic_salary' => strip_tags($basic_salary),
            'note' => strip_tags($note),
            'payday_date' => strip_tags($payday_date),
            'allowance' => $allowance,
            'effective_date' => strip_tags($effective_date),
            'offshore' => strip_tags($offshore),

        ];

        $param = [
            "id_hris" => session('id_hris'),
            "name" => session('name'),
            "token" => session('token'),
            "value" => $value,
        ];
        $rows = json_decode(ElaHelper::myCurl('hris/contract/do-extend', $param));
        if ($request->post('memo') == 'Y') {

            $rows = json_decode(ElaHelper::myCurl('hris/contract/do-extend-memo', $param));
        }
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        $data['customer'] = $customer;
        $data['cont_id'] = md5($rows->cont_id);

        echo json_encode($data);
    }

    public function extendChange(Request $request)
    {

        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $select = '';
        $select .= '<select id="link" style="background-color: #444d58; color: #fff;" class="form-control border-rounded" onchange="javascript:handleSelect(this)">';
        if ($request->has('type') & $request->get('type') == 'allowance') {
            $select .= '<option value="contract">Contract</option>';
            $select .= '<option value="allowance" selected>Allowance</option>';
        } else {
            $select .= '<option value="contract" selected>Contract</option>';
            $select .= '<option value="allowance">Allowance</option>';
        }
        $select .= '</select>';

        $data['select'] = $select;

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['contract'] = json_decode(ElaHelper::myCurl('hris/contract/get-contract-edit', $param));

        $data['id'] = $request->get('id');
        $data['link'] = $request->get('link');
        $data['title'] = 'Contract';
        $data['subtitle'] = 'Extend Contract';

        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "where" => ["cont_sta_id", "!=", "1"],
            "table" => "_contract_status",
        ];
        $data['contract_status'] = json_decode(ElaHelper::myCurl('master-global', $param));
        $param = [
            "order" => ["cont_city_name", "ASC"],
            "fields" => ["cont_city_id", "cont_city_name"],
            "where" => ["cus_id", 0],
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
            "cont_id" => $request->get('id'),
        ];
        $data['allowance'] = json_decode(ElaHelper::myCurl('hris/contract/get-master-allowance-edit', $param));

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        return view('HRIS.administration.contract.extendChange', $data);
    }

    public function extendMemo(Request $request)
    {
        $data = [];

        $data['id'] = $request->get('id');
        $data['link'] = $request->get('link');
        $data['title'] = 'Contract';
        $data['subtitle'] = 'Extend Contract ';

        $param = [
            "id_hris" => session('id_hris'),
            "cont_id" => $request->get('id'),
        ];
        $data['allowance'] = json_decode(ElaHelper::myCurl('hris/contract/get-master-allowance-edit', $param));

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['contract'] = json_decode(ElaHelper::myCurl('hris/contract/get-contract-edit', $param));
        return view('HRIS.administration.contract.extendMemo', $data);
    }

    public function doextendMemo(Request $request)
    {

        $cont_id = $request->post('cont_id');
        $param = [
            "token" => session("token"),
            "id" => md5($cont_id),
        ];

        $contract = json_decode(ElaHelper::myCurl('hris/contract/get-contract-edit', $param));
        $cont_no = $contract->contract->cont_no != null ? $contract->contract->cont_no : "";
        $cont_no_new = $contract->contract->cont_no_new != null ? $contract->contract->cont_no_new : "";
        $letter_no = $contract->contract->letter_no != null ? $contract->contract->letter_no : "";
        $cont_cus_code = $contract->contract->cont_cus_code != null ? $contract->contract->cont_cus_code : "";
        $cont_sta_id = $contract->contract->cont_sta_id != null ? $contract->contract->cont_sta_id : "";
        $cont_cus_nip = $contract->contract->cont_cus_nip != null ? $contract->contract->cont_cus_nip : "";
        $cont_id = $contract->contract->cont_id != null ? $contract->contract->cont_id : "";
        $employee_id = $contract->contract->mem_id != null ? $contract->contract->mem_id : "";
        $customer = $contract->contract->cus_id != null ? $contract->contract->cus_id : "";
        $sign_contract = $contract->contract->cont_return_date != null ? $contract->contract->cont_return_date : "";
        $contract_start = $contract->contract->cont_start_date != null ? $contract->contract->cont_start_date : "";
        $contract_end = $contract->contract->cont_end_date != null ? $contract->contract->cont_end_date : "";
        if ($request->has('position')) {
            $position = $request->post('position') != null ? $request->post('position') : "";
        } else {
            $position = $contract->contract->cont_position != null ? $contract->contract->cont_position : "";
        }

        if ($request->has('departement')) {
            $request->post('departement');
            $departement = $request->post('departement') != null ? $request->post('departement') : "";
        } else {
            $departement = $contract->contract->cont_dept != null ? $contract->contract->cont_dept : "";
        }

        if ($request->has('salary')) {
            $basic_salary = $request->post('salary') != null ? str_replace('.', '', $request->post('salary')) : "";
        } else {
            $basic_salary = $contract->contract->cont_basic_salary != null ? str_replace('.', '', $contract->contract->cont_basic_salary) : "";
        }
        $division = $contract->contract->cont_div != null ? $contract->contract->cont_div : "";
        $project_name = $contract->contract->cont_project != null ? $contract->contract->cont_project : "";
        $site_location = $contract->contract->cont_city_id != null ? $contract->contract->cont_city_id : "";
        $currency = $contract->contract->cur_id != null ? $contract->contract->cur_id : "";
        $note = $contract->contract->cont_note != null ? $contract->contract->cont_note : "";
        $payday_date = $contract->contract->ctrx_mem_pay_tgl != null ? $contract->contract->ctrx_mem_pay_tgl : "";
        $offshore = $contract->contract->cont_offshore != null ? $contract->contract->cont_offshore : "";

        $effective_date = $request->post('effective_date') != null ? $request->post('effective_date') : "";
        $create_date = $request->post('create_date') != null ? $request->post('create_date') : "";

        if ($sign_contract != "") {
            $sign_contract = $sign_contract;
            $sign_contract = str_replace('/', '-', $sign_contract);
            $sign_contract = date('Y-m-d', strtotime($sign_contract));
        } else {
            $sign_contract = "";
        }

        if ($contract_start != "") {
            $contract_start = $contract_start;
            $contract_start = str_replace('/', '-', $contract_start);
            $contract_start = date('Y-m-d', strtotime($contract_start));
        } else {
            $contract_start = "";
        }

        if ($contract_end != "") {
            $contract_end = $contract_end;
            $contract_end = str_replace('/', '-', $contract_end);
            $contract_end = date('Y-m-d', strtotime($contract_end));
        } else {
            $contract_end = "";
        }

        if ($create_date != "") {
            $create_date = $create_date;
            $create_date = str_replace('/', '-', $create_date);
            $create_date = date('Y-m-d', strtotime($create_date));
        } else {
            $create_date = "";
        }

        if ($effective_date != "") {
            $effective_date = $effective_date;
            $effective_date = str_replace('/', '-', $effective_date);
            $effective_date = date('Y-m-d', strtotime($effective_date));
        } else {
            $effective_date = "";
        }

        $allowance = [];

        if ($request->post('condition4') == 1) {

            if ($request->has('allowance_type')) {
                $allowance = [
                    'allowance_type' => $request->post('allowance_type'),
                    'amount' => str_replace('.', '', $request->post('amount')),
                    'description' => $request->post('description'),
                ];
            }
        } else {
            if ($contract->allowance) {
                $allowance_type = '';
                $amount = '';
                $description = '';

                for ($i = 0; $i < count($contract->allowance); $i++) {
                    $allowance_type .= $contract->allowance[$i]->fix_allow_type_id . ',';
                    $amount .= str_replace('.', '', $contract->allowance[$i]->cont_det_tot) . ',';
                    $description .= $contract->allowance[$i]->cont_det_desc . ',';
                }

                $allowance = [
                    'allowance_type' => explode(',', substr($allowance_type, 0, -1)),
                    'amount' => explode(',', substr($amount, 0, -1)),
                    'description' => explode(',', substr($description, 0, -1)),
                ];

            }
        }

        $value = [
            'cont_cus_nip' => strip_tags($cont_cus_nip),
            'status' => strip_tags($cont_sta_id),
            'cont_cus_code' => strip_tags($cont_cus_code),
            'letter_no' => strip_tags($letter_no),
            'cont_no_new' => strip_tags($cont_no_new),
            'cont_no' => strip_tags($cont_no),
            'employee_id' => strip_tags($employee_id),
            'customer' => strip_tags($customer),
            'date' => strip_tags($create_date),
            'sign_contract' => strip_tags($sign_contract),
            'contract_start' => strip_tags($contract_start),
            'contract_end' => strip_tags($contract_end),
            'position' => strip_tags($position),
            'division' => strip_tags($division),
            'departement' => strip_tags($departement),
            'project_name' => strip_tags($project_name),
            'site_location' => strip_tags($site_location),
            'currency' => strip_tags($currency),
            'basic_salary' => strip_tags($basic_salary),
            'note' => strip_tags($note),
            'payday_date' => strip_tags($payday_date),
            'allowance' => $allowance,
            'effective_date' => strip_tags($effective_date),
            'offshore' => strip_tags($offshore),
        ];

        $param = [
            "id_hris" => session('id_hris'),
            "name" => session('name'),
            "token" => session('token'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/contract/do-extend-memo', $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        $data['customer'] = $customer;
        $data['cont_id'] = md5($rows->cont_id);

        echo json_encode($data);
    }

    public function upload(Request $request)
    {
        $data['id'] = $request->get('id');
        $data['name'] = strtolower($request->get('name'));
        $data['link'] = $request->get('link');
        $data['title'] = 'Upload File Contract';
        $data['subtitle'] = 'List Employee';

        return view('HRIS.administration.contract.upload', $data);

    }

    public function doUpload(Request $request)
    {
        $id = $request->post('id') != null ? $request->post('id') : "";
        $name = $request->post('name') != null ? $request->post('name') : "";

        if ($request->hasFile('file')) {
            $file = $request->file('file')->getClientOriginalExtension();

            $fileName = str_slug($name) . '-' . date('YmdHis') . str_random(5) . '.' . $file;
            $destinationPath = base_path('public/hris/files/employee/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $request->file('file')->move($destinationPath, $fileName);
            $file = $fileName;

            $value = [
                'file' => $file,
            ];

            $urlMenu = 'hris/contract/do-upload';
            $param = [
                "id_hris" => session('id_hris'),
                "id" => $id,
                "token" => session('token'),
                "name" => session('name'),
                "value" => $value,
            ];
            $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
            $data['response_code'] = $rows->response_code;
            $data['message'] = $rows->message;
            echo json_encode($data);
        } else {

        }
    }

    public function resign(Request $request)
    {
        $data['id'] = $request->get('id');
        $data['link'] = $request->get('link');
        $data['title'] = 'Resign Contract';
        $data['subtitle'] = 'List Employee';

        return view('HRIS.administration.contract.resign', $data);

    }
    public function doResign(Request $request)
    {
        $id = $request->post('id') != null ? $request->post('id') : "";
        $status = $request->post('status') != null ? $request->post('status') : "";

        if ($request->post('date') != "" && $request->post('date') != null) {
            $date = $request->post('date');
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d', strtotime($date));
        } else {
            $date = "";
        }

        $value = [
            'date' => $date,
            'status' => $status,
        ];
        $urlMenu = 'hris/contract/do-resign';
        $param = [
            "id_hris" => session('id_hris'),
            "id" => $id,
            "token" => session('token'),
            "name" => session('name'),
            "value" => $value,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function detail(Request $request)
    {
        if ($request->get('id') == '' or $request->get('link') == '') {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index"
                </script>';
        }

        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $data['link'] = $request->get('link');
        $data['id'] = $request->get('id');

        $data['title'] = 'Contract';
        $data['subtitle'] = 'Detail Contract';
        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['contract'] = json_decode(ElaHelper::myCurl('hris/contract/get-contract', $param));
        return view('HRIS.administration.contract.detail', $data);
    }

    public function doDelete(Request $request)
    {

        $cont_id = $request->post('id');
        $urlMenu = 'hris/contract/do-delete';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "cont_id" => $cont_id,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doCancel(Request $request)
    {

        $cont_id = $request->post('id');
        $urlMenu = 'hris/contract/do-cancel';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "cont_id" => $cont_id,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function pdf(Request $request)
    {

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $res = json_decode(ElaHelper::myCurl('hris/contract/get-contract-pdf', $param));
        $now = date('d-m-Y', strtotime($res->contract->cont_date));
        $hari = array(1 => 'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        );

        $hari_e = array(1 => 'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        );

        $bulan = array(1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        );

        $bulan_e = array(1 => 'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        );
        $split = explode('-', $now);
        $num = date('N', strtotime(date('d-m-Y')));

        $today_day_numb = $split[0];
        $today_day = $hari[$num];
        $today_day_e = $hari_e[$num];
        $today_month = $bulan[(int) $split[1]];
        $today_month_e = $bulan_e[(int) $split[1]];
        $today_year = $split[2];

        $split_start_date = explode('/', $res->contract->cont_start_date);
        $num_start_date = date('N', strtotime($res->contract->cont_start_date));

        $start_date_day_numb = $split_start_date[0];
        $start_date_day = $hari[$num_start_date];
        $start_date_day_e = $hari_e[$num_start_date];
        $start_date_month = $bulan[(int) $split_start_date[1]];
        $start_date_month_e = $bulan_e[(int) $split_start_date[1]];
        $start_date_year = $split_start_date[2];

        if ($res->contract->cont_sta_id == 3) {

            $end_date_day_numb = "";
            $end_date_day = "";
            $end_date_day_e = "";
            $end_date_month = "";
            $end_date_month_e = "";
            $end_date_year = "";

        } else {

            $split_end_date = explode('/', $res->contract->cont_end_date);
            $num_end_date = date('N', strtotime($res->contract->cont_end_date));

            $end_date_day_numb = $split_end_date[0];
            $end_date_day = $hari[$num_end_date];
            $end_date_day_e = $hari_e[$num_end_date];
            $end_date_month = $bulan[(int) $split_end_date[1]];
            $end_date_month_e = $bulan_e[(int) $split_end_date[1]];
            $end_date_year = $split_end_date[2];

        }

        $split_dob = explode('/', $res->contract->mem_dob);
        $num_dob = date('N', strtotime($res->contract->mem_dob));

        $dob_day_numb = $split_dob[0];
        $dob_day = $hari[$num_dob];
        $dob_day_e = $hari_e[$num_dob];
        $dob_month = $bulan[(int) $split_dob[1]];
        $dob_month_e = $bulan_e[(int) $split_dob[1]];
        $dob_year = $split_dob[2];
        $mem_dob_city = $res->contract->mem_dob_city;

        if ($res->contract->effective_date != '') {
            $split_effective_date = explode('/', $res->contract->effective_date);
            $num_effective_date = date('N', strtotime($res->contract->effective_date));

            $effective_date_day_numb = $split_effective_date[0];
            $effective_date_day = $hari[$num_effective_date];
            $effective_date_day_e = $hari_e[$num_effective_date];
            $effective_date_month = $bulan[(int) $split_effective_date[1]];
            $effective_date_month_e = $bulan_e[(int) $split_effective_date[1]];
            $effective_date_year = $split_effective_date[2];
        } else {

            $effective_date_day_numb = "";
            $effective_date_day = "";
            $effective_date_day_e = "";
            $effective_date_month = "";
            $effective_date_month_e = "";
            $effective_date_year = "";
        }

        $interval = $res->contract->interval_contract / 30;
        if (floor($interval) < 1) {
            $interval_contract = 1;
        } else {
            $interval_contract = floor($interval);
        }

        if ($res->contract->age != null) {
            $age = floor($res->contract->age / 360);
        } else {
            $age = '-';

        }

        if ($request->get('type') == 'eng') {
            if ($res->contract->ctrx_mem_pay_tgl != '') {
                $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
                if (($res->contract->ctrx_mem_pay_tgl % 100) >= 11 && ($res->contract->ctrx_mem_pay_tgl % 100) <= 13) {
                    $abbreviation = $res->contract->ctrx_mem_pay_tgl . 'th';
                } else {
                    $abbreviation = $res->contract->ctrx_mem_pay_tgl . $ends[$res->contract->ctrx_mem_pay_tgl % 10];
                }

                $pay_tgl = $abbreviation;
            } else {
                $pay_tgl = '-';
            }
        } else {
            $pay_tgl = $res->contract->ctrx_mem_pay_tgl;
        }

        $cur_name = $res->contract->cur_name;
        $let_no_out = $res->contract->let_no_out;
        $approver = 'Kukandi';
        $approver_position = 'Deputy Head Manpower Solutions Outsourcing';
        $approver_position2 = 'Deputy Head MSO';

        $name = ucwords(strtolower($res->contract->mem_name));
        $customer = $res->contract->cus_name;
        $address = $res->contract->mem_address;

        $cont_no_footer = $request->get('type') == 'addendum' ? $res->contract->let_no_out : $res->contract->cont_no_new;

        $cont_no_new = $res->contract->cont_no_new;
        $position = $res->contract->cont_position;
        $bank_name = $res->contract->bank_name;
        $bank_ac = $res->contract->mem_bank_ac;
        $bank_an = $res->contract->mem_bank_an;
        $start_date = $res->contract->cont_start_date;
        $end_date = $res->contract->cont_end_date;
        $cur_id = $res->contract->cur_id;
        $cont_basic_salary2 = str_replace('.', '', $res->contract->cont_basic_salary);
        $basic_salary = $res->contract->cont_basic_salary;

        if ($res->contract->cur_id == 'expatriate') {
            $cont_tot = $cont_basic_salary2;
        } else {
            $cont_tot = $res->contract->cont_tot;
        }

        $total = number_format($cont_tot, 0, ".", ".");
        $allowance_salary = ($cont_tot - $cont_basic_salary2);

        $total_spell = ElaHelper::convert($cont_tot);
        $total_spell_e = ElaHelper::convert_e($cont_tot);
        $gender = $res->contract->mem_gender != 'L' ? 'Wanita' : 'Pria';
        $gender_e = $res->contract->mem_gender != 'L' ? 'Female' : 'Male';
        $citizenship = $res->contract->mem_citizenship;
        if ($citizenship != 'expatriate') {
            $identitas = 'KTP';
            $id_number = $res->contract->mem_ktp_no;
        } else {
            $identitas = 'Passport';
            $id_number = $res->contract->mem_passport;
        }

        $cont_sta_id = $res->contract->cont_sta_id;
        $cont_sta_name = $res->contract->cont_sta_name;
        $cont_dept = $res->contract->cont_dept;

        $cont_tot_before = $res->contract->cont_tot_before;
        $cont_position_before = $res->contract->cont_position_before;
        $cont_dept_before = $res->contract->cont_dept_before;

        $basic_salary_before = $res->contract->basic_salary_before;

        if ($cont_tot_before != '') {
            $total_before = number_format($cont_tot_before, 0, ".", ".");
        } else {
            $total_before = '';

        }

        if ($basic_salary_before != '') {
            $basic_salary_before = number_format($basic_salary_before, 0, ".", ".");
        } else {
            $basic_salary_before = '';

        }

        if ($basic_salary != '') {
            $basic_salary = number_format($basic_salary, 0, ".", ".");
        } else {
            $basic_salary = '';

        }

        $allowance_tot_before = floatval($res->contract->cont_tot_before) - floatval($res->contract->basic_salary_before);
        $allowance_tot = floatval($res->contract->cont_tot) - floatval($res->contract->cont_basic_salary);

        $pdf = (object) [
            'cur_name' => $cur_name,
            'let_no_out' => $let_no_out,
            'cont_no_new' => $cont_no_new,
            'name' => $name,
            'address' => $address,
            'customer' => $customer,
            'position' => ucwords($position),
            'bank_name' => $bank_name,
            'bank_ac' => $bank_ac,
            'bank_an' => $bank_an,
            'start_date' => $start_date,
            'end_date' => $start_date,
            'total' => $total,
            'basic_salary' => $basic_salary,
            'cur_id' => $cur_id,
            'now' => date('d-M-Y', strtotime($res->contract->cont_date)),
            'today_day_numb' => $today_day_numb,
            'today_day' => $today_day,
            'today_day_e' => $today_day_e,
            'today_month' => $today_month,
            'today_month_e' => $today_month_e,
            'today_year' => $today_year,
            'total_spell' => ucwords($total_spell),
            'total_spell_e' => ucwords($total_spell_e),
            'gender' => $gender,
            'gender_e' => $gender_e,
            'identitas' => $identitas,
            'id_number' => $id_number,
            'start_date_day_numb' => $start_date_day_numb,
            'start_date_day' => $start_date_day,
            'start_date_day_e' => $start_date_day_e,
            'start_date_month' => $start_date_month,
            'start_date_month_e' => $start_date_month_e,
            'start_date_year' => $start_date_year,
            'end_date_day_numb' => $end_date_day_numb,
            'end_date_day' => $end_date_day,
            'end_date_day_e' => $end_date_day_e,
            'end_date_month' => $end_date_month,
            'end_date_month_e' => $end_date_month_e,
            'end_date_year' => $end_date_year,
            'pay_tgl' => $pay_tgl,
            'approver' => $approver,
            'approver_position' => $approver_position,
            'approver_position2' => $approver_position2,
            'age' => $age,
            'interval_contract' => $interval_contract,
            'dob_day_numb' => $dob_day_numb,
            'dob_day' => $dob_day,
            'dob_day_e' => $dob_day_e,
            'dob_month' => $dob_month,
            'dob_month_e' => $dob_month_e,
            'dob_year' => $dob_year,
            'effective_date_day_numb' => $effective_date_day_numb,
            'effective_date_day' => $effective_date_day,
            'effective_date_day_e' => $effective_date_day_e,
            'effective_date_month' => $effective_date_month,
            'effective_date_month_e' => $effective_date_month_e,
            'effective_date_year' => $effective_date_year,
            'mem_dob_city' => $mem_dob_city,
            'cont_no_footer' => $cont_no_footer,
            'allowance_salary' => $allowance_salary,
            'cont_sta_name' => $cont_sta_name,
            'departement' => $cont_dept,
            'basic_salary_before' => $basic_salary_before,
            'total_before' => $total_before,
            'position_before' => $cont_position_before,
            'departement_before' => $cont_dept_before,
            'alltype' => $res->alltype,
            'allowance_tot_before' => $allowance_tot_before,
            'allowance_tot' => $allowance_tot,

        ];
        $data['contract'] = $pdf;
        if ($request->get('type') == 'addendum') {
            $let = explode('/', $let_no_out);

            if ($let[1] == 12) {

                if ($citizenship == 'expatriate') {
                    $pdf = PDF::loadView('HRIS.administration.contract.pdfAddendumMemoEng', $data)->setPaper('a4', 'portrait');
                } else {
                    $pdf = PDF::loadView('HRIS.administration.contract.pdfAddendumMemo', $data)->setPaper('a4', 'portrait');
                }

            } else {
                if ($res->contract->cont_sta_id == 4) {
                    if ($citizenship == 'expatriate') {
                        $pdf = PDF::loadView('HRIS.administration.contract.pdfAddendum', $data)->setPaper('a4', 'portrait');
                    } else {
                        $pdf = PDF::loadView('HRIS.administration.contract.pdfAddendumIndo', $data)->setPaper('a4', 'portrait');
                    }
                } else {
                    $pdf = PDF::loadView('HRIS.administration.contract.pdfAddendumPKWT', $data)->setPaper('a4', 'portrait');
                }

            }
            return $pdf->stream($name . '(' . $cont_no_footer . ').pdf');

        } else if ($request->get('type') == 'tha') {

            $pdf = PDF::loadView('HRIS.administration.contract.pdfTha', $data)->setPaper('a4', 'portrait');
            return $pdf->stream($name . '(' . $cont_no_footer . ').pdf');

            // $pdf = new FPDF();
            // // Add Thai font
            // $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
            // $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');
            // $pdf->AddPage();
            // $pdf->SetFont('THSarabunNew','',16);
            // $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', 'สวัสดี'));
            // $pdf->SetFont('THSarabunNew','B',16);
            // $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', 'สวัสดี'));
            // $pdf->Output();

        } else {

            switch ($cont_sta_id) {
                case 2:
                    $pdf = PDF::loadView('HRIS.administration.contract.pdfPKWT', $data)->setPaper('a4', 'portrait');
                    break;
                case 3:
                    if ($request->get('type') == 'eng') {
                        $pdf = PDF::loadView('HRIS.administration.contract.pdfPKWTTEng', $data)->setPaper('a4', 'portrait');
                    } else {
                        $pdf = PDF::loadView('HRIS.administration.contract.pdfPKWTT', $data)->setPaper('a4', 'portrait');
                    }
                    break;
                case 4:
                    if ($request->get('type') == 'eng') {
                        $pdf = PDF::loadView('HRIS.administration.contract.pdfKemitraanEng', $data)->setPaper('a4', 'portrait');
                    } else {
                        $pdf = PDF::loadView('HRIS.administration.contract.pdfKemitraanInd', $data)->setPaper('a4', 'portrait');
                        // $pdf = PDF::loadView('HRIS.administration.contract.pdfPKWTTThailand', $data)->setPaper('a4', 'portrait');

                    }
                    break;
                default:
                    $pdf = PDF::loadView('HRIS.administration.contract.pdfPKWTT', $data)->setPaper('a4', 'portrait');
            }
            return $pdf->stream($name . '(' . $cont_no_footer . ').pdf');

        }
    }

    public function filterExcel(Request $request)
    {

        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index"
                </script>';
        }
        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));

        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "where" => ["cont_sta_id", "!=", "1"],
            "table" => "_contract_status",
        ];
        $data['contract_status'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["mem_name", "ASC"],
            "fields" => ["mem_id", "mem_name"],
            "where" => ["mem_active", "Y"],
            "table" => "_member",
        ];
        $data['employee'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["cont_city_name", "ASC"],
            "fields" => ["cont_city_id", "cont_city_name"],
            "where" => ["cus_id", 0],
            "table" => "_contract_city",
        ];
        $data['contract_city'] = json_decode(ElaHelper::myCurl('master-global', $param));
        $data['link'] = $request->get('link');
        $data['title'] = 'Filter Excel Contract';
        $data['subtitle'] = 'List Report Final';
        return view('HRIS.administration.contract.filterExcel', $data);
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
        $title = 'Report Contract-' . date('dmyHis');

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
                $sheet->setCellValue('AJ1', 'Gross Salary');
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
                ];

                $contract = json_decode(ElaHelper::myCurl('hris/contract/get-excel', $param));

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
                    $sheet->setCellValue('AJ' . $i, $contract->result[$a]->cont_tot);
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
        $title = 'Report Contract-' . date('dmyHis');

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

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "customer" => $request->get('cus_id'),
                ];

                $contract = json_decode(ElaHelper::myCurl('hris/contract/get-excel', $param));

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

    public function template(Request $request)
    {

        return Excel::create('Contract HRIS', function ($excel) {
            $excel->sheet('Contract HRIS', function ($sheet) {
                $sheet->cell('A1', function ($cell) {$cell->setValue('No');});

                $sheet->cell('B1', function ($cell) {$cell->setValue('Name');});

                $sheet->cell('C1', function ($cell) {$cell->setValue('NIP');});
                $sheet->cell('C1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('D1', function ($cell) {$cell->setValue('Create Date (dd/mm/yyyy)');});
                $sheet->cell('D1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('E1', function ($cell) {$cell->setValue('Return Signed (dd/mm/yyyy)');});

                $sheet->cell('F1', function ($cell) {$cell->setValue('Contract Start (dd/mm/yyyy)');});
                $sheet->cell('F1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('G1', function ($cell) {$cell->setValue('Contract End (dd/mm/yyyy)');});
                $sheet->cell('G1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('H1', function ($cell) {$cell->setValue('Position');});
                $sheet->cell('H1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('I1', function ($cell) {$cell->setValue('Division/Cost Center');});

                $sheet->cell('J1', function ($cell) {$cell->setValue('Department');});

                $sheet->cell('K1', function ($cell) {$cell->setValue('Project Name');});

                $sheet->cell('L1', function ($cell) {$cell->setValue('Status');});
                $sheet->cell('L1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('M1', function ($cell) {$cell->setValue('Site Location');});
                $sheet->cell('M1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('N1', function ($cell) {$cell->setValue('Currency');});
                $sheet->cell('N1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('O1', function ($cell) {$cell->setValue('Basic salary / Onshore');});
                $sheet->cell('O1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('P1', function ($cell) {$cell->setValue('Offshore');});

                $sheet->cell('Q1', function ($cell) {$cell->setValue('Note');});

                $sheet->cell('R1', function ($cell) {$cell->setValue('Payday Date');});
                $sheet->cell('R1', function ($cell) {$cell->setBackground('#CCCCCC');});

                $sheet->cell('S1', function ($cell) {$cell->setValue('ACCOMODATION');});
                $sheet->cell('T1', function ($cell) {$cell->setValue('LAPTOP');});
                $sheet->cell('U1', function ($cell) {$cell->setValue('MEAL');});
                $sheet->cell('V1', function ($cell) {$cell->setValue('TRANSPORTATION');});
                $sheet->cell('W1', function ($cell) {$cell->setValue('MEDICAL');});
                $sheet->cell('X1', function ($cell) {$cell->setValue('OVERTIME');});
                $sheet->cell('Y1', function ($cell) {$cell->setValue('PHONE');});
                $sheet->cell('Z1', function ($cell) {$cell->setValue('PARKING');});
                $sheet->cell('AA1', function ($cell) {$cell->setValue('POSITION ALLOWANCE');});
                $sheet->cell('AB1', function ($cell) {$cell->setValue('RELOCATION');});
                $sheet->cell('AC1', function ($cell) {$cell->setValue('TOOLS');});
                $sheet->cell('AD1', function ($cell) {$cell->setValue('OTHERS');});
                $sheet->cell('AE1', function ($cell) {$cell->setValue('WORK ALLOWANCE');});
                $sheet->cell('AF1', function ($cell) {$cell->setValue('TUNJUNGAN TIDAK TETAP');});
                $sheet->cell('AG1', function ($cell) {$cell->setValue('TUNJANGAN KHUSUS (LEMBUR)');});
                $sheet->cell('AH1', function ($cell) {$cell->setValue('FLEXIBLE ALLOWANCE');});
                $sheet->cell('AI1', function ($cell) {$cell->setValue('COMMUNICATION ALLOWANCE');});

            });
        })->download('xlsx');
    }

    public function rule(Request $request)
    {
        $urlMenu = 'master-global';

        $param = [
            "order" => ["cont_city_name", "ASC"],
            "fields" => ["cont_city_id", "cont_city_name"],
            "where" => ["cus_id", "=", "0"],
            "where2" => ["cont_city_active", "=", "Y"],
            "table" => "_contract_city",
        ];
        $data['contract_city'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "table" => "_mcurrency",
        ];
        $data['currency'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "order" => ["cont_sta_name", "ASC"],
            "fields" => ["cont_sta_id", "cont_sta_name"],
            "where" => ["cont_sta_id", "!=", "1"],
            "table" => "_contract_status",
        ];
        $data['status'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $data['title'] = 'Contract';
        $data['subtitle'] = 'Rule Contract';

        return view('HRIS.administration.contract.rule', $data);
    }

    public function uploadContract(Request $request)
    {
        $data['id'] = $request->get('id');
        $data['name'] = strtolower($request->get('name'));
        $data['link'] = $request->get('link');
        $data['title'] = 'Upload Contract';
        $data['subtitle'] = 'List Employee';

        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        return view('HRIS.administration.contract.uploadContract', $data);
    }

    public function doUploadContract(Request $request)
    {
        $customer = $request->post('customer');
        if ($request->hasFile('file')) {
            try {
                $path = $request->file('file')->getRealPath();
                $filename = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
                $excelData = Excel::load($path)->get();
                if ($excelData->count()) {
                    $arr = [];
                    $fieldName = array('no',
                        'name',
                        'nip',
                        'create_date_ddmmyyyy',
                        'return_signed_ddmmyyyy',
                        'contract_start_ddmmyyyy',
                        'contract_end_ddmmyyyy',
                        'position',
                        'divisioncost_center',
                        'department',
                        'project_name',
                        'status',
                        'site_location',
                        'currency',
                        'basic_salary_onshore',
                        'offshore',
                        'note',
                        'payday_date',
                        'accomodation',
                        'laptop',
                        'meal',
                        'transportation',
                        'medical',
                        'overtime',
                        'phone',
                        'parking',
                        'position_allowance',
                        'relocation',
                        'tools',
                        'others',
                        'work_allowance',
                        'tunjungan_tidak_tetap',
                        'tunjangan_khusus_lembur',
                        'flexible_allowance',
                        'communication_allowance',

                    );
                    $headerRow = $excelData->first()->keys()->toArray();
                    $arr3 = array_diff($fieldName, $headerRow);
                    if (count($arr3) == 0) {
                        foreach ($excelData as $key => $value) {

                            if ($value["create_date_ddmmyyyy"] != "") {
                                $create_date = $value["create_date_ddmmyyyy"];
                                $create_date = str_replace('/', '-', $create_date);
                                $create_date = date('Y-m-d', strtotime($create_date));
                            } else {
                                $create_date = "";
                            }

                            if ($value["return_signed_ddmmyyyy"] != "") {
                                $return_signed = $value["return_signed_ddmmyyyy"];
                                $return_signed = str_replace('/', '-', $return_signed);
                                $return_signed = date('Y-m-d', strtotime($return_signed));
                            } else {
                                $return_signed = "";
                            }

                            if ($value["contract_start_ddmmyyyy"] != "") {
                                $contract_start = $value["contract_start_ddmmyyyy"];
                                $contract_start = str_replace('/', '-', $contract_start);
                                $contract_start = date('Y-m-d', strtotime($contract_start));
                            } else {
                                $contract_start = "";
                            }

                            if ($value["contract_end_ddmmyyyy"] != "") {
                                $contract_end = $value["contract_end_ddmmyyyy"];
                                $contract_end = str_replace('/', '-', $contract_end);
                                $contract_end = date('Y-m-d', strtotime($contract_end));
                            } else {
                                $contract_end = "";
                            }

                            $arr[] = [
                                'name' => trim(strip_tags($value["name"])),
                                'nip' => trim(strip_tags($value["nip"])),
                                'create_date_ddmmyyyy' => strip_tags($create_date),
                                'return_signed_ddmmyyyy' => strip_tags($return_signed),
                                'contract_start_ddmmyyyy' => strip_tags($contract_start),
                                'contract_end_ddmmyyyy' => strip_tags($contract_end),
                                'position' => trim(strip_tags($value["position"])),
                                'divisioncost_center' => trim(strip_tags($value["divisioncost_center"])),
                                'department' => trim(strip_tags($value["department"])),
                                'project_name' => trim(strip_tags($value["project_name"])),
                                'status' => trim(strip_tags($value["status"])),
                                'site_location' => trim(strip_tags($value["site_location"])),
                                'currency' => trim(strip_tags($value["currency"])),
                                'basic_salary_onshore' => trim(strip_tags($value["basic_salary_onshore"])),
                                'note' => trim(strip_tags($value["note"])),
                                'payday_date' => trim(strip_tags($value["payday_date"])),
                                'accomodation' => trim(strip_tags($value["accomodation"])),
                                'laptop' => trim(strip_tags($value["laptop"])),
                                'meal' => trim(strip_tags($value["meal"])),
                                'transportation' => trim(strip_tags($value["transportation"])),
                                'medical' => trim(strip_tags($value["medical"])),
                                'overtime' => trim(strip_tags($value["overtime"])),
                                'phone' => trim(strip_tags($value["phone"])),
                                'parking' => trim(strip_tags($value["parking"])),
                                'position_allowance' => trim(strip_tags($value["position_allowance"])),
                                'relocation' => trim(strip_tags($value["relocation"])),
                                'tools' => trim(strip_tags($value["tools"])),
                                'others' => trim(strip_tags($value["others"])),
                                'work_allowance' => trim(strip_tags($value["work_allowance"])),
                                'tunjungan_tidak_tetap' => trim(strip_tags($value["tunjungan_tidak_tetap"])),
                                'tunjangan_khusus_lembur' => trim(strip_tags($value["tunjangan_khusus_lembur"])),
                                'flexible_allowance' => trim(strip_tags($value["flexible_allowance"])),
                                'communication_allowance' => trim(strip_tags($value["communication_allowance"])),
                                'offshore' => trim(strip_tags($value["offshore"])),

                            ];
                        }

                        if (!empty($arr)) {
                            $dataDoc = array(
                                'contract' => $arr,
                                'customer' => $customer,
                                'token' => session('token'),
                                'name' => session('name'),
                                'id_hris' => session('id_hris'),
                            );

                            $model = ElaHelper::myCurl('hris/contract/do-upload-contract', $dataDoc);

                            $result = json_decode($model, true);
                            $data = array(
                                'customer' => $customer,
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

    public function listDataHistory(Request $request)
    {
        $draw = $request->post('draw');
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => session('id_hris'),
        ];
        $profile = json_decode(ElaHelper::myCurl('hris/get-profile-hris', $param));

        $urlMenu = 'hris/contract/history';

        if ($request->post('start') == 0) {
            $page = 1;
        } else {
            $page = ($request->post('start') / $request->post('length')) + 1;
        }

        $sort_by = $request->post('order')[0]['column'];
        $dir = $request->post('order')[0]['dir'];

        if ($request['columns'][3]['search']['value'] != "" && $request['columns'][3]['search']['value'] != null) {
            $start_date = $request['columns'][3]['search']['value'];
            $start_date = str_replace('/', '-', $start_date);
            $start_date = date('Y-m-d', strtotime($start_date));
        } else {
            $start_date = "";
        }

        if ($request['columns'][4]['search']['value'] != "" && $request['columns'][4]['search']['value'] != null) {
            $end_date = $request['columns'][4]['search']['value'];
            $end_date = str_replace('/', '-', $end_date);
            $end_date = date('Y-m-d', strtotime($end_date));
        } else {
            $end_date = "";
        }

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "mem_id" => $request->post('mem_id'),
            "page" => $page,
            "per_page" => $request->post('length'),
            "search" => $search,
            "sort_by" => $sort_by,
            "dir" => $dir,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['cont_his_id'] = $rows->data[$i]->cont_his_id;
                $nestedData['type'] = $rows->data[$i]->type;
                $nestedData['no_contract'] = $rows->data[$i]->no_contract;
                $nestedData['content'] = $rows->data[$i]->content;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $nestedData['updated_date'] = $rows->data[$i]->updated_date;

                $menu_access = '';
                if ($access) {
                    if ($access->menu_acc_add == '1') {
                        $menu_access .= '<a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->cont_his_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-search"></i> Detail</a>';
                    }
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

    public function historyDetail(Request $request)
    {

        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $data['link'] = $request->get('link');
        $data['id'] = $request->get('id');

        $data['title'] = 'Contract';
        $data['subtitle'] = 'Detail Contract';
        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $contract = json_decode(ElaHelper::myCurl('hris/contract/history-detail', $param));

        $data['history'] = $contract->history[0];
        $data['contract'] = json_decode($contract->history[0]->content);

        return view('HRIS.administration.contract.historyDetail', $data);
    }

    public function getEmployee(Request $request)
    {
        $param = [
            "search" => $request->get('term'),

        ];

        $contract = json_decode(ElaHelper::myCurl('hris/contract/get-employee-nocontract', $param));
        echo json_encode($contract);
        exit;

    }

}
