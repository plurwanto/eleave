@extends('Eleave.layout.main')

@section('title','Eleave | Unit List')

@section('style')

@endsection

@section('content')
<div class="tabbable-line boxless tabbable-reversed">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="{{url('eleave/inventory_master/unit')}}" id="tab1" aria-expanded="true"> Unit </a>
        </li>
        <li class="">
            <a href="{{url('eleave/inventory_master/supplier')}}" id="tab2" aria-expanded="false"> Supplier </a>
        </li>
        <li class="">
            <a href="{{url('eleave/inventory_master/item')}}" id="tab2" aria-expanded="false"> Item </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade active in" id="tab_1_1">

            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cart-plus"></i>Unit List
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dt-buttons">
                                    <a class="btn btn-default btn-circle btn-sm" tabindex="0" onclick="add_unit()"><i class="fa fa-plus"></i> Add Unit</a>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-condensed" width="100%" id="usertable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Name</th>
                                    <th>Satuan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Unit Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="" name="unit_id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Unit Name</label>
                            <div class="col-md-9">
                                <input name="unitName" placeholder="Unit Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Short Name</label>
                            <div class="col-md-9">
                                <input name="shortName" placeholder="Short Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                                <select id="status" name="status" class="form-control">
                                    <option value="1" >Active</option>
                                    <option value="0" >Not Active</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-circle grey-salsa btn-outline" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnSave" class="btn btn-circle green">&nbsp;Save&nbsp;</button>
            </div>
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
                "url": `${webUrl}eleave/inventory_master/getUnit`,
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
                {"data": "unit_name"},
                {"data": "short_name"},
                {"data": "status"},
                {"data": "action", "searchable": false, "orderable": false},
            ],
            "pageLength": 10,
            order: [[1, "desc"],[2, "desc"],[3, "desc"]],
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
            url = `${webUrl}eleave/inventory_master/save_unit`;
        } else {
            url = `${webUrl}eleave/inventory_master/update_unit`;
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                if (data.status == true)
                {
                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                    $('#modal_form').modal('hide');
                    $table.ajax.reload();
                    toastr.success(data.message);
                } else {
                    if (data.message){
                        toastr.error(data.message);
                    }
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

    function add_unit()
    {
        $('#form')[0].reset();
        save_method = 'add';
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Form');
        $('input[name="unitName"]').focus();
    }

    function edit_unit(id)
    {
        $('#form')[0].reset();
        save_method = 'update';
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url: `${webUrl}eleave/inventory_master/unit/{id}/edit`,
            type: "GET",
            data: {id: id, "_token": "{{ csrf_token() }}"},
            dataType: "JSON",
            success: function (response)
            {
                if (response.status == true) {
                    $('[name="unit_id"]').val(response[0].unit_id);
                    $('[name="unitName"]').val(response[0].unit_name);
                    $('[name="shortName"]').val(response[0].short_name);
                    $('[name="status"]').val(response[0].status);
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
                url: `${webUrl}eleave/inventory_master/delete_unit`,
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