<?php
namespace App\Http\Controllers\Eleave\TimeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;
use DateTime;
use URL;

class TimesheetController extends Controller {

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

        return view('Eleave.timesheet.ts_index', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getTimesheet(Request $request) {
        $columns = array(
            0 => 'ts_date',
            1 => 'ts_description',
        );

        $urlTimesheet = 'eleave/timesheet/index';
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
            "search_type" => $request['columns'][1]['search']['value'],
            "search_date" => $request['columns'][2]['search']['value'],
            "search_end_date" => $request['columns'][3]['search']['value'],
            "search_loc" => $request['columns'][5]['search']['value'],
            "search_activity" => $request['columns'][6]['search']['value'],
            "search_status" => $request['columns'][10]['search']['value'],
        ];

        $timesheet = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetData = json_decode($timesheet, true);

        $err = "";
        $result_timesheet = array();
        $no = $request->post('start');
        if ($timesheetData['response_code'] == 200) {
            $user_timesheet = $timesheetData['data'];
            $object = json_decode(json_encode($user_timesheet), FALSE);
            foreach ($object as $row) {
                $no++;
                $aksi = "";

                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ts_id . "','" . $row->ts_type . "')> &nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                if ($row->ts_approver_id != 0) {
//update
                    if ($row->ts_need_revision == 1) {
                        $aksi .= '<a href="' . url('eleave/timesheet/' . $row->ts_id . '/edit') . '" class="btn yellow btn-xs" title="Revise"><i class="fa fa-pencil"></i>';
                    }
//delete
                    // $aksi .= "<a class='btn red btn-icon-only tombol-delete' data-toggle='modal' href='#small' title='Delete' id='" . $row->ts_id . "'> <i class='fa fa-trash'></i> </a>";
                }
                if ($row->ts_draft == 1) {
                    $aksi .= "<a class='btn red btn-xs reject' id='" . $row->ts_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                }

                $status = "";
                if ($row->ts_draft == 0) {
                    if ($row->ts_rejected == 1) {
                        $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->ts_rejected_reason) ? "<i class='fa fa-question' title='" . $row->ts_rejected_reason . "'></i>" : "") . "";
                    } else {

                        if ($row->ts_approver_id == 0) {
                            $status = "<span class='label label-sm label-primary'>Approved</span>";
                        } else {
                            if ($row->ts_need_revision == 1) {
                                $status = "<span class='label label-sm label-success'>Waiting for your revision</span>";
                            } else {
                                if ($row->ts_approver_id == 1) {
                                    $curr_approver = User::split_name($row->approver1);
                                } elseif ($row->ts_approver_id == 2) {
                                    $curr_approver = User::split_name($row->approver2);
                                } else {
                                    $curr_approver = User::split_name($row->approver3);
                                }
                                $status = "<span class='label label-sm label-warning'>Waiting for " . $curr_approver . "'s approval</span>";
                            }
                        }
                    }
                } else {
                    // $status = "<a href='" . route('timesheet.draft', ['id' => $row->ts_id]) . "' class='' title='Edit Draft'>"
                    $status = "<a href='" . url('eleave/timesheet/' . $row->ts_id . '/draft') . "' class='' title='Edit Draft'>"
                            . "<span class='label label-sm label-info'>Draft</span></a>&nbsp;&nbsp;";
                }
                $activity = "";
                if ($row->ts_type == "Absent") {
                    $activity .= $row->ts_activity . "<br>Supporting Document : <a href='" . url(env('PUBLIC_PATH').$row->ts_file) . "' target='_blank'>Click To View</a>";
                } else {
                    $activity .= $row->ts_activity;
                }

                $result_timesheet[] = array(
                    "no" => $no,
                    "ts_type" => $row->ts_type,
                    "ts_date" => date('D, d M Y', strtotime($row->start_date)),
                    "ts_end_date" => date('D, d M Y', strtotime($row->end_date)),
                    "ts_activity" => $activity,
                    "ts_location" => $row->ts_location,
                    "ts_total_time" => $row->total_day . " day(s)", //$row->ts_total_time,
                    "ts_submit_date" => $row->ts_submit_date != "0000-00-00" ? date('d M y', strtotime($row->ts_submit_date)) : "",
                    "year" => date('Y', strtotime($row->ts_date)),
                    "month" => date('F', strtotime($row->ts_date)),
                    "status" => $status,
                    "action" => $aksi
                );
            }
        } else {
            $err = $timesheetData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $timesheetData['recordsTotal'],
            "recordsFiltered" => $timesheetData['recordsFiltered'],
            "data" => $result_timesheet,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function getTimesheetNotif(Request $request) {
        $columns = array(
            0 => 'ts_date',
            1 => 'ts_description',
        );

        $urlTimesheet = 'eleave/timesheet/index';
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
            "search_type" => $request['columns'][1]['search']['value'],
            "search_date" => $request['columns'][2]['search']['value'],
            "search_end_date" => $request['columns'][3]['search']['value'],
            "search_loc" => $request['columns'][5]['search']['value'],
            "search_activity" => $request['columns'][6]['search']['value'],
            "search_status" => $request['columns'][10]['search']['value'],
        ];

        $timesheet = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetData = json_decode($timesheet, true);

        $err = "";
        $result_timesheet = array();
        $no = $request->post('start');
        if ($timesheetData['response_code'] == 200) {
            $user_timesheet = $timesheetData['data'];
            $object = json_decode(json_encode($user_timesheet), FALSE);
            foreach ($object as $row) {

                $aksi = "";

                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ts_id . "','" . $row->ts_type . "')> &nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                if ($row->ts_approver_id != 0) {
//update
                    if ($row->ts_need_revision == 1) {
                        $aksi .= '<a href="' . url('eleave/timesheet/' . $row->ts_id . '/edit') . '" class="btn yellow btn-xs" title="Revise"><i class="fa fa-pencil"></i>';
                    }
//delete
                    // $aksi .= "<a class='btn red btn-icon-only tombol-delete' data-toggle='modal' href='#small' title='Delete' id='" . $row->ts_id . "'> <i class='fa fa-trash'></i> </a>";
                }
                if ($row->ts_draft == 1) {
                    $aksi .= "<a class='btn red btn-xs reject' id='" . $row->ts_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                }

                $status = "";
                if ($row->ts_draft == 0) {
                    if ($row->ts_rejected == 1) {
                        $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->ts_rejected_reason) ? "<i class='fa fa-question' title='" . $row->ts_rejected_reason . "'></i>" : "") . "";
                    } else {

                        if ($row->ts_approver_id == 0) {
                            $status = "<span class='label label-sm label-primary'>Approved</span>";
                        } else {
                            if ($row->ts_need_revision == 1) {
                                $status = "<span class='label label-sm label-success'>Waiting for your revision</span>";
                            } else {
                                if ($row->ts_approver_id == 1) {
                                    $curr_approver = User::split_name($row->approver1);
                                } elseif ($row->ts_approver_id == 2) {
                                    $curr_approver = User::split_name($row->approver2);
                                } else {
                                    $curr_approver = User::split_name($row->approver3);
                                }
                                $status = "<span class='label label-sm label-warning'>Waiting for " . $curr_approver . "'s approval</span>";
                            }
                        }
                    }
                } else {
                    // $status = "<a href='" . route('timesheet.draft', ['id' => $row->ts_id]) . "' class='' title='Edit Draft'>"
                    $status = "<a href='" . url('eleave/timesheet/' . $row->ts_id . '/draft') . "' class='' title='Edit Draft'>"
                            . "<span class='label label-sm label-info'>Draft</span></a>&nbsp;&nbsp;";
                }
                $activity = "";
                if ($row->ts_type == "Absent") {
                    $activity .= $row->ts_activity . "<br>Supporting Document : <a href='" . URL::to('/' . $row->ts_file) . "' target='_blank'>Click To View</a>";
                } else {
                    $activity .= $row->ts_activity;
                }

                $show = 0;
                if ($row->ts_need_revision == 1) {
                    $show = 1;
                }
                
                if ($show) {
                    $no++;
                    $result_timesheet[] = array(
                        "no" => $no,
                        "ts_type" => $row->ts_type,
                        "ts_date" => date('D, d M Y', strtotime($row->start_date)),
                        "ts_end_date" => date('D, d M Y', strtotime($row->end_date)),
                        "ts_activity" => $activity,
                        "ts_location" => $row->ts_location,
                        "ts_total_time" => $row->total_day . " day(s)", //$row->ts_total_time,
                        "ts_submit_date" => $row->ts_submit_date != "0000-00-00" ? date('d M y', strtotime($row->ts_submit_date)) : "",
                        "year" => date('Y', strtotime($row->ts_date)),
                        "month" => date('F', strtotime($row->ts_date)),
                        "status" => $status,
                        "action" => $aksi
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
            "error" => $err
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

    public function add() {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        return view('Eleave.timesheet.ts_new');
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlTimesheet = 'eleave/timesheet/getTimesheetId';
        $param = [
            "token" => session('token'),
            "ts_id" => $id,
        ];
        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetList = json_decode($timesheet_id, true);
        // dd($timesheetList);
        $ts = "";
        if ($timesheetList['response_code'] == 200) {
            $ts = json_decode(json_encode($timesheetList['data']), FALSE);
        } else {
            $ts = $timesheetList['message'];
        }
        // dd($timesheetList['data']);
        return view('Eleave.timesheet.ts_edit', ['ts' => $ts]);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $ts_id = $request->post('ts_id');
        $ts_date = $request->post('ts_date');
        $ts_type = $request->post('ts_type');
        $ts_time_in = "";
        $ts_time_out = "";
        $ts_total_time = "";
        $ts_time_in = $request->post('ts_time_in'); // . ":00";
        $ts_time_out = $request->post('ts_time_out'); // . ":00";
        $activity = $request->post('ts_activity');
        $location = $request->post('ts_location');
        $arr_date = $ts_date;
        if ($request->post('input_type') == "btn_draft") {
            $ts_draft = 1;
            $ts_need_rev = 0;
            $ts_approver = 0;
        } else {
            $ts_draft = 0;
            $ts_need_rev = 1;
            $ts_approver = 1;
        }

        $ts_date_tmp = '2037-12-31';
        $ts_activity_tmp = "";
        $data_detail = array();
        for ($i = 0; $i < count($ts_date); $i++) {
            if ($ts_type == "Timesheet") {
                $to = new DateTime($ts_date[$i] . " " . $ts_time_in[$i]);
                $from = new DateTime($ts_date[$i] . " " . $ts_time_out[$i]);
                $stat = $to->diff($from); // DateInterval object
                $ts_total_time = $stat->format('%h hour %i minute');
                $ts_total_day = $stat->format('%d days');
            }
            $data_detail[] = array(
                'ts_date' => $ts_date[$i],
                'ts_time_in' => ($ts_type == "Timesheet" ? $ts_time_in[$i] . ":00" : ""),
                'ts_time_out' => ($ts_type == "Timesheet" ? $ts_time_out[$i] . ":00" : ""),
                'ts_total_time' => $ts_total_time,
                'ts_activity' => $activity[$i],
                'ts_location' => ($ts_type == "Timesheet" ? $location[$i] : "")
            );
            if (strtotime($ts_date[$i]) <= strtotime($ts_date_tmp)) {
                $ts_date_tmp = $ts_date[$i];
                $ts_activity_tmp = $activity[$i];
            }
        }

        $urlTimesheet = 'eleave/timesheet/save';
        $param = [
            "token" => session('token'),
            "ts_id" => $ts_id,
            "user_id" => session('id'),
            "ts_type" => $ts_type,
            "ts_date" => $ts_date_tmp,
            "arr_date" => $arr_date,
            "ts_activity" => $ts_activity_tmp,
            "branch_id" => session('branch_id'),
            "ts_finger_print_id" => session('finger_print_id'),
            "ts_approver_id" => $ts_approver,
            "ts_need_revision" => $ts_need_rev,
            "ts_draft" => $ts_draft,
            "detail" => $data_detail,
        ];
        // dd($param);
        $timesheet = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetSave = json_decode($timesheet, true);
        // dd($timesheetSave['response_code']);
        if ($timesheetSave['response_code'] == 200) {
            if ($request->hasFile('ts_file')) {
                $ts_id = $timesheetSave['ts_id'];
                $fileName = $request->file('ts_file')->getClientOriginalName();
                $destinationPath = base_path('public/upload/timesheet/' . $ts_id . '/');
                $upload_dir = "upload/timesheet/" . $ts_id . "/";
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $request->file('ts_file')->move($destinationPath, $fileName);
                $file = $upload_dir . $fileName;

                $urlUpload = 'eleave/timesheet/do_upload';
                $param = [
                    "token" => session('token'),
                    "ts_id" => $ts_id,
                    "user_id" => session('id'),
                    "ts_file" => $file
                ];
                $timesheet = ElaHelper::myCurl($urlUpload, $param);
                $timesheetUpdate = json_decode($timesheet, true);
            }
            return redirect('eleave/timesheet/index')
                            ->with(array('message' => $timesheetSave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/timesheet/add')
                            ->with(array('message' => $timesheetSave['message'], 'alert-type' => 'error'));
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

        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheetList = json_decode($timesheet_id, true);
        $ot = "";
        if ($timesheetList['response_code'] == 200) {
            $ot = array('status' => true, 'message' => $timesheetList['message']);
        } else {
            $ot = array('status' => false);
        }
        echo json_encode($ot);
    }

    public function checkExisting(Request $request) {
        $userId = $request->post('employee_id');
        $ts_date = $request->post('ts_date'); //explode(",", $request->post('ts_dates'));
        $ts_id = $request->post('ts_id');
        // dibuat satu aja, submit draft gak bisa dobel
//        dd($request->post('btnDraft') . $request->post('btnSave'));
//        if ($request->post('btnDraft') == "btn_draft") {
//            $ts_draft = 1;
//            $ts_need_rev = 0;
//        } 
//        if($request->post('btnSave') == "btn_save") {
//            $ts_draft = 0;
//            $ts_need_rev = 1;
//        }
        $urlTimesheet = 'eleave/timesheet/check_existing';
        $param = [
            "token" => session('token'),
            "user_id" => $userId,
            "arr_date" => $ts_date,
            "ts_id" => $ts_id
//            "ts_need_revision" => $ts_need_rev,
//            "ts_draft" => $ts_draft
        ];
        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param);
        $timesheet_List = json_decode($timesheet_id, true);
        //dd($timesheet_List);
        if ($timesheet_List['response'] == true) {
            $response = true;
            $date_exist = "";
        } else {
            $response = false;
            $date_exist = $timesheet_List['date_exist'];
        }
        echo json_encode(array('status' => $response, 'date_exist' => $date_exist));
    }

    private function _validate($post) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

//        $urlRoom = 'eleave/room/check_existing';
//        $param = [
//            "room_id" => $id,
//            "room_name" => $ro_name,
//            "branch_id" => $branch_id,
//        ];
//        $room = ElaHelper::myCurl($urlRoom, $param);
//        $roomData = json_decode($room, true);

        if ($post['ts_date'] == '') {
            $data['inputerror'][] = 'ts_date';
            $data['error_string'][] = 'ts_date is required';
            $data['status'] = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}
