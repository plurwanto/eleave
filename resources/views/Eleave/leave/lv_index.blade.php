@extends('Eleave.layout.main')

@section('title','Eleave | Leave List')

@section('style')
<style>
/*    .DTFC_LeftBodyLiner,
    .DTFC_RightBodyLiner {
        max-height: unset !important;
    }

    .DTFC_LeftFootWrapper,
    .DTFC_RightFootWrapper {
        top: -1px !important;
    }

    .DTFC_RightFootWrapper .table {
        border-left: unset !important;
    }

    .DTFC_LeftFootWrapper .table {
        border-right: unset !important;
    }

    .DTFC_LeftFootWrapper .blank {
        border-right: unset !important;
    }
    
    .dataTables_scrollFootInner {
        display: none;
    }

    .blank {
        border-top: 1px solid #e7ecf1 !important;
        border-right: unset !important;
    }

    .total {
        border-top: 1px solid #e7ecf1 !important;
        border-right: 1px solid #e7ecf1 !important;
    }

    .total_day,
    .total_bf {
        border: 1px solid #e7ecf1 !important;
        border-bottom: unset !important;
        border-left: unset !important;
    }*/
</style>

<link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet"
      type="text/css" />
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
            <i class="fa fa-calendar-times-o"></i>Leave List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">
                        <a class="btn btn-default btn-circle btn-sm" tabindex="0" aria-controls="sample_2"
                           href="{{ URL::to('eleave/leave/check') }}"><i class="fa fa-plus"></i> Add Leave</a>
                        <a href="#" onclick="show_log()" class="btn btn-default btn-circle btn-sm" title="Log History"><i class="fa fa-history"></i>  </a>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                <thead>
                    <tr>
                        <!--                        column width sudah fix, please don't change..-->
                        <th style="width: 5px">No</th>
                        <th style="width: 90px">Type<br />
                            <div class="filter-wrapper-type"></div>
                        </th>
                        <th style="width: 105px">Start Date<br />
                            <div class="filter-wrapper-date-start"></div>
                        </th>
                        <th style="width: 105px">End Date<br />
                            <div class="filter-wrapper-date-end"></div>
                        </th>

                        <th style="width: 55px">Days<br />
                            <div class="filter-wrapper-small"></div>
                        </th>
                        <th style="width: 55px">BF<br />
                            <div class="filter-wrapper-small"></div>
                        </th>
                        <th style="width: 250px">Reason<br />
                            <div class="filter-wrapper"></div>
                        </th>

                        <th style="width: 90px">Submit Date</th>
                        <th class="text-right" style="width: 50px">Year</th>
                        <th style="width: 70px">Month</th>
                        <th style="width: 240px">Status<br />
                            <div class="filter-wrapper-status"></div>
                        </th>
                        <th style="width: 60px">Action</th>

                    </tr>
                </thead>
                    
<!--                <tfoot>
                    <tr>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="total"></td>
                        <td class="total_day"></td>
                        <td class="total_bf"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                    </tr>
                </tfoot>-->
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right;"></th>
                        <th style="font-size: 12px;" class="text-nowrap"></th>
                        <th style="font-size: 12px;" class="text-nowrap"></th>
                        <th colspan="6" ></th>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
                 
            </table>

        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade bs-modal-lg" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Log History</h3>
            </div>
            <div class="modal-body form">
                <div class="form-body">
                    <form id="frm_search" name="frm_search" action="" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-3">Period</label>
                            <div class="col-md-8">
                                <div class="input-group input-medium date-picker input-daterange" style="float: left" data-date="" data-date-format="mm/dd/yyyy">
                                    <input type="text" class="form-control" name="from" id="from">
                                    <span class="input-group-addon"> to </span>
                                    <input type="text" class="form-control" name="to" id="to"> 
                                </div>

                                &nbsp;
                                <button onclick="show_log();" title="search" class="btn blue" type="button"> <i class="fa fa-search"></i></button>
                                <button id="export-btn" name="export-btn" title="export xls" class="btn green" style="margin-left: 3px;" type="button"> <i class="fa fa-file-excel-o"></i></button>
                                <!-- /input-group -->
                            </div>
                        </div>
                    </form>

                    <div class="table table-responsive" id="tbldata" style="height:300px; width:100%;overflow: auto;">
                        <form action="#" id="form" class="form-horizontal">
                            <table id="detailtable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Submit Date</th>
                                        <th>Leave Type</th>
                                        <th>Description</th>
                                        <th>Agent</th>
                                        <th>Status</th>
                                        <th>Last Update</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>
<!-- End Bootstrap modal -->

@endsection

@section('script')
@include('Eleave/notification')
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.table2excel.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    var $table;

    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-small").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-date-start").html(
                    '<input type="text" autocomplete="off" class="filter form-control datepicker" id="src_date" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-date-end").html(
                    '<input type="text" autocomplete="off" class="filter form-control datepicker" id="src_date" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-type").html(
                    '<select class="filter form-control" >\n\
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
        });

        if ($('#notif').val() == "notif") {
            var url = `${webUrl}eleave/leave/getdataNotif`;
        } else {
            var url = `${webUrl}eleave/leave/getdata`;
        }

        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": {
                    "_token": "<?=csrf_token()?>"
                },
                dataSrc: function (data) {
                    totalDay = data.totalDays || 0;
                    totalBf = data.totalBf || 0;
                    return data.data;
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
                    "data": "lv_type",
                    "searchable": false,
                    "orderable": false
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
                    "orderable": false
                },
                {
                    "data": "bf",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "detail",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "lv_submit_date",
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
            columnDefs: [{
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap'>" + data + "</div>";
                    },
                    targets: [4]
                }],
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

            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,day(s)]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Total over this page
                pageTotalDays = api
                    .column(4, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    pageTotalBf = api
                    .column(5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
             //   $('.total_day').html(pageTotalDays + ' day(s)');
                $(api.column(4).footer()).html(pageTotalDays + " of " + totalDay);
                $(api.column(5).footer()).html(pageTotalBf + " of " + totalBf);
                var tableinfo = $table.page.info();
                if (tableinfo.recordsDisplay == 0 || isNaN(tableinfo.recordsDisplay)) {
                    $(".DTFC_Cloned tfoot tr").css("display", "none");
                    $(".DTFC_LeftFootWrapper").css("display", "none");   // fix display footer if record is empty
                    $(".DTFC_RightFootWrapper").css("display", "none");
                } else {
                    $(".DTFC_LeftWrapper").css({"display": "block"});
                    $(".DTFC_LeftWrapper .DTFC_Cloned tfoot tr").css({"display": "block", "height": "28px"});
                    $(".DTFC_RightWrapper .DTFC_Cloned tfoot tr").css({"display": "block", "height": "28px"});
                    $(".DTFC_LeftFootWrapper").css("display", "none");
                    $(".DTFC_RightFootWrapper").css("display", "none");
                }
                
            },
            "fnInitComplete": function () {
                // Disable scrolling in Head
                $('.dataTables_scrollHead').css({
                    'overflow-y': 'hidden !important'
                });

                // Disable TBODY scroll bars
                $('.dataTables_scrollBody').css({
                    'overflow-y': 'scroll',
                    'overflow-x': 'hidden',
                    'border': 'none',
                });

                // Enable TFOOT scoll bars
                $('.dataTables_scrollFoot').css('overflow', 'auto');

                //  Sync TFOOT scrolling with TBODY
                $('.dataTables_scrollFoot').on('scroll', function () {
                    $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                });

            },
                  
//            drawCallback: function (data, settings) {
//                // var api = this.api();
//                // $(api.column(1).footer()).html('Total');
//                // $(api.column(4).footer()).html(totalDay);
//                // $(api.column(5).footer()).html(totalBf);
//                $('.total').html('Total');
//                $('.total_day').html(totalDay + ' day(s)');
//                $('.total_bf').html(totalBf + ' day(s)');
//
//                var tableinfo = $table.page.info();
//                if (tableinfo.recordsDisplay == 0 || isNaN(tableinfo.recordsDisplay)) {
//                    $(".DTFC_LeftWrapper").css("display", "none");
//                    $(".DTFC_Cloned tfoot tr").css("display", "none");
//                } else {
//                    $(".DTFC_LeftWrapper").css({"display": "block"});
//                    $(".DTFC_LeftWrapper .DTFC_Cloned tfoot tr").css({"display": "block", "height": "28px"});
//                    $(".DTFC_RightWrapper .DTFC_Cloned tfoot tr").css({"display": "block", "height": "28px"});
//                }
//            },

        });



        new $.fn.dataTable.FixedColumns($table, {
            leftColumns: 4,
            rightColumns: 2
        });
        $table.columns().eq(0).each(function (colIdx) {
            $('input', $table.column(colIdx).header()).on('keyup change', function () {
                $table
                        .column(colIdx)
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

        $('.date-picker').datepicker({
            //format: 'dd M yy',
            format: 'yyyy-mm-dd',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
        });

        $('#export-btn').prop('disabled', true);

        $('#export-btn').on('click', function (e) {
            e.preventDefault();
            ResultsToTable();
        });

        function ResultsToTable() {
            $("#detailtable").table2excel({
                filename: "log_hitory_leave",
                name: "Results"
            });
        }

    });

    function setdatepicker() {
        //    buat datepicker ga scroll
        //    $('.datepicker').on("click", function () {
        //                    alert($(this).parent().outerWidth())
        //                })
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
</script>

<script>
    $(document).on('click', '.reject', function () {
        if (confirm("Are you sure delete ?  ")) {
            var $button = $(this);
            var id = this.id.split('-').pop();
            $.ajax({
                type: 'POST',
                url: `${webUrl}eleave/leave/delete`,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },

                success: function (data) {
                    if (data.status == true) {
                        $table.row($button.parents('tr')).remove().draw();
                        toastr.success(data.message);
                    }
                },
                error: function (data) {
                    toastr.error(data.message);
                }
            });
        }
    });

    function show_log() {
        $('table#detailtable tr#baris').remove();
        $('#modal_form').modal('show');
//                $('#from').val('');
//                $('#to').val('');
        $.ajax({
            type: "GET",
            "url": `${webUrl}eleave/leave/showTransLog`,
            dataType: 'json',
            data: {
                "from": $('#from').val(),
                "to": $('#to').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function (response) {
                for (var i = 0; i < response.result_log.length; i++) {
                    x = i + 1;
                    html = '<tr id="baris">';
                    html += '<td nowrap> ' + x + '</td>';
                    html += '<td nowrap> ' + response.result_log[i].trans_submit_date + '</td>';
                    html += '<td nowrap> ' + response.result_log[i].trans_type + '</td>';
                    html += '<td> ' + response.result_log[i].description + '</td>';
                    html += '<td nowrap> ' + response.result_log[i].submit_by_name.split(/(\s).+\s/).join("") + '</td>';
                    html += '<td> ' + response.result_log[i].trans_status + '</td>';
                    html += '<td nowrap> ' + response.result_log[i].submit_date + '</td>';
                    html += '</tr>';
                    $('#detailtable').append(html);
                }
                if (response.result_log.length > 0) {
                    $('#export-btn').prop('disabled', false);
                } else {
                    $('#export-btn').prop('disabled', true);
                }

            }
        });
    }

    function search_log() {

        $.ajax({
            type: "POST",
            "url": `${webUrl}eleave/leave/showTransLog`,
            dataType: 'json',
            data: {
                "from": $('#from').val(),
                "to": $('#to').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function (response) {
                for (var i = 0; i < response.result_log.length; i++) {
                    x = i + 1;
                    html = '<tr id="baris">';
                    html += '<td nowrap> ' + x + '</td>';
                    html += '<td nowrap> ' + response.result_log[i].trans_submit_date + '</td>';
                    html += '<td nowrap> ' + response.result_log[i].trans_type + '</td>';
                    html += '<td> ' + response.result_log[i].description + '</td>';
                    html += '<td nowrap> ' + response.result_log[i].submit_by_name.split(/(\s).+\s/).join("") + '</td>';
                    html += '<td> ' + response.result_log[i].trans_status + '</td>';
                    html += '<td nowrap> ' + response.result_log[i].submit_date + '</td>';
                    html += '</tr>';
                    $('#detailtable').append(html);
                }

                $('#modal_form').modal('show');

            }
        });
    }
</script>

@endsection