@extends('Eleave.layout.main')

@section('title','Eleave | Cash Advance Finance History')

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
            <i class="fa fa-dollar"></i>Cash Advance Finance Approval
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <ul class="nav nav-tabs">
            <li class="">
                <a href="{{url('eleave/cash_advanceApproval/all_request')}}" id="tab1" aria-expanded="false"> Request </a>
            </li>
            <li class="">
                <a href="{{url('eleave/cash_advanceApproval/realization?status=in_process')}}" id="tab2" aria-expanded="false"> Realization </a>
            </li>
            <li class="active">
                <a href="{{url('eleave/cash_advanceApproval/realization?status=done')}}" id="tab3" aria-expanded="true"> History </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tab_1_3">
                <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dt-buttons">
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                        <thead>
                            <tr>
                                <th style="width: 30px">No</th>
                                <th style="width: 110px">Number<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 150px">Employee<br />
                                    <div class="filter-wrapper"></div>
                                </th>
                                <th style="width: 80px">Date<br />
                                    <div class="filter-wrapper-date"></div>
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

                                <th style="width: 80px">Voucher</th>
                                <th style="width: 80">Cheque</th>
                                <th style="width: 70px">Bank Slip</th>

                                <th style="width: 150px">Status
                                </th>
                                <th style="width: 60px">Action</th>

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
                <h3 class="modal-title">Form Processing</h3>
            </div>
            <div class="modal-body">
                <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" value="" name="ca_approver1" id="ca_approver1" />
                    <input type="hidden" value="" name="ca_approver2" id="ca_approver2" />
                    <input type="hidden" value="" name="user_id" id="user_id" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Request Number</label>
                            <div class="col-md-9">
                                <input type="hidden" value="" name="ca_id" id="ca_id" class="form-control"/>
                                <input type="text" value="" name="ca_id_show" id="ca_id_show" class="form-control" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Requester</label>
                            <div class="col-md-9">
                                <input type="text" value="" name="user_name" id="user_name" class="form-control" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Subject</label>
                            <div class="col-md-9">
                                <input type="text" value="" name="subject" id="subject" class="form-control" disabled=""/>
                            </div>
                        </div>
                        <div class="fin1">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Voucher Number</label>
                                <div class="col-md-9">
                                    <input type="text" value="" name="voucher_no" id="voucher_no" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <label class="col-md-6 control-label">Voucher Slip</label>
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="" id="img_voucher" alt="" /> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file fin1_image">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" value="" name="voucher_file" id="voucher_file" accept="image/png, image/jpeg, image/jpg"/>
                                        </span>
                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fin2">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Cheque Number</label>
                                <div class="col-md-9">
                                    <input type="text" value="" name="cheque_no" id="cheque_no" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <label class="col-md-6 control-label">Bank Slip</label>
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="" id="img_cheque" alt="" /> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" value="" name="cheq_file" id="cheq_file" accept="image/png, image/jpeg, image/jpg"/>
                                        </span>
                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-o" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnSave" onclick="process_request()" class="btn btn-info">Submit</button>
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
                                            <span id="subject_show_detail" class="form-control-static">  </span>
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
                                        <label class="control-label col-md-3">Total Amount:</label>
                                        <div class="col-md-9">
                                            <p id="total_real" class="form-control-static"> 0 </p>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Branch:</label>
                                        <div class="col-md-9">
                                            <p id="branch" class="form-control-static">  </p>
                                        </div>
                                    </div>
                                </div>
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
                                        <th nowrap>Amount Realization</th>
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
                        <option value="{{ session("id") }}">Waiting your approve</option>\n\
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
        var url = `${webUrl}eleave/cash_advanceApproval/get_all_data_real`;
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
                    "step": "done",
                    notif: $('#notif').val(),
                    source_id: $('#source_id').val()
                }
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
                    //"visible": false
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
                    "data": "ca_voucher",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ca_cheque",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ca_bank_slip",
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
                [1, "desc"]
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
                $('#subject_show_detail').text(response.data[0].ca_subject);
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
                    html += '<td nowrap><a href=' + response.data[i]['ca_file'] + ' target="_blank"><i class="fa fa-file-image-o"></i></a></td>';
                    html += '</tr>';
                    $('#detailtable').append(html);
                }
            }
        });

    }

</script>

@endsection