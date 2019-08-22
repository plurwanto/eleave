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
                        echo  '<a href="'. URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/template-iuran') .'"><i class="fa fa-file-excel-o" style="
                margin-right: 3px;
                "></i>Template </a>';
                    }
                @endphp
                </li>
                <li>
                    <a dataaction="filterExcel"  dataid="" onclick="get_modal(this)" href="#"> <i class="fa fa-file-excel-o" style="
                    margin-right: 3px;
                    "></i>Export</a>
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
                            <div class="table-toolbar">
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="pull-right">
                                            <div class="pull-left text-left" style="display: inline-flex;">
                                                <select name='cus_id' id="cus_id" data-column="4" class="border-rounded input-sm" style="margin-right: 10px;height: 34px;
                                                    padding: 5px 10px;
                                                    font-size: 12px;
                                                    line-height: 1.5;  background-color: #fff;
                                                    border: 1px solid #c2cad8;
                                                    border-radius: 4px;
                                                    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                                                    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">
                                                    <option value="0">ALL Customer</option>
                                                    @for($i = 0; $i < count($customer); $i++)
                                                        @if($customer[$i]->cus_id == $cus_id)
                                                            <option value="{{$customer[$i]->cus_id}}" selected>{{$customer[$i]->cus_name}}</option>
                                                        @else
                                                            <option value="{{$customer[$i]->cus_id}}">{{$customer[$i]->cus_name}}</option>
                                                        @endif
                                                    @endfor
                                                </select>

                                                <select data-column="5" id="searchMonth" class="border-rounded input-sm" name="month" style="margin-right: 10px;height: 34px;
                                                padding: 5px 10px;
                                                font-size: 12px;
                                                line-height: 1.5;  background-color: #fff;
                                                border: 1px solid #c2cad8;
                                                border-radius: 4px;
                                                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                                                transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">
                                                    @php
                                                    $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                    $month_num = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                                                    for ($i = 0; $i < count($month); $i++) {
                                                        if($month_num[$i] == date('m')){
                                                            echo '<option value="' . $month_num[$i] . '" selected>' . $month[$i] . '</option>';
                                                        }else{
                                                            echo '<option value="' . $month_num[$i] . '">' . $month[$i] . '</option>';
                                                        }
                                                    }
                                                    @endphp
                                                </select>
                                                <input data-column="6" id="searchYear" class="border-rounded input-sm" style="margin-right: 10px; width: 75px;height: 34px;
                                                padding: 5px 10px;
                                                font-size: 12px;
                                                line-height: 1.5;    background-color: #fff;
                                                border: 1px solid #c2cad8;
                                                border-radius: 4px;
                                                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                                                transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;" type="number" name="year" value="{{date('Y')}}">
                                                <button class='btn btn-primary border-rounded search-button'>
                                                    <i class="icon-magnifier"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-advance table-hover" id="users-table">
                            <thead>
                            <tr>
                            <th>id. </th>
                                <th  class="no-sort"  style="width:10px">No. </th>
                                <th class="no-sort" style="width:65px"> Action </th>
                                <th> Employee </th>
                                <th> NIP </th>
                                <th> Customer </th>
                                <th> BPJS Kesehatan</th>
                                <th> BPJS Period </th>
                                <th> Amount</th>
                                <th> Created By </th>
                                <th> Update at</th>
                            </tr>
                            </thead>
                            <thead>
                            <tr>
                            <th></th>
                            <th></th>
                                <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Name"></th>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Nip"></th>
                                <th></th>
                                <th><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search code"></th>
                                <th></th>
                                <th></th>
                                <th><input type="text" data-column="3"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search User"></th>
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
<input type='hidden' value='{{$cus_id}}' id='cus_id'>


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
            var searchMonth = document.getElementById("searchMonth").value;
            var searchYear = document.getElementById("searchYear").value;
            var cus_id = $('#cus_id').val();


            $(document).ready(function () {

                var dataTable = $('#users-table').DataTable({
                    "dom": '<"bottom"f>rt<"bottom"lpi><"clear">',
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>","searchMonth":searchMonth,"searchYear":searchYear,"cus_id":cus_id}
                    },
                    "columns": [
                        { data: 'bpjs_kes_id', name: 'bpjs_kes_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'action', name: 'action' },
                        { data: 'mem_name', name: 'mem_name' },
                        { data: 'mem_nip', name: 'mem_nip', width:'10%'},
                        { data: 'cus_name', name: 'cus_name', width:'10%'},
                        { data: 'bpjs_kes_number', name: 'bpjs_kes_number' },
                        { data: 'period', name: 'period' },
                        { data: 'total', name: 'total' },
                        { data: 'nama', name: 'nama' },
                        { data: 'created_date', name: 'created_date' },

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
                    var customer = $('#cus_id').val();
                    var searchMonth = $('#searchMonth').val();
                    var searchYear = $('#searchYear').val();
                    dataTable.columns(4).search(customer).draw();
                    dataTable.columns(5).search(searchMonth).draw();
                    dataTable.columns(6).search(searchYear).draw();

                });
            });

            function get_modal(e)
            {
                var searchMonth = document.getElementById("searchMonth").value;
                var searchYear = document.getElementById("searchYear").value;
                var cus_id = $('#cus_id').val();

                linkObj = $(e);
                action = $(e).attr('dataaction');
                dataid = $(e).attr('dataid');
                var arr = dataid.split("|");

                if (action == 'upload') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/upload') }}",
                    {
                        searchMonth: searchMonth,
                        searchYear: searchYear,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'filterExcel') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/filter/excel') }}",
                    {
                        searchMonth: searchMonth,
                        searchYear: searchYear,
                        cus_id: cus_id,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'detail') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan/detail') }}",
                    {
                        searchMonth: searchMonth,
                        searchYear: searchYear,
                        id: arr[0]

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

            }

            function handleSelect(elm)
            {
                if (elm.value != '') {
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/bpjs/kesehatan') }}?link="+ elm.value;
                }
            }

        </script>
@endsection
