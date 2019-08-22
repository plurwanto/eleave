
<div class="modal-header">
       <button class="close" data-dismiss="modal"></button>

    <h4 class="modal-title">{{$title}}</h4>
</div>
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
                            <div>
                                <label style="font-weight: bold;">Name</label>
                                <div>{{$employee->employee->mem_name !=''? $employee->employee->mem_name : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Thailand Name</label>
                                <div>{{$employee->employee->mem_name_tha !=''? $employee->employee->mem_name_tha : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Place of Birth</label>
                                <div>{{$employee->employee->mem_dob_city !=''? $employee->employee->mem_dob_city : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Date of Birth</label>
                                <div>{{$employee->employee->mem_dob !=''? $employee->employee->mem_dob : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Gender</label>
                                <div>
                                @if($employee->employee->mem_gender == 'P')
                                Female
                                @else
                                Male
                                @endif
                                </div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Marital Status</label>
                                <div>{{$employee->employee->mem_marital_name !=''? $employee->employee->mem_marital_name : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Religion</label>
                                <div>{{$employee->employee->religi_name !=''? $employee->employee->religi_name : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Mobile</label>
                                <div>{{$employee->employee->mem_mobile !=''? $employee->employee->mem_mobile : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Nationality</label>
                                <div>{{$employee->employee->nat_name !=''? $employee->employee->nat_name : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Citizenship</label>
                                <div>{{$employee->employee->mem_citizenship !=''? $employee->employee->mem_citizenship : 'none'}}</div>
                            </div>
                            @if($employee->employee->mem_citizenship == 'expatriate')
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div id="passport" style="">
                                <div class="col-md-6" style="padding-left: 0">
                                    <label style="font-weight: bold;">Passport No.</label>
                                    <div>{{$employee->employee->mem_passport !=''? $employee->employee->mem_passport : 'none'}}</div>
                                </div>
                                <div class="col-md-6" style="padding-right: 0">
                                    <label style="font-weight: bold;">Expire Date</label>
                                    <div>{{$employee->employee->mem_exp_passport !=''? $employee->employee->mem_exp_passport : 'none'}}</div>
                                </div>
                            </div>
                            @else
                            <div id="id_card">
                                <label style="font-weight: bold;">ID Card</label>
                                <div>{{$employee->employee->mem_ktp_no !=''? $employee->employee->mem_ktp_no : 'none'}}</div>
                            </div>
                            @endif
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Email</label>
                                <div>{{$employee->employee->mem_email !=''? $employee->employee->mem_email : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 0px 30px;">
                        <div class="form-group form-margin-0">
                            <!-- <div>
                                <label style="font-weight: bold;">Last Education</label>
                                <div>{{$employee->employee->mem_last_education !=''? $employee->employee->mem_last_education : 'none'}}</div>
                            </div> -->
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <div class="col-md-6" style="padding-left: 0">
                                    <label style="font-weight: bold;">Join Date</label>
                                    <div>{{$employee->employee->mem_join_date !=''? $employee->employee->mem_join_date : 'none'}}</div>
                                </div>
                                <div class="col-md-6" style="padding-right: 0">
                                    <label style="font-weight: bold;">Resign Date</label>
                                    <div>{{$employee->employee->mem_resign_date !=''? $employee->employee->mem_resign_date : 'none'}}</div>
                                </div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Address</label>
                                <div style="    word-break: break-word">{{$employee->employee->mem_address !=''? $employee->employee->mem_address : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-body" style="padding: 8px 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div style="padding: 0px 30px;" class="col-md-4">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Bank Info</label>
                                <div>{{$employee->employee->bank_name !=''? $employee->employee->bank_name : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Account Name</label>
                                <div>{{$employee->employee->mem_bank_an !=''? $employee->employee->mem_bank_an : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Account Number</label>
                                <div>{{$employee->employee->mem_bank_ac !=''? $employee->employee->mem_bank_ac : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Insurance</label>
                                <div>{{$employee->employee->insr_name !=''? $employee->employee->insr_name : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Tax Remark</label>
                                <div>{{$employee->employee->tr_name !=''? $employee->employee->tr_name : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Tax Number</label>
                                <div>{{$employee->employee->mem_npwp_no !=''? $employee->employee->mem_npwp_no : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 0px 30px;">
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Homebase</label>
                                <div style="word-break: break-word">{{$employee->employee->homebase !=''? $employee->employee->homebase : 'none'}}
                                </div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Address in Thailand</label>
                                <div style="word-break: break-word">
                                {{$employee->employee->mem_address_tha !=''? $employee->employee->mem_address_tha : 'none'}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@if($employee->employee->mem_citizenship == 'expatriate')
<div class="portlet-body" style="padding: 8px 15px; " id="bank2">
                <div class="row" style="border-top: 1px solid #444d58; ">
                    <div class="col-md-12" style="margin-top:20px">
                        <div style="padding: 0px 30px;" class="col-md-4">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Bank Info (Secondary)</label>
                                <div>{{$employee->employee->bank_name2 !=''? $employee->employee->bank_name2 : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Account Name (Secondary)</label>
                                <div>{{$employee->employee->mem_bank_an2 !=''? $employee->employee->mem_bank_an2 : 'none'}}</div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Account Number (Secondary)</label>
                                <div>{{$employee->employee->mem_bank_ac2 !=''? $employee->employee->mem_bank_ac2 : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-margin-0">
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Swift</label>
                                <div>{{$employee->employee->swift_no !=''? $employee->employee->swift_no : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif

<div class="portlet-body" style="padding: 8px 15px;">
    <div class="row" style="border-top: 1px solid #444d58; ">
        <div class="col-md-12" style="margin-top:20px">
            <div class="col-md-4" style="padding: 0px 30px;">
                <div class="form-group form-margin-0">
                    <div>
                        <label style="font-weight: bold;">Name (Emergency)</label>
                        <div>{{$employee->employee->mem_emergency_name !=''? $employee->employee->mem_emergency_name : 'none'}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="padding: 0px 30px;">
                <div class="form-group form-margin-0">
                    <div>
                        <label style="font-weight: bold;">Relationship (Emergency)</label>
                        <div>{{$employee->employee->mem_emergency_relationship !=''? $employee->employee->mem_emergency_relationship : 'none'}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="padding: 0px 30px;">
                <div class="form-group form-margin-0">
                    <div>
                        <label style="font-weight: bold;">Contact Number (Emergency)</label>
                        <div>{{$employee->employee->mem_emergency_mobile !=''? $employee->employee->mem_emergency_mobile : 'none'}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($employee->employee->mem_marital_name != 'Single')
<div class="portlet-body" id="family" style="padding: 8px 15px; ">
                <div class="row">
                    <div class="col-md-12"  style="border-top: 1px solid #444d58;">
                        <div style="padding: 0px 30px;  margin-top:20px" class="col-md-12">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Spouse</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <small>Name</small>
                                        <div>{{$employee->employee->mem_spouse_name !=''? $employee->employee->mem_spouse_name : 'none'}}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small>Date of Birth</small>
                                        <div>{{$employee->employee->mem_spouse_dob !=''? $employee->employee->mem_spouse_dob : 'none'}}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small>Gender</small>
                                        <div>
                                        @if($employee->employee->mem_spouse_gender == 'P')
                                        Female
                                        @else
                                        Male
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="clear: both; margin-bottom: 10px;"></div>
                            <div>
                                <label style="font-weight: bold;">Child</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <small>Name</small>
                                        <div>{{$employee->employee->mem_child1_name !=''? $employee->employee->mem_child1_name : 'none'}}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small>Date of Birth</small>
                                        <div>{{$employee->employee->mem_child1_dob !=''? $employee->employee->mem_child1_dob : 'none'}}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small>Gender</small>
                                        <div>
                                        @if($employee->employee->mem_child1_gender == 'P')
                                        Female
                                        @else
                                        Male
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="modal-footer">
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
    </div>
</div>

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
            getFormId();
            $('#formInput').validate({
                rules: {
                    name: {
                        required: true
                    },
                    gender: {
                        required: true
                    },
                    dob: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    email1: {
                        required: true,
                        email: true,
                        remote: {
                        url: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-email-exising-edit') }}",
                        type: "get",
                        data: {
                            mem_id: function() {
                                return $("#mem_id").val();
                                }
                            }
                        }
                    },
                    ac_bank1: {
                        required: true,
                        number: true,
                        remote: {
                        url: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-bank-exising-edit') }}",
                        type: "get",
                        data: {
                            mem_id: function() {
                                return $("#mem_id").val();
                                }
                            }
                        }
                    },
                    an_bank1: {
                        required: true
                    },
                    citizenship: {
                        required: true
                    },
                    nationality: {
                        required: true
                    },
                    tax_remark: {
                        required: true
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
                },
                messages: {
                    email1: {
                                remote: "Email existing"
                            },
                    ac_bank1: {
                            remote: "Bank existing"
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
                url: "{{ URL::asset(env('APP_URL').'/hris/employee/others/doadd') }}",
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
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/employee/others') }}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                    } else {
                        swal({title: "Failed", text:data.message, type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/employee/others') }}";
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

        function addFunctionChild(e) {
        dataid = $(e).attr('dataid');
        name_child = $('#name_child' + dataid).val();

        if (name_child == '' || dataid == 3) {
            var msg = '<div class="alert alert-danger alert-dismissable">Fields can not be empty</div>';
            $("#errorChild").html(msg);
            $('#errorChild').alert();
            $('#errorChild').fadeTo(2000, 500).slideUp(500, function () {
                $('#errorChild').hide();

            });
        } else {
            newdataid = parseInt(dataid) + 1;
            $('#actionChild_' + dataid).hide();
            htm =   '<div id="row_' + newdataid + '" class="row">'+
                        '<div class="col-md-4">'+
                            '<div class="form-group">'+
                                '<input type="text" name="name_child' + newdataid + '" id="name_child' + newdataid + '" class="form-control" readonly>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<input type="text" name="dob_child' + newdataid + '" id="dob_child' + newdataid + '" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy">'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<select disabled name="gender_child' + newdataid + '" id="gender_child' + newdataid + '" class="form-control" readonly>'+
                                '<option value="">-- Choose a Gender --</option>'+
                                '<option value="L">Male</option>'+
                                '<option value="P">Female</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row" id="actionChild_' + newdataid + '" style="margin-top:5px">'+
                        '<div class="col-xs-6">'+
                            '<div class="form-group">'+
                                '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctionChild(this);">'+
                                    '<font style="color:white">Add New</font>'+
                                '</a>'+
                                '&nbsp;'+
                                '<a id="delete_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-danger" onclick="deleteFunctionChild(this);">' +
                                    '<i class="fa fa-minus" style="color:white"></i>' +
                                '</a>' +
                            '</div>'+
                        '</div>'+
                    '</div>';

            $('#div_Child').append(htm);
            $('#count_child').val(newdataid);
        }

    }

    function deleteFunctionChild(e) {
        dataid = $(e).attr('dataid');
        $('#actionChild_' + dataid).remove();
        newdataid = parseInt(dataid) - 1;
        $('#row_' + dataid).remove();
        $('#actionChild_' + newdataid).show();
        $('#count_child').val(newdataid);
    }


        function addFunctionbank(e) {
        dataid = $(e).attr('dataid');
        name_bank = $('#name_bank' + dataid).val();

        if (name_bank == ''|| dataid == 2) {
            var msg = '<div class="alert alert-danger alert-dismissable">Fields can not be empty</div>';
            $("#errorbank").html(msg);
            $('#errorbank').alert();
            $('#errorbank').fadeTo(2000, 500).slideUp(500, function () {
                $('#errorbank').hide();

            });
        } else {
            newdataid = parseInt(dataid) + 1;
            $('#actionbank_' + dataid).hide();
            htm ='  <div class="row" id="rowbank' + newdataid + '">'+
                            '<div class="col-md-4">'+
                                '<div class="form-group">'+
                                        '<select disabled name="name_bank' + newdataid + '" id="name_bank' + newdataid + '" class="form-control" readonly>'+
                                            '<option value="">-- Choose a Bank --</option>'+
                                            '@for($i = 0; $i < count($bank->result); $i++)'+
                                            '<option value="{{$bank->result[$i]->bank_id}}">{{$bank->result[$i]->bank_name}}</option>'+
                                            '@endfor'+
                                        '</select>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-4">'+
                                '<input type="text" name="ac_bank' + newdataid + '" id="ac_bank' + newdataid + '" class="form-control" readonly>'+
                            '</div>'+
                            '<div class="col-md-4">'+
                                '<input type="text"  name="an_bank' + newdataid + '" id="an_bank' + newdataid + '" class="form-control" readonly>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row" id="actionbank_' + newdataid + '" style="margin-top:5px">'+
                            '<div class="col-xs-6">'+
                                '<div class="form-group">'+
                                    '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctionbank(this);">'+
                                        '<font style="color:white">Add New</font>'+
                                    '</a>'+
                                    '&nbsp;'+
                                    '<a id="delete_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-danger" onclick="deleteFunctionbank(this);">' +
                                        '<i class="fa fa-minus" style="color:white"></i>' +
                                    '</a>' +
                                '</div>'+
                            '</div>'+
                        '</div>';

            $('#div_bank').append(htm);
            $('#count_bank').val(newdataid);
        }

    }

    function deleteFunctionbank(e) {
        dataid = $(e).attr('dataid');
        $('#actionbank_' + dataid).remove();
        newdataid = parseInt(dataid) - 1;
        $('#rowbank' + dataid).remove();
        $('#actionbank_' + newdataid).show();
        $('#count_bank').val(newdataid);
    }

    function getFormId() {
         var citizenship = document.getElementById("citizenship").value;
         if(citizenship =='local'){
            htm='<div class="form-group">'+
                    '<label>ID Card</label>'+
                        '<input name="id_card" value="{{$employee->employee->mem_ktp_no}}" type="text" class="form-control" readonly>'+
                '</div>';
         }else if(citizenship =='expatriate'){
            htm='<div class="form-group">'+
                    '<label>Passport Number</label>'+
                        '<input name="passport" value="{{$employee->employee->mem_passport}}" type="text" class="form-control" readonly>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label>Passport Expire Date</label>'+
                        '<input name="passport_date" value="{{$employee->employee->mem_exp_passport}}" type="text" class="form-control" readonly id="dp" onclick="$(\'#dp\').datepicker();$(\'#dp\').datepicker(\'show\');" data-date-format="dd/mm/yyyy">'+
                '</div>';
         }else{
            htm='';
         }
         $('#areaFormId').html(htm);
    }
    $(function() {
        $( "#date-picker" ).datepicker();
    });
</script>
