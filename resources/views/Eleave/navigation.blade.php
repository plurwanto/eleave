@php
define('ADD', 'add');
define('EDIT', 'edit');
define('REMOVE', 'remove');
define('VIEW', 'view');

define('HOME', 'HOME');
define('DASHBOARD', 'DASHBOARD');
define('EMPLOYEE', 'EMPLOYEE');
define('HR_DATA', 'HR_DATA');
define('EMPLOYEE_DATA', 'EMPLOYEE_DATA');
define('EMPLOYEE_REQUEST', 'EMPLOYEE_REQUEST');

define('ATTENDANCE', 'ATTENDANCE');
define('ATTENDANCE_EMPLOYEE', 'ATTENDANCE_EMPLOYEE');
define('ATTENDANCE_DATA', 'ATTENDANCE_DATA');

define('TIME_MANAGEMENT', 'TIME_MANAGEMENT');
define('TIMESHEET', 'TIMESHEET');
define('LEAVE', 'LEAVE');
define('OVERTIME', 'OVERTIME');

define('STATIONERY', 'STATIONERY');
define('STATIONERY_LIST', 'STATIONERY_LIST');
define('STATIONERY_GA', 'STATIONERY_GA');
define('STATIONERY_REPORT', 'STATIONERY_REPORT');
define('STATIONERY_PROCUREMENT', 'STATIONERY_PROCUREMENT');

define('ROOM_BOOKING', 'ROOM_BOOKING');
define('ALL_ROOM_BOOKING', 'ALL_ROOM_BOOKING');
define('MY_ROOM_BOOKING_HISTORY', 'MY_ROOM_BOOKING_HISTORY');
define('BOOK_MEETING_ROOM', 'BOOK_MEETING_ROOM');

define('APPROVAL', 'APPROVAL');
define('TIMESHEET_APPROVAL', 'TIMESHEET_APPROVAL');
define('LEAVE_APPROVAL', 'LEAVE_APPROVAL');
define('OVERTIME_APPROVAL', 'OVERTIME_APPROVAL');
define('CASH_ADVANCE_APPROVAL', 'CASH_ADVANCE_APPROVAL');
define('CLAIM_APPROVAL', 'CLAIM_APPROVAL');

define('TEAM', 'TEAM');

define('SUPPORT', 'SUPPORT');
define('ALL_TICKETING', 'ALL_TICKETING');
define('ADD_TICKETING', 'ADD_TICKETING');
define('REPORT_TICKETING', 'REPORT_TICKETING');

define('CONFIG', 'CONFIG');
define('SETTING', 'SETTING');
define('ACCESS_PERMISSION', 'ACCESS_PERMISSION');

define('MASTER', 'MASTER');
define('DEPARTMENT', 'DEPARTMENT');
define('ROOM', 'ROOM');
define('INVENTORY', 'INVENTORY');
define('HOLIDAY_LIST', 'HOLIDAY_LIST');
define('POLICY', 'POLICY');

define('EXPENSES', 'EXPENSES');
define('CASH_ADVANCE', 'CASH_ADVANCE');
define('CLAIM', 'CLAIM');

@endphp
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        @if (ElaHelper::privilege_check(HOME, 'view'))
            <li class="nav-item @if (!Request::segment(2)) active @endif">
                <a href="{{URL::to('/eleave')}}">
                    <i class="fa fa-home"></i>
                    <span class="title">Home</span>
                </a>
            </li>
        @endif
        @if (ElaHelper::privilege_check_approver(DASHBOARD, 'view'))
            <li class="nav-item @if (Request::segment(2) == 'dashboard') active @endif">
                <a href="{{URL::to('/eleave/dashboard')}}">
                    <i class="fa icon-bar-chart"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
        @endif
        @if (ElaHelper::privilege_check(EMPLOYEE, 'view'))   
            <li class="nav-item  @if (Request::segment(2) == 'user' && (Request::segment(3) == 'index' || Request::segment(3) == 'staff-request')) active open @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-user"></i>
                    <span class="title">Employee</span>
                    <span class="arrow"></span>

                    @if(session('dept_id') == 12)
                        <span class="badge badge-danger nav-request-badge hidden">3</span>
                    @endif                    
                </a>
                <ul class="sub-menu">
                    @if (ElaHelper::privilege_check(HR_DATA, 'view'))
                        <li class="nav-item  @if (Request::segment(2) == "user" && Request::segment(3) == "index" || Request::segment(2) == 'staff-request') active @endif">
                            <a href="{{URL::to('eleave/user/index')}}" class="nav-link ">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">HR Data</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(EMPLOYEE_DATA, 'view'))
                        <li class="nav-item  @if (Request::segment(2) == "user" && Request::segment(3) == "index" || Request::segment(2) == 'staff-request') active @endif">
                            <a href="{{URL::to('eleave/user/index')}}" class="nav-link ">
                                <i class="fa fa-list"></i>
                                <span class="title">Employee Data</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(EMPLOYEE_REQUEST, 'view'))
                        @php /*
                        <li class="nav-item  @if (Request::segment(2) == "user" && Request::segment(3) == "index" || Request::segment(2) == 'staff-request') active @endif">
                            <a href="{{URL::to('eleave/user/index')}}" class="nav-link ">
                                <i class="fa fa-list"></i>
                                <span class="title">Employee Request</span>
                                @if(session('dept_id') == 12)
                                    <span class="badge badge-danger nav-request-badge hidden">3</span>
                                @endif
                            </a>
                        </li>
                        */ @endphp
                    @endif
                </ul>
            </li>
        @endif   
        @if (ElaHelper::privilege_check(ATTENDANCE, 'view'))    
            <li class="nav-item  @if (Request::segment(2) == "attendance") active @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-calendar-check-o"></i>
                    <span class="title">Attendance</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if (ElaHelper::privilege_check(ATTENDANCE_EMPLOYEE, 'view'))
                        <li class="nav-item  @if (Request::segment(2) == "attendance" && Request::segment(3) == "employee") active @endif">
                            <a href="{{URL::to('eleave/attendance/employee')}}" class="nav-link ">
                                <i class="fa fa-list"></i>
                                <span class="title">Attendance List</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(ATTENDANCE_DATA, 'view'))
                        <li class="nav-item  @if (Request::segment(2) == "attendance" || Request::segment(3) == "index") active @endif">
                            <a href="{{URL::to('eleave/attendance')}}" class="nav-link ">
                                <i class="fa fa-list"></i>
                                <span class="title">Attendance Data</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (ElaHelper::privilege_check(TIME_MANAGEMENT, 'view')) 
            <li class="nav-item @if (Request::segment(2) == "timesheet" || Request::segment(2) == "leave" || Request::segment(2) == "overtime") active open @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-clock-o"></i>
                    <span class="title">Time Management</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if (ElaHelper::privilege_check(TIMESHEET, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "timesheet" && (Request::segment(3) == "index" || Request::segment(3) == "add")) active @endif">
                            <a href="{{URL::to('eleave/timesheet/index')}}" class="nav-link ">
                                <i class="fa fa-list"></i>
                                <span class="title">Timesheet</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(LEAVE, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "leave" && (Request::segment(3) == "index" || Request::segment(3) == "add")) active @endif">
                            <a href="{{URL::to('eleave/leave/index')}}" class="nav-link ">
                                <i class="fa fa-calendar-times-o"></i>
                                <span class="title">Leave</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(OVERTIME, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "overtime" && (Request::segment(3) == "index" || Request::segment(3) == "add")) active @endif">
                            <a href="{{URL::to('eleave/overtime/index')}}" class="nav-link ">
                                <i class="fa fa-clock-o"></i>
                                <span class="title">Overtime</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if (Session::get('branch_id') == 2)     
            @if (ElaHelper::privilege_check(STATIONERY, 'view')) 
                <li class="nav-item  @if (Request::segment(2) == "inventory" || Request::segment(2) == "inventory_report" || Request::segment(2) == "inventory_procurement") active open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-cart-plus"></i>
                        <span class="title">Stationery</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        @if (ElaHelper::privilege_check(STATIONERY_LIST, 'view')) 
                            <li class="nav-item  @if (Request::segment(2) == "inventory" && Request::segment(3) == "index") active @endif">
                                <a href="{{URL::to('eleave/inventory/index')}}" class="nav-link ">
                                    <i class="fa fa-list"></i>
                                    <span class="title">My Stationery List</span>
                                </a>
                            </li>
                        @endif
                        @if (ElaHelper::privilege_check(STATIONERY_GA, 'view')) 
                            <li class="nav-item  @if (Request::segment(2) == "inventory" && Request::segment(3) == "all_request") active @endif">
                                <a href="{{URL::to('eleave/inventory/all_request')}}" class="nav-link ">
                                    <i class="fa fa-list"></i>
                                    <span class="title">All Stationery Request</span>
                                </a>
                            </li>
                        @endif
                        @if (ElaHelper::privilege_check(STATIONERY_REPORT, 'view')) 
                            <li class="nav-item  @if (Request::segment(2) == "inventory_report" && Request::segment(3) == "index") active @endif">
                                <a href="{{URL::to('eleave/inventory_report/index')}}" class="nav-link ">
                                    <i class="fa fa-list-alt"></i>
                                    <span class="title">Stationery Report</span>
                                </a>
                            </li>
                        @endif
                        @if (ElaHelper::privilege_check(STATIONERY_PROCUREMENT, 'view')) 
                            <li class="nav-item  @if (Request::segment(2) == "inventory_procurement" && Request::segment(3) == "index") active @endif">
                                <a href="{{URL::to('eleave/inventory_procurement/index')}}" class="nav-link ">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="title">Stationery Procurement</span>
                                </a>
                            </li>
                        @endif  
                    </ul>
                </li>
            @endif

            @if (ElaHelper::privilege_check(ROOM_BOOKING, 'view')) 
                <li class="nav-item @if (Request::segment(1) == 'room-booking') active @endif">
                    <a href="{{URL::to('eleave/room-booking')}}" class="nav-link ">
                        <i class="fa fa-sign-in"></i>
                        <span class="title">Room Booking</span>
                    </a>
                </li>
            @endif
        @endif      

        @if (ElaHelper::privilege_check_approver(APPROVAL, 'view')) 
            <li class="nav-item  @if (Request::segment(2) == "timesheetApproval" || Request::segment(2) == "leaveApproval" || Request::segment(2) == "overtimeApproval" || Request::segment(2) == "cash_advanceApproval" || Request::segment(2) == "claimApproval") active open @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-calendar-check-o"></i>
                    <span class="title">Approval</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if (ElaHelper::privilege_check_approver(TIMESHEET_APPROVAL, 'view')) 
                        <!-- Approver Timesheet Menu -->
                        <li class="nav-item  @if (Request::segment(2) == "timesheetApproval" && Request::segment(3) == "index") active @endif">
                            <a href="{{URL::to('eleave/timesheetApproval/index')}}" class="nav-link ">
                                <i class="fa fa-paste"></i>
                                <span class="title">Timesheet Approval</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check_approver(LEAVE_APPROVAL, 'view')) 
                        <!-- Approver Timesheet Menu -->
                        <li class="nav-item  @if (Request::segment(2) == "leaveApproval") active @endif">
                            <a href="{{URL::to('eleave/leaveApproval/index')}}" class="nav-link ">
                                <i class="fa fa-calendar-check-o"></i>
                                <span class="title">Leave Approval</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check_approver(OVERTIME_APPROVAL, 'view')) 
                        <!-- Approver Overtime Menu -->
                        <li class="nav-item  @if (Request::segment(2) == "overtimeApproval" && Request::segment(3) == "index") active @endif">
                            <a href="{{URL::to('eleave/overtimeApproval/index')}}" class="nav-link ">
                                <i class="fa fa-clock-o"></i>
                                <span class="title">Overtime Approval</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check_approver(CASH_ADVANCE_APPROVAL, 'view')) 
                        @if (session('id') == 545 || session('id') == 62 || session('id') == 64 )
                        <li class="nav-item  @if (Request::segment(2) == "cash_advanceApproval" && (Request::segment(3) == "all_request" || Request::segment(3) == "realization")) active @endif">
                            <a href="{{URL::to('eleave/cash_advanceApproval/all_request')}}" class="nav-link ">
                                <i class="fa fa-dollar"></i>
                                <span class="title">Cash Advance</span>
                            </a>
                        </li>
                        @else   
                        <li class="nav-item  @if (Request::segment(2) == "cash_advanceApproval") active @endif">
                            <a href="{{URL::to('eleave/cash_advanceApproval?index=1')}}" class="nav-link ">
                                <i class="fa fa-dollar"></i>
                                <span class="title">Cash Advance Approval</span>
                            </a>
                        </li>
                         @endif
                    @endif
                    @if (ElaHelper::privilege_check_approver(CLAIM_APPROVAL, 'view')) 
                        @if (session('id') == 545 || session('id') == 62 || session('id') == 64 )
                        <li class="nav-item  @if (Request::segment(2) == "claimApproval" && Request::segment(3) == "all_request") active @endif">
                            <a href="{{URL::to('eleave/claimApproval/all_request')}}" class="nav-link ">
                                <i class="fa fa-dollar"></i>
                                <span class="title">Claim</span>
                            </a>
                        </li>
                        @else   
                        <li class="nav-item  @if (Request::segment(2) == "claimApproval" && Request::segment(3) == "index") active @endif">
                            <a href="{{URL::to('eleave/claimApproval/index')}}" class="nav-link ">
                                <i class="fa fa-dollar"></i>
                                <span class="title">Claim Approval</span>
                            </a>
                        </li>
                         @endif
                    @endif
                </ul>
            </li>
        @endif  
        @if (ElaHelper::privilege_check_approver(TEAM, 'view')) 
            <li class="nav-item  @if (Request::segment(2) == "user" && (Request::segment(3) == "team" || Request::segment(3) == "team_attendance")) active @endif">
                <a href="{{URL::to('eleave/user/team')}}" class="nav-link ">
                    <i class="fa fa-users"></i>
                    <span class="title">Team</span>
                </a>
            </li>
        @endif 
        @if (ElaHelper::privilege_check(SUPPORT, 'view'))         
            <li class="nav-item @if (Request::segment(2) == "ticketing" || Request::segment(2) == "ticketing_report") active open @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-headphones"></i>
                    <span class="title">Support</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if (ElaHelper::privilege_check(ALL_TICKETING, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "ticketing" && !Request::segment(3)) active @endif">
                            <a href="{{URL::to('eleave/ticketing')}}" class="nav-link ">
                                <i class="fa fa-calendar"></i>
                                <span class="title">Ticketing</span>
                            </a>
                        </li>
                    @endif
                    
                    @if (ElaHelper::privilege_check(REPORT_TICKETING, 'view'))
                        <li class="nav-item  @if (Request::segment(2) == "ticketing" && Request::segment(3) == "report") active @endif">
                            <a href="{{URL::to('eleave/ticketing/report')}}" class="nav-link ">
                                <i class="fa fa-list-alt"></i>
                                <span class="title">Report Ticketing</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif 

        @if (ElaHelper::privilege_check(CONFIG, 'view'))         
            <li class="nav-item  @if (Request::segment(2) == "userlevel" || Request::segment(2) == "setting" || Request::segment(2) == "privilege" || Request::segment(3) == 3) active open @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">Config</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if (ElaHelper::privilege_check(SETTING, 'view')) 
                        <li class="nav-item @if (Request::segment(2) == "setting") active @endif">
                            <a href="{{URL::to('eleave/setting/index')}}" class="nav-link ">
                                <i class="fa fa-sliders"></i>
                                <span class="title">Setting</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(ACCESS_PERMISSION, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "userlevel" && (Request::segment(3) == "index" || Request::segment(1) == "privilege" || Request::segment(2) == "show_user" || Request::segment(3) != NULL)) active @endif">
                            <a href="{{URL::to('eleave/userlevel/index')}}" class="nav-link ">
                                <i class="fa fa-lock"></i>
                                <span class="title">Access Permission</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif 

        @if (ElaHelper::privilege_check(MASTER, 'view'))         
            <li class="nav-item  @if (Request::segment(2) == "department" || Request::segment(2) == "room" || Request::segment(2) == "inventory_master" || Request::segment(2) == "holiday" || Request::segment(2) == "policy") active open @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title">Master</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if (ElaHelper::privilege_check(DEPARTMENT, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "department" && Request::segment(3) == "index") active @endif">
                            <a href="{{URL::to('eleave/department/index')}}" class="nav-link ">
                                <i class="fa fa-bank"></i>
                                <span class="title">Department</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(ROOM, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "room" && Request::segment(3) == "index") active @endif">
                            <a href="{{URL::to('eleave/room/index')}}" class="nav-link ">
                                <i class="fa fa-building"></i>
                                <span class="title">Room</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(INVENTORY, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "inventory_master" && Request::segment(3) == "unit") active @endif">
                            <a href="{{URL::to('eleave/inventory_master/unit')}}" class="nav-link ">
                                <i class="fa fa-cart-plus"></i>
                                <span class="title">Stationery</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(HOLIDAY_LIST, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "holiday" && Request::segment(3) == "index") active @endif">
                            <a href="{{URL::to('eleave/holiday/index')}}" class="nav-link ">
                                <i class="fa fa-plane"></i>
                                <span class="title">Holiday</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(POLICY, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "policy" && Request::segment(3) == "index") active @endif">
                            <a href="{{URL::to('eleave/policy/index')}}" class="nav-link ">
                                <i class="fa fa-legal"></i>
                                <span class="title">Policy</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif     
        @if (ElaHelper::privilege_check(EXPENSES, 'view')) 
            <li class="nav-item @if (Request::segment(2) == "cash_advance" || Request::segment(2) == "claim")) active open @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-dollar"></i>
                    <span class="title">Expenses</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-sm label-danger">new</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if (ElaHelper::privilege_check(CASH_ADVANCE, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "cash_advance" && (Request::segment(2) == "cash_advance" || Request::segment(3) == "add")) active @endif">
                            <a href="{{URL::to('eleave/cash_advance?index=1')}}" class="nav-link ">
                                <i class="fa fa-list"></i>
                                <span class="title">Cash Advance</span>
                            </a>
                        </li>
                    @endif
                    @if (ElaHelper::privilege_check(CLAIM, 'view')) 
                        <li class="nav-item  @if (Request::segment(2) == "claim" && (Request::segment(3) == "index" || Request::segment(3) == "add")) active @endif">
                            <a href="{{URL::to('eleave/claim/index')}}" class="nav-link ">
                                <i class="fa fa-download"></i>
                                <span class="title">Claim</span>
                                <span id="cl_notif" class="badge badge-danger nav-claim-badge"> </span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
