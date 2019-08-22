<?php
namespace App\Http\Controllers\Eleave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\ElaHelper;

class RoomBookingController extends Controller
{
    public function index(Request $request)
    {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $urlRoom = 'eleave/room/get-all-room';
        $param = [
            "token"     => session('token'),
            "branch_id" => session('branch_id'),
        ];

        $room       = ElaHelper::myCurl($urlRoom, $param);
        $roomData   = json_decode($room, true);
        
        $list_room = [];

        if ($roomData['response_code'] == 200)
        {
            $list_room = json_decode(json_encode($roomData['data']), TRUE);
        }
        $urlUserBranch  = 'eleave/user/user-by-branch';
        $allUser        = ElaHelper::myCurl($urlUserBranch, $param);
        $AllUserByData  = json_decode($allUser, true);
        
        $allUserList = [];

        if ($AllUserByData['response_code'] == 200)
        {
            $allUserList = json_decode(json_encode($AllUserByData['data']), TRUE);
        }

        $param['req'] = 'by';

        $urlUser        = 'eleave/room-booking/get-all-request-user';
        $userReq       = ElaHelper::myCurl($urlUser, $param);
        $reqByData   = json_decode($userReq, true);
        
        $listReqBy = [];

        if ($reqByData['response_code'] == 200)
        {
            $listReqBy = json_decode(json_encode($reqByData['data']), TRUE);
        }

        $param['req'] = 'for';

        $userFor       = ElaHelper::myCurl($urlUser, $param);
        $reqForData  = json_decode($userFor, true);
        
        $listReqFor = [];

        if ($reqForData['response_code'] == 200)
        {
            $listReqFor = json_decode(json_encode($reqForData['data']), TRUE);
        }

        $params = [
                    'room'      => $list_room,
                    'reqBy'     => $listReqBy,
                    'reqFor'    => $listReqFor,
                    'allUser'   => $allUserList
        ];
        
        return view('Eleave.room_booking.index', $params);
    }
}
