@extends('Eleave.layout.main')

@section('title','Eleave | Overtime List Approval')

@section('style')
<style>
    .attendance {
        position: absolute;
        top: 7px;
        /* left: 270px; */
        margin-left: -38px;
        width: 134px;
        padding-top: 3px;
        height: 25px;
        border-bottom: 1px solid #e7ecf1;
        background-color: #fff;
        text-align: center;
    }

    .overtime {
        position: absolute;
        top: 7px;
        /* left: 270px; */
        margin-left: -48px;
        width: 134px;
        padding-top: 3px;
        height: 25px;
        border-bottom: 1px solid #e7ecf1;
        background-color: #fff;
        text-align: center;
    }

    .actual {
        position: absolute;
        top: 7px;
        /* left: 270px; */
        margin-left: -47px;
        width: 134px;
        padding-top: 3px;
        height: 25px;
        border-bottom: 1px solid #e7ecf1;
        background-color: #fff;
        text-align: center;
    }

    .dataTables_sizing .attendance,
    .dataTables_sizing .overtime,
    .dataTables_sizing .actual {
        display: none;
    }
</style>
@endsection

@section('content')

@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }}
</div>
@endif
<input type="hidden" id="notif" name="notif" value="{{ $notif }}">
<input type="hidden" value="{{ $source_id }}" name="source_id" id="source_id" />
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>Overtime List Approval
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
            <thead>
                <!-- <tr>
                    <th></th>
                    <th></th>
                    <th style="width: 110px">Employee</th>
                    <th style="width: 80px">Date</th>
                    <th colspan="2" scope="colgroup">
                        <center>Attendance</center>
                    </th>
                    <th colspan="2" scope="colgroup">
                        <center>Overtime</center>
                    </th>
                    <th colspan="2" scope="colgroup">
                        <center>Actual</center>
                    </th>
                    <th></th>
                    <th>Description</th>
                    <th>Reason</th>
                    <th>Negative Impact</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Status</th>
                    <th></th>
                </tr> -->
                <tr>
                    <th style="width: 5px">No</th>
                    <th>ID</th>
                    <th style="width: 110px">Employee<br />
                        <div class="filter-wrapper"></div>
                    </th>
                    <th style="width: 105px">
                        Date<br />
                        <div class="filter-wrapper-date-start"></div>
                    </th>
                    <th style="width: 53px; vertical-align: bottom">In
                        <span class="attendance"></span>
                    </th>
                    <th style="width: 53px; vertical-align: bottom">Out</th>
                    <th style="width: 53px; vertical-align: bottom">From
                        <span class="overtime"></span>
                    </th>
                    <th style="width: 53px; vertical-align: bottom">To</th>
                    <th style="width: 53px; vertical-align: bottom">Start
                        <span class="actual"></span>
                    </th>
                    <th style="width: 53px; vertical-align: bottom">End</th>
                    <th style="width: 120px">Total</th>
                    <th style="width: 200px">
                        Description<br />
                        <div class="filter-wrapper"></div>
                    </th>
                    <th style="width: 200px">
                        Reason<br />
                        <div class="filter-wrapper"></div>
                    </th>
                    <th style="width: 200px">
                        Negative Impact<br />
                        <div class="filter-wrapper"></div>
                    </th>

                    <th style="width: 90px">Submit Date</th>
                    <th style="width: 110px">Approver 1</th>
                    <th style="width: 110px">Approver 2</th>
                    <th style="width: 110px">Approver 3</th>

                    <th style="width: 50px; text-align: left;">Year</th>
                    <th style="width: 70px">Month</th>
                    <th style="width: 60px">Active
                        <div class="filter-wrapper-active"></div>
                    </th>
                    <th style="width: 240px">Status<br />
                        <div class="filter-wrapper-status"></div>
                    </th>
                    <th style="width: 90px">Action<div class="filter-wrapper-100"></div>
                    </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Revision</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="user_id" id="user_id" />
                    <input type="hidden" value="" name="ot_id" id="ot_id" />
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Reason</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" placeholder="Enter reason"
                                          id="ot_revision_reason" name="ot_reason" maxlength="255"></textarea>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-o" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnSave" onclick="save_status()" class="btn btn-info">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script type="text/javascript">
// Server-side processing with object sourced data
    var $table;
    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            $(this).find(".attendance").html('Attendance');
            $(this).find(".overtime").html('Overtime');
            $(this).find(".actual").html('Actual');
            var title = $('#usertable thead th').eq($(this).index()).text().trim();
            $(this).find(".filter-wrapper").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-date-start").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-status").html(
                    '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="1">Rejected</option>\n\
                        <option value="2">Approved</option>\n\
                        <option value="3">Waiting revision</option>\n\
                        <option value="4">Waiting approval</option>\n\
                     </select>'
                    );
            $(this).find(".filter-wrapper-active").html(
                    '<select id="user_act" class="filter form-control">\n\
                        <option value=""></option>\n\
                        <option selected value="Active">Active</option>\n\
                        <option value="Resign">Resign</option>\n\
                     </select>'
                    );
        });

        if ($('#notif').val() == "notif") {
            var url = `${webUrl}eleave/overtimeApproval/getdataNotif`;
        } else {
            var url = `${webUrl}eleave/overtimeApproval/getdata`;
        }

        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": {
                    "_token": "<?=csrf_token()?>",
                    notif: $('#notif').val(),
                    source_id: $('#source_id').val()
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
                    "data": "ot_id",
                    "searchable": false,
                    "orderable": false,
                    "visible": false
                },
                {
                    "data": "user_name",
                    "orderable": true,
                },
                {
                    "data": "ot_date",
                    "orderable": true,
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
                    "data": "ot_time_in",
                    "searchable": false,
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "ot_time_out",
                    "searchable": false,
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "actual_start",
                    "searchable": false,
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "actual_end",
                    "searchable": false,
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "total_actual",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "ot_description",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "ot_reason",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "ot_negative_impact",
                    "searchable": false,
                    "orderable": false,
                },

                {
                    "data": "ot_submit_date",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "approver1",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "approver2",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "approver3",
                    "searchable": false,
                    "orderable": false,
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
                },
                {
                    "data": "user_status",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "status",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "action",
                    "searchable": false,
                    "orderable": false,
                },
            ],
            scrollY: 350,
            scrollX: true,
            "pageLength": ($('#notif').val() == "notif" ? 1000 : 10),
            lengthMenu: [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            order: [
                [14, "DESC"]
            ],
            "fnDrawCallback": function (oSettings) {
                if ($('#notif').val() == "notif") {
                    $('.dataTables_paginate').hide();
                    $('.dataTables_length').hide();
                }
            }
        });

        if ($('#user_act').val() == "Active") {
            $table.columns(20).search("Active").draw();
        }

        new $.fn.dataTable.FixedColumns($table, {
            leftColumns: 4,
            rightColumns: 2
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

    function revisi_this(ot_id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#ot_id').val(ot_id);
        // $('#user_id').val(user_id);
        $('.modal-title').text('Revision Form');

    }

    function reject_this(ot_id) {
        save_method = 'reject';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#ot_id').val(ot_id);
        $('.modal-title').text('Reject Form');
    }

    function save_status() {
        var url;
        if (save_method == 'update') {
            if ($('#ot_reason').val() == '') {
                alert('Enter revise reason');
                return false;
            }
            url = `${webUrl}eleave/overtimeApproval/revise`;

        } else if (save_method == 'reject') {
            url = `${webUrl}eleave/overtimeApproval/reject`;
        }

        $('#btnSave').text('Updating...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data) {
                // alert(data.inputerror);
                if (data.status) {
                    $('#modal_form').modal('hide');
                    $table.ajax.reload();
                    toastr.success(data.message);
                }
                $('#btnSave').text('Update');
                $('#btnSave').attr('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function setdatepicker() {
        $('.datepicker').datepicker({
            format: 'dd M yy',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
        })
                .on("show", function () {
                    var parent_scroll = $(this).parent().attr('class');
                    if (parent_scroll === 'filter-wrapper-date-start') {
                        $('.datepicker-dropdown').css({
                            top: 250.15,
                            left: 426,
                        });
                    }
                })
                .on("change", function () {
                    var value = $(this).val();
                    var parent_scroll = $(this).parent().attr('class');
                    if (parent_scroll === 'filter-wrapper-date-start') {
                        $('.DTFC_LeftWrapper .filter-wrapper-date-start #src_date').val(value);
                    }
                });
    }
</script>

<script>
    $(document).on('click', '.approve', function () {
        toastr.options = {
            "closeButton": true,
        };

        var $button = $(this);
        $button.attr('disabled', true);
        var arr = this.id.split('-');
        $.ajax({
            url: `${webUrl}eleave/overtimeApproval/approve`,
            type: "POST",
            data: {
                ot_id: arr[0],
                next: arr[1],
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == true) {
                    $table.ajax.reload();
                    toastr.success(data.message);
                }

            },
            error: function (data) {
                toastr.error(data.message);
            }
        });
    });

//    $(document).on('click', '.reject', function () {
//        var $button = $(this);
//        var id = this.id.split('-').pop();
//        if (confirm("Are you sure reject ?  ")) {
//            $button.attr('disabled', true);
//            $.ajax({
//                url: `${webUrl}eleave/overtimeApproval/reject`,
//                type: "POST",
//                data: {
//                    ot_id: id,
//                    "_token": "{{ csrf_token() }}"
//                },
//                dataType: 'json',
//                success: function (data) {
//                    if (data.status == true) {
//                        $table.ajax.reload();
//                        toastr.success(data.message);
//                    }
//
//                },
//                error: function (data) {
//                    toastr.error(data.message);
//                }
//            });
//        }
//    });
</script>

@endsection