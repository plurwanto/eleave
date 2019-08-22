<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class assetItem extends Controller
{
    public $menuID = 41;

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

        $param = [
            "order" => ["brand_name", "ASC"],
            "fields" => ["ass_brand_id", "brand_name"],
            "table" => "asset_brand",
        ];
        $data['brand'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["model", "ASC"],
            "fields" => ["*"],
            "table" => "asset",
        ];
        $data['asset'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["type_name", "ASC"],
            "fields" => ["ass_type_id", "type_name"],
            "table" => "asset_type",
        ];
        $data['type'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["vendor_name", "ASC"],
            "fields" => ["ass_vendor_id", "vendor_name"],
            "table" => "asset_vendor",
        ];
        $data['vendor'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $data['title'] = 'Asset Management';

        if ($request->get('link')) {
            switch ($request->get('link')) {
                case 'log-error':
                    $data['subtitle'] = 'Log Error Upload Asset';
                    $param = [
                        "id" => $request->get('id'),
                    ];

                    $param = [
                        "order" => ["id_temp", "ASC"],
                        "fields" => ["id_temp", "msg"],
                        "where" => ["id_temp", $request->get('id')],
                        "table" => "_temp_log",
                    ];

                    $temp_log = json_decode(ElaHelper::myCurl('master-global', $param));

                    if ($temp_log) {
                        $data['log_error'] = $temp_log->result[0]->msg;
                    } else {
                        $data['log_error'] = '';
                    }

                    return view('HRIS.administration.asset.item.log', $data);
                    break;
                default;
                    $data['subtitle'] = 'List Item';
                    return view('HRIS.administration.asset.item.index', $data);
            }
        } else {
            $data['subtitle'] = 'List Item';
            return view('HRIS.administration.asset.item.index', $data);
        }

    }

    public function listData(Request $request)
    {
        $draw = $request->post('draw');
        $urlMenu = 'hris/get-access-menu';
        $param = [
            "id_hris" => session('id_hris'),

        ];
        $access = ElaHelper::getMenuHRIS($this->menuID, session('id_hris'));

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value'])) ? $filter['value'] : false;

        $urlMenu = 'hris/asset/item';

        if ($request->post('start') == 0) {
            $page = 1;
        } else {
            $page = ($request->post('start') / $request->post('length')) + 1;
        }
        $sort_by = $request->post('order')[0]['column'];
        $dir = $request->post('order')[0]['dir'];

        if ($request['columns'][9]['search']['value'] != "" && $request['columns'][9]['search']['value'] != null) {
            $updated_at = $request['columns'][9]['search']['value'];
            $updated_at = str_replace('/', '-', $updated_at);
            $updated_at = date('Y-m-d', strtotime($updated_at));
        } else {
            $updated_at = "";
        }

        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "page" => $page,
            "per_page" => $request->post('length'),
            "search" => $search,
            "sort_by" => $sort_by,
            "dir" => $dir,
            "service_tag" => $request['columns'][0]['search']['value'],
            "elabram_tag" => $request['columns'][1]['search']['value'],
            "brand" => $request['columns'][2]['search']['value'],
            "type_id" => $request['columns'][3]['search']['value'],
            "condition" => $request['columns'][4]['search']['value'],
            "vendor" => $request['columns'][5]['search']['value'],
            "model" => $request['columns'][6]['search']['value'],
            "status" => $request['columns'][7]['search']['value'],
            "nama" => $request['columns'][8]['search']['value'],
            "updated_at" => $updated_at,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {

                $status = '';
                if ($rows->data[$i]->vendor_id == '' or $rows->data[$i]->vendor_id == '0' or $rows->data[$i]->vendor_id == null) {
                    $status = 'Company Asset';
                } else {
                    $status = 'Rent';
                }

                $updated_at = $rows->data[$i]->updated_at->date != "0000-00-00 00:00:00" ? date('d-M-Y H:i:s', strtotime($rows->data[$i]->updated_at->date)) : "";
                $nestedData['no'] = $a++;
                $nestedData['service_tag'] = $rows->data[$i]->service_tag;
                $nestedData['elabram_tag'] = $rows->data[$i]->elabram_tag;
                if ($rows->data[$i]->mem_id != null) {
                    $nestedData['status_name'] = '<label class="label label-sm border-rounded  label-danger">In Use</label>';

                } else {
                    $nestedData['status_name'] = '<label class="label label-sm border-rounded  label-primary">In Storage</label>';

                }
                $price = $rows->data[$i]->price != '' ? number_format($rows->data[$i]->price, 0, ',', '.') : '0';

                $nestedData['brand_name'] = $rows->data[$i]->brand_name;
                $nestedData['type_name'] = $rows->data[$i]->type_name;
                $nestedData['status'] = $status;
                $nestedData['vendor_name'] = $rows->data[$i]->vendor_name != '' ? $rows->data[$i]->vendor_name : 'None';
                $nestedData['price'] = $rows->data[$i]->cur_id . '. ' . $price;
                $nestedData['model'] = $rows->data[$i]->model;

                $nestedData['ass_item_id'] = $rows->data[$i]->ass_item_id;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $nestedData['updated_at'] = $updated_at;

                $menu_access = '';
                if ($access) {
                    if ($access->menu_acc_add == '1') {
                        if ($rows->data[$i]->mem_id > 0) {
                            $menu_access .= '
                        <a dataaction="remove_employee" title="return on assets" dataid="' . $rows->data[$i]->ass_item_id . '" onclick="get_modal(this)">
                            <i class="fa fa-external-link" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';

                        } else {
                            $menu_access .= '
                        <a dataaction="add_employee" title="Assign To" dataid="' . $rows->data[$i]->ass_item_id . '" onclick="get_modal(this)">
                            <i class="fa fa-check-square-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';

                        }

                    }

                    if ($access->menu_acc_edit == '1') {
                        $menu_access .= '
                        <a dataaction="edit" title="edit" dataid="' . $rows->data[$i]->ass_item_id . '" onclick="get_modal(this)">
                            <i class="fa fa-pencil-square-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                    }

                    if ($access->menu_acc_del == '1') {
                        $menu_access .= '

                        <a dataaction="delete" title="delete" dataid="' . $rows->data[$i]->ass_item_id . '" onclick="get_modal(this)">
                            <i class="fa fa-trash-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';
                    }

                    $menu_access .= '
                        <a dataaction="detail" title="detail" dataid="' . $rows->data[$i]->ass_item_id . '" onclick="get_modal(this)">
                            <i class="fa fa-search-plus" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';

                }

                $nestedData['action'] = $menu_access;
                $employee[] = $nestedData;
            }

            $data = array(
                'draw' => $draw,
                'recordsTotal' => $rows->paging->total,
                'recordsFiltered' => $rows->paging->total,
                'data' => $employee,
            );

        } else {
            $data = array(
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => $employee,
            );
        }
        echo json_encode($data);
    }

    public function add(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Add Asset Management';
        $data['subtitle'] = 'List Item';

        $param = [
            "order" => ["brand_name", "ASC"],
            "fields" => ["ass_brand_id", "brand_name"],
            "table" => "asset_brand",
        ];
        $data['brand'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["model", "ASC"],
            "fields" => ["*"],
            "table" => "asset",
        ];
        $data['asset'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["asset_type.ass_type_id", "DESC"],
            "fields" => ["asset_type.*"],
            "join" => ["asset", "asset_type.ass_type_id", "asset.ass_type_id"],
            "where" => ["asset.ass_vendor_id", null],
            "groupby" => ["ass_type_id"],
            "table" => "asset_type",
        ];

        $data['type'] = json_decode(ElaHelper::myCurl('hris/hris-setting/master-global-join', $param));

        $param = [
            "order" => ["vendor_name", "ASC"],
            "fields" => ["ass_vendor_id", "vendor_name"],
            "table" => "asset_vendor",
        ];
        $data['vendor'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "table" => "_mcurrency",
        ];
        $data['currency'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["processor_name", "ASC"],
            "fields" => ["*"],
            "table" => "asset_processor",
        ];
        $data['processor'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["ram_name", "ASC"],
            "fields" => ["*"],
            "table" => "asset_ram",
        ];
        $data['ram'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["hdd_name", "ASC"],
            "fields" => ["*"],
            "table" => "asset_hdd",
        ];
        $data['hdd'] = json_decode(ElaHelper::myCurl('master-global', $param));

        return view('HRIS.administration.asset.item.add', $data);

    }

    public function doAdd(Request $request)
    {
        $serial_number = $request->post('serial_number') != null ? $request->post('serial_number') : "";
        $hdd_size = $request->post('hdd_size') != null ? $request->post('hdd_size') : "";
        $asset = $request->post('asset') != null ? $request->post('asset') : "";
        $service_tag = $request->post('service_tag') != null ? $request->post('service_tag') : "";
        $elabram_tag = $request->post('elabram_tag') != null ? $request->post('elabram_tag') : "";
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $price = $request->post('price') != null ? str_replace('.', '', $request->post('price')) : "";
        $note = $request->post('note') != null ? $request->post('note') : "";
        $branch = $request->post('branch') != null ? $request->post('branch') : "";
        $processor = $request->post('processor') != null ? $request->post('processor') : "";
        $ram = $request->post('ram') != null ? $request->post('ram') : "";
        $hdd = $request->post('hdd') != null ? $request->post('hdd') : "";

        if ($request->post('purchase_date') != "" && $request->post('purchase_date') != null) {
            $purchase_date = $request->post('purchase_date');
            $purchase_date = str_replace('/', '-', $purchase_date);
            $purchase_date = date('Y-m-d', strtotime($purchase_date));
        } else {
            $purchase_date = "";
        }

        if ($request->post('warranty_date') != "" && $request->post('warranty_date') != null) {
            $warranty_date = $request->post('warranty_date');
            $warranty_date = str_replace('/', '-', $warranty_date);
            $warranty_date = date('Y-m-d', strtotime($warranty_date));
        } else {
            $warranty_date = "";
        }

        $value = [
            'serial_number' => strip_tags($serial_number),
            'hdd_size' => strip_tags($hdd_size),
            'processor' => strip_tags($processor),
            'hdd' => strip_tags($hdd),
            'ram' => strip_tags($ram),
            'asset' => strip_tags($asset),
            'service_tag' => strip_tags($service_tag),
            'elabram_tag' => strip_tags($elabram_tag),
            'currency' => strip_tags($currency),
            'price' => strip_tags($price),
            'purchase_date' => strip_tags($purchase_date),
            'warranty_date' => strip_tags($warranty_date),
            'note' => strip_tags($note),
            'branch' => strip_tags($branch),

        ];

        $urlMenu = 'hris/asset/item/do-add';
        $param = [
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);

    }

    public function edit(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Edit Asset Management';
        $data['subtitle'] = 'List Item';

        $param = [
            "order" => ["brand_name", "ASC"],
            "fields" => ["ass_brand_id", "brand_name"],
            "table" => "asset_brand",
        ];
        $data['brand'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["model", "ASC"],
            "fields" => ["*"],
            "table" => "asset",
        ];
        $data['asset'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["type_name", "ASC"],
            "fields" => ["ass_type_id", "type_name"],
            "table" => "asset_type",
        ];
        $data['type'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["vendor_name", "ASC"],
            "fields" => ["ass_vendor_id", "vendor_name"],
            "table" => "asset_vendor",
        ];
        $data['vendor'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['item'] = json_decode(ElaHelper::myCurl('hris/asset/item/get-item', $param));

        $param = [
            "order" => ["cur_name", "ASC"],
            "fields" => ["cur_id", "cur_name"],
            "table" => "_mcurrency",
        ];
        $data['currency'] = json_decode(ElaHelper::myCurl('master-global', $param));
        $param = [
            "order" => ["br_name", "ASC"],
            "fields" => ["br_id", "br_name"],
            "table" => "_mbranch",
        ];
        $data['branch'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["processor_name", "ASC"],
            "fields" => ["*"],
            "table" => "asset_processor",
        ];
        $data['processor'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["ram_name", "ASC"],
            "fields" => ["*"],
            "table" => "asset_ram",
        ];
        $data['ram'] = json_decode(ElaHelper::myCurl('master-global', $param));

        $param = [
            "order" => ["hdd_name", "ASC"],
            "fields" => ["*"],
            "table" => "asset_hdd",
        ];
        $data['hdd'] = json_decode(ElaHelper::myCurl('master-global', $param));

        return view('HRIS.administration.asset.item.edit', $data);

    }

    public function doEdit(Request $request)
    {
        $id = $request->post('id') != null ? $request->post('id') : "";
        $serial_number = $request->post('serial_number') != null ? $request->post('serial_number') : "";
        $hdd_size = $request->post('hdd_size') != null ? $request->post('hdd_size') : "";
        $asset = $request->post('asset') != null ? $request->post('asset') : "";
        $service_tag = $request->post('service_tag') != null ? $request->post('service_tag') : "";
        $elabram_tag = $request->post('elabram_tag') != null ? $request->post('elabram_tag') : "";
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $price = $request->post('price') != null ? str_replace('.', '', $request->post('price')) : "";
        $note = $request->post('note') != null ? $request->post('note') : "";
        $branch = $request->post('branch') != null ? $request->post('branch') : "";
        $processor = $request->post('processor') != null ? $request->post('processor') : "";
        $ram = $request->post('ram') != null ? $request->post('ram') : "";
        $hdd = $request->post('hdd') != null ? $request->post('hdd') : "";

        if ($request->post('purchase_date') != "" && $request->post('purchase_date') != null) {
            $purchase_date = $request->post('purchase_date');
            $purchase_date = str_replace('/', '-', $purchase_date);
            $purchase_date = date('Y-m-d', strtotime($purchase_date));
        } else {
            $purchase_date = "";
        }

        if ($request->post('warranty_date') != "" && $request->post('warranty_date') != null) {
            $warranty_date = $request->post('warranty_date');
            $warranty_date = str_replace('/', '-', $warranty_date);
            $warranty_date = date('Y-m-d', strtotime($warranty_date));
        } else {
            $warranty_date = "";
        }

        $value = [
            'serial_number' => strip_tags($serial_number),
            'hdd_size' => strip_tags($hdd_size),
            'processor' => strip_tags($processor),
            'hdd' => strip_tags($hdd),
            'ram' => strip_tags($ram),
            'asset' => strip_tags($asset),
            'service_tag' => strip_tags($service_tag),
            'elabram_tag' => strip_tags($elabram_tag),
            'currency' => strip_tags($currency),
            'price' => strip_tags($price),
            'purchase_date' => strip_tags($purchase_date),
            'warranty_date' => strip_tags($warranty_date),
            'note' => strip_tags($note),
            'branch' => strip_tags($branch),

        ];

        $urlMenu = 'hris/asset/item/do-edit';
        $param = [
            "id_item" => $id,
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
            "value" => $value,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function doDelete(Request $request)
    {
        $id = $request->get('id') != null ? $request->get('id') : "";

        $urlMenu = 'hris/asset/item/do-delete';
        $param = [
            "id_hris" => session('id_hris'),
            "id" => $id,
            "username" => session('username'),
            "token" => session('token'),
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

    public function getType(Request $request)
    {
        $vendor = $request->get('vendor');
        $type = $request->get('type_asset');

        $res = '<option value="">-- Choose a Type --</option>';
        if ($vendor != '') {

            $param = [
                "order" => ["asset_type.ass_type_id", "DESC"],
                "fields" => ["asset_type.*"],
                "join" => ["asset", "asset_type.ass_type_id", "asset.ass_type_id"],
                "where" => ["asset.ass_vendor_id", $vendor],
                "groupby" => ["ass_type_id"],
                "table" => "asset_type",
            ];

        } else {
            $param = [
                "order" => ["asset_type.ass_type_id", "DESC"],
                "fields" => ["asset_type.*"],
                "join" => ["asset", "asset_type.ass_type_id", "asset.ass_type_id"],
                "where" => ["asset.ass_vendor_id", $vendor],
                "groupby" => ["ass_type_id"],
                "table" => "asset_type",
            ];

        }

        $val = json_decode(ElaHelper::myCurl('hris/hris-setting/master-global-join', $param));

        for ($i = 0; $i < count($val->result); $i++) {
            $res .= '<option value="' . $val->result[$i]->ass_type_id . '">' . $val->result[$i]->type_name . '</option>';
        }

        echo $res;

    }

    public function getBrand(Request $request)
    {
        $vendor = $request->get('vendor');
        $type = $request->get('type_asset');
        $brand = $request->get('brand');

        $res = '<option value="">-- Choose a Brand --</option>';
        if ($vendor != '') {
            if ($type != '') {

                $param = [
                    "order" => ["asset_brand.ass_brand_id", "DESC"],
                    "fields" => ["asset_brand.*"],
                    "join" => ["asset", "asset_brand.ass_brand_id", "asset.ass_brand_id"],
                    "where" => ["asset.ass_vendor_id", $vendor],
                    "where2" => ["asset.ass_type_id", $type],
                    "groupby" => ["ass_brand_id"],
                    "table" => "asset_brand",
                ];

                $val = json_decode(ElaHelper::myCurl('hris/hris-setting/master-global-join', $param));

                for ($i = 0; $i < count($val->result); $i++) {
                    $res .= '<option value="' . $val->result[$i]->ass_brand_id . '">' . $val->result[$i]->brand_name . '</option>';
                }

            }

        } else {
            if ($type != '') {
                $param = [
                    "order" => ["asset_brand.ass_brand_id", "DESC"],
                    "fields" => ["asset_brand.*"],
                    "join" => ["asset", "asset_brand.ass_brand_id", "asset.ass_brand_id"],
                    "where" => ["asset.ass_vendor_id", null],
                    "where2" => ["asset.ass_type_id", $type],
                    "groupby" => ["ass_brand_id"],
                    "table" => "asset_brand",
                ];

                $val = json_decode(ElaHelper::myCurl('hris/hris-setting/master-global-join', $param));

                for ($i = 0; $i < count($val->result); $i++) {
                    $res .= '<option value="' . $val->result[$i]->ass_brand_id . '">' . $val->result[$i]->brand_name . '</option>';
                }

            }

        }

        echo $res;

    }

    public function getAsset(Request $request)
    {
        $vendor = $request->get('vendor');
        $type = $request->get('type_asset');
        $brand = $request->get('brand');
        $asset = $request->get('asset');

        $res = '<option value="">-- Choose a Model --</option>';
        if ($vendor != '') {
            if ($type != '' and $brand != '') {

                $param = [
                    "order" => ["ass_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_vendor_id", $vendor],
                    "where2" => ["ass_type_id", $type],
                    "where3" => ["ass_brand_id", $brand],
                    "table" => "asset",
                ];

                $val = json_decode(ElaHelper::myCurl('master-global', $param));

                for ($i = 0; $i < count($val->result); $i++) {
                    $res .= '<option value="' . $val->result[$i]->ass_id . '">' . $val->result[$i]->model . '</option>';
                }

            }

        } else {
            if ($type != '' and $brand != '') {
                $param = [
                    "order" => ["ass_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_vendor_id", null],
                    "where2" => ["ass_type_id", $type],
                    "where3" => ["ass_brand_id", $brand],
                    "table" => "asset",
                ];

                $val = json_decode(ElaHelper::myCurl('master-global', $param));

                for ($i = 0; $i < count($val->result); $i++) {
                    $res .= '<option value="' . $val->result[$i]->ass_id . '">' . $val->result[$i]->model . '</option>';

                }

            }

        }

        echo $res;

    }

    public function doExcel(Request $request)
    {

        $files = glob(base_path('public/hris/files/temp/*')); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file);
            }
            // delete file
        }

        $destinationPath = base_path('public/hris/files/temp/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
        $title = 'Asset Item-' . date('dmyHis');

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet($title, function ($sheet) use ($request, $title) {
                $sheet->setCellValue('A1', 'Elabram Tag');
                $sheet->setCellValue('B1', 'Service Tag');
                $sheet->setCellValue('C1', 'Serial Number');
                $sheet->setCellValue('D1', 'Type');
                $sheet->setCellValue('E1', 'Vendor');
                $sheet->setCellValue('F1', 'Brand');
                $sheet->setCellValue('G1', 'Model');
                $sheet->setCellValue('H1', 'Processor');
                $sheet->setCellValue('I1', 'RAM');
                $sheet->setCellValue('J1', 'HDD Size');
                $sheet->setCellValue('K1', 'HDD');
                $sheet->setCellValue('L1', 'Currency');
                $sheet->setCellValue('M1', 'Price');
                $sheet->setCellValue('N1', 'Purchase Date');
                $sheet->setCellValue('O1', 'Warranty Date');
                $sheet->setCellValue('P1', 'Branch');
                $sheet->setCellValue('Q1', 'Status');
                $sheet->setCellValue('R1', 'Note');
                $sheet->setCellValue('S1', 'Updated by');
                $sheet->setCellValue('T1', 'Updated at');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];

                $item = json_decode(ElaHelper::myCurl('hris/asset/item/get-item-excel', $param));

                for ($a = 0; $a < count($item->result); $a++) {

                    $status = '';
                    if ($item->result[$a]->vendor_id == '' or $item->result[$a]->vendor_id == '0' or $item->result[$a]->vendor_id == null) {
                        $status = 'Company Asset';
                    } else {
                        $status = 'Rent';
                    }

                    $serial_number = $item->result[$a]->serial_number != '' ? $item->result[$a]->serial_number : 'none';
                    $processor_name = $item->result[$a]->processor_name != '' ? $item->result[$a]->processor_name : 'none';
                    $ram_name = $item->result[$a]->ram_name != '' ? $item->result[$a]->ram_name : 'none';
                    $hdd_name = $item->result[$a]->hdd_name != '' ? $item->result[$a]->hdd_name : 'none';
                    $hdd_size = $item->result[$a]->hdd_size != '' ? $item->result[$a]->hdd_size : 'none';
                    $type_name = $item->result[$a]->type_name != '' ? $item->result[$a]->type_name : 'none';
                    $elabram_tag = $item->result[$a]->elabram_tag != '' ? $item->result[$a]->elabram_tag : 'none';
                    $service_tag = $item->result[$a]->service_tag != '' ? $item->result[$a]->service_tag : 'none';
                    $vendor_name = $item->result[$a]->vendor_name != '' ? $item->result[$a]->vendor_name : 'none';
                    $brand_name = $item->result[$a]->brand_name != '' ? $item->result[$a]->brand_name : 'none';
                    $model = $item->result[$a]->model != '' ? $item->result[$a]->model : 'none';
                    $cur_name = $item->result[$a]->cur_name != '' ? $item->result[$a]->cur_name : 'none';
                    $price = $item->result[$a]->price != '' ? $item->result[$a]->price : 'none';
                    $purchase_date = $item->result[$a]->purchase_date != '' ? date('d-M-Y', strtotime($item->result[$a]->purchase_date)) : 'none';
                    $warranty_date = $item->result[$a]->warranty_date != '' ? date('d-M-Y', strtotime($item->result[$a]->warranty_date)) : 'none';
                    $note = $item->result[$a]->note != '' ? $item->result[$a]->note : 'none';
                    $br_name = $item->result[$a]->br_name != '' ? $item->result[$a]->br_name : 'none';
                    $updated_by = $item->result[$a]->updated_by != '' ? $item->result[$a]->updated_by : 'none';
                    $updated_at = $item->result[$a]->updated_at != '' ? $item->result[$a]->updated_at : 'none';

                    $sheet->setCellValue('A' . $i, $elabram_tag);
                    $sheet->setCellValue('B' . $i, $service_tag);
                    $sheet->setCellValue('C' . $i, $serial_number);
                    $sheet->setCellValue('D' . $i, $type_name);
                    $sheet->setCellValue('E' . $i, $vendor_name);
                    $sheet->setCellValue('F' . $i, $brand_name);
                    $sheet->setCellValue('G' . $i, $model);
                    $sheet->setCellValue('H' . $i, $processor_name);
                    $sheet->setCellValue('I' . $i, $ram_name);
                    $sheet->setCellValue('J' . $i, $hdd_size);
                    $sheet->setCellValue('K' . $i, $hdd_name);
                    $sheet->setCellValue('L' . $i, $cur_name);
                    $sheet->setCellValue('M' . $i, $price);
                    $sheet->setCellValue('N' . $i, $purchase_date);
                    $sheet->setCellValue('O' . $i, $warranty_date);
                    $sheet->setCellValue('P' . $i, $br_name);
                    $sheet->setCellValue('Q' . $i, $status);
                    $sheet->setCellValue('R' . $i, $note);
                    $sheet->setCellValue('S' . $i, $updated_by);
                    $sheet->setCellValue('T' . $i, $updated_at);

                    $i++;
                    $no++;
                }

            });

        })->store('xlsx', $destinationPath);

        return [
            "response_code" => 200,
            "path" => env('APP_URL') . '/public/hris/files/temp/' . $title . '.xlsx',
        ];
    }

    public function doExcelHistory(Request $request)
    {

        $files = glob(base_path('public/hris/files/temp/*')); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file);
            }
            // delete file
        }

        $destinationPath = base_path('public/hris/files/temp/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
        $title = 'Asset History -' . date('dmyHis');

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet($title, function ($sheet) use ($request, $title) {
                $sheet->setCellValue('A1', 'Employee');
                $sheet->setCellValue('B1', 'Elabram Tag');
                $sheet->setCellValue('C1', 'Service Tag');
                $sheet->setCellValue('D1', 'Serial Number');
                $sheet->setCellValue('E1', 'Type');
                $sheet->setCellValue('F1', 'Vendor');
                $sheet->setCellValue('G1', 'Brand');
                $sheet->setCellValue('H1', 'Model');
                $sheet->setCellValue('I1', 'Processor');
                $sheet->setCellValue('J1', 'RAM');
                $sheet->setCellValue('K1', 'HDD Size');
                $sheet->setCellValue('L1', 'HDD');
                $sheet->setCellValue('M1', 'Purchase Date');
                $sheet->setCellValue('N1', 'Warranty Date');
                $sheet->setCellValue('O1', 'Branch');
                $sheet->setCellValue('P1', 'Action');
                $sheet->setCellValue('Q1', 'Condition');
                $sheet->setCellValue('R1', 'Date (Assign / Return)');
                $sheet->setCellValue('S1', 'Updated by');
                $sheet->setCellValue('T1', 'Updated at');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];

                $item = json_decode(ElaHelper::myCurl('hris/asset/item/get-item-excel-history', $param));

                for ($a = 0; $a < count($item->result); $a++) {
                    $condition = $item->result[$a]->condition != '' ? $item->result[$a]->condition : 'none';
                    $action = $item->result[$a]->action_code == '1' ? 'Assign' : 'Return';
                    $created_date = $item->result[$a]->created_date != '' ? $item->result[$a]->created_date : 'none';
                    $serial_number = $item->result[$a]->serial_number != '' ? $item->result[$a]->serial_number : 'none';
                    $processor_name = $item->result[$a]->processor_name != '' ? $item->result[$a]->processor_name : 'none';
                    $ram_name = $item->result[$a]->ram_name != '' ? $item->result[$a]->ram_name : 'none';
                    $hdd_name = $item->result[$a]->hdd_name != '' ? $item->result[$a]->hdd_name : 'none';
                    $hdd_size = $item->result[$a]->hdd_size != '' ? $item->result[$a]->hdd_size : 'none';

                    $mem_name = $item->result[$a]->mem_name != '' ? $item->result[$a]->mem_name : 'none';
                    $type_name = $item->result[$a]->type_name != '' ? $item->result[$a]->type_name : 'none';
                    $elabram_tag = $item->result[$a]->elabram_tag != '' ? $item->result[$a]->elabram_tag : 'none';
                    $service_tag = $item->result[$a]->service_tag != '' ? $item->result[$a]->service_tag : 'none';
                    $vendor_name = $item->result[$a]->vendor_name != '' ? $item->result[$a]->vendor_name : 'none';
                    $brand_name = $item->result[$a]->brand_name != '' ? $item->result[$a]->brand_name : 'none';
                    $model = $item->result[$a]->model != '' ? $item->result[$a]->model : 'none';
                    $cur_name = $item->result[$a]->cur_name != '' ? $item->result[$a]->cur_name : 'none';
                    $price = $item->result[$a]->price != '' ? $item->result[$a]->price : 'none';
                    $purchase_date = $item->result[$a]->purchase_date != '' ? date('d-M-Y', strtotime($item->result[$a]->purchase_date)) : 'none';
                    $warranty_date = $item->result[$a]->warranty_date != '' ? date('d-M-Y', strtotime($item->result[$a]->warranty_date)) : 'none';
                    $note = $item->result[$a]->note != '' ? $item->result[$a]->note : 'none';
                    $br_name = $item->result[$a]->br_name != '' ? $item->result[$a]->br_name : 'none';
                    $updated_by = $item->result[$a]->updated_by != '' ? $item->result[$a]->updated_by : 'none';
                    $updated_at = $item->result[$a]->updated_at != '' ? $item->result[$a]->updated_at : 'none';

                    $sheet->setCellValue('A' . $i, $mem_name);
                    $sheet->setCellValue('B' . $i, $elabram_tag);
                    $sheet->setCellValue('C' . $i, $service_tag);
                    $sheet->setCellValue('D' . $i, $serial_number);
                    $sheet->setCellValue('E' . $i, $type_name);
                    $sheet->setCellValue('F' . $i, $vendor_name);
                    $sheet->setCellValue('G' . $i, $brand_name);
                    $sheet->setCellValue('H' . $i, $model);
                    $sheet->setCellValue('I' . $i, $processor_name);
                    $sheet->setCellValue('J' . $i, $ram_name);
                    $sheet->setCellValue('K' . $i, $hdd_size);
                    $sheet->setCellValue('L' . $i, $hdd_name);
                    $sheet->setCellValue('M' . $i, $purchase_date);
                    $sheet->setCellValue('N' . $i, $warranty_date);
                    $sheet->setCellValue('O' . $i, $br_name);
                    $sheet->setCellValue('P' . $i, $action);
                    $sheet->setCellValue('Q' . $i, $condition);
                    $sheet->setCellValue('R' . $i, $created_date);
                    $sheet->setCellValue('S' . $i, $updated_by);
                    $sheet->setCellValue('T' . $i, $updated_at);

                    $i++;
                    $no++;
                }

            });

        })->store('xlsx', $destinationPath);

        return [
            "response_code" => 200,
            "path" => env('APP_URL') . '/public/hris/files/temp/' . $title . '.xlsx',
        ];
    }

    public function upload(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Upload Asset Management';
        $data['subtitle'] = 'List Item';
        return view('HRIS.administration.asset.item.upload', $data);

    }

    public function exportExcelExample(Request $request)
    {

        return redirect(env('PUBLIC_PATH') . 'hris/files/asset/Template Asset Management.xlsx');

    }

    public function doUpload(Request $request)
    {

        if ($request->hasFile('file')) {
            try {
                $path = $request->file('file')->getRealPath();
                $filename = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
                $excelData = Excel::selectSheetsByIndex(0)->load($path)->get();

                $param = [
                    "id_hris" => session('id_hris'),
                ];
                $getBranchId = json_decode(ElaHelper::myCurl('hris/hris-user/get-branch', $param));

                if ($excelData->count()) {
                    $arr = [];

                    foreach ($excelData as $key => $value) {

                        if ($value["service_tag"] != "") {
                            $arr[] = [
                                'serial_number' => trim(strip_tags($value["serial_number"])),
                                'service_tag' => trim(strip_tags($value["service_tag"])),
                                'elabram_tag' => trim(strip_tags($value["elabram_tag"])),
                                'vendor' => trim(strip_tags($value["vendor"])),
                                'brand' => trim(strip_tags($value["brand"])),
                                'type' => trim(strip_tags($value["type"])),
                                'model' => trim(strip_tags($value["model"])),
                                'currency' => trim(strip_tags($value["currency"])),
                                'price' => trim(strip_tags($value["price"])),
                                'purchase_date' => trim(strip_tags($value["purchase_date"])),
                                'warranty_date' => trim(strip_tags($value["warranty_date"])),
                                'note' => trim(strip_tags($value["note"])),
                                'branch' => trim(strip_tags($value["branch"])),
                                'processor' => trim(strip_tags($value["processor"])),
                                'ram' => trim(strip_tags($value["ram"])),
                                'hdd' => trim(strip_tags($value["hdd"])),
                                'hdd_size' => trim(strip_tags($value["hdd_size"])),
                            ];

                        }
                    }

                    if (!empty($arr)) {
                        $dataDoc = array(
                            'asset' => $arr,
                            'token' => session('token'),
                            'id_hris' => session('id_hris'),
                            'name' => session('name'),

                        );

                        $model = ElaHelper::myCurl('hris/asset/item/do-upload', $dataDoc);

                        $result = json_decode($model, true);
                        $id = rand(1, 100);
                        $data = array(
                            'message' => $result['result']['message'],
                            'response_code' => $result['result']['response_code'],
                            'wrong_id' => $result['wrongListId'],
                        );

                        return response()->json($data, 200);

                    } else {
                        $data = array(
                            'msg' => 'There are no request data',
                            'response_code' => 500,
                            'wrong_id' => '',
                        );
                        return response()->json($data, 200);
                    }
                } else {
                    $data = array(
                        'msg' => 'Empty File',
                        'response_code' => 500,
                        'wrong_id' => '',
                    );
                    return response()->json($data, 200);
                }
            } catch (Exception $e) {
                $data = array(
                    'msg' => 'Error!! ' . $e,
                    'response_code' => 500,
                    'wrong_id' => '',
                );
                return response()->json($data, 500);
            }
        } else {
            $data = array(
                'msg' => 'There are no request data',
                'response_code' => 500,
                'wrong_id' => '',
            );
            return response()->json($data, 200);
        }

    }

    public function detail(Request $request)
    {

        $data['link'] = $request->get('link');
        $data['title'] = 'Detail Asset Management';
        $data['subtitle'] = 'List Item';

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['item'] = json_decode(ElaHelper::myCurl('hris/asset/item/get-item', $param));
        return view('HRIS.administration.asset.item.detail', $data);

    }

    public function addEmployee(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Assign To';
        $data['subtitle'] = 'List Item';
        $data['id'] = $request->get('id');

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['item'] = json_decode(ElaHelper::myCurl('hris/asset/item/get-item', $param));
        return view('HRIS.administration.asset.item.add_employee', $data);

    }

    public function doAddEmployee(Request $request)
    {

        $id = $request->post('id') != null ? $request->post('id') : "";

        $mem_id = $request->post('mem_id') != null ? $request->post('mem_id') : "";
        if ($request->post('transfer_date') != "" && $request->post('transfer_date') != null) {
            $transfer_date = $request->post('transfer_date');
            $transfer_date = str_replace('/', '-', $transfer_date);
            $transfer_date = date('Y-m-d', strtotime($transfer_date));
        } else {
            $transfer_date = "";
        }

        $urlMenu = 'hris/asset/item/do-add-employee';
        $param = [
            "id" => $id,
            "mem_id" => $mem_id,
            "transfer_date" => $transfer_date,
            "condition" => 1,
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);

    }

    public function getEmployee(Request $request)
    {
        $employee = $request->get('employee');
        if ($employee != '') {
            $param = [
                "token" => session("token"),
                "employee" => $employee,
            ];

            $contract = json_decode(ElaHelper::myCurl('hris/contract/get-contract-active', $param));
            if ($contract->contract) {
                echo '
        <div class="form-group">
            <label class="col-md-4 control-label">Nama</label>
            <div class="col-md-6">
                <input type="text" name="status" value="' . $contract->contract->mem_name . '" class="form-control" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Email</label>
            <div class="col-md-6">
                <input type="text" name="status" value="' . $contract->contract->mem_email . '" class="form-control" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Phone</label>
            <div class="col-md-6">
                <input type="text" name="status" value="' . $contract->contract->mem_mobile . '" class="form-control" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Customer</label>
            <div class="col-md-6">
                <input type="text" name="status" value="' . $contract->contract->cus_name . '" class="form-control" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Contract  Start - End</label>
            <div class="col-md-6">
                <input type="text" name="status" value="' . $contract->contract->cont_start_date . ' - ' . $contract->contract->cont_end_date . '" class="form-control" disabled>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <input type="hidden" name="mem_id" id="mem_id"  value="' . $contract->contract->mem_id . '" class="form-control">
            </div>
        </div>
        ';
            } else {
                echo '<center><h4>- Employee  Not Found -</span></h4></center>';

            }

        } else {
            echo '<center><h4>- Employee  Not Found -</span></h4></center>';

        }

        exit;

        // for ($i = 0; $i < $contract; $i++) {

        // }

    }

    public function removeEmployee(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Return on assets';
        $data['subtitle'] = 'List Item';
        $data['id'] = $request->get('id');

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['item'] = json_decode(ElaHelper::myCurl('hris/asset/item/get-item', $param));
        return view('HRIS.administration.asset.item.remove_employee', $data);

    }

    public function doremoveEmployee(Request $request)
    {

        $id = $request->post('id') != null ? $request->post('id') : "";
        $mem_id = $request->post('mem_id') != null ? $request->post('mem_id') : "";

        if ($request->post('return_date') != "" && $request->post('return_date') != null) {
            $return_date = $request->post('return_date');
            $return_date = str_replace('/', '-', $return_date);
            $return_date = date('Y-m-d', strtotime($return_date));
        } else {
            $return_date = "";
        }

        $condition = $request->post('condition') != null ? $request->post('condition') : "";
        $remark = $request->post('remark') != null ? $request->post('remark') : "";

        $urlMenu = 'hris/asset/item/do-remove-employee';
        $param = [
            "id" => $id,
            "mem_id" => $mem_id,
            "return_date" => $return_date,
            "condition" => $condition,
            "remark" => $remark,
            "id_hris" => session('id_hris'),
            "username" => session('username'),
            "token" => session('token'),
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);

    }

    public function checkSevicetagExisting(Request $request)
    {

        $service_tag = $request->post('service_tag');
        $param = [
            "order" => ["service_tag", "ASC"],
            "fields" => ["ass_item_id", "service_tag"],
            "where" => ["service_tag", $service_tag],
            "table" => "asset_item",
        ];
        $tag = json_decode(ElaHelper::myCurl('master-global', $param));

        if ($tag->result) {
            $response = false;
        } else {
            $response = true;
        }

        echo json_encode($response);
    }

    public function checkElabramtagExisting(Request $request)
    {

        $elabram_tag = $request->post('elabram_tag');
        $param = [
            "order" => ["elabram_tag", "ASC"],
            "fields" => ["ass_item_id", "elabram_tag"],
            "where" => ["elabram_tag", $elabram_tag],
            "table" => "asset_item",
        ];
        $tag = json_decode(ElaHelper::myCurl('master-global', $param));

        if ($tag->result) {
            $response = false;
        } else {
            $response = true;
        }

        echo json_encode($response);
    }

    public function checkSevicetagExistingEdit(Request $request)
    {

        $id = $request->post('id');
        $service_tag = $request->post('service_tag');
        $param = [
            "order" => ["service_tag", "ASC"],
            "fields" => ["ass_item_id", "service_tag"],
            "where" => ["service_tag", $service_tag],
            "where2" => ["ass_item_id", '<>', $id],
            "table" => "asset_item",
        ];
        $tag = json_decode(ElaHelper::myCurl('master-global', $param));

        if ($tag->result) {
            $response = false;
        } else {
            $response = true;
        }

        echo json_encode($response);
    }

    public function checkElabramtagExistingEdit(Request $request)
    {
        $id = $request->post('id');
        $elabram_tag = $request->post('elabram_tag');
        $param = [
            "order" => ["elabram_tag", "ASC"],
            "fields" => ["ass_item_id", "elabram_tag"],
            "where" => ["elabram_tag", $elabram_tag],
            "where2" => ["ass_item_id", '<>', $id],
            "table" => "asset_item",
        ];
        $tag = json_decode(ElaHelper::myCurl('master-global', $param));

        if ($tag->result) {
            $response = false;
        } else {
            $response = true;
        }

        echo json_encode($response);
    }

    public function uploadAssign(Request $request)
    {
        $data['link'] = $request->get('link');
        $data['title'] = 'Upload Assign To';
        $data['subtitle'] = 'List Item';
        return view('HRIS.administration.asset.item.upload_assign', $data);

    }

    public function doUploadAssign(Request $request)
    {

        if ($request->hasFile('file')) {
            try {
                $path = $request->file('file')->getRealPath();
                $filename = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
                $excelData = Excel::selectSheetsByIndex(0)->load($path)->get();

                if ($excelData->count()) {
                    $arr = [];

                    foreach ($excelData as $key => $value) {

                        if ($value["transfer_date_yyyy_mm_dd"] != "" && $value["transfer_date_yyyy_mm_dd"] != null) {
                            $transfer_date_yyyy_mm_dd = $value["transfer_date_yyyy_mm_dd"];
                            $transfer_date_yyyy_mm_dd = str_replace('/', '-', $transfer_date_yyyy_mm_dd);
                            $transfer_date_yyyy_mm_dd = date('Y-m-d', strtotime($transfer_date_yyyy_mm_dd));
                        } else {
                            $transfer_date_yyyy_mm_dd = "";
                        }

                        if ($value["nip"] != "") {
                            $arr[] = [
                                'service_tag' => trim(strip_tags($value["service_tag"])),
                                'elabram_tag' => trim(strip_tags($value["elabram_tag"])),
                                'nip' => trim(strip_tags($value["nip"])),
                                'transfer_date' => strip_tags($transfer_date_yyyy_mm_dd),
                            ];

                        }
                    }

                    if (!empty($arr)) {
                        $dataDoc = array(
                            'asset' => $arr,
                            'token' => session('token'),
                            'id_hris' => session('id_hris'),
                            'name' => session('name'),

                        );

                        $model = ElaHelper::myCurl('hris/asset/item/do-upload-assign', $dataDoc);

                        $result = json_decode($model, true);
                        $id = rand(1, 100);
                        $data = array(
                            'message' => $result['result']['message'],
                            'response_code' => $result['result']['response_code'],
                            'wrong_id' => $result['wrongListId'],
                        );

                        return response()->json($data, 200);

                    } else {
                        $data = array(
                            'msg' => 'There are no request data',
                            'response_code' => 500,
                            'wrong_id' => '',
                        );
                        return response()->json($data, 200);
                    }
                } else {
                    $data = array(
                        'msg' => 'Empty File',
                        'response_code' => 500,
                        'wrong_id' => '',
                    );
                    return response()->json($data, 200);
                }
            } catch (Exception $e) {
                $data = array(
                    'msg' => 'Error!! ' . $e,
                    'response_code' => 500,
                    'wrong_id' => '',
                );
                return response()->json($data, 500);
            }
        } else {
            $data = array(
                'msg' => 'There are no request data',
                'response_code' => 500,
                'wrong_id' => '',
            );
            return response()->json($data, 200);
        }

    }

    public function templateAssign(Request $request)
    {

        $files = glob(base_path('public/hris/files/temp/*')); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file);
            }
            // delete file
        }

        $destinationPath = base_path('public/hris/files/temp/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
        $title = 'Template Assign To';

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet($title, function ($sheet) use ($request, $title) {
                $sheet->setCellValue('A1', 'No');
                $sheet->setCellValue('B1', 'NIP');
                $sheet->cell('B1', function ($cell) {$cell->setBackground('#CCCCCC');});
                $sheet->setCellValue('C1', 'Type');
                $sheet->cell('C1', function ($cell) {$cell->setBackground('#CCCCCC');});
                $sheet->setCellValue('D1', 'Elabram Tag');
                $sheet->cell('D1', function ($cell) {$cell->setBackground('#CCCCCC');});
                $sheet->setCellValue('E1', 'Service Tag');
                $sheet->cell('E1', function ($cell) {$cell->setBackground('#CCCCCC');});
                $sheet->setCellValue('F1', 'Brand');
                $sheet->cell('F1', function ($cell) {$cell->setBackground('#CCCCCC');});
                $sheet->setCellValue('G1', 'Model');
                $sheet->cell('G1', function ($cell) {$cell->setBackground('#CCCCCC');});
                $sheet->setCellValue('H1', 'Transfer Date (yyyy-mm-dd)');
                $sheet->cell('H1', function ($cell) {$cell->setBackground('#CCCCCC');});
                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];

                $item = json_decode(ElaHelper::myCurl('hris/asset/item/get-item-instorage', $param));

                $c = 1;
                for ($a = 0; $a < count($item->result); $a++) {
                    $elabram_tag = $item->result[$a]->elabram_tag != '' ? $item->result[$a]->elabram_tag : '';
                    $service_tag = $item->result[$a]->service_tag != '' ? $item->result[$a]->service_tag : '';
                    $brand_name = $item->result[$a]->brand_name != '' ? $item->result[$a]->brand_name : '';
                    $model = $item->result[$a]->model != '' ? $item->result[$a]->model : '';
                    $type_name = $item->result[$a]->type_name != '' ? $item->result[$a]->type_name : '';

                    $sheet->setCellValue('A' . $i, $no);
                    $sheet->setCellValue('B' . $i, '');
                    $sheet->setCellValue('C' . $i, $type_name);
                    $sheet->setCellValue('D' . $i, $elabram_tag);
                    $sheet->setCellValue('E' . $i, $service_tag);
                    $sheet->setCellValue('F' . $i, $brand_name);
                    $sheet->setCellValue('G' . $i, $model);
                    $sheet->setCellValue('H' . $i, '');

                    $i++;
                    $no++;
                }

            });

        })->store('xlsx', $destinationPath);

        return [
            "response_code" => 200,
            "path" => env('APP_URL') . '/public/hris/files/temp/' . $title . '.xlsx',
        ];
    }

}
