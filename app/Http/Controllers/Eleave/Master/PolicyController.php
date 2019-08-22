<?php
namespace App\Http\Controllers\Eleave\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\ElaHelper;

class PolicyController extends Controller {

    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlBranch = 'eleave/policy/getAllBranch';
        $param = [
            "token" => session('token'),
        ];
        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);
        //dd($branchData['data']);
        $list_branch = "";
        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = json_decode($branchData['message']);
        }
        return view('Eleave.master.pol_index', array('branch' => $list_branch));
    }

    public function getPolicy(Request $request) {
        $urlPolicy = 'eleave/policy/index';
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
        ];

        $policy = ElaHelper::myCurl($urlPolicy, $param);
        $policyData = json_decode($policy, true);
        //dd($policyData);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($policyData['response_code'] == 200) {
            $user_policy = $policyData['data'];
            $object = json_decode(json_encode($user_policy), FALSE);

            foreach ($object as $row) {
                $no++;
                $aksi = "";

                $aksi .= '<a href="#" onclick="edit_item(' . $row->pol_id . ')" class="btn yellow btn-xs" title="Edit"><i class="fa fa-pencil"></i>';
                $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->pol_id . "'><i class='fa fa-trash'></i></a>";

                $hasil[] = array("no" => $no,
                    "branch_name" => $row->branch_name,
                    "pol_attendance" => (!empty($row->pol_attendance) ? "<a href='" . url(env('PUBLIC_PATH') . $row->pol_attendance) . "' target='_blank'><center><i class='fa fa-file-image-o'></i></center></a>" : "<center><i class='glyphicon glyphicon-remove'></i></center>"),
                    "pol_leave" => (!empty($row->pol_leave) ? "<a href='" . url(env('PUBLIC_PATH') . $row->pol_leave) . "' target='_blank'><center><i class='fa fa-file-image-o'></i></center></a>" : "<center><i class='glyphicon glyphicon-remove'></i></center>"),
                    "pol_workplace" => (!empty($row->pol_workplace) ? "<a href='" . url(env('PUBLIC_PATH') . $row->pol_workplace) . "' target='_blank'><center><i class='fa fa-file-image-o'></i></center></a>" : "<center><i class='glyphicon glyphicon-remove'></i></center>"),
                    "pl_last_update" => $row->pl_last_update,
                    "action" => $aksi);
            }
        } else {
            $err = $policyData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $policyData['recordsTotal'],
            "recordsFiltered" => $policyData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->post('policy_id');
        $branch_id = $request->post('branch');
        $pol_att = $request->file('pol_att');
        $pol_lv = $request->file('pol_lv');
        $pol_wp = $request->file('pol_wp');

        $this->_validate($id, $branch_id, $pol_att, $pol_lv, $pol_wp);
        $file_att = "";
        $file_lv = "";
        $file_wp = "";

        if ($request->hasFile('pol_att') || $request->hasFile('pol_lv') || $request->hasFile('pol_wp')) {

            $destinationPath = base_path('public/upload/policy/');
            $upload_dir = "upload/policy/";
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if (!empty($pol_att)) {
                $fileName1 = $pol_att->getClientOriginalName();
                $pol_att->move($destinationPath, $fileName1);
                $file_att = $upload_dir . $fileName1;
            }
            if (!empty($pol_lv)) {
                $fileName2 = $pol_lv->getClientOriginalName();
                $pol_lv->move($destinationPath, $fileName2);
                $file_lv = $upload_dir . $fileName2;
            }
            if (!empty($pol_wp)) {
                $fileName3 = $pol_wp->getClientOriginalName();
                $pol_wp->move($destinationPath, $fileName3);
                $file_wp = $upload_dir . $fileName3;
            }
        }

        $urlPolicy = 'eleave/policy/save';
        $param = [
            "token" => session('token'),
            "pol_id" => $id,
            "branch_id" => $branch_id,
            "pol_att" => $file_att,
            "pol_lv" => $file_lv,
            "pol_wp" => $file_wp,
            "user_update" => session('id'),
        ];

        $policy = ElaHelper::myCurl($urlPolicy, $param);
        $policyData = json_decode($policy, true);
        $ro = "";
        if ($policyData['response_code'] == 200) {
            $ro = array('status' => TRUE, 'message' => $policyData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => FALSE, 'message' => $policyData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlPolicy = 'eleave/policy/getPolicyById';
        $param = [
            "token" => session('token'),
            "policy_id" => $id,
        ];
        $policy_id = ElaHelper::myCurl($urlPolicy, $param);
        $policyData = json_decode($policy_id, true);
        
        $urlLog = 'eleave/log/getTransLogByType';
        $param_log = [
            "token" => session('token'),
            "user_id" => "",
            "modul" => "Policy",
            "from" => "",
            "to" => "",
            "branch_id" => $policyData['data']['branch_id'],
        ];
        $log_id = ElaHelper::myCurl($urlLog, $param_log);
        $logData = json_decode($log_id, true);

        if ($policyData['response_code'] == 200) {
            $arr_data = array(
                "pol_id" => $policyData['data']['pol_id'],
                "branch_id" => $policyData['data']['branch_id'],
                "pol_att" => (!empty($policyData['data']['pol_attendance']) ? "<a href='" . url(env('PUBLIC_PATH') . $policyData['data']['pol_attendance']) . "' target='_blank'><i class='fa fa-file-image-o'></i></a>" : ""),
                "pol_lv" => (!empty($policyData['data']['pol_leave']) ? "<a href='" . url(env('PUBLIC_PATH') . $policyData['data']['pol_leave']) . "' target='_blank'><i class='fa fa-file-image-o'></i></a>" : ""),
                "pol_wp" => (!empty($policyData['data']['pol_workplace']) ? "<a href='" . url(env('PUBLIC_PATH') . $policyData['data']['pol_workplace']) . "' target='_blank'><i class='fa fa-file-image-o'></i></a>" : ""),
            );

           //   var_dump($logData['data']);

            echo json_encode(array('status' => true, 'data' => $arr_data, 'result_log' => $logData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $policyData['message']));
        }
    }

    public function update(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        
        $id = $request->post('policy_id');
        $branch_id = $request->post('branch');
        $pol_att = $request->file('pol_att');
        $pol_lv = $request->file('pol_lv');
        $pol_wp = $request->file('pol_wp');

        $this->_validate($id, $branch_id, $pol_att, $pol_lv, $pol_wp);
        $file_att = "";
        $file_lv = "";
        $file_wp = "";

        if ($request->hasFile('pol_att') || $request->hasFile('pol_lv') || $request->hasFile('pol_wp')) {

            $destinationPath = base_path('public/upload/policy/');
            $upload_dir = "upload/policy/";
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if (!empty($pol_att)) {
                $fileName1 = $pol_att->getClientOriginalName();
                $pol_att->move($destinationPath, $fileName1);
                $file_att = $upload_dir . $fileName1;
            }
            if (!empty($pol_lv)) {
                $fileName2 = $pol_lv->getClientOriginalName();
                $pol_lv->move($destinationPath, $fileName2);
                $file_lv = $upload_dir . $fileName2;
            }
            if (!empty($pol_wp)) {
                $fileName3 = $pol_wp->getClientOriginalName();
                $pol_wp->move($destinationPath, $fileName3);
                $file_wp = $upload_dir . $fileName3;
            }
        }

        $urlPolicy = 'eleave/policy/update';
        $param = [
            "token" => session('token'),
            "pol_id" => $id,
            "branch_id" => $branch_id,
            "pol_att" => $file_att,
            "pol_lv" => $file_lv,
            "pol_wp" => $file_wp,
            "user_update" => session('id'),
        ];
//dd($param);
        $policy = ElaHelper::myCurl($urlPolicy, $param);
        $policyData = json_decode($policy, true);
        $ro = "";
        if ($policyData['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $policyData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => false, 'message' => $policyData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlPolicy = 'eleave/policy/delete';
        $param = [
            "token" => session('token'),
            "policy_id" => $id,
            "user_update" => session('id'),
        ];

        $policy_id = ElaHelper::myCurl($urlPolicy, $param);
        $policyList = json_decode($policy_id, true);
        $ro = "";
        if ($policyList['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $policyList['message']);
        } else {
            $ro = array('status' => false, 'message' => $policyList['message']);
        }
        echo json_encode($ro);
    }

    private function _validate($id, $branch_id, $pol_att, $pol_lv, $pol_wp) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $urlPolicy = 'eleave/policy/check_existing';
        $param = [
            "policy_id" => $id,
            "branch_id" => $branch_id,
        ];
        $policy = ElaHelper::myCurl($urlPolicy, $param);
        $policyData = json_decode($policy, true);

        $allowed = array('pdf');
        $maxsize = 2097152;
        if (!empty($pol_att)) {
            $filename = $pol_att->getClientOriginalName();
            $file_size1 = $pol_att->getSize();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!empty($filename) && !in_array($ext, $allowed)) {
                $data['inputerror'][] = 'pol_att';
                $data['error_string'][] = 'File type not allowed';
                $data['status'] = FALSE;
            }
            if (!empty($filename) && $file_size1 >= $maxsize) {
                $data['inputerror'][] = 'pol_att';
                $data['error_string'][] = 'File must be less than 2 mb.';
                $data['status'] = FALSE;
            }
        }
        if (!empty($pol_lv)) {
            $filename2 = $pol_lv->getClientOriginalName();
            $file_size2 = $pol_lv->getSize();
            $ext2 = pathinfo($filename2, PATHINFO_EXTENSION);
            if (!empty($filename2) && !in_array($ext2, $allowed)) {
                $data['inputerror'][] = 'pol_lv';
                $data['error_string'][] = 'File type not allowed';
                $data['status'] = FALSE;
            }
            if (!empty($filename2) && $file_size2 >= $maxsize) {
                $data['inputerror'][] = 'pol_lv';
                $data['error_string'][] = 'File must be less than 2 mb.';
                $data['status'] = FALSE;
            }
        }
        if (!empty($pol_wp)) {
            $filename3 = $pol_wp->getClientOriginalName();
            $file_size3 = $pol_wp->getSize();
            $ext3 = pathinfo($filename3, PATHINFO_EXTENSION);
            if (!empty($filename3) && !in_array($ext3, $allowed)) {
                $data['inputerror'][] = 'pol_wp';
                $data['error_string'][] = 'File type not allowed';
                $data['status'] = FALSE;
            }
            if (!empty($filename) && $file_size3 >= $maxsize) {
                $data['inputerror'][] = 'pol_wp';
                $data['error_string'][] = 'File must be less than 2 mb.';
                $data['status'] = FALSE;
            }
        }

        if ($branch_id == '') {
            $data['inputerror'][] = 'branch';
            $data['error_string'][] = 'branch is required';
            $data['status'] = FALSE;
        }
        if ($policyData['response'] == FALSE) {
            $data['inputerror'][] = 'branch';
            $data['error_string'][] = 'Already branch with the same name.';
            $data['status'] = FALSE;
        }
//        if (empty($pol_att) && empty($pol_lv) && empty($pol_wp)) {
//            $data['inputerror'][] = 'pol_att';
//            $data['error_string'][] = 'minimal 1 file is required';
//            $data['status'] = FALSE;
//        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}
