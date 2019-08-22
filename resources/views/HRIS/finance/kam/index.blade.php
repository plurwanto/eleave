@extends('HRIS/layout.main')
@section('title', 'Letter Request')
@section('breadcrumbs')
<div style="height: 30px;margin: 0px 0px 15px 0px;">
    <div class="page-title" style="
        border-right: 1px solid #cbd4e0;
        display: inline-block;
        float: left;
        padding-right: 15px;
        margin-right: 15px;">
    <h1 style="
        color: #697882;
        font-size: 22px;
        font-weight: 400;
        margin: 0;">{{$title}}</h1>
    </div>
    <ul class="page-breadcrumb breadcrumb pull-left" style="padding: 3px 0;">
        <li style="color: #697882;">{{$subtitle}}</li>
    </ul>
    <div class="pull-right">
        <select style="width:190px; margin-right:10px" class="form-control border-rounded pull-left"  name="year" id="year" class="form-control"  onchange="javascript:handleSelect()">
            @php
                $now = date('Y');
                for($i=2014; $i <= $now; $i++){
                    if($i == $year){
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';

                    }else{
                        echo '<option value="'.$i.'">'.$i.'</option>';

                    }
                }
            @endphp
        </select>





        @if($access->menu_acc_add == 1)
            <a dataaction="add"  dataid="" title="add" onclick="get_modal(this)" class="border-rounded btn btn-icon-only green" style="
            border-right: 1px solid;
            width: 40px;"><i class="fa fa-plus"></i>
            </a>
        @endif
    </div>
 </div>
@endsection


@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
<style>
.dataTables_filter { display: none };
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- BEGIN PAGE BREADCRUMBS -->
        @yield('breadcrumbs')

        <!-- END PAGE BREADCRUMBS -->

        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light ">

                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover" style="table-layout:fixed;">
                                    <thead>
                                        <tr>
                                            <th  style="width:250px"> Name </th>
                                            <th style="width:80px"> Currency </th>
                                            <th style="width:120px"> Revenue Target </th>
                                            <th  style="width:120px"> Achievement </th>
                                            <th  style="width:120px"> Gap To Go </th>
                                            <th  style="width:50px"> ( % ) </th>
                                            <th  style="width:120px"> Jan </th>
                                            <th  style="width:120px"> Feb </th>
                                            <th  style="width:120px"> Mar </th>
                                            <th  style="width:120px"> Apr </th>
                                            <th  style="width:120px"> May </th>
                                            <th  style="width:120px"> Jun </th>
                                            <th  style="width:120px"> Jul </th>
                                            <th  style="width:120px"> Aug </th>
                                            <th  style="width:120px"> Sep </th>
                                            <th  style="width:120px"> Oct </th>
                                            <th  style="width:120px"> Nov </th>
                                            <th  style="width:120px"> Des </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        for($i=0; $i < count($kam); $i++){
                                            echo '<tr>';
                                            if($kam[$i]->revenue_based == 'FULL'){
                                                echo '<td  style="table-layout:fixed; width:300px">' . $kam[$i]->nama . '<label class="label label-sm border-rounded  label-danger pull-right"><font style="font-size:10px">' . $kam[$i]->revenue_based . '</font></label></td>';
                                            }else{
                                                echo '<td  style="table-layout:fixed; width:300px">' . $kam[$i]->nama . '<label class="label label-sm border-rounded  label-primary pull-right"><font style="font-size:10px">' . $kam[$i]->revenue_based . '</font></label></td>';
                                            }
                                            echo '<td>' . $kam[$i]->currency . '</td>';
                                            echo '<td><span class="pull-right">'.$kam[$i]->revenue_kpi.'</span></td>';
                                            echo '<td><span class="pull-right">' . $kam[$i]->total . '</span></td>';
                                            echo '<td><span class="pull-right">' . $kam[$i]->gap . '</span></td>';
                                            echo '<td><span class="pull-right">' . $kam[$i]->percent . '%</span></td>';
                                            for ($a = 0; $a < count($kam[$i]->detail); $a++) {
                                                echo '<td><span class="pull-right">' . $kam[$i]->detail[$a]->total . '</span></td>';
                                            }

                                            echo '</tr>';
                                        }
                                        @endphp
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>



@endsection

@section('script')

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'table-datatables-managed.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset(env('GLOBAL_SCRIPT_PATH').'datatable.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <script type="text/javascript">
            $(document).ready(function () {

                var dataTable = $('#users-table').DataTable({
                    "dom": '<"bottom"f>rt<"bottom"lpi><"clear">',
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>"}
                    },
                    "columns": [
                        { data: 'let_id', name: 'let_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'action', name: 'action',orderable: false},
                        { data: 'mem_name', name: 'mem_name' },
                        { data: 'cus_name', name: 'cus_name', width:'20%'},
                        { data: 'let_no_out', name: 'let_no_out' },
                        { data: 'nama', name: 'nama' },
                        { data: 'updated_at', name: 'updated_at' },
                    ],
                });

                //$("#dataTables_filter ").css("display", "none");  // hiding global search box
                $('.search-input-text').on('keyup click', function () {   // for text boxes
                    var i = $(this).attr('data-column');  // getting column index
                    var v = $(this).val();  // getting search input value
                    dataTable.columns(i).search(v).draw();
                });
                $('.search-input-select').on('change', function () {   // for select box
                    var i = $(this).attr('data-column');
                    var v = $(this).val();
                    dataTable.columns(i).search(v).draw();
                });
            });

            function get_modal(e)
            {
                $(".modal-content").html(`<div style="text-align: center"><h2><i class="fa fa-chevron-right-o-notch fa-spin fa-1x fa-fw"></i>
                <span>Loading...</span></h2>
            </div>`);
                linkObj = $(e);
                action = $(e).attr('dataaction');
                dataid = $(e).attr('dataid');
                var arr = dataid.split("|");
                var link = $("#link").val();

                if (action == 'add') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue/add') }}",
                    {
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'upload') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue/upload') }}",
                    {
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'edit') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue/edit') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'detail') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue/detail') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'delete') {
                    swal({
                        title: "Are you sure?",
                        //   text: "But you will still be able to retrieve this file.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: 'btn btn-danger',
                        cancelButtonColor: 'btn btn-danger',
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel please!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                function (isConfirm) {
                    if (isConfirm) {
                        $.get("{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue/do-delete') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                swal({title: "Successfully", type: "success"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue') }}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                            });
                    } else {
                        swal . close();
                        toastr.error("Cancelled", "Your action is cancelled :)",{timeOut: 2000});
                    }
                });

                }

            }

           function handleSelect()
            {
                var customer = $('#customer').val();
                var year = $('#year').val();
                if (customer == 0 && year == 0) {
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue') }}";
                }else{
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue') }}?year="+ year;

                }
            }
        </script>
@endsection
