@extends('Eleave.layout.main')

@section('title','Eleave | Employee List')

@section('style')
<style>
    .table .btn-xs {
        width: unset !important;
    }
</style>
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
            <li class="active">
                <a href="{{url('eleave/user/team')}}" id="tab1" aria-expanded="true"> Team Data </a>
            </li>
            <li class="">
                <a href="{{url('eleave/user/team_attendance')}}" id="tab2" aria-expanded="false"> Team Attendance </a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tab_1_1">
                <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                    <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                        <thead>
                            <tr>
                                <th style="width: 40px">No</th>
                                <th style="width: 90px; text-align: left;">Photo</th>
                                <th style="width: 110px">Name<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 60px">Action</th>

                                <th style="width: 100px">Type<br />
                                    <div class="filter-wrapper-type"></div>
                                </th>
                                <th style="width: 110px">Employee Ref No<br />
                                    <div class="filter-wrapper-100"></div>
                                </th>
                                <th style="width: 110px; text-align: left;">Finger Print ID<br />
                                    <div class="filter-wrapper-100"></div>
                                </th>
                                <th style="width: 100px">Email<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 50px; text-align: left;">Branch<br />
                                    <?php if (session('is_hr') == 0) {?>
                                        <select class="filter form-control" style="width:60px" id="slt_branch" name="slt_branch">
                                            <option value="">- Choose -</option>
                                            <?php
                                            if (!empty($branch)) {
                                                foreach ($branch as $value) {
                                                    echo "<option value='" . $value['branch_id'] . "'>" . $value['branch_name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php }?>
                                </th>
                                <th style="width: 70px">Department<br />
                                    <select class="filter form-control" style="width:60px" id="slt_department"
                                            name="slt_department">
                                        <option value="">- Choose -</option>
                                        <?php
                                        if (!empty($department)) {
                                            foreach ($department as $value) {
                                                echo "<option value='" . $value['department_id'] . "'>" . $value['department_name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </th>
                                <th style="width: 100px">Position<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 90px">Date of Birth<br />
                                    <div class="filter-wrapper-date"></div>
                                </th>
                                <th style="width: 40px">Gender<br />
                                    <div class="filter-wrapper-gender"></div>
                                </th>

                                <th style="width: 90px">Join Date<br />
                                    <div class="filter-wrapper-date"></div>
                                </th>
                                <th style="width: 90px">Contract Date<br />
                                    <div class="filter-wrapper-date"></div>
                                </th>
                                <th style="width: 90px">Active Until<br />
                                    <div class="filter-wrapper-date"></div>
                                </th>

                                <th style="width: 150px">Address<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 100px">Phone<br />
                                    <div class="filter-wrapper">
                                    </div>
                                </th>
                                <th style="width: 90px">Approver 1<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 90px">Approver 2<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 90px">Approver 3<br />
                                    <div class="filter-wrapper"></div>
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
@endsection

@section('script')
@include('Eleave/notification')
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<script type="text/javascript">
var $table;
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
        $(this).find(".filter-wrapper-status").html(
                '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="Active">Active</option>\n\
                        <option value="Resign">Resign</option>\n\
                     </select>'
                );
        $(this).find(".filter-wrapper-gender").html(
                '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="Male">Male</option>\n\
                        <option value="Female">Female</option>\n\
                     </select>'
                );
        $(this).find(".filter-wrapper-type").html(
                '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="Contract/Mitra">Contract/Mitra</option>\n\
                        <option value="Permanent">Permanent</option>\n\
                        <option value="Probation">Probation</option>\n\
                     </select>'
                );
        $(this).find(".filter-wrapper-choosen").html(
                '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="1">Yes</option>\n\
                        <option value="0">No</option>\n\
                     </select>'
                );

    });

    $table = $('#usertable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${webUrl}eleave/user/getdatateam`,
            "dataType": "json",
            "type": "POST",
            "data": {
                "_token": "<?=csrf_token()?>"
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
                "data": "user_photo",
                "searchable": false,
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "user_name",
                "searchable": false,
                "orderable": true
            },
            {
                "data": "action",
                "searchable": false,
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "user_type",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_nik",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_finger_print_id",
                "searchable": false,
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "user_email",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "branch_name",
                "searchable": false,
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "department_name",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_position",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_dob",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_gender",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_join_date",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_last_contract_start_date",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_active_until",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_address",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_phone",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_approver1",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_approver2",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "user_approver3",
                "searchable": false,
                "orderable": false
            },
        ],
        columnDefs: [{
                targets: 1,
                render: function (data) {
                    return '<img src="' + data + '" height="70">'
                }
            }],
        scrollY: 350,
        scrollX: true,
        "pageLength": 10,
        lengthMenu: [
            [5, 10, 25, 50, 100],
            [5, 10, 25, 50, 100]
        ],
        order: [
            [1, "desc"]
        ],
    });

    new $.fn.dataTable.FixedColumns($table, {
        leftColumns: 4,
        // rightColumns: 2
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
</script>

@endsection