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

                        <div class="portlet-body">
                            <div class="row">
                                    <div class="col-md-4">
                                        <table class="table table-bordered table-hover">
                                            <thead style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Status</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                $a = 1;
                                                for($i=0; $i < count($status->result); $i++){
                                                    echo '<tr>';
                                                    echo '<td>'.$a.'</td>';
                                                    echo '<td>'.$status->result[$i]->cont_sta_name.'</td>';
                                                    echo '</tr>';
                                                    $a++;
                                                }
                                                @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <table class="table table-bordered table-hover">
                                            <thead style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Currency</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                $a = 1;
                                                for($i=0; $i < count($currency->result); $i++){
                                                    echo '<tr>';
                                                    echo '<td>'.$a.'</td>';
                                                    echo '<td>'.$currency->result[$i]->cur_name.'</td>';
                                                    echo '</tr>';
                                                    $a++;
                                                }
                                                @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                    <table class="table table-bordered table-hover" id="table">
                                            <thead style="background-color: #CCCCCC;">
                                                <th>Code</th>
                                                <th>Site Location</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                $a = 1;
                                                for($i=0; $i < count($contract_city->result); $i++){
                                                    echo '<tr>';
                                                    echo '<td>'.$a.'</td>';
                                                    echo '<td>'.$contract_city->result[$i]->cont_city_name.'</td>';
                                                    echo '</tr>';
                                                    $a++;
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

                var dataTable = $('#table').DataTable();
            });
        </script>
@endsection
