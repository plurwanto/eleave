<li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar_employee">
    <input type="hidden" id="url_photo" value="{{ URL::to(env('PUBLIC_PATH')) }}">
    <input type="hidden" name="userId" id="userId" value="{{ session('id') }}">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">
        <i class="icon-bell"></i>
        <span id="total_all_user" class="badge badge-danger amount_user"></span>
    </a>
    <ul class="dropdown-menu" style="background: #ffffff;min-width: 300px; width: unset; max-width: unset;">
        <li class="external">
            <h3>You have
                <span id="tot_data_employee" class="bold"> </span> New Messages</h3>
        </li>
        <li>
            <ul id="list_all_user" class="dropdown-menu-list scroller" style="height: 255px;"
                data-handle-color="#637283">
                <!--Ajax-->
            </ul>
        </li>

    </ul>
</li>

<!--<li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar_employee">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">
        <i class="icon-bell"></i>
        <span id="total_all_user" class="badge badge-danger amount_user"></span>
    </a>
    <ul class="dropdown-menu" style="background: #ffffff;min-width: 300px; width: unset; max-width: unset;">
        <li class="external">
            <h3>You have
                <span id="tot_data_employee" class="bold"> </span> New Messages</h3>
        </li>
        <div class="portlet white" style="margin-bottom: 0;">
            <div class="tabbable-line boxless tabbable-reversed" style="padding-top: 0;">
                <form>
                    <div class="portlet-title tabbable-line" style="padding-top: 0;">
                        <ul class="nav nav-tabs">
                            <li style="width: 33.3%; text-align: center" class="active" id="list_user_1">
                                <a style="margin: 0 auto; padding-left: 0; padding-right: 0;" href="#tab_10_1"
                                   data-toggle="tab" aria-expanded="false"> Leave
                                    <span class="badge badge-empty badge-danger amount_user_lv"> </span>
                                </a>
                            </li>
                            <li style="width: 33.3%; text-align: center" class="" id="list_user_2">
                                <a style="margin: 0 auto; padding-left: 0; padding-right: 0;" href="#tab_10_2"
                                   data-toggle="tab" aria-expanded="false"> Timesheet
                                    <span class="badge badge-empty badge-danger amount_user_ts"> </span>
                                </a>
                            </li>
                            <li style="width: 33.3%; text-align: center" class="" id="list_user_3">
                                <a style="margin: 0 auto; padding-left: 0; padding-right: 0;" href="#tab_10_3"
                                   data-toggle="tab" aria-expanded="true"> Overtime
                                    <span class="badge badge-empty badge-danger amount_user_ot"> </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </form>
                <div class="tab-content" style="padding: 0;">
                    <div class="tab-pane active" id="tab_10_1">
                        <li>
                            <ul id="list_user_lv" class="dropdown-menu-list scroller" style="height: 255px;"
                                data-handle-color="#637283">
                                Ajax
                            </ul>
                        </li>
                    </div>
                    <div class="tab-pane" id="tab_10_2">
                        <li>
                            <ul id="list_user_ts" class="dropdown-menu-list scroller" style="height: 255px;"
                                data-handle-color="#637283">
                                Ajax
                            </ul>
                        </li>
                    </div>
                    <div class="tab-pane" id="tab_10_3">
                        <li>
                            <ul id="list_user_ot" class="dropdown-menu-list scroller" style="height: 255px;"
                                data-handle-color="#637283">
                                Ajax
                            </ul>
                        </li>
                    </div>
                </div>
            </div>
        </div>

        <a id="link_user_all" class="notification-bottom">
            <div class="notification-bottom-content">
                view all
            </div>
        </a>
    </ul>
</li>-->
@if (session('is_approver') != 0)
<li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">
        <i class="icon-envelope-open"></i>
        <span id="total_all" class="badge badge-danger amount"></span>
    </a>
    <ul class="dropdown-menu" style="background: #ffffff;min-width: 300px; width: unset; max-width: unset;">
        <li class="external">
            <h3>You have
                <span id="tot_data" class="bold"> </span> New Messages</h3>
        </li>
        <div class="portlet white" style="margin-bottom: 0;">
            <div class="tabbable-line boxless tabbable-reversed" style="padding-top: 0;">
                <form>
                    <div class="portlet-title tabbable-line" style="padding-top: 0;">
                        <ul class="nav nav-tabs">
                            <li style="width: 33.3%; text-align: center" class="active" id="list1">
                                <a style="margin: 0 auto; padding-left: 0; padding-right: 0;" href="#tab_15_1"
                                   data-toggle="tab" aria-expanded="false"> Leave
                                    <span class="badge badge-empty badge-danger amount_lv"> </span>
                                </a>
                            </li>
                            <li style="width: 33.3%; text-align: center" class="" id="list2">
                                <a style="margin: 0 auto; padding-left: 0; padding-right: 0;" href="#tab_15_2"
                                   data-toggle="tab" aria-expanded="false"> Timesheet
                                    <span class="badge badge-empty badge-danger amount_ts"> </span>
                                </a>
                            </li>
                            <li style="width: 33.3%; text-align: center" class="" id="list3">
                                <a style="margin: 0 auto; padding-left: 0; padding-right: 0;" href="#tab_15_3"
                                   data-toggle="tab" aria-expanded="true"> Overtime
                                    <span class="badge badge-empty badge-danger amount_ot"> </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </form>
                <div class="tab-content" style="padding: 0;">
                    <div class="tab-pane active" id="tab_15_1">
                        <li>
                            <ul id="list_lv" class="dropdown-menu-list scroller" style="height: 255px;"
                                data-handle-color="#637283">
                                <!--Ajax-->
                            </ul>
                        </li>
                    </div>
                    <div class="tab-pane" id="tab_15_2">
                        <li>
                            <ul id="list_ts" class="dropdown-menu-list scroller" style="height: 255px;"
                                data-handle-color="#637283">
                                <!--Ajax-->
                            </ul>
                        </li>
                    </div>
                    <div class="tab-pane" id="tab_15_3">
                        <li>
                            <ul id="list_ot" class="dropdown-menu-list scroller" style="height: 255px;"
                                data-handle-color="#637283">
                                <!--Ajax-->
                            </ul>
                        </li>
                    </div>
                </div>
            </div>
        </div>
        <div id="link_all">
            <!--ajax -->
        </div>
    </ul>
</li>
@endif