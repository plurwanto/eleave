<?php

namespace App\Http\Controllers\HRIS;

use App\ElaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class settingHRIS extends Controller
{
    public $menuID = 6;

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

        $data['link'] = $request->get('master');
        $link = ['branch',
            'bank',
            'division',
            'holiday',
            'timesheet-type',
            'claim-type',
            'travel-company',
            'travel-class',
            'travel-status',
            'fix-allowance-type',
            'fix-allowance-master',
            'contract-city',
            'deduction-type',
            'document-type',
            'contract-cus-ref-type',
            'purchase-order-type',
            'contract-cus-accept-type-1',
            'contract-cus-accept-type-2',
            'payroll-approval',
            'asset',
            'vendor',
            'brand',
            'type',
            'processor',
            'hdd',
            'ram'];

        $name_link = ['Branch',
            'Bank',
            'Division',
            'Holiday',
            'Type of Timesheet',
            'Type of Claim',
            'Transportation Name',
            'Transportation Class',
            'Transportation Status',
            'Type of Fix Allowance',
            'Type of Fix Allowance Master',
            'Site Location',
            'Type of Deduction',
            'Type of Document ',
            'Type of Customer Referance',
            'Type of Purchase Order',
            'Type of Customer Acceptance 1',
            'Type of Customer Acceptance 2',
            'Payroll Approval',
            'Asset',
            'Asset Vendor',
            'Asset Brand',
            'Asset Type',
            'Asset Processor',
            'Asset HDD',
            'Asset RAM'];
        $select = '';
        $select .= '<select style="width:200px; margin-right:10px" class="form-control border-rounded pull-left"  border-rounded" onchange="javascript:handleSelect(this)">';
        $select2 = '';
        for ($i = 0; $i < count($link); $i++) {
            if ($i == 0) {
                $select2 .= '<option value="' . env('APP_URL') . '/hris/master/hris-setting">' . $name_link[$i] . '</option>';
            } else {
                if ($request->get('master') == $link[$i]) {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/master/hris-setting?master=' . $link[$i] . '" selected>' . $name_link[$i] . '</option>';
                } else {
                    $select2 .= '<option value="' . env('APP_URL') . '/hris/master/hris-setting?master=' . $link[$i] . '">' . $name_link[$i] . '</option>';
                }
            }

        }
        $select .= $select2;
        $select .= '</select><input type="hidden" id="link" value="' . $request->get('master') . '">';

        $data['select'] = $select;

        $urlMenu = 'master-global';
        $urlMenu_join = 'hris/hris-setting/master-global-join';

        if ($request->get('master')) {
            switch ($request->get('master')) {
                case 'bank':
                    $data['title'] = 'Bank';
                    $data['subtitle'] = 'List Bank';
                    $param = [
                        "order" => ["bank_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "_mbank",
                    ];
                    $data['bank'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-bank.index', $data);
                    break;
                case 'division':
                    $data['title'] = 'Division';
                    $data['subtitle'] = 'List Division';
                    $param = [
                        "order" => ["div_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "_mdivision",
                    ];
                    $data['division'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-division.index', $data);
                    break;
                case 'holiday':
                    $data['title'] = 'Holiday';
                    $data['subtitle'] = 'List Holiday';
                    $param = [
                        "order" => ["ts_hol_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "_timesheet_holiday",
                    ];
                    $data['holiday'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-holiday.index', $data);
                    break;
                case 'timesheet-type':
                    $data['title'] = 'Timesheet Type';
                    $data['subtitle'] = 'List Timesheet Type';
                    $param = [
                        "order" => ["ts_type_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "_timesheet_type",
                    ];
                    $data['timesheetType'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-timesheet-type.index', $data);
                    break;
                case 'claim-type':
                    $data['title'] = 'Claim Type';
                    $data['subtitle'] = 'List Claim Type';
                    $param = [
                        "order" => ["clai_type_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "_claim_type",
                    ];
                    $data['claimType'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-type-claim.index', $data);
                    break;
                case 'travel-company':
                    $data['title'] = 'Travel Company';
                    $data['subtitle'] = 'List Travel Company';
                    $param = [
                        "order" => ["trav_company_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "_travel_company",
                    ];
                    $data['travelCompany'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-travel-company.index', $data);
                    break;
                case 'travel-class':
                    $data['title'] = 'Travel Class';
                    $data['subtitle'] = 'List Travel Class';
                    $param = [
                        "order" => ["trav_class_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "_travel_class",
                    ];
                    $data['travelClass'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-travel-class.index', $data);
                    break;
                case 'travel-status':
                    $data['title'] = 'Travel Status';
                    $data['subtitle'] = 'List Travel Status';
                    $param = [
                        "order" => ["trav_sta_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "_travel_status",
                    ];
                    $data['travelStatus'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-travel-status.index', $data);
                    break;
                case 'fix-allowance-type':
                    $data['title'] = 'Fix Allowance Type';
                    $data['subtitle'] = 'List Fix Allowance Type';
                    $param = [
                        "order" => ["fix_allow_type_id", "DESC"],
                        "fields" => ["_fix_allowance_type.*", "_fix_allowance_master.fix_allow_master_name"],
                        "where" => ["_fix_allowance_type.cus_id", 0],
                        "join" => ["_fix_allowance_master", "_fix_allowance_type.fix_allow_master_id", "_fix_allowance_master.fix_allow_master_id"],
                        "table" => "_fix_allowance_type",
                    ];
                    $data['fixAllowanceType'] = json_decode(ElaHelper::myCurl($urlMenu_join, $param));
                    return view('HRIS.master.settingHRIS.master-fix-allowance-type.index', $data);
                    break;
                case 'fix-allowance-master':
                    $data['title'] = 'Fix Allowance Master';
                    $data['subtitle'] = 'List Fix Allowance Master';
                    $param = [
                        "order" => ["fix_allow_master_id", "DESC"],
                        "fields" => ["_fix_allowance_master.*"],
                        "table" => "_fix_allowance_master",
                    ];
                    $data['fixAllowanceMaster'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-fix-allowance-master.index', $data);
                    break;
                case 'contract-city':
                    $data['title'] = 'Site Location';
                    $data['subtitle'] = 'List Site Location';
                    $param = [
                        "order" => ["cont_city_id", "DESC"],
                        "fields" => ["_contract_city.*", "_mcustomer.cus_name", "_mcity.city_name"],
                        "join" => ["_mcustomer", "_contract_city.cus_id", "_mcustomer.cus_id"],
                        "join2" => ["_mcity", "_contract_city.city_id", "_mcity.city_id"],
                        "where" => ["_contract_city.cus_id", 0],
                        "table" => "_contract_city",
                    ];
                    $data['contractCity'] = json_decode(ElaHelper::myCurl($urlMenu_join, $param));
                    return view('HRIS.master.settingHRIS.master-contract-city.index', $data);
                    break;
                case 'deduction-type':
                    $data['title'] = 'Type of Deduction';
                    $data['subtitle'] = 'List Type of Deduction';
                    $param = [
                        "order" => ["dt_id", "DESC"],
                        "fields" => ["_deduction_type.*"],
                        "table" => "_deduction_type",
                    ];
                    $data['deductionType'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-deduction-type.index', $data);
                    break;
                case 'document-type':
                    $data['title'] = 'Type of Document';
                    $data['subtitle'] = 'List Type of Document';
                    $param = [
                        "order" => ["doc_type_id", "DESC"],
                        "fields" => ["_document_type.*", "_document_department.doc_dept_name"],
                        "join" => ["_document_department", "_document_type.doc_dept_id", "_document_department.doc_dept_id"],
                        "table" => "_document_type",
                    ];
                    $data['documentType'] = json_decode(ElaHelper::myCurl($urlMenu_join, $param));
                    return view('HRIS.master.settingHRIS.master-document-type.index', $data);
                    break;
                case 'contract-cus-ref-type':
                    $data['title'] = 'Type of Customer Referance';
                    $data['subtitle'] = 'List Type of Customer Referance';
                    $param = [
                        "order" => ["cus_ref_typ_id", "DESC"],
                        "fields" => ["_contract_cus_ref_type.*", "_mcustomer.cus_name"],
                        "join" => ["_mcustomer", "_contract_cus_ref_type.cus_id", "_mcustomer.cus_id"],
                        "table" => "_contract_cus_ref_type",
                    ];
                    $data['contractCusRefType'] = json_decode(ElaHelper::myCurl($urlMenu_join, $param));
                    return view('HRIS.master.settingHRIS.master-contract-cus-ref-type.index', $data);
                    break;
                case 'purchase-order-type':
                    $data['title'] = 'TYPE OF PURCHASE ORDER';
                    $data['subtitle'] = 'List TYPE OF PURCHASE ORDER';
                    $param = [
                        "order" => ["pur_ord_typ_id", "DESC"],
                        "fields" => ["_contract_pur_order_type.*", "_mcustomer.cus_name"],
                        "join" => ["_mcustomer", "_contract_pur_order_type.cus_id", "_mcustomer.cus_id"],
                        "table" => "_contract_pur_order_type",
                    ];
                    $data['purchaseOrderType'] = json_decode(ElaHelper::myCurl($urlMenu_join, $param));
                    return view('HRIS.master.settingHRIS.master-purchase-order-type.index', $data);
                    break;
                case 'contract-cus-accept-type-1':
                    $data['title'] = 'TYPE OF CUSTOMER ACCEPTANCE 1';
                    $data['subtitle'] = 'List TYPE OF CUSTOMER ACCEPTANCE 1';
                    $param = [
                        "order" => ["cus_accept_typ_1_id", "DESC"],
                        "fields" => ["_contract_cus_accept_type_1.*", "_mcustomer.cus_name"],
                        "join" => ["_mcustomer", "_contract_cus_accept_type_1.cus_id", "_mcustomer.cus_id"],
                        "table" => "_contract_cus_accept_type_1",
                    ];
                    $data['contractCusAcceptType1'] = json_decode(ElaHelper::myCurl($urlMenu_join, $param));
                    return view('HRIS.master.settingHRIS.master-contract-cus-accept-type-1.index', $data);
                    break;
                case 'contract-cus-accept-type-2':
                    $data['title'] = 'TYPE OF CUSTOMER ACCEPTANCE 2';
                    $data['subtitle'] = 'List TYPE OF CUSTOMER ACCEPTANCE 2';
                    $param = [
                        "order" => ["cus_accept_typ_2_id", "DESC"],
                        "fields" => ["_contract_cus_accept_type_2.*", "_mcustomer.cus_name"],
                        "join" => ["_mcustomer", "_contract_cus_accept_type_2.cus_id", "_mcustomer.cus_id"],
                        "table" => "_contract_cus_accept_type_2",
                    ];
                    $data['contractCusAcceptType2'] = json_decode(ElaHelper::myCurl($urlMenu_join, $param));
                    return view('HRIS.master.settingHRIS.master-contract-cus-accept-type-2.index', $data);
                    break;
                case 'payroll-approval':
                    $data['title'] = 'Payroll Approval';
                    $data['subtitle'] = 'List Payroll Approval';
                    $param = [
                        "order" => ["menu_id", "DESC"],
                        "fields" => ["menu_id", "menu_name", "menu_code", "status"],
                        "where" => ["parent_id", "1"],
                        "table" => "hris_menu_setting",
                    ];
                    $data['approval'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-payroll-approval.index', $data);
                    break;
                case 'asset':
                    $data['title'] = 'Asset';
                    $data['subtitle'] = 'List Asset';
                    $param = [
                        "id_hris" => session('id_hris'),
                    ];
                    $data['asset'] = json_decode(ElaHelper::myCurl('hris/asset/item/get-asset', $param));
                    return view('HRIS.master.settingHRIS.master-asset.index', $data);
                    break;
                case 'vendor':
                    $data['title'] = 'Vendor';
                    $data['subtitle'] = 'List Vendor';
                    $param = [
                        "order" => ["ass_vendor_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "asset_vendor",
                    ];
                    $data['vendor'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-vendor.index', $data);
                    break;
                case 'brand':
                    $data['title'] = 'Brand';
                    $data['subtitle'] = 'List Brand';
                    $param = [
                        "order" => ["ass_brand_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "asset_brand",
                    ];
                    $data['brand'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-brand.index', $data);
                    break;
                case 'type':
                    $data['title'] = 'Type';
                    $data['subtitle'] = 'List Type';
                    $param = [
                        "order" => ["ass_type_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "asset_type",
                    ];
                    $data['type'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-type.index', $data);
                    break;

                case 'processor':
                    $data['title'] = 'Asset Processor';
                    $data['subtitle'] = 'List Processor';
                    $param = [
                        "order" => ["ass_processor_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "asset_processor",
                    ];
                    $data['processor'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-processor.index', $data);
                    break;
                case 'ram':
                    $data['title'] = 'Asset RAM';
                    $data['subtitle'] = 'List Ram';
                    $param = [
                        "order" => ["ass_ram_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "asset_ram",
                    ];
                    $data['ram'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-ram.index', $data);
                    break;
                case 'hdd':
                    $data['title'] = 'Asset HDD';
                    $data['subtitle'] = 'List HDD';
                    $param = [
                        "order" => ["ass_hdd_id", "DESC"],
                        "fields" => ["*"],
                        "table" => "asset_hdd",
                    ];
                    $data['hdd'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                    return view('HRIS.master.settingHRIS.master-hdd.index', $data);
                    break;
            }
        } else {
            $data['title'] = 'Branch';
            $data['subtitle'] = 'List Branch';
            $param = [
                "order" => ["br_id", "DESC"],
                "fields" => ["*"],
                "table" => "_mbranch",
            ];
            $data['branch'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
            return view('HRIS.master.settingHRIS.master-branch.index', $data);
        }
    }

    public function add(Request $request)
    {
        $data['link'] = $request->get('link');
        $urlMenu = 'master-global';
        $param = [
            "order" => ["cus_name", "asc"],
            "fields" => ["cus_id", "cus_name"],
            "table" => "_mcustomer",
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

        switch ($request->get('link')) {
            case 'bank':
                $data['title'] = 'Add Bank';
                return view('HRIS.master.settingHRIS.master-bank.add', $data);
                break;
            case 'division':
                $data['title'] = 'Add Division';
                return view('HRIS.master.settingHRIS.master-division.add', $data);
                break;
            case 'holiday':
                $data['title'] = 'Add Holiday';
                return view('HRIS.master.settingHRIS.master-holiday.add', $data);
                break;
            case 'timesheet-type':
                $data['title'] = 'Add Type of Timesheet';
                return view('HRIS.master.settingHRIS.master-timesheet-type.add', $data);
                break;
            case 'claim-type':
                $data['title'] = 'Add Type of Claim';
                return view('HRIS.master.settingHRIS.master-type-claim.add', $data);
                break;
            case 'travel-company':
                $data['title'] = 'Add Transportation Name';
                return view('HRIS.master.settingHRIS.master-travel-company.add', $data);
                break;
            case 'travel-class':
                $data['title'] = 'Add Transportation Class';
                return view('HRIS.master.settingHRIS.master-travel-class.add', $data);
                break;
            case 'travel-status':
                $data['title'] = 'Add Transportation Status';
                return view('HRIS.master.settingHRIS.master-travel-status.add', $data);
                break;
            case 'fix-allowance-type':
                $data['title'] = 'Add Type of Fix Allowance';
                $data['link'] = $request->get('link');
                $param = [
                    "order" => ["fix_allow_master_name", "ASC"],
                    "fields" => ["fix_allow_master_id", "fix_allow_master_name"],
                    "table" => "_fix_allowance_master",
                ];
                $data['fixAllowanceMaster'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-fix-allowance-type.add', $data);
                break;
            case 'fix-allowance-master':
                $data['title'] = 'Add Type of Fix Allowance Master';
                return view('HRIS.master.settingHRIS.master-fix-allowance-master.add', $data);
                break;
            case 'contract-city':
                $data['title'] = 'Add Site Location';
                $param = [
                    "order" => ["city_name", "ASC"],
                    "fields" => ["city_id", "city_name"],
                    "table" => "_mcity",
                ];
                $data['city'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-contract-city.add', $data);
                break;
            case 'deduction-type':
                $data['title'] = 'Add Type of Deduction';
                return view('HRIS.master.settingHRIS.master-deduction-type.add', $data);
                break;
            case 'document-type':
                $data['title'] = 'Add Type of Decument';
                $param = [
                    "order" => ["doc_dept_name", "ASC"],
                    "fields" => ["doc_dept_id", "doc_dept_name"],
                    "table" => "_document_department",
                ];
                $data['departement'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-document-type.add', $data);
                break;
            case 'contract-cus-ref-type':
                $data['title'] = 'Add Type of Customer Referance';
                return view('HRIS.master.settingHRIS.master-contract-cus-ref-type.add', $data);
                break;
            case 'purchase-order-type':
                $data['title'] = 'Add Type of Purchase Order';
                return view('HRIS.master.settingHRIS.master-purchase-order-type.add', $data);
                break;
            case 'contract-cus-accept-type-1':
                $data['title'] = 'Add Type of Customer Acceptance 1';
                return view('HRIS.master.settingHRIS.master-contract-cus-accept-type-1.add', $data);
                break;
            case 'contract-cus-accept-type-2':
                $data['title'] = 'Add Type of Customer Acceptance 2';
                return view('HRIS.master.settingHRIS.master-contract-cus-accept-type-2.add', $data);
                break;
            case 'payroll-approval':
                $data['title'] = 'Add Payroll Approval';
                return view('HRIS.master.settingHRIS.master-payroll-approval.add', $data);
                break;
            case 'asset':
                $data['title'] = 'Add Asset';
                $param = [
                    "order" => ["vendor_name", "ASC"],
                    "fields" => ["ass_vendor_id", "vendor_name"],
                    "table" => "asset_vendor",
                ];
                $data['vendor'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

                $param = [
                    "order" => ["type_name", "ASC"],
                    "fields" => ["ass_type_id", "type_name"],
                    "table" => "asset_type",
                ];
                $data['type'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

                $param = [
                    "order" => ["brand_name", "ASC"],
                    "fields" => ["ass_brand_id", "brand_name"],
                    "table" => "asset_brand",
                ];
                $data['brand'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

                return view('HRIS.master.settingHRIS.master-asset.add', $data);
                break;
            case 'vendor':
                $data['title'] = 'Add Vendor';
                return view('HRIS.master.settingHRIS.master-vendor.add', $data);
                break;
            case 'brand':
                $data['title'] = 'Add Brand';
                return view('HRIS.master.settingHRIS.master-brand.add', $data);
                break;
            case 'type':
                $data['title'] = 'Add Type';
                return view('HRIS.master.settingHRIS.master-type.add', $data);
                break;
            case 'processor':
                $data['title'] = 'Add Processor';
                return view('HRIS.master.settingHRIS.master-processor.add', $data);
                break;
            case 'ram':
                $data['title'] = 'Add RAM';
                return view('HRIS.master.settingHRIS.master-ram.add', $data);
                break;
            case 'hdd':
                $data['title'] = 'Add HDD';
                return view('HRIS.master.settingHRIS.master-hdd.add', $data);
                break;
            default;
                $data['title'] = 'Add Branch';
                return view('HRIS.master.settingHRIS.master-branch.add', $data);
        }
    }

    public function edit(Request $request)
    {
        $link = $request->get('link');
        $data['link'] = $link;
        $id = $request->get('id');
        $urlMenu = 'hris/hris-setting/master-data-edit';
        $urlMenu2 = 'master-global';

        $param = [
            "order" => ["cus_name", "asc"],
            "fields" => ["cus_id", "cus_name"],
            "table" => "_mcustomer",
        ];
        $data['customer'] = json_decode(ElaHelper::myCurl($urlMenu2, $param));

        switch ($link) {
            case 'bank':
                $data['title'] = 'Bank';
                $data['subtitle'] = 'List Bank';
                $param = [
                    "order" => ["bank_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["bank_id", $id],
                    "table" => "_mbank",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-bank.edit', $data);
                break;
            case 'division':
                $data['title'] = 'Division';
                $data['subtitle'] = 'List Division';
                $param = [
                    "order" => ["div_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["div_id", $id],
                    "table" => "_mdivision",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-division.edit', $data);
                break;
            case 'holiday':
                $data['title'] = 'Holiday';
                $data['subtitle'] = 'List Holiday';
                $param = [
                    "order" => ["ts_hol_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ts_hol_id", $id],
                    "table" => "_timesheet_holiday",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-holiday.edit', $data);
                break;
            case 'timesheet-type':
                $data['title'] = 'Timesheet Type';
                $data['subtitle'] = 'List Timesheet Type';
                $param = [
                    "order" => ["ts_type_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ts_type_id", $id],
                    "table" => "_timesheet_type",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-timesheet-type.edit', $data);
                break;
            case 'claim-type':
                $data['title'] = 'Claim Type';
                $data['subtitle'] = 'List Claim Type';
                $param = [
                    "order" => ["clai_type_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["clai_type_id", $id],
                    "table" => "_claim_type",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-type-claim.edit', $data);
                break;
            case 'travel-company':
                $data['title'] = 'Travel Company';
                $data['subtitle'] = 'List Travel Company';
                $param = [
                    "order" => ["trav_company_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["trav_company_id", $id],
                    "table" => "_travel_company",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-travel-company.edit', $data);
                break;
            case 'travel-class':
                $data['title'] = 'Travel Class';
                $data['subtitle'] = 'List Travel Class';
                $param = [
                    "order" => ["trav_class_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["trav_class_id", $id],
                    "table" => "_travel_class",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-travel-class.edit', $data);
                break;
            case 'travel-status':
                $data['title'] = 'Travel Status';
                $data['subtitle'] = 'List Travel Status';
                $param = [
                    "order" => ["trav_sta_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["trav_sta_id", $id],
                    "table" => "_travel_status",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-travel-status.edit', $data);
                break;
            case 'fix-allowance-type':
                $data['title'] = 'Fix Allowance Type';
                $data['subtitle'] = 'List Fix Allowance Type';
                $param = [
                    "order" => ["fix_allow_master_name", "ASC"],
                    "fields" => ["fix_allow_master_id", "fix_allow_master_name"],
                    "table" => "_fix_allowance_master",
                ];
                $data['fixAllowanceMaster'] = json_decode(ElaHelper::myCurl($urlMenu2, $param));
                $param = [
                    "order" => ["fix_allow_type_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["fix_allow_type_id", $id],
                    "table" => "_fix_allowance_type",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-fix-allowance-type.edit', $data);
                break;
            case 'fix-allowance-master':
                $data['title'] = 'Fix Allowance Master';
                $data['subtitle'] = 'List Fix Allowance Master';
                $param = [
                    "order" => ["fix_allow_master_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["fix_allow_master_id", $id],
                    "table" => "_fix_allowance_master",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-fix-allowance-master.edit', $data);
                break;
            case 'contract-city':
                $data['title'] = 'Site Location';
                $data['subtitle'] = 'List Site Location';

                $param = [
                    "order" => ["city_name", "ASC"],
                    "fields" => ["city_id", "city_name"],
                    "table" => "_mcity",
                ];
                $data['city'] = json_decode(ElaHelper::myCurl($urlMenu2, $param));

                $param = [
                    "order" => ["cont_city_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["cont_city_id", $id],
                    "table" => "_contract_city",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-contract-city.edit', $data);
                break;
            case 'deduction-type':
                $data['title'] = 'Type of Deduction';
                $data['subtitle'] = 'List Type of Deduction';
                $param = [
                    "order" => ["dt_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["dt_id", $id],
                    "table" => "_deduction_type",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-deduction-type.edit', $data);
                break;
            case 'document-type':
                $data['title'] = 'Type of Document';
                $data['subtitle'] = 'List Type of Document';
                $param = [
                    "order" => ["doc_dept_name", "ASC"],
                    "fields" => ["doc_dept_id", "doc_dept_name"],
                    "table" => "_document_department",
                ];
                $data['departement'] = json_decode(ElaHelper::myCurl($urlMenu2, $param));
                $param = [
                    "order" => ["doc_type_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["doc_type_id", $id],
                    "table" => "_document_type",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-document-type.edit', $data);
                break;
            case 'contract-cus-ref-type':
                $data['title'] = 'Type of Customer Referance';
                $data['subtitle'] = 'List Type of Customer Referance';
                $param = [
                    "order" => ["cus_ref_typ_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["cus_ref_typ_id", $id],
                    "table" => "_contract_cus_ref_type",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-contract-cus-ref-type.edit', $data);
                break;
            case 'purchase-order-type':
                $data['title'] = 'TYPE OF PURCHASE ORDER';
                $data['subtitle'] = 'List TYPE OF PURCHASE ORDER';
                $param = [
                    "order" => ["pur_ord_typ_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["pur_ord_typ_id", $id],
                    "table" => "_contract_pur_order_type",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-purchase-order-type.edit', $data);
                break;
            case 'contract-cus-accept-type-1':
                $data['title'] = 'TYPE OF CUSTOMER ACCEPTANCE 1';
                $data['subtitle'] = 'List TYPE OF CUSTOMER ACCEPTANCE 1';
                $param = [
                    "order" => ["cus_accept_typ_1_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["cus_accept_typ_1_id", $id],
                    "table" => "_contract_cus_accept_type_1",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-contract-cus-accept-type-1.edit', $data);
                break;
            case 'contract-cus-accept-type-2':
                $data['title'] = 'TYPE OF CUSTOMER ACCEPTANCE 2';
                $data['subtitle'] = 'List TYPE OF CUSTOMER ACCEPTANCE 2';
                $param = [
                    "order" => ["cus_accept_typ_2_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["cus_accept_typ_2_id", $id],
                    "table" => "_contract_cus_accept_type_2",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-contract-cus-accept-type-2.edit', $data);
                break;
            case 'payroll-approval':
                $data['title'] = 'Payroll Approval';
                $data['subtitle'] = 'List TYPE OF CUSTOMER ACCEPTANCE 2';
                $param = [
                    "order" => ["cus_accept_typ_2_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["cus_accept_typ_2_id", $id],
                    "table" => "_contract_cus_accept_type_2",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-payroll-approval.edit', $data);
                break;
            case 'asset':
                $data['title'] = 'Asset';
                $data['subtitle'] = 'List Asset';

                $param = [
                    "order" => ["vendor_name", "ASC"],
                    "fields" => ["ass_vendor_id", "vendor_name"],
                    "table" => "asset_vendor",
                ];
                $data['vendor'] = json_decode(ElaHelper::myCurl($urlMenu2, $param));

                $param = [
                    "order" => ["type_name", "ASC"],
                    "fields" => ["ass_type_id", "type_name"],
                    "table" => "asset_type",
                ];
                $data['type'] = json_decode(ElaHelper::myCurl($urlMenu2, $param));

                $param = [
                    "order" => ["brand_name", "ASC"],
                    "fields" => ["ass_brand_id", "brand_name"],
                    "table" => "asset_brand",
                ];
                $data['brand'] = json_decode(ElaHelper::myCurl($urlMenu2, $param));

                $param = [
                    "order" => ["vendor_name", "ASC"],
                    "fields" => ["ass_vendor_id", "vendor_name"],
                    "table" => "asset_vendor",
                ];
                $data['vendor'] = json_decode(ElaHelper::myCurl($urlMenu2, $param));

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

                $param = [
                    "order" => ["ass_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_id", $id],
                    "table" => "asset",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));

                return view('HRIS.master.settingHRIS.master-asset.edit', $data);
                break;
            case 'vendor':
                $data['title'] = 'vendor';
                $data['subtitle'] = 'List Vendor';
                $param = [
                    "order" => ["ass_vendor_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_vendor_id", $id],
                    "table" => "asset_vendor",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-vendor.edit', $data);
                break;
            case 'brand':
                $data['title'] = 'Brand';
                $data['subtitle'] = 'List Brand';
                $param = [
                    "order" => ["ass_brand_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_brand_id", $id],
                    "table" => "asset_brand",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-brand.edit', $data);
                break;
            case 'type':
                $data['title'] = 'Type';
                $data['subtitle'] = 'List Type';
                $param = [
                    "order" => ["ass_type_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_type_id", $id],
                    "table" => "asset_type",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-type.edit', $data);
            case 'processor':
                $data['title'] = 'Processor';
                $data['subtitle'] = 'List Processor';
                $param = [
                    "order" => ["ass_processor_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_processor_id", $id],
                    "table" => "asset_processor",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-processor.edit', $data);
                break;
            case 'ram':
                $data['title'] = 'RAM';
                $data['subtitle'] = 'List RAM';
                $param = [
                    "order" => ["ass_ram_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_ram_id", $id],
                    "table" => "asset_ram",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-ram.edit', $data);
                break;
            case 'hdd':
                $data['title'] = 'HDD';
                $data['subtitle'] = 'List HDD';
                $param = [
                    "order" => ["ass_hdd_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["ass_hdd_id", $id],
                    "table" => "asset_hdd",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-hdd.edit', $data);
                break;
            default;
                $data['title'] = 'Branch';
                $data['subtitle'] = 'List Branch';
                $param = [
                    "order" => ["br_id", "DESC"],
                    "fields" => ["*"],
                    "where" => ["br_id", $id],
                    "table" => "_mbranch",
                ];
                $data['row'] = json_decode(ElaHelper::myCurl($urlMenu, $param));
                return view('HRIS.master.settingHRIS.master-branch.edit', $data);
        }
    }

    public function doAdd(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $current_datetime = date('Y-m-d H:i:s');

        $data['link'] = $request->get('link');
        $urlMenu = 'hris/hris-setting/do-add';

        switch ($request->get('link')) {
            case 'bank':
                $inputArray = ["bank_name" => $request->post('bank_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_mbank",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'division':
                $inputArray = [
                    "div_name" => $request->post('div_name'),
                    "div_active" => $request->post('div_active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_mdivision",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'holiday':
                $inputArray = [
                    "ts_hol_date" => date('Y-m-d', strtotime($request->post('date'))),
                    "ts_hol_name" => $request->post('name'),
                    "ts_hol_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_timesheet_holiday",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'timesheet-type':
                $inputArray = [
                    "ts_type_name" => $request->post('name'),
                    "ts_type_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_timesheet_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'claim-type':
                $inputArray = [
                    "clai_type_name" => $request->post('name'),
                    "clai_type_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_claim_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-company':
                $inputArray = [
                    "trav_company_name" => $request->post('name'),
                    "trav_company_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_travel_company",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-class':
                $inputArray = [
                    "trav_class_name" => $request->post('name'),
                    "trav_class_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_travel_class",
                ];

                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-status':
                $inputArray = [
                    "trav_sta_name" => $request->post('name'),
                    "trav_sta_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_travel_status",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'fix-allowance-type':
                $inputArray = [
                    "fix_allow_type_name" => $request->post('name'),
                    "fix_allow_master_id" => $request->post('master'),
                    "fix_allow_type_active" => $request->post('active'),
                    "cus_id" => 0,
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_fix_allowance_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'fix-allowance-master':
                $inputArray = [
                    "fix_allow_master_name" => $request->post('name'),
                    "fix_allow_master_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_fix_allowance_master",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-city':
                $inputArray = [
                    "cont_city_name" => $request->post('name'),
                    "city_id" => $request->post('city'),
                    "cus_id" => 0,
                    "cont_city_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_contract_city",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'deduction-type':
                $inputArray = [
                    "dt_name" => $request->post('name'),
                    "dt_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_deduction_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'document-type':
                $inputArray = [
                    "doc_type_name" => $request->post('name'),
                    "doc_dept_id" => $request->post('departement'),
                    "doc_type_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_document_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-ref-type':
                $inputArray = [
                    "cus_ref_typ_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "cus_ref_typ_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_contract_cus_ref_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'purchase-order-type':
                $inputArray = [
                    "pur_ord_typ_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "pur_ord_typ_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_contract_pur_order_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-accept-type-1':
                $inputArray = [
                    "cus_accept_typ_1_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "cus_accept_typ_1_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_contract_cus_accept_type_1",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-accept-type-2':
                $inputArray = [
                    "cus_accept_typ_2_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "cus_accept_typ_2_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_contract_cus_accept_type_2",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'payroll-approval':
                $inputArray = [
                    "cus_accept_typ_2_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "cus_accept_typ_2_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_contract_cus_accept_type_2",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'asset':
                $inputArray = [
                    "ass_brand_id" => $request->post('brand'),
                    "ass_type_id" => $request->post('type'),
                    "model" => $request->post('model'),
                    "ass_vendor_id" => $request->post('vendor'),
                    "status" => $request->post('status'),
                    "updated_by" => session('id_hris'),
                    "updated_at" => $current_datetime,
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "asset",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;

            case 'vendor':
                $inputArray = [
                    "vendor_name" => $request->post('vendor_name'),
                    "vendor_mobile" => $request->post('vendor_mobile'),
                    "vendor_address" => $request->post('vendor_address'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "asset_vendor",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'brand':
                $inputArray = ["brand_name" => $request->post('brand_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "asset_brand",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'type':
                $inputArray = ["type_name" => $request->post('type_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "asset_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;

            case 'processor':
                $inputArray = ["processor_name" => $request->post('processor_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "asset_processor",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;

            default;
                $inputArray = [
                    "br_name" => $request->post('br_name'),
                    "br_code" => $request->post('br_code'),
                    "br_address" => $request->post('address'),
                    "br_phone" => $request->post('phone'),
                    "br_fax" => $request->post('fax'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "table" => "_mbranch",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
        }

        $data['response_code'] = $response->response_code;
        $data['message'] = $response->message;
        echo json_encode($data);
    }

    public function doEdit(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $current_datetime = date('Y-m-d H:i:s');

        $data['link'] = $request->get('link');
        $urlMenu = 'hris/hris-setting/do-edit';

        switch ($request->get('link')) {
            case 'bank':
                $inputArray = ["bank_name" => $request->post('bank_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["bank_id", $request->post('id')],
                    "table" => "_mbank",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'division':
                $inputArray = [
                    "div_name" => $request->post('div_name'),
                    "div_active" => $request->post('div_active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["div_id", $request->post('id')],
                    "table" => "_mdivision",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'holiday':
                $inputArray = [
                    "ts_hol_date" => date('Y-m-d', strtotime($request->post('date'))),
                    "ts_hol_name" => $request->post('name'),
                    "ts_hol_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ts_hol_id", $request->post('id')],
                    "table" => "_timesheet_holiday",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'timesheet-type':
                $inputArray = [
                    "ts_type_name" => $request->post('name'),
                    "ts_type_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ts_type_id", $request->post('id')],
                    "table" => "_timesheet_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'claim-type':
                $inputArray = [
                    "clai_type_name" => $request->post('name'),
                    "clai_type_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["clai_type_id", $request->post('id')],
                    "table" => "_claim_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-company':
                $inputArray = [
                    "trav_company_name" => $request->post('name'),
                    "trav_company_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["trav_company_id", $request->post('id')],
                    "table" => "_travel_company",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-class':
                $inputArray = [
                    "trav_class_name" => $request->post('name'),
                    "trav_class_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["trav_class_id", $request->post('id')],
                    "table" => "_travel_class",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-status':
                $inputArray = [
                    "trav_sta_name" => $request->post('name'),
                    "trav_sta_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["trav_sta_id", $request->post('id')],
                    "table" => "_travel_status",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'fix-allowance-type':
                $inputArray = [
                    "fix_allow_type_name" => $request->post('name'),
                    "fix_allow_master_id" => $request->post('master'),
                    "fix_allow_type_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["fix_allow_type_id", $request->post('id')],
                    "table" => "_fix_allowance_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'fix-allowance-master':
                $inputArray = [
                    "fix_allow_master_name" => $request->post('name'),
                    "fix_allow_master_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["fix_allow_master_id", $request->post('id')],
                    "table" => "_fix_allowance_master",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-city':
                $inputArray = [
                    "cont_city_name" => $request->post('name'),
                    "city_id" => $request->post('city'),
                    "cont_city_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["cont_city_id", $request->post('id')],
                    "table" => "_contract_city",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'deduction-type':
                $inputArray = [
                    "dt_name" => $request->post('name'),
                    "dt_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["dt_id", $request->post('id')],
                    "table" => "_deduction_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'document-type':
                $inputArray = [
                    "doc_type_name" => $request->post('name'),
                    "doc_dept_id" => $request->post('departement'),
                    "doc_type_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["doc_type_id", $request->post('id')],
                    "table" => "_document_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-ref-type':
                $inputArray = [
                    "cus_ref_typ_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "cus_ref_typ_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["cus_ref_typ_id", $request->post('id')],
                    "table" => "_contract_cus_ref_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'purchase-order-type':
                $inputArray = [
                    "pur_ord_typ_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "pur_ord_typ_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["pur_ord_typ_id", $request->post('id')],
                    "table" => "_contract_pur_order_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-accept-type-1':
                $inputArray = [
                    "cus_accept_typ_1_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "cus_accept_typ_1_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["cus_accept_typ_1_id", $request->post('id')],
                    "table" => "_contract_cus_accept_type_1",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-accept-type-2':
                $inputArray = [
                    "cus_accept_typ_2_name" => $request->post('name'),
                    "cus_id" => $request->post('customer'),
                    "cus_accept_typ_2_active" => $request->post('active'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["cus_accept_typ_2_id", $request->post('id')],
                    "table" => "_contract_cus_accept_type_2",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'asset':
                $inputArray = [
                    "ass_brand_id" => $request->post('brand'),
                    "ass_type_id" => $request->post('type'),
                    "model" => $request->post('model'),
                    "ass_vendor_id" => $request->post('vendor'),
                    "status" => $request->post('status'),
                    "updated_by" => session('id_hris'),
                    "updated_at" => $current_datetime,

                ];

                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ass_id", $request->post('id')],
                    "table" => "asset",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'vendor':
                $inputArray = [
                    "vendor_name" => $request->post('vendor_name'),
                    "vendor_mobile" => $request->post('vendor_mobile'),
                    "vendor_address" => $request->post('vendor_address'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ass_vendor_id", $request->post('id')],
                    "table" => "asset_vendor",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'brand':
                $inputArray = ["brand_name" => $request->post('brand_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ass_brand_id", $request->post('id')],
                    "table" => "asset_brand",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'type':
                $inputArray = ["type_name" => $request->post('type_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ass_type_id", $request->post('id')],
                    "table" => "asset_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'processor':
                $inputArray = ["processor_name" => $request->post('processor_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ass_processor_id", $request->post('id')],
                    "table" => "asset_processor",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'hdd':
                $inputArray = ["hdd_name" => $request->post('hdd_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ass_hdd_id", $request->post('id')],
                    "table" => "asset_hdd",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'ram':
                $inputArray = ["ram_name" => $request->post('ram_name')];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["ass_ram_id", $request->post('id')],
                    "table" => "asset_ram",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            default;
                $inputArray = [
                    "br_name" => $request->post('br_name'),
                    "br_code" => $request->post('br_code'),
                    "br_address" => $request->post('address'),
                    "br_phone" => $request->post('phone'),
                    "br_fax" => $request->post('fax'),
                ];
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "inputArray" => $inputArray,
                    "where" => ["br_id", $request->post('id')],
                    "table" => "_mbranch",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
        }

        $data['response_code'] = $response->response_code;
        $data['message'] = $response->message;
        echo json_encode($data);
    }

    public function doDelete(Request $request)
    {
        $data['link'] = $request->get('link');
        $urlMenu = 'hris/hris-setting/do-delete';

        switch ($request->get('link')) {
            case 'bank':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["bank_id", $request->post('id')],
                    "table" => "_mbank",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'division':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["div_id", $request->post('id')],
                    "table" => "_mdivision",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'holiday':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ts_hol_id", $request->post('id')],
                    "table" => "_timesheet_holiday",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'timesheet-type':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ts_type_id", $request->post('id')],
                    "table" => "_timesheet_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'claim-type':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["clai_type_id", $request->post('id')],
                    "table" => "_claim_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-company':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["trav_company_id", $request->post('id')],
                    "table" => "_travel_company",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-class':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["trav_class_id", $request->post('id')],
                    "table" => "_travel_class",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'travel-status':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["trav_sta_id", $request->post('id')],
                    "table" => "_travel_status",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'fix-allowance-type':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["fix_allow_type_id", $request->post('id')],
                    "table" => "_fix_allowance_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'fix-allowance-master':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["fix_allow_master_id", $request->post('id')],
                    "table" => "_fix_allowance_master",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-city':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["cont_city_id", $request->post('id')],
                    "table" => "_contract_city",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'deduction-type':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["dt_id", $request->post('id')],
                    "table" => "_deduction_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'document-type':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["doc_type_id", $request->post('id')],
                    "table" => "_document_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-ref-type':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["cus_ref_typ_id", $request->post('id')],
                    "table" => "_contract_cus_ref_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'purchase-order-type':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["pur_ord_typ_id", $request->post('id')],
                    "table" => "_contract_pur_order_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-accept-type-1':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["cus_accept_typ_1_id", $request->post('id')],
                    "table" => "_contract_cus_accept_type_1",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'contract-cus-accept-type-2':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["cus_accept_typ_2_id", $request->post('id')],
                    "table" => "_contract_cus_accept_type_2",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'asset':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ass_id", $request->post('id')],
                    "table" => "asset",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'brand':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ass_brand_id", $request->post('id')],
                    "table" => "asset_brand",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'vendor':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ass_vendor_id", $request->post('id')],
                    "table" => "asset_vendor",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'type':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ass_type_id", $request->post('id')],
                    "table" => "asset_type",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'processor':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ass_processor_id", $request->post('id')],
                    "table" => "asset_processor",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'hdd':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ass_hdd_id", $request->post('id')],
                    "table" => "asset_hdd",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            case 'ram':
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["ass_ram_id", $request->post('id')],
                    "table" => "asset_ram",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
                break;
            default;
                $param = [
                    "id_hris" => session('id_hris'),
                    "token" => session('token'),
                    "id" => $request->post('id'),
                    "where" => ["br_id", $request->post('id')],
                    "table" => "_mbranch",
                ];
                $response = json_decode(ElaHelper::myCurl($urlMenu, $param));
        }

        $data['response_code'] = $response->response_code;
        $data['message'] = $response->message;
        echo json_encode($data);
    }

    public function userAccess(Request $request)
    {

        $data['title'] = 'User Access HRIS';
        $data['subtitle'] = 'List Menu HRIS';

        $param = [
            "token" => session('token'),
            "id" => $request->get('id'),
        ];
        $data['user'] = json_decode(ElaHelper::myCurl('hris/get-profile-with-division', $param));

        $param = [
            "order" => ["div_id", "DESC"],
            "fields" => ["div_name"],
            "where" => ["div_id", $request->get('id')],
            "table" => "_mdivision",
        ];
        $raw = json_decode(ElaHelper::myCurl('master-global', $param));

        $data['id'] = $request->get('id');
        $data['nama'] = $raw->result[0]->div_name;
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
        ];
        $data['menu'] = json_decode(ElaHelper::myCurl('hris/get-menu', $param));
        return view('HRIS.master.settingHRIS.master-division.access', $data);
    }

    public function doAccess(Request $request)
    {
        $user_id = $request->post('user_id');
        $count = $request->post('count');

        $menu = [];

        for ($i = 1; $i <= $count; $i++) {
            $menu[] = [
                "menu_id" => $request->post('menu_id' . $i),
                "menu_acc_view" => $request->post('menu_acc_view' . $i),
                "menu_acc_add" => $request->post('menu_acc_add' . $i),
                "menu_acc_edit" => $request->post('menu_acc_edit' . $i),
                "menu_acc_del" => $request->post('menu_acc_del' . $i),
                "menu_acc_approve" => $request->post('menu_acc_approve' . $i),
            ];
        }
        $urlMenu = 'hris/hris-user/do-user-access';
        $param = [
            "id_hris" => session('id_hris'),
            "token" => session('token'),
            "user_access" => $user_id,
            "email" => $request->post('email'),
            "nama" => $request->post('nama'),
            "menu" => $menu,
        ];

        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $data['response_code'] = $rows->response_code;
        $data['message'] = $rows->message;
        echo json_encode($data);
    }

}
