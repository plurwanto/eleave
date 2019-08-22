@extends('Eleave.layout.main')

@section('title','Eleave | Leave Update')

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
                <i class="fa fa-clock-o"></i>Edit Leave Form
            </div>
            <div class="tools"></div>
        </div>
        <div class="portlet-body form">
            <?php if ($lv->lv_need_revision) {?>
                <div class="alert alert-warning">
                    <strong>Need to be revised.</strong> <?php
                    if ($lv->lv_revision_reason != "") {
                        echo "Message from " . $lv->user_name . " : " . $lv->lv_revision_reason;
                    }
                    ?>
                </div>
            <?php }?>
            <input type="hidden" id="user_id" name="user_id" value="{{session('id')}}">
            <!-- BEGIN FORM-->
            <form action="{{ url('eleave/leave/insert') }}" class="form-horizontal" enctype="multipart/form-data" method="post" id="form_leave">
                <input type="hidden" name="lv_act" value="lv_edit"/>
                <input type="hidden" name="lv_id" value="<?=$lv->lv_id?>"/>
                <input type="hidden" name="lv_type" id="lv_type" value="<?=$lv_type;?>"/>
                <?php if ($lv->lv_type != "Medical Leave" && $lv->lv_type != "Unpaid Leave") {?>
                    <input type="hidden" name="max_leave" value="<?=$data->take?>"/>
                <?php }?>
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Leave Type</label>
                        <div class="col-md-4" style="margin-top: 8px;">
                            <?=$lv->lv_type?>
                            <?php if ($lv->lv_type == "Annual Leave" && $lv->lv_is_emergency != "") {?>
                                - [Emergency]
                            <?php }?>
                        </div>
                    </div>
                    <?php if ($lv->lv_type == "Annual Leave" || $lv->lv_type == "Unpaid Leave") {?>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Full Day/Half Day</label>
                            <div class="col-md-4">
                                <div class="radio-list">
                                    <label>
                                        <input type="radio" name="lv_half" id="full" value="Full Day" <?php if ($lv->lv_half == "Full Day") {?>checked<?php }?>> Full Day</label>
                                    <label>
                                        <input type="radio" name="lv_half" id="half" value="Half Day" <?php if ($lv->lv_half == "Half Day") {?>checked<?php }?>> Half Day</label>
                                </div>
                            </div>															
                        </div>
                    <?php }?>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Start Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control datepicker" placeholder="Enter start date" name="lv_start_date" data-validation="date" data-validation-format="yyyy-mm-dd" data-validation-error-msg="'Start Date' is required." value="<?=$lv->lv_start_date?>" autocomplete="off">
                        </div>
                    </div>

                    <?php if ($lv->lv_type != "Annual Leave") {?>
                        <div class="form-group" id="lv_end_date_group">
                            <label class="col-md-3 control-label">End Date</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control datepicker" placeholder="Enter end date" name="lv_end_date" id="lv_end_date" data-validation="date" data-validation-format="yyyy-mm-dd" data-validation-error-msg="'End Date' is required." value="<?=$lv->lv_end_date?>" autocomplete="off">
                            </div>
                        </div>
                        <?php
                    } else {
                        if ($lv->lv_type == "Annual Leave") {
                            ?>
                            <?php if ($lv->lv_half == "Full Day") {?>
                                <div class="form-group" id="lv_end_date_group">
                                <?php } else {?>
                                    <div class="form-group" id="lv_end_date_group" style="display:none;">
                                    <?php }?>
                                    <label class="col-md-3 control-label">End Date</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control datepicker" placeholder="Enter end date" name="lv_end_date" id="lv_end_date" data-validation="date" data-validation-format="yyyy-mm-dd" data-validation-error-msg="'End Date' is required." value="<?=$lv->lv_end_date?>">
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

                        <?php if ($lv->lv_type == "Compassionate Leave" || $lv->lv_type == "Paternity Leave" || $lv->lv_type == "Maternity Leave" || $lv->lv_type == "Marriage Leave" || $lv->lv_type == "Medical Leave" || $lv->lv_type == "Annual Leave" || $lv->lv_type == "Study Leave" || $lv->lv_type == "Unpaid Leave") {?>
                            <div class="form-group" id="file_group">
                                <label class="control-label col-md-3">Detail</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" rows="3" placeholder="Enter detail" name="lv_detail" data-validation="required" data-validation-error-msg="'Detail' is required." maxlength="255"><?=$lv->lv_detail?></textarea>
                                </div>
                            </div>

                            <?php if (session('branch_id') == 2 && $lv->lv_type == "Medical Leave") {?>
                                <!-- Medical Certificate -->
                                <div class="form-group" id="file_group">
                                    <label class="control-label col-md-3">Attach Medical Certificate</label>
                                    <div class="col-md-4">
                                        <?php if ($lv->lv_document != "") {?>
                                            <input type="hidden" id="doc_existing" name="doc_existing" value="<?=$lv->lv_document;?>">
                                            <div><a href="{{ url($lv->lv_document) }}" target="_blank">Click To View Medical Certificate</a></div><br>
                                        <?php }?>																
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn green btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="lv_document" id="lv_document" data-validation="size required extension" data-validation-max-size="1M" data-validation-allowing="jpg, png, pdf, doc, docx" data-validation-error-msg="'Medical Certificate' should be one of jpg, jpeg, png, pdf, doc, or docx." data-validation-optional="true"> </span>
                                            <span class="fileinput-filename"> </span> &nbsp;
                                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Statement Letter -->
                                <div class="form-group" id="file_group">
                                    <label class="control-label col-md-3">Attach Statement Letter</label>
                                    <div class="col-md-4">
                                        <?php if ($lv->lv_statement_letter != "") {?>
                                            <input type="hidden" id="letter_existing" name="letter_existing" value="<?=$lv->lv_statement_letter;?>">
                                            <div><a href="{{ url($lv->lv_statement_letter) }}" target="_blank">Click To View Statement Letter</a></div><br>
                                        <?php }?>																
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn green btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="lv_statement_letter" id="lv_statement_letter" data-validation="size required extension" data-validation-max-size="1M" data-validation-allowing="jpg, png, pdf, doc, docx" data-validation-error-msg="'Statement Letter' should be one of jpg, jpeg, png, pdf, doc, or docx." data-validation-optional="true"> </span>
                                            <span class="fileinput-filename"> </span> &nbsp;
                                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="form-group" id="file_group">
                                    <label class="control-label col-md-3">Attach Support Document</label>
                                    <div class="col-md-4">
                                        <?php if ($lv->lv_document != "") {?>
                                            <div><a href="{{ url($lv->lv_document) }}" target="_blank">Click To View Document</a></div><br>
                                        <?php }?>																
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn green btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="lv_document" id="lv_document" data-validation="size required extension" data-validation-max-size="1M" data-validation-allowing="jpg, png, pdf, doc, docx" data-validation-error-msg="'Support Document' is required and should be one of jpg, jpeg, png, pdf, doc, or docx." data-validation-optional="true"> </span>
                                            <span class="fileinput-filename"> </span> &nbsp;
                                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        <?php }?>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green">Submit</button>
                                <a href="{{ URL::to('eleave/leave/index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
            </form>
            <!-- END FORM-->

        </div>

    </div>
    </div>
<?php } else {?>
    <div class="alert alert-warning"><?=$data->message;?></div>
<?php }?>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
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
                    remote: "You have another leave on this range of date.",
                },
                lv_statement_letter: {
                    remote: "You already take Medical Leave with Statement Letter this month. You have to submit Medical Certificate. ",
                },
            },
            rules: {
                lv_start_date: {
                    required: true,
//                    remote: {
//                        url: "{{ url('eleave/leave/check_existing') }}",
//                        type: "post",
//                        data: {
//                            lv_id: function (element) {
//                                return $('input[name=lv_id]').val();
//                            },
//                            half: function (element) {
//                                return $('input[name=lv_half]:checked').val();
//                            },
//                            lv_end_date: function (element) {
//                                return $('#lv_end_date').val();
//                            },
//                            "_token": "<?=csrf_token()?>"
//                        },
//                    }
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
                    extension: "jpg|png|jpeg|pdf"
                },
                lv_statement_letter: {
                    //fileUploadRequired: true,
                    extension: "jpg|png|jpeg|pdf",
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
                $('#btnSave').text('Saving...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 
                //success1.show();
                error1.hide();
                return true;
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
                    var doc_existing = $("#doc_existing").val();
                    if (empty(doc_existing)) {
                        if (type && ($("#lv_document").val() === "" && $("#lv_statement_letter").val() === "")) {
                            return false;
                        } else
                            return true;
                    }
                }, 'required file.');
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
        } else if (this.value == 'Half Day') {
            $('#lv_end_date').val('');
            //$('#lv_end_date').prop('disabled', true);
            $('#lv_end_date_group').hide('');
        }
    });


</script>

@endsection