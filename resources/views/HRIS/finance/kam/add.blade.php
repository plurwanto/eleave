<div class="modal-header portlet box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-pencil-square-o"></i>{{$title}}</div>
        <div class="tools">
            <a href="#" data-dismiss="modal" class="remove"> </a>
        </div>
    </div>
</div>
<form id="formInput"  class="form form-horizontal">

    <div class="modal-body">
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="portlet-body form">
                    <div class="col-md-12 ">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Year <font color="red">*</font></label>
                                <div class="col-md-6">
                                    <select style="width:190px; margin-right:10px" class="form-control border-rounded pull-left"  name="year_add" id="year_add" class="form-control"  onchange="getRevenue()">
                                        @php
                                            $now = date('Y');
                                            for($i=2014; $i <= $now; $i++){
                                                if($i == $now){
                                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                                }else{
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                            @if(in_array(1,explode(",", $profile->profile->div_id)))
                                <div class="form-group">
                                    <label class="col-md-4 control-label">User <font color="red">*</font></label>
                                    <div class="col-md-6">
                                       <select class="form-control select2" name="user_id" data-placeholder="-- Choose a KAM --" id="user_id">
                                            <option value="">-- Choose a KAM --</option>
                                            @for($i = 0; $i < count($kam->result); $i++)
                                            <option value="{{$kam->result[$i]->user_id}}">{{$kam->result[$i]->nama}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                @else
                                <input type="hidden" name="user_id" id="user_id" value="{{$id}}">
                            @endif
                            <div class="form-group">
                                <label class="col-md-4 control-label">type <font color="red">*</font></label>
                                <div class="col-md-6">
                                    <select name="type" id="type"  onchange="getRevenue()" class="search-input-select form-control input-sm">
                                        <option value="">-- Choose a type --</option>
                                        <option value="FULL">FULL</option>
                                        <option value="MF">MF</option>
                                    </select>
                                </div>
                            </div>
                            <div id="revenue_area">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END PAGE CONTENT INNER -->
    </div>
    <div class="modal-footer">
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="submit" class="btn green" id="btnSubmit">Save changes</button>
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
                    user_id: {
                        required: true
                    },
                    year_add: {
                        required: true
                    },
                    type: {
                        required: true
                    },
                    currency: {
                        required: true
                    },
                    revenue_kpi: {
                        required: true
                    },
                    remark: {
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
        $(document).on("submit", "#formInput", function (event)
        {
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
                type: "POST",
                async: true,
                dataType: "json",
                enctype: 'multipart/form-data',
                url: "{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue/doadd') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {
                    $('.loading').hide();
                    if (data.response_code == '200') {
                        $('#modalAction').modal('hide');
                                toastr . success('Action successfully');
                                setTimeout(function () {
                                    location . reload();
                                }, 1000);
                    } else {
                        $('#modalAction').modal('hide');
                        toastr.error("Failed", "Your action is failed :)",{timeOut: 2000});
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

        function getRevenue(){
        var year = $("#year_add").val();
        var type = $("#type").val();
        var user_id = $("#user_id").val();
        if (year != '' && type != '') {

            $("#revenue_area").html(`<div style="text-align: center"><h4><i class="fa fa-chevron-right-o-notch fa-spin fa-1x fa-fw"></i>
                <span>Loading...</span></h4>
            </div>`);

            $.get("{{ URL::asset(env('APP_URL').'/hris/finance/kam-revenue/get-revenue') }}",
                    {
                        year: year,
                        type: type,
                        user_id: user_id

                    },
                    function (data) {
                        $("#revenue_area").html(data);
                    });
        } else {
            $("#revenue_area").html('');
        }
    }

    function formatRupiah(e){
        var angka = e.value;
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        e.value = rupiah
    }
</script>
