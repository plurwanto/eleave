<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="employeeTimesheetBox">
    <div class="portlet light employeeTimesheetBoxInner">
        <div class="portlet-body">
            <div class="row">
            @include('Eleave.dashboard.employeeTimesheetChart')
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 table-section" style="display: none;">
                    <div class="mb-10">
                        <div class="chart-title">
                            <span id="title-text">Approved Employee Timesheet Summary</span>
                            <div class="pull-right closeTable" id="employeeTimesheet">
                                <div class="font-red text-right"><i class="fa fa-close"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-condensed" id="employeeTimesheetTable" width="100%">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
