
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
                            <div class="form-body">
                                <div class="form-group">
                                    <label>Full Name</label>
                                        <input name="nama" type="text" class="form-control" value="{{$profile->profile->nama}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input name="email" type="text" class="form-control" value="{{$profile->profile->email}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Branch</label>
                                    <input name="email" type="text" class="form-control" value="{{$profile->profile->br_name}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Division</label>
                                    <div class="input-group select2-bootstrap-append">
                                        <select name="division[]" id="multi-append" class="form-control select2" multiple disabled>
                                        <option value="">-- Choose a Division --</option>
                                        @for($i = 0; $i < count($division->result); $i++)
                                        @if(in_array($division->result[$i]->div_id, explode(',',$profile->profile->div_id)))
                                        <option value="{{$division->result[$i]->div_id}}" selected>{{$division->result[$i]->div_name}}</option>
                                        @else
                                        <option value="{{$division->result[$i]->div_id}}">{{$division->result[$i]->div_name}}</option>
                                        @endif
                                        @endfor
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-body">
                                <div class="form-group">
                                    <label>Region</label>
                                    <select name="region" class="form-control" disabled>
                                        <option value="">-- Choose a region --</option>
                                        @for($i = 0; $i < count($region->result); $i++)
                                        @if($profile->profile->region_id == $region->result[$i]->region_id)
                                            <option value="{{$region->result[$i]->region_id}}" selected>{{$region->result[$i]->region_name}}</option>
                                        @else
                                            <option value="{{$region->result[$i]->region_id}}">{{$region->result[$i]->region_name}}</option>
                                        @endif
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Recruitment Position</label>
                                    <input name="email" type="text" class="form-control" value="{{$profile->profile->recruitment_position}}" disabled>
                                </div>
                                <div class="form-group">
                                <label>Customer KAM</label>
                                <div class="input-group select2-bootstrap-append">
                                        <select name="kam[]" id="multi-append" class="form-control select2" multiple disabled>
                                        <option value="">-- Choose a customer --</option>
                                        @for($i = 0; $i < count($customer->result); $i++)
                                        @if(in_array($customer->result[$i]->cus_id, $customeraccess->customerKAM))
                                        <option value="{{$customer->result[$i]->cus_id}}" selected>{{$customer->result[$i]->cus_name}}</option>
                                        @else
                                        <option value="{{$customer->result[$i]->cus_id}}">{{$customer->result[$i]->cus_name}}</option>
                                        @endif
                                        @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Customer PIC</label>
                                    <div class="input-group select2-bootstrap-append">
                                        <select name="customer[]" id="multi-append" class="form-control select2" multiple disabled>
                                        <option value="">-- Choose a customer --</option>
                                        @for($i = 0; $i < count($customer->result); $i++)
                                        @if(in_array($customer->result[$i]->cus_id, $customeraccess->customerAccess))
                                        <option value="{{$customer->result[$i]->cus_id}}" selected>{{$customer->result[$i]->cus_name}}</option>
                                        @else
                                        <option value="{{$customer->result[$i]->cus_id}}">{{$customer->result[$i]->cus_name}}</option>
                                        @endif
                                        @endfor
                                        </select>
                                    </div>
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
        <button type="submit" class="btn green" id="btnSubmit">Save</button>
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
                    username: {
                        required: true
                    },
                    nama: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    branch: {
                        required: true
                    },
                    "division[]": {
                        required: true
                    },
                    region: {
                        required: true
                    },
                    recruitment_position: {
                        required: true
                    },
                    "customer[]": {
                        required: true
                    },
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
                url: "{{ URL::asset(env('APP_URL').'/hris/master/hris-user/doedit') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response == 'success') {
                        $('#modalAction').modal('hide');
                                toastr . success('Action successfully');
                                setTimeout(function () {
                                    location . reload();
                                }, 1000);
                    } else {
                        swal({title: "Failed", type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'/hris/master/hris-user') }}";
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
</script>
