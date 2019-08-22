
<div class="modal-header">
        @php
            if($link){
                echo '<a href="'. URL::asset(env('APP_URL').'hris/customer').'?link='. $link .'" type="button" class="close"></a>';
            }else{
                echo '<a href="'. URL::asset(env('APP_URL').'hris/customer') .'" type="button" class="close"></a>';
            }
        @endphp
    <h4 class="modal-title">{{$title}}</h4>
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
                                            <select class="form-control" name="category">
                                                <option value="">-- Choose a Category --</option> 
                                                <option value="1">ICT</option> 
                                                <option value="0">Non ICT</option> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Branch <font color="red">*</font></label>
                                            <select class="form-control" name="branch">
                                                <option value="">-- Choose a Branch --</option> 
                                                @for($i = 0; $i < count($branch->result); $i++)
                                                <option value="{{$branch->result[$i]->br_id}}">{{$branch->result[$i]->br_name}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>KAM <font color="red">*</font></label>
                                            <select class="form-control select2" name="kam">
                                                <option value="">-- Choose a KAM --</option> 
                                                @for($i = 0; $i < count($kam->result); $i++)
                                                <option value="{{$kam->result[$i]->user_id}}">{{$kam->result[$i]->nama}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Customer Name <font color="red">*</font></label>
                                                <input name="customer_name"result type="text" class="form-control"> 
                                        </div>
                                        <div class="form-group">
                                            <label>Date Paid Resources <font color="red">*</font></label>
                                            <input name="date_paid" type="number" min="1" max="31" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                                <input name="company_name" type="text" class="form-control"> 
                                        </div>
                                        <div class="form-group">
                                            <label>Customer Code <font color="red">*</font></label>
                                                <input name="customer_code" type="text" class="form-control"> 
                                        </div>
                                        <div class="form-group">
                                            <label>Prorate <font color="red">*</font></label>
                                            <select class="form-control" name="prorate">
                                                <option value="">-- Choose a Status --</option> 
                                                <option value="Y">Yes</option> 
                                                <option value="N">No</option> 
                                            </select> 
                                        </div>
                                        <div class="form-group">
                                            <label>Monthly Based <font color="red">*</font></label>
                                            <select class="form-control" name="monthly_based">
                                                <option value="">-- Choose a Status --</option> 
                                                <option value="Y">Yes</option> 
                                                <option value="N">No</option> 
                                            </select> 
                                        </div>
                                        <div class="form-group">
                                            <label>Attach Customer's Agreement</label>
                                                <input name="file" type="file" class="form-control"> 
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Prorate Factor <font color="red">*</font></label>
                                                <input name="prorate_factor" type="text" class="form-control"> 
                                        </div>
                                        <div class="form-group">
                                            <label>City </label>
                                                <input name="city" type="text" class="form-control"> 
                                        </div>
                                        <div class="form-group">
                                            <label>Postcode</label>
                                                <input name="postcode" type="text" class="form-control"> 
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea name="address" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                                <input name="phone" type="text" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label>Fax</label>
                                                <input name="fax" type="text" class="form-control"> 
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                                <input name="email" type="text" class="form-control"> 
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                                <input name="note" type="text" class="form-control"> 
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
                                        <select name="pic[]" id="multi-append" class="form-control select2" multiple>
                                        <option value="">-- Choose a Person in Charge --</option>
                                        @for($i = 0; $i < count($pic->result); $i++)
                                        <option value="{{$pic->result[$i]->user_id}}">{{$pic->result[$i]->nama}}</option>
                                        @endfor
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
                                                <input type="text" name="contact_name1" id="contact_name1" class="form-control"> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <label>Phone</label>
                                                <input type="text" name="contact_phone1" id="contact_phone1" class="form-control"> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <label>Position </label>
                                                <input type="text" name="contact_position1" id="contact_position1" class="form-control"> 
                                            </div>
                                            <div class="col-md-2 form-group" style="margin-left:15px">
                                                <label>Department </label>
                                                <input type="text"  name="contact_department1" id="contact_department1" class="form-control"> 
                                            </div>
                                            <div class="col-md-3 form-group" style="margin-left:15px">
                                                <label>Notes </label>
                                                <textarea name="contact_notes1" id="contact_notes1" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="row" id="actioncontact_1" style="margin-top:5px">
                                            <div class="col-xs-6">
                                                <div class="form-group">
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
                    <!-- END SAMPLE FORM PORTLET-->

            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
    <input type="hidden" value="3" name="form_type" id="form_type" class="form-control"> 
        @php
            if($link){
                echo '<a href="'. URL::asset(env('APP_URL').'hris/customer').'?link='. $link .'" type="button" class="btn dark btn-outline">Close</a>';
            }else{
                echo '<a href="'. URL::asset(env('APP_URL').'hris/customer') .'" type="button" class="btn dark btn-outline">Close</a>';
            }
        @endphp
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
                        required: true
                    },
                    passport_date: {
                        required: true
                    },
                    id_card: {
                        number: true,
                        required: true
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
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'hris/customer/doadd') }}",
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
                                    window.location = "{{ URL::asset(env('APP_URL').'hris/customer') }}";
                                    $("#btnSubmit").prop("disabled", false);
                                }
                        );
                    } else {
                        swal({title: "Failed", text:data.message, type: "warning"},
                                function () {
                                    window.location = "{{ URL::asset(env('APP_URL').'hris/customer') }}";
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
            htm = '<div id="row_' + newdataid + '" class="row">'+
                                '<div class="col-md-3 form-group">'+
                                    '<label>Name</label>'+
                                    '<input type="text" name="contact_name' + newdataid + '"  id="contact_name' + newdataid + '" class="form-control">'+ 
                                '</div>'+
                                '<div class="col-md-2 form-group" style="margin-left:15px">'+
                                    '<label>Phone</label>'+
                                    '<input type="text" name="contact_phone' + newdataid + '" id="contact_phone' + newdataid + '" class="form-control">'+ 
                                '</div>'+
                                '<div class="col-md-2 form-group" style="margin-left:15px">'+
                                    '<label>Position </label>'+
                                    '<input type="text" name="contact_position' + newdataid + '"  id="contact_position' + newdataid + '" class="form-control">'+ 
                                '</div>'+
                                '<div class="col-md-2 form-group" style="margin-left:15px">'+
                                    '<label>Department </label>'+
                                    '<input type="text"  name="contact_department' + newdataid + '" id="contact_department' + newdataid + '" class="form-control">'+ 
                                '</div>'+
                                '<div class="col-md-3 form-group" style="margin-left:15px">'+
                                    '<label>Notes </label>'+
                                    '<textarea name="contact_notes' + newdataid + '"  id="contact_notes' + newdataid + '" class="form-control"></textarea>'+
                                '</div>'+
                        '</div>'+
                            '<div class="row" id="actioncontact_' + newdataid + '" style="margin-top:5px">'+
                                '<div class="col-xs-6">'+
                                    '<div class="form-group">'+
                                        '<a id="add_' + newdataid + '" dataid="' + newdataid + '" class="btn btn-primary" onclick="addFunctioncontact(this);">'+
                                            '<font style="color:white">Add New</font>'+
                                        '</a>'+
                                    '</div>'+
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
