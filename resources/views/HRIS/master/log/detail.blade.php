
<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInput"  class="form form-horizontal">

    <div class="modal-body">



    <div class="page-content-inner">
            <div class="row">
                <div class="portlet-body form">
                    <div class="col-md-10 col-md-offset-1">
                    @php
                    if($log_error){
                        if($log_error->result[0]->type =='update'){
                            $before = json_decode($log_error->result[0]->log_before);
                            $after = json_decode($log_error->result[0]->log_after);
                            $afterVal ='';

                            if($after){
                                foreach ($after as $field => $value) {
                                    $afterVal .= $value.'|';
                                }
                            }else{
                                foreach ($before as $field => $value) {
                                    $afterVal .= '-|';
                                }

                            }
                            $afterVal = explode('|',substr($afterVal,0,-1));



                            $str ='';
                            echo '<table class="table table-bordered table-hover" id="table">
                                    <thead  style="background-color: #CCCCCC;">
                                        <th>Field</th>
                                        <th>Data Before</th>
                                        <th>Data After</th>
                                    </thead>
                                    <tbody>';
                                    $e = 0;
                                    foreach ($before as $field => $value) {
                                        $str .= "<tr>";
                                        $str .= "<td>" . $field . "</td>";
                                        $str .= "<td>" . $value . "</td>";
                                        $str .= "<td>" . $afterVal[$e++] . "</td>";
                                        $str .= "</tr>";
                                    }
                                    echo $str;
                                echo'</tbody>
                                </table>';
                        }else{
                            $before = json_decode($log_error->result[0]->log_before);
                            $str ='';
                            echo '<table class="table table-bordered table-hover" id="table">
                                    <thead  style="background-color: #CCCCCC;">
                                        <th>Field</th>
                                        <th>Data</th>
                                    </thead>
                                    <tbody>';
                                    foreach ($before as $field => $value) {
                                        $str .= "<tr>";
                                        $str .= "<td>" . $field . "</td>";
                                        $str .= "<td>" . $value . "</td>";
                                        $str .= "</tr>";
                                    }
                                    echo $str;
                                echo'</tbody>
                                </table>';
                        }
                    }else{
                        echo 'No Data To Show';
                    }
                    @endphp

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
    </div>
</form>

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
