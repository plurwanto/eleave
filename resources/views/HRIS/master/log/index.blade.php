@extends('HRIS/layout.main')
@section('title', 'Log Activity')
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
        <li style="color: #697882;">{{$subtitle2}}</li>
    </ul>
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
.dataTables_filter { display: none }; }

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
                            <table class="table table-striped table-bordered table-advance table-hover" id="users-table">
                            <thead>
                            <tr>
                            <th>id. </th>
                                <th  class="no-sort"  style="width:10px">No. </th>
                                <th class="no-sort"> Action </th>
                                <th> Type </th>
                                <th> Menu </th>
                                <th> Table </th>
                                <th> Created By </th>
                                <th> Date </th>
                            </tr>
                            </thead>
                            <thead>
                            <tr>
                            <th></th>
                                <th></th>
                                <th>
                                <select data-column="0" name="status" class="search-input-select form-control input-sm">
                                    <option value="">-- Choose a Type --</option>
                                    <option value="insert">Insert</option>
                                    <option value="update">Update</option>
                                    <option value="delete">Delete</option>
                                </select>
                                </th>
                                <th>
                                <select data-column="1" name="status" class="search-input-select form-control input-sm select2">
                                        <option value="">-- Choose a Menu --</option>
                                        <option value="28">HRIS Setting</option>
                                        <option value="33">Customer</option>
                                        <option value="32">Employee</option>
                                </select>
                                </th>
                                <th><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Code"></th>
                                <th><input type="text" data-column="3"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Code"></th>
                                <th><input type="text" data-column="4"  class="search-input-text form-control input-sm   border-rounded  date-picker" placeholder="Search End Date" data-date-format="dd/mm/yyyy"></th>
                                </th>
                            </tr>
                            </thead>
                        </table>
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
            var menu = $('#menu').val();

            $(document).ready(function () {

                var dataTable = $('#users-table').DataTable({
                    "dom": '<"bottom"f>rt<"bottom"lpi><"clear">',
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'/hris/master/log/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>","menu":menu}
                    },
                    "columns": [
                        { data: 'log_id', name: 'log_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'action', name: 'action' , orderable: false},
                        { data: 'type', name: 'type' },
                        { data: 'menu_name', name: 'menu_name', width:'10%'},
                        { data: 'table', name: 'table' },
                        { data: 'nama', name: 'nama' },
                        { data: 'created_at', name: 'created_at' }
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

                $('.search-button').on('click', function () {   // for search
                    var menu = $('#menu').val();
                    var searchMonth = $('#searchMonth').val();
                    var searchYear = $('#searchYear').val();
                    dataTable.columns(7).search(menu).draw();

                });
            });

            function get_modal(e)
            {
                var menu = $('#menu').val();

                linkObj = $(e);
                action = $(e).attr('dataaction');
                dataid = $(e).attr('dataid');
                var arr = dataid.split("|");

                if (action == 'detail') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/master/log/detail') }}",
                    {
                        id: arr[0]

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

            }
        </script>
@endsection
