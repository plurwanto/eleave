
<div class="modal-header">
<button class="close" data-dismiss="modal"></button>
    <h4 class="modal-title">{{$title}}</h4>
</div>
<form id="formInputEdit"  class="form form-horizontal">
    <div class="modal-body" style="padding-bottom: 0;">
    <table>
        <tr>
            <td><label style="font-weight: bold;">Type</label></td>
            <td style="width:20px;text-align:center">:</td>
            <td>{{ $history->type }}</td>
        </tr>
        <tr>
            <td><label style="font-weight: bold;">Number Contract</label></td>
            <td style="width:20px;text-align:center">:</td>
            <td>{{ $history->no_contract }}</td>
        </tr>
        <tr>
            <td><label style="font-weight: bold;">Updated by</label></td>
            <td style="width:20px;text-align:center">:</td>
            <td>{{ $history->nama }}</td>
        </tr>
        <tr>
            <td><label style="font-weight: bold;">Updated date</label></td>
            <td style="width:20px;text-align:center">:</td>
            <td>{{ $history->updated_date }}</td>
        </tr>
    </table>
    <br>
        <div class="portlet box" style="background-color: #444d58; margin-bottom: 0px">






            <div class="portlet-title">
                <div class="caption"><i class="icon-user" style="color: #fff !important"></i>
                    Contract Information
                </div>
            </div>
            <div class="portlet-body" style="padding: 8px 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div style="padding: 0px 30px;" class="col-md-4">
                            <div class="form-group form-margin-0">
                                <div>
                                    <label style="font-weight: bold;">Contract No</label>

                                    @php
                                    if( $contract->let_no_out !=''){
                                            $let = '<br>
                                            <span style="font-size:11px;text-align:right;color:blue">(Letter Number: '. $contract->let_no_out .')</span>';
                                        }else{
                                            $let = '';
                                        }


                                        $contractNo = $contract->cont_no_new !=''? $contract->cont_no_new :'none';

                                        echo '<div>'. $contractNo.$let .'</div>';
                                    @endphp

                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Name</label>
                                    <div>{{ $contract->mem_name !=''? $contract->mem_name :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Contract Date</label>
                                    <div>{{ $contract->cont_date !=''? $contract->cont_date :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Contract Start</label>
                                    <div>{{ $contract->cont_start_date !=''? $contract->cont_start_date :'none'}}</div>
                                </div>
                                <div>
                                    <label style="font-weight: bold;">Contract End</label>
                                    <div>{{ $contract->cont_end_date !=''? $contract->cont_end_date :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Contract Resign</label>
                                    <div>{{ $contract->cont_resign_date  !=''? $contract->cont_resign_date.'('. $contract->cont_resign_status.')' :'none'}}
                                    </div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Download File	</label>
                                    <div>
                                        @if($contract->cont_file_upload !="")
                                            <a href="{{ URL::asset(env('PUBLIC_PATH').'hris/files/employee/'). $contract->cont_file_upload }}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                        @else
                                        none
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-margin-0">
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Contract Status</label>
                                    <div>{{ $contract->cont_sta_name !=''? $contract->cont_sta_name :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Customer Name</label>
                                    <div>{{ $contract->cus_name !=''? $contract->cus_name :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Site Location	</label>
                                    <div>{{ $contract->cont_city_name !=''? $contract->cont_city_name :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Basic Salary</label>
                                    <div>{{ $contract->cur_id}}. {{ $contract->cont_basic_salary}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Gross Salary</label>
                                    <div>{{ $contract->cur_id}}. {{ $contract->cont_tot}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Note</label>
                                    <div>{{ $contract->cont_note !=''? $contract->cont_note :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Update</label>
                                    <div>{{ $contract->cont_user !=''? $contract->cont_user :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding: 0px 30px;">
                            <div class="form-group form-margin-0">
                                <div>
                                    <label style="font-weight: bold;">Department</label>
                                    <div>{{ $contract->cont_dept !=''? $contract->cont_dept :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Bank</label>
                                    <div>{{ $contract->bank_name !=''? $contract->bank_name :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Bank Account</label>
                                    <div>{{ $contract->mem_bank_ac !=''? $contract->mem_bank_ac :'none'}}</div>
                                </div>
                                <div>
                                    <label style="font-weight: bold;">Bank Account</label>
                                    <div>{{ $contract->mem_bank_an !=''? $contract->mem_bank_an :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Division/Cost Center</label>
                                    <div>{{ $contract->cont_div !=''? $contract->cont_div :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                <div>
                                    <label style="font-weight: bold;">Position</label>
                                    <div>{{ $contract->cont_position !=''? $contract->cont_position :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                @if($contract->effective_date !='')
                                <div>
                                    <label style="font-weight: bold;">Effective Date</label>
                                    <div>{{ $contract->effective_date !=''? $contract->effective_date :'none'}}</div>
                                </div>
                                <div style="clear: both; margin-bottom: 10px;"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-check-square-o" style="color: #fff !important"></i>
                    Allowance Information
                </div>
            </div>
            <div class="portlet-body" style="padding: 8px 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div style="padding: 0px 30px;" class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <th>Allowance Type</th>
                                    <th>Total</th>
                                    <th>Description</th>
                                    <th>Updated By</th>
                                    <th>Update</th>
                                </thead>
                                <tbody>
                                @php
                                $a=1;
                                    for($i = 0; $i < count($contract->allowance); $i++){
                                    echo'<tr>
                                            <td>'.$contract->allowance[$i]->fix_allow_type_name.'</td>
                                            <td>'.$contract->allowance[$i]->cur_id.'.'.$contract->allowance[$i]->cont_det_tot.'</td>
                                            <td>'.$contract->allowance[$i]->cont_det_desc.'</td>
                                            <td>'.$contract->allowance[$i]->cont_det_user.'</td>
                                            <td>'.$contract->allowance[$i]->cont_det_update.'</td>

                                        </tr>';
                                    }
                                @endphp
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn dark btn-outline" data-dismiss="modal">Close</button>
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
            $('#formInputEdit').validate({
                rules: {
                    category : {
                        required: true
                    },
                    branch : {
                        required: true
                    },
                    kam: {
                        required: true
                    },
                    customer_name: {
                        required: true
                    },
                    date_paid: {
                        required: true
                    },
                    customer_code: {
                        required: true,
                    },
                    prorate: {
                        required: true,
                    },
                    monthly_based: {
                        required: true
                    },
                    prorate_factor: {
                        required: true,
                        number: true
                    },
                    name_bank1: {
                        required: true
                    },
                    marital: {
                        required: true
                    },
                    marital: {
                        required: true
                    },
                    passport: {
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/check-passport') }}"
                    },
                    passport_date: {
                        required: true
                    },
                    id_card: {
                        number: true,
                        required: true,
                        remote: "{{ URL::asset(env('APP_URL').'/hris/employee/check-ktp') }}"
                   },
                    file: {
                        accept: "image/jpeg, image/pjpeg"
                    },
                    religion: {
                        required: true
                    },
                    email: {
                        email: true
                    },
                    phone: {
                        number: true
                    },
                    postcode: {
                        number: true
                    },
                    contact_phone1: {
                        number: true
                    },
                },
                messages: {
                        email1: {
                                remote: "Email existing"
                            },

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
        $(document).on("submit", "#formInputEdit", function (event)
        {
            $('.loading').show();
            //stop submit the form, we will post it manually.
            event.preventDefault();
            // Get form
            var form = $('#formInputEdit')[0];
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
                url: "{{ URL::asset(env('APP_URL').'/hris/customer/doedit') }}",
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



</script>
