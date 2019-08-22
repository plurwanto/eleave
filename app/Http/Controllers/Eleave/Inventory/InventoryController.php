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

class InventoryController extends Controller {

    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.inventory.iv_index');
    }

    public function getInventory(Request $request) {
        $token = session('token');
        $isAll = 'isAll';
        $is_req_ga = 'is_req_ga';
        $urlInventory = "request?token=" . $token . "&isAll=" . $isAll . "&is_req_ga=" . $is_req_ga . "";
        //dd($urlInventory);
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
            "isApp" => "web",
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
                $aksi .= "<a href='" . url('eleave/inventory/' . $row['request_id'] . '/view_detail/') . "' class='btn blue btn-xs' title='View'>
                            <i class='fa fa-info'></i></a>&nbsp;";

                if ($row['status'] == "1" && $row['user_request'] == session('nama')) {
                    $aksi .= "<a href='" . url('eleave/inventory/' . $row['request_id'] . '/edit/') . "' class='btn yellow btn-xs' title='Edit'>
                            <i class='fa fa-edit'></i></a>&nbsp;";
                    $aksi .= "<a href='" . url('eleave/inventory/' . $row['request_id'] . '/view_detail' . '?act=cancel') . "' class='btn red btn-xs' title='Delete'>
                               <i class='fa fa-trash'></i></a>&nbsp;&nbsp;";
                } elseif ($row['status'] == "5" && $row['user_request'] == session('nama')) {
                    $aksi .= "<a href='" . url('eleave/inventory/' . $row['request_id'] . '/view_detail' . '?act=receive') . "' class='btn green btn-xs' title='Receive'>
                            <i class='fa fa-check-square-o'></i></a>&nbsp;";
                } else {
                    $aksi .= "";
                }


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

                $hasil[] = array("no" => $no++,
                    "request_id" => $row['request_id'],
                    "request_name" => $row['request_name'],
                    "batch_id" => $row['batch_id'],
                    "status" => $status,
                    "created_by" => $row['user_request'],
                    "created_at" => date('d M y', strtotime($row['created_at']['date'])), //date('d-m-Y H:i', strtotime($row['created_at']['date'])),
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

        $urlInventory = "request-get";
        $param = [
            'token' => session('token'),
            'request_id' => $request->id,
            "isApp" => "web",
        ];
        $inventory_id = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventoryList = json_decode($inventory_id, true);

        $result = "";
        if ($inventoryList['response_code'] == 200) {
            $result = json_decode(json_encode($inventoryList['data']), TRUE);
        } else {
            $result = $inventoryList['message'];
        }

        return view('Eleave.inventory.iv_detail', ['list_item' => $result]);
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
                'filter' => $q,
                "isApp" => "web",
            ];
        } else {
            $param = [
                'token' => session('token'),
                'isAll' => 'isAll',
                "isApp" => "web",
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
                    if (!empty($numb)) {
                        $cls = (in_array($r['item_id'], $numb) ? "btn btn-xs default disabled" : "btn btn-xs green");
                    } else {
                        $cls = ($r['quantity'] > 0 ? "btn btn-xs green" : "btn btn-xs default disabled");
                    }
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
            'isAll' => 'isAll',
            "isApp" => "web",
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

        return view('Eleave.inventory.iv_new', ['list_item' => $result]);
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlInventory = 'request-get';
        $param = [
            "token" => session('token'),
            "request_id" => $id,
            "isApp" => "web",
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
        $stockFirst = $request->post('stock');
        $qty = $request->post('quantity');

        $day = date('D');
        $time = date('H');
        $daysArray1 = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri');
        $daysArray2 = array('Fri', 'Sat', 'Sun', 'Mon');
        if (($day == 'Mon' && $time >= '08') || in_array($day, $daysArray1) || ($day == 'Fri' && $time <= '13')) {
            $batch = "1";
        } elseif (($day == 'Fri' && $time >= '13') || in_array($day, $daysArray2) || ($day == 'Mon' && $time <= '08')) {
            $batch = "2";
        }

        $array = array();
        for ($i = 0; $i < count($itemNo); $i++) {
            $array[] = array(
                'item_id' => $itemNo[$i],
                'stock_first' => $stockFirst[$i],
                'quantity' => $qty[$i]
            );
        }

        $urlInventory = 'request-save';
        $param = [
            'token' => session('token'),
            "isApp" => "web",
            'user_request' => $employee_id,
            'request_name' => $subject,
            'status' => "1",
            'batch_id' => $batch,
            'item' => $array,
        ];

        $inventory = ElaHelper::myCurlInventory($urlInventory, $param);
        $inventorySave = json_decode($inventory, true);
        // dd($inventorySave);
        if ($inventorySave['response_code'] == 200) {
            return redirect('eleave/inventory/index')
                            ->with(array('message' => $inventorySave['message'], 'alert-type' => 'success'));
        } else {
            return redirect('eleave/inventory/add')
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
            'item' => $array,
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
            "isApp" => "web",
            'request_id' => $request_id,
            'request_name' => $subject,
            'status' => $status,
            'user_request' => $employee_id,
            'item' => $array,
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
            "isApp" => "web",
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
            "isApp" => "web",
            'items' => $array,
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
            "isApp" => "web",
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
