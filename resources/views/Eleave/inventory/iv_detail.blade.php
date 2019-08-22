@extends('Eleave.layout.main')

@section('title','Eleave | My Stationery Request Detail')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>My Stationery Request
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">

            <!-- BEGIN FORM-->
            <form id="form_inventory" name="form_inventory" action="{{ URL::to(env('APP_URL').'/eleave/inventory/ajax_status_request') }}" class="form-horizontal" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Employee</label>
                        <div class="col-md-4">
                            <input type="hidden" name="employee_id" value="<?=session('id');?>" >
                            <input type="hidden" name="request_id" id="request_id" value="<?=$list_item['request_id'];?>" >
                            <input type="text" class="form-control" name="employee_name" value="<?=$list_item['user_name'];?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Subject</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php
                            if (!empty($list_item['request_name'])) {
                                echo $list_item['request_name'];
                            }
                            ?>" placeholder="Enter subject" name="subject_name" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                            <table class="table table-bordered table-hover" id="barangtable">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="38%">Item Name</th>
                                        <th width="15%">Stock</th>
                                        <th width="15%">Quantity</th>
                                        <th width="15%">Quantity Revision</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    if (!empty($list_item['item'])) {
                                        foreach ($list_item['item'] as $key => $value) {
                                            $no++;
                                            $i = $key + 1;
                                            ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td class="hidden">
                                                    <input type="text" id="itemId_1" name="itemId[]" value="<?=$value['id'];?>"><input type = "text" data-type = "productCode" name = "itemNo[]" id = "itemNo_1" value="<?=$value['item_id'];?>" readonly = "readonly">
                                                    <input type = "text" data-type = "productName" name = "itemName[]" id = "itemName_1" value="<?=$value['item_name'];?>">
                                                    <input type = "text" name = "stock[]" value="<?=$value['qty_stock'];?>">
                                                    <input type = "text" name = "quantity[]" value="<?=$value['quantity'];?>">
                                                    <input type = "text" name = "revisi[]" value="<?=$value['rev_quantity'];?>">
                                                </td>
                                                <td><?=$value['item_name'];?></td>
                                                <td class="text-right"><?=$value['qty_stock'];?></td>
                                                <td class="text-right"><?=$value['quantity'];?></td>
                                                <td class="text-right"><?=$value['rev_quantity'];?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-offset-3 col-md-9">
                        <?php
                        if ($list_item['status'] == "5" && app('request')->input('act') == "receive") {
                            ?>
                            <button name='btn_submit' id='btn_receive' value="btn_receive" type="submit" onclick="return confirm('Are you sure you want to receive this request?');" class="btn btn-circle green">Receive Request</button>
                            <?php
                        }
                        if ($list_item['status'] == "1" && app('request')->input('act') == "cancel") {
                            ?>
                            <button name='btn_submit' id='btn_cancel' value="btn_cancel" type="submit" onclick="return confirm('Are you sure you want to cancel this request?');" class="btn btn-circle red">Cancel Request</button>
                            <?php
                        }
                        ?>
                        <?php
                        if (app('request')->input('request') == 'all') {
                            $url = 'eleave/inventory/all_request';
                        } else {
                            $url = 'eleave/inventory/index';
                        }
                        ?>
                        <a href="{{ URL::to($url) }}" class="btn btn-circle grey-salsa btn-outline">Back</a>
                        <br>
                        <br>
                    </div>

                </div>
                {{ csrf_field() }}
            </form>
            <!-- END FORM-->

        </div>
    </div>
</div>


@endsection

@section('script')
@include('Eleave/notification')
<script type="text/javascript">
    var $table;
    $(document).ready(function () {
        $('#usertable thead th').each(function () {
            setdatepicker();
            var title = $('#usertable thead th').eq($(this).index()).text();
            $(this).find(".filter-wrapper").html('<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-small").html('<input type="text" class="filter form-control" style="width:40px;" placeholder="' + title + '" />');
            $(this).find(".filter-wrapper-100").html('<input type="text" class="filter form-control" style="width:100px;" placeholder="' + title + '" />');
            $(this).find(".filter-wrapper-date-start").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date" style="width:80px;" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-date-end").html(
                    '<input type="text" class="filter form-control datepicker" id="src_date" style="width:80px;" placeholder="Filter ' + title + '" />');
            $(this).find(".filter-wrapper-status").html(
                    '<select class="filter form-control">\n\
                        <option value=""></option>\n\
                        <option value="1">Requested</option>\n\
                        <option value="2">Prepare</option>\n\
                        <option value="3">Reject</option>\n\
                        <option value="4">Done</option>\n\
                        <option value="5">Ready</option>\n\
                        <option value="6">Unfulfilled</option>\n\
                        </select>'
                    );
        });

        $table = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": `${webUrl}eleave/inventory/getDetail`,
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?=csrf_token()?>"}
            },
            dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "columns": [
                {"data": "no", "searchable": false, "orderable": false},
                {"data": "request_name", "searchable": false, "orderable": false},
                {"data": "status", "searchable": false, "orderable": true},
                {"data": "batch_id", "searchable": false, "orderable": false},
                {"data": "created_by", "searchable": false, "orderable": false},
                {"data": "created_at", "searchable": false, "orderable": false},
                {"data": "action", "searchable": false, "orderable": false},
            ],

            scrollY: 350,
            scrollX: true,
            //scrollCollapse: true,
            "pageLength": 10,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            order: [[2, "desc"]],
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
        $table.on("click", "tr", function () {
            var aData = $table.row(this).data();
            console.log(aData);
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

    }
</script>

<script>
    $(document).on('click', '.reject', function () {
        if (confirm("Are you sure delete ?  "))
        {
            var $button = $(this);
            var id = this.id.split('-').pop();
            $.ajax({
                type: 'POST',
                url: `${webUrl}eleave/inventory/delete`,
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