@extends('Eleave.layout.main')

@section('title','Eleave | Procurement Detail')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-list"></i>Procurement Detail
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">

            <!-- BEGIN FORM-->
            <form id="form_inventory" name="form_inventory" action="{{url('eleave/inventory/ajax_status_request')}}" class="form-horizontal" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Procurement Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php
                            if (!empty($list_item['procurement_name'])) {
                                echo $list_item['procurement_name'];
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
                                        <th width="15%">Quantity</th>
<!--                                        <th width="15%">Quantity Old</th>-->
                                        <th width="15%">Total Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    if (!empty($list_item['items'])) {
                                        foreach ($list_item['items'] as $key => $value) {
                                            $no++;
                                            $i = $key + 1;
                                            ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td class="hidden">
                                                    <input type="text" id="itemId_1" name="itemId[]" value="<?=$value['item_id'];?>"><input type = "text" data-type = "productCode" name = "itemNo[]" id = "itemNo_1" value="<?=$value['item_id'];?>" readonly = "readonly">
                                                    <input type = "text" data-type = "productName" name = "itemName[]" id = "itemName_1" value="<?=$value['item_name'];?>">
                                                    <input type = "text" name = "quantity_old[]" value="<?=$value['quantity_old'];?>">
                                                    <input type = "text" name = "quantity[]" value="<?=$value['quantity'];?>">
                                                </td>
                                                <td><?=$value['item_name'];?></td>
                                                <td class="text-right"><?=$value['quantity'];?></td>
<!--                                                <td class="text-right"><?=$value['quantity_old'];?></td>-->
                                                <td class="text-right"><?=$value['total_cost'];?></td>
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
                        <a href="{{ URL::to('eleave/inventory_procurement/index') }}" class="btn btn-circle grey-salsa btn-outline">Back</a>
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


@endsection