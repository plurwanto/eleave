<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<style>
 .big-checkbox {width: 17px; height: 17px;}
</style>
<!-- END PAGE LEVEL PLUGINS --><div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInputAccess"  class="form form-horizontal">

    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="portlet-body form">
                        <div class="col-md-12">
                            <div class="form-body">
                            <table>
                            <tr>
                                <td><b>Name Division</b></td>
                                <td style="width:20px; text-align:center">:</td>
                                <td>{{$nama}}</td>
                            </tr>
                            <tr>
                                <td><b>User</b></td>
                                <td style="width:20px; text-align:center">:</td>
                                <td>
                                    <select name="user[]" id="multi-append" class="form-control select2" multiple>
                                        <option value="">-- Choose a User --</option>
                                        @php
                                        for($i = 0; $i < count($user->profile); $i++){
                                            echo '<option value="'. $user->profile[$i]->user_id .'" selected>'. $user->profile[$i]->nama .'</option>';
                                        }
                                        @endphp
                                    </select>
                                </td>
                            </tr>
                            </table>
                            <br>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> View </th>
                                        <th> Add </th>
                                        <th> Update </th>
                                        <th> Delete </th>
                                        <th> Approve </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                $str ='';
                                $xx =1;
                                for($a = 0; $a < count($menu->menu); $a++){

                                    if(count($menu->menu[$a]->sub_menu) > 0){

                                        $str .='<tr class="active">';
                                        $str .='<td><i class="fa fa-caret-down"></i> '.$menu->menu[$a]->menu_name.'</td>';
                                        $str .='<td colspan="5">
                                        <!-- <input type="checkbox" class="big-checkbox" value="1" name="checkall"> -->
                                        </td>';
                                        $str .='</tr>';
                                        for($b = 0; $b < count($menu->menu[$a]->sub_menu); $b++){

                                            if(count($menu->menu[$a]->sub_menu[$b]->sub_menu) > 0){

                                                $str .='<tr class="active">';
                                                $str .='<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i> '.$menu->menu[$a]->sub_menu[$b]->menu_name.'</td>';
                                                $str .='<td colspan="5">
                                                <!-- <input type="checkbox" class="big-checkbox" value="1" name="checkall"> -->
                                                </td>';
                                                $str .='</tr>';
                                                for($c = 0; $c < count($menu->menu[$a]->sub_menu[$b]->sub_menu); $c++){
                                                    $str .='<tr>';
                                                    $str .='<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>
                                                                '.$menu->menu[$a]->sub_menu[$b]->sub_menu[$c]->menu_name.'
                                                                <input type="hidden" name="menu_id'.$xx.'" value="'.$menu->menu[$a]->sub_menu[$b]->sub_menu[$c]->menu_id.'">
                                                            </td>';

                                                            $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_view'.$xx.'"></td>';
                                                            $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_add'.$xx.'"></td>';
                                                            $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_edit'.$xx.'"></td>';
                                                            $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_del'.$xx.'"></td>';
                                                            $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_approve'.$xx++.'"></td>';
                                                    $str .='</tr>';
                                                }

                                            }else{
                                                $str .='<tr>';
                                                $str .='<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>
                                                            '.$menu->menu[$a]->sub_menu[$b]->menu_name.'
                                                            <input type="hidden" name="menu_id'.$xx.'" value="'.$menu->menu[$a]->sub_menu[$b]->menu_id.'">
                                                        </td>';
                                                        $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_view'.$xx.'"></td>';
                                                        $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_add'.$xx.'"></td>';
                                                        $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_edit'.$xx.'"></td>';
                                                        $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_del'.$xx.'"></td>';
                                                        $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_approve'.$xx++.'"></td>';
                                                $str .='</tr>';
                                            }

                                        }
                                    }else{
                                        $str .='<tr>';
                                        $str .='<td><i class="fa fa-caret-right"></i>
                                                    '.$menu->menu[$a]->menu_name.'
                                                    <input type="hidden" name="menu_id'.$xx.'" value="'.$menu->menu[$a]->menu_id.'">
                                                </td>';
                                                $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_view'.$xx.'"></td>';
                                                $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_add'.$xx.'"></td>';
                                                $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_edit'.$xx.'"></td>';
                                                $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_del'.$xx.'"></td>';
                                                $str .='<td><input type="checkbox" class="big-checkbox" value="1" name="menu_acc_approve'.$xx++.'"></td>';
                                        $str .='</tr>';
                                    }

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
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
    <input type="hidden" value="{{$xx -1}}" name="count">
    <input type="text" value="{{$id}}" name="id">

        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="submit" class="btn green" id="btnSubmit">Save changes</button>
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
<script>
$(document).ready( function () {
    $('#table_id').DataTable( {
    "fixedHeader": true,
    "lengthMenu": [26, 40, 60, 80, 100],
    "pageLength": 3,
     "columnDefs": [
    { "orderable": false, "targets": 0 },
    { "orderable": false, "targets": 1 },
    { "orderable": false, "targets": 2 },
    { "orderable": false, "targets": 3 },
    { "orderable": false, "targets": 4 },
    { "orderable": false, "targets": 5 },
  ]
});
});
        $(document).ready(function () {
            $('#formInputAccess').validate({
                rules: {
                    username: {
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
        //submit Detail Contract
        $(document).on("submit", "#formInputAccess", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInputAccess')[0];
            // Create an FormData object
            var data = new FormData(form);
            // If you want to add an extra field for the FormData
            data.append("CustomField", "This is some extra data, testing");
            // disabled the submit button
            $("#btnSubmit").prop("disabled", true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
            $.ajax({
                type: "POST",
                async: true,
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'/hris/master/hris-user/doaccess') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                        $('#modalAction').modal('hide');
                                toastr . success('Action successfully');
                                setTimeout(function () {
                                    location . reload();
                                }, 1000);
                    } else {
                        $('#modalAction').modal('hide');
                        toastr.error("Failed", "Your action is failed :)",{timeOut: 2000});
                    }
                },
                error: function (e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
            event.stopImmediatePropagation();
            return false;
        });
</script>
