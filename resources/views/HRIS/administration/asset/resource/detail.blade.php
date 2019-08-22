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
                    <div style="padding: 0px 30px;" class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4"><b>Name</b></label>
                            <div class="col-md-8">
                                : {{$item->result->mem_name !=''? $item->result->mem_name : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Type</b></label>
                            <div class="col-md-8">
                                : {{$item->result->type_name !=''? $item->result->type_name : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Service Tag</b></label>
                            <div class="col-md-8">
                                : {{$item->result->service_tag !=''? $item->result->service_tag : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Elabram Tag</b></label>
                            <div class="col-md-8">
                                : {{$item->result->elabram_tag !=''? $item->result->elabram_tag : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Brand</b></label>
                            <div class="col-md-8">
                                : {{$item->result->brand_name !=''? $item->result->brand_name : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Model</b></label>
                            <div class="col-md-8">
                                : {{$item->result->model !=''? $item->result->model : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Processor</b></label>
                            <div class="col-md-8">
                                : {{$item->result->processor_name !=''? $item->result->processor_name : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>RAM</b></label>
                            <div class="col-md-8">
                                : {{$item->result->ram_name !=''? $item->result->ram_name : 'none'}}
                            </div>
                        </div>
                    </div>
                    <div style="padding: 0px 30px;" class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4"><b>HDD Size</b></label>
                            <div class="col-md-8">
                                : {{$item->result->hdd_size !=''? $item->result->hdd_size : 'none'}} {{$item->result->hdd_name !=''? $item->result->hdd_name : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>HDD Size</b></label>
                            <div class="col-md-8">
                                : {{$item->result->hdd_size !=''? $item->result->hdd_size : 'none'}} {{$item->result->hdd_name !=''? $item->result->hdd_name : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Currency</b></label>
                            <div class="col-md-8">
                                : {{$item->result->cur_name !=''? $item->result->cur_name : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Price</b></label>
                            <div class="col-md-8">
                                : {{$item->result->price !=''? number_format($item->result->price, 0, ',', '.') : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Purchase Date</b></label>
                            <div class="col-md-8">
                                : {{$item->result->purchase_date !=''? date('d-M-Y', strtotime($item->result->purchase_date)) : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Warranty Date</b></label>
                            <div class="col-md-8">
                                : {{$item->result->warranty_date !=''? date('d-M-Y', strtotime($item->result->warranty_date)) : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Note</b></label>
                            <div class="col-md-8">
                                : {{$item->result->note !=''? $item->result->note : 'none'}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4"><b>Branch</b></label>
                            <div class="col-md-8">
                                : {{$item->result->br_name !=''? $item->result->br_name : 'none'}}
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
</script>
