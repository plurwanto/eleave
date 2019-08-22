<?php
namespace App\Http\Model\Eleave;

use Illuminate\Database\Eloquent\Model;

class GlobalMaster extends Model {

    public $timestamps = false;
    protected $connection = 'mysql_eleave';
   // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'department';
//    protected $fillable = [
//        'department_id', 'department_name',
//    ];

}
