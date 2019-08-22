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


    <div class="pull-right">
        <div class="btn-group pull-right">
            <a class="btn green border-rounded" title="file" onclick="get_modal(this)" href="javascript:;" data-toggle="dropdown" aria-expanded="false" style="padding: 6px 0px;width: 40px;"><i class="fa fa-file-text" style="margin-right: 3px;"></i><i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu pull-right">
                @php
                echo  '<li><a dataaction="download"  dataid="" title="download" onclick="get_modal(this)"><i class="fa fa-file-excel-o" style="
                margin-right: 3px;
                "></i>Export</a></li>';
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
                        <div style="width: 85em;
                        overflow-x: auto;
                        white-space: nowrap;">
                            <table class="table table-striped table-bordered table-advance table-hover" id="users-table">
                            <thead>
                            <tr>
                            <th>id. </th>
                                <th  class="no-sort"  style="width:10px">No. </th>
                                <th  class="no-sort" style="width:15px"> Action </th>
                                <th> Name </th>
                                <th> ID Number </th>
                                <th> Email </th>
                                <th> Customer </th>
                                <th> Position </th>
                                <th> Status </th>
                                <th> Date Interview</th>
                                <th> Condition </th>
                                <th> Hired By </th>
                            </tr>
                            </thead>
                            <thead>
                            <tr>
                            <th></th>
                                <th></th>
                                <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Name"></th>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search ID Number"></th>
                                <th><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Email"></th>
                                <th>
                                    <select data-column="3" name="brnm" class="search-input-select form-control input-sm select2">
                                            <option value="">-- Choose a customer --</option>
                                            @for($i = 0; $i < count($customer->result); $i++)
                                            <option value="{{$customer->result[$i]->cus_id}}">{{$customer->result[$i]->cus_name}}</option>
                                            @endfor
                                    </select>
                                </th>
                                <th><input type="text" data-column="4"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Position"></th>
                                <th>
                                    <select data-column="5" name="brnm" class="search-input-select form-control input-sm">
                                        <option value="">-- Choose a status --</option>
                                        <option value="SUBMITTED">SUBMITTED</option>
                                        <option value="HIRED">HIRED</option>
                                        <option value="REJECTED">REJECTED</option>
                                    </select>
                                </th>
                                <th><input type="text" data-column="6"  class="search-input-text form-control input-sm   border-rounded date-picker" placeholder="Search Position"></th>
                                <th>
                                    <select data-column="7" name="brnm" class="search-input-select form-control input-sm">
                                        <option value="">-- Choose a condition --</option>
                                        <option value="not synchronized">Not Synchronized</option>
                                        <option value="no contract">No Contract</option>
                                        <option value="contracted">Contracted</option>
                                    </select>
                                </th>
                                <th><input type="text" data-column="8"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search User"></th>
                            </tr>
                            </thead>
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
                        "url": "{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>"}
                    },
                    "columns": [
                        { data: 'mem_id', name: 'mem_id', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'action', name: 'action',orderable: false, width:'10%'},
                        { data: 'mem_name', name: 'mem_name', width:'20%'},
                        { data: 'mem_ktp_no', name: 'mem_ktp_no', width:'10%'},
                        { data: 'mem_email', name: 'mem_email' },
                        { data: 'cus_name', name: 'cus_name' },
                        { data: 'position', name: 'position' },
                        { data: 'status', name: 'status' },
                        { data: 'rod_interview_client_date', name: 'rod_interview_client_date' },
                        { data: 'status_rod', name: 'status_rod' },
                        { data: 'nama', name: 'nama', width:'20%' }
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

                if (action == 'detail') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/others/detail') }}",
                    {
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'add') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/add') }}",
                    {
                        id: arr[0]

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'addHrisUser') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/edit') }}",
                    {
                        id: arr[0]

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
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }



                if (action == 'download') {
                    $('.loading').show();
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/export-excel') }}",
                            {

                                id: arr[0]
                            },
                            function (data) {
                                $('.loading').hide();
                                toastr.success('download successfully');
                                window.location = data.path;

                            }

                        );
                }

                if (action == 'reject') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/reject') }}",
                    {
                        mem_id_hris: arr[0],
                        rod_id: arr[1]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'hired') {
                    swal({
                        title: "Are you sure?",
                        //   text: "But you will still be able to retrieve this file.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: 'btn btn-danger',
                        cancelButtonColor: 'btn btn-danger',
                        confirmButtonText: "Yes, hired it!",
                        cancelButtonText: "No, cancel please!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },

                    function (isConfirm) {
                        if (isConfirm) {
                            $.get("{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/do-hired') }}",
                                {

                                    id: arr[0],
                                    rod_id: arr[1],
                                    ro_id: arr[2]
                                },
                                function (data) {
                                    swal . close();
                                    toastr.success('Action successfully');
                                    setTimeout(function () {
                                        location . reload();
                                    }, 1000);

                                });
                        } else {
                            swal("Cancelled", "Your action is cancelled :)", "error");
                            return false;
                        }
                    });

                }


                if (action == 'search') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/add') }}",
                    {

                        id: arr[0]

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
}

function setHeight() {
    this.style.height = '1px';
    this.style.height = this.scrollHeight + 'px';
}

function checkCitizenship(citizenship) {
    if (citizenship.value == "Local") {
        document.getElementsByClassName('local-only')[0].style.display = "block";
        document.getElementsByClassName('expatriate-only')[0].style.display = "none";
    } else if (citizenship.value == "Expatriate") {
        document.getElementsByClassName('local-only')[0].style.display = "none";
        document.getElementsByClassName('expatriate-only')[0].style.display = "block";
    }

}

function onFocus(input, type, flag){

    if(type == "radio"){
        input.parentNode.style.color = "#414040";
    } else{
        input.style.color = "#414040";
        input.style.borderColor = "#0584D3";
    }

    if(flag == "compare"){
        onHighlight(input);
    }
}

function onHighlight(input){
    var className = '';
    if(input.classList.contains('name')){
        className = 'recruitment-name';
    } else if(input.classList.contains('email')){
        className = 'recruitment-email';
    } else if(input.classList.contains('hp')){
        className = 'recruitment-hp';
    } else if(input.classList.contains('gender')){
        className = 'recruitment-gender';
    } else if(input.classList.contains('birthplace')){
        className = 'recruitment-birthplace';
    } else if(input.classList.contains('birth')){
        className = 'recruitment-birth';
    } else if(input.classList.contains('religion')){
        className = 'recruitment-religion';
    } else if(input.classList.contains('marital')){
        className = 'recruitment-marital';
    } else if(input.classList.contains('nationality')){
        className = 'recruitment-nationality';
    } else if(input.classList.contains('address')){
        className = 'recruitment-address';
    } else if(input.classList.contains('emergencyName')){
        className = 'recruitment-emergencyName';
    } else if(input.classList.contains('emergencyRelationship')){
        className = 'recruitment-emergencyRelationship';
    } else if(input.classList.contains('emergencyContact')){
        className = 'recruitment-emergencyContact';
    } else {
        className = '';
    }

    if (className != ''){
        document.getElementsByClassName(className)[0].style.color = "#414040";
        document.getElementsByClassName(className)[0].style.borderColor = "#0584D3";
        document.getElementsByClassName(className)[1].style.color = "#414040";
        document.getElementsByClassName(className)[1].style.borderColor = "#0584D3";
    }
}

function onBlur(input, type, flag){

    if(type == "radio"){
        input.parentNode.style.color = "#BDBDBD";
    } else{
        input.style.color = "#BDBDBD";
        input.style.borderColor = "#BDBDBD";
    }

    if(flag == "compare"){
        onRemoveHighlight(input);
    }
}

function onRemoveHighlight(input){
    var className = '';
    if(input.classList.contains('name')){
        className = 'recruitment-name';
    } else if(input.classList.contains('email')){
        className = 'recruitment-email';
    } else if(input.classList.contains('hp')){
        className = 'recruitment-hp';
    } else if(input.classList.contains('gender')){
        className = 'recruitment-gender';
    } else if(input.classList.contains('birthplace')){
        className = 'recruitment-birthplace';
    } else if(input.classList.contains('birth')){
        className = 'recruitment-birth';
    } else if(input.classList.contains('religion')){
        className = 'recruitment-religion';
    } else if(input.classList.contains('marital')){
        className = 'recruitment-marital';
    } else if(input.classList.contains('nationality')){
        className = 'recruitment-nationality';
    } else if(input.classList.contains('address')){
        className = 'recruitment-address';
    } else if(input.classList.contains('emergencyName')){
        className = 'recruitment-emergencyName';
    } else if(input.classList.contains('emergencyRelationship')){
        className = 'recruitment-emergencyRelationship';
    } else if(input.classList.contains('emergencyContact')){
        className = 'recruitment-emergencyContact';
    } else {
        className = '';
    }

    if(className != ''){
        document.getElementsByClassName(className)[0].style.color = "#BDBDBD";
        document.getElementsByClassName(className)[0].style.borderColor = "#BDBDBD";
        document.getElementsByClassName(className)[1].style.color = "#BDBDBD";
        document.getElementsByClassName(className)[1].style.borderColor = "#BDBDBD";
    }
}

function handleSelect(elm) {
    if (elm.value != '') {
        window.location = elm.value;
    }
}
</script>
@endsection
