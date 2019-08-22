<?php
namespace App\Http\Controllers\Eleave\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\ElaHelper;

class DepartmentController extends Controller {

    public function index(Request $request) {
        return view('Eleave.master.dp_index');
    }

    public function getDepartment(Request $request) {
        $urlDepartment = 'eleave/department/index';
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
        ];

        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);
        //dd($departmentData);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($departmentData['response_code'] == 200) {
            $user_department = $departmentData['data'];
            $object = json_decode(json_encode($user_department), FALSE);

            foreach ($object as $row) {
                $no++;
                $aksi = "";

                $aksi .= '<a href="#" onclick="edit_item(' . $row->department_id . ')" class="btn yellow btn-xs" title="Edit"><i class="fa fa-pencil"></i>';
                $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->department_id . "'><i class='fa fa-trash'></i></a>";

                $hasil[] = array("no" => $no,
                    "department_name" => $row->department_name,
                    "action" => $aksi);
            }
        } else {
            $err = $departmentData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $departmentData['recordsTotal'],
            "recordsFiltered" => $departmentData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->post('department_id');
        $dp_name = $request->post('department_name');

        $this->_validate($id, $dp_name);

        $urlDepartment = 'eleave/department/save';
        $param = [
            "token" => session('token'),
            "department_name" => $dp_name,
        ];

        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);
        $dp = "";
        if ($departmentData['response_code'] == 200) {
            $dp = array('status' => true, 'message' => $departmentData['message'], 'alert-type' => 'success');
        } else {
            $dp = array('status' => false, 'message' => $departmentData['message'], 'alert-type' => 'error');
        }
        echo json_encode($dp);
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlDepartment = 'eleave/department/getDepartmentById';
        $param = [
            "token" => session('token'),
            "department_id" => $id,
        ];
        $department_id = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department_id, true);
        if ($departmentData['response_code'] == 200) {
            echo json_encode(array('status' => true, $departmentData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $departmentData['message']));
        }
    }

    public function update(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->post('department_id');
        $dp_name = trim($request->post('department_name'));

        $this->_validate($id, $dp_name);
        
        $urlDepartment = 'eleave/department/update';
        $param = [
            "token" => session('token'),
            "department_id" => $id,
            "department_name" => $dp_name,
        ];
//dd($param);
        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);
        $dp = "";
        if ($departmentData['response_code'] == 200) {
            $dp = array('status' => true, 'message' => $departmentData['message'], 'alert-type' => 'success');
        } else {
            $dp = array('status' => false, 'message' => $departmentData['message'], 'alert-type' => 'error');
        }
        echo json_encode($dp);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlDepartment = 'eleave/department/delete';
        $param = [
            "token" => session('token'),
            "department_id" => $id,
        ];

        $department_id = ElaHelper::myCurl($urlDepartment, $param);
        $departmentList = json_decode($department_id, true);
        $dp = "";
        if ($departmentList['response_code'] == 200) {
            $dp = array('status' => true, 'message' => $departmentList['message']);
        } else {
            $dp = array('status' => false, 'message' => $departmentList['message']);
        }
        echo json_encode($dp);
    }

    private function _validate($id, $dp_name) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $urlDepartment = 'eleave/department/check_existing';
        $param = [
            "department_id" => $id,
            "department_name" => $dp_name,
        ];
        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);

        if ($dp_name == '') {
            $data['inputerror'][] = 'department_name';
            $data['error_string'][] = 'department name is required';
            $data['status'] = FALSE;
        }
        if (trim(strlen($dp_name)) == 1) {
            $data['inputerror'][] = 'department_name';
            $data['error_string'][] = 'dont leave it empty or at least input 2 characters.';
            $data['status'] = FALSE;
        }

        if ($departmentData['response'] == FALSE) {
            $data['inputerror'][] = 'department_name';
            $data['error_string'][] = 'There are already room with the same name.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

//    public function checkExisting(Request $request) {
//        $dp_id = $request->post('dp_id');
//        $dp_name = $request->post('department_name');
//
//        $urlDepartment = 'eleave/department/check_existing';
//        $param = [
//            "department_id" => $dp_id,
//            "department_name" => $dp_name,
//        ];
//        $department = ElaHelper::myCurl($urlDepartment, $param);
//        $departmentData = json_decode($department, true);
//        $response = ($departmentData['response'] == true ? $response = true : $response = false);
//        echo json_encode($response);
//    }
}
