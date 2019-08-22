<?php
namespace App\Http\Controllers\Eleave\TimeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;

class OvertimeApprovalController extends Controller {

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

        return view('Eleave.overtime.overtimeApproval', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getOvertimeApproval(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $columns = array(
            0 => 'ot_date',
            1 => 'ot_description',
        );

        $urlOvertime = 'eleave/overtimeApproval/index';
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "notif" => $request->post('notif'),
            "source_id" => $request->post('source_id'),
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_in" => $request['columns'][4]['search']['value'],
            "search_out" => $request['columns'][5]['search']['value'],
            "search_from" => $request['columns'][6]['search']['value'],
            "search_to" => $request['columns'][7]['search']['value'],
//            "search_start" => $request['columns'][7]['search']['value'],
//            "search_end" => $request['columns'][7]['search']['value'],
            "search_desc" => $request['columns'][11]['search']['value'],
            "search_reason" => $request['columns'][12]['search']['value'],
            "search_impact" => $request['columns'][13]['search']['value'],
            "search_active" => $request['columns'][20]['search']['value'],
            "search_status" => $request['columns'][21]['search']['value'],
        ];
        // dd($param);
        $overtime = ElaHelper::myCurl($urlOvertime, $param);

        $overtimeData = json_decode($overtime, true);

        $err = "";
        $result_overtime = array();
        $no = $request->post('start');
        if ($overtimeData['response_code'] == 200) {

            $user_overtime = $overtimeData['data'];
            $object = json_decode(json_encode($user_overtime), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $no++;
                $status = "";
                $show = 0;
                if ($row->ot_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->ot_rejected_reason) ? "<i class='fa fa-question' title='" . $row->ot_rejected_reason . "'></i>" : "") . "";
                    $show = 1;
                } else {
                    if ($row->ot_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                        $show = 1;
                    } else {
                        if ($row->ot_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
                            $show = 1;
                        } else {
                            $id_approver = 0;
                            if ($row->ot_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ot_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            }
                            if ($id_approver == session('id')) {
                                $status = "<span class='label label-warning'>Waiting for your approval</span>";
                                $show = 1;
                                //if($row->ot_approver_id != 0){
                                //approve
                                $next = 0;
                                if ($row->ot_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                } elseif ($row->ot_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                } else {
                                    $next = 0;
                                }
                                //approve
                                //$aksi .= "<a href='" . url("eleave/overtimeApproval/reject/" . $row->ot_id . "/" . $next) . "'  class='btn btn-icon-only blue approve' title='Approve' id='approve-" . $no . "-" . $row->ot_id . "-" . $next . "'><i class='fa fa-thumbs-up'></i></a>&nbsp;&nbsp;&nbsp;";
                                $aksi .= "<a class='btn btn-xs blue approve' id='" . $row->ot_id . "-" . $next . "' title='Approve'><i class='fa fa-check'></i></a>";
                                //reject
                                $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->ot_id . "')><i class='fa fa-close'></i></a>";
                                //$aksi .= "<a class='btn btn-xs red reject' id='" . $row->ot_id . "' title='Reject'><i class='fa fa-close'></i></a>";
                                //revisi
                                //$aksi .=     "<a href='".base_url()."index.php/overtime_approval/revise/".$row->ot_id."' class='btn btn-icon-only yellow-crusta' title='Reject'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;&nbsp;";
                                //$aksi .= "<a class='btn btn-icon-only yellow-crusta tombol-delete' data-toggle='modal' data-user='" . $row->user_id . "' data-id='" . $row->ot_id . "' data-target='#small'  href='#small' title='Revision' id='" . $row->ot_id . "'> <i class='fa fa-edit'></i> </a>&nbsp;&nbsp;&nbsp;";

                                $aksi .= "<a onclick='revisi_this(" . $row->ot_id . ")' class='btn btn-xs yellow-crusta tombol-delete revise' title='Revise'><i class='fa fa-edit'></i></a>";
                                //}
                            } else {
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                $show = 1;
                            }
                        }
                    }
                }

                if ($show) {

                    if (!empty($row->at_time_in) && empty($row->ts_time_in)) {
                        $at_time_in = substr($row->at_time_in, 0, -3);
                    } elseif (!empty($row->ts_time_in) && empty($row->at_time_in)) {
                        $at_time_in = substr($row->ts_time_in, 0, -3);
                    } elseif ((!empty($row->at_time_in) && !empty($row->ts_time_in))) {
                        $absen = strtotime($row->at_time_in);
                        $timesheet = strtotime($row->ts_time_in);
                        $at_time_in = ($absen < $timesheet ? substr($row->at_time_in, 0, -3) : substr($row->ts_time_in, 0, -3));
                    } else {
                        $at_time_in = "-";
                    }

                    if (!empty($row->at_time_out) && empty($row->ts_time_out)) {
                        $at_time_out = substr($row->at_time_out, 0, -3);
                    } elseif (!empty($row->ts_time_out) && empty($row->at_time_out)) {
                        $at_time_out = substr($row->ts_time_out, 0, -3);
                    } elseif ((!empty($row->at_time_out) && !empty($row->ts_time_out))) {
                        $absen = strtotime($row->at_time_out);
                        $timesheet = strtotime($row->ts_time_out);
                        $at_time_out = ($absen > $timesheet ? substr($row->at_time_out, 0, -3) : substr($row->ts_time_out, 0, -3));
                    } else {
                        $at_time_out = "-";
                    }

                    if (!empty($row->at_time_in)) {
                        if ($this->isWeekend($row->ot_date)) {
                            $actual_start = substr($row->at_time_in, 0, -3);
                        } else {
                            $actual_start = "17:30";
                        }
                    } elseif (!empty($row->ts_time_in)) {
                        if ($this->isWeekend($row->ot_date)) {
                            $actual_start = substr($row->ts_time_in, 0, -3);
                        } else {
                            $actual_start = "17:30";
                        }
                    } else {
                        $actual_start = "-";
                    }

                    if (!empty($row->at_time_out) && empty($row->ts_time_out)) {
                        if (strtotime($row->at_time_out) > strtotime($row->ot_time_out)) {
                            $actual_end = $row->ot_time_out;
                        } else {
                            $actual_end = substr($row->at_time_out, 0, -3);
                        }
                    } elseif (!empty($row->ts_time_out) && empty($row->at_time_out)) {
                        if (strtotime($row->ts_time_out) > strtotime($row->ot_time_out)) {
                            $actual_end = $row->ot_time_out;
                        } else {
                            $actual_end = substr($row->ts_time_out, 0, -3);
                        }
                    } elseif ((!empty($row->at_time_out) && !empty($row->ts_time_out))) {
                        if (strtotime($row->ts_time_out) > strtotime($row->at_time_out)) {
                            if ((strtotime($row->ts_time_out) || strtotime($row->at_time_out)) > strtotime($row->ot_time_out)) {
                                $actual_end = $row->ot_time_out;
                            } else {
                                $actual_end = substr($row->ts_time_out, 0, -3);
                            }
                        } else {
                            $actual_end = $row->ot_time_out;
                        }
                    } else {
                        $actual_end = "-";
                    }

                    $t1 = strtotime($actual_start);
                    $t2 = strtotime($actual_end);
                    $total_time1 = ($t2 - $t1) / 60;   //$hours = 1.7
                    $total_time = sprintf("%d Hours %02d Minute", floor($total_time1 / 60), $total_time1 % 60);
                    //

                    $result_overtime[] = array(
                        "no" => $no,
                        "ot_id" => $row->ot_id,
                        "user_name" => $row->user_name,
                        //"ot_type" => $row->ot_type,
                        //"ot_date" => $row->ot_date,
                        "ot_date" => date('D, d M Y', strtotime($row->ot_date)),
                        "status" => $status,
                        "action" => $aksi,
                        //"ot_end_date" => $get_date_range->end_date,
                        "ot_submit_date" => $row->ot_submit_date != "0000-00-00" ? $row->ot_submit_date : "",
                        "ot_time_in" => $row->ot_time_in,
                        "ot_time_out" => $row->ot_time_out,
                        "ot_description" => $row->ot_description,
                        "ot_reason" => $row->ot_reason,
                        "ot_negative_impact" => $row->ot_negative_impact,
                        // "ot_total_time" => $rows . " day(s)", //$row->ot_total_time,
                        "year" => date('Y', strtotime($row->ot_date)),
                        "month" => date('F', strtotime($row->ot_date)),
                        "approver1" => User::split_name($row->approver1) . "<br>" . (!empty($row->date_approve1) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> ".date('d-M-y H:i', strtotime($row->date_approve1)) : ''),
                        "approver2" => User::split_name($row->approver2) . "<br>" . (!empty($row->date_approve2) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> ".date('d-M-y H:i', strtotime($row->date_approve2)) : ''),
                        "approver3" => User::split_name($row->approver3) . "<br>" . (!empty($row->date_approve3) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> ".date('d-M-y H:i', strtotime($row->date_approve3)) : ''),
                        "user_status" => $row->user_status,
                        //"at_date" => $row->at_date,
                        "at_time_in" => $at_time_in,
                        "at_time_out" => $at_time_out,
                        "actual_start" => $actual_start, //(!empty($row->at_time_in) ? substr($row->at_time_in, 0, -3) : (!empty($row->ts_time_in) ? substr($row->ts_time_in, 0, -3) : "-")),
                        "actual_end" => $actual_end, //($row->ot_time_out > substr($row->at_time_out, 0, -3) ? (!empty($row->at_time_in) ? substr($row->at_time_out, 0, -3) : "-") : $row->ot_time_out)
                        "total_actual" => $total_time
                    );
                }
            }
        } else {
            $err = $overtimeData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $overtimeData['recordsTotal'],
            "recordsFiltered" => $overtimeData['recordsFiltered'],
            "data" => $result_overtime,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function getOvertimeApprovalNotif(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $columns = array(
            0 => 'ot_date',
            1 => 'ot_description',
        );

        $urlOvertime = 'eleave/overtimeApproval/index';
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "notif" => $request->post('notif'),
            "source_id" => $request->post('source_id'),
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_in" => $request['columns'][4]['search']['value'],
            "search_out" => $request['columns'][5]['search']['value'],
            "search_from" => $request['columns'][6]['search']['value'],
            "search_to" => $request['columns'][7]['search']['value'],
//            "search_start" => $request['columns'][7]['search']['value'],
//            "search_end" => $request['columns'][7]['search']['value'],
            "search_desc" => $request['columns'][11]['search']['value'],
            "search_reason" => $request['columns'][12]['search']['value'],
            "search_impact" => $request['columns'][13]['search']['value'],
            "search_active" => $request['columns'][20]['search']['value'],
            "search_status" => $request['columns'][21]['search']['value'],
        ];
        $overtime = ElaHelper::myCurl($urlOvertime, $param);
        $overtimeData = json_decode($overtime, true);

        $err = "";
        $result_overtime = array();
        $no = $request->post('start');
        if ($overtimeData['response_code'] == 200) {

            $user_overtime = $overtimeData['data'];
            $object = json_decode(json_encode($user_overtime), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";

                $status = "";
                $show = 0;
                if ($row->ot_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->ot_rejected_reason) ? "<i class='fa fa-question' title='" . $row->ot_rejected_reason . "'></i>" : "") . "";
                    $show = 1;
                } else {
                    if ($row->ot_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                        $show = 1;
                    } else {
                        if ($row->ot_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
                            $show = 1;
                        } else {
                            $id_approver = 0;
                            if ($row->ot_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ot_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            }
                            if ($id_approver == session('id')) {
                                $status = "<span class='label label-warning'>Waiting for your approval</span>";
                                if (!empty($request->post('notif'))) {
                                    $show = "notif";
                                } else {
                                    $show = 1;
                                }
                                //if($row->ot_approver_id != 0){
                                //approve
                                $next = 0;
                                if ($row->ot_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                } elseif ($row->ot_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                } else {
                                    $next = 0;
                                }
                                //approve
                                //$aksi .= "<a href='" . url("eleave/overtimeApproval/reject/" . $row->ot_id . "/" . $next) . "'  class='btn btn-icon-only blue approve' title='Approve' id='approve-" . $no . "-" . $row->ot_id . "-" . $next . "'><i class='fa fa-thumbs-up'></i></a>&nbsp;&nbsp;&nbsp;";
                                $aksi .= "<a class='btn btn-xs blue approve' id='" . $row->ot_id . "-" . $next . "' title='Approve'><i class='fa fa-check'></i></a>";
                                //reject
                                $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->ot_id . "')><i class='fa fa-close'></i></a>";
                                //$aksi .= "<a class='btn btn-xs red reject' id='" . $row->ot_id . "' title='Reject'><i class='fa fa-close'></i></a>";
                                //revisi
                                //$aksi .=     "<a href='".base_url()."index.php/overtime_approval/revise/".$row->ot_id."' class='btn btn-icon-only yellow-crusta' title='Reject'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;&nbsp;";
                                //$aksi .= "<a class='btn btn-icon-only yellow-crusta tombol-delete' data-toggle='modal' data-user='" . $row->user_id . "' data-id='" . $row->ot_id . "' data-target='#small'  href='#small' title='Revision' id='" . $row->ot_id . "'> <i class='fa fa-edit'></i> </a>&nbsp;&nbsp;&nbsp;";

                                $aksi .= "<a onclick='revisi_this(" . $row->ot_id . ")' class='btn btn-xs yellow-crusta tombol-delete revise' title='Revise'><i class='fa fa-edit'></i></a>";
                                //}
                            } else {
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                $show = 1;
                            }
                        }
                    }
                }

                if ($show == "notif") {
                    $no++;
                    if (!empty($row->at_time_in) && empty($row->ts_time_in)) {
                        $at_time_in = substr($row->at_time_in, 0, -3);
                    } elseif (!empty($row->ts_time_in) && empty($row->at_time_in)) {
                        $at_time_in = substr($row->ts_time_in, 0, -3);
                    } elseif ((!empty($row->at_time_in) && !empty($row->ts_time_in))) {
                        $absen = strtotime($row->at_time_in);
                        $timesheet = strtotime($row->ts_time_in);
                        $at_time_in = ($absen < $timesheet ? substr($row->at_time_in, 0, -3) : substr($row->ts_time_in, 0, -3));
                    } else {
                        $at_time_in = "-";
                    }

                    if (!empty($row->at_time_out) && empty($row->ts_time_out)) {
                        $at_time_out = substr($row->at_time_out, 0, -3);
                    } elseif (!empty($row->ts_time_out) && empty($row->at_time_out)) {
                        $at_time_out = substr($row->ts_time_out, 0, -3);
                    } elseif ((!empty($row->at_time_out) && !empty($row->ts_time_out))) {
                        $absen = strtotime($row->at_time_out);
                        $timesheet = strtotime($row->ts_time_out);
                        $at_time_out = ($absen > $timesheet ? substr($row->at_time_out, 0, -3) : substr($row->ts_time_out, 0, -3));
                    } else {
                        $at_time_out = "-";
                    }

                    if (!empty($row->at_time_in)) {
                        if ($this->isWeekend($row->ot_date)) {
                            $actual_start = substr($row->at_time_in, 0, -3);
                        } else {
                            $actual_start = "17:30";
                        }
                    } elseif (!empty($row->ts_time_in)) {
                        if ($this->isWeekend($row->ot_date)) {
                            $actual_start = substr($row->ts_time_in, 0, -3);
                        } else {
                            $actual_start = "17:30";
                        }
                    } else {
                        $actual_start = "-";
                    }

                    if (!empty($row->at_time_out) && empty($row->ts_time_out)) {
                        if (strtotime($row->at_time_out) > strtotime($row->ot_time_out)) {
                            $actual_end = $row->ot_time_out;
                        } else {
                            $actual_end = substr($row->at_time_out, 0, -3);
                        }
                    } elseif (!empty($row->ts_time_out) && empty($row->at_time_out)) {
                        if (strtotime($row->ts_time_out) > strtotime($row->ot_time_out)) {
                            $actual_end = $row->ot_time_out;
                        } else {
                            $actual_end = substr($row->ts_time_out, 0, -3);
                        }
                    } elseif ((!empty($row->at_time_out) && !empty($row->ts_time_out))) {
                        if (strtotime($row->ts_time_out) > strtotime($row->at_time_out)) {
                            if ((strtotime($row->ts_time_out) || strtotime($row->at_time_out)) > strtotime($row->ot_time_out)) {
                                $actual_end = $row->ot_time_out;
                            } else {
                                $actual_end = substr($row->ts_time_out, 0, -3);
                            }
                        } else {
                            $actual_end = $row->ot_time_out;
                        }
                    } else {
                        $actual_end = "-";
                    }

                    $t1 = strtotime($actual_start);
                    $t2 = strtotime($actual_end);
                    $total_time1 = ($t2 - $t1) / 60;   //$hours = 1.7
                    $total_time = sprintf("%d Hours %02d Minute", floor($total_time1 / 60), $total_time1 % 60);
                    //

                    $result_overtime[] = array(
                        "no" => $no,
                        "ot_id" => $row->ot_id,
                        "user_name" => $row->user_name,
                        //"ot_type" => $row->ot_type,
                        //"ot_date" => $row->ot_date,
                        "ot_date" => date('D, d M Y', strtotime($row->ot_date)),
                        "status" => $status,
                        "action" => $aksi,
                        //"ot_end_date" => $get_date_range->end_date,
                        "ot_submit_date" => $row->ot_submit_date != "0000-00-00" ? $row->ot_submit_date : "",
                        "ot_time_in" => $row->ot_time_in,
                        "ot_time_out" => $row->ot_time_out,
                        "ot_description" => $row->ot_description,
                        "ot_reason" => $row->ot_reason,
                        "ot_negative_impact" => $row->ot_negative_impact,
                        // "ot_total_time" => $rows . " day(s)", //$row->ot_total_time,
                        "year" => date('Y', strtotime($row->ot_date)),
                        "month" => date('F', strtotime($row->ot_date)),
                        "approver1" => User::split_name($row->approver1) . "<br>" . (!empty($row->date_approve1) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> ".date('d-M-y H:i', strtotime($row->date_approve1)) : ''),
                        "approver2" => User::split_name($row->approver2) . "<br>" . (!empty($row->date_approve2) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> ".date('d-M-y H:i', strtotime($row->date_approve2)) : ''),
                        "approver3" => User::split_name($row->approver3) . "<br>" . (!empty($row->date_approve3) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> ".date('d-M-y H:i', strtotime($row->date_approve3)) : ''),
                        "user_status" => $row->user_status,
                        //"at_date" => $row->at_date,
                        "at_time_in" => $at_time_in,
                        "at_time_out" => $at_time_out,
                        "actual_start" => $actual_start, //(!empty($row->at_time_in) ? substr($row->at_time_in, 0, -3) : (!empty($row->ts_time_in) ? substr($row->ts_time_in, 0, -3) : "-")),
                        "actual_end" => $actual_end, //($row->ot_time_out > substr($row->at_time_out, 0, -3) ? (!empty($row->at_time_in) ? substr($row->at_time_out, 0, -3) : "-") : $row->ot_time_out)
                        "total_actual" => $total_time
                    );
                }
            }
        } else {
            $err = $overtimeData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($result_overtime),//$overtimeData['recordsTotal'],
            "recordsFiltered" => count($result_overtime),//$overtimeData['recordsFiltered'],
            "data" => $result_overtime,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function revise(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlOvertime = 'eleave/overtimeApproval/revise';
        $param = [
            'token' => session('token'),
            //'user_id' => $request->user_id,
            'ot_id' => $request->ot_id,
            'ot_approver_id' => 1,
            'ot_need_revision' => 1,
            'ot_revision_reason' => $request->ot_reason,
            'ot_revision_from' => session('id'),
            'ot_revision_nama' => session('nama'),
        ];
        $overtime_id = ElaHelper::myCurl($urlOvertime, $param);
        $overtimeList = json_decode($overtime_id, true);
        $ot = "";
        if ($overtimeList['response_code'] == 200) {
            $ot = array('status' => true, 'message' => $overtimeList['message']);
        } else {
            $ot = array('status' => false, 'message' => $overtimeList['message']);
        }
        echo json_encode($ot);
    }

    public function approve(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlOvertime = 'eleave/overtimeApproval/approve';
        $param = [
            'token' => session('token'),
            'next' => $request->next,
            'ot_id' => $request->ot_id,
            'ot_approve_nama' => session('nama'),
        ];
        //dd($param);
        $overtime_id = ElaHelper::myCurl($urlOvertime, $param);
        $overtimeList = json_decode($overtime_id, true);
        $ot = "";
        if ($overtimeList['response_code'] == 200) {
            $ot = array('status' => true, 'message' => $overtimeList['message']);
        } else {
            $ot = array('status' => false);
        }
        echo json_encode($ot);
    }

    public function reject(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlOvertime = 'eleave/overtimeApproval/reject';
        $param = [
            'token' => session('token'),
            //'user_id' => $request->user_id,
            'ot_id' => $request->ot_id,
            'ot_rejected' => 1,
            'ot_rejected_by' => session('id'),
            'ot_rejected_nama' => session('nama'),
            'ot_rejected_reason' => $request->ot_reason,
        ];
        //dd($param);
        $overtime_id = ElaHelper::myCurl($urlOvertime, $param);
        $overtimeList = json_decode($overtime_id, true);

        $ot = "";
        if ($overtimeList['response_code'] == 200) {
            $ot = array('status' => true, 'message' => $overtimeList['message']);
        } else {
            $ot = array('status' => false);
        }
        echo json_encode($ot);
    }

    public function add() {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        return view('Eleave.overtime.new');
    }

    public function edit($id) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlOvertime = 'eleave/overtime/getOvertimeId';
        $param = [
            "token" => session('token'),
            "ot_id" => $id,
        ];
        $overtime_id = ElaHelper::myCurl($urlOvertime, $param);
        $overtimeList = json_decode($overtime_id, true);
        $ot = "";
        if ($overtimeList['response_code'] == 200) {
            $ot = json_decode(json_encode($overtimeList['data']), FALSE);
        } else {
            $ot = $overtimeList['message'];
        }
        // dd($overtimeList['data']);
        return view('Eleave.overtime.overtimeEdit', ['ot' => $ot]);
    }

    public function getHoliday(Request $request) {
        $date = array_values($request->post('rows'));
        //echo "<pre>";print_r($request->all());echo "</pre>";
        $urlHoliday = 'eleave/overtime/getholiday';
        $param = [
            "token" => session('token'),
            "date" => $date,
            "branch" => session('branch_id'),
        ];
        $overtime_hol = ElaHelper::myCurl($urlHoliday, $param);
        $overtimeHoliday = json_decode($overtime_hol, true);

        $row = array();
        if ($overtimeHoliday['response_code'] == 200) {
            foreach ($overtimeHoliday['data'] as $value) {
                $row[] = array(
                    'hol_date' => $value['hol_date']
                );
            }
        } else {
            $row = $overtimeHoliday['message'];
        }
        echo json_encode($row);
    }

    public function save(Request $request) {
        $urlOvertime = 'eleave/overtime/save';
        $param = [
            "token" => session('token'),
            "user_id" => session('id'),
            "ot_date" => $request->post('ot_date'),
            "ot_time_in" => $request->post('ot_time_in'),
            "ot_time_out" => $request->post('ot_time_out'),
            "ot_description" => $request->post('ot_description'),
            "ot_reason" => $request->post('ot_reason'),
            "ot_negative_impact" => $request->post('ot_impact'),
            "branch_id" => session('branch_id'),
            "ot_finger_print_id" => session('finger_print_id'),
            "ot_approver_id" => 1,
            "ot_need_revision" => 0,
            "ot_last_update" => date('Y-m-d H:i:s'),
            "ot_submit_date" => date('Y-m-d')
        ];

        $overtime = ElaHelper::myCurl($urlOvertime, $param);
        $overtimeSave = json_decode($overtime, true);
        //echo json_encode($overtimeSave);
        //      dd($overtimeSave['response_code']);
        if ($overtimeSave['response_code'] == 200) {
            return redirect('eleave/overtime/index')
                            ->with('success', $overtimeSave['message']);
        } else {
            return redirect('eleave/overtime/add')
                            ->with('success', $overtimeSave['message']);
        }
    }

    public function update(Request $request, $id) {
        $urlOvertime = 'eleave/overtime/update';
        $param = [
            "token" => session('token'),
            "ot_id" => $id,
            "user_id" => session('id'),
            "ot_date" => $request->post('ot_date'),
            "ot_time_in" => $request->post('ot_time_in'),
            "ot_time_out" => $request->post('ot_time_out'),
            "ot_description" => $request->post('ot_description'),
            "ot_reason" => $request->post('ot_reason'),
            "ot_negative_impact" => $request->post('ot_impact'),
            "branch_id" => session('branch_id'),
            "ot_finger_print_id" => session('finger_print_id'),
            "ot_approver_id" => 1,
            "ot_need_revision" => 0,
            "ot_last_update" => date('Y-m-d H:i:s'),
        ];

        $overtime = ElaHelper::myCurl($urlOvertime, $param);
        $overtimeUpdate = json_decode($overtime, true);
        //dd($param);
        //echo json_encode($overtimeSave);
        return redirect('eleave/overtime/index')
                        ->with('success', $overtimeUpdate['message']);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlOvertime = 'eleave/overtime/delete';
        $param = [
            "token" => session('token'),
            "ot_id" => $id,
        ];
        // dd($param);
        $overtime_id = ElaHelper::myCurl($urlOvertime, $param);
        $overtimeList = json_decode($overtime_id, true);
        $ot = "";
        if ($overtimeList['response_code'] == 200) {
            $ot = array('status' => true);
        } else {
            $ot = $overtimeList['message'];
        }

        echo json_encode($ot);
    }

    function isWeekend($date) {
        // $weekDay = date('w', strtotime($date));
        return (date('N', strtotime($date)) >= 6);
    }

    public function notification(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $columns = array(
            0 => 'ot_date',
            1 => 'ot_description',
        );

        $urlOvertime = 'eleave/overtimeApproval/notify';
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_in" => $request['columns'][4]['search']['value'],
            "search_out" => $request['columns'][5]['search']['value'],
            "search_from" => $request['columns'][6]['search']['value'],
            "search_to" => $request['columns'][7]['search']['value'],
//            "search_start" => $request['columns'][7]['search']['value'],
//            "search_end" => $request['columns'][7]['search']['value'],
            "search_desc" => $request['columns'][11]['search']['value'],
//            "search_reason" => $request['columns'][10]['search']['value'],
//            "search_impact" => $request['columns'][11]['search']['value'],
        ];
        //var_dump($param);exit;
        $overtime = ElaHelper::myCurl($urlOvertime, $param);

        $overtimeData = json_decode($overtime, true);

        $err = "";
        $result_overtime = array();
        $no = $request->post('start');
        if ($overtimeData['response_code'] == 200) {

            $user_overtime = $overtimeData['data'];
            $object = json_decode(json_encode($user_overtime), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $no++;
                $status = "";
                $show = 0;
                if ($row->ot_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>";
                    $show = 1;
                } else {
                    if ($row->ot_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                        $show = 1;
                    } else {
                        if ($row->ot_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
                            $show = 1;
                        } else {
                            $id_approver = 0;
                            if ($row->ot_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ot_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            }
                            if ($id_approver == session('id')) {
                                $status = "<span class='label label-warning'>Waiting for your approval</span>";
                                $show = 1;
                                //if($row->ot_approver_id != 0){
                                //approve
                                $next = 0;
                                if ($row->ot_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                } elseif ($row->ot_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                } else {
                                    $next = 0;
                                }
                                //approve
                                //$aksi .= "<a href='" . url("eleave/overtimeApproval/reject/" . $row->ot_id . "/" . $next) . "'  class='btn btn-icon-only blue approve' title='Approve' id='approve-" . $no . "-" . $row->ot_id . "-" . $next . "'><i class='fa fa-thumbs-up'></i></a>&nbsp;&nbsp;&nbsp;";
                                $aksi .= "<a class='btn btn-xs blue approve' id='" . $row->ot_id . "-" . $next . "' title='Approve'><i class='fa fa-check'></i></a>";
                                //reject
                                // $aksi .= "<a href='" . url("eleave/overtimeApproval/reject/". $row->ot_id ) . "' class='btn btn-icon-only red reject' title='Reject' id='reject-" . $no . "-" . $row->ot_id . "'><i class='fa fa-thumbs-down'></i></a>&nbsp;&nbsp;&nbsp;";
                                $aksi .= "<a class='btn btn-xs red reject' id='" . $row->ot_id . "' title='Reject'><i class='fa fa-close'></i></a>";
                                //revisi
                                //$aksi .=     "<a href='".base_url()."index.php/overtime_approval/revise/".$row->ot_id."' class='btn btn-icon-only yellow-crusta' title='Reject'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;&nbsp;";
                                //$aksi .= "<a class='btn btn-icon-only yellow-crusta tombol-delete' data-toggle='modal' data-user='" . $row->user_id . "' data-id='" . $row->ot_id . "' data-target='#small'  href='#small' title='Revision' id='" . $row->ot_id . "'> <i class='fa fa-edit'></i> </a>&nbsp;&nbsp;&nbsp;";

                                $aksi .= "<a onclick='revisi_this(" . $row->ot_id . ")' class='btn btn-xs yellow-crusta tombol-delete revise' title='Revise'><i class='fa fa-edit'></i></a>";
                                //}
                            } else {
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                $show = 1;
                            }
                        }
                    }
                }

                if ($show) {

                    if (!empty($row->at_time_in) && empty($row->ts_time_in)) {
                        $at_time_in = substr($row->at_time_in, 0, -3);
                    } elseif (!empty($row->ts_time_in) && empty($row->at_time_in)) {
                        $at_time_in = substr($row->ts_time_in, 0, -3);
                    } elseif ((!empty($row->at_time_in) && !empty($row->ts_time_in))) {
                        $absen = strtotime($row->at_time_in);
                        $timesheet = strtotime($row->ts_time_in);
                        $at_time_in = ($absen < $timesheet ? substr($row->at_time_in, 0, -3) : substr($row->ts_time_in, 0, -3));
                    } else {
                        $at_time_in = "-";
                    }

                    if (!empty($row->at_time_out) && empty($row->ts_time_out)) {
                        $at_time_out = substr($row->at_time_out, 0, -3);
                    } elseif (!empty($row->ts_time_out) && empty($row->at_time_out)) {
                        $at_time_out = substr($row->ts_time_out, 0, -3);
                    } elseif ((!empty($row->at_time_out) && !empty($row->ts_time_out))) {
                        $absen = strtotime($row->at_time_out);
                        $timesheet = strtotime($row->ts_time_out);
                        $at_time_out = ($absen > $timesheet ? substr($row->at_time_out, 0, -3) : substr($row->ts_time_out, 0, -3));
                    } else {
                        $at_time_out = "-";
                    }

                    if (!empty($row->at_time_in)) {
                        if ($this->isWeekend($row->ot_date)) {
                            $actual_start = substr($row->at_time_in, 0, -3);
                        } else {
                            $actual_start = "17:30";
                        }
                    } elseif (!empty($row->ts_time_in)) {
                        if ($this->isWeekend($row->ot_date)) {
                            $actual_start = substr($row->ts_time_in, 0, -3);
                        } else {
                            $actual_start = "17:30";
                        }
                    } else {
                        $actual_start = "-";
                    }

                    if (!empty($row->at_time_out) && empty($row->ts_time_out)) {
                        if (strtotime($row->at_time_out) > strtotime($row->ot_time_out)) {
                            $actual_end = $row->ot_time_out;
                        } else {
                            $actual_end = substr($row->at_time_out, 0, -3);
                        }
                    } elseif (!empty($row->ts_time_out) && empty($row->at_time_out)) {
                        if (strtotime($row->ts_time_out) > strtotime($row->ot_time_out)) {
                            $actual_end = $row->ot_time_out;
                        } else {
                            $actual_end = substr($row->ts_time_out, 0, -3);
                        }
                    } elseif ((!empty($row->at_time_out) && !empty($row->ts_time_out))) {
                        if (strtotime($row->ts_time_out) > strtotime($row->at_time_out)) {
                            if ((strtotime($row->ts_time_out) || strtotime($row->at_time_out)) > strtotime($row->ot_time_out)) {
                                $actual_end = $row->ot_time_out;
                            } else {
                                $actual_end = substr($row->ts_time_out, 0, -3);
                            }
                        } else {
                            $actual_end = $row->ot_time_out;
                        }
                    } else {
                        $actual_end = "-";
                    }

                    $t1 = strtotime($actual_start);
                    $t2 = strtotime($actual_end);
                    $total_time1 = ($t2 - $t1) / 60;   //$hours = 1.7
                    $total_time = sprintf("%d Hours %02d Minute", floor($total_time1 / 60), $total_time1 % 60);
                    //

                    $result_overtime[] = array(
                        "no" => $no,
                        "ot_id" => $row->ot_id,
                        "user_name" => $row->user_name,
                        //"ot_type" => $row->ot_type,
                        //"ot_date" => $row->ot_date,
                        "ot_date" => $row->ot_date,
                        "status" => $status,
                        "action" => $aksi,
                        //"ot_end_date" => $get_date_range->end_date,
                        "ot_submit_date" => $row->ot_submit_date != "0000-00-00" ? $row->ot_submit_date : "",
                        "ot_time_in" => $row->ot_time_in,
                        "ot_time_out" => $row->ot_time_out,
                        "ot_description" => $row->ot_description,
                        "ot_reason" => $row->ot_reason,
                        "ot_negative_impact" => $row->ot_negative_impact,
                        // "ot_total_time" => $rows . " day(s)", //$row->ot_total_time,
                        "year" => date('Y', strtotime($row->ot_date)),
                        "month" => date('F', strtotime($row->ot_date)),
                        "approver1" => $row->approver1,
                        "approver2" => $row->approver2,
                        "approver3" => $row->approver3,
                        "user_status" => $row->user_status,
                        //"at_date" => $row->at_date,
                        "at_time_in" => $at_time_in,
                        "at_time_out" => $at_time_out,
                        "actual_start" => $actual_start, //(!empty($row->at_time_in) ? substr($row->at_time_in, 0, -3) : (!empty($row->ts_time_in) ? substr($row->ts_time_in, 0, -3) : "-")),
                        "actual_end" => $actual_end, //($row->ot_time_out > substr($row->at_time_out, 0, -3) ? (!empty($row->at_time_in) ? substr($row->at_time_out, 0, -3) : "-") : $row->ot_time_out)
                        "total_actual" => $total_time
                    );
                }
            }
        } else {
            $err = $overtimeData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $overtimeData['recordsTotal'],
            "recordsFiltered" => $overtimeData['recordsFiltered'],
            "data" => $result_overtime,
            "error" => $err
        );
        echo json_encode($json_data);
    }

}
