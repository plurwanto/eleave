<div class="portlet box periodBox">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12" style="margin-bottom: 0">
                <div class="pull-left">
                    <label class="form-control" style="border: unset;padding: 6px 0;" for="period">Period</label>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3" style="margin-bottom: 0">
                    <div class="form-group input-group">
                        <input type="text" autocomplete="off" class="form-control" placeholder="Choose Date" id="period"
                            name="period" />
                        <span class="input-group-addon period-date-icon">
                            <i class="fa fa-calendar-check-o font-dark"></i>
                        </span>
                    </div>
                </div>
            </div>
            @if(session('is_hr') > 0)
                @include('Eleave.dashboard.divisionPunctuality')
            @endif
            
            @include('Eleave.dashboard.employeePunctuality')
            @include('Eleave.dashboard.employeeLeave')
            @include('Eleave.dashboard.employeeTimesheet')
            @include('Eleave.dashboard.employeeOvertime')
            <div style="clear: both"></div>
        </div>
    </div>
</div>
