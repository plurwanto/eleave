
<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInputEdit"  class="form form-horizontal">

    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="portlet-body form">
                        <div class="col-md-12 ">
                            <div class="form-body">
                                <div class="form-group validate">
                                    <label class="col-md-3 control-label">Title <font color="red">*</font></label>
                                    <div class="col-md-9">
                                    @php
                                        if($request->result->isrejected =='Y'){
                                            echo '<input type="text" autocomplete="off" value="'.$request->result->app_name.'" name="title" class="form-control"  readonly>';
                                        }else{
                                            echo '<input type="text" autocomplete="off" value="'.$request->result->app_name.'" name="title" class="form-control" >';
                                        }
                                    @endphp
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Priode <font color="red">*</font></label>
                                    <div class="col-md-5 validate">
                                    <select disabled class="form-control" name='month'>
                                        <option value="">-- Choose a Month --</option>
                                        @php
                                        $month =['January','February','March','April','May','June','July','August','September','October','November','December'];
                                        $month_num =['01','02','03','04','05','06','07','08','09','10','11','12'];

                                        for($i=0; $i < count($month); $i++){
                                            if($month_num[$i] == substr($request->result->period,0,2)){
                                                echo '<option value="'.$month_num[$i].'" selected>'.$month[$i].'</option>';
                                            }else{
                                                echo '<option value="'.$month_num[$i].'">'.$month[$i].'</option>';
                                            }
                                        }
                                        @endphp
                                    </select>
                                    </div>
                                    <div class="col-md-4 validate">
                                    @php
                                    echo '<input disabled type="number" autocomplete="off" name="year" value="'.substr($request->result->period,2,6).'" class="form-control" >';
                                    @endphp
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency <font color="red">*</font></label>
                                    <div class="col-md-5 validate">
                                    <select name="currency" id="currency" class="search-input-select form-control input-sm" onchange="get_data('currency')">
                                                <option value="">-- Choose a type --</option>
                                                @for($i = 0; $i < count($currency->result); $i++)
                                                    @if($currency->result[$i]->cur_id == $request->result->cur_id)
                                                        <option value="{{$currency->result[$i]->cur_id}}" selected>{{$currency->result[$i]->cur_name}}</option>
                                                    @else
                                                        <option value="{{$currency->result[$i]->cur_id}}">{{$currency->result[$i]->cur_name}}</option>
                                                    @endif
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4 validate" id="amountType"></div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">File <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        @php
                                        if($request->result->file !=''){
                                            echo 'File Latest :';
                                            $file2 ='';
                                            $file = explode(';', $request->result->file);
                                                for($a = 0; $a < count($file); $a++){
                                                    $file2 .= '<a href="'.URL::asset(env('APP_URL').'/hris/files/payroll/'). $request->result->file.'"><i class="fa fa-file"></i></a>&nbsp;';
                                                }
                                            echo  $file2;
                                            echo '<br>';
                                        }
                                        @endphp
                                        <div id="errorfile"></div>
                                        <div id="div_file">
                                            <div class="row">
                                                <div class="col-md-12 validate">
                                                    <input type="file" name="file1" id="file1" autocomplete="off" class="form-control">
                                                </div>
                                                <div class="col-md-12" id="actionfile_1" style="margin-top:10px;">
                                                    <a id="add_1" dataid="1" class="btn btn-primary" onclick="addFunctionfile(this);">
                                                        <font style="color:white">Add New</font>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group validate">
                                    <label class="col-md-3 control-label">Remark <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        <textarea name="remark" class="form-control">{{$request->result->remark}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group validate">
                                    <label class="col-md-3 control-label">Customer <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        <select disabled class="search-input-select form-control input-sm select2" onchange="get_data('next_user')">
                                            <option value="">-- Choose a customer --</option>
                                            @for($i = 0; $i < count($customer); $i++)
                                                @if($customer[$i]->cus_id == $request->result->cus_id)
                                                    <option value="{{$customer[$i]->cus_id}}" selected>{{$customer[$i]->cus_name}}</option>
                                                @else
                                                    <option value="{{$customer[$i]->cus_id}}">{{$customer[$i]->cus_name}}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group validate">
                                    <label class="col-md-3 control-label">Type <font color="red">*</font></label>
                                    <div class="col-md-9">
                                        <select disabled name="type" id="type" class="search-input-select form-control input-sm select2" onchange="get_data('next_user')">
                                                <option value="">-- Choose a type --</option>
                                                @for($i = 0; $i < count($MenuSetting->result); $i++)
                                                    @if($MenuSetting->result[$i]->menu_id == $request->result->menu_id)
                                                        <option value="{{$MenuSetting->result[$i]->menu_id}}" selected>{{$MenuSetting->result[$i]->menu_name}}</option>
                                                    @else
                                                        <option value="{{$MenuSetting->result[$i]->menu_id}}">{{$MenuSetting->result[$i]->menu_name}}</option>
                                                    @endif
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                                <div id="getApprover">
                                </div>
                        </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
        <input type="hidden" name="cus_id" id="customer" value="{{$request->result->cus_id}}">
        <input type="hidden" id="count_file" name="count_file" value="1">
        <input type="hidden" name="link" value="{{$link}}">
        <input type="hidden" name="id" id="id" value="{{$id}}">
        <input type="hidden" name="app_no" value="{{$request->result->app_no}}">
        <input type="hidden" name="app_code" value="{{$request->result->app_code}}">
        <input type="hidden" id="isrejected" value="{{$request->result->isrejected}}">

        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="submit" class="btn green" id="btnSubmit">Save changes</button>
    </div>
</form>


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
            get_data('currency');
            get_data('next_user');

              $('#formInputEdit').validate({
                rules: {
                    title: {
                        required: true
                    },
                    month: {
                        required: true
                    },
                    year: {
                        required: true
                    },
                    currency: {
                        required: true
                    },
                    amount: {
                        required: true
                    },
                    remark: {
                        required: true
                    },
                    cus_id: {
                        required: true
                    },
                    type: {
                        required: true
                    },
                    file1: {
                    required: function(element) {
                        if ($("#isrejected").val() == 'N') {
                            return false;
                        }else {
                            return true;
                        }
                    },

                    remote: "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/validate-name-file') }}"
                    },
                    file2: {
                        remote: "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/validate-name-file') }}"
                    },
                    file3: {
                        remote: "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/validate-name-file') }}"
                    },
                    file4: {
                        remote: "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/validate-name-file') }}"
                    },
                    file5: {
                        remote: "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/validate-name-file') }}"
                    },
                    file6: {
                        remote: "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/validate-name-file') }}"
                    },
                    user1: {
                        required: true
                    },
                    user2: {
                        required: true
                    },
                    user3: {
                        required: true
                    },
                    user4: {
                        required: true
                    },
                    user5: {
                        required: true
                    },
                    user6: {
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.validate').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.validate').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
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
                async: true,
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/doedit') }}",
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
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval') }}?master={{$link}}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                    } else {
                        swal({title: "Failed", text:data.message, type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval') }}?master={{$link}}";
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

        function get_data(val) {
        if (val == 'next_user') {
            var customer = document.getElementById("customer").value;
            var type = document.getElementById("type").value;
            var id = document.getElementById("id").value;

            if (type != '' && customer != '') {
                $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/getapproveredit') }}",
                        {
                            customer: customer,
                            type: type,
                            id: id

                        },
                        function (data) {
                            $("#getApprover").html(data);
                        });
            } else {
                $("#getApprover").html('');
            }

        }
        if (val == 'currency') {
            var currency = document.getElementById("currency").value;
            var isrejected = document.getElementById("isrejected").value;

            if (currency != '') {
                $("#amountType").html('<div class="input-group validate">\n\
                        <span class="input-group-addon">' + currency + '</span>\n\
                        <input type="text"  value="{{ number_format( $request->result->amount,0,',','.')}}" class="form-control" placeholder="Input Amount" name="amount"   oninput="formatRupiah(this)">\n\
                        <span class="input-group-addon">.00</span>\n\
                    </div>');
            } else {
                $("#amountType").html('');
            }

        }
    }

    function addFunctionfile(e) {
        dataid = $(e).attr('dataid');
        file = $('#file' + dataid).val();
        amount = $('#amount' + dataid).val();


        if (file == '') {
            var msg = '<div class="alert alert-danger alert-dismissable">Fields can not be empty</div>';
            $("#errorfile").html(msg);
            $('#errorfile').alert();
            $('#errorfile').fadeTo(2000, 500).slideUp(500, function () {
                $('#errorfile').hide();

            });
        } else {
            newdataid = parseInt(dataid) + 1;
            $('#actionfile_' + dataid).hide();

            htm = '<div class="row" id="rowfile' + newdataid + '" style="margin-top:10px">'+
                        '<div class="col-md-12 validate">'+
                            '<input type="file" name="file' + newdataid + '" id="file' + newdataid + '" autocomplete="off" class="form-control">'+
                        '</div>'+
                        '<div class="col-md-12" id="actionfile_' + newdataid + '" style="margin-top:10px;">'+
                            '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctionfile(this);">'+
                                '<font style="color:white">Add New</font>'+
                            '</a>'+
                            '&nbsp;'+
                            '<a id="delete_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-danger" onclick="deleteFunctionfile(this);">' +
                                '<i class="fa fa-minus" style="color:white"></i>' +
                            '</a>' +
                        '</div>'+
                    '</div>';

            $('#div_file').append(htm);
            $('#count_file').val(newdataid);
        }

    }

    function deleteFunctionfile(e) {
        dataid = $(e).attr('dataid');
        $('#actionfile_' + dataid).remove();
        newdataid = parseInt(dataid) - 1;
        $('#rowfile' + dataid).remove();
        $('#actionfile_' + newdataid).show();
        $('#count_file').val(newdataid);
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
