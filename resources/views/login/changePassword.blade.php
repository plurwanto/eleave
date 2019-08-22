@extends('layout.main')

@section('title','Elabram Internal System | Change Password')

@section('css')
<style type="text/css">
	.toggle-old-password,
    .toggle-new-password,
    .toggle-confirm-password {
        margin-top: -25px !important;
        cursor: pointer;
        color: #000 !important;
    }
    .icon-arrow-left{
        padding-bottom: 2px;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div id="change-password-form">
    <div class="col-xs-12 col-md-4 col-md-offset-4 col-xs-offset-0">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue-sharp bold uppercase">Change Password</span>
                    <i class="icon-lock font-blue-sharp"></i>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-group">
                    <div class="alert alert-danger error-msg" v-if="showError">@{{errorMsg}}</div>
                    <div class="alert alert-success success-msg" v-if="showSuccess">@{{successMsg}}</div>
                </div>
                <div class="form-group">
                    <label>Old Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock font-green"></i>
                        <input type="password" class="form-control" placeholder="Old Password" v-model="changePassInput.oldPassword" id="oldPassword">
                        <div class="input-icon right">
                            <i class="fa toggle-old-password fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock font-green"></i>
                        <input type="password" class="form-control" placeholder="New Password" v-model="changePassInput.password" id="newPassword">
                        <div class="input-icon right">
                            <i class="fa toggle-new-password fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Retype Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock font-green"></i>
                        <input type="password" class="form-control" placeholder="Retype New Password" v-model="changePassInput.retypePassword" id="confirmPassword">
                    </div>
                    <div class="input-icon right">
                        <i class="fa toggle-confirm-password fa-eye-slash"></i>
                    </div>
                </div>
                <div class="form-actions margin-top-30 text-center" @click="checkEmail()" :disabled="btnDisabled">
                    <button type="submit" class="btn blue">@{{ textBtnReset }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- app js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/change-password.js') }}"></script>
<script type="text/javascript">
    $(".toggle-old-password").on("click", function () {
        var getClass = $(this).attr("class").split(' ')[2];
        if (getClass == "fa-eye-slash") {
            $(this).removeClass("fa-eye-slash");
            $(this).addClass("fa-eye");
        } else {
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
        }

        var getType = $("#oldPassword").attr("type");
        if (getType == "password") {
            $("#oldPassword").attr("type", "text");
        } else {
            $("#oldPassword").attr('type', "password");
        }
    });
    
    $(".toggle-new-password").on("click", function () {
        var getClass = $(this).attr("class").split(' ')[2];
        if (getClass == "fa-eye-slash") {
            $(this).removeClass("fa-eye-slash");
            $(this).addClass("fa-eye");
        } else {
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
        }

        var getType = $("#newPassword").attr("type");
        if (getType == "password") {
            $("#newPassword").attr("type", "text");
        } else {
            $("#newPassword").attr('type', "password");
        }
    });

    $(".toggle-confirm-password").on("click", function () {
        var getClass = $(this).attr("class").split(' ')[2];
        if (getClass == "fa-eye-slash") {
            $(this).removeClass("fa-eye-slash");
            $(this).addClass("fa-eye");
        } else {
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
        }

        var getType = $("#confirmPassword").attr("type");
        if (getType == "password") {
            $("#confirmPassword").attr("type", "text");
        } else {
            $("#confirmPassword").attr('type', "password");
        }
    });
</script>
@endsection
