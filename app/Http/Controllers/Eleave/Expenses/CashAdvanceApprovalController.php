<?php
namespace App\Http\Controllers\Eleave\Expenses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;

class CashAdvanceApprovalController extends Controller {

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
            return view('Eleave.expenses.ca_Approval', ['notif' => $link_notif, 'source_id' => $source_id]);
        } else {
            return view('Eleave.expenses.ca_realApproval', ['notif' => $link_notif, 'source_id' => $source_id]);
        }
    }

    public function getCashAdvanceApproval(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advanceApproval/index';
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "notif" => $request->post('notif'),
            "source_id" => $request->post('source_id'),
            "step" => ($request->post('step') == 1 ? 1 : 2),
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_subject" => $request['columns'][4]['search']['value'],
            "search_total" => $request['columns'][5]['search']['value'],
            "search_total_real" => $request['columns'][6]['search']['value'],
            "search_status" => $request['columns'][12]['search']['value'],
            "userId" => session('id'),
        ];
        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceData = json_decode($cash_advance, true);
        //    var_dump($cash_advance);exit();

        $err = "";
        $result_cash_advance = array();
        $no = $request->post('start');
        if ($cash_advanceData['response_code'] == 200) {

            $user_cash_advance = $cash_advanceData['data'];
            $object = json_decode(json_encode($user_cash_advance), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";
                $no++;
                $show = 0;

                if ($row->ca_step == 1) {
                    if ($row->ca_status == 1) {
                        if ($row->ca_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting employee revision</span>";
                        } else {
                            $id_approver = 0;
                            if ($row->ca_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ca_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } elseif ($row->ca_approver_id == 3) {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            } else {
                                $id_approver = 4;
                            }
                            if ($id_approver == session('id')) {
                                $status = "<span class='label label-warning'>Waiting your approval</span>";
                                $show = 1;
                                //approve
                                $next = 0;
                                $approver_user = 0;
                                if ($row->ca_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                    $approver_user = $row->user_approver2;
                                } elseif ($row->ca_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                    $approver_user = $row->user_approver3;
                                } else {
                                    $next = 4; //for finance
                                    $approver_user = 62; // set for user finance 1
                                }
                                //approve
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "|" . $row->user_id . "|" . $next . "|" . $approver_user . "' title='Approve' ><i class='fa fa-check'></i></a>";
                                //reject
                                $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->user_id . "','" . $row->ca_id . "') id='" . $row->ca_id . "|" . $row->user_id . "'><i class='fa fa-close'></i></a>";
                                //revisi
                                $aksi .= "<a class='btn yellow-crusta btn-xs' onClick=revisi_this('" . $row->user_id . "','" . $row->ca_id . "')><i class='fa fa-edit'></i></a>";
                            } else {
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                $show = 1;
                            }
                        }
                    } elseif ($row->ca_status == 2) {
                        $status = "<span class='label label-success'>Processing Finance</span>";
                        $show = 1;
                    }
                }



//                if ($row->ca_rejected == 1) {
//                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>";
//                    $show = 1;
//                } else {
//                    if ($row->ca_approver_id == 0) {
//                        $status = "<span class='label label-primary'>Approved</span>";
//                        $show = 1;
//                    } else {
//                        if ($row->ca_need_revision == 1) {
//                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
//                            $show = 1;
//                        } else {
//                            $id_approver = 0;
//                            if ($row->ca_approver_id == 1) {
//                                $id_approver = $row->user_approver1;
//                                $curr_approver = User::split_name($row->approver1);
//                            } elseif ($row->ca_approver_id == 2) {
//                                $id_approver = $row->user_approver2;
//                                $curr_approver = User::split_name($row->approver2);
//                            } elseif ($row->ca_approver_id == 3) {
//                                $id_approver = $row->user_approver3;
//                                $curr_approver = User::split_name($row->approver3);
//                            } else {
//                                $id_approver = 4;
//                            }
//                            if ($id_approver == session('id')) {
//                                $status = "<span class='label label-warning'>Waiting your approval</span>";
//                                $show = 1;
//                                //if($row->ca_approver_id != 0){
//                                //approve
//                                $next = 0;
//                                $approver_user = 0;
//                                if ($row->ca_approver_id == 1 && $row->user_approver2 != 0) {
//                                    $next = 2;
//                                    $approver_user = $row->user_approver2;
//                                } elseif ($row->ca_approver_id == 2 && $row->user_approver3 != 0) {
//                                    $next = 3;
//                                    $approver_user = $row->user_approver3;
//                                } else {
//                                    $next = 4; //for finance
//                                }
//                                //approve
//                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "|" . $row->user_id . "|" . $next . "|" . $approver_user . "' title='Approve' ><i class='fa fa-check'></i></a>";
//                                //reject
//                                //$aksi .= "<a href='" . base_url() . "index.php/cash_advance_approval/reject/" . $row->ca_id . "' class='btn btn-icon-only red reject' title='Reject' id='reject-" . $no . "-" . $row->ca_id . "'><i class='fa fa-thumbs-down'></i></a>&nbsp;";
//                                $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->user_id . "','" . $row->ca_id . "') id='" . $row->ca_id . "|" . $row->user_id . "'><i class='fa fa-close'></i></a>";
//                                //revisi
//                                $aksi .= "<a class='btn yellow-crusta btn-xs' onClick=revisi_this('" . $row->user_id . "','" . $row->ca_id . "')><i class='fa fa-edit'></i></a>";
//                            } else {
//                                if ($id_approver == 4) {
//                                    $status = "<span class='label label-success'>Processing Finance</span>";
//                                    $show = 1;
//                                } else {
//                                    $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
//                                    $show = 1;
//                                }
//                            }
//                        }
//                    }
//                }

                if ($show) {
                    $result_cash_advance[] = array(
                        "no" => $no,
                        "ca_id" => $row->ca_id,
                        "user_name" => $row->user_name,
                        "ca_subject" => $row->ca_subject,
                        "ca_date" => date('d M Y', strtotime($row->ca_date)),
                        "ca_total" => $row->ca_total,
                        "status" => $status,
                        "action" => $aksi,
                        //"ca_end_date" => $get_date_range->end_date,
                        "ca_submit_date" => $row->ca_submit_date != "0000-00-00" ? $row->ca_submit_date : "",
                        "year" => date('Y', strtotime($row->ca_date)),
                        "month" => date('F', strtotime($row->ca_date)),
                        "approver1" => $row->approver1,
                        "approver2" => $row->approver2,
                        "approver3" => $row->approver3,
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
            "totNotifReq" => $cash_advanceData['total_req'],
            "totNotifReal" => $cash_advanceData['total_real'],
        );
        echo json_encode($json_data);
    }

    public function getCashAdvanceApprovalNotif(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advanceApproval/index';
        $search = (isset($filter['value'])) ? $filter['value'] : false;
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "step" => ($request->post('step') == 1 ? 1 : 2),
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
        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);

        $cash_advanceData = json_decode($cash_advance, true);

        $err = "";
        $result_cash_advance = array();
        $no = $request->post('start');
        if ($cash_advanceData['response_code'] == 200) {

            $user_cash_advance = $cash_advanceData['data'];
            $object = json_decode(json_encode($user_cash_advance), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "','" . $row->ca_type . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";

                $show = 0;
                if ($row->ca_rejected == 1) {
                    $status = "<span class='label label-danger'>Rejected by " . $row->rejected_by_name . "</span>";
                    $show = 1;
                } else {
                    if ($row->ca_approver_id == 0) {
                        $status = "<span class='label label-primary'>Approved</span>";
                        $show = 1;
                    } else {
                        if ($row->ca_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
                            $show = 1;
                        } else {
                            $id_approver = 0;
                            if ($row->ca_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ca_approver_id == 2) {
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
                                //if($row->ca_approver_id != 0){
                                //approve
                                $next = 0;
                                if ($row->ca_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                } elseif ($row->ca_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                } else {
                                    $next = 4;
                                }
                                //approve
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "-" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
                                //reject
                                //$aksi .= "<a href='" . base_url() . "index.php/cash_advance_approval/reject/" . $row->ca_id . "' class='btn btn-icon-only red reject' title='Reject' id='reject-" . $no . "-" . $row->ca_id . "'><i class='fa fa-thumbs-down'></i></a>&nbsp;";
                                $aksi .= "<a class='btn red btn-xs reject' id='" . $row->ca_id . "'><i class='fa fa-close'></i></a>";
                                //revisi
                                $aksi .= "<a class='btn yellow-crusta btn-xs' onclick='revisi_this(" . $row->ca_id . ")'><i class='fa fa-edit'></i></a>";
                            } else {
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                $show = 1;
                            }
                        }
                    }
                }

                $activity = $row->ca_activity;
                $time = "";

                if ($row->ca_type == "Absent") {
                    //$activity .= "<br><br>Supporting Document : <a href='".base_url().$row->ca_file."' target='_blank'>Click To View</a>";
                    //$activity .= "<br><br><a href='" . base_url() . $row->ca_file . "' target='_blank' style='color:red;'>Click To View Support Document</a>";
                } else {
                    //$activity .= "<a href='#' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "','" . $row->ca_type . "')>" . substr($get_data_detail[0]['ca_activity'], 0, 55) . "...</a>";
                    //$time = "In  : " . $row->ca_time_in . "<br>Out : " . $row->ca_time_out . "<br>Total : " . $row->ca_total_time;
                }

                if ($show == "notif") {
                    $no++;
                    $result_cash_advance[] = array(
                        "no" => $no,
                        "ca_id" => $row->ca_id,
                        "user_name" => $row->user_name,
                        "ca_type" => $row->ca_type,
                        "ca_date" => $row->start_date,
                        "ca_end_date" => $row->end_date,
                        "status" => $status,
                        "action" => $aksi,
                        //"ca_end_date" => $get_date_range->end_date,
                        "ca_submit_date" => $row->ca_submit_date != "0000-00-00" ? $row->ca_submit_date : "",
                        "ca_time_in" => $row->ca_time_in,
                        "ca_time_out" => $row->ca_time_out,
                        "ca_location" => $row->ca_location,
                        "ca_activity" => $row->ca_activity,
                        "ca_total_time" => $row->total_day . " day(s)",
                        "year" => date('Y', strtotime($row->ca_date)),
                        "month" => date('F', strtotime($row->ca_date)),
                        "approver1" => $row->approver1,
                        "approver2" => $row->approver2,
                        "approver3" => $row->approver3,
                        "user_status" => $row->user_status,
                    );
                }
            }
        } else {
            $err = $cash_advanceData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($result_cash_advance), //$cash_advanceData['recordsTotal'],
            "recordsFiltered" => count($result_cash_advance), //$cash_advanceData['recordsFiltered'],
            "data" => $result_cash_advance,
            "totNotif" => $cash_advanceData['total'],
        );
        echo json_encode($json_data);
    }

    public function get_data_detail(Request $request) {
        if (!Session::has('token')) {
            return redirect('/logout');
        }

        $urlCashAdvance = 'eleave/cash_advance/getCashAdvanceDetail';
        $param = [
            'token' => session('token'),
            'id' => $request->id,
            'ca_id' => $request->ca_id,
        ];
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);

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
                    'ca_voucher' => $value['ca_voucher'],
                    'ca_cheque' => $value['ca_cheque'],
                    'ca_voucher_slip' => url(env('PUBLIC_PATH') . $value['ca_voucher_slip']),
                    'ca_bank_slip' => url(env('PUBLIC_PATH') . $value['ca_bank_slip']),
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

    public function revise(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advanceApproval/revise';
        $param = [
            'token' => session('token'),
            'user_id' => $request->user_id,
            'ca_id' => $request->ca_id,
            'ca_approver_id' => 1,
            'ca_need_revision' => 1,
            'ca_revision_reason' => $request->ca_reason,
            //'ca_revision_reason' => $request->ca_revision_reason,
            'ca_revision_from' => session('id'),
            'ca_revision_nama' => session('nama'),
        ];
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);

        $ts = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $cash_advanceList['message']);
        } else {
            $ts = array('status' => false);
        }
        echo json_encode($ts);
    }

    public function approve(Request $request) {
        if (!Session::has('token')) {
            return redirect('/logout');
        }

        $urlCashAdvance = 'eleave/cash_advanceApproval/approve';
        $param = [
            'token' => session('token'),
            'next' => $request->next,
            'ca_id' => $request->ca_id,
            'user_id' => $request->user_id,
            'ca_approve_nama' => session('nama'),
            'ca_approver_user' => $request->approver_user, //next user id approver
        ];
        //dd($param);
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);

        $ts = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $cash_advanceList['message']);
        } else {
            $ts = array('status' => false, 'message' => 'Bad Request');
        }
        echo json_encode($ts);
    }

    public function reject(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advanceApproval/reject';
        $param = [
            'token' => session('token'),
            'user_id' => $request->user_id,
            'ca_id' => $request->ca_id,
            'ca_rejected_reason' => $request->ca_reason,
            'ca_rejected' => 1,
            'ca_rejected_by' => session('id'),
            'ca_rejected_nama' => session('nama'),
        ];
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);
        $ts = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $cash_advanceList['message']);
        } else {
            $ts = array('status' => false);
        }
        echo json_encode($ts);
    }

    public function add() {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        return view('Eleave.cash_advance.new');
    }

    public function edit($id) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advance/getCashAdvanceId';
        $param = [
            "token" => session('token'),
            "ca_id" => $id,
        ];
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);
        $ot = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ot = json_decode(json_encode($cash_advanceList['data']), FALSE);
        } else {
            $ot = $cash_advanceList['message'];
        }
        // dd($cash_advanceList['data']);
        return view('Eleave.cash_advance.cash_advanceEdit', ['ot' => $ot]);
    }

    public function save(Request $request) {
        $urlCashAdvance = 'eleave/cash_advance/save';
        $param = [
            "token" => session('token'),
            "user_id" => session('id'),
            "ca_date" => $request->post('ca_date'),
            "ca_time_in" => $request->post('ca_time_in'),
            "ca_time_out" => $request->post('ca_time_out'),
            "ca_description" => $request->post('ca_description'),
            "ca_reason" => $request->post('ca_reason'),
            "ca_negative_impact" => $request->post('ca_impact'),
            "branch_id" => session('branch_id'),
            "ca_finger_print_id" => session('finger_print_id'),
            "ca_approver_id" => 1,
            "ca_need_revision" => 0,
            "ca_last_update" => date('Y-m-d H:i:s'),
            "ca_submit_date" => date('Y-m-d')
        ];

        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceSave = json_decode($cash_advance, true);
        //echo json_encode($cash_advanceSave);
        //      dd($cash_advanceSave['response_code']);
        if ($cash_advanceSave['response_code'] == 200) {
            return redirect('eleave/cash_advance/index')
                            ->with('success', $cash_advanceSave['message']);
        } else {
            return redirect('eleave/cash_advance/add')
                            ->with('success', $cash_advanceSave['message']);
        }
    }

    public function update(Request $request, $id) {
        $urlCashAdvance = 'eleave/cash_advance/update';
        $param = [
            "token" => session('token'),
            "ca_id" => $id,
            "user_id" => session('id'),
            "ca_date" => $request->post('ca_date'),
            "ca_time_in" => $request->post('ca_time_in'),
            "ca_time_out" => $request->post('ca_time_out'),
            "ca_description" => $request->post('ca_description'),
            "ca_reason" => $request->post('ca_reason'),
            "ca_negative_impact" => $request->post('ca_impact'),
            "branch_id" => session('branch_id'),
            "ca_finger_print_id" => session('finger_print_id'),
            "ca_approver_id" => 1,
            "ca_need_revision" => 0,
            "ca_last_update" => date('Y-m-d H:i:s'),
        ];

        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceUpdate = json_decode($cash_advance, true);
        //dd($param);
        //echo json_encode($cash_advanceSave);
        return redirect('eleave/cash_advance/index')
                        ->with('success', $cash_advanceUpdate['message']);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlCashAdvance = 'eleave/cash_advance/delete';
        $param = [
            "token" => session('token'),
            "ca_id" => $id,
        ];
        // dd($param);
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);
        $ot = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ot = array('status' => true);
        } else {
            $ot = $cash_advanceList['message'];
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

    ///////////// for finance execution ///////////////////////////////////////
    function all_request(Request $request) {
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

        return view('Eleave.expenses.ca_finance_index', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getCaFinance(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advanceApproval/all_request';
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
            "search_name" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_subject" => $request['columns'][4]['search']['value'],
            "search_total" => $request['columns'][5]['search']['value'],
            "search_status" => $request['columns'][9]['search']['value'],
            "userId" => session('id'),
        ];
        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceData = json_decode($cash_advance, true);
        //   var_dump($cash_advance);exit();
        $err = "";
        $result_cash_advance = array();
        $no = $request->post('start');
        if ($cash_advanceData['response_code'] == 200) {

            $user_cash_advance = $cash_advanceData['data'];
            $object = json_decode(json_encode($user_cash_advance), FALSE);
            $ca_approver = $cash_advanceData['ca_approver'];

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";
                $no++;
                $show = 0;
                if ($row->ca_step == 1) {
                    if ($row->ca_status == 1) {
                        if ($row->ca_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting employee revision</span>";
                        } else {
                            $id_approver = 0;
                            if ($row->ca_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ca_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } elseif ($row->ca_approver_id == 3) {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            } else {
                                $id_approver = 4;
                            }
                            $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                        }
                        $show = 1;
                    } elseif ($row->ca_status == 2) {
                        if (session('id') == $ca_approver['finance_approver1']) {
                            if (empty($row->ca_voucher) && empty($row->ca_voucher_slip)) {
                                $status = "<span class='label label-warning'>Waiting your processing</span>";
                                $aksi .= "<a class='btn yellow-crusta btn-xs' title='process' onClick=process_this('" . $row->user_id . "','" . $row->ca_id . "','" . $ca_approver['finance_approver1'] . "')><i class='fa fa-edit'></i></a>";
                            }else{
                                $status = "<span class='label label-warning'>Waiting finance2</span>";
                            }
                        } elseif (session('id') == $ca_approver['finance_approver2']) {
                            if (empty($row->ca_voucher) && empty($row->ca_voucher_slip)) {
                                $status = "<span class='label label-warning'>Waiting finance1</span>";
                            } else {
                                if (empty($row->ca_cheque) && empty($row->ca_bank_slip)) {
                                    $status = "<span class='label label-warning'>Waiting your processing</span>";
                                    $aksi .= "<a class='btn yellow-crusta btn-xs' title='process' onClick=process_this('" . $row->user_id . "','" . $row->ca_id . "','" . $ca_approver['finance_approver1'] . "')><i class='fa fa-edit'></i></a>";
                                }
                            }
                        }
                        $show = 1;
                    }
                }



//                if ($row->ca_rejected == 1) {
//                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>";
//                    $show = 1;
//                } else {
//                    if ($row->ca_approver_id == 0) {
//                        $status = "<span class='label label-primary'>Approved</span>";
//                        $show = 1;
//                    } else {
//                        if ($row->ca_need_revision == 1) {
//                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
//                            $show = 1;
//                        } else {
//                            $id_approver = 0;
//                            if ($row->ca_approver_id == 1) {
//                                $id_approver = $row->user_approver1;
//                                $curr_approver = User::split_name($row->approver1);
//                            } elseif ($row->ca_approver_id == 2) {
//                                $id_approver = $row->user_approver2;
//                                $curr_approver = User::split_name($row->approver2);
//                            } elseif ($row->ca_approver_id == 3) {
//                                $id_approver = $row->user_approver3;
//                                $curr_approver = User::split_name($row->approver3);
//                            } else {
//                                $id_approver = 4;
//                            }
//                            if ($id_approver == session('id')) {
//                                $status = "<span class='label label-warning'>Waiting for your approval</span>";
//                                $show = 1;
//                                //if($row->ca_approver_id != 0){
//                                //approve
//                                $next = 0;
//                                if ($row->ca_approver_id == 1 && $row->user_approver2 != 0) {
//                                    $next = 2;
//                                } elseif ($row->ca_approver_id == 2 && $row->user_approver3 != 0) {
//                                    $next = 3;
//                                } else {
//                                    $next = 4; //for finance
//                                }
//                                //approve
//                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "|" . $row->user_id . "|" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
//                                //reject
//                                //$aksi .= "<a href='" . base_url() . "index.php/cash_advance_approval/reject/" . $row->ca_id . "' class='btn btn-icon-only red reject' title='Reject' id='reject-" . $no . "-" . $row->ca_id . "'><i class='fa fa-thumbs-down'></i></a>&nbsp;";
//                                $aksi .= "<a class='btn red btn-xs reject' id='" . $row->ca_id . "|" . $row->user_id . "'><i class='fa fa-close'></i></a>";
//                                //revisi
//                                $aksi .= "<a class='btn yellow-crusta btn-xs' onClick=revisi_this('" . $row->user_id . "','" . $row->ca_id . "')><i class='fa fa-edit'></i></a>";
//                            } else {
//                                if ($id_approver == 4) {
//                                    $status = "<span class='label label-success'>Processing Finance</span>";
//                                    $show = 1;
//                                    $aksi .= "<a class='btn yellow-crusta btn-xs' title='process' onClick=process_this('" . $row->user_id . "','" . $row->ca_id . "','" . $ca_approver['finance_approver1'] . "')><i class='fa fa-edit'></i></a>";
//                                } else {
//                                    $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
//                                    $show = 1;
//                                }
//                            }
//                        }
//                    }
//                }

                if ($show) {
                    $result_cash_advance[] = array(
                        "no" => $no,
                        "ca_id" => $row->ca_id,
                        "user_name" => $row->user_name,
                        "ca_subject" => $row->ca_subject,
                        "ca_date" => date('d M Y', strtotime($row->ca_date)),
                        "ca_total" => $row->ca_total,
                        "ca_voucher" => (!empty($row->ca_voucher) ? $row->ca_voucher : "<center><i class='glyphicon glyphicon-remove'></i></center>" ),
                        "ca_cheque" => (!empty($row->ca_cheque) ? $row->ca_cheque : "<center><i class='glyphicon glyphicon-remove'></i></center>" ),
                        "ca_bank_slip" => (!empty($row->ca_bank_slip) ? "<center><a href='" . url(env('PUBLIC_PATH') . $row->ca_bank_slip) . "' target='_blank'><i class='fa fa-file-image-o'></i></a></center>" : "<center><i class='glyphicon glyphicon-remove'></i></center>"),
                        "status" => $status,
                        "action" => $aksi,
                            //"ca_step" => ($row->ca_step == 1 ? "Request" : "Realization"),
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
            "totNotifReq" => $cash_advanceData['total_req'],
            "totNotifReal" => $cash_advanceData['total_real'],
        );
        echo json_encode($json_data);
    }

    public function process_finance(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->ca_id;
        $urlCashAdvance = 'eleave/cash_advanceApproval/fa_update_request';
        $param = [
            "token" => session('token'),
            "ca_id" => $id,
            "user_id" => $request->user_id,
            "voucher_no" => $request->voucher_no,
            "cheque_no" => $request->cheque_no,
        ];
        $cash_advance_id = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceList = json_decode($cash_advance_id, true);
        //var_dump($param);exit();
        $ts = "";
        $file_voucher = "";
        $file_bank_slip = "";
        if ($cash_advanceList['response_code'] == 200) {
            $ca_id = $cash_advanceList['ca_id'];
            if ($request->hasFile('voucher_file')) {
                $id = substr($cash_advanceList['ca_id'], -4);
                $fileName = $request->file('voucher_file')->getClientOriginalName();
                $getFileExt = $request->file('voucher_file')->getClientOriginalExtension();
                $destinationPath = base_path('public/upload/cash_advance/' . $id . '/');
                $upload_dir = "upload/cash_advance/" . $id . "/";
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $request->file('voucher_file')->move($destinationPath, "voucher_" . $id . "." . $getFileExt);
                $file_voucher = $upload_dir . "voucher_" . $id . "." . $getFileExt;
            } elseif ($request->hasFile('cheq_file')) {
                $id = substr($cash_advanceList['ca_id'], -4);
                $getFileExt = $request->file('cheq_file')->getClientOriginalExtension();
                $destinationPath = base_path('public/upload/cash_advance/' . $id . '/');
                $upload_dir = "upload/cash_advance/" . $id . "/";
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $request->file('cheq_file')->move($destinationPath, "bank_slip_" . $id . "." . $getFileExt);
                $file_bank_slip = $upload_dir . "bank_slip_" . $id . "." . $getFileExt;
            }

            $urlUpload = 'eleave/cash_advanceApproval/fa_upload';
            $param = [
                "token" => session('token'),
                "ca_id" => $ca_id,
                "user_id" => $request->user_id,
                "ca_voucher_slip" => (!empty($file_voucher) ? $file_voucher : ""),
                "ca_bank_slip" => (!empty($file_bank_slip) ? $file_bank_slip : "")
            ];

            $fa_upload = ElaHelper::myCurl($urlUpload, $param);
            $faUpdate = json_decode($fa_upload, true);

            $ts = array('status' => true, 'message' => $cash_advanceList['message']);
        } else {
            $ts = $cash_advanceList['message'];
        }
        echo json_encode($ts);
        // dd($cash_advanceList['data']);
        //return view('Eleave.cash_advance.ts_edit', ['ts' => $ts]);
    }

    function all_realization(Request $request) {
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

        if ($request->get('status') == "in_process") {
            return view('Eleave.expenses.ca_realfinance_index', ['notif' => $link_notif, 'source_id' => $source_id]);
        } elseif ($request->get('status') == "done") {
            return view('Eleave.expenses.ca_historyfinance', ['notif' => $link_notif, 'source_id' => $source_id]);
        }
    }

    public function getCaFinanceReal(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advanceApproval/all_request';
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
            "search_name" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_subject" => $request['columns'][4]['search']['value'],
            "search_total" => $request['columns'][5]['search']['value'],
            "search_status" => $request['columns'][10]['search']['value'],
            "userId" => session('id'),
        ];
        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceData = json_decode($cash_advance, true);
        //   var_dump($cash_advance);exit();
        $err = "";
        $result_cash_advance = array();
        $no = $request->post('start');
        if ($cash_advanceData['response_code'] == 200) {

            $user_cash_advance = $cash_advanceData['data'];
            $object = json_decode(json_encode($user_cash_advance), FALSE);
            $ca_approver = $cash_advanceData['ca_approver'];

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";
                $no++;
                $show = 0;

                if ($row->ca_step == 2) {
                    if ($request->post('step') == 2) {
                        if ($row->ca_status == 3) {
                            $status = "<span class='label label-info'>Approved request</span>";
                            $show = 1;
                        } elseif ($row->ca_status == 4) {
                            if ($row->ca_need_revision == 1) {
                                $status = "<span class='label label-success'>Waiting for employee revision</span>";
                            } else {
                                $id_approver = 0;
                                if ($row->ca_approver_id == 1) {
                                    $id_approver = $row->user_approver1;
                                    $curr_approver = User::split_name($row->approver1);
                                } elseif ($row->ca_approver_id == 2) {
                                    $id_approver = $row->user_approver2;
                                    $curr_approver = User::split_name($row->approver2);
                                } elseif ($row->ca_approver_id == 3) {
                                    $id_approver = $row->user_approver3;
                                    $curr_approver = User::split_name($row->approver3);
                                } else {
                                    $id_approver = 4;
                                }
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                            }
                            $show = 1;
                        } elseif ($row->ca_status == 5) {
                            $status = "<span class='label label-warning'>Waiting your approval</span>";
                            $next = 0;
                            $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "|" . $row->user_id . "|" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
                            $show = 1;
                        } elseif ($row->ca_status == 10) {
                            if ($row->ca_rejected == 1) {
                                $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>";
                            } else {
                                $status = "<span class='label label-sm label-danger'>Deleted</span>";
                            }
                            $show = 1;
                        }
                    } elseif ($row->ca_status == 6 && $row->ca_approver_id == 0 && $request->post('step') == "done") {
                        $show = 1;
                        $status = "<span class='label label-primary'>Finish</span>";
                    }
                }

//                if ($row->ca_rejected == 1) {
//                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>";
//                    $show = 1;
//                } else {
//                    if ($row->ca_approver_id == 0 && $row->ca_step == 2 && $row->ca_status == 6) {
//                        $status = "<span class='label label-primary'>Finish</span>";
//                        $show = 1;
//                    } else {
//                        if ($row->ca_need_revision == 1) {
//                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
//                            $show = 1;
//                        } else {
//
//                            $id_approver = 0;
//                            if ($row->ca_approver_id == 1) {
//                                $id_approver = $row->user_approver1;
//                                $curr_approver = User::split_name($row->approver1);
//                            } elseif ($row->ca_approver_id == 2) {
//                                $id_approver = $row->user_approver2;
//                                $curr_approver = User::split_name($row->approver2);
//                            } elseif ($row->ca_approver_id == 3) {
//                                $id_approver = $row->user_approver3;
//                                $curr_approver = User::split_name($row->approver3);
//                            } else {
//                                $id_approver = 4;
//                            }
//                            $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
//
//                            if ($id_approver == session('id')) {
//                                $status = "<span class='label label-warning'>Waiting for your approval</span>";
//                                $show = 1;
//                                //if($row->ca_approver_id != 0){
//                                //approve
//                                $next = 0;
//                                if ($row->ca_approver_id == 1 && $row->user_approver2 != 0) {
//                                    $next = 2;
//                                } elseif ($row->ca_approver_id == 2 && $row->user_approver3 != 0) {
//                                    $next = 3;
//                                } else {
//                                    $next = 4; //for finance
//                                }
//                                //approve
//                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "|" . $row->user_id . "|" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
//                                //reject
//                                //$aksi .= "<a href='" . base_url() . "index.php/cash_advance_approval/reject/" . $row->ca_id . "' class='btn btn-icon-only red reject' title='Reject' id='reject-" . $no . "-" . $row->ca_id . "'><i class='fa fa-thumbs-down'></i></a>&nbsp;";
//                                $aksi .= "<a class='btn red btn-xs reject' id='" . $row->ca_id . "|" . $row->user_id . "'><i class='fa fa-close'></i></a>";
//                                //revisi
//                                $aksi .= "<a class='btn yellow-crusta btn-xs' onClick=revisi_this('" . $row->user_id . "','" . $row->ca_id . "')><i class='fa fa-edit'></i></a>";
//                            } else {
//                                if ($id_approver == 4) {
//                                    $status = "<span class='label label-success'>Processing Finance</span>";
//                                    $show = 1;
//                                    $next = 0;
//                                    $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "|" . $row->user_id . "|" . $next . "' title='Approve' ><i class='fa fa-check'></i></a>";
//                                } else {
//                                    $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
//                                    $show = 1;
//                                }
//                            }
//                        }
//                    }
//                }

                if ($show) {
                    $result_cash_advance[] = array(
                        "no" => $no,
                        "ca_id" => $row->ca_id,
                        "user_name" => $row->user_name,
                        "ca_subject" => $row->ca_subject,
                        "ca_date" => date('d M Y', strtotime($row->ca_date)),
                        "ca_total" => $row->ca_total,
                        "ca_total_real" => $row->ca_total_real,
                        "ca_voucher" => (!empty($row->ca_voucher) ? $row->ca_voucher : "<center><i class='glyphicon glyphicon-remove'></i></center>" ),
                        "ca_cheque" => (!empty($row->ca_cheque) ? $row->ca_cheque : "<center><i class='glyphicon glyphicon-remove'></i></center>" ),
                        "ca_bank_slip" => (!empty($row->ca_bank_slip) ? "<center><a href='" . url(env('PUBLIC_PATH') . $row->ca_bank_slip) . "' target='_blank'><i class='fa fa-file-image-o'></i></a></center>" : "<center><i class='glyphicon glyphicon-remove'></i></center>"),
                        "status" => $status,
                        "action" => $aksi,
                            //"ca_step" => ($row->ca_step == 1 ? "Request" : "Realization"),
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
            "totNotifReq" => $cash_advanceData['total_req'],
            "totNotifReal" => $cash_advanceData['total_real'],
        );
        echo json_encode($json_data);
    }

    ////////////////////////////// realization step for approver //////////////////////////////////////////////////////// 

    public function getCashAdvanceApprovalReal(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlCashAdvance = 'eleave/cash_advanceApproval/index';
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "notif" => $request->post('notif'),
            "source_id" => $request->post('source_id'),
            "step" => ($request->post('step') == 1 ? 1 : 2),
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_subject" => $request['columns'][4]['search']['value'],
            "search_total" => $request['columns'][5]['search']['value'],
            "search_total_real" => $request['columns'][6]['search']['value'],
            "search_status" => $request['columns'][13]['search']['value'],
            "userId" => session('id'),
        ];
        $cash_advance = ElaHelper::myCurl($urlCashAdvance, $param);
        $cash_advanceData = json_decode($cash_advance, true);
//        var_dump($cash_advance);exit();
        $err = "";
        $result_cash_advance = array();
        $no = $request->post('start');
        if ($cash_advanceData['response_code'] == 200) {

            $user_cash_advance = $cash_advanceData['data'];
            $object = json_decode(json_encode($user_cash_advance), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->ca_id . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";
                $no++;
                $show = 0;

                if ($row->ca_step == 2) {
                    if ($row->ca_status == 3) {
                        $status = "<span class='label label-info'>Approved request</span>";
                        $show = 1;
                    } elseif ($row->ca_status == 4) {
                        if ($row->ca_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting employee revision</span>";
                        } else {
                            $id_approver = 0;
                            if ($row->ca_approver_id == 1) {
                                $id_approver = $row->user_approver1;
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->ca_approver_id == 2) {
                                $id_approver = $row->user_approver2;
                                $curr_approver = User::split_name($row->approver2);
                            } elseif ($row->ca_approver_id == 3) {
                                $id_approver = $row->user_approver3;
                                $curr_approver = User::split_name($row->approver3);
                            } else {
                                $id_approver = 4;
                            }
                            if ($id_approver == session('id')) {
                                $status = "<span class='label label-warning'>Waiting your approval</span>";
                                $show = 1;
                                //approve
                                $next = 0;
                                $approver_user = 0;
                                if ($row->ca_approver_id == 1 && $row->user_approver2 != 0) {
                                    $next = 2;
                                    $approver_user = $row->user_approver2;
                                } elseif ($row->ca_approver_id == 2 && $row->user_approver3 != 0) {
                                    $next = 3;
                                    $approver_user = $row->user_approver3;
                                } else {
                                    $next = 4; //for finance
                                    $approver_user = 64; // set for user finance 1
                                }
                                //approve
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "|" . $row->user_id . "|" . $next . "|" . $approver_user . "' title='Approve' ><i class='fa fa-check'></i></a>";
                                //reject di disable request by kenji
                                // $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->user_id . "','" . $row->ca_id . "') id='" . $row->ca_id . "|" . $row->user_id . "'><i class='fa fa-close'></i></a>";
                                //revisi
                                $aksi .= "<a class='btn yellow-crusta btn-xs' onClick=revisi_this('" . $row->user_id . "','" . $row->ca_id . "')><i class='fa fa-edit'></i></a>";
                            } else {
                                $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                                $show = 1;
                            }
                        }
                        $show = 1;
                    } elseif ($row->ca_status == 5) {
                        $status = "<span class='label label-success'>Processing Finance</span>";
                        $show = 1;
                    }
                }


//                if ($row->ca_rejected == 1) {
//                    $status = "<span class='label label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>";
//                    $show = 1;
//                } else {
//                    if ($row->ca_approver_id == 0) {
//                        $status = "<span class='label label-primary'>Approved</span>";
//                        $show = 1;
//                    } else {
//                        if ($row->ca_need_revision == 1) {
//                            $status = "<span class='label label-success'>Waiting for employee revision</span>";
//                            $show = 1;
//                        } else {
//                            $id_approver = 0;
//                            if ($row->ca_approver_id == 1) {
//                                $id_approver = $row->user_approver1;
//                                $curr_approver = User::split_name($row->approver1);
//                            } elseif ($row->ca_approver_id == 2) {
//                                $id_approver = $row->user_approver2;
//                                $curr_approver = User::split_name($row->approver2);
//                            } elseif ($row->ca_approver_id == 3) {
//                                $id_approver = $row->user_approver3;
//                                $curr_approver = User::split_name($row->approver3);
//                            } else {
//                                $id_approver = 4;
//                            }
//                            if ($id_approver == session('id')) {
//                                $status = "<span class='label label-warning'>Waiting for your approval</span>";
//                                $show = 1;
//                                //if($row->ca_approver_id != 0){
//                                //approve
//                                $next = 0;
//                                $approver_user = 0;
//                                if ($row->ca_approver_id == 1 && $row->user_approver2 != 0) {
//                                    $next = 2;
//                                    $approver_user = $row->user_approver2;
//                                } elseif ($row->ca_approver_id == 2 && $row->user_approver3 != 0) {
//                                    $next = 3;
//                                    $approver_user = $row->user_approver3;
//                                } else {
//                                    $next = 4; //for finance
//                                }
//                                //approve
//                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->ca_id . "|" . $row->user_id . "|" . $next . "|" . $approver_user . "' title='Approve' ><i class='fa fa-check'></i></a>";
//                                //reject tidak ada di tab realization
//                                //revisi
//                                $aksi .= "<a class='btn yellow-crusta btn-xs' onClick=revisi_this('" . $row->user_id . "','" . $row->ca_id . "')><i class='fa fa-edit'></i></a>";
//                            } else {
//                                if ($id_approver == 4) {
//                                    $status = "<span class='label label-success'>Processing Finance</span>";
//                                    $show = 1;
//                                } else {
//                                    $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
//                                    $show = 1;
//                                }
//                            }
//                        }
//                    }
//                }

                if ($show) {
                    $result_cash_advance[] = array(
                        "no" => $no,
                        "ca_id" => $row->ca_id,
                        "user_name" => $row->user_name,
                        "ca_subject" => $row->ca_subject,
                        "ca_date" => date('d M Y', strtotime($row->ca_date)),
                        "ca_total" => $row->ca_total,
                        "ca_total_real" => $row->ca_total_real,
                        "status" => $status,
                        "action" => $aksi,
                        //"ca_end_date" => $get_date_range->end_date,
                        "ca_submit_date" => $row->ca_submit_date != "0000-00-00" ? $row->ca_submit_date : "",
                        "year" => date('Y', strtotime($row->ca_date)),
                        "month" => date('F', strtotime($row->ca_date)),
                        "approver1" => $row->approver1,
                        "approver2" => $row->approver2,
                        "approver3" => $row->approver3,
                        "user_status" => $row->user_status,
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
            "totNotifReq" => $cash_advanceData['total_req'],
            "totNotifReal" => $cash_advanceData['total_real'],
        );
        echo json_encode($json_data);
    }

}
