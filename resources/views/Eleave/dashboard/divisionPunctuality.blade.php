<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="divisionBox">
    <div class="portlet light divisionBoxInner">
        <div class="portlet-body">
            <div class="row">
                @include('Eleave.dashboard.divisionPunctualityChart')
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 table-section" style="display: none;">
                    <div class="mb-10">
                        <div class="chart-title">
                            <span id="title-text"></span>
                            <div class="pull-right closeTable" id="division">
                                <div class="font-red text-right"><i class="fa fa-close"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-condensed" id="divisionTable" width="100%">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>