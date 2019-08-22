<style>
.img-flag{
    border-radius: 6px!important;
    padding: 4px 0;
    margin-left: 5px;
    width: 40px;
}
</style>
<!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{ URL::asset(env('APP_URL').'/hris/dashboard') }}">
                    <img src="{{ URL::asset(env('IMAGES_PATH').'/logo_small.png') }}" alt="logo" class="logo-default"
                        width="150px" style="margin-top:15px;" /> </a>
                </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-hoverable" class after "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                    <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->

                    @php
                    if($userAccess){
                        if($userAccess['response_code'] == 200){
                            if((count($userAccess['notif']) + count($userAccess['notifCustomer'])) > 0){
                                if((count($userAccess['notif']) + count($userAccess['notifCustomer'])) > 1){
                                $height = '150px';
                                }else{
                                    $height = '50px';
                                }
                            echo '<li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                        data-close-others="true">
                                        <i class="icon-bell"></i>
                                        <span class="badge badge-default">'. (count($userAccess['notif']) + count($userAccess['notifCustomer'])) .'</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="external">
                                            <h3>You have
                                                <strong>'. (count($userAccess['notif']) + count($userAccess['notifCustomer'])) .' pending</strong> tasks</h3>
                                            <!-- <a href="app_todo.html">view all</a> -->
                                        </li>
                                        <li>
                                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">';
                                                if($userAccess['notif']){
                                                    for($a = 0;$a < count($userAccess['notif']); $a++){
                                                        echo '<li>
                                                                <a target="blank" href="'. env('APP_URL').'/hris/finance/payroll/approval?link=need-approve">
                                                                <span class="time">'.$userAccess['notif'][$a]['hours'].'</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-success">
                                                                        <i class="fa fa-check-circle-o "></i>
                                                                    </span>'.$userAccess['notif'][$a]['app_code'].' need your approval. </span>
                                                                </a>
                                                            </li>';
                                                    }
                                                }

                                                if($userAccess['notifCustomer']){
                                                    for($a = 0;$a < count($userAccess['notifCustomer']); $a++){
                                                        echo '<li>
                                                                <a target="blank" href="'. env('APP_URL').'/hris/customer?link=not-approved">
                                                                <span class="time">'.$userAccess['notifCustomer'][$a]['hours'].'</span>
                                                                <span class="details">
                                                                    <span class="label label-sm label-icon label-danger">
                                                                        <i class="fa fa-university"></i>
                                                                    </span>'.$userAccess['notifCustomer'][$a]['cus_code'].' need your approval. </span>
                                                                </a>
                                                            </li>';

                                                    }
                                                }
                                            echo '</ul>
                                        </li>
                                    </ul>
                                </li>';
                            }
                        }else{
                            echo '<script type="text/javascript">
                                    window.alert("you don\'t have access");
                                    window.location.href="'.env('APP_URL').'/index";
                                </script>';
                                exit;
                        }
                    }
                    @endphp

                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- <li class="droddown dropdown-separator">
                        <span class="separator"></span>
                    </li> -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                            data-close-others="true">
                            @php
                                echo '<img class="img-circle" src="'. URL::asset(env('PUBLIC_PATH').'images/profile_picture.png').'">';
                            @endphp
                            <span class="username username-hide-mobile">{{$userAccess['profile'][0]['nama']}}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a>
                                    <font style="font-size: 12px">Branch</font><br>
                                    {{$userAccess['profile'][0]['br_name']}}
                                </a>

                            </li>
                            <li>
                                <a>
                                    <font style="font-size: 12px">Position</font><br>
                                    {{$userAccess['profile'][0]['div_name']}}
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                            <a dataaction="getProfile" dataid="{{$userAccess['profile'][0]['user_id']}}" onclick="get_modal_navigation(this)">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="{{ URL::asset(env('APP_URL').'/index' ) }}">
                                    <i class="icon-globe"></i> Back to Portal </a>
                            </li>
                            <li>
                                <a href="{{ URL::asset(env('APP_URL').'/logout') }}">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <li class="droddown dropdown-separator">
                        <span class="separator"></span>
                    </li>
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li>
                            @php
                            switch ($userAccess['profile'][0]['br_id']) {
                            case 1:
                            echo '<img class="img-flag" src="'. URL::asset(env('PUBLIC_PATH').'images/logo-ind.png').'">';
                                break;
                            case 3:
                                echo '<img class="img-flag" src="'. URL::asset(env('PUBLIC_PATH').'images/logo-mal.png').'">';
                                break;
                            case 4:
                                echo '<img class="img-flag" src="'. URL::asset(env('PUBLIC_PATH').'images/logo-phi.png').'">';
                                break;
                            case 5:
                                echo '<img class="img-flag" src="'. URL::asset(env('PUBLIC_PATH').'images/logo-tha.png').'">';
                                break;
                            default;
                                echo '<img class="img-flag" src="'. URL::asset(env('PUBLIC_PATH').'images/logo-ind.png').'">';
                                break;
                            }
                            @endphp
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    <div class="page-header-menu">
        <div class="container-fluid">
            <!-- BEGIN HEADER SEARCH BOX -->
            <form class="search-form" action="{{ URL::asset(env('APP_URL').'/hris/employee/others') }}" method="GET">
                <div class="input-group">
                    <input type="hidden" name="link" value="search">
                    <input type="text" class="form-control" autocomplete="off" placeholder="Name / NIP / ID Number / Email / Account Number of Bank" name="keyword">
                    <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit">
                            <i class="icon-magnifier"></i>
                        </a>
                    </span>
                </div>
            </form>
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN MEGA MENU -->
            <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
            <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
            <div class="hor-menu  ">
                <ul class="nav navbar-nav">
                    @for($a=0; $a < count($userAccess['menu']); $a++)
                    @php
                    if(strpos($_SERVER['REQUEST_URI'],  $userAccess['menu'][$a]['menu_link']) !== false){
                        $isActive = 'active';
                    }else{
                        $isActive = '';
                    }

                    if(count($userAccess['menu'][$a]['sub_menu']) > 0){
                        $link = '#';
                    }else{
                        $link = env('APP_URL'). $userAccess['menu'][$a]['menu_link'];
                    }
                    @endphp

                    @if(count($userAccess['menu'][$a]['sub_menu']) > 0)
                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown {{$isActive}}">
                        <a href="#">
                            <i class="{{$userAccess['menu'][$a]['menu_icon']}}" active></i> {{$userAccess['menu'][$a]['menu_name']}}
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            @for($b=0; $b < count($userAccess['menu'][$a]['sub_menu']); $b++)
                            <li aria-haspopup="true" class="dropdown-submenu">
                                    @php
                                        if(count($userAccess['menu'][$a]['sub_menu'][$b]['sub_menu']) > 0){
                                            $dropdown = 'dropdown-submenu';
                                        }else{
                                            $dropdown = '';
                                        }

                                        if(strpos($_SERVER['REQUEST_URI'],  $userAccess['menu'][$a] ['sub_menu'][$b]['menu_link'])!== false){
                                            $isActive = 'active';
                                        }else{
                                            $isActive = '';
                                        }

                                        if(count($userAccess['menu'][$a]['sub_menu'][$b]['sub_menu']) > 0){
                                                $link = '#';
                                            }else{
                                                $link = env('APP_URL'). $userAccess['menu'][$a]['sub_menu'][$b]['menu_link'];
                                            }
                                    @endphp
                                    <li aria-haspopup="true" class="{{$dropdown}} {{$isActive}}">
                                    <a href="{{$link}}" class="nav-link nav-toggle ">
                                        <i class="{{$userAccess['menu'][$a]['sub_menu'][$b]['menu_icon']}}"></i> {{$userAccess['menu'][$a]['sub_menu'][$b]['menu_name']}}
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @for($c=0; $c < count($userAccess['menu'][$a]['sub_menu'][$b]['sub_menu']); $c++)
                                            @php
                                                if(strpos($_SERVER['REQUEST_URI'],  $userAccess['menu'][$a]['sub_menu'][$b]['sub_menu'][$c]['menu_link'])!== false){
                                                    $isActive = 'active';
                                                }else{
                                                    $isActive = '';
                                                }
                                            @endphp
                                                <li aria-haspopup="true" class="{{$isActive}}">
                                            <a href="{{ env('APP_URL'). $userAccess['menu'][$a]['sub_menu'][$b]['sub_menu'][$c]['menu_link']}}">
                                                <i class="{{$userAccess['menu'][$a]['sub_menu'][$b]['sub_menu'][$c]['menu_icon']}}"></i> {{$userAccess['menu'][$a]['sub_menu'][$b]['sub_menu'][$c]['menu_name']}}
                                            </a>
                                                </li>
                                        @endfor
                                    </ul>
                                </li>
                            @endfor
                        </ul>
                    </li>
                    @elseif(count($userAccess['menu'][$a]['sub_menu']) == 0
                    && in_array($userAccess['menu'][$a]['menu_name'], ['Dashboard','Customer'])
                    && in_array($userAccess['menu'][$a]['menu_name'], ['Dashboard','Customer'])
                    )
                    <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown {{$isActive}}">
                        <a href="{{ env('APP_URL').$userAccess['menu'][$a]['menu_link']}}">
                            <i class="{{$userAccess['menu'][$a]['menu_icon']}}" active></i> {{$userAccess['menu'][$a]['menu_name']}}
                            <span class="arrow"></span>
                        </a>
                    </li>
                    @endif
                @endfor

                </ul>
            </div>
            <!-- END MEGA MENU -->
        </div>
    </div>
    <!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
<script>
function get_modal_navigation(e)
{
    linkObj = $(e);
    action = $(e).attr('dataaction');
    dataid = $(e).attr('dataid');
    var arr = dataid.split("|");
    var link = $("#link").val();

    if (action == 'getProfile') {
        $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
        var id = arr[0];
        $.get("{{ URL::asset(env('APP_URL').'/hris/dashboard/get-profile') }}",
        {
            id: arr[0],
            link: link,
        },
        function (data) {
            $(".modal-content").html(data);
        });
    }
}
</script>
