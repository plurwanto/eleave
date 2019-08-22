<?php
namespace App\Http\Controllers\Eleave\TimeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;
use DateTime;
use DatePeriod;
use DateInterval;
use Redirect;
use Input;
use Excel;

class LeaveController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if (!empty($request->userid)) {
            $link_notif = "notif";
            $source_id = $request->get('source');
        } else {
            $link_notif = "";
            $source_id = "";
        }

        return view('Eleave.leave.lv_index', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getLeave(Request $request) {
//        $columns = array(
//            0 => 'lv_date',
//            1 => 'lv_description',
//        );

        $urlLeave = 'eleave/leave/index';
        $param = [
            "token" => session('token'),
            "branch_id" => session('branch_id'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "notif" => $request->post('notif'),
            "source_id" => $request->post('source_id'),
            "search" => $request->input('search.value'),
            "search_type" => $request['columns'][1]['search']['value'],
            "search_start_date" => $request['columns'][2]['search']['value'],
            "search_end_date" => $request['columns'][3]['search']['value'],
            "search_status" => $request['columns'][10]['search']['value'],
            "search_detail" => $request['columns'][6]['search']['value'],
        ];

        $leave = ElaHelper::myCurl($urlLeave, $param);
        $leaveData = json_decode($leave, true);
        //dd($leaveData);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($leaveData['response_code'] == 200) {
            $user_leave = $leaveData['data'];
            $object = json_decode(json_encode($user_leave), FALSE);
            $branch_id = session('branch_id');
            //$holidays = $this->eleave->get_holiday($branch_id);

            foreach ($object as $row) {
                $no++;
                $aksi = "";
                //jika belum full approved
                if ($row->lv_approver_id != 0) {
                    //update
                    if ($row->lv_need_revision == 1) {
                        $aksi .= '<a href="' . url('eleave/leave/' . $row->lv_id . '/edit') . '" class="btn yellow btn-xs" title="Revise"><i class="fa fa-pencil"></i>';
                    }
                    //delete
                    //$aksi .= 	"<a href='".base_url()."index.php/holiday/delete/".$row->hol_id."' onclick='return confirm(\"Are You sure?\");' class='btn btn-icon-only red' title='Delete'><i class='fa fa-trash'></i></a>";
                    //$aksi .= "<a class='btn red btn-icon-only tombol-delete' data-toggle='modal' href='#small' title='Delete' id='" . $row->lv_id . "'> <i class='fa fa-trash'></i> </a>";
                    $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->lv_id . "'><i class='fa fa-trash'></i></a>";
                }
                
                if ($row->lv_approver_id == 0) {
                    $last_approve = date('Y-m-d', strtotime($row->lv_last_update));
                    $auto_close = strtotime($last_approve . ' + 3 days');
                    $today = strtotime("today midnight");
                    if ($today <= $auto_close) {
                        $aksi .= "<a class='btn red btn-xs reject' href='#' title='Withdraw' id='" . $row->lv_id . "'><i class='fa fa-trash'></i></a>";
                    }
                }

                $status = "";
                if ($row->lv_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->lv_rejected_reason) ? "<i class='fa fa-question' title='" . $row->lv_rejected_reason . "'></i>" : "") . "";
                } else {
                    if ($row->lv_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                    } else {
                        if ($row->lv_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for your revision</span>";
                        } else {
                            if ($row->lv_approver_id == 1) {
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->lv_approver_id == 2) {
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $curr_approver = User::split_name($row->approver3);
                            }
                            $status = "<span class='label label-warning'>Waiting for " . $curr_approver . "'s approval</span>";
                        }
                    }
                }

                $detail = "";
                //if($row->lv_type == "Medical Leave" && $row->lv_document != ""){
                //	$detail .= "Statement Letter : <a href='".base_url().$row->lv_document."' target='_blank'>Click To View</a>";
                //}

                if ($row->lv_type == "Compassionate Leave" || $row->lv_type == "Paternity Leave" || $row->lv_type == "Maternity Leave" || $row->lv_type == "Marriage Leave" || $row->lv_type == "Annual Leave" || $row->lv_type == "Medical Leave" || $row->lv_type == "Study Leave" || $row->lv_type == "Unpaid Leave") {
                    if (!empty($row->lv_half) && $row->lv_half == "Half Day") {
                        $detail .= (!empty($row->lv_half_time) ? "[" . $row->lv_half . "] [" . $row->lv_half_time . "]<br>" : "[" . $row->lv_half . "]<br>");
                        $detail .= $row->lv_detail;
                    } else {
                        $detail .= (!empty($row->lv_half) ? "[" . $row->lv_half . "]<br>" : "");
                        $detail .= $row->lv_detail;
                    }
                    if ($row->lv_document != "") {
                        if ($row->lv_type == "Medical Leave") {
                            $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_document) . "' target='_blank' style='color:red;'>Click To View Medical Certificate</a>";
                        } else {
                            $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_document) . "' target='_blank'>Click To View Support Document</a>";
                        }
                    }
                    if ($row->lv_statement_letter != "") {
                        $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_statement_letter) . "' target='_blank' style='color:red;'>Click To View Statement Letter</a>";
                    }
                }

                // data $days & bf get from API

                $year = date('Y', strtotime($row->lv_start_date));
                $month = date('F', strtotime($row->lv_start_date));
                $cek_lv_type = (!empty($row->lv_is_emergency) ? $row->lv_is_emergency . " Leave" : $row->lv_type);

                $hasil[] = array("no" => $no,
                    "lv_type" => $cek_lv_type,
                    "lv_start_date" => date('D, d M Y', strtotime($row->lv_start_date)),
                    "lv_end_date" => date('D, d M Y', strtotime($row->lv_end_date)),
                    "lv_submit_date" => $row->lv_submit_date != "0000-00-00" ? date('d M Y', strtotime($row->lv_submit_date)) : "",
                    "detail" => $detail,
                    "days" => $row->days . " day(s)",
                    "bf" => $row->bf . " day(s)",
                    "year" => $year,
                    "month" => $month,
                    "status" => $status,
                    "action" => $aksi);
            }
        } else {
            $err = $leaveData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $leaveData['recordsTotal'],
            "recordsFiltered" => $leaveData['recordsFiltered'],
            "totalDays" => $leaveData['totalDays'],
            "totalBf" => $leaveData['totalBf'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function getLeaveNotif(Request $request) {
        $urlLeave = 'eleave/leave/index';
        $param = [
            "token" => session('token'),
            "branch_id" => session('branch_id'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "notif" => $request->post('notif'),
            "source_id" => $request->post('source_id'),
            "search" => $request->input('search.value'),
            "search_type" => $request['columns'][1]['search']['value'],
            "search_start_date" => $request['columns'][2]['search']['value'],
            "search_end_date" => $request['columns'][3]['search']['value'],
            "search_status" => $request['columns'][10]['search']['value'],
            "search_det" => $request['columns'][8]['search']['value'],
        ];

        $leave = ElaHelper::myCurl($urlLeave, $param);
        $leaveData = json_decode($leave, true);
        //dd($leaveData);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($leaveData['response_code'] == 200) {
            $user_leave = $leaveData['data'];
            $object = json_decode(json_encode($user_leave), FALSE);
            $branch_id = session('branch_id');
            //$holidays = $this->eleave->get_holiday($branch_id);

            foreach ($object as $row) {
                $aksi = "";
                //jika belum full approved
                if ($row->lv_approver_id != 0) {
                    //update
                    if ($row->lv_need_revision == 1) {
                        $aksi .= '<a href="' . url('eleave/leave/' . $row->lv_id . '/edit') . '" class="btn yellow btn-xs" title="Revise"><i class="fa fa-pencil"></i>';
                    }
                    //delete
                    //$aksi .= 	"<a href='".base_url()."index.php/holiday/delete/".$row->hol_id."' onclick='return confirm(\"Are You sure?\");' class='btn btn-icon-only red' title='Delete'><i class='fa fa-trash'></i></a>";
                    //$aksi .= "<a class='btn red btn-icon-only tombol-delete' data-toggle='modal' href='#small' title='Delete' id='" . $row->lv_id . "'> <i class='fa fa-trash'></i> </a>";
                    $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->lv_id . "'><i class='fa fa-trash'></i></a>";
                }
                
                if ($row->lv_approver_id == 0) {
                    $last_approve = date('Y-m-d', strtotime($row->lv_last_update));
                    $auto_close = strtotime($last_approve . ' + 3 days');
                    $today = strtotime("today midnight");
                    if ($today <= $auto_close) {
                        $aksi .= "<a class='btn red btn-xs reject' href='#' title='Withdraw' id='" . $row->lv_id . "'><i class='fa fa-trash'></i></a>";
                    }
                }

                $status = "";
                if ($row->lv_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->lv_rejected_reason) ? "<i class='fa fa-question' title='" . $row->lv_rejected_reason . "'></i>" : "") . "";
                } else {
                    if ($row->lv_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                    } else {
                        if ($row->lv_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for your revision</span>";
                        } else {
                            if ($row->lv_approver_id == 1) {
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->lv_approver_id == 2) {
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $curr_approver = User::split_name($row->approver3);
                            }
                            $status = "<span class='label label-warning'>Waiting for " . $curr_approver . "'s approval</span>";
                        }
                    }
                }

                $detail = "";
                //if($row->lv_type == "Medical Leave" && $row->lv_document != ""){
                //	$detail .= "Statement Letter : <a href='".base_url().$row->lv_document."' target='_blank'>Click To View</a>";
                //}

                if ($row->lv_type == "Compassionate Leave" || $row->lv_type == "Paternity Leave" || $row->lv_type == "Maternity Leave" || $row->lv_type == "Marriage Leave" || $row->lv_type == "Annual Leave" || $row->lv_type == "Medical Leave" || $row->lv_type == "Study Leave" || $row->lv_type == "Unpaid Leave") {
                    if (!empty($row->lv_half) && $row->lv_half == "Half Day") {
                        $detail .= (!empty($row->lv_half_time) ? "[" . $row->lv_half . "][" . $row->lv_half_time . "]<br>" : "[" . $row->lv_half . "]<br>");
                        $detail .= $row->lv_detail;
                    } else {
                        $detail .= $row->lv_detail;
                    }
                    if ($row->lv_document != "") {
                        if ($row->lv_type == "Medical Leave") {
                            $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_document) . "' target='_blank' style='color:red;'>Click To View Medical Certificate</a>";
                        } else {
                            $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_document) . "' target='_blank'>Click To View Support Document</a>";
                        }
                    }
                    if ($row->lv_statement_letter != "") {
                        $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_statement_letter) . "' target='_blank' style='color:red;'>Click To View Statement Letter</a>";
                    }
                }

                // data $days & bf get from API

                $year = date('Y', strtotime($row->lv_start_date));
                $month = date('F', strtotime($row->lv_start_date));

                $show = 0;
                if ($row->lv_need_revision == 1) {
                    $show = 1;
                }

                $cek_lv_type = (!empty($row->lv_is_emergency) ? $row->lv_is_emergency . " Leave" : $row->lv_type);
                if ($show) {
                    $no++;
                    $hasil[] = array("no" => $no,
                        "lv_type" => $cek_lv_type,
                        "lv_start_date" => date('D, d M Y', strtotime($row->lv_start_date)),
                        "lv_end_date" => date('D, d M Y', strtotime($row->lv_end_date)),
                        "lv_submit_date" => $row->lv_submit_date != "0000-00-00" ? $row->lv_submit_date : "",
                        "detail" => $detail,
                        "days" => $row->days . " day(s)",
                        "bf" => $row->bf . " day(s)",
                        "year" => $year,
                        "month" => $month,
                        "status" => $status,
                        "action" => $aksi);
                }
            }
        } else {
            $err = $leaveData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $leaveData['recordsTotal'],
            "recordsFiltered" => $leaveData['recordsFiltered'],
            "totalDays" => $leaveData['totalDays'],
            "totalBf" => $leaveData['totalBf'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function get_data_detail(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlTimeshet = 'eleave/leave/getLeaveDetail';
        $param = [
            'token' => session('token'),
            'id' => $request->id,
            'lv_id' => $request->lv_id,
        ];
        $leave_id = ElaHelper::myCurl($urlTimeshet, $param);
        $leaveList = json_decode($leave_id, true);

        $row = array();
        if ($leaveList['response_code'] == 200) {
            $data = array();
            foreach ($leaveList['data'] as $value) {
                $data[] = array(
                    'lv_date' => date("j F Y", strtotime($value['lv_date'])),
                    'lv_time_in' => substr($value['lv_time_in'], 0, -3),
                    'lv_time_out' => substr($value['lv_time_out'], 0, -3),
                    'lv_total_time' => $value['lv_total_time'],
                    'lv_location' => ($value['lv_location'] != "" ? $value['lv_location'] : ""),
                    'lv_activity' => $value['lv_activity']
                );
            }
            $output = array(
                "data" => $data
            );
        } else {
            $output = $leaveList['message'];
        }
        echo json_encode($output);
    }

    public function check() {
        if (!Session::has('token')) {
            return redirect('/login');
        } else {
            return view('Eleave.leave.lv_check');
        }
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlLeave = 'eleave/leave/getLeaveId';
        $param = [
            "token" => session('token'),
            "lv_id" => $id,
        ];
        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        $lv = "";
        if ($leaveList['response_code'] == 200) {
            $lv = json_decode(json_encode($leaveList['data']), FALSE);
            $user_id = session('id');
            $lv_type = $lv->lv_type;

            /// get_data_leave
            $urlLeave2 = 'eleave/leave/getLeaveData';
            $param2 = [
                "token" => session('token'),
                "lv_type" => $lv_type,
                'today' => $lv->lv_submit_date,
            ];
            $leave_data2 = ElaHelper::myCurl($urlLeave2, $param2);
            $leaveList2 = json_decode($leave_data2, true);
            if ($leaveList2['response_code'] == 200) {
                $data1 = json_decode(json_encode($leaveList2['data']), FALSE);
            } else {
                $data1 = $leaveList2['message'];
            }
        } else {
            $lv = $leaveList['message'];
        }

        return view('Eleave.leave.lv_edit', ['lv_type' => $lv_type, 'lv' => $lv, 'data' => $data1]);
    }

    public function add(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if ($request->post('lv_type')) {
            $lv_type = $request->post('lv_type');
        }

        $urlLeave = 'eleave/leave/getLeaveData';
        $param = [
            "token" => session('token'),
            "lv_type" => $lv_type,
            'today' => date('Y-m-d'),
        ];
        $leave_data = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_data, true);
        if ($leaveList['response_code'] == 200) {
            $lv = json_decode(json_encode($leaveList['data']), FALSE);
        } else {
            $lv = $leaveList['message'];
        }

        return view('Eleave.leave.lv_new', ['lv_type' => $lv_type, 'data' => $lv]);
    }

    public function input_invalid($lv_type) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        //   $lv_type = 
        $urlLeave = 'eleave/leave/getLeaveData';
        $param = [
            "token" => session('token'),
            "lv_type" => $lv_type,
            'today' => date('Y-m-d'),
        ];
        $leave_data = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_data, true);

        if ($leaveList['response_code'] == 200) {
            $lv = json_decode(json_encode($leaveList['data']), FALSE);
        } else {
            $lv = leaveList['message'];
        }

        if (session('lv_act') == "lv_insert") {
            return view('Eleave.leave.lv_new', ['lv_type' => $lv_type, 'data' => $lv]);
        } else {
            $id = session('lv_id');
            $urlLeave = 'eleave/leave/getLeaveId';
            $param = [
                "token" => session('token'),
                "lv_id" => $id,
            ];
            $leave_id = ElaHelper::myCurl($urlLeave, $param);
            $leaveList = json_decode($leave_id, true);
            $lv = "";
            if ($leaveList['response_code'] == 200) {
                $lv = json_decode(json_encode($leaveList['data']), FALSE);
                $user_id = session('id');
                $lv_type = $lv->lv_type;

                /// get_data_leave
                $urlLeave2 = 'eleave/leave/getLeaveData';
                $param2 = [
                    "token" => session('token'),
                    "lv_type" => $lv_type,
                    'today' => $lv->lv_submit_date,
                ];
                $leave_data2 = ElaHelper::myCurl($urlLeave2, $param2);
                $leaveList2 = json_decode($leave_data2, true);
                if ($leaveList2['response_code'] == 200) {
                    $data1 = json_decode(json_encode($leaveList2['data']), FALSE);
                } else {
                    $data1 = $leaveList2['message'];
                }
            } else {
                $lv = $leaveList['message'];
            }
            return view('Eleave.leave.lv_edit', ['lv_type' => $lv_type, 'lv' => $lv, 'data' => $data1]);
        }
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $lv_id = $request->post('lv_id');
        //$lv_date = $request->post('lv_date');
        $lv_type = $request->post('lv_type');

        $lv_start_date = $request->post('lv_start_date');
        $lv_end_date = $request->post('lv_start_date');
        if ($request->post('lv_end_date')) {
            $lv_end_date = $request->post('lv_end_date');
        }
        $lv_half = $request->post('lv_half');
        $lv_detail = $request->post('lv_detail');
        $lv_act = $request->post('lv_act');
        $lv_half_time = $request->post('lv_half_time');

        $urlLeave = 'eleave/leave/save';
        $param = [
            "token" => session('token'),
            "lv_id" => $lv_id,
            "user_id" => session('id'),
            "lv_type" => $lv_type,
            "lv_start_date" => $lv_start_date,
            "lv_end_date" => $lv_end_date,
            "lv_rejected" => 0,
            "branch_id" => session('branch_id'),
            "lv_finger_print_id" => session('finger_print_id'),
            "lv_approver_id" => 1,
            "lv_need_revision" => 0,
            "max_leave" => $request->post('max_leave'),
            "lv_half" => $lv_half,
            "lv_detail" => $lv_detail,
            "lv_document" => $request->file('lv_document'),
            "lv_statement_letter" => $request->file('lv_statement_letter'),
            "lv_half_time" => $lv_half_time,
        ];
//        echo "<pre>";
//        var_dump($param);
//        echo "</pre>";exit;
        $leave = ElaHelper::myCurl($urlLeave, $param);
        $leaveSave = json_decode($leave, true);
        //      dd($leaveSave['response_code']);
        if ($leaveSave['response_code'] == 200) {
            $lv_id = $leaveSave['lv_id'];
            if ($request->hasFile('lv_document')) {
                $fileName = $request->file('lv_document')->getClientOriginalName();
                $destinationPath = base_path('public/upload/leave/' . $lv_id . '/');
                $upload_dir = "upload/leave/" . $lv_id . "/";
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $request->file('lv_document')->move($destinationPath, $fileName);
                $file_document = $upload_dir . $fileName;
                $urlUpload = 'eleave/leave/do_upload';
                $param = [
                    "token" => session('token'),
                    "lv_id" => $lv_id,
                    "user_id" => session('id'),
                    "lv_document" => $file_document,
                ];
                $leave = ElaHelper::myCurl($urlUpload, $param);
                $leaveUpdate = json_decode($leave, true);
            }

            if ($request->hasFile('lv_statement_letter')) {
                $fileName2 = $request->file('lv_statement_letter')->getClientOriginalName();
                $destinationPath = base_path('public/upload/leave/' . $lv_id . '/');
                $upload_dir = "upload/leave/" . $lv_id . "/";
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $request->file('lv_statement_letter')->move($destinationPath, $fileName2);
                $file_letter = $upload_dir . $fileName2;
                $urlUpload = 'eleave/leave/do_upload_letter';
                $param = [
                    "token" => session('token'),
                    "lv_id" => $lv_id,
                    "user_id" => session('id'),
                    "lv_statement_letter" => $file_letter,
                ];
                $leave = ElaHelper::myCurl($urlUpload, $param);
                $leaveUpdate = json_decode($leave, true);
            }
            return redirect('eleave/leave/index')
                            ->with(array('message' => $leaveSave['message'], 'alert-type' => 'success'));
        } else {
//dd('errr');
            // return redirect()->back()->withInput()->withErrors($leaveSave['message']);
            //return redirect('eleave/leave/check');
            return redirect('eleave/leave/invalid/' . $leaveSave['lv_type'])->with(['warning' => $leaveSave['message'], 'sd' => $lv_start_date, 'ed' => $lv_end_date, 'dt' => $lv_detail, 'lv_act' => $lv_act, 'lv_id' => $lv_id])->withErrors($lv_type)->withInput();
            // return redirect()->back()->withErrors(['msg_err', 'The Message']);
            //return redirect()->to('eleave/leave/add')->withErrors($leaveSave['message'])->withInput();
//            return redirect('eleave/leave/index')
//                            ->with('warning', $leaveSave['message']);
        }
    }

    public function update(Request $request, $id) {
        $urlLeave = 'eleave/leave/update';
        $param = [
            "token" => session('token'),
            "lv_id" => $id,
            "user_id" => session('id'),
            "lv_date" => $request->post('lv_date'),
            "lv_time_in" => $request->post('lv_time_in'),
            "lv_time_out" => $request->post('lv_time_out'),
            "lv_description" => $request->post('lv_description'),
            "lv_reason" => $request->post('lv_reason'),
            "lv_negative_impact" => $request->post('lv_impact'),
            "branch_id" => session('branch_id'),
            "lv_finger_print_id" => session('finger_print_id'),
            "lv_approver_id" => 1,
            "lv_need_revision" => 0,
            "lv_last_update" => date('Y-m-d H:i:s'),
        ];

        $leave = ElaHelper::myCurl($urlLeave, $param);
        $leaveUpdate = json_decode($leave, true);
//dd($param);
//echo json_encode($leaveSave);
        return redirect('eleave/leave/index')
                        ->with('success', $leaveUpdate['message']);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlLeave = 'eleave/leave/delete';
        $param = [
            "token" => session('token'),
            "lv_id" => $id,
        ];

        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        $lv = "";
        if ($leaveList['response_code'] == 200) {
            $lv = array('status' => true, 'message' => $leaveList['message']);
        } else {
            $lv = array('status' => false);
        }
        echo json_encode($lv);
    }

    public function checkExisting(Request $request) {
        $lv_id = $request->post('lv_id');
        $lv_start_date = $request->post('lv_start_date');
        $half = $request->post('half');
        $lv_type = $request->post('lv_type');
        $lv_half_time = $request->post('lv_half_time');
        $lv_end_date = $request->post('lv_start_date');
        if ($request->post('lv_end_date')) {
            $lv_end_date = $request->post('lv_end_date');
        }

        $urlLeave = 'eleave/leave/check_existing';
        $param = [
            "lv_id" => $lv_id,
            "user_id" => session('id'),
            "lv_start_date" => $lv_start_date,
            "lv_end_date" => $lv_end_date,
            "lv_rejected" => 0,
            "half" => $half,
            "lv_type" => $lv_type,
            "lv_half_time" => $lv_half_time,
        ];

        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        //dd($leave_id);
        if ($leaveList['response'] == true) {
            //     dd('masuk');
           // $response = true;
            $response = array('status' => true, 'message' => $leaveList['message']);
        } else {
            //$response = false;
            $response = array('status' => false, 'message' => $leaveList['message']);
        }
        echo json_encode($response);
    }
    
    public function checkExistingSameDate(Request $request) {
        $lv_id = $request->post('lv_id');
        $lv_start_date = $request->post('lv_start_date');
        $half = $request->post('half');
        $lv_type = $request->post('lv_type');
        $lv_half_time = $request->post('lv_half_time');
        $lv_end_date = $request->post('lv_start_date');
        if ($request->post('lv_end_date')) {
            $lv_end_date = $request->post('lv_end_date');
        }

        $urlLeave = 'eleave/leave/check_existing_day_session';
        $param = [
            "lv_id" => $lv_id,
            "user_id" => session('id'),
            "lv_start_date" => $lv_start_date,
            "lv_end_date" => $lv_end_date,
            "lv_rejected" => 0,
            "half" => $half,
            "lv_type" => $lv_type,
            "lv_half_time" => $lv_half_time,
        ];

        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        //dd($leave_id);
        if ($leaveList['response'] == true) {
            //     dd('masuk');
           // $response = true;
            $response = array('status' => true, 'message' => $leaveList['message']);
        } else {
            //$response = false;
            $response = array('status' => false, 'message' => $leaveList['message']);
        }
        echo json_encode($response);
    }

    public function team_leave_show($id) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $urlLeave = 'eleave/leave/getTeamLeaveSummary';
        $param = [
            "token" => session('token'),
            "user_id" => $id,
        ];

        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        if ($leaveList['response_code'] == 200) {
            $list_user = json_decode(json_encode($leaveList['user']), FALSE);
            $report_summary = json_decode(json_encode($leaveList['leave_summary']), TRUE);
        } else {
            $list_user = "";
            $report_summary = "";
            session()->flash('message', $leaveList['message']);
            session()->flash('alert-type', 'warning');
        }
        return view('Eleave.employee.team_leave', ['userId' => $id, 'user' => $list_user, 'leave_summary' => $report_summary]);
    }

    public function team_leave(Request $request) {

        $user_id = $request->id;
        $data['title'] = 'E-LEAVE - Leave Record';

        $urlLeave = 'eleave/leave/team_leave';
        $param = [
            "token" => session('token'),
            "user_id" => $user_id,
            "branch_id" => session('branch_id'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "notif" => $request->post('notif'),
            "source_id" => $request->post('source_id'),
            "search" => $request->input('search.value'),
            "search_type" => $request['columns'][1]['search']['value'],
            "search_start_date" => $request['columns'][2]['search']['value'],
            "search_end_date" => $request['columns'][3]['search']['value'],
            "search_status" => $request['columns'][10]['search']['value'],
            "search_detail" => $request['columns'][6]['search']['value'],
            "search_year" => $request['columns'][8]['search']['value'],
            "search_month" => $request['columns'][9]['search']['value'],
        ];

        $leave = ElaHelper::myCurl($urlLeave, $param);
        $leaveData = json_decode($leave, true);
        $err = "";
        $no = $request->post('start');
        $hasil = array();
        if ($leaveData['response_code'] == 200) {
            $user_leave = $leaveData['data'];
            //   dd($user_leave);
            $object = json_decode(json_encode($user_leave), FALSE);
            $branch_id = session('branch_id');
            //$holidays = $this->eleave->get_holiday($branch_id);

            foreach ($object as $row) {
                $no++;
                $aksi = "";
                $status = "";

                if ($row->lv_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . $row->rejected_by_name . "</span>";
                } else {
                    if ($row->lv_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                        //hapus leave, add user stella tan or Pan Chui Ting (request Stepi)
                        if (session('is_hr') || session('id') == 13 || session('id') == 320) {
                            $aksi .= "<a class='btn red btn-xs reject' data-toggle='modal' href='#small' title='Delete' id='" . $row->lv_id . "'> <i class='fa fa-trash'></i> </a>";
                        }
                    } else {
                        if ($row->lv_need_revision == 1) {
                            $status = "<span class='label label-sm label-success'>Waiting for employee revision</span>";
                        } else {
                            if ($row->lv_approver_id == 1) {
                                $curr_approver = $row->approver1;
                            } elseif ($row->lv_approver_id == 2) {
                                $curr_approver = $row->approver2;
                            } else {
                                $curr_approver = $row->approver3;
                            }
                            $status = "<span class='label label-warning'>Waiting for " . $curr_approver . "'s approval</span>";
                        }

                        //hapus leave
                        if (session('is_hr') || session('id') == 13 || session('id') == 320) {
                            $aksi .= "<a class='btn red btn-xs reject' data-toggle='modal' href='#small' title='Delete' id='" . $row->lv_id . "'> <i class='fa fa-trash'></i> </a>";
                        }
                    }
                }

                $detail = "";

                if ($row->lv_type == "Compassionate Leave" || $row->lv_type == "Paternity Leave" || $row->lv_type == "Maternity Leave" || $row->lv_type == "Marriage Leave" || $row->lv_type == "Annual Leave" || $row->lv_type == "Medical Leave" || $row->lv_type == "Study Leave") {
//                    if ($row->lv_type == "Annual Leave") {
////                        if ($row->lv_is_emergency != "") {
////                            $detail .= "[" . $row->lv_is_emergency . "] - ";
////                        }
//                        $detail .= ($row->lv_half ? "[" . $row->lv_half . "][".$row->lv_half_time ."]<br>" : "" );
//                    }
//                    $detail .= $row->lv_detail;

                    if (!empty($row->lv_half) && $row->lv_half == "Half Day") {
                        $detail .= (!empty($row->lv_half_time) ? "[" . $row->lv_half . "] [" . $row->lv_half_time . "]<br>" : "[" . $row->lv_half . "]<br>");
                        $detail .= $row->lv_detail;
                    } else {
                        $detail .= (!empty($row->lv_half) ? "[" . $row->lv_half . "]<br>" : "");
                        $detail .= $row->lv_detail;
                    }

                    if ($row->lv_document != "") {
                        if ($row->lv_type == "Medical Leave") {
                            $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_document) . "' target='_blank' style='color:red;'>Click To View Medical Certificate</a>";
                        } else {
                            $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_document) . "' target='_blank' style='color:red;'>Click To View Support Document</a>";
                        }
                    }
                    if ($row->lv_statement_letter != "") {
                        $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_statement_letter) . "' target='_blank' style='color:red;'>Click To View Statement Letter</a>";
                    }
                }
                // data $days & bf get from API

                $year = date('Y', strtotime($row->lv_start_date));
                $month = date('F', strtotime($row->lv_start_date));

                $cek_lv_type = (!empty($row->lv_is_emergency) ? $row->lv_is_emergency . " Leave" : $row->lv_type);
                $hasil[] = array("no" => $no,
                    "lv_type" => $cek_lv_type,
                    "lv_start_date" => date('d M Y', strtotime($row->lv_start_date)),
                    "lv_end_date" => date('d M Y', strtotime($row->lv_end_date)),
                    "lv_submit_date" => $row->lv_submit_date != "0000-00-00" ? $row->lv_submit_date : "",
                    "detail" => $detail,
                    "days" => $row->days . " day(s)",
                    "bf" => $row->bf . " day(s)",
                    "year" => $year,
                    "month" => $month,
                    "status" => $status,
                    "action" => $aksi);
            }
        } else {
            $err = $leaveData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $leaveData['recordsTotal'],
            "recordsFiltered" => $leaveData['recordsFiltered'],
            "totalDays" => $leaveData['totalDays'],
            "totalBf" => $leaveData['totalBf'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function destroyHr(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlLeave = 'eleave/leave/deleteHr';
        $param = [
            "token" => session('token'),
            "user_id" => session('id'),
            "lv_id" => $id,
        ];

        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        $lv = "";
        if ($leaveList['response_code'] == 200) {
            $lv = array('status' => true, 'message' => $leaveList['message']);
        } else {
            $lv = array('status' => false);
        }
        echo json_encode($lv);
    }

    public function getTransLogById(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $urlLeave = 'eleave/log/getTransLogByType';
        $param = [
            "token" => session('token'),
            "user_id" => session('id'),
            "modul" => "Leave",
            "from" => $request->from, //(!empty($request->post('from')) ? date("Y-m-d", strtotime($request->post('from'))) : ""),
            "to" => $request->to, //(!empty($request->post('to')) ? date("Y-m-d", strtotime($request->post('to'))) : ""),
            "branch_id" => "",
        ];

        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        //var_dump($leave_id);
        $leaveList = json_decode($leave_id, true);
        $lv = "";
        if ($leaveList['response_code'] == 200) {
            $lv = array('status' => true, 'message' => $leaveList['message'], 'result_log' => $leaveList['data']);
        } else {
            $lv = array('status' => false);
        }
        echo json_encode($lv);
    }

}
