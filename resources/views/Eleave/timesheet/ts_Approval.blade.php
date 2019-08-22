@extends('Eleave.layout.main')

@section('title','Eleave | Timesheet List Approval')

@section('style')

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
            <i class="fa fa-clock-o"></i>Timesheet List Approval
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
            <thead>
                <tr>
                    <th style="width: 5px">No</th>
                    <th>ID</th>
                    <th style="width: 80px">Type<br />
                        <div class="filter-wrapper-type"></div>
                    </th>
                    <th style="width: 110px">Employee<br />
                        <div class="filter-wrapper"></div>
                    </th>
                    <th style="width: 105px">Start Date<br />
                        <div class="filter-wrapper-date"></div>
                    </th>
                    <th style="width: 105px">End Date<br />
                        <div class="filter-wrapper-date"></div>
                    </th>
                    <th style="width: 53px">Days<br />
                        <div class="filter-wrapper-small"></div>
                    </th>
                    <th style="width: 150px">Location<br />
                        <div class="filter-wrapper-100"></div>
                    </th>
                    <th style="width: 300px">Activity<br />
                        <div class="filter-wrapper"></div>
                    </th>

                    <th style="width: 90px">Submit Date</th>
                    <th style="width: 110px">Approver 1</th>
                    <th style="width: 110px">Approver 2</th>
                    <th style="width: 110px">Approver 3</th>

                    <th style="width: 50px; text-align: left">Year</th>
                    <th style="width: 70px">Month</th>
                    <th style="width: 60px">Active
                        <div class="filter-wrapper-active"></div>
                    </th>
                    <th style="width: 230px">Status<br />
                        <div class="filter-wrapper-status"></div>
                    </th>
                    <th style="width: 115px">Action</th>

                </tr>
            </thead>

            <!--            <thead>
                <tr></tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="text" data-column="1" class="search-input-text form-control input-sm" placeholder="Search">
                    </td>
                    <td><input type="text" data-column="2" class="search-input-text form-control input-sm" placeholder="Search"></td>
                    <td><input type="text" data-column="3" class="search-input-text form-control input-sm" placeholder="Search"></td>
                    <td><input type="text" data-column="4" class="search-input-text form-control input-sm" placeholder="Search"></td>
                    <td><input type="text" data-column="5" class="search-input-text form-control input-sm" placeholder="Search"></td>
                    <td><input type="text" data-column="6" class="search-input-text form-control input-sm" placeholder="Search"></td>
                    <td><input type="text" data-column="7" class="search-input-text form-control input-sm" placeholder="Search"></td>
                    <td><input type="text" data-column="8" class="search-input-text form-control input-sm" placeholder="Search"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>                  
                    <td></td>
                    <td></td>
                    <td></td>                  
                </tr>
            </thead>-->
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
            <div class="modal-body">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="user_id" id="user_id" />
                    <input type="hidden" value="" name="ts_id" id="ts_id" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Reason</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" placeholder="Enter reason"
                                          id="ts_reason" name="ts_reason" maxlength="255"></textarea>
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
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_detail" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">List Detail</h3>
            </div>
            <div class="modal-body">
                <div class="table table-responsive" id="tbldata" style="height:300px; width:100%;overflow: auto;">
                    <form action="#" id="form_detail" class="form-horizontal">
                        <table id="detailtable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th nowrap>No</th>
                                    <th nowrap>Date</th>
                                    <th id="th_time_in_group" nowrap>Time In</th>
                                    <th id="th_time_out_group" nowrap>Time Out</th>
                                    <th id="th_total_time_group" nowrap>Total Time</th>
                                    <th id="th_location_group" nowrap>Location</th>
                                    <th nowrap>Activity</th>

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
<script type="text/javascript">
// Server-side processing with object sourced data
    var $table;
    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-small").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-date").html(
                    '<input type="text" class="filter form-control datepicker" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-type").html(
                    '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="Timesheet">Timesheet</option>\n\
                        <option value="Absent">Absent</option>\n\
                     </select>'
                    );
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
            var url = `${webUrl}eleave/timesheetApproval/getdataNotif`;
        } else {
            var url = `${webUrl}eleave/timesheetApproval/getdata`;
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
                    "data": "ts_id",
                    "searchable": false,
                    "orderable": false,
                    "visible": false
                },
                {
                    "data": "ts_type",
                    "orderable": false
                },
                {
                    "data": "user_name",
                    "orderable": true
                },
                {
                    "data": "ts_date",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "ts_end_date",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ts_total_time",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ts_location",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ts_activity",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ts_submit_date",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "approver1",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "approver2",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "approver3",
                    "searchable": false,
                    "orderable": false
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
                    "orderable": false
                },
                {
                    "data": "action",
                    "searchable": false,
                    "orderable": false
                },
            ],

            scrollY: 350,
            scrollX: true,
            //scrollCollapse: true,
            "pageLength": ($('#notif').val() == "notif" ? 1000 : 10),
            lengthMenu: [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            order: [
                [9, "desc"]
            ],
            "fnDrawCallback": function (oSettings) {
                if ($('#notif').val() == "notif") {
                    $('.dataTables_paginate').hide();
                    $('.dataTables_length').hide();
                }
            }
        });

        if ($('#user_act').val() == "Active") {
            $table.columns(15).search("Active").draw();
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

    function setdatepicker() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
        });
    }

    function revisi_this(ts_id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#ts_id').val(ts_id);
        // $('#user_id').val(user_id);
        $('.modal-title').text('Revision Form');

    }
    
    function reject_this(ts_id) {
        save_method = 'reject';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#ts_id').val(ts_id);
        $('.modal-title').text('Reject Form');
    }

    function save_status() {
        var url;
        if (save_method == 'update') {
            if ($('#ts_reason').val() == '') {
                alert('Enter revise reason');
                return false;
            }
            url = `${webUrl}eleave/timesheetApproval/revise`;

        } else if (save_method == 'reject') {
            url = `${webUrl}eleave/timesheetApproval/reject`;
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


//    function approve_this(id, next) {
//        $.ajax({
//            url: '{{ URL::to("eleave/timesheetApproval/approve") }}',
//            //  url: '{{ URL::to("eleave/timesheetApproval/reject") }}',
//            type: "POST",
//            data: {ts_id: id, next: next, "_token": "{{ csrf_token() }}"},
//            dataType: 'json',
//            success: function (data)
//            {
//                location.reload();
//                // alert(data);
//            },
//            error: function (jqXHR, textStatus, errorThrown)
//            {
//            }
//        });
//    }
//
//    function reject_this(id) {
//        if (confirm("Are you sure reject ?  "))
//        {
//            $.ajax({
//                url: '{{ URL::to("eleave/timesheetApproval/reject") }}',
//                //  url: '{{ URL::to("eleave/timesheetApproval/reject") }}',
//                type: "POST",
//                data: {ts_id: id, "_token": "{{ csrf_token() }}"},
//                dataType: 'json',
//                success: function (data)
//                {
//                    location.reload();
//                    // alert(data);
//                },
//                error: function (jqXHR, textStatus, errorThrown)
//                {
//                }
//            });
//        }
//    }

    function show_detail(id, ts_id, tipe) {
        $('#user_id').val(id);
        $('#ts_id').val(ts_id);
        $('#modal_form_detail').modal('show');
        $('.modal-title').text('Detail');

        $.ajax({
            type: "POST",
            "url": `${webUrl}eleave/timesheet/getDetail`,
            //url: '{{ URL::to("eleave/timesheet/getDetail") }}',
            dataType: 'json',
            data: {
                id: id,
                ts_id: ts_id,
                "_token": "{{ csrf_token() }}"
            },
            //cache: false,
            success: function (response) {
                if (tipe == "Absent") {
                    $('#th_time_in_group').hide('');
                    $('#th_time_out_group').hide('');
                    $('#th_total_time_group').hide('');
                    $('#th_location_group').hide('');
                } else {
                    $('#th_time_in_group').show('');
                    $('#th_time_out_group').show('');
                    $('#th_total_time_group').show('');
                    $('#th_location_group').show('');
                }

                $('table#detailtable tr#baris').remove();
                //alert(response)
                for (var i = 0; i < response.data.length; i++) {
                    x = i + 1;
                    html = '<tr id="baris">';
                    html += '<td nowrap> ' + x + '</td>';
                    html += '<td nowrap> ' + response.data[i]['ts_date'] + '</td>';
                    if (tipe == "Timesheet") {
                        html += '<td nowrap> ' + response.data[i]['ts_time_in'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['ts_time_out'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['ts_total_time'] + '</td>';
                        html += '<td> ' + response.data[i]['ts_location'] + '</td>';
                    }
                    html += '<td> ' + response.data[i]['ts_activity'] + '</td>';
                    html += '</tr>';
                    $('#detailtable').append(html);
                }
            }
        });

    }

    function setdatepicker() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
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
            url: `${webUrl}eleave/timesheetApproval/approve`,
            type: "POST",
            data: {
                ts_id: arr[0],
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
//                url: `${webUrl}eleave/timesheetApproval/reject`,
//                type: "POST",
//                data: {
//                    ts_id: id,
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