$(document).ready(function () {
  // showEmployeeOvertimeChart()
})

function showEmployeeOvertimeChart(month) {
  closeTable('employeeOvertime')

  var months = (typeof month == 'undefined') ? $('#period').val() : month

  $.ajax({
    url: `${apiUrl}eleave/dashboard/employee-overtime-chart`,
    type: "POST",
    data: {
      token: token,
      user_id: id_eleave,
      branch_id: branch_id,
      month: months
    },
    dataType: 'json',
    success: function (response) {

      if (response.data.data.length <= 0) {
        // all data value is 0
        $("#employeeOvertimeChart").addClass('hide')
        $("#employeeOvertimeChartEmpty").removeClass('hide')
      } else {
        $("#employeeOvertimeChart").removeClass('hide')
        $("#employeeOvertimeChartEmpty").addClass('hide')
      }

      var employeeOvertime = am4core.create("employeeOvertimeChart", am4charts.XYChart)
      // Add data
      employeeOvertime.data = response.data.data

      // Create axes
      var overtimeCategoryAxis = employeeOvertime.xAxes.push(new am4charts.CategoryAxis())
      overtimeCategoryAxis.dataFields.category = "employee_name"
      overtimeCategoryAxis.renderer.grid.template.location = 0
      overtimeCategoryAxis.renderer.minGridDistance = 30;
      overtimeCategoryAxis.renderer.cellStartLocation = 0.1
      overtimeCategoryAxis.renderer.cellEndLocation = 0.9

      // Configure axis label
      var labelOvertime = overtimeCategoryAxis.renderer.labels.template;
      labelOvertime.wrap = true;
      labelOvertime.maxWidth = 110;

      var overtimeValueAxis = employeeOvertime.yAxes.push(new am4charts.ValueAxis())
      overtimeValueAxis.renderer.labels.template.disabled = true

      createSeries('waiting', 'Waiting for Approval', '#acb5c3', employeeOvertime)
      createSeries('approved', 'Approved', '#26c281', employeeOvertime)
    },
    error: function (data) {
      toastr.error(data.message)
    }
  })
}

function createSeries(field, name, color, parents) {
  var employeeOvertimeSeries = parents.series.push(new am4charts.ColumnSeries())
  employeeOvertimeSeries.dataFields.valueY = field
  employeeOvertimeSeries.dataFields.categoryX = "employee_name"
  employeeOvertimeSeries.name = name
  employeeOvertimeSeries.columns.template.tooltipText = "{name}: {valueY}"
  employeeOvertimeSeries.columns.template.fill = am4core.color(color)
}