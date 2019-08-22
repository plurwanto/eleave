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

class InventoryProcurementController extends Controller {

    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.inventory.iv_procurement');
    }

    public function getInventoryPro(Request $request) {
        $urlInventory = "procurement";
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            "start" => $request->post('start'),
            "limit" => $request->post('length'),
            "order" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][1]['search']['value'],
            "search_supplier" => $request['columns'][2]['search']['value'],
            "search_status" => $request['columns'][3]['search']['value'],
        ];
        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryData = json_decode($inventory, true);
        $err = "";
        $hasil = array();
        $no = $request->post('start');
        if ($inventoryData['response_code'] == 200) {
            $user_inventory = $inventoryData['data'];
            $object = json_decode(json_encode($user_inventory), TRUE);
            foreach ($object as $row) {
                $no++;
                $aksi = "";
                $auto_close = strtotime($row['entry_date'] . ' + 2 days');
                $today = strtotime("today midnight");

                $aksi .= "<a href='" . url('eleave/inventory_procurement/' . $row['procurement_id'] . '/view_detail/') . "' class='btn blue btn-xs' title='View'>
                            <i class='fa fa-info'></i></a>&nbsp;";

//                if ($today <= $auto_close) {
//                    //if ($this->general->privilege_check(INVENTORY, 'edit'))
//                    $aksi .= "<a href='" . url('eleave/inventory_procurement/' . $row['procurement_id']. '/edit/' ) . "' class='btn btn-xs yellow' title='Edit'>
//                            <i class='fa fa-edit'></i></a>&nbsp;&nbsp;";
//                }

                //if ($this->general->privilege_check(INVENTORY, 'remove'))
//                    $aksi .= "<a onclick='delete_procurement(" . $row['procurement_id'] . ")' class='btn btn-xs red' title='Delete'>
//                            <i class='fa fa-remove'></i></a>&nbsp;&nbsp;";

                if ($row['status'] == "0") {
                    $status = "Not Active";
                } elseif ($row['status'] == "1") {
                    $status = "Active";
                } elseif ($row['status'] == "2") {
                    $status = "Deleted";
                }

                $hasil[] = array("no" => $no,
                    "procurement_id" => $row['procurement_id'],
                    "procurement_name" => $row['procurement_name'],
                    "supplier_name" => $row['supplier_name'],
                    "created_by" => $row['user_request'],
                    "created_at" => $row['entry_date'],
                    "status" => $status,
                    "action" => $aksi);
            }
        } else {
            $err = $inventoryData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $inventoryData['recordsTotal'],
            "recordsFiltered" => $inventoryData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function get_data_detail(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlInventory = "procurement-get";
        $param = [
            'token' => session('token'),
            "isApp" => "web",
            'procurement_id' => $request->id,
        ];
        $inventory_id = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryList = json_decode($inventory_id, true);

        $result = "";
        if ($inventoryList['response_code'] == 200) {
            $result = json_decode(json_encode($inventoryList['data']), TRUE);
        } else {
            $result = $inventoryList['message'];
        }

        return view('Eleave.inventory.iv_pro_detail', ['list_item' => $result]);
    }

    public function get_data(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $numb = $request->post('arr_id');
        if (!empty($request->post('q'))) {
            $q = $request->post('q');
            $param = [
                'token' => session('token'),
                "isApp" => "web",
                'filter' => $q,
            ];
        } else {
            $param = [
                'token' => session('token'),
                "isApp" => "web",
                'isAll' => 'isAll'
            ];
        }

        $urlInventory = "stock";
        $inventory_id = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryList = json_decode($inventory_id, true);
        // dd($inventoryList);
        $rows = '';
        if ($inventoryList['response_code'] = 200) {
            if ($inventoryList['data']) {
                $i = 1;
                $j = 1;
                foreach ($inventoryList['data'] as $r) {
//                    if (!empty($numb)) {
//                        $cls = (in_array($r['item_id'], $numb) ? "btn btn-xs default disabled" : "btn btn-xs green");
//                    } else {
//                        $cls = ($r['quantity'] > 0 ? "btn btn-xs green" : "btn btn-xs default disabled");
//                    }
                    $cls = "btn btn-xs green"; // disable for GA Procurement
                    $rows .= '<tr>';

                    $rows .= '<td>' . $i . '</td>';
                    $rows .= '<td class="hidden">' . $r['item_id'] . '</td>';
                    $rows .= '<td>' . $r['item_name'] . '</td>';
                    $rows .= '<td>' . $r['quantity'] . '</td>';
                    $rows .= '<td>';
                    $rows .= '<a title="choose" id="btnchoose_' . $r['item_id'] . '" name="btnchoose[]" class="' . $cls . '" onclick="tab1_To_tab2(' . $i . ');" ><i class="fa fa-check"></i></a>';

                    $rows .= '</td>';

                    $rows .= '</tr>';

                    ++$i;
                    ++$j;
                }
            } else {

                $rows .= '<tr>';
                $rows .= '<td colspan="4">No data available in table</td>';
                $rows .= '</tr>';
            }
            echo json_encode(array('rows' => $rows, 'numb' => $numb, 'message' => $inventoryList['message'], 'alert-type' => 'success'));
        } else {
            echo json_encode(array('rows' => '', 'numb' => '', 'message' => $inventoryList['message'], 'alert-type' => 'warning'));
        }
    }

    public function add(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlInventory = "stock";
        $param = [
            'token' => session('token'),
            "isApp" => "web",
            'isAll' => 'isAll',
        ];
        $inventory_id = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryList = json_decode($inventory_id, true);

        $result = "";
        if ($inventoryList['response_code'] == 200) {
            $result = json_decode(json_encode($inventoryList['data']), TRUE);
        } else {
            $result = "";
            $request->session()->flash('message', $inventoryList['message']);
            $request->session()->flash('alert-type', 'warning');
        }

        return view('Eleave.inventory.iv_pro_add', ['list_item' => $result]);
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlInventory = 'request-get';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            "request_id" => $id,
        ];
        $inventory_id = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryList = json_decode($inventory_id, true);
        // dd($inventoryList);
        $result = "";
        if ($inventoryList['response_code'] == 200) {
            $result = json_decode(json_encode($inventoryList['data']), TRUE);
        } else {
            $result = $inventoryList['message'];
        }

        return view('Eleave.inventory.iv_edit', ['list_item' => $result]);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $userid = session('id');
        $id = $request->post('request_id');
        $employee_id = $request->post('employee_id');
        $subject = $request->post('subject_name');
        $itemNo = $request->post('itemNo');
        $supp_id = $request->post('supplier_id');
        $qty = $request->post('quantity');
        $cost = $request->post('cost');

        $array = array();
        for ($i = 0; $i < count($itemNo); $i++) {
            $array[] = array(
                'item_id' => $itemNo[$i],
                'quantity' => $qty[$i],
                //'quantity_old' => $qty[$i],
                'total_cost' => $cost[$i]
            );
        }

        $urlInventory = 'procurement-save';
        $param = [
            'token' => session('token'),
            "isApp" => "web",
            'user_procurement' => $employee_id,
            'procurement_name' => $subject,
            'status' => "1",
            'entry_date' => date('Y-m-d'),
            'supplier_id' => $supp_id,
            'item' => $array
        ];
        //dd($param);
        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventorySave = json_decode($inventory, true);
        
        if ($inventorySave['response_code'] == 200) {
            return redirect('eleave/inventory_procurement/index')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/inventory_procurement/add')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'error'));
        }
    }

    public function update(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $userid = session('id');
        $request_id = $request->post('request_id');
        $employee_id = $request->post('employee_id');
        $subject = $request->post('subject_name');
        $itemId = $request->post('itemId');
        $itemNo = $request->post('itemNo');
        $stockFirst = $request->post('stock');
        $qty = $request->post('quantity');
        $rev_qty = $request->post('revisi');

        $array = array();
        for ($i = 0; $i < count($itemNo); $i++) {
            $array[] = array(
                'id' => $itemId[$i],
                'item_id' => $itemNo[$i],
                'stock_first' => $stockFirst[$i],
                'quantity' => $qty[$i],
                'rev_quantity' => $rev_qty[$i]
            );
        }

        $urlInventory = 'request-update';
        $param = [
            'token' => session('token'),
            "isApp" => "web",
            'request_id' => $request_id,
            'user_request' => $employee_id,
            'request_name' => $subject,
            'status' => "1",
            'item' => $array
        ];

        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventorySave = json_decode($inventory, true);
        // dd($inventorySave);
        if ($inventorySave['response_code'] == 200) {
            return redirect('eleave/inventory/index')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/inventory/' . $request_id . '/edit')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'error'));
        }
    }

    public function ajax_status_request(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $request_id = $request->post('request_id');
        $employee_id = $request->post('employee_id');
        $subject = $request->post('subject_name');
        $itemId = $request->post('itemId');
        $itemNo = $request->post('itemNo');
        $stockFirst = $request->post('stock');
        $qty = $request->post('quantity');
        $rev_qty = $request->post('revisi');
        $btn_status = $request->post('btn_submit');
        $status = ($btn_status == "btn_receive" ? "4" : "3");

        $array = array();
        for ($i = 0; $i < count($itemNo); $i++) {
            $array[] = array(
                'id' => $itemId[$i],
                'item_id' => $itemNo[$i],
                'stock_first' => $stockFirst[$i],
                'quantity' => $qty[$i],
                'rev_quantity' => $rev_qty[$i]
            );
        }

        $urlInventory = 'request-update';
        $param = [
            'token' => session('token'),
            'request_id' => $request_id,
            'request_name' => $subject,
            'status' => $status,
            'user_request' => $employee_id,
            'item' => $array
        ];

        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventorySave = json_decode($inventory, true);

        if ($inventorySave['response_code'] == 200) {
            return redirect('eleave/inventory/index')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/inventory/' . $request_id . '/view_detail')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'error'));
        }
    }

    ///start for GA execution ---------------------------------------------------------------------------
    function all_request(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.inventory.iv_ga_index');
    }

    function all_processed(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.inventory.iv_ga_process');
    }

    public function getInventoryGa(Request $request) {

        $urlInventory = "request-summaryWeb";
        $param = [
            "token" => session('token'),
            "skip" => $request->post('start'),
            "limit" => $request->post('length'),
            "order" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][1]['search']['value'],
            "search_status" => $request['columns'][2]['search']['value'],
            "search_batch" => $request['columns'][3]['search']['value'],
        ];
        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryData = json_decode($inventory, true);

        $err = "";
        $hasil = array();
        $no = $request->post('start');
        if ($inventoryData['response_code'] == 200) {
            $user_inventory = $inventoryData['data'];
            $object = json_decode(json_encode($user_inventory), TRUE);
            foreach ($object as $row) {
                $no++;
                $aksi = "";
                $aksi .= "<a href='" . url('eleave/inventory/' . $row['request_id'] . '/view_detail?request=all') . "' class='btn blue btn-xs' title='View'>
                            <i class='fa fa-info'></i></a>&nbsp;";

//                if ($row['stock_qty'] >= $row['tot_qty']) {
//                    $aksi .= "<a onclick='verify(" . $row['request_id'] . ")' class='btn green btn-xs' title='verify'>
//                            <i class='fa fa-check-square'></i></a>&nbsp;";
//                } else {
//                    $aksi .= "<a href='" . url('eleave/inventory/' . $row['request_id'] . '/edit?request=all') . "' class='btn yellow btn-xs' title='Edit'>
//                            <i class='fa fa-edit'></i></a>&nbsp;";
//                }

                if ($row['status'] == "1") {
                    $status = "Requested";
                } elseif ($row['status'] == "2") {
                    $status = "Prepare";
                } elseif ($row['status'] == "3") {
                    $status = "Reject";
                } elseif ($row['status'] == "4") {
                    $status = "Done";
                } elseif ($row['status'] == "5") {
                    $status = "Ready";
                } elseif ($row['status'] == "6") {
                    $status = "Unfulfilled";
                }

                if ($row['status'] == "1") {
                    $hasil[] = array("no" => $no,
                        "request_id" => $row['request_id'],
                        "request_name" => $row['request_name'],
                        "batch_id" => $row['batch_id'],
                        "status" => $status,
                        "created_by" => $row['user_id'],
                        "created_at" => date('d M y', strtotime($row['created_at']['date'])),
                        "action" => $aksi);
                }
            }
        } else {
            $err = $inventoryData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $inventoryData['recordsTotal'],
            "recordsFiltered" => $inventoryData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function ga_update_request(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $userid = session('id');
        $request_id = $request->post('request_id');
        $employee_id = $request->post('employee_id');
        $subject = $request->post('subject_name');
        $itemId = $request->post('itemId');
        $itemNo = $request->post('itemNo');
        $stockFirst = $request->post('stock');
        $qty = $request->post('quantity');
        $rev_qty = $request->post('revisi');
        $btn_status = $request->post('btn_submit');
        $status = ($btn_status == "btn_receive" ? "4" : "3");

        $array = array();
        for ($i = 0; $i < count($itemNo); $i++) {
            $array[] = array(
                'item_id' => $itemNo[$i],
                'request_id' => $request_id,
                'rev_quantity' => $rev_qty[$i]
            );
        }

        $urlInventory = 'request-revQtyUpdate';
        $param = [
            'token' => session('token'),
            'items' => $array
        ];

        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventorySave = json_decode($inventory, true);
        // dd($inventorySave);
        if ($inventorySave['response_code'] == 200) {
            return redirect('eleave/inventory/all_request')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/inventory/' . $request_id . '/edit?request=all')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'error'));
        }
    }

    public function getInventoryGaProcess(Request $request) {

        $urlInventory = "request-summaryWeb";
        $param = [
            "token" => session('token'),
            "skip" => $request->post('start'),
            "limit" => $request->post('length'),
            "order" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][1]['search']['value'],
            "search_status" => $request['columns'][2]['search']['value'],
            "search_batch" => $request['columns'][3]['search']['value'],
        ];
        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryData = json_decode($inventory, true);

        $err = "";
        $hasil = array();
        $no = $request->post('start');
        if ($inventoryData['response_code'] == 200) {
            $user_inventory = $inventoryData['data'];
            $object = json_decode(json_encode($user_inventory), TRUE);
            foreach ($object as $row) {
                $no++;
                $aksi = "";
                $aksi .= "<a href='" . url('eleave/inventory/' . $row['request_id'] . '/view_detail?request=all') . "' class='btn blue btn-xs' title='View'>
                            <i class='fa fa-info'></i></a>&nbsp;";

//                if ($row['stock_qty'] >= $row['tot_qty']) {
//                    $aksi .= "<a onclick='verify(" . $row['request_id'] . ")' class='btn green btn-xs' title='verify'>
//                            <i class='fa fa-check-square'></i></a>&nbsp;";
//                } else {
//                    $aksi .= "<a href='" . url('eleave/inventory/' . $row['request_id'] . '/edit?request=all') . "' class='btn yellow btn-xs' title='Edit'>
//                            <i class='fa fa-edit'></i></a>&nbsp;";
//                }

                if ($row['status'] == "1") {
                    $status = "Requested";
                } elseif ($row['status'] == "2") {
                    $status = "Prepare";
                } elseif ($row['status'] == "3") {
                    $status = "Reject";
                } elseif ($row['status'] == "4") {
                    $status = "Done";
                } elseif ($row['status'] == "5") {
                    $status = "Ready";
                } elseif ($row['status'] == "6") {
                    $status = "Unfulfilled";
                }

                if ($row['status'] == "2") {
                    $hasil[] = array("no" => $no,
                        "request_id" => $row['request_id'],
                        "request_name" => $row['request_name'],
                        "batch_id" => $row['batch_id'],
                        "status" => $status,
                        "created_by" => $row['user_id'],
                        "created_at" => date('d M y', strtotime($row['created_at']['date'])),
                        "action" => $aksi);
                }
            }
        } else {
            $err = $inventoryData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $inventoryData['recordsTotal'],
            "recordsFiltered" => $inventoryData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

//    public function destroy(Request $request) {
//        if (!Session::has('token')) {
//            return redirect('/login');
//        }
//        $id = $request->id;
//        $urlInventory = 'eleave/inventory/delete';
//        $param = [
//            "token" => session('token'),
//            "iv_id" => $id,
//        ];
//
//        $inventory_id = ElaHelper::myCurlInventory($urlInventory, $param);
//        $inventoryList = json_decode($inventory_id, true);
//        $ot = "";
//        if ($inventoryList['response_code'] == 200) {
//            $ot = array('status' => true, 'message' => $inventoryList['message']);
//        } else {
//            $ot = array('status' => false);
//        }
//        echo json_encode($ot);
//    }
}
