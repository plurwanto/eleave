<?php
namespace App\Http\Model\Eleave;

use Illuminate\Database\Eloquent\Model;
use DB;

class Attendance extends Model {

    protected $connection = 'mysql_eleave';
    protected $table = 'attendance';
    protected $primaryKey = 'at_id';
    
    public static function checkAttendanceByFinger($branch_id, $user_id, $fg_date) {
        $userAtt = Self::selectRaw('attendance.at_date,attendance.at_time_in,attendance.at_time_out')
                ->where('branch_id', $branch_id)->where('user_id', $user_id)->where('at_date', $fg_date)
                ->orderBy('at_id', 'ASC');
        return $userAtt;
    }
    
    public static function checkAttendanceByFingerByDate($branch_id, $user_id, $fg_date) {
        $userAtt = Self::selectRaw('attendance.user_id,attendance.at_date,attendance.at_time_in,attendance.at_time_out,attendance.at_total_time,attendance.branch_id,attendance.at_finger_print_id,attendance.at_late_point')
                ->whereIn('branch_id', $branch_id)->whereIn('user_id', $user_id)->whereIn('at_date', $fg_date)
                ->orderBy('at_id', 'ASC');
        return $userAtt;
    }
    
    public static function saveAttendance($user_id, $branch_id, $fg_date, $fg_time_in, $fg_time_out, $at_total_time, $fg_print_id, $at_late_point) {
        $at_insert = new static;
        $at_insert->user_id = $user_id;
        $at_insert->branch_id = $branch_id;
        $at_insert->at_date = $fg_date;
        $at_insert->at_time_in = $fg_time_in;
        $at_insert->at_time_out = $fg_time_out;
        $at_insert->at_total_time = $at_total_time;
        $at_insert->at_finger_print_id = $fg_print_id;
        $at_insert->at_late_point = $at_late_point;
        $at_insert->att_time_in_images = 0;
        $at_insert->save();
        
        return $at_insert;
    }

    
}
