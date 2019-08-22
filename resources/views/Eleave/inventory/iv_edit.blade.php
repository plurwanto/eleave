@extends('Eleave.layout.main')

@section('title','Eleave | Stationery Edit')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square"></i>Edit Stationery Request
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <?php
        if (app('request')->input('request') == 'all') {
            $url = 'eleave/inventory/ga_update_request';
        } else {
            $url = 'eleave/inventory/update';
        }
        ?>
        <!-- BEGIN FORM-->
        <form id="form_inventory" name="form_inventory" action="{{url($url)}}" class="form-horizontal" method="post">

            <div class="form-body">
                <div class="form-group">

                    <label class="col-md-3 control-label">Employee</label>

                    <div class="col-md-4">
                        <input type="hidden" name="employee_id" value="<?=session('id');?>" >
                        <input type="hidden" name="request_id" id="request_id" value="<?=$list_item['request_id'];?>" >

                        <input type="text" class="form-control" name="employee_name" value="<?=session('nama');?>" readonly="readonly">
                    </div>

                </div>


                <div class="form-group">

                    <label class="col-md-3 control-label">Subject</label>

                    <div class="col-md-4">

                        <input type="text" class="form-control" value="<?=$list_item['request_name']?>" placeholder="Enter subject" name="subject_name" readonly="readonly">

                    </div>

                </div>

                <div class="form-group">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                        <table class="table table-bordered table-hover" id="barangtable">
                            <thead>
                                <tr>
                                    <th class="hide" width="15%">Item No</th>
                                    <th width="38%">Item Name</th>
                                    <th width="15%">Stock</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Change Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
//                                                           
                                foreach ($list_item['item'] as $key => $value) {
                                    $i = $key + 1;
                                    ?>
                                    <tr>
                                        <td class = "hidden"><input type="text" id="itemId_1" name="itemId[]" value="<?=$value['id'];?>"><input type = "text" data-type = "productCode" name = "itemNo[]" id = "itemNo_1" value="<?=$value['item_id'];?>" readonly = "readonly" class = "form-control autocomplete_txt" autocomplete = "off"></td>
                                        <td>
                                            <input type = "text" data-type = "productName" name = "itemName[]" id = "itemName_1" value="<?=$value['item_name'];?>" readonly = "readonly" class = "form-control autocomplete_txt" data-validation = "required" data-validation-error-msg = "'Item' is required." autocomplete = "off">
                                        </td>
                                        <td><input type = "text" name = "stock[]" id="stock_<?=$i;?>" value="<?=$value['qty_stock'];?>"  class = "form-control text-right input-sm stk_<?=$i;?>" readonly = "readonly" ></td>
                                        <td><input type = "text" name = "quantity[]" id="quantity_<?=$i;?>" value="<?=$value['quantity'];?>" class = "form-control changesNo text-right" autocomplete = "off" readonly = "readonly" ></td>
                                        <td><input type = "number" name = "revisi[]" id="revisi_<?=$i;?>" value="<?=$value['rev_quantity'];?>" class = "form-control changesNo text-right rev_<?=$i;?>" autocomplete = "off" onkeypress = "return IsNumeric(event);" ondrop = "return false;" onpaste = "return false;" min = "0"></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
            <?php
            if (app('request')->input('request') == 'all') {
                $url2 = 'eleave/inventory/all_request';
            } else {
                $url2 = 'eleave/inventory/index';
            }
            ?>

            <div class="row">

                <div class="col-md-offset-3 col-md-9">
                    <!--                                                <button name='btnsave' id='btnsave' onclick="save();" class="btn btn-circle green">Submit</button>-->
                    <button type="submit" id="btnSave" class="btn btn-circle green">Submit</button>
                    <a href="{{ URL::to($url2) }}" class="btn btn-circle grey-salsa btn-outline">Cancel</a>
                    <br>
                    <br>
                </div>

            </div>
            {{ csrf_field() }}
        </form>
        <!-- END FORM-->
    </div>
</div>

@endsection

@section('script')
@include('Eleave/notification')
<script type="text/javascript">
    $(document).ready(function () {
        $("#btnSave").click(function () {
            var j = $('#barangtable tr').length;

            for (var i = 1; i <= j; i++) {
                var rev = parseInt($('.rev_' + i).val());
                var inventory = parseInt($('.stk_' + i).val());
                if (rev > inventory) {
                    alert('Your order quantity ' + rev + ' is greater than ' + inventory + ' stock');
                    $('#rev_' + i).select();
                    return false;
                }
            }

        });
    });

    function delete_item(rows) {
        if (confirm('Are you sure delete ?'))
        {
            $('table#detailtable tr#baris' + rows).remove();
            $('input[name*="ts_date[]"]').each(function (i) {
                var i = i + 1;
                $(this).attr('id', 'ts_date_' + i);
            });
        }
    }


</script>

@endsection