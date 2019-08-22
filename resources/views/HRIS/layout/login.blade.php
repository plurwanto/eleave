<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{{ URL::asset(env('PUBLIC_PATH').'images/elabramico.png') }}}">

        <title>@yield('title')</title>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all"            rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'font-awesome/css/font-awesome.min.css') }}"           rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'simple-line-icons/simple-line-icons.min.css') }}"     rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap/css/bootstrap.min.css') }}"                 rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-switch/css/bootstrap-switch.min.css') }}"   rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ URL::asset(env('GLOBAL_CSS_PATH').'components.min.css') }}"  rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ URL::asset(env('GLOBAL_CSS_PATH').'plugins.min.css') }}"     rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ URL::asset(env('PAGES_CSS_PATH').'login.min.css') }}"  rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
    </head>

    <body class="login">

        @yield('content')

        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.min.js') }}"                                type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap/js/bootstrap.min.js') }}"                type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'js.cookie.min.js') }}"                             type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-slimscroll/jquery.slimscroll.min.js') }}"  type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.blockui.min.js') }}"                        type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-switch/js/bootstrap-switch.min.js') }}"  type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.min.js') }}"      type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.min.js') }}"   type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.full.min.js') }}"                   type="text/javascript"></script>
        <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'backstretch/jquery.backstretch.min.js') }}"            type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ URL::asset(env('GLOBAL_SCRIPT_PATH').'app.min.js') }}"     type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'login.min.js') }}"  type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        @yield('script')
    </body>
</html>