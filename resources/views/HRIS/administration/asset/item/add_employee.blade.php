<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInputEmployee"  class="form form-horizontal">
    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="portlet-body form">
                    <div class="col-md-12 ">
                        <div id="employee_search">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Transfer Date <font color="red">*</font></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control date-picker" autocomplete="off" name="transfer_date" id="transfer_date" value="{{date('d-M-Y')}}"  data-date-format="dd-M-yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="employee_search">
                                <label class="col-md-4 control-label">NIP Employee <font color="red">*</font></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" autocomplete="off" name="employee" id="employee" placeholder="Search Employee Active With NIP">
                                        <span class="input-group-btn">
                                            <button class="btn blue" type="button" onclick="getEmployee()"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div id="employee_area">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
        <input type="hidden" class="form-control" autocomplete="off" name="id" id="id" value="{{$id}}">
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="submit" class="btn green" id="btnSubmit" disabled>Save changes</button>
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
            $('#formInputEmployee').validate({

                rules: {
                    transfer_date: {
                        required: true
                    },
                    employee: {
                        required: true
                    },
                    condition: {
                        required: true
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
        $(document).on("submit", "#formInputEmployee", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInputEmployee')[0];
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
                url: "{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/doaddEmployee') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                        $('#modalAction').modal('hide');
                        toastr.success('Add successfully');
                        setTimeout(function () {
                            location . reload();
                        }, 1000);
                    } else {
                        swal({title: "Failed", text:data.message, type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/asset/item') }}";
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

            $(function() {
                $( "#date-picker" ).datepicker();
            });

            function formatRupiah(e){
                var angka = e.value;
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                e.value = rupiah
            }

            function getEmployee() {
                var employee = $('#employee').val();
                $('#employee_area').html(`<center><h4><i class="fa fa-chevron-right-o-notch fa-spin fa-1x fa-fw"></i>
                <span>Loading...</span></h4></center>`);

                $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/get-employee') }}",
                        {
                            employee: employee
                        },
                        function (data) {
                            $("#employee_area").html(data);

                             if($('#mem_id').val() >0){
                                $("#btnSubmit").prop("disabled", false);
                            }else{
                                $("#btnSubmit").prop("disabled", true);
                            }
                        }
                );

            }

</script>
