
<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInput" class="form form-horizontal">

    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Customer</label>
                    <div class="col-md-7">
                        <select name='cus_id' id='cus_id_filt' class="form-control input-sm select2-multiple" style="border-radius: 6px !important;">
                            <option value="0">ALL</option>
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
                    <label class="col-md-3 control-label">Period <font color="red">*</font></label>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="periodFilt" id="periodFilt" value="{{$period}}">
                    </div>
                    <div class="col-md-1">
                     <strong> s/d</strong>
                     </div>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="periodFilt2" id="periodFilt2" value="{{$period2}}">
                    </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
    <input name="link" id="link" type="hidden" value="{{$link}}">
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="submit" class="btn green" id="btnSubmit"><i class="fa fa-file-excel-o"></i> Download</button>
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

            $("#periodFilt").datepicker( {
                    format: "mm/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true

                });




            $('#formInput').validate({
                rules: {
                    cus_id : {
                        required: true
                    },
                    periodFilt : {
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

 //submit Detail Contract
    //submit Detail Contact

    $(document).on("submit", "#formInput", function (event)
        {
            var period = document.getElementById("periodFilt").value;
            var period2 = document.getElementById("periodFilt2").value;
            var cus_id = $('#cus_id_filt').val();
            var links = $('#links').val();

            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInput')[0];
            // Create an FormData object
            var data = new FormData(form);
            // If you want to add an extra field for the FormData
            data.append("CustomField", "This is some extra data, testing");
            // disabled the submit button
            $("#btnSubmit").prop("disabled", true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
            $.ajax({
                type: "GET",
                async: true,
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'/hris/administration/travel/do-excel') }}",
                data:"cus_id="+cus_id+"&period="+period+"&period2="+period2+"&link="+link,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                        $('#modalAction').modal('hide');
                        toastr.success('download successfully');
                        location.href = data.path;

                    } else {
                        $('#modalAction').modal('hide');
                        toastr.error('download failed');

                    }
                },
                error: function (e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
            event.stopImmediatePropagation();
            return false;
        });


    $(function() {
        $( "#date-picker" ).datepicker();
    });
</script>
