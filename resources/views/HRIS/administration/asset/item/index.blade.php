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
        @if($access->menu_acc_add == 1)
            <a dataaction="add"  dataid="" title="add" onclick="get_modal(this)" class="border-rounded btn btn-icon-only green" style="
            border-right: 2px solid;
            width: 40px;"><i class="fa fa-plus"></i>
            </a>
        @endif
        <div class="btn-group pull-right">
            <a class="btn green border-rounded" title="file" onclick="get_modal(this)" href="javascript:;" data-toggle="dropdown" aria-expanded="false" style="padding: 6px 0px;width: 40px;"><i class="fa fa-file-text" style="margin-right: 3px;"></i><i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a dataaction="download"  dataid="" onclick="get_modal(this)" href="#"> <i class="fa fa-file-excel-o" style="
                    margin-right: 3px;
                    "></i>Master Asset</a>
                </li>
                <li>
                    <a dataaction="download_history"  dataid="" onclick="get_modal(this)" href="#"> <i class="fa fa-file-excel-o" style="
                    margin-right: 3px;
                    "></i>History</a>
                </li>
                @php
                echo '<li><a href="' . URL::asset(env('PUBLIC_PATH') . '/hris/files/asset/template_asset.xlsx') . '"><i class="fa fa-file-excel-o" style="
                margin-right: 3px;
                "></i>Template Asset</a></li>';
                @endphp
                <li>
                    <a dataaction="template_assign"  dataid="" title="template assign to" onclick="get_modal(this)" href="#"> <i class="fa fa-file-excel-o"
                    style="margin-right: 3px;"></i>Template Assign To</a>
                </li>

            </ul>
        </div>
        <div class="btn-group pull-right" style="margin-right: 2px;">
            <a class="btn green border-rounded" title="file" onclick="get_modal(this)" href="javascript:;" data-toggle="dropdown" aria-expanded="false" style="padding: 6px 0px;width: 40px;"><i class="fa fa-upload" style="margin-right: 3px;"></i>
            <i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a dataaction="upload"  dataid="" title="upload" onclick="get_modal(this)" href="#"> <i class="fa fa-upload"
                    style="margin-right: 3px;"></i> Asset</a>
                </li>
                <li>
                    <a dataaction="upload_assign"  dataid="" title="upload assign" onclick="get_modal(this)" href="#"> <i class="fa fa-upload"
                    style="margin-right: 3px;"></i> Assign To</a>
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
                        <div class="portlet-body" style="width: 87em;
                        overflow-x: auto;
                        white-space: nowrap;">
                            <table class="table table-striped table-bordered table-advance table-hover" id="users-table">
                                <thead>
                                <tr>
                                <th>id. </th>
                                    <th  class="no-sort"  style="width:10px">No. </th>
                                    <th  class="no-sort" style="width:65px"> Action </th>
                                    <th> Elabram Tag </th>
                                    <th> Service Tag </th>
                                    <th> Brand </th>
                                    <th> Type </th>
                                    <th> Rent/Company </th>
                                    <th> Vendor </th>
                                    <th> Price </th>
                                    <th> Model </th>

                                    <th> Status </th>
                                    <th> Updated by</th>
                                    <th> Updated at </th>
                                </tr>
                                </thead>
                                <thead>
                                    <th></th>
                                    <th></th>
                                    <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Tag"></th>
                                    <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Tag"></th>
                                    <th>
                                        <select data-column="2" name="brand" class="search-input-select form-control input-sm select2">
                                            <option value="">-- Choose a brand --</option>
                                            @for($i = 0; $i < count($brand->result); $i++)
                                            <option value="{{$brand->result[$i]->ass_brand_id}}">{{$brand->result[$i]->brand_name}}</option>
                                            @endfor
                                        </select>
                                    </th>
                                    <th>
                                        <select data-column="3" name="type" class="search-input-select form-control input-sm">
                                            <option value="">-- Choose a type --</option>
                                            @for($i = 0; $i < count($type->result); $i++)
                                            <option value="{{$type->result[$i]->ass_type_id}}">{{$type->result[$i]->type_name}}</option>
                                            @endfor
                                        </select>
                                    </th>
                                     <th>
                                        <select data-column="4" name="condition" class="search-input-select form-control input-sm select2">
                                            <option value="">-- Choose a status --</option>
                                            <option value="rent">Rent</option>
                                            <option value="company asset">Company Asset	</option>
                                        </select>
                                    </th>
                                    <th>
                                        <select data-column="5" name="vendor" class="search-input-select form-control input-sm select2">
                                            <option value="">-- Choose a vendor --</option>
                                            @for($i = 0; $i < count($vendor->result); $i++)
                                            <option value="{{$vendor->result[$i]->ass_vendor_id}}">{{$vendor->result[$i]->vendor_name}}</option>
                                            @endfor
                                        </select>
                                    </th>
                                    <th></th>
                                    <th><input type="text" data-column="6"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search model" style="width:200px"></th>

                                    <th>
                                        <select data-column="7" name="status" class="search-input-select form-control input-sm"  style="width:160px">
                                            <option value="">-- Choose a status --</option>
                                            <option value="1">In Storage</option>
                                            <option value="2">In Use</option>
                                        </select>
                                    </th>
                                    <th><input type="text" data-column="8"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Updated By" style="width:160px"></th>
                                    <th><input type="text" data-column="9"  class="search-input-text form-control input-sm   border-rounded date-picker" placeholder="Search Updated at"></th>
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
                        "url": "{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>"}
                    },
                    "columns": [
                        { data: 'ass_item_id', name: 'ass_item_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'action', name: 'action',orderable: false, width:'10%'},
                        { data: 'elabram_tag', name: 'elabram_tag', width:'20%'},
                        { data: 'service_tag', name: 'service_tag' },
                        { data: 'brand_name', name: 'brand_name' },
                        { data: 'type_name', name: 'type_name' },
                        { data: 'status', name: 'status' },
                        { data: 'vendor_name', name: 'vendor_name' },
                        { data: 'price', name: 'price' },
                        { data: 'model', name: 'model' },
                        { data: 'status_name', name: 'status_name' },
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
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/do-excel') }}",
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
                if (action == 'download_history') {
                    $('.loading').show();
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/do-excel-history') }}",
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
                if (action == 'add_employee') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/add-employee') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'remove_employee') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/remove-employee') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'add') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/add') }}",
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
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/detail') }}",
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
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/edit') }}",
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
                        $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/do-delete') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                swal.close();
                                toastr.success('Delete successfully');
                                setTimeout(function () {
                                    location . reload();
                                }, 1000);
                            });
                    } else {
                        swal . close();
                        toastr.error("Cancelled", "Your action is cancelled :)",{timeOut: 2000});
                    }
                });

                }

                if (action == 'upload') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/upload') }}",
                    {
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'upload_assign') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/upload-assign') }}",
                    {
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'template_assign') {
                    $('.loading').show();
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/template-assign') }}",
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

            }

            function handleSelect(elm)
            {
                if (elm.value != '') {
                    window.location = elm.value;
                }
            }
        </script>
@endsection
