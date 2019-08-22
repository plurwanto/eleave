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
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Vendor <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" name="vendor" id="vendor" onChange="get_func('gettype')">
                                    <option value="">-- Choose a Vendor --</option>
                                    @php
                                        for($i = 0; $i < count($vendor->result); $i++){
                                        if($item->result->ass_vendor_id == $vendor->result[$i]->ass_vendor_id){
                                            echo '<option value="'.$vendor->result[$i]->ass_vendor_id.'" selected>'. $vendor->result[$i]->vendor_name.'</option>';
                                        }else{
                                            echo '<option value="'.$vendor->result[$i]->ass_vendor_id.'">'. $vendor->result[$i]->vendor_name.'</option>';
                                        }
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Type <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" name="type_asset" id="type_asset" onChange="get_func('getBrand')">
                                    <option value="">-- Choose a Type --</option>
                                    @php
                                        for($i = 0; $i < count($type->result); $i++){
                                        if($item->result->ass_type_id == $type->result[$i]->ass_type_id){
                                            echo '<option value="'.$type->result[$i]->ass_type_id.'" selected>'. $type->result[$i]->type_name.'</option>';
                                        }else{
                                            echo '<option value="'.$type->result[$i]->ass_type_id.'">'. $type->result[$i]->type_name.'</option>';
                                        }
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Brand <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" name="brand" id="brand" onChange="get_func('getAsset')">
                                    <option value="">-- Choose a Brand --</option>
                                    @php
                                        for($i = 0; $i < count($brand->result); $i++){
                                        if($item->result->ass_brand_id == $brand->result[$i]->ass_brand_id){
                                            echo '<option value="'.$brand->result[$i]->ass_brand_id.'" selected>'. $brand->result[$i]->brand_name.'</option>';
                                        }else{
                                            echo '<option value="'.$brand->result[$i]->ass_brand_id.'">'. $brand->result[$i]->brand_name.'</option>';
                                        }
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Model <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" name="asset" id="asset">
                                    <option value="">-- Choose a Model --</option>
                                    @php
                                        for($i = 0; $i < count($asset->result); $i++){
                                        if($item->result->ass_id == $asset->result[$i]->ass_id){
                                            echo '<option value="'.$asset->result[$i]->ass_id.'" selected>'. $asset->result[$i]->model.'</option>';
                                        }else{
                                            echo '<option value="'.$asset->result[$i]->ass_id.'">'. $asset->result[$i]->model.'</option>';
                                        }
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Service Tag <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="text" name="service_tag" class="form-control" value="{{$item->result->service_tag}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Elabram Tag <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="text" name="elabram_tag" class="form-control" value="{{$item->result->elabram_tag}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Branch <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" name="branch" id="branch" onChange="get_func('getBrand')">
                                    <option value="">-- Choose a Branch --</option>
                                    @php
                                        for($i = 0; $i < count($branch->result); $i++){
                                            if($item->result->br_id == $branch->result[$i]->br_id){
                                                echo '<option value="' . $branch->result[$i]->br_id . '" selected>' . $branch->result[$i]->br_name . '</option>';
                                            }else{
                                                echo '<option value="' . $branch->result[$i]->br_id . '">' . $branch->result[$i]->br_name . '</option>';
                                            }
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Currency <font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" name="currency" id="currency" onChange="get_func('getBrand')">
                                    <option value="">-- Choose a Currency --</option>
                                    @php
                                        for($i = 0; $i < count($currency->result); $i++){
                                            if($item->result->cur_id == $currency->result[$i]->cur_id){
                                                echo '<option value="' . $currency->result[$i]->cur_id . '" selected>' . $currency->result[$i]->cur_name . '</option>';
                                            }else{
                                                echo '<option value="' . $currency->result[$i]->cur_id . '">' . $currency->result[$i]->cur_name . '</option>';
                                            }
                                    }
                                    @endphp
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Price <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="text" name="price" class="form-control" value="{{ number_format($item->result->price, 0, ',', '.') }}" oninput="formatRupiah(this)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Purchase Date <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="text" name="purchase_date" class="form-control date-picker" data-date-format="dd-M-yyyy" value="{{$item->result->purchase_date}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Warranty Date <font color="red">*</font></label>
                            <div class="col-md-8">
                                <input type="text" name="warranty_date" class="form-control date-picker" data-date-format="dd-M-yyyy" value="{{$item->result->warranty_date}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Note <font color="red">*</font></label>
                            <div class="col-md-8">
                                <textarea name="note" class="form-control">{{$item->result->note}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
    <input type="hidden" name="id" value="{{$item->result->ass_item_id}}">
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
            $('#formInputEdit').validate({
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
                    service_tag: {
                        required: true
                    },
                    elabram_tag: {
                        required: true
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
                url: "{{ URL::asset(env('APP_URL').'/hris/administration/asset/item/doedit') }}",
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
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/administration/asset/item') }}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
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
