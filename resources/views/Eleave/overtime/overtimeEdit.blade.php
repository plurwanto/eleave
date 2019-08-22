@extends('Eleave.layout.main')

@section('title','Eleave | UserLevel Add')

@section('content')
@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }} 
</div>
@endif
<input type="hidden" id="open_date" name="open_date" value="">
<input type="hidden" id="user_id" name="user_id" value="{{session('id')}}">
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>Edit Overtime Request Form (ORF)
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body form">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <?php if ($ot->ot_need_revision) {?>
                <div class="alert alert-warning">
                    <strong>Need to be revised.</strong> <?php
                    if ($ot->ot_revision_reason != "") {
                        echo "Message from " . $ot->user_name . " : " . $ot->ot_revision_reason;
                    }
                    ?>
                </div>
            <?php }?>
            <input type="hidden" id="user_id" name="user_id" value="{{session('id')}}">
            <form action="{{ URL::to(env('APP_URL').'/eleave/overtime/'.$ot->ot_id.'/update') }}" class="" method="POST" id="form_input">
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                    <input type="hidden" name="employee_id" value="{{session('id')}}">
                    <input type="hidden" name="ot_id" value="<?=$ot->ot_id;?>">
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
                                <td nowrap>
                                    <div class="input-group err">
                                        <input type="text" readonly="readonly" class="form-control datepicker" value="<?=$ot->ot_date;?>" placeholder="Enter date" name="ot_date" id="ot_date" autocomplete="off">
                                        <label class="input-group-addon" for="ot_date">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group err">
                                        <input type="text" class="form-control timepicker timepicker-24 Time1" value="<?=$ot->ot_time_in;?>" name="ot_time_in" id="ot_time_in" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group err">
                                        <input type="text" class="form-control timepicker timepicker-24 Time2" value="<?=$ot->ot_time_out;?>" name="ot_time_out" id="ot_time_out" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td nowrap>
                                    <div class="err">
                                        <input type="text" class="form-control" value="<?=$ot->ot_description;?>" placeholder="Enter description" name="ot_description">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <textarea name="ot_reason" class="form-control input-sm" rows="3"><?=$ot->ot_reason;?></textarea>
                        <label for="form_control_1">The reason(s) why the work cannot be completed during regular work hours</label>
                    </div>
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <textarea name="ot_impact" class="form-control input-sm" rows="3"><?=$ot->ot_negative_impact;?></textarea>
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
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'moment.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    var form1 = $('#form_input');
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
            }
        },
        rules: {
            ot_date: {
                required: true
            },
            ot_time_in: {
                required: true
            },
            ot_time_out: {
                required: true
            },
            ot_description: {
                required: true
            },
            ot_reason: {
                required: true
            },
            ot_impact: {
                required: true
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
            return true;
        }
    });

    //setdatepicker();
    settimepicker();
  
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
    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        //forceParse: false,
        //calendarWeeks: true,
        //startView: 2,
        autoclose: true,
        todayHighlight: true,
        startDate: new Date(date.getFullYear(), currentMonth - 1, 1),
        endDate: '0'
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

</script>
@endsection
