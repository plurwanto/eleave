<?php
namespace App\Http\Controllers\Eleave\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use App\Http\Model\Eleave\UserLevel;
use DB;
use App\ElaHelper;
use Illuminate\Support\Facades\Session;

class UserLevelController extends Controller {

    public function index(Request $request) {
        return view('Eleave.userlevel.index');
    }

    public function getUserLevel(Request $request) {
        // print_r($request->all());exit;
        $columns = array(
            0 => 'userlevel_name',
            1 => 'description',
            2 => 'action',
        );

        $totalData = UserLevel::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = UserLevel::offset($start)
                    ->where('id', '<>', 3)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            $totalFiltered = UserLevel::count();
        } else {
            $search = $request->input('search.value');
            $posts = UserLevel::where('userlevel_name', 'like', "%{$search}%")
                    ->where('id', '<>', 3)
                    ->orWhere('description', 'like', "%{$search}%")
                    //->orWhere('created_at', 'like', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            $totalFiltered = UserLevel::where('userlevel_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->count();
        }


        $data = array();
        $no = $_POST['start'];
        if ($posts) {
            foreach ($posts as $r) {
                $result_user = UserLevel::getTotalGroupUserLevel($r->id);
                if ($r->id != 1) {
                    if ($result_user > 0) {
                        $btn_act = '<a title="edit" href="' . url('eleave/userlevel/' . $r->id . '/edit') . '" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a> '
                                . '<a title="show" href="' . url('eleave/userlevel/' . $r->id . '/show') . '" class="btn btn-success btn-xs"><i class="fa fa-list"></i></a>'
                                . '<a title="Configure Privilege" href="' . url('eleave/privilege/' . $r->id . '/proses') . '" class="btn btn-info btn-xs"><i class="fa fa-key"></i></a>';
                    } else {
                        $btn_act = '<a title="edit" href="' . url('eleave/userlevel/' . $r->id . '/edit') . '" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a> '
                                . '<a href="#" title="delete" onclick="delete_list(' . $r->id . ');" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    }
                } else {
                    $btn_act = "";
                }

                $no++;
                $nestedData['no'] = $no;
                $nestedData['userlevel_name'] = $r->userlevel_name;
                $nestedData['description'] = $r->description;
                $nestedData['action'] = $btn_act;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function show($id) {
        $level_id = UserLevel::find($id);
        return view('Eleave.userlevel.show', ['userlevelId' => $level_id]);
    }

    public function getUserLevelById(Request $request) {
        $id = $request->id;
        //print_r($request->all());exit;
        $columns = array(
            0 => 'user_name',
            1 => 'user_position',
        );

        $totalData = UserLevel::getTotalGroupUserLevel($id);
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $posts = User::offset($start)
                ->select('user.user_name', 'user.user_position', 'userlevels.userlevel_name')
                ->leftJoin('userlevels', 'userlevels.id', '=', 'user.user_id')
                ->where('user.level_id', $id)
                ->limit($limit)
                ->orderBy($order, $dir);

        $totalFiltered = User::select('user.user_name', 'user.user_position', 'userlevels.userlevel_name')
                ->leftJoin('userlevels', 'userlevels.id', '=', 'user.user_id')
                ->where('user.level_id', $id);
        //->count();
//        if (!empty($request['columns'][0]['search']['value'])) {   
//            $posts->where('user.user_name', 'like', "%{$request['columns'][0]['search']['value']}%");
//            $totalFiltered->where('user.user_name', 'like', "%{$request['columns'][0]['search']['value']}%");
//        }
//        if (!empty($request['columns'][1]['search']['value'])) {  
//             $posts->where('user.user_position', 'like', "%{$request['columns'][1]['search']['value']}%");
//             $totalFiltered->where('user.user_position', 'like', "%{$request['columns'][1]['search']['value']}%");
//        }

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $posts->where('user.user_name', 'like', "%{$search}%")
                    ->orWhere('user.user_position', 'like', "%{$search}%");

            $totalFiltered->where('user.user_name', 'like', "%{$search}%")
                    ->orWhere('user.user_position', 'like', "%{$search}%");
        }

        $dataPosts = $posts->get();
        $dataRow = $totalFiltered->count();

        $data = array();
        $no = $_POST['start'];
        if ($dataPosts) {
            foreach ($dataPosts as $r) {

                $no++;
                $nestedData['no'] = $no;
                $nestedData['user_name'] = $r->user_name;
                $nestedData['user_position'] = $r->user_position;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($dataRow),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function add() {
        return view('Eleave.userlevel.new');
    }

    public function store(Request $request) {
        $userlevel = new UserLevel;
        $userlevel->userlevel_name = $request->txt_userlevel_name;
        $userlevel->description = $request->txt_description;
        $userlevel->save();

        return redirect('eleave/userlevel/index')
                        ->with('success', 'Userlevel insert successfully');
    }

    public function edit($id) {
        $userlevel = UserLevel::find($id);
        return view('Eleave.userlevel.edit', ['userlevellist' => $userlevel]);
    }

    public function update(Request $request, $id) {
        $userlevel = UserLevel::find($id);
        $userlevel->userlevel_name = $request->txt_userlevel_name;
        $userlevel->description = $request->txt_description;
        $userlevel->save();
        return redirect('eleave/userlevel/index')
                        ->with('success', 'Userlevel update successfully');
    }

    public function destroy(Request $request) {
        if (isset($request->id)) {
            $todo = UserLevel::findOrFail($request->id);
            $todo->delete();
            echo json_encode(array('status' => true));
        }
    }

    ///////////////////////////////////for approval ///////////////////////////
    public function show_approver() {

        return view('Eleave.userlevel.approver');
    }

    function get_approver_detail(Request $request) {
        $columns = array(
            0 => 'user_name',
            1 => 'user_position',
        );

        $totalData = User::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $posts = User::offset($start)
                ->select('user_id', 'user_name', 'user_position')
                ->where('user_status', 'Active')
                ->where('is_approver', 1)
                ->where('level_id', '<>', NULL)
                ->where('user_name', '<>', '0')
                ->limit($limit)
                ->orderBy($order, $dir);

        $totalFiltered = User::select('user_id', 'user_name', 'user_position')
                ->where('user_status', 'Active')
                ->where('is_approver', 1)
                ->where('level_id', '<>', NULL)
                ->where('user_name', '<>', '0');


        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $posts->where('user.user_name', 'like', "%{$search}%")
                    ->orWhere('user.user_position', 'like', "%{$search}%");
            $totalFiltered->where('user.user_name', 'like', "%{$search}%")
                    ->orWhere('user.user_position', 'like', "%{$search}%");
        }

        $dataPosts = $posts->get();
        $dataRow = $totalFiltered->count();

        $data = array();
        $no = $_POST['start'];
        if ($dataPosts) {
            foreach ($dataPosts as $r) {
                $btn_act = '<a title="Configure Privilege" href="' . url('eleave/privilege/proses/' . 3 . '/' . $r->user_id . '') . '" class="btn btn-info btn-xs"><i class="fa fa-key"></i></a>';
                $no++;
                $nestedData['no'] = $no;
                $nestedData['user_name'] = $r->user_name;
                $nestedData['user_position'] = $r->user_position;
                $nestedData['action'] = $btn_act;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($dataRow),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    ///////////////////////////////////for user apps ///////////////////////////
    public function show_apps() {

        return view('Eleave.userlevel.user_apps');
    }

    function get_apps_detail(Request $request) {
        $urlUser = 'eleave/user/userapps';
        $param = [
            "token" => session('token'),
            "start" => $request->post('start'),
            "length" => $request->post('length'),
            "sort_by" => $request->post('order')[0]['column'],
            "dir" => $request->post('order')[0]['dir'],
            "search" => $request->input('search.value'),
        ];

        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);
        //dd($userData);
        $err = "";
        $no = $request->post('start');
        $hasil = array();

        if ($userData['response_code'] == 200) {
            $user_user = $userData['data'];
            $object = json_decode(json_encode($user_user), FALSE);
         
            foreach ($object as $row) {
                $no++;
                $aksi = "";
                $aksi .= '<a href="#" onclick="edit_item(' . $row->user_id . ')" class="btn yellow btn-xs" title="Edit"><i class="fa fa-pencil"></i>';

                if ($row->is_app == "" || $row->is_app == "1") {
                    $is_app = "Eleave";
                } elseif ($row->is_app == "2") {
                    $is_app = "HRIS";
                } elseif ($row->is_app == "3") {
                    $is_app = "Dashboard";
                } elseif ($row->is_app == "1,2") {
                    $is_app = "Eleave - HRIS";
                } elseif ($row->is_app == "1,3") {
                    $is_app = "Eleave - Dashboard";
                } elseif ($row->is_app == "1,4") {
                    $is_app = "Eleave - E-Gemes";
                } elseif ($row->is_app == "2,3") {
                    $is_app = "HRIS - Dashboard";
                }elseif ($row->is_app == "2,4") {
                    $is_app = "HRIS - E-Gemes";
                } elseif ($row->is_app == "1,2,3") {
                    $is_app = "Eleave - HRIS - Dashboard";
                }elseif ($row->is_app == "1,2,4") {
                    $is_app = "Eleave - HRIS - E-Gemes";
                }elseif ($row->is_app == "1,3,4") {
                    $is_app = "Eleave - Dashboard - E-Gemes";
                }elseif ($row->is_app == "2,3,4") {
                    $is_app = "HRIS - Dashboard - E-Gemes";
                }elseif ($row->is_app == "1,2,3,4") {
                    $is_app = "Eleave - HRIS - Dashboard - E-Gemes";
                }

                $hasil[] = array("no" => $no,
                    "user_name" => $row->user_name,
                    "user_id" => $row->user_id,
                    "user_email" => $row->user_email,
                    "branch_name" => $row->branch_name,
                    "active" => $row->user_status,
                    "is_app" => $is_app,
                    "action" => $aksi);
            }
        } else {
            $err = $userData['message'];
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $userData['recordsTotal'],
            "recordsFiltered" => $userData['recordsFiltered'],
            "data" => $hasil,
            "error" => $err
        );
        echo json_encode($json_data);
    }

    public function editApps(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }

        $id = $request->id;
        $urlUser = 'eleave/user/getUserAppsId';
        $param = [
            "token" => session('token'),
            "user_id" => $id,
        ];
        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);

        if ($userData['response_code'] == 200) {
            echo json_encode(array('status' => true, $userData['data']));
        } else {
            echo json_encode(array('status' => false, 'msg' => $userData['message']));
        }
    }

    public function updateUserApps(Request $request) {
        if (!Session::has('token')) {
            return redirect('/login');
        }
        $id = $request->post('user_id');

        $urlUser = 'eleave/user/userappsUpdate';
        $param = [
            "token" => session('token'),
            "user_id" => $id,
            "user_name" => $request->post('txt_user_name'),
            "user_email" => $request->post('txt_user_email'),
            "is_app" => $request->post('chkApp'),
        ];
//dd($param);
        $user = ElaHelper::myCurl($urlUser, $param);
        $userData = json_decode($user, true);
        $dp = "";
        if ($userData['response_code'] == 200) {
            $dp = array('status' => true, 'message' => $userData['message'], 'alert-type' => 'success');
        } else {
            $dp = array('status' => false, 'message' => $userData['message'], 'alert-type' => 'error');
        }
        echo json_encode($dp);
    }

}
