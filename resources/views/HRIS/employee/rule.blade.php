@extends('HRIS/layout.main')

@section('title', $title)

@section('breadcrumbs')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <span>{{$title}}</span>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{$subtitle}}</span>
    </li>
</ul>
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
.loading{
    background: #000000;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    opacity: 0.5;
    z-index: 8888888888;
    display: none;
}
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
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase font-dark">{{$subtitle}}</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#"> </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                                <div class="row">
                                <div class="col-md-6">
                                    @if($access)
                                            <div class="btn-group">
                                                <a  class="btn dark btn-outline btn-circle btn-md border-rounded" onclick="get_modal(this)" href="javascript:;" data-toggle="dropdown" aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    @if($access->menu_acc_add == 1)
                                                    <li>
                                                        <a dataaction="add" dataid="" onclick="get_modal(this)">
                                                            <i class="fa fa-plus"></i> Add New </a>
                                                    </li>
                                                    <li>
                                                        <a dataaction="upload"  dataid="" onclick="get_modal(this)" href="#">
                                                            <i class="fa fa-upload"></i> Upload New </a>
                                                    </li>
                                                    @endif
                                                    <li class="divider"> </li>
                                                    <li>
                                                    @php
                                                        echo  '<a href="'. URL::asset(env('APP_URL').'hris/employee/export-excel-template') .'">Download Template </a>';
                                                    @endphp    
                                                    </li>
                                                    <li>
                                                    @php
                                                        echo '<a href="'. URL::asset(env('APP_URL').'hris/employee?link=rule-template') .'">Rules Template </a>';
                                                    @endphp  
                                                    </li>
                                                </ul>
                                            </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-4">
                                        <table class="table table-bordered table-hover">
                                            <thead style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Gender</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Male</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Female</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-hover">
                                            <thead  style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Tax Remark</th>
                                            </thead>
                                            <tbody>
                                            @php
                                                $a = 1;
                                                for($i = 0; $i < count($tax_remark->result); $i++){
                                                 echo '<tr>
                                                            <td>'. $a++ .'</td>
                                                            <td>'. $tax_remark->result[$i]->tr_name .'</td>
                                                        </tr>';   
                                                }
                                            @endphp  
                                            </tbody>  
                                            </table>
                                        </table>
                                        <table class="table table-bordered table-hover">
                                            <thead  style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Insurance</th>
                                            </thead>
                                            <tbody>
                                            @php
                                                $a = 1;
                                                for($i = 0; $i < count($insurance->result); $i++){
                                                 echo '<tr>
                                                            <td>'. $a++ .'</td>
                                                            <td>'. $insurance->result[$i]->insr_name .'</td>
                                                        </tr>';   
                                                }
                                            @endphp  
                                            </tbody>  
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                      <table class="table table-bordered table-hover">
                                            <thead  style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Marital</th>
                                            </thead>
                                            <tbody>
                                            @php
                                                $a = 1;
                                                for($i = 0; $i < count($marital->result); $i++){
                                                 echo '<tr>
                                                            <td>'. $a++ .'</td>
                                                            <td>'. $marital->result[$i]->mem_marital_name .'</td>
                                                        </tr>';   
                                                }
                                            @endphp  
                                            </tbody>  
                                            </table>
                                        </table>
                                        <table class="table table-bordered table-hover">
                                            <thead style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>User Level</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-hover">
                                            <thead style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Citizenship</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Local</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Expatriate</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                      <table class="table table-bordered table-hover">
                                            <thead  style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Religion</th>
                                            </thead>
                                            <tbody>
                                            @php
                                                $a = 1;
                                                for($i = 0; $i < count($religion->result); $i++){
                                                 echo '<tr>
                                                            <td>'. $a++ .'</td>
                                                            <td>'. $religion->result[$i]->religi_name .'</td>
                                                        </tr>';   
                                                }
                                            @endphp  
                                            </tbody>  
                                            </table>
                                        </table>

                                        <table class="table table-bordered table-hover">
                                            <thead style="background-color: #CCCCCC;">
                                                <th>Other Rule</th>
                                                <th>Valid Format</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>date of birth</td>
                                                    <td>dd/mm/yyyy</td>
                                                </tr>
                                                <tr>
                                                    <td>date of end passport</td>
                                                    <td>dd/mm/yyyy</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>please enter valid email address with '@'</td>
                                                </tr>
                                                <tr>
                                                    <td>bank account</td>
                                                    <td>only number</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-hover" id="table">
                                            <thead  style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Bank</th>
                                            </thead>
                                            <tbody>
                                            @php
                                                $a = 1;
                                                for($i = 0; $i < count($bank->result); $i++){
                                                 echo '<tr>
                                                            <td>'. $bank->result[$i]->bank_id .'</td>
                                                            <td>'. $bank->result[$i]->bank_name .'</td>
                                                        </tr>';   
                                                }
                                            @endphp  
                                            </tbody>  
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-hover" id="table2">
                                            <thead  style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Nationality</th>
                                            </thead>
                                            <tbody>
                                            @php
                                                $a = 1;
                                                for($i = 0; $i < count($nationality->result); $i++){
                                                 echo '<tr>
                                                            <td>'. $nationality->result[$i]->nat_id .'</td>
                                                            <td>'. $nationality->result[$i]->nat_name .'</td>
                                                        </tr>';   
                                                }
                                            @endphp  
                                            </tbody>  
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>


<div class="modal fade bs-modal-lg" id="modalLarge" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div style="text-align: center"><h2><i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>
                <span>Loading...</span></h2>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade bs-modal-lg" id="modalSmall" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div style="text-align: center"><h2><i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>
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


        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'ui-sweetalert.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <script type="text/javascript">
            $(document).ready(function () {
                <?php
                   if(Request::segment(3) !=''){
                        $url_current ='/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3);
                    }else{
                        $url_current ='/'.Request::segment(1).'/'.Request::segment(2);
                    }
                ?>
                var dataTable = $('#table').DataTable();
                var dataTable = $('#table2').DataTable();

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
                    $('#modalLarge').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'hris/employee/add') }}",
                    {
                        link: link,
                        
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'upload') {
                    $('#modalLarge').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'hris/employee/upload') }}",
                    {
                        link: link,
                        
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'edit') {
                    $('#modalLarge').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'hris/employee/edit') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
                if (action == 'detail') {
                    $('#modalLarge').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'hris/employee/detail') }}",
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
                        $.get("{{ URL::asset(env('APP_URL').'hris/employee/do-delete') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                swal({title: "Successfully", type: "success"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'hris/employee') }}?master={{$link}}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                            });
                    } else {
                        swal("Cancelled", "Your action is cancelled :)", "error");
                        return false;
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
