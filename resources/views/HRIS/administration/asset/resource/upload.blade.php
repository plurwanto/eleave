<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInputEdit"  class="form form-horizontal">
    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="portlet-body form">
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Upload File <font color="red">*</font></label>
                            <div class="col-md-9">
                                <input type="file" name="file" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
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
            $('#formInputEdit').validate({
                rules: {
                    file: {
                        required: true,
                        accept: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
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
        $(document).on("submit", "#formInputEdit", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInputEdit')[0];
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
                url: "{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/doupload') }}",
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
                                    location . reload();
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
                                                    var link = "{{URL::asset(env('APP_URL').'/hris/administration/asset/item?link=log-error&id=')}}"+ data.wrong_id;
                                                    link = link.replace(/&amp;/g, '&') ;
                                                    window.open(link,'_blank');
                                                    location.reload();
                                                    location.reload();
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
            event.stopImmediatePropagation();
            return false;
        });

        function formReq(){
            $member = $('#member').val();
            if($member !=''){
                $('#reqForm').show();
            }else{
                $('#reqForm').hide();
            }

        }

        function get_func(e)
            {
                var vendor = $('#vendor').val();
                var type_asset = $('#type_asset').val();
                var brand = $('#brand').val();
                var asset = $('#asset').val();
                var data = '';
                if(e == 'gettype'){
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/get-type') }}",
                        {
                            vendor: vendor,
                            type_asset: type_asset
                        },
                        function (data) {
                            $("#type_asset").html(data);
                        }
                    );
                }

                if(e == 'getBrand'){
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/get-brand') }}",
                        {
                            vendor: vendor,
                            type_asset: type_asset,
                            brand: brand
                        },
                        function (data) {
                            $("#brand").html(data);
                        }
                    );
                }

                if(e == 'getAsset'){
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/get-asset') }}",
                        {
                            vendor: vendor,
                            type_asset: type_asset,
                            brand: brand,
                            asset: asset
                        },
                        function (data) {
                            $("#asset").html(data);
                        }
                    );
                }



            }
</script>
