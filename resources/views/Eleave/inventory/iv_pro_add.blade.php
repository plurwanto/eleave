@extends('Eleave.layout.main')

@section('title','Eleave | Procurement Add')

@section('style')
<style>
    #listtable td , #listtable td input{
        font-size: 12px !important;
        padding: 6px 10px !important;
        height: 20px;
    }
</style>
@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-plus-square"></i>Procurement Add
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <!-- BEGIN FORM-->
        <form id="form_inventory" name="form_inventory" action="{{ URL::to(env('APP_URL').'/eleave/inventory_procurement/insert') }}" class="form-horizontal" method="post">
            <div class="form-body">
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:30px;">
                        <input type="hidden" name="employee_id" value="<?=session('id');?>" >
                        <input type="hidden" name="request_id" id="request_id" value="" >
                        <input type="hidden" class="form-control" name="employee_name" value="<?=session('nama');?>" readonly="readonly">
                        <label class="col-md-2 control-label">Subject</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" placeholder="Enter subject" name="subject_name" id="subject_name" maxlength="255">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:30px;">
                        <label class="col-md-2 control-label">Supplier</label>
                        <div class="col-md-8">
                            <select name="supplier_id" id="supplier_id" class="form-control">
                                <option value="1">External</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-body">
                            <div class="bootstrap-table">
                                <div class="fixed-table-toolbar">
                                    <div class="pull-right search" style="padding-bottom:10px;" >
                                        <input type="text" class="form-control autocomplete_txt1" autocomplete="off" id="search" placeholder="Search..." >
                                    </div>
                                </div>
                                <div class="fixed-table-container" style="min-height:320px; max-height: 320px;  padding-bottom: 41px;">
                                    <div class="fixed-table-header" style="margin-right: 0px;">
                                        <table style="width: 461px;" class="table table-hover">
                                            <thead>
                                                <tr> 
                                                    <th style="width: 3%">No</th>
                                                    <th style="width: 60%">Item Name</th>
                                                    <th style="width: 15%">Stock</th>
                                                    <th style="width: 25%">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="fixed-table-body">
                                        <div class="fixed-table-loading" style="top: 42px; display: none;">Loading, please wait...</div>
                                        <div class="table-responsive" style="overflow: auto; max-height: 200px; margin-bottom: 50px;">  
                                            <?php
                                            if (!empty($list_item)) {
                                                ?>
                                                <input type="hidden" name="row_number" id="row_number" value="">
                                                <table id="itemtable" class="table table-hover" style="margin-top: -33px;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Item Name</th>
                                                            <th>Stock</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $number = 1;
                                                    foreach ($list_item as $value) {
                                                        //$cls = ($value['quantity'] > 0 ? "btn btn-xs green" : "btn btn-xs default disabled");
                                                        $cls = "btn btn-xs green"; // disable for GA Procurement
                                                        ?>
                                                        <tr>
                                                            <td><?=$number;?></td>
                                                            <td class="hidden"><?=$value['item_id'];?></td>
                                                            <td><?=$value['item_name'];?></td>
                                                            <td><?=$value['quantity'];?></td>
                                                            <td><a title="choose" id="btnchoose_<?=$value['item_id'];?>" name="btnchoose[]" class="<?=$cls;?>" onclick="tab1_To_tab2(<?=$number;?>);" ><i class="fa fa-check"></i></a></td>
                                                        </tr>
                                                        <?php
                                                        $number++;
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-9">No Item List</label>
                                                    </div>
                                                <?php }?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-body ">
                            <div class="bootstrap-table">
                                <div class="fixed-table-toolbar">
                                    <!--                                                                    <div class="pull-right search" style="padding-bottom:10px;" >
                                                                                                            <input type="text" class="form-control autocomplete_txt1" autocomplete="off" id="search___" placeholder="Search..." >
                                                                                                        </div>-->
                                </div>
                                <div class="fixed-table-container" style="min-height:320px; max-height: 320px;  padding-bottom: 41px;  padding-top: 45px;">
                                    <div class="fixed-table-header" style="margin-right: 0px;">
                                        <table style="width: 461px;" class="table table-hover">
                                            <thead>
                                                <tr> 
                                                    <th style="width: 3%">No</th>
                                                    <th style="width: 42%">Item Name</th>
                                                    <th style="width: 20%">Qty</th>
                                                    <th style="width: 15%">Cost</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="fixed-table-body">
                                        <div class="fixed-table-loading" style="top: 42px; display: none;">Loading, please wait...</div>
                                        <div class="table-responsive" style="overflow: auto; max-height: 200px; margin-bottom: 50px;">
                                            <table id="listtable" class="table table-hover" style="margin-top: -33px;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Item Name</th>
                                                        <th>Qty</th>
                                                        <th>Cost</th>
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
                            <div class="clearfix">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <!--                                                <button name='btnsave' id='btnsave' onclick="save();" class="btn btn-circle green">Submit</button>-->
                        <button type="submit" id="btnSave" class="btn btn-circle green">Submit</button>
                        <a href="{{ URL::to('eleave/inventory_procurement/index') }}"  class="btn btn-circle grey-salsa btn-outline">Back</a>
                        <br>
                        <br>
                    </div>
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
        $("#search").keypress(function (e) {
            var key = e.keyCode ? e.keyCode : e.which;
            if (key == 13) { //enter
                e.preventDefault();
                do_search();
            }

        });

        $("#btnSave").click(function () {
            var row = $('#listtable tr').length;
            var j = $('#listtable tr').length;

            if ($('#subject_name').val() == "") {
                toastr.error('subject is required');
                $('#subject_name').focus();
                return false;
            }
            if (j < 2) {
                toastr.error('item is required');
                return false;
            } else {
                var kosong = false;
                var num = 1;
                $('input[name*="quantity[]"]').each(function () {
                    var i = num++;
                    var qty = Number($(this).val());
                    if (qty == 0 || qty == "") {
                        alert("Number " + i + " Quantity Required");
                        kosong = true;
                    }
                });
                if (kosong == false) {
                    return true;
                } else {
                    return false;
                }



//                var lastRow = $('input[name*="quantity[]"]').length;
//                alert(lastRow);
//                for (a = 1; a <= lastRow; a++) {
//                    var qty = $('#')
//                }

                // return false;
                // return true;
            }
        });
    });

    // by purwanto on mei 18
// barang detail on auto_complete
    $(document).on('focus', '.autocomplete_txt', function () {
        $(this).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: 'index.php/inventory/getItemByName',
                    dataType: "json",
                    method: 'post',
                    data: {
                        name_startsWith: request.term
                                //type: type
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            var code = item.split("|");
                            return {
                                label: code[2],
                                value: code[2],
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 2,
            select: function (event, ui) {
                var names = ui.item.data.split("|");
                id_arr = $(this).attr('id');
                id = id_arr.split("_");
                $('#itemNo_' + id[1]).val(names[1]);
                $('#itemName_' + id[1]).val(names[2]);
                $('#stock_' + id[1]).val(names[3]);
                $('#quantity_' + id[1]).focus();

//                var lastRow = $('#barangtable tr').length;
//                var kodebarang = $('#itemNo_' + id[1]);
//                var namabarang = $('#itemName_' + id[1]);
//                var stockbarang = $('#stock_' + id[1]);
//                var exist = false;
//                //alert(lastRow);
//                for (a = 1; a < lastRow; a++) {
//                    if (a == id[1]) {
//                        a = a + 1;
//                    }
//                    if (a == lastRow) {
//                        break;
//                    }
//                    var kd = $('#itemNo_' + a);
//                    var nm = $('#itemName_' + a);
//                    // alert(kd);
//                    if (kd.val() == kodebarang.val())
//                    {
//                        alert("Item Name Already Exist..!");
//                        kodebarang.val('');
//                        namabarang.select();
//                        stockbarang.val('');
//                        //namabarang.focus();
//                        var exist = true;
//                        break;
//                    }
//
//                }

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

<script>

    function tab1_To_tab2(id)
    {
        var table1 = document.getElementById("itemtable"),
                table2 = document.getElementById("listtable");

        var newRow = table2.insertRow(table2.length),
                cell1 = newRow.insertCell(0),
                cell2 = newRow.insertCell(1),
                cell3 = newRow.insertCell(2),
                cell4 = newRow.insertCell(3),
                cell5 = newRow.insertCell(4),
                cell6 = newRow.insertCell(5),
                cell7 = newRow.insertCell(6),
                cell8 = newRow.insertCell(0);
        var item_id = table1.rows[id].cells[1].innerHTML;
        var i = $('#listtable tr').length - 1;
        newRow.id = "baris_" + i;
        cell2.setAttribute("class", "hidden");
        cell4.setAttribute("class", "hidden");
        cell8.setAttribute("class", "hidden");
        cell1.setAttribute("class", "order");
        cell1.setAttribute("width", "3%");
        cell3.setAttribute("width", "50%");
        cell4.setAttribute("width", "10%");
        cell5.setAttribute("width", "15%");
        cell6.setAttribute("width", "20%");
        //$('table#listtable tr#noitem').remove();
        // add values to the cells
        cell1.innerHTML = i;
        cell2.innerHTML = "<input type='text' value='" + table1.rows[id].cells[1].innerHTML + "' name='itemNo[]' id='itemNo_" + id + "' class='form-control item_id'>";
        cell3.innerHTML = table1.rows[id].cells[2].innerHTML;
        //cell4.innerHTML = table1.rows[id].cells[3].innerHTML;
        //cell4.innerHTML = "<input type='text' value='" + table1.rows[id].cells[3].innerHTML + "' name='supplier_id[]' id='supplier_id_" + id + "' class='form-control text-right input-sm stk_" + i + "'>";
        cell5.innerHTML = "<input type='text' name='quantity[]' id='quantity_" + id + "' class='form-control changesNo text-right input-xs qty_" + i + "' autocomplete='off' onkeypress='return IsNumeric(event);' min='1' value='1'>";
        cell6.innerHTML = "<input type='text' name='cost[]' id='cost_" + id + "' class='form-control changesNo text-right input-xs cost_" + i + "' autocomplete='off' onkeypress='return IsNumeric(event);' min='0' value='0'>";
        cell7.innerHTML = "<a title='cancel' id='del" + i + "' name='del[]' class='btn btn-xs red' onclick='tab2_To_tab1(" + i + ");' ><i class='fa fa-trash'></i></a>";
        cell8.innerHTML = "<input type='hidden' class='keyvalue' id='arr_num_" + i + "' name='arr_num[]' value='" + item_id + "'>";
        $('#btnchoose_' + item_id).toggleClass('btn btn-xs green btn btn-xs default disabled');
        $('<input/>').attr({type: 'hidden', name: 'arr_id[]', id: 'arr_id_' + item_id + '', value: item_id}).appendTo('#form_inventory');
    }

    function tab2_To_tab1(id)
    {
        var table1 = document.getElementById("itemtable"),
                table2 = document.getElementById("listtable");
        var i = $('#listtable tr').length - 1;
        var num = $('#arr_num_' + id).val();
        $('#arr_id_' + num).val(''); //sebagian tidak clear
        $('#btnchoose_' + num).toggleClass('btn btn-xs default disabled btn btn-xs green');
        $('table#listtable tr#baris_' + id).remove();
        $('table#listtable td.order').text(function (i) { // re order numb table 
          return i + 1;
        });
    }

    function get_data(url, q) {
        if (!url)
            url = `${webUrl}eleave/inventory_procurement/get_filter_name`;
        var arr_id = [];
        $('input[name^="arr_id"]').each(function () {
            arr_id.push($(this).val());
        });
        //alert(arr_id)
        $.ajax({
            url: url, type: 'post', dataType: 'json',
            data: {q: q, arr_id: arr_id, "_token": "{{ csrf_token() }}"},
            success: function (result) {
                $("#itemtable tbody").html(result.rows);
            }
        });
    }

    function do_search() {
        get_data('', $("#search").val());
    }

    function search_item(numb)
    {
        $('#row_number').val(numb);
        $('#modal_form').modal('show');
        $('.modal-title').text('Choose Item');


    }

    function delete_item(rows) {
        if (confirm('Are you sure delete ?'))
        {
            $('table#barangtable tr#baris' + rows).remove();
            $('input[name*="itemNo[]"]').each(function (i) {
                var i = i + 1;
                $(this).attr('id', 'itemNo_' + i);
                // $('input[name*="itemName[]"]').attr('id','itemName_'+i);
            });
        }
    }

    //It restrict the non-numbers
    var specialKeys = new Array();
    specialKeys.push(8, 46); //Backspace
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        console.log(keyCode);
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        return ret;
    }
</script>

@endsection