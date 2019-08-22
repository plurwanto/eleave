<?php
namespace App\Http\Controllers\Eleave\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\ElaHelper;
use App\Http\Model\Eleave\Finger;
use DB;
use App\Http\Model\Eleave\Attendance;
use App\Http\Model\Eleave\User;
use DateInterval;
use DateTime;

class AttendanceController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index($year = null) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if ($year == null) {
            $year = date('Y');
        }
        $urlBranch = 'eleave/room/getAllBranch';
        $param = [
            "token" => session('token'),
        ];
        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);
        $list_branch = "";
        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = "";
        }

        return view('Eleave.attendance.at_index', ['year' => $year, 'branch' => $list_branch]);
    }

    public function getAttendanceAllEmployee(Request $request) {
        $year = $request->year;
        $urlAttendance = 'eleave/attendance/employeeAll';
        $param = [
            "token" => session('token'),
            "year" => $year,
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_branch" => $request['columns'][1]['search']['value'],
            "search_user" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_day" => $request['columns'][4]['search']['value'],
            "search_time_in" => $request['columns'][5]['search']['value'],
            "search_time_out" => $request['columns'][6]['search']['value'],
            "search_total_time" => $request['columns'][7]['search']['value'],
            "search_late_point" => $request['columns'][8]['search']['value'],
            "search_month" => $request['columns'][9]['search']['value'],
        ];
        $attendance = ElaHelper::myCurl($urlAttendance, $param);
        $attendanceData = json_decode($attendance, true);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($attendanceData['response_code'] == 200) {
            $attendance = $attendanceData['data'];
            $object = json_decode(json_encode($attendance), FALSE);

            foreach ($object as $row) {
                $no++;
                $aksi = "";
                $month = date('F', strtotime($row->at_date));
                $day = date('l', strtotime($row->at_date));

                $hasil[] = array("no" => $no,
                    "branch_name" => $row->branch_name,
                    "user_name" => $row->user_name,
                    "at_date" => date('d M Y', strtotime($row->at_date)),
                    "at_time_in" => $row->at_time_in,
                    "at_time_out" => $row->at_time_out,
                    "at_total_time" => $row->at_total_time,
                    "at_late_point" => $row->at_late_point,
                    "month" => $month,
                    "day" => $day,
                    "action" => $aksi);
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

    public function employee() {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $param1 = [
            "token" => session('token'),
            "branch_id" => session('branch_id'),
        ];
        $urlHoliday = 'eleave/holiday/getHolidayBranch';
        $holiday_id = ElaHelper::myCurl($urlHoliday, $param1);
        $holidayList = json_decode($holiday_id, true);
        $holidayData = json_decode(json_encode($holidayList['data']), FALSE);

        $param2 = [
            "token" => session('token'),
            "user_id" => session('id'),
        ];
        // leave employee
        $urlLeave = 'eleave/leave/getLeaveEmployee';
        $leave_id = ElaHelper::myCurl($urlLeave, $param2);
        $leaveList = json_decode($leave_id, true);
        $leaveData = json_decode(json_encode($leaveList['data']), FALSE);

        // timesheet employee
        $urlTimesheet = 'eleave/timesheet/getTimesheetEmployee';
        $timesheet_id = ElaHelper::myCurl($urlTimesheet, $param2);
        $timesheetList = json_decode($timesheet_id, true);
        $timesheetData = json_decode(json_encode($timesheetList['data']), FALSE);

        //attendance employee
        $urlAttendance = 'eleave/attendance/getAttendanceEmployee';
        $attendance_id = ElaHelper::myCurl($urlAttendance, $param2);
        $attendanceList = json_decode($attendance_id, true);
        //dd($attendanceList);
        $attendanceData = json_decode(json_encode($attendanceList['data']), FALSE);

        return view('Eleave.attendance.at_employee', ['holiday' => $holidayData, 'leave' => $leaveData, 'timesheet' => $timesheetData, 'attendance' => $attendanceData]);
    }

    public function getAttendanceEmployee(Request $request) {
        $urlAttendance = 'eleave/attendance/employee';
        $param = [
            "token" => session('token'),
            "user_id" => session('id'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_date" => $request['columns'][1]['search']['value'],
            "search_day" => $request['columns'][2]['search']['value'],
            "search_time_in" => $request['columns'][3]['search']['value'],
            "search_time_out" => $request['columns'][4]['search']['value'],
            "search_total_time" => $request['columns'][5]['search']['value'],
            "search_late_point" => $request['columns'][6]['search']['value'],
            "search_year" => $request['columns'][7]['search']['value'],
            "search_month" => $request['columns'][8]['search']['value'],
        ];
        $attendance = ElaHelper::myCurl($urlAttendance, $param);
        $attendanceData = json_decode($attendance, true);

        $err = "";
        $no = $request->post('start');
        $hasil = array();
//dd($attendanceData['TotLatePoints']);
        if ($attendanceData['response_code'] == 200) {
            $attendance = $attendanceData['data'];
            $object = json_decode(json_encode($attendance), FALSE);

            foreach ($object as $row) {
                $no++;
                $aksi = "";

                $year = date('Y', strtotime($row->at_date));
                $month = date('F', strtotime($row->at_date));
                $day = date('l', strtotime($row->at_date));

                $hasil[] = array("no" => $no,
                    "branch_name" => $row->branch_name,
                    "user_name" => $row->user_name,
                    "at_date" => date('d M Y', strtotime($row->at_date)),
                    "at_time_in" => $row->at_time_in,
                    "at_time_out" => $row->at_time_out,
                    "at_total_time" => $row->at_total_time,
                    "at_late_point" => $row->at_late_point,
                    "year" => $year,
                    "month" => $month,
                    "day" => $day,
                    "action" => $aksi);
            }
        } else {
            //$err = $attendanceData['message'];
            $err .= session()->flash('message', $attendanceData['message']);
            $err .= session()->flash('alert-type', 'warning');
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $attendanceData['recordsTotal'],
            "recordsFiltered" => $attendanceData['recordsFiltered'],
            "data" => $hasil,
            "TotLatePoints" => $attendanceData['TotLatePoints'],
            "error" => $err,
            "BranchId" => session('branch_id')
        );
        echo json_encode($json_data);
    }

    function excel_attendance($year = null) {
        if ($year == null) {
            $year = date('Y');
        }
        $param = [
            "token" => session('token'),
            "branch_id" => "",
            "year" => $year,
            "month" => "",
            "employee_name" => ""
        ];
//dd($param);
        $urlAttendance = 'eleave/attendance/getToExcel';
        $attendance = ElaHelper::myCurl($urlAttendance, $param);
        $attendanceData = json_decode($attendance, true);
        // dd($attendanceData);
        if ($attendanceData['response_code'] == 200) {
            $attendance_excel = $attendanceData['data'];
            return view('Eleave.excel_attendance')->with(array('title' => 'Attendance', 'hasil' => $attendance_excel));
        } else {
            $err = $attendanceData['message'];
        }
    }

    function upload_attendance(Request $request) {
        //dd($request->all());
        if ($request->hasFile('finger_file')) {
            $fileName = $request->file('finger_file')->getClientOriginalName();
            $destinationPath = base_path('public/upload/finger/');
            $upload_dir = base_path('public/upload/finger/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $request->file('finger_file')->move($destinationPath, $fileName);
            $file_document = $upload_dir . $fileName;

            $content = array();
            if (($handle = fopen($file_document, "r")) !== FALSE) {
                $cek = 0;
                // looping per row
                // $branch_id = $finger_print_id = $fg_date = $fg_time_in = $fg_time_out = array();
                while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                    $branch_id = $data[0];
                    $finger_print_id = $data[1];
                    $fg_date = $data[2];
                    $fg_time_in = $data[3];
                    $fg_time_out = $data[3];

                    for ($c = 12; $c > 3; $c--) {
                        if ($data[$c] != "") {
                            $fg_time_out = $data[$c];
                            if ($fg_time_in == "") {
                                $fg_time_in = $fg_time_out;
                            }
                            break;
                        }
                    }

                    // jika tidak kosong dan bukan header
                    if ($branch_id != "" && $finger_print_id != "" && $fg_date != "" && $fg_time_in != "" && $fg_time_out != "" && $cek > 0) {
                        $content[] = [
                            "branch_id" => $branch_id,
                            "user_id" => 0,
                            "finger_print_id" => $finger_print_id,
                            "fg_date" => date('Y-m-d', strtotime($fg_date)),
                            "fg_time_in" => $fg_time_in,
                            "fg_time_out" => $fg_time_out,
                        ];
                    }
                    $cek++;
                }
                fclose($handle);
            }

            $finger_insert = new Finger();
            $finger_insert->insert($content);

            $finger = Finger::selectRaw('finger.branch_id,usr.user_id,finger.finger_print_id,finger.fg_date,finger.fg_time_in,finger.fg_time_out')
                    //->join('user as usr', 'usr.user_finger_print_id', '=', 'finger.finger_print_id')
                    ->Join('user as usr', function ($join) {
                        $join->on('usr.user_finger_print_id', '=', 'finger.finger_print_id')
                        ->on('usr.branch_id', '=', 'finger.branch_id');
                    })
                    ->where('usr.user_status', 'Active')
                    // ->where('usr.branch_id', $branch_id)
                    //  ->orderBy('branch_id', 'ASC')->orderBy('finger_print_id', 'ASC')->orderBy('fg_date', 'ASC')->orderBy('fg_time_in', 'ASC')
                    ->get();

            $key = 0;

            if (!empty($finger)) {
                $arrFinger = [];

                $todayYear = date('Y');
                $allAttendance = Attendance::whereRaw('YEAR(at_date) = ' . $todayYear)->get();

                $arr_att = array();
                foreach ($allAttendance as $value) {
                    $arr_att[$value->branch_id . $value->user_id . $value->at_date] = $value;
                }

                foreach ($finger as $item) {

                    $cekAtt = false;
                    if (array_key_exists($item->branch_id . $item->user_id . $item->fg_date, $arr_att)) {
                        $cekAtt = true;
                    }

                    if ($cekAtt) {
                        $getAtt = $arr_att[$item->branch_id . $item->user_id . $item->fg_date];
                        if ($item->fg_time_in != $getAtt->at_time_in || $item->fg_time_out != $getAtt->at_time_out) {
                            if (strtotime($getAtt->at_time_in) < strtotime($item->fg_time_in)) {
                                $new_time_in = $getAtt->at_time_in;
                            } else {
                                $new_time_in = $item->fg_time_in;
                            }
                            if (strtotime($getAtt->at_time_out) > strtotime($item->fg_time_out)) {
                                $new_time_out = $getAtt->at_time_out;
                            } else {
                                $new_time_out = $item->fg_time_out;
                            }

                            $at_total_time = $this->getTotalTime($getAtt->at_date, $new_time_in, $new_time_out);
                            $at_late_point = 0;
                            if (date('N', strtotime($getAtt->at_date)) < 6) {
                                $at_late_point = $this->get_late_point($getAtt->at_date, $new_time_in);
                            }

                            Attendance::where('branch_id', $item->branch_id)
                                    ->where('user_id', $item->user_id)
                                    ->where('at_date', $item->fg_date)
                                    ->update(array(
                                        'user_id' => $item->user_id,
                                        'at_date' => $item->fg_date,
                                        'at_time_in' => $new_time_in,
                                        'at_time_out' => $new_time_out,
                                        'at_total_time' => $at_total_time,
                                        'branch_id' => $item->branch_id,
                                        'at_finger_print_id' => $item->finger_print_id,
                                        'at_late_point' => $at_late_point,
                                        'updated_at' => date('Y-m-d H:i:s')
                            ));
                            $msg = "Update Successfully";
                        } else {
                            $msg = "Data already up to date";
                        }
                    } else {
                        // insert 
                        $at_total_time = $this->getTotalTime($item->fg_date, $item->fg_time_in, $item->fg_time_out);
                        $at_late_point = 0;
                        if (date('N', strtotime($item->fg_date)) < 6) {
                            $at_late_point = $this->get_late_point($item->fg_date, $item->fg_time_in);
                        }

                        $arrFinger[] = array(
                            'user_id' => $item->user_id,
                            'at_date' => $item->fg_date,
                            'at_time_in' => $item->fg_time_in,
                            'at_time_out' => $item->fg_time_out,
                            'at_total_time' => $at_total_time,
                            'branch_id' => $item->branch_id,
                            'at_finger_print_id' => $item->finger_print_id,
                            'at_late_point' => $at_late_point,
                        );
                    }
                }
                if (!empty($arrFinger)) {
                    Attendance::insert($arrFinger);
                    $msg = "Insert Successfully";
                }
            } else {
                $msg = "File is empty, please contact your administrator..!";
            }

            // DELETE FINGER PRINT DATA
            $todo = finger::where('branch_id', '!=', 0)->delete();

//                if ($cekTemp) {
//                    //foreach ($arrTable as $tableName) {
//                        DB::table('attendance')
//                                ->where('branch_id', $item->branch_id)
//                                ->where('user_id', $item->user_id)
//                                ->where('at_date', $item->fg_date)
//                                ->update([
//                                    'user_id' => $item->user_id,
//                                    'at_date' => $item->fg_date,
//                                    'at_time_in' => $item->fg_time_in,
//                                    'at_time_out' => $item->fg_time_out,
//                                    'at_total_time' => 0,
//                                    'branch_id' => $item->branch_id,
//                                    'at_finger_print_id' => $item->finger_print_id,
//                                    'updated_at' => date('Y-m-d H:i:s')
//                        ]);
//                   // }
//                } else {
//
//                    foreach ($arrTable as $tableName) {
//
//                        DB::table($tableName)
//                                ->insert(array(
//                                    'user_id' => $item->user_id,
//                                    'at_date' => $item->fg_date,
//                                    'at_time_in' => $item->fg_time_in,
//                                    'at_time_out' => $item->fg_time_out,
//                                    'at_total_time' => 0,
//                                    'branch_id' => $item->branch_id,
//                                    'at_finger_print_id' => $item->finger_print_id
//                        ));
//                    }
//                }
            //    exit();
//            $attendance_temp_update = [];
//            foreach ($finger as $item) {
//                $branch_id[] = $item->branch_id;
//                $user_id[] = $item->user_id;
//                $fg_date[] = $item->fg_date;
//
//                //table temp
//                $attendance_temp = AttendanceTemp::selectRaw('attendance.user_id,attendance.branch_id,attendance.at_date,attendance.at_time_in,attendance.at_time_out,attendance.at_total_time')
//                        ->where('branch_id', $item->branch_id)->where('user_id', $item->user_id)->where('at_date', $item->fg_date)
//                        ->orderBy('at_id', 'ASC');
//                if ($attendance_temp->count() == 0) {
//                    $att_insert = new AttendanceTemp();
//                    $att_insert->user_id = $item->user_id;
//                    $att_insert->at_date = $item->fg_date;
//                    $att_insert->at_time_in = $item->fg_time_in;
//                    $att_insert->at_time_out = $item->fg_time_out;
//                    $att_insert->branch_id = $item->branch_id;
//                    $att_insert->at_finger_print_id = $item->finger_print_id;
//                    $att_insert->save();
//
//                    $insert_asli = new Attendance();
//                    $insert_asli->user_id = $item->user_id;
//                    $insert_asli->at_date = $item->fg_date;
//                    $insert_asli->at_time_in = $item->fg_time_in;
//                    $insert_asli->at_time_out = $item->fg_time_out;
//                    $insert_asli->branch_id = $item->branch_id;
//                    $insert_asli->at_finger_print_id = $item->finger_print_id;
//                    $insert_asli->save();
//                } else {
//                    $attendance_temp->update(array(
//                        'user_id' => $item->user_id,
//                        'at_date' => $item->fg_date,
//                        'at_time_in' => $item->fg_time_in,
//                        'at_time_out' => $item->fg_time_out,
//                        'branch_id' => $item->branch_id,
//                        'at_finger_print_id' => $item->finger_print_id,
//                        'updated_at' => date('Y-m-d H:i:s')
//                    ));
//
//                    Attendance:: where('branch_id', $item->branch_id)->where('user_id', $item->user_id)->where('at_date', $item->fg_date)->update(array(
//                        'user_id' => $item->user_id,
//                        'at_date' => $item->fg_date,
//                        'at_time_in' => $item->fg_time_in,
//                        'at_time_out' => $item->fg_time_out,
//                        'branch_id' => $item->branch_id,
//                        'at_finger_print_id' => $item->finger_print_id,
//                        'updated_at' => date('Y-m-d H:i:s')
//                    ));
//                }
//
//                $attendance_temp_update[] = array(
//                    'user_id' => $item->user_id,
//                    'at_date' => $item->fg_date,
//                    'at_time_in' => $item->fg_time_in,
//                    'at_time_out' => $item->fg_time_out,
//                    'branch_id' => $item->branch_id,
//                    'at_finger_print_id' => $item->finger_print_id,
//                    'updated_at' => date('Y-m-d H:i:s')
//                );
//            }
//                $result = $attendance->first();
//                $check_att = $attendance->count();
//
//                if ($check_att > 0) {
//                    if (strtotime($result['at_time_in']) < strtotime($item->fg_time_in)) {
//                        $new_time_in = $result['at_time_in'];
//                    } else {
//                        $new_time_in = $item->fg_time_in;
//                    }
//                    if (strtotime($result['at_time_out']) > strtotime($item->fg_time_out)) {
//                        $new_time_out = $result['at_time_out'];
//                    } else {
//                        $new_time_out = $item->fg_time_out;
//                    }
//                } else {
//                    $new_time_in = $item->fg_time_in;
//                    $new_time_out = $item->fg_time_out;
//                }
//
//                $at_total_time = $this->getTotalTime($item->fg_date, $new_time_in, $new_time_out);
//                $at_late_point = 0;
//                if (date('N', strtotime($item->fg_date)) < 6) {
//                    $at_late_point = $this->get_late_point($item->fg_date, $new_time_in);
//                }
//
//                $fg_date[] = $item->fg_date;
//                $user_id[] = $item->user_id;
//                $branch_id[] = $item->branch_id;
//                $fg_print_id[] = $item->finger_print_id;
//
//                // if ($branch_id == $item->branch_id) {
//                $arrFinger[] = [
//                    "branch_id" => $item->branch_id,
//                    "user_id" => $item->user_id,
//                    "at_finger_print_id" => $item->finger_print_id,
//                    "at_date" => $item->fg_date,
//                    "at_time_in" => $new_time_in,
//                    "at_time_out" => $new_time_out,
//                    "at_total_time" => $at_total_time,
//                    "at_late_point" => $at_late_point,
//                    "updated_at" => date('Y-m-d H:i:s')
//                ];
//                //}
//                $key++;
//            $attendance = Attendance::whereIn('branch_id', $branch_id)->whereIn('user_id', $user_id)->whereIn('at_date', $fg_date)->orderBy('at_id', 'ASC');
//
//            $attendance->update($attendance_temp_update);
//            $att_insert = new Attendance();
//            $att_insert->insert($attendance_temp_update);
//            echo "<pre>";
//            print_r($attendance);
//            echo "</pre>";
//            exit();
//            $attendance2 = Attendance::selectRaw('attendance.user_id,attendance.branch_id,attendance.at_date,attendance.at_time_in,attendance.at_time_out,attendance.at_total_time')
//                    ->whereIn('branch_id', $branch_id)->whereIn('user_id', $user_id)->whereIn('at_date', $fg_date)
//                    ->whereRaw('att_time_in_timezone IS NULL AND att_time_out_timezone IS NULL');
//            $check_att2 = $attendance2->count();
//            $result = $attendance2->get();
////            echo "<pre>";
////            print_r($result);
////            echo "</pre>";
////            exit();
//            $att_insert = new Attendance();
//            if ($check_att2 == 0) {
//                $att_insert->insert($arrFinger);
//            } else {
//                $attendance2->update($arrFinger);
//
////                $attendance2->delete();
////                $att_insert->insert($arrFinger);
//            }
//                foreach ($result as $value) {
//                    // var_dump($fg_date);
//                    if (strtotime($value['at_time_in']) < strtotime($fg_time_in)) {
//                        $new_time_in = $value['at_time_in'];
//                    } else {
//                        $new_time_in = $fg_time_in;
//                    }
//
//                    if (strtotime($value['at_time_out']) > strtotime($fg_time_out)) {
//                        $new_time_out = $value['at_time_out'];
//                    } else {
//                        $new_time_out = $fg_time_out;
//                    }
//                    $at_insert = new Attendance();
//                   
//                    $at_insert->user_id = $user_id;
//                    $at_insert->branch_id = $branch_id;
//                    $at_insert->at_date = $fg_date;
//                    $at_insert->at_time_in = $new_time_in;
//                    $at_insert->at_time_out = $new_time_out;
//                    $at_insert->at_total_time = 0;
//                    $at_insert->at_finger_print_id = $fg_print_id;
//                    $at_insert->at_late_point = 0;
//                    $at_insert->save();
//                }
            //exit();
            // $att_insert->insert($arrFinger);
//            }
//            foreach (json_decode(json_encode($arrFinger), FALSE) as $value) {
//                // INSERT FIRST ATTENDANCE
//                $attendance = Attendance::checkAttendanceByFinger($value->branch_id, $value->user_id, $value->fg_date)->first();
//
//
//                if (empty($attendance)) {
//                    $at_total_time = $this->getTotalTime($fg_date, $fg_time_in, $fg_time_out);
//                    $at_late_point = 0;
//                    if (date('N', strtotime($fg_date)) < 6) {
//                        $at_late_point = $this->get_late_point($fg_date, $fg_time_in);
//                    }
//
//                    // if ($branch_id == $value->branch_id && $fg_print_id == $value->finger_print_id) {
//                    $at_insert = new Attendance();
//                    //  if ($attendance->count() == 0) {
//                    $at_insert->user_id = $value->user_id;
//                    $at_insert->branch_id = $value->branch_id;
//                    $at_insert->at_date = $value->fg_date;
//                    $at_insert->at_time_in = $value->fg_time_in;
//                    $at_insert->at_time_out = $value->fg_time_out;
//                    $at_insert->at_total_time = $at_total_time;
//                    $at_insert->at_finger_print_id = $value->finger_print_id;
//                    $at_insert->at_late_point = $at_late_point;
//                    $at_insert->save();
//                    // }
//                } else {
//                    $del = Attendance::where('user_id', $value->user_id)->where('at_date', $value->fg_date)->where('branch_id', $value->branch_id)->delete();
//
////                    $at_total_time = $this->getTotalTime($fg_date, $fg_time_in, $fg_time_out);
////                    $at_late_point = 0;
////                    if (date('N', strtotime($fg_date)) < 6) {
////                        $at_late_point = $this->get_late_point($fg_date, $fg_time_in);
////                    }
////
////                    $at_insert = new Attendance();
////                    //  if ($attendance->count() == 0) {
////                    $at_insert->user_id = $value->user_id;
////                    $at_insert->branch_id = $value->branch_id;
////                    $at_insert->at_date = $value->fg_date;
////                    $at_insert->at_time_in = $value->fg_time_in;
////                    $at_insert->at_time_out = $value->fg_time_out;
////                    $at_insert->at_total_time = $at_total_time;
////                    $at_insert->at_finger_print_id = $value->finger_print_id;
////                    $at_insert->at_late_point = $at_late_point;
////                    $at_insert->save();
////                        if (strtotime($rest[0]->at_time_in) < strtotime($fg_time_in)) {
////                            $new_time_in = $rest[0]->at_time_in;
////                        } else {
////                            $new_time_in = $fg_time_in;
////                        }
////
////                        if (strtotime($rest[0]->at_time_out) > strtotime($fg_time_out)) {
////                            $new_time_out = $rest[0]->at_time_out;
////                        } else {
////                            $new_time_out = $fg_time_out;
////                        }
////
////                        $at_total_time = $this->getTotalTime($fg_date, $fg_time_in, $fg_time_out);
////                        $at_late_point = 0;
////                        if (date('N', strtotime($fg_date)) < 6) {
////                            $at_late_point = $this->get_late_point($fg_date, $fg_time_in);
////                        }
////
////                        if ($branch_id == $item->branch_id && $fg_print_id == $item->finger_print_id) {
////                            $todo = Attendance::where('user_id', $user_id)->where('at_date', $item->fg_date)->where('branch_id', $branch_id)
////                                    ->delete();
////
////                            $at_insert = new Attendance();
////                            //  if ($attendance->count() == 0) {
////                            $at_insert->user_id = $user_id;
////                            $at_insert->branch_id = $branch_id;
////                            $at_insert->at_date = $fg_date;
////                            $at_insert->at_time_in = $new_time_in;
////                            $at_insert->at_time_out = $new_time_out;
////                            $at_insert->at_total_time = $at_total_time;
////                            $at_insert->at_finger_print_id = $fg_print_id;
////                            $at_insert->at_late_point = $at_late_point;
////                            $at_insert->save();
////                        }
//                }
//            }
//                // DELETE FINGER PRINT DATA
//                $todo = finger::where('branch_id', '!=', 0)->delete();
//
//                // INSERT FIRST ATTENDANCE
//
//                $at_total_time = $this->getTotalTime($fg_date, $fg_time_in, $fg_time_out);
//                $at_late_point = 0;
//                if (date('N', strtotime($fg_date)) < 6) {
//                    $at_late_point = $this->get_late_point($fg_date, $fg_time_in);
//                }
//                $attendance = Attendance::checkAttendanceByFinger($branch_id, $user_id, $fg_date);
//                $rest = $attendance->get();
            // dd($rest[0]->at_time_in);
//                $at_insert = new Attendance();
//                //  if ($attendance->count() == 0) {
//                $at_insert->user_id = $user_id;
//                $at_insert->branch_id = $branch_id;
//                $at_insert->at_date = $fg_date;
//                $at_insert->at_time_in = $fg_time_in;
//                $at_insert->at_time_out = $fg_time_out;
//                $at_insert->at_total_time = $at_total_time;
//                $at_insert->at_finger_print_id = $fg_print_id;
//                $at_insert->at_late_point = $at_late_point;
//                $at_insert->save();
            //$at_insert->saveAttendance($user_id, $branch_id, $fg_date, $fg_time_in, $fg_time_out, $at_total_time, $fg_print_id, $at_late_point);
            //  } else {
//                    if (strtotime($rest[0]->at_time_in) < strtotime($fg_time_in)) {
//                        $new_time_in = $rest[0]->at_time_in;
//                    } else {
//                $new_time_in = $fg_time_in;
////                    }
////                    if (strtotime($rest[0]->at_time_out) > strtotime($fg_time_out)) {
////                        $new_time_out = $rest[0]->at_time_out;
////                    } else {
//                $new_time_out = $fg_time_out;
////                    }
//
//                $at_total_time = $this->getTotalTime($fg_date, $new_time_in, $new_time_out);
//                $at_late_point = 0;
//                if (date('N', strtotime($fg_date)) < 6) {
//                    $at_late_point = $this->get_late_point($fg_date, $new_time_in);
//                }
//
////                    $todo = Attendance::where('user_id', $user_id)->where('at_date', $fg_date)->where('branch_id', $branch_id)
////                            ->delete();
//
//                $at_insert->saveAttendance($user_id, $branch_id, $fg_date, $new_time_in, $new_time_out, $at_total_time, $fg_print_id, $at_late_point);
//                }
//                jj
//                $arrFingerDate = [];
//
//                foreach ($finger as $value) {
//                    $arrFingerDate[] = $value->fg_date;
//                }
//
//                $attendance = Attendance::checkAttendanceByFingerByDate($branch_id, $user_id, $arrFingerDate);
//                $rest = $attendance->get();
////                var_dump(json_encode($rest, JSON_PRETTY_PRINT));
////                exit;
////                          end jj  
//                foreach ($finger as $item) {
//                    // jika cabang, finger, date sama
////                    if ($branch_id == $item->branch_id && $fg_print_id == $item->finger_print_id && $fg_date == $item->fg_date) {
////
////                        $at_total_time = $this->getTotalTime($item->fg_date, $fg_time_in, $item->fg_time_out);
////
////                        $attendance = Attendance::checkAttendanceByFinger($branch_id, $user_id, $fg_date);
////                        $att_update = $attendance->first();
////                        $rest = $attendance->get();
////
////                        if (strtotime($rest[0]->at_time_out) > strtotime($item->fg_time_out)) {
////                            $new_time_out = $rest[0]->at_time_out;
////                        } else {
////                            $new_time_out = $item->fg_time_out;
////                        }
////
////                        $att_update->at_time_out = $new_time_out;
////                        $att_update->at_total_time = $at_total_time;
////
////                        if ($att_update->update()) {
////                            // $data = HelperService::_success();
////                        } else {
////                            $data = array(
////                                'error' => 1,
////                                'message' => 'Failed to update this user, Please try again',
////                                'response_code' => 500
////                            );
////                        }
////                    }
//                    // jika cabang, finger sama tapi tanggal beda
////                    elseif ($branch_id == $item->branch_id && $fg_print_id == $item->finger_print_id) {
////                        // cari data absen yang sudah ada sebelumnya ditanggal tersebut
////                        $attendance = Attendance::checkAttendanceByFinger($branch_id, $user_id, $item->fg_date);
////                        $rest = $attendance->get();
////                        //jika ada data
////                        if ($attendance->count() > 0) {
////                            if (strtotime($rest[0]->at_time_in) < strtotime($item->fg_time_in)) {
////                                $new_time_in = $rest[0]->at_time_in;
////                            } else {
////                                $new_time_in = $item->fg_time_in;
////                            }
////
////                            if (strtotime($rest[0]->at_time_out) > strtotime($item->fg_time_out)) {
////                                $new_time_out = $rest[0]->at_time_out;
////                            } else {
////                                $new_time_out = $item->fg_time_out;
////                            }
////                            // delete
////                            $todo = Attendance::where('user_id', $user_id)->where('at_date', $item->fg_date)->where('branch_id', $branch_id)
////                                    ->delete();
////                        } else {
////                            $new_time_in = $item->fg_time_in;
////                            $new_time_out = $item->fg_time_out;
////                        }
////
////                        $at_total_time = $this->getTotalTime($item->fg_date, $new_time_in, $new_time_out);
////                        $at_late_point = 0;
////                        if (date('N', strtotime($item->fg_date)) < 6) {
////                            $at_late_point = $this->get_late_point($item->fg_date, $new_time_in);
////                        }
////
////                        $at_insert->saveAttendance($user_id, $branch_id, $item->fg_date, $new_time_in, $new_time_out, $at_total_time, $fg_print_id, $at_late_point);
////
////                        $fg_date = $item->fg_date;
////                        $fg_time_in = $item->fg_time_in;
////                    }
//                    // jika cabang sama tapi finger beda
//                    if ($branch_id == $item->branch_id) {
//                        // get user
//                        //  $user = User::selectRaw('`user`.user_id')->where('branch_id', $item->branch_id)->where('user_finger_print_id', $item->finger_print_id)
//                        //                  ->orderBy('user_id', 'ASC')->first();
//                        //if user exist
//                        if (!empty($user)) {
//                            // $user_id = $user->user_id;
//                            //jika ada data absennya simpan data absen baru
//                            if ($rest->count() > 0) {
//                                foreach ($rest as $val) {
//                                    if (strtotime($val->at_time_in) < strtotime($item->fg_time_in)) {
//                                        $new_time_in = $val->at_time_in;
//                                    } else {
//                                        $new_time_in = $item->fg_time_in;
//                                    }
//
//                                    if (strtotime($val->at_time_out) > strtotime($item->fg_time_out)) {
//                                        $new_time_out = $val->at_time_out;
//                                    } else {
//                                        $new_time_out = $item->fg_time_out;
//                                    }
//                                }
//
//                                // delete
//                                $todo = Attendance::where('user_id', $user_id)->where('at_date', $item->fg_date)->where('branch_id', $branch_id)
//                                        ->delete();
//                            } else {
//                                $new_time_in = $item->fg_time_in;
//                                $new_time_out = $item->fg_time_out;
//                            }
//
//                            $at_total_time = $this->getTotalTime($item->fg_date, $new_time_in, $new_time_out);
//                            $at_late_point = 0;
//                            if (date('N', strtotime($item->fg_date)) < 6) {
//                                $at_late_point = $this->get_late_point($item->fg_date, $new_time_in);
//                            }
//
//                            $at_insert->saveAttendance($user_id, $branch_id, $item->fg_date, $new_time_in, $new_time_out, $at_total_time, $item->finger_print_id, $at_late_point);
//
//                            $fg_print_id = $item->finger_print_id;
//                            $fg_date = $item->fg_date;
//                            $fg_time_in = $item->fg_time_in;
//                        }
//                    }
//                    // jika semua beda
////                    else {
////                        $user = User::selectRaw('`user`.user_id')->where('branch_id', $item->branch_id)->where('user_finger_print_id', $item->finger_print_id)
////                                        ->orderBy('user_id', 'ASC')->first();
////
////                        //if user exist
////                        if (!empty($user)) {
////                            $user_id = $query->row()->user_id;
////
////                            // get data absen pada tanggal tersebut
////                            $attendance = Attendance::checkAttendanceByFinger($item->branch_id, $user_id, $item->fg_date);
////
////                            //jika belum ada data absen maka simpan data absen baru
////                            if ($attendance->count() > 0) {
////                                // delete
////                                $todo = Attendance::where('user_id', $user_id)->where('at_date', $item->fg_date)->where('branch_id', $item->branch_id)
////                                        ->delete();
////                            }
////
////                            $at_total_time = $this->getTotalTime($item->fg_date, $item->fg_time_in, $item->fg_time_out);
////                            $at_late_point = 0;
////                            if (date('N', strtotime($item->fg_date)) < 6) {
////                                $at_late_point = $this->get_late_point($item->fg_date, $item->fg_time_in);
////                            }
////
////                            $at_insert->saveAttendance($user_id, $item->branch_id, $item->fg_date, $item->fg_time_in, $item->fg_time_out, $at_total_time, $item->finger_print_id, $at_late_point);
////
////                            $branch_id = $item->branch_id;
////                            $fg_print_id = $item->finger_print_id;
////                            $fg_date = $item->fg_date;
////                            $fg_time_in = $item->fg_time_in;
////                        }
////                    }
//                }
//                $urlUpload = 'eleave/attendance/upload_finger';
//                $param = array(
//                    'token' => session('token'),
//                    'data'  => $content
//                );
//                
//                $finger = ElaHelper::myCurl($urlUpload, $param);
//                $fingerUpdate = json_decode($finger, true);
//
//                if ($fingerUpdate['response_code'] == 200) {
//                    $upload = array('status' => true, 'message' => $fingerUpdate['message']);
//                } else {
//                    $upload = array('status' => false, 'message' => $fingerUpdate['message']);
//                }
        }
        $upload = array('status' => true, 'message' => $msg);
        echo json_encode($upload);
    }

    function get_late_point($fg_date, $new_time_in) {
        $today = $fg_date;
        $next = $today . " " . $new_time_in;
        $today = $today . " 08:00:00";
        $awal = strtotime($today);
        $akhir = strtotime($next);
        $selisih = ($akhir - $awal) / 60;

        $at_late_point = 0;
        // more than 11 minutes
        if ($selisih > 11) {
            // less than 31 minutes
            if ($selisih < 31) {
                $at_late_point = 0.5;
            }
            // less than 61 minutes
            elseif ($selisih < 61) {
                $at_late_point = 1;
            }
            // more than 1 hour
            else {
                $at_late_point = 3;
            }
        }

        return $at_late_point;
    }

    function getTotalTime($fg_date, $new_time_in, $new_time_out) {
        $to = new DateTime($fg_date . " " . $new_time_in);
        $from = new DateTime($fg_date . " " . $new_time_out);

        $stat = $to->diff($from); // DateInterval object
        return $at_total_time = $stat->format('%h hour %i minute');
    }

}
