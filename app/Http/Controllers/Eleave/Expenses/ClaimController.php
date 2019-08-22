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

class ClaimController extends Controller {

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

        return view('Eleave.expenses.cl_index', ['notif' => $link_notif, 'source_id' => $source_id]);
    }

    public function getClaim(Request $request) {
        $urlClaim = 'eleave/claim/index';
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
            "search_date" => $request['columns'][3]['search']['value'],
            "search_subject" => $request['columns'][4]['search']['value'],
            "search_status" => $request['columns'][7]['search']['value'],
        ];

        $claim = ElaHelper::myCurl($urlClaim, $param);
        $claimData = json_decode($claim, true);
        //  var_dump($claim);exit();
        $err = "";
        $result_claim = array();
        $no = $request->post('start');
        if ($claimData['response_code'] == 200) {
            $user_claim = $claimData['data'];
            $object = json_decode(json_encode($user_claim), FALSE);
            foreach ($object as $row) {
                $no++;
                $status = "";
                $aksi = "";

                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->cl_id . "','" . $row->cl_type . "')> &nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                if ($row->cl_draft == 0) {
                    if ($row->cl_status == 1 && $row->cl_approver_id != 0) {
                        if ($row->cl_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for your revision</span>";
                            $aksi .= '<a href="' . url('eleave/claim/' . $row->cl_id . '/edit') . '" class="btn yellow btn-xs" title="Revise"><i class="fa fa-pencil"></i>';
                        } else {
                            if ($row->cl_approver_id == 1) {
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->cl_approver_id == 2) {
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $curr_approver = User::split_name($row->approver3);
                            }
                            $status = "<span class='label label-sm label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                            $aksi .= "<a class='btn red btn-xs reject' id='" . $row->cl_id . "|" . $row->user_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                        }
                    } elseif ($row->cl_status == 2) {
                        $status = "<span class='label label-sm label-success'>Processing Finance</span>";
                    } elseif ($row->cl_status == 3) {
                        $status = "<span class='label label-sm label-primary'>Close</span>";
                        $show = 1;
                    } elseif ($row->cl_status == 10) {
                        if ($row->cl_rejected == 1) {
                            $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span> <i class='fa fa-info-circle tooltips' title='" . $row->cl_rejected_reason . "'></i>";
                        } else {
                            $status = "<span class='label label-sm label-danger'>Deleted</span>";
                        }
                    }
                } else {
                    $status = "<a href='" . url('eleave/claim/' . $row->cl_id . '/draft') . "' class='' title='Edit Draft'>"
                            . "<span class='label label-sm label-info'>Draft</span></a>&nbsp;&nbsp;";
                    $aksi .= "<a class='btn red btn-xs reject' id='" . $row->cl_id . "|" . $row->user_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                }
                $show_tooltip = '<i class="fa fa-info-circle tooltips" title="' . $row->cl_approve_reason . '"></i>';
                $result_claim[] = array(
                    "no" => $no,
                    "cl_id" => $row->cl_id,
                    "cl_type" => ($row->cl_type == 1 ? "expense" : "travel"),
                    "cl_date" => date('d M Y', strtotime($row->cl_date)),
                    "cl_subject" => $row->cl_subject,
                    "cl_bank_slip" => (isset($row->cl_bank_slip) ? "<a href='" . url(env('PUBLIC_PATH') . $row->cl_bank_slip) . "' target='_blank'><center><i class='fa fa-file-image-o'></i></center></a>" : "<center><i class='glyphicon glyphicon-remove'></i></center>"),
                    "cl_total_from" => $row->cl_currency . " " . number_format($row->cl_total_from, 0, ',', '.'),
                    "status" => $status . " " . (!empty($row->cl_approve_reason) ? $show_tooltip : ""),
                    "action" => $aksi
                );
            }
        } else {
            $err = $claimData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $claimData['recordsTotal'],
            "recordsFiltered" => $claimData['recordsFiltered'],
            "data" => $result_claim,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function getClaimNotif(Request $request) {
        $urlClaim = 'eleave/claim/index';
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
            "search_date" => $request['columns'][3]['search']['value'],
            "search_subject" => $request['columns'][4]['search']['value'],
            "search_status" => $request['columns'][7]['search']['value'],
        ];

        $claim = ElaHelper::myCurl($urlClaim, $param);
        $claimData = json_decode($claim, true);
        //  var_dump($claim);exit();
        $err = "";
        $result_claim = array();
        $no = $request->post('start');
        if ($claimData['response_code'] == 200) {
            $user_claim = $claimData['data'];
            $object = json_decode(json_encode($user_claim), FALSE);
            foreach ($object as $row) {
                $no++;
                $status = "";
                $aksi = "";

                $aksi .= "<a href='#' class='btn blue btn-xs' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->cl_id . "','" . $row->cl_type . "')> &nbsp;<i class='fa fa-info'></i>&nbsp;</a>";
                if ($row->cl_draft == 0) {
                    if ($row->cl_status == 1 && $row->cl_approver_id != 0) {
                        if ($row->cl_need_revision == 1) {
                            $status = "<span class='label label-success'>Waiting for your revision</span>";
                            $aksi .= '<a href="' . url('eleave/claim/' . $row->cl_id . '/edit') . '" class="btn yellow btn-xs" title="Revise"><i class="fa fa-pencil"></i>';
                        } else {
                            if ($row->cl_approver_id == 1) {
                                $curr_approver = User::split_name($row->approver1);
                            } elseif ($row->cl_approver_id == 2) {
                                $curr_approver = User::split_name($row->approver2);
                            } else {
                                $curr_approver = User::split_name($row->approver3);
                            }
                            $status = "<span class='label label-sm label-info'>Waiting for " . $curr_approver . "'s approval</span>";
                            $aksi .= "<a class='btn red btn-xs reject' id='" . $row->cl_id . "|" . $row->user_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                        }
                    } elseif ($row->cl_status == 2) {
                        $status = "<span class='label label-sm label-success'>Processing Finance</span>";
                    } elseif ($row->cl_status == 3) {
                        $status = "<span class='label label-sm label-primary'>Close</span>";
                        $show = 1;
                    } elseif ($row->cl_status == 10) {
                        if ($row->cl_rejected == 1) {
                            $status = "<span class='label label-sm label-danger'>Rejected by " . User::split_name($row->rejected_by_name) . "</span> <i class='fa fa-info-circle tooltips' title='" . $row->cl_rejected_reason . "'></i>";
                        } else {
                            $status = "<span class='label label-sm label-danger'>Deleted</span>";
                        }
                    }
                } else {
                    $status = "<a href='" . url('eleave/claim/' . $row->cl_id . '/draft') . "' class='' title='Edit Draft'>"
                            . "<span class='label label-sm label-info'>Draft</span></a>&nbsp;&nbsp;";
                    $aksi .= "<a class='btn red btn-xs reject' id='" . $row->cl_id . "|" . $row->user_id . "' href='#' title='Delete'> <i class='fa fa-trash'></i> </a>";
                }
                $show_tooltip = '<i class="fa fa-info-circle tooltips" title="' . $row->cl_approve_reason . '"></i>';

                $show = 0;
                if ($row->cl_need_revision == 1) {
                    $show = 1;
                }

                if ($show) {
                    $result_claim[] = array(
                        "no" => $no,
                        "cl_id" => $row->cl_id,
                        "cl_type" => ($row->cl_type == 1 ? "expense" : "travel"),
                        "cl_date" => date('d M Y', strtotime($row->cl_date)),
                        "cl_subject" => $row->cl_subject,
                        "cl_bank_slip" => (isset($row->cl_bank_slip) ? "<a href='" . url(env('PUBLIC_PATH') . $row->cl_bank_slip) . "' target='_blank'><center><i class='fa fa-file-image-o'></i></center></a>" : "<center><i class='glyphicon glyphicon-remove'></i></center>"),
                        "cl_total_from" => $row->cl_currency . " " . number_format($row->cl_total_from, 0, ',', '.'),
                        "status" => $status . " " . (!empty($row->cl_approve_reason) ? $show_tooltip : ""),
                        "action" => $aksi
                    );
                }
            }
        } else {
            $err = $claimData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($result_claim),
            "recordsFiltered" => count($result_claim),
            "data" => $result_claim,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function get_data_detail(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlClaim = 'eleave/claim/getClaimDetail';
        $param = [
            'token' => session('token'),
            'id' => $request->id,
            'cl_id' => $request->cl_id,
        ];
        $claim_id = ElaHelper::myCurl($urlClaim, $param);
        $claimList = json_decode($claim_id, true);
        //dd($claim_id);
        $row = array();
        if ($claimList['response_code'] == 200) {
            $data = array();
            foreach ($claimList['data'] as $value) {
                $data[] = array(
                    'cl_id' => $value['cl_id'],
                    'cl_subject' => $value['cl_subject'],
                    'cl_date' => date('d M Y', strtotime($value['cl_date'])),
                    'cl_currency' => $value['cl_currency'],
                    'cl_total_from' => $value['cl_currency'] . " " . number_format($value['cl_total_from'], 0, ',', '.'),
                    'cl_total_to' => $value['cl_total_to'],
                    'cl_sub_total_from' => $value['cl_total_from'],
                    'cl_type' => $value['cl_type'],
                    'cl_file' => (isset($value['cl_file']) ? "<a href='" . url(env('PUBLIC_PATH') . $value['cl_file']) . "' target='_blank'><i class='fa fa-file-image-o'></i></a>" : ""),
                    'cl_remark' => (!empty($value['cl_remark']) ? $value['cl_remark'] : ""),
                    'cl_username' => $value['user_name'],
                    'cl_dept' => $value['department_name'],
                    'cl_branch' => $value['branch_name'],
                    'cl_description' => $value['cl_description'],
                    'cl_amount' => $value['cl_amount'],
                    'cl_date_travel' => $value['cl_date_travel'],
                    'cl_loc_from' => $value['cl_loc_from'],
                    'cl_loc_to' => $value['cl_loc_to'],
                    'cl_reason' => $value['cl_reason'],
                    'cl_distance' => $value['cl_distance'],
                    'cl_transport' => $value['cl_transport'],
                    'cl_mileage' => $value['cl_mileage'],
                    'cl_parking' => $value['cl_parking'],
                    'cl_toll' => $value['cl_toll'],
                    'cl_petrol' => $value['cl_petrol'],
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

    public function add() {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        return view('Eleave.expenses.cl_new');
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlClaim = 'eleave/claim/getClaimId';
        $param = [
            "token" => session('token'),
            "cl_id" => $id,
            "userId" => session('id')
        ];
        $claim_id = ElaHelper::myCurl($urlClaim, $param);
        $claimList = json_decode($claim_id, true);
//        echo "<pre>";
//        var_dump($claimList);
//        echo "</pre>";
//        exit;
        $cl = "";
        if ($claimList['response_code'] == 200) {
            $cl = json_decode(json_encode($claimList['data']), FALSE);
        } else {
            $cl = "";
            $request->session()->flash('message', $claimList['message']);
            $request->session()->flash('alert-type', 'error');
        }
        // dd($claimList['data']);
        return view('Eleave.expenses.cl_edit', ['cl' => $cl]);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $cl_id = $request->post('cl_id');
        $cl_date = $request->post('cl_date');
        $cl_type = $request->post('cl_type');
        $cl_subject = $request->post('subject_name');
        $cl_currency = $request->post('cl_currency');
        $cl_total_from = $request->post('cl_total_from');
        $cl_total_to = $request->post('cl_total_to');
        $cl_remark = $request->post('cl_remark');

        $cl_description = $request->post('cl_description');
        $cl_amount = $request->post('cl_amount');

        $cl_travel_date = $request->post('cl_travel_date');
        $cl_travel_from = $request->post('cl_travel_from');
        $cl_travel_to = $request->post('cl_travel_to');
        $cl_travel_reason = $request->post('cl_travel_reason');
        $cl_travel_distance = $request->post('cl_travel_distance');
        $cl_travel_mileage = $request->post('cl_travel_mileage');
        $cl_travel_transport = $request->post('cl_travel_transport');
        $cl_travel_parking = $request->post('cl_travel_parking');
        $cl_travel_toll = $request->post('cl_travel_toll');
        $cl_travel_petrol = $request->post('cl_travel_petrol');


        $btn_act = $request->post('btnSubmit');

        $data_detail = array();
        if ($cl_type == 1) {
            for ($i = 0; $i < count($cl_description); $i++) {
                $data_detail[] = array(
                    'cl_description' => $cl_description[$i],
                    'cl_amount' => $cl_amount[$i],
                );
            }
        } else {
            for ($i = 0; $i < count($cl_travel_date); $i++) {
                $data_detail[] = array(
                    'cl_travel_date' => $cl_travel_date[$i],
                    'cl_travel_from' => $cl_travel_from[$i],
                    'cl_travel_to' => $cl_travel_to[$i],
                    'cl_travel_reason' => $cl_travel_reason[$i],
                    'cl_travel_distance' => $cl_travel_distance[$i],
                    'cl_travel_transport' => $cl_travel_transport[$i],
                    'cl_travel_mileage' => $cl_travel_mileage[$i],
                    'cl_travel_parking' => $cl_travel_parking[$i],
                    'cl_travel_toll' => $cl_travel_toll[$i],
                    'cl_travel_petrol' => $cl_travel_petrol[$i],
                );
            }
        }

        $urlClaim = 'eleave/claim/save';
        $param = [
            "token" => session('token'),
            "cl_id" => $cl_id,
            "user_id" => session('id'),
            "cl_date" => $cl_date,
            "cl_type" => $cl_type,
            "cl_subject" => $cl_subject,
            "branch_id" => session('branch_id'),
            "cl_currency" => $cl_currency,
            "cl_total_from" => $cl_total_from,
            "cl_total_to" => $cl_total_to,
            "cl_remark" => $cl_remark,
            "cl_draft" => ($btn_act == "btn_draft" ? 1 : 0),
            //  "cl_need_revision" => ($btn_act == "btn_draft" ? 0 : 1),
            "detail" => $data_detail,
        ];
        //     dd($param);
        $claim = ElaHelper::myCurl($urlClaim, $param);
        $claimSave = json_decode($claim, true);
//        echo '<pre>';
//        var_dump($claim);
//        echo '</pre>';
//        exit();
        if ($claimSave['response_code'] == 200) {
            if ($request->hasFile('cl_file')) {

                $id = $claimSave['cl_id'];
                $fileName = $request->file('cl_file')->getClientOriginalName();
                $getFileExt = $request->file('cl_file')->getClientOriginalExtension();
                $destinationPath = base_path('public/upload/claim/' . $id . '/');
                $upload_dir = "upload/claim/" . $id . "/";
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                //cek file exist...
//                $files_old = glob($destinationPath . "cl_file_" . $id . ".*");
//                if ($files_old) {
//                    unlink($files_old);
//                }
//                $request->file('cl_file')->move($destinationPath, "cl_file_" . $id . "." . $getFileExt);
//
//                $cl_file = $upload_dir . "cl_file_" . $id . "." . $getFileExt;
                $request->file('cl_file')->move($destinationPath, $fileName);
                $cl_file = $upload_dir . $fileName;

                $urlUpload = 'eleave/claim/cl_upload';
                $param = [
                    "token" => session('token'),
                    "user_id" => $request->post('employee_id'),
                    "cl_id" => $id,
                    "upload_detail" => $cl_file,
                ];
                $cl_upload = ElaHelper::myCurl($urlUpload, $param);
                $clUpdate = json_decode($cl_upload, true);
            }

            return redirect('eleave/claim/index')
                            ->with(array('message' => $claimSave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/claim/add')
                            ->with(array('message' => $claimSave['message'], 'alert-type' => 'error'));
        }
    }

    public function getLatestCurrency(Request $request) {
        $endpoint = $request->endpoint;
        $access_key = 'd375e0cc29b6ee4827b55b1962857a5a';
        $to = "MYR";
        $date = $request->date;
        $symbol = "EUR,SGD,BRL,AUD,GBP,THB,PHP,IDR,USD";

        // initialize CURL:
        $ch = curl_init('https://data.fixer.io/api/' . $endpoint . '?access_key=' . $access_key . '&base=' . $to . '&symbols=' . $symbol . '&date=' . $date);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // get the JSON data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        $cr = "";
        if ($exchangeRates['success'] == true) {
            $cr = ['status' => true, 'rates' => $exchangeRates['rates']];
        } else {
            // Knights of Cydonia by Muse ke puter tepat di 23:51 PM
            $cr = ['status' => false, 'msg' => '#404 The requested resource does not exist.', 'rates' => ''];
        }

        echo json_encode($cr);
    }

    public function getConvertCurrency(Request $request) {
        $endpoint = $request->endpoint;
        $access_key = 'd375e0cc29b6ee4827b55b1962857a5a';
        $to = "MYR";
        $from = $request->from;
        $amount = $request->amount;
        $date = $request->date;


        $ch = curl_init('https://data.fixer.io/api/' . $endpoint . '?access_key=' . $access_key . '&from=' . $from . '&to=' . $to . '&amount=' . $amount . '&date=' . $date);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

        $conversionResult = json_decode($json, true);

        $cr2 = "";
        if ($conversionResult['success'] == true) {
            $cr2 = ['status' => true, 'result' => $conversionResult['result']];
        } else {
            $cr2 = ['status' => false, 'msg' => 'The requested resource does not exist.', 'result' => ''];
        }
        echo json_encode($cr2);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/logout');
        }
        $id = $request->id;
        $urlClaim = 'eleave/claim/delete';
        $param = [
            "token" => session('token'),
            "cl_id" => $id,
            "user_id" => $request->user_id,
        ];

        $claim_id = ElaHelper::myCurl($urlClaim, $param);
        $claimList = json_decode($claim_id, true);

        $ot = "";
        if ($claimList['response_code'] == 200) {
            $ot = array('status' => true, 'message' => $claimList['message']);
        } else {
            $ot = array('status' => false, 'message' => $claimList['message']);
        }
        echo json_encode($ot);
    }

}
