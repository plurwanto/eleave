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
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ URL::asset(env('GLOBAL_CSS_PATH').'components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_CSS_PATH').'plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout3/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout3/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout3/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- END THEME LAYOUT STYLES -->
    <style>
.loading{
    background: #000000;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    opacity: 0.5;
    z-index: 8888888888;
    display: none;
}

.loading-span{
    /* background-repeat: no-repeat !Important;
    background-size: 100% !Important;
    background-position: center !Important;
    top: 0;
    left: 0;
    position: fixed;
    background: transparent url('{{{ URL::asset(env('IMG_PATH').'loading.gif') }}}');
    z-index: 1000;
    height: 100%;
    width: 100%; */
    top: 30%;
    left: 43%;
    position: fixed;
    background: transparent url('{{{ URL::asset(env('IMG_PATH').'loading.svg') }}}');
    z-index: 1000;
    height: 100%;
    width: 100%;
    background-repeat: no-repeat !Important;
}

.sweet-alert,
.sweet-overlay  {
  z-index: 99999 !Important;
}

.table-scrollable>.table-bordered>thead>tr:last-child>th, .table.table-bordered thead>tr>th,
table.dataTable tbody th, table.dataTable tbody td {
    padding: 6px 10px !Important;
    font-size:	12px !Important;
}

.select2-selection{
    min-width: 176px!important;
    border-radius: 6px !important;
}
.breadcrumb{
    padding: 15px 0;
}

.page-header .page-header-menu .search-form.open{
width: 250px!important;
/* width: 176px!important; */
transition: width .4s;
}
.page-header .page-header-menu .search-form .select2{
background-color: #444d58;
}
.page-header .page-header-menu .search-form .select2 .select2-selection{
    background-color: #444d58 !important;
    color: #bcc2cb !important;
    border: 1px solid #bcc2cb !important;
    border-radius: 6px !important;
}
.page-header .page-header-menu .search-form .select2 .select2-selection__rendered{
    color: #bcc2cb !important;
}
.page-header .page-header-menu .search-form .select2 .select2-selection__arrow{
    display: none
}
.page-header .page-header-menu .search-form .input-group{
border: 1px solid #BCC2CB;
border-radius: 6px !important;
}
.page-header .page-header-menu .search-form .input-group-btn{
background: #38414c !important;
border-top-right-radius: 6px !important;
border-bottom-right-radius: 6px !important;
/* border-right: 1px solid #BCC2CB !important;
border-top: 1px solid #BCC2CB !important;
border-bottom: 1px solid #BCC2CB !important; */
}
.page-header .page-header-menu .search-form.open .input-group-btn{
background: #38414c !important;
border-top-right-radius: 6px !important;
border-bottom-right-radius: 6px !important;
/* border-right: 1px solid #fff !important;
border-top: 1px solid #fff !important;
border-bottom: 1px solid #fff !important; */
}
.page-header .page-header-menu .search-form.open .input-group{
border: 1px solid #fff !important;
}
.page-header .page-header-menu .search-form .input-group .form-control{
border-top-left-radius: 6px !important;
border-bottom-left-radius: 6px !important;
/* border-bottom: 1px solid #c2cad8; */
/* border-left: 1px solid #BCC2CB !important;
border-top: 1px solid #BCC2CB !important; */
}
.page-header .page-header-menu .search-form.open .input-group .form-control{
border-top-left-radius: 6px !important;
border-bottom-left-radius: 6px !important;
/* border-bottom: 1px solid #fff; */
/* border-left: 1px solid #fff !important;
border-top: 1px solid #fff !important; */
}
.page-header .page-header-menu .search-form .input-group .form-control,
.page-header .page-header-menu .search-form .input-group .form-control::placeholder,
.page-header .page-header-menu .search-form .input-group .input-group-btn .btn.submit>i{
color: #BCC2CB !important;
}
.page-header .page-header-menu .search-form.open .input-group .form-control,
.page-header .page-header-menu .search-form.open .input-group .form-control::placeholder,
.page-header .page-header-menu .search-form.open .input-group .input-group-btn .btn.submit>i{
color: #fff !important;
}
.page-header .page-header-menu .hor-menu .navbar-nav>li>a{
    padding: 10px 15px;
    padding-top: 15px;
    padding-bottom: 15px;
}
.border-rounded {
border-radius: 6px !important;
}
div.dataTables_wrapper div.dataTables_length select{
border-radius: 6px !important;
}

.swal2-container {
  z-index: 9999999 !Important;
}

.modal-header.portlet{
        background-color: #444d58;
    }
    .modal-header .portlet-title .caption .fa{
        color: #BCC2CB !important;
    }
</style>
 @yield('css')
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid">
<div class="loading"><span class="loading-span"></span></div>
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
            <!-- BEGIN INNER FOOTER -->
            <div class="page-footer">
                <div class="container"> 2019 &copy; HRIS Portal | Elabram Systems
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
<div class="modal fade bs-modal-md portlet" id="modalAction" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div style="text-align: center"><h2><i class="fa fa-chevron-right-o-notch fa-spin fa-1x fa-fw"></i>
                <span>Loading...</span></h2>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ URL::asset(env('GLOBAL_SCRIPT_PATH').'app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ URL::asset(env('LAYOUT_PATH').'layout3/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('LAYOUT_PATH').'layout3/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('LAYOUT_PATH').'global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('LAYOUT_PATH').'global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'clockface/js/clockface.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'ui-sweetalert.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'ui-toastr.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
    $(document).ready(function()
    {
        $('#clickmewow').click(function()
        {
            $('#radio1003').attr('checked', 'checked');
        });

        $('.date-picker').datepicker({
            format: 'dd-M-yyyy',
            todayHighlight:'TRUE',
            autoclose: true,
        })

    });
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5d299adbbfcb827ab0cb96ba/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
@yield('script')
</body>

</html>
