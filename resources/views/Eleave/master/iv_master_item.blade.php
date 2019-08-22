@extends('Eleave.layout.main')

@section('title','Eleave | Item List')

@section('style')

@endsection

@section('content')
<div class="tabbable-line boxless tabbable-reversed">
    <ul class="nav nav-tabs">
        <li class="">
            <a href="{{url('eleave/inventory_master/unit')}}" id="tab1" aria-expanded="false"> Unit </a>
        </li>
        <li class="">
            <a href="{{url('eleave/inventory_master/supplier')}}" id="tab2" aria-expanded="false"> Supplier </a>
        </li>
        <li class="active">
            <a href="{{url('eleave/inventory_master/item')}}" id="tab2" aria-expanded="true"> Item </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade active in" id="tab_1_1">

            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cart-plus"></i>Item List
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dt-buttons">
                                    <a class="btn btn-default btn-circle btn-sm" tabindex="0" onclick="add_item()"><i class="fa fa-plus"></i> Add Item</a>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-condensed" width="100%" id="usertable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Item Name</th>
                                    <th>Unit Name</th>
                                    <th>Supplier Name</th>
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
                <h3 class="modal-title">Item Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="" name="item_id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Item Name</label>
                            <div class="col-md-9">
                                <input name="itemName" placeholder="item Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Unit</label>
                            <div class="col-md-9">
                                <select id="unit_id" name="unit_id" class="form-control">
                                    <option value="" >-- Choose Unit --</option>

                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Supplier</label>
                            <div class="col-md-9">
                                <select id="supplier_id" name="supplier_id" class="form-control">
                                    <option value="" >-- Choose Supplier --</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Photo</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="file" name="attach_file1" id="attach_file1" accept="image/*">
                                </div>
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
                "url": `${webUrl}eleave/inventory_master/getItem`,
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
                {"data": "item_id", "visible": false},
                {"data": "item_name"},
                {"data": "unit_name", "orderable": false},
                {"data": "supplier_name", "orderable": false},
                {"data": "status"},
                {"data": "action", "searchable": false, "orderable": false},
            ],
            "pageLength": 10,
            order: [[1, "DESC"]],
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
            url = `${webUrl}eleave/inventory_master/save_item`;
       } else {
            url = `${webUrl}eleave/inventory_master/update_item`;
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
                    if (data.message) {
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

    function add_item()
    {
        getUnitSupplier();
        $('#form')[0].reset();
        save_method = 'add';
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Form');
        $('input[name="itemName"]').focus();
    }

    function edit_item(id)
    {
        getUnitSupplier();
        $('#form')[0].reset();
        save_method = 'update';
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $.ajax({
            url : `${webUrl}eleave/inventory_master/item/{id}/edit`,
            type: "GET",
            data: {id: id, "_token": "{{ csrf_token() }}"},
            dataType: "JSON",
            success: function (response)
            {
                if (response.status == true) {
                    
                    $('[name="item_id"]').val(response[0].item_id);
                    $('[name="itemName"]').val(response[0].item_name);
                    $('[name="unit_id"]').val(response[0].unit_id);
                    $('[name="supplier_id"]').val(response[0].supplier_id);
                    $('[name="image"]').val(response[0].image);
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
                url : `${webUrl}eleave/inventory_master/delete_item`,
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

    function getUnitSupplier() {
        $.ajax({
            url : `${webUrl}eleave/inventory_master/getUnitByName`,
            dataType: "json",
            method: 'GET',
            success: function (response) {
                if (response.status == true) {
                    var $select = $('#unit_id');
                    $select.find('option').remove();
                    $("#unit_id").append('<option value=' + '' + '>' + '-- Choose Unit --' + '</option>');
                    $.each(response.data, function (key, value)
                    {
                        $("#unit_id").append('<option value=' + value['unit_id'] + '>' + value['unit_name'] + '</option>');
                    });
                } else {
                    $select.find('option').remove();
                }
            }
        });

        $.ajax({
            url : `${webUrl}eleave/inventory_master/getSupplierByName`,
            dataType: "json",
            method: 'get',
            success: function (response) {
                if (response.status == true) {
                    var $select = $('#supplier_id');
                    $select.find('option').remove();
                    $("#supplier_id").append('<option value=' + '' + '>' + '-- Choose Supplier --' + '</option>');
                    $.each(response.data, function (key, value)
                    {
                        $("#supplier_id").append('<option value=' + value['supplier_id'] + '>' + value['supplier_name'] + '</option>');
                    });
                } else {
                    $select.find('option').remove();
                }
            }
        });

    }

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