<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;
use PDF;

class assetResource extends Controller
{
    public $menuID = 42;

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

                    return view('HRIS.administration.asset.resource.log', $data);
                    break;
                default;
                    $data['subtitle'] = 'List Resource';
                    return view('HRIS.administration.asset.resource.index', $data);
            }
        } else {
            $data['subtitle'] = 'List Resource';
            return view('HRIS.administration.asset.resource.index', $data);
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

        $urlMenu = 'hris/asset/resource';

        if ($request->post('start') == 0) {
            $page = 1;
        } else {
            $page = ($request->post('start') / $request->post('length')) + 1;
        }
        $sort_by = $request->post('order')[0]['column'];
        $dir = $request->post('order')[0]['dir'];

        if ($request['columns'][6]['search']['value'] != "" && $request['columns'][6]['search']['value'] != null) {
            $updated_at = $request['columns'][6]['search']['value'];
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
            "employee" => $request['columns'][0]['search']['value'],
            "service_tag" => $request['columns'][1]['search']['value'],
            "elabram_tag" => $request['columns'][2]['search']['value'],
            "brand" => $request['columns'][3]['search']['value'],
            "type_id" => $request['columns'][4]['search']['value'],
            "condition" => $request['columns'][5]['search']['value'],
            "nama" => $request['columns'][6]['search']['value'],
            "updated_at" => $updated_at,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));

        $a = $start + 1;
        $employee = [];
        if ($rows) {
            for ($i = 0; $i < count($rows->data); $i++) {

                $updated_at = $rows->data[$i]->updated_at->date != "0000-00-00 00:00:00" ? date('d-M-Y H:i:s', strtotime($rows->data[$i]->updated_at->date)) : "";
                $nestedData['no'] = $a++;
                $nestedData['mem_name'] = $rows->data[$i]->mem_name;
                $nestedData['service_tag'] = $rows->data[$i]->service_tag;
                $nestedData['elabram_tag'] = $rows->data[$i]->elabram_tag;
                switch ($rows->data[$i]->condition_code) {
                    case "1":
                        $con = "Good";
                        break;
                    case "2":
                        $con = "Broke";
                        break;
                    case "3":
                        $con = "Bad";
                        break;
                    default:
                        $con = "Good";
                }
                $nestedData['condition'] = $con;
                $nestedData['brand_name'] = $rows->data[$i]->brand_name;
                $nestedData['type_name'] = $rows->data[$i]->type_name;
                $nestedData['model'] = $rows->data[$i]->model;
                $nestedData['ass_item_id'] = $rows->data[$i]->ass_item_id;
                $nestedData['nama'] = $rows->data[$i]->nama;
                $nestedData['updated_at'] = $updated_at;

                $menu_access = '';
                if ($access) {
                    $menu_access .= '
                        <a dataaction="pdf" title="pdf" dataid="' . $rows->data[$i]->ass_item_id . '" onclick="get_modal(this)">
                            <i class="fa fa-file-pdf-o" style="
                            font-size: 18px;
                            width: 18px;
                            height: 18px;
                            margin-right: 3px;"></i>
                        </a>';

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
        $data['subtitle'] = 'List Resource';

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

        return view('HRIS.administration.asset.resource.add', $data);

    }

    public function doAdd(Request $request)
    {
        $asset = $request->post('asset') != null ? $request->post('asset') : "";
        $service_tag = $request->post('service_tag') != null ? $request->post('service_tag') : "";
        $elabram_tag = $request->post('elabram_tag') != null ? $request->post('elabram_tag') : "";
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $price = $request->post('price') != null ? str_replace('.', '', $request->post('price')) : "";
        $note = $request->post('note') != null ? $request->post('note') : "";
        $branch = $request->post('branch') != null ? $request->post('branch') : "";

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

        $urlMenu = 'hris/asset/resource/do-add';
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
        $data['subtitle'] = 'List Resource';

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

        $data['item'] = json_decode(ElaHelper::myCurl('hris/asset/resource/get-item', $param));

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

        return view('HRIS.administration.asset.resource.edit', $data);

    }

    public function doEdit(Request $request)
    {
        $id = $request->post('id') != null ? $request->post('id') : "";

        $asset = $request->post('asset') != null ? $request->post('asset') : "";
        $service_tag = $request->post('service_tag') != null ? $request->post('service_tag') : "";
        $elabram_tag = $request->post('elabram_tag') != null ? $request->post('elabram_tag') : "";
        $currency = $request->post('currency') != null ? $request->post('currency') : "";
        $price = $request->post('price') != null ? str_replace('.', '', $request->post('price')) : "";
        $note = $request->post('note') != null ? $request->post('note') : "";
        $branch = $request->post('branch') != null ? $request->post('branch') : "";

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

        $urlMenu = 'hris/asset/resource/do-edit';
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

        $urlMenu = 'hris/asset/resource/do-delete';
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

        $res = '<option value="">-- Choose a Model --</option>';
        if ($vendor != '') {

            $param = [
                "order" => ["asset_type.ass_type_id", "DESC"],
                "fields" => ["asset_type.*"],
                "join" => ["asset", "asset_type.ass_type_id", "asset.ass_type_id"],
                "where" => ["asset.ass_vendor_id", $vendor],
                "groupby" => ["ass_type_id"],
                "table" => "asset_type",
            ];

            $val = json_decode(ElaHelper::myCurl('hris/hris-setting/master-global-join', $param));

            for ($i = 0; $i < count($val->result); $i++) {
                if ($val->result[$i]->ass_type_id == $type) {
                    $res .= '<option value="' . $val->result[$i]->ass_type_id . '" selected>' . $val->result[$i]->type_name . '</option>';
                } else {
                    $res .= '<option value="' . $val->result[$i]->ass_type_id . '">' . $val->result[$i]->type_name . '</option>';

                }

            }

        }

        echo $res;

    }

    public function getBrand(Request $request)
    {
        $vendor = $request->get('vendor');
        $type = $request->get('type_asset');
        $brand = $request->get('brand');

        $res = '<option value="">-- Choose a Brand --</option>';
        if ($vendor != '' and $type != '') {

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
                if ($val->result[$i]->ass_brand_id == $brand) {
                    $res .= '<option value="' . $val->result[$i]->ass_brand_id . '" selected>' . $val->result[$i]->brand_name . '</option>';

                } else {
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
        if ($vendor != '' and $type != '' and $brand != '') {

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
                if ($val->result[$i]->ass_id == $asset) {
                    $res .= '<option value="' . $val->result[$i]->ass_id . '" selected>' . $val->result[$i]->model . '</option>';

                } else {
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
        $title = 'Asset Employee-' . date('dmyHis');

        Excel::create($title, function ($excel) use ($request, $title) {
            $excel->sheet($title, function ($sheet) use ($request, $title) {
                $sheet->setCellValue('A1', 'Nama');
                $sheet->setCellValue('B1', 'Condition');
                $sheet->setCellValue('C1', 'Elabram Tag');
                $sheet->setCellValue('D1', 'Service Tag');
                $sheet->setCellValue('E1', 'Serial Number');
                $sheet->setCellValue('F1', 'Type');
                $sheet->setCellValue('G1', 'Vendor');
                $sheet->setCellValue('H1', 'Brand');
                $sheet->setCellValue('I1', 'Model');
                $sheet->setCellValue('J1', 'Processor');
                $sheet->setCellValue('K1', 'RAM');
                $sheet->setCellValue('L1', 'HDD Size');
                $sheet->setCellValue('M1', 'HDD');
                $sheet->setCellValue('N1', 'Currency');
                $sheet->setCellValue('O1', 'Price');
                $sheet->setCellValue('P1', 'Purchase Date');
                $sheet->setCellValue('Q1', 'Warranty Date');
                $sheet->setCellValue('R1', 'Branch');
                $sheet->setCellValue('S1', 'Note');
                $sheet->setCellValue('T1', 'Updated by');
                $sheet->setCellValue('U1', 'Updated at');

                $i = 2;
                $no = 1;

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                ];

                $item = json_decode(ElaHelper::myCurl('hris/asset/resource/get-item-excel', $param));

                for ($a = 0; $a < count($item->result); $a++) {
                    $serial_number = $item->result[$a]->serial_number != '' ? $item->result[$a]->serial_number : 'none';

                    $processor_name = $item->result[$a]->processor_name != '' ? $item->result[$a]->processor_name : 'none';
                    $ram_name = $item->result[$a]->ram_name != '' ? $item->result[$a]->ram_name : 'none';
                    $hdd_size = $item->result[$a]->hdd_size != '' ? $item->result[$a]->hdd_size : 'none';
                    $hdd_name = $item->result[$a]->hdd_name != '' ? $item->result[$a]->hdd_name : 'none';

                    $mem_name = $item->result[$a]->mem_name != '' ? $item->result[$a]->mem_name : 'none';
                    $condition = $item->result[$a]->condition != '' ? $item->result[$a]->condition : 'none';
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
                    $sheet->setCellValue('B' . $i, $condition);
                    $sheet->setCellValue('C' . $i, $elabram_tag);
                    $sheet->setCellValue('D' . $i, $service_tag);
                    $sheet->setCellValue('E' . $i, $serial_number);
                    $sheet->setCellValue('F' . $i, $type_name);
                    $sheet->setCellValue('G' . $i, $vendor_name);
                    $sheet->setCellValue('H' . $i, $brand_name);
                    $sheet->setCellValue('I' . $i, $model);
                    $sheet->setCellValue('J' . $i, $processor_name);
                    $sheet->setCellValue('K' . $i, $ram_name);
                    $sheet->setCellValue('L' . $i, $hdd_size);
                    $sheet->setCellValue('M' . $i, $hdd_name);
                    $sheet->setCellValue('N' . $i, $cur_name);
                    $sheet->setCellValue('O' . $i, $price);
                    $sheet->setCellValue('P' . $i, $purchase_date);
                    $sheet->setCellValue('Q' . $i, $warranty_date);
                    $sheet->setCellValue('R' . $i, $br_name);
                    $sheet->setCellValue('S' . $i, $note);
                    $sheet->setCellValue('T' . $i, $updated_by);
                    $sheet->setCellValue('U' . $i, $updated_at);

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
        $data['subtitle'] = 'List Resource';
        return view('HRIS.administration.asset.resource.upload', $data);

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

                        $model = ElaHelper::myCurl('hris/asset/resource/do-upload', $dataDoc);

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
        $data['subtitle'] = 'List Resource';

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $data['item'] = json_decode(ElaHelper::myCurl('hris/asset/resource/get-item', $param));

        return view('HRIS.administration.asset.resource.detail', $data);

    }

    public function pdf(Request $request)
    {

        $param = [
            "token" => session("token"),
            "id" => $request->get('id'),
        ];

        $res = json_decode(ElaHelper::myCurl('hris/asset/resource/get-item', $param));

        $mem_name = $res->contract->mem_name != "" ? $res->contract->mem_name : "-";
        $cont_dept = $res->contract->cont_dept != "" ? $res->contract->cont_dept : "-";
        $cont_position = $res->contract->cont_position != "" ? $res->contract->cont_position : "-";
        $mem_gender = $res->contract->mem_gender == 'L' ? 'Male' : 'Female';
        $cus_name = $res->contract->cus_name != "" ? $res->contract->cus_name : "-";
        $mem_mobile = $res->contract->mem_mobile != "" ? $res->contract->mem_mobile : "-";
        $cont_no_new = $res->contract->cont_no_new != "" ? $res->contract->cont_no_new : "-";
        $mem_email = $res->contract->mem_email != "" ? $res->contract->mem_email : "-";
        $date = date('d-M-Y');

        $vendor_name = $res->result->vendor_name;
        $brand_name = $res->result->brand_name;

        $elabram_tag = $res->result->elabram_tag;
        $type_name = $res->result->type_name;
        $serial_number = $res->result->serial_number;
        $service_tag = $res->result->service_tag;
        $note = $res->result->note;

        $pdf = (object) [
            'mem_name' => $mem_name,
            'cont_dept' => $cont_dept,
            'cont_position' => $cont_position,
            'mem_gender' => $mem_gender,
            'cus_name' => $cus_name,
            'mem_mobile' => $mem_mobile,
            'cont_no_new' => $cont_no_new,
            'mem_email' => $mem_email,
            'date' => $date,
            'brand_name' => $brand_name,

            'vendor_name' => $vendor_name,

            'elabram_tag' => $elabram_tag,
            'type_name' => $type_name,
            'serial_number' => $serial_number,
            'service_tag' => $service_tag,
            'note' => $note,

        ];

        $data['contract'] = $pdf;
        $pdf = PDF::loadView('HRIS.administration.asset.resource.pdf', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('Asset Assign ' . $mem_name . '.pdf');

    }

}
