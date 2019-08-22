@extends('Eleave.layout.main')

@section('title','Eleave | Employee List')

@section('style')
<style>
.table .btn-leave {
    width: unset !important;
}
.modal-dialog {
  height: 80% !important;
  padding-top:10%;
}
.modal-header, h4, .close {
    background-color: #32c5d2;
    color: white !important;
    text-align: center;
    font-size: 20px;
}

.modal-footer {
    background-color: #efeeee;
}
</style>
@endsection

@section('content')
@if(session('dept_id') != 12)
<div class="row">
    <div class="col-md-8">
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
                                        <option value="1">Employee Data</option>
                                        <option value="2">Leave Balance</option>
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
                                        <?php if (session('is_hr') != 1) {?>
                                            <option value="">All Branch</option>
                                            <?php
                                        }
                                        $branch_id = session('branch_id');
                                        if (!empty($branch)) {
                                            foreach ($branch as $row) {
                                                ?>
                                                <option value="<?php echo $row['branch_id'];?>">
                                                    <?php echo $row['branch_name'];?></option>
                                                <?php
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
                                            for ($i = 2010; $i <= $lastYear; $i++) {
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
    <div class="col-md-4">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-clock-o"></i>End Contract </div>
            </div>
            <div class="portlet-body form">
                <div class="responsive" style="overflow: auto; height: 27.5vh; padding: 5px 0; width: 100%;">
                    <table class="table table-condensed table-responsive" style="margin-bottom: 0 !important">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>End Contract</th>
                            </tr>
                        </thead>
                        <?php
                            $no = 0;
                            if (!empty($last_contract)) {
                                foreach ($last_contract as $key => $value) {
                                    $no++;
                                    ?>
                        <tr>
                            <td><?=$no;?></td>
                            <td><?=$value['user_name'];?></td>
                            <td><?=date('d-m-Y', strtotime($value['user_active_until']));?></td>
                        </tr>
                        <?php
                                }
                            }
                            ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user"></i>
            @if(session('dept_id') == 12)
            Employee Request
            @else
            Employee Data
            @endif
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        @if(session('dept_id') != 12)
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#employee-list" aria-controls="employee-list" role="tab" data-toggle="tab">Employee List</a>
                </li>
                <li role="presentation">
                    <a href="#staff-request" aria-controls="staff-request" role="tab" data-toggle="tab">Staff Request</a>
                </li>
            </ul>
        @endif

        <!-- Tab panes -->
        <div class="tab-content">
            @if(session('dept_id') != 12)
            <!-- Employee List -->
            <div role="tabpanel" class="tab-pane active" id="employee-list">
                <div id="employee_list_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dt-buttons">
                                <a class="btn btn-default btn-circle btn-sm" tabindex="0"
                                    href="{{ URL::to('eleave/user/add') }}"><i class="fa fa-plus"></i> Add Employee</a>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-condensed nowrap" width="100%"
                        id="usertable">
                        <thead>
                            <tr>
                                <th style="width: 40px">No</th>
                                <th style="width: 110px">Name<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 60px">Status<br />
                                    <div class="filter-wrapper-status"></div>
                                </th>
                                <th style="width: 40px;text-align: left">Action</th>
                                <th style="width: 90px; text-align: left;"><br />Photo</th>
                                <th style="width: 100px">Email<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 40px">Gender<br />
                                    <div class="filter-wrapper-gender"></div>
                                </th>
                                <th style="width: 100px">Type<br />
                                    <div class="filter-wrapper-type"></div>
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
                                <th style="width: 110px">Employee Ref No<br />
                                    <div class="filter-wrapper-100"></div>
                                </th>
                                <th style="width: 110px; text-align: left;">Finger Print ID<br />
                                    <div class="filter-wrapper-100"></div>
                                </th>

                                <th style="width: 50px; text-align: left;">Branch<br />
                                    <?php if (session('is_hr') == 0) {?>
                                    <select class="filter form-control" style="width:60px" id="slt_branch"
                                        name="slt_branch">
                                        <option value=""></option>
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
                                        <option value=""></option>
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
                                <th style="width: 40px;text-align: left">Approver<br />
                                    <div class="filter-wrapper-choosen"></div>
                                </th>
                                <th style="width: 40px;text-align: left">HR<br />
                                    <div class="filter-wrapper-choosen"></div>
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
                                <th style="width: 150px">Address<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 100px">Phone<br />
                                    <div class="filter-wrapper"></div>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Staff Request -->
            <div role="tabpanel" class="tab-pane @if(session('dept_id') == 12) active @endif" id="staff-request">
                <div id="staff_request_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dt-buttons">
                                <button class="btn btn-default btn-circle btn-refresh btn-sm" title='Refresh'>
                                    Refresh
                                    <i class="fa fa-refresh"></i>
                                </button>
                                @if(session('dept_id') != 12)
                                <a class="btn btn-default btn-circle btn-sm" tabindex="0"
                                    href="{{ URL::to('eleave/staff-request/form') }}">
                                    <i class="fa fa-plus"></i>
                                    Request
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-condensed nowrap" width="100%"
                        id="staffRequest">
                        <thead>
                            <tr>
                                <th style="width: 40px">No</th>
                                <th style="width: 90px">
                                    Request Date
                                </th>
                                <th style="width: 70px">
                                    Request By
                                </th>
                                <th style="width: 65px;">
                                    Service By
                                </th>
                                <th style="width: 110px;">
                                    Name
                                </th>
                                <th style="width: 90px;">
                                    Dept.
                                </th>
                                <th style="width: 110px">
                                    Employee Type
                                </th>
                                <th style="width: 65px;">
                                    Branch
                                </th>
                                <th style="width: 90px">
                                    Join Date
                                </th>
                                <th style="width: 90px">
                                    Resign Date
                                </th>
                                <th style="width: 70px">
                                    Type
                                </th>
                                <th style="width: 70px">
                                    Status
                                </th>
                                <th style="width: 270px">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Cancel Request -->
        <div id="cancelRequest" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirm Cancel Request</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to cancel the request?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            No
                        </button>
                        <button type="button" class="btn btn-primary btn-cancelRequest btn-actions"
                            data-actions="cancelRequest">
                            <i class="fa fa-check"></i>
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Close Request -->
        <div id="closeRequest" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirm Close Request</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to close the request?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            No
                        </button>
                        <button type="button" class="btn btn-primary btn-closeRequest btn-actions"
                            data-actions="closeRequest">
                            <i class="fa fa-check"></i>
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Finish Request -->
        <div id="finishRequest" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirm Finish Request</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to finish the request?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            No
                        </button>
                        <button type="button" class="btn btn-primary btn-finishRequest btn-actions"
                            data-actions="finishRequest">
                            <i class="fa fa-check"></i>
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Proccess Request -->
        <div id="prosesRequest" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirm Proccess Request</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to proccess the request?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            No
                        </button>
                        <button type="button" class="btn btn-primary btn-prosesRequest btn-actions"
                            data-actions="prosesRequest">
                            <i class="fa fa-check"></i>
                            Yes
                        </button>
                    </div>
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
var $staffRequest;
$(document).ready(function() {
    @if(session('dept_id') != 12)
    // window.onload = function () { NProgress.done(); }
    $('#usertable thead th').each(function() {
        setdatepicker();
        var title = $('#usertable thead th').eq($(this).index()).text();
        $(this).find(".filter-wrapper").html(
            '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
        $(this).find(".filter-wrapper-100").html(
            '<input type="text" class="filter form-control" placeholder="' +
            title + '" />');
        $(this).find(".filter-wrapper-small").html(
            '<input type="text" class="filter form-control" placeholder="' +
            title + '" />');
        $(this).find(".filter-wrapper-date").html(
            '<input type="text" class="filter form-control datepicker"  placeholder="Filter ' +
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
            "url": `${webUrl}eleave/user/getdata`,
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
                "data": "user_name",
                "searchable": false,
                "orderable": true
            },
            {
                "data": "active",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "action",
                "searchable": false,
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "user_photo",
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
                "data": "user_gender",
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
                "data": "approver",
                "searchable": false,
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "hr",
                "searchable": false,
                "orderable": false,
                "className": "text-center"
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
        ],
        columnDefs: [{
            targets: 4,
            render: function(data) {
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
    $table.on("click", "tr", function() {
        var aData = $table.row(this).data();
        console.log(aData);
    });
    @endif

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        if ((target == '#staff-request')) {
            $staffRequest.ajax.reload()
        }
    });

    $staffRequest = $('#staffRequest').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${apiUrl}eleave/staff-request`,
            "dataType": "json",
            "type": "POST",
            "data": {
                "token": token,
                "user_id": id_eleave,
                "branch_id": branch_id
            }
        },
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "columns": [{
                "data": "no",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "request_date",
                "orderable": true
            },
            {
                "data": "request_by",
                "orderable": true
            },
            {
                "data": "service_by",
                "orderable": false,
            },
            {
                "data": "employee_name",
                "orderable": true,
            },
            {
                "data": "department_name",
                "orderable": true,
                "className": "text-center"
            },
            {
                "data": "employee_type",
                "orderable": true
            },
            {
                "data": "branch_name",
                "orderable": true,
                "className": "text-center"
            },
            {
                "data": "join_date",
                "orderable": true
            },
            {
                "data": "resign_date",
                "orderable": true
            },
            {
                "data": "type",
                "orderable": true
            },
            {
                "data": "status",
                "orderable": true
            },
            {
                "data": "action",
                "orderable": false
            }
        ],
        // scrollX: true,
        order: [
            [1, "desc"]
        ],
    })

    // new $.fn.dataTable.FixedColumns($staffRequest, {
    //     leftColumns: 2,
    //     rightColumns: 2
    // });
    

    $staffRequest.columns().eq(0).each(function(colIdx) {
        $('input', $staffRequest.column(colIdx).header()).on('keyup change', function() {
            $staffRequest
                .column(colIdx)
                .search(this.value)
                .draw()
        });
        $('input', $staffRequest.column(colIdx).header()).on('click', function(e) {
            e.stopPropagation()
        });
        $('select', $staffRequest.column(colIdx).header()).on('change', function() {
            $staffRequest
                .column(colIdx)
                .search(this.value)
                .draw()
        });
        $('select', $staffRequest.column(colIdx).header()).on('click', function(e) {
            e.stopPropagation()
        });
    })

    $(".btn-refresh").click(function() {
        $staffRequest.ajax.reload()
        $staffRequest.order([1,'desc']).draw()

        staffRequestNotif()
    })

    //S:Change Staff Request Status
    $(".btn-actions").click(function() {
        let reqId = $(this).attr('id')
        let action = $(this).attr('data-actions')
        let actionWords = ''

        switch (action) {
            case 'cancelRequest':
                actionWords = 'Cancel'
                break
            case 'prosesRequest':
                actionWords = 'Proccess'
                break
            case 'finishRequest':
                actionWords = 'Finished'
                break
            case 'closeRequest':
                actionWords = 'Close'
                break
            default:
                actionWords = 'Requested'
                break
        }

        $.ajax({
            url: `${apiUrl}eleave/staff-request/change-status`,
            type: 'POST',
            dataType: 'json',
            data: {request_id: reqId, token: token, action: action, user_id: id_eleave},
            beforeSend: function () {
                NProgress.start()
                $(`#${action} .modal-footer button`).attr('disabled',true)
                $(`#${action} .modal-footer .btn-actions`).text('Processing...')
            },
            success: function (response) {
                if(response.response_code == 200)
                {
                    toastr.success(response.message)
                    $(`#${action}`).modal('hide')
                    $staffRequest.ajax.reload()

                    staffRequestNotif()

                    $(`#${action} .modal-footer button`).attr('disabled',false)
                    $(`#${action} .modal-footer .btn-actions`).text('Yes')
                }
                else
                {
                    toastr.warning(`Failed to ${actionWords} the request`)
                }

                NProgress.done()
            }
        })
        .fail(function() {
            toastr.error("System failure, Please contact the Administrator")
        })
    })
    //E:Change Staff Request Status

    @if(session('dept_id') == 12)
    // S:Get bubble notif for staff request
    $.ajax({
            url: `${apiUrl}eleave/staff-request/get-total-request`,
            type: 'POST',
            dataType: 'json',
            data: {
                token: token
            },
            success: function(response) {
                if (response.response_code == 200) {
                    if (response.data.total > 0) {
                        $(".nav-request-badge").text(response.data.total)
                        $(".nav-request-badge").attr('title', response.data.tooltip)
                        $(".nav-request-badge").removeClass('hidden')
                    } else {
                        $(".nav-request-badge").text(0)
                        $(".nav-request-badge").attr('title', 'You do not have any request')
                        $(".nav-request-badge").addClass('hidden')
                    }
                } else {
                    toastr.warning(`Failed to ${actionWords} the request`)
                }
            }
        })
        .fail(function() {
            toastr.error("System failure, Please contact the Administrator")
        })
    // E:Get bubble notif for staff request
    @endif
})

function nProgress() {
    NProgress.start();
    var interval = setInterval(function() {
        NProgress.inc();
    }, 10);

    jQuery(window).load(function() {
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

$("#btn_filter").click(function() {
    if ($("#slt_module").val() == "") { // Not Valid
        alert("please select report");
        return false;
    } else {
        NProgress.start();
        setTimeout(function() {
            NProgress.done();
            $('.fade').removeClass('out');
        }, 1000);

        $("#form_filter").submit();

    }

});

$('#slt_module').on('change', function() {
    if (this.value == 1 || this.value == 2){
        $('#slt_year').prop('disabled', true);
        $('#slt_month').prop('disabled', true);
        $("#slt_year")[0].selectedIndex = 0;
        $("#slt_month")[0].selectedIndex = 0;
    }else{
        $('#slt_year').prop('disabled', false);
        $('#slt_month').prop('disabled', false);
    }
});

//S:Show modal by actions button
function actions(id, type) {
    $(`#${type} .btn-${type}`).attr('id', id)
}
//E:Show modal by actions button
</script>
<script>
$(document).on('click', '.reject', function() {
    if (confirm("Are you sure delete ?  ")) {
        var $button = $(this);
        var id = this.id.split('-').pop();
        $.ajax({
            type: 'POST',
            url: `${webUrl}eleave/user/delete`,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                "_token": "{{ csrf_token() }}"
            },

            success: function(data) {
                if (data.status == true) {
                    $table.row($button.parents('tr')).remove().draw();
                    toastr.success(data.message);
                }
            },
            error: function(data) {
                toastr.error(data.message);
            }
        });
    }
});
</script>
@endsection