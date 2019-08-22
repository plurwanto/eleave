$(document).ready(function() {
	 //S: show datepicker in for Period Field
    $('#period').datepicker({
        format: 'MM - yyyy',
        clearBtn: true,
        autoclose: true,
        todayHighlight: true,
        viewMode: 1,
        minViewMode: 1
    })
    .on("change", function () {
        var value = $(this).val()

        $('.periodBox .month-year').hide()

        $('.DTFC_LeftWrapper #period').val(value)
        $('.periodBox .month-year').fadeIn('slow').text(value)

        // S:Change chart after pick a month and years
        if(hrId > 0)
        {
            showDivisionChart(value)
        }
        
        showEmployeePunctualityChart(value)
        showEmployeeLeaveChart(value)
        showEmployeeTimesheetChart(value)
        showEmployeeOvertimeChart(value)
        // E:Change chart after pick a month and years
    })
    .datepicker("setDate", new Date())
    //E: show datepicker in for Period Field

    $('.period-date-icon').on('click', function() {
        $('#period').datepicker("show");
    });
})

$(document).on('click', '.closeTable', function () {
    let div = this.id

    closeTable(div,'click')
})

function closeTable(div,events)
{
    $(`#${div}Box`).hide()

    $(`#${div}Box`).removeClass('col-lg-12 col-md-12 col-sm-12 col-xs-12').addClass('col-lg-6 col-md-6 col-sm-6 col-xs-6')
    $(`#${div}Box .chart-section`).removeClass('col-lg-6 col-md-6 col-sm-6 col-xs-6').addClass('col-lg-12 col-md-12 col-sm-12 col-xs-12 chart-section')
    $(`#${div}Box .table-section`).hide()
    $(`#${div}Box .${div}BoxInner`).css("border", "1px solid #e7ecf1")
    $(`#${div}Box`).fadeIn()
    $(`#${div}Box .${div}LegendList`).removeClass('activeLegend')

    if(typeof events != 'undefined')
    {
        $('html, body').animate({
            scrollTop: $(`#${div}Box`).parent().parent().offset().top - 75
        }, 2000)
    }
}