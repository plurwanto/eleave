@extends('HRIS/layout.list')

@section('breadcrumbs')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{ URL::asset(env('APP_URL').'/hris/dashboard') }}">Dashboard</a>
        <i class="fa fa-chevron-right"></i>
    </li>
    <li>
        <span>Master Data</span>
        <i class="fa fa-chevron-right"></i>
    </li>
    <li>
        <span>{{$title}}</span>
    </li>
</ul>
@endsection


@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
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
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase font-dark">{{$subtitle}}</span>
                            </div>
                            <div class="actions">
                                <!-- <a class="btn btn-circle btn-icon-only btn-default" href="#">
                                    <i class="icon-cloud-upload"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="#">
                                    <i class="icon-wrench"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="#">
                                    <i class="icon-trash"></i>
                                </a> -->
                                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#"> </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <button id="sample_editable_1_2_new" class="btn sbold green"  onclick="get_modal('add')"> Add New
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="btn-group pull-right">
                                            <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-print"></i> Print </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-advance table-hover" id="users-table">
                            <thead>
                            <tr>
                            <th>id. </th>
                                <th  class="no-sort"  style="width:20px">No. </th>
                                <th  class="no-sort" style="width:65px"> Action </th>
                                <th> Name </th>
                                <th> Email </th>
                                <th> Branch </th>
                                <th> Position </th>
                                <th> IsActive </th>
                                <th> Recruitment Position </th>
                            </tr>
                            </thead>
                            <thead>
                            <tr>
                            <th></th>
                                <th></th>
                                <th> </th>
                                <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Name"></th>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Email"></th>
                                <th><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Branch"></th>
                                <th><input type="text" data-column="3"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Position"></th>
                                <th>
                                    <select   data-column="4" class="search-input-select form-control input-sm border-rounded">
                                        <option value=""> all </option>   
                                        <option value="Y">Active</option>
                                        <option  value="N"> No Active</option>
                                    </select>
                                </th>
                                <th>
                                    <select  data-column="5" class="search-input-select form-control input-sm border-rounded">
                                        <option value=''>all</option>
                                        <option value='NA'>NA</option>
                                        <option value='GUEST'> GUEST</option>
                                        <option value='ASSIGN'> ASSIGNMENT</option>
                                        <option value='RECRUIT'> RECRUITER</option>
                                        <option value='SALES'> SALES</option>
                                        <option value='MANAGEMENT'>MANAGEMENT</option>
                                        <option value='SUPER'> SUPER ADMIN</option>
                                    </select>
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


<div class="modal fade bs-modal-lg" id="modalAction" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body"> Modal body goes here </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn green">Save changes</button>
            </div> -->

            <div style="text-align: center"><h2><i class="fa fa-chevron-right-o-notch fa-spin fa-1x fa-fw"></i>
                <span>Loading...</span></h2>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@section('script')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset(env('GLOBAL_SCRIPT_PATH').'datatable.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'table-datatables-managed.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'components-select2.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->


<script type="text/javascript">

    $(document).ready(function () {
  
        var dataTable = $('#users-table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[ 0, "DESC" ]],
            "ajax": {
                "url": "{{ URL::asset(env('APP_URL').'/hris/master/wms-user/listdata') }}",
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?=csrf_token()?>"}
            },
            "columns": [
                { data: 'user_id', name: 'user_id'},
                { data: 'no', name: 'no' },
                { data: 'action', name: 'action' },
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email' },
                { data: 'br_name', name: 'br_name' },
                { data: 'div_name', name: 'div_name' },
                { data: 'active', name: 'active' },
                { data: 'recruitment_position', name: 'recruitment_position' }
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

    function get_modal(val) 
    {
        if (val == 'add') {
            $('#modalAction').modal('show');
            $.get("{{ URL::asset(env('APP_URL').'/hris/master/wms-user/add') }}",
            {
                // cus_id: 'sdsadsad'
            },
            function (data) {
                $(".modal-content").html(data);
            });
        }
    }
</script>
@endsection
