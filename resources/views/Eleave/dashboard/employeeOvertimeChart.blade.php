<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 chart-section">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="chart-title pull-left">
            Top 5 - Employee Overtime
            <div class="month-year">{{ date('M - Y') }}</div>
        </div>
        <div class="pull-right">
            <button class="btn btn-primary text-right employeeOvertimeList">Info</button>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
        <div id="employeeOvertimeChart" class="dashboard-bar-chart"></div>
        <div class="employeeOvertimeChartEmptyBox">
            <div class="text-center hide" id="employeeOvertimeChartEmpty">
                <img src="{{ URL::asset(env('IMAGES_PATH').'noData.png') }}" style="width: 125px;">
                <div style="font-weight: 600; color: #8D8D8D; font-size: 18px; margin: 30px 0;">You Have No Employee Overtime Submission</div>
            </div>
        </div>
    </div>
</div>