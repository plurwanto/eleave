<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class employeeRec extends Controller
{
    public $menuID = 38;

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

        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $data['subtitle'] = 'List Employee From Recruitment';
        return view('HRIS.employee.recruitment.index', $data);
    }

    public function listData(Request $request)
    {
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');
        $link = $request->post('link');

        $search = (isset($filter['value'])) ? $filter['value'] : false;
        $urlMenu = 'hris/employee-rec';

        if ($request->post('start') == 0) {
            $page = 1;
        } else {
            $page = ($request->post('start') / $request->post('length')) + 1;
        }
        $sort_by = $request->post('order')[0]['column'];
        $dir = $request->post('order')[0]['dir'];

        if ($request['columns'][6]['search']['value'] != "" && $request['columns'][6]['search']['value'] != null) {
            $intervie_date = $request['columns'][6]['search']['value'];
            $intervie_date = str_replace('/', '-', $intervie_date);
            $intervie_date = date('Y-m-d', strtotime($intervie_date));
        } else {
            $intervie_date = "";
        }

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "page" => $page,
            "per_page" => $request->post('length'),
            "search" => $search,
            "sort_by" => $sort_by,
            "dir" => $dir,
            "search_name" => $request['columns'][0]['search']['value'],
            "search_id_number" => $request['columns'][1]['search']['value'],
            "search_email" => $request['columns'][2]['search']['value'],
            "search_customer" => $request['columns'][3]['search']['value'],
            "search_position" => $request['columns'][4]['search']['value'],
            "search_status" => $request['columns'][5]['search']['value'],
            "search_intervie_date" => $intervie_date,
            "search_condition" => $request['columns'][7]['search']['value'],
            "search_update_by" => $request['columns'][8]['search']['value'],
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $a = $start + 1;
        $members = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {
                $nestedData['no'] = $a++;
                $nestedData['mem_id'] = $rows->data[$i]->mem_id;
                if ($rows->data[$i]->mem_id_hris != '') {
                    $nestedData['mem_name'] = '
                <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->mem_id_hris . '" onclick="get_modal(this)">' . $rows->data[$i]->mem_name . '</a>';
                } else {
                    $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                }
                $nestedData['mem_ktp_no'] = $rows->data[$i]->mem_ktp_no;
                $nestedData['mem_gender'] = $rows->data[$i]->mem_gender;
                $nestedData['mem_email'] = $rows->data[$i]->mem_email;
                $nestedData['mem_address'] = $rows->data[$i]->mem_address;
                $nestedData['rod_interview_client_date'] = $rows->data[$i]->rod_interview_client_date;
                $nestedData['mem_position_desired'] = $rows->data[$i]->mem_position_desired;

                switch ($rows->data[$i]->status) {
                    case "not synchronized":
                        $status = '<h5><span class="label label-default xs">' . ucWords($rows->data[$i]->status) . '</span></h5>';
                        break;
                    case "no contract":
                        $status = '<h5><span class="label label-danger xs">' . ucWords($rows->data[$i]->status) . '</span></h5>';
                        break;
                    case "contracted":
                        $status = '<h5><span class="label label-primary xs">' . ucWords($rows->data[$i]->status) . '</span></h5>';
                        break;
                    case "not hired":
                        $status = '<h5><span class="label label-danger xs">' . ucWords($rows->data[$i]->status) . '</span></h5>';
                        break;
                    default:
                        $status = '<h5><span class="label label-default xs">' . ucWords($rows->data[$i]->status) . '</span></h5>';
                }

                $nestedData['status'] = $rows->data[$i]->rod_status;
                $nestedData['status_rod'] = $status;
                $nestedData['position'] = $rows->data[$i]->ro_position;

                $nestedData['cus_name'] = $rows->data[$i]->cus_name;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $menu_access = '';

                if ($rows->data[$i]->status == 'not synchronized' and $rows->data[$i]->rod_status == 'SUBMITTED') {
                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                    <a dataaction="search" title="Create Hris Employee" dataid="' . $rows->data[$i]->mem_id . '" onclick="get_modal(this)">
                        <i class="fa fa-plus-circle" style="
                        font-size: 18px;
                        width: 18px;
                        height: 18px;
                        margin-right: 3px;"></i>
                    </a>';
                    }

                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                        <a dataaction="reject" title="reject" dataid="' . $rows->data[$i]->mem_id_hris . '|' . $rows->data[$i]->rod_id . '" onclick="get_modal(this)">
                            <i class="fa fa-ban" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                    }

                } else if ($rows->data[$i]->status == 'no contract' and $rows->data[$i]->rod_status != 'REJECTED') {
                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                        <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id_hris . '" onclick="get_modal(this)">
                            <i class="fa fa-pencil-square-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                    }

                    if ($access->menu_acc_add == '1') {
                        $menu_access .= '
                        <a title="add contract" href="' . env('APP_URL') . '/hris/employee/recruitment/contract?employee_id=' . md5($rows->data[$i]->mem_id_hris) . '&rod=' . $rows->data[$i]->rod_id . '" target="blank">
                            <i class="fa fa-file-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                    }
                } else if ($rows->data[$i]->status == 'contracted' and (!in_array($rows->data[$i]->rod_status, ['HIRED', 'REJECTED', 'NOT QUALIFIED'], 'TRUE'))) {
                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                        <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->mem_id_hris . '" onclick="get_modal(this)">
                            <i class="fa fa-pencil-square-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                    }

                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                        <a dataaction="reject" title="reject" dataid="' . $rows->data[$i]->mem_id_hris . '|' . $rows->data[$i]->rod_id . '" onclick="get_modal(this)">
                            <i class="fa fa-ban" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                    }

                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                        <a dataaction="hired" title="hired" dataid="' . $rows->data[$i]->mem_id_hris . '|' . $rows->data[$i]->rod_id . '|' . $rows->data[$i]->ro_id . '" onclick="get_modal(this)">
                            <i class="fa fa-check-circle" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
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

    public function doAdd(Request $request)
    {

        if ($request->post('dob') != "" && $request->post('dob') != null) {
            $dob = $request->post('dob');
            $dob = str_replace('/', '-', $dob);
            $dob = date('Y-m-d', strtotime($dob));
        } else {
            $dob = "";
        }

        if ($request->post('join_date') != "" && $request->post('join_date') != null) {
            $join_date = $request->post('join_date');
            $join_date = str_replace('/', '-', $join_date);
            $join_date = date('Y-m-d', strtotime($join_date));
        } else {
            $join_date = "";
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

        $emgName = $request->post('emgName') != null ? $request->post('emgName') : "";
        $emgRelationship = $request->post('emgRelationship') != null ? $request->post('emgRelationship') : "";
        $emgMobile = $request->post('emgMobile') != null ? $request->post('emgMobile') : "";

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
        $mem_id = $request->post('mem_id') != null ? $request->post('mem_id') : "";

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
            'mem_join_date' => strip_tags($join_date),
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
            'mem_emergency_name' => strip_tags($emgName),
            'mem_emergency_relationship' => strip_tags($emgRelationship),
            'mem_emergency_mobile' => strip_tags($emgMobile),

        ];

        $urlMenu = 'hris/employee-rec/do-add';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "name" => session('name'),
            "mem_id" => $mem_id,
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
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

        if ($request->post('join_date') != "" && $request->post('join_date') != null) {
            $join_date = $request->post('join_date');
            $join_date = str_replace('/', '-', $join_date);
            $join_date = date('Y-m-d', strtotime($join_date));
        } else {
            $join_date = "";
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
        $emgName = $request->post('emgName') != null ? $request->post('emgName') : "";
        $emgRelationship = $request->post('emgRelationship') != null ? $request->post('emgRelationship') : "";
        $emgMobile = $request->post('emgMobile') != null ? $request->post('emgMobile') : "";

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

        $mem_id = $request->post('mem_id') != null ? $request->post('mem_id') : "";
        $mem_id_hris = $request->post('mem_id_hris') != null ? $request->post('mem_id_hris') : "";

        $value = ['mem_name' => strip_tags($name),
            'mem_alias' => strip_tags($alias_name),
            'mem_gender' => strip_tags($gender),
            'mem_dob_city' => strip_tags($pob),
            'mem_dob' => strip_tags($dob),
            'mem_marital_id' => strip_tags($marital),
            'religi_id' => strip_tags($religion),
            'mem_mobile' => strip_tags($mobile1),
            // 'mem_mobile2'=>$mobile2),
            // 'mem_phone'=>$phone),
            'mem_address' => strip_tags($address),
            'mem_email' => strip_tags($email1),
            // 'mem_email2'=>$email2),
            'mem_citizenship' => strip_tags($citizenship),
            'mem_ktp_no' => strip_tags($id_card),
            'mem_passport' => strip_tags($passport),
            'mem_exp_passport' => strip_tags($passport_date),
            'insr_deduction' => strip_tags($education),
            'mem_nationality' => strip_tags($nationality),
            'mem_join_date' => strip_tags($join_date),
            'mem_resign_date' => strip_tags($resign_date),
            // 'file'=>$file),
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
            'mem_emergency_name' => strip_tags($emgName),
            'mem_emergency_relationship' => strip_tags($emgRelationship),
            'mem_emergency_mobile' => strip_tags($emgMobile),
        ];

        $urlMenu = 'hris/employee-rec/do-edit';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "name" => session('name'),
            "mem_id" => $mem_id,
            "mem_id_hris" => $mem_id_hris,
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
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

        $param = [
            "id_hris" => session("id_hris"),
            "token" => session("token"),
            "rod" => $request->get('rod'),
        ];
        $data['employee'] = json_decode(ElaHelper::myCurl('hris/employee-rec/getRod', $param));

        return view('HRIS.employee.recruitment.addContract', $data);
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
                $name = 'employee-ind-rec';
                break;
            case 4: //phil
                $name = 'employee-phi-rec';
                break;
            case 5: //tha
                $name = 'employee-tha-rec';
                break;
            default; //mal
                $name = 'employee-mal-rec';
        }

        $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
        $title = $name . '-' . date('dmyHis');

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet($title, function ($sheet) use ($request, $title) {
                $sheet->cell('A1', function ($cell) {$cell->setValue('No');});
                $sheet->cell('B1', function ($cell) {$cell->setValue('Name');});
                $sheet->cell('C1', function ($cell) {$cell->setValue('ID Number');});
                $sheet->cell('D1', function ($cell) {$cell->setValue('Email');});
                $sheet->cell('E1', function ($cell) {$cell->setValue('Customer');});
                $sheet->cell('F1', function ($cell) {$cell->setValue('Branch');});
                $sheet->cell('G1', function ($cell) {$cell->setValue('Interview Date');});
                $sheet->cell('H1', function ($cell) {$cell->setValue('Position');});
                $sheet->cell('I1', function ($cell) {$cell->setValue('Status');});
                $sheet->cell('J1', function ($cell) {$cell->setValue('Condition');});

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];

                $member = json_decode(ElaHelper::myCurl('hris/employee-rec/export-excel', $param));
                for ($a = 0; $a < count($member->employee); $a++) {

                    $sheet->setCellValue('A' . $i, $no);
                    $sheet->setCellValue('B' . $i, $member->employee[$a]->mem_name);
                    $sheet->setCellValueExplicit('C' . $i, $member->employee[$a]->mem_ktp_no);
                    $sheet->setCellValue('D' . $i, $member->employee[$a]->mem_email);
                    $sheet->setCellValue('E' . $i, $member->employee[$a]->cus_name);
                    $sheet->setCellValue('F' . $i, $member->employee[$a]->br_name);
                    $sheet->setCellValue('G' . $i, $member->employee[$a]->rod_interview_client_date);
                    $sheet->setCellValue('H' . $i, $member->employee[$a]->ro_position);
                    $sheet->setCellValue('I' . $i, $member->employee[$a]->rod_status);
                    $sheet->setCellValue('J' . $i, $member->employee[$a]->status);

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

    public function add(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Add Employee';
        $data['subtitle'] = 'List Employee';
        $data['id'] = $request->get('id');
        return view('HRIS.employee.recruitment.add', $data);

    }

    public function getData(Request $request)
    {

        $id_number = $request->post('id_number');
        $id = $request->post('id');

        $html = "<h3 style='text-align: center'>- Data Not Found -</h3>";

        $data['link'] = $request->get('link');
        $data['title'] = 'Create Employee HRIS From Recruitment';
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
            "id" => $id,
        ];
        $employee = json_decode(ElaHelper::myCurl('hris/employee-rec/get-employee', $param));

        if ($employee) {

            $param = [
                "token" => session("token"),
                "id" => $id_number,
            ];

            $employee2 = json_decode(ElaHelper::myCurl('hris/employee/get-employee-with-idcard', $param));
            $data['id'] = $id;
            $data['id_number'] = $id_number;
            $data['employee'] = $employee;

            if ($employee2->employee) {
                $data['employee2'] = $employee2;

                switch ($employee->employee->br_id) {
                    case 3:
                        return view('HRIS.employee.recruitment.editMal', $data);
                        break;
                    case 4:
                        return view('HRIS.employee.recruitment.editPhi', $data);
                        break;
                    case 5:
                        return view('HRIS.employee.recruitment.editTha', $data);
                        break;
                    default:
                        return view('HRIS.employee.recruitment.editInd', $data);
                }
                exit;

            } else {
                switch ($employee->employee->br_id) {
                    case 3:
                        return view('HRIS.employee.recruitment.addMal', $data);
                        break;
                    case 4:
                        return view('HRIS.employee.recruitment.addPhi', $data);
                        break;
                    case 5:
                        return view('HRIS.employee.recruitment.addTha', $data);
                        break;
                    default:
                        return view('HRIS.employee.recruitment.addInd', $data);
                }

                exit;

            }
        }
        echo $html;
        exit;

    }

    public function doReject(Request $request)
    {
        $mem_id_hris = $request->post('mem_id_hris');
        $ro_id = $request->post('ro_id');
        $rod_id = $request->post('rod_id');
        $remark = $request->post('remark');
        $role = strtolower($request->post('role'));

        if ($mem_id_hris != 0 and $mem_id_hris != "") {
            $param = [
                "user_id" => session('id_hris'),
                "token" => session('token'),
                "mem_id_hris" => $mem_id_hris,
            ];
            json_decode(ElaHelper::myCurl('hris/employee-rec/do-reject', $param));
        }

        $param = [
            "user_id" => session('id_hris'),
            "token" => session('token'),
            "jobId" => $ro_id,
            "rod_id" => $rod_id,
            "rejectRemark" => $remark,
            "role" => $role,
        ];

        $rows = json_decode(ElaHelper::myCurl('recruitment/order/reject', $param));

        // send email to candidate
        if ($rows->result) {

            $dataMail = [
                "candName" => $rows->result->mem_name,
                "position" => $rows->result->ro_position,
                "rejectedBy" => $rows->result->rejectedBy,
            ];

            $param2 = [
                // "to" => 'emailfauzimdev@gmail.com',
                // "to" => 'alexius.m@elabram.com',
                "to" => $rows->result->mem_email,
                "data" => $dataMail,
                "file_name" => 'recruitment/toCandidateReject',
                "from" => 'notification@elabram.com',
                "from_name" => 'Elabram Systems - Recruitment',
                // "bcc" => '',
                "bcc" => 'kenji.azimi@gmail.com',
                "subject" => 'We regret, you are not selected',
            ];

            $rows2 = json_decode(ElaHelper::myCurl('send-mail', $param2));
        }

        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);

    }

    public function doHired(Request $request)
    {
        $id = $request->post('id');
        $rod_id = $request->post('rod_id');
        $ro_id = $request->post('ro_id');

        $urlMenu = 'recruitment/order/hire';
        $param = [
            "user_id" => session('id_hris'),
            "rod_id" => $rod_id,
            "ro_id" => $ro_id,
            "token" => session('token'),
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        if ($rows->result) {

            $dataMail = [
                "candidateName" => $rows->result->candidate->mem_name,
                "position" => $rows->result->dataEmail->ro_position,
                "hiredBy" => $rows->result->dataEmail->hired_by,
            ];

            $param2 = [
                //                 "to" => 'alexius.m@elabram.com',
                "to" => $rows->result->candidate->mem_email,
                "data" => $dataMail,
                "file_name" => 'recruitment/toCandidateHired',
                "from" => 'notification@elabram.com',
                "from_name" => 'Elabram Systems - Recruitment',
                // "bcc" => '',
                "bcc" => 'kenji.azimi@gmail.com',
                "subject" => 'Congratulation, you are hired',
            ];

            $rows2 = json_decode(ElaHelper::myCurl('send-mail', $param2));
        }

        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);

    }

    public function reject(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Reject Employee';
        $data['subtitle'] = 'List Employee';
        $rod_id = $request->get('rod_id');
        $mem_id_hris = $request->get('mem_id_hris');
        $data['mem_id_hris'] = $mem_id_hris;

        $param = [
            "id_hris" => session("id_hris"),
            "token" => session("token"),
            "rod" => $rod_id,
        ];

        $data['employee'] = json_decode(ElaHelper::myCurl('hris/employee-rec/getRod', $param));
        return view('HRIS.employee.recruitment.reject', $data);

    }
}
