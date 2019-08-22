@extends('Eleave.layout.main')

@section('title','Eleave | Cash Advance List Approval')

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
            <i class="fa fa-dollar"></i>Cash Advance List Approval
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <ul class="nav nav-tabs">
            <li class="">
                <a href="{{url('eleave/cash_advanceApproval?index=1')}}" id="tab1" aria-expanded="false"> Request <span id="amount_req" class=""> </span></a>
            </li>
            <li class="active">
                <a href="{{url('eleave/cash_advanceApproval?index=2')}}" id="tab2" aria-expanded="true"> Realization <span id="amount_real" class=""> </span></a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tab_1_1">
                <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dt-buttons">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="txtnotifreq">
                    <input type="hidden" id="txtnotifreal">
                    <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                        <thead>
                            <tr>
                                <th style="width: 30px">No</th>
                                <th>Number</th>
                                <th style="width: 150px">Employee<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 80px">Date<br />
                                    <div class="filter-wrapper-date-start"></div>
                                </th>
                                <th style="width: 80px">Subject<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 80px">Cost<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 80px">Realization<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 80px">Submit Date</th>
                                <th style="width: 110px">Approver 1</th>
                                <th style="width: 110px">Approver 2</th>
                                <th style="width: 110px">Approver 3</th>

                                <th style="width: 50px; text-align: left">Year</th>
                                <th style="width: 90px">Month</th>
                                <th style="width: 150px">Status<br />
                                    <div class="filter-wrapper-status"></div>
                                </th>
                                <th style="width: 110px">Action</th>

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
                    <input type="hidden" value="" name="ca_id" id="ca_id" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Reason</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" placeholder="Enter reason"
                                          id="ca_reason" name="ca_reason" maxlength="255"></textarea>
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
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <h3 class="form-section">Person Info</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Number:</label>
                                        <div class="col-md-6">
                                            <input type="hidden" value="" name="ca_id_detail" id="ca_id_detail" />
                                            <p id="number" class="form-control-static">  </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Subject:</label>
                                        <div class="col-md-9">
                                            <span id="subject" class="form-control-static">  </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Date:</label>
                                        <div class="col-md-9">
                                            <p id="date" class="form-control-static">  </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Total:</label>
                                        <div class="col-md-9">
                                            <p id="total" class="form-control-static">  </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Name:</label>
                                        <div class="col-md-9">
                                            <p id="name" class="form-control-static">  </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Total Realization:</label>
                                        <div class="col-md-9">
                                            <p id="total_real" class="form-control-static">  </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Department:</label>
                                        <div class="col-md-9">
                                            <p id="dept" class="form-control-static">  </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Branch:</label>
                                        <div class="col-md-9">
                                            <p id="branch" class="form-control-static">  </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Balance:</label>
                                        <div class="col-md-9">
                                            <p id="balance" class="form-control-static"> 0 </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <h3 class="form-section">Detail Info</h3>
                        </div>

                    </form>
                    <div class="table table-responsive" id="tbldata" style="height:200px; width:100%;overflow: auto;">
                        <form action="#" id="form" class="form-horizontal">
                            <table id="detailtable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th nowrap>No</th>
                                        <th nowrap>Date</th>
                                        <th nowrap>Project Cost Center</th>
                                        <th nowrap>Detail</th>
                                        <th nowrap>Amount</th>
                                        <th nowrap>Realization</th>
                                        <th nowrap>File</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </form>
                    </div>
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
            $(this).find(".filter-wrapper-date-start").html(
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
                        <option value="{{ session("id") }}">Waiting your approval</option>\n\
                        <option value="4">Waiting other approval</option>\n\
                        <option value="3">Approved request</option>\n\
                        <option value="6">Approve realization</option>\n\
                        <option value="11">Revision</option>\n\
                        <option value="10">Rejected</option>\n\
                    </select>'
                    );
        });

//        if ($('#notif').val() == "notif") {
//            var url = `${webUrl}eleave/cash_advanceApproval/getdataNotif`;
//        } else {
        var url = `${webUrl}eleave/cash_advanceApproval/getdataRealization`;
        //  }

        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": {
                    "_token": "<?=csrf_token()?>",
                    "step": 2,
                    notif: $('#notif').val(),
                    source_id: $('#source_id').val()
                },
                dataSrc: function (data) {
                    totalNotifReq = data.totNotifReq || 0;
                    totalNotifReal = data.totNotifReal || 0;
                    return data.data;
                },          
            },
            dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "columns": [{
                    "data": "no",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ca_id",
                    "searchable": false,
                    "orderable": false,
                    "visible": false
                },
                {
                    "data": "user_name",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "ca_date",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "ca_subject",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ca_total",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ca_total_real",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ca_submit_date",
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
                [7, "desc"]
            ],
            "fnDrawCallback": function (oSettings) {
                if ($('#notif').val() == "notif") {
                    $('.dataTables_paginate').hide();
                    $('.dataTables_length').hide();
                }
                $('#txtnotifreq').val(totalNotifReq);
                $('#txtnotifreal').val(totalNotifReal);
                ($('#txtnotifreq').val() > 0 ? $('#amount_req').addClass('badge badge-empty badge-danger') : $('#amount_req').removeClass('badge badge-empty badge-danger'));
                ($('#txtnotifreal').val() > 0 ? $('#amount_real').addClass('badge badge-empty badge-danger') : $('#amount_real').removeClass('badge badge-empty badge-danger'));
            }
        });

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

    function revisi_this(id, ca_id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#ca_id').val(ca_id);
        $('#user_id').val(id);
        $('.modal-title').text('Revision Form');

    }

    function reject_this(id, ca_id) {
        save_method = 'reject';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#ca_id').val(ca_id);
        $('#user_id').val(id);
        $('.modal-title').text('Reject Form');

    }

    function save_status() {
        if ($('#ca_reason').val() != '') {
            $('#btnSave').text('Updating...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;

            if (save_method == 'update') {
                url = `${webUrl}eleave/cash_advanceApproval/revise`;
            } else {
                url = `${webUrl}eleave/cash_advanceApproval/reject`;
            }

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
        } else {
            alert('Enter reason');
            return false;
        }
    }

    function show_detail(id, ca_id) {
        $('#user_id').val(id);
        $('#ca_id_detail').val(ca_id);
        $('#modal_form_detail').modal('show');
        $('.modal-title').text('Detail');

        $.ajax({
            type: "POST",
            "url": `${webUrl}eleave/cash_advanceApproval/getDetail`,
            dataType: 'json',
            data: {
                id: id,
                ca_id: ca_id,
                "_token": "{{ csrf_token() }}"
            },
            //cache: false,
            success: function (response) {
                $('#number').html(response.data[0].ca_id);
                $('#subject').text(response.data[0].ca_subject);
                $('#date').text(response.data[0].ca_date);
                $('#total').text(response.data[0].ca_total);
                $('#total_real').text(response.data[0].ca_total_real);
                $('#name').text(response.data[0].ca_username);
                $('#dept').text(response.data[0].ca_dept);
                $('#branch').text(response.data[0].ca_branch);
                $('#balance').text(response.data[0].ca_total - response.data[0].ca_total_real);
                $('table#detailtable tr#baris').remove();
                for (var i = 0; i < response.data.length; i++) {
                    x = i + 1;
                    html = '<tr id="baris">';
                    html += '<td nowrap> ' + x + '</td>';
                    html += '<td nowrap> ' + response.data[i]['ca_date_detail'] + '</td>';
                    html += '<td nowrap> ' + response.data[i]['ca_project'] + '</td>';
                    html += '<td nowrap> ' + response.data[i]['ca_detail_project'] + '</td>';
                    html += '<td nowrap> ' + response.data[i]['ca_amount'] + '</td>';
                    html += '<td nowrap> ' + response.data[i]['ca_realization'] + '</td>';
                    //html += '<td nowrap><a href=' + response.data[i]['ca_file'] + ' target="_blank"><i class="fa fa-file-image-o"></i></a></td>';
                    html += '<td nowrap>' + response.data[i]['ca_file'] + '</td>';
                    html += '</tr>';
                    $('#detailtable').append(html);
                }
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
                    } else if (parent_scroll === 'filter-wrapper-date-end') {
                        $('.datepicker-dropdown').css({
                            top: 250.15,
                            left: 532,
                        });
                    }
                })
                .on("change", function () {
                    var value = $(this).val();
                    var parent_scroll = $(this).parent().attr('class');
                    if (parent_scroll === 'filter-wrapper-date-start') {
                        $('.DTFC_LeftWrapper .filter-wrapper-date-start #src_date').val(value);
                    } else if (parent_scroll === 'filter-wrapper-date-end') {
                        $('.DTFC_LeftWrapper .filter-wrapper-date-end #src_date').val(value);
                    }
                });
    }
</script>

<script>
    $(document).on('click', '.approve', function () {
        var $button = $(this);
        if (confirm("Are you sure approve ?  ")) {
            $button.attr('disabled', true);
            var arr = this.id.split('|');
            $.ajax({
                url: `${webUrl}eleave/cash_advanceApproval/approve`,
                type: "POST",
                data: {
                    ca_id: arr[0],
                    user_id: arr[1],
                    next: arr[2],
                    approver_user: arr[3], //next user id approver
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
        }
    });

//    $(document).on('click', '.reject', function () {
//        var $button = $(this);
//        //var id = this.id.split('-').pop();
//        var id = this.id.split('|');
//        if (confirm("Are you sure reject ?  ")) {
//            $button.attr('disabled', true);
//            $.ajax({
//                url: `${webUrl}eleave/cash_advanceApproval/reject`,
//                type: "POST",
//                data: {
//                    id: id[0],
//                    user_id: id[1],
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