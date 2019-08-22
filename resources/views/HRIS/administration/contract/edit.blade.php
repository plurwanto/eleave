
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
    </ul>
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

            <div class="portlet light ">
                <form id="formInputEdit"  class="form form-horizontal">
                    <div class="page-content-inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="col-md-12" align="center" style="margin-bottom:50px">
                                        <h4 style="margin-left:100px"><label style="font-weight: bold; text-transform: uppercase">{{$subtitle. $contract->contract->mem_name}}</label></h4>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Customer <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <select class="form-control" disabled id="customer">
                                                    <option value="">-- Choose a customer --</option>
                                                    @php
                                                        for($i = 0; $i < count($customer); $i++){
                                                            if($customer[$i]->cus_id == $link){
                                                                echo '<option value="'.$customer[$i]->cus_id.'" selected>'.$customer[$i]->cus_name.'</option>';
                                                            }else{
                                                                echo '<option value="'.$customer[$i]->cus_id.'">'.$customer[$i]->cus_name.'</option>';
                                                            }
                                                        }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Status <font color="red">*</font></label>
                                            <div class="col-md-9">
                                            @if($contract->contract->cont_sta_id == 4)
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="4" name="status" id="status" onclick="$('#contract_end').prop('disabled', false);" disabled checked> Kemitraan (Partnership)</label>
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="2" name="status" id="status" onclick="$('#contract_end').prop('disabled', false);" disabled> PKWT (Contract)</label>
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="3" name="status" id="status" onclick="$('#contract_end').prop('disabled', true);" disabled> PKWTT (Permanent)</label>
                                            @elseif($contract->contract->cont_sta_id == 2)
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="4" name="status" id="status" onclick="$('#contract_end').prop('disabled', false);" disabled> Kemitraan (Partnership)</label>
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="2" name="status" id="status" onclick="$('#contract_end').prop('disabled', false);" disabled checked> PKWT (Contract)</label>
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="3" name="status" id="status" onclick="$('#contract_end').prop('disabled', true);" disabled> PKWTT (Permanent)</label>
                                            @elseif($contract->contract->cont_sta_id == 3)
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="4" name="status" id="status" onclick="$('#contract_end').prop('disabled', false);" disabled> Kemitraan (Partnership)</label>
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="2" name="status" id="status" onclick="$('#contract_end').prop('disabled', false);" disabled> PKWT (Contract)</label>
                                                <label style="margin-right:20px"><input type="radio" autocomplete="off" value="3" name="status" id="status" onclick="$('#contract_end').prop('disabled', true);" disabled checked> PKWTT (Permanent)</label>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Project Name</label>
                                            <div class="col-md-9">
                                                <input name="project_name" value="{{ $contract->contract->cont_project}}" type="text" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Position <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <input name="position" value="{{ $contract->contract->cont_position}}" type="text" autocomplete="off" class="form-control ">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Department</label>
                                            <div class="col-md-9">
                                                <input name="departement" value="{{ $contract->contract->cont_dept}}" type="text" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Division/Cost Center</label>
                                            <div class="col-md-9">
                                                <input name="division" value="{{ $contract->contract->cont_div}}" type="text" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Site Location <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <select data-column="5" name="site_location" class="search-input-select form-control input-sm select2">
                                                    <option value="">-- Choose a Location --</option>
                                                    @for($i = 0; $i < count($contract_city->result); $i++)
                                                        @if($contract_city->result[$i]->cont_city_id == $contract->contract->cont_city_id)
                                                            <option value="{{$contract_city->result[$i]->cont_city_id}}" selected>{{$contract_city->result[$i]->cont_city_name}}</option>
                                                        @else
                                                            <option value="{{$contract_city->result[$i]->cont_city_id}}">{{$contract_city->result[$i]->cont_city_name}}</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Create Date <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <input name="date" value="{{ $contract->contract->cont_date}}" type="text" autocomplete="off" class="form-control date-picker">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Contract Start <font color="red">*</font></label>
                                            <div class="col-md-3">
                                                <input name="contract_start"  value="{{ $contract->contract->cont_start_date}}" type="text" autocomplete="off" class="form-control date-picker">
                                            </div>
                                            <div>
                                                <label class="col-md-2 control-label" style="font-weight: bold;">Contract End<font color="red">*</font></label>
                                                <div class="col-md-4">
                                                    <input name="contract_end" id="contract_end"  value="{{ $contract->contract->cont_end_date}}" type="text" autocomplete="off" class="form-control date-picker">
                                                </div>
                                            </div>
                                        </div>
                                        @if($contract->contract->mem_citizenship == 'expatriate')
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Currency <font color="red">*</font></label>
                                            <div class="col-md-3">
                                                <select data-column="5" name="currency" class="search-input-select form-control input-sm">
                                                    <option value="">-- Choose a Location --</option>
                                                    @for($i = 0; $i < count($currency->result); $i++)
                                                        @if($currency->result[$i]->cur_id == $contract->contract->cur_id)
                                                            <option value="{{$currency->result[$i]->cur_id}}" selected>{{$currency->result[$i]->cur_name}}</option>
                                                        @else
                                                            <option value="{{$currency->result[$i]->cur_id}}">{{$currency->result[$i]->cur_name}}</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                            <div>
                                                <label class="col-md-2 control-label" style="font-weight: bold;">Onshore <font color="red">*</font></label>
                                                <div class="col-md-4">
                                                    <input name="basic_salary" value="{{ $contract->contract->cont_basic_salary}}" type="text" autocomplete="off" class="form-control"  oninput="formatRupiah(this)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Offshore <font color="red">*</font></label>
                                            <div class="col-md-3">
                                                <input name="offshore" value="{{ $contract->contract->cont_offshore}}" type="text" autocomplete="off" class="form-control"  oninput="formatRupiah(this)">
                                            </div>
                                        </div>
                                        @else
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Currency <font color="red">*</font></label>
                                            <div class="col-md-3">
                                                <select data-column="5" name="currency" class="search-input-select form-control input-sm">
                                                    <option value="">-- Choose a Location --</option>
                                                    @for($i = 0; $i < count($currency->result); $i++)
                                                        @if($currency->result[$i]->cur_id == $contract->contract->cur_id)
                                                            <option value="{{$currency->result[$i]->cur_id}}" selected>{{$currency->result[$i]->cur_name}}</option>
                                                        @else
                                                            <option value="{{$currency->result[$i]->cur_id}}">{{$currency->result[$i]->cur_name}}</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                            <div>
                                                <label class="col-md-2 control-label" style="font-weight: bold;">Onshore <font color="red">*</font></label>
                                                <div class="col-md-4">
                                                    <input name="basic_salary" value="{{ $contract->contract->cont_basic_salary}}" type="text" autocomplete="off" class="form-control"  oninput="formatRupiah(this)">
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" style="font-weight: bold;">Payday Date <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <input name="payday_date" value="{{ $contract->contract->ctrx_mem_pay_tgl}}" type="number" min="1" max="31" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="margin-bottom:30px;margin-top:10px; color:#3399FF">
                                        <h4 style="margin-left:50px"><i class="fa fa-usd" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<label style="font-weight: bold">ALLOWANCE</label></h4>
                                        <hr>
                                        <div id="errorallowance"></div>
                                    </div>
                                    <div class="col-md-12" id="div_allowance">
                                        @php
                                            if(count($contract->allowance)>0){
                                            $a=1;
                                                for($i = 0; $i < count($contract->allowance); $i++){
                                                echo'
                                                <div id="unik'.$i.'">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" style="font-weight: bold;">Allowance Type</label>
                                                        <div class="col-md-9">
                                                            <select data-column="5" name="allowance_type[]" id="allowance_type'.$a.'" class="search-input-select form-control input-sm select2">
                                                                <option value="">-- Choose a contract_status --</option>';
                                                                for($a = 0; $a < count($allowance->result); $a++){
                                                                    if($allowance->result[$a]->fix_allow_type_id == $contract->allowance[$i]->fix_allow_type_id){
                                                                        echo'<option value="'.$allowance->result[$a]->fix_allow_type_id.'" selected>'.$allowance->result[$a]->fix_allow_type_name.'</option>';
                                                                    }else{
                                                                        echo'<option value="'.$allowance->result[$a]->fix_allow_type_id.'">'.$allowance->result[$a]->fix_allow_type_name.'</option>';

                                                                    }
                                                                }
                                                        echo'</select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" style="font-weight: bold;">Amount</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="amount[]" value="'.$contract->allowance[$i]->cont_det_tot.'" id="amount'.$a.'" autocomplete="off" class="form-control"  oninput="formatRupiah(this)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" style="font-weight: bold;">Description</label>
                                                        <div class="col-md-9">
                                                            <textarea name="description[]" id="description'.$a.'" class="form-control">'.$contract->allowance[$i]->cont_det_desc.'</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="actionallowance_0">
                                                        <div class="col-md-12">
                                                            <a id="unik'.$i.'" dataid="unik'.$i.'" class="btn red btn-outline btn-circle btn-md border-rounded pull-right" onclick="deleteFunctionallowance(this);">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>&nbsp;&nbsp;<font>Delete</font>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>';
                                                }
                                            }else{
                                                echo'
                                                <div id="unik1">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" style="font-weight: bold;">Allowance Type</label>
                                                        <div class="col-md-9">
                                                            <select data-column="5" name="allowance_type[]" id="allowance_type1" class="search-input-select form-control input-sm">
                                                                <option value="">-- Choose a contract_status --</option>';
                                                                for($i = 0; $i < count($allowance->result); $i++){
                                                                echo '<option value="'.$allowance->result[$i]->fix_allow_type_id.'">'.$allowance->result[$i]->fix_allow_type_name.'</option>';
                                                                }
                                                        echo'</select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" style="font-weight: bold;">Amount</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="amount[]" id="amount1" autocomplete="off" class="form-control"  oninput="formatRupiah(this)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" style="font-weight: bold;">Description</label>
                                                        <div class="col-md-9">
                                                            <textarea name="description[]" id="description1" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="actionallowance_0">
                                                        <div class="col-md-12">
                                                            <a id="unik1" dataid="unik1" class="btn red btn-outline btn-circle btn-md border-rounded pull-right" onclick="deleteFunctionallowance(this);">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>&nbsp;&nbsp;<font>Delete</font>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>';
                                            }
                                        @endphp
                                    </div>
                                    <div class="col-md-12">
                                        <a id="add_0" dataid="0" class="btn blue btn-outline btn-circle btn-md border-rounded pull-right" onclick="addFunctionallowance(this);">
                                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;<font>Add new allowance</font>
                                        </a>
                                    </div>
                                    <div class="col-md-12" style="margin-bottom:30px;margin-top:10px;">
                                    <hr>
                                    </div>
                                    <div class="col-md-12"  style="font-weight: bold;">Note</div>
                                    <div class="col-md-12">
                                        <textarea name="note" class="form-control">{{ $contract->contract->cont_note}}</textarea>
                                    </div>
                                    <div class="col-md-12"  style="font-weight: bold; margin-top:10px">
                                        <div style="text-align:center">
                                            <input type="hidden" name="customer" id="customer" autocomplete="off" value="{{ $contract->contract->cus_id}}">
                                            <input type="hidden" name="employee_id" id="employee_id" autocomplete="off" value="{{ $contract->contract->mem_id}}">
                                            <input type="hidden" name="cont_id" value="{{ $contract->contract->cont_id}}" class="form-control">
                                            <span style="float:left">
                                                @php
                                                    if($link){
                                                        echo '<a href="'. URL::asset(env('APP_URL').'/hris/administration/contract').'?link='. $link .'" type="button" class="btn blue btn-outline btn-circle btn-md border-rounded pull-right" style="width:350px">Close</a>';
                                                    }else{
                                                        echo '<a href="'. URL::asset(env('APP_URL').'/hris/administration/contract') .'" type="button" class="btn blue btn-outline btn-circle btn-md border-rounded pull-right" style="width:350px">Close</a>';
                                                    }
                                                @endphp
                                            </span>
                                            <span>
                                                <button type="submit" class="btn blue btn-circle btn-md border-rounded pull-right" style="width:350px" id="btnSubmit">Update Contract</button>
                                            </span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
            statusContract();
            $('#formInputEdit').validate({
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
                    offshore: {
                        required: true
                    },
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
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
        $(document).on("submit", "#formInputEdit", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInputEdit')[0];
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
                url: "{{ URL::asset(env('APP_URL').'/hris/administration/contract/doedit') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                        swal({title: "Input Successfully", type: "success"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract') }}?link="+data.customer;
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                    } else {
                        swal({title: "Failed", text:data.message, type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract') }}?link="+data.customer;
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
            return false;
        });


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
            htm = `
            <div id="${newdataid}">
            <hr>

                <div class="form-group">
                    <label class="col-md-3 control-label" style="font-weight: bold;">Allowance Type</label>
                    <div class="col-md-9">
                        <select name="allowance_type[]" id="allowance_type${newdataid}" class="search-input-select form-control input-sm select2 allowance_type">
                                <option value="">-- Choose a contract_status --</option>
                                @for($i = 0; $i < count($allowance->result); $i++)
                                <option value="{{$allowance->result[$i]->fix_allow_type_id}}">{{$allowance->result[$i]->fix_allow_type_name}}</option>
                                @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" style="font-weight: bold;">Amount</label>
                    <div class="col-md-9">
                        <input type="text" name="amount[]" id="amount${newdataid}" autocomplete="off" class="form-control amount"  oninput="formatRupiah(this)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" style="font-weight: bold;">Description</label>
                    <div class="col-md-9">
                        <textarea name="description[]" id="description${newdataid}" class="form-control description"></textarea>
                    </div>
                </div>
                <div class="form-group" id="actionallowance_${newdataid}">
                    <div class="col-md-12">
                        <a id="${newdataid}" dataid="${newdataid}" class="btn red btn-outline btn-circle btn-md border-rounded pull-right" onclick="deleteFunctionallowance(this);">
                            <i class="fa fa-trash" aria-hidden="true"></i>&nbsp;&nbsp;<font>Delete</font>
                        </a>
                    </div>
                </div>
            </div>`;

            $('#div_allowance').append(htm);
            $('#count_allowance').val(newdataid);
        }

    }

    function deleteFunctionallowance(e) {
        dataid = $(e).attr('dataid');
        $('#' + dataid).remove();
    }

    function handleSelect(elm)
            {
                if (elm.value != '') {
                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/contract/edit') }}?link="+ elm.value;
                }
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
