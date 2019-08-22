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
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css"> -->

    <!-- END PAGE LEVEL PLUGINS -->

<style>
.dataTables_filter { display: none; }

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
                                <span class="caption-subject bold uppercase font-dark">{{$subtitle}} 
                                </span>
                            </div>
                            <div style="float: left; margin-left: 10px; margin-top: 2px;">
                                {!! $select !!}
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
                                                        echo  '<a href="'. URL::asset(env('APP_URL').'hris/administration/contract/export-excel-template') .'">Download Template </a>';
                                                    @endphp    
                                                    </li>
                                                    <li>
                                                    @php
                                                        echo '<a href="'. URL::asset(env('APP_URL').'hris/administration/contract?link=rule-template') .'">Rules Template </a>';
                                                    @endphp  
                                                    </li>
                                                </ul>
                                            </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
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
                                <th> Resign Status </th>
                                <th> Status </th>
                                <th> Updated By </th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type="text" data-column="0"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Name"></td>
                                <td><input type="text" data-column="1"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search NIP"></td>
                                <td><input type="text" data-column="2"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search Contract No"></td>
                                <td><input type="text" data-column="3"  class="search-input-text form-control input-sm   border-rounded  date-picker" placeholder="Search Start Date" data-date-format="dd/mm/yyyy"></td>
                                <td><input type="text" data-column="4"  class="search-input-text form-control input-sm   border-rounded  date-picker" placeholder="Search End Date" data-date-format="dd/mm/yyyy"></td>
                                <td></td>
                                <td></td>
                                <td>
                                <select data-column="5" name="status" class="search-input-select form-control input-sm select2">
                                            <option value="">-- Choose a contract_status --</option>
                                            @for($i = 0; $i < count($contract_status->result); $i++)
                                            <option value="{{$contract_status->result[$i]->cont_sta_id}}">{{$contract_status->result[$i]->cont_sta_name}}</option>
                                            @endfor
                                    </select>
                                </td>
                                <td><input type="text" data-column="6"  class="search-input-text form-control input-sm   border-rounded" placeholder="Search User"></td>
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

            var $cus_id = document.getElementById("link").value;
            $(document).ready(function () {
                <?php
                   if(Request::segment(3) !=''){
                        $url_current ='/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3);
                    }else{
                        $url_current ='/'.Request::segment(1).'/'.Request::segment(2);
                    }
                ?>
                var dataTable = $('#users-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [[ 0, "DESC" ]],
                    "scrollY": "300px",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "fixedColumns":   {
                        "leftColumns": 5,
                    },
                    "ajax": {
                        "url": "{{ URL::asset(env('APP_URL').'hris/administration/contract/listdata') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {"_token": "<?=csrf_token()?>","url_current":"<?=$url_current?>","cus_id":$cus_id}
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
                        { data: 'cont_resign_status', name: 'cont_resign_status', width:'80px'},
                        { data: 'cont_sta_name', name: 'cont_sta_name',width:'100px'},
                        { data: 'cont_user', name: 'cont_user',width:'100px' }
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
                linkObj = $(e);
                action = $(e).attr('dataaction');
                dataid = $(e).attr('dataid');
                var arr = dataid.split("|");
                var link = $("#link").val();

              
                if (action == 'add') {
                    var id = arr[0];
                    window.location = "{{ URL::asset(env('APP_URL').'hris/administration/contract/add') }}";
                }
                if (action == 'upload') {
                    $('#modalLarge').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'hris/administration/contract/upload') }}",
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
                    window.location = "{{ URL::asset(env('APP_URL').'hris/administration/contract/edit') }}?link={{$link}}&id="+id;
                }
                if (action == 'detail') {
                    var id = arr[0];
                    window.location = "{{ URL::asset(env('APP_URL').'hris/administration/contract/detail') }}?link={{$link}}&id="+id;
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
                        $.get("{{ URL::asset(env('APP_URL').'hris/administration/contract/do-delete') }}",
                            {
                                link: link,
                                id: arr[0]
                            },
                            function (data) {
                                swal({title: "Successfully", type: "success"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'hris/administration/contract') }}?link={{$link}}";
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



                if (action == 'pdf_eng') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'hris/administration/contract/pdf') }}?type=eng&id="+id, '_blank');
                }
                if (action == 'pdf_ind') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'hris/administration/contract/pdf') }}?type=ind&id="+id, '_blank');

                }
                
                if (action == 'pdf_addendum') {
                    var id = arr[0];
                    window.open("{{ URL::asset(env('APP_URL').'hris/administration/contract/pdf') }}?type=addendum&id="+id, '_blank');
                }

                if (action == 'resign') {
                    $('#modalLarge').modal({backdrop: 'static', show: true, keyboard: false});
                    var id = arr[0];
                    $.get("{{ URL::asset(env('APP_URL').'hris/administration/contract/resign') }}",
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
                    window.location = "{{ URL::asset(env('APP_URL').'hris/administration/contract') }}?link="+ elm.value;
                }
            }
        </script>
@endsection
