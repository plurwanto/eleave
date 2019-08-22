@extends('Eleave.layout.main')

@section('title','Eleave | Employee Profile')

@section('style')
<link href="{{ URL::asset(env('PAGES_CSS_PATH').'profile.min.css') }}"
      rel="stylesheet" type="text/css" />

<style>
    .form-control[readonly], fieldset[disabled] .form-control {
        background-color: #f2f4f6;
        opacity: 1;
    }
</style>
@endsection

@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user"></i>Employee Profile
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body form">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="form-body">
                <!-- BEGIN PAGE BASE CONTENT -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PROFILE SIDEBAR -->
                        <div class="profile-sidebar">
                            <!-- PORTLET MAIN -->
                            <div class="portlet light profile-sidebar-portlet bordered">
                                <!-- SIDEBAR USERPIC -->
                                <div class="profile-userpic">
                                    <img src="{{ URL::to(env('PUBLIC_PATH').'/'.$user_list->user_photo) }}" class="img-responsive" alt=""> </div>
                                <!-- END SIDEBAR USERPIC -->
                                <!-- SIDEBAR USER TITLE -->
                                <div class="profile-usertitle">
                                    <div class="profile-usertitle-name"> {{ $user_list->user_name }} </div>
                                    <div class="profile-usertitle-job"> {{ $user_list->user_position }} </div>
                                </div>
                                <!-- END SIDEBAR USER TITLE -->
                                <!-- SIDEBAR BUTTONS -->
                                <!--                                <div class="profile-userbuttons">
                                                                    <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                                                                    <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                                                </div>-->
                                <!-- END SIDEBAR BUTTONS -->
                                <!-- SIDEBAR MENU -->
                                <div class="profile-usermenu">
                                    <ul class="nav">
                                        <li>
                                            <a href="/" onclick="return false;" style="pointer-events: none; cursor: default;">
                                                <i class="icon-credit-card"></i> {{ $user_list->user_nik }} </a>
                                        </li>
                                        <li>
                                            <a href="/" onclick="return false;" style="pointer-events: none; cursor: default;">
                                                <i class="fa fa-building-o"></i> {{ $user_list->branch_name }} </a>
                                        </li>
                                        <li>
                                            <a href="/" onclick="return false;" style="pointer-events: none; cursor: default;">
                                                <i class="icon-envelope"></i> {{ $user_list->user_email }} </a>
                                        </li>
                                        <li>
                                            <a href="{{ URL::to(env('APP_URL').'/change-password') }}" >
                                                <i class="icon-key"></i> Change Password </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- END MENU -->
                            </div>
                            <!-- END PORTLET MAIN -->
                            <!-- PORTLET MAIN -->
                            <!--                            <div class="portlet light bordered">
                                                             STAT 
                                                            <div class="row list-separated profile-stat">
                                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                                    <div class="uppercase profile-stat-title"> 37 </div>
                                                                    <div class="uppercase profile-stat-text"> Projects </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                                    <div class="uppercase profile-stat-title"> 51 </div>
                                                                    <div class="uppercase profile-stat-text"> Tasks </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                                    <div class="uppercase profile-stat-title"> 61 </div>
                                                                    <div class="uppercase profile-stat-text"> Uploads </div>
                                                                </div>
                                                            </div>
                                                             END STAT 
                                                            <div>
                                                                <h4 class="profile-desc-title">About Marcus Doe</h4>
                                                                <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                                                                <div class="margin-top-20 profile-desc-link">
                                                                    <i class="fa fa-globe"></i>
                                                                    <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                                                                </div>
                                                                <div class="margin-top-20 profile-desc-link">
                                                                    <i class="fa fa-twitter"></i>
                                                                    <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                                                                </div>
                                                                <div class="margin-top-20 profile-desc-link">
                                                                    <i class="fa fa-facebook"></i>
                                                                    <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                                                                </div>
                                                            </div>
                                                        </div>-->
                            <!-- END PORTLET MAIN -->
                        </div>
                        <!-- END BEGIN PROFILE SIDEBAR -->
                        <!-- BEGIN PROFILE CONTENT -->
                        <div class="profile-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption caption-md">
                                                <i class="icon-globe theme-font hide"></i>
                                                <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                                </li>
                                                <li>
                                                    <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                                                </li>
                                                <!--                                                <li>
                                                                                                    <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                                                                                </li>-->
                                                <!--                                                <li>
                                                                                                    <a href="#tab_1_4" data-toggle="tab">Privacy Settings</a>
                                                                                                </li>-->
                                            </ul>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <!-- PERSONAL INFO TAB -->
                                                <div class="tab-pane active" id="tab_1_1">
                                                    <form role="form" action="#">
                                                        <div class="form-group">
                                                            <label class="control-label">Name</label>
                                                            <input type="text" value="{{ $user_list->user_name }}" readonly="" class="form-control" /> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Finger Print ID</label>
                                                            <input type="text" value="{{ $user_list->user_finger_print_id }}" readonly="" class="form-control" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Date of Birth</label>
                                                            <input type="text" readonly="" class="form-control" value="{{ date('j F Y', strtotime($user_list->user_dob)) }}" /> 
                                                        </div>                                                      
                                                        <div class="form-group">
                                                            <label class="control-label">Gender</label>
                                                            <input type="text" value="{{ $user_list->user_gender }}" readonly="" class="form-control" /> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Type of Employee</label>
                                                            <input type="text" value="{{ $user_list->user_type }}" readonly="" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Join Date</label>
                                                            <input type="text" value="{{ date('j F Y', strtotime($user_list->user_join_date)) }}" readonly="" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Last Contract Start Date</label>
                                                            <input type="text" value="{{ date('j F Y', strtotime($user_list->user_last_contract_start_date)) }}" readonly="" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Active Until</label>
                                                            <input type="text" value="{{ date('j F Y', strtotime($user_list->user_active_until)) }}" readonly="" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Address</label>
                                                            <textarea readonly="" class="form-control" rows="3">{{ $user_list->user_address }}</textarea> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Phone</label>
                                                            <input type="text" value="{{ $user_list->user_phone }}" readonly="" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Approver 1</label>
                                                            <input type="text" value="{{ $user_list->approver1 }}" readonly="" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Approver 2</label>
                                                            <input type="text" value="{{ $user_list->approver2 }}" readonly="" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Approver 3</label>
                                                            <input type="text" value="{{ $user_list->approver3 }}" readonly="" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Status</label>
                                                            <input type="text" value="{{ $user_list->user_status }}" readonly="" class="form-control" /> </div>

                                                    </form>

                                                </div>
                                                <!-- END PERSONAL INFO TAB -->
                                                <!-- CHANGE AVATAR TAB -->
                                                <div class="tab-pane" id="tab_1_2">
                                                    <form id="form_user" action="{{ URL::asset(env('APP_URL').'/eleave/user/changeAvatar') }}" method="POST" enctype="multipart/form-data" role="form">
                                                        <?php
                                                        $show_photo = ($user_list->user_photo == "" ? "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" : URL::to(env('PUBLIC_PATH'). '/' .$user_list->user_photo));
                                                        ?>
                                                        <div class="form-group">
                                                            <input type="hidden" name="user_id" value="{{ $user_list->user_id }}">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                    <img src="{{ $show_photo }}" alt="" /> </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                                <div>
                                                                    <span class="btn default btn-file">
                                                                        <span class="fileinput-new"> Select image </span>
                                                                        <span class="fileinput-exists"> Change </span>
                                                                        <input type="file" name="user_photo" accept="image/png, image/jpeg, image/jpg" required="required"> </span>
                                                                    <button type="submit" id="btnSave" class="btn green fileinput-exists">Update</button>
                                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix margin-top-10">
                                                                <span class="label label-danger">NOTE! </span>
                                                                <span>  Max: 1Mb </span>
                                                            </div>
                                                        </div>
                                                        <div class="margin-top-10">
                                                            
                                                        </div>
                                                        {{ csrf_field() }}
                                                    </form>
                                                </div>
                                                <!-- END CHANGE AVATAR TAB -->
                                                <!-- CHANGE PASSWORD TAB -->
                                                <!--                                                <div class="tab-pane" id="tab_1_3">
                                                                                                    <form action="#">
                                                                                                        <div class="form-group">
                                                                                                            <label class="control-label">Current Password</label>
                                                                                                            <input type="password" id="user_password" name="user_password" class="form-control" /> </div>
                                                                                                        <div class="form-group">
                                                                                                            <label class="control-label">New Password</label>
                                                                                                            <input type="password" id="user_new_password" name="user_new_password" class="form-control" /> </div>
                                                                                                        <div class="form-group">
                                                                                                            <label class="control-label">Re-type New Password</label>
                                                                                                            <input type="password" id="user_new_password_conf" name="user_new_password_conf" class="form-control" /> </div>
                                                                                                        <div class="margin-top-10">
                                                                                                            <a href="javascript:;" id="btnSubmit" class="btn green"> Change Password </a>
                                                                                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>-->
                                                <!-- END CHANGE PASSWORD TAB -->
                                                <!-- PRIVACY SETTINGS TAB -->
                                                <!--                                                <div class="tab-pane" id="tab_1_4">
                                                                                                    <form action="#">
                                                                                                        <table class="table table-light table-hover">
                                                                                                            <tr>
                                                                                                                <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                                                                                                <td>
                                                                                                                    <div class="mt-radio-inline">
                                                                                                                        <label class="mt-radio">
                                                                                                                            <input type="radio" name="optionsRadios1" value="option1" /> Yes
                                                                                                                            <span></span>
                                                                                                                        </label>
                                                                                                                        <label class="mt-radio">
                                                                                                                            <input type="radio" name="optionsRadios1" value="option2" checked/> No
                                                                                                                            <span></span>
                                                                                                                        </label>
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                                                                <td>
                                                                                                                    <div class="mt-radio-inline">
                                                                                                                        <label class="mt-radio">
                                                                                                                            <input type="radio" name="optionsRadios11" value="option1" /> Yes
                                                                                                                            <span></span>
                                                                                                                        </label>
                                                                                                                        <label class="mt-radio">
                                                                                                                            <input type="radio" name="optionsRadios11" value="option2" checked/> No
                                                                                                                            <span></span>
                                                                                                                        </label>
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                                                                <td>
                                                                                                                    <div class="mt-radio-inline">
                                                                                                                        <label class="mt-radio">
                                                                                                                            <input type="radio" name="optionsRadios21" value="option1" /> Yes
                                                                                                                            <span></span>
                                                                                                                        </label>
                                                                                                                        <label class="mt-radio">
                                                                                                                            <input type="radio" name="optionsRadios21" value="option2" checked/> No
                                                                                                                            <span></span>
                                                                                                                        </label>
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                                                                <td>
                                                                                                                    <div class="mt-radio-inline">
                                                                                                                        <label class="mt-radio">
                                                                                                                            <input type="radio" name="optionsRadios31" value="option1" /> Yes
                                                                                                                            <span></span>
                                                                                                                        </label>
                                                                                                                        <label class="mt-radio">
                                                                                                                            <input type="radio" name="optionsRadios31" value="option2" checked/> No
                                                                                                                            <span></span>
                                                                                                                        </label>
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </table>
                                                                                                        end profile-settings
                                                                                                        <div class="margin-top-10">
                                                                                                            <a href="javascript:;" class="btn red"> Save Changes </a>
                                                                                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>-->
                                                <!-- END PRIVACY SETTINGS TAB -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PROFILE CONTENT -->
                    </div>
                </div>
                <!-- END PAGE BASE CONTENT -->
            </div>


        </div>
    </div>
</div>

@endsection

@section('script')
@include('Eleave/notification')

<script type="text/javascript">
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
                user_photo: {
                    extension: "Invalid file type",
                    filesize: "less than 1MB"
                }
            },
            rules: {
                "user_photo": {
                    filesize: 1048576,
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
                $('#btnSave').text('Updating...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 
                //success1.show();
                error1.hide();
                return true;
            }
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        });

    });
</script>
@endsection