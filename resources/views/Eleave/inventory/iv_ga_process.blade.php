@extends('Eleave.layout.main')

@section('title','Eleave | All Stationery Request List')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-list"></i>All Stationery Request List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs">
                <li class="">
                    <a href="{{url('eleave/inventory/all_request')}}" id="tab1" aria-expanded="false"> Request Summary </a>
                </li>
                <li class="active">
                    <a href="{{url('eleave/inventory/all_processed')}}" id="tab2" aria-expanded="true"> Processed </a>
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

                        <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subject Name</th>
                                    <th>Status</th>
                                    <th>Batch</th>
                                    <th>Request By</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
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


    @endsection

    @section('script')
    @include('Eleave/notification')
    <script type="text/javascript">
        var $table;
        $(document).ready(function () {
//            $('#usertable thead th').each(function () {
//                setdatepicker();
//                var title = $('#usertable thead th').eq($(this).index()).text();
//                $(this).find(".filter-wrapper").html('<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
//                $(this).find(".filter-wrapper-small").html('<input type="text" class="filter form-control" style="width:60px;" placeholder="' + title + '" />');
//                $(this).find(".filter-wrapper-100").html('<input type="text" class="filter form-control" style="width:100px;" placeholder="' + title + '" />');
//                $(this).find(".filter-wrapper-date-start").html(
//                        '<input type="text" class="filter form-control datepicker" id="src_date" style="width:80px;" placeholder="Filter ' + title + '" />');
//                $(this).find(".filter-wrapper-date-end").html(
//                        '<input type="text" class="filter form-control datepicker" id="src_date" style="width:80px;" placeholder="Filter ' + title + '" />');
//                $(this).find(".filter-wrapper-status").html(
//                        '<select class="filter form-control">\n\
//                            <option value=""></option>\n\
//                            <option value="1">Requested</option>\n\
//                            <option value="2">Prepare</option>\n\
//                            <option value="3">Reject</option>\n\
//                            <option value="4">Done</option>\n\
//                            <option value="5">Ready</option>\n\
//                            <option value="6">Unfulfilled</option>\n\
//                            </select>'
//                        );
//            });

            $table = $('#usertable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": `${webUrl}eleave/inventory/get_all_process`,
                    "dataType": "json",
                    "type": "POST",
                    "data": {"_token": "<?=csrf_token()?>"}
                },
                //dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "columns": [
                    {"data": "no", "searchable": false, "orderable": false},
                    {"data": "request_name", "searchable": false, "orderable": false},
                    {"data": "status", "searchable": false, "orderable": true},
                    {"data": "batch_id", "searchable": false, "orderable": false},
                    {"data": "created_by", "searchable": false, "orderable": false},
                    {"data": "created_at", "searchable": false, "orderable": false},
                    {"data": "action", "searchable": false, "orderable": false, width: "85px"},
                ],

                scrollY: 350,
                scrollX: true,
                //scrollCollapse: true,
                "pageLength": 10,
                lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                order: [[2, "desc"]],
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
                format: 'dd M yy',
                clearBtn: true,
                autoclose: true,
                todayHighlight: true,
                // endDate: "1m"
            })

        }
    </script>
    @endsection