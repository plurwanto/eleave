<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInputProfile"  class="form form-horizontal">

    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                          <div class="portlet-body form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">Name <font color="red"></font></label>
                                        <div class="col-md-7">
                                        {{$profile->profile->nama}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">Branch <font color="red"></font></label>
                                        <div class="col-md-7">
                                        {{$profile->profile->br_name}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">Position <font color="red"></font></label>
                                        <div class="col-md-7">
                                        {{$profile->profile->div_name}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">New Password <font color="red"></font></label>
                                        <div class="col-md-7">
                                            <input type="password" name="newPassword" id="newPassword" autocomplete="off" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">Re Password <font color="red"></font></label>
                                        <div class="col-md-7">
                                            <input type="password" name="rePassword" id="rePassword" autocomplete="off" class="form-control">
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
    <input name="email" id="email" type="hidden" class="form-control" value="{{$profile->profile->email}}">
    <input name="id" id="id" type="hidden" class="form-control" value="{{$id}}">
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="submit" class="btn green" id="btnSubmit">Save changes</button>
    </div>
</form>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'form-validation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript">
        $(document).ready(function () {
            $('#formInputProfile').validate({
                rules: {
                    newPassword: {
                        required: true,
                        minlength: 5
                    },
                    rePassword: {
                        required: true,
                        minlength: 5,
                        equalTo: "#newPassword"
                    },
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
        $(document).on("submit", "#formInputProfile", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInputProfile')[0];
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
                url: "{{ URL::asset(env('APP_URL').'/hris/dashboard/do-update-profile') }}",
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
                                    location.reload();
                                }
                        );
                    } else {
                        swal({title: "Upload Failed", text: data.msg, type: "warning"},
                                            function () {
                                                location.reload();
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



    $(function() {
        $( "#date-picker" ).datepicker();
    });
</script>
