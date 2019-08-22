// Themes begin
am4core.useTheme(am4themes_animated)
// Themes end
$(document).ready(function () {
    showPendingApprovalChart()
})

function showPendingApprovalChart() {
    $.ajax({
        url: `${apiUrl}eleave/dashboard/pending-approval-chart`,
        type: "POST",
        data: {
            token: token,
            user_id: id_eleave,
            branch_id: branch_id
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
                $("#pendingApprovalChart").addClass('hide')
                $("#pendingApprovalChartEmpty").removeClass('hide')
            } else {
                $("#pendingApprovalChart").removeClass('hide')
                $("#pendingApprovalChartEmpty").addClass('hide')
            }

            //S:Pending Approval Chart
            let pendingApproval = am4core.create("pendingApprovalChart", am4charts.PieChart)
            pendingApproval.hiddenState.properties.opacity = 0 // this creates initial fade-in
            pendingApproval.title = 'Pending Approval'

            // pendingApproval.dataSource.url = `${apiUrl}eleave/dashboard/pending-approval-chart`
            pendingApproval.data = response.data
            pendingApproval.radius = am4core.percent(70)
            pendingApproval.innerRadius = am4core.percent(40)
            pendingApproval.startAngle = 180
            pendingApproval.endAngle = 360

            // pendingApproval.export.enabled = true

            let series = pendingApproval.series.push(new am4charts.PieSeries())
            series.dataFields.value = "value"
            series.dataFields.category = "label"

            series.slices.template.cornerRadius = 10
            series.slices.template.innerCornerRadius = 7
            series.slices.template.draggable = false
            series.slices.template.inert = true
            series.alignLabels = false
            series.labels.template.disabled = true;
            series.ticks.template.disabled = true;

            var chartColor = []
            var chartLegend = ''

            $.each(response.data, function (i, val) {
                chartColor.push(am4core.color(val.color))

                var activeLegend = (i == 0) ? 'activeLegend' : ''

                chartLegend += `<li class="legendList pendingApprovallegendList  ${activeLegend}" id="${val.label.toLowerCase()}">
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

            $(".pendingApprovalLegend").html(chartLegend)

            series.colors.list = chartColor;

            series.hiddenState.properties.startAngle = 90
            series.hiddenState.properties.endAngle = 90
            //E:Pending Approval Chart
        },
        error: function (data) {
            if (data.status == false) {
                $table.ajax.reload()
                toastr.error(data.message)
            }
        }
    })
}