
<div class="modal-header">
<button class="close" data-dismiss="modal"></button>
    <h4 class="modal-title">{{$title}}</h4>
</div>
<form id="formInputEdit"  class="form form-horizontal">
    <div class="modal-body" style="padding-bottom: 0;">
        <div class="portlet box" style="background-color: #444d58; margin-bottom: 0px">
            <div class="portlet-title">
                <div class="caption"><i class="icon-user" style="color: #fff !important"></i>
                    Personal Information
                </div>
            </div>
            <div class="portlet-body" style="padding: 8px 15px;">
                <div class="row">
                    <div class="col-md-12" style="border-bottom: 1px solid #444d58; ">
                        <div style="padding: 0px 30px;" class="col-md-4">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Category</label>
                                    <div>{{$customer->result->cus_telco}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Branch</label>
                                   <div>{{$customer->result->br_name}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">KAM</label>
                                   <div>{{$customer->result->kam_name}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Customer Name</label>
                                   <div>{{$customer->result->cus_name}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Date Paid Resources</label>
                                   <div>{{$customer->result->mem_pay_tgl}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Company Name</label>
                                   <div>{{$customer->result->cus_corporation}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Customer Code</label>
                                   <div>{{$customer->result->cus_code}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div id="id_card" class="validate">
                                   <label style="font-weight: bold;">Prorate</label>
                                   <div>{{$customer->result->cus_prorate}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding: 0px 30px;">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                   <label style="font-weight: bold;">Monthly Based</label>
                                   <div>{{$customer->result->cus_monthly}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Person in Charge</label>
                                    <div>{{$customer->result->cus_pic}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Attach Customer's Agreement</label>
                                    @php
                                    if($customer->result->cus_file !=''){
                                        echo '<div><a href="'.URL::asset(env('PUBLIC_PATH').'hris/files/customer/'. $customer->result->cus_file).'"><i class="fa fa-file"></i></a></div>';
                                    }else{
                                        echo '<div>NA</div>';
                                    }
                                    @endphp
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Prorate Factor</label>
                                   <div>{{$customer->result->cus_factor}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">City </label>
                                   <div>{{$customer->result->cus_city}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Postcode</label>
                                   <div>{{$customer->result->cus_postcode}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Address</label>
                                   <div>{{$customer->result->cus_address}}</div>
                                </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div class="validate">
                                   <label style="font-weight: bold;">Phone</label>
                                   <div>{{$customer->result->cus_phone}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                            </div>
                        </div>
                        <div style="padding: 0px 30px;" class="col-md-4">

                            <div class="validate">
                                <label style="font-weight: bold;">Fax</label>
                                <div>{{$customer->result->cus_fax}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div class="validate">
                                <label style="font-weight: bold;">email </label>
                                <div>{{$customer->result->cus_email}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div class="validate">
                                <label style="font-weight: bold;">Note </label>
                                <div>{{$customer->result->cus_note}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div class="validate">
                                <label style="font-weight: bold;">Management Fee (%) </label>
                                <div>{{$customer->result->management_fee}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div class="validate">
                                <label style="font-weight: bold;">Payment Term </label>
                                <div>{{$customer->result->payment_term}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div class="validate">
                                <label style="font-weight: bold;">Company Size </label>
                                <div>{{$customer->result->company_size}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div class="validate">
                                <label style="font-weight: bold;">Date Cut Off</label>
                                <div>{{$customer->result->date_cutoff}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" style="padding: 8px 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div style="padding: 0px 30px;" class="col-md-12">
                            <div class="form-group form-margin-0">
                                <label style="font-weight: bold;">CONTACT PERSON</label>
                                <div id="errorcontact"></div>
                                <div id="div_contact">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Name</label>
                                            <div>{{$customer->result->cus_contact_name1}}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Position </label>
                                            <div>{{$customer->result->cus_contact_position1}}</div>
                                        </div>
                                        <div class="validate">
                                            <div class="col-md-4">
                                                <label style="font-weight: bold;">Phone</label>
                                                <div>{{$customer->result->cus_contact_phone1}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Department </label>
                                            <div>{{$customer->result->cus_contact_department1}}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Notes </label>
                                            <div>{{$customer->result->cus_contact_note1}}</div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 1px solid #444d58;">
                                <div id="div_contact">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Name</label>
                                            <div>{{$customer->result->cus_contact_name2}}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Position </label>
                                            <div>{{$customer->result->cus_contact_position2}}</div>
                                        </div>
                                        <div class="validate">
                                            <div class="col-md-4">
                                                <label style="font-weight: bold;">Phone</label>
                                                <div>{{$customer->result->cus_contact_phone2}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Department </label>
                                            <div>{{$customer->result->cus_contact_department2}}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Notes </label>
                                            <div>{{$customer->result->cus_contact_note2}}</div>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 1px solid #444d58;">
                                <div id="div_contact">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Name</label>
                                            <div>{{$customer->result->cus_contact_name3}}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Position </label>
                                            <div>{{$customer->result->cus_contact_position3}}</div>
                                        </div>
                                        <div class="validate">
                                            <div class="col-md-4">
                                                <label style="font-weight: bold;">Phone</label>
                                                <div>{{$customer->result->cus_contact_phone3}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Department </label>
                                            <div>{{$customer->result->cus_contact_department3}}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-weight: bold;">Notes </label>
                                            <div>{{$customer->result->cus_contact_note3}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
    <input name="cus_id" value="{{$customer->result->cus_id}}" type="hidden" class="form-control">
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
            $('#formInputEdit').validate({
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
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-passport') }}"
                    },
                    passport_date: {
                        required: true
                    },
                    id_card: {
                        number: true,
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-ktp') }}"
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
                url: "{{ URL::asset(env('APP_URL').'/hris/customer/doedit') }}",
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
