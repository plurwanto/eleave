@extends('Eleave.layout.main')

@section('title','Eleave | Holiday List')

@section('style')

@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light calendar bordered">
            <div class="portlet-title ">
            </div>
            <div class="portlet-body">
                <div id="calendar"></div>
            </div>
            <span class='label' id="detail"></span><br>
            <br>
            <span class='label' style="background-color:#36D7B7;">ESI</span>
            <span class='label' style="background-color:#3598DC;">ESSB</span>
            <span class='label' style="background-color:#F4D03F;">EST</span>
            <span class='label' style="background-color:#D91E18;">PTES</span>
        </div>
        <!-- END PORTLET--></div>
</div>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-plane"></i>Holiday List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">
                        <a class="btn btn-default btn-circle btn-sm" tabindex="0" onclick="add_item()"><i class="fa fa-plus"></i> Add Holiday</a>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-condensed" width="100%" id="usertable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name<br><div class="filter-wrapper"></div></th>
                        <th>Branch<br>
                            <?php if (session('is_hr') == 0) {?>
                                <select class="filter form-control" style="width:100px" id="slt_branch" name="slt_branch">
                                    <option value=""></option>
                                    <?php
                                    if (!empty($branch)) {
                                        foreach ($branch as $value) {
                                            echo "<option value='" . $value['branch_id'] . "'>" . $value['branch_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            <?php }?>
                        </th>
                        <th>Holiday Date<br><div class="filter-wrapper-date"></div></th>
                        <th>Year<br>
                            <select class="filter form-control" style="width:100px" id="slt_year" name="slt_year">
                                <option value="" ></option>
                                <?php
                                $lastYear = (int) date('Y');
                                for ($i = 2010; $i <= $lastYear; $i++) {
                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form" action="#" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Add Form</h3>
                </div>
                <div class="modal-body form">
                    <input type="hidden" name="holiday_id" id="holiday_id">
                    <input type="hidden" id="txt_branch" value="" name="txt_branch">
                    <div class="form-body">
                        <div class="form-group has-error">
                            <label class="col-md-3 control-label">Branch</label>
                            <div class="col-md-4">
                                <select class="form-control" name="branch_id" id="branch_id">
                                    <option value="">-- Choose Branch --</option>
                                    <?php
                                    if (!empty($branch)) {
                                        foreach ($branch as $value) {
                                            echo "<option value='" . $value['branch_id'] . "'>" . $value['branch_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group has-error">
                            <label class="col-md-3 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Enter name" id="hol_name" name="hol_name" maxlength="50">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Holiday Date</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control holidaypicker" placeholder="Enter holiday date" name="hol_date" id="hol_date">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-circle grey-salsa btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnSave" class="btn btn-circle green">&nbsp;Save&nbsp;</button>
                </div>
                {{ csrf_field() }}
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
@endsection

@section('script')
<script type="text/javascript">
    var $table;
    $(document).ready(function () {
        calendar();
        
        $("input").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function () {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html('<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-point").html('<input type="text" class="filter form-control" style="width:70px;" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-date").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date" style="width:100px;" placeholder="Filter ' + title + '" />');
        });
        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": `${webUrl}eleave/holiday/getdata`,
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?=csrf_token()?>"},
                error: function (jqXhr, textStatus, errorThrown) //jqXHR, textStatus, errorThrown
                {
                    if (jqXhr.status == 419) {//if you get 419 error / page expired
                        toastr.warning("page expired, please login to continue.");
                        location.reload(); 
                    }
                }
            },
            dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "columns": [
                {"data": "no", "searchable": false, "orderable": false},
                {"data": "hol_name"},
                {"data": "branch_name"},
                {"data": "hol_date_table"},
                {"data": "year"},
                {"data": "action", "searchable": false, "orderable": false},
            ],
            order: [[2, "desc"], [3, "desc"]],
        });
        $table.columns().eq(0).each(function (colIdx) {
            $('input', $table.column(colIdx).header()).on('keyup change', function () {
                $table
                        .column(colIdx)
                        .search(this.value)
                        .draw();
            });
            $('input', $table.column(colIdx).header()).on('click', function (e) {
                e.stopPropagation();
            });
            $('select', $table.column(colIdx).header()).on('change', function () {
                $table
                        .column(colIdx)
                        .search(this.value)
                        .draw();
            });
            $('select', $table.column(colIdx).header()).on('click', function (e) {
                e.stopPropagation();
            });
        });
    });
    </script>


<script>
    var save_method;
    $("#btnSave").click(function (e) {

        var url;
        if (save_method == 'add') {
            url = `${webUrl}eleave/holiday/insert`;
        } else {
            url = `${webUrl}eleave/holiday/update`;
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                if (data.status)
                {
                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                    $('#modal_form').modal('hide');
                    $table.ajax.reload();
                    toastr.success(data.message);
                } else {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').closest('.form-group').removeClass('has-success').addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                        $('[name="' + data.inputerror[0] + '"]').focus();
                        e.preventDefault();
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    });
    function add_item()
    {
        $('#form')[0].reset();
        save_method = 'add';
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Form');
        $('input[name="hol_name"]').focus();
        $('[name="hol_date"]').datepicker({format: 'yyyy-mm-dd',autoclose: true,}).datepicker("setDate", new date());
    }

    function edit_item(id)
    {
        $('#form')[0].reset();
        $('[name="hol_date"]').val("");
        save_method = 'update';
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url: `${webUrl}eleave/holiday/{id}/edit`,
            type: "GET",
            data: {id: id, "_token": "{{ csrf_token() }}"},
            dataType: "JSON",
            success: function (response)
            {
                if (response.status == true) {
                    $('[name="holiday_id"]').val(response[0].hol_id);
                    $('[name="branch_id"]').val(response[0].branch_id);
                    $('[name="hol_name"]').val(response[0].hol_name);
                    $('[name="hol_date"]').val(response[0].hol_date);
                    $('[name="hol_date"]').datepicker({format: 'yyyy-mm-dd',autoclose: true,}).datepicker("setDate", response[0].hol_date);
                    $('#modal_form').modal('show');
                    $('.modal-title').text('Edit item');
                } else {
                    toastr.warning(response.msg);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    $(document).on('click', '.reject', function () {
        if (confirm("Are you sure delete ?  "))
        {
            var $button = $(this);
            var id = this.id.split('-').pop();
            $.ajax({
                type: 'POST',
                url: `${webUrl}eleave/holiday/delete`,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: id, "_token": "{{ csrf_token() }}"},
                success: function (data) {
                    if (data.status == true) {
                        $table.row($button.parents('tr')).remove().draw();
                        toastr.success(data.message);
                    }
                },
                error: function (data)
                {
                    toastr.error(data.message);
                }
            });
        }
    });
    function setdatepicker() {
        $('.datepicker').datepicker({
            format: 'dd M yy',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
        });
    }

    
</script>

<script>
    toastr.options = {
        "closeButton": true,
    }
    ;
            @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type){
    case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
            case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
            case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
            case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
<script>
    function calendar(){
    //// CALENDAR
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var h = {};
    if ($('#calendar').width() <= 400) {

    $('#calendar').addClass("mobile");
    h = {

    left: 'title, prev, next',
            center: '',
            right: 'today,month'

    };
    } else {

    $('#calendar').removeClass("mobile");
    if (App.isRTL()) {

    h = {

    right: 'title',
            center: '',
            left: 'prev,next,today,month'

    };
    } else {

    h = {

    left: 'title',
            center: '',
            right: 'prev,next,today,month'

    };
    }

    }



    $('#calendar').fullCalendar('destroy'); // destroy the calendar

    $('#calendar').fullCalendar({ //re-initialize the calendar

    disableDragging: true,
            header: h,
            editable: false,
            fixedWeekCount: false,
            aspectRatio: 3,
            events: [

<?php
  if (!empty($holiday)){  
    foreach ($holiday as $item) {?>

                {

                title: "<?=$item->hol_name?>",
                        start: '<?=$item->hol_date?>',
                        allDay: true,
    <?php if ($item->branch_id == 1) {?>

                    backgroundColor: '#3598DC'

    <?php } elseif ($item->branch_id == 2) {?>

                    backgroundColor: '#D91E18'

    <?php } elseif ($item->branch_id == 3) {?>

                    backgroundColor: '#36D7B7'

    <?php } else {?>

                    backgroundColor: '#F4D03F'

    <?php }?>

                //1BBC9B

                },
    <?php }}?>

            /*{
             
             title: 'Click for Google',
             
             start: new Date(y, m, 28),
             
             end: new Date(y, m, 29),
             
             backgroundColor: App.getBrandColor('yellow'),
             
             url: 'http://google.com/'
             
             }*/

            ],
            eventMouseover: function(calEvent, jsEvent, view) {

            $('#detail').html(calEvent.title);
            $('#detail').css('background-color', calEvent.backgroundColor);
            },
            eventMouseout: function(calEvent, jsEvent, view) {

            $('#detail').html("");
            }

    });
    }
</script>
@endsection