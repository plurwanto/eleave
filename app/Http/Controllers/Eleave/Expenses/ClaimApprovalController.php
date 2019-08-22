<?php
namespace App\Http\Controllers\Eleave\Expenses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;

class ClaimApprovalController extends Controller {

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

        return view('Eleave.expenses.cl_Approval', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getClaimApproval(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlClaim = 'eleave/claimApproval/index';
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
            "search_subject" => $request['columns'][5]['search']['value'],
            "search_total" => $request['columns'][6]['search']['value'],
            "search_status" => $request['columns'][7]['search']['value'],
            "userId" => session('id'),
        ];
        $claim = ElaHelper::myCurl($urlClaim, $param);
        $claimData = json_decode($claim, true);
        //   var_dump($claim);exit();

        $err = "";
        $result_claim = array();
        $no = $request->post('start');
        if ($claimData['response_code'] == 200) {

            $user_claim = $claimData['data'];
            $object = json_decode(json_encode($user_claim), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->cl_id . "','" . $row->cl_type . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";
                $no++;
                $show = 0;

                if ($row->cl_status == 1) {
                    if ($row->cl_need_revision == 1) {
                        $status = "<span class='label label-success'>Waiting employee revision</span>";
                        $show = 1;
                    } else {
                        $id_approver = 0;
                        if ($row->cl_approver_id == 1) {
                            $id_approver = $row->user_approver1;
                            $curr_approver = User::split_name($row->approver1);
                        } elseif ($row->cl_approver_id == 2) {
                            $id_approver = $row->user_approver2;
                            $curr_approver = User::split_name($row->approver2);
                        } elseif ($row->cl_approver_id == 3) {
                            $id_approver = $row->user_approver3;
                            $curr_approver = User::split_name($row->approver3);
                        } else {
                            $id_approver = 4;
                        }
                        if ($id_approver == session('id')) {
                            $status = "<span class='label label-warning'>Waiting for your approval</span>";
                            $show = 1;
                            //approve
                            $next = 0;
                            $approver_user = 0;
                            if ($row->cl_approver_id == 1 && $row->user_approver2 != 0) {
                                $next = 2;
                                $approver_user = $row->user_approver2;
                                $aksi .= "<a class='btn btn-xs btn-success' onClick=approve_this('" . $row->cl_id . "','" . $row->user_id . "','" . $next . "','" . $approver_user . "') title='Approve' ><i class='fa fa-check'></i></a>";
                            } elseif ($row->cl_approver_id == 2 && $row->user_approver3 != 0) {
                                $next = 3;
                                $approver_user = $row->user_approver3;
                                //approve with reason if approver 1
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->cl_id . "|" . $row->user_id . "|" . $next . "|" . $approver_user . "' title='Approve' ><i class='fa fa-check'></i></a>";
                            } else {
                                $next = 4; //for finance
                                $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->cl_id . "|" . $row->user_id . "|" . $next . "|" . $approver_user . "' title='Approve' ><i class='fa fa-check'></i></a>";
                            }

                            //reject
                            $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->user_id . "','" . $row->cl_id . "') id='" . $row->cl_id . "|" . $row->user_id . "'><i class='fa fa-close'></i></a>";
                            //revisi
                            $aksi .= "<a class='btn yellow-crusta btn-xs' onClick=revisi_this('" . $row->user_id . "','" . $row->cl_id . "')><i class='fa fa-edit'></i></a>";
                        } else {
                            $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                            $show = 1;
                        }
                    }
                } elseif ($row->cl_status == 2) {
                    $status = "<span class='label label-success'>Processing Finance</span>";
                    $show = 1;
                } elseif ($row->cl_status == 3) {
                    $status = "<span class='label label-sm label-primary'>Close</span>";
                    $show = 1;
                } elseif ($row->cl_status == 10 && $row->cl_rejected == 1) {
                    $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span> <i class='fa fa-info-circle tooltips' title='" . $row->cl_rejected_reason . "'></i>";
                    $show = 1;
                }

                $show_tooltip = '<i class="fa fa-info-circle tooltips" title="' . $row->cl_approve_reason . '"></i>';
                if ($show) {
                    $result_claim[] = array(
                        "no" => $no,
                        "cl_id" => $row->cl_id,
                        "cl_type" => ($row->cl_type == 1 ? "expense" : "travel"),
                        "user_name" => User::split_name($row->user_name),
                        "cl_subject" => $row->cl_subject,
                        "cl_date" => date('d M Y', strtotime($row->cl_date)),
                        "cl_total_from" => $row->cl_currency . " " . number_format($row->cl_total_from, 0, ',', '.'),
                        "status" => $status . " " . (!empty($row->cl_approve_reason) ? $show_tooltip : ""),
                        "action" => $aksi,
                        //"cl_end_date" => $get_date_range->end_date,
                        "cl_submit_date" => $row->cl_submit_date != "0000-00-00" ? $row->cl_submit_date : "",
                        "year" => date('Y', strtotime($row->cl_date)),
                        "month" => date('F', strtotime($row->cl_date)),
                        "approver1" => User::split_name($row->approver1),
                        "approver2" => User::split_name($row->approver2),
                        "approver3" => User::split_name($row->approver3),
                    );
                }
            }
        } else {
            $err = $claimData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $claimData['recordsTotal'],
            "recordsFiltered" => $claimData['recordsFiltered'],
            "data" => $result_claim,
        );
        echo json_encode($json_data);
    }

    public function getClaimApprovalNotif(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlClaim = 'eleave/claimApproval/index';
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
        $claim = ElaHelper::myCurl($urlClaim, $param);

        $claimData = json_decode($claim, true);

        $err = "";
        $result_claim = array();
        $no = $request->post('start');
        if ($claimData['response_code'] == 200) {

            $user_claim = $claimData['data'];
            $object = json_decode(json_encode($user_claim), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->cl_id . "','" . $row->cl_type . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";

                $show = 0;
                if ($row->cl_status == 1) {
                    if ($row->cl_need_revision == 1) {
                        $status = "<span class='label label-success'>Waiting employee revision</span>";
                    } else {
                        $id_approver = 0;
                        if ($row->cl_approver_id == 1) {
                            $id_approver = $row->user_approver1;
                            $curr_approver = User::split_name($row->approver1);
                        } elseif ($row->cl_approver_id == 2) {
                            $id_approver = $row->user_approver2;
                            $curr_approver = User::split_name($row->approver2);
                        } elseif ($row->cl_approver_id == 3) {
                            $id_approver = $row->user_approver3;
                            $curr_approver = User::split_name($row->approver3);
                        } else {
                            $id_approver = 4;
                        }
                        if ($id_approver == session('id')) {
                            $status = "<span class='label label-warning'Waiting for your approval</span>";
                            $show = 1;
                            //approve
                            $next = 0;
                            $approver_user = 0;
                            if ($row->cl_approver_id == 1 && $row->user_approver2 != 0) {
                                $next = 2;
                                $approver_user = $row->user_approver2;
                            } elseif ($row->cl_approver_id == 2 && $row->user_approver3 != 0) {
                                $next = 3;
                                $approver_user = $row->user_approver3;
                            } else {
                                $next = 4; //for finance
                            }
                            //approve
                            $aksi .= "<a class='btn btn-xs btn-success approve' id='" . $row->cl_id . "|" . $row->user_id . "|" . $next . "|" . $approver_user . "' title='Approve' ><i class='fa fa-check'></i></a>";
                            //reject
                            $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->user_id . "','" . $row->cl_id . "') id='" . $row->cl_id . "|" . $row->user_id . "'><i class='fa fa-close'></i></a>";
                            //revisi
                            $aksi .= "<a class='btn yellow-crusta btn-xs' onClick=revisi_this('" . $row->user_id . "','" . $row->cl_id . "')><i class='fa fa-edit'></i></a>";
                        } else {
                            $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                            $show = 1;
                        }
                    }
                } elseif ($row->cl_status == 2) {
                    $status = "<span class='label label-success'>Processing Finance</span>";
                    $show = 1;
                } elseif ($row->cl_status == 10 && $row->cl_rejected == 1) {
                    $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span>";
                    $show = 1;
                }


                if ($show == "notif") {
                    $no++;
                    $result_claim[] = array(
                        "no" => $no,
                        "cl_id" => $row->cl_id,
                        "user_name" => User::split_name($row->user_name),
                        "cl_type" => $row->cl_type,
                        "cl_date" => $row->start_date,
                        "cl_end_date" => $row->end_date,
                        "status" => $status,
                        "action" => $aksi,
                        //"cl_end_date" => $get_date_range->end_date,
                        "cl_submit_date" => $row->cl_submit_date != "0000-00-00" ? $row->cl_submit_date : "",
                        "cl_time_in" => $row->cl_time_in,
                        "cl_time_out" => $row->cl_time_out,
                        "cl_location" => $row->cl_location,
                        "cl_activity" => $row->cl_activity,
                        "cl_total_time" => $row->total_day . " day(s)",
                        "year" => date('Y', strtotime($row->cl_date)),
                        "month" => date('F', strtotime($row->cl_date)),
                        "approver1" => $row->approver1,
                        "approver2" => $row->approver2,
                        "approver3" => $row->approver3,
                        "user_status" => $row->user_status,
                    );
                }
            }
        } else {
            $err = $claimData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($result_claim), //$claimData['recordsTotal'],
            "recordsFiltered" => count($result_claim), //$claimData['recordsFiltered'],
            "data" => $result_claim,
        );
        echo json_encode($json_data);
    }

    public function get_data_detail(Request $request) {
        if (!Session::has('token')) {
            return redirect('/logout');
        }

        $urlClaim = 'eleave/claim/getClaimDetail';
        $param = [
            'token' => session('token'),
            'id' => $request->id,
            'cl_id' => $request->cl_id,
        ];
        $claim_id = ElaHelper::myCurl($urlClaim, $param);
        $claimList = json_decode($claim_id, true);

        $row = array();
        if ($claimList['response_code'] == 200) {
            $data = array();
            foreach ($claimList['data'] as $value) {
                $data[] = array(
                    'cl_id' => $value['cl_id'],
                    'cl_subject' => $value['cl_subject'],
                    'cl_date' => $value['cl_date'],
                    'cl_total' => $value['cl_total'],
                    'cl_total_real' => $value['cl_total_real'],
                    'cl_username' => $value['cl_username'],
                    'cl_dept' => $value['cl_dept'],
                    'cl_branch' => $value['cl_branch'],
                    'cl_voucher' => $value['cl_voucher'],
                    'cl_cheque' => $value['cl_cheque'],
                    'cl_voucher_slip' => url(env('PUBLIC_PATH') . $value['cl_voucher_slip']),
                    'cl_bank_slip' => url(env('PUBLIC_PATH') . $value['cl_bank_slip']),
                    'cl_date_detail' => date("j F Y", strtotime($value['cl_date_detail'])),
                    'cl_project' => $value['cl_project'],
                    'cl_detail_project' => $value['cl_detail_project'],
                    'cl_amount' => $value['cl_amount'],
                    'cl_realization' => $value['cl_realization'],
                    'cl_file' => url(env('PUBLIC_PATH') . $value['cl_file']),
                );
            }
            $output = array(
                "data" => $data
            );
        } else {
            $output = $claimList['message'];
        }
        echo json_encode($output);
    }

    public function revise(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlClaim = 'eleave/claimApproval/revise';
        $param = [
            'token' => session('token'),
            'user_id' => $request->user_id,
            'cl_id' => $request->cl_id,
            'cl_approver_id' => 1,
            'cl_need_revision' => 1,
            'cl_revision_reason' => $request->cl_reason,
            //'cl_revision_reason' => $request->cl_revision_reason,
            'cl_revision_from' => session('id'),
            'cl_revision_nama' => session('nama'),
        ];
        $claim_id = ElaHelper::myCurl($urlClaim, $param);
        $claimList = json_decode($claim_id, true);

        $ts = "";
        if ($claimList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $claimList['message']);
        } else {
            $ts = array('status' => false);
        }
        echo json_encode($ts);
    }

    public function approve(Request $request) {
        if (!Session::has('token')) {
            return redirect('/logout');
        }

        $urlClaim = 'eleave/claimApproval/approve';
        $param = [
            'token' => session('token'),
            'next' => $request->next,
            'cl_id' => $request->cl_id,
            'user_id' => $request->user_id,
            'cl_approve_nama' => session('nama'),
            'cl_approver_user' => $request->approver_user, //next user id approver
            'cl_approve_reason' => $request->cl_reason,
        ];
        //dd($param);
        $claim_id = ElaHelper::myCurl($urlClaim, $param);
        $claimList = json_decode($claim_id, true);
//var_dump($claim_id);
        $ts = "";
        if ($claimList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $claimList['message']);
        } else {
            $ts = array('status' => false, 'message' => 'Bad Request');
        }
        echo json_encode($ts);
    }

    public function reject(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlClaim = 'eleave/claimApproval/reject';
        $param = [
            'token' => session('token'),
            'user_id' => $request->user_id,
            'cl_id' => $request->cl_id,
            'cl_rejected_reason' => $request->cl_reason,
            'cl_rejected' => 1,
            'cl_rejected_by' => session('id'),
            'cl_rejected_nama' => session('nama'),
        ];
        $claim_id = ElaHelper::myCurl($urlClaim, $param);
        $claimList = json_decode($claim_id, true);
        $ts = "";
        if ($claimList['response_code'] == 200) {
            $ts = array('status' => true, 'message' => $claimList['message']);
        } else {
            $ts = array('status' => false);
        }
        echo json_encode($ts);
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

        return view('Eleave.expenses.cl_finance_index', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getClFinance(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlClaim = 'eleave/claimApproval/all_request';
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
            "search_subject" => $request['columns'][5]['search']['value'],
            "search_total" => $request['columns'][6]['search']['value'],
            "search_status" => $request['columns'][8]['search']['value'],
            "userId" => session('id'),
        ];
        $claim = ElaHelper::myCurl($urlClaim, $param);
        $claimData = json_decode($claim, true);
        //         var_dump($claim);exit();
        $err = "";
        $result_claim = array();
        $no = $request->post('start');
        if ($claimData['response_code'] == 200) {

            $user_claim = $claimData['data'];
            $object = json_decode(json_encode($user_claim), FALSE);

            foreach ($object as $key => $row) {
                $aksi = "";
                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->cl_id . "','" . $row->cl_type . "')>&nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                $status = "";
                $no++;
                $show = 0;
                if ($row->cl_status == 1) {
                    if ($row->cl_need_revision == 1) {
                        $status = "<span class='label label-success'>Waiting employee revision</span>";
                    } else {
                        $id_approver = 0;
                        if ($row->cl_approver_id == 1) {
                            $id_approver = $row->user_approver1;
                            $curr_approver = User::split_name($row->approver1);
                        } elseif ($row->cl_approver_id == 2) {
                            $id_approver = $row->user_approver2;
                            $curr_approver = User::split_name($row->approver2);
                        } elseif ($row->cl_approver_id == 3) {
                            $id_approver = $row->user_approver3;
                            $curr_approver = User::split_name($row->approver3);
                        } else {
                            $id_approver = 4;
                        }
                        $status = "<span class='label label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                    }
                    $show = 1;
                } elseif ($row->cl_status == 2 && empty($row->cl_bank_slip)) {
                    $status = "<span class='label label-warning'>Waiting your processing</span>";
                    $aksi .= "<a class='btn yellow-crusta btn-xs' title='process' onClick=process_this('" . $row->user_id . "','" . $row->cl_id . "')><i class='fa fa-edit'></i></a>";
                    $aksi .= "<a class='btn red btn-xs reject' onClick=reject_this('" . $row->user_id . "','" . $row->cl_id . "') id='" . $row->cl_id . "|" . $row->user_id . "'><i class='fa fa-close'></i></a>";
                    $show = 1;
                } elseif ($row->cl_status == 3) {
                    $status = "<span class='label label-sm label-primary'>Close</span>";
                    $show = 1;
                } elseif ($row->cl_status == 10) {
                    if ($row->cl_rejected == 1) {
                        $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span> <i class='fa fa-info-circle tooltips' title='" . $row->cl_rejected_reason . "'></i>";
                    } else {
                        $status = "<span class='label label-sm label-danger'>Deleted</span>";
                    }
                    $show = 1;
                }

                $show_tooltip = '<i class="fa fa-info-circle tooltips" title="' . $row->cl_approve_reason . '"></i>';
                if ($show) {
                    $result_claim[] = array(
                        "no" => $no,
                        "cl_id" => $row->cl_id,
                        "cl_type" => ($row->cl_type == 1 ? "expense" : "travel"),
                        "user_name" => User::split_name($row->user_name),
                        "cl_subject" => $row->cl_subject,
                        "cl_date" => date('d M Y', strtotime($row->cl_date)),
                        "cl_total_from" => $row->cl_currency . " " . number_format($row->cl_total_from, 0, ',', '.'),
                        "cl_bank_slip" => (!empty($row->cl_bank_slip) ? "<center><a href='" . url(env('PUBLIC_PATH') . $row->cl_bank_slip) . "' target='_blank'><i class='fa fa-file-image-o'></i></a></center>" : "<center><i class='glyphicon glyphicon-remove'></i></center>"),
                        "status" => $status . " " . (!empty($row->cl_approve_reason) ? $show_tooltip : ""),
                        "action" => $aksi,
                    );
                }
            }
        } else {
            $err = $claimData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $claimData['recordsTotal'],
            "recordsFiltered" => $claimData['recordsFiltered'],
            "data" => $result_claim,
        );
        echo json_encode($json_data);
    }

    public function process_finance(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->cl_id;
        $urlClaim = 'eleave/claimApproval/fa_update_request';
        $param = [
            "token" => session('token'),
            "cl_id" => $id,
            "user_id" => $request->user_id,
            "cl_approve_nama" => session('nama')
        ];
        $claim_id = ElaHelper::myCurl($urlClaim, $param);
        $claimList = json_decode($claim_id, true);
        //var_dump($param);exit();
        $ts = "";
        $bank_slip = "";
        if ($claimList['response_code'] == 200) {
            $cl_id = $claimList['cl_id'];
            if ($request->hasFile('cl_bank_slip')) {
                $id = substr($claimList['cl_id'], -4);
                $fileName = $request->file('cl_bank_slip')->getClientOriginalName();
                $getFileExt = $request->file('cl_bank_slip')->getClientOriginalExtension();
                $destinationPath = base_path('public/upload/claim/' . $id . '/');
                $upload_dir = "upload/claim/" . $id . "/";
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $request->file('cl_bank_slip')->move($destinationPath, "bank_slip_" . $id . "." . $getFileExt);
                $bank_slip = $upload_dir . "bank_slip_" . $id . "." . $getFileExt;
            }

            $urlUpload = 'eleave/claimApproval/fa_upload';
            $param = [
                "token" => session('token'),
                "cl_id" => $cl_id,
                "user_id" => $request->user_id,
                "file_bank_slip" => $bank_slip,
                "cl_approver_user" => session('id'),
            ];

            $fa_upload = ElaHelper::myCurl($urlUpload, $param);
            $faUpdate = json_decode($fa_upload, true);

            $ts = array('status' => true, 'message' => $claimList['message']);
        } else {
            $ts = $claimList['message'];
        }
        echo json_encode($ts);
    }

}
