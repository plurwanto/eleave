<?php
namespace App\Http\Controllers\Eleave\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\ElaHelper;

class HolidayController extends Controller {

    public function index(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlBranch = 'eleave/room/getAllBranch';
        $param = [
            "token" => session('token'),
        ];
        $branch = ElaHelper::myCurl($urlBranch, $param);
        $branchData = json_decode($branch, true);
        //dd($branchData['data']);
        $list_branch = "";
        if ($branchData['response_code'] == 200) {
            $list_branch = json_decode(json_encode($branchData['data']), TRUE);
        } else {
            $list_branch = json_decode($branchData['message']);
        }

        $urlHoliday = 'eleave/holiday/getHolidayAllBranch';
        $holiday_id = ElaHelper::myCurl($urlHoliday, $param);
        $holidayList = json_decode($holiday_id, true);
        if ($holidayList['response_code'] == 200) {
            $holidayData = json_decode(json_encode($holidayList['data']), FALSE);
        } else {
            $holidayData = "";
        }

        return view('Eleave.master.hol_index', array('branch' => $list_branch, 'holiday' => $holidayData));
    }

    public function getHoliday(Request $request) {
        $urlHoliday = 'eleave/holiday/index';
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
            "search_name" => $request['columns'][1]['search']['value'],
            "search_branch" => $request['columns'][2]['search']['value'],
            "search_date" => $request['columns'][3]['search']['value'],
            "search_year" => $request['columns'][4]['search']['value'],
        ];

        $holiday = ElaHelper::myCurl($urlHoliday, $param);
        $holidayData = json_decode($holiday, true);
        //dd($holidayData);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($holidayData['response_code'] == 200) {
            $user_holiday = $holidayData['data'];
            $object = json_decode(json_encode($user_holiday), FALSE);

            foreach ($object as $row) {
                $no++;
                $aksi = "";

                $aksi .= '<a href="#" onclick="edit_item(' . $row->hol_id . ')" class="btn yellow btn-xs" title="Edit"><i class="fa fa-pencil"></i>';
                $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->hol_id . "'><i class='fa fa-trash'></i></a>";
                $year = date('Y', strtotime($row->hol_date));
                $hasil[] = array("no" => $no,
                    "hol_name" => $row->hol_name,
                    "branch_name" => $row->branch_name,
                    "hol_date_table" => date('d M Y', strtotime($row->hol_date)),
                    "year" => $year,
                    "action" => $aksi);
            }
        } else {
            $err = $holidayData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $holidayData['recordsTotal'],
            "recordsFiltered" => $holidayData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->post('holiday_id');
        $hol_name = $request->post('hol_name');
        $hol_date = $request->post('hol_date');
        $branch_id = $request->post('branch_id');

        $this->_validate($id, $branch_id, $hol_name, $hol_date);

        $urlHoliday = 'eleave/holiday/save';
        $param = [
            "token" => session('token'),
            "holiday_name" => $hol_name,
            "holiday_date" => $hol_date,
            "branch_id" => $branch_id,
        ];

        $holiday = ElaHelper::myCurl($urlHoliday, $param);
        $holidayData = json_decode($holiday, true);
        $ro = "";
        if ($holidayData['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $holidayData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => false, 'message' => $holidayData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlHoliday = 'eleave/holiday/getHolidayById';
        $param = [
            "token" => session('token'),
            "holiday_id" => $id,
        ];
        $holiday_id = ElaHelper::myCurl($urlHoliday, $param);
        $holidayData = json_decode($holiday_id, true);
        if ($holidayData['response_code'] == 200) {
            echo json_encode(array('status' => true, $holidayData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $holidayData['message']));
        }
    }

    public function update(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->post('holiday_id');
        $hol_name = $request->post('hol_name');
        $hol_date = $request->post('hol_date');
        $branch_id = $request->post('branch_id');

        $this->_validate($id, $branch_id, $hol_name, $hol_date);

        $urlHoliday = 'eleave/holiday/update';
        $param = [
            "token" => session('token'),
            "holiday_id" => $id,
            "holiday_name" => $hol_name,
            "holiday_date" => $hol_date,
            "branch_id" => $branch_id,
        ];

        $holiday = ElaHelper::myCurl($urlHoliday, $param);
        $holidayData = json_decode($holiday, true);
        $ro = "";
        if ($holidayData['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $holidayData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => false, 'message' => $holidayData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlHoliday = 'eleave/holiday/delete';
        $param = [
            "token" => session('token'),
            "holiday_id" => $id,
        ];

        $holiday_id = ElaHelper::myCurl($urlHoliday, $param);
        $holidayList = json_decode($holiday_id, true);
        $ro = "";
        if ($holidayList['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $holidayList['message']);
        } else {
            $ro = array('status' => false, 'message' => $holidayList['message']);
        }
        echo json_encode($ro);
    }

    private function _validate($id, $branch_id, $hol_name, $hol_date) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $urlHoliday = 'eleave/holiday/check_existing';
        $param = [
            "holiday_id" => $id,
            "holiday_name" => $hol_name,
            "holiday_date" => $hol_date,
            "branch_id" => $branch_id,
        ];
        $holiday = ElaHelper::myCurl($urlHoliday, $param);
        $holidayData = json_decode($holiday, true);

        if ($branch_id == '') {
            $data['inputerror'][] = 'branch_id';
            $data['error_string'][] = 'branch is required';
            $data['status'] = FALSE;
        }
        if ($hol_name == '') {
            $data['inputerror'][] = 'hol_name';
            $data['error_string'][] = 'holiday name is required';
            $data['status'] = FALSE;
        }
        if (trim(strlen($hol_name)) == 1) {
            $data['inputerror'][] = 'hol_name';
            $data['error_string'][] = 'dont leave it empty or at least input 2 characters.';
            $data['status'] = FALSE;
        }
        if ($hol_date == '') {
            $data['inputerror'][] = 'hol_date';
            $data['error_string'][] = 'holiday date is required';
            $data['status'] = FALSE;
        }
        if ($holidayData['response'] == FALSE) {
            $data['inputerror'][] = 'branch_id';
            $data['error_string'][] = 'There are already holiday with the same name and date.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

}
