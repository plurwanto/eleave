$(document).ready(function () {
    $.ajax({
        url: `${apiUrl}eleave/dashboard/pending-approval-chart`,
        type: "POST",
        data: {
            token: token,
            user_id: id_eleave,
            branch_id: branch_id,
            is_home: 1
        },
        dataType: 'json',
        success: function (response) {
            // //S:Pending Approval Chart
            let pendingRequest = am4core.create("pendingRequestChart", am4charts.PieChart)
            pendingRequest.hiddenState.properties.opacity = 0 // this creates initial fade-in
            pendingRequest.title = 'Employee Punctuality'

            pendingRequest.data = response.data

            empty = 0;

            for (var i = 0; i < response.data.length; i++) {
                
                if (response.data[i].value > 0) {
                    empty++;
                }
            }

            if (empty > 0) {
                // all data value is 0
                $(".pendingRequestChartNotEmpty").removeClass('hide')
                $(".pendingRequestChartEmpty").addClass('hide')
            } else {
                $(".pendingRequestChartNotEmpty").addClass('hide')
                $(".pendingRequestChartEmpty").removeClass('hide')
            }
            
            pendingRequest.radius = am4core.percent(70)
            pendingRequest.innerRadius = am4core.percent(40)
            pendingRequest.startAngle = 180
            pendingRequest.endAngle = 360

            let pendingRequestSeries = pendingRequest.series.push(new am4charts.PieSeries())
            pendingRequestSeries.dataFields.value = "value"
            pendingRequestSeries.dataFields.category = "label"

            pendingRequestSeries.slices.template.cornerRadius = 10
            pendingRequestSeries.slices.template.innerCornerRadius = 7
            pendingRequestSeries.slices.template.draggable = false
            pendingRequestSeries.slices.template.inert = true
            pendingRequestSeries.alignLabels = false
            pendingRequestSeries.labels.template.disabled = true;
            pendingRequestSeries.ticks.template.disabled = true;

            var chartColor = []
            var chartLegend = ''

            $.each(response.data, function (i, val) {
                chartColor.push(am4core.color(val.color))

                chartLegend += `<li class="legendList">
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

            $(".pendingRequestLegend").html(chartLegend)

            pendingRequestSeries.colors.list = chartColor

            pendingRequestSeries.hiddenState.properties.startAngle = 90
            pendingRequestSeries.hiddenState.properties.endAngle = 90
            //E:Pending Approval Chart
        },
        error: function (data) {
            toastr.error(data.message)
        }
    })
})
