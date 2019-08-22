@extends('layout.login')

@section('title','Elabram Internal System | Forgot Password')

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
    .form-control-position {
        top: 0px;
    }
</style>
@endsection

@section('content')
<div id="forgot-password-form">
    <section class="flexbox-container">
        <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header no-border">
                    <div class="card-title text-xs-center">
                        <div class="p-1"><img src="http://elabram.com/pulsa/dashboard/image/elabram_logo.png"
                                alt="branding logo"></div>
                    </div>
                    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                        <span>Forgot Password</span>
                    </h6>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <div class="alert alert-danger error-msg" v-if="showError">@{{errorMsg}}</div>
                            <div class="alert alert-success success-msg" v-if="showSuccess">@{{successMsg}}</div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control form-control-lg input-lg" id="email" name="email" placeholder="Your Email" title="Password Required" v-model="forgotPassInput.email">
                            <div class="form-control-position">
                                <i class="fa fa-user"></i>
                            </div>
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
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/forgot-password.js') }}"></script>
@endsection
