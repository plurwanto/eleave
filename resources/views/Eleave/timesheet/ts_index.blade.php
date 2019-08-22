@extends('Eleave.layout.main')

@section('title','Eleave | Timesheet List')

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
            <i class="fa fa-clock-o"></i>Timesheet List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">
                        <a class="btn btn-default btn-circle btn-sm" tabindex="0" aria-controls="sample_2"
                           href="{{ URL::to('eleave/timesheet/add') }}"><i class="fa fa-plus"></i> Add Timesheet</a>

                    </div>
                </div>
            </div>

            <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                <thead>
                    <tr>
                        <th style="width: 5px">No</th>
                        <th style="width: 70px">Type<br />
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
                        <th style="width: 100px">Location<br />
                            <div class="filter-wrapper-100"></div>
                        </th>
                        <th style="width: 250px">Activity<br />
                            <div class="filter-wrapper"></div>
                        </th>

                        <th style="width: 90px">Submit Date</th>
                        <th style="width: 50px; text-align: left">Year</th>
                        <th style="width: 70px">Month</th>
                        <th style="width: 240px">Status<br />
                            <div class="filter-wrapper-status"></div>
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
            $(this).find(".filter-wrapper-date-start").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date"  placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-date-end").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date"  placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-type").html(
                    '<select class="filter form-control" >\n\
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
        });

        if ($('#notif').val() == "notif") {
            var url = `${webUrl}eleave/timesheet/getdataNotif`;
        } else {
            var url = `${webUrl}eleave/timesheet/getdata`;
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
                    "data": "ts_type",
                    "searchable": false,
                    "orderable": false
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
            "pageLength": 10,
            lengthMenu: [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            order: [
                [2, "desc"]
            ],
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
    function show_detail(id, ts_id, tipe) {
        $('#user_id').val(id);
        $('#ts_id').val(ts_id);
        $('#modal_form').modal('show');
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

    $(document).on('click', '.reject', function () {
        if (confirm("Are you sure delete ?  ")) {
            var $button = $(this);
            var id = this.id.split('-').pop();
            $.ajax({
                type: 'POST',
                url: `${webUrl}eleave/timesheet/delete`,
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
</script>
<script>
    toastr.options = {
        "closeButton": true,
    };

    @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
    case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
            case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
            case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
            case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
            }
    @endif
</script>
@endsection