$(document).ready(function () {
    // showDivisionChart()
})

function showDivisionChart(month) {
    closeTable('division')

    var months = (typeof month == 'undefined') ? $('#period').val() : month

    $.ajax({
        url: `${apiUrl}eleave/dashboard/division-chart`,
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
                $("#divisionChart").addClass('hide')
                $("#divisionChartEmpty").removeClass('hide')
            } else {
                $("#divisionChart").removeClass('hide')
                $("#divisionChartEmpty").addClass('hide')
            }
            
            // //S:Pending Approval Chart
            let division = am4core.create("divisionChart", am4charts.PieChart)
            division.hiddenState.properties.opacity = 0 // this creates initial fade-in
            division.title = 'Division Punctuality'

            // division.dataSource.url = `${apiUrl}eleave/dashboard/pending-approval-chart`
            division.data = response.data
            division.radius = am4core.percent(70)
            division.innerRadius = am4core.percent(40)
            division.startAngle = 180
            division.endAngle = 360

            // // division.export.enabled = true

            let divisionSeries = division.series.push(new am4charts.PieSeries())
            divisionSeries.dataFields.value = "value"
            divisionSeries.dataFields.category = "label"

            divisionSeries.slices.template.cornerRadius = 10
            divisionSeries.slices.template.innerCornerRadius = 7
            divisionSeries.slices.template.draggable = false
            divisionSeries.slices.template.inert = true
            divisionSeries.alignLabels = false
            divisionSeries.labels.template.disabled = true;
            divisionSeries.ticks.template.disabled = true;

            var chartColor = []
            var chartLegend = ''

            $.each(response.data, function (i, val) {
                chartColor.push(am4core.color(val.color))

                chartLegend += `<li class="legendList divisionLegendList" id="${val.legendId}">
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

            $(".divisionLegend").html(chartLegend)

            divisionSeries.colors.list = chartColor

            divisionSeries.hiddenState.properties.startAngle = 90
            divisionSeries.hiddenState.properties.endAngle = 90
            //E:Pending Approval Chart
        },
        error: function (data) {
            toastr.error(data.message)
        }
    })
}