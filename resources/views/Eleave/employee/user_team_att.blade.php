@extends('Eleave.layout.main')

@section('title','Eleave | Employee Team Attendance')

@section('style')

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-filter"></i>Filter Download </div>
            </div>
            <div class="portlet-body form">
                <form action="{{ url('eleave/user/export_excel') }}" name="form" id="form_filter" method="GET"
                      style="height: 27.5vh; display: table-cell; vertical-align: middle;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <div class="form-group form-md-line-input has-success">
                                    <label class="control-label">Report</label>
                                    <select class="form-control" name="slt_module" id="slt_module">
                                        <option value="">- Choose -</option>
                                        <option value="3">Attendance</option>
                                        <option value="4">Leave Summary</option>
                                        <option value="5">Timesheet Summary</option>
                                        <option value="6">Overtime Summary</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-md-line-input has-success">
                                    <label class="control-label">Branch</label>
                                    <select class="form-control" name="slt_branch" id="slt_branch">
                                        <?php
                                        $branch_id = session('branch_id');
                                        if (!empty($branch_id)) {
                                            foreach ($branch as $row) {
                                                if ($row['branch_id'] == $branch_id) {
                                                    ?>
                                                    <option value="<?php echo $row['branch_id'];?>">
                                                        <?php echo $row['branch_name'];?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-md-line-input has-success">
                                    <label class="control-label">Year</label>
                                    <select class="form-control" name="slt_year" id="slt_year">
                                        <option value="">All Year</option>
                                        <?php
                                        $lastYear = (int) date('Y');
                                        for ($i = 2015; $i <= $lastYear; $i++) {
                                            $selected = ($i == $lastYear ? $selected = ' selected ' : '');
                                            echo "<option value='" . $i . "' $selected>" . $i . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-md-line-input has-success">
                                    <label class="control-label">Month</label>
                                    <select class="form-control" name="slt_month" id="slt_month">
                                        <option value="">All Month</option>
                                        <?php
                                        $getMonthVal = $getMonthName = [];
                                        $lastMonth = (int) date('m');
                                        foreach (range(1, 12) as $m) {
                                            $getMonthVal = date('m', mktime(0, 0, 0, $m, 1));
                                            $getMonthName = date('F', mktime(0, 0, 0, $m, 1));
                                            $selected = ($m == $lastMonth ? $selected = ' selected ' : '');
                                            echo "<option value='" . $getMonthVal . "' $selected>" . $getMonthName . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group form-md-line-input has-success">
                                    <label class="control-label">Employee</label>
                                    <input class="form-control" placeholder="Employee" type="text" id="employee_name"
                                           name="employee_name" value="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="btn_filter" style="margin: 40px 0px"
                                        class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-users"></i>Team List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <ul class="nav nav-tabs">
            <li class="">
                <a href="{{url('eleave/user/team')}}" id="tab1" aria-expanded="true"> Team Data </a>
            </li>
            <li class="active">
                <a href="{{url('eleave/user/team_attendance')}}" id="tab2" aria-expanded="false"> Team Attendance </a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tab_1_1">
                <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                    <input type="hidden" name="txt_year" id="txt_year" value="{{date('Y')}}">
                    <table class="table table-striped table-bordered table-condensed table-hover nowrap" width="100%"
                           id="usertable">
                        <thead>
                            <tr>
                                <th style="width: 10px"></th>

                                <th style="width: 120px">Employee<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 60px">Date<br />
                                    <div class="filter-wrapper-date-start"></div>
                                </th>
                                <th style="width:30px">Day<br />
                                    <div class="filter-wrapper-day"></div>
                                </th>
                                <th style="width: 30px; text-align: left;">Time In
                                </th>
                                <th style="width: 30px; text-align: left;">Time Out
                                </th>
                                <th style="width: 80px">Total Time<br />
                                    <div class="filter-70"></div>
                                </th>
                                <th style="width: 40px; text-align: left;">Late Point<br />
                                    <div class="filter-70"></div>
                                </th>

                                <th style="width: 50px">Month<br />
                                    <select class="filter form-control" name="slt_month" id="slt_month">
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
                                </th>
                                <th style="width: 70px; text-align: left;">Source<br />
                                    <div class="filter-wrapper-status"></div>
                                </th>
                            </tr>
                        </thead>


                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">List Detail</h3>
            </div>
            <div class="modal-body">
                <div class="table table-responsive" id="tbldata" style="height:300px; width:100%;overflow: auto;">
                    <form action="#" id="form" class="form-horizontal">
                        <table id="detailtable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th nowrap>No</th>
                                    <th nowrap>Date time</th>
                                    <th>Location</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-o" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

@endsection

@section('script')
@include('Eleave/notification')
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<script type="text/javascript">
var $table;
var year = $('#txt_year').val();
$(document).ready(function () {
    // window.onload = function () { NProgress.done(); }
    $('#usertable thead th').each(function () {
        setdatepicker();
        var title = $('#usertable thead th').eq($(this).index()).text();
        $(this).find(".filter-wrapper").html(
                '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
        $(this).find(".filter-wrapper-100").html(
                '<input type="text" class="filter form-control"  placeholder="Filter ' +
                title + '" />');
        $(this).find(".filter-wrapper-small").html(
                '<input type="text" class="filter form-control" placeholder="Filter ' +
                title + '" />');
        $(this).find(".filter-wrapper-date").html(
                '<input type="text" class="filter form-control datepicker" placeholder="Filter ' +
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
        $(this).find(".filter-wrapper-status").html(
                    '<select class="filter form-control">\n\
                        <option value="">Choose</option>\n\
                        <option value="1">Finger</option>\n\
                        <option value="2">Mobile</option>\n\
                        </select>'
                    );
    });

    $table = $('#usertable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${webUrl}eleave/user/getTeamAttendance`,
            "dataType": "json",
            "type": "POST",
            "data": {
                "_token": "<?=csrf_token()?>",
                year: year
            },
            error: function (jqXhr, textStatus, errorThrown) //jqXHR, textStatus, errorThrown
            {
                if (jqXhr.status == 419) {//if you get 419 error / page expired
                    toastr.warning("page expired, please login to continue.");
                    location.reload();
                }
            }
        },
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "columns": [{
                "data": "no",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_name",
                "searchable": false,
                "orderable": true
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
                "data": "month",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "is_attendance",
                "searchable": false,
                "orderable": false
            }
        ],
        order: [
            [1, "desc"]
        ],
    });

    $table.columns().eq(0).each(function (colIdx) {
        $('input', $table.column(colIdx).header()).on('keyup change', function () {
            $table
                    .column(colIdx)
                    .search(this.value)
                    .draw();
        });
        $('input', $table.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation();
        });
        $('select', $table.column(colIdx).header()).on('change', function () {
            $table
                    .column(colIdx)
                    .search(this.value)
                    .draw();
        });
        $('select', $table.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation();
        });
    });
    $table.on("click", "tr", function () {
        var aData = $table.row(this).data();
        console.log(aData);
    });
});

function nProgress() {
    NProgress.start();
    var interval = setInterval(function () {
        NProgress.inc();
    }, 10);

    jQuery(window).load(function () {
        clearInterval(interval);
        NProgress.done();
    });
}

function setdatepicker() {
    $('.datepicker').datepicker({
        format: 'dd M yy',
        clearBtn: true,
        autoclose: true,
        todayHighlight: true,
    });
}

$("#btn_filter").click(function () {
    if ($("#slt_module").val() == "") { // Not Valid
        alert("please select report");
        return false;
    } else {
        NProgress.start();
        setTimeout(function () {
            NProgress.done();
            $('.fade').removeClass('out');
        }, 1000);

        $("#form_filter").submit();

    }

});

function show_detail(user_id, branch_id, at_date) {
    $('#modal_form').modal('show');
    $('.modal-title').text('Attendance Detail');
    $.ajax({
        type: "POST",
        "url": `${webUrl}eleave/user/getTeamAttendanceDetail`,
        dataType: 'json',
        data: {
            user_id: user_id,
            branch_id: branch_id,
            at_date: at_date,
            "_token": "{{ csrf_token() }}"
        },
        success: function (response) {
            $('table#detailtable tr#baris').remove();
            //alert(response)
            if (response.data.length > 0) {
                for (var i = 0; i < response.data.length; i++) {
                    x = i + 1;
                    html = '<tr id="baris">';
                    html += '<td nowrap> ' + x + '</td>';
                    html += '<td nowrap> ' + response.data[i]['date_time'] + '</td>';
                    html += '<td nowrap> ' + response.data[i]['location'] + '</td>';
                    html += '<td nowrap> ' + response.data[i]['remark'] + '</td>';
                    html += '</tr>';
                    $('#detailtable').append(html);
                }
            } else {
                html = '<tr id="baris">';
                html += '<td colspan="4" class="text-center"> <b>No Mobile Attendance Record found </b></td>';
                html += '</tr>';
                $('#detailtable').append(html);
            }
        }
    });
}


</script>

@endsection