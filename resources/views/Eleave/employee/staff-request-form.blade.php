@extends('Eleave.layout.main')

@section('title','Eleave | New Employee Item Request')

@section('style')

@endsection

@section('content')
@include('Eleave/notification')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>New Employee Item Request
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body form">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <!-- BEGIN FORM-->


            <form action="{{ URL::to(env('APP_URL').'/eleave/staff-request/insert') }}" class="form-horizontal" method="post" id="form_user">
                <input type="hidden" id="user_id" name="user_id" value="{{$reqId}}"/>
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Personal Email</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" placeholder="Enter email" name="user_email" id="user_email"> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Suggested Company Email</label>
                        <div class="col-md-4">
                            <textarea class="form-control" rows="5" name="suggested_email" id="suggested_email"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Branch</label>
                        <div class="col-md-4">
                            <select class="form-control" name="branch_id" id="branchId">
                                <?php if (session('is_hr') != 1) {?>
                                    <option value="">-- Choose Branch --</option>
                                    <?php
                                }
                                $branch_id = session('branch_id');
                                if (!empty($branch)) {
                                    foreach ($branch as $row) {
                                        ?>
                                        <option value="<?php echo $row['branch_id'];?>"><?php echo $row['branch_name'];?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Department</label>
                        <div class="col-md-4">
                            <select class="filter form-control" id="dept_id" name="dept_id">
                                <option value="">-- Choose Department --</option>
                                <?php
                                if (!empty($department)) {
                                    foreach ($department as $value) {
                                        echo "<option value='" . $value['department_id'] . "'>" . $value['department_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Position</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Enter position" name="position" id="position">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Join Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control joindate" placeholder="Enter join date" name="join_date" id="join_date" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Type of Employee</label>
                        <div class="col-md-4">
                            <select class="form-control" name="employee_type" id="select_type">
                                <option value="">-- Choose Type of Employee --</option>
                                <option value="Contract/Mitra">Contract/Mitra</option>
                                <option value="Permanent">Permanent</option>
                                <option value="Probation">Probation</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Date of Birth</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control datepicker" placeholder="Enter date of birth" name="birthdate" id="birthdate" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Gender</label>
                        <div class="col-md-4">
                            <select class="form-control" name="gender" id="gender">
                                <option value="">-- Choose Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group resign_date">
                        <label class="col-md-3 control-label">Resign Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control datepicker" placeholder="Enter resign date" name="resign_date" id="resign_date" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group remark">
                        <label class="col-md-3 control-label">Remark</label>
                        <div class="col-md-4">
                            <textarea class="form-control" rows="3" placeholder="Enter Remark" name="remark" id="remark"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" style="text-align: left;padding-left: 185px;">
                            <h4 style="font-weight: bold;">Requested Item</h4>
                        </label>
                        <label class="col-md-4 control-label" id="new_staff" style="text-align: left;padding-left: 100px;">
                            <h4 style="font-weight: bold;">New Staff<br/> Item Checklist</h4>
                        </label>
                        <label class="col-md-4 control-label" id="resign" style="text-align: left;">
                            <h4 style="font-weight: bold;">Resign Staff<br/> Item Checklist</h4>
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <input type="checkbox" class="items" name="items[1]" id="accesscard" value="Access Card">
                            <label for="accesscard">Access Card</label>
                        </div>
                        <div class="col-md-3 new-items">
                            <input type="checkbox" class="new_items" name="new_items[1]" id="new_accesscard" value="Access Card">
                            <label for="accesscard">Access Card</label>
                        </div>
                        <div class="col-md-3 resign-items">
                            <input type="checkbox" name="resign_items[1]" id="resign_accesscard" value="Access Card">
                            <label for="accesscard">Access Card</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <input type="checkbox" class="items" name="items[2]" id="email" value="Email">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-3 new-items">
                            <input type="checkbox" class="new_items" name="new_items[2]" id="new_email" value="Email">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-3 resign-items">
                            <input type="checkbox" name="resign_items[2]" id="resign_email" value="Email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <input type="checkbox" class="items" name="items[3]" id="phoneline" value="Phone Line (Extension)">
                            <label for="phoneline">Phone Line (Extension)</label>
                        </div>
                        <div class="col-md-3 new-items">
                            <input type="checkbox" class="new_items" name="new_items[3]" id="new_phoneline" value="Phone Line (Extension)">
                            <label for="phoneline">Phone Line (Extension)</label>
                        </div>
                        <div class="col-md-3 resign-items">
                            <input type="checkbox" name="resign_items[3]" id="resign_phoneline" value="Phone Line (Extension)">
                            <label for="phoneline">Phone Line (Extension)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <input type="checkbox" class="items" name="items[4]" id="rmsid" value="RMS ID">
                            <label for="rmsid">RMS ID</label>
                        </div>
                        <div class="col-md-3 new-items">
                            <input type="checkbox" class="new_items" name="new_items[4]" id="new_rmsid" value="RMS ID">
                            <label for="rmsid">RMS ID</label>
                        </div>
                        <div class="col-md-3 resign-items">
                            <input type="checkbox" name="resign_items[4]" id="resign_rmsid" value="RMS ID">
                            <label for="rmsid">RMS ID</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <input type="checkbox" class="items" name="items[5]" id="apps" value="Portal/IMS/Promas/AMS">
                            <label for="apps">Portal/IMS/Promas/AMS</label>
                        </div>
                        <div class="col-md-3 new-items">
                            <input type="checkbox" class="new_items" name="new_items[5]" id="new_apps" value="Portal/IMS/Promas/AMS">
                            <label for="apps">Portal/IMS/Promas/AMS</label>
                        </div>
                        <div class="col-md-3 resign-items">
                            <input type="checkbox" name="resign_items[5]" id="resign_apps" value="Portal/IMS/Promas/AMS">
                            <label for="apps">Portal/IMS/Promas/AMS</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <input type="checkbox" class="items" name="items[6]" id="laptop" value="Laptop (5 working days)">
                            <label for="laptop">Laptop (5 working days)</label>
                        </div>
                        <div class="col-md-3 new-items">
                            <input type="checkbox" class="new_items" name="new_items[6]" id="new_laptop" value="Laptop (5 working days)">
                            <label for="laptop">Laptop (5 working days)</label>
                        </div>
                        <div class="col-md-3 resign-items">
                            <input type="checkbox" name="resign_items[6]" id="resign_laptop" value="Laptop (5 working days)">
                            <label for="laptop">Laptop (5 working days)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <input type="checkbox" class="items" name="items[7]" id="desktop" value="Desktop (5 working days)">
                            <label for="desktop">Desktop (5 working days)</label>
                        </div>
                        <div class="col-md-3 new-items">
                            <input type="checkbox" class="new_items" name="new_items[7]" id="new_desktop" value="Desktop (5 working days)">
                            <label for="desktop">Desktop (5 working days)</label>
                        </div>
                        <div class="col-md-3 resign-items">
                            <input type="checkbox" name="resign_items[7]" id="resign_desktop" value="Desktop (5 working days)">
                            <label for="desktop">Desktop (5 working days)</label>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" id="btnSave" class="btn btn-circle green">Submit</button>
                            <button type="reset" id="btnReset" class="btn btn-circle grey-salsa btn-outline">Reset</button>
                        </div>
                        <div class="col-md-offset-3 col-md-9 hidden">
                            <a href="#" id="back-button" class="btn btn-circle green">Back</a>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
            </form>


            <!-- END FORM-->
        </div>

    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    var $table;
    $(document).ready(function () {
        var form1 = $('#form_user');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        let placeholder = 'For contractor please use this format only \n(essb.xxxx.yyyy@gmail.com) \nKindly fill in the total number of leave as we need to generate his/her leave detail'

        @if($type != 'view')
            $('#suggested_email').val(placeholder)
        @endif

        $('#suggested_email').focus(function(){
            if($(this).val() == placeholder)
            {
                $(this).val('')
            }
        })

        $('#suggested_email').blur(function(){
            if($(this).val() == '')
            {
                $(this).val(placeholder)
            }    
        })

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                select_multi: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                },
                user_email: {
                    remote: "This email has been used by other employee.",
                }
            },
            rules: {
                "name": {
                    required: true,
                },
                "user_email": {
                    required: true,
                    email: true,
                    remote: {
                        url: `${webUrl}eleave/user/check_existing_mail`,
                        type: "post",
                        data: {
                            "user_id": $('#user_id').val(),
                            "_token": "<?=csrf_token()?>"
                        },
                    }
                },
                "suggested_email": {
                    required: true
                },
                "branch_id": {
                    required: true
                },
                "dept_id": {
                    required: true,
                },
                "position": {
                    required: true,
                },
                "birthdate": {
                    required: true,
                },
                "gender": {
                    required: true,
                },
                "employee_type": {
                    required: true
                },
                "join_date": {
                    required: true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                //App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                //error.appendTo($("div#errorContainer"));
                var cont = $(element).parent('.input-group');
                if (cont.size() > 0) {
                    cont.after(error);
                } else {
                    element.after(error);
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                @if(!empty($type) && $type == 'edit')
                    $('#btnSave').text('Updating...'); //change button text
                @else
                    $('#btnSave').text('Saving...'); //change button text
                @endif

                $('#btnSave').attr('disabled', true); //set button disable 
                //success1.show();

                if($('#suggested_email').val() == placeholder)
                {
                    toastr.error('Suggested Company Email is required')
                    $('#btnSave').attr('disabled', false)
                    $("#btnSave").text('Update')
                    return false
                }

                error1.hide();
                return true;
            }
        })

        $("#form_user").submit(function(event) {
            let items = $(`input[type=checkbox]:checked`)
            let newItems = $(`.new-items input[type=checkbox]:checked`)
            let resignItems = $(`.resign-items input[type=checkbox]:checked`)
            
            if(items.length <= 0)
            {
                toastr.error("Please choose at least one item")

                @if(!empty($type) && $type == 'edit')
                    $('#btnSave').text('Update') //change button text
                @else
                    $('#btnSave').text('Submit') //change button text
                @endif
                
                $('#btnSave').attr('disabled', false)
                return false
            }
            
            @if(session('dept_id') == 12)
                @if($type == 'new-staff')
                    if(newItems.length <= 0)
                    {
                        toastr.error("Please choose at least one item")

                        $('#btnSave').text('Proccess') //change button text
                        
                        $('#btnSave').attr('disabled', false)
                        return false
                    }
                @else
                    if(resignItems.length <= 0)
                    {
                        toastr.error("Please choose at least one item")

                        $('#btnSave').text('Proccess') //change button text
                        
                        $('#btnSave').attr('disabled', false)
                        return false
                    }
                @endif
            @endif
        })

        $(".resign_date").addClass('hidden')
        $(".remark").addClass('hidden')

        @if(!empty($type))
            $.ajax({
                url: `${apiUrl}eleave/staff-request/select-data`,
                type: 'POST',
                dataType: 'json',
                data: {token: token, request_id: '{{$reqId}}'},
                success: function (response) {

                    $.each(response.data, function(index, el) {
                        if(index == 'items')
                        {
                            $.each(response.data.items, function(index, val) {
                                $(`input[name="items[${index}]"]`).attr('checked', 'checked')
                            })
                        }
                        else if(index == 'new_staff_items')
                        {
                            $.each(response.data.new_staff_items, function(index, val) {
                                $(`input[name="new_items[${index}]"]`).attr('checked', 'checked')
                            })
                        }
                        else if(index == 'resign_staff_items')
                        {
                            $.each(response.data.resign_staff_items, function(index, val) {
                                $(`input[name="resign_items[${index}]"]`).attr('checked', 'checked')
                            })
                        }
                        else
                        {
                            @if($type != 'view')
                                if(response.data.suggested_email == '')
                                {
                                    $("#suggested_email").val(placeholder)
                                }
                            @endif
                            
                            if(index == 'branch_id')
                            {
                                $(`#branchId`).val(el)
                            }
                            else
                            {
                                $(`#${index}`).val(el)                                
                            }
                        }
                    })

                    if(response.data.type == 2)
                    {
                        $("#resign_date").rules("add", "required")
                        $("#remark").rules("add", "required")
                        $(".resign_date").removeClass('hidden')
                        $(".remark").removeClass('hidden')
                    }
                    else
                    {
                        $("#resign_date").rules("remove", "required")
                        $("#remark").rules("remove", "required")
                    }
                    
                    @if($type == 'edit')
                        $('#form_user').attr('action', `${webUrl}eleave/staff-request/update`)
                        $("#btnSave").text('Update')
                        $("#btnReset").hide()
                        $("#btnReset").parent().removeClass('col-md-offset-3')
                        $("#btnReset").parent().addClass('col-md-offset-5')
                        $(".new-items").addClass('hidden')
                        $("#new_staff").addClass('hidden')
                        $(".resign-items").addClass('hidden')
                        $("#resign").addClass('hidden')
                    @elseif($type == 'view')
                        $("input, select, textarea").attr('disabled','disabled')
                        $("#btnReset").parent().hide()
                        $("#back-button").attr('href',`${webUrl}eleave/user/index#staff-request`)
                        $("#back-button").parent().removeClass('col-md-offset-3')
                        $("#back-button").parent().addClass('col-md-offset-5')
                        $("#back-button").parent().removeClass('hidden')
                        
                        if(response.data.type == 1)
                        {
                            $(".resign-items").addClass('hidden')
                            $("#resign").addClass('hidden')

                            if(response.data.status == 1 || response.data.status == 2)
                            {
                                @if(session('dept_id') != 12)
                                    $(".new-items").addClass('hidden')
                                    $("#new_staff").addClass('hidden')
                                @else
                                    $(".new-items").removeClass('hidden')
                                    $("#new_staff").removeClass('hidden')
                                @endif
                            }
                        }
                        else
                        {
                            $(".resign_date").removeClass('hidden')
                            $(".remark").removeClass('hidden')
                        }

                        if(response.data.type == 2 && response.data.resign_staff_items == null && (response.data.status == 1 || response.data.status == 2 || response.data.status == 3))
                        {
                            $(".resign-items").addClass('hidden')
                            $("#resign").addClass('hidden')
                        }
                    @elseif($type == 'new-staff')
                        $('#form_user').attr('action', `${webUrl}eleave/staff-request/update`)
                        $("input[type=text], input[type=email], select, textarea").attr('disabled','disabled')
                        $(".items").attr('disabled', true)
                        $("#btnSave").text('Process')

                        $("#resign_date").attr('disabled', true)
                        $("#remark").attr('disabled', true)
                        $(".resign-items").addClass('hidden')
                        $("#resign").addClass('hidden')

                        @if(session('dept_id') != 12)
                            $(".items").attr('disabled', true)
                            $(".new-items input[type=checkbox]").attr('disabled', true)
                            $("#resign_date").attr('disabled', false)
                            $("#remark").attr('disabled', false)
                            $("#btnSave").text('Update')
                        @endif

                        $("#btnReset").hide()
                        $("#btnSave").parent().removeClass('col-md-offset-3')
                        $("#btnSave").parent().addClass('col-md-offset-5')

                        @if(session('dept_id') == 12)
                            $("#suggested_email").attr('disabled', false)
                        @endif
                    @elseif($type == 'resign-staff')
                        $('#form_user').attr('action', `${webUrl}eleave/staff-request/update`)
                        $("input[type=text], input[type=email], select, textarea").attr('disabled','disabled')
                        $(".items").attr('disabled', true)
                        $(".new-items input[type=checkbox]").attr('disabled', true)
                        $("#btnReset").hide()
                        $("#btnSave").text('Process')
                        $("#btnSave").parent().removeClass('col-md-offset-3')
                        $("#btnSave").parent().addClass('col-md-offset-5')

                        @if(session('dept_id') != 12)
                            $(".resign-items").addClass('hidden')
                            $("#resign").addClass('hidden')                            
                        @endif
                    @endif
                }
            })
            .fail(function(error) {
                console.log(error)
                toastr.error("System failure, Please contact the Administrator")
            })
        @else
            $(".new-items").addClass('hidden')
            $("#new_staff").addClass('hidden')
            $(".resign-items").addClass('hidden')
            $("#resign").addClass('hidden')
            $("#btnReset").parent().removeClass('col-md-offset-3')
            $("#btnReset").parent().addClass('col-md-offset-5')
        @endif

    })

    function nProgress() {
        NProgress.start();
        var interval = setInterval(function () {
            NProgress.inc();
        }, 10);

        jQuery(window).load(function () {
            clearInterval(interval);
            NProgress.done();
        });
    }

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        startView: 2,
        autoclose: true,
        todayHighlight: true
    });

    $('.joindate').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        autoclose: true,
        todayHighlight: true
    });
</script>

<script>
    toastr.options = {
        "closeButton": true,
    };

    @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
    case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
            case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
            case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
            case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
@endsection