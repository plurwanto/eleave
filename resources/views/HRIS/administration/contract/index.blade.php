@extends('HRIS/layout.main')
@section('title', 'Contract')
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
        {!! $select !!}
        @if($access->menu_acc_add == 1)
            <a dataaction="add"  dataid="" title="add" onclick="get_modal(this)" class="border-rounded btn btn-icon-only green" style="
            border-right: 1px solid;
            width: 40px;"><i class="fa fa-plus"></i>
            </a>
            <a dataaction="uploadContract"  dataid="" title="upload contract" onclick="get_modal(this)" class="border-rounded btn btn-icon-only green" style="
            border-right: 1px solid;
            width: 40px;"><i class="fa fa-upload"></i>
            </a>
        @endif
        <div class="btn-group pull-right">
            <a class="btn green border-rounded" title="file" onclick="get_modal(this)" href="javascript:;" data-toggle="dropdown" aria-expanded="false" style="padding: 6px 0px;width: 40px;"><i class="fa fa-file-text" style="margin-right: 3px;"></i><i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a dataaction="filterExcel"  dataid="" onclick="get_modal(this)" href="#"> <i class="fa fa-file-excel-o" style="
                    margin-right: 3px;
                    "></i>Export</a>
                </li>

                @php
                    echo  '<li><a href="'. URL::asset(env('APP_URL').'/hris/administration/contract/template') .'"><i class="fa fa-file-excel-o" style="
                margin-right: 3px;
                "></i>Template </a></li>';
                    echo  '<li><a target="blank" href="'. URL::asset(env('APP_URL').'/hris/administration/contract/rule') .'"><i class="fa fa-file-excel-o" style="
                margin-right: 3px;
                "></i>Rule </a></li>';
                @endphp
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
                                <th  class="no-sort" style="width:65px"> Action </th>
                                <th> Employee </th>
                                <th> NIP </th>
                                <th> Contract No </th>
                                <th> Start Date </th>
                                <th> End Date </th>
                                <th> Resign Date </th>
                                <!-- <th> Resign Status </th> -->
                                <th> Status </th>
                                <th> Site Location </th>
                            </tr>
                            </thead>
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Name"></th>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search NIP"></th>
                                <th><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Contract No"></th>
                                <th><input type="text" data-column="3"  class="search-input-text form-control input-sm   border-rounded  date-picker" placeholder="Search Start Date" data-date-format="dd/mm/yyyy"></th>
                                <th><input type="text" data-column="4"  class="search-input-text form-control input-sm   border-rounded  date-picker" placeholder="Search End Date" data-date-format="dd/mm/yyyy"></th>
                                <th></th>
                                <!-- <th></th> -->
                                <th>
                                <select data-column="5" name="status" class="search-input-select form-control input-sm select2">
                                            <option value="">-- Choose a contract status --</option>
                                            @for($i = 0; $i < count($contract_status->result); $i++)
                                            <option value="{{$contract_status->result[$i]->cont_sta_id}}">{{$contract_status->result[$i]->cont_sta_name}}</option>
                                            @endfor
                                    </select>
                                </th>
                                <th><input type="text" data-column="6"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search site"></td>
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

            var cus_id = document.getElementById("link").value;
            $(document).ready(function () {

                var dataTable = $('#users-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'/hris/administration/contract/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>","cus_id":cus_id}
                    },
                    "columns": [
                        { data: 'cont_id', name: 'cont_id', visible: false},
                        { data: 'no', name: 'no', orderable: false, width:'20px'},
                        { data: 'action', name: 'action', width:'80px'},
                        { data: 'mem_name', name: 'mem_name', width:'150px'},
                        { data: 'mem_nip', name: 'mem_nip', width:'100px'},
                        { data: 'cont_no', name: 'cont_no', width:'200px'},
                        { data: 'cont_start_date', name: 'cont_start_date', width:'80px'},
                        { data: 'cont_end_date', name: 'cont_end_date', width:'80px'},
                        { data: 'cont_resign_date', name: 'cont_resign_date', width:'80px'},
                        { data: 'cont_sta_name', name: 'cont_sta_name',width:'100px'},
                        { data: 'cont_city_name', name: 'cont_city_name',width:'100px' }
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
                    var id = arr[0];
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract/add') }}?link="+cus_id;
                }

                if (action == 'uploadContract') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/contract/upload-contract') }}",
                    {
                        link: link,
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'upload') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/contract/upload') }}",
                    {
                        link: link,
                        id: arr[0],
                        name: arr[1]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'edit') {
                    var id = arr[0];
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract/edit') }}?link="+link+"&id="+id;
                }
                if (action == 'detail') {
                    var id = arr[0];
                        window.open('{{ URL::asset(env('APP_URL').'/hris/administration/contract/detail') }}?link='+link+'&id='+id,'_blank');
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
                        $.get("{{ URL::asset(env('APP_URL').'/hris/administration/contract/do-delete') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                swal({title: "Successfully", type: "success"},
                                function () {
                                    location.reload();
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


                if (action == 'cancel') {
                    swal({
                        title: "Are you sure cancel it?",
                        //   text: "But you will still be able to retrieve this file.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: 'btn btn-danger',
                        cancelButtonColor: 'btn btn-danger',
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                function (isConfirm) {
                    if (isConfirm) {
                        $.get("{{ URL::asset(env('APP_URL').'/hris/administration/contract/do-cancel') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                swal({title: "Successfully", type: "success"},
                                function () {
                                    location.reload();
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


                if (action == 'pdf_eng') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'/hris/administration/contract/pdf') }}?type=eng&id="+id, '_blank');
                }
                if (action == 'pdf_ind') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'/hris/administration/contract/pdf') }}?type=ind&id="+id, '_blank');

                }


                if (action == 'pdf_tha') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'/hris/administration/contract/pdf') }}?type=tha&id="+id, '_blank');

                }

                if (action == 'pdf_phi') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'/hris/administration/contract/pdf') }}?type=phi&id="+id, '_blank');

                }

                if (action == 'pdf_addendum') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'/hris/administration/contract/pdf') }}?type=addendum&id="+id, '_blank');
                }

                if (action == 'resign') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = arr[0];
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/contract/resign') }}",
                    {
                        id: arr[0],
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'filterExcel') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/contract/filter-excel') }}",
                    {
                        id: arr[0],
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
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract') }}?link="+ elm.value;
                }
            }
        </script>
@endsection
