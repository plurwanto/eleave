@extends('Eleave.layout.main')

@section('title','Eleave | Attendance All Employee')

@section('content')
<div class="row">
    <div class="col-md-6">
        <input type="hidden" name="txt_year" id="txt_year" value="{{$year}}">
        <a href="{{ URL::to('eleave/attendance/index/'.($year - 1)) }}" class="btn default red-stripe"
           style="margin-right:15px;"> <i class="fa fa-angle-double-left"></i> </a>
        <a href="" class="btn default green-stripe" style="margin-right:15px;"> {{$year}} </a>
        <a href="{{ URL::to('eleave/attendance/index/'.($year + 1)) }}" class="btn default blue-stripe"> <i
                class="fa fa-angle-double-right"></i> </a>
    </div>
    <br><br>
</div>
<div class="row">
    <br>
    <div class="col-md-6"><a href="{{url('eleave/attendance/excel_attendance/'.$year)}}" id="btn_filter"
                             class="btn red">Download Attendance</a><br><br></div>
</div>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-calendar-times-o"></i>Attendance Data
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">
                        <a class="btn btn-default btn-circle btn-sm" tabindex="0" onclick="show_upload()"><i
                                class="fa fa-plus"></i> Upload Attendance</a>
                    </div>
                </div>
            </div>
            <input type="hidden" name="user_id" id="user_id" value="">
            <table class="table table-striped table-bordered table-condensed nowrap" width="100%"
                   id="usertable">
                <thead>
                    <tr>
                        <th style="width: 40px">No</th>
                        <th style="width: 60px; text-align: left;">Branch<br />
                            <select class="filter form-control" style="width:60px" id="slt_branch" name="slt_branch">
                                <option value="">- Choose </option>
                                <?php
                                if (!empty($branch)) {
                                    foreach ($branch as $value) {
                                        echo "<option value='" . $value['branch_id'] . "'>" . $value['branch_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </th>
                        <th style="width: 110px">Employee<br />
                            <div class="filter-wrapper"></div>
                        </th>
                        <th style="width: 90px">Date<br />
                            <div class="filter-wrapper-date-start"></div>
                        </th>
                        <th style="width:60px">Day<br />
                            <div class="filter-wrapper-day"></div>
                        </th>
                        <th style="width: 60px; text-align: left;">Time In<br />
                            <div class="filter-wrapper-small"></div>
                        </th>
                        <th style="width: 60px; text-align: left;">Time Out<br />
                            <div class="filter-wrapper-small"></div>
                        </th>
                        <th style="width: 90px">Total Time<br />
                            <div class="filter-70"></div>
                        </th>
                        <th style="width: 60px; text-align: left;">Late Point<br />
                            <div class="filter-70"></div>
                        </th>

                        <th style="width: 40px">Month<br />
                            <select class="filter form-control" name="slt_month" id="slt_month">
                                <option value="">All Month</option>
                                <?php
                                $getMonthVal = $getMonthName = [];
                                foreach (range(1, 12) as $m) {
                                    $getMonthVal = date('m', mktime(0, 0, 0, $m, 1));
                                    $getMonthName = date('F', mktime(0, 0, 0, $m, 1));
                                    echo "<option value='" . $getMonthVal . "'>" . $getMonthName . "</option>";
                                }
                                ?>
                            </select>
                        </th>
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
            <form id="form" action="#" enctype="multipart/form-data" class="form-horizontal">
                <input type="hidden" name="token" id="token" value="{{ session('token') }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Upload Finger Print Form</h3>
                </div>
                <div class="modal-body form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">File Name</label>
                            <div class="col-md-3">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="input-group input-large">
                                        <div class="form-control uneditable-input input-fixed input-medium"
                                             data-trigger="fileinput">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                            <span class="fileinput-filename"> </span>
                                        </div>
                                        <span class="input-group-addon btn default btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" id="finger_file" name="finger_file" accept=".csv"
                                                   onchange='triggerValidation(this)'> </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists"
                                           data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p></p>
                        <div class="note note-info">
                            <p> Please make sure that the file uploaded is within 1 week range maximum and in a current year. </p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-circle grey-salsa btn-outline"
                            data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnUpload" class="btn btn-circle green">&nbsp;Upload&nbsp;</button>
                </div>
                {{ csrf_field() }}
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
@endsection
@section('script')
@include('Eleave/notification')

<script type="text/javascript">
    var $table;
    var year = $('#txt_year').val();
    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-70").html(
                    '<input type="text" class="filter form-control"  placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-small").html(
                    '<input type="text" class="filter form-control"  placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-date-start").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date"placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-day").html(
                    '<select class="filter form-control" >\n\
                        <option value="">- Choose </option>\n\
                        <option value="0">Monday</option>\n\
                        <option value="1">Tuesday</option>\n\
                        <option value="2">Wednesday</option>\n\
                        <option value="3">Thursday</option>\n\
                        <option value="4">Friday</option>\n\
                        <option value="5">Saturday</option>\n\
                     </select>'
                    );
        });
        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": `${webUrl}eleave/attendance/getAttendanceAllEmployee`,
                "dataType": "json",
                "type": "POST",
                "data": {
                    "_token": "<?=csrf_token()?>",
                    year: year
                },
                error: function (jqXhr, textStatus, errorThrown) //jqXHR, textStatus, errorThrown
                {
                    if (jqXhr.status == 419) {//if you get 419 error / page expired
                        toastr.warning("page expired, please login to continue.");
                        location.reload(); 
                    }
                }
            },
            dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "columns": [{
                    "data": "no",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "branch_name",
                    "className": "text-center"
                },
                {
                    "data": "user_name",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "at_date"
                },
                {
                    "data": "day",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "at_time_in",
                    "searchable": false,
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "at_time_out",
                    "searchable": false,
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "at_total_time",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "at_late_point",
                    "searchable": false,
                    "orderable": false,
                    "className": "text-right"
                },
                {
                    "data": "month",
                    "searchable": false,
                    "orderable": false
                }
            ],
            order: [
                [1, "asc"],
                [2, "asc"],
                [3, "desc"]
            ],

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

    function setdatepicker() {
        $('.datepicker').datepicker({
            format: 'dd M yy',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
        })
                .on("change", function () {
                    var value = $(this).val();
                    var parent_scroll = $(this).parent().attr('class');
                    if (parent_scroll == 'filter-wrapper-date-start') {
                        $('.DTFC_LeftWrapper .filter-wrapper-date-start #src_date').val(value);
                    }
                });
    }

    $("#btn_filter").click(function () {
        NProgress.start();
        setTimeout(function () {
            NProgress.done();
            $('.fade').removeClass('out');
        }, 1000);
    });
</script>

<script>
    function show_upload() {
        save_method = 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Upload Finger Print Form');

    }

    $("#btnUpload").click(function () {
        if ($('#finger_file').val() == "") {
            toastr.error('required file');
            return false;
        }

        var url;

        url = `${webUrl}eleave/attendance/finger_upload`;
        //url = `${apiUrl}eleave/attendance/upload_finger`;
        NProgress.inc();


        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData($('#form')[0]),
            beforeSend: function () {
                $.blockUI();
                //showLoadingScreen();
                $('#modal_form').modal('hide');
            },
            success: function (data) {
                if (data.status == true) {
                    $table.ajax.reload();
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnUpload').text('upload'); //change button text
                $('#btnUpload').attr('disabled', false); //set button enable 
            },
            complete: function (data) {
                NProgress.done();
                $.unblockUI();
            }
        });

    });

    function showLoadingScreen() {
        $.blockUI({
            message: 'Loading....',
            css: {
                border: 'none',
                width: '300px',
                height: '50px',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });
    }

    var regex = new RegExp("(.*?)\.(csv)$");

    function triggerValidation(el) {
        if (!(regex.test(el.value.toLowerCase()))) {
            el.value = '';
            toastr.error('Please select csv file format');

        }
    }
</script>
@endsection