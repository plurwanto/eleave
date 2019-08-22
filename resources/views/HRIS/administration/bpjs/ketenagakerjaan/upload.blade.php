<div class="modal-header">
        <button class="close" data-dismiss="modal"></button>
    <h4 class="modal-title">{{$title}}</h4>
</div>
<form id="formInput" action="{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/ketenagakerjaan') }}" method="get"  class="form form-horizontal">

    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body">
                            <div class="row">
                            <div class="form-group">
                                        <label class="col-md-3 control-label">File <font color="red">*</font></label>
                                        <div class="col-md-8">
                                            <input type='file' name='file' class='form-control'>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Date <font color="red">*</font></label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="month">
                                                @php
                                                $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                $month_num = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                                                for ($i = 0; $i < count($month); $i++) {
                                                    if ($month_num[$i] == $searchMonth) {
                                                        echo '<option value="' . $month_num[$i] . '" selected>' . $month[$i] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $month_num[$i] . '">' . $month[$i] . '</option>';
                                                    }
                                                }
                                                @endphp
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="number" name="year" value="{{$searchYear}}">
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
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="submit" class="btn green" id="btnSubmit">Upload</button>
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
                        accept: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                    },
                    month : {
                        required: true
                    },
                    year: {
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
                url: "{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/ketenagakerjaan/do-upload') }}",
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
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/ketenagakerjaan?month=') }}"+ data.month +"&year="+ data.year;
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
                                                var link = "{{URL::asset(env('APP_URL').'/hris/administration/bpjs/ketenagakerjaan?link=log-error&id=')}}"+ data.wrong_id;
                                                link = link.replace(/&amp;/g, '&') ;
                                                window.open(link,'_blank');
                                                location.reload();
                                                } else {
                                                location.reload();
                                            }
                                        });
                            } else {
                                swal({title: "Upload Failed", text: data.message, type: "warning"},
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
            event.stopImmediatePropagation();
            return false;
        });







    $(function() {
        $( "#date-picker" ).datepicker();
    });
</script>
