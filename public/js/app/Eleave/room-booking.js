var $allRoomTable
var $myRoomTable
var $select = $('select')

$(document).ready(function ()
{
    let user_id = document.getElementById('id_eleave').value

    //S:show all room booking data
    $allRoomTable = $('#allRoomTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${apiUrl}eleave/room-booking`,
            "dataType": "json",
            "type": "POST",
            "data": {
                        "token": document.getElementById('token').value,
                        "branch_id": document.getElementById('branch_id').value
            }
        },
        "columns": [
            {"data": "no", "orderable": false},
            {"data": "rb_status"},
            {"data": "room_name"},
            {"data": "rb_date"},
            {"data": "rb_time_in"},
            {"data": "rb_time_out"},
            {"data": "user_by"},
            {"data": "user_for"},
            {"data": "rb_desc"},
            {"data": "created_date"}
        ],
        "columnDefs":[
           {"orderData": 9, "targets": 9},
           {"visible": false, "targets":9}
        ],
        order: [[9, "desc"]],
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>"
    })

    $allRoomTable.columns().eq(0).each(function (colIdx)
    {
        $('input', $allRoomTable.column(colIdx).header()).on('keyup change', function () {
            $allRoomTable
                    .column(colIdx)
                    .search(this.value)
                    .draw();
        })
        $('input', $allRoomTable.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation();
        })
        $('select', $allRoomTable.column(colIdx).header()).on('change', function () {
            $allRoomTable
                    .column(colIdx)
                    .search(this.value)
                    .draw();
        })
        $('select', $allRoomTable.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation();
        })
    })

    //show datepicker in first column of all room booking data
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        autoclose: true,
        todayHighlight: true,
        // endDate: "1m"
    })
    .on("show", function () {
        var parent_scroll = $(this).attr('id')

        if (parent_scroll === 'all_room_date')
        {
            $('.datepicker-dropdown').css({
                top: 250.15,
                left: 426,
            })
        }
    })
    .on("change", function () {
        var value = $(this).val()

        $('.DTFC_LeftWrapper #all_room_date').val(value)
    })
    //E:show all room booking data

    //S:show my room booking data
    $myRoomTable = $('#myRoomTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${apiUrl}eleave/room-booking`,
            "dataType": "json",
            "type": "POST",
            "data": {
                        "token": document.getElementById('token').value,
                        "branch_id": document.getElementById('branch_id').value,
                        "user_id": document.getElementById('id_eleave').value
            }
        },
        "columns": [
            {"data": "no", "orderable": false},
            {"data": "rb_status"},
            {"data": "room_name"},
            {"data": "rb_date"},
            {"data": "rb_time_in"},
            {"data": "rb_time_out"},
            {"data": "user_by"},
            {"data": "user_for"},
            {"data": "rb_desc"},
            {"data": "created_date"},
            {"data": "action", "orderable": false},
        ],
        "columnDefs":[
           {"orderData": 9, "targets": 9},
           {"visible": false, "targets":9}
        ],
        order: [[9, "desc"]],
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>"
    })

    $myRoomTable.columns().eq(0).each(function (colIdx)
    {
        $('input', $myRoomTable.column(colIdx).header()).on('keyup change', function () {
            $myRoomTable
                    .column(colIdx)
                    .search(this.value)
                    .draw()
        })
        $('input', $myRoomTable.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation()
        })
        $('select', $myRoomTable.column(colIdx).header()).on('change', function () {
            $myRoomTable
                    .column(colIdx)
                    .search(this.value)
                    .draw()
        })
        $('select', $myRoomTable.column(colIdx).header()).on('click', function (e) {
            e.stopPropagation();
        })
    })

    //S:show datepicker in first column of all room booking data
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        autoclose: true,
        todayHighlight: true,
        // endDate: "1m"
    })
    .on("show", function () {
        var parent_scroll = $(this).attr('id')

        if (parent_scroll === 'my_room_date')
        {
            $('.datepicker-dropdown').css({
                top: 250.15,
                left: 426,
            })
        }
    })
    .on("change", function () {
        var value = $(this).val()

        $('.DTFC_LeftWrapper #my_room_date').val(value)
    })
    //E:show datepicker in first column of all room booking data

    //S:Multiple Select All Room Dropdown Status
    var $allMultiStatus = $('#allRoomTable select#allMultiStatus')

    $allMultiStatus.multipleSelect({
        filter: true,
        placeholder: '-- Select Status --',
        onClick: function(){
            var allStatusValue = $('select#allMultiStatus').val()

            if(allStatusValue != null)
            {
                $allRoomTable
                        .column(1)
                        .search(allStatusValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var allStatusValue = $('select#allMultiStatus').val()

            if(allStatusValue != null)
            {
                $allRoomTable
                        .column(1)
                        .search(allStatusValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select All Room Dropdown Status

    //S:Multiple Select All Room Dropdown Room
    var $allMultiRoom = $('#allRoomTable select#allMultiRoom')

    $allMultiRoom.multipleSelect({
        filter: true,
        placeholder: '-- Select Room --',
        onClick: function(){
            var allRoomValue = $('select#allMultiRoom').val()

            if(allRoomValue != null)
            {
                $allRoomTable
                        .column(2)
                        .search(allRoomValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var allRoomValue = $('select#allMultiRoom').val()

            if(allRoomValue != null)
            {
                $allRoomTable
                        .column(2)
                        .search(allRoomValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select All Room Dropdown Room

    //S:Multiple Select All Room Dropdown User By
    var $allMultiReqBy = $('#allRoomTable select#allMultiReqBy')

    $allMultiReqBy.multipleSelect({
        filter: true,
        placeholder: '-- Select Request By --',
        onClick: function(){
            var allMultiReqByValue = $('select#allMultiReqBy').val()

            if(allMultiReqByValue != null)
            {
                $allRoomTable
                        .column(6)
                        .search(allMultiReqByValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var allMultiReqByValue = $('select#allMultiReqBy').val()

            if(allMultiReqByValue != null)
            {
                $allRoomTable
                        .column(6)
                        .search(allMultiReqByValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select All Room Dropdown User By

    //S:Multiple Select All Room Dropdown User For
    var $allMultiReqFor = $('#allRoomTable select#allMultiReqFor')

    $allMultiReqFor.multipleSelect({
        filter: true,
        placeholder: '-- Select Request For --',
        onClick: function(){
            var allMultiReqForValue = $('select#allMultiReqFor').val()

            if(allMultiReqForValue != null)
            {
                $allRoomTable
                        .column(7)
                        .search(allMultiReqForValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var allMultiReqForValue = $('select#allMultiReqFor').val()

            if(allMultiReqForValue != null)
            {
                $allRoomTable
                        .column(7)
                        .search(allMultiReqForValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select All Room Dropdown User For

    //S:Multiple Select My Room Dropdown Status
    var $myMultiStatus = $('#myRoomTable select#myMultiStatus')

    $myMultiStatus.multipleSelect({
        filter: true,
        placeholder: '-- Select Status --',
        onClick: function(){
            var myStatusValue = $('select#myMultiStatus').val()

            if(myStatusValue != null)
            {
                $myRoomTable
                        .column(1)
                        .search(myStatusValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var myStatusValue = $('select#myMultiStatus').val()

            if(myStatusValue != null)
            {
                $myRoomTable
                        .column(1)
                        .search(myStatusValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select My Room Dropdown Status

    //S:Multiple Select My Room Dropdown Room
    var $myMultiRoom = $('#myRoomTable select#myMultiRoom')

    $myMultiRoom.multipleSelect({
        filter: true,
        placeholder: '-- Select Room --',
        onClick: function(){
            var myRoomValue = $('select#myMultiRoom').val()

            if(myRoomValue != null)
            {
                $myRoomTable
                        .column(2)
                        .search(myRoomValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var myRoomValue = $('select#myMultiRoom').val()

            if(myRoomValue != null)
            {
                $myRoomTable
                        .column(2)
                        .search(myRoomValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select My Room Dropdown Room

    //S:Multiple Select My Room Dropdown User By
    var $myMultiReqBy = $('#myRoomTable select#myMultiReqBy')

    $myMultiReqBy.multipleSelect({
        filter: true,
        placeholder: '-- Select User By --',
        onClick: function(){
            var myMultiReqByValue = $('select#myMultiReqBy').val()

            if(myMultiReqByValue != null)
            {
                $myRoomTable
                        .column(6)
                        .search(myMultiReqByValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var myMultiReqByValue = $('select#myMultiReqBy').val()

            if(myMultiReqByValue != null)
            {
                $myRoomTable
                        .column(6)
                        .search(myMultiReqByValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select My Room Dropdown User By

    //S:Multiple Select My Room Dropdown User For
    var $myMultiReqFor = $('#myRoomTable select#myMultiReqFor')

    $myMultiReqFor.multipleSelect({
        filter: true,
        placeholder: '-- Select User For --',
        onClick: function(){
            var myMultiReqForValue = $('select#myMultiReqFor').val()

            if(myMultiReqForValue != null)
            {
                $myRoomTable
                        .column(7)
                        .search(myMultiReqForValue)
                        .draw();
            }
        },
        onCheckAll: function(){
            var myMultiReqForValue = $('select#myMultiReqFor').val()

            if(myMultiReqForValue != null)
            {
                $myRoomTable
                        .column(7)
                        .search(myMultiReqForValue)
                        .draw();
            }
        }
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })
    //E:Multiple Select My Room Dropdown User For

    //S:validate input form to show room list and description
    $("#new-book #revDate").change(function()
    {
        $(".after-date").hide()

        let revDate     = $("#new-book #revDate").val()
        let startTime   = $("#new-book #startTime").val()
        let endTime     = $("#new-book #endTime").val()
        let token       = document.getElementById('token').value
        let branch_id   = document.getElementById('branch_id').value

        if(revDate != "" && startTime != "" && endTime != "")
        {
            let param = {revDate: revDate, startTime: startTime, endTime: endTime, token: token, branch_id: branch_id}

            getAvailableRoom(param)
        }
    })
    //E:validate input form to show room list and description

    //S:show datepicker in new-book modal to revision date input form
    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

    $('#new-book #revDate').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        autoclose: true,
        todayHighlight: true,
        startDate: 'today',
        endDate: '+6d',
        // endDate: "1m"
    })
    .on("show", function () {
        $('.datepicker-dropdown').css({
                top: 165,
                left: 399,
        })
    })
    .on("change", function () {
        var selectedDate = $(this).datepicker('getDate')
        var now = new Date()
        now.setHours(0,0,0,0)

        if(selectedDate < now)
        {
            toastr.warning("You can't choose past date")
            $(this).datepicker('setDate', now)

            return false
        }
        else
        {
            var value = $(this).val()

            $('.DTFC_LeftWrapper #revDate').val(value)
        }

        //S:Validate startTime
        let today         = new Date()
        let valDateTime   = `${value} ${today.getHours()}:${today.getMinutes()}`
        let startTime     = new Date(valDateTime)

        checkStartTime(startTime.getHours(),startTime.getMinutes(),valDateTime)
    })
    //E:show datepicker in new-book modal to revision date input form

    $('.timepicker').timepicker({disableFocus: true, showSeconds: false, showMeridian: false, minuteStep : 15})
    $('.timepicker').val('')

    //S:Get All User By Branch ID
    var $multiReqFor = $('#new-book select#multiReqFor')

    $multiReqFor.multipleSelect({
        filter: true,
        selectAll: false,
        placeholder: '-- Choose Request For --',
        single: true
    })
    .next().find('.ms-drop li').each(function () {
        $(this).attr('title', $(this).text())
    })

    $multiReqFor.multipleSelect('setSelects',[user_id])
    //E:Get All User By Branch ID

    $('#startTime').on('hide.timepicker', function(e) {
        checkStartTime(e.time.hours, e.time.minutes, $("#revDate").val())
    })

    $('#endTime').on('hide.timepicker', function(e) {
        //S:Validate revision date, start time, and end time input form
        let revDate     = $("#new-book #revDate").val()
        let startTime   = $("#new-book #startTime").val()
        let endTime     = $("#new-book #endTime").val()
        let token       = document.getElementById('token').value
        let branch_id   = document.getElementById('branch_id').value

        let splitStartTime  = startTime.split(':')
        let splitEndTime    = endTime.split(':')

        let hStartTime  = parseInt(splitStartTime[0])
        let mStartTime  = parseInt(splitStartTime[1])

        let hEndTime    = parseInt(splitEndTime[0])
        let mEndTime    = parseInt(splitEndTime[0])

        if(hEndTime < hStartTime)
        {
            let mEndtime = mStartTime + 15

            if(mEndtime > 60)
            {
                mEndtime = mEndtime - 60
                hStartTime += 1
            }

            if(mEndtime == 60)
            {
                mEndtime = "00"
                hStartTime += 1
            }

            if(mEndtime < 10)
            {
                mEndtime = `0${mEndtime}`
            }

            let newEndTime = `${hStartTime}:${mEndtime}`
            
            $('#endTime').val(newEndTime)
        }

        if(hEndTime == hStartTime)
        {
            let mEndtime = mStartTime + 15

            if(mEndtime > 60)
            {
                mEndtime = mEndtime - 60
                hStartTime += 1
            }

            if(mEndtime == 60)
            {
                mEndtime = "00"
                hStartTime += 1
            }

            if(mEndtime < 10)
            {
                mEndtime = `0${mEndtime}`
            }

            let newEndTime = `${hStartTime}:${mEndtime}`
            
            $('#endTime').val(newEndTime)
        }

        if(revDate != "" && startTime != "" && endTime != "")
        {
            let param = {revDate: revDate, startTime: startTime, endTime: endTime, token: token, branch_id: branch_id}

            getAvailableRoom(param)
            $multiReqFor.multipleSelect('setSelects',[user_id])
        }
        //E:Validate revision date, start time, and end time input form
    });

    //S:Save Booking Room
    $("#new-book .btn-add-room").click(function() {
        if(validated())
        {
            let token   = document.getElementById('token').value
            let user    = document.getElementById('id_eleave').value

            let formData = $('#book-room').serialize()+'&token='+token+'&user='+user

            $.ajax({
                url: `${apiUrl}eleave/room-booking/booking`,
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response.response_code == 200)
                    {
                        toastr.success("Success to book the room")
                        $("#new-book").modal('hide')

                        $allRoomTable.ajax.reload()
                        $myRoomTable.ajax.reload()
                    }
                    else
                    {
                        toastr.error(response.message)
                    }
                }
            })
            .fail(function(error) {
                console.log(error);
                toastr.error("System failure, Please contact the Administrator")
            })
            
        }
    })
    //E:Save Booking Room

    $(".btn-book-form").click(function() {
        $("#book-room").trigger("reset")
        // $("#multiReqFor").val('')
        $("#new-book .ms-drop li").removeClass('selected')
        $(".after-date").hide()
    })

    $(".btn-refresh").click(function() {
        if($(this).attr('id') == 'all')
        {
            $allMultiStatus.multipleSelect('setSelects',[])
            $allMultiRoom.multipleSelect('setSelects',[])
            $allMultiReqBy.multipleSelect('setSelects',[])
            $allMultiReqFor.multipleSelect('setSelects',[])
            $("#all_room_date").val('').keyup()
            $("#allDesc").val('').keyup()
            $allRoomTable.ajax.reload()
        }
        else
        {
            $myMultiStatus.multipleSelect('setSelects',[])
            $myMultiRoom.multipleSelect('setSelects',[])
            $myMultiReqBy.multipleSelect('setSelects',[])
            $myMultiReqFor.multipleSelect('setSelects',[])
            $("#my_room_date").val('').keyup()
            $("#myDesc").val('').keyup()
            $myRoomTable.ajax.load()
        }
    });

    $(".btn-actions").click(function() {
        let rbId        = $(this).attr('id')
        let action      = $(this).attr('data-actions')
        let token       = document.getElementById('token').value
        let actionWords = ''

        switch (action)
        {
            case 'cancel':
                actionWords = 'Cancel'
                break;
            case 'check_in':
                actionWords = 'Check In'
                break;
            case 'check_out':
                actionWords = 'Check Out'
                break;
        }

        $.ajax({
            url: `${apiUrl}eleave/room-booking/change-room-status`,
            type: 'POST',
            dataType: 'json',
            data: {rb_id: rbId, token: token, action: action},
            success: function (response) {
                if(response.response_code == 200)
                {
                    toastr.success(response.message)
                    $(`#${action}`).modal('hide')
                    $allRoomTable.ajax.reload()
                    $myRoomTable.ajax.reload()
                }
                else
                {
                    toastr.warning(`Failed to ${actionWords} the room`)
                }
            }
        })
        .fail(function() {
            toastr.error("System failure, Please contact the Administrator")
        })
    });
})

function validated()
{
    var selectedDate = $('#revDate').datepicker('getDate')
    var now = new Date()
    now.setHours(0,0,0,0)

    if($("#revDate").val() == '')
    {
        toastr.warning("Please Choose Revision date")

        return false
    }
    
    if(selectedDate < now)
    {
        toastr.warning("You can't choose past date")
        $("#revDate").datepicker('setDate', now)

        return false
    }
    
    if($("#startTime").val() == '')
    {
        toastr.warning("Please Choose Start Time")

        return false
    }
    
    if($("#endTime").val() == '')
    {
        toastr.warning("Please Choose End Time")

        return false
    }
    
    if($("#multiReqFor").val() == '')
    {
        toastr.warning("Please Choose Request For")

        return false
    }
    
    if($("#room").val() == '')
    {
        toastr.warning("Please Choose a Room")

        return false
    }
    
    if($("#description").val() == '')
    {
        toastr.warning("Please fill in Description")

        return false
    }

    return true
}

function getAvailableRoom(param)
{
    $.ajax({
        url: `${apiUrl}eleave/room-booking/get-available-room`,
        type: 'POST',
        dataType: 'json',
        data: param,
        success: function(response) {
            if(response.response_code == 200)
            {
                let roomList = '<option value="">-- Choose Room --</option>'

                $.each(response.data, function(index, val)
                {
                    roomList += `<option value="${val.room_id}">${val.room_name}</option>`
                });

                $("#new-book #room").html(roomList)
                $(".after-date").show()
            }
            else
            {
                $(".after-date").hide()
                toastr.warning(response.message)
            }
        }
    })
    .fail(function() {
        toastr.error("System failure, Please contact the Administrator")
    })
}

function actions(id, type)
{
    $(`#${type} .btn-${type}`).attr('id', id)
}

function checkStartTime(startHours,startMinutes,revDates)
{
    let fullCurrDate    = new Date()
    let revDate         = new Date(revDates)
    let currMinutes     = fullCurrDate.getMinutes()
    let currHour        = fullCurrDate.getHours()
    let h               = startHours
    let endTime         = $("#new-book #endTime").val()
    let splitEndTime    = endTime.split(':')
    let hEndTime        = parseInt(splitEndTime[0])
    let mEndTime        = parseInt(splitEndTime[0])
    
    currHour = (h > currHour) ? h : currHour
    
    if(revDate.getDate() == fullCurrDate.getDate() && revDate.getMonth() == fullCurrDate.getMonth() && revDate.getFullYear() == fullCurrDate.getFullYear())
    {
        let currTime = `${currHour}:${startMinutes}`

        $('#startTime').val(currTime)
        $('#startTime').timepicker('setTime', currTime)
    }

    if(h < currHour)
    {
        if(revDate.getDate() == fullCurrDate.getDate() && revDate.getMonth() == fullCurrDate.getMonth() && revDate.getFullYear() == fullCurrDate.getFullYear())
        {
            let currTime = `${currHour}:${currMinutes}`

            $('#startTime').val(currTime)
            $('#startTime').timepicker('setTime', currTime)
        }
        else
        {
            currHour = h
        }
    }

    let m = currMinutes + 15

    if(h == currHour)
    {
        m = startMinutes + 15

        if(m < 10)
        {
            m = `0${m}`
        }
    }

    if (m == 60)
    {
        m = "00"
        currHour += 1
    }

    if(m > 60)
    {
        m = m - 60

        if(m < 10)
        {
            m = `0${m}`
        }

        currHour += 1
    }

    let newTime = currHour + ":" + m

    $('#endTime').val(newTime)
}
