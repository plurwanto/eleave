@extends('Eleave.layout.main')

@section('title','Eleave | Claim List Approval')

@section('style')

@endsection

@section('content')
@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }}
</div>
@endif

<input type="hidden" id="notif" name="notif" value="{{ $notif }}">
<input type="hidden" value="{{ $source_id }}" name="source_id" id="source_id" />
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-dollar"></i>Claim List Approval
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div class="tab-content">
            <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dt-buttons">
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                    <thead>
                        <tr>
                            <th style="width: 15px">No</th>
                            <th>Number</th>
                            <th style="width: 50px">Type<br />
                                <div class="filter-wrapper-type"></div>
                            </th>
                            <th style="width: 120px">Employee<br />
                                <div class="filter-wrapper"></div>
                            </th>
                            <th style="width: 70px">Date<br />
                                <div class="filter-wrapper-date-start"></div>
                            </th>
                            <th style="width: 90px">Subject<br />
                                <div class="filter-wrapper"></div>
                            </th>
                            <th style="width: 90px">Claim Total</th>

                            <th style="width: 260px">Status<br />
                                <div class="filter-wrapper-status"></div>
                            </th>
                            <th style="width: 108px">Action</th>

                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Revision</h3>
            </div>
            <div class="modal-body">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="user_id" id="user_id" />
                    <input type="hidden" value="" name="cl_id" id="cl_id" />
                    <input type="hidden" value="" name="next" id="next" />
                    <input type="hidden" value="" name="approver_user" id="approver_user" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Note
                                <span id="show_required" class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" placeholder="Enter note"
                                          id="cl_reason" name="cl_reason" maxlength="150"></textarea>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-o" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnSave" onclick="save_status()" class="btn btn-info">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Bootstrap modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_detail" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Claim Detail</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="row static-info">
                            <div class="col-md-2 name"> Type: </div>
                            <div id="cl_type" class="col-md-4 value">  </div>
                            <div class="col-md-2 name"> Document: </div>
                            <div id="cl_doc" class="col-md-3 value">  </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-2 name"> Subject: </div>
                            <div id="subject" class="col-md-4 value">  </div>
                            <div class="col-md-2 name"> Remark: </div>
                            <div id="cl_rem" class="col-md-3 value">  </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-2 name"> Date: </div>
                            <div id="date" class="col-md-7 value">  </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-2 name"> Total: </div>
                            <div id="total" class="col-md-7 value">  </div>
                        </div>


                        <h3 class="form-section">Details</h3>
                    </div>

                </form>

                <div class="table table-responsive" id="tbldata" style="height:150px; width:100%;overflow: auto;">
                    <form action="#" id="form" class="form-horizontal">
                        <table id="detailtable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th id="th_expense_1" width="20%">Description 
                                    </th>
                                    <th id="th_expense_2" width="10%">Amount

                                    </th>
                                    <th id="th_travel_1" width="10%" style="display: none;">Date Traveled

                                    </th>
                                    <th id="th_travel_2" width="15%" style="display: none;">Location (From)

                                    </th>
                                    <th id="th_travel_3" width="15%" style="display: none;">Location (To)

                                    </th>
                                    <th id="th_travel_4" width="15%" style="display: none;">Reason

                                    </th>
                                    <th id="th_travel_5" width="5%" style="display: none;">Distance (KM)

                                    </th>
                                    <th id="th_travel_6" width="10%" style="display: none;">Mode of Transport

                                    </th>
                                    <th id="th_travel_7" width="15%" style="display: none;">Parking

                                    </th>
                                    <th id="th_travel_8" width="15%" style="display: none;">Toll

                                    </th>
                                    <th id="th_travel_9" width="15%" style="display: none;">Petrol

                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-6"> </div>
                    <div class="col-md-6">
                        <div class="well">
                            <div id="sub_park" class="row static-info align-reverse" style="display: none;">
                                <div class="col-md-7 name"> Sub Total Parking: </div>
                                <div id="div_sub_park" class="col-md-4 value">  </div>
                            </div>
                            <div id="sub_toll" class="row static-info align-reverse" style="display: none;">
                                <div class="col-md-7 name"> Sub Total Toll: </div>
                                <div id="div_sub_toll" class="col-md-4 value">  </div>
                            </div>
                            <div id="sub_petr" class="row static-info align-reverse" style="display: none;">
                                <div class="col-md-7 name"> Sub Total Petroll: </div>
                                <div id="div_sub_pet" class="col-md-4 value">  </div>
                            </div>
                            <div class="row static-info align-reverse">
                                <div class="col-md-7 name"> Total: </div>
                                <div id="cl_total_from" class="col-md-4 value">  </div>
                            </div>
                            <div class="row static-info align-reverse">
                                <div class="col-md-7 name"> Total (MYR): </div>
                                <div id="cl_total_to" class="col-md-4 value">  </div>
                            </div>
                            <div id="sub_mile" class="row static-info align-reverse" style="display: none;">
                                <div class="col-md-7 name"> Mileage (MYR): </div>
                                <div id="cl_total_mileage" class="col-md-4 value">  </div>
                            </div>
                            <div class="row static-info align-reverse">
                                <div class="col-md-7 name"> Grand Total (MYR): </div>
                                <div id="cl_grd_total" class="col-md-4 value">  </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-o" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

@endsection

@section('script')
@include('Eleave/notification')
<script type="text/javascript">
// Server-side processing with object sourced data
    var $table;
    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-small").html(
                    '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-date-start").html(
                    '<input type="text" class="filter form-control datepicker" placeholder="Filter ' +
                    title + '" />');
            $(this).find(".filter-wrapper-type").html(
                    '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                       <option value="1">Expense</option>\n\
                        <option value="2">Travel</option>\n\
                     </select>'
                    );
            $(this).find(".filter-wrapper-status").html(
                    '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="{{ session("id") }}">Waiting your approval</option>\n\
                        <option value="1">Waiting other approval</option>\n\
                        <option value="2">Process request</option>\n\
                        <option value="3">Approve request</option>\n\
                        <option value="11">Revision</option>\n\
                        <option value="10">Rejected</option>\n\
                    </select>'
                    );
        });

//        if ($('#notif').val() == "notif") {
//            var url = `${webUrl}eleave/claimApproval/getdataNotif`;
//        } else {
        var url = `${webUrl}eleave/claimApproval/getdata`;
        //  }

        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": {
                    "_token": "<?=csrf_token()?>",
                    "step": 1,
                    notif: $('#notif').val(),
                    source_id: $('#source_id').val()
                }
            },
            dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "columns": [{
                    "data": "no",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "cl_id",
                    "searchable": false,
                    "orderable": false,
                    "visible": false
                },
                {
                    "data": "cl_type",
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "data": "user_name",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "cl_date",
                    "searchable": false,
                    "orderable": true
                },
                {
                    "data": "cl_subject",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "cl_total_from",
                    "searchable": false,
                    "orderable": false
                },
                
                {
                    "data": "status",
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "action",
                    "searchable": false,
                    "orderable": false
                },
            ],

//            scrollY: 350,
//            scrollX: true,
            //scrollCollapse: true,
            "pageLength": ($('#notif').val() == "notif" ? 1000 : 10),
            lengthMenu: [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            order: [
                [1, "desc"]
            ],
            "fnDrawCallback": function (oSettings) {
                if ($('#notif').val() == "notif") {
                    $('.dataTables_paginate').hide();
                    $('.dataTables_length').hide();
                }
            }
        });

//        new $.fn.dataTable.FixedColumns($table, {
//            leftColumns: 4,
//            rightColumns: 2
//        });

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
        $table.on("click", "tr", function () {
            var aData = $table.row(this).data();
            console.log(aData);
        });


    });

    function revisi_this(id, cl_id) {
        save_method = 'update';
        $('#show_required').show();
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#cl_id').val(cl_id);
        $('#user_id').val(id);
        $('.modal-title').text('Revision Form');

    }

    function reject_this(id, cl_id) {
        save_method = 'reject';
        $('#show_required').show();
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#cl_id').val(cl_id);
        $('#user_id').val(id);
        $('.modal-title').text('Reject Form');

    }

    function approve_this(cl_id, id, next, approver_user) {
        save_method = 'approve';
        $('#show_required').hide();
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('#cl_id').val(cl_id);
        $('#user_id').val(id);
        $('#next').val(next);
        $('#approver_user').val(approver_user);
        $('.modal-title').text('Approve Form');

    }

    function save_status() {

        if (save_method == 'approve') {
            $('#btnSave').text('Updating...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;

            url = `${webUrl}eleave/claimApproval/approve`;

            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function (data) {
                    // alert(data.inputerror);
                    if (data.status) {
                        $('#modal_form').modal('hide');
                        $table.ajax.reload();
                        toastr.success(data.message);
                    }
                    $('#btnSave').text('Update');
                    $('#btnSave').attr('disabled', false);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 

                }
            });
        } else {
            if ($('#cl_reason').val() != '') {
                $('#btnSave').text('Updating...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 
                var url;

                if (save_method == 'update') {
                    url = `${webUrl}eleave/claimApproval/revise`;
                } else if (save_method == 'reject') {
                    url = `${webUrl}eleave/claimApproval/reject`;
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        // alert(data.inputerror);
                        if (data.status) {
                            $('#modal_form').modal('hide');
                            $table.ajax.reload();
                            toastr.success(data.message);
                        }
                        $('#btnSave').text('Update');
                        $('#btnSave').attr('disabled', false);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                        $('#btnSave').text('save'); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable 

                    }
                });
            } else {
                alert('Enter note');
                return false;
            }
        }
    }

    function show_detail(id, cl_id, tipe) {
        var sum = 0;
        var mile = 0;
        var park = 0;
        var toll = 0;
        var pet = 0;
        var grdTot = 0;

        $('#user_id').val(id);
        $('#modal_form_detail').modal('show');
        //$('.modal-title').text('Detail');
        $.ajax({
            type: "POST",
            "url": `${webUrl}eleave/claim/getDetail`,
            dataType: 'json',
            data: {
                id: id,
                cl_id: cl_id,
                "_token": "{{ csrf_token() }}"
            },
            //cache: false,
            success: function (response) {
                if (tipe == 2) {
                    $('#th_expense_1').hide();
                    $('#th_expense_2').hide();

                    for (var i = 1; i < 10; i++) {
                        $('#th_travel_' + i).show();

                    }

                    $('#sub_park').show();
                    $('#sub_toll').show();
                    $('#sub_petr').show();
                    $('#sub_mile').show();
                } else {
                    $('#th_expense_1').show('');
                    $('#th_expense_2').show('');

                    for (var i = 1; i < 10; i++) {
                        $('#th_travel_' + i).hide();

                    }

                    $('#sub_park').hide();
                    $('#sub_toll').hide();
                    $('#sub_petr').hide();
                    $('#sub_mile').hide();

                }

                $('#number').html(response.data[0].cl_id);
                $('#subject').text(response.data[0].cl_subject);
                $('#date').text(response.data[0].cl_date);
                $('#total').text(response.data[0].cl_total_from);
                $('#cl_currency').text(response.data[0].cl_currency);
                $('#cl_doc').html(response.data[0].cl_file);
                $('#cl_rem').text(response.data[0].cl_remark);
                $('#cl_type').text(response.data[0].cl_type == 1 ? 'expense' : 'travel');
                $('table#detailtable tr#baris').remove();
                //alert(response)
                for (var i = 0; i < response.data.length; i++) {
                    x = i + 1;
                    html = '<tr id="baris">';
                    html += '<td nowrap> ' + x + '</td>';
                    if (tipe == 1) {
                        html += '<td nowrap> ' + response.data[i]['cl_description'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['cl_amount'] + '</td>';
                    } else {
                        html += '<td nowrap> ' + response.data[i]['cl_date_travel'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['cl_loc_from'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['cl_loc_to'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['cl_reason'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['cl_distance'] + '</td>';
                        html += '<td nowrap> ' + response.data[i]['cl_transport'] + '<input type="hidden" name="cl_travel_mileage[]" value="' + response.data[i]['cl_mileage'] + '"></td>';
                        html += '<td nowrap> ' + response.data[i]['cl_parking'] + '<input type="hidden" name="cl_travel_parking[]" value="' + response.data[i]['cl_parking'] + '"></td>';
                        html += '<td nowrap> ' + response.data[i]['cl_toll'] + '<input type="hidden" name="cl_travel_toll[]" value="' + response.data[i]['cl_toll'] + '"></td>';
                        html += '<td nowrap> ' + response.data[i]['cl_petrol'] + '<input type="hidden" name="cl_travel_petrol[]" value="' + response.data[i]['cl_petrol'] + '"></td>';
                    }
                    html += '</tr>';
                    $('#detailtable').append(html);
                }
                $('input[name*="cl_travel_mileage[]"]').each(function () {
                    var prodprice = Number($(this).val());
                    mile += prodprice;
                });
                $('input[name*="cl_travel_parking[]"]').each(function () {
                    var prodprice = Number($(this).val());
                    park += prodprice;
                });
                $('input[name*="cl_travel_toll[]"]').each(function () {
                    var prodprice = Number($(this).val());
                    toll += prodprice;
                });
                $('input[name*="cl_travel_petrol[]"]').each(function () {
                    var prodprice = Number($(this).val());
                    pet += prodprice;
                });
                $('#div_sub_park').text(park);
                $('#div_sub_toll').text(toll);
                $('#div_sub_pet').text(pet);

                $('#cl_total_from').text(response.data[0].cl_sub_total_from);
                $('#cl_total_to').text(response.data[0].cl_total_to);
                $('#cl_total_mileage').text(mile.toFixed(2));
                grdTot = mile + response.data[0].cl_total_to;
                $('#cl_grd_total').text(grdTot.toFixed(2));



            }
        });
    }

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
    $(document).on('click', '.approve', function () {
        var $button = $(this);
        if (confirm("Are you sure approve ?  ")) {
            $button.attr('disabled', true);
            var arr = this.id.split('|');
            $.ajax({
                url: `${webUrl}eleave/claimApproval/approve`,
                type: "POST",
                data: {
                    cl_id: arr[0],
                    user_id: arr[1],
                    next: arr[2],
                    approver_user: arr[3], //next user id approver
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == true) {
                        $table.ajax.reload();
                        toastr.success(data.message);
                    }

                },
                error: function (data) {
                    toastr.error(data.message);
                }
            });
        }
    });

</script>

@endsection