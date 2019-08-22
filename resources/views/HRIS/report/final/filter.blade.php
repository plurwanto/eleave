
<div class="modal-header">
        @php
            if($period !=0){
                echo '<a href="'. URL::asset(env('APP_URL').'hris/report/final').'?period='. $period .'" type="button" class="close"></a>';
            }else{
                echo '<a href="'. URL::asset(env('APP_URL').'hris/report/final') .'" type="button" class="close"></a>';
            }
        @endphp
    <h4 class="modal-title">{{$title}}</h4>
</div>
<form id="formInput" action="{{ URL::asset(env('APP_URL').'hris/report/final') }}" method="get"  class="form form-horizontal">

    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-body">
                            <div class="row">
                            <div class="form-group">
                                        <label class="col-md-3 control-label">Customer <font color="red">*</font></label>
                                        <div class="col-md-8">
                                            <select name="cus_id" id="customer" class="search-input-select form-control input-sm select2">
                                                <option value='0'>ALL</option>
                                                @for($i = 0; $i < count($customer); $i++)
                                                    @if($customer[$i]->cus_id == $cus_id)
                                                        <option value="{{$customer[$i]->cus_id}}" selected>{{$customer[$i]->cus_name}}</option>
                                                    @else
                                                        <option value="{{$customer[$i]->cus_id}}">{{$customer[$i]->cus_name}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Date <font color="red">*</font></label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="month">
                                                @php
                                                $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                $month_num = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                                                for ($i = 0; $i < count($month); $i++) {
                                                    if ($month_num[$i] == substr($period,4,6)) {
                                                        echo '<option value="' . $month_num[$i] . '" selected>' . $month[$i] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $month_num[$i] . '">' . $month[$i] . '</option>';
                                                    }
                                                }
                                                @endphp
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="number" name="year" value="{{substr($period,0,4)}}">
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
        @php
            if($cus_id !=0){
                echo '<a href="'. URL::asset(env('APP_URL').'hris/report/final').'?cus_id='. $cus_id .'&month='. substr($period,4,6) .'&year='. substr($period,0,4) .'" type="button" class="btn dark btn-outline">Close</a>';
            }else{
                echo '<a href="'. URL::asset(env('APP_URL').'hris/report/final') .'" type="button" class="btn dark btn-outline">Close</a>';
            }
        @endphp
        <button type="submit" class="btn green" id="btnSubmit">Filter</button>
    </div>
</form>

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

<script type="text/javascript">
        $(document).ready(function () {
            $('#formInput').validate({
                rules: {
                    cus_id : {
                        required: true
                    },
                    month : {
                        required: true
                    },
                    year: {
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });



    $(function() {
        $( "#date-picker" ).datepicker();
    });
</script>
