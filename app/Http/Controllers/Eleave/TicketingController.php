<?php
namespace App\Http\Controllers\Eleave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\ElaHelper;

class TicketingController extends Controller
{
    public function index(Request $request)
    {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        //S:Validate if session is admin or employee
        $is_admin = [540, 395, 569, 95];

        $roleTicketing = in_array(session('id_eleave'), $is_admin) ? 'admin' : 'employee';
        //E:Validate if session is admin or employee

        $param = [
            "token"     => session('token'),
            "branch_id" => session('branch_id'),
        ];

        //S:Get all application list
        $urlApp     = 'eleave/ticketing/app-list';
        $app        = ElaHelper::myCurl($urlApp, $param);
        $appResult  = json_decode($app, true);
        
        $allAppList = [];

        if ($appResult['response_code'] == 200)
        {
            $allAppList = $appResult['data'];
        }
        //E:Get all application list

        $urlEmployee        = 'eleave/ticketing/user-by-data';
        $param['user_id']   = session('id_eleave');

        if($roleTicketing == 'admin')
        {
            //S:Get open employee list by data
            $param['type']      = 'open';
            $param['req']       = 'employee';

            $getOpenEmployee    = ElaHelper::myCurl($urlEmployee, $param);
            $openEmployee       = json_decode($getOpenEmployee, true);
            
            $openEmployeeList = [];

            if ($openEmployee['response_code'] == 200)
            {
                $openEmployeeList = $openEmployee['data'];
            }
            //E:Get open employee list by data

            //S:Get close employee list by data
            $param['type']      = 'close';
            $param['req']       = 'employee';

            $getCloseEmployee    = ElaHelper::myCurl($urlEmployee, $param);
            $closeEmployee       = json_decode($getCloseEmployee, true);
            
            $closeEmployeeList = [];

            if ($closeEmployee['response_code'] == 200)
            {
                $closeEmployeeList = $closeEmployee['data'];
            }
            //E:Get close employee list by data

            //S:Get open assigned by list by data
            $param['type']      = 'open';
            $param['req']       = 'assBy';

            $getOpenAssBy    = ElaHelper::myCurl($urlEmployee, $param);
            $openAssBy       = json_decode($getOpenAssBy, true);
            
            $openAssByList = [];

            if ($openAssBy['response_code'] == 200)
            {
                $openAssByList = $openAssBy['data'];
            }
            //E:Get open assigned by list by data

            //S:Get close assigned by list by data
            $param['type']      = 'close';
            $param['req']       = 'assBy';

            $getCloseAssBy    = ElaHelper::myCurl($urlEmployee, $param);
            $closeAssBy       = json_decode($getCloseAssBy, true);
            
            $closeAssByList = [];

            if ($closeAssBy['response_code'] == 200)
            {
                $closeAssByList = $closeAssBy['data'];
            }
            //E:Get close assigned by list by data
        }

        //S:Get open assigned to list by data
        $param['type']      = 'open';
        $param['req']       = 'assTo';

        $getOpenAssTo    = ElaHelper::myCurl($urlEmployee, $param);
        $openAssTo       = json_decode($getOpenAssTo, true);
        
        $openAssToList = [];

        if ($openAssTo['response_code'] == 200)
        {
            $openAssToList = $openAssTo['data'];
        }
        //E:Get open assigned to list by data

        //S:Get close assigned to list by data
        $param['type']      = 'close';
        $param['req']       = 'assTo';

        $getCloseAssTo    = ElaHelper::myCurl($urlEmployee, $param);
        $closeAssTo       = json_decode($getCloseAssTo, true);
        
        $closeAssToList = [];

        if ($closeAssTo['response_code'] == 200)
        {
            $closeAssToList = $closeAssTo['data'];
        }
        //E:Get close assigned to list by data
        
        //S:Get all application list with status not close
        $param['type']      = 'open';

        $urlAppByData           = 'eleave/ticketing/app-by-data';
        $openAppByData          = ElaHelper::myCurl($urlAppByData, $param);
        $openAppResultByData    = json_decode($openAppByData, true);

        $allOpenAppByData = [];

        if ($openAppResultByData['response_code'] == 200)
        {
            $allOpenAppByData = $openAppResultByData['data'];
        }
        //E:Get all application list with status not close

        //S:Get all application list with status close
        $param['type'] = 'close';

        $closeAppByData         = ElaHelper::myCurl($urlAppByData, $param);
        $closeAppResultByData   = json_decode($closeAppByData, true);
        

        $allCloseAppByData = [];

        if ($closeAppResultByData['response_code'] == 200)
        {
            $allCloseAppByData = $closeAppResultByData['data'];
        }
        //E:Get all application list with status close
        
        //S:Get all priority list with status not close
        $param['type']      = 'open';

        $urlPriority           = 'eleave/ticketing/priority-by-data';
        $getOpenPriority          = ElaHelper::myCurl($urlPriority, $param);
        $openPriorityResult    = json_decode($getOpenPriority, true);

        $openPriority = [];

        if ($openPriorityResult['response_code'] == 200)
        {
            $openPriority = $openPriorityResult['data'];
        }
        //E:Get all priority list with status not close

        //S:Get all priority list with status close
        $param['type'] = 'close';

        $getclosePriority       = ElaHelper::myCurl($urlPriority, $param);
        $closePriorityResult    = json_decode($getclosePriority, true);
        

        $closePriority = [];

        if ($closePriorityResult['response_code'] == 200)
        {
            $closePriority = $closePriorityResult['data'];
        }
        //E:Get all priority list with status close
        
        //S:Get all status list with status not close
        $param['type']      = 'open';

        $urlStatus           = 'eleave/ticketing/status-by-data';
        $getOpenStatus          = ElaHelper::myCurl($urlStatus, $param);
        $openStatusResult    = json_decode($getOpenStatus, true);

        $openStatus = [];

        if ($openStatusResult['response_code'] == 200)
        {
            $openStatus = $openStatusResult['data'];
        }
        //E:Get all status list with status not close

        $data = [
                    'roleTicketing'     => $roleTicketing,
                    'appList'           => $allAppList,
                    'openAppList'       => $allOpenAppByData,
                    'closeAppList'      => $allCloseAppByData,
                    'openAssToList'     => $openAssToList,
                    'closeAssToList'    => $closeAssToList,
                    'openPriority'      => $openPriority,
                    'closePriority'     => $closePriority,
                    'openStatus'        => $openStatus
        ];

        if($roleTicketing == 'admin')
        {
            $data['openEmployeeList']   = $openEmployeeList;
            $data['closeEmployeeList']  = $closeEmployeeList;
            $data['openAssByList']      = $openAssByList;
            $data['closeAssByList']     = $closeAssByList;
        }
        
        return view('Eleave.ticketing.index', $data);
    }

    public function report(Request $request)
    {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        return view('Eleave.ticketing.report');
    }
}
