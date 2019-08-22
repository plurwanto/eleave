@extends('Eleave.layout.main')

@section('title','Eleave | Leave List Approval')

@section('style')
<!--<link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />-->
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
            <i class="fa fa-clock-o"></i>Leave List Approval
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
            <thead>
                <tr>
                    <th style="width: 5px">No</th>
                    <th>ID</th>
                    <th style="width: 90px">Type<br />
                        <div class="filter-wrapper-type"></div>
                    </th>
                    <th style="width: 110px">Employee<br />
                        <div class="filter-wrapper"></div>
                    </th>
                    <th style="width: 105px">Start Date<br />
                        <div class="filter-wrapper-date-start"></div>
                    </th>
                    <th style="width: 105px">End Date<br />
                        <div class="filter-wrapper-date-end"></div>
                    </th>
                    <th style="width: 53px">Days<br />
                        <div class="filter-wrapper-small"></div>
                    </th>
                    <th style="width: 250px">Reason<br />
                        <div class="filter-wrapper"></div>
                    </th>

                    <th style="width: 90px">Submit Date</th>
                    <th style="width: 110px">Approver 1</th>
                    <th style="width: 110px">Approver 2</th>
                    <th style="width: 110px">Approver 3</th>
                    <th style="width: 50px">Year</th>
                    <th style="width: 70px">Month</th>
                    <th style="width: 60px">Active
                        <div class="filter-wrapper-active"></div>
                    </th>
                    <th style="width: 230px">Status<br />
                        <div class="filter-wrapper-status"></div>
                    </th>
                    <th style="width: 85px">Action</th>

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
                    <input type="hidden" value="" name="lv_id" id="lv_id" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Reason</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" placeholder="Enter reason"
                                          id="lv_reason" name="lv_reason" maxlength="255"></textarea>
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
<!--<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.min.js') }}" type="text/javascript"></script>-->
<script type="text/javascript">
// Server-side processing with object sourced data
    var $table;
    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-small").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-date-start").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-date-end").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-type").html(
                    '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="Annual Leave">Annual Leave</option>\n\
                        <option value="Emergency Leave">Emergency Leave</option>\n\
                        <option value="Unpaid Leave">Unpaid Leave</option>\n\
                        <option value="Medical Leave">Medical Leave</option>\n\
                        <option value="Marriage Leave">Marriage Leave</option>\n\
                        <option value="Maternity Leave">Maternity Leave</option>\n\
                        <option value="Compassionate Leave">Compassionate Leave</option>\n\
                        <option value="Study Leave">Study Leave</option>\n\
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
            var url = `${webUrl}eleave/leaveApproval/getdataNotif`;
        } else {
            var url = `${webUrl}eleave/leaveApproval/getdata`;
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
                    "data": "lv_id",
                    "searchable": false,
                    "orderable": false,
                    "visible": false
                },
                {
                    "data": "lv_type",
                    "orderable": false,
                },
                {
                    "data": "user_name",
                    "orderable": true,
                },
                {
                    "data": "lv_start_date",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "lv_end_date",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "days",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "detail",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "lv_submit_date",
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
                    "orderable": false
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
            //scrollCollapse: true,
            "pageLength": ($('#notif').val() == "notif" ? 1000 : 10),
            lengthMenu: [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            order: [
                [8, "desc"]
            ],
            "fnDrawCallback": function (oSettings) {
                if ($('#notif').val() == "notif") {
                    $('.dataTables_paginate').hide();
                    $('.dataTables_length').hide();
                }
            }
        });
       // $('.select2').select2();
        
        if ($('#user_act').val() == "Active") {
            $table.columns(11).search("Active").draw();
        }

        new $.fn.dataTable.FixedColumns($table, {
            leftColumns: 5,
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

        toastr.options = {
            "closeButton": true,
        };

    });

    function setdatepicker() {
        $('.datepicker').datepicker({
            format: 'dd M yy',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
        })
                .on("change", function () {
                    var value = $(this).val();
                    var parent_scroll = $(this).parent().attr('class');
                    if (parent_scroll == 'filter-wrapper-date-start') {
                        $('.DTFC_LeftWrapper .filter-wrapper-date-start #src_date').val(value);
                    } else if (parent_scroll == 'filter-wrapper-date-end') {
                        $('.DTFC_LeftWrapper .filter-wrapper-date-end #src_date').val(value);
                    }
                });
    }

    function revisi_this(lv_id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#lv_id').val(lv_id);
        // $('#user_id').val(user_id);
        $('.modal-title').text('Revision Form');

    }
    
    function reject_this(lv_id) {
        save_method = 'reject';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#lv_id').val(lv_id);
        $('.modal-title').text('Reject Form');
    }

    function save_status() {
        var url;
        if (save_method == 'update') {
            if ($('#lv_reason').val() == '') {
                alert('Enter revise reason');
                return false;
            }
            url = `${webUrl}eleave/leaveApproval/revise`;

        } else if (save_method == 'reject') {
            url = `${webUrl}eleave/leaveApproval/reject`;
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
//            url: '{{ URL::to("eleave/leaveApproval/approve") }}',
//            //  url: '{{ URL::to("eleave/leaveApproval/reject") }}',
//            type: "POST",
//            data: {lv_id: id, next: next, "_token": "{{ csrf_token() }}"},
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

//    function reject_this(id) {
//        if (confirm("Are you sure reject ?  "))
//        {
//            $.ajax({
//                url: '{{ URL::to("eleave/leaveApproval/reject") }}',
//                type: "POST",
//                data: {lv_id: id, "_token": "{{ csrf_token() }}"},
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

    function show_detail(id, lv_id, tipe) {
        $('#user_id').val(id);
        $('#lv_id').val(lv_id);
        $('#modal_form_detail').modal('show');
        $('.modal-title').text('Detail');

        $.ajax({
            type: "POST",
            "url": `${webUrl}eleave/leave/getDetail`,
            //url: '{{ URL::to("eleave/leave/getDetail") }}',
            dataType: 'json',
            data: {
                id: id,
                lv_id: lv_id,
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
                    html += '<td nowrap> ' + response.data[i]['lv_date'] + '</td>';
                    if (tipe == "Leave") {
                        html += '<td nowrap> ' + response.data[i]['lv_time_in'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['lv_time_out'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['lv_total_time'] + '</td>';
                        html += '<td> ' + response.data[i]['lv_location'] + '</td>';
                    }
                    html += '<td> ' + response.data[i]['lv_activity'] + '</td>';
                    html += '</tr>';
                    $('#detailtable').append(html);
                }
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
            url: `${webUrl}eleave/leaveApproval/approve`,
            type: "POST",
            data: {
                lv_id: arr[0],
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
                if (data.status == false) {
                    $table.ajax.reload();
                    toastr.error(data.message);
                }
            }
        });
    });

//    $(document).on('click', '.reject', function () {
//        var $button = $(this);
//        var id = this.id.split('-').pop();
//        if (confirm("Are you sure reject ?  ")) {
//            $button.attr('disabled', true);
//            $.ajax({
//                url: `${webUrl}eleave/leaveApproval/reject`,
//                type: "POST",
//                data: {
//                    lv_id: id,
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