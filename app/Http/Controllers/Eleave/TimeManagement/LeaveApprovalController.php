<?php
namespace App\Http\Controllers\Eleave\TimeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;

class LeaveApprovalController extends Controller {

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

        return view('Eleave.leave.lv_Approval', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getLeaveApproval(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $columns = array(
            0 => 'lv_date',
            1 => 'lv_description',
        );

        $urlLeave = 'eleave/leaveApproval/index';
        $search = (isset($filter['value'])) ? $filter['value'] : false;
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
            "search_type" => $request['columns'][2]['search']['value'],
            "search_name" => $request['columns'][3]['search']['value'],
            "search_start_date" => $request['columns'][4]['search']['value'],
            "search_end_date" => $request['columns'][5]['search']['value'],
            "search_detail" => $request['columns'][7]['search']['value'],
            "search_active" => $request['columns'][14]['search']['value'],
            "search_status" => $request['columns'][15]['search']['value'],
        ];
        //var_dump($param);exit;
        $leave = ElaHelper::myCurl($urlLeave, $param);

        $leaveData = json_decode($leave, true);

        $err = "";
        $result_leave = array();
        $no = $request->post('start');
        if ($leaveData['response_code'] == 200) {
            $user_leave = $leaveData['data'];
            $object = json_decode(json_encode($user_leave), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $no++;
                $status = "";
                $show = 1;
                if ($row->lv_rejected == 1) {
                    $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->lv_rejected_reason) ? "<i class='fa fa-question' title='" . $row->lv_rejected_reason . "'></i>" : "") . "";
                    $show = 1;
                } else {
                    if ($row->lv_approver_id == 0) {
                        $status = "<span class='label label-sm label-primary'>Approved</span>";
                        $show = 1;
                    } else {
                        if ($row->lv_need_revision == 1) {
                            $status = "<span class='label label-sm label-success'>Waiting for employee revision</span>";
                        } else {
                            $id_approver = 0;
                            if ($row->lv_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->lv_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            }

                            if ($id_approver == session('id')) {
                                $status = "<span class='label label-sm label-warning'>Waiting for your approval</span>";
                                $show = 1;

                                //approve
                                $next = 0;
                                if ($row->lv_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                } elseif ($row->lv_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                } else {
                                    $next = 0;
                                }

                                //approve
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->lv_id . "-" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
                                //reject
                                $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->lv_id . "')><i class='fa fa-close'></i></a>";
                                //$aksi .= "<a class='btn red btn-xs reject' id='" . $row->lv_id . "' title='Reject'><i class='fa fa-close'></i></a>";
                                //revisi
                                $aksi .= "<a class='btn yellow-crusta btn-xs' title='Revision' onclick='revisi_this(" . $row->lv_id . ")'><i class='fa fa-edit'></i></a>";
                            } else {
                                $status = "<span class='label label-sm label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                            }
                        }
                    }
                }

                $detail = "";

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
                            $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_document) . "' target='_blank' style='color:red;'>Click To View Support Document</a>";
                        }
                    }
                    if ($row->lv_statement_letter != "") {
                        $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_statement_letter) . "' target='_blank' style='color:red;'>Click To View Statement Letter</a>";
                    }
                }

                $year = date('Y', strtotime($row->lv_start_date));
                $month = date('F', strtotime($row->lv_start_date));
                $cek_lv_type = (!empty($row->lv_is_emergency) ? $row->lv_is_emergency . " Leave" : $row->lv_type);

                if ($show) {
                    $result_leave[] = array(
                        "no" => $no,
                        "lv_id" => $row->lv_id,
                        "user_name" => $row->user_name,
                        "lv_type" => $cek_lv_type,
                        "lv_start_date" => date('D, d M Y', strtotime($row->lv_start_date)),
                        "lv_end_date" => date('D, d M Y', strtotime($row->lv_end_date)),
                        "lv_submit_date" => $row->lv_submit_date != "0000-00-00" ? date('d M Y', strtotime($row->lv_submit_date)) : "",
                        "detail" => $detail,
                        "days" => $row->days . " day(s)",
                        "year" => $year,
                        "month" => $month,
                        "status" => $status,
                        "action" => $aksi,
                        "user_status" => $row->user_status,
                        "approver1" => User::split_name($row->approver1) . "<br>" . (!empty($row->date_approve1) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve1)) : ''),
                        "approver2" => User::split_name($row->approver2) . "<br>" . (!empty($row->date_approve2) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve2)) : ''),
                        "approver3" => User::split_name($row->approver3) . "<br>" . (!empty($row->date_approve3) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve3)) : ''),
                    );
                }
            }
        } else {
            $err = $leaveData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $leaveData['recordsTotal'],
            "recordsFiltered" => $leaveData['recordsFiltered'],
            "data" => $result_leave,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function getLeaveApprovalNotif(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $columns = array(
            0 => 'lv_date',
            1 => 'lv_description',
        );

        $urlLeave = 'eleave/leaveApproval/index_notif';
        $search = (isset($filter['value'])) ? $filter['value'] : false;
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
            "search_type" => $request['columns'][2]['search']['value'],
            "search_name" => $request['columns'][3]['search']['value'],
            "search_start_date" => $request['columns'][4]['search']['value'],
            "search_end_date" => $request['columns'][5]['search']['value'],
            "search_detail" => $request['columns'][7]['search']['value'],
            "search_active" => $request['columns'][14]['search']['value'],
            "search_status" => $request['columns'][15]['search']['value'],
        ];
        //var_dump($param);exit;
        $leave = ElaHelper::myCurl($urlLeave, $param);

        $leaveData = json_decode($leave, true);

        $err = "";
        $result_leave = array();
        $no = $request->post('start');
        if ($leaveData['response_code'] == 200) {
            $user_leave = $leaveData['data'];
            $object = json_decode(json_encode($user_leave), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";

                $status = "";
                $show = 1;
                if ($row->lv_rejected == 1) {
                    $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->lv_rejected_reason) ? "<i class='fa fa-question' title='" . $row->lv_rejected_reason . "'></i>" : "") . "";
                    $show = 1;
                } else {
                    if ($row->lv_approver_id == 0) {
                        $status = "<span class='label label-sm label-primary'>Approved</span>";
                        $show = 1;
                    } else {
                        if ($row->lv_need_revision == 1) {
                            $status = "<span class='label label-sm label-success'>Waiting for employee revision</span>";
                        } else {
                            $id_approver = 0;
                            if ($row->lv_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->lv_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            }

                            if ($id_approver == session('id')) {
                                $status = "<span class='label label-sm label-warning'>Waiting for your approval</span>";
                                if (!empty($request->post('notif'))) {
                                    $show = "notif";
                                } else {
                                    $show = 1;
                                }

                                //approve
                                $next = 0;
                                if ($row->lv_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                } elseif ($row->lv_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                } else {
                                    $next = 0;
                                }

                                //approve
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->lv_id . "-" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
                                //reject
                                $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->lv_id . "')><i class='fa fa-close'></i></a>";
                                //$aksi .= "<a class='btn red btn-xs reject' id='" . $row->lv_id . "' title='Reject'><i class='fa fa-close'></i></a>";
                                //revisi
                                $aksi .= "<a class='btn yellow-crusta btn-xs' title='Revision' onclick='revisi_this(" . $row->lv_id . ")'><i class='fa fa-edit'></i></a>";
                            } else {
                                $status = "<span class='label label-sm label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                            }
                        }
                    }
                }

                $detail = "";

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
                            $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_document) . "' target='_blank' style='color:red;'>Click To View Support Document</a>";
                        }
                    }
                    if ($row->lv_statement_letter != "") {
                        $detail .= "<br><a href='" . url(env('PUBLIC_PATH') . $row->lv_statement_letter) . "' target='_blank' style='color:red;'>Click To View Statement Letter</a>";
                    }
                }

                $year = date('Y', strtotime($row->lv_start_date));
                $month = date('F', strtotime($row->lv_start_date));
                $cek_lv_type = (!empty($row->lv_is_emergency) ? $row->lv_is_emergency . " Leave" : $row->lv_type);

              //  if ($show == "notif") {
                    $no++;
                    $result_leave[] = array(
                        "no" => $no,
                        "lv_id" => $row->lv_id,
                        "user_name" => $row->user_name,
                        "lv_type" => $cek_lv_type,
                        "lv_start_date" => date('d M Y', strtotime($row->lv_start_date)),
                        "lv_end_date" => date('d M Y', strtotime($row->lv_end_date)),
                        "lv_submit_date" => $row->lv_submit_date != "0000-00-00" ? date('d M Y', strtotime($row->lv_submit_date)) : "",
                        "detail" => $detail,
                        "days" => $row->days,
                        "year" => $year,
                        "month" => $month,
                        "status" => $status,
                        "action" => $aksi,
                        "user_status" => $row->user_status,
                        "approver1" => User::split_name($row->approver1) . "<br>" . (!empty($row->date_approve1) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve1)) : ''),
                        "approver2" => User::split_name($row->approver2) . "<br>" . (!empty($row->date_approve2) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve2)) : ''),
                        "approver3" => User::split_name($row->approver3) . "<br>" . (!empty($row->date_approve3) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve3)) : ''),
                    );
            //    }
            }
        } else {
            $err = $leaveData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($result_leave), //$leaveData['recordsTotal'],
            "recordsFiltered" => count($result_leave), //$leaveData['recordsFiltered'],
            "data" => $result_leave,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function revise(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlLeave = 'eleave/leaveApproval/revise';
        $param = [
            'token' => session('token'),
            //'user_id' => $request->user_id,
            'lv_id' => $request->lv_id,
            'lv_approver_id' => 1,
            'lv_need_revision' => 1,
            'lv_revision_reason' => $request->lv_reason,
            'lv_revision_from' => session('id'),
            'lv_revision_nama' => session('nama') // for mail template (who is revise???)
        ];
        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        $lv = "";
        if ($leaveList['response_code'] == 200) {
            $lv = array('status' => true, 'message' => $leaveList['message']);
        } else {
            $lv = array('status' => false, 'message' => $leaveList['message']);
        }
        echo json_encode($lv);
    }

    public function approve(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlLeave = 'eleave/leaveApproval/approve';
        $param = [
            'token' => session('token'),
            'next' => $request->next,
            'lv_id' => $request->lv_id,
            'lv_approve_nama' => session('nama'),
        ];
        //dd($param);
        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        //dd($leaveList);
        $lv = "";
        if ($leaveList['response_code'] == 200) {
            $lv = array('status' => true, 'message' => $leaveList['message']);
        } else {
            $lv = array('status' => false, 'message' => $leaveList['message']);
        }
        echo json_encode($lv);
    }

    public function reject(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlLeave = 'eleave/leaveApproval/reject';
        $param = [
            'token' => session('token'),
            //'user_id' => $request->user_id,
            'lv_id' => $request->lv_id,
            'lv_rejected' => 1,
            'lv_rejected_by' => session('id'),
            'lv_rejected_nama' => session('nama'), // for mail template (who is rejected???)
            'lv_rejected_reason' => $request->lv_reason,
        ];
        //dd($param);
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

    public function add() {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        return view('Eleave.leave.new');
    }

    public function edit($id) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlLeave = 'eleave/leave/getLeaveId';
        $param = [
            "token" => session('token'),
            "lv_id" => $id,
        ];
        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        $ot = "";
        if ($leaveList['response_code'] == 200) {
            $ot = json_decode(json_encode($leaveList['data']), FALSE);
        } else {
            $ot = $leaveList['message'];
        }
        // dd($leaveList['data']);
        return view('Eleave.leave.leaveEdit', ['ot' => $ot]);
    }

    public function getHoliday(Request $request) {
        $date = array_values($request->post('rows'));
        //echo "<pre>";print_r($request->all());echo "</pre>";
        $urlHoliday = 'eleave/leave/getholiday';
        $param = [
            "token" => session('token'),
            "date" => $date,
            "branch" => session('branch_id'),
        ];
        $leave_hol = ElaHelper::myCurl($urlHoliday, $param);
        $leaveHoliday = json_decode($leave_hol, true);

        $row = array();
        if ($leaveHoliday['response_code'] == 200) {
            foreach ($leaveHoliday['data'] as $value) {
                $row[] = array(
                    'hol_date' => $value['hol_date']
                );
            }
        } else {
            $row = $leaveHoliday['message'];
        }
        echo json_encode($row);
    }

    public function save(Request $request) {
        $urlLeave = 'eleave/leave/save';
        $param = [
            "token" => session('token'),
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
            "lv_submit_date" => date('Y-m-d')
        ];

        $leave = ElaHelper::myCurl($urlLeave, $param);
        $leaveSave = json_decode($leave, true);
        //echo json_encode($leaveSave);
        //      dd($leaveSave['response_code']);
        if ($leaveSave['response_code'] == 200) {
            return redirect('eleave/leave/index')
                            ->with('success', $leaveSave['message']);
        } else {
            return redirect('eleave/leave/add')
                            ->with('success', $leaveSave['message']);
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
        // dd($param);
        $leave_id = ElaHelper::myCurl($urlLeave, $param);
        $leaveList = json_decode($leave_id, true);
        $ot = "";
        if ($leaveList['response_code'] == 200) {
            $ot = array('status' => true);
        } else {
            $ot = $leaveList['message'];
        }

        echo json_encode($ot);
    }

    function isWeekend($date) {
        // $weekDay = date('w', strtotime($date));
        return (date('N', strtotime($date)) >= 6);
    }

}
