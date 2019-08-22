@extends('Eleave.layout.main')

@section('title','Eleave | Overtime List')

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
            <i class="fa fa-clock-o"></i>Overtime List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">
                        <a class="btn btn-default btn-circle btn-sm" tabindex="0" aria-controls="sample_2"
                           href="{{ URL::to('eleave/overtime/add') }}"><i class="fa fa-plus"></i> Add Overtime</a>

                    </div>
                </div>
            </div>

            <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                <thead>
                    <tr>
                        <th style="width: 5px">No</th>
                        <th style="width: 105px">Date<br />
                            <div class="filter-wrapper-date-start"></div>
                        </th>
                        <th style="width: 50px">From</th>
                        <th style="width: 50px">To</th>
                        <th style="width: 200px">Description<br />
                            <div class="filter-wrapper"></div>
                        </th>
                        <th style="width: 200px">Reason<br />
                            <div class="filter-wrapper"></div>
                        </th>
                        <th style="width: 200px">Negative Impact<br />
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
                    '<input type="text" class="filter form-control"  placeholder="Filter ' +
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
        });

        if ($('#notif').val() == "notif") {
            var url = `${webUrl}eleave/overtime/getdataNotif`;
        } else {
            var url = `${webUrl}eleave/overtime/getdata`;
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
                    "data": "ot_date",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "ot_time_in",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ot_time_out",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ot_description",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ot_reason",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ot_negative_impact",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "ot_submit_date",
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
                [1, "desc"]
            ],
        });

        // var tableinfo = $table.page.info();
        // total = tableinfo.recordsTotal

        // if (total > 0) {

        // }

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
    $(document).on('click', '.reject', function () {
        if (confirm("Are you sure delete ?  ")) {
            var $button = $(this);
            var id = this.id.split('-').pop();
            $.ajax({
                type: 'POST',
                url: `${webUrl}eleave/overtime/delete`,
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

//    function delete_list(id)
//    {
//        // alert(id)
//        if (confirm("Are you sure delete ?  "))
//        {
//            $.ajax({
//                type: 'POST',
//                url: '{{ URL::to("eleave/overtime/delete") }}',
//                dataType: 'json',
//                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//                data: {id: id, "_token": "{{ csrf_token() }}"},
//
//                success: function (data) {
//                    if (data.status == true) {
//                        location.reload();
//                    }
//                },
//
//            });
//
//        }
//    }
</script>

<script>
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