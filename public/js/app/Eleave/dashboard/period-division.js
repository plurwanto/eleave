let $divisionTable

$(document).on('click', '.divisionLegendList', function () {
    $("#divisionBox").hide()
    $("#divisionBox .table-section #title-text").hide()

    let type = this.id
    let legendLabel = $(`#${type} .legendLabel`).text()
    
    showDivisionTables(type)

    $(this).addClass('activeLegend').siblings().removeClass('activeLegend')

    $("#divisionBox .table-section #title-text").fadeIn('slow').text(legendLabel);

    $("#divisionBox").fadeIn()
    $("#divisionBox .divisionBoxInner").css("border", "1px solid #000")
    $("#divisionBox").removeClass('col-lg-6 col-md-6 col-sm-6 col-xs-6').addClass('col-lg-12 col-md-12 col-sm-12 col-xs-12')
    $("#divisionBox .chart-section").removeClass('col-lg-12 col-md-12 col-sm-12 col-xs-12').addClass('col-lg-6 col-md-6 col-sm-6 col-xs-6')
    $("#divisionBox .table-section").fadeIn('slow')

    $('html, body').animate({
        scrollTop: $(`#divisionBox`).offset().top - 75
    }, 2000)
})

function showDivisionTables(type)
{
    var tableType   = type
    $divisionTable  = $(`#divisionTable`)
    var months      = $('#period').val()

    var head = ''

    //S:Pending Approval Table
    $.ajax({
        "url": `${apiUrl}eleave/dashboard/division-table`,
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

            $(`#divisionTable thead`).html(head)

            // $(`#pendingApproval${}`').empty()

            $divisionTable.DataTable({
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
