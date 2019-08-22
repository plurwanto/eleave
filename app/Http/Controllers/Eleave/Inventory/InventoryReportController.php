<?php
namespace App\Http\Controllers\Eleave\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;
use DateTime;
use URL;

class InventoryReportController extends Controller {

    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.inventory.iv_report');
    }

    public function show(Request $request) {
        $token = session('token');
        $isMonth = $request->get('slt_month');
        $isYear = $request->get('slt_year');

        $urlInventory = "stock-report";
        $param = [
            "token" => $token,
            "isApp" => "web",
            "is_month" => $isMonth,
            "is_year" => $isYear,
        ];

        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryData = json_decode($inventory, true);
        $err = "";

        if ($inventoryData['response_code'] == 200) {
            $no = 1;
            $user_inventory = $inventoryData['data'];
            //$object = json_decode(json_encode($user_inventory), TRUE);
            $hasil = array();
            $hasil2 = array();
            $hasil3 = array();
            foreach ($user_inventory['stock_current'] as $key => $value) {
                $hasil[] = array("no" => $no++,
                    "item_id" => $value['id'],
                    "item_name" => $value['nama_item'],
                    "qty" => $value['quantity'],
                );
            }
            foreach ($user_inventory['stock_in'] as $key => $value) {
                $hasil2[] = array(
                    "qty_in" => $value['quantity'],
                );
            }
            foreach ($user_inventory['request_item'] as $key => $value) {
                $hasil3[] = array(
                    "qty_req" => $value['total_quantity'],
                );
            }

            $hasil = (!empty($hasil) ? $hasil : "");
            $hasil2 = (!empty($hasil2) ? $hasil2 : "");
            $hasil3 = (!empty($hasil3) ? $hasil3 : "");
//            $data['list_stock_current'] = $hasil;
//            $data['stock_in'] = $hasil2;
//            $data['stock_request'] = $hasil3;
        } else {
            $err = $inventoryData['message'];
        }

        return view('Eleave.inventory.iv_report', ['list_stock_current' => $hasil, 'stock_in' => $hasil2, 'stock_request' => $hasil3, 'err' => $err,
            'isMonth' => $isMonth, 'isYear' => $isYear]);
    }

}
