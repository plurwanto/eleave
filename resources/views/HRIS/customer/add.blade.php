
<div class="modal-header">
       <button class="close" data-dismiss="modal"></button>

    <h4 class="modal-title">{{$title}}</h4>
</div>
<form id="formInput"  class="form form-horizontal">
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
                                        <option value="1">ICT</option>
                                        <option value="0">Non ICT</option>
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Branch <font color="red">*</font></label>
                                   <input class="form-control" type="text" value="{{$user->result[0]->br_name}}" readonly>
                                   <input class="form-control" name="branch" type="hidden" value="{{$user->result[0]->br_id}}">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">KAM <font color="red">*</font></label>
                                    <select class="form-control select2" name="kam">
                                        <option value="">-- Choose a KAM --</option>
                                        @for($i = 0; $i < count($kam->result); $i++)
                                        <option value="{{$kam->result[$i]->user_id}}">{{$kam->result[$i]->nama}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Customer Name <font color="red">*</font></label>
                                    <input name="customer_name"result type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Date Cut Off </label>
                                    <input name="date_cutoff" type="number" min="1" max="31" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Date Paid Resources <font color="red">*</font></label>
                                    <input name="date_paid" type="number" min="1" max="31" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Company Name</label>
                                    <input name="company_name" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <!-- <div class="validate">
                                   <label style="font-weight: bold;">Customer Code <font color="red">*</font></label>
                                    <input name="customer_code" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div> -->
                                <div id="id_card" class="validate">
                                   <label style="font-weight: bold;">Prorate <font color="red">*</font></label>
                                    <select class="form-control" name="prorate">
                                        <option value="">-- Choose a Status --</option>
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Monthly Based <font color="red">*</font></label>
                                    <select class="form-control" name="monthly_based">
                                        <option value="">-- Choose a Status --</option>
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                    <label style="font-weight: bold;">Person in Charge</label>
                                    <select name="pic[]" id="multi-append" class="form-control select2" multiple>
                                        <option value="">-- Choose a Person in Charge --</option>
                                        @for($i = 0; $i < count($pic->result); $i++)
                                        <option value="{{$pic->result[$i]->user_id}}">{{$pic->result[$i]->nama}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Attach Customer's Agreement</label>
                                    <input name="file" type="file" class="form-control">
                                </div>

                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Prorate Factor <font color="red">*</font></label>
                                    <input name="prorate_factor" type="text" class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6" style="padding: 0px 30px;">
                            <div class="form-group form-margin-0">
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">City </label>
                                    <input name="city" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Postcode</label>
                                    <input name="postcode" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Address</label>
                                   <textarea name="address" class="form-control"></textarea>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Phone</label>
                                   <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Fax</label>
                                   <input type="text" name="fax" id="fax" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">email </label>
                                   <input name="email" type="text" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Note </label>
                                   <textarea name="note" id="note" class="form-control"></textarea>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Management Fee (%) </label>
                                   <input type="text"  name="management_fee" id="management_fee" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Payment Term </label>
                                   <input type="text"  name="payment_term" id="payment_term" class="form-control">
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div class="validate">
                                   <label style="font-weight: bold;">Company Size </label>
                                   <select name="company_size" class="form-control">
                                        <option value="">-- Choose a size --</option>
                                        <option value="1">Local</option>
                                        <option value="2">Regional</option>
                                        <option value="3">Multinational</option>
                                    </select>
                                </div>
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
                                            <input type="text" name="contact_name1" id="contact_name1" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Position </label>
                                            <input type="text" name="contact_position1" id="contact_position1" class="form-control">
                                        </div>
                                        <div class="validate">
                                            <div class="col-md-4">
                                                <label>Phone</label>
                                                <input type="text" name="contact_phone1" id="contact_phone1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Department </label>
                                            <input type="text"  name="contact_department1" id="contact_department1" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Notes </label>
                                            <textarea name="contact_notes1" id="contact_notes1" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-12" id="actioncontact_1" style="margin-top:10px;">
                                            <a id="add_1" dataid="1" class="btn btn-primary" onclick="addFunctioncontact(this);">
                                                <font style="color:white">Add New</font>
                                            </a>
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
        <input type="hidden" value="3" name="form_type" id="form_type" autocomplete="off" class="form-control">
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
        //submit Detail Contact
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

        function addFunctioncontact(e) {
        dataid = $(e).attr('dataid');
        contact_name = $('#contact_name' + dataid).val();

        if (contact_name == '' || dataid == 3) {
            var msg = '<div class="alert alert-danger alert-dismissable">Fields can not be empty</div>';
            $("#errorcontact").html(msg);
            $('#errorcontact').alert();
            $('#errorcontact').fadeTo(2000, 500).slideUp(500, function () {
                $('#errorcontact').hide();

            });
        } else {
            newdataid = parseInt(dataid) + 1;
            $('#actioncontact_' + dataid).hide();

            htm = '<hr style="border: 1px solid #444d58;>'+
            '<div id="row_' + newdataid + '" class="row">'+
                        '<div class="col-md-4">'+
                            '<label>Name</label>'+
                            '<input type="text" name="contact_name' + newdataid + '" id="contact_name' + newdataid + '" class="form-control">'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<label>Position </label>'+
                            '<input type="text" name="contact_position' + newdataid + '" id="contact_position' + newdataid + '" class="form-control">'+
                        '</div>'+
                        '<div class="validate">'+
                            '<div class="col-md-4">'+
                                '<label>Phone</label>'+
                                '<input type="text" name="contact_phone' + newdataid + '" id="contact_phone' + newdataid + '" class="form-control">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<label>Department </label>'+
                            '<input type="text"  name="contact_department' + newdataid + '" id="contact_department' + newdataid + '" class="form-control">'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<label>Notes </label>'+
                            '<textarea name="contact_notes' + newdataid + '" id="contact_notes' + newdataid + '" class="form-control"></textarea>'+
                        '</div>'+
                        '<div class="col-md-12" id="actioncontact_' + newdataid + '" style="margin-top:10px;">'+
                            '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctioncontact(this);">'+
                                '<font style="color:white">Add New</font>'+
                            '</a>'+
                        '</div>'+
                    '</div>';

            $('#div_contact').append(htm);
            $('#count_contact').val(newdataid);
        }

    }

    function deleteFunctioncontact(e) {
        dataid = $(e).attr('dataid');
        $('#actioncontact_' + dataid).remove();
        newdataid = parseInt(dataid) - 1;
        $('#rowcontact' + dataid).remove();
        $('#actioncontact_' + newdataid).show();
        $('#count_contact').val(newdataid);
    }

    $(function() {
        $( "#date-picker" ).datepicker();
    });
</script>
