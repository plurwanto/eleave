@extends('Eleave.layout.main')

@section('title','Eleave | Report Stock Stationery')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-list"></i>Stationery Stock
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <form role="form" action="{{url('eleave/inventory_report/show')}}" method="get">

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group form-md-line-input has-success">
                            <label class="control-label">Year</label>
                            <select class="form-control" name="slt_year" id="slt_year">
                                <?php
                                $lastYear = (int) date('Y');
                                for ($i = 2015; $i <= $lastYear; $i++) {
                                    if (!empty($isYear)) {
                                        $selected = ($i == $isYear ? $selected = ' selected ' : '');
                                    } else {
                                        $selected = ($i == $lastYear ? $selected = ' selected ' : '');
                                    }

                                    echo "<option value='" . $i . "' $selected>" . $i . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-md-line-input has-success">
                            <label class="control-label">Month</label>
                            <select class="form-control" name="slt_month" id="slt_month">
                                <?php
                                $getMonthVal = $getMonthName = [];
                                $lastMonth = (int) date('m');
                                foreach (range(1, 12) as $m) {
                                    $getMonthVal = date('m', mktime(0, 0, 0, $m, 1));
                                    $getMonthName = date('F', mktime(0, 0, 0, $m, 1));
                                    if (!empty($isMonth)) {
                                        $selected = ($m == $isMonth ? $selected = ' selected ' : '');
                                    } else {
                                        $selected = ($m == $lastMonth ? $selected = ' selected ' : '');
                                    }
                                    echo "<option value='" . $getMonthVal . "' $selected>" . $getMonthName . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group form-md-line-input">
                            <label></label>
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-md-line-input">
                            <label></label>
                            <button type="button" id="export-btn" name="export-btn" value="" class="btn btn green-meadow btn-block"><i class="fa fa-file"></i> Export</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <table class="table table-condensed table-hover" id="tbldata">
                        <thead>
                            <tr>
                                <td colspan="3">
                                    <?=(!empty($isYear) ? "Inventory Stock Year : <b>" . $isYear . "</b>" : '')?> &nbsp;&nbsp;  <?=(!empty($isMonth) ? "Month : <b>" . $isMonth . "</b>" : '')?>
                                </td>
                            </tr>

                            <tr>
                                <th>No</th>
                                <th>Item Id</th>
                                <th>Item Name</th>
                                <th>Stock In</th>
                                <th>Stock Request</th>
                                <th>Item Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($list_stock_current)) {
                                $no = 0;
                                for ($i = 0; $i < count($list_stock_current); $i++) {
                                    ?>
                                    <tr>
                                        <td><?=$list_stock_current[$i]['no'];?></td>
                                        <td><?=$list_stock_current[$i]['item_id'];?></td>
                                        <td nowrap><?=$list_stock_current[$i]['item_name'];?></td>
                                        <td><?=$stock_in[$i]['qty_in'];?></td>
                                        <td><?=$stock_request[$i]['qty_req'];?></td>
                                        <td><?=$list_stock_current[$i]['qty'];?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@section('script')
@include('Eleave/notification')
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.table2excel.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#export-btn').prop('disabled', true);
    if ($("#tbldata tr").length > 2) {
        $('#export-btn').prop('disabled', false);
    }

    $('#export-btn').on('click', function (e) {
        e.preventDefault();
        ResultsToTable();
    });

    function ResultsToTable() {
        $("#tbldata").table2excel({
            filename: "inventory_stock",
            name: "Results"
        });
    }

});
</script>
@endsection