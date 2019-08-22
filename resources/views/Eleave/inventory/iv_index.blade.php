@extends('Eleave.layout.main')

@section('title','Eleave | My Stationery Request History')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-list"></i>My Stationery Request History
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">
                        <a class="btn btn-default btn-circle btn-sm" tabindex="0" aria-controls="sample_2" href="{{ URL::to('eleave/inventory/add') }}"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                <thead>
                    <tr>
                        <th>No</th>
<!--                        <th>Subject Name<br/><div class="filter-wrapper"></div></th>
                        <th>Status</br><div class="filter-wrapper-status"></div></th>
                        <th>Batch<br/><div class="filter-wrapper-small"></div></th>-->
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


@endsection

@section('script')
@include('Eleave/notification')
<script type="text/javascript">
    var $table;
    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html('<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-small").html('<input type="text" class="filter form-control" style="width:60px;" placeholder="' + title + '" />');
            $(this).find(".filter-wrapper-100").html('<input type="text" class="filter form-control" style="width:100px;" placeholder="' + title + '" />');
            $(this).find(".filter-wrapper-date-start").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date" style="width:80px;" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-date-end").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date" style="width:80px;" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-status").html(
                    '<select class="filter form-control">\n\
                        <option value=""></option>\n\
                        <option value="1">Requested</option>\n\
                        <option value="2">Prepare</option>\n\
                        <option value="3">Reject</option>\n\
                        <option value="4">Done</option>\n\
                        <option value="5">Ready</option>\n\
                        <option value="6">Unfulfilled</option>\n\
                        </select>'
                    );
        });

        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": `${webUrl}eleave/inventory/get_data`,
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
                {"data": "action", "searchable": false, "orderable": false},
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