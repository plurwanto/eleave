<?php
namespace App\Http\Controllers\Eleave\TimeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;

class TimesheetApprovalController extends Controller {

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

        return view('Eleave.timesheet.ts_Approval', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getTimesheetApproval(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $columns = array(
            0 => 'ts_date',
            1 => 'user_name',
        );
        //$order = $columns[$request->input('order.0.column')];

        $urlTimesheet = 'eleave/timesheetApproval/index';
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
            "search_type" => $request['columns'][2]['search']['value'],
            "search_name" => $request['columns'][3]['search']['value'],
            "search_date" => $request['columns'][4]['search']['value'],
            "search_end_date" => $request['columns'][5]['search']['value'],
            "search_day" => $request['columns'][6]['search']['value'],
            "search_location" => $request['columns'][7]['search']['value'],
            "search_activity" => $request['columns'][8]['search']['value'],
            "search_active" => $request['columns'][15]['search']['value'],
            "search_status" => $request['columns'][16]['search']['value'],
        ];
        //var_dump($param);exit;
        $timesheet = ElaHelper::myCurl($urlTimesheet, $param);

        $timesheetData = json_decode($timesheet, true);

        $err = "";
        $result_timesheet = array();
        $no = $request->post('start');
        if ($timesheetData['response_code'] == 200) {

            $user_timesheet = $timesheetData['data'];
            $object = json_decode(json_encode($user_timesheet), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ts_id . "','" . $row->ts_type . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";
                $no++;
                $show = 0;
                if ($row->ts_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->ts_rejected_reason) ? "<i class='fa fa-question' title='" . $row->ts_rejected_reason . "'></i>" : "") . "";
                    $show = 1;
                } else {
                    if ($row->ts_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                        $show = 1;
                    } else {
                        if ($row->ts_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
                            $show = 1;
                        } else {
                            $id_approver = 0;
                            if ($row->ts_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ts_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            }
                            if ($id_approver == session('id')) {
                                $status = "<span class='label label-warning'>Waiting for your approval</span>";
                                $show = 1;
                                //if($row->ts_approver_id != 0){
                                //approve
                                $next = 0;
                                if ($row->ts_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                } elseif ($row->ts_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                } else {
                                    $next = 0;
                                }
                                //approve
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ts_id . "-" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
                                //reject
                                $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->ts_id . "')><i class='fa fa-close'></i></a>";
                                //$aksi .= "<a class='btn red btn-xs reject' id='" . $row->ts_id . "'><i class='fa fa-close'></i></a>";
                                //revisi
                                $aksi .= "<a class='btn yellow-crusta btn-xs' onclick='revisi_this(" . $row->ts_id . ")'><i class='fa fa-edit'></i></a>";
                            } else {
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                $show = 1;
                            }
                        }
                    }
                }

                $activity = $row->ts_activity;
                $time = "";

                if ($row->ts_type == "Absent") {
                    //$activity .= "<br><br>Supporting Document : <a href='".base_url().$row->ts_file."' target='_blank'>Click To View</a>";
                    //$activity .= "<br><br><a href='" . base_url() . $row->ts_file . "' target='_blank' style='color:red;'>Click To View Support Document</a>";
                } else {
                    //$activity .= "<a href='#' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ts_id . "','" . $row->ts_type . "')>" . substr($get_data_detail[0]['ts_activity'], 0, 55) . "...</a>";
                    //$time = "In  : " . $row->ts_time_in . "<br>Out : " . $row->ts_time_out . "<br>Total : " . $row->ts_total_time;
                }

                if ($show) {
                    $result_timesheet[] = array(
                        "no" => $no,
                        "ts_id" => $row->ts_id,
                        "user_name" => $row->user_name,
                        "ts_type" => $row->ts_type,
                        "ts_date" => date('D, d M Y', strtotime($row->start_date)),
                        "ts_end_date" => date('D, d M Y', strtotime($row->end_date)),
                        "status" => $status,
                        "action" => $aksi,
                        //"ts_end_date" => $get_date_range->end_date,
                        "ts_submit_date" => $row->ts_submit_date != "0000-00-00" ? $row->ts_submit_date : "",
                        "ts_time_in" => $row->ts_time_in,
                        "ts_time_out" => $row->ts_time_out,
                        "ts_location" => $row->ts_location,
                        "ts_activity" => $row->ts_activity,
                        "ts_total_time" => $row->total_day . " day(s)",
                        "year" => date('Y', strtotime($row->ts_date)),
                        "month" => date('F', strtotime($row->ts_date)),
                        "approver1" => User::split_name($row->approver1) . "<br>" . (!empty($row->date_approve1) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve1)) : ''),
                        "approver2" => User::split_name($row->approver2) . "<br>" . (!empty($row->date_approve2) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve2)) : ''),
                        "approver3" => User::split_name($row->approver3) . "<br>" . (!empty($row->date_approve3) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve3)) : ''),
                        "user_status" => $row->user_status,
                    );
                }
            }
        } else {
            $err = $timesheetData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $timesheetData['recordsTotal'],
            "recordsFiltered" => $timesheetData['recordsFiltered'],
            "data" => $result_timesheet,
        );
        echo json_encode($json_data);
    }

    public function getTimesheetApprovalNotif(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $columns = array(
            0 => 'ts_date',
            1 => 'user_name',
        );
        //$order = $columns[$request->input('order.0.column')];

        $urlTimesheet = 'eleave/timesheetApproval/index';
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
            "search_type" => $request['columns'][2]['search']['value'],
            "search_name" => $request['columns'][3]['search']['value'],
            "search_date" => $request['columns'][4]['search']['value'],
            "search_end_date" => $request['columns'][5]['search']['value'],
            "search_day" => $request['columns'][6]['search']['value'],
            "search_location" => $request['columns'][7]['search']['value'],
            "search_activity" => $request['columns'][8]['search']['value'],
            "search_active" => $request['columns'][15]['search']['value'],
            "search_status" => $request['columns'][16]['search']['value'],
        ];
        $timesheet = ElaHelper::myCurl($urlTimesheet, $param);

        $timesheetData = json_decode($timesheet, true);

        $err = "";
        $result_timesheet = array();
        $no = $request->post('start');
        if ($timesheetData['response_code'] == 200) {

            $user_timesheet = $timesheetData['data'];
            $object = json_decode(json_encode($user_timesheet), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ts_id . "','" . $row->ts_type . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";

                $show = 0;
                if ($row->ts_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->ts_rejected_reason) ? "<i class='fa fa-question' title='" . $row->ts_rejected_reason . "'></i>" : "") . "";
                    $show = 1;
                } else {
                    if ($row->ts_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                        $show = 1;
                    } else {
                        if ($row->ts_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
                            $show = 1;
                        } else {
                            $id_approver = 0;
                            if ($row->ts_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ts_approver_id == 2) {
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
                                //if($row->ts_approver_id != 0){
                                //approve
                                $next = 0;
                                if ($row->ts_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                } elseif ($row->ts_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                } else {
                                    $next = 0;
                                }
                                //approve
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ts_id . "-" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
                                //reject
                                $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->ts_id . "')><i class='fa fa-close'></i></a>";
                                //$aksi .= "<a class='btn red btn-xs reject' id='" . $row->ts_id . "'><i class='fa fa-close'></i></a>";
                                //revisi
                                $aksi .= "<a class='btn yellow-crusta btn-xs' onclick='revisi_this(" . $row->ts_id . ")'><i class='fa fa-edit'></i></a>";
                            } else {
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                $show = 1;
                            }
                        }
                    }
                }

                $activity = $row->ts_activity;
                $time = "";

                if ($row->ts_type == "Absent") {
                    //$activity .= "<br><br>Supporting Document : <a href='".base_url().$row->ts_file."' target='_blank'>Click To View</a>";
                    //$activity .= "<br><br><a href='" . base_url() . $row->ts_file . "' target='_blank' style='color:red;'>Click To View Support Document</a>";
                } else {
                    //$activity .= "<a href='#' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ts_id . "','" . $row->ts_type . "')>" . substr($get_data_detail[0]['ts_activity'], 0, 55) . "...</a>";
                    //$time = "In  : " . $row->ts_time_in . "<br>Out : " . $row->ts_time_out . "<br>Total : " . $row->ts_total_time;
                }

                if ($show == "notif") {
                    $no++;
                    $result_timesheet[] = array(
                        "no" => $no,
                        "ts_id" => $row->ts_id,
                        "user_name" => $row->user_name,
                        "ts_type" => $row->ts_type,
                        "ts_date" => date('D, d M Y', strtotime($row->start_date)),
                        "ts_end_date" => date('D, d M Y', strtotime($row->end_date)),
                        "status" => $status,
                        "action" => $aksi,
                        //"ts_end_date" => $get_date_range->end_date,
                        "ts_submit_date" => $row->ts_submit_date != "0000-00-00" ? $row->ts_submit_date : "",
                        "ts_time_in" => $row->ts_time_in,
                        "ts_time_out" => $row->ts_time_out,
                        "ts_location" => $row->ts_location,
                        "ts_activity" => $row->ts_activity,
                        "ts_total_time" => $row->total_day . " day(s)",
                        "year" => date('Y', strtotime($row->ts_date)),
                        "month" => date('F', strtotime($row->ts_date)),
                        "approver1" => User::split_name($row->approver1) . "<br>" . (!empty($row->date_approve1) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve1)) : ''),
                        "approver2" => User::split_name($row->approver2) . "<br>" . (!empty($row->date_approve2) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve2)) : ''),
                        "approver3" => User::split_name($row->approver3) . "<br>" . (!empty($row->date_approve3) ? "<i class='fa fa-calendar-check-o' style='color:green'></i> " . date('d-M-y H:i', strtotime($row->date_approve3)) : ''),
                        "user_status" => $row->user_status,
                    );
                }
            }
        } else {
            $err = $timesheetData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($result_timesheet), //$timesheetData['recordsTotal'],
            "recordsFiltered" => count($result_timesheet), //$timesheetData['recordsFiltered'],
            "data" => $result_timesheet,
        );
        echo json_encode($json_data);
    }

    public function get_data_detail(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlTimeshet = 'eleave/timesheet/getTimesheetDetail';
        $param = [
            'token' => session('token'),
            'id' => $request->id,
            'ts_id' => $request->ts_id,
        ];
        $timesheet_id = ElaHelper::myCurl($urlTimeshet, $param);
        $timesheetList = json_decode($timesheet_id, true);

        $row = array();
        if ($timesheetList['response_code'] == 200) {
            $data = array();
            foreach ($timesheetList['data'] as $value) {
                $data[] = array(
                    'ts_date' => date("j F Y", strtotime($value['ts_date'])),
                    'ts_time_in' => substr($value['ts_time_in'], 0, -3),
                    'ts_time_out' => substr($value['ts_time_out'], 0, -3),
                    'ts_total_time' => $value['ts_total_time'],
                    'ts_location' => ($value['ts_location'] != "" ? $value['ts_location'] : ""),
                    'ts_activity' => $value['ts_activity']
                );
            }
            $output = array(
                "data" => $data
            );
        } else {
            $output = $timesheetList['message'];
        }
        echo json_encode($output);
    }

    public function revise(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlTimesheet = 'eleave/timesheetApproval/revise';
        $param = [
            'token' => session('token'),
            //'user_id' => $request->user_id,
            'ts_id' => $request->ts_id,
            'ts_approver_id' => 1,
            'ts_need_revision' => 1,
            'ts_revision_reason' => $request->ts_reason,
            'ts_revision_from' => session('id'),
            'ts_revision_nama' => session('nama'),
        ];
        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetList = json_decode($timesheet_id, true);
        $ts = "";
        if ($timesheetList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $timesheetList['message']);
        } else {
            $ts = array('status' => false);
        }
        echo json_encode($ts);
    }

    public function approve(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlTimesheet = 'eleave/timesheetApproval/approve';
        $param = [
            'token' => session('token'),
            'next' => $request->next,
            'ts_id' => $request->ts_id,
            'ts_approve_nama' => session('nama'),
        ];
        //dd($param);
        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetList = json_decode($timesheet_id, true);
        $ts = "";
        if ($timesheetList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $timesheetList['message']);
        } else {
            $ts = array('status' => false);
        }
        echo json_encode($ts);
    }

    public function reject(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlTimesheet = 'eleave/timesheetApproval/reject';
        $param = [
            'token' => session('token'),
            //'user_id' => $request->user_id,
            'ts_id' => $request->ts_id,
            'ts_rejected' => 1,
            'ts_rejected_by' => session('id'),
            'ts_rejected_nama' => session('nama'),
            'ts_rejected_reason' => $request->ts_reason,
        ];
        //dd($param);
        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetList = json_decode($timesheet_id, true);
        $ts = "";
        if ($timesheetList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $timesheetList['message']);
        } else {
            $ts = array('status' => false);
        }
        echo json_encode($ts);
    }

    public function add() {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        return view('Eleave.timesheet.new');
    }

    public function edit($id) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlTimesheet = 'eleave/timesheet/getTimesheetId';
        $param = [
            "token" => session('token'),
            "ts_id" => $id,
        ];
        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetList = json_decode($timesheet_id, true);
        $ot = "";
        if ($timesheetList['response_code'] == 200) {
            $ot = json_decode(json_encode($timesheetList['data']), FALSE);
        } else {
            $ot = $timesheetList['message'];
        }
        // dd($timesheetList['data']);
        return view('Eleave.timesheet.timesheetEdit', ['ot' => $ot]);
    }

    public function getHoliday(Request $request) {
        $date = array_values($request->post('rows'));
        //echo "<pre>";print_r($request->all());echo "</pre>";
        $urlHoliday = 'eleave/timesheet/getholiday';
        $param = [
            "token" => session('token'),
            "date" => $date,
            "branch" => session('branch_id'),
        ];
        $timesheet_hol = ElaHelper::myCurl($urlHoliday, $param);
        $timesheetHoliday = json_decode($timesheet_hol, true);

        $row = array();
        if ($timesheetHoliday['response_code'] == 200) {
            foreach ($timesheetHoliday['data'] as $value) {
                $row[] = array(
                    'hol_date' => $value['hol_date']
                );
            }
        } else {
            $row = $timesheetHoliday['message'];
        }
        echo json_encode($row);
    }

    public function save(Request $request) {
        $urlTimesheet = 'eleave/timesheet/save';
        $param = [
            "token" => session('token'),
            "user_id" => session('id'),
            "ts_date" => $request->post('ts_date'),
            "ts_time_in" => $request->post('ts_time_in'),
            "ts_time_out" => $request->post('ts_time_out'),
            "ts_description" => $request->post('ts_description'),
            "ts_reason" => $request->post('ts_reason'),
            "ts_negative_impact" => $request->post('ts_impact'),
            "branch_id" => session('branch_id'),
            "ts_finger_print_id" => session('finger_print_id'),
            "ts_approver_id" => 1,
            "ts_need_revision" => 0,
            "ts_last_update" => date('Y-m-d H:i:s'),
            "ts_submit_date" => date('Y-m-d')
        ];

        $timesheet = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetSave = json_decode($timesheet, true);
        //echo json_encode($timesheetSave);
        //      dd($timesheetSave['response_code']);
        if ($timesheetSave['response_code'] == 200) {
            return redirect('eleave/timesheet/index')
                            ->with('success', $timesheetSave['message']);
        } else {
            return redirect('eleave/timesheet/add')
                            ->with('success', $timesheetSave['message']);
        }
    }

    public function update(Request $request, $id) {
        $urlTimesheet = 'eleave/timesheet/update';
        $param = [
            "token" => session('token'),
            "ts_id" => $id,
            "user_id" => session('id'),
            "ts_date" => $request->post('ts_date'),
            "ts_time_in" => $request->post('ts_time_in'),
            "ts_time_out" => $request->post('ts_time_out'),
            "ts_description" => $request->post('ts_description'),
            "ts_reason" => $request->post('ts_reason'),
            "ts_negative_impact" => $request->post('ts_impact'),
            "branch_id" => session('branch_id'),
            "ts_finger_print_id" => session('finger_print_id'),
            "ts_approver_id" => 1,
            "ts_need_revision" => 0,
            "ts_last_update" => date('Y-m-d H:i:s'),
        ];

        $timesheet = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetUpdate = json_decode($timesheet, true);
        //dd($param);
        //echo json_encode($timesheetSave);
        return redirect('eleave/timesheet/index')
                        ->with('success', $timesheetUpdate['message']);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlTimesheet = 'eleave/timesheet/delete';
        $param = [
            "token" => session('token'),
            "ts_id" => $id,
        ];
        // dd($param);
        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetList = json_decode($timesheet_id, true);
        $ot = "";
        if ($timesheetList['response_code'] == 200) {
            $ot = array('status' => true);
        } else {
            $ot = $timesheetList['message'];
        }

        echo json_encode($ot);
    }

    function isWeekend($date) {
        // $weekDay = date('w', strtotime($date));
        return (date('N', strtotime($date)) >= 6);
    }

    public function split_name($name) {
        $parts = explode(' ', $name);
        $num = count($parts);
        $firstname = $parts[0]; //implode(" ", $parts);
        $middlename = ($num > 1 ? $parts[1] : '');
        $lastname = array_pop($parts);
        if (strlen($firstname) == 1) {
            $name_show = $firstname . ' ' . $middlename . ' ' . $lastname;
        } else {
            $name_show = $firstname . ' ' . $lastname;
        }
        return ($num == 1) ? $firstname : $name_show;
    }

}
