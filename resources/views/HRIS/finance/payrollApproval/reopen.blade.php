
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
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="portlet-body form">
                        <div class="col-md-12 ">
                            <div class="form-body">
                                <div class="form-group validate">
                                    <label class="col-md-3 control-label">Request Code :</label>
                                    <div class="col-md-9">
                                    {{$request->result->app_code}}
                                    </div>
                                </div>
                                <div class="form-group validate">
                                    <label class="col-md-3 control-label">Title :</label>
                                    <div class="col-md-9">
                                    {{$request->result->app_name}}
                                    </div>
                                </div>
                                <div class="form-group validate">
                                    <label class="col-md-3 control-label">File Request :</label>
                                    <div class="col-md-9">
                                    @php
                                    $file2 ='';
                                    $file = explode(';',$request->result->file);
                                        for($a = 0; $a < count($file); $a++){
                                            $file2 .= '<a href="'.URL::asset(env('APP_URL').'/hris/files/payroll/'). $request->result->file.'"><i class="fa fa-file fa-2x"></i></a>&nbsp;';
                                        }

                                    echo  $file2;
                                    @endphp
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Upload Bank Slip <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        <div id="errorfile"></div>
                                        <div id="div_file">
                                            <div class="row">
                                                <div class="col-md-12 validate">
                                                    <input type="file" name="file1" id="file1" autocomplete="off" class="form-control">
                                                </div>
                                                <div class="col-md-12" id="actionfile_1" style="margin-top:10px;">
                                                    <a id="add_1" dataid="1" class="btn btn-primary" onclick="addFunctionfile(this);">
                                                        <font style="color:white">Add New</font>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group validate">
                                    <label class="col-md-3 control-label">Remark <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        <textarea name="remark" class="form-control"></textarea>
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
        <input type="hidden" id="count_file" name="count_file" value="1">
        <input type="hidden" name="link" value="{{$link}}">
        <input type="hidden" name="app_id" value="{{$request->result->app_id}}">
        <input type="hidden" name="app_no" value="{{$request->result->app_no}}">
        <input type="hidden" name="app_code" value="{{$request->result->app_code}}">
        <input type="hidden" name="cus_id" value="{{$request->result->cus_id}}">
        <input type="hidden" name="period" value="{{$request->result->period}}">
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

<script type="text/javascript">
        $(document).ready(function () {
            $('#formInput').validate({
                rules: {
                    remark: {
                        required: true
                    },
                    customer: {
                        required: true
                    },
                    file1: {
                        required: true,
                    },
                    file2: {
                        required: true,
                    },
                    file3: {
                        required: true,
                    },
                    file4: {
                        required: true,
                    },
                    file5: {
                        required: true,
                    },
                    file6: {
                        required: true,
                    },
                },
                highlight: function (element) {
                    $(element).closest('.validate').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.validate').removeClass('has-error').addClass('has-success');
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
        $(document).on("submit", "#formInput", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInput')[0];
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
                url: "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/doreopen') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                        swal({title: "Input Successfully", type: "success"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval?link=need-approve') }}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                    } else {
                        swal({title: "Failed", text:data.message, type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval?link=need-approve') }}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
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

        function get_data(val) {
        if (val == 'next_user') {
            var customer = document.getElementById("customer").value;
            var type = document.getElementById("type").value;
            if (type != '' && customer != '') {
                $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/getapprover') }}",
                        {
                            customer: customer,
                            type: type
                        },
                        function (data) {
                            $("#getApprover").html(data);
                        });
            } else {
                $("#getApprover").html('');
            }

        }
        if (val == 'currency') {
            var currency = document.getElementById("currency").value;
            if (currency != '') {
                if (currency == 'IDR') {
                    $("#amountType").html('<div class="input-group validate">\n\
                    <span class="input-group-addon">' + currency + '</span>\n\
                    <input type="text" class="form-control" placeholder="Input Amount" name="amount" >\n\
                    <span class="input-group-addon">.00</span>\n\
                </div>');
                } else {
                    $("#amountType").html('<div class="input-group validate">\n\
                    <span class="input-group-addon">' + currency + '</span>\n\
                    <input type="number" class="form-control" placeholder="Input Amount" name="amount"  maxlength="255" data-validation="required" data-validation-error-msg="Data \'Amount\' is required.">\n\
                </div>');
                }

            } else {
                $("#amountType").html('');
            }

        }
    }



    function addFunctionfile(e) {
        dataid = $(e).attr('dataid');
        file = $('#file' + dataid).val();
        amount = $('#amount' + dataid).val();


        if (file == '') {
            var msg = '<div class="alert alert-danger alert-dismissable">Fields can not be empty</div>';
            $("#errorfile").html(msg);
            $('#errorfile').alert();
            $('#errorfile').fadeTo(2000, 500).slideUp(500, function () {
                $('#errorfile').hide();

            });
        } else {
            newdataid = parseInt(dataid) + 1;
            $('#actionfile_' + dataid).hide();

            htm = '<div class="row" id="rowfile' + newdataid + '" style="margin-top:10px">'+
                        '<div class="col-md-12 validate">'+
                            '<input type="file" name="file' + newdataid + '" id="file' + newdataid + '" autocomplete="off" class="form-control">'+
                        '</div>'+
                        '<div class="col-md-12" id="actionfile_' + newdataid + '" style="margin-top:10px;">'+
                            '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctionfile(this);">'+
                                '<font style="color:white">Add New</font>'+
                            '</a>'+
                            '&nbsp;'+
                            '<a id="delete_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-danger" onclick="deleteFunctionfile(this);">' +
                                '<i class="fa fa-minus" style="color:white"></i>' +
                            '</a>' +
                        '</div>'+



                    '</div>';

            $('#div_file').append(htm);
            $('#count_file').val(newdataid);
        }

    }

    function deleteFunctionfile(e) {
        dataid = $(e).attr('dataid');
        $('#actionfile_' + dataid).remove();
        newdataid = parseInt(dataid) - 1;
        $('#rowfile' + dataid).remove();
        $('#actionfile_' + newdataid).show();
        $('#count_file').val(newdataid);
    }
</script>
