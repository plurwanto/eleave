var base_url = `${webUrl}`;
var url_photo = $('#url_photo').val();
var userId = $('#userId').val();

$.ajax({
    url: `${apiUrl}eleave/notify/getNotifyUser`,
    type: "POST",
    data: {"token": token},
    dataType: "JSON",
    success: function (data)
    {
        if (data.response_code == 200) {
            (data.total_all > 0 ? $('#total_all_user').html(data.total_all) : $('.amount_user').hide());
            $('#tot_data_employee').html(data.total_all);
            if (data.total_all > 0) {
                $('#list_all_user').html('');
                for (var i = 0; i < data.total_all; i++) {
                    html = '<li>'
                    html += '<a href="' + base_url + 'eleave/' + data.data_all[i]['link'] + '/' + data.data_all[i]['user_id'] + '/notification?source=' + data.data_all[i]['id'] + '">'
                    html += '<span class="photo">'
                    html += '<i class="fa fa-bullhorn large"></i> </span>'
                    html += '<span class="subject">'
                    html += '<span class="from">' + data.data_all[i]['type'] + ' </span>'
                    html += '<span class="time">' + data.data_all[i]['ago'] + ' </span>'
                    html += '</span>'
                    html += '<span class="message"> [Revision] ' + data.data_all[i]['tanggal'] + ' - ' + data.data_all[i]['description'].substring(0, 50) + ' </span>'
                    html += '</a>'
                    html += '</li>'
                    $('#list_all_user').append(html);
                }
            } else {
                $('#list_all_user').html('');
                $('.amount_user_lv').hide();
                $('#list_all_user').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
            }

            //for bubble notif menu
            if (data.total_claim > 0) {
                $('.nav-claim-badge').text(data.total_claim);
            } else {
                $('.nav-claim-badge').addClass('hidden');

            }

        } else {
            $('#list_all_user').html('');
            $('#list_all_user').append('<li><center>' + data.message + '</center></li>');
        }

    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error adding / update data');

    }
});


//// for approver
$.ajax({
    url: `${apiUrl}eleave/notify/getNotifyApproval`,
    type: "POST",
    data: {"token": token},
    dataType: "JSON",
    success: function (data)
    {
        if (data.response_code == 200) {
            //  $("#link_all").attr('href',"");
            //  $("#link_all").attr('href', `${webUrl}` + 'eleave/leaveApproval/' + userId + '/notification?source=all');
            (data.total_all > 0 ? $('#total_all').html(data.total_all) : $('.amount').hide());
            (data.total_ts > 0 ? $('.amount_ts').show() : $('.amount_ts').hide());
            (data.total_ot > 0 ? $('.amount_ot').show() : $('.amount_ot').hide());
            $('#tot_data').html(data.total_lv);
            if (data.total_lv > 0) {
                $('#list_lv').html('');
                for (var i = 0; i < data.total_lv; i++) {
                    html = '<li>'
                    html += '<a href="' + base_url + 'eleave/leaveApproval/' + data.data_lv[i]['user_id'] + '/notification?source=' + data.data_lv[i]['lv_id'] + '">'
                    html += '<span class="photo">'
                    html += '<img src="' + url_photo + '/' + data.data_lv[i]['user_photo'] + '" class="img-circle" alt=""> </span>'
                    html += '<span class="subject">'
                    html += '<span class="from">' + data.data_lv[i]['user_name'] + ' </span>'
                    html += '<span class="time">' + data.data_lv[i]['ago'] + ' </span>'
                    html += '</span>'
                    html += '<span class="message"> [' + data.data_lv[i]['lv_type'] + '] ' + data.data_lv[i]['lv_start_date'] + ' - ' + data.data_lv[i]['lv_end_date'].substring(0, 50) + ' </span>'
                    html += '</a>'
                    html += '</li>'
                    $('#list_lv').append(html);
                }

                link = '<a href="' + base_url + 'eleave/leaveApproval/' + userId + '/notification?source=all" class="notification-bottom">'
                link += '<div class="notification-bottom-content">'
                link += 'view all'
                link += '</div>'
                link += '</a>'
                $('#link_all').append(link);
            } else {
                $('#list_lv').html('');
                $('#link_all').html('');
                $('.amount_lv').hide();
                $('#list_lv').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
            }
        } else {
            $('#list_lv').html('');
            $('#list_lv').append('<li><center>' + data.message + '</center></li>');

            toastr.warning(data.message)

            if (data.response_code == 401)
            {
                setTimeout(function () {
                    location.href = `${webUrl}logout`
                }, 3000)
            }
        }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        toastr.warning('Something wrong with the application, <br/>Please Contact administrator')
    }
});

$("#list1").on("click", function () {
    $('#link_all').html('');
    $.ajax({
        url: `${apiUrl}eleave/notify/getNotifyApproval`,
        type: "POST",
        data: {"token": token},
        dataType: "JSON",
        success: function (data)
        {
            if (data.response_code == 200) {
                //   $("#link_all").attr('href', base_url + 'eleave/leaveApproval/' + userId + '/notification?source=all');
                $('#tot_data').html(data.total_lv);
                if (data.total_lv > 0) {
                    $('#list_lv').html('');
                    for (var i = 0; i < data.total_lv; i++) {
                        html = '<li>'
                        html += '<a href="' + base_url + 'eleave/leaveApproval/' + data.data_lv[i]['user_id'] + '/notification?source=' + data.data_lv[i]['lv_id'] + '">'
                        html += '<span class="photo">'
                        html += '<img src="' + url_photo + '/' + data.data_lv[i]['user_photo'] + '" class="img-circle" alt=""> </span>'
                        html += '<span class="subject">'
                        html += '<span class="from">' + data.data_lv[i]['user_name'] + ' </span>'
                        html += '<span class="time">' + data.data_lv[i]['ago'] + ' </span>'
                        html += '</span>'
                        html += '<span class="message"> [' + data.data_lv[i]['lv_type'] + '] ' + data.data_lv[i]['lv_start_date'] + ' - ' + data.data_lv[i]['lv_end_date'].substring(0, 50) + ' </span>'
                        html += '</a>'
                        html += '</li>'
                        $('#list_lv').append(html);
                    }
                    link = '<a href="' + base_url + 'eleave/leaveApproval/' + userId + '/notification?source=all" class="notification-bottom">'
                    link += '<div class="notification-bottom-content">'
                    link += 'view all'
                    link += '</div>'
                    link += '</a>'
                    $('#link_all').append(link);
                } else {
                    $('#list_lv').html('');
                    $('#link_all').html('');
                    $('.amount_lv').hide();
                    $('#list_lv').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
                }
            } else {
                $('#list_lv').html('');
                $('#list_lv').append('<li><center>' + data.message + '</center></li>');
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');

        }
    }
    );
});

$("#list2").on("click", function () {
    $('#link_all').html('');
    $.ajax({
        url: `${apiUrl}eleave/notify/getNotifyApproval`,
        type: "POST",
        data: {"token": token},
        dataType: "JSON",
        success: function (data)
        {
            if (data.response_code == 200) {

                //$("#link_all").attr('href', 'eleave/timesheetApproval/' + userId + '/notification?source=all');
                $('#tot_data').html(data.total_ts);
                if (data.total_ts > 0) {
                    $('#list_ts').html('');
                    for (var i = 0; i < data.total_ts; i++) {
                        html = '<li>'
                        html += '<a href="' + base_url + 'eleave/timesheetApproval/' + data.data_ts[i]['user_id'] + '/notification?source=' + data.data_ts[i]['ts_id'] + '">'
                        html += '<span class="photo">'
                        html += '<img src="' + url_photo + '/' + data.data_ts[i]['user_photo'] + '" class="img-circle" alt=""> </span>'
                        html += '<span class="subject">'
                        html += '<span class="from">' + data.data_ts[i]['user_name'] + ' </span>'
                        html += '<span class="time">' + data.data_ts[i]['ago'] + ' </span>'
                        html += '</span>'
                        html += '<span class="message"> [' + data.data_ts[i]['ts_type'] + '] ' + data.data_ts[i]['ts_date'] + ' - ' + data.data_ts[i]['ts_activity'].substring(0, 50) + ' </span>'
                        html += '</a>'
                        html += '</li>'
                        $('#list_ts').append(html);
                    }
                    link = '<a href="' + base_url + 'eleave/timesheetApproval/' + userId + '/notification?source=all" class="notification-bottom">'
                    link += '<div class="notification-bottom-content">'
                    link += 'view all'
                    link += '</div>'
                    link += '</a>'
                    $('#link_all').append(link);
                } else {
                    $('#list_ts').html('');
                    $('#link_all').html('');
                    $('.amount_ts').hide();
                    $('#list_ts').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
                }
            } else {
                $('#list_ts').html('');
                $('#list_ts').append('<li><center>' + data.message + '</center></li>');
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');

        }
    }
    );
});

$("#list3").on("click", function () {
    $('#link_all').html('');
    $.ajax({
        url: `${apiUrl}eleave/notify/getNotifyApproval`,
        type: "POST",
        data: {"token": token},
        dataType: "JSON",
        success: function (data)
        {
            if (data.response_code == 200) {

                $('#tot_data').html(data.total_ot);
                //$("#link_all").attr('href', 'eleave/overtimeApproval/' + userId + '/notification?source=all');
                if (data.total_ot > 0) {
                    $('#list_ot').html('');
                    for (var i = 0; i < data.total_ot; i++) {
                        html = '<li>'
                        html += '<a href="' + base_url + 'eleave/overtimeApproval/' + data.data_ot[i]['user_id'] + '/notification?source=' + data.data_ot[i]['ot_id'] + '">'
                        html += '<span class="photo">'
                        html += '<img src="' + url_photo + '/' + data.data_ot[i]['user_photo'] + '" class="img-circle" alt=""> </span>'
                        html += '<span class="subject">'
                        html += '<span class="from">' + data.data_ot[i]['user_name'] + ' </span>'
                        html += '<span class="time">' + data.data_ot[i]['ago'] + ' </span>'
                        html += '</span>'
                        html += '<span class="message"> [' + data.data_ot[i]['ot_date'] + '] ' + data.data_ot[i]['ot_description'].substring(0, 50) + ' </span>'
                        html += '</a>'
                        html += '</li>'
                        $('#list_ot').append(html);
                    }
                    link = '<a href="' + base_url + 'eleave/overtimeApproval/' + userId + '/notification?source=all" class="notification-bottom">'
                    link += '<div class="notification-bottom-content">'
                    link += 'view all'
                    link += '</div>'
                    link += '</a>'
                    $('#link_all').append(link);
                } else {
                    $('#list_ot').html('');
                    $('#link_all').html('');
                    $('.amount_ot').hide();
                    $('#list_ot').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
                }
            } else {
                $('#list_ot').html('');
                $('#list_ot').append('<li><center>' + data.message + '</center></li>');
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');

        }
    });
});

$(document).on('click', '.link', function () {
    var arr = this.id.split('-');
    $.ajax({
        url: `${webUrl}eleave/overtimeApproval/notification`,
        type: "POST",
        data: {ot_id: arr[0], user_id: arr[1], "_token": "<?=csrf_token()?>"},
        dataType: 'json',
        success: function (data)
        {
            alert(data);

        },
        error: function (data)
        {
            toastr.error(data.message);
        }
    });
});


//$.ajax({
//    url: `${apiUrl}eleave/notify/getNotifyUser`,
//    type: "POST",
//    data: {"token": token},
//    dataType: "JSON",
//    success: function (data)
//    {
//        if (data.response_code == 200) {
//            
//            $("#link_user_all").attr('href', '/eleave/leave/' + userId + '/notification?source=all');
//            (data.total_all > 0 ? $('#total_all_user').html(data.total_all) : $('.amount_user').hide());
//            (data.total_ts > 0 ? $('.amount_user_ts').show() : $('.amount_user_ts').hide());
//            (data.total_ot > 0 ? $('.amount_user_ot').show() : $('.amount_user_ot').hide());
//            $('#tot_data_employee').html(data.total_lv);
//            if (data.total_lv > 0) {
//                $('#list_user_lv').html('');
//                for (var i = 0; i < data.total_lv; i++) {
//                    html = '<li>'
//                    html += '<a href="' + base_url + '/eleave/leave/' + data.data_lv[i]['user_id'] + '/notification?source=' + data.data_lv[i]['lv_id'] + '">'
//                    html += '<span class="photo">'
//                    html += '<img src="' + base_url + '/' + data.data_lv[i]['user_photo'] + '" class="img-circle" alt=""> </span>'
//                    html += '<span class="subject">'
//                    html += '<span class="from">' + data.data_lv[i]['user_name'] + ' </span>'
//                    html += '<span class="time">' + data.data_lv[i]['ago'] + ' </span>'
//                    html += '</span>'
//                    html += '<span class="message"> [' + data.data_lv[i]['lv_type'] + '] ' + data.data_lv[i]['lv_start_date'] + ' - ' + data.data_lv[i]['lv_end_date'].substring(0, 50) + ' </span>'
//                    html += '</a>'
//                    html += '</li>'
//                    $('#list_user_lv').append(html);
//                }
//            } else {
//                $('#list_user_lv').html('');
//                $('.amount_user_lv').hide();
//                $('#list_user_lv').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
//            }
//        } else {
//            $('#list_user_lv').html('');
//            $('#list_user_lv').append('<li><center>' + data.message + '</center></li>');
//        }
//
//    },
//    error: function (jqXHR, textStatus, errorThrown)
//    {
//        alert('Error adding / update data');
//
//    }
//});

//$("#list_user_1").on("click", function () {
//    $.ajax({
//        url: `${apiUrl}eleave/notify/getNotifyUser`,
//        type: "POST",
//        data: {"token": token},
//        dataType: "JSON",
//        success: function (data)
//        {
//            if (data.response_code == 200) {
//                
//                $("#link_user_all").attr('href', '/eleave/leave/' + userId + '/notification?source=all');
//                $('#tot_data_employee').html(data.total_lv);
//                if (data.total_lv > 0) {
//                    $('#list_user_lv').html('');
//                    for (var i = 0; i < data.total_lv; i++) {
//                        html = '<li>'
//                        html += '<a href="' + base_url + '/eleave/leave/' + data.data_lv[i]['user_id'] + '/notification?source=' + data.data_lv[i]['lv_id'] + '">'
//                        html += '<span class="photo">'
//                        html += '<img src="' + base_url + '/' + data.data_lv[i]['user_photo'] + '" class="img-circle" alt=""> </span>'
//                        html += '<span class="subject">'
//                        html += '<span class="from">' + data.data_lv[i]['user_name'] + ' </span>'
//                        html += '<span class="time">' + data.data_lv[i]['ago'] + ' </span>'
//                        html += '</span>'
//                        html += '<span class="message"> [' + data.data_lv[i]['lv_type'] + '] ' + data.data_lv[i]['lv_start_date'] + ' - ' + data.data_lv[i]['lv_end_date'].substring(0, 50) + ' </span>'
//                        html += '</a>'
//                        html += '</li>'
//                        $('#list_user_lv').append(html);
//                    }
//                } else {
//                    $('#list_user_lv').html('');
//                    $('.amount_user_lv').hide();
//                    $('#list_user_lv').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
//                }
//            } else {
//                $('#list_user_lv').html('');
//                $('#list_user_lv').append('<li><center>' + data.message + '</center></li>');
//            }
//
//        },
//        error: function (jqXHR, textStatus, errorThrown)
//        {
//            alert('Error adding / update data');
//
//        }
//    }
//    );
//});
//
//$("#list_user_2").on("click", function () {
//    $.ajax({
//        url: `${apiUrl}eleave/notify/getNotifyUser`,
//        type: "POST",
//        data: {"token": token},
//        dataType: "JSON",
//        success: function (data)
//        {
//            if (data.response_code == 200) {
//                
//                $("#link_user_all").attr('href', '/eleave/timesheet/' + userId + '/notification?source=all');
//                $('#tot_data_employee').html(data.total_ts);
//                if (data.total_ts > 0) {
//                    $('#list_user_ts').html('');
//                    for (var i = 0; i < data.total_ts; i++) {
//                        html = '<li>'
//                        html += '<a href="' + base_url + '/eleave/timesheet/' + data.data_ts[i]['user_id'] + '/notification?source=' + data.data_ts[i]['ts_id'] + '">'
//                        html += '<span class="photo">'
//                        html += '<img src="' + base_url + '/' + data.data_ts[i]['user_photo'] + '" class="img-circle" alt=""> </span>'
//                        html += '<span class="subject">'
//                        html += '<span class="from">' + data.data_ts[i]['user_name'] + ' </span>'
//                        html += '<span class="time">' + data.data_ts[i]['ago'] + ' </span>'
//                        html += '</span>'
//                        html += '<span class="message"> [' + data.data_ts[i]['ts_type'] + '] ' + data.data_ts[i]['ts_date'] + ' - ' + data.data_ts[i]['ts_activity'].substring(0, 50) + ' </span>'
//                        html += '</a>'
//                        html += '</li>'
//                        $('#list_user_ts').append(html);
//                    }
//                } else {
//                    $('#list_user_ts').html('');
//                    $('.amount_user_ts').hide();
//                    $('#list_ts').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
//                }
//            } else {
//                $('#list_user_ts').html('');
//                $('#list_user_ts').append('<li><center>' + data.message + '</center></li>');
//            }
//
//        },
//        error: function (jqXHR, textStatus, errorThrown)
//        {
//            alert('Error adding / update data');
//
//        }
//    }
//    );
//});
//
//$("#list_user_3").on("click", function () {
//    $.ajax({
//        url: `${apiUrl}eleave/notify/getNotifyUser`,
//        type: "POST",
//        data: {"token": token},
//        dataType: "JSON",
//        success: function (data)
//        {
//            if (data.response_code == 200) {
//                
//                $('#tot_data_employee').html(data.total_ot);
//                $("#link_user_all").attr('href', '/eleave/overtime/' + userId + '/notification?source=all');
//                if (data.total_ot > 0) {
//                    $('#list_user_ot').html('');
//                    for (var i = 0; i < data.total_ot; i++) {
//                        html = '<li>'
//                        html += '<a href="' + base_url + '/eleave/overtime/' + data.data_ot[i]['user_id'] + '/notification?source=' + data.data_ot[i]['ot_id'] + '">'
//                        html += '<span class="photo">'
//                        html += '<img src="' + base_url + '/' + data.data_ot[i]['user_photo'] + '" class="img-circle" alt=""> </span>'
//                        html += '<span class="subject">'
//                        html += '<span class="from">' + data.data_ot[i]['user_name'] + ' </span>'
//                        html += '<span class="time">' + data.data_ot[i]['ago'] + ' </span>'
//                        html += '</span>'
//                        html += '<span class="message"> [' + data.data_ot[i]['ot_date'] + '] ' + data.data_ot[i]['ot_description'].substring(0, 50) + ' </span>'
//                        html += '</a>'
//                        html += '</li>'
//                        $('#list_user_ot').append(html);
//                    }
//                } else {
//                    $('#list_user_ot').html('');
//                    $('.amount_user_ot').hide();
//                    $('#list_user_ot').append('<li><center style="padding: 20px;">You dont have notification</center></li>');
//                }
//            } else {
//                $('#list_user_ot').html('');
//                $('#list_user_ot').append('<li><center>' + data.message + '</center></li>');
//            }
//
//        },
//        error: function (jqXHR, textStatus, errorThrown)
//        {
//            alert('Error adding / update data');
//
//        }
//    });
//});