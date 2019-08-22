<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 chart-section">
    <div class="chart-title col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Employee Punctuality
        <div class="month-year">{{ date('M - Y') }}</div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 p-0">
            <div id="employeePunctualityChart" class="dashboard-pie-chart"></div>
            <div class="text-center hide" style="margin: 15px;" id="employeePunctualityChartEmpty">
                <img src="{{ URL::asset(env('IMAGES_PATH').'noData.png') }}" style="width: 125px;">
                <div style="font-weight: 600; color: #8D8D8D; font-size: 18px; margin: 30px 0;">You have no employee attendance record</div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 p-0 legendBox">
            <div class="legends">
                <ul class="employeePunctualityLegend"></ul>
            </div>
        </div>
    </div>
</div>