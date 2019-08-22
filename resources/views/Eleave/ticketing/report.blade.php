@extends('Eleave.layout.main')

@section('title','Eleave | Ticketing Report')

@section('style')
<!-- multiple-select.css -->
<link type="text/css" rel="stylesheet" href="{{ URL::asset(env('PUBLIC_PATH').'css/buttons.dataTables.min.css') }}"></link>

<style type="text/css">
    .my-divider {
        margin-bottom: 20px;
    }
    .dataTables_empty {
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-ticket"></i>Ticketing Report
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group form-md-line-input has-success">
                        <label class="control-label" for="year">Year</label>
                        <select class="form-control" name="year" id="year">
                            @php $currentYear = (int) date('Y'); @endphp

                            @for ($i = 2015; $i <= $currentYear; $i++)
                                @php 
                                    $selected = ($i == $currentYear) ? 'selected="selected"' : ''; 
                                @endphp
                                <option value="{{ $i }}" {{ $selected }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group form-md-line-input has-success">
                        <label class="control-label" for="month">Month</label>
                        <select class="form-control" name="month" id="month">
                            @for ($i = 1; $i < 13; $i++)
                                @php
                                    $show_month = ElaHelper::month($i, 'name');
                                    $mm = ($i <= 9 ? "0" . $i : $i);
                                    $selected = (date('m') == $i) ? 'selected="selected"' : '';
                                @endphp
                                
                                <option value="{{ $mm }}" {{ $selected }}>{{ $show_month }}</option>
                            @endfor
                        </select>
                        <input type="hidden" id="monthNum">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group form-md-line-input">
                        <label></label>
                        <button class="btn btn-success btn-block" id="btn-search">Search</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group form-md-line-input">
                        <label></label>
                        <button id="export-btn" name="export-btn" class="btn btn green-meadow btn-block">Export</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-divider"></div>
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <table class="table table-condensed" id="report" width="100%">
                <thead>
                    <tr>
                        <td colspan="3" id="tableReportInfo"></td>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Requester</th>
                        <th>Department</th>
                        <th>Application</th>
                        <th>Developer</th>
                        <th>Status</th>
                        <th>Request Date</th>
                        <th>Finish Date</th>
                        <th>Ticket ID</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- config.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
    };
</script>
<!-- ticketing.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/Eleave/ticketing-report.js?v='.date('YmdHis')) }}"></script>
@endsection