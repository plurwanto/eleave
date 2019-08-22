<?php
namespace App\Http\Model\Eleave;

use Illuminate\Database\Eloquent\Model;
use DB;

class Finger extends Model {

    public $timestamps = false;
    protected $connection = 'mysql_eleave';
    protected $table = 'finger';
    
}
