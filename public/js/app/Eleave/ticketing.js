var $openTable
var $closeTable
var $select = $('select')

if(role == 'admin')
{
    var openColumn = [
                        {"data": "no", "orderable": false},
                        {"data": "ticket_date"},
                        {"data": "ticket_id"},
                        {"data": "employee"},
                        {"data": "subject"},
                        {"data": "application"},
                        {"data": "priority"},
                        {"data": "assignBy"},
                        {"data": "assignTo"},
                        {"data": "status"},
                        {"data": "action"}
    ]

    var closeColumn = [
                        {"data": "no", "orderable": false},
                        {"data": "ticket_date"},
                        {"data": "ticket_id"},
                        {"data": "employee"},
                        {"data": "subject"},
                        {"data": "application"},
                        {"data": "priority"},
                        {"data": "assignBy"},
                        {"data": "assignTo"},
                        {"data": "status"}
    ]

    var appCol = 5
    var priorityCol = 6
    var assByCol = 7
    var assToCol = 8
    var statusCol = 9
}
else
{
    var openColumn = [
                        {"data": "no", "orderable": false},
                        {"data": "ticket_date"},
                        {"data": "ticket_id"},
                        {"data": "subject"},
                        {"data": "application"},
                        {"data": "priority"},
                        {"data": "assignTo"},
                        {"data": "status"},
                        {"data": "action"}
    ]

    var closeColumn = [
                        {"data": "no", "orderable": false},
                        {"data": "ticket_date"},
                        {"data": "ticket_id"},
                        {"data": "subject"},
                        {"data": "application"},
                        {"data": "priority"},
                        {"data": "assignTo"},
                        {"data": "status"}
    ]

    var appCol = 4
    var priorityCol = 5
    var assToCol = 6
    var statusCol = 7
}

let customTools = {
                    toolbar: [
                        { 
                            name: 'document', 
                            items: [ 
                                    'Source', '-',
                                    'Preview' 
                            ]
                        },
                        [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
                        '/',
                        { 
                            name: 'basicstyles', 
                            items: [ 
                                        'Bold', 
                                        'Italic', 
                                        'Underline', 
                                        'Strike'
                            ]
                        },
                        {
                            name: 'paragraph', 
                            groups: [ 
                                        'list', 
                                        'indent', 
                                        'blocks', 
                                        'align', 
                                        'bidi' 
                            ], 
                            items: [ 
                                        'NumberedList', 
                                        'BulletedList', '-', 
                                        'Outdent', 
                                        'Indent', '-', 
                                        'Blockquote', '-', 
                                        'JustifyLeft', 
                                        'JustifyCenter', 
                                        'JustifyRight', 
                                        'JustifyBlock', '-'
                            ]
                        }
                    ]
}


$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href");
    if ((target == '#closeTab')) {
        $closeTable.ajax.reload()
    }
});


$(document).ready(function ()
{
    //S:show open ticket data
    $openTable = $('#openTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${apiUrl}eleave/ticketing`,
            "dataType": "json",
            "type": "POST",
            "data": {
                        "token": token,
                        "user_id": id_eleave,
                        "branch_id": branch_id,
                        "type": "open"
            }
        },
        "columns": openColumn,
        /*"columnDefs":[
           {"orderData": 1, "targets": 1},
           {"visible": false, "targets":1}
        ],*/
        order: [[2, "desc"]],
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        scrollX: true,
        /* scrollY: 350,
        scrollCollapse: true,
        fixedColumns:   true,
        fixedHeader: true */
    })
    //E:show open ticket data

    new $.fn.dataTable.FixedColumns($openTable, {
        leftColumns: 4,
        rightColumns: 2
    })


    $openTable.columns().eq(0).each(function (colIdx)
    {
        $('input', $openTable.column(colIdx).header()).on('keyup change', function () {
            $openTable
                    .column(colIdx)
                    .search(this.value)
                    .draw()
        })
        $('input', $openTable.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation()
        })
        $('select', $openTable.column(colIdx).header()).on('change', function () {
            $openTable
                    .column(colIdx)
                    .search(this.value)
                    .draw()
        })
        $('select', $openTable.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation()
        })
    })

    //S: show datepicker in first column of open ticketing data
    $('#openTab #submitDate').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        autoclose: true,
        todayHighlight: true
    })
    .on("show", function () {
        $('.datepicker-dropdown').css({
            top: 250.15,
            left: 426,
        })
    })
    .on("change", function () {
        var value = $(this).val()

        $('.DTFC_LeftWrapper #openTab #submitDate').val(value)
    })
    //E: show datepicker in first column of open ticketing data

    //S:show my room booking data
    $closeTable = $('#closeTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${apiUrl}eleave/ticketing`,
            "dataType": "json",
            "type": "POST",
            "data": {
                        "token": token,
                        "user_id": id_eleave,
                        "branch_id": branch_id,
                        "type": "close"
            }
        },
        "columns": closeColumn,
        /*"columnDefs":[
           {"orderData": 1, "targets": 1},
           {"visible": false, "targets":1}
        ],*/
        order: [[2, "desc"]],
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        scrollX: true
        /*fixedColumns: {
            leftColumns: 3
        },
        fixedHeader: true*/
    })
    //E:show my room booking data

    $closeTable.columns().eq(0).each(function (colIdx)
    {
        $('input', $closeTable.column(colIdx).header()).on('keyup change', function () {
            $closeTable
                    .column(colIdx)
                    .search(this.value)
                    .draw()
        })
        $('input', $closeTable.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation()
        })
        $('select', $closeTable.column(colIdx).header()).on('change', function () {
            $closeTable
                    .column(colIdx)
                    .search(this.value)
                    .draw()
        })
        $('select', $closeTable.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation()
        })
    })

    $(".dataTables_scroll").attr('style', 'overflow: auto;');
    $(".dataTables_scrollHead").css('overflow', 'unset');
    $(".dataTables_scrollBody").css('overflow', 'unset');

    //S:show datepicker in first column of open table data
    $('#closeTab #submitDate').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        autoclose: true,
        todayHighlight: true,
        // endDate: "1m"
    })
    .on("show", function () {
        var parent_scroll = $(this).attr('id')

        $('.datepicker-dropdown').css({
            top: 250.15,
            left: 426,
        })
    })
    .on("change", function () {
        var value = $(this).val()

        $('.DTFC_LeftWrapper #closeTab #submitDate').val(value)
    })
    //E:show datepicker in first column of open table data

    //S:Multiple Select Open Dropdown Employee
    var $openEmployee       = $('#openTab select#employee')

    $openEmployee.multipleSelect({
        filter: true,
        placeholder: '-- Select Employee --',
        onClick: function(){
            var openEmployeeValue = $openEmployee.val()
            
            if(openEmployeeValue != null)
            {
                $openTable
                        .column(3)
                        .search(openEmployeeValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var openEmployeeValue = $openEmployee.val()

            if(openEmployeeValue != null)
            {
                $openTable
                        .column(3)
                        .search(openEmployeeValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Open Dropdown Employee

    //S:Multiple Select Close Dropdown Employee
    var $closeEmployee       = $('#closeTab select#employee')

    $closeEmployee.multipleSelect({
        filter: true,
        placeholder: '-- Select Employee --',
        onClick: function(){
            var closeEmployeeValue   = $closeEmployee.val()

            if(closeEmployeeValue != null)
            {
                $closeTable
                        .column(3)
                        .search(closeEmployeeValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var closeEmployeeValue   = $closeEmployee.val()

            if(closeEmployeeValue != null)
            {
                $closeTable
                        .column(3)
                        .search(closeEmployeeValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Close Dropdown Employee

    //S:Multiple Select Open Dropdown Application
    var $openApplication       = $('#openTab select#application')

    $openApplication.multipleSelect({
        filter: true,
        placeholder: '-- Select Application --',
        onClick: function(){
            var openApplicationValue   = $openApplication.val()

            if(openApplicationValue != null)
            {
                $openTable
                        .column(appCol)
                        .search(openApplicationValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var openApplicationValue   = $openApplication.val()

            if(openApplicationValue != null)
            {
                $openTable
                        .column(appCol)
                        .search(openApplicationValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Open Dropdown Application

    //S:Multiple Select Close Dropdown Application
    var $closeApplication       = $('#closeTab select#application')

    $closeApplication.multipleSelect({
        filter: true,
        placeholder: '-- Select Application --',
        onClick: function(){
            var closeApplicationValue   = $closeApplication.val()

            if(closeApplicationValue != null)
            {
                $closeTable
                        .column(appCol)
                        .search(closeApplicationValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var closeApplicationValue   = $closeApplication.val()

            if(closeApplicationValue != null)
            {
                $closeTable
                        .column(appCol)
                        .search(closeApplicationValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Close Dropdown Application

    //S:Multiple Select Open Dropdown Priority
    var $openPriority       = $('#openTab select#priority')

    $openPriority.multipleSelect({
        filter: true,
        placeholder: '-- Select Priority --',
        onClick: function(){
            var openPriorityValue   = $openPriority.val()

            if(openPriorityValue != null)
            {
                $openTable
                        .column(priorityCol)
                        .search(openPriorityValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var openPriorityValue   = $openPriority.val()

            if(openPriorityValue != null)
            {
                $openTable
                        .column(priorityCol)
                        .search(openPriorityValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Open Dropdown Priority

    //S:Multiple Select Close Dropdown Priority
    var $closePriority       = $('#closeTab select#priority')

    $closePriority.multipleSelect({
        filter: true,
        placeholder: '-- Select Priority --',
        onClick: function(){
            var closePriorityValue   = $closePriority.val()

            if(closePriorityValue != null)
            {
                $closeTable
                        .column(priorityCol)
                        .search(closePriorityValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var closePriorityValue   = $closePriority.val()

            if(closePriorityValue != null)
            {
                $closeTable
                        .column(priorityCol)
                        .search(closePriorityValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Close Dropdown Priority

    //S:Multiple Select Open Dropdown Assign By
    var $openAssignBy       = $('#openTab select#assignBy')

    $openAssignBy.multipleSelect({
        filter: true,
        placeholder: '-- Select Assign By --',
        onClick: function(){
            var openAssignByValue   = $openAssignBy.val()

            if(openAssignByValue != null)
            {
                $openTable
                        .column(assByCol)
                        .search(openAssignByValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var openAssignByValue   = $openAssignBy.val()

            if(openAssignByValue != null)
            {
                $openTable
                        .column(assByCol)
                        .search(openAssignByValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Open Dropdown Assign By

    //S:Multiple Select Close Dropdown Assign By
    var $closeAssignBy       = $('#closeTab select#assignBy')

    $closeAssignBy.multipleSelect({
        filter: true,
        placeholder: '-- Select Assign By --',
        onClick: function(){
            var closeAssignByValue   = $closeAssignBy.val()

            if(closeAssignByValue != null)
            {
                $closeTable
                        .column(assByCol)
                        .search(closeAssignByValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var closeAssignByValue   = $closeAssignBy.val()

            if(closeAssignByValue != null)
            {
                $closeTable
                        .column(assByCol)
                        .search(closeAssignByValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Close Dropdown Assign By

    //S:Multiple Select Open Dropdown Assign To
    var $openAssignTo       = $('#openTab select#assignTo')

    $openAssignTo.multipleSelect({
        filter: true,
        placeholder: '-- Select Assign To --',
        onClick: function(){
            var openAssignToValue   = $openAssignTo.val()

            if(openAssignToValue != null)
            {
                $openTable
                        .column(assToCol)
                        .search(openAssignToValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var openAssignToValue   = $openAssignTo.val()

            if(openAssignToValue != null)
            {
                $openTable
                        .column(assToCol)
                        .search(openAssignToValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Open Dropdown Assign To

    //S:Multiple Select Close Dropdown Assign To
    var $closeAssignTo       = $('#closeTab select#assignTo')

    $closeAssignTo.multipleSelect({
        filter: true,
        placeholder: '-- Select Assign To --',
        onClick: function(){
            var closeAssignToValue   = $closeAssignTo.val()

            if(closeAssignToValue != null)
            {
                $closeTable
                        .column(assToCol)
                        .search(closeAssignToValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var closeAssignToValue   = $closeAssignTo.val()

            if(closeAssignToValue != null)
            {
                $closeTable
                        .column(assToCol)
                        .search(closeAssignToValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Close Dropdown Assign To

    //S:Multiple Select Open Dropdown Status
    var $openStatus       = $('#openTab select#status')

    $openStatus.multipleSelect({
        filter: true,
        placeholder: '-- Select Status --',
        onClick: function(){
            var openStatusValue   = $openStatus.val()

            if(openStatusValue != null)
            {
                $openTable
                        .column(statusCol)
                        .search(openStatusValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var openStatusValue   = $openStatus.val()

            if(openStatusValue != null)
            {
                $openTable
                        .column(statusCol)
                        .search(openStatusValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Open Dropdown Status

    //S:Multiple Select Close Dropdown Status
    var $closeStatus       = $('#closeTab select#status')

    $closeStatus.multipleSelect({
        filter: true,
        placeholder: '-- Select Status --',
        onClick: function(){
            var closeStatusValue   = $closeStatus.val()

            if(closeStatusValue != null)
            {
                $closeTable
                        .column(statusCol)
                        .search(closeStatusValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var closeStatusValue   = $closeStatus.val()

            if(closeStatusValue != null)
            {
                $closeTable
                        .column(statusCol)
                        .search(closeStatusValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select Close Dropdown Status

    //S:Save Ticketing
    $("#new-ticket .btn-add-ticket").click(function() {
        if(validated())
        {
            let application = $('#new-ticket #application').val()
            let priority    = $('#new-ticket #priority').val()
            let subject     = $('#new-ticket #subject').val()
            let attachment  = $('#new-ticket #attachment').val()
            let txtAreaId   = $('#new-ticket textarea').attr('id')
            let txtAreaVal  = CKEDITOR.instances[txtAreaId].getData()

            // let addParam    = `&token=${token}&user=${user}&issue=${txtAreaVal}`
            // let formData = $('#submit-ticket').serialize()+addParam

            let formData = new FormData($("#submit-ticket")[0])

            formData.append('token', token)
            formData.append('user', id_eleave)
            formData.append('branch_id', branch_id)
            formData.append('issue', txtAreaVal)
            /*formData.append('application', application)
            formData.append('attachment', attachment)*/

            $.ajax({
                url: `${apiUrl}eleave/ticketing/create`,
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                data: formData,
                success: function (response) {
                    if(response.response_code == 200)
                    {
                        toastr.success("Success to submit the ticket")
                        $("#new-ticket").modal('hide')

                        $openTable.ajax.reload()
                        $closeTable.ajax.reload()

                        if (CKEDITOR.instances[txtAreaId])
                        {
                            /* destroying instance */
                            CKEDITOR.instances[txtAreaId].destroy();
                        }

                        $('#new-ticket input, #new-ticket select, #new-ticket textarea').val('')
                        $("#new-ticket select#priority").val(2)

                        //S:Send to user email
                        let toUser      = response.user.to
                        let userData    = response.user.param
                        let subject     = response.subject

                        let paramUser = {
                                            'to'        : toUser,
                                            'data'      : userData,
                                            'file_name' : `eleave.ticketing.newTicket`,
                                            'from'      : `eleave@elabram.com`,
                                            'from_name' : `E-LEAVE - ELABRAM`,
                                            'bcc'       : `kartaterazu27@gmail.com`,
                                            'subject'   : subject
                        }

                        let sendUserEmail = setMail(paramUser)

                        // toastr.success(sendUserEmail)
                        //E:Send to user email

                        //S:Send to admin email
                        let toAdmin     = response.admin.to
                        let adminData   = response.admin.param

                        let paramAdmin = {
                                            'to'        : toAdmin,
                                            'data'      : adminData,
                                            'file_name' : `eleave.ticketing.newTicketAdmin`,
                                            'from'      : `eleave@elabram.com`,
                                            'from_name' : `E-LEAVE - ELABRAM`,
                                            'bcc'       : `kartaterazu27@gmail.com`,
                                            'subject'   : subject
                        }

                        let sendAdminEmail = setMail(paramAdmin)

                        // toastr.success(sendAdminEmail)
                        //E:Send to admin email
                    }
                    else
                    {
                        toastr.warning(response.message)
                    }
                }
            })
            .fail(function(error) {
                console.log(error);
                toastr.error("System failure, Please contact the Administrator")
            })
            
        }
    })
    //E:Save Ticketing

    //S:Reset Submit Ticket Form
    $(".btn-book-form").click(function() {
        $("#book-room").trigger("reset")
        // $("#multiReqFor").val('')
        $("#new-book .ms-drop li").removeClass('selected')
        $(".after-date").hide()
    })
    //E:Reset Submit Ticket Form

    //S:Refresh the table
    $(".btn-refresh").click(function() {
        if($(this).attr('id') == 'open')
        {
            $openEmployee.multipleSelect('setSelects',[])
            $openApplication.multipleSelect('setSelects',[])
            $openPriority.multipleSelect('setSelects',[])
            $openAssignBy.multipleSelect('setSelects',[])
            $openAssignTo.multipleSelect('setSelects',[])
            $openStatus.multipleSelect('setSelects',[])
            $("#openTab #submitDate").val('').keyup()
            $("#openTab #ticketId").val('').keyup()
            $("#openTab #subject").val('').keyup()
            $openTable.ajax.reload()
        }
        else
        {
            $closeEmployee.multipleSelect('setSelects',[])
            $closeApplication.multipleSelect('setSelects',[])
            $closePriority.multipleSelect('setSelects',[])
            $closeAssignBy.multipleSelect('setSelects',[])
            $closeAssignTo.multipleSelect('setSelects',[])
            $closeStatus.multipleSelect('setSelects',[])
            $("#closeTab #submitDate").val('').keyup()
            $("#closeTab #ticketId").val('').keyup()
            $("#closeTab #subject").val('').keyup()
            $closeTable.ajax.reload()
        }
    })
    //E:Refresh the table

    //S:Actions button
    $(".btn-actions").click(function() {
        let ticketId    = $(this).attr('id')
        let action      = $(this).attr('data-actions')
        let token       = document.getElementById('token').value
        let actionWords = ''

        switch (action)
        {
            case 'resolve':
                actionWords = 'Close'
                break
            case 'reopen':
                actionWords = 'Re-Open'
                break
        }

        $.ajax({
            url: `${apiUrl}eleave/ticketing/change-status`,
            type: 'POST',
            dataType: 'json',
            data: {ticket_id: ticketId, token: token, action: action, user_id: id_eleave},
            success: function (response) {
                if(response.response_code == 200)
                {
                    toastr.success(response.message)
                    $(`#${action}`).modal('hide')
                    $openTable.ajax.reload()
                    $closeTable.ajax.reload()
                }
                else
                {
                    toastr.warning(`Failed to ${actionWords} the ticket`)
                }
            }
        })
        .fail(function() {
            toastr.error("System failure, Please contact the Administrator")
        })
    })
    //E:Actions button

    //S:init CKEditor to new ticket
    $("#new-ticket textarea").focus(function() {
        let txtAreaId = $('#new-ticket textarea').attr('id')

        CKEDITOR.replace( txtAreaId, customTools )

        setTimeout(function () {
            let editor = CKEDITOR.instances[txtAreaId]
                    
            if (editor) 
            {
                editor.focus()
            }
        },1000)
    })
    //E:init CKEditor to new ticket

    //S:Destroy CKEditor and empty input form to new ticket
    $("#new-ticket #btn-close").click(function() {
        let txtAreaId = $("#new-ticket textarea").attr('id')

        if (CKEDITOR.instances[txtAreaId])
        {
            /* destroying instance */
            CKEDITOR.instances[txtAreaId].destroy()
        }

        $('#new-ticket input, #new-ticket select, #new-ticket textarea').val('')
        $("#new-ticket select#priority").val(2)
    })
    //E:Destroy CKEditor and empty input form to new ticket

    //S:Destroy CKEditor and empty input form to ticket detail
    $("#detailTicket #btn-close").click(function() {
        let txtAreaId = $("#detailTicket textarea").attr('id')

        if (CKEDITOR.instances[txtAreaId])
        {
            /* destroying instance */
            CKEDITOR.instances[txtAreaId].destroy()
        }

        $('#detailTicket select, #detailTicket textarea').val('')
    })
    //E:Destroy CKEditor and empty input form to ticket detail

    //S:Show preview attachment modal in ticket detail
    $("#detailTicket #btn-image").click(function(){
        let imgUrl = $("#detailTicket #attachment a").attr('data-img-url')

        $("#detailTicket .image-preview").fadeIn('slow')
        $("#detailTicket .image-preview .content img").attr('src', imgUrl)
    })
    //E:Show preview attachment modal in ticket detail

    //S:Close prewiew attachment modal in ticket detail
    $("#detailTicket .image-preview .header .fa-close").click(function(){
        $("#detailTicket .image-preview").fadeOut('slow')
    })
    //E:Close prewiew attachment modal in ticket detail

    //S:Show / Hide assigned to select dropdown
    $("#detailTicket #ticketStatus").change(function(){
        if ($(this).val() == "1")
        {
            $('.assTo').show('slow');
        }
        else
        {
            $('.assTo').hide('slow');
        }
    })
    //E:Show / Hide assigned to select dropdown

    //S:Show preview attachment modal in ticket detail
    $("#detailTicket .btn-detailTicket").click(function(){
        let txtAreaId  = $('#detailTicket textarea').attr('id')
        let txtAreaVal = CKEDITOR.instances[txtAreaId].getData()
        let status     = $("#detailTicket #ticketStatus").val()
        let assTo      = $("#detailTicket #developer").val()
        let ticketId   = $(this).attr('id')

        let formData = {
            token: token,
            user: id_eleave,
            branch_id: branch_id,
            issue: txtAreaVal,
            status: status,
            assignTo: assTo,
            ticketId: ticketId,
            role: role,
        }

        if(validateComment())
        {
            $.ajax({
                url: `${apiUrl}eleave/ticketing/submit-comment`,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function (response) {
                    if(response.response_code == 200)
                    {
                        toastr.success("Success to submit the comment")

                        CKEDITOR.instances[txtAreaId].setData('')

                        showDetail(ticketId)

                        $openTable.ajax.reload()
                        $closeTable.ajax.reload()

                        let subject     = response.subject

                        if(typeof response.user != 'undefined')
                        {
                            //S:Send to user email
                            let toUser      = response.user.to
                            let userData    = response.user.param

                            let paramUser = {
                                                'to'        : toUser,
                                                'data'      : userData,
                                                'file_name' : `eleave.ticketing.statusReOpen`,
                                                'from'      : `eleave@elabram.com`,
                                                'from_name' : `E-LEAVE - ELABRAM`,
                                                'bcc'       : `kartaterazu27@gmail.com`,
                                                'subject'   : subject
                            }

                            let sendUserEmail = setMail(paramUser)

                            // toastr.success(sendUserEmail)
                            //E:Send to user email
                        }

                        if(typeof response.admin != 'undefined')
                        {
                            //S:Send to admin email
                            let toAdmin     = response.admin.to
                            let adminData   = response.admin.param

                            let paramAdmin = {
                                                'to'        : toAdmin,
                                                'data'      : adminData,
                                                'file_name' : response.admin.file_name,
                                                'from'      : `eleave@elabram.com`,
                                                'from_name' : `E-LEAVE - ELABRAM`,
                                                'bcc'       : `kartaterazu27@gmail.com`,
                                                'subject'   : subject
                            }

                            let sendAdminEmail = setMail(paramAdmin)

                            // toastr.success(sendAdminEmail)
                            //E:Send to admin email
                        }
                    }
                    else
                    {
                        toastr.warning(response.message)
                    }
                }
            })
            .fail(function(error) {
                console.log(error);
                toastr.error("System failure, Please contact the Administrator")
            })
        }
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

//S:Show modal by actions button
function actions(id, type)
{
    $(`#${type} .btn-${type}`).attr('id', id)

    if(type == 'detailTicket')
    {
        showDetail(id)
    }
}
//E:Show modal by actions button

//S:show detail
function showDetail(id)
{
    let txtAreaId = $('#detailTicket textarea').attr('id')

    if (!CKEDITOR.instances[txtAreaId])
    {
        CKEDITOR.replace( txtAreaId, customTools )
    }

    $.ajax({
        url: `${apiUrl}eleave/ticketing/show-detail`,
        type: 'POST',
        dataType: 'json',
        data: {token: token, branch_id: branch_id, user_id: id_eleave, ticket_id: id},
        success: function(response)
        {
            if(response.response_code == 200)
            {
                //S:Set detial information value
                let ticketStatus    = response.data.result_header.status == 0 ? '' : response.data.result_header.status
                let assignToVal     = response.data.result_header.assigned_to
                let statusTicket    = '<span class="label label-sm label-warning">Open</span>'

                if(ticketStatus == 1)
                {
                    statusTicket = '<span class="label label-sm label-success">In Progress</span>'
                }
                else if(ticketStatus == 2)
                {
                    statusTicket = '<span class="label label-sm label-success">Finish</span>'
                }
                else if(ticketStatus == 3)
                {
                    statusTicket = '<span class="label label-sm label-info">Close</span>'
                }

                $(".change-status").hide()

                if(role == 'admin')
                {
                    $(".change-status").show()
                }

                $('.assTo').show('slow')

                if (ticketStatus != 1)
                {
                    $('.assTo').hide('slow')
                }

                if(response.data.role == 'admin')
                {
                    $("#detailTicket #assignBy").text(response.data.result_header.assigned_by_name)
                    $("#detailTicket #assignTo").text(response.data.result_header.assigned_to_name)
                }
                else
                {
                    $("#detailTicket #assignTo").text('Admin')
                }

                if(response.data.result_header.attachment == '' || response.data.result_header.attachment == '0')
                {
                    $("#detailTicket #attachment a").fadeOut('slow');
                }
                else
                {
                    let imgUrl = apiStorage+response.data.result_header.attachment
                    $("#detailTicket #attachment a").fadeIn('slow')
                    $("#detailTicket #attachment a").attr('data-img-url',imgUrl)
                }

                let totalDesc   = response.data.result_detail.length
                let description = response.data.result_detail
                let lastRow     = totalDesc - 1
                let lastReply   = description[lastRow]['user_name']

                $("#detailTicket h4.modal-title").text(response.data.result_header.subject)
                $("#detailTicket #ticket_id").text(response.data.result_header.ticket_id)
                $("#detailTicket #status").html(statusTicket)
                $("#detailTicket #created_date").text(response.data.result_header.add_date)
                $("#detailTicket #edit_date").text(response.data.result_header.edit_date)
                $("#detailTicket #last_reply").text(lastReply)
                $("#detailTicket #application").text(response.data.result_header.application_name)
                $("#detailTicket #priority").text(response.data.result_header.priority)
                //E:Set detial information value

                //S:Set description value
                var descData = ''

                if(totalDesc > 0)
                {
                    descData += '<span class="detail-title">Description</span>'

                    for(i=0;i<totalDesc;i++)
                    {
                        var issue = $("<textarea />").html(description[i].issue).text()


                        let userImgUrl = apiStorage+description[i].user_photo
                        let styles     = (i == lastRow) ? '' : 'border-bottom: 1px solid #9e9e9e;'
                        let liClass    = (i == 0) ? 'note note-info' : 'portlet'

                        descData += `<li class="${liClass}" style="${styles}">
                                        <img class="avatar" alt="${description[i].user_name}" src="${userImgUrl}">
                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">${description[i].user_name}</a>
                                            <span class="datetime">${description[i].update_date}</span>
                                            <span class="body">${issue}</span>
                                        </div>
                                    </li>`
                    }

                    $("#detailTicket ul.chats").html(descData)
                }
                //E:Set description value

                //S:Set assign to default value by ticket status
                let totalAssignTo   = response.data.get_assign.length
                let assignToArr     = response.data.get_assign

                $("#detailTicket #ticketStatus").val(ticketStatus)
                $("#detailTicket #oldTicketStatus").val(ticketStatus)
                $("#detailTicket #oldDeveloper").val(assignToVal)

                var assignToOpt = '<option value="">-- Choose Developer --</option>'

                if(totalAssignTo > 0)
                {
                    for(i=0;i<totalAssignTo;i++)
                    {
                        let selected = ''

                        if(assignToVal != 0 && assignToVal == assignToArr[i].user_id)
                        {
                            selected = 'selected="selected"'
                        }

                        assignToOpt += `<option value="${assignToArr[i].user_id}" ${selected}>${assignToArr[i].user_name}</option>`
                    }
                }

                $("#detailTicket #developer").html(assignToOpt)
                //E:Set assign to default value by ticket status

                //S:Show Ticketing log
                let totalLog   = response.data.result_log.length
                let logArr     = response.data.result_log

                var logData = ''

                if(totalLog > 0)
                {
                    for(i=0;i<totalLog;i++)
                    {
                        logData += `<li>${logArr[i].update_date} | ${logArr[i].description}</li>`
                    }
                }

                $("#detailTicket .ticket-log").html(logData)
                //E:Show Ticketing log
            }
        }
    })
}
//E:show detail

//S:Validate comment form
function validateComment()
{
    let ticketStatus      = $("#detailTicket #ticketStatus").val()
    let oldTicketStatus   = $("#detailTicket #oldTicketStatus").val()
    let developer         = $("#detailTicket #developer").val()
    let oldDeveloper      = $("#detailTicket #oldDeveloper").val()
    let txtAreaId         = $('#detailTicket textarea').attr('id')
    let txtAreaVal        = CKEDITOR.instances[txtAreaId].getData()

    if(role == 'admin')
    {
        if(ticketStatus == '' && txtAreaVal == '')
        {
            toastr.warning("Please Choose status or input your comment")

            return false
        }

        if(oldTicketStatus == '' && oldDeveloper == 0)
        {
            if(ticketStatus == 2)
            {
                toastr.warning("You can't finish new ticket, <br/>please assign the ticket to a developer")

                return false
            }
            else if(ticketStatus != '' && developer == '')
            {
                toastr.warning("Please choose a developer")

                return false
            }
            else if(txtAreaVal == '' && ticketStatus == '' && developer == '')
            {
                toastr.warning("Please input your comment")

                return false
            }
        }
        else
        {
            if(ticketStatus == oldTicketStatus && developer == oldDeveloper && txtAreaVal == '')
            {
                toastr.warning("Please input your comment")

                return false
            }
            else if(ticketStatus != '' && developer == '')
            {
                toastr.warning("Please choose a developer")

                return false
            }
        }
    }
    else
    {
        if(txtAreaVal == '')
        {
            toastr.warning("Please input your comment")

            return false
        }
    }

    return true
}
//E:Validate comment form