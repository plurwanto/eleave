@extends('Eleave.layout.main')

@section('title','Eleave | UserLevel Add')

@section('content')
@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }} 
</div>
@endif

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-user-md"></i>Add User Levels
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="{{ URL::to(env('APP_URL').'/eleave/userlevel/save') }}" class="form-horizontal" method="post" id="form_input">
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Level Name
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="txt_userlevel_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Description
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="txt_description">
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-circle green" id="btnSave"><i class="fa fa-save"></i> Submit</button>
                        <a href="{{ URL::to('eleave/userlevel/index') }}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Cancel</a>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
        <!-- END FORM-->
    </div>

</div>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        var form1 = $('#form_input');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                select_multi: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                }
            },
            rules: {
                txt_userlevel_name: {
                    minlength: 2,
                    required: true
                },
                txt_description: {
                    minlength: 5,
                    required: true
                },

            },

            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                //App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var cont = $(element).parent('.input-group');
                if (cont.size() > 0) {
                    cont.after(error);
                } else {
                    element.after(error);
                }
            },

            highlight: function (element) { // hightlight error inputs

                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                $('#btnSave').text('Saving...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 
                //success1.show();
                error1.hide();
                return true;
            }
        });

    });
</script>
@endsection
