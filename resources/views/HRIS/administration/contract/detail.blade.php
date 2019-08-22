@extends('HRIS/layout.main')
@section('title', 'Detail Contract')
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
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase font-dark">{{$subtitle}}</span>
                            </div>
                            <div class="pull-right">

                                @if($contract->contract->is_cancel !="1")
                                    <div class="btn-group">
                                        <button class="btn dark btn-outline btn-circle btn-md border-rounded" type="button" data-toggle="dropdown" aria-expanded="false"> Extend
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            @if($access->menu_acc_add == 1 && $contract->contract->cont_sta_id != 3)
                                            <li>
                                                <a dataaction="extend" dataid="{{ md5($contract->latest_contract->cont_id)}}" onclick="get_modal(this)" href="#" style="border-right: 1px solid;">
                                                    <i class="fa fa-plus"></i> Extend Same Status
                                                </a>
                                            </li>
                                            <li>
                                                <a dataaction="extendChange" dataid="{{ md5($contract->latest_contract->cont_id)}}" onclick="get_modal(this)" href="#" style="border-right: 1px solid;">
                                                    <i class="fa fa-plus"></i> Extend Change Status
                                                </a>
                                            </li>
                                            @endif
                                            <li>
                                                <a dataaction="extendMemo" dataid="{{ md5($contract->latest_contract->cont_id)}}" onclick="get_modal(this)" href="#" style="border-right: 1px solid;">
                                                    <i class="fa fa-plus"></i> Memo
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @if($contract->contract->let_no_out !="")
                                        @if($contract->contract->let_no_out !="" &&  stripos($contract->contract->let_no_out, '/12/') == TRUE)
                                            <a dataaction="pdf_addendum"  dataid="{{ md5($contract->contract->cont_id)}}" onclick="get_modal(this)" href="#" class="btn dark btn-outline btn-circle btn-md border-rounded"
                                            style="border-right: 1px solid;"><i class="fa fa-file-pdf-o"></i> Memo
                                            </a>
                                        @else
                                            <a dataaction="pdf_addendum"  dataid="{{ md5($contract->contract->cont_id)}}" onclick="get_modal(this)" href="#" class="btn dark btn-outline btn-circle btn-md border-rounded"
                                            style="border-right: 1px solid;"><i class="fa fa-file-pdf-o"></i> Addendum
                                            </a>
                                        @endif
                                    @endif

                                @endif
                                @php
                                    if($link){
                                        echo '<a class="btn dark btn-outline btn-circle btn-md border-rounded" href="'. URL::asset(env('APP_URL').'/hris/administration/contract').'?link='. $link .'"
                                                style="border-right: 1px solid;"> Back
                                                </a>';
                                    }else{
                                        echo '<a href="'. URL::asset(env('APP_URL').'/hris/administration/contract') .'">Back</a>';
                                        echo '<a class="btn dark btn-outline btn-circle btn-md border-rounded" href="'. URL::asset(env('APP_URL').'/hris/administration/contract') .'"
                                                style="border-right: 1px solid;"> Back
                                                </a>';
                                    }
                                @endphp
                            </div>
                        </div>


















                        <div class="tabbable tabbable-tabdrop">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab1" data-toggle="tab">Contract </a>
                                </li>
                                <li>
                                    <a href="#tab2" data-toggle="tab">History Contract</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                <div class="portlet box" style="background-color: #444d58; margin-bottom: 0px">
                                    <div class="portlet-title">
                                        <div class="caption"><i class="icon-user" style="color: #fff !important"></i>
                                            Contract Information
                                        </div>
                                    </div>
                                    <div class="portlet-body" style="padding: 8px 15px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="padding: 0px 30px;" class="col-md-4">
                                                    <div class="form-group form-margin-0">
                                                        <div>
                                                            <label style="font-weight: bold;">Contract No</label>

                                                            @php
                                                            if( $contract->contract->let_no_out !=''){
                                                                    $let = '<br>
                                                                    <span style="font-size:11px;text-align:right;color:blue">(Letter Number: '. $contract->contract->let_no_out .')</span>';
                                                                }else{
                                                                    $let = '';
                                                                }


                                                                $contractNo = $contract->contract->cont_no_new !=''? $contract->contract->cont_no_new :'none';

                                                                echo '<div>'. $contractNo.$let .'</div>';
                                                            @endphp

                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Name</label>
                                                            <div>{{ $contract->contract->mem_name !=''? $contract->contract->mem_name :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Contract Date</label>
                                                            <div>{{ $contract->contract->cont_date !=''? $contract->contract->cont_date :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Contract Start</label>
                                                            <div>{{ $contract->contract->cont_start_date !=''? $contract->contract->cont_start_date :'none'}}</div>
                                                        </div>
                                                        <div>
                                                            <label style="font-weight: bold;">Contract End</label>
                                                            <div>{{ $contract->contract->cont_end_date !=''? $contract->contract->cont_end_date :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Contract Resign</label>
                                                            <div>{{ $contract->contract->cont_resign_date  !=''? $contract->contract->cont_resign_date.'('. $contract->contract->cont_resign_status.')' :'none'}}
                                                            </div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Download File	</label>
                                                            <div>
                                                                @if($contract->contract->cont_file_upload !="")
                                                                    <a href="{{ URL::asset(env('PUBLIC_PATH').'hris/files/employee/'). $contract->contract->cont_file_upload }}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                                                @else
                                                                none
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-margin-0">
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Contract Status</label>
                                                            <div>{{ $contract->contract->cont_sta_name !=''? $contract->contract->cont_sta_name :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Customer Name</label>
                                                            <div>{{ $contract->contract->cus_name !=''? $contract->contract->cus_name :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Site Location	</label>
                                                            <div>{{ $contract->contract->cont_city_name !=''? $contract->contract->cont_city_name :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Basic Salary</label>
                                                            <div>{{ $contract->contract->cur_id}}. {{ $contract->contract->cont_basic_salary}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Gross Salary</label>
                                                            <div>{{ $contract->contract->cur_id}}. {{ $contract->contract->cont_tot}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Note</label>
                                                            <div>{{ $contract->contract->cont_note !=''? $contract->contract->cont_note :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Update</label>
                                                            <div>{{ $contract->contract->cont_user !=''? $contract->contract->cont_user :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="padding: 0px 30px;">
                                                    <div class="form-group form-margin-0">
                                                        <div>
                                                            <label style="font-weight: bold;">Department</label>
                                                            <div>{{ $contract->contract->cont_dept !=''? $contract->contract->cont_dept :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Bank</label>
                                                            <div>{{ $contract->contract->bank_name !=''? $contract->contract->bank_name :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Bank Account</label>
                                                            <div>{{ $contract->contract->mem_bank_ac !=''? $contract->contract->mem_bank_ac :'none'}}</div>
                                                        </div>
                                                        <div>
                                                            <label style="font-weight: bold;">Bank Account</label>
                                                            <div>{{ $contract->contract->mem_bank_an !=''? $contract->contract->mem_bank_an :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Division/Cost Center</label>
                                                            <div>{{ $contract->contract->cont_div !=''? $contract->contract->cont_div :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div>
                                                            <label style="font-weight: bold;">Position</label>
                                                            <div>{{ $contract->contract->cont_position !=''? $contract->contract->cont_position :'none'}}</div>
                                                        </div>
                                                        @if($contract->contract->mem_citizenship == 'expatriate')
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        <div class="validate">
                                                            <label style="font-weight: bold;">Offshore</label>
                                                            <div>{{ $contract->contract->cont_offshore}}</div>
                                                        </div>
                                                        @endif
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        @if($contract->contract->effective_date !='')
                                                        <div>
                                                            <label style="font-weight: bold;">Effective Date</label>
                                                            <div>{{ $contract->contract->effective_date !=''? $contract->contract->effective_date :'none'}}</div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-title">
                                        <div class="caption"><i class="fa fa-check-square-o" style="color: #fff !important"></i>
                                            Allowance Information
                                        </div>
                                    </div>
                                    <div class="portlet-body" style="padding: 8px 15px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="padding: 0px 30px;" class="col-md-12">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <th>Allowance Type</th>
                                                            <th>Total</th>
                                                            <th>Description</th>
                                                            <th>Updated By</th>
                                                            <th>Update</th>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                        $a=1;
                                                            for($i = 0; $i < count($contract->allowance); $i++){
                                                            echo'<tr>
                                                                    <td>'.$contract->allowance[$i]->fix_allow_type_name.'</td>
                                                                    <td>'.$contract->allowance[$i]->cur_id.'.'.$contract->allowance[$i]->cont_det_tot.'</td>
                                                                    <td>'.$contract->allowance[$i]->cont_det_desc.'</td>
                                                                    <td>'.$contract->allowance[$i]->cont_det_user.'</td>
                                                                    <td>'.$contract->allowance[$i]->cont_det_update.'</td>

                                                                </tr>';
                                                            }
                                                        @endphp
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-title">
                                        <div class="caption"><i class="fa fa-check-square-o" style="color: #fff !important"></i>
                                            History Information
                                        </div>
                                    </div>
                                    <div class="portlet-body" style="padding: 8px 15px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="padding: 0px 30px;" class="col-md-12">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <th>Contract No</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Status</th>
                                                            <th>Income</th>
                                                            <th>Location</th>
                                                            <th>Update By</th>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                        $a=1;
                                                            for($i = 0; $i < count($contract->history); $i++){
                                                                if($contract->history[$i]->let_no_out !=''){
                                                                $let = '<br>
                                                                    <span class="pull-right" style="font-size:11px;text-align:right;color:blue">(Letter Number: '. $contract->history[$i]->let_no_out .')</span>';
                                                                }else{
                                                                    $let = '';
                                                                }
                                                            echo'<tr>
                                                                    <td>
                                                                    '.$contract->history[$i]->cont_no.$let.$contract->history[$i]->is_cancel.'
                                                                    </td>
                                                                    <td>'.$contract->history[$i]->cont_start_date.'</td>
                                                                    <td>'.$contract->history[$i]->cont_end_date.'</td>
                                                                    <td>'.$contract->history[$i]->cont_sta_name.'</td>
                                                                    <td>'.$contract->history[$i]->cur_id.'.'.$contract->history[$i]->cont_tot.'</td>
                                                                    <td>'.$contract->history[$i]->cont_city_name.'</td>
                                                                    <td>'.$contract->history[$i]->cont_user.'</td>
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
                                <div class="tab-pane" id="tab2">









                                    <div class="portlet box" style="background-color: #444d58; margin-bottom: 0px">
                                        <div class="portlet-title">
                                            <div class="caption"><i class="fa fa-check-square-o" style="color: #fff !important"></i>
                                                History Contract
                                            </div>
                                        </div>
                                        <div class="portlet-body" style="padding: 8px 15px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div style="padding: 0px 30px;" class="col-md-12">
                                                        <table class="table table-striped table-bordered table-advance table-hover" id="users-table">
                                                            <thead>
                                                            <tr>
                                                            <th>id. </th>
                                                                <th  class="no-sort"  style="width:10px">No. </th>
                                                                <th  class="no-sort" style="width:65px"> Updated Date </th>
                                                                <th> Updated By </th>
                                                                <th> Type </th>
                                                                <th style="width:200px"> No contract </th>
                                                                <th> Action </th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>






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
            var mem_id = {{ $contract->contract->mem_id }};

            $(document).ready(function () {

                var dataTable = $('#users-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'/hris/administration/contract/listdata-history') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>","mem_id":mem_id}
                    },
                    "columns": [
                        { data: 'cont_his_id', name: 'cont_his_id', visible: false},
                        { data: 'no', name: 'no', orderable: false, width: '10px'},
                        { data: 'updated_date', name: 'updated_date'},
                        { data: 'nama', name: 'nama'},
                        { data: 'type', name: 'type'},
                        { data: 'no_contract', name: 'no_contract'},
                        { data: 'action', name: 'action'},

                    ],
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

                if (action == 'pdf_addendum') {
                    var data = $(this).attr('data-column');
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'/hris/administration/contract/pdf') }}?type=addendum&id="+id, '_blank');
                }

                if (action == 'extend') {
                    var id = arr[0];
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract/extend') }}?link={{$link}}&id="+id;
                }
                if (action == 'extendChange') {
                    var id = arr[0];
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract/extend-change') }}?link={{$link}}&id="+id;
                }
                if (action == 'extendMemo') {
                    var id = arr[0];
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract/extend-memo') }}?link={{$link}}&id="+id;
                }

                if (action == 'detail') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = $(this).attr('data-column');
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/contract/history-detail') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }
            }
        </script>
@endsection
