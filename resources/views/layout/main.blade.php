<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <title>Elabram Internal Systems | @yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('PUBLIC_PATH').'css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('PUBLIC_PATH').'css/simple-line-icons.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('PUBLIC_PATH').'css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('PUBLIC_PATH').'css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('PUBLIC_PATH').'css/blue.min.css') }}" rel="stylesheet" type="text/css"
        id="style_color" />
    <link rel="shortcut icon" href="{{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_favicon.ico') }}}" />

    <style>
    html,
    body {
        width: 100%;
    }

    body {
        background-color: #ffffff;
    }

    .page-container,
    .page-content-wrapper {
        background-color: #fafafa;
    }

    .box-header {
        background-color: #fff;
        box-shadow: 0 1px 10px 0 rgba(50, 50, 50, .2);
        height: 68px;
        min-height: 68px;
    }

    @media (min-width: 767px) {
        .box-header {
            box-shadow: 0 1px 10px 0 rgba(50, 50, 50, .2);
        }

        .box-header .page-logo {
            float: unset !important;
            margin: 0 auto;
        }

        .box-column {
            width: 33.33333%;
            float: left;
        }

        .box-header .page-top {
            box-shadow: unset !important;
        }

        .box-header .btn {
            margin: 15px;
            margin-left: 30px;
        }

    }

    @media (max-width: 769px) {
        .page-header {
            height: auto !important;
            background: transparent !important;

        }

        .page-content-wrapper {
            margin-top: 40px;
        }

        .box-column {
            width: 50%;
            float: left;
        }

        .box-column:first-child {
            top: 80px !important;
            left: 20px !important;
        }
    }

    @media (max-width: 991px) {
        .row {
            margin: unset;
        }

        .box-column:first-child {
            position: absolute;
            top: 70px;
            left: 10px;
        }
    }

    .page-content {
        background-color: unset !important;
    }

    .page-sidebar-wrapper {
        display: none;
    }

    .page-content-wrapper .page-content {
        margin-left: 0;
    }

    .application-list {
        text-align: center;
    }

    .application-list-header h1 {
        color: #373d43;
        font-size: 35px;
        font-weight: 700;
    }

    .application-list .row {
        display: inline;
    }

    .application-name {
        /* height: 175px; */
        height: 165px;
        border: 1px solid #e7ecf1;
        display: table;
        width: 100%;
        background-size: 100%;
        color: white;
        font-size: 20px;
    }

    .mt-element-overlay .mt-overlay-4:hover h2 {
        transform: translatey(40px) !important;
    }

    .eleave {
        background-image: url("{{ URL::asset(env('PUBLIC_PATH').'images/portal/images-01.png') }}");
        background-size: cover;
    }

    .hris {
        background-image: url("{{ URL::asset(env('PUBLIC_PATH').'images/portal/images-02.png') }}");
        background-size: cover;
    }

    .recruitment {
        background-image: url("{{ URL::asset(env('PUBLIC_PATH').'images/portal/images-03.png') }}");
        background-size: cover;
    }

    .egemes {
        background-image: url("{{ URL::asset(env('PUBLIC_PATH').'images/portal/images-04.png') }}");
        background-size: cover;
    }

    .dashboard {
        background-image: url("{{ URL::asset(env('PUBLIC_PATH').'images/portal/images-05.png') }}");
        background-size: cover;
    }

    .dcs {
        background-image: url("{{ URL::asset(env('PUBLIC_PATH').'images/portal/images-06.png') }}");
        background-size: cover;
    }

    .application-name span {
        display: table-cell;
        vertical-align: middle;
        font-weight: bold;
        text-transform: uppercase;
    }

    .mt-element-card .mt-card-item {
        border: unset;
    }

    .page-footer {
        background-color: #26344b;
    }

    @media screen and (max-width: 600px) {
        .container-application {
            display: block !important;
        }
    }
    </style>
    <link href="{{ URL::asset(env('PUBLIC_PATH').'css/component.min.css') }}" rel="stylesheet" id="style_components"
        type="text/css" />
    @yield('css')
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
            <div class="row box-header">
                <div class="box-column">
                    <a href="{{ URL::to('index') }}" class="btn btn-circle btn-default"
                        style="{{ Request::is('change-password') ? '' : 'visibility: hidden' }}">
                        <i class="icon-arrow-left"></i>
                        Back to Portal
                    </a>
                </div>
                <div class="box-column">
                    <div class="page-logo " style="padding-left:15px;background:white;">
                        <a href="index.html">
                            <img src="{{ URL::asset(env('PUBLIC_PATH').'images/logo-crop.png') }}" alt="logo"
                                class="logo-default" width="140px" style="margin-top:5px;" />
                        </a>
                    </div>
                </div>
                <div class="box-column">
                    <div class="page-top">
                        <div class="top-menu">
                            <ul class="nav navbar-nav pull-right">
                                <li class="dropdown dropdown-user">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                        data-hover="dropdown" data-close-others="true">
                                        <span class="username username-hide-on-mobile"> {{ session('name') }} </span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-default">
                                        <li>
                                            <a href="{{ URL::to('change-password') }}">
                                                <i class="icon-lock"></i> Change Password
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ URL::to('logout') }}">
                                                <i class="icon-logout"></i> Log Out
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class="page-container">
        <div class="page-content-wrapper">
            <div class="page-content">
                <input type="hidden" id="token" value="{{ session('token') }}">
                <input type="hidden" id="id_hris" value="{{ session('id_hris') }}">
                <input type="hidden" id="id_eleave" value="{{ session('id_eleave') }}">
                @yield('content')
            </div>
        </div>
    </div>

    <div class="page-footer">
        <div style="color: #a1b2cf;text-align:center;">
            {{ date('Y') }} &copy; Elabram Systems.
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/layout.min.js') }}" type="text/javascript"></script>
    <!-- axios -->
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/axios.js') }}"></script>
    <!-- Vue.js -->
    <script src="{{ URL::asset(env('PUBLIC_PATH').env('VUE_FILE')) }}"></script>
    <!-- vue config -->
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
    @yield('script')
</body>

</html>