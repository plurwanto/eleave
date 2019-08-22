<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index";
                </script>';
        }

        $data['title'] = 'Dashboard';
        $param = [
            "id_hris" => session('id_hris'),
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl('hris/get-customer', $param));
        if ($request->has('customer') or $request->get('customer') != 0) {
            $customer = $request->get('customer');
        } else {
            $customer = '';

        }
        $data['cus_id'] = $customer;
        $param = [
            "customer" => $customer,
            "id_hris" => session('id_hris'),
            "token" => session('token'),
        ];
        $hasil = json_decode(ElaHelper::myCurl('hris/dashboard', $param));

        $param = [
            "order" => ["nama", "ASC"],
            "fields" => ["user_id", "nama", "div_id"],
            "where" => ["user_id", session('id_hris')],
            "table" => "_muser",
        ];
        $user = json_decode(ElaHelper::myCurl('master-global', $param));
        $data['div_id'] = explode(',', $user->result[0]->div_id);

        if ($hasil->response_code == 200) {
            $data['topTen'] = json_encode($hasil->topTen);
            $data['employeeBranch'] = json_encode($hasil->employeeBranch);

            $data['passportEnd'] = $hasil->activity->passportEnd;
            $data['contractEnd'] = $hasil->activity->contractEnd;
            $data['contractActive'] = $hasil->activity->contractActive;
            $data['employeeActive'] = $hasil->activity->employeeActive;

        } else {
            $data['topTen'] = json_encode($hasil->topTen);
            $data['employeeBranch'] = json_encode($hasil->employeeBranch);

            $data['passportEnd'] = '';
            $data['contractEnd'] = '';
            $data['contractActive'] = '';
            $data['employeeActive'] = '';
        }

        $data['access'] = ElaHelper::getMenuHRIS(34, session('id_hris'));
        $data['payroll'] = [];
        if ($data['access']) {
            if ($data['access']->menu_acc_view == 1) {

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];
                $payrollApp = json_decode(ElaHelper::myCurl('hris/dashboard/payroll-approval', $param));
                $data['payroll'] = $payrollApp->activity;
            }
        }

        if ($request->has('year')) {
            $year = $request->get('year');
        } else {
            $year = date('Y');
        }
        $data['year'] = $year;

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "year" => $year,
        ];

        $kam = json_decode(ElaHelper::myCurl('hris/dashboard/get-kam', $param));
        $data['res'] = $kam;
        $data['kam'] = $kam->activity;
        $data['kam_footer'] = $kam->footer;

        return view('HRIS.dashboard.index', $data);
    }

    public function getProfile(Request $request)
    {
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => $request->get('id'),
        ];
        $data['id'] = $request->get('id');
        $data['profile'] = json_decode(ElaHelper::myCurl('hris/get-profile-hris', $param));
        $data['title'] = 'Profile Detail';

        return view('HRIS.dashboard.profile', $data);

    }

    public function doUpdateProfile(Request $request)
    {
        $email = $request->get('email');
        $newPassword = $request->get('newPassword');

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "newPassword" => $newPassword,
            "email" => $email,
        ];

        $rows = json_decode(ElaHelper::myCurl('hris/do-update-profile', $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);

    }
}
