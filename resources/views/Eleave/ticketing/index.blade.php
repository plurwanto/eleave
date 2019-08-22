@extends('Eleave.layout.main')

@section('title','Eleave | Ticketing')

@section('style')
<!-- multiple-select.css -->
<link type="text/css" rel="stylesheet" href="{{ URL::asset(env('PUBLIC_PATH').'css/multiple-select.css') }}"></link>

<style type="text/css">
    .my-divider {
        margin-bottom: 20px;
    }
    .modal-header, h4, .close {
        background-color: #32c5d2;
        color:white !important;
        text-align: center;
        font-size: 25px;
    }
    .modal-footer {
        background-color: #efeeee;
    }
    .dataTables_empty {
        text-align: center;
    }
    .after-date {
        display: none;
    }
    .detail-title {
        font-weight: bold;
    }
    #btn-image {
        display: none;
    }
    .image-preview {
        position: absolute;
        z-index: 999;
        top: 0px;
        background-color: #fff;
        border: 1px solid #ababab;
        display: none;
    }
    .image-preview .header{
        background-color: #32c5d2;
        color: #fff;
        padding: 5px;
        text-align: center;
    }
    .image-preview .content{
        padding: 10px;
    }
    .image-preview .header .fa-close{
        color: red;
    }
    .image-preview .header .fa-close:hover{
        cursor: pointer;
    }
    /*.image-preview .content img:hover { 
        transform: scale(1.2); 
    }*/

    div.dataTables_length label {
        float: left;
    }
    .dataTables_scrollBody {
        margin-top: -10px!important;
    } 
    .dataTables_scrollBody .sorting,
    .dataTables_scrollBody .sorting_asc,
    .dataTables_scrollBody .sorting_desc {
        background: none!important;
        border-bottom: 1px solid #e7ecf1!important;
    }
    .DTFC_RightBodyLiner .sorting {
        background: none!important;
    }
    .DTFC_RightHeadWrapper th:last-child  {
        background: none!important;
    }
    .table>tr:first-child > th .sorting {
        background: none;
    }
    
    
    /* .table.table-bordered thead>tr:last-of-type>th:first-of-type {
        border-bottom : none;
    } */

    /* .dataTables_scrollHead:first-of-type > thead > th {
        border-bottom: none;
    } */


    #closeTable_wrapper .dataTables_scrollHeadInner {
        width: auto!important;
        border-bottom: none;
    }
    #closeTable_wrapper .dataTables_scrollHead table,
    #closeTable_wrapper .dataTables_scrollBody table {
        width: 100%!important;
    }
    #closeTable_wrapper .table.table-bordered thead:last-child>tr>th{
        border-bottom: 1px solid #e7ecf1!important;
    }
    #closeTable_wrapper .dataTables_scrollBody .sorting,
    #closeTable_wrapper .dataTables_scrollBody .sorting-disabled,
    #closeTable_wrapper .dataTables_scrollBody .sorting_asc,
    #closeTable_wrapper .dataTables_scrollBody .sorting_desc {
        border-bottom: none!important;
    }
    #closeTable_wrapper .dataTables_scrollHeadInner thead>tr>th:first-of-type {
        border-bottom: 0;
    }

    @media (min-width: 1024px;) and (max-width:1079px;) {
        #closeTable_wrapper .dataTables_scrollHeadInner {
            width: unset!important;
        }
        #closeTable_wrapper .dataTables_scrollHead table,
        #closeTable_wrapper .dataTables_scrollBody table {
            width: unset!important;
        }
    }
    table.dataTable thead tr:last-child {
    border-bottom: 1px solid #e7ecf1!important;
    }

    .table>thead:first-child>tr:first-child>th {
        border: 1px solid #e7ecf1;
    }
    
</style>
@endsection

@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-building"></i>Ticketing
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        @if($roleTicketing == 'admin')
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#openTab" aria-controls="open" role="tab" data-toggle="tab">Open</a>
                </li>
                <li role="presentation">
                    <a href="#closeTab" aria-controls="close" role="tab" data-toggle="tab">Close</a>
                </li>
            </ul>
        @endif

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="openTab">
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="dt-buttons">
                            <button class="btn btn-default btn-circle btn-refresh" id="open" title='Refresh'>
                                Refresh
                                <i class="fa fa-refresh"></i> 
                            </button>
                        </div>
                    </div>
                </div>
                <div class="my-divider"></div> -->
                <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                    <a class="btn btn-default btn-circle pull-right btn-create" id="open" data-toggle="modal" data-backdrop="static" href="#new-ticket" title='Create Ticket'>
                        Create Ticket
                        <i class="fa fa-plus"></i> 
                    </a>
                    <table class="table table-striped table-bordered table-condensed nowrap" id="openTable" width="100%" height="100%">
                        <thead>
                            <tr>
                                <th style="width: 2%;">No</th>
                                <th style="width: 10%;">
                                    Date
                                    <input type="text" class="filter form-control datepicker" id="submitDate" style="width:10%;" placeholder="Filter Date" />
                                </th>
                                <th style="width: 4%;">
                                    Ticket ID
                                    <input type="text" id="ticketId" class="filter form-control" style="width: 4%;" placeholder="Filter Ticket ID" autocomplete="off" />
                                </th>
                                @if($roleTicketing == 'admin')
                                    <th style="width: 12%;">
                                        Employee
                                        <select multiple="multiple" id="employee" class="filter form-control" style="width: 12%;">
                                            @foreach($openEmployeeList as $users)
                                                <option value="{{ $users['userId'] }}">{{ $users['userName'] }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                @endif
                                <th style="width: 14%">
                                    Subject
                                    <input type="text" id="subject" class="filter form-control" style="width: 14%" placeholder="Filter Subject" autocomplete="off" />
                                </th>
                                <th style="width: 8%;">
                                    Application
                                    <select multiple="multiple" id="application" class="filter form-control" style="width: 8%;">
                                        @foreach($openAppList as $app)
                                            <option value="{{ $app['app_id'] }}">{{ $app['app_name'] }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th style="width: 10%">
                                    Priority
                                    <select multiple="multiple" id="priority" class="filter form-control" style="width: 10%">
                                        @foreach($openPriority as $priority)
                                            <option value="{{ $priority['priority_id'] }}">{{ $priority['priority_name'] }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                @if($roleTicketing == 'admin')
                                    <th style="width: 12%">
                                        Assigned By
                                        <select multiple="multiple" id="assignBy" class="filter form-control" style="width: 12%">
                                            @foreach($openAssByList as $users)
                                                <option value="{{ $users['userId'] }}">{{ $users['userName'] }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                @endif
                                <th style="width: 12%">
                                    Assigned To
                                    @if($roleTicketing == 'admin')
                                        <select multiple="multiple" id="assignTo" class="filter form-control" style="width: 12%">
                                            @foreach($openAssToList as $users)
                                                <option value="{{ $users['userId'] }}">{{ $users['userName'] }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </th>
                                <th style="width: 10%">
                                    Status
                                    <select multiple="multiple" id="status" class="filter form-control" style="width: 10%">
                                        @foreach($openStatus as $status)
                                            <option value="{{ $status['status_id'] }}">{{ $status['status_name'] }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th style="width:4%;">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="closeTab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dt-buttons">
                            <button class="btn btn-default btn-circle btn-refresh" id="close" title='Refresh'>
                                Refresh
                                <i class="fa fa-refresh"></i> 
                            </button>
                        </div>
                    </div>
                </div>
                <div class="my-divider"></div>
                <a class="btn btn-default btn-circle pull-right btn-create" id="open" data-toggle="modal" data-backdrop="static" href="#new-ticket" title='Create Ticket'>
                    Create Ticket
                    <i class="fa fa-plus"></i> 
                </a>
                <table class="table table-bordered table-condensed" id="closeTable" width="100%">
                    <thead>
                        <tr>
                            <th style="min-width: 2%;">No</th>
                            <th style="min-width: 10%;">
                                Date
                                <input type="text" class="filter form-control datepicker" id="submitDate" style="min-width: 10%;" placeholder="Filter Date" />
                            </th>
                            <th style="min-width: 7%;">
                                Ticket ID
                                <input type="text" id="ticketId" class="filter form-control" style="min-width: 7%;" placeholder="Filter Ticket ID" autocomplete="off" />
                            </th>
                            @if($roleTicketing == 'admin')
                                <th style="min-width: 10%;">
                                    Employee
                                    <select multiple="multiple" id="employee" style="min-width: 10%;" class="filter form-control">
                                        @foreach($closeEmployeeList as $users)
                                            <option value="{{ $users['userId'] }}">{{ $users['userName'] }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            @endif
                            <th style="min-width: 10%;">
                                Subject
                                <input type="text" id="subject" class="filter form-control" style="min-width: 10%;" placeholder="Filter Subject" autocomplete="off" />
                            </th>
                            <th style="min-width: 9%;">
                                Application
                                <select multiple="multiple" id="application" style="min-width: 9%;" class="filter form-control">
                                    @foreach($closeAppList as $app)
                                        <option value="{{ $app['app_id'] }}">{{ $app['app_name'] }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th style="min-width: 7%;">
                                Priority
                                <select multiple="multiple" id="priority" style="min-width: 7%;" class="filter form-control" >
                                    @foreach($closePriority as $priority)
                                        <option value="{{ $priority['priority_id'] }}">{{ $priority['priority_name'] }}</option>
                                    @endforeach
                                </select>
                            </th>
                            @if($roleTicketing == 'admin')
                                <th style="min-width: 10%;">
                                    Assigned By
                                    <select multiple="multiple" id="assignBy" style="min-width: 10%;" class="filter form-control">
                                        @foreach($closeAssByList as $users)
                                            <option value="{{ $users['userId'] }}">{{ $users['userName'] }}</option>
                                        @endforeach
                                    </select>
                                </th>
                            @endif
                            <th style="min-width: 10%;">
                                Assigned To
                                @if($roleTicketing == 'admin')
                                    <select multiple="multiple" id="assignTo" style="min-width: 10%;" class="filter form-control" >
                                        @foreach($closeAssToList as $users)
                                            <option value="{{ $users['userId'] }}">{{ $users['userName'] }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </th>
                            <th style="min-width: 2%;">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Create New Ticket -->
        <div id="new-ticket" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ticketing Form</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="submit-ticket" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="application">
                                    Application
                                </label>
                                <select class="form-control" name="application" id="application">
                                    <option value="">-- Select Application --</option>
                                    @foreach($appList as $app)
                                        <option value="{{ $app['app_id'] }}">{{ $app['app_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="priority">
                                    Priority
                                </label>
                                <select class="form-control" name="priority" id="priority">
                                    <option value="">-- Select Priority --</option>
                                    <option value="1">Low</option>
                                    <option value="2" selected="selected">Normal</option>
                                    <option value="3">High</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subject">
                                    Subject
                                </label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Input the subject">
                            </div>
                            <div class="form-group">
                                <label for="issue">
                                    Issue
                                </label>
                                <textarea class="form-control" name="issue" id="issue" placeholder="Input the Issue"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="attachment">
                                    File Upload
                                </label>
                                <input type="file" class="form-control-file" name="attachment" id="attachment" accept=".jpg,.jpeg,.png">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btn-close" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            Close
                        </button>
                        <button type="button" class="btn btn-success btn-add-ticket">
                            <i class="fa fa-check"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Ticket -->
        <div id="detailTicket" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="portlet light bordered">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-5">
                                        <div class="user-left">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" style="font-weight: bold;font-size: 14px !important;">Detail Information</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Ticket ID:</td>
                                                        <td id="ticket_id"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ticket Status:</td>
                                                        <td id="status"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Created on:</td>
                                                        <td id="created_date"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Updated on:</td>
                                                        <td id="edit_date"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Update By:</td>
                                                        <td id="last_reply"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <div class="user-left">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($roleTicketing == 'admin')
                                                        <tr>
                                                            <td>Assign By:</td>
                                                            <td id="assignBy"></td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Assign To:</td>
                                                        <td id="assignTo"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Application:</td>
                                                        <td id="application"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Priority:</td>
                                                        <td id="priority"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Attachment:</td>
                                                        <td id="attachment">
                                                            <a class="btn btn-default btn-circle" id="btn-image" data-img-url="" title='View Attachment'>
                                                                View Attachment
                                                                <i class="fa fa-search"></i> 
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="image-preview">
                            <div class="header">
                                Attachment Preview 
                                <i class="fa fa-close pull-right" title="Close attachment preview"></i>
                            </div>
                            <div class="content">
                                <img src="#" width="800" height="500">
                            </div>
                        </div>
                        <div class="portlet light bordered">
                            <div class="portlet-body">
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-sm-12">
                                        <ul class="chats"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="portlet light bordered">
                            <div class="portlet-body">
                                <div class="row change-status">
                                    <div class="col-sm-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="ticketStatus">
                                                    Change status to <span class="symbol required"></span>
                                                </label>
                                                <select id="ticketStatus" name="ticketStatus" class="form-control">
                                                    <option value="">-- Choose Status --</option>
                                                    <option value="1">In Progress</option>
                                                    <option value="2">Finish</option>
                                                </select>
                                                <input type="hidden" id="oldTicketStatus">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label assTo" for="developer">
                                                    Assign to <span class="symbol required"></span>
                                                </label>
                                                <select id="developer" name="developer" class="form-control assTo"></select>
                                                <input type="hidden" id="oldDeveloper">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="commentText">
                                                    <div class="center"> Add Comment</div> 
                                                </label>
                                                <textarea class="form-control" name="commentText" id="commentText" placeholder="Enter your comment"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="portlet light bordered">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="detail-title">Ticket History</span>
                                        <br/>
                                        <ul class="ticket-log"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btn-close" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            Close
                        </button>
                        <button type="button" class="btn btn-success btn-detailTicket">
                            <i class="fa fa-check"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Mark as Resolve -->
        <div id="resolve" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirm Close Ticket</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to close this ticket?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            Close
                        </button>
                        <button type="button" class="btn btn-success btn-resolve btn-actions" data-actions="resolve">
                            <i class="fa fa-check"></i>
                            Mark as Resolve
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- config.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<!-- config.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/axios.js') }}"></script>

<!-- multiple-select.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/multiple-select.js') }}"></script>
<!-- ckeditor.js -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'ckeditor/ckeditor.js') }}"></script>
<!-- adapters.js -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
    let role        = '{{$roleTicketing}}'

    toastr.options = {
        "closeButton": true,
    };
</script>
<!-- ticketing.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/ticketing.js?v='.date('YmdHis')) }}"></script>
@endsection