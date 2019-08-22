<?php
namespace App\Http\Controllers\Eleave\Setting;

use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;
use DB;
use App\ElaHelper;

class SettingController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlSetting = 'eleave/setting/index';
        $param = [
            "token" => session('token'),
        ];

        $setting = ElaHelper::myCurl($urlSetting, $param);
        $settingData = json_decode($setting, true);

        $list_setting = "";
        if ($settingData['response_code'] == 200) {
            $list_setting = json_decode(json_encode($settingData['data']), FALSE);
        } else {
            $list_setting = "";
        }
        //dd($list_setting);
        return view('Eleave.config.setting', ['global_setting' => $list_setting]);
    }

    public function update(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        if ($request->post('server_status') == 'on') {
            $server_status = 1;
        } else {
            $server_status = 0;
        }
        if ($request->post('flag_email') == 'on') {
            $flag_email = 1;
        } else {
            $flag_email = 0;
        }
        if ($request->post('flag_overtime') == 'on') {
            $flag_overtime = 1;
        } else {
            $flag_overtime = 0;
        }


        $urlSetting = 'eleave/setting/update';
        $param = [
            'token' => session('token'),
            'id' => $request->post('id'),
            'server_status' => $server_status,
            'flag_email' => $flag_email,
            'flag_overtime' => $flag_overtime,
            'gs_max_forward_day' => $request->post('gs_max_forward_day'),
            'gs_min_time' => $request->post('gs_min_time'),
        ];
//dd($param);
        $setting = ElaHelper::myCurl($urlSetting, $param);
        $settingData = json_decode($setting, true);

        if ($settingData['response_code'] == 200) {
            return redirect('eleave/setting/index')
                            ->with(array('message' => $settingData['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/setting/index')
                            ->with(array('message' => $settingData['message'], 'alert-type' => 'error'));
        }
    }

}
