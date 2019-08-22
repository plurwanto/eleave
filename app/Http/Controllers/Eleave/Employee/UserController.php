<?php
namespace App\Http\Controllers\Eleave\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\ElaHelper;
use Excel;

class UserController extends Controller {

    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if (session('is_hr') == 0) {
            $urlBranch = 'eleave/room/getAllBranch';
            $param = [
                "token" => session('token'),
            ];
        } else {
            $urlBranch = 'eleave/user/branchId';
            $param = [
                "token" => session('token'),
                "branch_id" => session('branch_id'),
            ];
        }

        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);
        $list_branch = "";
        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = "";
        }

        $urlDepartment = 'eleave/user/department';
        $param = [
            "token" => session('token'),
        ];
        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);

        $list_department = "";
        if ($departmentData['response_code'] == 200) {
            $list_department = json_decode(json_encode($departmentData['data']), TRUE);
        } else {
            $list_department = "";
        }

        $urlLastContract = 'eleave/user/lastcontract';
        $param = [
            "token" => session('token'),
        ];
        $userlastcontract = ElaHelper::myCurl($urlLastContract, $param);
        $userlastcontractData = json_decode($userlastcontract, true);
        $list_lastcontract = "";
        if ($userlastcontractData['response_code'] == 200) {
            $list_lastcontract = json_decode(json_encode($userlastcontractData['data']), TRUE);
        } else {
            $list_lastcontract = "";
//            $arr = array('message' => $userlastcontractData['message'], 'alert-type' => 'error');
//            echo json_encode($arr);
        }

        return view('Eleave.employee.user_index', array('branch' => $list_branch, 'department' => $list_department, 'last_contract' => $list_lastcontract));
    }

    public function getEmployee(Request $request) {
        $urlUser = 'eleave/user/index';
        $param = [
            "token" => session('token'),
            "is_hr" => session('is_hr'),
            "branch_id" => session('branch_id'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][1]['search']['value'],
            "search_status" => $request['columns'][2]['search']['value'],
            "search_email" => $request['columns'][5]['search']['value'],
            "search_gender" => $request['columns'][6]['search']['value'],
            "search_type" => $request['columns'][7]['search']['value'],
            "search_join" => $request['columns'][8]['search']['value'],
            "search_contract_date" => $request['columns'][9]['search']['value'],
            "search_active_until" => $request['columns'][10]['search']['value'],
            "search_ref" => $request['columns'][11]['search']['value'],
            "search_finger" => $request['columns'][12]['search']['value'],
            "search_branch" => $request['columns'][13]['search']['value'],
            "search_department" => $request['columns'][14]['search']['value'],
            "search_position" => $request['columns'][15]['search']['value'],
            "search_dob" => $request['columns'][16]['search']['value'],
            "search_approver" => $request['columns'][17]['search']['value'],
            "search_hr" => $request['columns'][18]['search']['value'],
            "search_ap1" => $request['columns'][19]['search']['value'],
            "search_ap2" => $request['columns'][20]['search']['value'],
            "search_ap3" => $request['columns'][21]['search']['value'],
            "search_address" => $request['columns'][21]['search']['value'],
            "search_ap3" => $request['columns'][22]['search']['value'],
        ];

        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);
        //dd($userData);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($userData['response_code'] == 200) {
            $user_user = $userData['data'];
            $object = json_decode(json_encode($user_user), FALSE);

            foreach ($object as $row) {
                $no++;
                $aksi = "";
                $aksi .= '<a href="' . url('eleave/user/' . $row->user_id . '/edit') . '" class="btn btn-xs yellow" title="Revise"><i class="fa fa-pencil"></i>';
                $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->user_id . "'><i class='fa fa-trash'></i></a>";
                $aksi .= '<a href="' . url('eleave/leave/' . $row->user_id . '/team_leave_show') . '" class="btn btn-xs blue btn-leave" title="Leave" style="margin-top: 5px;" target="_blank"><i class="fa fa-calendar-times-o">Leave</i>';

                $user_active_until = "";
                if ($row->user_active_until != "0000-00-00") {
                    if ($row->user_type == "Permanent") {
                        $user_active_until = "";
                    } else {
                        $user_active_until = date('d M Y', strtotime($row->user_active_until));
                    }
                }

                $hasil[] = array("no" => $no,
                    "user_name" => $row->user_name,
                    "user_nik" => $row->user_nik,
                    "user_finger_print_id" => $row->user_finger_print_id,
                    "user_email" => $row->user_email,
                    "branch_name" => $row->branch_name,
                    "department_name" => $row->department_name,
                    "user_dob" => $row->user_dob != "0000-00-00" ? date('d M Y', strtotime($row->user_dob)) : "",
                    "user_gender" => $row->user_gender,
                    "user_position" => $row->user_position,
                    "user_type" => $row->user_type,
                    "user_join_date" => $row->user_join_date != "0000-00-00" ? date('d M Y', strtotime($row->user_join_date)) : "",
                    "user_last_contract_start_date" => $row->user_last_contract_start_date != "0000-00-00" ? date('d M Y', strtotime($row->user_last_contract_start_date)) : "",
                    "user_active_until" => $user_active_until,
                    "user_address" => $row->user_address,
                    "user_phone" => $row->user_phone,
                    "user_photo" => url(env('PUBLIC_PATH') . $row->user_photo),
                    "user_approver1" => $row->app1,
                    "user_approver2" => $row->app2,
                    "user_approver3" => $row->app3,
                    "active" => $row->user_status,
                    "hr" => ($row->is_hr == 1 ? 'Yes' : 'No'), //$hr,
                    "approver" => ($row->is_approver == 1 ? 'Yes' : 'No'), //$approver,
                    "action" => $aksi);
            }
//            $data['last_contract'] = $this->muser->get_last_contract();
//            $data['branch'] = $this->muser->get_branch();
        } else {
            $err = $userData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $userData['recordsTotal'],
            "recordsFiltered" => $userData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function add(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        if (session('level_id') == 8 || session('is_admin') == 1) {
            $urlBranch = 'eleave/room/getAllBranch';
            $param = [
                "token" => session('token'),
            ];
        } else {
            $urlBranch = 'eleave/user/branchId';
            $param = [
                "token" => session('token'),
                "branch_id" => session('branch_id'),
            ];
        }
        //$err = "";
        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);
        $list_branch = "";
        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = "";
        }

        $urlDepartment = 'eleave/user/department';
        $param = [
            "token" => session('token'),
        ];
        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);

        $list_department = "";
        if ($departmentData['response_code'] == 200) {
            $list_department = json_decode(json_encode($departmentData['data']), TRUE);
        } else {
            $list_department = "";
        }

        $urlApprover = 'eleave/user/approver';
        $param = [
            "token" => session('token'),
        ];
        $approver = ElaHelper::myCurl($urlApprover, $param);
        $approverData = json_decode($approver, true);
        //dd($approverData);
        $list_approver = "";
        if ($approverData['response_code'] == 200) {
            // Sort multidimension array by key name
            usort($approverData['data'], function($a, $b) {
                return strcmp($a["user_name"], $b["user_name"]);
            });

            $list_approver = $approverData['data'];
        } else {
            $list_approver = "";
        }

        $urlLevel = 'eleave/user/userlevel';
        $param = [
            "token" => session('token'),
        ];
        $userlevel = ElaHelper::myCurl($urlLevel, $param);
        $userlevelData = json_decode($userlevel, true);
        $list_userlevel = "";
        if ($userlevelData['response_code'] == 200) {
            $list_userlevel = json_decode(json_encode($userlevelData['data']), TRUE);
        } else {
            $list_userlevel = "";
            $request->session()->flash('message', $userlevelData['message']);
            $request->session()->flash('alert-type', 'warning');
        }

        $type = $request->has('type') ? $request->type : '';
        $reqId = $request->has('reqId') ? $request->reqId : '';

        $params = [
            'branch' => $list_branch,
            'department' => $list_department,
            'user' => $list_approver,
            'user_level' => $list_userlevel,
            'type' => $type,
            'reqId' => $reqId
        ];

        return view('Eleave.employee.user_new', $params);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $role = $request->post('level_id');

        if ($role == '4') {
            $is_hr = '1';
            $is_ga = '0';
        } elseif ($role == '5') {
            $is_hr = '0';
            $is_ga = '1';
        } else {
            $is_hr = '';
            $is_ga = '';
        }

        //$this->_validate($request->post('user_id'), $request->post('user_name'), $request->post('user_nik'), $request->post('user_finger_print_id'), $request->post('user_email'), $request->post('branch_id'), $request->post('dept_id'), $request->post('user_position'), $request->post('user_dob'), $request->post('user_gender'), $request->post('user_type'), $request->post('user_join_date'), $request->post('user_last_contract_start_date'), $request->post('user_active_until'), $request->post('user_address'), $request->post('user_phone'), $request->post('user_approver1'), $request->post('user_approver2'), $request->post('user_approver3'));
        // $this->_validate($request->all());
        $urlUser = 'eleave/user/save';
        $param = [
            'token' => session('token'),
            'user_id' => $request->post('user_id'),
            'user_name' => $request->post('user_name'),
            'user_nik' => $request->post('user_nik'),
            'user_finger_print_id' => $request->post('user_finger_print_id'),
            'user_email' => $request->post('user_email'),
            'branch_id' => $request->post('branch_id'),
            'dept_id' => $request->post('dept_id'),
            'user_position' => $request->post('user_position'),
            'user_dob' => $request->post('user_dob'),
            'user_gender' => $request->post('user_gender'),
            'user_type' => $request->post('user_type'),
            'user_join_date' => $request->post('user_join_date'),
            'user_last_contract_start_date' => $request->post('user_last_contract_start_date'),
            'user_active_until' => $request->post('user_active_until'),
            'user_address' => $request->post('user_address'),
            'user_phone' => $request->post('user_phone'),
            'user_approver1' => $request->post('user_approver1'),
            'user_approver2' => $request->post('user_approver2'),
            'user_approver3' => $request->post('user_approver3'),
            'user_status' => $request->post('user_status'),
            'is_hr' => $is_hr,
            'is_ga' => $is_ga,
            'is_approver' => $request->post('optapprove'),
            'level_id' => $role,
            'is_app' => $request->post('chkApp'),
            'remark' => $request->has('remark') ? $request->post('remark') : NULL,
            'resign_date' => $request->has('resign_date') ? $request->post('resign_date') : NULL,
        ];
        //dd($param);
        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);

        if ($userData['response_code'] == 200) {
            if ($request->hasFile('user_photo')) {
                $user_id = $userData['user_id'];
                $fileName = $request->file('user_photo')->getClientOriginalName();
                $upload_dir = 'upload/user/' . $user_id . '/';

                $destinationPath = public_path($upload_dir);

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $request->file('user_photo')->move($destinationPath, $fileName);
                $file = $upload_dir . $fileName;
                $urlUpload = 'eleave/user/changeAvatar';
                $param = [
                    "token" => session('token'),
                    "user_id" => $user_id,
                    "user_photo" => $file
                ];
                $user = ElaHelper::myCurl($urlUpload, $param);
                $userUpdate = json_decode($user, true);
            }

            return redirect('eleave/user/index')
                            ->with(array('message' => $userData['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/user/index')
                            ->with(array('message' => $userData['message'], 'alert-type' => 'error'));
        }
    }

    // private function _validate($id, $field1, $field1, $field1, $field1, $field1, $field1, $field1, $field1, $field1, $field1, $field1, $field1) {
    private function _validate($request) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
//
//        $urlUser = 'eleave/user/check_existing';
//        $param = [
//            "user_id" => $request['user_id'],
//            "user_nik" => $request['user_nik'],
//            "user_email" => $request['user_email'],
//        ];
//        $user = ElaHelper::myCurl($urlUser, $param);
//        $userData = json_decode($user, true);

        if ($request['user_name'] == '') {
            $data['inputerror'][] = 'user_name';
            $data['error_string'][] = 'name is required';
            $data['status'] = FALSE;
        }

//        if ($userData['response'] == FALSE) {
//            $data['inputerror'][] = 'room_name';
//            $data['error_string'][] = 'There are already room with the same name.';
//            $data['status'] = FALSE;
//        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlUser = 'eleave/user/getUserId';
        $param = [
            "token" => session('token'),
            "user_id" => $id,
        ];
        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);

        if ($userData['response_code'] == 200) {
            $list_user = json_decode(json_encode($userData['data']), FALSE);
        } else {
            $request->session()->flash('message', $userData['message']);
            $request->session()->flash('alert-type', 'warning');
        }

        if (session('level_id') == 8 || session('level_id') == 2) {
            $urlBranch = 'eleave/room/getAllBranch';
            $param = [
                "token" => session('token'),
            ];
        } else {
            $urlBranch = 'eleave/user/branchId';
            $param = [
                "token" => session('token'),
                "branch_id" => session('branch_id'),
            ];
        }
        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);
        $list_branch = "";
        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = "";
        }

        $urlDepartment = 'eleave/user/department';
        $param = [
            "token" => session('token'),
        ];
        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);

        $list_department = "";
        if ($departmentData['response_code'] == 200) {
            $list_department = json_decode(json_encode($departmentData['data']), TRUE);
        } else {
            $list_department = "";
        }

        $urlApprover = 'eleave/user/approver';
        $param = [
            "token" => session('token'),
        ];
        $approver = ElaHelper::myCurl($urlApprover, $param);
        $approverData = json_decode($approver, true);
        //dd($approverData);
        $list_approver = "";
        if ($approverData['response_code'] == 200) {
            $list_approver = json_decode(json_encode($approverData['data']), FALSE);
        } else {
            $list_approver = "";
        }

        $urlLevel = 'eleave/user/userlevel';
        $param = [
            "token" => session('token'),
        ];
        $userlevel = ElaHelper::myCurl($urlLevel, $param);
        $userlevelData = json_decode($userlevel, true);
        $list_userlevel = "";
        if ($userlevelData['response_code'] == 200) {
            $list_userlevel = json_decode(json_encode($userlevelData['data']), TRUE);
        } else {
            $list_userlevel = "";
        }
        return view('Eleave.employee.user_edit', array('branch' => $list_branch, 'department' => $list_department, 'user' => $list_approver, 'user_level' => $list_userlevel, 'user_list' => $list_user));
    }

    public function update(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->post('user_id');
        $dp_name = trim($request->post('user_name'));

        $urlUser = 'eleave/user/update';
        $param = [
            "token" => session('token'),
            "user_id" => $id,
            "user_name" => $dp_name,
        ];
//dd($param);
        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);
        $dp = "";
        if ($userData['response_code'] == 200) {
            $dp = array('status' => true, 'message' => $userData['message'], 'alert-type' => 'success');
        } else {
            $dp = array('status' => false, 'message' => $userData['message'], 'alert-type' => 'error');
        }
        echo json_encode($dp);
    }

    public function checkExistingNik(Request $request) {

        $urlUser = 'eleave/user/check_existing_nik';
        $param = [
            "user_id" => $request->post('user_id'),
            "user_nik" => $request->post('user_nik'),
        ];
        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);
        $response = ($userData['response'] == true ? $response = true : $response = false);
        echo json_encode($response);
    }

    public function checkExistingMail(Request $request) {

        $urlUser = 'eleave/user/check_existing_mail';
        $param = [
            "user_id" => $request->post('user_id'),
            "user_email" => $request->post('user_email'),
        ];
        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);
        $response = ($userData['response'] == true ? $response = true : $response = false);
        echo json_encode($response);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlUser = 'eleave/user/delete';
        $param = [
            "token" => session('token'),
            "user_id" => $id,
        ];

        $user_id = ElaHelper::myCurl($urlUser, $param);
        $userList = json_decode($user_id, true);

        if ($userList['response_code'] == 200) {
            $dp = array('status' => true, 'message' => $userList['message']);
        } else {
            $dp = array('status' => false, 'message' => $userList['message']);
        }
        echo json_encode($dp);
    }

    public function excel(Request $request) {
        //dd($request->all());
        $modul = $request->get('slt_module');
        $branch = $request->get('slt_branch');
        $year = $request->get('slt_year');
        $month = $request->get('slt_month');
        $employee_name = $request->get('employee_name');

        $param = [
            "token" => session('token'),
            "is_hr" => session('is_hr'),
            "branch_id" => $branch,
            "year" => $year,
            "month" => $month,
            "employee_name" => $employee_name
        ];

        if ($modul == 1) {
            $urlUser = 'eleave/user/getToExcel';
            $user = ElaHelper::myCurl($urlUser, $param);
            $userData = json_decode($user, true);
            if ($userData['response_code'] == 200) {
                $user_excel = $userData['data'];

                Excel::create('excel_employee', function($excel) use ($user_excel) {
                    $excel->sheet('Excel sheet', function($sheet) use ($user_excel) {
                        $sheet->loadView('Eleave.export_excel')->mergeCells('A1:V1')->with(array('title' => 'Employee', 'data' => $user_excel));
                    });
                })->download('xlsx');
            } else {
                $err = $userData['message'];
            }
        } elseif ($modul == 2) {
            $urlUser = 'eleave/user/getLeaveBalance';
            $user = ElaHelper::myCurl($urlUser, $param);
            $userData = json_decode($user, true);
            if ($userData['response_code'] == 200) {
                $user_excel = $userData['data'];
                return view('Eleave.excel_leave_balance')->with(array('title' => 'E-LEAVE - Leave Balance', 'data' => $user_excel));
            } else {
                $err = $userData['message'];
            }
        } elseif ($modul == 3) {
            $urlAttendance = 'eleave/attendance/getToExcel';
            $attendance = ElaHelper::myCurl($urlAttendance, $param);
            $attendanceData = json_decode($attendance, true);
            if ($attendanceData['response_code'] == 200) {
                $attendance_excel = $attendanceData['data'];
                return view('Eleave.excel_attendance')->with(array('title' => 'Attendance', 'hasil' => $attendance_excel));
            } else {
                $err = $attendanceData['message'];
            }
        } elseif ($modul == 4) {
            $urlUser = 'eleave/leave/getLeaveSummary';
            $user = ElaHelper::myCurl($urlUser, $param);
            $userData = json_decode($user, true);
            if ($userData['response_code'] == 200) {
                $user_excel = $userData['data'];
                return view('Eleave.excel_employee_leave')->with(array('title' => 'Employee Leave Summary', 'hasil' => $user_excel));
            } else {
                $err = $userData['message'];
            }
        } elseif ($modul == 5) {
            $urlUser = 'eleave/timesheet/getTimesheetSummary';
            $user = ElaHelper::myCurl($urlUser, $param);
            $userData = json_decode($user, true);
            if ($userData['response_code'] == 200) {
                $user_excel = $userData['data'];
                return view('Eleave.excel_employee_timesheet')->with(array('title' => 'Employee Timesheet Summary', 'hasil' => $user_excel));
            } else {
                $err = $userData['message'];
            }
        } elseif ($modul == 6) {
            $urlUser = 'eleave/overtime/getOvertimeSummary';
            $user = ElaHelper::myCurl($urlUser, $param);
            $userData = json_decode($user, true);
            if ($userData['response_code'] == 200) {
                $user_excel = $userData['data'];
                return view('Eleave.excel_employee_overtime')->with(array('title' => 'Employee Overtime Summary', 'hasil' => $user_excel));
            } else {
                $err = $userData['message'];
            }
        }
    }

    public function team(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if (session('is_hr') == 0) {
            $urlBranch = 'eleave/room/getAllBranch';
            $param = [
                "token" => session('token'),
            ];
        } else {
            $urlBranch = 'eleave/user/branchId';
            $param = [
                "token" => session('token'),
                "branch_id" => session('branch_id'),
            ];
        }

        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);
        $list_branch = "";
        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = "";
        }

        $urlDepartment = 'eleave/user/department';
        $param = [
            "token" => session('token'),
        ];
        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);

        $list_department = "";
        if ($departmentData['response_code'] == 200) {
            $list_department = json_decode(json_encode($departmentData['data']), TRUE);
        } else {
            $list_department = "";
        }

        return view('Eleave.employee.user_team', array('branch' => $list_branch, 'department' => $list_department));
    }

    public function getTeam(Request $request) {
        $urlUser = 'eleave/user/getUserTeam';
        $param = [
            "token" => session('token'),
            "branch_id" => session('branch_id'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][2]['search']['value'],
            "search_type" => $request['columns'][4]['search']['value'],
            "search_ref" => $request['columns'][5]['search']['value'],
            "search_finger" => $request['columns'][6]['search']['value'],
            "search_email" => $request['columns'][7]['search']['value'],
            "search_branch" => $request['columns'][8]['search']['value'],
            "search_department" => $request['columns'][9]['search']['value'],
            "search_position" => $request['columns'][10]['search']['value'],
            "search_dob" => $request['columns'][11]['search']['value'],
            "search_gender" => $request['columns'][12]['search']['value'],
            "search_join" => $request['columns'][13]['search']['value'],
            "search_contract_date" => $request['columns'][14]['search']['value'],
            "search_active_until" => $request['columns'][15]['search']['value'],
            "search_address" => $request['columns'][16]['search']['value'],
            "search_phone" => $request['columns'][17]['search']['value'],
            "search_ap1" => $request['columns'][18]['search']['value'],
            "search_ap2" => $request['columns'][19]['search']['value'],
            "search_ap3" => $request['columns'][20]['search']['value'],
        ];

        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);
        // dd($param);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($userData['response_code'] == 200) {
            $user_user = $userData['data'];
            $object = json_decode(json_encode($user_user), FALSE);

            foreach ($object as $row) {
                $no++;
                $aksi = "";
                $aksi .= '<a href="' . url('eleave/leave/' . $row->user_id . '/team_leave_show') . '" class="btn btn-xs blue" title="Leave" target="_blank"><i class="fa fa-calendar-times-o">Leave</i>';

                $user_active_until = "";
                if ($row->user_active_until != "0000-00-00") {
                    $user_active_until = date('d M Y', strtotime($row->user_active_until));
                }

                $hasil[] = array("no" => $no,
                    "user_name" => $row->user_name,
                    "user_nik" => $row->user_nik,
                    "user_finger_print_id" => $row->user_finger_print_id,
                    "user_email" => $row->user_email,
                    "branch_name" => $row->branch_name,
                    "department_name" => $row->department_name,
                    "user_dob" => $row->user_dob != "0000-00-00" ? date('d M Y', strtotime($row->user_dob)) : "",
                    "user_gender" => $row->user_gender,
                    "user_position" => $row->user_position,
                    "user_type" => $row->user_type,
                    "user_join_date" => $row->user_join_date != "0000-00-00" ? date('d M Y', strtotime($row->user_join_date)) : "",
                    "user_last_contract_start_date" => $row->user_last_contract_start_date != "0000-00-00" ? date('d M Y', strtotime($row->user_last_contract_start_date)) : "",
                    "user_active_until" => $user_active_until,
                    "user_address" => $row->user_address,
                    "user_phone" => $row->user_phone,
                    "user_photo" => url(env('PUBLIC_PATH') . $row->user_photo),
                    "user_approver1" => $row->app1,
                    "user_approver2" => $row->app2,
                    "user_approver3" => $row->app3,
                    "active" => $row->user_status,
                    "hr" => ($row->is_hr == 1 ? 'Yes' : 'No'), //$hr,
                    "approver" => ($row->is_approver == 1 ? 'Yes' : 'No'), //$approver,
                    "action" => $aksi);
            }
//            $data['last_contract'] = $this->muser->get_last_contract();
//            $data['branch'] = $this->muser->get_branch();
        } else {
            $err = $userData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $userData['recordsTotal'],
            "recordsFiltered" => $userData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function profile(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlUser = 'eleave/user/getUserId';
        $param = [
            "token" => session('token'),
            "user_id" => session('id'),
        ];

        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);

        if ($userData['response_code'] == 200) {
            $list_user = json_decode(json_encode($userData['data']), FALSE);
        } else {
            $request->session()->flash('message', $userData['message']);
            $request->session()->flash('alert-type', 'warning');
        }

        return view('Eleave.employee.user_profile', array('user_list' => $list_user));
    }

    public function changeAvatar(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if ($request->hasFile('user_photo')) {
            $user_id = $request->user_id;
            ;
            $fileName = $request->file('user_photo')->getClientOriginalName();
            $upload_dir = 'upload/user/' . $user_id . '/';

            $destinationPath = public_path($upload_dir);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $request->file('user_photo')->move($destinationPath, $fileName);
            $file = $upload_dir . $fileName;
            $urlUpload = 'eleave/user/changeAvatar';
            $param = [
                "token" => session('token'),
                "user_id" => $user_id,
                "user_photo" => $file
            ];
            $user = ElaHelper::myCurl($urlUpload, $param);
            $userUpdate = json_decode($user, true);
            if ($userUpdate['response_code'] == 200) {
                return redirect('eleave/user/profile')
                                ->with(array('message' => $userUpdate['message'], 'alert-type' => 'success', 'photo' => $userUpdate['user_photo']));
            } else {
                return redirect('eleave/user/profile')
                                ->with(array('message' => $userUpdate['message'], 'alert-type' => 'error'));
            }
        }
    }

    public function requestForm(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if (session('level_id') == 8 || session('is_admin') == 1) {
            $urlBranch = 'eleave/room/getAllBranch';
            $param = [
                "token" => session('token'),
            ];
        } else {
            $urlBranch = 'eleave/user/branchId';
            $param = [
                "token" => session('token'),
                "branch_id" => session('branch_id'),
            ];
        }
        //$err = "";
        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);

        $list_branch = "";

        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = "";
        }

        $urlDepartment = 'eleave/user/department';
        $param = [
            "token" => session('token'),
        ];
        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);

        $list_department = "";

        if ($departmentData['response_code'] == 200) {
            $list_department = json_decode(json_encode($departmentData['data']), TRUE);
        } else {
            $list_department = "";
        }

        $urlApprover = 'eleave/user/approver';
        $param = [
            "token" => session('token'),
        ];
        $approver = ElaHelper::myCurl($urlApprover, $param);
        $approverData = json_decode($approver, true);
        //dd($approverData);

        $list_approver = "";

        if ($approverData['response_code'] == 200) {
            $list_approver = json_decode(json_encode($approverData['data']), FALSE);
        } else {
            $list_approver = "";
        }

        $urlLevel = 'eleave/user/userlevel';
        $param = [
            "token" => session('token'),
        ];
        $userlevel = ElaHelper::myCurl($urlLevel, $param);
        $userlevelData = json_decode($userlevel, true);

        $list_userlevel = "";

        if ($userlevelData['response_code'] == 200) {
            $list_userlevel = json_decode(json_encode($userlevelData['data']), TRUE);
        } else {
            $list_userlevel = "";
            $request->session()->flash('message', $userlevelData['message']);
            $request->session()->flash('alert-type', 'warning');
        }

        $type = $request->has('type') ? $request->type : '';
        $reqId = $request->has('reqId') ? $request->reqId : '';

        $params = [
            'branch' => $list_branch,
            'department' => $list_department,
            'user' => $list_approver,
            'user_level' => $list_userlevel,
            'type' => $type,
            'reqId' => $reqId
        ];

        return view('Eleave.employee.staff-request-form', $params);
    }

    public function requestInsert(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        date_default_timezone_set('Asia/Jakarta');

        $urlUser = 'eleave/staff-request/save';
        $param = [
            'token' => session('token'),
            'name' => $request->post('name'),
            'email' => $request->post('user_email'),
            'suggested_email' => $request->post('suggested_email'),
            'branch_id' => $request->post('branch_id'),
            'dept_id' => $request->post('dept_id'),
            'position' => $request->post('position'),
            'join_date' => $request->post('join_date'),
            'employee_type' => $request->post('employee_type'),
            'birthdate' => $request->post('birthdate'),
            'gender' => $request->post('gender'),
            'items' => json_encode($request->post('items')),
            'status' => 1,
            'type' => 1,
            'created_by' => session('id_eleave'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);

        if ($userData['response_code'] == 200) {
            return redirect('eleave/user/index#staff-request')
                            ->with(array('message' => $userData['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/user/index#staff-request')
                            ->with(array('message' => $userData['message'], 'alert-type' => 'error'));
        }
    }

    public function requestUpdate(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        date_default_timezone_set('Asia/Jakarta');

        $urlUser = 'eleave/staff-request/update';

        if (session('dept_id') != 12) {
            $param = [
                'token' => session('token'),
                'user_id' => $request->post('user_id'),
                'name' => $request->post('name'),
                'email' => $request->post('user_email'),
                'suggested_email' => $request->post('suggested_email'),
                'branch_id' => $request->post('branch_id'),
                'dept_id' => $request->post('dept_id'),
                'position' => $request->post('position'),
                'join_date' => $request->post('join_date'),
                'employee_type' => $request->post('employee_type'),
                'birthdate' => $request->post('birthdate'),
                'gender' => $request->post('gender'),
                'items' => json_encode($request->post('items')),
                'updated_by' => session('id_eleave'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($request->has('resign_date') && !empty($request->post('resign_date'))) {
                $param['resign_date'] = $request->post('resign_date');
                $param['remark'] = $request->post('remark');
            }
        } else {
            $param = [
                'token' => session('token'),
                'user_id' => $request->post('user_id'),
                'suggested_email' => $request->post('suggested_email'),
                'updated_by' => session('id_eleave'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!empty($request->post('new_items'))) {
                $param['new_items'] = json_encode($request->post('new_items'));
            }

            if (!empty($request->post('resign_items'))) {
                $param['resign_items'] = json_encode($request->post('resign_items'));
            }
        }

        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);

        if ($userData['response_code'] == 200) {
            return redirect('eleave/user/index#staff-request')
                            ->with(array('message' => $userData['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/user/index#staff-request')
                            ->with(array('message' => $userData['message'], 'alert-type' => 'error'));
        }
    }

    public function team_attendance(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if (session('is_hr') == 0) {
            $urlBranch = 'eleave/room/getAllBranch';
            $param = [
                "token" => session('token'),
            ];
        } else {
            $urlBranch = 'eleave/user/branchId';
            $param = [
                "token" => session('token'),
                "branch_id" => session('branch_id'),
            ];
        }

        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);
        $list_branch = "";
        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = "";
        }

        $urlDepartment = 'eleave/user/department';
        $param = [
            "token" => session('token'),
        ];
        $department = ElaHelper::myCurl($urlDepartment, $param);
        $departmentData = json_decode($department, true);

        $list_department = "";
        if ($departmentData['response_code'] == 200) {
            $list_department = json_decode(json_encode($departmentData['data']), TRUE);
        } else {
            $list_department = "";
        }

        return view('Eleave.employee.user_team_att', array('branch' => $list_branch, 'department' => $list_department));
    }

    public function getTeamAttendance(Request $request) {
        $year = $request->year;
        $urlAttendance = 'eleave/attendance/employeeByApprover';
        $param = [
            "token" => session('token'),
            "year" => $year,
            "userApprover" => session('id'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_user" => $request['columns'][1]['search']['value'],
            "search_date" => $request['columns'][2]['search']['value'],
            "search_day" => $request['columns'][3]['search']['value'],
            "search_time_in" => $request['columns'][4]['search']['value'],
            "search_time_out" => $request['columns'][5]['search']['value'],
            "search_total_time" => $request['columns'][6]['search']['value'],
            "search_late_point" => $request['columns'][7]['search']['value'],
            "search_month" => $request['columns'][8]['search']['value'],
            "search_status" => $request['columns'][9]['search']['value'],
        ];
        $attendance = ElaHelper::myCurl($urlAttendance, $param);
       //var_dump($attendance);exit();
        $attendanceData = json_decode($attendance, true);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($attendanceData['response_code'] == 200) {
            $attendance = $attendanceData['data'];
            $object = json_decode(json_encode($attendance), FALSE);

            foreach ($object as $row) {
                $no++;
                $month = date('F', strtotime($row->at_date));
                $day = date('l', strtotime($row->at_date));

                $hasil[] = array("no" => $no,
                    "at_id" => $row->at_id,
                    "user_name" => ($row->is_attendance == "Mobile" ? "<a href='#' title='View Detail' onClick=show_detail('" . $row->user_id . "','" . $row->branch_id . "','" . $row->at_date . "')> &nbsp;" . $row->user_name . "&nbsp;</a>" : $row->user_name),
                    "at_date" => date('d M Y', strtotime($row->at_date)),
                    "at_time_in" => $row->at_time_in,
                    "at_time_out" => $row->at_time_out,
                    "at_total_time" => $row->at_total_time,
                    "at_late_point" => $row->at_late_point,
                    "month" => $month,
                    "day" => $day,
                    "is_attendance" => $row->is_attendance);
            }
        } else {
            $err .= session()->flash('message', $attendanceData['message']);
            $err .= session()->flash('alert-type', 'warning');
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $attendanceData['recordsTotal'],
            "recordsFiltered" => $attendanceData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function getTeamAttendanceDetail(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlAttendance = 'eleave/attendance/getAttDetail';
        $param = [
            'token' => session('token'),
            'user_id' => $request->user_id,
            'branch_id' => $request->branch_id,
            'at_date' => $request->at_date,
        ];
        $attendance_id = ElaHelper::myCurl($urlAttendance, $param);
        $attendanceList = json_decode($attendance_id, true);

        $row = array();
        if ($attendanceList['response_code'] == 200) {
            $data = array();
            foreach ($attendanceList['data'] as $value) {
                $data[] = array(
                    'date_time' => date("d M Y H:i", strtotime($value['att_datetime'])),
                    'location' => $value['location'],
                    'remark' => $value['remark'],
                );
            }
            $output = array(
                "data" => $data
            );
        } else {
            $output = $attendanceList['message'];
        }
        echo json_encode($output);
    }

}
