<?php
namespace App\Http\Controllers\Eleave\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use DB;
use Session;
use App\ElaHelper;
use DateTime;
use URL;

class InventoryMasterController extends Controller {

    public function unit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.master.iv_master_unit');
    }

    public function getInventoryUnit(Request $request) {

        $urlInventory = "unit";
        //dd($urlInventory);
        $param = [
            "token" => session('token'),
            "isAll" => "",
            "isApp" => "web",
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
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
                //if ($this->general->privilege_check(INVENTORY, 'edit'))
                $aksi .= "<a onclick='edit_unit(" . $row['unit_id'] . ")' class='btn btn-xs yellow' title='Edit'>
                            <i class='fa fa-edit'></i></a>&nbsp;&nbsp;";
                //if ($this->general->privilege_check(INVENTORY, 'remove'))
                $aksi .= "<a class='btn red btn-xs reject' id='" . $row['unit_id'] . "' title='Delete'>
                            <i class='fa fa-trash'></i></a>&nbsp;&nbsp;";

                if ($row['status'] == "0") {
                    $status = "Not Active";
                } elseif ($row['status'] == "1") {
                    $status = "Active";
                } elseif ($row['status'] == "2") {
                    $status = "Deleted";
                }

                $hasil[] = array("no" => $no,
                    "unit_id" => $row['unit_id'],
                    "unit_name" => $row['unit_name'],
                    "short_name" => $row['short_name'],
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

    public function save_unit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $userid = session('id');
        $unit_name = trim(ucwords($request->post('unitName')));
        $short_name = trim(ucwords($request->post('shortName')));
        $status = $request->post('status');
        $module = "unit";
        $this->_validate($request->all(), $module);

        $urlUnit = 'unit-save';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            'unit_name' => $unit_name,
            'short_name' => $short_name,
            'status' => $status,
            'created_by' => $userid,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $userid,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $unit = ElaHelper::myCurlInventory($urlUnit, $param);
        $unitData = json_decode($unit, true);

        if ($unitData['response_code'] == 200) {
            $ro = array('status' => TRUE, 'message' => $unitData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => FALSE, 'message' => $unitData['message'], 'alert-type' => 'error', 'errcode' => 'error');
        }
        echo json_encode($ro);
    }

    public function edit_unit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlUnit = 'unit-detail';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            "unit_id" => $id,
        ];
        $unit_id = ElaHelper::myCurlInventory($urlUnit, $param);
        $unitData = json_decode($unit_id, true);
        if ($unitData['response_code'] == 200) {
            echo json_encode(array('status' => true, $unitData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $unitData['message']));
        }
    }

    public function update_unit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $unit_id = $request->post('unit_id');
        $unit_name = trim(ucwords($request->post('unitName')));
        $short_name = trim(ucwords($request->post('shortName')));
        $status = $request->post('status');
        $module = "unit";
        $this->_validate($request->all(), $module);

        $urlUnit = 'unit-update';
        $param = [
            'token' => session('token'),
            "isApp" => "web",
            'unit_id' => $unit_id,
            'unit_name' => $unit_name,
            'short_name' => $short_name,
            'status' => $status,
            'created_by' => session('id'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => session('id'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
//dd($param);
        $unit = ElaHelper::myCurlInventory($urlUnit, $param);
        $unitData = json_decode($unit, true);
        $ro = "";
        if ($unitData['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $unitData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => false, 'message' => $unitData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function destroy_unit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlUnit = 'unit-delete';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            "unit_id" => $id,
        ];

        $unit_id = ElaHelper::myCurlInventory($urlUnit, $param);
        $unitList = json_decode($unit_id, true);
        $ro = "";
        if ($unitList['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $unitList['message']);
        } else {
            $ro = array('status' => false, 'message' => $unitList['message']);
        }
        echo json_encode($ro);
    }

    ////////////////////// master supplier

    public function supplier(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.master.iv_master_supplier');
    }

    public function getInventorySupplier(Request $request) {

        $urlInventory = "supplier";
        //dd($urlInventory);
        $param = [
            "token" => session('token'),
            "isAll" => "",
            "isApp" => "web",
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
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
                //if ($this->general->privilege_check(INVENTORY, 'edit'))
                $aksi .= "<a onclick='edit_supplier(" . $row['supplier_id'] . ")' class='btn btn-xs yellow' title='Edit'>
                            <i class='fa fa-edit'></i></a>&nbsp;&nbsp;";
                //if ($this->general->privilege_check(INVENTORY, 'remove'))
                $aksi .= "<a class='btn red btn-xs reject' id='" . $row['supplier_id'] . "' title='Delete'>
                            <i class='fa fa-trash'></i></a>&nbsp;&nbsp;";

                if ($row['status'] == "0") {
                    $status = "Not Active";
                } elseif ($row['status'] == "1") {
                    $status = "Active";
                } elseif ($row['status'] == "2") {
                    $status = "Deleted";
                }

                $hasil[] = array("no" => $no,
                    "supplier_code" => $row['supplier_code'],
                    "supplier_name" => $row['supplier_name'],
                    "supplier_phone" => $row['supplier_phone'],
                    "supplier_address" => $row['supplier_address'],
                    "supplier_email" => $row['supplier_email'],
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

    public function save_supplier(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $userid = session('id');
        $supplier_name = trim(ucwords($request->post('supplierName')));
        $address = trim(ucwords($request->post('address')));
        $phone = $request->post('phone');
        $email = $request->post('email');
        $status = $request->post('status');
        $module = "supplier";
        $this->_validate($request->all(), $module);

        $urlSupplier = 'supplier-save';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            'supplier_code' => '',
            'supplier_name' => $supplier_name,
            'supplier_address' => $address,
            'supplier_phone' => $phone,
            'supplier_email' => $email,
            'status' => $status,
            'created_by' => $userid,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $userid,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $supplier = ElaHelper::myCurlInventory($urlSupplier, $param);
        $supplierData = json_decode($supplier, true);

        if ($supplierData['response_code'] == 200) {
            $ro = array('status' => TRUE, 'message' => $supplierData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => FALSE, 'message' => $supplierData['message'], 'alert-type' => 'error', 'errcode' => 'error');
        }
        echo json_encode($ro);
    }

    public function edit_supplier(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlSupplier = 'supplier-detail';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            "supplier_id" => $id,
        ];
        $supplier_id = ElaHelper::myCurlInventory($urlSupplier, $param);
        $supplierData = json_decode($supplier_id, true);
        if ($supplierData['response_code'] == 200) {
            echo json_encode(array('status' => true, $supplierData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $supplierData['message']));
        }
    }

    public function update_supplier(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $userid = session('id');
        $supplier_id = $request->post('supplier_id');
        $supplier_name = trim(ucwords($request->post('supplierName')));
        $address = trim(ucwords($request->post('address')));
        $phone = $request->post('phone');
        $email = $request->post('email');
        $status = $request->post('status');
        $module = "supplier";
        $this->_validate($request->all(), $module);

        $urlSupplier = 'supplier-update';
        $param = [
            'token' => session('token'),
            "isApp" => "web",
            'supplier_id' => $supplier_id,
            'supplier_code' => '',
            'supplier_name' => $supplier_name,
            'supplier_address' => $address,
            'supplier_phone' => $phone,
            'supplier_email' => $email,
            'status' => $status,
            'created_by' => $userid,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $userid,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $supplier = ElaHelper::myCurlInventory($urlSupplier, $param);
        $supplierData = json_decode($supplier, true);
        $ro = "";
        if ($supplierData['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $supplierData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => false, 'message' => $supplierData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function destroy_supplier(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlSupplier = 'supplier-delete';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            "supplier_id" => $id,
        ];

        $supplier_id = ElaHelper::myCurlInventory($urlSupplier, $param);
        $supplierList = json_decode($supplier_id, true);
        $ro = "";
        if ($supplierList['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $supplierList['message']);
        } else {
            $ro = array('status' => false, 'message' => $supplierList['message']);
        }
        echo json_encode($ro);
    }

    ////////////////////// master item

    public function item(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.master.iv_master_item');
    }

    public function getInventoryItem(Request $request) {

        $urlInventory = "item";
        //dd($urlInventory);
        $param = [
            "token" => session('token'),
            "isAll" => "",
            "isApp" => "web",
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
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
                //if ($this->general->privilege_check(INVENTORY, 'edit'))
                $aksi .= "<a onclick='edit_item(" . $row['item_id'] . ")' class='btn btn-xs yellow' title='Edit'>
                            <i class='fa fa-edit'></i></a>&nbsp;&nbsp;";
//                //if ($this->general->privilege_check(INVENTORY, 'remove'))
                    $aksi .= "<a class='btn red btn-xs reject' id='" . $row['item_id'] . "' title='Delete'>
                            <i class='fa fa-trash'></i></a>&nbsp;&nbsp;";

                if ($row['status'] == "0") {
                    $status = "Not Active";
                } elseif ($row['status'] == "1") {
                    $status = "Active";
                } elseif ($row['status'] == "2") {
                    $status = "Deleted";
                }

                $hasil[] = array("no" => $no,
                    "item_id" => $row['item_id'],
                    "item_name" => $row['item_name'],
                    "unit_name" => $row['unit_name'],
                    "supplier_name" => $row['supplier_name'],
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

    public function save_item(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $userid = session('id');
        $item_name = trim($request->post('itemName'));
        $unit_id = $request->post('unit_id');
        $supplier_id = $request->post('supplier_id');
        $photo = $request->post('attach_file1');
        $status = $request->post('status');
        $module = "item";
        $this->_validate($request->all(), $module);

        $urlItem = 'item-save';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            'item_name' => $item_name,
            'unit_id' => $unit_id,
            'supplier_id' => $supplier_id,
            'image' => $photo,
            'status' => $status,
            'created_by' => $userid,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $userid,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $item = ElaHelper::myCurlInventory($urlItem, $param);
        $itemData = json_decode($item, true);

        if ($itemData['response_code'] == 200) {
            $ro = array('status' => TRUE, 'message' => $itemData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => FALSE, 'message' => $itemData['message'], 'alert-type' => 'error', 'errcode' => 'error');
        }
        echo json_encode($ro);
    }

    public function edit_item(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlItem = 'item-detail';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            "item_id" => $id,
        ];
        $item_id = ElaHelper::myCurlInventory($urlItem, $param);
        $itemData = json_decode($item_id, true);
        if ($itemData['response_code'] == 200) {
            echo json_encode(array('status' => true, $itemData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $itemData['message']));
        }
    }

    public function update_item(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $userid = session('id');
        $item_id = $request->post('item_id');
        $item_name = $request->post('itemName');
        $unit_id = $request->post('unit_id');
        $supplier_id = $request->post('supplier_id');
        $photo = $request->post('attach_file1');
        $status = $request->post('status');
        $module = "item";
        $this->_validate($request->all(), $module);

        $urlItem = 'item-update';
        $param = [
            'token' => session('token'),
            "isApp" => "web",
            'item_id' => $item_id,
            'item_name' => $item_name,
            'unit_id' => $unit_id,
            'supplier_id' => $supplier_id,
            'image' => $photo,
            'status' => $status,
            'created_by' => $userid,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $userid,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $item = ElaHelper::myCurlInventory($urlItem, $param);
        $itemData = json_decode($item, true);
        $ro = "";
        if ($itemData['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $itemData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => false, 'message' => $itemData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function destroy_item(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlItem = 'item-delete';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
            "item_id" => $id,
        ];

        $item_id = ElaHelper::myCurlInventory($urlItem, $param);
        $itemList = json_decode($item_id, true);
        $ro = "";
        if ($itemList['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $itemList['message']);
        } else {
            $ro = array('status' => false, 'message' => $itemList['message']);
        }
        echo json_encode($ro);
    }

    private function _validate($post, $module) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        if ($module == "unit") {
            if ($post['unitName'] == '') {
                $data['inputerror'][] = 'unitName';
                $data['error_string'][] = 'unit name is required';
                $data['status'] = FALSE;
            }
            if ($post['shortName'] == '') {
                $data['inputerror'][] = 'shortName';
                $data['error_string'][] = 'short name is required';
                $data['status'] = FALSE;
            }
        }
        if ($module == "supplier") {
            if ($post['supplierName'] == '') {
                $data['inputerror'][] = 'supplierName';
                $data['error_string'][] = 'supplier name is required';
                $data['status'] = FALSE;
            }
            if ($post['address'] == '') {
                $data['inputerror'][] = 'address';
                $data['error_string'][] = 'address is required';
                $data['status'] = FALSE;
            }
            if ($post['phone'] == '') {
                $data['inputerror'][] = 'phone';
                $data['error_string'][] = 'phone is required';
                $data['status'] = FALSE;
            }
            if ($post['email'] == '') {
                $data['inputerror'][] = 'email';
                $data['error_string'][] = 'email is required';
                $data['status'] = FALSE;
            }
        }
        if ($module == "item") {
            if ($post['itemName'] == '') {
                $data['inputerror'][] = 'itemName';
                $data['error_string'][] = 'item name is required';
                $data['status'] = FALSE;
            }
            if ($post['unit_id'] == '') {
                $data['inputerror'][] = 'unit_id';
                $data['error_string'][] = 'unit is required';
                $data['status'] = FALSE;
            }
            if ($post['supplier_id'] == '') {
                $data['inputerror'][] = 'supplier_id';
                $data['error_string'][] = 'supplier is required';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function getUnitByName(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlItem = 'unit';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
        ];
        $item_id = ElaHelper::myCurlInventory($urlItem, $param);
        $itemData = json_decode($item_id, true);
        if ($itemData['response_code'] == 200) {
            echo json_encode(array('status' => true, 'data' => $itemData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $itemData['message']));
        }
    }

    public function getSupplierByName(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlItem = 'supplier';
        $param = [
            "token" => session('token'),
            "isApp" => "web",
        ];
        $item_id = ElaHelper::myCurlInventory($urlItem, $param);
        $itemData = json_decode($item_id, true);
        if ($itemData['response_code'] == 200) {
            echo json_encode(array('status' => true, 'data' => $itemData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $itemData['message']));
        }
    }

}
