@extends('layout.login')

@section('title','Elabram Internal System | Change Password')

@section('css')
<style>
    .login-page{
        text-align: center;
        padding-top: 1.5rem;
        display:block;
    }
    .login-page:hover{
        text-decoration: underline;
    }
    .form-simple input[type="password"] {
            margin-bottom: 10px;
    }
    .form-simple input[type="text"] {
        margin-bottom: 10px;
    }
    .toggle-password,
    .toggle-confirm-password{
        position: absolute;
        right: 0;
        top: 0;
        margin: 15px 10px;
        cursor: pointer;
        color: #000;
    }
    .form-control-position {
        top: 0px;
    }
</style>
@endsection

@section('content')
<div id="reset-password-form">
    <section class="flexbox-container">
        <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header no-border">
                    <div class="card-title text-xs-center">
                        <div class="p-1"><img src="http://elabram.com/pulsa/dashboard/image/elabram_logo.png"
                                alt="branding logo"></div>
                    </div>
                    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                        <span>Change Password</span>
                    </h6>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        <input type="hidden" id="reset_token" value="{{ $token }}">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <div class="alert alert-danger error-msg" v-if="showError">@{{errorMsg}}</div>
                            <div class="alert alert-success success-msg" v-if="showSuccess">@{{successMsg}}</div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <input type="password" class="form-control form-control-lg input-lg mb-0" id="password" name="password" placeholder="New Password" title="New Password Required" v-model="resetPassInput.password">
                            <div class="form-control-position">
                                <i class="fa fa-lock"></i>
                            </div>
                             <i class="fa toggle-password fa-eye-slash"></i>
                        </fieldset>
                        <br/>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="password" class="form-control form-control-lg input-lg" id="newpassword" name="newpassword" placeholder="Retype New Password" title="Retype New Password Required" v-model="resetPassInput.retypePassword">
                            <div class="form-control-position">
                                <i class="fa fa-lock"></i>
                            </div>
                            <i class="fa toggle-confirm-password fa-eye-slash "></i>
                        </fieldset>
                        <button class="btn btn-primary btn-lg btn-block" @click="checkEmail()" :disabled="btnDisabled">
                            <i class="fa fa-key"></i> @{{ textBtnReset }}
                        </button>

                        <a href="{{ URL::to('login') }}" class="login-page">
                            Back to Login Page
                        </a>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-xs-center">
                        <a href="https://www.facebook.com/elabramsystems/
                               "
                            class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="fa fa-facebook"></span></a>
                        <a href="https://twitter.com/elabram_systems?lang=en" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span
                                class="fa fa-twitter"></span></a>
                        <a href="https://www.linkedin.com/company/elabram-systems" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"><span
                                class="fa fa-linkedin font-medium-4"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<!-- app js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/reset-password.js') }}"></script>
<script type="text/javascript">
    $(".toggle-password").on("click", function () {
        var getClass = $(this).attr("class").split(' ')[2];
        if (getClass == "fa-eye-slash") {
            $(this).removeClass("fa-eye-slash");
            $(this).addClass("fa-eye");
        } else {
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
        }

        var getType = $("#password").attr("type");
        if (getType == "password") {
            $("#password").attr("type", "text");
        } else {
            $("#password").attr('type', "password");
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

        var getType = $("#newpassword").attr("type");
        if (getType == "password") {
            $("#newpassword").attr("type", "text");
        } else {
            $("#newpassword").attr('type', "password");
        }
    });
</script>
@endsection
