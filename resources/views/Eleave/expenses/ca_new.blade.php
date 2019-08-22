@extends('Eleave.layout.main')

@section('title','Eleave | Cash Advance Add')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-dollar"></i>Cash Advance Form
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <!-- BEGIN FORM-->
        <form action="{{ URL::to(env('APP_URL').'/eleave/cash_advance/insert') }}" class="form-horizontal" method="post" id="form_ca">
            <div class="form-body">
                <!--                <div class="alert alert-danger display-hide" id="errorContainer">
                                    <button class="close" data-close="alert"></button> 
                                    You have some form errors. Please check below. </div>-->
                <div id='errorbox'></div>
                <input type="hidden" name="employee_id" id="employee_id" value="{{session('id')}}" >
                <input type="hidden" name="input_type" id="input_type" value="" >
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Subject</label>
                        <div class="col-md-6 err">
                            <input type="text" class="form-control" placeholder="Enter subject" name="subject_name" id="subject_name" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Total</label>
                        <div class="col-md-4">
                            <input readonly="readonly" type="text" class="form-control" name="ca_total" id="ca_total" value="0">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <input type="hidden" class="form-control" name="ca_date" id="ca_date" value="{{ date('Y-m-d') }}">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Date</label>
                        <label class="col-md-2 control-label" id="sp_ca_date">{{ date('Y-m-d') }}</label>
                    </div>
                </div>

                <!--                <div class="form-group" id="file_group" style="display:none;">
                                    <label class="control-label col-md-3">Attach Supporting Document</label>
                                    <div class="col-md-4">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn green btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="ts_file" id="ts_file"> </span>
                                            <span class="fileinput-filename"> </span> &nbsp;
                                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                        </div>
                                    </div>
                                </div>-->
                <br>
                <div class="form-group">
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                        <table class="table table-bordered" id="detailtable">
                            <thead>
                                <tr>
                                    <th width="10%">Date</th>
                                    <th width="15%">Project Cost Center</th>
                                    <th width="30%">Detail</th>
                                    <th width="10%">Amount</th>
                                    <th width="2%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="baris1">
                                    <td>
                                        <div class="err">
                                            <input type="text" class="form-control datepicker row-id" placeholder="Enter date" name="ca_date_detail[]" id="ca_date_detail_1" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="err">
                                            <input type="text" class="form-control" name="ca_project[]" id="ca_project_1" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="err">
                                            <input type="text" class="form-control" name="ca_detail[]" id="ca_detail_1" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="err">
                                            <input type="text" name="ca_amount[]" id="ca_amount_1" placeholder="0" onkeyup="valangka(this); loadgrandtotal();" class="form-control text-right" value="" autocomplete="off">
                                        </div>
                                    </td>

                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                            <button class="btn btn-success btn-xs addmore" type="button">+ Add More</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button id="btnSave" name="btnSave" value="btn_save" type="submit" class="btn btn-circle green">Submit</button>
                        <a href="{{ URL::to('eleave/cash_advance?index=1') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
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
                'ca_date_detail[]': {
                    required: "<font color='red'>Date required.</font>",
                },
                'ca_project[]': {
                    required: "<font color='red'>required.</font",
                },
                'ca_detail[]': {
                    required: "<font color='red'>required.</font",
                },
                'ca_amount[]': {
                    required: "<font color='red'>required.</font",
                },
                'ca_file': {
                    extension: "Invalid file type",
                    filesize: "less than 2MB"
                }
            },
            rules: {
                "subject_name": {
                    required: true,
                },
                "ca_date_detail[]": {
                    required: true,

                },
                "ca_project[]": {
                    required: true,
                },
                "ca_detail[]": {
                    required: true,
                },
                "ca_amount[]": {
                    required: true
                },
                "ca_file": {
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
                $('#btnSave').text('Saving...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 
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
            html += '<td><div class="err"><input type="text" class="form-control datepicker row-id" placeholder="Enter date" name="ca_date_detail[]" id="ca_date_detail_' + i + '" autocomplete="off"></div></td>';
            html += '<td><div class="err"><input type="text" class="form-control" name="ca_project[]" id="ca_project_' + i + '" autocomplete="off"></div></td>';
            html += '<td><div class="err"><input type="text" class="form-control" name="ca_detail[]" id="ca_detail_' + i + '" autocomplete="off"></div></td>';
            html += '<td><div class="err"><input type="text" name="ca_amount[]" id="ca_amount_' + i + '" onkeyup="valangka(this); loadgrandtotal();" class="form-control text-right subtot" placeholder="0" value="" autocomplete="off"></div></td>';
            html += '<td><a class="btn btn-xs red" onclick="delete_item(' + i + ')"><i class="glyphicon glyphicon-trash"></i></a></td>';
            html += '</tr>';
            $('#detailtable').append(html);
            // $('#ca_date_detail_' + i).focus();
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

    });

    function loadgrandtotal() {
        var sum = 0;
        $('input[name*="ca_amount[]"]').each(function () {
            var prodprice = Number($(this).val());
            sum += prodprice;
        });
        $("#ca_total").val(sum);
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
            $('input[name*="ca_date_detail[]"]').each(function (i) {
                var i = i + 1;
                $(this).attr('id', 'ca_date_detail_' + i);
            });
            loadgrandtotal();
        }
    }


</script>

@endsection