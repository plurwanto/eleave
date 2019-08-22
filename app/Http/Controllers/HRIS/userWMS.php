<?php

namespace App\Http\Controllers\HRIS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ElaHelper;

class userWMS extends Controller
{
    var $haha = 0;

    public function index()
    {
        $data['title'] = 'User WMS';
        $data['subtitle'] = 'List User WMS';

        return view('HRIS\master\userWMS.index', $data);
    }



    public function listData(Request $request) {

        $draw = $request->post('draw');
        $start = $request->post('start');
        $length = $request->post('length');

        $search = (isset($filter['value']))? $filter['value'] : false;

        $urlMenu = 'hris/hrisUser';

        if($request->post('start') == 0){
            $page =  1;  
        }else{
            $page = ($request->post('start') / $request->post('length')) + 1;
        }
        $sort_by =  $request->post('order')[0]['column'];
        $dir =  $request->post('order')[0]['dir'];
        $param = [
            "user_id" => session('id_hris'),
            "token" => session('token'),
            "page" => $page,
            "per_page" =>  $request->post('length'),
            "search" => $search,
            "sort_by" => $sort_by,
            "dir" => $dir,
            "search_name" => $request['columns'][0]['search']['value'],
            "search_email" => $request['columns'][1]['search']['value'],
            "search_branch" => $request['columns'][2]['search']['value'],
            "search_position" => $request['columns'][3]['search']['value'],
            "search_isactive" => $request['columns'][4]['search']['value'],
            "search_rec_pos" => $request['columns'][5]['search']['value']
        ];
        $rows = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $a = $start+1;
        $members = [];
        if($rows){
                for($i=0; $i< count($rows->data);$i++){
                    $user_active =  $rows->data[$i]->user_active =='Y' ? "<label class='btn btn-success btn-xs'>Active</label>":"<label class='btn btn-danger btn-xs'>No Active</label>";

                $nestedData['no'] = $a++;
                $nestedData['user_id'] = $rows->data[$i]->user_id;
                        $nestedData['nama'] = $rows->data[$i]->nama;
                        $nestedData['br_name'] = $rows->data[$i]->br_name;
                        $nestedData['active'] = $user_active;
                        $nestedData['div_name'] = $rows->data[$i]->div_name;
                        $nestedData['recruitment_position'] = $rows->data[$i]->recruitment_position;
                        $nestedData['email'] = $rows->data[$i]->email;
                        $nestedData['created_at'] =$rows->data[$i]->username;
                        $nestedData['updated_at'] =$rows->data[$i]->username; 
                        $nestedData['action'] = '<div class="btn-group">
                        <button class="btn dark btn-outline btn-circle btn-xs border-rounded" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                        <li>
                        <a href="javascript:;">
                            <i class="fa fa-search-plus"></i> Detail </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-pencil-square-o"></i> Edit </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-tag"></i> User Access </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-user"></i> Change Password </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                        $members[] = $nestedData;
                }

                $this->haha = $rows->paging->total;
                
                $data = array(
                    'draw' => $draw,
                    'recordsTotal' => $rows->paging->total,
                    'recordsFiltered' => $rows->paging->total,
                    'data' => $members,
                );

            }else{
                $data = array(
                    'draw' => $draw,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => $members,
                );
        }
        echo json_encode($data);
    }

    public function contentAdd()
    {
        $data['title'] = 'Add User WMS';
        $data['subtitle'] = 'List User WMS';   
  
        $urlMenu = 'master-global';
        $param = [
            "order" => ["br_name","ASC"],
            "fields" => ["br_id","br_name"],
            "table" => "_mbranch"
        ];
        $data['branch']  = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["div_name","ASC"],
            "fields" => ["div_id","div_name"],
            "table" => "_mdivision"
        ];
        $data['division']  = json_decode(ElaHelper::myCurl($urlMenu, $param));
        $param = [
            "order" => ["religi_name","ASC"],
            "fields" => ["religi_id","religi_name"],
            "table" => "_mreligion"
        ];
        $data['religion']  = json_decode(ElaHelper::myCurl($urlMenu, $param));

        return view('HRIS\master\userHRIS.add', $data);
    }
}
