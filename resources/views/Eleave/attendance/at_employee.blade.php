@extends('Eleave.layout.main')

@section('title','Eleave | Attendance List Employee')

@section('style')
<style>
#calendar .fc-button-group {
    position: absolute;
    right: 35px;
    top: 80px;
}

#calendar .fc-left {
    top: 25px;
    position: absolute;
}

#calendar .fc-event {
    margin: 2px;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light calendar bordered">
            <div class="portlet-title" style="margin-bottom: 0;">
            </div>
            <div class="portlet-body" style="padding: 20px 0 !important;">
                <div id="calendar" style="margin-top: -20px"></div>
            </div>
            <span>Color Legend :</span>
            @if (session('branch_id') == 2)
            <span class='label' style="background-color:#1BBC9B; margin: 0 3px">Late Point : 0</span>
            <span class='label' style="background-color:#F3C200; margin: 0 3px">Late Point : 0.5</span>
            <span class='label' style="background-color:#E87E04; margin: 0 3px">Late Point : 1</span>
            <span class='label' style="background-color:#D91E18; margin: 0 3px">Late Point : 3</span>
            @endif
            <span class='label' style="background-color:#8E44AD; margin: 0 3px">Leave</span>
            <span class='label' style="background-color:#3598DC; margin: 0 3px">Timesheet</span>
            <span class='label' style="background-color:#2F353B; margin: 0 3px">Holiday</span>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-calendar-times-o"></i>Attendance List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">

                    </div>
                </div>
            </div>
            <input type="hidden" name="user_id" id="user_id" value="">
            <table class="table table-striped table-bordered table-condensed table-hover nowrap" width="100%"
                id="usertable">
                <thead>
                    <tr>
                        <th style="width: 50px">No</th>
                        <th style="width: 110px">Date<br />
                            <div class="filter-wrapper-date-start"></div>
                        </th>
                        <th style="width: 110px">Day<br />
                            <div class="filter-wrapper-day"></div>
                        </th>
                        <th style="width: 100px; text-align: left !important">Time In<br />
                            <div class="filter-wrapper-small"></div>
                        </th>
                        <th style="width: 100px; text-align: left !important">Time Out<br />
                            <div class="filter-wrapper-small"></div>
                        </th>
                        <th style="width: 150px">Total Time<br />
                            <div class="filter-wrapper"></div>
                        </th>
                        <th style="width: 100px; text-align: left !important">Late Point<br />
                            <div class="filter-point"></div>
                        </th>
                        <th style="width: 100px; text-align: left !important">Year<br>
                            <div class="filter-wrapper-year">
                                <select class="filter form-control" style="width:60px" id="slt_year" name="slt_year">
                                    <option value="">All Year</option>
                                    <?php
                                $lastYear = (int) date('Y');
                                for ($i = 2010; $i <= $lastYear; $i++) {
                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </th>
                        <th style="width: 100px">Month<br>
                            <div class="filter-wrapper-month">
                                <select class="filter form-control" style="width:60px" name="slt_month" id="slt_month">
                                    <option value="">All Month</option>
                                    <?php
                                $getMonthVal = $getMonthName = [];
                                foreach (range(1, 12) as $m) {
                                    $getMonthVal = date('m', mktime(0, 0, 0, $m, 1));
                                    $getMonthName = date('F', mktime(0, 0, 0, $m, 1));
                                    echo "<option value='" . $getMonthVal . "'>" . $getMonthName . "</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tfoot align="right" id="tfootlate">
                    <tr>
                        <td colspan="6" style="text-align: right !important;">Total Late Time</td>
                        <td colspan="3">
                            <div class="total_table" style="width: 100px; text-align: right;"> </div>
                        </td>
                    </tr>
                </tfoot>

                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
@section('script')
@include('Eleave/notification')
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<script type="text/javascript">
var $table;
$(document).ready(function() {
    $('#usertable thead th').each(function() {
        setdatepicker();
        var title = $('#usertable thead th').eq($(this).index()).text();
        $(this).find(".filter-wrapper").html(
            '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
        $(this).find(".filter-point").html(
            '<input type="text" class="filter form-control" placeholder="Filter ' +
            title + '" />');
        $(this).find(".filter-wrapper-small").html(
            '<input type="text" class="filter form-control" placeholder="Filter ' +
            title + '" />');
        $(this).find(".filter-wrapper-date-start").html(
            '<input type="text" class="filter form-control datepicker" id="src_date" placeholder="Filter ' +
            title + '" />');
        $(this).find(".filter-wrapper-day").html(
            '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="0">Monday</option>\n\
                        <option value="1">Tuesday</option>\n\
                        <option value="2">Wednesday</option>\n\
                        <option value="3">Thursday</option>\n\
                        <option value="4">Friday</option>\n\
                        <option value="5">Saturday</option>\n\
                     </select>'
        );
    });
    $table = $('#usertable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${webUrl}eleave/attendance/getAttendanceEmployee`,
            "dataType": "json",
            "type": "POST",
            "data": {
                "_token": "<?=csrf_token()?>"
            },
            dataSrc: function(data) {
                TotLatePoint = data.TotLatePoints;
                BranchId = data.BranchId;
                return data.data;
            }
        },
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "columns": [{
                "data": "no",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "at_date"
            },
            {
                "data": "day",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "at_time_in",
                "searchable": false,
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "at_time_out",
                "searchable": false,
                "orderable": false,
                "className": "text-center"

            },
            {
                "data": "at_total_time",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "at_late_point",
                "searchable": false,
                "orderable": false,
                "className": "text-right"
            },
            {
                "data": "year",
                "searchable": false,
                "orderable": false,
                "className": "text-right"
            },
            {
                "data": "month",
                "searchable": false,
                "orderable": false
            }
        ],
        order: [
            [1, "desc"]
        ],
        drawCallback: function(data, settings) {
            if (BranchId == 2){ 
                $('#tfootlate').removeClass('hidden');
                $('.total_table').html(TotLatePoint);
            }else{
                $table.column(6).visible(false);
                $('#tfootlate').addClass('hidden');
            }
        },
    });
    $table.columns().eq(0).each(function(colIdx) {
        $('input', $table.column(colIdx).header()).on('keyup change', function() {
            $table
                .column(colIdx)
                .search(this.value)
                .draw();
        });
        $('input', $table.column(colIdx).header()).on('click', function(e) {
            e.stopPropagation();
        });
        $('select', $table.column(colIdx).header()).on('change', function() {
            $table
                .column(colIdx)
                .search(this.value)
                .draw();
        });
        $('select', $table.column(colIdx).header()).on('click', function(e) {
            e.stopPropagation();
        });
    });
    //// CALENDAR

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var h = {};
    if ($('#calendar').width() <= 400) {
        $('#calendar').addClass("mobile");
        h = {
            left: 'title, prev, next',
            center: '',
            right: 'today,month'
        };
    } else {
        $('#calendar').removeClass("mobile");
        if (App.isRTL()) {
            h = {
                right: 'title',
                center: '',
                left: 'prev,next,today,month'
            };
        } else {
            h = {
                left: 'title',
                center: '',
                right: 'prev,next,today,month'
            };
        }
    }

    $('#calendar').fullCalendar('destroy'); // destroy the calendar
    $('#calendar').fullCalendar({ //re-initialize the calendar
        disableDragging: true,
        header: h,
        editable: false,
        fixedWeekCount: false,
        aspectRatio: 3,
        events: [

            <?php foreach ($attendance as $item) {?> {
                title: "<?=$item->at_time_in?> - <?=$item->at_time_out?>",
                start: '<?=$item->at_date?>',
                allDay: true,
                <?php if($item->at_late_point == 0){?>
                backgroundColor: '#1BBC9B'
                <?php }elseif($item->at_late_point == 0.5 && session('branch_id') == 2){?>
                backgroundColor: '#F3C200'
                <?php }elseif($item->at_late_point == 1 && session('branch_id') == 2){?>
                backgroundColor: '#E87E04'
                <?php }else{?>
                <?php if (session('branch_id') == 2){ ?>    
                    backgroundColor: '#D91E18'
                <?php } else{ ?>
                    backgroundColor: '#1BBC9B'
                <?php }}?>
            },
            <?php }?>

            <?php foreach ($holiday as $item) {?> {
                title: "<?=$item->hol_name?>",
                start: '<?=$item->hol_date?>',
                allDay: true,
                backgroundColor: '#2F353B'
            },
            <?php }?>

            <?php foreach ($leave as $item) {?> {
                title: "<?=$item->le_type?>",
                start: '<?=$item->le_date?>',
                allDay: true,
                backgroundColor: '#8E44AD'
            },
            <?php }?>

            <?php foreach ($timesheet as $item) {?> {
                title: "<?=$item->ts_type?>",
                start: '<?=$item->ts_date?>',
                allDay: true,
                backgroundColor: '#3598DC'
            },
            <?php }?>

        ],
        eventRender: function(event, element) {
            if (event.backgroundColor == '#2F353B' && event.title.trim().length >= '17') {
                $(element).tooltip({
                    title: event.title
                })
            }
        }
    });
});

function setdatepicker() {
    $('.datepicker').datepicker({
            format: 'dd M yy',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
        })
        .on("change", function() {
            var value = $(this).val();
            var parent_scroll = $(this).parent().attr('class');
            if (parent_scroll == 'filter-wrapper-date-start') {
                $('.DTFC_LeftWrapper .filter-wrapper-date-start #src_date').val(value);
            }
        });
}
</script>
@endsection