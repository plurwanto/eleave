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
                    <div class="col-md-12" style="margin-bottom:-40px">
                        <div class="pull-right">
                            <div class="form-body">
                                <div class="form-group">
                                    <select name="active" autocomplete="off" class="form-control" style="width: 120px;">
                                        @php
                                            $active =['Y','N'];
                                            $active_name =['Active','Not Active'];
                                            for($i = 0; $i < count($active); $i++){
                                                if($profile->profile->user_active == $active[$i]){
                                                    echo '<option value="'. $active[$i] .'" selected>'. $active_name[$i] .'</option>';
                                                }else{
                                                    echo '<option value="'. $active[$i] .'">'. $active_name[$i] .'</option>';
                                                }
                                            }
                                            @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Full Name</label>
                                    <input name="nama" type="text" class="form-control" value="{{$profile->profile->nama}}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input name="email" id="email" type="text" class="form-control" value="{{$profile->profile->email}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Branch</label>
                                <select name="branch" class="form-control">
                                    <option value="">-- Choose a Branch --</option>
                                    @for($i = 0; $i < count($branch->result); $i++)
                                    @if($profile->profile->br_id == $branch->result[$i]->br_id)
                                    <option value="{{$branch->result[$i]->br_id}}" selected>{{$branch->result[$i]->br_name}}</option>
                                    @else
                                    <option value="{{$branch->result[$i]->br_id}}">{{$branch->result[$i]->br_name}}</option>
                                    @endif
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Division</label>
                                <div class="input-group select2-bootstrap-append">
                                    <select name="division[]" id="multi-append" class="form-control select2" multiple>
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
                                <select name="region" class="form-control">
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
                                <select name="recruitment_position" id="recruitment_position" class="form-control"  onchange="recAccess()">
                                    <option value=''>-- Choose a Recruitment --</option>
                                    @php
                                    $rec = array('NA','GUEST','ASSIGN','RECRUIT','SALES','MANAGEMENT','SUPER');
                                    for($i=0; $i < count($rec); $i++){
                                        if($profile->profile->recruitment_position == $rec[$i]){
                                            echo '<option value="'.$rec[$i].'" selected>'.$rec[$i].'</option>';
                                        }else{
                                            echo '<option value="'.$rec[$i].'">'.$rec[$i].'</option>';
                                        }
                                    }
                                    @endphp
                                </select>
                            </div>
                            <div class="form-group" id="accessAssign" style="display:none">
                                <label>Access Recuitment</label>
                                <div class="input-group select2-bootstrap-append">
                                    <select name="accessAssign[]" id="multi-append" class="form-control select2" multiple>
                                        <option value="">-- Choose a access --</option>
                                        @php
                                            $rec = array('1','2','3','4');
                                            $recName = array('tab recruiter','change status job','all job access','change status candidate');
                                            $access_assign = explode(',',$profile->profile->access_assign);
                                            for($i=0; $i < count($rec); $i++){
                                                if(in_array($rec[$i],$access_assign)){
                                                    echo '<option value="'.$rec[$i].'" selected>'.$recName[$i].'</option>';
                                                }else{
                                                    echo '<option value="'.$rec[$i].'">'.$recName[$i].'</option>';
                                                }
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="salesAccess" style="display:none">
                                <label>Job Application Access </label>
                                <div class="mt-radio-inline" style="padding-top: 7px;padding-bottom: 9px;">
                                @if($profile->profile->sales_access == 1)
                                    <label class="mt-radio" style="margin-bottom: 0;"><input type="radio" name="salesAccess"
                                            value="0">
                                        Only HRIS
                                        <span></span>
                                    </label>
                                    <label class="mt-radio" style="margin-bottom: 0;"><input type="radio" name="salesAccess"
                                            value="1" checked="checked">
                                        HRIS & Recruitment
                                        <span></span>
                                    </label>
                                    @else
                                    <label class="mt-radio" style="margin-bottom: 0;"><input type="radio" name="salesAccess"
                                            value="0" checked="checked">
                                        Only HRIS
                                        <span></span>
                                    </label>
                                    <label class="mt-radio" style="margin-bottom: 0;"><input type="radio" name="salesAccess"
                                            value="1">
                                        HRIS & Recruitment
                                        <span></span>
                                    </label>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-body">
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
                                    <select name="customer[]" id="multi-append" class="form-control select2" multiple>
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
    <input name="user_id" id="user_id" type="hidden" class="form-control" value="{{$profile->profile->user_id}}">
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
            recAccess();
            $('#formInputEdit').validate({
                rules: {
                    username: {
                        required: true
                    },
                    nama: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                        url: "{{ URL::asset(env('APP_URL').'/hris/master/hris-user/check-exising-edit') }}",
                        type: "get",
                        data: {
                                user_id: function() {
                                return $( "#user_id" ).val();
                                }
                            }
                        }
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
                messages: {
                        email: {
                                remote: "Email existing"
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
                url: "{{ URL::asset(env('APP_URL').'/hris/master/hris-user/doedit') }}",
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

        function recAccess(){
            var type = document.getElementById("recruitment_position").value;
            if(type == 'RECRUIT'){
                $('#accessAssign').show();
            }else{
                $('#accessAssign').hide();
            }

            if(type == 'SALES'){
                $('#salesAccess').show();
            }else{
                $('#salesAccess').hide();
            }
        }
</script>
