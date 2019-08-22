@extends('Eleave.layout.main')

@section('title','Eleave | Dashboard')

@section('style')
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
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

.closeTable {
    cursor: pointer;
}

.employeeLeaveLegendList,
.legendList {
    min-height: 30px;
    padding: 5px;
    clear: both
}

.legendListInner {
    display: flex;
    align-items: center;
}

li.legendList:hover {
    cursor: pointer;
    background-color: #ECECEC;
    border-right: 3px solid #659BE0;
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

.activeLegend {
    background-color: #ECECEC;
    border-right: 3px solid #659BE0;
}

.pendingApprovalLeave_wrapper .row:first-child [class*="col-"] {
    margin-bottom: 0px;
}

.table-section {
    margin-bottom: 0;
    border-left: 1px solid #e7ecf1;
    min-height: 350px;
}

.chart-section {
    min-height: 350px;
    margin-bottom: 0;
    padding: 0;
}

.legendBox {
    display: table;
}

.legends {
    min-height: 315px;
    height: 315px;
    display: table-cell;
    vertical-align: middle;
    width: 100%;
}

.legendBoxInner {
    min-height: 285px !important;
    height: 285px !important;
    display: table-cell;
    vertical-align: middle;
    width: 100%;
}

#pendingApprovalChart {
    min-height: 285px;
    float: left;
}

.dashboard-pie-chart {
    min-height: 315px;
    float: left;
}

.dashboard-bar-chart {
    min-height: 315px;
}

.divisionLegend{
    transform: translateY(-20px);
}

.pendingApprovalLegend,
.divisionLegend,
.employeePunctualityLegend,
.employeeLeaveLegend {
    list-style-type: none;
    padding-left: 0;
}

#pendingApprovalBox,
#divisionBox,
#employeePunctualityBox,
#employeeLeaveBox,
#employeeTimesheetBox,
#employeeOvertimeBox {
    margin-bottom: 0;
    padding-bottom: 3px;
}

.employeeTimesheetChartEmptyBox,
.employeeOvertimeChartEmptyBox{
    display: table;
    width: 100%;
}
#employeeTimesheetChartEmpty,
#employeeOvertimeChartEmpty{
    height: 340px;
    display: table-cell;
    vertical-align: middle;
}

.pendingApprovalBoxInner{
    border: 1px solid #e7ecf1;
    padding: 12px 14px !important;
}

.divisionBoxInner,
.employeePunctualityBoxInner,
.employeeLeaveBoxInner,
.employeeTimesheetBoxInner,
.employeeOvertimeBoxInner {
    border: 1px solid #e7ecf1;
    padding: 12px 14px !important;
    height: 400px;
}

.divisionBoxInner .portlet-body,
.employeePunctualityBoxInner .portlet-zbody,
.employeeLeaveBoxInner .portlet-body,
.employeeTimesheetBoxInner .portlet-body,
.employeeOvertimeBoxInner .portlet-body {
    min-height: 315px;
}

.month-year {
    font-size: 12px;
    font-weight: normal
}

.pending-chart-section {
    min-height: 225px;
    margin-bottom: 0;
    padding: 0;
}
</style>
@endsection

@section('content')

@if(session('is_approver') > 0)
<!-- S:Pending Approval -->
@include('Eleave.dashboard.pendingApproval')
<!-- E:Pending Approval -->
@endif

<!-- S:Period Grafik -->
@include('Eleave.dashboard.period')
<!-- E:Period Grafik -->
@endsection

@section('script')
<!-- config.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/core.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/charts.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/animated.js') }}"></script>

<!-- Chart code -->
<script>
let csrf_token = "{{ csrf_token() }}"
let hrId = "{{ session('is_hr') }}"

toastr.options = {
    "closeButton": true,
}
</script>
<!-- pending-approval-chart.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/pending-approval-chart.js?v='.date('YmdHis')) }}">
</script>
<!-- leave-approval.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/pending-approval.js?v='.date('YmdHis')) }}">
</script>

<!-- period.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period.js?v='.date('YmdHis')) }}"></script>

@if(session('is_hr') > 0)
    <!-- period-division.js -->
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-division.js?v='.date('YmdHis')) }}">
    </script>
    <!-- period-division-chart.js -->
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-division-chart.js?v='.date('YmdHis')) }}">
    </script>
@endif

<!-- period-employee-punctuality.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-employee-punctuality.js?v='.date('YmdHis')) }}">
</script>
<!-- period-employee-punctuality-chart.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-employee-punctuality-chart.js?v='.date('YmdHis')) }}">
</script>

<!-- period-employee-leave-chart.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-employee-leave-chart.js?v='.date('YmdHis')) }}">
</script>
<!-- period-employee-leave.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-employee-leave.js?v='.date('YmdHis')) }}">
</script>

<!-- period-employee-timesheet.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-employee-timesheet.js?v='.date('YmdHis')) }}">
</script>
<!-- period-employee-timesheet-chart.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-employee-timesheet-chart.js?v='.date('YmdHis')) }}">
</script>

<!-- period-employee-overtime.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-employee-overtime.js?v='.date('YmdHis')) }}">
</script>
<!-- period-employee-overtime-chart.js -->
<script
    src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/dashboard/period-employee-overtime-chart.js?v='.date('YmdHis')) }}">
</script>

@include('Eleave/notification')
@endsection