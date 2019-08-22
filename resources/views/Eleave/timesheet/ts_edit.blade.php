@extends('Eleave.layout.main')

@section('title','Eleave | Timesheet Edit')

@section('style')

@endsection

@section('content')

@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }} 
</div>
@endif

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>Timesheet Edit
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <?php if ($ts->ts_need_revision) {?>
            <div class="alert alert-warning">
                <strong>Need to be revised.</strong> <?php
                if ($ts->ts_revision_reason != "") {
                    echo "Message from " . $ts->user_name . " : " . $ts->ts_revision_reason;
                }
                ?>
            </div>
        <?php }?>
        <!-- BEGIN FORM-->
        <form action="{{ URL::to(env('APP_URL').'/eleave/timesheet/insert') }}" class="form-horizontal" enctype="multipart/form-data" method="post" id="form_timesheet">
            <input type="hidden" id="user_id" name="user_id" value="{{session('id')}}">
            <input type="hidden" id="employee_id" name="employee_id" value="{{session('id')}}">
            <input type="hidden" name="input_type" id="input_type" value="" >
            <div class="form-body">
                <!--                <div class="alert alert-danger display-hide" id="errorContainer">
                                    <button class="close" data-close="alert"></button>You have some form errors. Please check below.</div>-->
                <input type="hidden" name="ts_id" id="ts_id" value="<?=$ts->ts_id?>">
                <input type="hidden" name="ts_type" id="ts_type" value="<?=$ts->ts_type;?>">
                <div class="form-group">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                        <table class="table table-bordered table-hover" id="detailtable">
                            <thead>
                                <tr>
                                    <th width="15%">Date</th>
                                    <?php if ($ts->ts_type == "Timesheet") {?>
                                        <th id="th_time_in_group" width="15%">Time In</th>
                                        <th id="th_time_out_group" width="15%">Time Out</th>
                                        <th id="th_location_group" width="20%">Location</th>
                                    <?php }?>
                                    <th width="40%">Activity</th>
                                    <th width="2%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($ts->detail)) {
                                    $numb = 0;
                                    foreach ($ts->detail as $key => $value) {
                                        $numb++;
                                        ?>
                                        <tr id="baris<?=$numb;?>">
                                            <td>
                                                <div class="err">
                                                    <input type="text" value="<?=$value->detail_date;?>" class="form-control datepicker" placeholder="Enter date" name="ts_date[]" id="ts_date_<?=$numb;?>" autocomplete="off">
                                                </div>
                                            </td>
                                            <?php if ($ts->ts_type == "Timesheet") {?>
                                                <td id="ts_time_in_group_1">
                                                    <div class="input-group">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->time_in;?>" class="form-control timepicker timepicker-24" name="ts_time_in[]" id="ts_time_in_1" autocomplete="off">
                                                        </div>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td id="ts_time_out_group_1">
                                                    <div class="input-group">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->time_out;?>" class="form-control timepicker timepicker-24" name="ts_time_out[]" id="ts_time_out_1" maxlength="5" autocomplete="off">
                                                        </div>
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="err">
                                                        <input type="text" value="<?=$value->location;?>" name="ts_location[]" id="ts_location_1" class="form-control" placeholder="Enter location">
                                                    </div>
                                                </td>
                                            <?php }?>

                                            <td>
                                                <div class="err">
                                                    <textarea class="form-control" rows="3" style="height: 35px" placeholder="Enter activity" name="ts_activity[]" id="ts_activity_1" data-validation="required" maxlength="255"><?=$value->activity?></textarea>
                                                </div>
                                            </td>
                                            <td><a class="btn btn-xs red" onclick="delete_item(<?=$numb;?>)"><i class="glyphicon glyphicon-trash"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                            <button class="btn btn-success btn-xs addmore" type="button">+ Add More</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button id="btnSave" name="btnSave" value="btn_save" type="button" class="btn btn-circle green">Submit</button>
                        <button id="btnDraft" name="btnSave" value="btn_draft" type="button" class="btn btn-circle yellow">Save As Draft</button>
                        <!--                        <button type="reset" class="btn btn-circle grey-salsa btn-outline">Reset</button>-->
                        <a href="{{ URL::to('eleave/timesheet/index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
        <!-- END FORM-->
    </div>
</div>

@endsection

@section('script')
@include('Eleave/notification')
<script type="text/javascript">
    $(document).ready(function () {
        var form1 = $('#form_timesheet');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        $.validator.addMethod("time24", function (value, element) {
            return /^([01]?[0-9]|2[0-3])(:[0-5][0-9]){2}$/.test(value);
        }, "Invalid time format.");

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
                'ts_date[]': {
                    required: "<font color='red'>Date required.</font>",
                    //remote: "You have another timesheet at the same date.",
                },
                'ts_time_in[]': {
                    required: "<font color='red'>required.</font",
                },
                'ts_time_out[]': {
                    required: "<font color='red'>required.</font",
                },
                'ts_location[]': {
                    required: "<font color='red'>Location required.</font",
                },
                'ts_activity[]': {
                    required: "<font color='red'>Activity required.</font",
                },
            },
            rules: {
                "ts_date[]": {
                    required: true,
//                    remote: {
//                        url: "{{ url('eleave/timesheet/check_existing') }}",
//                        type: "post",
//                        data: {
//                            employee_id: function (element) {
//                                return $('#employee_id').val();
//                            },
//                            ts_id: function (element) {
//                                return $('#ts_id').val();
//                            },
//                            "_token": "<?=csrf_token()?>"
//                        },
//                    }
                },
                "ts_time_in[]": {
                    required: true,
                    //   time24: true
                },
                "ts_time_out[]": {
                    required: true,
                },
                "ts_location[]": {
                    required: true
                },
                "ts_activity[]": {
                    required: true
                },

            },

            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                //App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                //error.appendTo($("div#errorContainer"));
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
//                $(element)
//                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                        .closest('.err').removeClass('has-error');
//                $(element)
//                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                //$('#btnSave').text('Saving...'); //change button text
                //$('#btnSave').attr('disabled', true); //set button disable 
                //success1.show();
                NProgress.start();
                var interval = setInterval(function () {
                    NProgress.inc();
                }, 10);

                jQuery(window).load(function () {
                    clearInterval(interval);
                    NProgress.done();
                });
                error1.hide();

                return true;
            }
        });

        setdatepicker();
        settimepicker();

        //adds extra table rows
        var i = $('#detailtable tr').length;
        var j = $('#detailtable tr').length - 1;
        $(".addmore").on('click', function () {

            var lastRow = $('input[name*="ts_date[]"]').length;
            var ts_date = $('#ts_date_' + lastRow);
            var exist = false;
            for (a = 1; a < lastRow; a++) {

                var dt = $('#ts_date_' + a);
                //alert(dt.val());
                if (dt.val() == ts_date.val())
                {
                    alert("Date Already Exist!");
                    ts_date.select();
                    var exist = true;
                    break;
                }
            }

            if (exist != true) {
                html = '<tr id="baris' + i + '">';
                //html += '<td><input type="checkbox"/></td>';
                html += '<td><div class="err"><input type="text" class="form-control datepicker" placeholder="Enter date" name="ts_date[]" id="ts_date_' + i + '" autocomplete="off"></div></td>';
                if ($('#ts_type').val() == "Timesheet") {
                    html += '<td id="ts_time_in_group_' + i + '"><div class="input-group"><div class="err"><input type="text" class="form-control timepicker timepicker-24" name="ts_time_in[]" id="ts_time_in_' + i + '" maxlength="5" autocomplete="off"></div><span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span></div></td>';
                    html += '<td id="ts_time_out_group_' + i + '"><div class="input-group"><div class="err"><input type="text" class="form-control timepicker timepicker-24" name="ts_time_out[]" id="ts_time_out_' + i + '" maxlength="5" autocomplete="off"></div><span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span></div></td>';
                    html += '<td id="ts_location_group_' + i + '"><div class="err"><input type="text" name="ts_location[]" id="ts_location_' + i + '" class="form-control" placeholder="Enter location" value=""></div></td>';
                }
                html += '<td><div class="err"><textarea class="form-control" rows="3" style="height: 35px" placeholder="Enter activity" name="ts_activity[]" id="ts_activity_' + i + '" data-validation="required" data-validation-error-msg=""Activity" is required." maxlength="255"></textarea></div></td>';
                html += '<td><a class="btn btn-xs red" onclick="delete_item(' + i + ')"><i class="glyphicon glyphicon-trash"></i></a></td>';
                html += '</tr>';
                $('#detailtable').append(html);
                // $('#ts_date_' + i).focus();
                setdatepicker();
                settimepicker();
                i++;
            }
            $('input[name*="ts_date[]"]').each(function (j) {
                var j = j + 1;
                $(this).attr('id', 'ts_date_' + j);
            });

        });
    });

    $("#btnSave").click(function () {
        $('#input_type').val('btn_save');
        if (!$("#form_timesheet").validate()) { // Not Valid
            return false;
        } else {
            var ts_date = $("input[name='ts_date[]']")
                    .map(function () {
                        return $(this).val();
                    }).get();
            // cek duplicate date
            $.ajax({
                url: `${webUrl}eleave/timesheet/check_existing`,
                type: "post",
                data: {
                    "employee_id": $('#employee_id').val(),
                    "ts_date": ts_date,
                    "ts_id": $('#ts_id').val(),
                    "_token": "<?=csrf_token()?>"
                },
                dataType: "JSON",
                success: function (response)
                {
                    var lastRows = document.getElementsByName("ts_date[]").length;
                    if (response.status == false) {
                        toastr.error(response.date_exist + ' You have another timesheet at the same date.');
                        return false;
                    } else {
                        var lastRow = $('input[name*="ts_date[]"]').length;
                        var ts_date = $('#ts_date_' + lastRow);

                        for (a = 1; a < lastRow; a++) {
                            var dt = $('#ts_date_' + a);
                            if (dt.val() == ts_date.val())
                            {
                                alert("Date Already Exist!");
                                ts_date.select();
                                return false;
                            }
                        }

                        if ($('#ts_type').val() != "Absent") {
                            for (index = 0; index < lastRows; index++) {
                                masuk = document.getElementsByName("ts_time_in[]");
                                keluar = document.getElementsByName("ts_time_out[]");
                                temp_in = masuk[index].id;
                                temp_out = keluar[index].id;
                                //  indexs = temp.substr(7, temp.length - 7);
                                //alert(index)
                                var startTime = $('#' + temp_in + '').val();
                                var endTime = $('#' + temp_out + '').val();
                                var end_time = $('#' + temp_out + '');

                                st = minFromMidnight(startTime);
                                et = minFromMidnight(endTime);
                                if (st > et) {
                                    alert("End time must be greater than start time");
                                    end_time.closest('.err').addClass('has-error');
                                    return false;
                                }
                            }
                            end_time.closest('.err').removeClass('has-error');
                        }
                        $('#form_timesheet').submit();
                    }
                },
            });
        }
    });

    $("#btnDraft").click(function () {
        $('#input_type').val('btn_draft');
        if (!$("#form_timesheet").validate()) { // Not Valid
            return false;
        } else {
            var ts_date = $("input[name='ts_date[]']")
                    .map(function () {
                        return $(this).val();
                    }).get();
            // cek duplicate date
            $.ajax({
                url: `${webUrl}eleave/timesheet/check_existing`,
                type: "post",
                data: {
                    "employee_id": $('#employee_id').val(),
                    "ts_date": ts_date,
                    "ts_id": $('#ts_id').val(),
                    "_token": "<?=csrf_token()?>"
                },
                dataType: "JSON",
                success: function (response)
                {
                    var lastRows = document.getElementsByName("ts_date[]").length;
                    if (response.status == false) {
                        toastr.error(response.date_exist + ' You have another timesheet at the same date.');
                        return false;
                    } else {
                        var lastRow = $('input[name*="ts_date[]"]').length;
                        var ts_date = $('#ts_date_' + lastRow);

                        for (a = 1; a < lastRow; a++) {
                            var dt = $('#ts_date_' + a);
                            if (dt.val() == ts_date.val())
                            {
                                alert("Date Already Exist!");
                                ts_date.select();
                                return false;
                            }
                        }

                        if ($('#ts_type').val() != "Absent") {
                            for (index = 0; index < lastRows; index++) {
                                masuk = document.getElementsByName("ts_time_in[]");
                                keluar = document.getElementsByName("ts_time_out[]");
                                temp_in = masuk[index].id;
                                temp_out = keluar[index].id;
                                //  indexs = temp.substr(7, temp.length - 7);
                                //alert(index)
                                var startTime = $('#' + temp_in + '').val();
                                var endTime = $('#' + temp_out + '').val();
                                var end_time = $('#' + temp_out + '');

                                st = minFromMidnight(startTime);
                                et = minFromMidnight(endTime);
                                if (st > et) {
                                    alert("End time must be greater than start time");
                                    end_time.closest('.err').addClass('has-error');
                                    return false;
                                }
                            }
                            end_time.closest('.err').removeClass('has-error');
                        }
                        $('#form_timesheet').submit();
                    }
                },
            });
        }
    });

    function minFromMidnight(tm) {
        var ampm = tm.substr(-2)
        var clk = tm.substr(0, 5);
        var m = parseInt(clk.match(/\d+$/)[0], 10);
        var h = parseInt(clk.match(/^\d+/)[0], 10);
        h += (ampm.match(/pm/i)) ? 12 : 0;
        return h * 60 + m;
    }

    function setdatepicker() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            clearBtn: true,
            //forceParse: false,
            //calendarWeeks: true,
            //startView: 2,
            autoclose: true,
            todayHighlight: true,
            //  endDate: "1m"
        });
    }

    function settimepicker() {
        $('.timepicker').timepicker({
            // defaultTime: '',
            minuteStep: 5,
            //disableFocus: true,
            //template: 'dropdown',
            showMeridian: false
        });
    }

    function delete_item(rows) {
        var tbl = $('#detailtable tr').length - 1;
        if (confirm('Are you sure delete ?'))
        {
            if (tbl == 1) {
                alert("Must be at least 1 rows!");
                return false;
            } else {
                $('table#detailtable tr#baris' + rows).remove();
                $('input[name*="ts_date[]"]').each(function (i) {
                    var i = i + 1;
                    $(this).attr('id', 'ts_date_' + i);
                });
            }
        }
    }
</script>

@endsection