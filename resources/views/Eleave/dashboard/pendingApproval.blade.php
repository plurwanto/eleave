<div id="pendingApprovalBox">
    <div class="portlet light pendingApprovalBoxInner">
        <div class="portlet-body">
            <div class="row">
                @include('Eleave.dashboard.pendingApprovalChart')
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 table-section">
                    <div class="mb-10">
                        <div class="chart-title">
                            <span id="title-text">Leave</span>
                        </div>
                    </div>
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-condensed pendingApprovalTable" id="pendingApprovalleave"
                            width="100%">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                        <table class="table table-condensed pendingApprovalTable hidden" id="pendingApprovaltimesheet"
                            width="100%">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                        <table class="table table-condensed pendingApprovalTable hidden" id="pendingApprovalovertime"
                            width="100%">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- S:Modal Pending Approval Leave Detail -->
<div id="pendingApprovalDetail" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Information</h4>
            </div>
            <div class="modal-body">
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="user-left">
                                    <div class="dataTables_wrapper no-footer">
                                        <table class="table table-condensed pendingApprovalDetailTable"
                                            id="pendingApprovalLeaveDetail" width="100%">
                                            <thead></thead>
                                            <tbody></tbody>
                                        </table>
                                        <table class="table table-condensed pendingApprovalDetailTable hidden"
                                            id="pendingApprovalTimesheetDetail" width="100%">
                                            <thead></thead>
                                            <tbody></tbody>
                                        </table>
                                        <table class="table table-condensed pendingApprovalDetailTable hidden"
                                            id="pendingApprovalOvertimeDetail" width="100%">
                                            <thead></thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn-close" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- E:Modal Pending Approval Leave Detail -->

<!-- S:Modal Pending Approval Leave Approve -->
<div class="modal fade" id="approve" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Confirm Approval <span id="title"></span></h3>
            </div>
            <div class="modal-body">
                <p>Are you sure want to approve the <span id="actions"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn-close" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Close
                </button>
                <button type="button" class="btn btn-info btn-approve">
                    <i class="fa fa-check"></i>
                    Approve
                </button>
            </div>
        </div>
    </div>
</div>
<!-- E:Modal Pending Approval Leave Approve -->

<!-- S:Modal Pending Approval Leave Reject -->
<div class="modal fade" id="reject" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Confirm Reject <span id="title"></span></h3>
            </div>
            <div class="modal-body">
                <p>Are you sure want to reject the <span id="actions"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn-close" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Close
                </button>
                <button type="button" class="btn btn-warning btn-reject">
                    <i class="fa fa-times-circle"></i>
                    Reject
                </button>
            </div>
        </div>
    </div>
</div>
<!-- E:Modal Pending Approval Leave Reject -->

<!-- S:Modal Pending Approval Leave Revision -->
<div class="modal fade" id="revise" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Confirm Revision <span id="title"></span></h3>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top: 20px;">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label" for="revision_reason">Revise Reason</label>
                            <textarea class="form-control" rows="3" placeholder="Enter reason" id="revision_reason"
                                name="revision_reason" maxlength="255"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn-close" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                    Close
                </button>
                <button type="button" class="btn btn-success btn-revise">
                    <i class="fa fa-save"></i>
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
<!-- E:Modal Pending Approval Leave Revision -->