
<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
           <a target="blank" href="{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/print?id='.$request->result->app_id) }}" class="caption"><i class="fa fa-print fa2x"></i></a>
            &nbsp;
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table>
                                        <tr>
                                            <td style="width:100px" valign="top"><strong>Title</strong></td>
                                            <td style="width:10px" valign="top">:</td>
                                            <td>{{$request->result->app_name}}</td>
                                        </tr>
                                        <tr>
                                            <td  valign="top"><strong>Request By</strong></td>
                                            <td style="width:10px" valign="top">:</td>
                                            <td>{{$request->result->nama}}</td>
                                        </tr>
                                        <tr>
                                            <td  valign="top"><strong>Created Date</strong></td>
                                            <td style="width:10px" valign="top">:</td>
                                            <td>{{$request->result->created_at}}</td>
                                        </tr>
                                        <tr>
                                            <td  valign="top"><strong>Status</strong></td>
                                            <td style="width:10px" valign="top">:</td>
                                            <td> @php
                                                echo $request->result->status_label
                                                @endphp
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table>
                                        <tr>
                                            <td style="width:100px" valign="top"><strong>Customer</strong></td>
                                            <td style="width:10px" valign="top">:</td>
                                            <td>{{$request->result->cus_name}}</td>
                                        </tr>
                                        <tr>
                                            <td  valign="top"><strong>Amount</strong></td>
                                            <td style="width:10px" valign="top">:</td>
                                            <td>{{$request->result->amount2}}</td>
                                        </tr>
                                        <tr>
                                            <td  valign="top"><strong>Remark</strong></td>
                                            <td style="width:10px" valign="top">:</td>
                                            <td>{{$request->result->remark}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width:100px" valign="top"><strong>Document</strong></td>
                                            <td style="width:10px" valign="top">:</td>
                                            <td>
                                                @php
                                                $file2 ='';
                                                $file = explode(';',$request->result->file);
                                                    for($a = 0; $a < count($file); $a++){
                                                        $filename = base_path('public/hris/files/payroll/'. $request->result->file);
                                                        if (file_exists($filename)) {
                                                            $file2 .= '<a href="'.URL::asset(env('PUBLIC_PATH').'hris/files/payroll/'. $request->result->file).'"><i class="fa fa-file"></i></a>&nbsp;';
                                                        }else{
                                                            $file2 .= '<a href="https://elabram.com/hris/files/payroll/'. $request->result->file .'"><i class="fa fa-file"></i></a>&nbsp;';
                                                        }
                                                    }

                                                echo  $file2;
                                                @endphp

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12" style="margin-top:20px;border-top: 1px solid black;">
                                    <h3> Flow </h3>
                                    <div class="table-scrollable" style="padding: 13px;">
                                        <center>
                                        <table>
                                            @php

                                            for ($i = 0; $i < count($request->flow); $i++) {
                                                echo '<td style="width:100px" valign="top">
                                                    <center>';
                                                if ($request->flow[$i]->status == '1' & $request->flow[$i]->active == 'Y') {
                                                    echo'<i class="fa fa-user fa-3x primary"></i>';
                                                } else if ($request->flow[$i]->status == '2' & $request->flow[$i]->active == 'Y') {
                                                    echo'<i class="fa fa-user fa-3x success"></i>';
                                                } else if ($request->flow[$i]->status == '3' & $request->flow[$i]->active == 'Y') {
                                                    echo'<i class="fa fa-user fa-3x danger"></i>';
                                                } else {
                                                    echo'<i class="fa fa-user fa-3x"></i>';
                                                }

                                                echo'<br>
                                                        <b>' . $request->flow[$i]->status_label . '</b><br>
                                                        ' . $request->flow[$i]->name . '

                                                    </center>
                                                    </td>';
                                                if ($i < count($request->flow) - 1) {
                                                    echo ' <td style = "width:50px"><center><i class = "fa fa-arrow-right fa-1x"></i></center></td>';
                                                }
                                            }
                                            @endphp
                                        </table>
                                        </center>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3> History </h3>
                                    <div class="table-scrollable">
                                        <table class="table table-striped table-bordered table-advance table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <i class="fa fa-user"></i> Excuted By
                                                    </th>
                                                    <th class="hidden-xs">
                                                        <i class="fa fa-briefcase"></i> Division
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-file"></i> File
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-edit"></i> Remark
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-flag"></i> Status
                                                    </th>
                                                    <th>
                                                        <i class="fa fa-calendar"></i> Upadated at
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $str ='';
                                                for($i=0; $i < count($request->his); $i++){

                                                    switch ($request->his[$i]->status) {
                                                        case "1":
                                                            $flag ='primary';
                                                            break;
                                                        case "2":
                                                            $flag ='success';
                                                            break;
                                                        case "3":
                                                            $flag ='danger';
                                                            break;
                                                        case "3":
                                                            $flag ='warning';
                                                            break;
                                                        default:
                                                            $flag ='success';
                                                    }
                                                    $str .='<tr>';
                                                    $str .='<td class="highlight"><div class="'.$flag.'"></div>&nbsp;&nbsp;'.$request->his[$i]->nama.'</td>';
                                                    $str .='<td class="highlight">'.$request->his[$i]->div_name.'</td>';

                                                    $file2 = '';
                                                    $file = explode(';',$request->his[$i]->file);
                                                    if($file[0] !=''){
                                                        for($a = 0; $a < count($file); $a++){
                                                            $filename2 = base_path('public/hris/files/payroll/'. $file[$a]);
                                                            if (file_exists($filename2)) {
                                                                $file2 .= '<a href="'.URL::asset(env('PUBLIC_PATH').'hris/files/payroll/'. $file[$a]).'"><i class="fa fa-file"></i></a>&nbsp;';
                                                            }else{
                                                                $file2 .= '<a href="https://elabram.com/hris/files/payroll/'. $file[$a].'"><i class="fa fa-file"></i></a>&nbsp;';
                                                            }
                                                        }
                                                    }
                                                    $str .='<td class="highlight">'.$file2.'</td>';

                                                    if($request->his[$i]->reference !=''){
                                                        $reference ='<br>(INB :'. $request->his[$i]->reference .')';
                                                    }else{
                                                        $reference ='';
                                                    }
                                                    $str .='<td class="highlight">'. $request->his[$i]->remark . $reference .'</td>';
                                                    $str .='<td class="highlight">'.$request->his[$i]->status_label.'</td>';
                                                    $str .='<td class="highlight">'.$request->his[$i]->updated_at.'</td>';
                                                    $str .='</tr>';

                                                }
                                                echo $str;
                                                @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->

            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
    <input type="hidden" value="3" name="form_type" id="form_type" class="form-control" readonly>
       <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
    </div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'components-select2.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'form-validation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
