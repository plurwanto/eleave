<?php

namespace App\Http\Model\HRIS;

use App\ElaHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Navigation extends Model
{
    protected $table = 'hris_menu';
    protected $primaryKey = 'menu_id';

    public static function getMenu($url_current)
    {

        $urlMenu = 'hris/user-access';
        $param = [
            "id_eleave" => session('id_eleave'),
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "url_current" => $url_current,
        ];

    
        $login = ElaHelper::myCurl($urlMenu, $param);
        $userAccess = json_decode($login, true);

        return $userAccess;
    }
}
