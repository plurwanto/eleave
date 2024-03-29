@extends('HRIS/layout.main')
@section('title', 'Report Final')
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
    <select name='cus_id' id="cus_id" data-column="7" class="border-rounded input-sm" style="width:250px; margin-right: 10px;height: 34px;
                                                padding: 5px 10px;
                                                font-size: 12px;
                                                line-height: 1.5;  background-color: #fff;
                                                border: 1px solid #c2cad8;
                                                border-radius: 4px;
                                                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                                                transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">
                                                <option value="0">ALL Customer</option>
                                                @for($i = 0; $i < count($customer); $i++)
                                                    <option value="{{$customer[$i]->cus_id}}">{{$customer[$i]->cus_name}}</option>
                                                @endfor
                                            </select>

                                            <input data-column="8" id="period" name="period" class="border-rounded input-sm" style="margin-right: 10px; width: 100px;height: 34px;
                                            padding: 5px 10px;
                                            font-size: 12px;
                                            line-height: 1.5;    background-color: #fff;
                                            border: 1px solid #c2cad8;
                                            border-radius: 4px;
                                        /* box-shadow: inset 0 1px 1px rgba(0,0,0,.075);.'[;p,lmokijnuhygtf */
                                            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;" type="text" value="{{date('m/Y')}}">



                                            <button class='btn btn-primary border-rounded search-button'>
                                                <i class="icon-magnifier"></i>
                                            </button>
                                            <div class="pull-right" style="padding-left:20px;">
    {!! $select !!}

        <div class="btn-group pull-right">
            <a class="btn green border-rounded" title="file" onclick="get_modal(this)" href="javascript:;" data-toggle="dropdown" aria-expanded="false" style="padding: 6px 0px;width: 40px;"><i class="fa fa-file-text" style="margin-right: 3px;"></i><i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a dataaction="filterExcel"  dataid="" onclick="get_modal(this)" href="#"> <i class="fa fa-file-excel-o" style="
                    margin-right: 3px;
                    "></i>Export</a>
                </li>
            </ul>
        </div>
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
                                <th> Name </th>
                                <th> NIP </th>
                                <th> ID Number </th>
                                <th> No Contract </th>
                                <th> Status Contract </th>
                                <th> Start Date </th>
                                <th> End Date </th>
                                <th> Customer </th>
                            </tr>
                            </thead>
                            <thead>
                            <tr>
                            <th></th>
                                <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Name"></th>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Nip"></th>
                                <th><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search ID Number"></th>
                                <th><input type="text" data-column="3"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Code"></th>
                                <th>
                                <select data-column="4" name="status" class="search-input-select form-control input-sm select2">
                                        <option value="">-- Choose a contract_status --</option>
                                        @for($i = 0; $i < count($contract_status->result); $i++)
                                        <option value="{{$contract_status->result[$i]->cont_sta_id}}">{{$contract_status->result[$i]->cont_sta_name}}</option>
                                        @endfor
                                </select>
                                </th>
                                <th></th>
                                <th></th>
                                <th>
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


        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'ui-toastr.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <script type="text/javascript">
            var period = document.getElementById("period").value;
            var cus_id = $('#cus_id').val();
            var link = $('#link').val();


                $(document).ready(function () {

                    $("#period").datepicker( {
                    format: "mm/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true

                });

                var dataTable = $('#users-table').DataTable({
                    "dom": '<"bottom"f>rt<"bottom"lpi><"clear">',
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'/hris/report/activity/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>","period":period,"cus_id":cus_id,"link":link}
                    },
                    "columns": [
                        { data: 'cont_id', name: 'cont_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'mem_name', name: 'mem_name' },
                        { data: 'mem_nip', name: 'mem_nip', width:'10%'},
                        { data: 'id_number', name: 'id_number' },
                        { data: 'cont_no_new', name: 'cont_no_new' },
                        { data: 'cont_sta_name', name: 'cont_sta_name' },
                        { data: 'cont_start_date', name: 'cont_start_date' },
                        { data: 'cont_end_date', name: 'cont_end_date' },
                        { data: 'cus_name', name: 'cus_name' },

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
                    var period = $('#period').val();
                    dataTable.columns(7).search(customer).draw();
                    dataTable.columns(8).search(period).draw();

                });
            });

            function get_modal(e)
            {
                var period = document.getElementById("period").value;
                var cus_id = $('#cus_id').val();
                var link = $('#link').val();


                linkObj = $(e);
                action = $(e).attr('dataaction');
                dataid = $(e).attr('dataid');
                var arr = dataid.split("|");



                if (action == 'filterExcel') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/report/activity/filter/excel') }}",
                    {
                        period: period,
                        cus_id: cus_id,
                        link: link,


                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

            }

            function handleSelect(elm)
            {
                if (elm.value != '') {
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/report/activity') }}?link="+ elm.value;
                }else{
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/report/activity') }}";

                }
            }
        </script>
@endsection
