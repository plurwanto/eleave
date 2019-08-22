<?php
namespace App\Http\Controllers\Eleave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Excel;

class ExportExcelController extends Controller {

    function index(Request $request) {
        $employee_data = DB::table('user')->get();
        return view('Eleave.export_excel')->with('user_data', $employee_data);
    }

    function excel() {
        $customer_data = DB::table('user')->get()->toArray();
        $customer_array[] = array('Customer Name', 'Address');
        foreach ($customer_data as $customer) {
            $customer_array[] = array(
                'Customer Name' => $customer->user_id,
                'Address' => $customer->user_name,
              
            );
        }
        Excel::create('Customer Data', function($excel) use ($customer_array) {
            $excel->setTitle('Customer Data');
            $excel->sheet('Customer Data', function($sheet) use ($customer_array) {
                $sheet->fromArray($customer_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

}

?>