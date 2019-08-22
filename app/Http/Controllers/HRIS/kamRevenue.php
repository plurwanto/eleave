<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class kamRevenue extends Controller
{
    public $menuID = 43;

    public function index(Request $request)
    {

        if (!session('token')) {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index";
                </script>';
        }
        $data['access'] = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));
        if ($data['access']) {
            if ($data['access']->menu_acc_view != 1) {
                echo '<script type="text/javascript">
                        window.alert("you don\'t have access");
                        window.location.href="' . env('APP_URL') . '/index";
                      </script>';

            }
        } else {
            echo '<script type="text/javascript">
                    window.alert("you don\'t have access");
                    window.location.href="' . env('APP_URL') . '/index";
                  </script>';
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
        $data['kam'] = $kam->activity;

        $data['title'] = 'KAM Revenue';
        $data['subtitle'] = 'List KAM Revenue';
        return view('HRIS.finance.kam.index', $data);
    }

    public function add(Request $request)
    {
        $data['id'] = session("id_hris");

        $data['link'] = $request->get('link');
        $data['title'] = 'Add KAM Revenue';
        $data['subtitle'] = 'List KAM Revenue';

        $urlMenu = 'master-global';
        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "where" => ["cur_active", "Y"],
            "table" => "_mcurrency",
        ];
        $data['currency'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $param = [
            "token" => session('token'),
        ];
        $data['kam'] = json_decode(ElaHelper::myCurl('hris/customer/kam', $param));

        $urlMenu = 'hris/get-profile-hris';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "id" => session('id_hris'),
        ];
        $data['profile'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        return view('HRIS.finance.kam.add', $data);

    }

    public function getRevenue(Request $request)
    {
        $year = $request->get('year');
        $type = $request->get('type');
        $id = $request->get('user_id');

        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "table" => "_mcurrency",
        ];
        $cur = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "year" => $year,
            "type" => $type,
            "id" => $id,
            "id_hris" => session('id_hris'),
            "token" => session('token'),
        ];

        $rev = json_decode(ElaHelper::myCurl('hris/kam-revenue/get-revenue', $param));
        if ($rev->result) {
            echo '
            <div class="form-group">
                <label class="col-md-4 control-label">Currency <font color="red">*</font></label>
                <div class="col-md-6">
                    <select name="currency" class="form-control">
                        <option value="">-- choose a currency --</option>';
            for ($i = 0; $i < count($cur->result); $i++) {
                if ($rev->result->currency == $cur->result[$i]->cur_id) {
                    echo '<option value="' . $cur->result[$i]->cur_id . '" selected>' . $cur->result[$i]->cur_name . '</option>';
                } else {
                    echo '<option value="' . $cur->result[$i]->cur_id . '">' . $cur->result[$i]->cur_name . '</option>';
                }
            }
            echo '</select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Revenue Target <font color="red">*</font></label>
                <div class="col-md-6">
                <input type="text" name="revenue_kpi" class="form-control" value="' . $rev->result->revenue_kpi . '"  oninput="formatRupiah(this)">
                </div>
            </div>';
            $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bln = 01;
            for ($a = 0; $a < count($rev->result->detail); $a++) {
                echo '<div class="form-group">
                        <label class="col-md-4 control-label">' . $month[$a] . '</label>
                        <div class="col-md-6">
                            <input type="text" name="revenue_target[]" class="form-control"  oninput="formatRupiah(this)" value="' . $rev->result->detail[$a]->total . '">
                            <input type="hidden" name="month[]" value="' . $rev->result->year . '-' . sprintf("%'02d", $bln++) . '-01">

                        </div>
                    </div>';
            }
        } else {
            echo '
            <div class="form-group">
                <label class="col-md-4 control-label">Currency <font color="red">*</font></label>
                <div class="col-md-6">
                    <select name="currency" class="form-control">
                        <option value="">-- choose a currency --</option>';
            for ($i = 0; $i < count($cur->result); $i++) {
                echo '<option value="' . $cur->result[$i]->cur_id . '">' . $cur->result[$i]->cur_name . '</option>';

            }
            echo '</select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Revenue Target <font color="red">*</font></label>
                <div class="col-md-6">
                <input type="text" name="revenue_kpi" class="form-control"  oninput="formatRupiah(this)">
                </div>
            </div>';
            $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $bln = 01;
            for ($a = 0; $a < 12; $a++) {
                echo '<div class="form-group">
                        <label class="col-md-4 control-label">' . $month[$a] . '</label>
                        <div class="col-md-6">
                            <input type="text" name="revenue_target[]" class="form-control"  oninput="formatRupiah(this)">
                            <input type="hidden" name="month[]" value="' . $year . '-' . sprintf("%'02d", $bln++) . '-01">

                        </div>
                    </div>';
            }

        }

    }

    public function doAdd(Request $request)
    {
        $user_id = $request->post('user_id') != null ? $request->post('user_id') : "";

        $year = $request->post('year_add') != null ? $request->post('year_add') : "";
        $type = $request->post('type') != null ? $request->post('type') : "";
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $revenue_kpi = $request->post('revenue_kpi') != null ? $request->post('revenue_kpi') : "";
        $revenue_target = $request->post('revenue_target') != null ? $request->post('revenue_target') : "";
        $month = $request->post('month') != null ? $request->post('month') : "";
        $company_name = $request->post('company_name') != null ? $request->post('company_name') : "";

        $urlMenu = 'hris/kam-revenue/do-add';
        $param = [
            'user_id' => strip_tags($user_id),
            'year' => strip_tags($year),
            'type' => strip_tags($type),
            'currency' => strip_tags($currency),
            'revenue_kpi' => strip_tags($revenue_kpi),
            'revenue_target' => $revenue_target,
            'month' => $month,
            'company_name' => strip_tags($company_name),
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }
}
