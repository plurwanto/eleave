@extends('Eleave.layout.main')

@section('title','Eleave | Room Booking')

@section('style')
<!-- multiple-select.css -->
<link type="text/css" rel="stylesheet" href="{{ URL::asset(env('PUBLIC_PATH').'css/multiple-select.css') }}">
</link>

<style type="text/css">
.my-divider {
    margin-bottom: 20px;
}

.modal-header,
h4,
.close {
    background-color: #32c5d2;
    color: white !important;
    text-align: center;
    font-size: 25px;
}

.modal-footer {
    background-color: #efeeee;
}

.after-date {
    display: none;
}

#new-book ul li.selected {
    background-color: #ddd;
}

#new-book ul li:hover {
    background-color: #ddd;
}

#new-book input[type="radio"] {
    visibility: hidden;
}
</style>
@endsection

@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-building"></i>Room Booking
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#allRoomBoooking" aria-controls="allRoomBoooking" role="tab"
                    data-toggle="tab">All Room Booking</a></li>
            <li role="presentation"><a href="#myRoomBooking" aria-controls="myRoomBooking" role="tab"
                    data-toggle="tab">My Room Booking</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="allRoomBoooking">
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="dt-buttons">
                            <button class="btn btn-default btn-circle btn-refresh" id="all" title='Refresh'>
                                Refresh
                                <i class="fa fa-refresh"></i> 
                            </button>
                        </div>
                    </div>
                </div>
                <div class="my-divider"></div> -->
                <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                    <table class="table table-striped table-bordered table-condensed nowrap" width="100%"
                        id="allRoomTable">
                        <thead>
                            <tr>
                                <th style="width: 40px">No</th>
                                <th style="width: 70px">
                                    Status<br />
                                    <select multiple="multiple" id="allMultiStatus" class="filter form-control"
                                        style="width: 120px">
                                        <option value="Y">Booked</option>
                                        <option value="N">Cancel</option>
                                    </select>
                                </th>
                                <th style="width: 125px">
                                    Room<br />
                                    <select multiple="multiple" id="allMultiRoom" class="filter form-control"
                                        style="width: 125px">
                                        @foreach ($room as $value)
                                        <option value="{{ $value['room_id']}}">{{ $value['room_name'] }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th style="width: 125px">
                                    Reservation Date<br />
                                    <input type="text" class="filter form-control datepicker" id="all_room_date"
                                        style="width:100px;" placeholder="Filter Reservation Date" />
                                </th>
                                <th style="width: 70px">Start Time</th>
                                <th style="width: 65px">End Time</th>
                                <th>
                                    Request By<br />
                                    <select multiple="multiple" id="allMultiReqBy" class="filter form-control"
                                        style="width: 125px">
                                        @foreach ($reqBy as $reqByVal)
                                        <option value="{{ $reqByVal['userId']}}">{{ $reqByVal['userName'] }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th>
                                    Request For<br />
                                    <select multiple="multiple" id="allMultiReqFor" class="filter form-control"
                                        style="width: 125px">
                                        @foreach ($reqFor as $reqForVal)
                                        <option value="{{ $reqForVal['userId']}}">{{ $reqForVal['userName'] }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th style="width: 130px">
                                    Description<br />
                                    <input type="text" id="allDesc" class="filter form-control" style="width:130px;"
                                        placeholder="Filter Description" />
                                </th>
                                <th style="width: 150px">
                                    Created Date
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="myRoomBooking">
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="dt-buttons pull-right">
                            <a class="btn btn-default btn-circle btn-book-form" data-toggle='modal'
                                data-backdrop="static" href="#new-book" title='Book a Room'>
                                Book
                                <i class="fa fa-plus"></i>
                            </a>
                            <button class="btn btn-default btn-circle btn-refresh" id="my" title='Refresh'>
                                Refresh
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="my-divider"></div> -->
                    <a class="btn btn-default btn-circle pull-right btn-book-form" data-toggle='modal' data-backdrop="static"
                    href="#new-book" title='Book a Room'>
                    Book
                    <i class="fa fa-plus"></i>
                </a>
                <table class="table table-bordered table-condensed" width="100%" id="myRoomTable">
                    <thead>
                        <tr>
                            <th style="width: 40px">No</th>
                            <th style="width: 70px">
                                Status<br />
                                <select multiple="multiple" id="myMultiStatus" class="filter form-control"
                                    style="width: 116px">
                                    <option value="Y">Booked</option>
                                    <option value="N">Cancel</option>
                                </select>
                            </th>
                            <th style="width: 115px">
                                Room<br />
                                <select multiple="multiple" id="myMultiRoom" class="filter form-control"
                                    style="width: 115px">
                                    @foreach ($room as $value)
                                    <option value="{{ $value['room_id']}}">{{ $value['room_name'] }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th style="width: 115px">
                                Reservation Date<br />
                                <input type="text" class="filter form-control datepicker" id="my_room_date"
                                    style="width:100px;" placeholder="Filter Reservation Date" />
                            </th>
                            <th style="width: 100px">Start Time</th>
                            <th style="width: 80px">End Time</th>
                            <th>
                                Request By<br />
                                <select multiple="multiple" id="myMultiReqBy" class="filter form-control"
                                    style="width: 125px">
                                    @foreach ($reqFor as $reqForVal)
                                    <option value="{{ $reqForVal['userId']}}">{{ $reqForVal['userName'] }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                Request For<br />
                                <select multiple="multiple" id="myMultiReqFor" class="filter form-control"
                                    style="width: 125px">
                                    @foreach ($reqFor as $reqForVal)
                                    <option value="{{ $reqForVal['userId']}}">{{ $reqForVal['userName'] }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th style="width: 150px">
                                Description<br />
                                <input type="text" id="myDesc" class="filter form-control" style="width:90px;"
                                    placeholder="Filter Description" />
                            </th>
                            <th style="width: 150px">
                                Created Date
                            </th>
                            <th style="width: 45px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Check In -->
        <div id="check_in" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirm Check In</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to check in?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            Close
                        </button>
                        <button type="button" class="btn btn-success btn-check_in btn-actions" data-actions="check_in">
                            <i class="fa fa-sign-in"></i>
                            Check In
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Check Out -->
        <div id="check_out" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirm Check Out</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to check out?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            Close
                        </button>
                        <button type="button" class="btn btn-success btn-check_out btn-actions"
                            data-actions="check_out">
                            <i class="fa fa-sign-out"></i>
                            Check Out
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Cancel -->
        <div id="cancel" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirm Cancel</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to cancel room booking?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            Close
                        </button>
                        <button type="button" class="btn btn-success btn-cancel btn-actions" data-actions="cancel">
                            <i class="fa fa-check"></i>
                            Cancel Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Book New Room -->
        <div id="new-book" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Room Booking Form</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="book-room">
                            <div class="form-group">
                                <label for="revDate">
                                    Reservation Date
                                </label>
                                <input type="text" class="form-control" name="revDate" id="revDate"
                                    placeholder="Choose date">
                            </div>
                            <div class="form-group">
                                <label for="startTime">
                                    Start Time
                                </label>
                                <input type="text" class="form-control timepicker timepicker-24" name="startTime"
                                    id="startTime" placeholder="Choose Start Time">
                            </div>
                            <div class="form-group">
                                <label for="endTime">
                                    End Time
                                </label>
                                <input type="text" class="form-control timepicker timepicker-24" name="endTime"
                                    id="endTime" placeholder="Choose Start End Time">
                            </div>
                            <div class="form-group">
                                <label for="reqFor">
                                    Request For
                                </label>
                                <select class="form-control" name="reqFor" id="multiReqFor">
                                    @foreach ($allUser as $allUserVal)
                                    <option value="{{ $allUserVal['user_id']}}">{{ $allUserVal['user_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group after-date">
                                <label for="room">
                                    Room
                                </label>
                                <select class="form-control" name="room" id="room"></select>
                            </div>
                            <div class="form-group after-date">
                                <label for="description">
                                    Description
                                </label>
                                <textarea class="form-control" name="description" id="description"
                                    placeholder="Enter Description"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-close"></i>
                            Close
                        </button>
                        <button type="button" class="btn btn-success btn-add-room">
                            <i class="fa fa-check"></i>
                            Book
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
<!-- multiple-select.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/multiple-select.js') }}"></script>
<!-- room-booking.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/room-booking.js') }}"></script>

<script>
toastr.options = {
    "closeButton": true,
};

@if(Session::has('message'))
var type = "{{ Session::get('alert-type', 'info') }}"

switch (type) {
    case 'info':
        toastr.info("{{ Session::get('message') }}")
        break;
    case 'warning':
        toastr.warning("{{ Session::get('message') }}")
        break;
    case 'success':
        toastr.success("{{ Session::get('message') }}")
        break;
    case 'error':
        toastr.error("{{ Session::get('message') }}")
        break;
}
@endif
</script>
@endsection