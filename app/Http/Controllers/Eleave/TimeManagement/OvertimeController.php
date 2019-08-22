<?php
namespace App\Http\Controllers\Eleave\TimeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;

class OvertimeController extends Controller {

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

        return view('Eleave.overtime.index', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getOvertime(Request $request) {
        $columns = array(
            0 => 'ot_date',
            1 => 'ot_description',
        );

        $urlOvertime = 'eleave/overtime/index';
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
            "search_status" => $request['columns'][7]['search']['value'],
            "search_date" => $request['columns'][1]['search']['value'],
            "search_from" => $request['columns'][2]['search']['value'],
            "search_to" => $request['columns'][3]['search']['value'],
            "search_desc" => $request['columns'][4]['search']['value'],
            "search_reason" => $request['columns'][5]['search']['value'],
            "search_impact" => $request['columns'][6]['search']['value'],
            "search_status" => $request['columns'][10]['search']['value'],
        ];

        $overtime = ElaHelper::myCurl($urlOvertime, $param);

        $overtimeData = json_decode($overtime, true);

        $err = "";
        $result_overtime = array();
        $no = $request->post('start');
        if ($overtimeData['response_code'] == 200) {

            $user_overtime = $overtimeData['data'];
            $object = json_decode(json_encode($user_overtime), FALSE);
            //dd($object);   

            foreach ($object as $row) {
                $aksi = "";
                $no++;
                if ($row->ot_approver_id != 0) {
                    if ($row->ot_need_revision == 1) {
                        $aksi .= '<a href="' . url('eleave/overtime/' . $row->ot_id . '/edit') . '" class="btn btn-xs yellow" title="Revise"><i class="fa fa-pencil"></i>';
                    }
                    //$aksi .= "<a class='btn btn-sm red' onclick='delete_list(" . $row->ot_id . ");' href='#' title='Delete' id='" . $row->ot_id . "'> <i class='fa fa-trash'></i> </a>";
                    $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->ot_id . "'> <i class='fa fa-trash'></i> </a>";
                }

                $status = "";
                if ($row->ot_rejected == 1) {
                    $status = "<span class='label label-danger label-sm'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->ot_rejected_reason) ? "<i class='fa fa-question' title='" . $row->ot_rejected_reason . "'></i>" : "") . "";
                } else {
                    if ($row->ot_approver_id == 0) {
                        $status = "<span class='label label-primary label-sm'>Approved</span>";
                    } else {
                        if ($row->ot_need_revision == 1) {
                            $status = "<span class='label label-success label-sm'>Waiting for your revision</span>";
                        } else {
                            if ($row->ot_approver_id == 1) {
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ot_approver_id == 2) {
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $curr_approver = User::split_name($row->approver3);
                            }
                            $status = "<span class='label label-warning label-sm'>Waiting for " . $curr_approver . "'s approval</span>";
                        }
                    }
                }

                $result_overtime[] = array(
                    "no" => $no,
                    "ot_date" =>date('D, d M y', strtotime($row->ot_date)),
                    "ot_submit_date" => $row->ot_submit_date != "0000-00-00" ? date('d M y', strtotime($row->ot_submit_date)) : "",
                    "ot_time_in" => $row->ot_time_in,
                    "ot_time_out" => $row->ot_time_out,
                    "ot_description" => $row->ot_description,
                    "ot_reason" => $row->ot_reason,
                    "ot_negative_impact" => $row->ot_negative_impact,
                    // "ot_total_time" => $rows . " day(s)", //$row->ot_total_time,
                    "year" => date('Y', strtotime($row->ot_date)),
                    "month" => date('F', strtotime($row->ot_date)),
                    //"approver1" => $row->approver1,
                    //"approver2" => $row->approver2,
                    //"approver3" => $row->approver3,
                    "status" => $status,
                    "action" => $aksi
                );
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

    public function getOvertimeNotif(Request $request) {
        $columns = array(
            0 => 'ot_date',
            1 => 'ot_description',
        );

        $urlOvertime = 'eleave/overtime/index';
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
            "search_status" => $request['columns'][10]['search']['value'],
            "search_date" => $request['columns'][1]['search']['value'],
            "search_from" => $request['columns'][2]['search']['value'],
            "search_to" => $request['columns'][3]['search']['value'],
            "search_desc" => $request['columns'][4]['search']['value'],
            "search_reason" => $request['columns'][5]['search']['value'],
            "search_impact" => $request['columns'][6]['search']['value'],
        ];

        $overtime = ElaHelper::myCurl($urlOvertime, $param);

        $overtimeData = json_decode($overtime, true);

        $err = "";
        $result_overtime = array();
        $no = $request->post('start');
        if ($overtimeData['response_code'] == 200) {

            $user_overtime = $overtimeData['data'];
            $object = json_decode(json_encode($user_overtime), FALSE);
            //dd($object);   

            foreach ($object as $row) {
                $aksi = "";

                if ($row->ot_approver_id != 0) {
                    if ($row->ot_need_revision == 1) {
                        $aksi .= '<a href="' . url('eleave/overtime/' . $row->ot_id . '/edit') . '" class="btn btn-xs yellow" title="Revise"><i class="fa fa-pencil"></i>';
                    }
                    //$aksi .= "<a class='btn btn-sm red' onclick='delete_list(" . $row->ot_id . ");' href='#' title='Delete' id='" . $row->ot_id . "'> <i class='fa fa-trash'></i> </a>";
                    $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->ot_id . "'> <i class='fa fa-trash'></i> </a>";
                }

                $status = "";
                if ($row->ot_rejected == 1) {
                    $status = "<span class='label label-danger label-sm'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>&nbsp;" . (!empty($row->ot_rejected_reason) ? "<i class='fa fa-question' title='" . $row->ot_rejected_reason . "'></i>" : "") . "";
                } else {
                    if ($row->ot_approver_id == 0) {
                        $status = "<span class='label label-primary label-sm'>Approved</span>";
                    } else {
                        if ($row->ot_need_revision == 1) {
                            $status = "<span class='label label-success label-sm'>Waiting for your revision</span>";
                        } else {
                            if ($row->ot_approver_id == 1) {
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ot_approver_id == 2) {
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $curr_approver = User::split_name($row->approver3);
                            }
                            $status = "<span class='label label-warning label-sm'>Waiting for " . $curr_approver . "'s approval</span>";
                        }
                    }
                }

                $show = 0;
                if ($row->ot_need_revision == 1) {
                    $show = 1;
                }

                if ($show) {
                    $no++;
                    $result_overtime[] = array(
                        "no" => $no,
                        "ot_date" => date('d M y', strtotime($row->ot_date)),
                        "ot_submit_date" => $row->ot_submit_date != "0000-00-00" ? date('d M y', strtotime($row->ot_submit_date)) : "",
                        "ot_time_in" => $row->ot_time_in,
                        "ot_time_out" => $row->ot_time_out,
                        "ot_description" => $row->ot_description,
                        "ot_reason" => $row->ot_reason,
                        "ot_negative_impact" => $row->ot_negative_impact,
                        // "ot_total_time" => $rows . " day(s)", //$row->ot_total_time,
                        "year" => date('Y', strtotime($row->ot_date)),
                        "month" => date('F', strtotime($row->ot_date)),
                        //"approver1" => $row->approver1,
                        //"approver2" => $row->approver2,
                        //"approver3" => $row->approver3,
                        "status" => $status,
                        "action" => $aksi
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
        );
        echo json_encode($json_data);
    }

    public function add() {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $param = [
            "token" => session('token'),
        ];
        $urlSetting = 'eleave/setting/index';
        $config = ElaHelper::myCurl($urlSetting, $param);
        $configAccess = json_decode($config, true);

        if ($configAccess['response_code'] == 200) {
            $openAccess = $configAccess['data'];
            $allow_access = $openAccess['flag_overtime'];
        }else{
            $allow_access = "";
        }

        return view('Eleave.overtime.new',['allow_access' => $allow_access]);
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
        if ($overtimeSave['response_code'] == 200) {
            return redirect('eleave/overtime/index')
                            ->with(array('message' => $overtimeSave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/overtime/add')
                            ->with(array('message' => $overtimeSave['message'], 'alert-type' => 'error'));
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
        if ($overtimeUpdate['response_code'] == 200) {
            return redirect('eleave/overtime/index')
                            ->with(array('message' => $overtimeUpdate['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/overtime/add')
                            ->with(array('message' => $overtimeUpdate['message'], 'alert-type' => 'error'));
        }
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
            $ot = array('status' => true, 'message' => $overtimeList['message']);
        } else {
            $ot = array('status' => false);
        }
        echo json_encode($ot);
    }

    public function checkExisting(Request $request) {
        $userId = $request->post('employee_id');
        $ot_date = $request->post('ot_date');

        $urlOvertime = 'eleave/overtime/check_existing';
        $param = [
            "token" => session('token'),
            "user_id" => $userId,
            "ot_date" => $ot_date,
        ];

        $overtime_id = ElaHelper::myCurl($urlOvertime, $param);
        $overtime_List = json_decode($overtime_id, true);
//        dd($leaveList);
        if ($overtime_List['response'] == true) {
            $response = true;
        } else {
            $response = false;
        }
        echo json_encode($response);
    }

}
