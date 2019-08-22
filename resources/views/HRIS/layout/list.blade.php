<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Elabram Systems | @yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_favicon.ico') }}}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ URL::asset(env('GLOBAL_CSS_PATH').'components.min.css') }}" rel="stylesheet" id="style_components"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_CSS_PATH').'plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout3/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout3/css/themes/default.min.css') }}" rel="stylesheet" type="text/css"
        id="style_color" />
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout3/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- END THEME LAYOUT STYLES -->
    
 @yield('css')
</head>
<!-- END HEAD -->


<body class="page-container-bg-solid">
    <div class="page-wrapper">
        <div class="page-wrapper-row">
            <div class="page-wrapper-top">
            @include('HRIS/navigation')
            </div>
        </div>
        <div class="page-wrapper-row full-height">
            <div class="page-wrapper-middle">
                <!-- BEGIN CONTAINER -->
                <div class="page-container">
                    <!-- BEGIN CONTENT -->
                    <div class="page-content-wrapper">
                        <!-- BEGIN CONTENT BODY -->
                        <!-- BEGIN PAGE HEAD-->
                        <div class="page-head">
                            <div class="container">
                                <!-- BEGIN PAGE TITLE -->
                                <div class="page-title">
                                    <h1>@yield('title')
                                    </h1>
                                </div>
                                <!-- END PAGE TITLE -->

                            </div>
                        </div>
                        <!-- END PAGE HEAD-->
                        <!-- BEGIN PAGE CONTENT BODY -->
                        <input type="hidden" id="token" value="{{session('token')}}">
                        <input type="hidden" id="id_hris" value="{{session('id_hris')}}">
                        <input type="hidden" id="id_eleave" value="{{session('id_eleave')}}">

                        @yield('content')
                        <!-- END PAGE CONTENT BODY -->
                        <!-- END CONTENT BODY -->
                    </div>
                    <!-- END CONTENT -->
              
                </div>
                <!-- END CONTAINER -->
            </div>
        </div>
        <div class="page-wrapper-row">
            <div class="page-wrapper-bottom">
                <!-- BEGIN FOOTER -->
                <!-- BEGIN PRE-FOOTER -->
                <div class="page-prefooter">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                                <h2>About</h2>
                                <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam dolore. </p>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs12 footer-block">
                                <h2>Subscribe Email</h2>
                                <div class="subscribe-form">
                                    <form action="javascript:;">
                                        <div class="input-group">
                                            <input type="text" placeholder="mail@email.com" class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn" type="submit">Submit</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                                <h2>Follow Us On</h2>
                                <ul class="social-icons">
                                    <li>
                                        <a href="javascript:;" data-original-title="rss" class="rss"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-original-title="facebook" class="facebook"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-original-title="twitter" class="twitter"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-original-title="googleplus" class="googleplus"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-original-title="linkedin" class="linkedin"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-original-title="youtube" class="youtube"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" data-original-title="vimeo" class="vimeo"></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                                <h2>Contacts</h2>
                                <address class="margin-bottom-40"> Phone: 800 123 3456
                                    <br> Email:
                                    <a href="mailto:info@metronic.com">info@metronic.com</a>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PRE-FOOTER -->
                <!-- BEGIN INNER FOOTER -->
                <div class="page-footer">
                    <div class="container"> 2016 &copy; Metronic Theme By
                        <a target="_blank" href="http://keenthemes.com">Keenthemes</a> &nbsp;|&nbsp;
                        <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes"
                            title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase
                            Metronic!</a>
                    </div>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
                <!-- END INNER FOOTER -->
                <!-- END FOOTER -->
            </div>
        </div>
    </div>

    <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script>
<script src="../assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'js.cookie.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'morris/morris.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'morris/raphael-min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/amcharts/serial.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/amcharts/pie.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/amcharts/radar.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/amcharts/themes/light.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/amcharts/themes/patterns.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/amcharts/themes/chalk.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/ammap/ammap.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/ammap/maps/js/worldLow.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'amcharts/amstockcharts/amstock.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'horizontal-timeline/horizontal-timeline.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'flot/jquery.flot.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-easypiechart/jquery.easypiechart.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jqvmap/jqvmap/jquery.vmap.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jqvmap/jqvmap/maps/jquery.vmap.russia.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jqvmap/jqvmap/maps/jquery.vmap.world.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jqvmap/jqvmap/maps/jquery.vmap.europe.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jqvmap/jqvmap/maps/jquery.vmap.germany.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jqvmap/jqvmap/maps/jquery.vmap.usa.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jqvmap/jqvmap/data/jquery.vmap.sampledata.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{ URL::asset(env('GLOBAL_SCRIPT_PATH').'app.min.js') }}" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{ URL::asset(env('LAYOUT_PATH').'layout3/scripts/layout.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('LAYOUT_PATH').'layout3/scripts/demo.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('LAYOUT_PATH').'global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('LAYOUT_PATH').'global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->

    <!-- axios -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/axios.js') }}"></script>
<!-- Vue.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').env('VUE_FILE')) }}"></script>
    <script>
        $(document).ready(function () {
            $('#clickmewow').click(function () {
                $('#radio1003').attr('checked', 'checked');
            });
        })
    </script>
      @yield('script')
</body>

</html>
