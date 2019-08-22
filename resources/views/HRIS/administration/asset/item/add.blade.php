<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInput"  class="form form-horizontal">
    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="portlet-body form">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Status <font color="red">*</font></label>
                            <div class="col-md-8">
                                <label><input autocomplete="off" type="radio" name="status" value="1" onclick="$('#vendor_area').hide();get_func('gettype');get_func('getBrand');get_func('getAsset')" checked> Company Asset</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input autocomplete="off" type="radio" name="status" value="2" onclick="$('#vendor_area').show();get_func('gettype');get_func('getBrand');get_func('getAsset')"> Rent</label>
                            </div>
                        </div>
                        <div class="form-group" id="vendor_area" style="display:none">
                            <label class="col-md-4 control-label">Vendor <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" autocomplete="off" name="vendor" id="vendor" onChange="get_func('gettype')">
                                    <option value="">-- Choose a Vendor --</option>
                                    @php
                                        for($i = 0; $i < count($vendor->result); $i++){
                                        echo '<option value="' . $vendor->result[$i]->ass_vendor_id . '">' . $vendor->result[$i]->vendor_name . '</option>';
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Type <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" autocomplete="off" name="type_asset" id="type_asset" onChange="get_func('getBrand')">
                                    <option value="">-- Choose a Type --</option>
                                    @php
                                        for($i = 0; $i < count($type->result); $i++){
                                        echo '<option value="' . $type->result[$i]->ass_type_id . '">' . $type->result[$i]->type_name . '</option>';
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Brand <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" autocomplete="off" name="brand" id="brand" onChange="get_func('getAsset')">
                                    <option value="">-- Choose a Brand --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Model <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" autocomplete="off" name="asset" id="asset">
                                    <option value="">-- Choose a Model --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Service Tag <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" name="service_tag" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Elabram Tag <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" name="elabram_tag" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Serial Number</label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" name="serial_number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Branch <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" autocomplete="off" name="branch" id="branch">
                                    <option value="">-- Choose a Branch --</option>
                                    @php
                                        for($i = 0; $i < count($branch->result); $i++){
                                        echo '<option value="' . $branch->result[$i]->br_id . '">' . $branch->result[$i]->br_name . '</option>';
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Processor <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select name="processor" class="form-control">
                                    <option value="">-- Choose a Processor --</option>
                                    @for($i = 0; $i < count($processor->result); $i++)
                                    <option value="{{$processor->result[$i]->ass_processor_id}}">{{$processor->result[$i]->processor_name}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="col-md-4 control-label">RAM <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select name="ram" class="form-control">
                                    <option value="">-- Choose a ram --</option>
                                    @for($i = 0; $i < count($ram->result); $i++)
                                    <option value="{{$ram->result[$i]->ass_ram_id}}">{{$ram->result[$i]->ram_name}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">HDD <font color="red">*</font></label>
                            <div class="col-md-3">
                                <input type="text" name="hdd_size" class="form-control" placeholder="size">
                            </div>
                            <div class="col-md-5">
                                <select name="hdd" class="form-control">
                                    <option value="">- Choose a HDD -</option>
                                    @for($i = 0; $i < count($hdd->result); $i++)
                                    <option value="{{$hdd->result[$i]->ass_hdd_id}}">{{$hdd->result[$i]->hdd_name}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Currency <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" autocomplete="off" name="currency" id="currency">
                                    <option value="">-- Choose a Currency --</option>
                                    @php
                                        for($i = 0; $i < count($currency->result); $i++){
                                        echo '<option value="' . $currency->result[$i]->cur_id . '">' . $currency->result[$i]->cur_name . '</option>';
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Price <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" name="price" class="form-control" autocomplete="off"  oninput="formatRupiah(this)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Purchase Date <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" name="purchase_date" class="form-control date-picker" data-date-format="dd-M-yyyy">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Warranty Date <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" name="warranty_date" class="form-control date-picker" data-date-format="dd-M-yyyy">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Note <font color="red">*</font></label>
                            <div class="col-md-8">
                                <textarea name="note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
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
            $('#formInput').validate({
                rules: {
                    vendor: {
                        required: true
                    },
                    type_asset: {
                        required: true
                    },
                    brand: {
                        required: true
                    },
                    asset: {
                        required: true
                    },
                    currency: {
                        required: true
                    },
                    price: {
                        required: true
                    },
                    purchase_date: {
                        required: true
                    },
                    warranty_date: {
                        required: true
                    },
                    note: {
                        required: true
                    },
                    branch: {
                        required: true
                    },
                    service_tag: {
                        required: true,
                        remote:"{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/check-sevicetag-existing') }}"
                    },
                    elabram_tag: {
                        required: true,
                        remote:"{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/check-elabramtag-existing') }}"
                    },
                    processor: {
                        required: true,
                    },
                    hdd: {
                        required: true,
                    },
                    ram: {
                        required: true,
                    },
                    hdd_size: {
                        required: true,
                    },
                    serial_number: {
                        required: true
                    },

                },

                messages: {
                    service_tag: {
                            remote: "service tag existing"
                        },
                    elabram_tag: {
                        remote: "elabram tag existing"
                    }

                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
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
        $(document).on("submit", "#formInput", function (event)
        {
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
                async: true,
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/doadd') }}",
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
                            location . reload();
                        }, 1000);
                    } else {
                        swal({title: "Failed", text:data.message, type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/asset/item') }}";
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

        function formReq(){
            $member = $('#member').val();
            if($member !=''){
                $('#reqForm').show();
            }else{
                $('#reqForm').hide();
            }

        }

        function get_func(e)
            {
                var vendor = $('#vendor').val();
                var type_asset = $('#type_asset').val();
                var brand = $('#brand').val();
                var asset = $('#asset').val();
                var data = '';
                if(e == 'gettype'){
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/get-type') }}",
                        {
                            vendor: vendor,
                            type_asset: type_asset
                        },
                        function (data) {
                            $("#type_asset").html(data);
                        }
                    );
                }

                if(e == 'getBrand'){
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/get-brand') }}",
                        {
                            vendor: vendor,
                            type_asset: type_asset,
                            brand: brand
                        },
                        function (data) {
                            $("#brand").html(data);
                        }
                    );
                }

                if(e == 'getAsset'){
                    $.get("{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/get-asset') }}",
                        {
                            vendor: vendor,
                            type_asset: type_asset,
                            brand: brand,
                            asset: asset
                        },
                        function (data) {
                            $("#asset").html(data);
                        }
                    );
                }
            }

            $(function() {
                $( "#date-picker" ).datepicker();
            });

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
