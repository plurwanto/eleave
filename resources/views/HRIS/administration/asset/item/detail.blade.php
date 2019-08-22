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
                    <div style="padding: 0px 30px;" class="col-md-4">
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Type</label>
                                <div>{{$item->result->type_name !=''? $item->result->type_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Brand</label>
                                <div>{{$item->result->brand_name !=''? $item->result->brand_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Model</label>
                                <div>{{$item->result->model !=''? $item->result->model : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Serial Number</label>
                                <div>{{$item->result->serial_number !=''? $item->result->serial_number : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Service Tag</label>
                                <div>{{$item->result->service_tag !=''? $item->result->service_tag : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 0px 30px;" class="col-md-4">
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Elabram Tag</label>
                                <div>{{$item->result->elabram_tag !=''? $item->result->elabram_tag : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Processor</label>
                                <div>{{$item->result->processor_name !=''? $item->result->processor_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">RAM</label>
                                <div>{{$item->result->ram_name !=''? $item->result->ram_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">HDD</label>
                                <div>{{$item->result->hdd_size !=''? $item->result->hdd_size : 'none'}} {{$item->result->hdd_name !=''? $item->result->hdd_name : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Currency</label>
                                <div>{{$item->result->cur_name !=''? $item->result->cur_name : 'none'}}</div>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 0px 30px;" class="col-md-4">
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Price</label>
                                <div>{{$item->result->price !=''? number_format($item->result->price, 0, ',', '.') : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Purchase Date</label>
                                <div>{{$item->result->purchase_date !=''? date('d-M-Y', strtotime($item->result->purchase_date)) : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Warranty Date</label>
                                <div>{{$item->result->warranty_date !=''? date('d-M-Y', strtotime($item->result->warranty_date)) : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Note</label>
                                <div>{{$item->result->note !=''? $item->result->note : 'none'}}</div>
                            </div>
                        </div>
                        <div class="form-group form-margin-0">
                            <div>
                                <label style="font-weight: bold;">Branch</label>
                                <div>{{$item->result->br_name !=''? $item->result->br_name : 'none'}}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <h3>History</h3>
            <table class="table table-striped table-bordered table-advance table-hover">
            <thead>
                <th>No</th>
                <th>Last Resource</th>
                <th>Action</th>
                <th>Created Date</th>
                <th>Updated By</th>
                <th>Updated Date</th>
                <th>Remark</th>
            </thead>
            <tbody>

            @php
            $a = 1;
            for($i=0;$i< count($item->history); $i++){



                switch ($item->history[$i]->action_code) {
                    case "1":
                        $action = "Assign";
                        break;
                    case "2":
                        $action = "Return";
                        break;
                    default:
                        $action = "";
                }


                echo '<tr>';
                    echo '<td>'.$a++ .'</td>';
                    echo '<td>'. $item->history[$i]->mem_name .'</td>';
                    echo '<td>'. $action .'</td>';
                    echo '<td>'. $item->history[$i]->created_date .'</td>';
                    echo '<td>'. $item->history[$i]->updated_by .'</td>';
                    echo '<td>'. $item->history[$i]->updated_at .'</td>';
                    echo '<td>'. $item->history[$i]->remark .'</td>';
                echo '</tr>';

            }
            @endphp

            </tbody>
            </table>
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
