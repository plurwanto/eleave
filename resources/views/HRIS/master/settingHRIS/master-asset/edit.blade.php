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
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Brand <font color="red">*</font></label>
                                    <div class="col-md-8">
                                        <select name="brand" class="form-control">
                                        <option value="">-- Choose a Brand --</option>
                                            @for($i = 0; $i < count($brand->result); $i++)
                                                @if($brand->result[$i]->ass_brand_id == $row->result->ass_brand_id)
                                                    <option value="{{$brand->result[$i]->ass_brand_id}}" selected>{{$brand->result[$i]->brand_name}}</option>
                                                @else
                                                    <option value="{{$brand->result[$i]->ass_brand_id}}">{{$brand->result[$i]->brand_name}}</option>
                                                @endif

                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Type <font color="red">*</font></label>
                                    <div class="col-md-8">
                                        <select name="type" class="form-control">
                                        <option value="">-- Choose a Type --</option>
                                            @for($i = 0; $i < count($type->result); $i++)
                                                @if($type->result[$i]->ass_type_id == $row->result->ass_type_id)
                                                    <option value="{{$type->result[$i]->ass_type_id}}" selected>{{$type->result[$i]->type_name}}</option>
                                                @else
                                                    <option value="{{$type->result[$i]->ass_type_id}}">{{$type->result[$i]->type_name}}</option>
                                                @endif

                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status <font color="red">*</font></label>
                                    <div class="col-md-6">
                                    @if($row->result->status == 'rent')
                                        <label><input type="radio" name="status" value="company asset" onclick="$('#vendor_area').hide();"> Company Asset</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" name="status" value="rent" onclick="$('#vendor_area').show();" checked> Rent</label>
                                    @else
                                        <label><input type="radio" name="status" value="company asset" onclick="$('#vendor_area').hide();" checked> Company Asset</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label><input type="radio" name="status" value="rent" onclick="$('#vendor_area').show();"> Rent</label>
                                    @endif
                                    </div>
                                </div>
                                @if($row->result->status == 'rent')
                                <div class="form-group" id="vendor_area">
                                    <label class="col-md-3 control-label">Vendor <font color="red">*</font></label>
                                    <div class="col-md-8">
                                        <select name="vendor" class="form-control">
                                            <option value="">-- Choose a Vendor --</option>
                                            @for($i = 0; $i < count($vendor->result); $i++)
                                                @if($vendor->result[$i]->ass_vendor_id == $row->result->ass_vendor_id)
                                                    <option value="{{$vendor->result[$i]->ass_vendor_id}}" selected>{{$vendor->result[$i]->vendor_name}}</option>
                                                @else
                                                    <option value="{{$vendor->result[$i]->ass_vendor_id}}">{{$vendor->result[$i]->vendor_name}}</option>
                                                @endif

                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                @else
                                <div class="form-group"  style="display:none" id="vendor_area">
                                    <label class="col-md-3 control-label">Vendor <font color="red">*</font></label>
                                    <div class="col-md-8">
                                        <select name="vendor" class="form-control">
                                            <option value="">-- Choose a Vendor --</option>
                                            @for($i = 0; $i < count($vendor->result); $i++)
                                                @if($vendor->result[$i]->ass_vendor_id == $row->result->ass_vendor_id)
                                                    <option value="{{$vendor->result[$i]->ass_vendor_id}}" selected>{{$vendor->result[$i]->vendor_name}}</option>
                                                @else
                                                    <option value="{{$vendor->result[$i]->ass_vendor_id}}">{{$vendor->result[$i]->vendor_name}}</option>
                                                @endif

                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Model <font color="red">*</font></label>
                                    <div class="col-md-8">
                                        <textarea autocomplete="off" name="model" class="form-control">{{$row->result->model}}</textarea>                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
    <input type="hidden" name="id" value="{{$row->result->ass_id}}">
    <input type="hidden" name="link" value="{{$link}}">
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
                    brand: {
                        required: true
                    },
                    type: {
                        required: true
                    },
                    model: {
                        required: true
                    },
                    vendor: {
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
                url: "{{ URL::asset(env('APP_URL').'/hris/master/hris-setting/doedit') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                       $('#modalAction').modal('hide');
                                toastr . success('Action successfully');
                                setTimeout(function () {
                                    location . reload();
                                }, 1000);
                    } else {
                        $('#modalAction').modal('hide');
                        toastr.error("Failed", "Your action is failed :)",{timeOut: 2000});
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
</script>
