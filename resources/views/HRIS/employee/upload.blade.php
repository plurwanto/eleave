
<div class="modal-header">
        @php
            if($link){
                echo '<a href="'. URL::asset(env('APP_URL').'hris/employee').'?link='. $link .'" type="button" class="close"></a>';
            }else{
                echo '<a href="'. URL::asset(env('APP_URL').'hris/employee') .'" type="button" class="close"></a>';
            }
        @endphp
    <h4 class="modal-title">{{$title}}</h4>
</div>
<form id="formInput"  class="form form-horizontal">

    <div class="modal-body"> 
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                          <div class="portlet-body form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">File input <font color="red"></font></label>
                                        <div class="col-md-7">
                                            <input type="file" name="file" class="form-control">
                                            <br>
                                            @php
                                            echo '<p class="help-block"> Only Excel Format</p>';
                                            @endphp
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
    <input type="hidden" value="3" name="form_type" id="form_type" class="form-control"> 
        @php
            if($link){
                echo '<a href="'. URL::asset(env('APP_URL').'hris/employee').'?link='. $link .'" type="button" class="btn dark btn-outline">Close</a>';
            }else{
                echo '<a href="'. URL::asset(env('APP_URL').'hris/employee') .'" type="button" class="btn dark btn-outline">Close</a>';
            }
        @endphp
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
                    file: {
                        required: true,
                        accept: "application/vnd.ms-excel"
                    },
                },
                messages: {
                        file: {
                            remote: "Please enter a value with Excel Format"
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
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'hris/employee/do-upload') }}",
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
                                    window.location = "{{ URL::asset(env('APP_URL').'hris/employee') }}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                    } else {
                        if (data.wrong_id != '') {
                                    swal({
                                        title: "Upload Failed",
                                        type: "warning",
                                        text: data.msg,
                                        showCancelButton: true,
                                        confirmButtonColor: '#DD6B55',
                                        confirmButtonText: 'View Error Log!',
                                        cancelButtonText: "No, cancel it!",
                                        closeOnConfirm: false,
                                        closeOnCancel: false
                                    },
                                            function (isConfirm) {

                                                if (isConfirm) {
                                                    var link = "{{URL::asset(env('APP_URL').'hris/employee?link=log-error&id=')}}"+ data.wrong_id;
                                                    link = link.replace(/&amp;/g, '&') ;
                                                    window.open(link,'_blank');
                                                } else {
                                                    location.reload();
                                                }
                                            });
                                } else {
                                    swal({title: "Upload Failed", text: data.msg, type: "warning"},
                                            function () {
                                                location.reload();
                                            }
                                    );
                                }
                    }
                },
                error: function (e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
        });

       
    
    $(function() {
        $( "#date-picker" ).datepicker();
    });
</script>
