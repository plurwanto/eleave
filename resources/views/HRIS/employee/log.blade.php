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
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-hover" id="table">
                                            <thead  style="background-color: #CCCCCC;">
                                                <th>Name</th>
                                                <th>Log Error</th>
                                            </thead>
                                            <tbody>
                                            @php

                                            $log_error = json_decode($log_error);
                                            $str = '';
                                            if($log_error){
                                                for($i = 0; $i < count($log_error); $i++){
                                                    if(count($log_error[$i]->message) > 0){
                                                        $str .= '<tr>';
                                                        $str .= '<td>'. $log_error[$i]->nama .'</td>';
                                                        $str .= '<td>';
                                                        $msg[$i] = '';
                                                        for($a= 0; $a < count($log_error[$i]->message); $a++){
                                                            $msg[$i] .= $log_error[$i]->message[$a]->message.' | ';
                                                        }
                                                        $str .= $msg[$i];
                                                        $str .= '</td>';
                                                        $str .= '</tr>';
                                                    }
                                                }
                                                echo $str;

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
if (Request::segment(3) != '') {
    $url_current = '/' . Request::segment(1) . '/' . Request::segment(2) . '/' . Request::segment(3);
} else {
    $url_current = '/' . Request::segment(1) . '/' . Request::segment(2);
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
