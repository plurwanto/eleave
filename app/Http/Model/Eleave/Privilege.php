<?php
namespace App\Http\Model\Eleave;

use Illuminate\Database\Eloquent\Model;
use DB;

class Privilege extends Model {

    public $timestamps = false;
    protected $connection = 'mysql_eleave';
    protected $table = 'userlevels_privilege';
    protected $primaryKey = 'id_akses';

    public static function check_privilege_approver($id, $user_id) {
        return self::limit(1)->where(array('level_id' => $id, 'user_id' => $user_id))->count();
    }

    public static function check_privilege($id) {
        return self::limit(1)->where('level_id', $id)->count();
    }

    public static function get_role($modul, $id, $user_id) {

        if (!empty($user_id)) {
//            $sql = "SELECT * FROM elabram_elave.userlevels_privilege WHERE user_id = '$user_id' AND modul = '%s' AND level_id = %d";
//            $result = DB::select(sprintf($sql, $modul, $id, $user_id));
            $result = Self::where('user_id', $user_id)
                    ->where('modul', $modul)
                    ->where('level_id', $id)
                    ->first();
        } else {
//            $sql = "SELECT * FROM elabram_elave.userlevels_privilege WHERE modul = '%s' AND level_id = %d";
//            $result = DB::select(sprintf($sql, $modul, $id));
            $result = Self::where('modul', $modul)
                    ->where('level_id', $id)
                    ->first();
        }

//        $newArray = array();
//        foreach ($result as $array) {
//            foreach ($array as $k => $v) {
//                $newArray[$k] = $v;
//            }
//        }

//        if (count($newArray) > 0) {
        if (!empty($result)) {
            //    return $newArray;
            return $result;
        } else {
            return $q = array('view' => '', 'add' => '', 'edit' => '', 'remove' => '');
        }
    }

    public function simpan($data) {

        $arr = array();

        foreach ($data['data'] as $page_id => $page_akses) {

            if (!isset($page_akses['view']))
                $page_akses['view'] = 0;
            if (!isset($page_akses['add']))
                $page_akses['add'] = 0;
            if (!isset($page_akses['edit']))
                $page_akses['edit'] = 0;
            if (!isset($page_akses['remove']))
                $page_akses['remove'] = 0;
//            if (!isset($page_akses['cetak']))
//                $page_akses['cetak'] = 0;

            $tmp = array(
                'level_id' => $data['level_id'],
                'modul' => $page_id,
                'view' => $page_akses['view'],
                'add' => $page_akses['add'],
                'edit' => $page_akses['edit'],
                'remove' => $page_akses['remove'],
                //  'cetak' => $page_akses['cetak'],
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => session('id_eleave'), //$this->session->userdata('id'),
                'user_id' => 0,
            );
            $arr[] = $tmp;
        }

        /* meski tidak di centang...maka ttep sertakan array nya... */
        //take CONST where the modul is not checked (add,view etc) nya
        $n = $this->_olah_modul($data, $user_id = '');
        $vv = array();
        foreach ($n as $o) {
            $vv[] = array(
                'level_id' => $data['level_id'],
                'modul' => $o,
                'view' => 0,
                'add' => 0,
                'edit' => 0,
                'remove' => 0,
                //'cetak' => 0,
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => session('id_eleave'),
                'user_id' => 0,
            );
        }

        DB::beginTransaction();
        try {
            //remove first if exist
            self::where('level_id', '=', $data['level_id'])->delete();
            self::insert(array_merge($arr, $vv));
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            $data = array(
                'error' => 1,
                'message' => 'Failed to insert new request, Please try again',
            );
            return false;
        }
    }

    public function simpan_approver($data) {

        $arr = array();

        foreach ($data['data'] as $page_id => $page_akses) {

            if (!isset($page_akses['view']))
                $page_akses['view'] = 0;
            if (!isset($page_akses['add']))
                $page_akses['add'] = 0;
            if (!isset($page_akses['edit']))
                $page_akses['edit'] = 0;
            if (!isset($page_akses['remove']))
                $page_akses['remove'] = 0;
//            if (!isset($page_akses['cetak']))
//                $page_akses['cetak'] = 0;

            $tmp = array(
                'level_id' => $data['level_id'],
                'modul' => $page_id,
                'view' => $page_akses['view'],
                'add' => $page_akses['add'],
                'edit' => $page_akses['edit'],
                'remove' => $page_akses['remove'],
                //  'cetak' => $page_akses['cetak'],
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => session('id_eleave'),
                'user_id' => $data['txtuserid'],
            );
            $arr[] = $tmp;
        }

        /* meski tidak di centang...maka ttep sertakan array nya... */
        //take CONST where the modul is not checked (add,view etc) nya
        $n = $this->_olah_modul($data, $user_id = '');
        $vv = array();
        foreach ($n as $o) {
            $vv[] = array(
                'level_id' => $data['level_id'],
                'modul' => $o,
                'view' => 0,
                'add' => 0,
                'edit' => 0,
                'remove' => 0,
                //'cetak' => 0,
                'update_date' => date('Y-m-d H:i:s'),
                'update_by' => session('id_eleave'),
                'user_id' => $data['txtuserid'],
            );
        }

        DB::beginTransaction();
        try {
            //remove first if exist
            self::where(array('level_id' => $data['level_id'], 'user_id' => $data['txtuserid']))->delete();
            self::insert(array_merge($arr, $vv));
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            $data = array(
                'error' => 1,
                'message' => 'Failed to insert new request, Please try again',
            );
            return false;
        }
    }

    public function _olah_modul($data, $user_id) {

        if (!empty($user_id)) {
            $module = $this->modul_approval();
        } else {
            $module = $this->modul();
        }

        $m = array();
        $n = array();
        foreach ($data['data'] as $page_id => $x) {

            $m[] = $page_id;
        }

        foreach ($module as $mdl) {

            if (!in_array($mdl['const'], $m)) {

                $n[] = $mdl['const'];
            }

            if (isset($mdl['anak'])) {

                foreach ($mdl['anak'] as $k) {

                    if (!in_array($k['const'], $m)) {
                        $n[] = $k['const'];
                    }
                }
            }
        }

        return $n;
    }

    public function modul() {

        $module = array(
            array(
                'const' => 'HOME',
                'induk' => true,
                'name' => 'Home',
            ),
//            array(
//                'const' => 'DASHBOARD',
//                'induk' => true,
//                'name' => 'Dashboard',
//            ),
            array(
                'const' => 'EMPLOYEE',
                'induk' => true,
                'name' => 'Employee',
                'anak' => array(
                    array(
                        'const' => 'HR_DATA',
                        'name' => 'HR Data'
                    ), array(
                        'const' => 'EMPLOYEE_DATA',
                        'name' => 'Employee Data'
                    ), array(
                        'const' => 'EMPLOYEE_REQUEST',
                        'name' => 'Employee Request'
                    ),
                )
            ),
            array(
                'const' => 'ATTENDANCE',
                'induk' => true,
                'name' => 'Attendance',
                'anak' => array(
                    array(
                        'const' => 'ATTENDANCE_EMPLOYEE',
                        'name' => 'Attendance List'
                    ),
                    array(
                        'const' => 'ATTENDANCE_DATA',
                        'name' => 'Attendance Data'
                    ),
//                    array(
//                        'const' => 'UPLOAD_FINGER_PRINT',
//                        'name' => 'Upload Finger Print'
//                    ),
                )
            ),
            array(
                'const' => 'TIME_MANAGEMENT',
                'induk' => true,
                'name' => 'Time Management',
                'anak' => array(
                    array(
                        'const' => 'TIMESHEET',
                        'name' => 'Timesheet'
                    ),
                    array(
                        'const' => 'LEAVE',
                        'name' => 'Self Leave'
                    ),
                    array(
                        'const' => 'OVERTIME',
                        'name' => 'Self Overtime'
                    ),
                )
            ),
            array(
                'const' => 'STATIONERY',
                'induk' => true,
                'name' => 'Stationery',
                'anak' => array(
                    array(
                        'const' => 'STATIONERY_LIST',
                        'name' => 'My Stationery List'
                    ),
                    array(
                        'const' => 'STATIONERY_GA',
                        'name' => 'Stationery All Request'
                    ),
                    array(
                        'const' => 'STATIONERY_REPORT',
                        'name' => 'Stationery Report'
                    ),
                    array(
                        'const' => 'STATIONERY_PROCUREMENT',
                        'name' => 'Stationery Procurement'
                    ),
                )
            ),
            array(
                'const' => 'ROOM_BOOKING',
                'induk' => true,
                'name' => 'Room Booking',
                'anak' => array(
                    array(
                        'const' => 'ALL_ROOM_BOOKING',
                        'name' => 'All Room Booking'
                    ),
                    array(
                        'const' => 'MY_ROOM_BOOKING_HISTORY',
                        'name' => 'My Room Booking History'
                    ),
                    array(
                        'const' => 'BOOK_MEETING_ROOM',
                        'name' => 'Book Meeting Room'
                    ),
                )
            ),
            array(
                'const' => 'SUPPORT',
                'induk' => true,
                'name' => 'Support',
                'anak' => array(
                    array(
                        'const' => 'ALL_TICKETING',
                        'name' => 'All Ticketing'
                    ),
                    array(
                        'const' => 'ADD_TICKETING',
                        'name' => 'Add Ticketing'
                    ),
                    array(
                        'const' => 'REPORT_TICKETING',
                        'name' => 'Report Ticketing'
                    ),
                )
            ),
            array(
                'const' => 'CONFIG',
                'induk' => true,
                'name' => 'Config',
                'anak' => array(
                    array(
                        'const' => 'SETTING',
                        'name' => 'Setting'
                    ),
                    array(
                        'const' => 'ACCESS_PERMISSION',
                        'name' => 'Access Permission'
                    ),
                )
            ),
            array(
                'const' => 'MASTER',
                'induk' => true,
                'name' => 'Master',
                'anak' => array(
                    array(
                        'const' => 'DEPARTMENT',
                        'name' => 'Department'
                    ),
                    array(
                        'const' => 'ROOM',
                        'name' => 'Room'
                    ),
                    array(
                        'const' => 'INVENTORY',
                        'name' => 'Inventory'
                    ),
                    array(
                        'const' => 'HOLIDAY_LIST',
                        'name' => 'Holiday'
                    ),
                    array(
                        'const' => 'POLICY',
                        'name' => 'Policy'
                    ),
                )
            ),
            array(
                'const' => 'EXPENSES',
                'induk' => true,
                'name' => 'Expenses',
                'anak' => array(
                    array(
                        'const' => 'CASH_ADVANCE',
                        'name' => 'Cash Advance'
                    ),
                    array(
                        'const' => 'CLAIM',
                        'name' => 'Claim'
                    ),
                )
            ),
        );

        return $module;
    }

    function modul_approval() {
        $module_approval = array(
            array(
                'const' => 'DASHBOARD',
                'induk' => true,
                'name' => 'Dashboard',
            ),
            array(
                'const' => 'APPROVAL',
                'induk' => true,
                'name' => 'Approval',
                'anak' => array(
                    array(
                        'const' => 'TIMESHEET_APPROVAL',
                        'name' => 'Timesheet Approval'
                    ),
                    array(
                        'const' => 'LEAVE_APPROVAL',
                        'name' => 'Leave Approval'
                    ),
                    array(
                        'const' => 'OVERTIME_APPROVAL',
                        'name' => 'Overtime Approval'
                    ),
                    array(
                        'const' => 'CASH_ADVANCE_APPROVAL',
                        'name' => 'Cash Advance Approval'
                    ),
                    array(
                        'const' => 'CLAIM_APPROVAL',
                        'name' => 'Claim Approval'
                    ),
                )
            ),
            array(
                'const' => 'TEAM',
                'induk' => true,
                'name' => 'Team',
            ),
        );
        return $module_approval;
    }

}
