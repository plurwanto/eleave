var $reportTable

$(document).ready(function ()
{
    //S:show open ticket data
    $reportTable = $('#report').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${apiUrl}eleave/ticketing/report`,
            "dataType": "json",
            "type": "POST",
            "data": {
                        "token": token,
                        "user_id": id_eleave,
                        "branch_id": branch_id
            }
        },
        "columns": [
                        {"data": "no", "orderable": false},
                        {"data": "requester"},
                        {"data": "department"},
                        {"data": "application"},
                        {"data": "developer"},
                        {"data": "status"},
                        {"data": "requestDate"},
                        {"data": "finishDate"},
                        {"data": "ticketId"}
        ],
        "columnDefs":[
           {"orderData": 8, "targets": 8},
           {"visible": false, "targets":8}
        ],
        order: [[8, "desc"]],
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>"
    })
    //E:show open ticket data

    //S:Search data by month and years
    $("#btn-search").click(function(){
        let reportMonth    = $("#month").val()
        let reportYear     = $("#year").val()
        let reportDate     = `${reportMonth}-${reportYear}`
        
        $reportTable.column(6)
                    .search(reportDate)
                    .draw()
    })
    //E:Search data by month and years

    //S:Show preview attachment modal in ticket detail
    $("#export-btn").click(function(){
        let reportMonth    = $("#month").val()
        let reportMonthNum = (reportMonth.charAt(0) == '0') ? $("#month").val().substring(1, 2) : $("#month").val()
        let reportYear     = $("#year").val()
        let reportDate     = `${reportMonth}-${reportYear}`
        let monthName      = getMonthName(reportMonthNum)

        $.ajax({
            url: `${apiUrl}eleave/ticketing/report`,
            type: 'POST',
            dataType: 'json',
            data: {
                    "token": token,
                    "user_id": id_eleave,
                    "branch_id": branch_id,
                    "order": {0:{'column':6, 'dir':'desc'}},
                    "columns": "",
                    "ticket_date": reportDate,
                    "type": 'excel'
            },
            success: function (response) {
                let reportTitle = `Ticketing Report Year : ${reportYear}    Month : ${monthName}`

                JSONToCSVConvertor(response.data, reportTitle, true, `Ticketing Report_${reportDate}`)
            }
        })
        .fail(function() {
            console.log("error");
        })
        
    })
    //E:Show preview attachment modal in ticket detail
})

//S:Validate new ticket form
function validated()
{
    if($("#new-ticket #application").val() == '')
    {
        toastr.warning("Please Choose Application")

        return false
    }

    if($("#new-ticket #priority").val() == '')
    {
        toastr.warning("Please Choose Priority")

        return false
    }

    if($("#new-ticket #subject").val() == '')
    {
        toastr.warning("Please Input the Subject")

        return false
    }

    let txtAreaId = $('#new-ticket textarea').attr('id')
    let txtAreaVal = (CKEDITOR.instances[txtAreaId]) ? CKEDITOR.instances[txtAreaId].getData() : $('#new-ticket textarea').val()

    if(txtAreaVal == '')
    {
        toastr.warning("Please Describe the Issue")

        return false
    }

    return true
}
//E:Validate new ticket form