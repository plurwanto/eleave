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
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Master <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        <select name="master" class="form-control">
                                            <option value="">-- Choose a Master --</option>
                                            @for($i = 0; $i < count($fixAllowanceMaster->result); $i++)
                                            <option value="{{$fixAllowanceMaster->result[$i]->fix_allow_master_id}}">{{$fixAllowanceMaster->result[$i]->fix_allow_master_name}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" autocomplete="off" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Active <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        <div class="mt-radio-list">
                                            <label class="mt-radio mt-radio-outline">
                                                <input type="radio" name="active" id="optionsRadios22" value="Y" checked> Active
                                                <span></span>
                                            </label>
                                            <label class="mt-radio mt-radio-outline">
                                                <input type="radio" name="active" id="optionsRadios22" value="N"> No Active
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
    <input type="hidden" name="link" value="{{$link}}">
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
                    master: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    active: {
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
                url: "{{ URL::asset(env('APP_URL').'/hris/master/hris-setting/doadd') }}",
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
