@extends('Eleave.layout.main')

@section('title','Eleave | Home')

@section('style')
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<link rel="stylesheet"
    href="https://www.jqueryscript.net/demo/Fully-Responsive-Flexible-jQuery-Carousel-Plugin-slick/css/slick.css"
    type="text/css" media="all" />
<style>
.portlet,
.portlet-body {
    height: 100%;
}

.hide {
    display: none;
}

.pr-0 {
    padding-right: 0;
}

.pl-0 {
    padding-left: 0;
}

.mb-10 {
    margin-bottom: 10px;
}

.p-0 {
    padding: 0 !important;
}

.chart-title {
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 0;
    padding: 0;
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


.legendList {
    min-height: 30px;
    padding: 5px;
    float: left;
}

.legendListInner {
    display: flex;
    align-items: center;
}

.legendListColorBox {
    width: 22px;
    height: 14px;
}

.legendListColor {
    float: left;
    margin-right: 8px;
    width: 15px;
    height: 15px;
    border-radius: 50px !important;
}

.legendLabelBorder {
    border-bottom: 1px solid black;
}

.pendingApprovalLeave_wrapper .row:first-child [class*="col-"] {
    margin-bottom: 0px;
}

.chart-section {
    height: 329px;
    max-height: 329px;
    margin-bottom: 0;
    padding: 0;
    float: unset;
}

.dashboard-pie-chart {
    height: 255px;
    max-height: 255px;
    width: 100%;
    float: left;
}

.dashboard-chart-legend {
    display: table;
    margin: 0 auto;
}

.pendingRequestLegend,
.attendancePunctualityLegend {
    list-style-type: none;
    margin: 0 auto;
    float: left;
    padding: 10px 5px;
    width: 100%;
}

.calendarBox {
    height: 473px;
    max-height: 473px;
}

.informationLeaveBox {
    height: 457px;
    max-height: 457px;
    padding: 0 !important;
}

.informationLeaveBox .table {
    height: 100%;
}

.informationLeaveTable {
    height: 395px;
    margin-bottom: 0 !important;
}

.birthdayBox {
    height: 245px;
}

.newEmployeeBox {
    height: 241px;
}

.name {
    font-size: 17px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    width: 110px;
    display: inline-block;
}

.date {
    color: #8D8D8D;
    font-weight: bold;
    font-size: 14px
}

.fc-toolbar {
    margin-bottom: 0 !important;
    height: 11px;
}

.durationContributionBox {
    background-color: #3598DC !important;
    color: #fff;
}

.duration {
    text-transform: uppercase;
    font-weight: 600;
}

.duration-number {
    font-size: 36px;
    padding-left: 15px;
}

.duration-number:first-child {
    padding-left: 0;
}

.download-policy {
    border-radius: 5px !important;
    width: 96% !important;
    cursor: pointer;
}

.download-button {
    background-color: #659BE0;
    color: #fff !important;
    text-transform: uppercase;
    border-radius: 5px !important;
}

.download-button:hover {
    background-color: #3598dc;
}

/* slider */

.slider {
    opacity: 0;
    visibility: hidden;
    transition: opacity 1s ease;
    -webkit-transition: opacity 1s ease;
}

.slider.slick-initialized {
    visibility: visible;
    opacity: 1;
}

.slick-slider {
    margin-bottom: 0;
}

.slick-slider .slide img {
    margin: 0 auto;
    /* width: 90%; */
    width: 125px;
    border-radius: 50% !important;
    margin-bottom: 5px;
    padding: 5px;
    height: 130px;
    object-fit: cover;
}

.slick-slider .slide {
    text-align: center;
}

.slick-slider .slick-prev {
    top: 0;
    right: 50px;
    margin-top: -45px;
    left: unset;
    background: unset;
    font-family: FontAwesome;
}

.slick-slider .slick-next {
    top: 0;
    right: 0;
    margin-top: -45px;
    background: unset;
    font-family: FontAwesome;
}

.slick-prev:after {
    content: "\f053";
    color: black;
    font-size: 20px;
    float: left;
    text-indent: 0;
    margin: 5px;
    -webkit-text-stroke: 2px white;
}

.slick-next:after {
    content: "\f054";
    color: black;
    font-size: 20px;
    float: left;
    text-indent: 0;
    margin: 5px;
    -webkit-text-stroke: 2px white;
}
</style>
@endsection

@section('content')
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
    <div class="portlet box">
        <div class="portlet-body">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 chart-section">
                <div class="chart-title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Attendance Punctuality Chart
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                    <div class="text-center attendancePunctualityChartEmpty hide" style="margin: 15px;">
                        <img src="{{ URL::asset(env('IMAGES_PATH').'noData.png') }}" style="width: 150px;">
                        <div style="font-weight: 600; color: #8D8D8D; font-size: 18px; margin: 30px 0;">You have no attendance record</div>
                    </div>
                    <div class="attendancePunctualityChartNotEmpty">
                        <div id="attendancePunctualityChart" class="dashboard-pie-chart"></div>
                        <div class="dashboard-chart-legend">
                            <ul class="attendancePunctualityLegend"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portlet box">
        <div class="portlet-body">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 chart-section">
                <div class="chart-title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Pending Request
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                    <div class="text-center pendingRequestChartEmpty hide" style="margin: 15px;">
                        <img src="{{ URL::asset(env('IMAGES_PATH').'noData.png') }}" style="width: 150px;">
                        <div style="font-weight: 600; color: #8D8D8D; font-size: 18px; margin: 30px 0;">You have no pending requests</div>
                    </div>
                    <div class="pendingRequestChartNotEmpty">
                        <div id="pendingRequestChart" class="dashboard-pie-chart"></div>
                        <div class="dashboard-chart-legend">
                            <ul class="pendingRequestLegend"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 ">
    <div class="portlet box">
        <div class="portlet-body calendarBox">
            <div class="chart-title" style="margin-bottom: 0;">
                Holiday &amp; Birthday on {{ date('F') }}
            </div>
            <div id="calendar"></div>
        </div>
    </div>
    <div class="portlet box">
        <div class="portlet-body birthdayBox">
            <div class="chart-title" style="margin-bottom: 15px;">
                Upcoming Birthday on {{ date('F') }}
            </div>
            <div class="slider upcomingBirthday"></div>
            <div class="text-center upcomingBirthdayEmpty hide" style="margin: 15px;">
                <img src="{{ URL::asset(env('IMAGES_PATH').'newEmployee.png') }}" style="width: 150px;">
                <div style="font-weight: 600; color: #8D8D8D; font-size: 18px; margin: 30px 0;">There is no upcoming employee birthday</div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 ">
    <div class="portlet box">
        <div class="portlet-body informationLeaveBox">
            <div class="chart-title" style="margin-bottom: 0; padding: 15px;">
                Information Leave
            </div>
            <div class="table-scrollable table-scrollable-borderless informationLeaveTable">
                <table class="table table-striped table-scrollable table-scrollable-borderless table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px"></th>
                            <th
                                style="font-weight: 800; text-align: center; color: #8D8D8D; font-size: 14px !important; text-transform: uppercase;">
                            </th>
                            <th
                                style="font-weight: 800; text-align: center; color: #8D8D8D; font-size: 14px !important; text-transform: uppercase;">
                                Entitle </th>
                            <th
                                style="font-weight: 800; text-align: center; color: #8D8D8D; font-size: 14px !important; text-transform: uppercase;">
                                Taken </th>
                            <th
                                style="font-weight: 800; text-align: center; color: #8D8D8D; font-size: 14px !important; text-transform: uppercase;">
                                Balance </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
    <div class="portlet box">
        <div class="portlet-body durationContributionBox">
            <div class="chart-title" style="margin-bottom: 0;">
                Duration of Contribution
            </div>
            <div class="duration">
                <span class="duration-number">{{ $contribDay->y }}</span> Year
                <span class="duration-number">{{ $contribDay->m }}</span> Month
                <span class="duration-number">{{ $contribDay->d }}</span> Day
            </div>
        </div>
    </div>
    <div class="portlet box">
        <div class="portlet-body newEmployeeBox">
            <div class="chart-title" style="margin-bottom: 15px;">
                New Employee on {{ date('F') }}
            </div>
            <div class="slider newEmployee"></div>
            <div class="newEmployeeEmpty text-center hide" style="margin: 15px;">
                <img src="{{ URL::asset(env('IMAGES_PATH').'newEmployee.png') }}" style="width: 150px;">
                <div style="font-weight: 600; color: #8D8D8D; font-size: 18px; margin: 30px 0;">There is no new employee this month</div>
            </div>
        </div>
    </div>
    <div class="portlet box">
        <div class="portlet-body">
            <div class="input-group">
                <select class="form-control download-policy">
                    <?php echo (!empty($policy['pol_attendance']) ? '<option value="attendance">Attendance Policy</option>' : '');?>
                    <?php echo (!empty($policy['pol_leave']) ? '<option value="leave">Leave Policy</option>' : ''); ?>
                    <?php echo (!empty($policy['pol_workplace']) ? '<option value="workplace">Workplace Policy</option>' : ''); ?>
                </select>
                <span class="input-group-btn">
                    <button class="btn download-button" type="button" <?php echo (empty($policy['pol_leave'] && $policy['pol_workplace'] && $policy['pol_attendance']) ? 'disabled' : ''); ?>>Download</button>
                </span>
            </div>
            <!-- <div class="chart-title" style="margin-bottom: 0;">
                <select class="form-control download-policy">
                    <option value="attendance">Attendance Policy</option>
                    <option value="leave">Leave Policy</option>
                    <option value="workplace">Workplace Policy</option>
                </select>
                <button type="button" class="btn download-button">Download</button>
            </div> -->
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- config.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/core.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/charts.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/animated.js') }}"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'slick/slick.js') }}">
</script>

<!-- Chart code -->
<script>
let csrf_token = "{{ csrf_token() }}"

toastr.options = {
    "closeButton": true,
}
</script>

<!-- period-employee-punctuality-chart.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/attendance-punctuality-chart.js?v='.date('YmdHis')) }}">
</script>
<!-- pending-approval-chart.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/pending-request-chart.js?v='.date('YmdHis')) }}">
</script>

<!-- calendar -->
<link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'fullcalendar/fullcalendar.min.css') }}" rel="stylesheet"
    type="text/css" />

<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'fullcalendar/fullcalendar.min.js') }}" type="text/javascript">
</script>

<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        height: 410,
        contentHeight: 410,
        header: {
            left: '',
            center: '',
            right: ''
        },
        events: {
            url: `${apiUrl}eleave/dashboard/calendar`,
            type: 'POST',
            data: {
                token: token,
                branch_id: branch_id
            },
            error: function() {
                alert('there was an error while fetching data!');
            },
            color: 'yellow', // a non-ajax option
            textColor: 'black' // a non-ajax option
        },
        eventRender: function(event, element) {
            var customTitle = (event.customTooltip == '') ? event.title : event.customTooltip

            $(element).tooltip({
                title: customTitle
            })
        }
    })

    // Get upcoming birthday
    $.ajax({
        url: `${apiUrl}eleave/dashboard/upcoming-birthday`,
        type: "POST",
        data: {
            token: token,
            branch_id: branch_id
        },
        dataType: 'json',
        success: function(response) {
            var dataLength = response.data.length

            if (dataLength > 0) {

                var birthContent = ''

                $.each(response.data, function(i, val) {
                    birthContent += `<div class="multiple" title="${val.user_name}">
                                    <img src="${publicPath}${val.photo}">
                                    <span class="name">${val.user_name}</span>
                                    <br>
                                    <span class="date">${val.birthdate}</span>
                                </div>`
                });

                $(".upcomingBirthday").html(birthContent)

                if (dataLength <= 4) {
                    // slick slider
                    // if dataLength <= 4
                    $('.upcomingBirthday').slick({
                        slidesToShow: dataLength, // based on total
                        arrows: false,
                        autoplay: false,
                        swipe: false,
                        swipeToSlide: false,
                        touchMove: false,
                        draggable: false,
                        accessibility: false
                    })
                } else {
                    // if dataLength > 4
                    $('.upcomingBirthday').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2000,
                    })
                }

                $(".upcomingBirthday").removeClass('hide')
                $(".upcomingBirthdayEmpty").addClass('hide')
            } else {
                $(".upcomingBirthday").addClass('hide')
                $(".upcomingBirthdayEmpty").removeClass('hide')
            }
        },
        error: function(data) {
            toastr.error('Something wrong with the application, <br/>Please Contact administrator')
        }
    })

    // Get new employee
    $.ajax({
        url: `${apiUrl}eleave/dashboard/new-employee`,
        type: "POST",
        data: {
            token: token,
            branch_id: branch_id
        },
        dataType: 'json',
        success: function(response) {
            var dataLength = response.data.length

            if (dataLength > 0) {
                var newEmpContent = ''

                $.each(response.data, function(i, val) {
                    newEmpContent += `<div class="multiple" title="${val.user_name}">
                                        <img src="${val.photo}">
                                        <span class="name">${val.user_name}</span>
                                        <br>
                                        <span class="date">${val.join_date}</span>
                                    </div>`
                });

                $(".newEmployee").html(newEmpContent)

                if (dataLength <= 3) {
                    // slick slider
                    // if dataLength <= 3
                    $('.newEmployee').slick({
                        slidesToShow: dataLength, // based on total
                        arrows: false,
                        autoplay: false,
                        swipe: false,
                        swipeToSlide: false,
                        touchMove: false,
                        draggable: false,
                        accessibility: false
                    })
                } else {
                    // if dataLength > 3
                    $('.newEmployee').slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2000,
                    })
                }

                $(".newEmployee").removeClass('hide')
                $(".newEmployeeEmpty").addClass('hide')
            } else {
                $(".newEmployee").addClass('hide')
                $(".newEmployeeEmpty").removeClass('hide')
            }
        },
        error: function(data) {
            toastr.error('Something wrong with the application, <br/>Please Contact administrator')
        }
    })

    // Get new employee
    $.ajax({
        url: `${apiUrl}eleave/dashboard/leave-information`,
        type: "POST",
        data: {
            token: token,
            branch_id: branch_id
        },
        dataType: 'json',
        success: function(response) {
            var informationLeave = ''

            $.each(response.data, function(i, val) {
                informationLeave += `<tr>
                                        <td style="width: 50px"></td>
                                        <td style="font-weight: 700; font-size: 14px !important; text-transform: uppercase; padding: 12px 10px 10px 10px !important">${val.title}</td>
                                        <td style="font-weight: 600; text-align: center; font-size: 14px !important; text-transform: uppercase; padding: 12px 10px 10px 10px !important">${val.max}</td>
                                        <td style="font-weight: 600; text-align: center; font-size: 14px !important; text-transform: uppercase; padding: 12px 10px 10px 10px !important">${val.taken}</td>
                                        <td style="font-weight: 600; text-align: center; font-size: 14px !important; text-transform: uppercase; padding: 12px 10px 10px 10px !important">${val.balance}</td>
                                    </tr>`
            });

            $(".informationLeaveBox table tbody").html(informationLeave)
        },
        error: function(data) {
            toastr.error('Something wrong with the application, <br/>Please Contact administrator')
        }
    })

    $(".download-button").click(function() {
        let policy = $(".download-policy").val()
       
        location.href = `${webUrl}eleave/policy/${policy}`
    });
})
</script>
@include('Eleave/notification')
@endsection