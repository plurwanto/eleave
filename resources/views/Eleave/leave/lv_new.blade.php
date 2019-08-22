@extends('Eleave.layout.main')

@section('title','Eleave | Leave Add')

@section('style')

@endsection

@section('content')

@if ($msg = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i> {{ $msg }} 
</div>
@endif
@if ($msg = Session::get('warning'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-warning'></i> {{ $msg }} 
</div>
@endif
<div>
    <span id="StartErrorMsg" class="errmessage" ></span>
    <span id="EndErrorMsg" class="errmessage" ></span>
    <span id="errorMsg" class="errmessage" ></span>
</div>

<?php if ($data->message == "") {?>
    <?php if ($lv_type != "Medical Leave" && $lv_type != "Unpaid Leave") {?>
        <div class="alert alert-info">You can take <?=$data->take?> days leave.</div>
    <?php }?>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-clock-o"></i>Add Leave Form
            </div>
            <div class="tools"></div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ url('eleave/leave/insert') }}" class="form-horizontal" enctype="multipart/form-data" method="post" id="form_leave">
                <input type="hidden" name="lv_act" value="lv_insert"/>
                <input type="hidden" name="lv_type" id="lv_type" value="<?=$lv_type;?>"/>
                <?php if ($lv_type != "Medical Leave" && $lv_type != "Unpaid Leave") {?>
                    <input type="hidden" name="max_leave" value="<?=$data->take?>"/>
                <?php }?>
                <div class="form-body">
                    <!--                    <div class="alert alert-danger display-hide" id="errorContainer">
                                            <button class="close" data-close="alert"></button> 
                                            You have some form errors. Please check below. </div>-->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Leave Type</label>
                        <div class="col-md-4" style="margin-top: 8px;">
                            <?=$lv_type?>
                        </div>
                    </div>
                    <?php if ($lv_type == "Annual Leave" || $lv_type == "Emergency Leave" || $lv_type == "Unpaid Leave") {?>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Day Session</label>
                            <div class="col-md-4">
                                <div class="radio-list">
                                    <label>
                                        <input type="radio" name="lv_half" id="full" value="Full Day" checked> Full Day</label>
                                    <label>
                                        <input type="radio" name="lv_half" id="half" value="Half Day"> Half Day</label>
                                        <select name="lv_half_time" id="lv_half_time" class="form-control">
                                        <option value="First Half">First Half</option>
                                        <option value="Second Half">Second Half</option>
                                    </select>
                                </div>
                            </div>															
                        </div>
                    <?php }?>

                    <?php if ($lv_type == "Emergency Leave") {?>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Start Date</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control datepicker_emergency" placeholder="Enter start date" name="lv_start_date" id="lv_start_date" autocomplete="off">
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Start Date</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control datepicker" value="{{ session('sd') }}" placeholder="Enter start date" name="lv_start_date" id="lv_start_date" autocomplete="off">
                            </div>
                        </div>
                    <?php }?>

                    <div class="form-group" id="lv_end_date_group">
                        <label class="col-md-3 control-label">End Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control datepicker" value="{{ session('ed') }}" placeholder="Enter end date" name="lv_end_date" id="lv_end_date" autocomplete="off">
                        </div>
                    </div>

                    <?php if ($lv_type == "Compassionate Leave" || $lv_type == "Paternity Leave" || $lv_type == "Maternity Leave" || $lv_type == "Marriage Leave" || $lv_type == "Medical Leave" || $lv_type == "Annual Leave" || $lv_type == "Emergency Leave" || $lv_type == "Study Leave" || $lv_type == "Unpaid Leave") {?>
                        <div class="form-group" id="file_group">
                            <label class="control-label col-md-3">Detail</label>
                            <div class="col-md-4">
                                <textarea class="form-control" rows="3" placeholder="Enter detail" name="lv_detail" maxlength="255">{{ session('dt') }}</textarea>
                            </div>
                        </div>
                        <?php if ($lv_type == "Medical Leave") {?>
                            <!-- PTES -->
                            <?php if (session('branch_id') == 2) {?>
                                <div class="form-group" id="file_group">
                                    <label class="control-label col-md-3">Attach Medical Certificate</label>
                                    <div class="col-md-4">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn green btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="lv_document" id="lv_document"> </span>
                                            <span class="fileinput-filename"> </span> &nbsp;
                                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="file_group">
                                    <label class="control-label col-md-3">Attach Statement Letter</label>
                                    <div class="col-md-4">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn green btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="lv_statement_letter" id="lv_statement_letter" value="{{ session('up') }}"> </span>
                                            <span class="fileinput-filename"> </span> &nbsp;
                                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="form-group" id="file_group">
                                    <label class="control-label col-md-3">Attach Support Document</label>
                                    <div class="col-md-4">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn green btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="lv_document" id="lv_document"> </span>
                                            <span class="fileinput-filename"> </span> &nbsp;
                                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>															
                        <?php } else {?>
                            <div class="form-group" id="file_group">
                                <label class="control-label col-md-3">Attach Support Document</label>
                                <div class="col-md-4">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn green btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="lv_document" id="lv_document"> </span>
                                        <span class="fileinput-filename"> </span> &nbsp;
                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-circle green" id="btnSave">Submit Leave</button>
                            <a href="{{ URL::to('eleave/leave/index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>
            <!-- END FORM-->
        </div>
    </div>
<?php } else {?>
    <div class="alert alert-warning"><?=$data->message;?></div>
<?php }?>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#lv_half_time').attr('disabled', true);
        var form1 = $('#form_leave');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                select_multi: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                },
                lv_document: {
                    extension: "Invalid file type",
                },
                lv_start_date: {
                    remote: function(){ return message; }
                    //remote: "You have another leave on this range of date.",
                },
                lv_document: {
                    filesize: "less than 2MB"
                },
                lv_statement_letter: {
                    remote: "You already take Medical Leave with Statement Letter this month. You have to submit Medical Certificate. ",
                    filesize: "less than 2MB"
                },
            },
            rules: {
                lv_start_date: {
                    required: true,
                    remote: {
                        url: `${webUrl}eleave/leave/check_existing`,
                        type: "post",
                        data: {
                            half: function (element) {
                                return $('input[name=lv_half]:checked').val();
                            },
                            lv_end_date: function (element) {
                                return $('#lv_end_date').val();
                            },
                            lv_type: function (element) {
                                return $('#lv_type').val();
                            },
                            "_token": "<?=csrf_token()?>"
                        },
                        dataFilter: function(data) {
                            response = $.parseJSON(data);
                            if (response.status === true) return true;
                            else {
                                message = response.message;
                                return false;
                            }
                        },
                    }
                },
                lv_end_date: {
                    required: function (element) {
                        return $('input[name=lv_half]:checked').val() == "Full Day";
                    },
                    greaterThan: "#lv_start_date",
                },
                lv_detail: {
                    required: true
                },
                lv_document: {
                    fileUploadRequired: true,
//                    required: function (element) {
//                        return $("#lv_type").val() == "Medical Leave";
//                    },
                    extension: "jpg|png|jpeg|pdf",
                    filesize: 2097152
                },
                lv_statement_letter: {
                    fileUploadRequired: true,
                    extension: "jpg|png|jpeg|pdf",
                    filesize: 2097152,
//                    remote: {
//                        url: "{{ url('eleave/leave/check_existing_upload') }}",
//                        type: "post",
//                        data: {
//                            lv_start_date: function (element) {
//                                return $("#lv_start_date").val();
//                            },
//                            lv_end_date: function (element) {
//                                return $("#lv_end_date").val();
//                            },
//                            "_token": "<?=csrf_token()?>",
//                        },
//                    }
                },
//                lv_half: {
//                    required: true,
//                    remote: {
//                        url: `${webUrl}eleave/leave/check_existing`,
//                        type: "post",
//                        data: {
//                            half: function (element) {
//                                return $('input[name=lv_half]:checked').val();
//                            },
//                            lv_end_date: function (element) {
//                                return $('#lv_end_date').val();
//                            },
//                            lv_type: function (element) {
//                                return $('#lv_type').val();
//                            },
//                            "_token": "<?=csrf_token()?>"
//                        },
//                        dataFilter: function(response) {
//                            
//                            response = $.parseJSON(response);
//                            if (response.status === true) return true;
//                            else {
//                                message = response.message;
//                                return false;
//                            }
//                        },
//                    }
//                }, 
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                //App.scrollTo(error1, -200);
            },
            errorPlacement: function (error, element) { // render error placement for each input type
                //   error.appendTo($("div#errorContainer"));
                var cont = $(element).parent('.input-group');
                if (cont.size() > 0) {
                    cont.after(error);
                } else {
                    element.after(error);
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.err').addClass('has-error');
                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                        .closest('.err').removeClass('has-error');
                $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                
                if ($('#lv_type').val() == "Unpaid Leave"){
                    var tmp = null;
                    $.ajax({
                        async: false,
                        type: 'POST',
                        url: `${webUrl}eleave/leave/check_existing_same_date`,
                        dataType: 'json',
                        data: {
                            half: $('input[name=lv_half]:checked').val(),
                            lv_start_date: $('#lv_start_date').val(),
                            lv_end_date: $('#lv_end_date').val(),
                            lv_type: $('#lv_type').val(),
                            lv_half_time: $('#lv_half_time').val(),
                            "_token": "{{ csrf_token() }}"
                        },

                        success: function (data) {
                                if (data.status === true){
                                    tmp = data.status;
                                }else{
                                    tmp = data.status;
                                    alert(data.message);
                                }
                        },
                    });
                    return tmp;
                }else{
                    $('#btnSave').text('Saving...'); //change button text
                    $('#btnSave').attr('disabled', true); //set button disable 
                     //success1.show();
                    error1.hide();
                    return true;
                }
            }
        });
        jQuery.validator.addMethod("greaterThan",
                function (value, element, params) {
                    if (!/Invalid|NaN/.test(new Date(value))) {
                        if ($('input[name=lv_half]:checked').val() == "Full Day") {
                            return new Date(value) >= new Date($(params).val());
                        } else {
                            return true;
                        }
                    }

                    if ($('input[name=lv_half]:checked').val() == "Full Day") {
                        return isNaN(value) && isNaN($(params).val())
                                || (Number(value) >= Number($(params).val()));
                    } else {
                        return true;
                    }
                }, 'Must be greater than start date.');

        jQuery.validator.addMethod("fileUploadRequired",
                function (value, element, params) {
                    var type = $("#lv_type").val() === "Medical Leave";
                    if (type && ($("#lv_document").val() === "" && $("#lv_statement_letter").val() === "")) {
                        return false;
                    } else
                        return true;
                }, 'required file.');

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });
        
        if ($('#lv_type').val() == "Unpaid Leave"){
            $('input[name=lv_half]:checked').on('change', function() {
                var validator = $( "#form_leave" ).validate();
                validator.resetForm(); // <- force re-validation
            });
        }
    });

    $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
            clearBtn: true,
<?php if ($lv_type == "Annual Leave") {?>
        startDate: '<?=$data->min_date_picker?>',
<?php } else {?>
        startDate: '<?=$data->emergency_last_date?>',
<?php }?>
    endDate: '<?=$data->max_date_picker?>',
            autoclose: true,
            todayHighlight: true
    }
    );
<?php if ($lv_type == "Emergency Leave") {?>
        $('.datepicker_emergency').datepicker({
            format: 'yyyy-mm-dd',
            clearBtn: true,
            startDate: '<?=$data->emergency_last_date?>',
            endDate: '<?=$data->min_date_picker?>',
            autoclose: true,
            todayHighlight: true
        });
<?php }?>

    $('input[type=radio][name=lv_half]').change(function () {
        if (this.value == 'Full Day') {
            //$('#lv_end_date').val('');
            //$('#lv_end_date').prop('disabled', true);
            $('#lv_end_date_group').show('');
            $('#lv_half_time').attr('disabled', true);
        } else if (this.value == 'Half Day') {
            $('#lv_end_date').val('');
            //$('#lv_end_date').prop('disabled', true);
            $('#lv_end_date_group').hide('');
            $('#lv_half_time').attr('disabled', false);
        }
    });


</script>

@endsection