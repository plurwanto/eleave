<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
use App\Http\Model\HRIS\Navigation;

Auth::routes();
/** BEGIN GLOBAL */
Route::get('/', 'HomeController@index');
Route::post('/login', '\App\Http\Controllers\Auth\LoginController@login');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/change-password', '\App\Http\Controllers\Auth\ResetPasswordController@changePassword');
Route::get('/forgot-password', '\App\Http\Controllers\Auth\ForgotPasswordController@forgotPassword');
Route::get('/reset-password/{token}', '\App\Http\Controllers\Auth\ResetPasswordController@resetPassword');
Route::get('/index', 'HomeController@portal');
Route::post('/create-session', 'HomeController@createSession');
/** END GLOBAL */

// use App\Http\Model\Navigation;

/* BEGIN HRIS*/
$router->group(['prefix' => 'hris'], function () use ($router) {
    Route::get('/dashboard', '\App\Http\Controllers\HRIS\DashboardController@index');
    Route::get('/dashboard/get-profile', 'HRIS\DashboardController@getProfile');
    Route::post('/dashboard/do-update-profile', 'HRIS\DashboardController@doUpdateProfile');

    Route::get('/master/hris-user', '\App\Http\Controllers\HRIS\userHRIS@index');
    Route::post('/master/hris-user/listdata', 'HRIS\userHRIS@listData');
    Route::post('/master/hris-user/listmenu', 'HRIS\userHRIS@listMenu');
    Route::get('/master/hris-user/add', 'HRIS\userHRIS@add');
    Route::post('/master/hris-user/doadd', 'HRIS\userHRIS@doAdd');
    Route::get('/master/hris-user/edit', 'HRIS\userHRIS@edit');
    Route::post('/master/hris-user/doedit', 'HRIS\userHRIS@doEdit');
    Route::get('/master/hris-user/detail', 'HRIS\userHRIS@detail');
    Route::get('/master/hris-user/do-delete', 'HRIS\userHRIS@doDelete');
    Route::get('/master/hris-user/check-exising', 'HRIS\userHRIS@checkExisting');
    Route::get('/master/hris-user/check-exising-edit', 'HRIS\userHRIS@checkExistingEdit');
    Route::get('/master/hris-user/useraccess', 'HRIS\userHRIS@userAccess');
    Route::post('/master/hris-user/doaccess', 'HRIS\userHRIS@doAccess');

    Route::get('/employee/others', '\App\Http\Controllers\HRIS\employee@index');
    Route::post('/employee/others/listdata', 'HRIS\employee@listData');
    Route::post('/employee/others/listdata-search', 'HRIS\employee@listDataSearch');
    Route::post('/employee/others/listdata-active', 'HRIS\employee@listDataActive');
    Route::post('/employee/others/listdata-no-active', 'HRIS\employee@listDataNoActive');
    Route::post('/employee/others/listdata-resign', 'HRIS\employee@listDataResign');
    Route::post('/employee/others/listdata-no-valid', 'HRIS\employee@listDataNoValid');
    Route::post('/employee/others/listdata-contract-end', 'HRIS\employee@listDataContractEnd');
    Route::post('/employee/others/listdata-passport-end', 'HRIS\employee@listDataPassportEnd');
    Route::post('/employee/others/listdata-recruitment', 'HRIS\employee@listDataRecruitment');

    Route::get('/employee/others/check-email-exising', 'HRIS\employee@checkEmailExisting');
    Route::get('/employee/others/check-email-exising-edit', 'HRIS\employee@checkEmailExistingEdit');
    Route::get('/employee/others/check-bank-exising', 'HRIS\employee@checkBankExisting');
    Route::get('/employee/others/check-bank-exising-edit', 'HRIS\employee@checkBankExistingEdit');

    Route::get('/employee/others/check-ktp', 'HRIS\employee@checkKtp');
    Route::get('/employee/others/check-ktp-edit', 'HRIS\employee@checkKtpEdit');
    Route::get('/employee/others/check-passport', 'HRIS\employee@checkPassport');
    Route::get('/employee/others/check-passport-edit', 'HRIS\employee@checkPassportEdit');

    Route::get('/employee/others/add', 'HRIS\employee@add');
    Route::post('/employee/others/doadd', 'HRIS\employee@doAdd');
    Route::get('/employee/others/edit', 'HRIS\employee@edit');
    Route::post('/employee/others/doedit', 'HRIS\employee@doEdit');
    Route::post('/employee/others/do-edit-type', 'HRIS\employee@doEditType');

    Route::get('/employee/others/check-swift', 'HRIS\employee@checkSwift');
    Route::get('/employee/others/check-swift-edit', 'HRIS\employee@checkSwiftEdit');

    Route::get('/employee/others/detail', 'HRIS\employee@detail');
    Route::get('/employee/others/do-delete', 'HRIS\employee@doDelete');
    Route::get('/employee/others/upload', 'HRIS\employee@upload');
    Route::get('/employee/others/export-excel-template', 'HRIS\employee@exportExcelExample');
    Route::post('/employee/others/do-upload', 'HRIS\employee@doUpload');
    Route::get('/employee/others/form-type', 'HRIS\employee@formType');
    Route::get('/employee/others/export-excel', 'HRIS\employee@exportExcel');
    Route::get('/employee/others/export-excel-endsoon', 'HRIS\employee@exportExcelEndSoon');
    Route::get('/employee/others/contract', 'HRIS\employee@addContract');

////////////

    Route::get('/employee/recruitment', '\App\Http\Controllers\HRIS\employeeRec@index');
    Route::post('/employee/recruitment/listdata', 'HRIS\employeeRec@listData');

    Route::get('/employee/recruitment/add', 'HRIS\employeeRec@add');
    Route::post('/employee/recruitment/doadd', 'HRIS\employeeRec@doAdd');
    Route::get('/employee/recruitment/edit', 'HRIS\employeeRec@edit');
    Route::post('/employee/recruitment/doedit', 'HRIS\employeeRec@doEdit');
    Route::post('/employee/recruitment/do-edit-type', 'HRIS\employeeRec@doEditType');
    Route::post('/employee/recruitment/do-reject', 'HRIS\employeeRec@doReject');
    Route::get('/employee/recruitment/do-hired', 'HRIS\employeeRec@doHired');

    Route::get('/employee/recruitment/detail', 'HRIS\employeeRec@detail');
    Route::get('/employee/recruitment/do-delete', 'HRIS\employeeRec@doDelete');
    Route::get('/employee/recruitment/upload', 'HRIS\employeeRec@upload');
    Route::get('/employee/recruitment/export-excel-template', 'HRIS\employeeRec@exportExcelExample');
    Route::post('/employee/recruitment/do-upload', 'HRIS\employeeRec@doUpload');
    Route::get('/employee/recruitment/form-type', 'HRIS\employeeRec@formType');
    Route::get('/employee/recruitment/export-excel', 'HRIS\employeeRec@exportExcel');
    Route::get('/employee/recruitment/contract', 'HRIS\employeeRec@addContract');
    Route::get('/employee/filter-export', 'HRIS\employee@filterExport');
    Route::get('/employee/recruitment/get-data', 'HRIS\employeeRec@getData');

    Route::get('/employee/recruitment/reject', 'HRIS\employeeRec@reject');

    Route::get('/master/hris-setting', '\App\Http\Controllers\HRIS\settingHRIS@index');
    Route::post('/master/hris-setting/listdata', 'HRIS\settingHRIS@listData');
    Route::post('/master/hris-setting/listmenu', 'HRIS\settingHRIS@listMenu');
    Route::get('/master/hris-setting/add', 'HRIS\settingHRIS@add');
    Route::post('/master/hris-setting/doadd', 'HRIS\settingHRIS@doAdd');
    Route::get('/master/hris-setting/edit', 'HRIS\settingHRIS@edit');
    Route::post('/master/hris-setting/doedit', 'HRIS\settingHRIS@doEdit');
    Route::get('/master/hris-setting/detail', 'HRIS\settingHRIS@detail');
    Route::get('/master/hris-setting/do-delete', 'HRIS\settingHRIS@doDelete');
    Route::get('/master/hris-setting/check-exising', 'HRIS\settingHRIS@checkExisting');
    Route::get('/master/hris-setting/check-exising-edit', 'HRIS\settingHRIS@checkExistingEdit');
    Route::get('/master/hris-setting/useraccess', 'HRIS\settingHRIS@userAccess');

    Route::get('/master/wms-user', '\App\Http\Controllers\HRIS\userWMS@index');
    Route::post('/master/wms-user/listdata', 'HRIS\userWMS@listData');
    Route::get('/master/wms-user/add', 'HRIS\userWMS@add');

    Route::get('/administration/contract', '\App\Http\Controllers\HRIS\contract@index');
    Route::post('/administration/contract/listdata', 'HRIS\contract@listData');
    Route::post('/administration/contract/listmenu', 'HRIS\contract@listMenu');
    Route::get('/administration/contract/add', 'HRIS\contract@add');
    Route::post('/administration/contract/doadd', 'HRIS\contract@doAdd');
    Route::get('/administration/contract/edit', 'HRIS\contract@edit');
    Route::post('/administration/contract/doedit', 'HRIS\contract@doEdit');
    Route::get('/administration/contract/extend', 'HRIS\contract@extend');
    Route::get('/administration/contract/extend-change', 'HRIS\contract@extendChange');
    Route::get('/administration/contract/extend-memo', 'HRIS\contract@extendMemo');

    Route::post('/administration/contract/doextend', 'HRIS\contract@doExtend');
    Route::post('/administration/contract/doextendMemo', 'HRIS\contract@doextendMemo');

    Route::get('/administration/contract/upload', 'HRIS\contract@upload');
    Route::get('/administration/contract/upload-contract', 'HRIS\contract@uploadContract');
    Route::get('/administration/contract/resign', 'HRIS\contract@resign');
    Route::post('/administration/contract/do-upload', 'HRIS\contract@doUpload');
    Route::post('/administration/contract/do-upload-contract', 'HRIS\contract@doUploadContract');
    Route::post('/administration/contract/do-resign', 'HRIS\contract@doResign');
    Route::post('/administration/contract/listdata-employee', 'HRIS\contract@listDataEmployee');
    Route::post('/administration/contract/doedit', 'HRIS\contract@doEdit');
    Route::get('/administration/contract/detail', 'HRIS\contract@detail');
    Route::get('/administration/contract/do-delete', 'HRIS\contract@doDelete');
    Route::get('/administration/contract/do-cancel', 'HRIS\contract@doCancel');
    Route::get('/administration/contract/pdf', 'HRIS\contract@pdf');
    Route::get('/administration/contract/filter-excel', 'HRIS\contract@filterExcel');
    Route::get('/administration/contract/do-excel', 'HRIS\contract@doExcel');
    Route::get('/administration/contract/template', 'HRIS\contract@template');
    Route::get('/administration/contract/rule', 'HRIS\contract@rule');
    Route::post('/administration/contract/listdata-history', 'HRIS\contract@listDataHistory');
    Route::get('/administration/contract/history-detail', 'HRIS\contract@historyDetail');
    Route::get('/administration/contract/get-employee', 'HRIS\contract@getEmployee');

    Route::get('customer', '\App\Http\Controllers\HRIS\customer@index');
    Route::post('customer/listdata', 'HRIS\customer@listData');
    Route::post('customer/listdata-not-approved', 'HRIS\customer@listDataNonApproved');
    Route::post('customer/listdata-approved', 'HRIS\customer@listDataApproved');
    Route::get('customer/add', 'HRIS\customer@add');
    Route::post('customer/doadd', 'HRIS\customer@doAdd');
    Route::get('customer/edit', 'HRIS\customer@edit');
    Route::post('customer/doedit', 'HRIS\customer@doEdit');
    Route::get('customer/detail', 'HRIS\customer@detail');
    Route::get('customer/do-delete', 'HRIS\customer@doDelete');
    Route::get('customer/do-approve', 'HRIS\customer@doApprove');
    Route::get('customer/export-excel', 'HRIS\customer@exportExcel');

    Route::get('/administration/letter-request', '\App\Http\Controllers\HRIS\letterRequest@index');
    Route::post('/administration/letter-request/listdata', 'HRIS\letterRequest@listData');
    Route::get('/administration/letter-request/add', 'HRIS\letterRequest@add');
    Route::post('/administration/letter-request/doadd', 'HRIS\letterRequest@doAdd');
    Route::get('/administration/letter-request/edit', 'HRIS\letterRequest@edit');
    Route::post('/administration/letter-request/doedit', 'HRIS\letterRequest@doEdit');
    Route::get('/administration/letter-request/detail', 'HRIS\letterRequest@detail');
    Route::get('/administration/letter-request/do-delete', 'HRIS\letterRequest@doDelete');

    Route::get('/administration/asset/item', '\App\Http\Controllers\HRIS\assetItem@index');
    Route::post('/administration/asset/item/listdata', 'HRIS\assetItem@listData');
    Route::get('/administration/asset/item/add', 'HRIS\assetItem@add');
    Route::post('/administration/asset/item/doadd', 'HRIS\assetItem@doAdd');
    Route::post('/administration/asset/item/doaddEmployee', 'HRIS\assetItem@doaddEmployee');
    Route::post('/administration/asset/item/doRemoveEmployee', 'HRIS\assetItem@doRemoveEmployee');

    Route::get('/administration/asset/item/edit', 'HRIS\assetItem@edit');
    Route::post('/administration/asset/item/doedit', 'HRIS\assetItem@doEdit');
    Route::get('/administration/asset/item/detail', 'HRIS\assetItem@detail');
    Route::get('/administration/asset/item/do-delete', 'HRIS\assetItem@doDelete');

    Route::get('/administration/asset/item/get-type', 'HRIS\assetItem@getType');
    Route::get('/administration/asset/item/get-brand', 'HRIS\assetItem@getBrand');
    Route::get('/administration/asset/item/get-asset', 'HRIS\assetItem@getAsset');

    Route::get('/administration/asset/item/do-excel-history', 'HRIS\assetItem@doExcelHistory');

    Route::get('/administration/asset/item/do-excel', 'HRIS\assetItem@doExcel');
    Route::get('/administration/asset/item/upload', 'HRIS\assetItem@upload');
    Route::post('/administration/asset/item/doupload', 'HRIS\assetItem@doUpload');

    Route::get('/administration/asset/item/upload-assign', 'HRIS\assetItem@uploadAssign');
    Route::post('/administration/asset/item/doupload-assign', 'HRIS\assetItem@doUploadAssign');

    Route::get('/administration/asset/item/add-employee', 'HRIS\assetItem@addEmployee');
    Route::get('/administration/asset/item/remove-employee', 'HRIS\assetItem@removeEmployee');
    Route::get('/administration/asset/item/get-employee', 'HRIS\assetItem@getEmployee');

    Route::get('/administration/asset/item/check-sevicetag-existing', 'HRIS\assetItem@checkSevicetagExisting');
    Route::get('/administration/asset/item/check-elabramtag-existing', 'HRIS\assetItem@checkElabramtagExisting');
    Route::get('/administration/asset/item/check-sevicetag-existing-edit', 'HRIS\assetItem@checkSevicetagExistingEdit');
    Route::get('/administration/asset/item/check-elabramtag-existing-edit', 'HRIS\assetItem@checkElabramtagExistingEdit');
    Route::get('/administration/asset/item/template-assign', 'HRIS\assetItem@templateAssign');

    Route::get('/administration/asset/resource', '\App\Http\Controllers\HRIS\assetResource@index');
    Route::post('/administration/asset/resource/listdata', 'HRIS\assetResource@listData');
    Route::get('/administration/asset/resource/add', 'HRIS\assetResource@add');
    Route::post('/administration/asset/resource/doadd', 'HRIS\assetResource@doAdd');
    Route::get('/administration/asset/resource/edit', 'HRIS\assetResource@edit');
    Route::post('/administration/asset/resource/doedit', 'HRIS\assetResource@doEdit');
    Route::get('/administration/asset/resource/detail', 'HRIS\assetResource@detail');
    Route::get('/administration/asset/resource/do-delete', 'HRIS\assetResource@doDelete');

    Route::get('/administration/asset/resource/get-type', 'HRIS\assetResource@getType');
    Route::get('/administration/asset/resource/get-brand', 'HRIS\assetResource@getBrand');
    Route::get('/administration/asset/resource/get-asset', 'HRIS\assetResource@getAsset');

    Route::get('/administration/asset/resource/do-excel', 'HRIS\assetResource@doExcel');
    Route::get('/administration/asset/resource/upload', 'HRIS\assetResource@upload');
    Route::post('/administration/asset/resource/doupload', 'HRIS\assetResource@doUpload');
    Route::get('/administration/asset/resource/pdf', 'HRIS\assetResource@pdf');

    Route::get('/finance/kam-revenue', 'HRIS\kamRevenue@index');
    Route::get('/finance/kam-revenue/add', 'HRIS\kamRevenue@add');
    Route::post('/finance/kam-revenue/doadd', 'HRIS\kamRevenue@doAdd');
    Route::get('/finance/kam-revenue/do-delete', 'HRIS\kamRevenue@doDelete');
    Route::get('/finance/kam-revenue/get-revenue', 'HRIS\kamRevenue@getRevenue');

    Route::get('/finance/payroll/approval', '\App\Http\Controllers\HRIS\payrollApproval@index');
    Route::post('/finance/payroll/approval/listdata', 'HRIS\payrollApproval@listData');
    Route::post('/finance/payroll/approval/listdataapprover', 'HRIS\payrollApproval@listDataApprover');
    Route::get('/finance/payroll/approval/add', 'HRIS\payrollApproval@add');
    Route::post('/finance/payroll/approval/doadd', 'HRIS\payrollApproval@doAdd');

    Route::get('/finance/payroll/approval/bankslip', 'HRIS\payrollApproval@bankslip');
    Route::post('/finance/payroll/approval/dobankslip', 'HRIS\payrollApproval@doBankslip');

    Route::get('/finance/payroll/approval/checker', 'HRIS\payrollApproval@checker');
    Route::post('/finance/payroll/approval/dochecker', 'HRIS\payrollApproval@doChecker');

    Route::get('/finance/payroll/approval/reopen', 'HRIS\payrollApproval@reopen');
    Route::post('/finance/payroll/approval/doreopen', 'HRIS\payrollApproval@doReopen');

    Route::get('/finance/payroll/approval/edit', 'HRIS\payrollApproval@edit');
    Route::post('/finance/payroll/approval/doedit', 'HRIS\payrollApproval@doEdit');
    Route::get('/finance/payroll/approval/detail', 'HRIS\payrollApproval@detail');
    Route::get('/finance/payroll/approval/do-delete', 'HRIS\payrollApproval@doDelete');
    Route::get('/finance/payroll/approval/do-approve', 'HRIS\payrollApproval@doApprove');
    Route::get('/finance/payroll/approval/reject', 'HRIS\payrollApproval@reject');
    Route::post('/finance/payroll/approval/do-reject', 'HRIS\payrollApproval@doReject');

    Route::get('/finance/payroll/approval/getapprover', 'HRIS\payrollApproval@getApprover');
    Route::get('/finance/payroll/approval/getapproveredit', 'HRIS\payrollApproval@getApproverEdit');

    Route::get('/finance/payroll/approval/validate-name-file', 'HRIS\payrollApproval@validateNameFile');
    Route::get('/finance/payroll/approval/print', 'HRIS\payrollApproval@print');

    Route::get('report/final', '\App\Http\Controllers\HRIS\reportFinal@index');
    Route::post('report/final/listdata', 'HRIS\reportFinal@listData');
    Route::get('report/final/filter', 'HRIS\reportFinal@filter');
    Route::get('report/final/filter/excel', 'HRIS\reportFinal@filterExcel');
    Route::get('report/final/filter/do-excel', 'HRIS\reportFinal@doExcel');
    Route::get('report/final/get-customer', 'HRIS\reportFinal@getCustomer');

    Route::get('report/activity', '\App\Http\Controllers\HRIS\reportActivity@index');
    Route::post('report/activity/listdata', 'HRIS\reportActivity@listData');
    Route::get('report/activity/filter', 'HRIS\reportActivity@filter');
    Route::get('report/activity/filter/excel', 'HRIS\reportActivity@filterExcel');
    Route::get('report/activity/filter/do-excel', 'HRIS\reportActivity@doExcel');

    Route::get('administration/travel', '\App\Http\Controllers\HRIS\travel@index');
    Route::post('administration/travel/listdata', 'HRIS\travel@listData');
    Route::get('administration/travel/filter', 'HRIS\travel@filter');
    Route::get('administration/travel/filter/excel', 'HRIS\travel@filterExcel');
    Route::get('administration/travel/filter/template', 'HRIS\travel@filterTemplate');

    Route::get('administration/travel/do-excel', 'HRIS\travel@doExcel');
    Route::get('administration/travel/do-template-excel', 'HRIS\travel@doTemplateExcel');
    Route::get('administration/travel/detail', 'HRIS\travel@detail');

    Route::get('/master/log', '\App\Http\Controllers\HRIS\log@index');
    Route::post('/master/log/listdata', 'HRIS\log@listData');
    Route::get('/master/log/detail', 'HRIS\log@detail');

    Route::get('administration/bpjs/kesehatan', '\App\Http\Controllers\HRIS\BPJSkesehatan@index');
    Route::post('administration/bpjs/kesehatan/listdata', 'HRIS\BPJSkesehatan@listData');
    Route::post('administration/bpjs/kesehatan/listdata-employee', 'HRIS\BPJSkesehatan@listDataEmployee');

    Route::get('administration/bpjs/kesehatan/filter', 'HRIS\BPJSkesehatan@filter');
    Route::get('administration/bpjs/kesehatan/filter/excel', 'HRIS\BPJSkesehatan@filterExcel');
    Route::get('administration/bpjs/kesehatan/filter/do-excel', 'HRIS\BPJSkesehatan@doExcel');

    Route::get('administration/bpjs/kesehatan/template-iuran', 'HRIS\BPJSkesehatan@templateIuran');
    Route::get('administration/bpjs/kesehatan/template-update', 'HRIS\BPJSkesehatan@templateUpdate');
    Route::get('administration/bpjs/kesehatan/upload', 'HRIS\BPJSkesehatan@upload');
    Route::get('administration/bpjs/kesehatan/upload-employee', 'HRIS\BPJSkesehatan@uploadEmployee');
    Route::get('administration/bpjs/kesehatan/detail', 'HRIS\BPJSkesehatan@detail');
    Route::post('administration/bpjs/kesehatan/do-upload', 'HRIS\BPJSkesehatan@doUpload');
    Route::post('administration/bpjs/kesehatan/do-upload-employee', 'HRIS\BPJSkesehatan@doUploadEmployee');

    Route::get('administration/bpjs/ketenagakerjaan', '\App\Http\Controllers\HRIS\BPJSketenagakerjaan@index');
    Route::post('administration/bpjs/ketenagakerjaan/listdata', 'HRIS\BPJSketenagakerjaan@listData');
    Route::post('administration/bpjs/ketenagakerjaan/listdata-employee', 'HRIS\BPJSketenagakerjaan@listDataEmployee');

    Route::get('administration/bpjs/ketenagakerjaan/filter', 'HRIS\BPJSketenagakerjaan@filter');
    Route::get('administration/bpjs/ketenagakerjaan/filter/excel', 'HRIS\BPJSketenagakerjaan@filterExcel');
    Route::get('administration/bpjs/ketenagakerjaan/filter/do-excel', 'HRIS\BPJSketenagakerjaan@doExcel');

    Route::get('administration/bpjs/ketenagakerjaan/template-iuran', 'HRIS\BPJSketenagakerjaan@templateIuran');
    Route::get('administration/bpjs/ketenagakerjaan/template-update', 'HRIS\BPJSketenagakerjaan@templateUpdate');
    Route::get('administration/bpjs/ketenagakerjaan/upload', 'HRIS\BPJSketenagakerjaan@upload');
    Route::get('administration/bpjs/ketenagakerjaan/upload-employee', 'HRIS\BPJSketenagakerjaan@uploadEmployee');
    Route::get('administration/bpjs/ketenagakerjaan/detail', 'HRIS\BPJSketenagakerjaan@detail');
    Route::post('administration/bpjs/ketenagakerjaan/do-upload', 'HRIS\BPJSketenagakerjaan@doUpload');
    Route::post('administration/bpjs/ketenagakerjaan/do-upload-employee', 'HRIS\BPJSketenagakerjaan@doUploadEmployee');

    View::composer('HRIS/navigation', function ($view) {
        if (Request::segment(3) != '') {
            $url_current = '/' . Request::segment(1) . '/' . Request::segment(2) . '/' . Request::segment(3);

        } else {
            $url_current = '/' . Request::segment(1) . '/' . Request::segment(2);
        }
        $userAccess = Navigation::getMenu($url_current);
        $view->with(compact('userAccess'));
    });
});
/* END HRIS*/

/* BEGIN ELEAVE */
$router->group(['prefix' => 'eleave'], function () use ($router) {
    Route::get('/', 'Eleave\HomeController@index');
    Route::post('home', 'Eleave\HomeController@home');
    Route::get('dashboard', 'Eleave\DashboardController@index');
    Route::get('department/index', 'Eleave\Master\DepartmentController@index');
    Route::post('department/getdata', 'Eleave\Master\DepartmentController@getDepartment');
    Route::post('department/insert', 'Eleave\Master\DepartmentController@save');
    Route::post('department/check_existing', 'Eleave\Master\DepartmentController@checkExisting');
    Route::get('department/{id}/edit', 'Eleave\Master\DepartmentController@edit');
    Route::post('department/update', 'Eleave\Master\DepartmentController@update');
    Route::post('department/delete', 'Eleave\Master\DepartmentController@destroy');

    Route::get('userlevel/index', 'Eleave\Setting\UserLevelController@index');
    Route::post('userlevel/getdata', 'Eleave\Setting\UserLevelController@getUserLevel');
    Route::get('userlevel/add', 'Eleave\Setting\UserLevelController@add');
    Route::post('userlevel/save', 'Eleave\Setting\UserLevelController@store');
    Route::get('/userlevel/{id}/edit', 'Eleave\Setting\UserLevelController@edit');
    Route::put('/userlevel/{id}/update', 'Eleave\Setting\UserLevelController@update');
    Route::delete('userlevel/delete', 'Eleave\Setting\UserLevelController@destroy');
    Route::get('/userlevel/{id}/show', 'Eleave\Setting\UserLevelController@show');
    Route::post('userlevelgroup/getdata', 'Eleave\Setting\UserLevelController@getUserLevelById');

    Route::get('/privilege/{id}/proses', 'Eleave\Setting\PrivilegeController@proses');
    Route::post('privilege/save', 'Eleave\Setting\PrivilegeController@store');

    Route::get('userlevel/show_approver', 'Eleave\Setting\UserLevelController@show_approver');
    Route::post('userlevelapprover/getdata', 'Eleave\Setting\UserLevelController@get_approver_detail');
    Route::get('/privilege/proses/{id}/{user_id}', 'Eleave\Setting\PrivilegeController@proses');
    Route::get('userlevel/show_apps', 'Eleave\Setting\UserLevelController@show_apps');
    Route::post('userlevelapps/getdata', 'Eleave\Setting\UserLevelController@get_apps_detail');
    Route::get('userlevelapps/{id}/edit', 'Eleave\Setting\UserLevelController@editApps');
    Route::post('userlevelapps/update', 'Eleave\Setting\UserLevelController@updateUserApps');

    //overtime
    Route::get('overtime/index', 'Eleave\TimeManagement\OvertimeController@index');
    Route::post('overtime/getdata', 'Eleave\TimeManagement\OvertimeController@getOvertime');
    Route::get('overtime/add', 'Eleave\TimeManagement\OvertimeController@add');
    Route::post('overtime/check_holiday', 'Eleave\TimeManagement\OvertimeController@getHoliday');
    Route::post('overtime/save', 'Eleave\TimeManagement\OvertimeController@save');
    Route::get('overtime/{id}/edit', 'Eleave\TimeManagement\OvertimeController@edit');
    Route::post('overtime/{id}/update', 'Eleave\TimeManagement\OvertimeController@update');
    Route::post('overtime/delete', 'Eleave\TimeManagement\OvertimeController@destroy');
    Route::post('overtime/check_existing', 'Eleave\TimeManagement\OvertimeController@checkExisting');
    Route::get('overtime/{userid}/notification', 'Eleave\TimeManagement\OvertimeController@index');
    Route::post('overtime/getdataNotif', 'Eleave\TimeManagement\OvertimeController@getOvertimeNotif');

    //overtime approval
    Route::get('overtimeApproval/index', 'Eleave\TimeManagement\OvertimeApprovalController@index');
    Route::post('overtimeApproval/getdata', 'Eleave\TimeManagement\OvertimeApprovalController@getOvertimeApproval');
    Route::post('overtimeApproval/revise', 'Eleave\TimeManagement\OvertimeApprovalController@revise');
    Route::post('overtimeApproval/reject', 'Eleave\TimeManagement\OvertimeApprovalController@reject');
    Route::post('overtimeApproval/approve', 'Eleave\TimeManagement\OvertimeApprovalController@approve');
    Route::get('overtimeApproval/{userid}/notification', 'Eleave\TimeManagement\OvertimeApprovalController@index');
    Route::post('overtimeApproval/getdataNotif', 'Eleave\TimeManagement\OvertimeApprovalController@getOvertimeApprovalNotif');

    //timesheet
    Route::get('timesheet/index', 'Eleave\TimeManagement\TimesheetController@index');
    Route::post('timesheet/getdata', 'Eleave\TimeManagement\TimesheetController@getTimesheet');
    Route::post('timesheet/getDetail', 'Eleave\TimeManagement\TimesheetController@get_data_detail');
    Route::get('timesheet/add', 'Eleave\TimeManagement\TimesheetController@add');
    Route::post('timesheet/insert', 'Eleave\TimeManagement\TimesheetController@save');
    Route::get('timesheet/{id}/edit', 'Eleave\TimeManagement\TimesheetController@edit');
    Route::get('/timesheet/{id}/draft', 'Eleave\TimeManagement\TimesheetController@edit');
    Route::post('timesheet/delete', 'Eleave\TimeManagement\TimesheetController@destroy');
    Route::post('timesheet/check_existing', 'Eleave\TimeManagement\TimesheetController@checkExisting');
    Route::get('timesheet/{userid}/notification', 'Eleave\TimeManagement\TimesheetController@index');
    Route::post('timesheet/getdataNotif', 'Eleave\TimeManagement\TimesheetController@getTimesheetNotif');

    //timesheet approval
    Route::get('timesheetApproval/index', 'Eleave\TimeManagement\TimesheetApprovalController@index');
    Route::post('timesheetApproval/getdata', 'Eleave\TimeManagement\TimesheetApprovalController@getTimesheetApproval');
    Route::post('timesheetApproval/getDetail', 'Eleave\TimeManagement\TimesheetController@get_data_detail');
    Route::post('timesheetApproval/revise', 'Eleave\TimeManagement\TimesheetApprovalController@revise');
    Route::post('timesheetApproval/reject', 'Eleave\TimeManagement\TimesheetApprovalController@reject');
    Route::post('timesheetApproval/approve', 'Eleave\TimeManagement\TimesheetApprovalController@approve');
    Route::get('timesheetApproval/{userid}/notification', 'Eleave\TimeManagement\TimesheetApprovalController@index');
    Route::post('timesheetApproval/getdataNotif', 'Eleave\TimeManagement\TimesheetApprovalController@getTimesheetApprovalNotif');

    //leave
    Route::get('leave/index', 'Eleave\TimeManagement\LeaveController@index');
    Route::post('leave/getdata', 'Eleave\TimeManagement\LeaveController@getLeave');
    Route::post('leave/getDetail', 'Eleave\TimeManagement\LeaveController@get_data_detail');
    Route::get('leave/check', 'Eleave\TimeManagement\LeaveController@check');
    Route::post('leave/add', 'Eleave\TimeManagement\LeaveController@add');
    Route::get('leave/invalid/{id?}', 'Eleave\TimeManagement\LeaveController@input_invalid');
    Route::post('leave/insert', 'Eleave\TimeManagement\LeaveController@save');
    Route::get('leave/{id}/edit', 'Eleave\TimeManagement\LeaveController@edit');
    Route::post('leave/delete', 'Eleave\TimeManagement\LeaveController@destroy');
    Route::post('leave/check_existing', 'Eleave\TimeManagement\LeaveController@checkExisting');
    Route::post('leave/check_existing_same_date', 'Eleave\TimeManagement\LeaveController@checkExistingSameDate');
    // Route::post('leave/check_existing_upload', 'Eleave\TimeManagement\LeaveController@checkExistingUpload');
    Route::get('leave/{id}/team_leave_show', 'Eleave\TimeManagement\LeaveController@team_leave_show');
    Route::post('leave/team_leave', 'Eleave\TimeManagement\LeaveController@team_leave');
    Route::post('leave/deleteHr', 'Eleave\TimeManagement\LeaveController@destroyHr');
    Route::get('leave/{userid}/notification', 'Eleave\TimeManagement\LeaveController@index');
    Route::post('leave/getdataNotif', 'Eleave\TimeManagement\LeaveController@getLeaveNotif');
    Route::get('leave/showTransLog', 'Eleave\TimeManagement\LeaveController@getTransLogById');

    //leave approval
    Route::get('leaveApproval/index', 'Eleave\TimeManagement\LeaveApprovalController@index');
    Route::post('leaveApproval/getdata', 'Eleave\TimeManagement\LeaveApprovalController@getLeaveApproval');
    Route::post('leaveApproval/getDetail', 'Eleave\TimeManagement\LeaveController@get_data_detail');
    Route::post('leaveApproval/revise', 'Eleave\TimeManagement\LeaveApprovalController@revise');
    Route::post('leaveApproval/reject', 'Eleave\TimeManagement\LeaveApprovalController@reject');
    Route::post('leaveApproval/approve', 'Eleave\TimeManagement\LeaveApprovalController@approve');
    Route::get('leaveApproval/{userid}/notification', 'Eleave\TimeManagement\LeaveApprovalController@index');
    Route::post('leaveApproval/getdataNotif', 'Eleave\TimeManagement\LeaveApprovalController@getLeaveApprovalNotif');

    //master
    Route::get('room/index', 'Eleave\Master\RoomController@index');
    Route::post('room/getdata', 'Eleave\Master\RoomController@getRoom');
    Route::post('room/insert', 'Eleave\Master\RoomController@save');
    Route::post('room/check_existing', 'Eleave\Master\RoomController@checkExisting');
    Route::get('room/{id}/edit', 'Eleave\Master\RoomController@edit');
    Route::post('room/update', 'Eleave\Master\RoomController@update');
    Route::post('room/delete', 'Eleave\Master\RoomController@destroy');

    Route::get('holiday/index', 'Eleave\Master\HolidayController@index');
    Route::post('holiday/getdata', 'Eleave\Master\HolidayController@getHoliday');
    Route::post('holiday/insert', 'Eleave\Master\HolidayController@save');
    Route::get('holiday/{id}/edit', 'Eleave\Master\HolidayController@edit');
    Route::post('holiday/update', 'Eleave\Master\HolidayController@update');
    Route::post('holiday/delete', 'Eleave\Master\HolidayController@destroy');

    Route::get('inventory_master/unit', 'Eleave\Master\InventoryMasterController@unit');
    Route::post('inventory_master/getUnit', 'Eleave\Master\InventoryMasterController@getInventoryUnit');
    Route::post('inventory_master/save_unit', 'Eleave\Master\InventoryMasterController@save_unit');
    Route::get('inventory_master/unit/{id}/edit', 'Eleave\Master\InventoryMasterController@edit_unit');
    Route::post('inventory_master/update_unit', 'Eleave\Master\InventoryMasterController@update_unit');
    Route::post('inventory_master/delete_unit', 'Eleave\Master\InventoryMasterController@destroy_unit');

    Route::get('inventory_master/supplier', 'Eleave\Master\InventoryMasterController@supplier');
    Route::post('inventory_master/getSupplier', 'Eleave\Master\InventoryMasterController@getInventorySupplier');
    Route::post('inventory_master/save_supplier', 'Eleave\Master\InventoryMasterController@save_supplier');
    Route::get('inventory_master/supplier/{id}/edit', 'Eleave\Master\InventoryMasterController@edit_supplier');
    Route::post('inventory_master/update_supplier', 'Eleave\Master\InventoryMasterController@update_supplier');
    Route::post('inventory_master/delete_supplier', 'Eleave\Master\InventoryMasterController@destroy_supplier');

    Route::get('inventory_master/item', 'Eleave\Master\InventoryMasterController@item');
    Route::post('inventory_master/getItem', 'Eleave\Master\InventoryMasterController@getInventoryItem');
    Route::post('inventory_master/save_item', 'Eleave\Master\InventoryMasterController@save_item');
    Route::get('inventory_master/item/{id}/edit', 'Eleave\Master\InventoryMasterController@edit_item');
    Route::post('inventory_master/update_item', 'Eleave\Master\InventoryMasterController@update_item');
    Route::post('inventory_master/delete_item', 'Eleave\Master\InventoryMasterController@destroy_item');
    Route::get('inventory_master/getUnitByName', 'Eleave\Master\InventoryMasterController@getUnitByName');
    Route::get('inventory_master/getSupplierByName', 'Eleave\Master\InventoryMasterController@getSupplierByName');

    Route::get('policy/index', 'Eleave\Master\PolicyController@index');
    Route::post('policy/getdata', 'Eleave\Master\PolicyController@getPolicy');
    Route::post('policy/insert', 'Eleave\Master\PolicyController@save');
    Route::get('policy/{id}/edit', 'Eleave\Master\PolicyController@edit');
    Route::post('policy/update', 'Eleave\Master\PolicyController@update');
    Route::post('policy/delete', 'Eleave\Master\PolicyController@destroy');

    //master
    Route::get('room-booking', 'Eleave\RoomBookingController@index');

    //user employee
    Route::get('user/index', 'Eleave\Employee\UserController@index');
    Route::post('user/getdata', 'Eleave\Employee\UserController@getEmployee');
    Route::get('user/add', 'Eleave\Employee\UserController@add');
    Route::post('user/insert', 'Eleave\Employee\UserController@save');
    Route::post('user/check_existing_nik', 'Eleave\Employee\UserController@checkExistingNik');
    Route::post('user/check_existing_mail', 'Eleave\Employee\UserController@checkExistingMail');
    Route::get('user/{id}/edit', 'Eleave\Employee\UserController@edit');
    //    Route::post('user/update', 'Eleave\Employee\UserController@update');
    Route::post('user/delete', 'Eleave\Employee\UserController@destroy');
    Route::get('user/export_excel', 'Eleave\Employee\UserController@excel')->name('user.export_excel');
    Route::get('user/team', 'Eleave\Employee\UserController@team');
    Route::post('user/getdatateam', 'Eleave\Employee\UserController@getTeam');
    Route::get('user/profile', 'Eleave\Employee\UserController@profile');
    Route::post('user/changeAvatar', 'Eleave\Employee\UserController@changeAvatar');
    Route::get('user/team_attendance', 'Eleave\Employee\UserController@team_attendance');
    Route::post('user/getTeamAttendance', 'Eleave\Employee\UserController@getTeamAttendance');
    Route::post('user/getTeamAttendanceDetail', 'Eleave\Employee\UserController@getTeamAttendanceDetail');

    // attendance
    Route::get('attendance/employee', 'Eleave\Attendance\AttendanceController@employee');
    Route::post('attendance/getAttendanceEmployee', 'Eleave\Attendance\AttendanceController@getAttendanceEmployee');
    Route::get('attendance', 'Eleave\Attendance\AttendanceController@index');
    Route::get('attendance/index/{year}', 'Eleave\Attendance\AttendanceController@index');
    Route::post('attendance/getAttendanceAllEmployee', 'Eleave\Attendance\AttendanceController@getAttendanceAllEmployee');
    Route::get('attendance/excel_attendance/{year}', 'Eleave\Attendance\AttendanceController@excel_attendance');
    Route::post('attendance/finger_upload', 'Eleave\Attendance\AttendanceController@upload_attendance');

    // Ticketing
    Route::get('ticketing', 'Eleave\TicketingController@index');
    Route::get('ticketing/report', 'Eleave\TicketingController@report');

    // Inventory Stationery
    Route::get('inventory/index', 'Eleave\Inventory\InventoryController@index');
    Route::post('inventory/get_data', 'Eleave\Inventory\InventoryController@getInventory');
    Route::post('inventory/get_filter_name', 'Eleave\Inventory\InventoryController@get_data');
    Route::get('inventory/{id}/view_detail', 'Eleave\Inventory\InventoryController@get_data_detail')->name('inventory/getDetail');
    Route::get('inventory/add', 'Eleave\Inventory\InventoryController@add');
    Route::post('inventory/insert', 'Eleave\Inventory\InventoryController@save');
    Route::get('inventory/{id}/edit', 'Eleave\Inventory\InventoryController@edit');
    Route::post('inventory/update', 'Eleave\Inventory\InventoryController@update');
    Route::post('inventory/ajax_status_request', 'Eleave\Inventory\InventoryController@ajax_status_request');
    Route::get('inventory/all_request', 'Eleave\Inventory\InventoryController@all_request');
    Route::post('inventory/get_all_data', 'Eleave\Inventory\InventoryController@getInventoryGa');
    Route::post('inventory/ga_update_request', 'Eleave\Inventory\InventoryController@ga_update_request');
    Route::get('inventory/all_processed', 'Eleave\Inventory\InventoryController@all_processed');
    Route::post('inventory/get_all_process', 'Eleave\Inventory\InventoryController@getInventoryGaProcess');
    Route::get('inventory_report/index', 'Eleave\Inventory\InventoryReportController@index');
    Route::get('inventory_report/show', 'Eleave\Inventory\InventoryReportController@show');
    Route::get('inventory_procurement/index', 'Eleave\Inventory\InventoryProcurementController@index');
    Route::post('inventory_procurement/get_data', 'Eleave\Inventory\InventoryProcurementController@getInventoryPro');
    Route::post('inventory_procurement/get_filter_name', 'Eleave\Inventory\InventoryProcurementController@get_data');
    Route::get('inventory_procurement/{id}/view_detail', 'Eleave\Inventory\InventoryProcurementController@get_data_detail');
    Route::get('inventory_procurement/add', 'Eleave\Inventory\InventoryProcurementController@add');
    Route::post('inventory_procurement/insert', 'Eleave\Inventory\InventoryProcurementController@save');
    Route::get('inventory_procurement/{id}/edit', 'Eleave\Inventory\InventoryProcurementController@edit');

    Route::get('policy/{policy}', 'Eleave\HomeController@getPolicy');

    // setting
    Route::get('setting/index', 'Eleave\Setting\SettingController@index');
    Route::post('setting/update', 'Eleave\Setting\SettingController@update');

    // expenses
    Route::get('cash_advance', 'Eleave\Expenses\CashAdvanceController@index');
    Route::post('cash_advance/getdata', 'Eleave\Expenses\CashAdvanceController@getCashAdvance');
    Route::post('cash_advance/getDetail', 'Eleave\Expenses\CashAdvanceController@get_data_detail');
    Route::get('cash_advance/add', 'Eleave\Expenses\CashAdvanceController@add');
    Route::post('cash_advance/insert', 'Eleave\Expenses\CashAdvanceController@save');
    Route::get('cash_advance/{id}/edit', 'Eleave\Expenses\CashAdvanceController@edit');
    Route::post('cash_advance/delete', 'Eleave\Expenses\CashAdvanceController@destroy');
    Route::post('cash_advance/check_existing', 'Eleave\Expenses\CashAdvanceController@checkExisting');
    Route::get('cash_advance/{userid}/notification', 'Eleave\Expenses\CashAdvanceController@index');
    Route::post('cash_advance/getdataNotif', 'Eleave\Expenses\CashAdvanceController@getCashAdvanceNotif');

    Route::post('cash_advance/getdataRealization', 'Eleave\Expenses\CashAdvanceController@getCashAdvanceReal');
    Route::get('cash_advance/{id}/edit_real', 'Eleave\Expenses\CashAdvanceController@edit_real');
    Route::post('cash_advance/update_real', 'Eleave\Expenses\CashAdvanceController@update_real');

    //expenses approval
    Route::get('cash_advanceApproval', 'Eleave\Expenses\CashAdvanceApprovalController@index');
    Route::post('cash_advanceApproval/getdata', 'Eleave\Expenses\CashAdvanceApprovalController@getCashAdvanceApproval');
    Route::post('cash_advanceApproval/getDetail', 'Eleave\Expenses\CashAdvanceApprovalController@get_data_detail');
    Route::post('cash_advanceApproval/revise', 'Eleave\Expenses\CashAdvanceApprovalController@revise');
    Route::post('cash_advanceApproval/reject', 'Eleave\Expenses\CashAdvanceApprovalController@reject');
    Route::post('cash_advanceApproval/approve', 'Eleave\Expenses\CashAdvanceApprovalController@approve');
    Route::get('cash_advanceApproval/{userid}/notification', 'Eleave\Expenses\CashAdvanceApprovalController@index');
    Route::post('cash_advanceApproval/getdataNotif', 'Eleave\Expenses\CashAdvanceApprovalController@getCashAdvanceApprovalNotif');

    Route::post('cash_advanceApproval/getdataRealization', 'Eleave\Expenses\CashAdvanceApprovalController@getCashAdvanceApprovalReal');

    Route::get('cash_advanceApproval/all_request', 'Eleave\Expenses\CashAdvanceApprovalController@all_request');
    Route::post('cash_advanceApproval/get_all_data', 'Eleave\Expenses\CashAdvanceApprovalController@getCaFinance');
    Route::post('cash_advanceApproval/fa_update_request', 'Eleave\Expenses\CashAdvanceApprovalController@process_finance');

    Route::get('cash_advanceApproval/realization', 'Eleave\Expenses\CashAdvanceApprovalController@all_realization');
    Route::post('cash_advanceApproval/get_all_data_real', 'Eleave\Expenses\CashAdvanceApprovalController@getCaFinanceReal');

    Route::get('staff-request/form', 'Eleave\Employee\UserController@requestForm');
    Route::post('staff-request/insert', 'Eleave\Employee\UserController@requestInsert');
    Route::post('staff-request/update', 'Eleave\Employee\UserController@requestUpdate');
    Route::get('claim/index', 'Eleave\Expenses\ClaimController@index');
    Route::post('claim/getdata', 'Eleave\Expenses\ClaimController@getClaim');
    Route::post('claim/getDetail', 'Eleave\Expenses\ClaimController@get_data_detail');
    Route::get('claim/add', 'Eleave\Expenses\ClaimController@add');
    Route::post('claim/insert', 'Eleave\Expenses\ClaimController@save');
    Route::get('claim/{id}/edit', 'Eleave\Expenses\ClaimController@edit');
    Route::get('claim/{id}/draft', 'Eleave\Expenses\ClaimController@edit');
    Route::post('claim/delete', 'Eleave\Expenses\ClaimController@destroy');
    Route::get('claim/{userid}/notification', 'Eleave\Expenses\ClaimController@index');
    Route::post('claim/getdataNotif', 'Eleave\Expenses\ClaimController@getClaimNotif');
    Route::post('claim/getLatestCurrency', 'Eleave\Expenses\ClaimController@getLatestCurrency');
    Route::post('claim/getConvertCurrency', 'Eleave\Expenses\ClaimController@getConvertCurrency');

    //claim approval
    Route::get('claimApproval/index', 'Eleave\Expenses\ClaimApprovalController@index');
    Route::post('claimApproval/getdata', 'Eleave\Expenses\ClaimApprovalController@getClaimApproval');
    Route::post('claimApproval/getDetail', 'Eleave\Expenses\ClaimApprovalController@get_data_detail');
    Route::post('claimApproval/revise', 'Eleave\Expenses\ClaimApprovalController@revise');
    Route::post('claimApproval/reject', 'Eleave\Expenses\ClaimApprovalController@reject');
    Route::post('claimApproval/approve', 'Eleave\Expenses\ClaimApprovalController@approve');
    Route::get('claimApproval/all_request', 'Eleave\Expenses\ClaimApprovalController@all_request');
    Route::post('claimApproval/get_all_data', 'Eleave\Expenses\ClaimApprovalController@getClFinance');
    Route::post('claimApproval/fa_update_request', 'Eleave\Expenses\ClaimApprovalController@process_finance');
    // View::composer('eleave\navigation', function ($view) {
    //     $menu = Navigation::where('parent_id', 0)->where('status', 1)->orderBy('order', 'ASC')->get();
    //     $view->with(compact('menu'));
    // });
});
/* END ELEAVE */
