@extends('HRIS/layout.main')
@section('title', 'Asset Management')
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
        <div class="btn-group pull-right">
            <a class="btn green border-rounded" title="file" onclick="get_modal(this)" href="javascript:;" data-toggle="dropdown" aria-expanded="false" style="padding: 6px 0px;width: 40px;"><i class="fa fa-file-text" style="margin-right: 3px;"></i><i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a dataaction="download"  dataid="" onclick="get_modal(this)" href="#"> <i class="fa fa-file-excel-o" style="
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
                            <table class="table table-striped table-bordered table-advance table-hover" id="users-table">
                            <thead>
                            <tr>
                            <th>id. </th>
                                <th  class="no-sort"  style="width:10px">No. </th>
                                <th  class="no-sort" style="width:65px"> Action </th>
                                <th> Employee </th>
                                <th> Elabram Tag </th>
                                <th> Service Tag </th>
                                <th> Brand </th>
                                <th> Type </th>
                                <th> Condition </th>
                                <th> Updated by</th>
                                <th> Updated at </th>
                            </tr>
                            </thead>
                            <thead>
                                <th></th>
                                <th></th>
                                <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Member"></th>
                                <th><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Tag"></th>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Tag"></th>
                                <th>
                                    <select data-column="3" name="brand" class="search-input-select form-control input-sm select2">
                                        <option value="">-- Choose a brand --</option>
                                        @for($i = 0; $i < count($brand->result); $i++)
                                        <option value="{{$brand->result[$i]->ass_brand_id}}">{{$brand->result[$i]->brand_name}}</option>
                                        @endfor
                                    </select>
                                </th>
                                <th>
                                    <select data-column="4" name="type" class="search-input-select form-control input-sm">
                                        <option value="">-- Choose a type --</option>
                                        @for($i = 0; $i < count($type->result); $i++)
                                        <option value="{{$type->result[$i]->ass_type_id}}">{{$type->result[$i]->type_name}}</option>
                                        @endfor
                                    </select>
                                </th>
                                <th>
                                    <select data-column="5" name="condition" class="search-input-select form-control input-sm">
                                        <option value="">-- Choose a condition --</option>
                                        <option value="1">Good</option>
                                        <option value="2">Broke</option>
                                        <option value="3">Bad</option>
                                    </select>
                                </th>
                                <th><input type="text" data-column="6"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Updated By"></th>
                                <th><input type="text" data-column="7"  class="search-input-text form-control input-sm   border-rounded date-picker" placeholder="Search Updated at"></th>
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
                        "url": "{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>"}
                    },
                    "columns": [
                        { data: 'ass_item_id', name: 'ass_item_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'action', name: 'action',orderable: false},
                        { data: 'mem_name', name: 'mem_name' },
                        { data: 'elabram_tag', name: 'elabram_tag', width:'20%'},
                        { data: 'service_tag', name: 'service_tag' },
                        { data: 'brand_name', name: 'brand_name' },
                        { data: 'type_name', name: 'type_name' },
                        { data: 'condition', name: 'condition' },
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

                if (action == 'download') {
                    $('.loading').show();
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource/do-excel') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                $('.loading').hide();
                                toastr.success('download successfully');
                                window.location = data.path;

                            }

                        );
                }

                if (action == 'add') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource/add') }}",
                    {
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'detail') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource/detail') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'edit') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource/edit') }}",
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
                        $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource/do-delete') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                swal({title: "Successfully", type: "success"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource') }}";
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

                if (action == 'upload') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource/upload') }}",
                    {
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'pdf') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'/hris/administration/asset/resource/pdf') }}?id="+id, '_blank');
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
