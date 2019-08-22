$(document).ready(function () {
    // showEmployeePunctualityChart()
})

function showEmployeePunctualityChart(month) {
    closeTable('employeePunctuality')

    var months = (typeof month == 'undefined') ? $('#period').val() : month

    $.ajax({
        url: `${apiUrl}eleave/dashboard/employee-punctuality-chart`,
        type: "POST",
        data: {
            token: token,
            user_id: id_eleave,
            branch_id: branch_id,
            month: months
        },
        dataType: 'json',
        success: function (response) {
            empty = 0;

            for (var i = 0; i < response.data.length; i++) {    
                if (response.data[i].value > 0) {
                    empty++;
                }
            }

            if (empty <= 0) {
                // all data value is 0
                $("#employeePunctualityChart").addClass('hide')
                $("#employeePunctualityChartEmpty").removeClass('hide')
            } else {
                $("#employeePunctualityChart").removeClass('hide')
                $("#employeePunctualityChartEmpty").addClass('hide')
            }

            // //S:Pending Approval Chart
            let employeePunctuality = am4core.create("employeePunctualityChart", am4charts.PieChart)
            employeePunctuality.hiddenState.properties.opacity = 0 // this creates initial fade-in
            employeePunctuality.title = 'Employee Punctuality'

            // employeePunctuality.dataSource.url = `${apiUrl}eleave/dashboard/pending-approval-chart`
            employeePunctuality.data = response.data
            employeePunctuality.radius = am4core.percent(70)
            employeePunctuality.innerRadius = am4core.percent(40)
            employeePunctuality.startAngle = 180
            employeePunctuality.endAngle = 360

            // // employeePunctuality.export.enabled = true

            let employeePunctualitySeries = employeePunctuality.series.push(new am4charts.PieSeries())
            employeePunctualitySeries.dataFields.value = "value"
            employeePunctualitySeries.dataFields.category = "label"

            employeePunctualitySeries.slices.template.cornerRadius = 10
            employeePunctualitySeries.slices.template.innerCornerRadius = 7
            employeePunctualitySeries.slices.template.draggable = false
            employeePunctualitySeries.slices.template.inert = true
            employeePunctualitySeries.alignLabels = false
            employeePunctualitySeries.labels.template.disabled = true;
            employeePunctualitySeries.ticks.template.disabled = true;

            var chartColor = []
            var chartLegend = ''

            $.each(response.data, function (i, val) {
                chartColor.push(am4core.color(val.color))

                chartLegend += `<li class="legendList employeePunctualityLegendList" id="${val.legendId}">
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

            $(".employeePunctualityLegend").html(chartLegend)

            employeePunctualitySeries.colors.list = chartColor

            employeePunctualitySeries.hiddenState.properties.startAngle = 90
            employeePunctualitySeries.hiddenState.properties.endAngle = 90
            //E:Pending Approval Chart
        },
        error: function (data) {
            toastr.error(data.message)
        }
    })
}