<?php
namespace App\Http\Controllers\Eleave\Expenses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;
use DateTime;
use URL;

class CashAdvanceController extends Controller {

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

        if ($request->get('index') == 1) {
            return view('Eleave.expenses.ca_index', ['notif' => $link_notif, 'source_id' => $source_id]);
        } elseif ($request->get('index') == 2) {
            return view('Eleave.expenses.ca_real_index', ['notif' => $link_notif, 'source_id' => $source_id]);
        } else {
            return view('Eleave.expenses.ca_history_index', ['notif' => $link_notif, 'source_id' => $source_id]);
        }
    }

    public function getCashAdvance(Request $request) {
        $urlCashAdvance = 'eleave/cash_advance/index';
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
            "step" => ($request->post('step') == 1 ? 1 : 2),
            "search_number" => $request['columns'][1]['search']['value'],
            "search_date" => $request['columns'][2]['search']['value'],
            "search_subject" => $request['columns'][3]['search']['value'],
//            "search_loc" => $request['columns'][5]['search']['value'],
//            "search_activity" => $request['columns'][6]['search']['value'],
//            "search_status" => $request['columns'][10]['search']['value'],
        ];

        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceData = json_decode($cash_advance, true);
        //var_dump($cash_advance);exit();
        $err = "";
        $result_cash_advance = array();
        $no = $request->post('start');
        if ($cash_advanceData['response_code'] == 200) {
            $user_cash_advance = $cash_advanceData['data'];
            $object = json_decode(json_encode($user_cash_advance), FALSE);
            foreach ($object as $row) {
                $no++;
                $status = "";
                $aksi = "";

                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "')> &nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                if ($row->ca_step == 1) {
                    if ($row->ca_status == 1 && $row->ca_approver_id != 0) {
                        if ($row->ca_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting your revision</span>";
                            $aksi .= '<a href="' . url('eleave/cash_advance/' . $row->ca_id . '/edit') . '" class="btn yellow btn-xs" title="Revise"><i class="fa fa-pencil"></i>';
                        } else {
                            if ($row->ca_approver_id == 1) {
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ca_approver_id == 2) {
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $curr_approver = User::split_name($row->approver3);
                            }
                            $status = "<span class='label label-sm label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                            $aksi .= "<a class='btn red btn-xs reject' id='" . $row->ca_id . "|" . $row->user_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                        }
                    } elseif ($row->ca_status == 2) {
                        $status = "<span class='label label-sm label-success'>Processing Finance</span>";
                    } elseif ($row->ca_status == 10) {
                        if ($row->ca_rejected == 1) {
                            $status = "<span class='label label-sm label-danger'>Rejected by " . $row->rejected_by_name . "</span>";
                        } else {
                            $status = "<span class='label label-sm label-danger'>Deleted</span>";
                        }
                    }
                }

                $result_cash_advance[] = array(
                    "no" => $no,
                    "ca_id" => $row->ca_id,
                    "ca_date" => date('d M Y', strtotime($row->ca_date)),
                    "ca_subject" => $row->ca_subject,
                    "ca_total" => $row->ca_total,
                    "ca_total_real" => $row->ca_total_real,
                    // "ca_submit_date" => $row->ca_submit_date != "0000-00-00" ? date('d M y', strtotime($row->ca_submit_date)) : "",
                    "status" => $status,
                    "action" => $aksi
                );
            }
        } else {
            $err = $cash_advanceData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $cash_advanceData['recordsTotal'],
            "recordsFiltered" => $cash_advanceData['recordsFiltered'],
            "data" => $result_cash_advance,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function getCashAdvanceNotif(Request $request) {
        $urlCashAdvance = 'eleave/cash_advance/index';
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

        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceData = json_decode($cash_advance, true);

        $err = "";
        $result_cash_advance = array();
        $no = $request->post('start');
        if ($cash_advanceData['response_code'] == 200) {
            $user_cash_advance = $cash_advanceData['data'];
            $object = json_decode(json_encode($user_cash_advance), FALSE);
            foreach ($object as $row) {

                $aksi = "";

                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "','" . $row->ts_type . "')> &nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                if ($row->ca_approver_id != 0) {
//update
                    if ($row->ca_need_revision == 1) {
                        $aksi .= '<a href="' . url('eleave/cash_advance/' . $row->ca_id . '/edit') . '" class="btn yellow btn-xs" title="Revise"><i class="fa fa-pencil"></i>';
                    }
//delete
                    // $aksi .= "<a class='btn red btn-icon-only tombol-delete' data-toggle='modal' href='#small' title='Delete' id='" . $row->ca_id . "'> <i class='fa fa-trash'></i> </a>";
                }
                if ($row->ts_draft == 1) {
                    $aksi .= "<a class='btn red btn-xs reject' id='" . $row->ca_id . "'|'" . $row->user_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                }

                $status = "";
                if ($row->ts_draft == 0) {
                    if ($row->ca_rejected == 1) {
                        $status = "<span class='label label-sm label-danger'>Rejected by " . $row->rejected_by_name . "</span>";
                    } else {

                        if ($row->ca_approver_id == 0) {
                            $status = "<span class='label label-sm label-primary'>Approved</span>";
                        } else {
                            if ($row->ca_need_revision == 1) {
                                $status = "<span class='label label-sm label-success'>Waiting for your revision</span>";
                            } else {
                                if ($row->ca_approver_id == 1) {
                                    $curr_approver = User::split_name($row->approver1);
                                } elseif ($row->ca_approver_id == 2) {
                                    $curr_approver = User::split_name($row->approver2);
                                } else {
                                    $curr_approver = User::split_name($row->approver3);
                                }
                                $status = "<span class='label label-sm label-warning'>Waiting for " . $curr_approver . "'s approval</span>";
                            }
                        }
                    }
                } else {
                    // $status = "<a href='" . route('cash_advance.draft', ['id' => $row->ca_id]) . "' class='' title='Edit Draft'>"
                    $status = "<a href='" . url('eleave/cash_advance/' . $row->ca_id . '/draft') . "' class='' title='Edit Draft'>"
                            . "<span class='label label-sm label-info'>Draft</span></a>&nbsp;&nbsp;";
                }
                $activity = "";
                if ($row->ts_type == "Absent") {
                    $activity .= $row->ts_activity . "<br>Supporting Document : <a href='" . URL::to('/' . $row->ts_file) . "' target='_blank'>Click To View</a>";
                } else {
                    $activity .= $row->ts_activity;
                }

                $show = 0;
                if ($row->ca_need_revision == 1) {
                    $show = 1;
                }

                if ($show) {
                    $no++;
                    $result_cash_advance[] = array(
                        "no" => $no,
                        "ts_type" => $row->ts_type,
                        "ts_date" => date('d M Y', strtotime($row->start_date)),
                        "ts_end_date" => date('d M Y', strtotime($row->end_date)),
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
            $err = $cash_advanceData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $cash_advanceData['recordsTotal'],
            "recordsFiltered" => $cash_advanceData['recordsFiltered'],
            "data" => $result_cash_advance,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function get_data_detail(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advance/getCashAdvanceDetail';
        $param = [
            'token' => session('token'),
            'id' => $request->id,
            'ca_id' => $request->ca_id,
        ];
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);
        //dd($cash_advance_id);
        $row = array();
        if ($cash_advanceList['response_code'] == 200) {
            $data = array();
            foreach ($cash_advanceList['data'] as $value) {
                $data[] = array(
                    'ca_id' => $value['ca_id'],
                    'ca_subject' => $value['ca_subject'],
                    'ca_date' => $value['ca_date'],
                    'ca_total' => $value['ca_total'],
                    'ca_total_real' => $value['ca_total_real'],
                    'ca_username' => $value['ca_username'],
                    'ca_dept' => $value['ca_dept'],
                    'ca_branch' => $value['ca_branch'],
                    'ca_date_detail' => date("j F Y", strtotime($value['ca_date_detail'])),
                    'ca_project' => $value['ca_project'],
                    'ca_detail_project' => $value['ca_detail_project'],
                    'ca_amount' => $value['ca_amount'],
                    'ca_realization' => $value['ca_realization'],
                    'ca_file' => "<a href='" . url(env('PUBLIC_PATH').$value['ca_file']) . "' target='_blank'><i class='fa fa-file-image-o'></i></a>",//url(env('PUBLIC_PATH').$value['ca_file']),
                );
            }
            $output = array(
                "data" => $data
            );
        } else {
            $output = $cash_advanceList['message'];
        }
        echo json_encode($output);
    }

    public function add() {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        return view('Eleave.expenses.ca_new');
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlCashAdvance = 'eleave/cash_advance/getCashAdvanceId';
        $param = [
            "token" => session('token'),
            "ca_id" => $id,
            "userId" => session('id')
        ];
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);
//        echo "<pre>";
//        var_dump($cash_advanceList);
//        echo "</pre>";
//        exit;
        $ca = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ca = json_decode(json_encode($cash_advanceList['data']), FALSE);
        } else {
            $ca = $cash_advanceList['message'];
        }
        // dd($cash_advanceList['data']);
        return view('Eleave.expenses.ca_edit', ['ca' => $ca]);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $ca_id = $request->post('ca_id');
        $ca_date = $request->post('ca_date');
        $ca_subject = $request->post('subject_name');
        $ca_total = $request->post('ca_total');

        $ca_id_detail = $request->post('ca_id_detail');
        $ca_date_detail = $request->post('ca_date_detail');
        $ca_project = $request->post('ca_project');
        $ca_detail = $request->post('ca_detail');
        $ca_amount = $request->post('ca_amount');

        $data_detail = array();
        for ($i = 0; $i < count($ca_date_detail); $i++) {
            $data_detail[] = array(
                'ca_id_detail' => $ca_id_detail[$i],
                'ca_date_detail' => $ca_date_detail[$i],
                'ca_project' => $ca_project[$i],
                'ca_detail' => $ca_detail[$i],
                'ca_amount' => $ca_amount[$i],
            );
        }

        $urlCashAdvance = 'eleave/cash_advance/save';
        $param = [
            "token" => session('token'),
            "ca_id" => $ca_id,
            "user_id" => session('id'),
            "ca_date" => $ca_date,
            "ca_subject" => $ca_subject,
            "branch_id" => session('branch_id'),
            "ca_total" => $ca_total,
            "detail" => $data_detail,
        ];
        // dd($param);
        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceSave = json_decode($cash_advance, true);
//        echo '<pre>';
//        var_dump($cash_advance);
//        echo '</pre>';
//        exit();
        if ($cash_advanceSave['response_code'] == 200) {
            return redirect('eleave/cash_advance?index=1')
                            ->with(array('message' => $cash_advanceSave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/cash_advance/add')
                            ->with(array('message' => $cash_advanceSave['message'], 'alert-type' => 'error'));
        }
    }

    public function update(Request $request, $id) {
        $urlCashAdvance = 'eleave/cash_advance/update';
        $param = [
            "token" => session('token'),
            "ca_id" => $id,
            "user_id" => session('id'),
            "ts_date" => $request->post('ts_date'),
            "ts_time_in" => $request->post('ts_time_in'),
            "ts_time_out" => $request->post('ts_time_out'),
            "ts_description" => $request->post('ts_description'),
            "ts_reason" => $request->post('ts_reason'),
            "ts_negative_impact" => $request->post('ts_impact'),
            "branch_id" => session('branch_id'),
            "ts_finger_print_id" => session('finger_print_id'),
            "ca_approver_id" => 1,
            "ca_need_revision" => 0,
            "ts_last_update" => date('Y-m-d H:i:s'),
        ];

        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceUpdate = json_decode($cash_advance, true);
//dd($param);
//echo json_encode($cash_advanceSave);
        return redirect('eleave/cash_advance')
                        ->with('success', $cash_advanceUpdate['message']);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/logout');
        }
        $id = $request->id;
        $urlCashAdvance = 'eleave/cash_advance/delete';
        $param = [
            "token" => session('token'),
            "ca_id" => $id,
            "user_id" => $request->user_id,
        ];

        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);

        $ot = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ot = array('status' => true, 'message' => $cash_advanceList['message']);
        } else {
            $ot = array('status' => false, 'message' => $cash_advanceList['message']);
        }
        echo json_encode($ot);
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

    ////////////////////////////// realization step for employee ////////////////////////////////////////////////////////          

    public function getCashAdvanceReal(Request $request) {
        $urlCashAdvance = 'eleave/cash_advance/index';
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
            "step" => ($request->post('step') == 1 ? 1 : 2),
            "search_number" => $request['columns'][1]['search']['value'],
            "search_date" => $request['columns'][2]['search']['value'],
            "search_subject" => $request['columns'][3]['search']['value'],
        ];

        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceData = json_decode($cash_advance, true);

        $err = "";
        $result_cash_advance = array();
        $no = $request->post('start');
        if ($cash_advanceData['response_code'] == 200) {
            $user_cash_advance = $cash_advanceData['data'];
            $object = json_decode(json_encode($user_cash_advance), FALSE);
            foreach ($object as $row) {
                $no++;
                $show = 0;
                $status = "";
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "')> &nbsp;<i class='fa fa-info'></i>&nbsp;</a>";

                if ($row->ca_step == 2) {
                    if ($request->post('step') == 2) {
                        if ($row->ca_status == 3) {
                            $aksi .= '<a href="' . url('eleave/cash_advance/' . $row->ca_id . '/edit_real?index=2') . '" class="btn yellow btn-xs" title="Update"><i class="fa fa-pencil"></i>';
                            $status = "<span class='label label-sm label-primary'>Approved request</span>";
                            $show = 1;
                        } elseif ($row->ca_status == 4 && $row->ca_approver_id != 0) {
                            if ($row->ca_need_revision == 1) {
                                $status = "<span class='label label-warning'>Waiting your revision</span>";
                                $aksi .= '<a href="' . url('eleave/cash_advance/' . $row->ca_id . '/edit_real?index=2') . '" class="btn yellow btn-xs" title="Update"><i class="fa fa-pencil"></i>';
                            } else {
                                if ($row->ca_approver_id == 1) {
                                    $curr_approver = User::split_name($row->approver1);
                                } elseif ($row->ca_approver_id == 2) {
                                    $curr_approver = User::split_name($row->approver2);
                                } else {
                                    $curr_approver = User::split_name($row->approver3);
                                }
                                $status = "<span class='label label-sm label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                //  $aksi .= "<a class='btn red btn-xs reject' id='" . $row->ca_id . "|" . $row->user_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                            }
                            $show = 1;
                        } elseif ($row->ca_status == 5) {
                            $status = "<span class='label label-success'>Processing Finance</span>";
                            $show = 1;
                        }
                    } elseif ($row->ca_status == 6 && $request->post('step') == "done") {
                        $show = 1;
                        $status = "<span class='label label-primary'>Finish</span>";
                    }
                }


//                if ($row->ca_step == 2 && $row->ca_status == 3 || $row->ca_need_revision == 1) {
//                    $aksi .= '<a href="' . url('eleave/cash_advance/' . $row->ca_id . '/edit_real?index=2') . '" class="btn yellow btn-xs" title="Update"><i class="fa fa-pencil"></i>';
//                }
//
//                $status = "";
//                if ($row->ca_rejected == 1) {
//                    $status = "<span class='label label-sm label-danger'>Rejected by " . $row->rejected_by_name . "</span>";
//                } else {
//
//                    if ($row->ca_approver_id == 0) {
//                        if ($row->ca_status == 3) {
//                            $status = "<span class='label label-sm label-primary'>Approved request</span>";
//                        } elseif ($row->ca_status == 6) {
//                            $status = "<span class='label label-sm label-primary'>Finish</span>";
//                        }
//                    } else {
//                        if ($row->ca_need_revision == 1) {
//                            $status = "<span class='label label-sm label-success'>Waiting for your revision</span>";
//                        } else {
//                            if ($row->ca_approver_id == 1) {
//                                $curr_approver = User::split_name($row->approver1);
//                            } elseif ($row->ca_approver_id == 2) {
//                                $curr_approver = User::split_name($row->approver2);
//                            } else {
//                                $curr_approver = User::split_name($row->approver3);
//                            }
//                            $status = "<span class='label label-sm label-warning'>Waiting for " . $curr_approver . "'s approval</span>";
//                        }
//                    }
//                }

                if ($show) {
                    $result_cash_advance[] = array(
                        "no" => $no,
                        "ca_id" => $row->ca_id,
                        "ca_date" => date('d M Y', strtotime($row->ca_date)),
                        "ca_subject" => $row->ca_subject . "<br><a href='" . url(env('PUBLIC_PATH') . $row->ca_bank_slip) . "' target='_blank'>View bank slip</a>",
                        "ca_total" => $row->ca_total,
                        "ca_total_real" => $row->ca_total_real,
                        // "ca_submit_date" => $row->ca_submit_date != "0000-00-00" ? date('d M y', strtotime($row->ca_submit_date)) : "",
                        "status" => $status,
                        "action" => $aksi
                    );
                }
            }
        } else {
            $err = $cash_advanceData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $cash_advanceData['recordsTotal'],
            "recordsFiltered" => $cash_advanceData['recordsFiltered'],
            "data" => $result_cash_advance,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function edit_real(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlCashAdvance = 'eleave/cash_advance/getCashAdvanceId';
        $param = [
            "token" => session('token'),
            "ca_id" => $id,
            "userId" => session('id'),
            "step" => $request->get('index'),
        ];
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);
        //echo '<pre>';var_dump($cash_advance_id);echo '</pre>';exit();
        $ca = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ca = json_decode(json_encode($cash_advanceList['data']), FALSE);
        } else {
            $ca = array('message' => $cash_advanceList['message'], 'alert-type' => 'error');
        }
        // dd($cash_advanceList['data']);
        return view('Eleave.expenses.ca_real_update', ['ca' => $ca]);
    }

    public function update_real(Request $request) {
        $ca_id_detail = $request->post('ca_id_detail');
        $ca_date_detail = $request->post('ca_date_detail');
        $ca_real = $request->post('ca_real');
        $data_detail = array();
        for ($i = 0; $i < count($ca_id_detail); $i++) {
            $data_detail[] = array(
                "ca_id_detail" => $ca_id_detail[$i],
                "ca_date_detail" => $ca_date_detail[$i],
                "ca_realization" => $ca_real[$i],
                "ca_last_update" => date('Y-m-d H:i:s'),
            );
        }

        $urlCashAdvance = 'eleave/cash_advance/update_real';
        $param = [
            "token" => session('token'),
            "ca_id" => $request->post('ca_id'),
            "user_id" => $request->post('employee_id'),
            "ca_total_real" => $request->post('ca_total_real'),
            "detail" => $data_detail,
            "ca_last_update" => date('Y-m-d H:i:s'),
            'ca_approver_user' => $request->user_approver1, //next user id approver
        ];
//dd($param);
        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceUpdate = json_decode($cash_advance, true);

        if ($cash_advanceUpdate['response_code'] == 200) {
            if ($request->hasFile('ca_file')) {
                $ca_file = [];

                foreach ($request->file('ca_file') as $index => $file) {
                    // blum dapet index file nya.....

                    $id = substr($cash_advanceUpdate['ca_id'], -4);
                    $fileName = $file->getClientOriginalName();
                    $getFileExt = $file->getClientOriginalExtension();
                    $destinationPath = base_path('public/upload/cash_advance/' . $id . '/');
                    $upload_dir = "upload/cash_advance/" . $id . "/";
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    //cek file exist...
//                    $files_old = glob($destinationPath . "ca_file_" . $id . "_" . $ca_id_detail[$index] . ".*");
//                    foreach ($files_old as $files) {
//                        unlink($files);
//                    }

//                    $file->move($destinationPath, "ca_file_" . $id . "_" . $ca_id_detail[$index] . "." . $getFileExt);
                    $file->move($destinationPath, $fileName);
                    
                    $ca_file[] = array(
                        "id" => $ca_id_detail[$index],
                        //"ca_file" => $upload_dir . "ca_file_" . $id . "_" . $ca_id_detail[$index] . "." . $getFileExt,
                        "ca_file" => $upload_dir . $fileName,
                    );

                    $index++;
                }

                $urlUpload = 'eleave/cash_advance/ca_upload';
                $param = [
                    "token" => session('token'),
                    "user_id" => $request->post('employee_id'),
                    "ca_id" => $request->post('ca_id'),
                    "upload_detail" => $ca_file,
                ];
                $ca_upload = ElaHelper::myCurl($urlUpload, $param);
                $caUpdate = json_decode($ca_upload, true);
            }

            return redirect('eleave/cash_advance?index=2')
                            ->with(array('message' => $cash_advanceUpdate['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/cash_advance/' . $request->post('ca_id') . '/edit_real')
                            ->with(array('message' => $cash_advanceUpdate['message'], 'alert-type' => 'error'));
        }
    }

}
