@extends('Eleave.layout.main')

@section('title','Eleave | Timesheet Add')

@section('style')

@endsection

@section('content')

@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }} 
</div>
@endif
<div>
    <span id="StartErrorMsg" class="errmessage" ></span>
    <span id="EndErrorMsg" class="errmessage" ></span>
    <span id="errorMsg" class="errmessage" ></span>
</div>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>Timesheet List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <!-- BEGIN FORM-->
        <form action="{{ URL::to(env('APP_URL').'/eleave/timesheet/insert') }}" class="form-horizontal" enctype="multipart/form-data" method="post" id="form_timesheet">
            <div class="form-body">
                <!--                <div class="alert alert-danger display-hide" id="errorContainer">
                                    <button class="close" data-close="alert"></button> 
                                    You have some form errors. Please check below. </div>-->
                <div id='errorbox'></div>
                <input type="hidden" name="employee_id" id="employee_id" value="{{session('id')}}" >
                <input type="hidden" name="input_type" id="input_type" value="" >
                <div class="form-group">
                    <label class="col-md-3 control-label">Type</label>
                    <div class="col-md-4">
                        <select class="form-control" name="ts_type" id="select_type">
                            <!--<option value="">-- Choose Type --</option>-->
                            <option value="Timesheet">Timesheet</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="file_group" style="display:none;">
                    <label class="control-label col-md-3">Attach Supporting Document</label>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn green btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" name="ts_file" id="ts_file"> </span>
                            <span class="fileinput-filename"> </span> &nbsp;
                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                        <table class="table table-bordered" id="detailtable">
                            <thead>
                                <tr>
                                    <th width="15%">Date</th>
                                    <th id="th_time_in_group" width="15%">Time In</th>
                                    <th id="th_time_out_group" width="15%">Time Out</th>
                                    <th id="th_location_group" width="20%">Location</th>
                                    <th width="40%">Activity</th>
                                    <th width="2%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="baris1">
                                    <td>
                                        <div class="err"><input type="text" class="form-control datepicker row-id" placeholder="Enter date" name="ts_date[]" id="ts_date_1" autocomplete="off"></div>
                                    </td>
                                    <td id="ts_time_in_group_1">
                                        <div class="input-group err">
                                            <input type="text" class="form-control timepicker timepicker-24" name="ts_time_in[]" id="ts_time_in_1" maxlength="5" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-clock-o"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </td>
                                    <td id="ts_time_out_group_1">
                                        <div class="input-group err">
                                            <input type="text" class="form-control timepicker timepicker-24 EndTimeSlot" name="ts_time_out[]" id="ts_time_out_1" maxlength="5" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-clock-o"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </td>
                                    <td id="ts_location_group_1">
                                        <div class="err">
                                            <input type="text" name="ts_location[]" id="ts_location_1" class="form-control" placeholder="Enter location" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="err">
                                            <textarea class="form-control" rows="3" style="height: 35px" placeholder="Enter activity" name="ts_activity[]" id="ts_activity_1" maxlength="255"></textarea>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
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
                    remote: "You have another timesheet at the same date.",
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
                'ts_file': {
                    extension: "Invalid file type",
                    filesize: "less than 2MB"
                }
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
//                            ts_dates: function (element) {
//                                return $("input[name='ts_date[]']")
//                                        .map(function () {
//                                            return $(this).val();
//                                        }).get();
//                            },
//                            "_token": "<?=csrf_token()?>"
//                        },
//                        success: function (response)
//                        {
//                            if (response == false) {
//                                alert('duplicate date')
//                            }
//                            return true;
//                        },
//                    }
                },
                "ts_time_in[]": {
                    required: true,
                    //time24: true
                },
                "ts_time_out[]": {
                    required: true,
                },
                "ts_location[]": {
                    required: function (element) {
                        return $("#select_type").val() == "Timesheet";
                    }
                },
                "ts_activity[]": {
                    required: true
                },
                "ts_file": {
                    required: function (element) {
                        return $("#select_type").val() == "Absent";
                    },
                    filesize: 2097152,
                    extension: "jpg|png|jpeg|pdf",
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
//                    if (element.attr("name") == "ts_date[]") {
//                        error.appendTo($('#errorbox'));
//                    } else {
                    element.after(error);
//                        error.appendTo( element.parent().next() );
//                    }
                }

//                if (element.attr("name") == "ts_date[]") {
//                    toastr.success('erro date');
//                } else {
//                    error.insertAfter(element);
//                }
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
                $('#btnSave').text('Saving...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 
                //success1.show();
                error1.hide();

                NProgress.start();
                var interval = setInterval(function () {
                    NProgress.inc();
                }, 10);

                jQuery(window).load(function () {
                    clearInterval(interval);
                    NProgress.done();
                });

                return true;
            }
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });

        setdatepicker();
        settimepicker();

        var lastRow = $('#detailtable tr').length + 2;
        $('#select_type').on('change', function () {
            if (this.value == "Absent") {

                $('#ts_time_in').prop('disabled', true);
                $('#th_time_in_group').hide('');
                $('#th_time_out_group').hide('');
                $('#th_location_group').hide('');
                for (var i = 1; i < lastRow; i++) {
                    $('#ts_time_in_group_' + i).hide('');
                    $('#ts_time_out_group_' + i).hide('');
                    $('#ts_location_group_' + i).hide('');
//                    $('#ts_time_in_' + i).val('');
//                    $('#ts_time_out_' + i).val('');
                    $('#ts_location_' + i).val('');
                }

                $('#ts_time_out').prop('disabled', true);
                $('#file_group').show();
                $('#ts_file').prop('disabled', false);
            } else {

                $('#th_time_in_group').show('');
                $('#th_time_out_group').show('');
                $('#th_location_group').show('');
                $('#ts_time_in').prop('disabled', false);
                $('#ts_time_out').prop('disabled', false);
                for (var i = 1; i < lastRow; i++) {
                    $('#ts_time_in_group_' + i).show('');
                    $('#ts_time_out_group_' + i).show('');
                    $('#ts_location_group_' + i).show('');
                }

                $('#ts_file').prop('disabled', true);
                $('#file_group').hide();
            }

        });
        //adds extra table rows
        var i = $('#detailtable tr').length;
        var j = $('#detailtable tr').length - 1;
        $(".addmore").on('click', function () {
            var lastRow = $('input[name*="ts_date[]"]').length;
            var ts_date = $('#ts_date_' + lastRow);
            var exist = false;
            for (a = 1; a < lastRow; a++) {
//                if (a == j) {
//                    a = a + 1;
//                }
//                if (a == i) {
//                    break;
//                }
                var dt = $('#ts_date_' + a);
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
                html += '<td><div class="err"><input type="text" class="form-control datepicker row-id" placeholder="Enter date" name="ts_date[]" id="ts_date_' + i + '" autocomplete="off"></div></td>';
                if ($('#select_type').val() == "Timesheet") {
                    html += '<td id="ts_time_in_group_' + i + '"><div class="input-group err"><input type="text" class="form-control timepicker timepicker-24" name="ts_time_in[]" id="ts_time_in_' + i + '" maxlength="5" autocomplete="off"><span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span></div></td>';
                    html += '<td id="ts_time_out_group_' + i + '"><div class="input-group err"><input type="text" class="form-control timepicker timepicker-24 EndTimeSlot" name="ts_time_out[]" id="ts_time_out_' + i + '" maxlength="5" autocomplete="off"><span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span></div></td>';
                    html += '<td id="ts_location_group_' + i + '"><div class="err"><input type="text" name="ts_location[]" id="ts_location_' + i + '" class="form-control" placeholder="Enter location" value=""></div></td>';
                }
                html += '<td><div class="err"><textarea class="form-control" rows="3" style="height: 35px" placeholder="Enter activity" name="ts_activity[]" id="ts_activity_' + i + '" maxlength="255"></textarea></div></td>';
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
            //   j++;
            //}
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
                            $('#form_timesheet').submit();
                        }
                    },
                });
            }
        });


        // $('.EndTimeSlot').timepicker().on('hide.timepicker', function (tess()) {

    });

    // $('.EndTimeSlot').timepicker().on('hide.timepicker', function () {

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
            // endDate: "1m"
        });
    }

    function settimepicker() {
        $('.timepicker').timepicker({
            // defaultTime: '',
            minuteStep: 5,
            //disableFocus: true,
            //template: 'dropdown',
            showMeridian: false,
        });
    }

    function delete_item(rows) {
        if (confirm('Are you sure delete ?'))
        {
            $('table#detailtable tr#baris' + rows).remove();
            $('input[name*="ts_date[]"]').each(function (i) {
                var i = i + 1;
                $(this).attr('id', 'ts_date_' + i);
            });
        }
    }


</script>

@endsection