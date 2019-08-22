<form id="formInputEdit"  class="form form-horizontal">
    <div class="modal-header">
    <button class="close" data-dismiss="modal"></button>
        <h4 class="modal-title">{{$title}}</h4>
        <div style="position: absolute; right: 45px; top: 12px;">
            <label style="font-weight: bold; margin-top: 8px;margin-right: 10px;">Active</label>
            <select name="cus_active" autocomplete="off" class="form-control" style="float: right;padding: 6px 7px;width: 50px;">
                @php
                    $active =['Y','N'];
                    $active_name =['Y','N'];
                    for($i = 0; $i < count($active); $i++){
                        if($customer->result->cus_active == $active[$i]){
                            echo '<option value="'. $active[$i] .'" selected>'. $active_name[$i] .'</option>';
                        }else{
                            echo '<option value="'. $active[$i] .'">'. $active_name[$i] .'</option>';
                        }
                    }
                    @endphp
            </select>
        </div>
    </div>
    <div class="modal-body" style="padding-bottom: 0;">
        <div class="portlet box" style="background-color: #444d58; margin-bottom: 0px">
            <div class="portlet-title">
                <div class="caption"><i class="icon-user" style="color: #fff !important"></i>
                    Personal Information
                </div>
            </div>
            <div class="portlet-body" style="padding: 8px 15px;">
                <div class="row">
                    <div class="col-md-12" style="border-bottom: 1px solid #444d58; ">
                        <div style="padding: 0px 30px;" class="col-md-6">
                            <div class="form-group form-margin-0">
                                <div class="validate">
                                    <label style="font-weight: bold;">Category <font color="red">*</font></label>
                                    <select class="form-control" name="category">
                                        <option value="">-- Choose a Category --</option>
                                        @php
                                        $category =['1','0'];
                                        $category_name =['ICT','Non ICT'];
                                        for($i = 0; $i < count($category); $i++){
                                            if($customer->result->cus_telco == $category[$i]){
                                                echo '<option value="'. $category[$i] .'" selected>'. $category_name[$i] .'</option>';
                                            }else{
                                                echo '<option value="'. $category[$i] .'">'. $category_name[$i] .'</option>';
                                            }
                                        }
                                        @endphp
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Branch <font color="red">*</font></label>
                                   <select class="form-control" disabled>
                                        <option value="">-- Choose a Branch --</option>
                                        @php
                                        for($i = 0; $i < count($branch->result); $i++){
                                            if($customer->result->br_id == $branch->result[$i]->br_id){
                                                echo '<option value="'.$branch->result[$i]->br_id.'" selected>'.$branch->result[$i]->br_name.'</option>';
                                            }else{
                                                echo '<option value="'.$branch->result[$i]->br_id.'">'.$branch->result[$i]->br_name.'</option>';
                                            }
                                        }
                                        @endphp
                                    </select>
                                    <input name="branch" value="{{$customer->result->br_id}}" type="hidden" class="form-control">

                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">KAM <font color="red">*</font></label>
                                   <select class="form-control select2" name="kam">
                                        <option value="">-- Choose a KAM --</option>
                                        @php
                                            for($i = 0; $i < count($kam->result); $i++){
                                            if($customer->result->cus_kam == $kam->result[$i]->user_id){
                                                echo '<option value="'.$kam->result[$i]->user_id.'" selected>'.$kam->result[$i]->nama.'</option>';
                                            }else{
                                                echo '<option value="'.$kam->result[$i]->user_id.'">'.$kam->result[$i]->nama.'</option>';
                                            }
                                        }
                                        @endphp
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Customer Name <font color="red">*</font></label>
                                   <input name="customer_name" value="{{$customer->result->cus_name}}" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Date Cut Off </label>
                                   <input name="date_cutoff" value="{{$customer->result->date_cutoff}}" type="number" min="1" max="31" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Date Paid Resources <font color="red">*</font></label>
                                   <input name="date_paid" value="{{$customer->result->mem_pay_tgl}}" type="number" min="1" max="31" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Company Name</label>
                                   <input name="company_name" value="{{$customer->result->cus_corporation}}" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <!-- <div class="validate">
                                   <label style="font-weight: bold;">Customer Code <font color="red">*</font></label>
                                   <input name="customer_code" value="{{$customer->result->cus_code}}" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div> -->
                                <div id="id_card" class="validate">
                                   <label style="font-weight: bold;">Prorate <font color="red">*</font></label>
                                   <select class="form-control" name="prorate">
                                        <option value="">-- Choose a Status --</option>
                                        @php
                                        $prorate =['Y','N'];
                                        $prorate_name =['Yes','No'];
                                        for($i = 0; $i < count($prorate); $i++){
                                            if($customer->result->cus_prorate == $prorate[$i]){
                                                echo '<option value="'. $prorate[$i] .'" selected>'. $prorate_name[$i] .'</option>';
                                            }else{
                                                echo '<option value="'. $prorate[$i] .'">'. $prorate_name[$i] .'</option>';
                                            }
                                        }
                                        @endphp
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Monthly Based <font color="red">*</font></label>
                                   <select class="form-control" name="monthly_based">
                                        <option value="">-- Choose a Status --</option>
                                        @php
                                        $monthly_based =['Y','N'];
                                        $monthly_based_name =['Yes','No'];
                                        for($i = 0; $i < count($monthly_based); $i++){
                                            if($customer->result->cus_monthly == $monthly_based[$i]){
                                                echo '<option value="'. $monthly_based[$i] .'" selected>'. $monthly_based_name[$i] .'</option>';
                                            }else{
                                                echo '<option value="'. $monthly_based[$i] .'">'. $monthly_based_name[$i] .'</option>';
                                            }
                                        }
                                        @endphp
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Person in Charge</label>
                                    <select name="pic[]" id="multi-append" class="form-control select2" multiple>
                                        <option value="">-- Choose a Person in Charge --</option>
                                        @php
                                        $cus_pic = explode(',', $customer->result->cus_pic);
                                        for($i = 0; $i < count($pic->result); $i++){
                                            if(in_array($pic->result[$i]->user_id, $cus_pic)){
                                                echo '<option value="'.$pic->result[$i]->user_id.'" selected>'.$pic->result[$i]->nama.'</option>';
                                            }else{
                                                echo '<option value="'.$pic->result[$i]->user_id.'">'.$pic->result[$i]->nama.'</option>';
                                            }
                                        }
                                        @endphp
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Attach Customer's Agreement</label>
                                    @php
                                    if($customer->result->cus_file !=''){
                                        echo '<a href="'.URL::asset(env('PUBLIC_PATH').'hris/files/customer/'. $customer->result->cus_file).'"><i class="fa fa-file"></i></a>&nbsp;';
                                    }
                                    @endphp
                                    <input name="file" type="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding: 0px 30px;">
                            <div class="form-group form-margin-0">
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Prorate Factor <font color="red">*</font></label>
                                   <input name="prorate_factor" value="{{$customer->result->cus_factor}}" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">City </label>
                                   <input name="city" value="{{$customer->result->cus_city}}" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Postcode</label>
                                   <input name="postcode" value="{{$customer->result->cus_postcode}}" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Address</label>
                                   <textarea name="address" class="form-control">{{$customer->result->cus_address}}</textarea>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Phone</label>
                                   <input type="text" value="{{$customer->result->cus_phone}}" name="phone" id="phone" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Fax</label>
                                   <input type="text" value="{{$customer->result->cus_fax}}" name="fax" id="fax" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">email </label>
                                   <input name="email" value="{{$customer->result->cus_email}}" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Note </label>
                                   <textarea name="note" id="note" class="form-control">{{$customer->result->cus_note}}</textarea>
                                </div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Management Fee (%)</label>
                                   <input type="text" value="{{$customer->result->management_fee}}" name="management_fee" id="management_fee" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Payment Term</label>
                                   <input type="text" value="{{$customer->result->payment_term}}" name="payment_term" id="payment_term" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Company Size</label>
                                   <select name="company_size" id="multi-append" class="form-control select2">
                                        <option value="">-- Choose a company size --</option>
                                        @php
                                            $monthly_based =['1','2','3'];
                                            $monthly_based_name =['Local','Regional','Multinational'];
                                            for($i = 0; $i < count($monthly_based); $i++){
                                                if($customer->result->company_size == $monthly_based[$i]){
                                                    echo '<option value="'. $monthly_based[$i] .'" selected>'. $monthly_based_name[$i] .'</option>';
                                                }else{
                                                    echo '<option value="'. $monthly_based[$i] .'">'. $monthly_based_name[$i] .'</option>';
                                                }
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" style="padding: 8px 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div style="padding: 0px 30px;" class="col-md-12">
                            <div class="form-group form-margin-0">
                                <label style="font-weight: bold;">CONTACT PERSON</label>
                                <div id="errorcontact"></div>
                                <div id="div_contact">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Name</label>
                                            <input type="text" value="{{$customer->result->cus_contact_name1}}" name="contact_name1" id="contact_name1" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Position </label>
                                            <input type="text" value="{{$customer->result->cus_contact_position1}}" name="contact_position1" id="contact_position1" class="form-control">
                                        </div>
                                        <div class="validate">
                                            <div class="col-md-4">
                                                <label>Phone</label>
                                                <input type="text" value="{{$customer->result->cus_contact_phone1}}" name="contact_phone1" id="contact_phone1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Department </label>
                                            <input type="text" value="{{$customer->result->cus_contact_department1}}" name="contact_department1" id="contact_department1" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Notes </label>
                                            <textarea name="contact_notes1" id="contact_notes1" class="form-control">{{$customer->result->cus_contact_note1}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 1px solid #444d58;">
                                <div id="div_contact">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Name</label>
                                            <input type="text" value="{{$customer->result->cus_contact_name2}}" name="contact_name2" id="contact_name2" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Position </label>
                                            <input type="text" value="{{$customer->result->cus_contact_position2}}" name="contact_position2" id="contact_position2" class="form-control">
                                        </div>
                                        <div class="validate">
                                            <div class="col-md-4">
                                                <label>Phone</label>
                                                <input type="text" value="{{$customer->result->cus_contact_phone2}}" name="contact_phone2" id="contact_phone2" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Department </label>
                                            <input type="text" value="{{$customer->result->cus_contact_department2}}" name="contact_department2" id="contact_department2" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Notes </label>
                                            <textarea name="contact_notes2" id="contact_notes2" class="form-control">{{$customer->result->cus_contact_note2}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border: 1px solid #444d58;">
                                <div id="div_contact">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Name</label>
                                            <input type="text" value="{{$customer->result->cus_contact_name3}}" name="contact_name3" id="contact_name3" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Position </label>
                                            <input type="text" value="{{$customer->result->cus_contact_position3}}" name="contact_position3" id="contact_position3" class="form-control">
                                        </div>
                                        <div class="validate">
                                            <div class="col-md-4">
                                                <label>Phone</label>
                                                <input type="text" value="{{$customer->result->cus_contact_phone3}}" name="contact_phone3" id="contact_phone3" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Department </label>
                                            <input type="text" value="{{$customer->result->cus_contact_department3}}" name="contact_department3" id="contact_department3" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Notes </label>
                                            <textarea name="contact_notes3" id="contact_notes3" class="form-control">{{$customer->result->cus_contact_note3}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
    <input name="cus_id" value="{{$customer->result->cus_id}}" type="hidden" class="form-control">
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
                    category : {
                        required: true
                    },
                    branch : {
                        required: true
                    },
                    kam: {
                        required: true
                    },
                    customer_name: {
                        required: true
                    },
                    date_paid: {
                        required: true
                    },
                    customer_code: {
                        required: true,
                    },
                    prorate: {
                        required: true,
                    },
                    monthly_based: {
                        required: true
                    },
                    prorate_factor: {
                        required: true,
                        number: true
                    },
                    name_bank1: {
                        required: true
                    },
                    marital: {
                        required: true
                    },
                    marital: {
                        required: true
                    },
                    passport: {
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-passport') }}"
                    },
                    passport_date: {
                        required: true
                    },
                    id_card: {
                        number: true,
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/others/check-ktp') }}"
                   },
                    file: {
                        accept: "image/jpeg, image/pjpeg"
                    },
                    religion: {
                        required: true
                    },
                    email: {
                        email: true
                    },
                    phone: {
                        number: true
                    },
                    postcode: {
                        number: true
                    },
                    contact_phone1: {
                        number: true
                    },
                    management_fee: {
                        required: true,
                        number: true
                    },
                    payment_term: {
                        required: true,
                        number: true
                    },
                    company_size: {
                        required: true
                    },
                },
                messages: {
                        email1: {
                                remote: "Email existing"
                            },

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
                url: "{{ URL::asset(env('APP_URL').'/hris/customer/doedit') }}",
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
