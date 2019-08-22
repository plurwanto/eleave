<?php
namespace App\Http\Controllers\Eleave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Model\Eleave\User;
use App\Http\Model\Eleave\UserLevel;
use Session;
use DB;
use App\ElaHelper;
use DateTime;

class HomeController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/logout');
        }

        $urlSession = 'eleave/user/usersession';
        $urlBranch = 'eleave/user/branch';
        $urlPolicy = 'eleave/user/policy';
        $urlSetting = 'eleave/setting/index';
        $param = [
            "token" => session('token'),
        ];
        $param_branch = [
            "token" => session('token'),
            "branch_id" => session('branch_id')
        ];

        $login = ElaHelper::myCurl($urlSession, $param);
        $userAccess = json_decode($login, true);
        $err = "";
        $result_branch = array();

        if ($userAccess['response_code'] == 200) {
            session($userAccess['user_session']);

            $result_policy = $userAccess['user_policy'];
            $result_summary = $userAccess['user_leave_summary'];

            $user_branch = $userAccess['user_branch'];
            foreach ($user_branch as $value) {
                $result_branch[] = array(
                    "user_name" => $value['user_name']
                );
            }
        } else {
            $err .= session()->flash('message', $userAccess['message']);
            $err .= session()->flash('alert-type', 'warning');
            $result_policy = "";
            $result_summary = "";
        }

        $datetime1 = new DateTime(session('user_join_date'));
        $datetime2 = new DateTime();
        $contribDay = $datetime1->diff($datetime2);

        $data = [
            'user_branch' => $result_branch,
            'policy' => $result_policy,
            'leave_summary' => $result_summary,
            'err' => $err,
            'contribDay' => $contribDay
        ];

        $config = ElaHelper::myCurl($urlSetting, $param);
        $configAccess = json_decode($config, true);
//dd($configAccess);
        if (session('is_admin') == 1) {
            return view('Eleave.dashboard.new-home', $data);
        } else {
            if ($configAccess['response_code'] == 200) {
                $cek_serv = $configAccess['data'];
                if ($cek_serv['server_maintenance'] == 1) {
                    return view('errors.500');
                } else {
                    return view('Eleave.dashboard.new-home', $data);
                    // return view('Eleave.dashboard.leaveSummary', ['user_branch' => $result_branch, 'policy' => $result_policy, 'leave_summary' => $result_summary, 'err' => $err]);
                }
            }else{
                return redirect('/logout');
            }
        }
    }

    public function home(Request $request) {
        $urlPolicy = 'eleave/user/policy';
        $param = [
            "token" => session('token'),
            "branch_id" => session('branch_id')
        ];

        $policy = ElaHelper::myCurl($urlPolicy, $param);
        $userPolicy = json_decode($policy, true);
        //   dd($userPolicy['data'][0]);
        $result_policy = array();
        if ($userPolicy['response_code'] == 200) {
            $user_policy = $userPolicy['data'];
            foreach ($user_policy as $value) {
                $result_policy[] = array(
                    "pol_attendance" => $value['pol_attendance']
                );
            }
        } else {
            $err = $userPolicy['message'];
        }
        json_encode(array('policy' => $result_policy));
    }

    public function getPolicy($policy) {
        $urlPolicy = 'eleave/user/policy';
        $param = [
            "token" => session('token'),
            "branch_id" => session('branch_id')
        ];

        $policyData = ElaHelper::myCurl($urlPolicy, $param);
        $userPolicy = json_decode($policyData, true);
       
       
        if ($userPolicy['response_code'] == 200) {
            $user_policy = $userPolicy['data'];
            
            foreach ($user_policy as $val) {
                if ($policy == 'attendance') {
                    $filename = $val["pol_attendance"];
                } elseif ($policy == 'leave') {
                    $filename = $val["pol_leave"];
                } else {
                    $filename = $val["pol_workplace"];
                }
            }
        } else {
            $err = $userPolicy['message'];
            $filename = "";
        }

      $path = public_path($filename);

      return response()->download($path);
    }

}
