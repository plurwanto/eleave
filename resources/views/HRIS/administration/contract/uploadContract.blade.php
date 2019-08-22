<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInputUpload"  class="form form-horizontal">

    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                          <div class="portlet-body form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">Customer <font color="red"></font></label>
                                        <div class="col-md-7">
                                            <select name="customer" class="search-input-select form-control input-sm select2">
                                                <option value="">-- Choose a Customer --</option>
                                                @for($i = 0; $i < count($customer); $i++)
                                                    @if($customer[$i]->cus_id == $link)
                                                    <option value="{{$customer[$i]->cus_id}}" selected>{{$customer[$i]->cus_name}}</option>
                                                    @else
                                                    <option value="{{$customer[$i]->cus_id}}">{{$customer[$i]->cus_name}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">File input <font color="red"></font></label>
                                        <div class="col-md-7">
                                            <input type="file" name="file" class="form-control">
                                            <br>
                                            @php
                                            echo '<p class="help-block"> Only xlsx Format</p>';
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
    <input name="id" id="id" type="hidden" class="form-control" value="{{$id}}">
    <input name="name" id="name" type="hidden" class="form-control" value="{{$name}}">
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
            $('#formInputUpload').validate({
                rules: {
                    file: {
                        required: true,
                        accept: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                    },
                    customer: {
                        required: true,
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
        $(document).on("submit", "#formInputUpload", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInputUpload')[0];
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
                url: "{{ URL::asset(env('APP_URL').'/hris/administration/contract/do-upload-contract') }}",
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
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract') }}?link="+data.customer;
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
                                                var link = "{{URL::asset(env('APP_URL').'/hris/administration/contract?link=log-error&id=')}}"+ data.wrong_id;
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
