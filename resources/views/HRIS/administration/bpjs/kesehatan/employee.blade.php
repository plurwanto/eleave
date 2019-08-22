@extends('HRIS/layout.main')
@section('title', 'BPJS Kesehatan')
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
    <div class="pull-right">
        {!! $select !!}
        @if($access->menu_acc_add == 1)
        <a dataaction="upload"  dataid="" title="upload" onclick="get_modal(this)" class="border-rounded btn btn-icon-only green" style="
        border-right: 1px solid;
        /* padding: 6px; */
        width: 40px;"><i class="fa fa-upload"></i>
        </a>
        @endif
        <div class="btn-group pull-right">
            <a class="btn green border-rounded" title="file" onclick="get_modal(this)" href="javascript:;" data-toggle="dropdown" aria-expanded="false" style="padding: 6px 0px;width: 40px;"><i class="fa fa-file-text" style="margin-right: 3px;"></i><i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-right">
                <li>
                @php
                    if($access->menu_acc_add == 1){
                        echo  '<a href="'. URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/template-update') .'"><i class="fa fa-file-excel-o" style="
                margin-right: 3px;
                "></i>Template </a>';
                    }
                @endphp
                </li>
            </ul>
        </div>
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
                                <th> Employee </th>
                                <th> NIP </th>
                                <th> ID Number </th>
                                <th> BPJS Kesehatan</th>
                                <th> Created By </th>
                                <th> Update at</th>
                            </tr>
                            </thead>
                            <thead>
                            <tr>
                            <th></th>
                                <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Employee"></th>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Nip"></th>
                                <th><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search ID Number"></th>
                                <th><input type="text" data-column="3"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search BPJS Ketenagakerjaan"></th>
                                <th><input type="text" data-column="4"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Created By"></th>
                                <th></th>
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

            $(document).ready(function () {

                var dataTable = $('#users-table').DataTable({
                    "dom": '<"bottom"f>rt<"bottom"lpi><"clear">',
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/listdata-employee') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>"}
                    },
                    "columns": [
                        { data: 'mem_id', name: 'mem_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'mem_name', name: 'mem_name' },
                        { data: 'mem_nip', name: 'mem_nip', width:'10%'},
                        { data: 'idNumber', name: 'idNumber', width:'10%'},
                        { data: 'mem_bpjs_kes', name: 'mem_bpjs_kes' },
                        { data: 'mem_user', name: 'mem_user' },
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

                if (action == 'upload') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/upload-employee') }}",
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'filterExcel') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/filter/excel') }}",
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

            }

            function handleSelect(elm)
            {
                if (elm.value != '') {
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan?link=employee') }}?link="+ elm.value;
                }
            }
        </script>
@endsection
