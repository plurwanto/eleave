<?php
namespace App\Http\Controllers\Eleave\Setting;

use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Controller;
use App\Http\Model\Eleave\User;
use App\Http\Model\Eleave\UserLevel;
use App\Http\Model\Eleave\Privilege;
use DB;

class PrivilegeController extends Controller {

    public function index(Request $request) {
        return view('Eleave.userlevel.index');
    }

    public function proses(Request $request) {
        $id = $request->id;
        $user_id = $request->user_id;

        if ($id == 3) {
            $userlevel = User::where('user_id', $user_id)->first();
            $user = $userlevel->user_name;
        } else {
            $userlevel = UserLevel::find($id);
            $user = $userlevel->userlevel_name;
        }

//        if (!$jabatan)
//            show_404();
        //if privilege already exist, its edit_box else add_box

        $box = $this->_add_box($id, $user_id);
        if (!empty($user_id)) {
            if (Privilege::check_privilege_approver($id, $user_id))
                $box = $this->_edit_box($id, $user_id);
        }else {
            if (Privilege::check_privilege($id))
                $box = $this->_edit_box($id, $user_id);
        }
        return view('Eleave.userlevel.privilege', ['id' => $id, 'tr' => $box, 'jabatan' => $user]);
    }

    private function _add_box($id, $user_id) {
        $modulex = new Privilege;
        if (!empty($user_id)) {
            $module = $modulex->modul_approval();
        } else {
            $module = $modulex->modul();
        }

        $arr_action = array('view', 'add', 'edit', 'remove');
        $tr = '';
        $i = 0;
        foreach ($module as $r) {
            $i++;
            if (isset($r['induk']) and $r['induk']) {

                $tr .= '<tr>';

                $tr .= '<td><b>' . $r['name'] . '</b></td>';
                $tr .= '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;
					            <input class="parent" data-name="chck-' . $r['name'] . '" id="View" value="1" type="checkbox" name="data[' . $r['const'] . '][view]"/>
				            <td colspan="4"></td>';

                $tr .= '</tr>';
            } else {

                $tr .= '<tr>';

                $tr .= '<td><b>' . $r['name'] . '</b></td>';
                foreach ($arr_action as $act) {

                    $tr .= '<td align="center">
					              <input id="' . ucwords($act) . '" value="1" type="checkbox" name="data[' . $r['const'] . '][' . $act . ']"/>
				                </td>';
                }
                $tr .= '</tr>';
            }

            if (isset($r['anak'])) {

                foreach ($r['anak'] as $k) {

                    $tr .= '<tr>';
                    $nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $tr .= '<td>' . $nbsp . $k['name'] . '</td>';
                    foreach ($arr_action as $act) {

                        $tr .= '<td align="center">
					                    <input class="child" data-name="chck-' . $r['name'] . '" id="' . ucwords($act) . '" value="1" type="checkbox" name="data[' . $k['const'] . '][' . $act . ']"/>
				                    </td>';
                    }

                    $tr .= '</tr>';
                }
            }
        }

        return $tr;
    }

    public function _edit_box($id, $user_id) {
        $modulex = new Privilege;
        if (!empty($user_id)) {
            $module = $modulex->modul_approval();
        } else {
            $module = $modulex->modul();
        }
        //   echo "<pre>";print_r($user_id);echo "</pre>";exit;
        $arr_action = array('view', 'add', 'edit', 'remove'); //, 'cetak');
        $tr = '';
        foreach ($module as $key => $r) {

            $role = Privilege::get_role($r['const'], $id, $user_id);
              //echo "<pre>";print_r($role[0]['view']);echo "</pre>";exit;
            if (isset($r['induk']) and $r['induk']) {

                $tr .= '<tr>';
   //echo "<pre>";print_r($role[$key]);echo "</pre>";exit;
                
                $tr .= '<td><b>' . $r['name'] . '</b></td>';
                $is_checked = ($role['view'] == 1) ? 'checked="checked"' : '';
                $tr .= '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;
					            <input class="parent" data-name="chck-' . $r['name'] . '" id="View" ' . $is_checked . ' value="1" type="checkbox" name="data[' . $r['const'] . '][view]"/>
				            <td colspan="4"></td>';

                $tr .= '</tr>';
            } else {

                $tr .= '<tr>';

                $tr .= '<td><b>' . $r['name'] . '</b></td>';
                foreach ($arr_action as $act) {

                    $is_checked2 = '';
                    if (isset($role[$act]) and $role[$act] == 1) {

                        $is_checked2 = 'checked="checked"';
                    }
                    $tr .= '<td align="center">
					                <input id="' . ucwords($act) . '" ' . $is_checked2 . ' value="1" type="checkbox" name="data[' . $r['const'] . '][' . $act . ']"/>
				                </td>';
                }
                $tr .= '</tr>';
            }
            if (isset($r['anak'])) {

                foreach ($r['anak'] as $k) {

                    $role2 = Privilege::get_role($k['const'], $id, $user_id);

                    $tr .= '<tr>';
                    $nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $tr .= '<td>' . $nbsp . $k['name'] . '</td>';
                    foreach ($arr_action as $act) {

                        $is_checked3 = '';
                        if (isset($role2[$act]) and $role2[$act] == 1) {

                            $is_checked3 = 'checked="checked"';
                        }
                        $tr .= '<td align="center">
					                    <input class="child" data-name="chck-' . $r['name'] . '" id="' . ucwords($act) . '" ' . $is_checked3 . ' value="1" type="checkbox" name="data[' . $k['const'] . '][' . $act . ']"/>
				                    </td>';
                    }

                    $tr .= '</tr>';
                }
            }
        }

        return $tr;
    }

    public function store(Request $request) {
        $id_level = $request->txtjabatan;
        $level = $request->level_id;
        // $data = $this->input->post(null, true);
        $data = $request->all();

        $privilege = new Privilege();

        if ($level == 3) {
            $privilege->simpan_approver($data);
            return redirect('eleave/userlevel/show_approver')
                            ->with('success', 'Privilege update successfully');
        } else {
            $privilege->simpan($data);
            return redirect('eleave/userlevel/index')
                            ->with('success', 'Privilege update successfully');
        }
    }

}
