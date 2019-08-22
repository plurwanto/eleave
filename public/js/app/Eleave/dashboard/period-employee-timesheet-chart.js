$(document).ready(function () {
  // showEmployeeTimesheetChart()
})

function showEmployeeTimesheetChart(month) {
  closeTable('employeeTimesheet')

  var months = (typeof month == 'undefined') ? $('#period').val() : month

  $.ajax({
    url: `${apiUrl}eleave/dashboard/employee-timesheet-chart`,
    type: "POST",
    data: {
      token: token,
      user_id: id_eleave,
      branch_id: branch_id,
      month: months
    },
    dataType: 'json',
    success: function (response) {
      var employeeTimesheet = am4core.create("employeeTimesheetChart", am4charts.XYChart)

      if (response.data.data.length <= 0) {
        // all data value is 0
        $("#employeeTimesheetChart").addClass('hide')
        $("#employeeTimesheetChartEmpty").removeClass('hide')
      } else {
        $("#employeeTimesheetChart").removeClass('hide')
        $("#employeeTimesheetChartEmpty").addClass('hide')
      }

      // Add data
      employeeTimesheet.data = response.data.data

      // Create axes
      var timesheetCategoryAxis = employeeTimesheet.xAxes.push(new am4charts.CategoryAxis())
      timesheetCategoryAxis.dataFields.category = "employee_name"
      timesheetCategoryAxis.renderer.grid.template.location = 0
      timesheetCategoryAxis.renderer.minGridDistance = 30;
      timesheetCategoryAxis.renderer.cellStartLocation = 0.1
      timesheetCategoryAxis.renderer.cellEndLocation = 0.9

      // Configure axis label
      var label = timesheetCategoryAxis.renderer.labels.template;
      label.wrap = true;
      label.maxWidth = 110;

      var timesheetValueAxis = employeeTimesheet.yAxes.push(new am4charts.ValueAxis())
      timesheetValueAxis.renderer.labels.template.disabled = true

      createSeries('waiting', 'Waiting for Approval', '#acb5c3', employeeTimesheet)
      createSeries('approved', 'Approved', '#26c281', employeeTimesheet)
    },
    error: function (data) {
      toastr.error(data.message)
    }
  })
}

function createSeries(field, name, color, parents) {
  var employeeTimesheetSeries = parents.series.push(new am4charts.ColumnSeries())
  employeeTimesheetSeries.dataFields.valueY = field
  employeeTimesheetSeries.dataFields.categoryX = "employee_name"
  employeeTimesheetSeries.name = name
  employeeTimesheetSeries.columns.template.tooltipText = "{name}: {valueY}"
  employeeTimesheetSeries.columns.template.fill = am4core.color(color)
}