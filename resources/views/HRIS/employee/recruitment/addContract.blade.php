
@extends('HRIS/layout.main')
@section('title', 'Contract')
@section('breadcrumbs')
<div style="height: 30px;margin: 0px 0px 15px 0px;">
    <div class="page-title" style="
        border-right: 1px solid #cbd4e0;
        display: inline-block;
        float: left;
        padding-right: 15px;
        margin-right: 15px;">
    <h1 style="
        color: #697882;
        font-size: 22px;
        font-weight: 400;
        margin: 0;">{{$title}}</h1>
    </div>
    <ul class="page-breadcrumb breadcrumb pull-left" style="padding: 3px 0;">
        <li style="color: #697882;">{{$subtitle}}</li>
        <li><i class="fa fa-chevron-right" style="font-size: 13px; margin: unset; top: 0; padding-right: 5px;"></i></li>
        <li style="color: #697882;">{{$subtitle3}}</li>
        <li><i class="fa fa-chevron-right" style="font-size: 13px; margin: unset; top: 0; padding-right: 5px;"></i></li>
        <li style="color: #697882;">{{$subtitle4}}</li>
    </ul>
    <div class="pull-right">
    @php
    echo '<a  class="btn dark btn-outline btn-circle btn-md border-rounded" href="'. URL::asset(env('APP_URL').'/hris/employee/recruitment') .'">Back</a>';
    @endphp
    </div>
 </div>
@endsection


@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->


@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- BEGIN PAGE BREADCRUMBS -->
        @yield('breadcrumbs')

        <!-- END PAGE BREADCRUMBS -->

        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-body" style="padding: 8px 15px;">
                            <form id="formInput"  class="form form-horizontal">
                                <div class="row">
                                    <div class="col-md-12"  style="border-bottom: 1px solid #444d58; margin-bottom: 20px">
                                        <div style="padding: 0px 30px;" class="col-md-4">
                                            <div class="form-group form-margin-0">
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Customer <font color='red'>*</font></label>
                                                    <select class="form-control" name="customer" id="customer">
                                                        <option value="">-- Choose a customer --</option>
                                                        @php
                                                            for($i = 0; $i < count($customer); $i++){

                                                                if($employee->employee->cus_id == $customer[$i]->cus_id){
                                                                    echo '<option value="' . $customer[$i]->cus_id . '" selected>' . $customer[$i]->cus_name . '</option>';
                                                                }else{
                                                                    echo '<option value="' . $customer[$i]->cus_id . '">' . $customer[$i]->cus_name . '</option>';
                                                                }
                                                            }
                                                        @endphp
                                                    </select>
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Status <font color='red'>*</font></label>
                                                    <select data-column="5" name="status" id="status" class="search-input-select form-control input-sm" onchange="statusContract()">
                                                            <option value="">-- Choose a contract_status --</option>
                                                            @for($i = 0; $i < count($contract_status->result); $i++)
                                                            <option value="{{$contract_status->result[$i]->cont_sta_id}}">{{$contract_status->result[$i]->cont_sta_name}}</option>
                                                            @endfor
                                                    </select>
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Create Date <font color='red'>*</font></label>
                                                    <input name="date" id="date" type="text" autocomplete="off" class="form-control date-picker">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <!-- <div class="validate">
                                                    <label style="font-weight: bold;">Return Signed Contract</label>
                                                    <input name="sign_contract" id="sign_contract" type="text" autocomplete="off" class="form-control date-picker">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>-->
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Contract Start <font color='red'>*</font></label>
                                                    <input name="contract_start" id="contract_start" type="text" autocomplete="off" class="form-control date-picker">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Contract End <font color='red'>*</font></label>
                                                    <input name="contract_end" id="contract_end" type="text" autocomplete="off" class="form-control date-picker">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="padding: 0px 30px;">
                                            <div class="form-group form-margin-0">

                                                <div class="validate">
                                                    <label style="font-weight: bold;">Position <font color='red'>*</font></label>
                                                    <input name="position" id="position" type="text" autocomplete="off" class="form-control" value="{{$employee->employee->ro_position}}">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Division/Cost Center</label>
                                                    <input name="division" id="division" type="text" autocomplete="off" class="form-control">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Department</label>
                                                    <input name="departement" id="departement" type="text" autocomplete="off" class="form-control">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Project Name</label>
                                                    <input name="project_name" id="project_name" type="text" autocomplete="off" class="form-control">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Site Location <font color='red'>*</font></label>
                                                    <select name="site_location"  id="site_location" class="search-input-select form-control input-sm select2">
                                                        <option value="">-- Choose a Location --</option>
                                                        @for($i = 0; $i < count($contract_city->result); $i++)
                                                        <option value="{{$contract_city->result[$i]->cont_city_id}}">{{$contract_city->result[$i]->cont_city_name}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="padding: 0px 30px;">
                                            <div class="form-group form-margin-0">

                                                <div class="validate">
                                                    <label style="font-weight: bold;">Currency <font color='red'>*</font></label>
                                                    <select name="currency" id="currency" class="search-input-select form-control input-sm select2">
                                                        <option value="">-- Choose a Location --</option>
                                                        @for($i = 0; $i < count($currency->result); $i++)
                                                        <option value="{{$currency->result[$i]->cur_id}}">{{$currency->result[$i]->cur_name}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Basic salary / Onshore <font color='red'>*</font></label>
                                                    <input name="basic_salary" id="basic_salary" type="text" autocomplete="off" class="form-control"  oninput="formatRupiah(this)">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Note</label>
                                                    <input name="note" id="note" type="text" autocomplete="off" class="form-control">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                                <div class="validate">
                                                    <label style="font-weight: bold;">Payday Date <font color='red'>*</font></label>
                                                    <input name="payday_date" id="payday_date" type="number" min="1" max="31" autocomplete="off" class="form-control">
                                                </div>
                                                <div style="clear: both; margin-bottom: 10px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="portlet-body" style="padding: 8px 15px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="padding: 0px 30px;" class="col-md-12">
                                                    <div class="form-group form-margin-0">
                                                        <div>
                                                            <label style="font-weight: bold;">Allowance</label>
                                                            <div id="errorallowance"></div>
                                                            <div id="div_allowance">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <small>Allowance Type</small>
                                                                        <select name="allowance_type[]" id="allowance_type0" class="search-input-select form-control input-sm select2 allowance_type">
                                                                                <option value="">-- Choose a contract_status --</option>
                                                                                @for($i = 0; $i < count($allowance->result); $i++)
                                                                                <option value="{{$allowance->result[$i]->fix_allow_type_id}}">{{$allowance->result[$i]->fix_allow_type_name}}</option>
                                                                                @endfor
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4 validate">
                                                                        <small>Amount</small>
                                                                        <input type="text" name="amount[]" id="amount0" autocomplete="off" class="form-control amount"  oninput="formatRupiah(this)">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <small>Description</small>
                                                                        <textarea name="description[]" id="description0" class="form-control description"></textarea>
                                                                    </div>
                                                                    <div class="col-md-12" id="actionallowance_0" style="margin-top:10px;">
                                                                        <a id="add_0" dataid="0" class="btn btn-primary" onclick="addFunctionallowance(this);">
                                                                            <font style="color:white">Add New</font>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="clear: both; margin-bottom: 10px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <input type="hidden" name="employee_id" id="employee_id" autocomplete="off" value="{{$employee_id}}">
                                        @php
                                        echo '<a href="'. URL::asset(env('APP_URL').'/hris/employee/others').'" type="button" class="btn dark btn-outline">Close</a>';
                                        @endphp
                                    <button type="submit" class="btn green" id="btnSubmit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<div class="modal fade bs-modal-md portlet" id="alert-notif" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">


    <div class="modal-content">
      <div class="modal-body">
      <table width="60%">
        <tr>
            <td style="width:200px">Customer</td><td style="width:15px">:</td><td><span id="cus_mod"></span></td>
        </tr>
        <tr>
            <td>Create Date</td><td>:</td><td><span id="create_date_mod"></span></td>
        </tr>
        <!-- <tr>
            <td>Return Signed Contract</td><td>:</td><td><span id="return_sign_mod"></span></td>
        </tr> -->
        <tr>
            <td>Contract Start</td><td>:</td><td><span id="start_date_mod"></span></td>
        </tr>
        <tr>
            <td>Contract End</td><td>:</td><td><span id="end_date_mod"></span></td>
        </tr>
        <tr>
            <td>Position</td><td>:</td><td><span id="position_mod"></span></td>
        </tr>
        <tr>
            <td>Division/Cost Center</td><td>:</td><td><span id="division_mod"></span></td>
        </tr>
        <tr>
            <td>Department</td><td>:</td><td><span id="department_mod"></span></td>
        </tr>
        <tr>
            <td>Project Name</td><td>:</td><td><span id="project_mod"></span></td>
        </tr>
        <tr>
            <td>Status</td><td>:</td><td><span id="status_mod"></span></td>
        </tr>
        <tr>
            <td>Site Location</td><td>:</td><td><span id="site_mod"></span></td>
        </tr>
        <tr>
            <td>Currency</td><td>:</td><td><span id="currency_mod"></span></td>
        </tr>
        <tr>
            <td>Basic salary / Onshore</td><td>:</td><td><span id="basic_salary_mod"></span></td>
        </tr>
        <tr>
            <td>Note</td><td>:</td><td><span id="note_mod"></span></td>
        </tr>
        <tr>
            <td>Payday Date</td><td>:</td><td><span id="payday_mod"></span></td>
        </tr>
      </table>
      <br>
      <strong> Allowance </strong>
      <br><br>
      <table width="60%" id="allowanceArea">
      </table>
      </div>
      <div class="modal-footer" style="text-align: center">
      Are you sure want to process ?<br><br>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="buttonConfrim">Yes</button>
      </div>
    </div>


    </div>
    <!-- /.modal-dialog -->
</div>


@endsection

@section('script')

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'components-select2.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'form-validation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->


<script type="text/javascript">
        $(document).ready(function () {
            status = $('#status').val();
            $('#formInput').validate({
                rules: {
                    customer: {
                        required: true
                    },
                    date: {
                        required: true
                    },
                    position: {
                        required: true
                    },
                    contract_start: {
                        required: true
                    },
                    contract_end: {
                        required: function(element) {
                            if (status == 3) {
                                return false;
                            }else {
                                return true;
                            }
                        },
                    },
                    Position: {
                        required: true
                    },
                    status: {
                        required: true,
                    },
                    site_location: {
                        required: true
                    },
                    currency: {
                        required: true
                    },
                    basic_salary: {
                        required: true
                    },
                    payday_date: {
                        required: true
                    },
                    'amount[]': {

                    },
                },
                highlight: function (element) {
                    $(element).closest('.validate').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.validate').removeClass('has-error').addClass('has-success');
                },

                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
        //submit Detail Contract

        $(document).on("submit", "#formInput", function (event)
        {
            preview();

            return false;
        });

        $("#buttonConfrim").click(function(){
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInput')[0];
            // Create an FormData object
            var data = new FormData(form);
            // If you want to add an extra field for the FormData
            data.append("CustomField", "This is some extra data, testing");
            // disabled the submit button
            $("#btnSubmit").prop("disabled", true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    url: "{{ URL::asset(env('APP_URL').'/hris/administration/contract/doadd') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {

                        $('#modalAction').modal('hide');
                        toastr.success('Add successfully');
                        setTimeout(function () {
                            window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract/detail') }}?link="+data.customer+"&id="+data.cont_id;
                        }, 1000);

                    } else {
                        swal({title: "Failed", text:data.message, type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/employee/recruitment') }}?link="+data.customer;
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                    }
                },
                error: function (e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
            event.stopImmediatePropagation();
        })


    function addFunctionallowance(e) {
        dataid = $(e).attr('dataid');
        allowance_type = $('#allowance_type' + dataid).val();
        amount = $('#amount' + dataid).val();


        if (allowance_type == '' || amount == "") {
            var msg = '<div class="alert alert-danger alert-dismissable">Fields can not be empty</div>';
            $("#errorallowance").html(msg);
            $('#errorallowance').alert();
            $('#errorallowance').fadeTo(2000, 500).slideUp(500, function () {
                $('#errorallowance').hide();

            });
        } else {
            newdataid = parseInt(dataid) + 1;
            $('#actionallowance_' + dataid).hide();

            htm = '<div class="row" id="rowallowance' + newdataid + '" style="margin-top:10px">'+
                        '<div class="col-md-4">'+
                            '<select name="allowance_type[]" id="allowance_type' + newdataid + '" class="search-input-select form-control input-sm select2 allowance_type">'+
                                    '<option value="">-- Choose a contract_status --</option>'+
                                    '@for($i = 0; $i < count($allowance->result); $i++)'+
                                    '<option value="{{$allowance->result[$i]->fix_allow_type_id}}">{{$allowance->result[$i]->fix_allow_type_name}}</option>'+
                                    '@endfor'+
                            '</select>'+
                        '</div>'+
                        '<div class="col-md-4 validate">'+
                            '<input type="text" name="amount[]" id="amount' + newdataid + '" autocomplete="off" class="form-control amount"  oninput="formatRupiah(this)">'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<textarea name="description[]" id="description' + newdataid + '" class="form-control description"></textarea>'+
                        '</div>'+
                        '<div class="col-md-12" id="actionallowance_' + newdataid + '" style="margin-top:10px;">'+
                            '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctionallowance(this);">'+
                                '<font style="color:white">Add New</font>'+
                            '</a>'+
                            '&nbsp;'+
                            '<a id="delete_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-danger" onclick="deleteFunctionallowance(this);">' +
                                '<i class="fa fa-minus" style="color:white"></i>' +
                            '</a>' +
                        '</div>'+



                    '</div>';

            $('#div_allowance').append(htm);
        }

    }

    function deleteFunctionallowance(e) {
        dataid = $(e).attr('dataid');
        $('#actionallowance_' + dataid).remove();
        newdataid = parseInt(dataid) - 1;
        $('#rowallowance' + dataid).remove();
        $('#actionallowance_' + newdataid).show();
    }


    function statusContract(){
        status = $('#status').val();
            if(status == 3){
                $("#contract_end").prop("disabled", true);
            }else{
                $("#contract_end").prop("disabled", false);
            }
    }

function preview(){
    $('#alert-notif').modal('show');

    $('#cus_mod').html($('#customer  option:selected').text());
            $('#create_date_mod').html($('#date').val());
            $('#return_sign_mod').html($('#sign_contract').val());
            $('#start_date_mod').html($('#contract_start').val());
            $('#end_date_mod').html($('#contract_end').val());
            $('#position_mod').html($('#position').val());
            $('#division_mod').html($('#division').val());
            $('#department_mod').html($('#departement').val());
            $('#project_mod').html($('#project_name').val());
            $('#status_mod').html($('#status  option:selected').text());
            $('#site_mod').html($('#site_location   option:selected').text());
            $('#currency_mod').html($('#currency   option:selected').text());
            $('#basic_salary_mod').html($('#basic_salary').val());
            $('#note_mod').html($('#note').val());
            $('#payday_mod').html($('#payday_date').val());
            // console.log($('.amount')[1].value)
            var allowance = ''
            $.each($('.amount'), function(i,v){
                var allow = $(`.allowance_type option:selected`)[i].text
                if(v.value != undefined &&	v.value != ""){
                    // var title1 = $('#allowance_type1   option:selected').text();
                    allowance +=`<tr>
                                    <td style="width:200px">${allow}</td><td style="width:15px">:</td><td>${v.value}</td>
                                </tr>`
                }
            })

            $('#allowanceArea').html(allowance)


}

function formatRupiah(e){
        var angka = e.value;
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        e.value = rupiah
    }
</script>
@endsection
