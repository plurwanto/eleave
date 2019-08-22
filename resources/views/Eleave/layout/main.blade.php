<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{{ URL::asset(env('PUBLIC_PATH').'images/Elabram_favicon.ico') }}}">

    <title>Elabram Portal | @yield('title')</title>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />

    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'simple-line-icons/simple-line-icons.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-switch/css/bootstrap-switch.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!--<link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
                        <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />  -->

    <!--<link href="//cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">    
        <link href="//cdn.datatables.net/fixedcolumns/3.0.4/css/dataTables.fixedColumns.css" rel="stylesheet" />-->

    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables_eleave/dataTables.bootstrap.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables_eleave/dataTables.fixedColumns.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link
        href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-fileinput/bootstrap-fileinput.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-toastr/toastr.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'nprogress/nprogress.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'fullcalendar/fullcalendar.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!--        <link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />-->
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ URL::asset(env('GLOBAL_CSS_PATH').'components.min.css') }}" rel="stylesheet" id="style_components"
        type="text/css" />
    <link href="{{ URL::asset(env('GLOBAL_CSS_PATH').'plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout4/css/themes/light.min.css') }}" rel="stylesheet"
        type="text/css" id="style_color" />
    <link href="{{ URL::asset(env('LAYOUT_PATH').'layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    
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

    @yield('style')

    <!-- END HEAD -->
    <style>
    .dataTables_wrapper .dataTables_processing {
        z-index: 999;
        padding: 15px;
    }

    .table>thead>tr>th {
        vertical-align: middle;
    }

    .table>thead>tr>th,
    .table>tfoot>tr>td,
    .table>tbody>tr>td {
        font-size: 12px !important;
        padding: 6px 10px !important;
    }

    .table>tbody>tr>td>.label {
        font-size: 12px !important;
        word-break: break-all !important;
        vertical-align: text-bottom;
    }

    .table>thead>tr>.sorting_asc {
        background-position: top 8px right !important;
    }

    .table>thead>tr>.sorting,
    .table>thead>tr>.sorting_desc {
        background-position: top right !important;
    }

    .DTFC_LeftBodyWrapper .dataTable thead .sorting,
    .DTFC_LeftBodyWrapper .dataTable thead .sorting_asc,
    .DTFC_LeftBodyWrapper .dataTable thead .sorting_desc {
        background: unset;
    }

    .table .btn-xs {
        width: 23px;
    }

    .filter {
        font-size: 12px;
        padding-right: 4px;
        padding-left: 4px;
        padding-bottom: 3px;
        padding-top: 3px;
        width: 100% !important;
        height: 25px;
        margin-top: 3px;
        border: 1px solid #c2cad8 !important;
    }

    .filter-wrapper,
    .filter-wrapper-small,
    .filter-wrapper-day,
    .filter-wrapper-date,
    .filter-wrapper-type,
    .filter-wrapper-date-start,
    .filter-point,
    .filter-wrapper-year,
    .filter-wrapper-month,
    .filter-wrapper-100,
    .filter-70 {
        margin: 5px 0;
        font-size: 12px;
        white-space: nowrap;
    }

    .DTFC_NoData {
        height: unset !important;
    }


    /* .filter-wrapper {
        display: inline-block;
        white-space: nowrap;
    }

    .filter-wrapper-small {
        margin-top: 3px;
        display: inline-block;
        white-space: nowrap;
    }

    .filter-wrapper-day {
        margin-top: 3px;
    }

    .filter-wrapper-date {
        margin-top: 3px;
        font-size: 12px;
        display: inline-block;
        white-space: nowrap;
    }

    .filter-wrapper-type {
        margin-top: 3px;
        font-size: 12px;
        white-space: normal;
    } */

    .text-wrap {
        white-space: normal;
    }

    .width-200 {
        width: 200px;
    }

    .width-100 {
        width: 100px;
    }

    .width-5 {
        width: 5px;
    }

    .page-footer {
        background-color: #26344b;
    }

    .page-header.navbar .top-menu .navbar-nav>li.dropdown-dark .dropdown-menu .dropdown-menu-list>li a {
        color: #8e9daa;
        border-bottom: 1px solid #dae2ea !important;
    }

    .page-header.navbar .top-menu .navbar-nav>li.dropdown-dark .dropdown-menu .dropdown-menu-list>li a:hover {
        color: #d4dadf;
    }

    .notification-bottom:hover {
        text-decoration: unset;
    }

    .notification-bottom-content:hover {
        background: #dae2ea;
    }

    .notification-bottom-content {
        padding: 10px;
        text-align: center;
        border-top: 1px solid #dae2ea;
    }

    table.dataTable td.dataTables_empty {
        text-align: center;
    }

    .blockUI.blockOverlay {
        z-index: 9999 !important;
    }

    /* filter for approval menu */
    .dropdown-menu {
        position: absolute;
    }

    #usertable,
    div.DTFC_RightBodyWrapper table,
    div.DTFC_LeftBodyWrapper table {
        margin-top: -10px !important;
    }

    #usertable>thead>tr>th,
    div.DTFC_RightBodyWrapper table>thead>tr>th,
    div.DTFC_LeftBodyWrapper table>thead>tr>th {
        border-bottom: 1px solid #e7ecf1 !important;
    }

    div.DTFC_RightHeadWrapper table,
    div.DTFC_LeftHeadWrapper table {
        margin-bottom: -2px !important;
    }

    .dataTables_scrollHead {
        border-bottom: unset !important;
    }

    .dataTables_scrollBody,
    .DTFC_ScrollWrapper,
    .DTFC_LeftBodyWrapper,
    .DTFC_RightBodyWrapper,
    .DTFC_RightWrapper {
        height: auto !important;
        width: auto !important;
    }

    .DTFC_LeftBodyLiner,
    .DTFC_RightBodyLiner {
        height: 100% !important;
        width: 100% !important;
    }

    .DTFC_RightWrapper {
        right: 0 !important;
        left: unset !important;
    }

    .DTFC_Blocker {
        display: none !important;
    }

    .ms-choice {
        border: unset !important;
        height: unset !important;
        line-height: 23px !important;
    }

    .ms-drop {
        min-width: 100px;
    }
    </style>
    @yield('notif')
    
</head>

<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo" style="background: unset;">
                <a href="{{URL::to('/eleave')}}">
                    <img src="{{ URL::asset(env('IMAGES_PATH').'/logo_small.png') }}" alt="logo" class="logo-default"
                        width="140px" style="margin-top:15px;" /> </a>
                <div class="menu-toggler sidebar-toggler hide">
                    <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                </div>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
            data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->

        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide"> </li>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- DOC: Apply "dropdown-hoverable" class after "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                    <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->

                    <!-- END NOTIFICATION DROPDOWN -->
                    <li class="separator hide"> </li>
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    @include('Eleave/notify')

                    <!-- END INBOX DROPDOWN -->
                    <li class="separator hide"> </li>
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                            data-close-others="true">
                            <span class="username username-hide-on-mobile"> {{session('nama')}} </span>
                            <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                            <?php //if (session('photo') != null) {?>
                            <!-- <img alt="image_profile" class="img-circle" src="{{ url('/').session('photo') }}"  style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; object-position: top;"/> </a>-->
                            <?php //} else {?>
                            <img alt="" class="img-circle"
                                src="{{ URL::to(env('PUBLIC_PATH'). '/' .session('photo')) }}"
                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; object-position: top;" />
                        </a>
                        <?php //}?>
                        <ul class="dropdown-menu dropdown-menu-default">
                            @if(!session('is_admin'))
                            <li>
                                <a href="{{ URL::to('eleave/user/profile') }}">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ URL::to('/index') }}">
                                    <i class="icon-arrow-left"></i> Back to portal </a>
                            </li>
                            <li>
                                <a href="{{ URL::to('logout') }}">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->

                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            @include('Eleave/navigation')
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEAD-->
                <div class="page-head">
                    <!-- BEGIN PAGE TITLE -->
                    <!-- END PAGE TITLE -->
                    <!-- BEGIN PAGE TOOLBAR -->
                    <!-- END PAGE TOOLBAR -->
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE BREADCRUMB -->
                <!-- END PAGE BREADCRUMB -->

                <!-- BEGIN PAGE BASE CONTENT -->
                <input type="hidden" name="token" id="token" value="{{ session('token') }}">
                <input type="hidden" name="branch_id" id="branch_id" value="{{ session('branch_id') }}">
                <input type="hidden" name="id_eleave" id="id_eleave" value="{{ session('id_eleave') }}">
                <input type="hidden" name="user_login" id="user_login" value="{{ session('nama') }}">
                @yield('content')
                <!-- END PAGE BASE CONTENT -->

            </div>
            <!-- END CONTENT BODY -->
        </div>
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div style="color: #a1b2cf;text-align:center;">
            2018 © Elabram Systems.
        </div>
        <div class="scroll-to-top" style="right: 80px;">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->

    <!-- BEGIN QUICK NAV -->
    <!-- END QUICK NAV -->

    <!--[if lt IE 9]>
            <script src="../assets/global/plugins/respond.min.js"></script>
            <script src="../assets/global/plugins/excanvas.min.js"></script> 
            <script src="../assets/global/plugins/ie8.fix.min.js"></script> 
        <![endif]-->

    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap/js/bootstrap.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'js.cookie.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-slimscroll/jquery.slimscroll.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-switch/js/bootstrap-switch.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-fileinput/bootstrap-fileinput.js') }}"
        type="text/javascript"></script>
    <!--<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.js') }}"  type="text/javascript"></script>
            <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.js') }}"  type="text/javascript"></script> -->

    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables_eleave/jquery.dataTables.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables_eleave/dataTables.bootstrap.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables_eleave/dataTables.fixedColumns.min.js') }}"
        type="text/javascript"></script>
    <!--<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js" type="text/javascript"></script>-->
    <!--<script type="text/javascript" src="//cdn.datatables.net/1.10.6/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.js"></script>
        <script src="//cdn.datatables.net/fixedcolumns/3.0.4/js/dataTables.fixedColumns.min.js"></script>-->

    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'counterup/jquery.waypoints.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'counterup/jquery.counterup.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
        type="text/javascript"></script>
    <script
        src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.js') }}"
        type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-toastr/toastr.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'nprogress/nprogress.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'fullcalendar/lib/moment.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'fullcalendar/fullcalendar.min.js') }}" type="text/javascript">
    </script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{ URL::asset(env('GLOBAL_SCRIPT_PATH').'app.min.js') }}" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/notify.js').'?v='.date('ymdHis') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{ URL::asset(env('LAYOUT_PATH').'layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('LAYOUT_PATH').'layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset(env('LAYOUT_PATH').'global/scripts/quick-sidebar.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ URL::asset(env('LAYOUT_PATH').'global/scripts/quick-nav.min.js') }}" type="text/javascript">
    </script>
    <!-- END THEME LAYOUT SCRIPTS -->

    <!-- helper.js -->
    <script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/helper.js') }}"></script>

    <script>
    NProgress.start();
    window.onload = function() {
        NProgress.done();
    }

    let publicPath = `${webUrl}{{ env("PUBLIC_PATH") }}`

    staffRequestNotif()
    </script>

    @yield('script')
</body>

</html>