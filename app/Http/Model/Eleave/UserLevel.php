<?php
namespace App\Http\Model\Eleave;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserLevel extends Model {

    public $timestamps = false;
    protected $connection = 'mysql_eleave';
    protected $table = 'userlevels';
    protected $primaryKey = 'id';

    // public $fillable = ['userlevel_name', 'description'];

//    public static function getGroupUserLevel($id) {
//        $users = DB::table('user')
//                ->select('user.user_name,user.user_position,userlevels.userlevel_name')
//                ->leftJoin('userlevels', 'user.user_id', '=', 'userlevels.id')
//                ->where('user.level_id', $id)
//                ->get();
//        return $users;
//       // var_dump($users);
//    }
    
    public static function getTotalGroupUserLevel($id) {
        $totalUsers = Self::selectRaw('user.user_name,user.user_position,userlevels.userlevel_name')
                ->rightJoin('user', 'user.user_id', '=', 'userlevels.id')
                ->where('user.level_id', $id)
                ->count();
        return $totalUsers;
       // var_dump($users);
    }

}
