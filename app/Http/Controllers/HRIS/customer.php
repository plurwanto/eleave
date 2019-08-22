<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;
use Session;

class customer extends Controller
{
    public $menuID = 33;

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
                        window.location.href="' . env('APP_URL') . '/index";
                      </script>';

            }
        } else {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index"
                  </script>';
        }

        $data['link'] = $request->get('link');
        $link = ['all',
            'approved',
            'not-approved'];

        $name_link = ['All',
            'Approved',
            'Not Approved'];
        $select = '';
        $select .= '<select style="width:150px; margin-right:10px" class="form-control border-rounded pull-left"  border-rounded" onchange="javascript:handleSelect(this)">';
        $select2 = '';
        for ($i = 0; $i < count($link); $i++) {
            if ($i == 0) {
                $select2 .= '<option value="' . env('APP_URL') . '/hris/customer">' . $name_link[$i] . '</option>';
            } else {
                if ($request->get('link') == $link[$i]) {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/customer?link=' . $link[$i] . '" selected>' . $name_link[$i] . '</option>';
                } else {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/customer?link=' . $link[$i] . '">' . $name_link[$i] . '</option>';
                }
            }

        }
        $select .= $select2;
        $select .= '</select><input type="hidden" id="link" value="' . $request->get('link') . '">';

        $data['select'] = $select;

        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $data['title'] = 'Customer';
        if ($request->get('link')) {
            switch ($request->get('link')) {
                case 'approved':
                    $data['subtitle'] = 'List Customer Approved';
                    return view('HRIS.customer.indexApproved', $data);
                    break;
                case 'not-approved':
                    $data['subtitle'] = 'List Customer Not Approved';
                    return view('HRIS.customer.indexNotApproved', $data);
                    break;
                default;
                    $data['subtitle'] = 'List Customer';
                    return view('HRIS.customer.index', $data);
            }
        } else {
            $data['subtitle'] = 'List Customer';
            return view('HRIS.customer.index', $data);
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

        $urlMenu = 'hris/customer';

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
            "search_corporation" => $request['columns'][1]['search']['value'],
            "search_code" => $request['columns'][2]['search']['value'],
            "search_branch" => $request['columns'][3]['search']['value'],
            "search_telco" => $request['columns'][4]['search']['value'],
            "search_isactive" => $request['columns'][5]['search']['value'],
            "search_kam_name" => $request['columns'][6]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $cus_active = $rows->data[$i]->cus_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";
                $nestedData['no'] = $a++;
                $nestedData['cus_id'] = $rows->data[$i]->cus_id;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['cus_corporation'] = $rows->data[$i]->cus_corporation;
                $nestedData['cus_code'] = $rows->data[$i]->cus_code;
                $nestedData['br_name'] = $rows->data[$i]->br_name;
                $nestedData['cus_telco'] = $rows->data[$i]->cus_telco;
                $nestedData['cus_active'] = $cus_active;
                $nestedData['kam_name'] = $rows->data[$i]->kam_name;
                $nestedData['cus_user'] = $rows->data[$i]->cus_user;

                $menu_access = '';
                if ($access) {
                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                    }

                    if ($access->menu_acc_del == '1') {
                        $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                    }
                }
                $menu_access .= '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
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

    public function listDataApproved(Request $request)
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

        $urlMenu = 'hris/customer';

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
            "cus_req" => 'approved',
            "search_name" => $request['columns'][0]['search']['value'],
            "search_corporation" => $request['columns'][1]['search']['value'],
            "search_code" => $request['columns'][2]['search']['value'],
            "search_branch" => $request['columns'][3]['search']['value'],
            "search_telco" => $request['columns'][4]['search']['value'],
            "search_isactive" => $request['columns'][5]['search']['value'],
            "search_kam_name" => $request['columns'][6]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $cus_active = $rows->data[$i]->cus_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";

                $nestedData['no'] = $a++;
                $nestedData['cus_id'] = $rows->data[$i]->cus_id;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['cus_corporation'] = $rows->data[$i]->cus_corporation;
                $nestedData['cus_code'] = $rows->data[$i]->cus_code;
                $nestedData['br_name'] = $rows->data[$i]->br_name;
                $nestedData['cus_telco'] = $rows->data[$i]->cus_telco;
                $nestedData['cus_active'] = $cus_active;
                $nestedData['kam_name'] = $rows->data[$i]->kam_name;
                $nestedData['cus_user'] = $rows->data[$i]->cus_user;

                $menu_access = '';
                if ($access) {

                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                    <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
                        <i class="fa fa-pencil-square-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                    }

                    if ($access->menu_acc_del == '1') {
                        $menu_access .= '

                    <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
                        <i class="fa fa-trash-o" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                    }
                }
                $menu_access .= '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
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

    public function listDataNonApproved(Request $request)
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
            "cus_req" => 'not-approved',
            "search_name" => $request['columns'][0]['search']['value'],
            "search_corporation" => $request['columns'][1]['search']['value'],
            "search_code" => $request['columns'][2]['search']['value'],
            "search_branch" => $request['columns'][3]['search']['value'],
            "search_telco" => $request['columns'][4]['search']['value'],
            "search_isactive" => $request['columns'][5]['search']['value'],
            "search_kam_name" => $request['columns'][6]['search']['value'],
        ];
        $rows = json_decode(ElaHelper::myCurl('hris/customer', $param));
        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $cus_active = $rows->data[$i]->cus_active == 'Y' ? "<label class='label label-sm border-rounded  label-success'>Active</label>" : "<label class='label label-sm border-rounded  label-danger'>No Active</label>";

                $nestedData['no'] = $a++;
                $nestedData['cus_id'] = $rows->data[$i]->cus_id;
                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['cus_corporation'] = $rows->data[$i]->cus_corporation;
                $nestedData['cus_code'] = $rows->data[$i]->cus_code;
                $nestedData['br_name'] = $rows->data[$i]->br_name;
                $nestedData['cus_telco'] = $rows->data[$i]->cus_telco;
                $nestedData['cus_active'] = $cus_active;
                $nestedData['kam_name'] = $rows->data[$i]->kam_name;
                $nestedData['cus_user'] = $rows->data[$i]->cus_user;

                $menu_access = '';

                if ($access) {

                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                                        <li>
                                            <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-pencil-square-o"></i> Edit </a>
                                        </li>';
                    }
                    if ($access->menu_acc_approve == '1') {
                        $menu_access .= '
                                        <li>
                                            <a dataaction="approve" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
                                            <i class="fa fa-check-circle-o"></i> Approve
                                            </a>
                                        </li>';
                    }
                    if ($access->menu_acc_del == '1') {
                        $menu_access .= '
                                        <li class="divider"> </li>
                                        <li>
                                            <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
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
                            <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->cus_id . '" onclick="get_modal(this)">
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

    public function add(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Add Customer';
        $data['subtitle'] = 'List Customer';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "token" => session('token'),
        ];
        $data['kam'] = json_decode(ElaHelper::myCurl('hris/customer/kam', $param));
        $param = [
            "token" => session('token'),
        ];
        $data['pic'] = json_decode(ElaHelper::myCurl('hris/customer/pic', $param));

        $param = [
            "order" => ["nama", "ASC"],
            "fields" => ["_muser.br_id", "_mbranch.br_name"],
            "join" => ["_mbranch", "_muser.br_id", "_mbranch.br_id"],
            "where" => ["user_id", session('id_hris')],
            "table" => "_muser",
        ];
        $data['user'] = json_decode(ElaHelper::myCurl('hris/hris-setting/master-global-join', $param));

        return view('HRIS.customer.add', $data);

    }

    public function doAdd(Request $request)
    {
        $date_cutoff = $request->post('date_cutoff') != null ? $request->post('date_cutoff') : "";
        $category = $request->post('category') != null ? $request->post('category') : "";
        $branch = $request->post('branch') != null ? $request->post('branch') : "";
        $kam = $request->post('kam') != null ? $request->post('kam') : "";
        $customer_name = $request->post('customer_name') != null ? $request->post('customer_name') : "";
        $company_name = $request->post('company_name') != null ? $request->post('company_name') : "";
        // $customer_code = $request->post('customer_code') != null ? $request->post('customer_code') : "";
        $prorate = $request->post('prorate') != null ? $request->post('prorate') : "";
        $monthly_based = $request->post('monthly_based') != null ? $request->post('monthly_based') : "";
        $prorate_factor = $request->post('prorate_factor') != null ? $request->post('prorate_factor') : "";
        $city = $request->post('city') != null ? $request->post('city') : "";
        $postcode = $request->post('postcode') != null ? $request->post('postcode') : "";
        $address = $request->post('address') != null ? $request->post('address') : "";
        $phone = $request->post('phone') != null ? $request->post('phone') : "";
        $fax = $request->post('fax') != null ? $request->post('fax') : "";
        $email = $request->post('email') != null ? $request->post('email') : "";
        $note = $request->post('note') != null ? $request->post('note') : "";
        $contact_name1 = $request->post('contact_name1') != null ? $request->post('contact_name1') : "";
        $contact_phone1 = $request->post('contact_phone1') != null ? $request->post('contact_phone1') : "";
        $contact_position1 = $request->post('contact_position1') != null ? $request->post('contact_position1') : "";
        $contact_department1 = $request->post('contact_department1') != null ? $request->post('contact_department1') : "";
        $contact_notes1 = $request->post('contact_notes1') != null ? $request->post('contact_notes1') : "";
        $contact_name2 = $request->post('contact_name2') != null ? $request->post('contact_name2') : "";
        $contact_phone2 = $request->post('contact_phone2') != null ? $request->post('contact_phone2') : "";
        $contact_position2 = $request->post('contact_position2') != null ? $request->post('contact_position2') : "";
        $contact_department2 = $request->post('contact_department2') != null ? $request->post('contact_department2') : "";
        $contact_notes2 = $request->post('contact_notes2') != null ? $request->post('contact_notes2') : "";
        $contact_name3 = $request->post('contact_name3') != null ? $request->post('contact_name3') : "";
        $contact_phone3 = $request->post('contact_phone3') != null ? $request->post('contact_phone3') : "";
        $contact_position3 = $request->post('contact_position3') != null ? $request->post('contact_position3') : "";
        $contact_department3 = $request->post('contact_department3') != null ? $request->post('contact_department3') : "";
        $contact_notes3 = $request->post('contact_notes3') != null ? $request->post('contact_notes3') : "";
        $date_paid = $request->post('date_paid') != null ? $request->post('date_paid') : "";
        $management_fee = $request->post('management_fee') != null ? $request->post('management_fee') : "";
        $payment_term = $request->post('payment_term') != null ? $request->post('payment_term') : "";
        $company_size = $request->post('company_size') != null ? $request->post('company_size') : "";

        $pic = "";
        if ($request->post('pic') != null) {
            for ($i = 0; $i < count($request->post('pic')); $i++) {
                $pic .= $request->post('pic')[$i] . ',';
            }
            $pic = substr($pic, 0, -1);
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file')->getClientOriginalName();
            $fileName = date('YmdHis') . str_random(5) . $file;
            $destinationPath = base_path('public/hris/files/customer/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $request->file('file')->move($destinationPath, $fileName);
            $file = $fileName;
        } else {
            $file = "";

        }

        $param = [
            "token" => session('token'),
        ];
        $nip = json_decode(ElaHelper::myCurl('hris/employee/get-nip', $param));

        $value = [
            'date_cutoff' => strip_tags($date_cutoff),
            'cus_telco' => strip_tags($category),
            'br_id' => strip_tags($branch),
            'cus_kam' => strip_tags($kam),
            'cus_name' => strip_tags($customer_name),
            'cus_corporation' => strip_tags($company_name),
            // 'cus_code' => strip_tags($customer_code),
            'cus_prorate' => strip_tags($prorate),
            'cus_monthly' => strip_tags($monthly_based),
            'cus_factor' => strip_tags($prorate_factor),
            'cus_city' => strip_tags($city),
            'cus_postcode' => strip_tags($postcode),
            'cus_address' => strip_tags($address),
            'cus_phone' => strip_tags($phone),
            'cus_fax' => strip_tags($fax),
            'cus_email' => strip_tags($email),
            'cus_note' => strip_tags($note),
            'cus_contact_name1' => strip_tags($contact_name1),
            'cus_contact_phone1' => strip_tags($contact_phone1),
            'cus_contact_position1' => strip_tags($contact_position1),
            'cus_contact_department1' => strip_tags($contact_department1),
            'cus_contact_note1' => strip_tags($contact_notes1),
            'cus_contact_name2' => strip_tags($contact_name2),
            'cus_contact_phone2' => strip_tags($contact_phone2),
            'cus_contact_position2' => strip_tags($contact_position2),
            'cus_contact_department2' => strip_tags($contact_department2),
            'cus_contact_note2' => strip_tags($contact_notes2),
            'cus_contact_name3' => strip_tags($contact_name3),
            'cus_contact_phone3' => strip_tags($contact_phone3),
            'cus_contact_position3' => strip_tags($contact_position3),
            'cus_contact_department3' => strip_tags($contact_department3),
            'cus_contact_note3' => strip_tags($contact_notes3),
            'cus_file' => strip_tags($file),
            'cus_pic' => strip_tags($pic),
            'date_paid' => strip_tags($date_paid),
            'management_fee' => strip_tags($management_fee),
            'payment_term' => strip_tags($payment_term),
            'company_size' => strip_tags($company_size),

        ];

        $urlMenu = 'hris/customer/do-add';
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

    public function edit(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Edit Customer';
        $data['subtitle'] = 'List Customer';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "token" => session('token'),
        ];
        $data['kam'] = json_decode(ElaHelper::myCurl('hris/customer/kam', $param));
        $param = [
            "token" => session('token'),
        ];
        $data['pic'] = json_decode(ElaHelper::myCurl('hris/customer/pic', $param));

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/customer/get-customer', $param));
        return view('HRIS.customer.edit', $data);

    }

    public function doEdit(Request $request)
    {
        $date_cutoff = $request->post('date_cutoff') != null ? $request->post('date_cutoff') : "";
        $cus_id = $request->post('cus_id') != null ? $request->post('cus_id') : "";
        $category = $request->post('category') != null ? $request->post('category') : "";
        $branch = $request->post('branch') != null ? $request->post('branch') : "";
        $kam = $request->post('kam') != null ? $request->post('kam') : "";
        $customer_name = $request->post('customer_name') != null ? $request->post('customer_name') : "";
        $company_name = $request->post('company_name') != null ? $request->post('company_name') : "";
        // $customer_code = $request->post('customer_code') != null ? $request->post('customer_code') : "";
        $prorate = $request->post('prorate') != null ? $request->post('prorate') : "";
        $monthly_based = $request->post('monthly_based') != null ? $request->post('monthly_based') : "";
        $prorate_factor = $request->post('prorate_factor') != null ? $request->post('prorate_factor') : "";
        $city = $request->post('city') != null ? $request->post('city') : "";
        $postcode = $request->post('postcode') != null ? $request->post('postcode') : "";
        $address = $request->post('address') != null ? $request->post('address') : "";
        $phone = $request->post('phone') != null ? $request->post('phone') : "";
        $fax = $request->post('fax') != null ? $request->post('fax') : "";
        $email = $request->post('email') != null ? $request->post('email') : "";
        $note = $request->post('note') != null ? $request->post('note') : "";
        $contact_name1 = $request->post('contact_name1') != null ? $request->post('contact_name1') : "";
        $contact_phone1 = $request->post('contact_phone1') != null ? $request->post('contact_phone1') : "";
        $contact_position1 = $request->post('contact_position1') != null ? $request->post('contact_position1') : "";
        $contact_department1 = $request->post('contact_department1') != null ? $request->post('contact_department1') : "";
        $contact_notes1 = $request->post('contact_notes1') != null ? $request->post('contact_notes1') : "";
        $contact_name2 = $request->post('contact_name2') != null ? $request->post('contact_name2') : "";
        $contact_phone2 = $request->post('contact_phone2') != null ? $request->post('contact_phone2') : "";
        $contact_position2 = $request->post('contact_position2') != null ? $request->post('contact_position2') : "";
        $contact_department2 = $request->post('contact_department2') != null ? $request->post('contact_department2') : "";
        $contact_notes2 = $request->post('contact_notes2') != null ? $request->post('contact_notes2') : "";
        $contact_name3 = $request->post('contact_name3') != null ? $request->post('contact_name3') : "";
        $contact_phone3 = $request->post('contact_phone3') != null ? $request->post('contact_phone3') : "";
        $contact_position3 = $request->post('contact_position3') != null ? $request->post('contact_position3') : "";
        $contact_department3 = $request->post('contact_department3') != null ? $request->post('contact_department3') : "";
        $contact_notes3 = $request->post('contact_notes3') != null ? $request->post('contact_notes3') : "";
        $date_paid = $request->post('date_paid') != null ? $request->post('date_paid') : "";
        $management_fee = $request->post('management_fee') != null ? $request->post('management_fee') : "";
        $payment_term = $request->post('payment_term') != null ? $request->post('payment_term') : "";
        $company_size = $request->post('company_size') != null ? $request->post('company_size') : "";

        $pic = "";
        if ($request->post('pic') != null) {
            for ($i = 0; $i < count($request->post('pic')); $i++) {
                $pic .= $request->post('pic')[$i] . ',';
            }
            $pic = substr($pic, 0, -1);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file')->getClientOriginalName();
            $fileName = date('YmdHis') . str_random(5) . $file;
            $destinationPath = base_path('public/hris/files/customer/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $request->file('file')->move($destinationPath, $fileName);
            $file = $fileName;
        } else {
            $file = "";

        }

        $param = [
            "token" => session('token'),
        ];
        $nip = json_decode(ElaHelper::myCurl('hris/employee/get-nip', $param));

        $value = [
            'date_cutoff' => strip_tags($date_cutoff),
            'cus_id' => strip_tags($cus_id),
            'cus_telco' => strip_tags($category),
            'br_id' => strip_tags($branch),
            'cus_kam' => strip_tags($kam),
            'cus_name' => strip_tags($customer_name),
            'cus_corporation' => strip_tags($company_name),
            // 'cus_code' => strip_tags($customer_code),
            'cus_prorate' => strip_tags($prorate),
            'cus_monthly' => strip_tags($monthly_based),
            'cus_factor' => strip_tags($prorate_factor),
            'cus_city' => strip_tags($city),
            'cus_postcode' => strip_tags($postcode),
            'cus_address' => strip_tags($address),
            'cus_phone' => strip_tags($phone),
            'cus_fax' => strip_tags($fax),
            'cus_email' => strip_tags($email),
            'cus_note' => strip_tags($note),
            'cus_contact_name1' => strip_tags($contact_name1),
            'cus_contact_phone1' => strip_tags($contact_phone1),
            'cus_contact_position1' => strip_tags($contact_position1),
            'cus_contact_department1' => strip_tags($contact_department1),
            'cus_contact_note1' => strip_tags($contact_notes1),
            'cus_contact_name2' => strip_tags($contact_name2),
            'cus_contact_phone2' => strip_tags($contact_phone2),
            'cus_contact_position2' => strip_tags($contact_position2),
            'cus_contact_department2' => strip_tags($contact_department2),
            'cus_contact_note2' => strip_tags($contact_notes2),
            'cus_contact_name3' => strip_tags($contact_name3),
            'cus_contact_phone3' => strip_tags($contact_phone3),
            'cus_contact_position3' => strip_tags($contact_position3),
            'cus_contact_department3' => strip_tags($contact_department3),
            'cus_contact_note3' => strip_tags($contact_notes3),
            'cus_file' => strip_tags($file),
            'cus_pic' => strip_tags($pic),
            'date_paid' => strip_tags($date_paid),
            'management_fee' => strip_tags($management_fee),
            'payment_term' => strip_tags($payment_term),
            'company_size' => strip_tags($company_size),
            'cus_active' => strip_tags($request->post('cus_active')),
        ];

        $urlMenu = 'hris/customer/do-edit';
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

    public function detail(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Detail Customer';
        $data['subtitle'] = 'List Customer';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "token" => session('token'),
        ];
        $data['kam'] = json_decode(ElaHelper::myCurl('hris/customer/kam', $param));
        $param = [
            "token" => session('token'),
        ];
        $data['pic'] = json_decode(ElaHelper::myCurl('hris/customer/pic', $param));

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['customer'] = json_decode(ElaHelper::myCurl('hris/customer/get-customer-detail', $param));
        return view('HRIS.customer.detail', $data);

    }

    public function doDelete(Request $request)
    {

        $cus_id = $request->post('id');
        $urlMenu = 'hris/customer/do-delete';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "cus_id" => $cus_id,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doApprove(Request $request)
    {
        $cus_id = $request->post('id');
        $urlMenu = 'hris/customer/do-approve';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "cus_id" => $cus_id,
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
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

        $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
        $title = 'Customer-' . date('dmyHis');

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet($title, function ($sheet) use ($request, $title) {
                $sheet->cell('A1', function ($cell) {$cell->setValue('No');});
                $sheet->cell('B1', function ($cell) {$cell->setValue('Customer Name');});
                $sheet->cell('C1', function ($cell) {$cell->setValue('Company Name');});
                $sheet->cell('D1', function ($cell) {$cell->setValue('Category ');});
                $sheet->cell('E1', function ($cell) {$cell->setValue('Branch');});
                $sheet->cell('F1', function ($cell) {$cell->setValue('KAM');});
                $sheet->cell('G1', function ($cell) {$cell->setValue('Date Paid Resources');});
                $sheet->cell('H1', function ($cell) {$cell->setValue('Customer Code');});
                $sheet->cell('I1', function ($cell) {$cell->setValue('Prorate');});
                $sheet->cell('J1', function ($cell) {$cell->setValue('Monthly Based');});
                $sheet->cell('K1', function ($cell) {$cell->setValue('Person in Charge');});
                $sheet->cell('L1', function ($cell) {$cell->setValue('Prorate Factor');});
                $sheet->cell('M1', function ($cell) {$cell->setValue('City');});
                $sheet->cell('N1', function ($cell) {$cell->setValue('Postcode');});
                $sheet->cell('O1', function ($cell) {$cell->setValue('Address');});
                $sheet->cell('P1', function ($cell) {$cell->setValue('Phone');});
                $sheet->cell('Q1', function ($cell) {$cell->setValue('Fax');});
                $sheet->cell('R1', function ($cell) {$cell->setValue('email');});
                $sheet->cell('S1', function ($cell) {$cell->setValue('Note');});
                $sheet->cell('T1', function ($cell) {$cell->setValue('Contract Person Name');});
                $sheet->cell('U1', function ($cell) {$cell->setValue('Department');});
                $sheet->cell('V1', function ($cell) {$cell->setValue('Position');});
                $sheet->cell('W1', function ($cell) {$cell->setValue('Phone');});
                $sheet->cell('X1', function ($cell) {$cell->setValue('Notes');});
                $sheet->cell('Y1', function ($cell) {$cell->setValue('Active');});
                $sheet->cell('Z1', function ($cell) {$cell->setValue('Management Fee');});
                $sheet->cell('AA1', function ($cell) {$cell->setValue('Payment Term');});
                $sheet->cell('AB1', function ($cell) {$cell->setValue('Company Size');});
                $sheet->cell('AC1', function ($cell) {$cell->setValue('Updated By');});
                $sheet->cell('AD1', function ($cell) {$cell->setValue('Date Cut Off');});
                $sheet->setBorder('A1:AD1');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];

                $customer = json_decode(ElaHelper::myCurl('hris/customer/export-excel', $param));

                for ($a = 0; $a < count($customer->result); $a++) {

                    $sheet->setCellValue('A' . $i, $no);
                    $sheet->setCellValue('B' . $i, $customer->result[$a]->cus_name);
                    $sheet->setCellValue('C' . $i, $customer->result[$a]->cus_corporation);
                    $sheet->setCellValue('D' . $i, $customer->result[$a]->cus_telco);
                    $sheet->setCellValue('E' . $i, $customer->result[$a]->br_name);
                    $sheet->setCellValue('F' . $i, $customer->result[$a]->kam_name);
                    $sheet->setCellValue('G' . $i, $customer->result[$a]->mem_pay_tgl);

                    $sheet->setCellValue('H' . $i, $customer->result[$a]->cus_code);
                    $sheet->setCellValue('I' . $i, $customer->result[$a]->cus_prorate);
                    $sheet->setCellValue('J' . $i, $customer->result[$a]->cus_monthly);
                    $sheet->setCellValueExplicit('K' . $i, $customer->result[$a]->cus_pic);
                    $sheet->setCellValue('L' . $i, $customer->result[$a]->cus_factor);

                    $sheet->setCellValueExplicit('M' . $i, $customer->result[$a]->cus_city);
                    $sheet->setCellValueExplicit('N' . $i, $customer->result[$a]->cus_postcode);
                    $sheet->setCellValue('O' . $i, $customer->result[$a]->cus_address);
                    $sheet->setCellValueExplicit('P' . $i, $customer->result[$a]->cus_phone);
                    $sheet->setCellValue('Q' . $i, $customer->result[$a]->cus_fax);
                    $sheet->setCellValue('R' . $i, $customer->result[$a]->cus_email);
                    $sheet->setCellValue('S' . $i, $customer->result[$a]->cus_note);
                    $sheet->setCellValueExplicit('T' . $i, $customer->result[$a]->cus_contact_name1);
                    $sheet->setCellValue('U' . $i, $customer->result[$a]->cus_contact_department1);
                    $sheet->setCellValue('V' . $i, $customer->result[$a]->cus_contact_position1);
                    $sheet->setCellValue('W' . $i, $customer->result[$a]->cus_contact_phone1);
                    $sheet->setCellValue('X' . $i, $customer->result[$a]->cus_contact_note1);
                    $sheet->setCellValue('Y' . $i, $customer->result[$a]->cus_active);
                    $sheet->setCellValue('Z' . $i, $customer->result[$a]->management_fee);
                    $sheet->setCellValue('AA' . $i, $customer->result[$a]->payment_term);
                    $sheet->setCellValue('AB' . $i, $customer->result[$a]->company_size);
                    $sheet->setCellValue('AC' . $i, $customer->result[$a]->cus_user);
                    $sheet->setCellValue('AD' . $i, $customer->result[$a]->date_cutoff);

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
