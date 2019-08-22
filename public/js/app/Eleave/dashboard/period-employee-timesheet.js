// let $divisionTable

$(document).on('click', '.employeeTimesheetList', function () {
    $("#employeeTimesheetBox").hide()

    showEmployeeTimesheetTables()

    $("#employeeTimesheetBox").fadeIn()
    $("#employeeTimesheetBox .employeeTimesheetBoxInner").css("border", "1px solid #000")
    $("#employeeTimesheetBox").removeClass('col-lg-6 col-md-6 col-sm-6 col-xs-6').addClass('col-lg-12 col-md-12 col-sm-12 col-xs-12')
    $("#employeeTimesheetBox .chart-section").removeClass('col-lg-12 col-md-12 col-sm-12 col-xs-12').addClass('col-lg-6 col-md-6 col-sm-6 col-xs-6')
    $("#employeeTimesheetBox .table-section").fadeIn('slow')

    $('html, body').animate({
        scrollTop: $(`#employeeTimesheetBox`).offset().top - 75
    }, 2000)
})

function showEmployeeTimesheetTables()
{
    $employeeTimesheetTable  = $(`#employeeTimesheetTable`)
    var months      = $('#period').val()

    var head = ''

    // S:Employee Timesheet Table
    $.ajax({
        "url": `${apiUrl}eleave/dashboard/employee-timesheet-table`,
        "dataType": "json",
        "type": "POST",
        "data": {token: token, branch_id: branch_id, user_id: id_eleave, month: months},
        beforeSend: function () {
            NProgress.start()
        },
        "success": function (response) {

            var result             = response.data.data
            var datatables_columns = response.data.datatables_columns
            var order_column       = response.data.order_column
            var hidden_column      = response.data.hidden_column

            var head = '<tr>'

            $.each(response.data.columns, function (i, val) {
                head += `<th>${val}</th>`
            })

            head += '</tr>'

            $(`#employeeTimesheetTable thead`).html(head)

            $employeeTimesheetTable.DataTable({
                data: result,
                columns: datatables_columns,
                order: order_column,
                pagingType: 'simple',
                pageLength: 5,
                lengthChange: false,
                destroy: true,
                columnDefs: hidden_column,
            })

            NProgress.done()
        }
    })
    // E:Employee Timesheet Table
}
