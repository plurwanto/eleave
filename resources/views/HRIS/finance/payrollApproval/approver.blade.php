@extends('HRIS/layout.main')
@section('title', 'Payroll Approval')
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
        @endif
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
.dataTables_filter { display: none};
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
                                <th> Code </th>
                                <th> Title </th>
                                <th> Customer </th>
                                <th> Referance </th>
                                <th> Amount</th>
                                <th> Status </th>
                                <th> Condition </th>
                            </tr>
                            </thead>
                            <thead>
                                <th></th>
                                <th></th>
                                <th><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Code"></th>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Title"></th>
                                <th>
                                    <select data-placeholder="choose a customer"  data-column="2" name="customer" class="search-input-select form-control input-sm select2">
                                            <option value="">-- Choose a customer --</option>
                                            @for($i = 0; $i < count($customer); $i++)
                                            <option value="{{$customer[$i]->cus_id}}">{{$customer[$i]->cus_name}}</option>
                                            @endfor
                                    </select>
                                </th>
                                <th><input type="text"  data-column="3"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Letter No"></th>
                                <th>
                                    <select data-column="4"  data-placeholder="choose a type" name="currency" class="search-input-select form-control input-sm select2">
                                            <option value="">-- Choose a currency --</option>
                                            @for($i = 0; $i < count($currency->result); $i++)
                                            <option value="{{$currency->result[$i]->cur_id}}">{{$currency->result[$i]->cur_name}}</option>
                                            @endfor
                                    </select>
                                </th>
                                <th>
                                    <select   data-column="5" class="search-input-select form-control input-sm border-rounded">
                                        <option value=""> all </option>
                                        <option value="0"> Request</option>
                                        <option  value="2"> Closed</option>
                                        <option  value="3"> Rejected</option>
                                        <option  value="4"> Re-open</option>
                                    </select>
                                </th>
                                <th>
                                    <select   data-column="6" class="search-input-select form-control input-sm border-rounded">
                                        <option value=""> all </option>
                                        <option value="1">need approval</option>
                                        <option  value="2">without bankslip</option>
                                        <option  value="3">closed</option>
                                    </select>
                                </th>
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


<div class="modal fade bs-modal-lg" id="modalAction" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
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
                        "url": "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/listdataapprover') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>"}
                    },
                    "columns": [
                        { data: 'updated_date', name: 'updated_date', visible: false},
                        { data: 'no', name: 'no', orderable: false},
                        { data: 'action', name: 'action',orderable: false, width:'2%'},
                        { data: 'app_code', name: 'app_code' },
                        { data: 'app_name', name: 'app_name'},
                        { data: 'cus_name', name: 'cus_name' },
                        { data: 'reference', name: 'reference', width:'8%' },
                        { data: 'amount', name: 'amount', width:'14%' },
                        { data: 'app_status', name: 'app_status', width:'8%'},
                        { data: 'condition', name: 'condition', width:'8%'},

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
                var link = $('#link option:selected').text();
                var id = $(this).attr('data-column');

                if (action == 'add') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/add') }}",
                    {
                        link: link,

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'detail') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/detail') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'approve') {
                    swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: 'btn btn-success',
                        cancelButtonColor: 'btn btn-success',
                        confirmButtonText: "Yes, approve it!",
                        cancelButtonText: "No, cancel please!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                function (isConfirm) {
                    $('.loading').show();
                    if (isConfirm) {
                        $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/do-approve') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                $('.loading').hide();
                                swal({title: "Successfully", type: "success"},
                                function () {
                                    location.reload();
                                }
                        );
                            });
                    } else {
                        $('.loading').hide();
                        swal . close();
                        toastr.error("Cancelled", "Your action is cancelled :)",{timeOut: 2000});
                    }
                });

                }

                if (action == 'reject') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/reject') }}",
                    {
                        link: link,
                        id: arr[0]

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'upload-bankslip') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/bankslip') }}",
                    {
                        link: link,
                        id: arr[0]

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'checker') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/checker') }}",
                    {
                        link: link,
                        id: arr[0]

                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

                if (action == 'reopen') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/reopen') }}",
                    {
                        link: link,
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
                    window.location = elm.value;
                }
            }
        </script>
@endsection
