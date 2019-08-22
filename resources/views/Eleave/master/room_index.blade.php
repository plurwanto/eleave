@extends('Eleave.layout.main')

@section('title','Eleave | Room List')

@section('style')

@endsection

@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-building"></i>Room List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">
                        <a class="btn btn-default btn-circle btn-sm" tabindex="0" onclick="add_item()"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-condensed" width="100%" id="usertable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Branch Name</th>
                        <th>Room Name</th>
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
            <form id="form"  action="#" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Add Form</h3>
                </div>
                <div class="modal-body form">
                    <input type="hidden" name="room_id" id="room_id">
                    <input type="hidden" id="txt_branch" value="" name="txt_branch">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Branch</label>
                            <div class="col-md-4">
                                <select class="form-control" name="branch_id" id="branch_id">
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
                            <label class="col-md-3 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Enter name" id="room_name" name="room_name" maxlength="50">
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
        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": `${webUrl}eleave/room/getdata`,
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
                {"data": "room_name"},
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
            url = `${webUrl}eleave/room/insert`;
        } else {
            url = `${webUrl}eleave/room/update`;
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                // alert(data.status);
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
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                        $('[name="' + data.inputerror[0] + '"]').focus();
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
        $('input[name="room_name"]').focus();
    }

    function edit_item(id)
    {
        $('#form')[0].reset();
        save_method = 'update';
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url: `${webUrl}eleave/room/{id}/edit`,
            type: "GET",
            data: {id: id, "_token": "{{ csrf_token() }}"},
            dataType: "JSON",
            success: function (response)
            {
                if (response.status == true) {
                    $('[name="room_id"]').val(response[0].room_id);
                    $('[name="room_name"]').val(response[0].room_name);
                    $('[name="branch_id"]').val(response[0].branch_id);
                    $('[name="txt_branch"]').val(response[0].branch_id);
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
                url: `${webUrl}eleave/room/delete`,
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
<script>
    toastr.options = {
        "closeButton": true,
    };

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
@endsection