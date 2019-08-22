<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="employeeLeaveBox">
    <div class="portlet light employeeLeaveBoxInner">
        <div class="portlet-body">
            <div class="row">
            @include('Eleave.dashboard.employeeLeaveChart')
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 table-section" style="display: none;">
                    <div class="mb-10">
                        <div class="chart-title">
                            <span id="title-text"></span>
                            <div class="pull-right closeTable" id="employeeLeave">
                                <div class="font-red text-right"><i class="fa fa-close"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-condensed" id="employeeLeaveTable" width="100%">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
