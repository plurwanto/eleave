<?php
namespace App\Http\Model\Eleave;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model {

    public $timestamps = false;
    protected $connection = 'mysql_eleave';
    protected $table = 'user';
    protected $primaryKey = 'id';

    public static function split_name($name) {
        $parts = explode(' ', $name);
        $num = count($parts);
        $firstname = $parts[0]; //implode(" ", $parts);
        $middlename = ($num > 1 ? $parts[1] : '');
        $lastname = array_pop($parts);
        if (strlen($firstname) == 1) {
            $name_show = $firstname . ' ' . $middlename . ' ' . $lastname;
        } else {
            $name_show = $firstname . ' ' . $lastname;
        }
        return ($num == 1) ? $firstname : $name_show;
    }

}
