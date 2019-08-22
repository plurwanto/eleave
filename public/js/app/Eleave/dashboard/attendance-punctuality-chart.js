// Themes begin
am4core.useTheme(am4themes_animated)
// Themes end
$(document).ready(function () {
    showAttendancePunctualityChart()
})

function showAttendancePunctualityChart() {
    $.ajax({
        url: `${apiUrl}eleave/dashboard/attendance-punctuality-chart`,
        type: "POST",
        data: {
            token: token,
            user_id: id_eleave,
            branch_id: branch_id
        },
        dataType: 'json',
        success: function (response) {
            // //S:Pending Approval Chart
            let attendancePunctuality = am4core.create("attendancePunctualityChart", am4charts.PieChart)
            attendancePunctuality.hiddenState.properties.opacity = 0 // this creates initial fade-in
            attendancePunctuality.title = 'Employee Punctuality'

            attendancePunctuality.data = response.data

            empty = 0;

            for (var i = 0; i < response.data.length; i++) {
                
                if (response.data[i].value > 0) {
                    empty++;
                }
            }

            if (empty > 0) {
                // all data value is 0
                $(".attendancePunctualityChartNotEmpty").removeClass('hide')
                $(".attendancePunctualityChartEmpty").addClass('hide')
            } else {
                $(".attendancePunctualityChartNotEmpty").addClass('hide')
                $(".attendancePunctualityChartEmpty").removeClass('hide')
            }

            attendancePunctuality.radius = am4core.percent(70)
            attendancePunctuality.innerRadius = am4core.percent(40)
            attendancePunctuality.startAngle = 180
            attendancePunctuality.endAngle = 360

            let attendancePunctualitySeries = attendancePunctuality.series.push(new am4charts.PieSeries())
            attendancePunctualitySeries.dataFields.value = "value"
            attendancePunctualitySeries.dataFields.category = "label"

            attendancePunctualitySeries.slices.template.cornerRadius = 10
            attendancePunctualitySeries.slices.template.innerCornerRadius = 7
            attendancePunctualitySeries.slices.template.draggable = false
            attendancePunctualitySeries.slices.template.inert = true
            attendancePunctualitySeries.alignLabels = false
            attendancePunctualitySeries.labels.template.disabled = true;
            attendancePunctualitySeries.ticks.template.disabled = true;

            var chartColor = []
            var chartLegend = ''

            $.each(response.data, function (i, val) {
                chartColor.push(am4core.color(val.color))

                chartLegend += `<li class="legendList" id="${val.legendId}">
                                    <div class="legendListInner">
                                        <div class="legendListColorBox">
                                            <div class="legendListColor" style="background-color: ${val.color};">
                                            </div>
                                        </div>
                                        <div>
                                            <span class="legendLabelBorder">
                                                <span class="legendLabel">${val.label}</span> : ${val.value}</span>
                                        </div>
                                    </div>
                                </li>`
            })

            $(".attendancePunctualityLegend").html(chartLegend)

            attendancePunctualitySeries.colors.list = chartColor

            attendancePunctualitySeries.hiddenState.properties.startAngle = 90
            attendancePunctualitySeries.hiddenState.properties.endAngle = 90
            //E:Pending Approval Chart
        },
        error: function (data) {
            toastr.error(data.message)
        }
    })
}
