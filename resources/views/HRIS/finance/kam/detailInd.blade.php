
<div class="modal-header">
       <button class="close" data-dismiss="modal"></button>

    <h4 class="modal-title">{{$title}}</h4>
</div>
<form id="formInput"  class="form form-horizontal">

    <div class="modal-body"> 
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Name <font color="red">*</font></label>
                                            <input name="name" value="{{$employee->employee->mem_name}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Alias Name</label>
                                                <input name="alias_name" value="{{$employee->employee->mem_alias}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Gender <font color="red">*</font></label>
                                            @if($employee->employee->mem_gender == 'L')
                                            <input name="alias_name" value="Male" type="text" class="form-control" readonly> 
                                            @elseif($employee->employee->mem_gender == 'P')
                                            <input name="alias_name" value="Female" type="text" class="form-control" readonly> 
                                            @else
                                            <input name="alias_name" value="" type="text" class="form-control" readonly> 
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Place of Birth</label>
                                                <input name="pob"  value="{{$employee->employee->mem_dob_city}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Birth <font color="red">*</font></label>
                                            <input type="text" name="dob" value="{{$employee->employee->mem_dob}}" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy"> 
                                        </div>
                                        <div class="form-group">
                                            <label>Marital Status</label>
                                            <input name="alias_name" value="{{$employee->employee->mem_marital_name}}" type="text" class="form-control" readonly> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Religion</label>
                                            <input name="alias_name" value="{{$employee->employee->religi_name}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile 1</label>
                                                <input name="mobile1" value="{{$employee->employee->mem_mobile}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile 2</label>
                                                <input name="mobile2" value="{{$employee->employee->mem_mobile2}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                                <input name="phone" value="{{$employee->employee->mem_phone}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Address <font color="red">*</font></label>
                                                <textarea style="height:110px" name="address" type="text" class="form-control" readonly>{{$employee->employee->mem_address}}</textarea> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Email 1 <font color="red">*</font></label>
                                                <input name="email1" value="{{$employee->employee->mem_email}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Email 2</label>
                                                <input name="email2" value="{{$employee->employee->mem_email2}}" type="text" class="form-control" readonly> 
                                        </div>

                                        <div class="form-group">
                                            <label>Citizenship <font color="red">*</font></label>
                                            <select disabled name="citizenship" id="citizenship" class="form-control" onchange="getFormId()">
                                                <option value="">-- Choose a Citizenship --</option>
                                                @php
                                                    $citizenship =['local','expatriate'];
                                                    for($i = 0; $i < count($citizenship); $i++){
                                                        if($employee->employee->mem_citizenship == $citizenship[$i]){
                                                            echo '<option value="'. $citizenship[$i] .'" selected>'. ucwords($citizenship[$i]) .'</option>';
                                                        }else{
                                                            echo '<option value="'. $citizenship[$i] .'">'. ucwords($citizenship[$i]) .'</option>';
                                                        }
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                        <div id="areaFormId"></div>
                                        <div class="form-group">
                                            <label>Last Education</label>
                                                <input name="education" value="{{$employee->employee->mem_last_education}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Nationality <font color="red">*</font></label>
                                                <input name="education" value="{{$employee->employee->nat_name}}" type="text" class="form-control" readonly> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Resign Date</label>
                                            <input type="text" name="resign_date" value="{{$employee->employee->mem_resign_date}}" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy"> 
                                        </div>
                                        <div class="form-group">
                                            @php
                                            if($employee->employee->mem_image != NULL){
                                                echo '<img width="100%" src="'. URL::asset(env('APP_URL').'/hris/files/employee/'). $employee->employee->mem_image .'">';
                                            }else{

                                            }
                                            @endphp
                                        </div>
                                        <div class="form-group">
                                            <label>Mail Address</label>
                                                <textarea name="mail_address" value="{{$employee->employee->mem_mail_address}}" type="text" class="form-control" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-ambulance"></i>
                                <span class="caption-subject font-dark bold uppercase">Insurance</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-4">
                                <input type="text" name="resign_date" value="{{$employee->employee->insr_name}}" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-graduation-cap"></i>
                                <span class="caption-subject font-dark bold uppercase">TAX</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="form-body">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Remark <font color="red">*</font></label>
                                            <input type="text" name="resign_date" value="{{$employee->employee->tr_name}}" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy"> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>NPWP Number</label>
                                        <input type="text" name="tax_number" value="{{$employee->employee->mem_npwp_no}}" class="form-control" readonly> 
                                    </div>
                                    <div class="col-md-4">
                                        <label>Address</label>
                                        <textarea type="text" name="tax_address" class="form-control" readonly>{{$employee->employee->mem_npwp_address}}</textarea> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-plus-circle"></i>
                                <span class="caption-subject font-dark bold uppercase">BPJS</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="form-body">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jamsostek Number (KPJ)</label>
                                            <input type="text" name="bpjs_ket" value="{{$employee->employee->mem_jamsostek}}" class="form-control" readonly> 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Virtual Account BPJS Kesehatan</label>
                                        <input type="text" name="bpjs_kes" value="{{$employee->employee->mem_bpjs_kes}}" class="form-control" readonly> 
                                    </div>
                                    <div class="col-md-4">
                                        <label>BPJS Jaminan Pensiun Number</label>
                                        <input type="text" value="{{$employee->employee->mem_bpjs_pen}}"  name="bpjs_pen" class="form-control" readonly> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-plus-circle"></i>
                                <span class="caption-subject font-dark bold uppercase">Bank Info</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="errorbank"></div>
                                <div class="form-body">
                                    <div id="div_bank">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label>Bank Name <font color="red">*</font></label>
                                                    <select disabled name="name_bank1" id="name_bank1" class="form-control" readonly>
                                                        <option value="">-- Choose a Bank --</option>
                                                        @php
                                                        for($i = 0; $i < count($bank->result); $i++){
                                                                if($employee->employee->mem_bank_name == $bank->result[$i]->bank_id){
                                                                    echo '<option value="'.$bank->result[$i]->bank_id.'" selected>'.$bank->result[$i]->bank_name.'</option>';
                                                                }else{
                                                                    echo '<option value="'.$bank->result[$i]->bank_id.'">'.$bank->result[$i]->bank_name.'</option>';
                                                                }
                                                            }
                                                        @endphp
                                                    </select> 
                                            </div>
                                            <div class="col-md-4 form-group" style="margin-left:15px">
                                                <label>Account Number</label>
                                                <input type="text" name="ac_bank1" value="{{$employee->employee->mem_bank_ac}}" id="ac_bank1" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-4 form-group" style="margin-left:15px">
                                                <label>Bank Account Name </label>
                                                <input type="text"  name="an_bank1" value="{{$employee->employee->mem_bank_an}}" id="an_bank1" class="form-control" readonly> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                    <select disabled name="name_bank2" id="name_bank2" class="form-control" disabled>
                                                        <option value="">-- Choose a Bank --</option>
                                                        @php
                                                        for($i = 0; $i < count($bank->result); $i++){
                                                                if($employee->employee->mem_bank_name2 == $bank->result[$i]->bank_id){
                                                                    echo '<option value="'.$bank->result[$i]->bank_id.'" selected>'.$bank->result[$i]->bank_name.'</option>';
                                                                }else{
                                                                    echo '<option value="'.$bank->result[$i]->bank_id.'">'.$bank->result[$i]->bank_name.'</option>';
                                                                }
                                                            }
                                                        @endphp
                                                    </select> 
                                            </div>
                                                <div class="col-md-4 form-group" style="margin-left:15px">
                                                    <input type="text" name="ac_bank2" value="{{$employee->employee->mem_bank_ac2}}" id="ac_bank2" class="form-control" readonly> 
                                                </div>
                                            <div class="col-md-4 form-group" style="margin-left:15px">
                                                <input type="text"  name="an_bank2" value="{{$employee->employee->mem_bank_an2}}" id="an_bank2" class="form-control" readonly> 
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                                   
                    <!-- END SAMPLE FORM PORTLET-->

                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-plus-circle"></i>
                                <span class="caption-subject font-dark bold uppercase">Spouse </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                                <div class="form-body">
                                    <div id="div_spouse">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name_spouse" value="{{$employee->employee->mem_spouse_name}}" class="form-control" readonly> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Date Birth</label>
                                                <input type="text" name="dob_spouse" value="{{$employee->employee->mem_spouse_dob}}" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy"> 
                                            </div>
                                            <div class="col-md-4">
                                                <label>Gender</label>
                                                @if($employee->employee->mem_spouse_gender == 'L')
                                                <input name="alias_name" value="Male" type="text" class="form-control" readonly> 
                                                @elseif($employee->employee->mem_spouse_gender == 'P')
                                                <input name="alias_name" value="Female" type="text" class="form-control" readonly> 
                                                @else
                                                <input name="alias_name" value="" type="text" class="form-control" readonly> 
                                                @endif  
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    <!-- END SAMPLE FORM PORTLET-->

                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-plus-circle"></i>
                                    <span class="caption-subject font-dark bold uppercase">Child </span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="errorChild"></div>
                                    <div class="form-body">
                                        <div id="div_Child">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" value="{{$employee->employee->mem_child1_name}}"  name="name_child1" id="name_child1" class="form-control" readonly> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Date Birth</label>
                                                    <input type="text"  name="dob_child1" value="{{$employee->employee->mem_child1_dob}}" id="dob_child1" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy"> 
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Gender</label>
                                                    @if($employee->employee->mem_child1_gender == 'L')
                                                    <input name="alias_name" value="Male" type="text" class="form-control" readonly> 
                                                    @elseif($employee->employee->mem_child1_gender == 'P')
                                                    <input name="alias_name" value="Female" type="text" class="form-control" readonly> 
                                                    @else
                                                    <input name="alias_name" value="" type="text" class="form-control" readonly> 
                                                    @endif  
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" value="{{$employee->employee->mem_child2_name}}"  name="name_child2" id="name_child2" class="form-control" readonly> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text"  name="dob_child2" value="{{$employee->employee->mem_child2_dob}}" id="dob_child2" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy"> 
                                                </div>
                                                <div class="col-md-4">
                                                    @if($employee->employee->mem_child2_gender == 'L')
                                                    <input name="alias_name" value="Male" type="text" class="form-control" readonly> 
                                                    @elseif($employee->employee->mem_child2_gender == 'P')
                                                    <input name="alias_name" value="Female" type="text" class="form-control" readonly> 
                                                    @else
                                                    <input name="alias_name" value="" type="text" class="form-control" readonly> 
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" value="{{$employee->employee->mem_child3_name}}"  name="name_child3" id="name_child3" class="form-control" readonly> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text"  name="dob_child3" value="{{$employee->employee->mem_child3_dob}}" id="dob_child3" class="form-control date-picker" readonly data-date-format="dd/mm/yyyy"> 
                                                </div>
                                                <div class="col-md-4">
                                                @if($employee->employee->mem_child3_gender == 'L')
                                                <input name="alias_name" value="Male" type="text" class="form-control" readonly> 
                                                @elseif($employee->employee->mem_child3_gender == 'P')
                                                <input name="alias_name" value="Female" type="text" class="form-control" readonly> 
                                                @else
                                                <input name="alias_name" value="" type="text" class="form-control" readonly> 
                                                @endif
                                                     
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
    <input type="hidden" value="3" name="form_type" id="form_type" class="form-control"> 
    <input name="mem_id" id="mem_id" type="hidden" class="form-control" readonly value="{{$employee->employee->mem_id}}"> 
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