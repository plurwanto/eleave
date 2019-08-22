
<div class="modal-header">
       <button class="close" data-dismiss="modal"></button>

    <h4 class="modal-title">{{$title}}</h4>
</div>
<form id="formInput"  class="form form-horizontal">
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
                        <div style="padding: 0px 30px;" class="col-md-6">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Name</label>
                                    <input name="name" type="text" autocomplete="off" class="form-control" placeholder="Enter Name">
                                </div>
                                <!-- <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Alias Name <small>(optional)</small></label>
                                    <input name="alias_name" type="text" autocomplete="off" class="form-control" placeholder="Enter Alias Name">
                                </div> -->
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Place of Birth</label>
                                    <input name="pob" type="text" autocomplete="off" class="form-control" placeholder="Enter Place of Birth">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Date of Birth</label>
                                    <div>
                                        <input type="text" name="dob" autocomplete="off" class="form-control date-picker" data-date-format="dd/mm/yyyy"
                                            placeholder="Enter Date of Birth" id="dob" onclick="$('#dob').datepicker();$('#dob').datepicker('show');">
                                    </div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Gender</label>
                                    <div class="mt-radio-inline" style="padding-top: 7px;padding-bottom: 9px;">
                                        <label class="mt-radio" style="margin-bottom: 0;"><input type="radio" name="gender"
                                                value="L" checked="checked">
                                            Male
                                            <span></span>
                                        </label>
                                        <label class="mt-radio" style="margin-bottom: 0;"><input type="radio" name="gender"
                                                value="P">
                                            Female
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Marital Status</label>
                                    <select name="marital" id="marital" autocomplete="off" class="form-control" onchange="family_cond()">
                                        <option value="">-- Choose a Marital --</option>
                                        @for($i = 0; $i < count($marital->result); $i++)
                                        <option value="{{$marital->result[$i]->mem_marital_id}}">{{$marital->result[$i]->mem_marital_name}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Religion</label>
                                    <select name="religion" autocomplete="off" class="form-control">
                                        <option value="">-- Choose a religion --</option>
                                        @for($i = 0; $i < count($religion->result); $i++)
                                        <option value="{{$religion->result[$i]->religi_id}}">{{$religion->result[$i]->religi_name}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Mobile</label>
                                    <input name="mobile1" type="text" autocomplete="off" class="form-control" placeholder="Enter Mobile">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding: 0px 30px;">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Nationality</label>
                                    <select name="nationality" autocomplete="off" class="form-control">
                                        <option value="">-- Choose a nationality --</option>
                                        @for($i = 0; $i < count($nationality->result); $i++)
                                        <option value="{{$nationality->result[$i]->nat_id}}">{{$nationality->result[$i]->nat_name}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Citizenship</label>
                                    <div class="mt-radio-inline" style="padding-top: 7px;padding-bottom: 9px;">
                                        <label class="mt-radio" style="margin-bottom: 0;"><input type="radio" name="citizenship"
                                                value="local" checked="checked" onclick="$('#id_card').show(); $('#passport').hide(); $('#bank2').hide();">
                                            Local
                                            <span></span>
                                        </label>
                                        <label class="mt-radio" style="margin-bottom: 0;"><input type="radio" name="citizenship"
                                                value="expatriate" onclick="$('#id_card').hide(); $('#passport').show(); $('#bank2').show();">
                                            Expatriate
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div id="id_card" class="validate">
                                    <label style="font-weight: bold;">ID Card</label>
                                    <input name="id_card" type="text" autocomplete="off" class="form-control" placeholder="Enter ID Card">
                                </div>
                                <div id="passport" style="display:none">
                                    <div class="col-md-6 validate" style="padding-left: 0">
                                        <label style="font-weight: bold;">Passport Number</label>
                                        <input name="passport" type="text" autocomplete="off" class="form-control" placeholder="Enter Number">
                                    </div>
                                    <div class="col-md-6 validate" style="padding-right: 0">
                                        <label style="font-weight: bold;">Passport Expire Date</label>
                                        <input name="passport_date" type="text" autocomplete="off" class="form-control" placeholder="Enter Expire Date"
                                            id="passport_date" onclick="$('#passport_date').datepicker();$('#passport_date').datepicker('show');"
                                            data-date-format="dd/mm/yyyy">
                                    </div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Email</label>
                                    <input name="email1" type="text" autocomplete="off" class="form-control" placeholder="Enter Email">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <!-- <div class="validate">
                                    <label style="font-weight: bold;">Last Education <small>(optional)</small></label>
                                    <input name="education" type="text" autocomplete="off" class="form-control" placeholder="Enter Last Education">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div> -->
                                <div>
                                    <!-- <div class="col-md-6" style="padding-left: 0">
                                        <label style="font-weight: bold;">Join Date</label>
                                        <input type="text" name="join_date" autocomplete="off" class="form-control date-picker" id="join_date"
                                           data-date-format="dd/mm/yyyy" placeholder="Enter Join Date">
                                    </div> -->
                                    <!-- <div class="col-md-6" style="padding-right: 0">
                                        <label style="font-weight: bold;">Resign Date <small>(optional)</small></label>
                                        <input type="text" name="resign_date" autocomplete="off" class="form-control date-picker" id="resign_date"
                                            onclick="$('#resign_date').datepicker();$('#resign_date').datepicker('show');"
                                            data-date-format="dd/mm/yyyy" placeholder="Enter Resign Date">
                                    </div> -->
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Address</label>
                                    <textarea name="address" type="text" autocomplete="off" class="form-control" style="height: 104px"
                                        placeholder="Enter Address"></textarea>
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
                                    <select name="name_bank1" id="name_bank1" autocomplete="off" class="form-control">
                                        <option value="">-- Choose a Bank --</option>
                                        @for($i = 0; $i < count($bank->result); $i++)
                                        <option value="{{$bank->result[$i]->bank_id}}">{{$bank->result[$i]->bank_name}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Account Number</label>
                                    <input type="text" name="ac_bank1" id="ac_bank1" autocomplete="off" class="form-control" placeholder="Enter Account Number">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Account Name</label>
                                    <input type="text" name="an_bank1" id="an_bank1" autocomplete="off" class="form-control" placeholder="Enter Account Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Insurance</label>
                                    <select name="insurance" autocomplete="off" class="form-control">
                                        <option value="">-- Choose a Insurance --</option>
                                        @for($i = 0; $i < count($insurance->result); $i++)
                                        <option value="{{$insurance->result[$i]->insr_id}}">{{$insurance->result[$i]->insr_name}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Tax Remark</label>
                                    <select name="tax_remark" autocomplete="off" class="form-control">
                                        <option value="">-- Choose a Remark --</option>
                                        @for($i = 0; $i < count($tax_remark->result); $i++)
                                        <option value="{{$tax_remark->result[$i]->tr_id}}">{{$tax_remark->result[$i]->tr_name}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Tax Number</label>
                                    <input type="text" name="tax_number" autocomplete="off" class="form-control" placeholder="Enter Tax Number">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding: 0px 30px;">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">KPJ Number <small>(optional)</small></label>
                                    <input type="text" name="bpjs_ket" autocomplete="off" class="form-control" placeholder="Enter Number">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Jaminan Pensiun Number <small>(optional)</small></label>
                                    <input type="text" name="bpjs_pen" autocomplete="off" class="form-control" placeholder="Enter Number">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">VA BPJS Kesehatan <small>(optional)</small></label>
                                    <input type="text" name="bpjs_kes" autocomplete="off" class="form-control" placeholder="Enter Number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" style="padding: 8px 15px; display:none" id="bank2">
                <div class="row"  style="border-top: 1px solid #444d58;">
                    <div class="col-md-12" style="margin-top:20px">
                        <div style="padding: 0px 30px;" class="col-md-4">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Bank Info (Secondary)</label>
                                    <select name="name_bank2" id="name_bank2" autocomplete="off" class="form-control">
                                        <option value="">-- Choose a Bank --</option>
                                        @for($i = 0; $i < count($bank->result); $i++)
                                        <option value="{{$bank->result[$i]->bank_id}}">{{$bank->result[$i]->bank_name}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Account Number (Secondary)</label>
                                    <input type="text" name="ac_bank2" id="ac_bank2" autocomplete="off" class="form-control" placeholder="Enter Account Number">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Account Name (Secondary)</label>
                                    <input type="text" name="an_bank2" id="an_bank2" autocomplete="off" class="form-control" placeholder="Enter Account Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Swift Code</label>
                                    <input type="text" name="swift" id="swift" autocomplete="off" class="form-control" placeholder="Enter Account Name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" id="family" style="padding: 8px 15px; display:none">
                <div class="row">
                    <div class="col-md-12" style="border-top: 1px solid #444d58;">
                        <div style="padding: 0px 30px; margin-top:20px" class="col-md-12">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Spouse</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small>Name</small>
                                            <input type="text" name="name_spouse" autocomplete="off" class="form-control" placeholder="Enter Name">
                                        </div>
                                        <div class="col-md-4">
                                            <small>Date of Birth</small>
                                            <input type="text" name="dob_spouse" autocomplete="off" class="form-control date-picker"
                                                placeholder="Enter Date" data-date-format="dd/mm/yyyy" onclick="$('#dob_spouse').datepicker();$('#dob_spouse').datepicker('show');">
                                        </div>
                                        <div class="col-md-4">
                                            <small>Gender</small>
                                            <select name="gender_spouse" autocomplete="off" class="form-control">
                                                <option value="">-- Choose a Gender --</option>
                                                <option value="L">Male</option>
                                                <option value="P">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Child</label>
                                    <div id="errorChild"></div>
                                    <div id="div_Child">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <small>Name</small>
                                                <input type="text" name="name_child1" id="name_child1" autocomplete="off" class="form-control"
                                                    placeholder="Enter Name">
                                            </div>
                                            <div class="col-md-4">
                                                <small>Date of Birth</small>
                                                <input type="text" name="dob_child1" autocomplete="off" placeholder="Enter Date" autocomplete="off" class="form-control date-picker"
                                                    data-date-format="dd/mm/yyyy" onclick="$('#dob_child1').datepicker();$('#dob_child1').datepicker('show');">
                                            </div>
                                            <div class="col-md-4">
                                                <small>Gender</small>
                                                <select name="gender_child1" id="gender_child1" autocomplete="off" class="form-control">
                                                    <option value="">-- Choose a Gender --</option>
                                                    <option value="L">Male</option>
                                                    <option value="P">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12" id="actionChild_1" style="margin-top:10px;">
                                                <a id="add_1" dataid="1" class="btn btn-primary" onclick="addFunctionChild(this);">
                                                    <font style="color:white">Add New</font>
                                                </a>
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
    </div>
    <div class="modal-footer">
        <input type="hidden" value="3" name="form_type" id="form_type" autocomplete="off" class="form-control">
            <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="submit" class="btn green" id="btnSubmit">Save</button>
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
                    tax_number: {
                        number: true
                    },
                    mobile1: {
                        number: true
                    },
                    join_date: {
                        required: true
                    },
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

                        remote:"{{ URL::asset(env('APP_URL').'/hris/employee/others/check-email-exising') }}"
                    },
                    name_bank1: {
                        required: true
                    },
                    ac_bank1: {
                        number: true,
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-bank-exising') }}"
                    },
                    an_bank1: {
                        required: true
                    },
                    ac_bank2: {
                        number: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-bank-exising') }}"
                    },
                    swift: {
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
                },
                messages: {
                        passport: {
                            remote: "Passport existing"
                        },
                        id_card: {
                            remote: "ID Card existing"
                        },
                        email1: {
                            remote: "Email existing"
                        },
                        ac_bank1: {
                            remote: "Bank existing"
                        },
                        ac_bank2: {
                            remote: "Bank existing"
                        },
                        file: {
                            remote: "Please enter a value with JPEG Format"
                        },

                },
                highlight: function (element) {
                    $(element).closest('.validate').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.validate').removeClass('has-error').addClass('has-success');
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


                    htm ='<div id="row_' + newdataid + '" class="row" style="margin-top:20px">'+
                    '<div class="col-md-4">'+
                            '<input type="text" name="name_child' + newdataid + '" autocomplete="off" id="name_child' + newdataid + '" autocomplete="off" class="form-control" placeholder="Enter Name">'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<input type="text" name="dob_child' + newdataid + '" autocomplete="off" placeholder="Enter Date" autocomplete="off" class="form-control date-picker" data-date-format="dd/mm/yyyy" id="dob_child' + newdataid + '" onclick="$(\'#dob_child' + newdataid + '\').datepicker();$(\'#dob_child' + newdataid + '\').datepicker(\'show\');">'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<select name="gender_child' + newdataid + '" autocomplete="off" id="gender_child' + newdataid + '" autocomplete="off" class="form-control">'+
                                '<option value="">-- Choose a Gender --</option>'+
                                '<option value="L">Male</option>'+
                                '<option value="P">Female</option>'+
                            '</select>'+
                        '</div>'+
                        '<div class="col-md-12" id="actionChild_' + newdataid + '" style="margin-top:10px;">'+
                            '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctionChild(this);">'+
                                '<font style="color:white">Add New</font>'+
                            '</a>'+
                            '&nbsp;'+
                            '<a id="delete_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-danger" onclick="deleteFunctionChild(this);">'+
                                '<i class="fa fa-minus" style="color:white"></i>'+
                            '</a>'+
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
                            '<div class="col-md-4 form-group validate">'+
                                        '<select name="name_bank' + newdataid + '" id="name_bank' + newdataid + '" autocomplete="off" class="form-control">'+
                                            '<option value="">-- Choose a Bank --</option>'+
                                            '@for($i = 0; $i < count($bank->result); $i++)'+
                                            '<option value="{{$bank->result[$i]->bank_id}}">{{$bank->result[$i]->bank_name}}</option>'+
                                            '@endfor'+
                                        '</select>'+
                            '</div>'+
                            '<div class="col-md-4 form-group validate" style="margin-left:15px">'+
                                '<input type="text" name="ac_bank' + newdataid + '" id="ac_bank' + newdataid + '" autocomplete="off" class="form-control">'+
                            '</div>'+
                            '<div class="col-md-4 form-group validate" style="margin-left:15px">'+
                                '<input type="text"  name="an_bank' + newdataid + '" id="an_bank' + newdataid + '" autocomplete="off" class="form-control">'+
                            '</div>'+
                        '</div>'+
                        '<div class="row" id="actionbank_' + newdataid + '" style="margin-top:5px">'+
                            '<div class="col-xs-6">'+
                                '<div class="form-group validate">'+
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


    function family_cond() {
        var marital = document.getElementById("marital").value;

        if(marital == 'S'){
            $('#family').hide();

        }else{
            $('#family').show();

        }
    }



    $(function() {
        $( "#date-picker" ).datepicker();
    });
</script>
