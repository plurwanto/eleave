
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
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Category <font color="red">*</font></label>
                                                @php 
                                                    if($customer->result->cus_telco == 1){
                                                        $status = 'ICT';
                                                    }else{
                                                        $status = 'Non ICT';
                                                    }
                                                    echo '<input name="customer_name" value="'.$status.'" type="text" class="form-control" readonly>'
                                                @endphp
                                        </div>
                                        <div class="form-group">
                                            <label>Branch <font color="red">*</font></label>
                                            <input name="customer_name" value="{{$customer->result->br_name}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>KAM <font color="red">*</font></label>
                                            <input name="customer_name" value="{{$customer->result->kam_name}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Customer Name <font color="red">*</font></label>
                                                <input name="customer_name" value="{{$customer->result->cus_name}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Date Paid Resources <font color="red">*</font></label>
                                            <input name="date_paid" value="{{$customer->result->mem_pay_tgl}}" type="number" min="1" max="31" class="form-control" readonly> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                                <input name="company_name" value="{{$customer->result->cus_corporation}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Customer Code <font color="red">*</font></label>
                                                <input name="customer_code" value="{{$customer->result->cus_code}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Prorate <font color="red">*</font></label>
                                            @if($customer->result->cus_prorate == 'Y')
                                            <input name="alias_name" value="Yes" type="text" class="form-control" readonly> 
                                            @elseif($customer->result->cus_prorate == 'N')
                                            <input name="alias_name" value="No" type="text" class="form-control" readonly> 
                                            @else
                                            <input name="alias_name" value="" type="text" class="form-control" readonly> 
                                            @endif                                              
                                        </div>
                                        <div class="form-group">
                                            <label>Monthly Based <font color="red">*</font></label>
                                            
                                            @if($customer->result->cus_monthly == 'Y')
                                            <input name="alias_name" value="Yes" type="text" class="form-control" readonly> 
                                            @elseif($customer->result->cus_monthly == 'N')
                                            <input name="alias_name" value="No" type="text" class="form-control" readonly> 
                                            @else
                                            <input name="alias_name" value="" type="text" class="form-control" readonly> 
                                            @endif  
                                        </div>
                                        <div class="form-group">
                                            <label>Attach Customer's Agreement</label>
                                            {{$customer->result->cus_file}}
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Prorate Factor <font color="red">*</font></label>
                                                <input name="prorate_factor" value="{{$customer->result->cus_factor}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>City </label>
                                                <input name="city" value="{{$customer->result->cus_city}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Postcode</label>
                                                <input name="postcode" value="{{$customer->result->cus_postcode}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea name="address" value="{{$customer->result->cus_address}}" class="form-control" readonly></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                                <input name="phone" value="{{$customer->result->cus_phone}}" type="text" class="form-control" readonly> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Fax</label>
                                                <input name="fax" value="{{$customer->result->cus_fax}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                                <input name="email" value="{{$customer->result->cus_email}}" type="text" class="form-control" readonly> 
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                                <input name="note" value="{{$customer->result->cus_note}}" type="text" class="form-control" readonly> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                            <i class="fa fa-plus-circle"></i>
                                <span class="caption-subject font-dark bold uppercase">Person in Charge</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-4">
                                  
                                    <div class="input-group select2-bootstrap-append">
                                        <select name="pic[]" id="multi-append" class="form-control select2" multiple disabled>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-plus-circle"></i>
                                <span class="caption-subject font-dark bold uppercase">Contact Person</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="errorcontact"></div>
                                <div class="form-body">
                                    <div id="div_contact">
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>Name</label>
                                                <input type="text" value="{{$customer->result->cus_contact_name1}}" name="contact_name1" id="contact_name1" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <label>Phone</label>
                                                <input type="text" value="{{$customer->result->cus_contact_phone1}}" name="contact_phone1" id="contact_phone1" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <label>Position </label>
                                                <input type="text" value="{{$customer->result->cus_contact_position1}}" name="contact_position1" id="contact_position1" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <label>Department </label>
                                                <input type="text" value="{{$customer->result->cus_contact_department1}}" name="contact_department1" id="contact_department1" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-3 form-group" style="margin-left:15px">
                                                <label>Notes </label>
                                                <textarea name="contact_notes1" id="contact_notes1" class="form-control" readonly>{{$customer->result->cus_contact_note1}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <input type="text" value="{{$customer->result->cus_contact_name2}}" name="contact_name2" id="contact_name2" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <input type="text" value="{{$customer->result->cus_contact_phone2}}" name="contact_phone2" id="contact_phone2" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <input type="text" value="{{$customer->result->cus_contact_position2}}" name="contact_position2" id="contact_position2" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <input type="text" value="{{$customer->result->cus_contact_department2}}" name="contact_department2" id="contact_department2" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-3 form-group" style="margin-left:15px">
                                                <textarea name="contact_notes2" id="contact_notes2" class="form-control" readonly>{{$customer->result->cus_contact_note2}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <input type="text" value="{{$customer->result->cus_contact_name3}}" name="contact_name3" id="contact_name3" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <input type="text" value="{{$customer->result->cus_contact_phone3}}" name="contact_phone3" id="contact_phone3" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <input type="text" value="{{$customer->result->cus_contact_position3}}" name="contact_position3" id="contact_position3" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <input type="text" value="{{$customer->result->cus_contact_department3}}" name="contact_department3" id="contact_department3" class="form-control" readonly> 
                                            </div>
                                            <div class="col-md-3 form-group" style="margin-left:15px">
                                                <textarea name="contact_notes3" id="contact_notes3" class="form-control" readonly>{{$customer->result->cus_contact_note3}}</textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>    
                            </div>
                        </div>
                    <!-- END SAMPLE FORM PORTLET-->

            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
    <input type="hidden" value="3" name="form_type" id="form_type" class="form-control" readonly> 
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
            $('#formInput').validate({
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
                        remote:"{{ URL::asset(env('APP_URL').'/hris/customer/check-email-exising') }}"
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
                },
                messages: {
                        email1: {
                                remote: "Email existing"
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
                url: "{{ URL::asset(env('APP_URL').'/hris/customer/doadd') }}",
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
