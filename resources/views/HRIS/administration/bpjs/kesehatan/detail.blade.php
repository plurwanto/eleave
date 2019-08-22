
<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<div class="modal-body" style="padding-bottom: 0;">
    <div class="portlet box" style="background-color: #444d58; margin-bottom: 0px">
        <div class="portlet-body" style="padding: 8px 15px;">
            <div class="row">
                <div style="padding: 0px 30px;" class="col-md-6">
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Name</label>
                            <div>{{ $hasil->result->mem_name }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">NIP</label>
                            <div>{{ $hasil->result->mem_nip }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Contract Number</label>
                            <div>{{ $hasil->result->cont_no_new }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Customer</label>
                            <div>{{ $hasil->result->cus_name }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Start Date</label>
                            <div>{{ $hasil->result->cont_start_date }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">End Date</label>
                            <div>{{ $hasil->result->cont_end_date }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Resign Date</label>
                            <div>{{ $hasil->result->cont_resign_date }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">BPJS Kesehatan No</label>
                            <div>{{ $hasil->result->bpjs_kes_number }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Period</label>
                            <div>{{ $hasil->result->period }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Amount</label>
                            <div>{{ $hasil->result->total }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Additional Amount</label>
                            <div>{{ $hasil->result->additional_total }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Created by</label>
                            <div>{{ $hasil->result->nama }}</div>
                        </div>
                    </div>
                    <div class="form-group form-margin-0">
                        <div>
                            <label style="font-weight: bold;">Created at</label>
                            <div>{{ $hasil->result->created_date }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal-footer">
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
    </div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'components-select2.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'form-validation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
