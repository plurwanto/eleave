@extends('Eleave.layout.main')

@section('title','Eleave | History Cash Advance List')

@section('style')

@endsection

@section('content')

<!--@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }} 
</div>
@endif-->
<input type="hidden" id="notif" name="notif" value="{{ $notif }}">
<input type="hidden" value="{{ $source_id }}" name="source_id" id="source_id" />
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-dollar"></i>Expenses
        </div>
        <div class="tools">      

        </div>
    </div>
    <div class="portlet-body">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs">
                <li class="">
                    <a href="{{url('eleave/cash_advance?index=1')}}" id="tab1" aria-expanded="false"> Request </a>
                </li>
                <li class="">
                    <a href="{{url('eleave/cash_advance?index=2')}}" id="tab2" aria-expanded="false"> Realization </a>
                </li>
                <li class="active">
                    <a href="{{url('eleave/cash_advance?index=done')}}" id="tab3" aria-expanded="true"> History </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab_1_3">
                    <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dt-buttons">
<!--                                    <a class="btn btn-info btn-circle" tabindex="0" aria-controls="sample_2" href="{{ URL::to('eleave/cash_advance/add') }}"><i class="fa fa-plus"></i> Add Request</a>-->
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width: 120px">Req Number<br />
                                        <div class="filter-wrapper"></div></th>
                                    <th style="width: 100px">Date<br />
                                        <div class="filter-wrapper-date"></div>
                                    </th>
                                    <th style="width: 150px">Subject<br />
                                        <div class="filter-wrapper"></div>
                                    </th>
                                    <th style="width: 80px">Total Cost</th>
                                    <th style="width: 80px">Realization</th>
                                    <th style="width: 150px">Status</th>
                                    <th style="width: 130px">Action</th>
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
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">View Cash Advance Detail</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <h3 class="form-section">Person Info</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Number:</label>
                                    <div class="col-md-6">
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
                                    <label class="control-label col-md-3">Cash Advance:</label>
                                    <div class="col-md-9">
                                        <p id="total" class="form-control-static"> 0 </p>
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
                                    <th nowrap>Amount Request</th>
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
    var $table;
    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-small").html(
                    '<input type="text" class="filter form-control"  placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-100").html(
                    '<input type="text" class="filter form-control"  placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-date").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date"  placeholder="Filter ' +
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
        });

        if ($('#notif').val() == "notif") {
            var url = `${webUrl}eleave/cash_advance/getdataNotif`;
        } else {
            var url = `${webUrl}eleave/cash_advance/getdataRealization`;
        }

        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": {
                    "step": "done",
                    "_token": "<?=csrf_token()?>",
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
                    "orderable": false
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
            "pageLength": 10,
            lengthMenu: [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            order: [
                [2, "desc"]
            ],
        });

//    new $.fn.dataTable.FixedColumns($table, {
//        leftColumns: 4,
//        rightColumns: 2
//    });

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
        //    buat datepicker ga scroll
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
    function show_detail(id, ca_id) {
        $('#user_id').val(id);
        $('#modal_form').modal('show');
        //$('.modal-title').text('Detail');
        $.ajax({
            type: "POST",
            "url": `${webUrl}eleave/cash_advance/getDetail`,
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
                //alert(response)
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