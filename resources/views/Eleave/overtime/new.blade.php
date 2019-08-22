@extends('Eleave.layout.main')

@section('title','Eleave | UserLevel Add')

@section('content')
@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }} 
</div>
@endif
<input type="hidden" id="open_date" name="open_date" value="{{ $allow_access }}">
<input type="hidden" id="user_id" name="user_id" value="{{session('id')}}">
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>Overtime List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body form">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">

            <form action="{{ URL::to(env('APP_URL').'/eleave/overtime/save') }}" class="" method="POST" id="form_input">
                <div class="form-body">
                    <!--                    <div class="alert alert-danger display-hide" id="errorbox">
                                            <button class="close" data-close="alert"></button>  </div>-->
                    <input type="hidden" name="employee_id" id="employee_id" value="{{session('id')}}" >
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">DESCRIPTION OF OVERTIME</th>
                            </tr>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="15%">Time (From)</th>
                                <th width="15%">Time (To)</th>
                                <th width="40%">Description of the tasks to be performed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="err">
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" placeholder="Enter date" name="ot_date" id="ot_date" autocomplete="off">
                                            <label class="input-group-addon" for="ot_date">
                                                <i class="fa fa-calendar"></i>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker timepicker-24 Time1" name="ot_time_in" id="ot_time_in" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group err">
                                        <input type="text" class="form-control timepicker timepicker-24 Time2" name="ot_time_out" id="ot_time_out" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td nowrap>
                                    <div class="err">
                                        <input type="text" class="form-control" placeholder="Enter description" name="ot_description">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <textarea name="ot_reason" class="form-control input-sm" rows="3"></textarea>
                        <label for="form_control_1">The reason(s) why the work cannot be completed during regular work hours</label>
                    </div>
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <textarea name="ot_impact" class="form-control input-sm" rows="3"></textarea>
                        <label for="form_control_2">The negative impact as a result of the inability to perform tasks or provide services</label>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-circle green" id="btnSave"><i class="fa fa-save"></i> Submit</button>
                            <a href="{{ URL::to('eleave/overtime/index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>
        </div>

    </div>
</div>
@endsection

@section('script')
@include('Eleave/notification')
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'moment.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    var form1 = $('#form_input');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);

    jQuery.validator.addMethod("noSpace", function (value, element) {
        return value.indexOf("  ") < 0 && value != "";
    }, "No space please and don't leave it empty");

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
            ot_date: {
                remote: "You have another overtime at the same date.",
            },
            ot_reason: {
                minlength: 'Min 2 charather'
            }
        },
        rules: {
            ot_date: {
                required: true,
                remote: {
                    url: `${webUrl}eleave/overtime/check_existing`,
                    type: "post",
                    data: {
                        employee_id: function (element) {
                            return $('#employee_id').val();
                        },
                        "_token": "<?=csrf_token()?>"
                    },
                }
            },
            ot_time_in: {
                required: true
            },
            ot_time_out: {
                required: true
            },
            ot_description: {
                required: true,
                noSpace: true
            },
            ot_reason: {
                required: true,
                minlength: 2
            },
            ot_impact: {
                required: true,
                minlength: 2
            },
        },

        invalidHandler: function (event, validator) { //display error alert on form submit              
            success1.hide();
            error1.show();
            //App.scrollTo(error1, -200);
        },

        errorPlacement: function (error, element) { // render error placement for each input type
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

    document.getElementById('ot_time_out').value = "";
    setdatepicker();
    settimepicker();

    $("#btnSave").click(function () {
        var lastRow = $('input[name*="ts_date[]"]').length;
        var ts_date = $('#ts_date_' + lastRow);
        // var exist = false;
        for (a = 1; a < lastRow; a++) {
            var dt = $('#ts_date_' + a);
            if (dt.val() == ts_date.val())
            {
                alert("Date Already Exist!");
                ts_date.select();
                return false;
            }
        }

    });
    
     $('#ot_time_in').timepicker().on('hide.timepicker', function (e) {
        var user_id = $('#user_id').val();
        startTime = $('#ot_time_in').val();
        endTime = $('#ot_time_out').val();

        st = minFromMidnight(startTime);
        et = minFromMidnight(endTime);
        if (user_id == '84') {
            var hours = parseInt($(".Time2").val().split(':')[0], 10) - parseInt('17:30'.split(':')[0], 10);
            if (hours < 0) {
                hours = 24 + hours;
                if (hours > 12) { //17:30 - 5:59 pagi (12 hours)
                    alert("End time must be greater than start time");
                    $('#ot_time_out').val('');
                }
            }
        } else {
            if (st >= et) {
                alert("End time must be greater than start time");
                $('#ot_time_out').val('');
            }
        }
    });

    $('#ot_time_out').timepicker().on('hide.timepicker', function (e) {
        var user_id = $('#user_id').val();
        startTime = $('#ot_time_in').val();
        endTime = $('#ot_time_out').val();

        st = minFromMidnight(startTime);
        et = minFromMidnight(endTime);
        if (user_id == '84') {
            var hours = parseInt($(".Time2").val().split(':')[0], 10) - parseInt('17:30'.split(':')[0], 10);
            if (hours < 0) {
                hours = 24 + hours;
                if (hours > 12) { //17:30 - 5:59 pagi (12 hours)
                    alert("End time must be greater than start time");
                    $('#ot_time_out').val('');
                }
            }
        } else {
            if (st >= et) {
                alert("End time must be greater than start time");
                $('#ot_time_out').val('');
            }
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

});


function setdatepicker() {
    var open_access = $('#open_date').val();
    var currentDate = new Date; // get current date
    var first = currentDate.getDate() - currentDate.getDay() + 1; // First day is the day of the month - the day of the week
    var last = first + 6; // last day is the first day + 7
    var firstday = new Date(currentDate.setDate(first));

    if (new Date().getDay() == 1) { //patokannya senin yee..!!
        var last = first - 1;
        var lastday = new Date(currentDate.setDate(last));
        var arrLength = 1;
        // alert(lastday);
    }
    if (new Date().getDay() == 2) {
        var last = first - 1;
        var lastday = new Date(currentDate.setDate(last));
        var arrLength = 2;
        // alert(lastday);
    }
    if (new Date().getDay() == 3) {
        var last = first - 1;
        var lastday = new Date(currentDate.setDate(last));
        var arrLength = 3;
        // alert(lastday);
    } else {
        var arrLength = 8;
        var last = first - 6;
        var lastday = new Date(currentDate.setDate(last));
    }

    var last_submit = [];
    var i = 0;
    for (i = 0; i < arrLength; i++) {
        last_submit[i] = moment(lastday.setDate(lastday.getDate() + 1)).format('YYYY-MM-DD');
        last_submit.push(i);
    }

    // alert(last_submit)
    $.ajax({
        url: `${webUrl}eleave/overtime/check_holiday`,
        type: "POST",
        dataType: "JSON",
        data: {rows: last_submit, "_token": "<?=csrf_token()?>"},
        success: function (response)
        {
            var endDate = '0';
            var tot_hol = response.length;
            //alert(tot_hol);
            if (open_access == 1) {
                var currentDate = new Date().getDay();
                var firstday = '-60d';
                var endDate = '-1d';// + currentDate + 'd';
            } else {
                if (response.length < 1) {  // cek jika ada tanggal libur di calendar
                    var currentDate = new Date;
                    var first = currentDate.getDate() - currentDate.getDay() + 1;
                    if (new Date().getDay() == 1) {
                        if (open_access == 1) {
                            var firstday = '-60d';
                        } else {
                            var firstday = '-7d';
                        }
                    } else {
                        if (open_access == 1) {
                            var firstday = '-60d';
                        } else {
                            var firstday = new Date(currentDate.setDate(first));
                        }
                    }

                } else {
                    var currentDate = new Date; // get current date
                    // var last = first + 7; // last day is the first day + 7
                    if (new Date().getDay() == 1) {
                        var first = 6 + tot_hol;
                        var firstday = '-' + first + 'd';
                        var last_tot_hol = tot_hol;
                        var endDate = '-' + last_tot_hol + 'd';
                    } else if (new Date().getDay() == 2) {
                        var first = 7 + tot_hol;
                        var firstday = '-' + first + 'd';
                        var last_tot_hol = tot_hol + 1;
                        var endDate = '-' + last_tot_hol + 'd';
                    } else if (new Date().getDay() == 3 && tot_hol >= 2) {

                        var first = 7 + tot_hol;
                        var firstday = '-' + first + 'd';
                        var last_tot_hol = tot_hol + 1;
                        var endDate = '-' + last_tot_hol + 'd';
                    } else if (new Date().getDay() == 4 && tot_hol >= 3) {
                        var first = 7 + tot_hol;
                        var firstday = '-' + first + 'd';
                        var last_tot_hol = tot_hol + 1;
                        var endDate = '-' + last_tot_hol + 'd';
                    } else {
                        let holiday_date = '';
                        for (var i = 0; i < tot_hol; i++) {
                            var currentDate = new Date;
                            holiday_date = new Date(response[i]['hol_date'])
                            //alert(holiday_date);
                        }
                        if (new Date().getDay() == 1) {
                            var hol_day = moment(holiday_date.setDate(holiday_date.getDate() + 1)).format('YYYY-MM-DD');
                        } else {
                            var hol_day = moment(holiday_date.setDate(holiday_date.getDate())).format('YYYY-MM-DD');
                        }
                        var today_date = moment(currentDate.setDate(currentDate.getDate())).format('YYYY-MM-DD')
                        //alert(today_date);
                        if (today_date == hol_day) {
                            var first = 7 - tot_hol;
                            var firstday = '-' + first + 'w';
                            var last_tot_hol = tot_hol + 1;
                            var endDate = '-' + last_tot_hol + 'd';
                        } else {

                            var currentDate = new Date;
                            var first = currentDate.getDate() - currentDate.getDay() + 1;
                            var firstday = new Date(currentDate.setDate(first));
                        }

                    }
                }
            }
            //alert(firstday);
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                clearBtn: true,
                autoclose: true,
                todayHighlight: true,
                startDate: firstday,
                endDate: endDate,
            });

            // alert(response[0]['hol_date']);

        }
    });
    //   }

}

function settimepicker() {
    $('.timepicker').timepicker({
        defaultTime: '17:30',
        minuteStep: 5,
        //disableFocus: true,
        //template: 'dropdown',
        showMeridian: false,
    });
}
</script>
@endsection
