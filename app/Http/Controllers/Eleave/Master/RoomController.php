<?php
namespace App\Http\Controllers\Eleave\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\ElaHelper;

class RoomController extends Controller {

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
        return view('Eleave.master.room_index', array('branch' => $list_branch));
    }

    public function getRoom(Request $request) {
        $urlRoom = 'eleave/room/index';
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
        ];

        $room = ElaHelper::myCurl($urlRoom, $param);
        $roomData = json_decode($room, true);
        //dd($roomData);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($roomData['response_code'] == 200) {
            $user_room = $roomData['data'];
            $object = json_decode(json_encode($user_room), FALSE);

            foreach ($object as $row) {
                $no++;
                $aksi = "";

                $aksi .= '<a href="#" onclick="edit_item(' . $row->room_id . ')" class="btn yellow btn-xs" title="Edit"><i class="fa fa-pencil"></i>';
                $aksi .= "<a class='btn red btn-xs reject' href='#' title='Delete' id='" . $row->room_id . "'><i class='fa fa-trash'></i></a>";

                $hasil[] = array("no" => $no,
                    "room_name" => $row->room_name,
                    "branch_name" => $row->branch_name,
                    "action" => $aksi);
            }
        } else {
            $err = $roomData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $roomData['recordsTotal'],
            "recordsFiltered" => $roomData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function save(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->post('room_id');
        $ro_name = $request->post('room_name');
        $branch_id = $request->post('branch_id');
        $branch_temp = $request->post('txt_branch');

        $this->_validate($id, $branch_id, $ro_name);

        $urlRoom = 'eleave/room/save';
        $param = [
            "token" => session('token'),
            "room_name" => $ro_name,
            "branch_id" => $branch_id,
        ];

        $room = ElaHelper::myCurl($urlRoom, $param);
        $roomData = json_decode($room, true);

        if ($roomData['response_code'] == 200) {
            $ro = array('status' => TRUE, 'message' => $roomData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => FALSE, 'message' => $roomData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function edit(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlRoom = 'eleave/room/getRoomById';
        $param = [
            "token" => session('token'),
            "room_id" => $id,
        ];
        $room_id = ElaHelper::myCurl($urlRoom, $param);
        $roomData = json_decode($room_id, true);
        if ($roomData['response_code'] == 200) {
            echo json_encode(array('status' => true, $roomData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $roomData['message']));
        }
    }

    public function update(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->post('room_id');
        $ro_name = trim($request->post('room_name'));
        $branch_id = $request->post('branch_id');

        $this->_validate($id, $branch_id, $ro_name);

        $urlRoom = 'eleave/room/update';
        $param = [
            "token" => session('token'),
            "room_id" => $id,
            "room_name" => $ro_name,
            "branch_id" => $branch_id,
        ];
//dd($param);
        $room = ElaHelper::myCurl($urlRoom, $param);
        $roomData = json_decode($room, true);
        $ro = "";
        if ($roomData['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $roomData['message'], 'alert-type' => 'success');
        } else {
            $ro = array('status' => false, 'message' => $roomData['message'], 'alert-type' => 'error');
        }
        echo json_encode($ro);
    }

    public function destroy(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->id;
        $urlRoom = 'eleave/room/delete';
        $param = [
            "token" => session('token'),
            "room_id" => $id,
        ];

        $room_id = ElaHelper::myCurl($urlRoom, $param);
        $roomList = json_decode($room_id, true);
        $ro = "";
        if ($roomList['response_code'] == 200) {
            $ro = array('status' => true, 'message' => $roomList['message']);
        } else {
            $ro = array('status' => false, 'message' => $roomList['message']);
        }
        echo json_encode($ro);
    }

    private function _validate($id, $branch_id, $ro_name) {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $urlRoom = 'eleave/room/check_existing';
        $param = [
            "room_id" => $id,
            "room_name" => $ro_name,
            "branch_id" => $branch_id,
        ];
        $room = ElaHelper::myCurl($urlRoom, $param);
        $roomData = json_decode($room, true);

        if ($branch_id == '') {
            $data['inputerror'][] = 'branch_id';
            $data['error_string'][] = 'branch is required';
            $data['status'] = FALSE;
        }
        if ($ro_name == '') {
            $data['inputerror'][] = 'room_name';
            $data['error_string'][] = 'room name is required';
            $data['status'] = FALSE;
        }
        if (trim(strlen($ro_name)) == 1) {
            $data['inputerror'][] = 'room_name';
            $data['error_string'][] = 'dont leave it empty or at least input 2 characters.';
            $data['status'] = FALSE;
        }

        if ($roomData['response'] == FALSE) {
            $data['inputerror'][] = 'room_name';
            $data['error_string'][] = 'There are already room with the same name.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
    
    
//    public function checkExisting(Request $request) {
//        $room_id = $request->post('ro_id');
//        $ro_name = $request->post('room_name');
//        $branch_id = $request->post('branch_id');
//        $branch_temp = $request->post('txt_branch');
//
//        $urlRoom = 'eleave/room/check_existing';
//        $param = [
//            "room_id" => $room_id,
//            "room_name" => $ro_name,
//            "branch_id" => $branch_id,
//            "branch_temp" => $branch_temp,
//        ];
//        $room = ElaHelper::myCurl($urlRoom, $param);
//        $roomData = json_decode($room, true);
//        $response = ($roomData['response'] == true ? $response = true : $response = false);
//        echo json_encode($response);
//    }


}
