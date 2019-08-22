@extends('Eleave.layout.main')

@section('title','Eleave | Claim Add')

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
        <!-- BEGIN FORM-->
        <form action="{{ URL::to(env('APP_URL').'/eleave/claim/insert') }}" class="form-horizontal" method="post" id="form_ca" enctype="multipart/form-data">
            <div class="form-body">
                <input type="hidden" name="employee_id" id="employee_id" value="{{session('id')}}" >
                <div class="col-md-8">
                    <input type="hidden" class="form-control" name="cl_date" id="cl_date" value="{{ date('Y-m-d') }}">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Claim Date</label>
                        <label class="col-md-2 control-label" id="sp_cl_date">{{ date('d M Y') }}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Type</label>
                        <div class="col-md-4">
                            <select class="form-control" name="cl_type" id="cl_type">
                                <option value="1">Expense</option>
                                <option value="2">Travel</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Subject 
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6 err">
                            <input type="text" class="form-control" placeholder="Enter subject" name="subject_name" id="subject_name" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Total</label>
                        <div class="col-md-4">
                            <input readonly="readonly" type="text" class="form-control" name="cl_total_from" id="cl_total_from" value="0">
                            <input readonly="readonly" type="hidden" class="form-control" name="cl_total_to" id="cl_total_to" value="0">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="cl_currency" id="cl_currency">
                                <option value="MYR">MYR</option>
                                <option value="IDR">IDR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="file_group">
                        <label class="control-label col-md-3">Attachment File</label>
                        <div class="col-md-4">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn green btn-file">
                                    <span class="fileinput-new"> Select file </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="cl_file" id="cl_file"> </span>
                                <span class="fileinput-filename"> </span> &nbsp;
                                <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Remark</label>
                        <div class="col-md-6 err">
                            <textarea name="cl_remark" id="cl_remark" cols="3" class="form-control"></textarea>
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
                    <div class='col-md-12'>
                        <table class="table table-bordered" id="detailtable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th id="th_expense_1" width="300px">Description 
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_expense_2" width="30px">Amount
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_1" width="10px" style="display: none;">Date Traveled
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_2" width="15px" style="display: none;">Location (From)
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_3" width="15px" style="display: none;">Location (To)
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_4" width="15px" style="display: none;">Reason
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_5" width="5px" style="display: none;">Distance (KM)
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_6" width="10px" style="display: none;">Mode of Transport
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_7" width="15px" style="display: none;">Parking
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_8" width="15px" style="display: none;">Toll
                                        <span class="required"> * </span>
                                    </th>
                                    <th id="th_travel_9" width="15px" style="display: none;">Petrol
                                        <span class="required"> * </span>
                                    </th>
                                    <th width="20px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="baris1">
                                    <td>
                                        <span>1</span>
                                    </td>
                                    <td id="td_expense_1_1">
                                        <div class="err">
                                            <input type="text" class="form-control" name="cl_description[]" id="cl_description_1" autocomplete="off">
                                        </div>
                                    </td>
                                    <td id="td_expense_2_1">
                                        <div class="err">
                                            <input type="text" name="cl_amount[]" id="cl_amount_1" placeholder="0" onkeyup="valangka(this); loadgrandtotal();" class="form-control text-right" value="" autocomplete="off">
                                        </div>
                                    </td>
                                    <td id="td_travel_1_1" style="display: none;">
                                        <div class="err">
                                            <input type="text" class="form-control datepicker" name="cl_travel_date[]" id="cl_travel_date_1">
                                        </div>
                                    </td>
                                    <td id="td_travel_2_1" style="display: none;">
                                        <div class="err">
                                            <input type="text" class="form-control" name="cl_travel_from[]" id="cl_travel_from_1">
                                        </div>
                                    </td>
                                    <td id="td_travel_3_1" style="display: none;">
                                        <div class="err">
                                            <input type="text" class="form-control" name="cl_travel_to[]" id="cl_travel_to_1">
                                        </div>
                                    </td>
                                    <td id="td_travel_4_1" style="display: none;">
                                        <div class="err">
                                            <input type="text" class="form-control" name="cl_travel_reason[]" id="cl_travel_reason_1">
                                        </div>
                                    </td>
                                    <td id="td_travel_5_1" style="display: none;">
                                        <div class="err">
                                            <input type="text" class="form-control" name="cl_travel_distance[]" id="cl_travel_distance_1" onchange="convert_mileage();">
                                        </div>
                                    </td>
                                    <td id="td_travel_6_1" style="display: none;">
                                        <div class="err">
                                            <select class="form-control" name="cl_travel_transport[]" id="cl_travel_transport_1" onchange="convert_mileage();">
                                                <option value="Car">Car</option>
                                                <option value="Motorbike">Motorbike</option>
                                            </select>
                                            <input type="hidden" class="form-control" name="cl_travel_mileage[]" id="cl_travel_mileage_1">
                                        </div>
                                    </td>
                                    <td id="td_travel_7_1" style="display: none;">
                                        <div class="err">
                                            <input type="text" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_parking[]" id="cl_travel_parking_1">
                                        </div>
                                    </td>
                                    <td id="td_travel_8_1" style="display: none;">
                                        <div class="err">
                                            <input type="text" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_toll[]" id="cl_travel_toll_1">
                                        </div>
                                    </td>
                                    <td id="td_travel_9_1" style="display: none;">
                                        <div class="err">
                                            <input type="text" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_petrol[]" id="cl_travel_petrol_1">
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="2" id="td_foot_btn_add">
                                        <button class="btn btn-outline-success addmore" style="border-radius:10px;" type="button"><i class="fa fa-plus text-primary"></i><span class="font-weight-bold ml-1"></span></button>
                                        <span class="pull-right" style="padding: 10px 0;">Total :</span>
                                    </td>
                                    <td id="td_foot_expense_1"><span id="sub_tot_amount" class="pull-right" style="padding: 10px 10px;"></span></td>
                                    <td id="td_foot_expense_2"></td>

                                    <td id="td_foot_travel_1" style="display: none;"><span id="sub_tot_park" class="pull-right" style="padding: 10px 10px;"></span></td>
                                    <td id="td_foot_travel_2" style="display: none;"><span id="sub_tot_toll" class="pull-right" style="padding: 10px 10px;"></span></td>
                                    <td id="td_foot_travel_3" style="display: none;"><span id="sub_tot_pet" class="pull-right" style="padding: 10px 10px;"></span></td>
                                    <td id="td_foot_travel_4" style="display: none;"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <!--                        <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
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
                'cl_file': {
                    extension: "Invalid file type",
                    filesize: "less than 2MB"
                },
                'cl_description[]': {
                    required: "<font color='red'>Date required.</font>",
                },
                'cl_amount[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_date[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_from[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_to[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_reason[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_distance[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_transport[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_parking[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_toll[]': {
                    required: "<font color='red'>required.</font",
                },
                'cl_travel_petrol[]': {
                    required: "<font color='red'>required.</font",
                },
            },
            rules: {
                "subject_name": {
                    required: true,
                },
                "cl_file": {
                    filesize: 2097152,
                    extension: "jpg|png|jpeg|pdf",
                },
                "cl_description[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 1;
                    },

                },
                "cl_amount[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 1;
                    },
                },
                "cl_travel_date[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
                },
                "cl_travel_from[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
                },
                "cl_travel_to[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
                },
                "cl_travel_reason[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
                },
                "cl_travel_distance[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
                },
                "cl_travel_transport[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
                },
                "cl_travel_parking[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
                },
                "cl_travel_toll[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
                },
                "cl_travel_petrol[]": {
                    required: function (element) {
                        return $("#cl_type").val() == 2;
                    },
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
        var i = $('#detailtable tbody tr').length + 1;
        var j = $('#detailtable tr').length - 1;
        $(".addmore").on('click', function () {

            html = '<tr id="baris' + i + '">';
            html += '<td class="align-middle"><span>' + i + '</span>';
            //var show = ($('#cl_type').val() == 1 ? 'style="display: none;"' : '');
            if ($('#cl_type').val() == 1) {
                var show = 'style="display: none;"';
            } else {
                var show = 'style="display: ;"';
            }

            if ($('#cl_type').val() == 2) {
                var show2 = 'style="display: none;"';
            } else {
                var show2 = 'style="display: ;"';
            }

            //   if ($('#cl_type').val() == 1) {
            html += '<td id="td_expense_1_' + i + '" ' + show2 + '><div class="err"><input type="text" class="form-control" name="cl_description[]" id="cl_description_' + i + '" autocomplete="off"></div></td>';
            html += '<td id="td_expense_2_' + i + '" ' + show2 + '><div class="err"><input type="text" name="cl_amount[]" id="cl_amount_' + i + '" onkeyup="valangka(this); loadgrandtotal();" class="form-control text-right subtot" placeholder="0" value="" autocomplete="off"></div></td>';
            //  }
            //   } else {
            html += '<td id="td_travel_1_' + i + '" ' + show + '><div class="err"><input type="text" class="form-control datepicker" name="cl_travel_date[]" id="cl_travel_date_' + i + '" autocomplete="off"></div></td>';
            html += '<td id="td_travel_2_' + i + '" ' + show + '><div class="err"><input type="text" class="form-control" name="cl_travel_from[]" id="cl_travel_from_' + i + '" autocomplete="off"></div></td>';
            html += '<td id="td_travel_3_' + i + '" ' + show + '><div class="err"><input type="text" class="form-control" name="cl_travel_to[]" id="cl_travel_to_' + i + '" autocomplete="off"></div></td>';
            html += '<td id="td_travel_4_' + i + '" ' + show + '><div class="err"><input type="text" class="form-control" name="cl_travel_reason[]" id="cl_travel_reason_' + i + '" autocomplete="off"></div></td>';
            html += '<td id="td_travel_5_' + i + '" ' + show + '><div class="err"><input type="text" class="form-control" name="cl_travel_distance[]" id="cl_travel_distance_' + i + '" onchange="convert_mileage();" autocomplete="off"></div></td>';
            html += '<td id="td_travel_6_' + i + '" ' + show + '><div class="err"><select class="form-control" name="cl_travel_transport[]" id="cl_travel_transport_' + i + '" onchange="convert_mileage();"><option value="Car">Car</option><option value="Motorbike">Motorbike</option></select><input type="hidden" class="form-control" name="cl_travel_mileage[]" id="cl_travel_mileage_' + i + '"></div></td>';
            html += '<td id="td_travel_7_' + i + '" ' + show + '><div class="err"><input type="text" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_parking[]" id="cl_travel_parking_' + i + '" autocomplete="off"></div></td>';
            html += '<td id="td_travel_8_' + i + '" ' + show + '><div class="err"><input type="text" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_toll[]" id="cl_travel_toll_' + i + '" autocomplete="off"></div></td>';
            html += '<td id="td_travel_9_' + i + '" ' + show + '><div class="err"><input type="text" class="form-control text-right" onkeyup="valangka(this); loadgrandtotal();" name="cl_travel_petrol[]" id="cl_travel_petrol_' + i + '" autocomplete="off"></div></td>';
            //  }
            html += '<td class="align-middle"><a class="" onclick="delete_item(' + i + ')"><i class="fa fa-times fa-2x text-danger"></i></a></td>';
            html += '</tr>';
            $('#detailtable').append(html);
            setdatepicker();
            i++;
            loadgrandtotal();

        });

        var lastRow = $('#detailtable tr').length + 2;
        // var rowCount = $('table#detailtable tr:last').index() + 1;

        $('#cl_type').on('change', function () {
            //   alert(rowCount);
            if (this.value == 2) {
                $('#th_expense_1').hide();
                $('#th_expense_2').hide();

                for (var i = 1; i < 10; i++) {
                    $('#th_travel_' + i).show();

                    for (var j = 1; j < lastRow; j++) {
                        // var x = j + 1;
                        $('#td_expense_1_' + j).hide();
                        $('#td_expense_2_' + j).hide();

                        $('#td_travel_' + i + '_' + j).show();
                        // $('table#detailtable tr#baris' + x).remove();
                    }
                }

                $('#td_foot_btn_add').attr('colspan', 7);

                $('#td_foot_expense_1').hide();
                $('#td_foot_expense_2').hide();
                $('#td_foot_travel_1').show();
                $('#td_foot_travel_2').show();
                $('#td_foot_travel_3').show();
                $('#td_foot_travel_4').show();


            } else {
                $('#th_expense_1').show('');
                $('#th_expense_2').show('');

                for (var i = 1; i < 10; i++) {
                    $('#th_travel_' + i).hide();

                    for (var j = 1; j < lastRow; j++) {
                        //      var x = j + 1;
                        $('#td_expense_1_' + j).show();
                        $('#td_expense_2_' + j).show();

                        $('#td_travel_' + i + '_' + j).hide();
                        //    $('table#detailtable tr#baris' + x).remove();
                    }
                }

                $('#td_foot_btn_add').attr('colspan', 2);
                $('#td_foot_expense_1').show();
                $('#td_foot_expense_2').show();
                $('#td_foot_travel_1').hide();
                $('#td_foot_travel_2').hide();
                $('#td_foot_travel_3').hide();
                $('#td_foot_travel_4').hide();

            }

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
            $("#sub_tot_park").text(park);
            $("#sub_tot_toll").text(toll);
            $("#sub_tot_pet").text(pet);
        }



        if ($("#cl_total_from").val() != 0) {
            $.ajax({
                type: "POST",
                url: `${webUrl}eleave/claim/getConvertCurrency`,
                dataType: 'json',
                data: {
                    endpoint: "convert",
                    from: $('#cl_currency').val(),
                    amount: $('#cl_total_from').val(),
                    date: $('#cl_date').val(),
                    "_token": "{{ csrf_token() }}"
                },
                //cache: false,
                success: function (response) {
                    if (response.status == true) {
                        $('#btnSave').attr('disabled', false);
                        $("#cl_total_to").val(response.result);
                    } else {
                        alert(response.msg); // error 404 
                        $('#btnSave').attr('disabled', true);
                    }
                }
            });
        }
    }

    $('#cl_currency').on('change', function () {
        loadgrandtotal();
    });

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