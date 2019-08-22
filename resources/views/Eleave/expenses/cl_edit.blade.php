@extends('Eleave.layout.main')

@section('title','Eleave | Claim Edit')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-dollar"></i>Claim Form
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <?php
        if (!empty($cl)) {
            ?>
            <?php if ($cl->cl_need_revision) {?>
                <div class="alert alert-warning">
                    <strong>Need to be revised.</strong> <?php
                    if ($cl->cl_revision_reason != "") {
                        echo "Message from " . $cl->user_name . " : " . $cl->cl_revision_reason;
                    }
                    ?>
                </div>
            <?php }?>
            <!-- BEGIN FORM-->
            <form action="{{ URL::to(env('APP_URL').'/eleave/claim/insert') }}" class="form-horizontal" method="post" id="form_ca" enctype="multipart/form-data">
                <div class="form-body">
                    <input type="hidden" name="employee_id" id="employee_id" value="{{session('id')}}" >
                    <input type="hidden" name="cl_id" id="cl_id" value="<?=$cl->cl_id;?>">
                    <input type="hidden" name="input_type" id="input_type" value="" >
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Claim Date</label>
                            <label class="col-md-2 control-label" id="sp_cl_date">{{ date('d M Y', strtotime($cl->cl_date)) }}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Type</label>
                            <div class="col-md-4">
                                <input type="hidden" name="cl_type" id="cl_type" value="<?=$cl->cl_type;?>">
                                <select class="form-control" name="cl_type_temp" id="cl_type_temp" disabled="disabled">
                                    <option value=""><?=($cl->cl_type == 1 ? "expense" : "travel");?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Subject 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6 err">
                                <input type="text" class="form-control" value="<?=$cl->cl_subject;?>" name="subject_name" id="subject_name" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Total</label>
                            <div class="col-md-4">
                                <input type="hidden" name="cl_currency" id="cl_currency" value="<?=$cl->cl_currency;?>">
                                <input type="hidden" name="cl_total_to" id="cl_total_to" value="<?=$cl->cl_total_to;?>">
                                <input readonly="readonly" value="<?=$cl->cl_total_from;?>" type="text" class="form-control" name="cl_total_from" id="cl_total_from">
                            </div>
                        </div>
                        <div class="form-group" id="file_group">
                            <label class="control-label col-md-3">Attachment File</label>
                            <div class="col-md-4">
                                <div class="err">
                                    <input type="hidden" name="ca_file_temp" id="ca_file_temp" value="<?=$cl->cl_file;?>">
                                    <?php
                                    if (!empty($cl->cl_file)) {
                                        ?>
                                        <a href="{{ URL::to(env('PUBLIC_PATH'). $cl->cl_file) }}" target='_blank'><i class='fa fa-file-image-o'></i></a>
                                    <?php }?>
                                    &nbsp;&nbsp;
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn green btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" value="" name="cl_file" id="cl_file"> </span>
                                        <span class="fileinput-filename"> </span> &nbsp;
                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                    </div>

                                </div>
                                <!--                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <span class="btn green btn-file">
                                                                        <span class="fileinput-new"> Select file </span>
                                                                        <span class="fileinput-exists"> Change </span>
                                                                        <input type="file" name="cl_file" id="cl_file"> </span>
                                                                    <span class="fileinput-filename"> </span> &nbsp;
                                                                    <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                                                </div>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Remark</label>
                            <div class="col-md-6 err">
                                <textarea name="cl_remark" id="cl_remark" cols="3" class="form-control"><?=$cl->cl_remark;?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <table id="ratestable" class="table table-bordered table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2">Currency rate / {{ date('l, d M Y') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <br>
                    <div class="form-group">
                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                            <table class="table table-bordered" id="detailtable">
                                <thead>
                                    <tr>
                                        <th width="3px">No</th>
                                        <?php if ($cl->cl_type == 1) {?>
                                            <th id="th_expense_1" width="20px">Description 
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_expense_2" width="10px">Amount
                                                <span class="required"> * </span>
                                            </th>
                                        <?php } else if ($cl->cl_type == 2) {?>
                                            <th id="th_travel_1" width="10px">Date Traveled
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_travel_2" width="15px">Location (From)
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_travel_3" width="15px">Location (To)
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_travel_4" width="20px">Reason
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_travel_5" width="5px">Distance (KM)
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_travel_6" width="10px">Mode of Transport
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_travel_7" width="15px">Parking
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_travel_8" width="15px">Toll
                                                <span class="required"> * </span>
                                            </th>
                                            <th id="th_travel_9" width="15px">Petrol
                                                <span class="required"> * </span>
                                            </th>
                                            <th width="2px"></th>
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($cl->detail)) {
                                        $numb = 0;
                                        foreach ($cl->detail as $key => $value) {
                                            $numb++;
                                            ?>
                                            <tr id="baris<?=$numb;?>">
                                                <td>
                                                    <span><?=$numb;?></span>
                                                </td>
                                                <?php if ($cl->cl_type == 1) {?>
                                                    <td>
                                                        <div class="err">
                                                            <input type="hidden" value="<?=$value->id;?>" name="cl_id_detail[]" id="cl_id_detail_<?=$numb;?>">
                                                            <input type="text" value="<?=$value->cl_description;?>" class="form-control" name="cl_description[]" id="cl_description_<?=$numb;?>" autocomplete="off">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_amount;?>" name="cl_amount[]" id="cl_amount_<?=$numb;?>" placeholder="0" onkeyup="valangka(this); loadgrandtotal();" class="form-control text-right" autocomplete="off">
                                                        </div>
                                                    </td>
                                                <?php } else if ($cl->cl_type == 2) {?>

                                                    <td id="td_travel_1_1">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_date_travel;?>" class="form-control datepicker" name="cl_travel_date[]" id="cl_travel_date_1">
                                                        </div>
                                                    </td>
                                                    <td id="td_travel_2_1">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_loc_from;?>" class="form-control" name="cl_travel_from[]" id="cl_travel_from_1">
                                                        </div>
                                                    </td>
                                                    <td id="td_travel_3_1">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_loc_to;?>" class="form-control" name="cl_travel_to[]" id="cl_travel_to_1">
                                                        </div>
                                                    </td>
                                                    <td id="td_travel_4_1">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_reason;?>" class="form-control" name="cl_travel_reason[]" id="cl_travel_reason_1">
                                                        </div>
                                                    </td>
                                                    <td id="td_travel_5_1">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_distance;?>" class="form-control" name="cl_travel_distance[]" id="cl_travel_distance_<?=$numb;?>" onchange="convert_mileage();">
                                                        </div>
                                                    </td>
                                                    <td id="td_travel_6_1">
                                                        <div class="err">
                                                            <select class="form-control" name="cl_travel_transport[]" id="cl_travel_transport_<?=$numb;?>" onchange="convert_mileage();">
                                                                <option value="Car" <?php if ($value->cl_transport == "Car") {?>selected="selected"<?php }?>>Car</option>
                                                                <option value="Motorbike" <?php if ($value->cl_transport == "Motorbike") {?>selected="selected"<?php }?>>Motorbike</option>
                                                            </select>
                                                            <input type="hidden" value="<?=$value->cl_mileage;?>" class="form-control" name="cl_travel_mileage[]" id="cl_travel_mileage_<?=$numb;?>">
                                                        </div>
                                                    </td>
                                                    <td id="td_travel_7_1">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_parking;?>" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_parking[]" id="cl_travel_parking_1">
                                                        </div>
                                                    </td>
                                                    <td id="td_travel_8_1">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_toll;?>" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_toll[]" id="cl_travel_toll_1">
                                                        </div>
                                                    </td>
                                                    <td id="td_travel_9_1">
                                                        <div class="err">
                                                            <input type="text" value="<?=$value->cl_petrol;?>" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_petrol[]" id="cl_travel_petrol_1">
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                <?php }?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td colspan="2" id="td_foot_btn_add">
                                            <span class="pull-right" style="padding: 10px 0;">Total :</span>
                                        </td>
                                        <td id="td_foot_expense_1"><span id="sub_tot_amount" class="pull-right" style="padding: 10px 10px;"></span></td>
    <!--                                        <td id="td_foot_expense_2"></td>-->

                                        <td id="td_foot_travel_1" style="display: none;"><span id="sub_tot_park" class="pull-right" style="padding: 10px 10px;"></span></td>
                                        <td id="td_foot_travel_2" style="display: none;"><span id="sub_tot_toll" class="pull-right" style="padding: 10px 10px;"></span></td>
                                        <td id="td_foot_travel_3" style="display: none;"><span id="sub_tot_pet" class="pull-right" style="padding: 10px 10px;"></span></td>
                                        <td id="td_foot_travel_4" style="display: none;"></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <!--                            <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                                                            <button class="btn btn-success btn-xs addmore" type="button">+ Add More</button>
                                                        </div>-->
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button id="btnSave" name="btnSubmit" value="btn_save" type="submit" class="btn btn-circle green">Submit</button>
                            <button id="btnDraft" name="btnSubmit" value="btn_draft" type="submit" class="btn btn-circle yellow">Save as Draft</button>
                            <a href="{{ URL::to('eleave/claim/index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>
            <!-- END FORM-->
        <?php }?>
    </div>
</div>

@endsection

@section('script')
@include('Eleave/notification')
<script type="text/javascript">
    $(document).ready(function () {
        loadgrandtotal();
        var form1 = $('#form_ca');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                select_multi: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                },
                'subject_name': {
                    required: "<font color='red'>required.</font",
                },
                'cl_description[]': {
                    required: "<font color='red'>Date required.</font>",
                },
                'cl_amount[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_file': {
                    extension: "Invalid file type",
                    filesize: "less than 2MB"
                }
            },
            rules: {
                "subject_name": {
                    required: true,
                },
                "cl_description[]": {
                    required: true,

                },
                "cl_amount[]": {
                    required: true
                },
                "cl_file": {
                    filesize: 2097152,
                    extension: "jpg|png|jpeg|pdf",
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                //App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                //error.appendTo($("div#errorContainer"));
                var cont = $(element).parent('.input-group');
                if (cont.size() > 0) {
                    cont.after(error);

                } else {
                    element.after(error);
                }

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.err').addClass('has-error');
//                $(element)
//                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                        .closest('.err').removeClass('has-error');
//                $(element)
//                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                //    $('#btnSave').text('Saving...'); //change button text
                //    $('#btnSave').attr('disabled', true); //set button disable 
                //success1.show();
                error1.hide();

                NProgress.start();
                var interval = setInterval(function () {
                    NProgress.inc();
                }, 10);

                jQuery(window).load(function () {
                    clearInterval(interval);
                    NProgress.done();
                });

                return true;
            }
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });

        setdatepicker();


        //adds extra table rows
        var i = $('#detailtable tr').length;
        var j = $('#detailtable tr').length - 1;
        $(".addmore").on('click', function () {

            html = '<tr id="baris' + i + '">';
            //html += '<td><input type="checkbox"/></td>';
            html += '<td><span>' + i + '</span>';
            html += '<td><div class="err"><input type="text" class="form-control" name="cl_description[]" id="cl_description_' + i + '" autocomplete="off"></div></td>';
            html += '<td><div class="err"><input type="text" name="cl_amount[]" id="cl_amount_' + i + '" onkeyup="valangka(this); loadgrandtotal();" class="form-control text-right subtot" placeholder="0" value="" autocomplete="off"></div></td>';

            html += '<td><a class="btn btn-xs red" onclick="delete_item(' + i + ')"><i class="glyphicon glyphicon-trash"></i></a></td>';
            html += '</tr>';
            $('#detailtable').append(html);
            // $('#cl_date_detail_' + i).focus();
            setdatepicker();
            i++;
            loadgrandtotal();

        });

        $("#btnSave").click(function () {
            $('#input_type').val('btn_save');
            if (!$("#form_ca").validate()) { // Not Valid
                return false;
            } else {

                $('#form_ca').submit();

            }
        });

        $.ajax({
            type: "POST",
            url: `${webUrl}eleave/claim/getLatestCurrency`,
            dataType: 'json',
            data: {
                endpoint: "latest",
                date: $('#cl_date').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.status == true) {
                    $.each(response.rates, function (key, value) {
                        html = '<tr>';
                        html += '<td nowrap> ' + key + '</td>';
                        html += '<td nowrap> ' + value + '</td>';
                        html += '</tr>';
                        $('#ratestable').append(html);
                    });
                } else {
                    html = '<tr>';
                    html += '<td colspan="2"> ' + response.msg + '</td>';
                    html += '</tr>';
                    $('#ratestable').append(html);
                    //alert(response.msg); // error 404 

                }
            }
        });

    });

    function loadgrandtotal() {
        var sum = 0;
        var park = 0;
        var toll = 0;
        var pet = 0;

        if ($('#cl_type').val() == 1) {
            $('input[name*="cl_amount[]"]').each(function () {
                var prodprice = Number($(this).val());
                sum += prodprice;
            });
            $("#cl_total_from").val(sum);

            $('#td_foot_btn_add').attr('colspan', 2);
            $('#td_foot_expense_1').show();
            $('#td_foot_expense_2').show();
            $('#td_foot_travel_1').hide();
            $('#td_foot_travel_2').hide();
            $('#td_foot_travel_3').hide();
            $('#td_foot_travel_4').hide();
            $("#sub_tot_amount").text(sum);
        }

        if ($('#cl_type').val() == 2) {
            var subTotal = 0;
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
            subTotal = park + toll + pet;

            $("#cl_total_from").val(subTotal);

            $('#td_foot_btn_add').attr('colspan', 7);

            $('#td_foot_expense_1').hide();
            $('#td_foot_expense_2').hide();
            $('#td_foot_travel_1').show();
            $('#td_foot_travel_2').show();
            $('#td_foot_travel_3').show();
            $('#td_foot_travel_4').show();

            $("#sub_tot_park").text(park);
            $("#sub_tot_toll").text(toll);
            $("#sub_tot_pet").text(pet);
        }



        if ($("#cl_total_from").val() != 0) {
            $.ajax({
                type: "GET",
                "url": "https://data.fixer.io/api/convert",
                dataType: 'json',
                data: {
                    access_key: "d375e0cc29b6ee4827b55b1962857a5a",
                    from: $('#cl_currency').val(),
                    to: "MYR",
                    amount: $('#cl_total_from').val(),
                    date: $('#cl_date').val(),
                },
                //cache: false,
                success: function (response) {
                    if (response.success == true) {
                        $("#cl_total_to").val(response.result);
                    }
                }
            });
        }
    }

    function convert_mileage() {

        var lastRow = $('input[name*="cl_travel_distance[]"]').length;

        for (a = 1; a <= lastRow; a++) {
            var distance = $('#cl_travel_distance_' + a).val();
            var mode_trans = $('#cl_travel_transport_' + a).val();
            var mil = (mode_trans == "Car" ? 0.60 : 0.30);

            $('#cl_travel_mileage_' + a).val(distance * mil);
        }

    }

    function setdatepicker() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            clearBtn: true,
            //forceParse: false,
            //calendarWeeks: true,
            //startView: 2,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
        });
    }

    function valangka(e) {
        if (!/^[0-9]+$/.test(e.value)) {
            e.value = e.value.substring(0, e.value.length - 1);
        }
    }

    function delete_item(rows) {
        if (confirm('Are you sure delete ?'))
        {
            $('table#detailtable tr#baris' + rows).remove();
            $('input[name*="cl_date_detail[]"]').each(function (i) {
                var i = i + 1;
                $(this).attr('id', 'cl_date_detail_' + i);
            });
            loadgrandtotal();
        }
    }


</script>

@endsection