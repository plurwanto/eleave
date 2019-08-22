<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="PIXINVENT">
        <title>@yield('title')</title><link rel="shortcut icon" type="image/x-icon" href="{{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_favicon.ico') }}}">
        <link href="{{ URL::asset(env('PUBLIC_PATH').'fonts/portal-font.css') }}"
            rel="stylesheet">
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/style.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/flag-icon.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/pace.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/iCheck/icheck.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/iCheck/custom.css') }}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN STACK CSS-->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/hris/app.css') }}">
        <!-- END STACK CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset(env('PUBLIC_PATH').'css/login-register.css') }}">
        <!-- END Page Level CSS-->
        @yield('css')
    </head>

    <body data-open="hover" data-menu="horizontal-menu" data-col="1-column" class="horizontal-layout horizontal-menu 1-column  bg-full-screen-image menu-expanded blank-page blank-page">

        <!-- page content -->
        <div class="app-content content container-fluid">
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <input type="hidden" id="token" value="">
                    <input type="hidden" id="id_hris" value="">
                    <input type="hidden" id="id_eleave" value="">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- jQuery -->
        <script src="{{ URL::asset(env('PUBLIC_PATH').'js/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ URL::asset(env('PUBLIC_PATH').'js/bootstrap.min.js') }}"></script>
        <!-- axios -->
        <script src="{{ URL::asset(env('PUBLIC_PATH').'js/axios.js') }}"></script>
        <!-- Vue.js -->
        <script src="{{ URL::asset(env('PUBLIC_PATH').env('VUE_FILE')) }}"></script>
        <!-- vue config -->
        <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
        <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/helper.js') }}"></script>
        @yield('script')
    </body>
</html>