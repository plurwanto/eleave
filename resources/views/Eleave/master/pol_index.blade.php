@extends('Eleave.layout.main')

@section('title','Eleave | Policy List')

@section('style')

@endsection

@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-legal"></i>Policy List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">
                        <a class="btn btn-default btn-circle btn-sm" tabindex="0" onclick="add_item()"><i class="fa fa-plus"></i> Add Policy</a>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-bordered table-condensed nowrap" id="mastertable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Branch Name</th>
                        <th>Attendance</th>
                        <th>Leave</th>
                        <th>Workplace</th>
                        <th>Last Updated</th>
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
            <form id="form"  action="#" class="form-horizontal" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Add Form</h3>
                </div>
                <div class="modal-body form">
                    <input type="hidden" name="policy_id" id="policy_id">
                    <input type="hidden" id="txt_branch" value="" name="txt_branch">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Branch
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-4">
                                <select class="form-control" name="branch" id="branch">
                                    <option value="">-- Choose Branch --</option>
                                    <?php
                                    foreach ($branch as $value) {
                                        echo "<option value='" . $value['branch_id'] . "'>" . $value['branch_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Attendance</label>
                            <div class="col-md-6">
                                <span id="img_pol_att"></span>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn green btn-file">
                                        <span class="fileinput-new"> Select file </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="pol_att" id="pol_att" accept="application/pdf"> 
                                        <span class="help-block"> </span>
                                    </span>
                                    <span class="fileinput-filename"> </span> &nbsp;
                                    <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Leave</label>
                            <div class="col-md-6">
                                <span id="img_pol_lv"></span>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn green btn-file">
                                        <span class="fileinput-new"> Select file </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="pol_lv" id="pol_lv" accept="application/pdf">
                                        <span class="help-block"></span>
                                    </span>
                                    <span class="fileinput-filename"> </span> &nbsp;
                                    <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Workplace</label>
                            <div class="col-md-6">
                                <span id="img_pol_wp"></span>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn green btn-file">
                                        <span class="fileinput-new"> Select file </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="pol_wp" id="pol_wp" accept="application/pdf"> 
                                        <span class="help-block"></span>
                                    </span>
                                    <span class="fileinput-filename"> </span> &nbsp;
                                    <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <span id="show_history"> History
                            <div id="div_log">

                            </div>
                        </span>
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
                $table = $('#mastertable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": `${webUrl}eleave/policy/getdata`,
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
                    "columns": [
                        {"data": "no", "searchable": false, "orderable": false},
                        {"data": "branch_name"},
                        {"data": "pol_attendance", "searchable": false, "orderable": false},
                        {"data": "pol_leave", "searchable": false, "orderable": false},
                        {"data": "pol_workplace", "searchable": false, "orderable": false},
                        {"data": "pl_last_update", "searchable": false, "orderable": false},
                        {"data": "action", "searchable": false, "orderable": false},
                    ],
                    order: [[1, "desc"]],
                });

                $("input").change(function () {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("textarea").change(function () {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });
                $("select").change(function () {
                    $(this).parent().parent().removeClass('has-error');
                    $(this).next().empty();
                });

            });

        </script>

        <script>
            var save_method;
            $("#btnSave").click(function () {
                var url;

                if (save_method == 'add') {
                    url = `${webUrl}eleave/policy/insert`;
                } else {
                    url = `${webUrl}eleave/policy/update`;
                }
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: new FormData($('#form')[0]),
                    success: function (data) {

                        if (data.status == true) {
                            $.blockUI();
                            $('#modal_form').modal('hide');
                            $.unblockUI();
                            $table.ajax.reload();
                            toastr.success(data.message);
                        } else {
                            for (var i = 0; i < data.inputerror.length; i++)
                            {
                                $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                                $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                                $('[name="' + data.inputerror[0] + '"]').focus();
                            }
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                        $('#btnUpload').text('upload'); //change button text
                        $('#btnUpload').attr('disabled', false); //set button enable 
                    },
                    //            complete: function (data) {
                    //                NProgress.done();
                    //                $.unblockUI();
                    //            }
                });

            });

            function add_item()
            {
                $('#form')[0].reset();
                $('#policy_id').val('');
                $('#img_pol_att').html('');
                $('#img_pol_lv').html('');
                $('#img_pol_wp').html('');
                $('#show_history').hide();
                save_method = 'add';
                $('.form-group').removeClass('has-error');
                $('.help-block').empty();
                $('#modal_form').modal('show');
                $('.modal-title').text('Add Form');
            }

            function edit_item(id)
            {
                $('#form')[0].reset();
                $('#pol_att').val(null);
                $('#pol_lv').val(null);
                $('#pol_wp').val(null);
                $('#show_history').show();
                $('#div_log').html('');
                NProgress.inc();
                save_method = 'update';
                $('.form-group').removeClass('has-error');
                $('.help-block').empty();
                $.ajax({
                    url: `${webUrl}eleave/policy/{id}/edit`,
                    type: "GET",
                    data: {id: id, "_token": "{{ csrf_token() }}"},
                    dataType: "JSON",
                    beforeSend: function () {
                        $.blockUI();
                    },
                    success: function (response)
                    {
                        if (response.status == true) {
                            $('[name="policy_id"]').val(response.data.pol_id);
                            $('[name="branch"]').val(response.data.branch_id);
                            $('[name="txt_branch"]').val(response.data.branch_id);
                            $('#img_pol_att').html(response.data.pol_att);
                            $('#img_pol_lv').html(response.data.pol_lv);
                            $('#img_pol_wp').html(response.data.pol_wp);
                            //  alert(response.result_log[1].description);

                            html = '<div style="height: 200px; overflow-y: auto">\n\
                                        <div class="portlet"><div class="portlet-body" style="display: block;">\n\
                                    <div class="tools">\n\
                                     <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>\n\
                                    </div>';
                            html += '<ul class="feeds">';
                            for (var i = 0; i < response.result_log.length; i++) {
                                html += '<li class="small font-grey-cascade">' + response.result_log[i].branch_name + '  &nbsp;' + response.result_log[i].submit_by_name + '  &nbsp;' + response.result_log[i].submit_date + ' &nbsp;&nbsp;<b>' + response.result_log[i].description + '</b></li>';
                            }
                            html += '</div></div><ul></div>';
                            $('#div_log').append(html);

                            $('#modal_form').modal('show');
                            $('.modal-title').text('Edit item');
                        } else {
                            toastr.warning(response.msg);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error get data from ajax');
                    },
                    complete: function (data) {
                        NProgress.done();
                        $.unblockUI();
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
                        url: `${webUrl}eleave/policy/delete`,
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

        </script>

        @endsection