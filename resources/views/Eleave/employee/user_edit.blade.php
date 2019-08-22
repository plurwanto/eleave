@extends('Eleave.layout.main')

@section('title','Eleave | Employee Edit')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>Employee Edit
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body form">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <!-- BEGIN FORM-->

            <form action="{{ URL::to(env('APP_URL').'/eleave/user/insert') }}" class="form-horizontal" enctype="multipart/form-data" method="post" id="form_user">
                <input type="hidden" id="user_id" name="user_id" value="<?=$user_list->user_id?>"/>
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Enter name" name="user_name" value="<?=$user_list->user_name?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Employee Ref No</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Enter Employee Ref No" name="user_nik" id="user_nik" value="<?=$user_list->user_nik?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Finger Print ID</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Enter Finger Print ID" name="user_finger_print_id" value="<?=$user_list->user_finger_print_id?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Email</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" placeholder="Enter email" name="user_email" id="user_email" value="<?=$user_list->user_email?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Branch</label>
                        <div class="col-md-4">
                            <select class="form-control" name="branch_id" id="branch_id">
                                <?php if (session('is_hr') != 1) {?>
                                    <option value="">-- Choose Branch --</option>
                                    <?php
                                }
                                $branch_id = session('branch_id');
                                if (!empty($branch)) {
                                    foreach ($branch as $row) {
                                        ?>
                                        <option value="<?php echo $row['branch_id'];?>" <?php if ($row['branch_id'] == $user_list->branch_id) {?>selected="selected"<?php }?>><?php echo $row['branch_name'];?></option>
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
                                        $selected = ($value['department_id'] == $user_list->dept_id ? $selected = ' selected ' : '');
                                        echo "<option value='" . $value['department_id'] . "' $selected >" . $value['department_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Position</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Enter position" name="user_position" value="<?=$user_list->user_position?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Date of Birth</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control datepicker" placeholder="Enter date of birth" name="user_dob" value="<?=$user_list->user_dob?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Gender</label>
                        <div class="col-md-4">
                            <select class="form-control" name="user_gender">
                                <option value="">-- Choose Gender --</option>
                                <option value="Male" <?php if ("Male" == $user_list->user_gender) {?>selected="selected"<?php }?>>Male</option>
                                <option value="Female" <?php if ("Female" == $user_list->user_gender) {?>selected="selected"<?php }?>>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Type of Employee</label>
                        <div class="col-md-4">
                            <select class="form-control" name="user_type" id="select_type">
                                <option value="">-- Choose Type of Employee --</option>
                                <option value="Contract/Mitra" <?php if ("Contract/Mitra" == $user_list->user_type) {?>selected="selected"<?php }?>>Contract/Mitra</option>
                                <option value="Permanent" <?php if ("Permanent" == $user_list->user_type) {?>selected="selected"<?php }?>>Permanent</option>
                                <option value="Probation" <?php if ("Probation" == $user_list->user_type) {?>selected="selected"<?php }?>>Probation</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Join Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control joindate" placeholder="Enter join date" name="user_join_date" autocomplete="off" value="<?=$user_list->user_join_date?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Last Contract Start Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control joindate" placeholder="Enter last contract start date" name="user_last_contract_start_date" value="<?=$user_list->user_last_contract_start_date?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Active Until</label>
                        <div class="col-md-4">
                            <?php 
                            if ($user_list->user_type == "Permanent"){
                                $disable = "disabled";
                            }else{
                                $disable = "";
                            }
                            ?>
                            <input type="text" class="form-control joindate" placeholder="Enter active until" name="user_active_until" id="active_until" value="<?php
                            if ($user_list->user_active_until != "0000-00-00") {
                                echo $user_list->user_active_until;
                            }
                            ?>" <?=$disable;?> autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Address</label>
                        <div class="col-md-4">
                            <textarea class="form-control" rows="3" placeholder="Enter address" name="user_address"><?=$user_list->user_address?></textarea>
                        </div>
                    </div>
                    <div class="form-group last">
                        <label class="col-md-3 control-label">Phone</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Enter phone number" name="user_phone" value="<?=$user_list->user_phone?>">
                        </div>
                    </div>
                    <div class="form-group last">
                        <label class="col-md-3 control-label">Photo</label>
                        <div class="col-md-4">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <?php if ($user_list->user_photo == "") {?>
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                    <?php } else {?>
                                        <img src="{{ URL::to(env('APP_URL'). '/' .$user_list->user_photo) }}" alt="" />
                                    <?php }?>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="user_photo" accept="image/png, image/jpeg, image/jpg">
                                    </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Approver 1</label>
                        <div class="col-md-4">
                            <select class="form-control" name="user_approver1">
                                <option value="">-- Choose Approver 1 --</option>
                                <?php
                                if (!empty($user)) {
                                    foreach ($user as $item) {
                                        ?>
                                        <option value="<?=$item->user_id?>" <?php if ($item->user_id == $user_list->user_approver1) {?>selected="selected"<?php }?>><?=$item->user_name?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Approver 2</label>
                        <div class="col-md-4">
                            <select class="form-control" name="user_approver2">
                                <option value="">-- Choose Approver 2 --</option>
                                <?php
                                if (!empty($user)) {
                                    foreach ($user as $item) {
                                        ?>
                                        <option value="<?=$item->user_id?>" <?php if ($item->user_id == $user_list->user_approver2) {?>selected="selected"<?php }?>><?=$item->user_name?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Approver 3</label>
                        <div class="col-md-4">
                            <select class="form-control" name="user_approver3">
                                <option value="">-- Choose Approver 3 --</option>
                                <?php
                                if (!empty($user)) {
                                    foreach ($user as $item) {
                                        ?>
                                        <option value="<?=$item->user_id?>" <?php if ($item->user_id == $user_list->user_approver3) {?>selected="selected"<?php }?>><?=$item->user_name?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Is Approver</label>
                        <div class="col-md-4">
                            <div class="mt-radio-inline">
                                <label class="mt-radio">
                                    <input name="optapprove" id="optno" value="0" <?php if ($user_list->is_approver == '0') {?>checked="checked"<?php }?> type="radio"> No
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input name="optapprove" id="optyes" value="1" <?php if ($user_list->is_approver == '1') {?>checked="checked"<?php }?> type="radio"> Yes
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">User Level</label>
                        <div class="col-md-4">
                            <select class="form-control" name="level_id">
                                <?php
                                if (!empty($user_level)) {
                                    foreach ($user_level as $value) {
                                        $level_id = (!empty($user_list->level_id) ? $user_list->level_id : '7');
                                        $selected = ($value['id'] == $level_id ? $selected = ' selected ' : '');
                                        echo "<option value='$value[id]' $selected > $value[userlevel_name] </option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status</label>
                        <div class="col-md-4">
                            <select class="form-control" name="user_status" id="user_status" data-validation="required" data-validation-error-msg="'Status' is required." onchange="showResign()">
                                <!--<option value="">-- Choose Status --</option>-->
                                <option value="Active" <?php if ("Active" == $user_list->user_status) {?>selected="selected"<?php }?>>Active</option>
                                <option value="Resign" <?php if ("Resign" == $user_list->user_status) {?>selected="selected"<?php }?>>Resign</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group resign hidden">
                        <label class="col-md-3 control-label">Resign Date</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control datepicker" placeholder="Enter resign date" name="resign_date" id="resign_date" autocomplete="off" >
                        </div>
                    </div>
                    <div class="form-group resign hidden">
                        <label class="col-md-3 control-label">Remark</label>
                        <div class="col-md-4">
                            <textarea class="form-control" rows="5" placeholder="Enter remark" name="remark" id="remark"></textarea>
                        </div>
                    </div>
                    <div class="resign hidden">
                        <div class="form-group">
                            <label class="col-md-4 control-label" style="text-align: left;padding-left: 185px;">
                                <h4 style="font-weight: bold;">Requested Item</h4>
                            </label>
                            <label class="col-md-4 control-label" id="new_staff" style="text-align: left;padding-left: 100px;">
                                <h4 style="font-weight: bold;">New Staff<br/> Item Checklist</h4>
                            </label>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <input type="checkbox" disabled="disabled" class="items" name="items[1]" id="accesscard" value="Access Card">
                                <label for="accesscard">Access Card</label>
                            </div>
                            <div class="col-md-3 new-items">
                                <input type="checkbox" disabled="disabled" class="new_items" name="new_items[1]" id="new_accesscard" value="Access Card">
                                <label for="accesscard">Access Card</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <input type="checkbox" disabled="disabled" class="items" name="items[2]" id="email" value="Email">
                                <label for="email">Email</label>
                            </div>
                            <div class="col-md-3 new-items">
                                <input type="checkbox" disabled="disabled" class="new_items" name="new_items[2]" id="new_email" value="Email">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <input type="checkbox" disabled="disabled" class="items" name="items[3]" id="phoneline" value="Phone Line (Extension)">
                                <label for="phoneline">Phone Line (Extension)</label>
                            </div>
                            <div class="col-md-3 new-items">
                                <input type="checkbox" disabled="disabled" class="new_items" name="new_items[3]" id="new_phoneline" value="Phone Line (Extension)">
                                <label for="phoneline">Phone Line (Extension)</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <input type="checkbox" disabled="disabled" class="items" name="items[4]" id="rmsid" value="RMS ID">
                                <label for="rmsid">RMS ID</label>
                            </div>
                            <div class="col-md-3 new-items">
                                <input type="checkbox" disabled="disabled" class="new_items" name="new_items[4]" id="new_rmsid" value="RMS ID">
                                <label for="rmsid">RMS ID</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <input type="checkbox" disabled="disabled" class="items" name="items[5]" id="apps" value="Portal/IMS/Promas/AMS">
                                <label for="apps">Portal/IMS/Promas/AMS</label>
                            </div>
                            <div class="col-md-3 new-items">
                                <input type="checkbox" disabled="disabled" class="new_items" name="new_items[5]" id="new_apps" value="Portal/IMS/Promas/AMS">
                                <label for="apps">Portal/IMS/Promas/AMS</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <input type="checkbox" disabled="disabled" class="items" name="items[6]" id="laptop" value="Laptop (5 working days)">
                                <label for="laptop">Laptop (5 working days)</label>
                            </div>
                            <div class="col-md-3 new-items">
                                <input type="checkbox" disabled="disabled" class="new_items" name="new_items[6]" id="new_laptop" value="Laptop (5 working days)">
                                <label for="laptop">Laptop (5 working days)</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <input type="checkbox" disabled="disabled" class="items" name="items[7]" id="desktop" value="Desktop (5 working days)">
                                <label for="desktop">Desktop (5 working days)</label>
                            </div>
                            <div class="col-md-3 new-items">
                                <input type="checkbox" disabled="disabled" class="new_items" name="new_items[7]" id="new_desktop" value="Desktop (5 working days)">
                                <label for="desktop">Desktop (5 working days)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-5 col-md-9">
                            <button type="submit" id="btnSave" class="btn btn-circle green">Submit</button>
                            <a href="{{ URL::to('eleave/user/index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
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
@include('Eleave/notification')
<script type="text/javascript">
    var $table;
    $(document).ready(function () {
        var form1 = $('#form_user');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

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
                user_nik: {
                    remote: "This Ref No has been used by other employee.",
                },
                user_email: {
                    remote: "This email has been used by other employee.",
                },
                'user_photo': {
                    extension: "Invalid file type",
                    filesize: "less than 2MB"
                }
            },
            rules: {
                "user_name": {
                    required: true,
                },
                "user_nik": {
                    required: true,
                    remote: {
                        url: `${webUrl}eleave/user/check_existing_nik`,
                        type: "post",
                        data: {
                            "user_id": $('#user_id').val(),
                            "_token": "<?=csrf_token()?>"
                        },
                    }
                },
                "user_finger_print_id": {
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
                "branch_id": {
                    required: true
                },
                "dept_id": {
                    required: true,
                },
                "user_position": {
                    required: true,
                },
                "user_dob": {
                    required: true,
                },
                "user_gender": {
                    required: true,
                },
                "user_type": {
                    required: true
                },
                "user_join_date": {
                    required: true
                },

                "user_last_contract_start_date": {
                    required: true,
                },
                "user_active_until": {
                    required: true
                },
                "user_address": {
                    required: true,
                },
                "user_phone": {
                    required: true,
                },
                "user_photo": {
                    filesize: 2097152,
                    extension: "jpg|png|jpeg",
                },
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
                $('#btnSave').text('Saving...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 
                //success1.show();
                error1.hide();
                return true;
            }
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });

        @if($user_list->user_status == 'Resign')
            @php /*
            $(".resign").removeClass('hidden')
            $("#resign_date").val('{{$user_list->resign_date}}')
            $("#remark").val('{{$user_list->remark}}')
            showResign()
            */ @endphp
        @endif
    });

    function showResign()
    {
        let status  = $("#user_status").val()
        let elaMail = $("#user_email").val()
        @php /*
        if(status == 'Resign')
        {
            $("#resign_date").rules("add", "required")
            $("#remark").rules("add", "required")

            $.ajax({
                url: `${apiUrl}eleave/staff-request/select-data`,
                type: 'POST',
                dataType: 'json',
                data: {token: token, email: elaMail},
                beforeSend: function () {
                    NProgress.start()
                },
                success: function (response) {
                    let result = response.data
                    
                    if(!$.isEmptyObject(result))
                    {
                        $.each(response.data, function(index, el) {
                            if(index == 'items')
                            {
                                $.each(response.data.items, function(i, val) {
                                    $(`input[name="items[${i}]"]`).attr('checked', true)
                                })
                            }
                            else if(index == 'new_staff_items')
                            {
                                if(response.data.new_staff_items == null)
                                {
                                    $.each(response.data.items, function(j, val) {
                                        $(`input[name="new_items[${j}]"]`).attr('checked', true)
                                    })
                                }
                                else
                                {
                                    $.each(response.data.new_staff_items, function(j, val) {
                                        $(`input[name="new_items[${j}]"]`).attr('checked', true)
                                    })
                                }
                            }
                        })
                    }
                    else
                    {
                        $(`input[type="checkbox"]`).attr('checked', false)
                    }
                    
                    $(".resign").removeClass('hidden')
                    NProgress.done()
                }
            })
        }
        else
        {
            $("#resign_date").rules("remove", "required")
            $("#remark").rules("remove", "required")

            $(".resign").addClass('hidden')
        }
        */ @endphp
    }

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

    $('#select_type').on('change', function () {
        if (this.value == "Permanent") {
            $('#active_until').val('');
            $('#active_until').prop('disabled', true);
        } else {
            $('#active_until').prop('disabled', false);
        }

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