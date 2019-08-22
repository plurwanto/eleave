
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
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">


        <div class="portlet-body" style="padding: 8px 15px;">
            <div class="row">
                <div class="col-md-12">
                    <div style="padding: 0px 30px;" class="col-md-6">
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Name</label>
                                <div>{{$employee->result->mem_name !=''? $employee->result->mem_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Customer</label>
                                <div>{{$employee->result->cus_name !=''? $employee->result->cus_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Travel Date</label>
                                <div>{{$employee->result->trav_date !=''? $employee->result->trav_date : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Travel Invoice</label>
                                <div>{{$employee->result->trav_inv !=''? $employee->result->trav_inv : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Departure Date</label>
                                <div>{{$employee->result->trav_det_departure_date !=''? $employee->result->trav_det_departure_date : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Departure Time</label>
                                <div>{{$employee->result->trav_det_departure_time !=''? $employee->result->trav_det_departure_time : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Company</label>
                                <div>{{$employee->result->trav_company_name !=''? $employee->result->trav_company_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Class</label>
                                <div>{{$employee->result->trav_class_name !=''? $employee->result->trav_class_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Status</label>
                                <div>{{$employee->result->trav_sta_name !=''? $employee->result->trav_sta_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Flight No</label>
                                <div>{{$employee->result->trav_det_flight_no !=''? $employee->result->trav_det_flight_no : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Description</label>
                                <div>{{$employee->result->trav_det_desc !=''? $employee->result->trav_det_desc : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Total</label>
                                <div>{{$employee->result->tot_values !=''? $employee->result->tot_values : 'none'}}</div>
                            </div>
                        </div>
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
    <input type="hidden" value="3" name="form_type" id="form_type" class="form-control" readonly>
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

<script type="text/javascript">
        $(document).ready(function () {
            $('#formInput').validate({
                rules: {
                    category : {
                        required: true
                    },
                    branch : {
                        required: true
                    },
                    kam: {
                        required: true
                    },
                    customer_name: {
                        required: true
                    },
                    date_paid: {
                        required: true
                    },
                    customer_code: {
                        required: true,
                        remote:"{{ URL::asset(env('APP_URL').'/hris/customer/check-email-exising') }}"
                    },
                    prorate: {
                        required: true,
                    },
                    monthly_based: {
                        required: true
                    },
                    prorate_factor: {
                        required: true,
                        number: true
                    },
                    name_bank1: {
                        required: true
                    },
                    marital: {
                        required: true
                    },
                    marital: {
                        required: true
                    },
                    passport: {
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/check-passport') }}"
                    },
                    passport_date: {
                        required: true
                    },
                    id_card: {
                        number: true,
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/check-ktp') }}"
                   },
                    file: {
                        accept: "image/jpeg, image/pjpeg"
                    },
                    religion: {
                        required: true
                    },
                    email: {
                        email: true
                    },
                    phone: {
                        number: true
                    },
                    postcode: {
                        number: true
                    },
                    contact_phone1: {
                        number: true
                    },
                },
                messages: {
                        email1: {
                                remote: "Email existing"
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
                async: true,
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'/hris/customer/doadd') }}",
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
