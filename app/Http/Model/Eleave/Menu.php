<?php
namespace App\Http\Model\Eleave;

use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model {

    public $timestamps = false;
    protected $connection = 'mysql_eleave';
    protected $table = 'userlevels_privilege';
    protected $primaryKey = 'id_akses';

    public static function privilege_check($page_id, $do = null)
    {
        $result = Self::join('user AS a', 'userlevels_privilege.level_id', 'a.level_id')
                        ->where('userlevels_privilege.modul',$page_id)
                        ->where('a.level_id',session('level_id'));

        if($do != null)
        {
            $result = $result->where('userlevels_privilege.'.$do,1);
        }

        $result = $result->count();

        if ($result > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public static function privilege_check_approver($page_id, $do = null)
    {
        $result = Self::join('user AS a', 'userlevels_privilege.user_id', 'a.user_id')
                        ->where('userlevels_privilege.modul',$page_id)
                        ->where('a.user_id',session('id'))
                        ->where('a.is_approver',1);

        if($do != null)
        {
            $result = $result->where('userlevels_privilege.'.$do,1);
        }

        $result = $result->count();

        if ($result > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
