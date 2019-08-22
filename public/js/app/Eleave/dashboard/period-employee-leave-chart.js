$(document).ready(function () {
    // showEmployeeLeaveChart()
})

function showEmployeeLeaveChart(month) {
    closeTable('employeeLeave')

    var months = (typeof month == 'undefined') ? $('#period').val() : month

    $.ajax({
        url: `${apiUrl}eleave/dashboard/employee-leave-chart`,
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
                $("#employeeLeaveChart").addClass('hide')
                $("#employeeLeaveChartEmpty").removeClass('hide')
            } else {
                $("#employeeLeaveChart").removeClass('hide')
                $("#employeeLeaveChartEmpty").addClass('hide')
            }

            let employeeLeave = am4core.create("employeeLeaveChart", am4charts.PieChart)

            // Add data
            employeeLeave.data = response.data

            // Set inner radius
            employeeLeave.innerRadius = am4core.percent(50)

            // Add and configure Series
            let employeeLeaveSeries = employeeLeave.series.push(new am4charts.PieSeries())
            employeeLeaveSeries.dataFields.value = "value"
            employeeLeaveSeries.dataFields.category = "label"
            employeeLeaveSeries.labels.template.disabled = true;
            employeeLeaveSeries.ticks.template.disabled = true;

            // This creates initial animation
            employeeLeaveSeries.hiddenState.properties.opacity = 1
            employeeLeaveSeries.hiddenState.properties.endAngle = -90
            employeeLeaveSeries.hiddenState.properties.startAngle = -90

            var chartColor = []
            var chartLegend = ''

            $.each(response.data, function (i, val) {
                chartColor.push(am4core.color(val.color))

                // var legendClass = (val.legendId == 'annual' || val.legendId == 'medical') ? 'legendList employeeLeaveLegendList' : 'employeeLeaveLegendList'

                chartLegend += `<li class="legendList employeeLeaveLegendList" id="${val.legendId}" >
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

            $(".employeeLeaveLegend").html(chartLegend)

            employeeLeaveSeries.colors.list = chartColor

        },
        error: function (data) {
            toastr.error(data.message)
        }
    })
}