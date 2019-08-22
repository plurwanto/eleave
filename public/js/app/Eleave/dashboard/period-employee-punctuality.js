let $employeePunctualityTable

$(document).on('click', '.employeePunctualityLegendList', function () {
    $("#employeePunctualityBox").hide()
    $("#employeePunctualityBox .table-section #title-text").hide()

    let type = this.id
    let legendLabel = $(`#${type} .legendLabel`).text()
    
    showEmployeePunctualityTables(type)

    $(this).addClass('activeLegend').siblings().removeClass('activeLegend')

    $("#employeePunctualityBox .table-section #title-text").fadeIn('slow').text(legendLabel);

    $("#employeePunctualityBox").fadeIn()
    $("#employeePunctualityBox .employeePunctualityBoxInner").css("border", "1px solid #000")
    $("#employeePunctualityBox").removeClass('col-lg-6 col-md-6 col-sm-6 col-xs-6').addClass('col-lg-12 col-md-12 col-sm-12 col-xs-12')
    $("#employeePunctualityBox .chart-section").removeClass('col-lg-12 col-md-12 col-sm-12 col-xs-12').addClass('col-lg-6 col-md-6 col-sm-6 col-xs-6')
    $("#employeePunctualityBox .table-section").fadeIn('slow')

    $('html, body').animate({
        scrollTop: $(`#employeePunctualityBox`).offset().top - 75
    }, 2000)
})

function showEmployeePunctualityTables(type)
{
    var tableType   = type
    $employeePunctualityTable  = $(`#employeePunctualityTable`)
    var months      = $('#period').val()

    var head = ''

    //S:Pending Approval Table
    $.ajax({
        "url": `${apiUrl}eleave/dashboard/employee-punctuality-table`,
        "dataType": "json",
        "type": "POST",
        "data": {token: token, branch_id: branch_id, user_id: id_eleave, type: tableType, month: months},
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

            $(`#employeePunctualityTable thead`).html(head)

            // $(`#pendingApproval${}`').empty()

            $employeePunctualityTable.DataTable({
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
    //E:Pending Approval Table
}
