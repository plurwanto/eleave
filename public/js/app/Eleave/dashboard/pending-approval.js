let $pendingApprovalTable

$(document).ready(function() {
    showPendingApprovalTables()
})

$(document).on('click', '.btn-approve', function () {
    var $button        = $(this)    
    var arr            = this.id.split('-')
    var approveUrl     = $button.attr('data-url')
    var action         = $button.attr('data-action')
    var chartLegendId  = action.toLowerCase()

    $button.attr('disabled', true)

    let dataParam = {
                        next: arr[1], 
                        token: token, 
                        user_id: id_eleave, 
                        branch_id: branch_id
    }

    if(action == 'Leave')
    {
        dataParam.lv_id             = arr[0]
        dataParam.lv_approve_nama   = user_login
    }
    else if(action == 'Timesheet')
    {
        dataParam.ts_id = arr[0]
        dataParam.ts_approve_nama   = user_login
    }
    else
    {
        dataParam.ot_id = arr[0]
        dataParam.ot_approve_nama   = user_login
    }

    $.ajax({
        url: `${apiUrl}eleave${approveUrl}`,
        type: "POST",
        data: dataParam,
        dataType: 'json',
        beforeSend: function () {
            NProgress.start()
        },
        success: function (data)
        {
            if (data.response_code == 200)
            {
                showPendingApprovalTables(chartLegendId)
                showPendingApprovalChart()
                toastr.success(data.message)
                $button.attr('disabled', false)
                $("#approve").modal("hide")
                NProgress.done()

                setTimeout(function () {
                    $(`.pendingApprovalLegend #${chartLegendId}`).addClass('activeLegend').siblings().removeClass('activeLegend')
                }, 2000)
            }
            else
            {
                showPendingApprovalTables(chartLegendId)
                toastr.error('Something wrong with the application, <br/>Please Contact administrator')
                $button.attr('disabled', false)
                NProgress.done()
            }
        },
        error: function (data)
        {
            showPendingApprovalTables(chartLegendId)
            toastr.error('Something wrong with the application, <br/>Please Contact administrator')
            $button.attr('disabled', false)
            NProgress.done()
        }
    })
})

$(document).on('click', '.btn-reject', function () {
    var $button        = $(this)    
    var id             = this.id
    var rejectUrl      = $button.attr('data-url')
    var action         = $button.attr('data-action')
    var chartLegendId  = action.toLowerCase()

    $button.attr('disabled', true)

    let dataParam = {
                        token: token, 
                        user_id: id_eleave, 
                        branch_id: branch_id
    }

    if(action == 'Leave')
    {
        dataParam.lv_id             = id
        dataParam.lv_rejected_by    = id_eleave
        dataParam.lv_rejected       = 1
        dataParam.lv_rejected_nama  = user_login
    }
    else if(action == 'Timesheet')
    {
        dataParam.ts_id             = id
        dataParam.ts_rejected_by    = id_eleave
        dataParam.ts_rejected       = 1
        dataParam.ts_rejected_nama  = user_login
    }
    else
    {
        dataParam.ot_id             = id
        dataParam.ot_rejected_by    = id_eleave
        dataParam.ot_rejected       = 1
        dataParam.ot_rejected_nama  = user_login
    }
    
    $.ajax({
        url: `${apiUrl}eleave${rejectUrl}`,
        type: "POST",
        data: dataParam,
        dataType: 'json',
        beforeSend: function () {
            NProgress.start()
        },
        success: function (data)
        {
            if (data.response_code == 200)
            {
                showPendingApprovalChart()
                showPendingApprovalTables(chartLegendId)
                toastr.success(data.message)
                $button.attr('disabled', false)
                $("#reject").modal("hide")
                NProgress.done()

                setTimeout(function () {
                    $(`.pendingApprovalLegend #${chartLegendId}`).addClass('activeLegend').siblings().removeClass('activeLegend')
                }, 2000)
            }
            else
            {
                showPendingApprovalTables(chartLegendId)
                toastr.error('Something wrong with the application, <br/>Please Contact administrator')
                $button.attr('disabled', false)
                NProgress.done()
            }
        },
        error: function (data)
        {
            toastr.error(data.message)
            showPendingApprovalTables(chartLegendId)
            $button.attr('disabled', false)
            NProgress.done()
        }
    })
})

$(document).on('click', '.btn-revise', function () {
    var $button        = $(this)    
    var id             = this.id
    var reviseUrl      = $button.attr('data-url')
    var action         = $button.attr('data-action')
    var chartLegendId  = action.toLowerCase()
    var revision       = $('#revise #revision_reason').val()

    $button.attr('disabled', true)

    let dataParam = {
                        token: token, 
                        user_id: id_eleave, 
                        branch_id: branch_id
    }

    if(action == 'Leave')
    {
        dataParam.lv_id              = id
        dataParam.lv_revision_from   = id_eleave
        dataParam.lv_revision_reason = revision
        dataParam.lv_rejected_nama   = user_login
        dataParam.lv_approver_id     = 1
        dataParam.lv_need_revision   = 1
    }
    else if(action == 'Timesheet')
    {
        dataParam.ts_id              = id
        dataParam.ts_revision_from   = id_eleave
        dataParam.ts_revision_reason = revision
        dataParam.ts_rejected_nama   = user_login
        dataParam.ts_approver_id     = 1
        dataParam.ts_need_revision   = 1
    }
    else
    {
        dataParam.ot_id              = id
        dataParam.ot_revision_from   = id_eleave
        dataParam.ot_revision_reason = revision
        dataParam.ot_rejected_nama   = user_login
        dataParam.ot_approver_id     = 1
        dataParam.ot_need_revision   = 1
    }

    if (revision != '')
    {
        $.ajax({
            url: `${apiUrl}eleave${reviseUrl}`,
            type: "POST",
            data: dataParam,
            dataType: 'json',
            beforeSend: function () {
                NProgress.start()
            },
            success: function (data)
            {
                if (data.response_code == 200)
                {
                    showPendingApprovalChart()
                    showPendingApprovalTables(chartLegendId)
                    toastr.success(data.message)
                    $button.attr('disabled', false)
                    $("#revise").modal("hide")
                    NProgress.done()

                    setTimeout(function () {
                        $(`.pendingApprovalLegend #${chartLegendId}`).addClass('activeLegend').siblings().removeClass('activeLegend')
                    }, 2000)
                }
                else
                {
                    showPendingApprovalTables(chartLegendId)
                    toastr.error('Something wrong with the application, <br/>Please Contact administrator')
                    $button.attr('disabled', false)
                    NProgress.done()
                }
            },
            error: function (data)
            {
                showPendingApprovalTables(chartLegendId)
                $button.attr('disabled', false)
                toastr.error(data.message)
                NProgress.done()
            }
        })
    }
    else
    {
        toastr.warning('Please fill the reason')
        $button.attr('disabled', false)
    }
})

$(document).on('click', '.pendingApprovallegendList', function () {
    $(".chart-title span#title-text").hide()

    let type = this.id
    let legendLabel = $(`#${type} .legendLabel`).text()
    
    showPendingApprovalTables(type)

    $(this).addClass('activeLegend').siblings().removeClass('activeLegend')

    $(".chart-title span#title-text").fadeIn('slow').text(legendLabel);
})

function showPendingApprovalTables(type)
{
    var tableType          = (typeof type == 'undefined') ? 'leave' : type
    $pendingApprovalTable  = $(`#pendingApproval${tableType}`)
    var head = ''

    //S:Pending Approval Table
    $.ajax({
        "url": `${apiUrl}eleave/dashboard/pending-approval-table`,
        "dataType": "json",
        "type": "POST",
        "data": {token: token, branch_id: branch_id, user_id: id_eleave, type: tableType},
        beforeSend: function () {
            NProgress.start()
        },
        "success": function (response) {

            switch (tableType) {
                case 'timesheet':
                    $(`#pendingApproval${tableType}`).removeClass('hidden')
                    $(`#pendingApprovalleave_wrapper`).addClass('hidden')
                    $(`#pendingApprovalovertime_wrapper`).addClass('hidden')
                    break;
                case 'overtime':
                    $(`#pendingApproval${tableType}`).removeClass('hidden')
                    $(`#pendingApprovalleave_wrapper`).addClass('hidden')
                    $(`#pendingApprovaltimesheet_wrapper`).addClass('hidden')
                    break;
                default:
                    $(`#pendingApproval${tableType}`).removeClass('hidden')
                    $(`#pendingApprovaltimesheet_wrapper`).addClass('hidden')
                    $(`#pendingApprovalovertime_wrapper`).addClass('hidden')
                    break;
            }

            var result             = response.data.data
            var datatables_columns = response.data.datatables_columns
            var order_column       = response.data.order_column
            var hidden_column      = response.data.hidden_column

            var head = '<tr>'

            $.each(response.data.columns, function (i, val) {
                head += `<th>${val}</th>`
            })

            head += '</tr>'

            $(`#pendingApproval${tableType} thead`).html(head)

            // $(`#pendingApproval${}`').empty()

            $pendingApprovalTable.DataTable({
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

//S:Show modal by actions button
function PendingApprovalActions(id, type, action)
{
    let title = action

    $(`#${type} .btn-${type}`).attr('id', id)

    if(typeof action != 'undefined')
    {
        let contentType   = action.toLowerCase()

        if(action == 'Leave')
        {
            var url = `/leaveApproval/${type}`
        }
        else if(action == 'Timesheet')
        {
            var url = `/timesheetApproval/${type}`
        }
        else
        {
            var url = `/overtimeApproval/${type}`
        }

        $(`#${type} .btn-${type}`).attr('data-url', url)
        $(`#${type} .btn-${type}`).attr('data-action', action)
        $(`#${type} #title`).text(title)
        $(`#${type} #actions`).text(contentType)
    }

    if(type == 'LeaveDetail' || type == 'TimesheetDetail' || type == 'OvertimeDetail')
    {
        showPendingApprovalDetail(id,type)
    }

    if(type == 'revise')
    {
        $('#revise #revision_reason').val('')
    }
}
//E:Show modal by actions button

//S:show detail
function showPendingApprovalDetail(id,type)
{
    $.ajax({
        "url": `${apiUrl}eleave/dashboard/pending-approval-table-detail`,
        "dataType": "json",
        "type": "POST",
        "data": {token: token, user_id: id_eleave, type: type, branch_id: branch_id, approval_id: id},
        beforeSend: function () {
            NProgress.start()
        },
        "success": function (response) {
            switch (type) {
                case 'TimesheetDetail':
                    $(`#pendingApproval${type}`).removeClass('hidden')
                    $(`#pendingApprovalLeaveDetail_wrapper`).addClass('hidden')
                    $(`#pendingApprovalOvertimeDetail_wrapper`).addClass('hidden')
                    break;
                case 'OvertimeDetail':
                    $(`#pendingApproval${type}`).removeClass('hidden')
                    $(`#pendingApprovalLeaveDetail_wrapper`).addClass('hidden')
                    $(`#pendingApprovalTimesheetDetail_wrapper`).addClass('hidden')
                    break;
                default:
                    $(`#pendingApproval${type}`).removeClass('hidden')
                    $(`#pendingApprovalTimesheetDetail_wrapper`).addClass('hidden')
                    $(`#pendingApprovalOvertimeDetail_wrapper`).addClass('hidden')
                    break;
            }

            var result             = response.data.data
            var datatables_columns = response.data.datatables_columns

            var head = '<tr>'

            $.each(response.data.columns, function (i, val) {
                head += `<th>${val}</th>`
            })

            head += '</tr>'

            $(`#pendingApproval${type} thead`).html(head)

            // $(`#pendingApproval${}`').empty()

            $(`#pendingApproval${type}`).DataTable({
                data: result,
                columns: datatables_columns,
                pagingType: 'simple',
                pageLength: 5,
                lengthChange: false,
                destroy: true,
                info: false,
                paging: false,
                searching: false
            })

            NProgress.done()
        }
    })
}
//E:show detail
