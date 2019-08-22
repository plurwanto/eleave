@extends('HRIS/layout.main')
@section('title', 'Employee')
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

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
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
                        <h3>Keyword : {{$keyword}}</h3>
                        <br>
                            <table class="table table-striped table-bordered table-advance table-hover" id="users-table">
                            <thead>
                            <tr>
                            <th>id. </th>
                                <th  class="no-sort"  style="width:10px">No. </th>
                                <th  class="no-sort" style="width:65px"> Action </th>
                                <th> Name </th>
                                <th> NIP </th>
                                <th> ID Number </th>
                                <th> Citizenship </th>
                                <th> Form Type </th>
                                <th> Customer </th>
                                <th> IsActive </th>
                                <th> Updated By </th>
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


        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'ui-sweetalert.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <script type="text/javascript">
            $(document).ready(function () {
                
                var dataTable = $('#users-table').DataTable({
                    "dom": '<"bottom"f>rt<"bottom"lpi><"clear">',
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'/hris/employee/others/listdata-search?keyword=') }}{{$keyword}}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>"}
                    },
                    "columns": [
                        { data: 'mem_id', name: 'mem_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'action', name: 'action',orderable: false, width:'15%'},
                        { data: 'mem_name', name: 'mem_name' },
                        { data: 'mem_nip', name: 'mem_nip', width:'10%'},
                        { data: 'id_number', name: 'id_number' },
                        { data: 'mem_citizenship', name: 'mem_citizenship' },
                        { data: 'form_type', name: 'form_type', width:'10%'},
                        { data: 'cus_name', name: 'cus_name' },
                        { data: 'mem_active', name: 'mem_active' },
                        { data: 'mem_user', name: 'mem_user' }
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
                linkObj = $(e);
                action = $(e).attr('dataaction');
                dataid = $(e).attr('dataid');
                var arr = dataid.split("|");
                var link = $("#link").val();

                if (action == 'add') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/others/add') }}",
                    {
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'upload') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/others/upload') }}",
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
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/others/edit') }}",
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
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/others/detail') }}",
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
                        $.get("{{ URL::asset(env('APP_URL').'/hris/employee/others/do-delete') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                swal({title: "Successfully", type: "success"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/employee/others') }}?master={{$link}}";
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

            function handleSelect(elm)
            {
                if (elm.value != '') {
                    window.location = elm.value;
                }
            }
        </script>
@endsection
