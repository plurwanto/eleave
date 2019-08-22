@extends('Eleave.layout.main')

@section('title','Eleave | User Apps Detail')

@section('content')
@if ($message = Session::get('success'))
<div class='alert alert-warning alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>
    <i class='fa fa-check'></i>{{ $message }} 
</div>
@endif

<ul class="nav nav-tabs">
    <li class="">
        <a href="{{URL::to('eleave/userlevel/index')}}" id="tab1" aria-expanded="false"> Userlevel </a>
    </li>
    <li class="">
        <a href="{{URL::to('eleave/userlevel/show_approver')}}" aria-expanded="false"> Approver </a>
    </li>
    <li class="active">
        <a href="{{URL::to('eleave/userlevel/show_apps')}}" aria-expanded="true"> Apps Access </a>
    </li>
</ul>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-users font-green"></i>
            <span class="caption-subject font-green bold uppercase">User Apps</span>
        </div>
        <div class="actions">

        </div>
    </div>
    <div class="portlet-body">
        <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
            </div>
            <div class="fixed-table-container" style="height: 186px; padding-bottom: 41px;">
                <input name="level_id" type="hidden" id='level_id' value="">

                <div class="fixed-table-body">
                    <div class="fixed-table-loading" style="top: 42px; display: none;">Loading, please wait...</div>
                    <table id="mastertable" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Employee Name</th>
                                <th>Employee Email</th>
                                <th>Branch</th>
                                <th>Grantes Access</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--Appended by Ajax-->
                        </tbody>

                    </table>
                </div>
                <div class="fixed-table-footer" >
                    <table>
                        <tbody>
                            <tr><div class="pull-right">
                            <ul class="pagination"></ul>    
                        </div></tr>
                        </tbody>
                    </table>
                </div>
                <a href="{{URL::to('eleave/userlevel/index')}}" class="btn btn-circle grey-salsa btn-outline"><i class="fa fa-times"></i> Back</a>

            </div>
        </div>
        <div class="clearfix"></div>
        <br/>
        <br/>
    </div>
</div>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form"  action="#" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Update</h3>
                </div>
                <div class="modal-body form">
                    <input type="hidden" name="user_id" id="user_id">
                    <input type="hidden" name="txt_user_email" id="txt_user_email">
                    <input type="hidden" name="txt_user_name" id="txt_user_name">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Name:</label>
                            <label class="col-md-6 control-label" style="text-align: left" id='user_name' name='user_name'></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Email:</label>
                            <label class="col-md-6 control-label" style="text-align: left" id='user_email' name='user_email'></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Branch:</label>
                            <label class="col-md-6 control-label" style="text-align: left" id='user_branch' name='user_branch'></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">App Permission:</label>
                            <div class="col-md-9">
                                <div class="mt-checkbox-inline">
                                    <label class="mt-checkbox">
                                        <input type="checkbox" name="chkApp[]" id="chkApp1" value="1"> E-Leave
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox">
                                        <input type="checkbox" name="chkApp[]" id="chkApp2" value="2"> HRIS
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox">
                                        <input type="checkbox" name="chkApp[]" id="chkApp3" value="3"> Dashboard
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox">
                                        <input type="checkbox" name="chkApp[]" id="chkApp4" value="4"> E-Gemes
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-circle grey-salsa btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnSave" class="btn btn-circle green">&nbsp;Save&nbsp;</button>
                </div>
                {{ csrf_field() }}
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
@endsection
@section('script')

<script type="text/javascript">
    var $table;
    $(document).ready(function () {
        $table = $('#mastertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": `${webUrl}eleave/userlevelapps/getdata`,
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?=csrf_token()?>"},
                error: function (jqXhr, textStatus, errorThrown) //jqXHR, textStatus, errorThrown
                {
                    if (jqXhr.status == 419) {//if you get 419 error / page expired
                        toastr.warning("page expired, please login to continue.");
                        location.reload(); 
                    }
                }
            },
            "columns": [
                {"data": "no", "searchable": false, "orderable": false},
                {"data": "user_id", "searchable": false, "orderable": false, "visible": false},
                {"data": "user_name"},
                {"data": "user_email"},
                {"data": "branch_name"},
                {"data": "is_app"},
                {"data": "action", "searchable": false, "orderable": false},
            ],
            order: [[1, "desc"], [3, "desc"]],
        });
    });
</script>

<script>
    function edit_item(id)
    {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();

        $.ajax({
            url: `${webUrl}eleave/userlevelapps/{id}/edit`,
            type: "GET",
            data: {id: id, "_token": "{{ csrf_token() }}"},
            dataType: "JSON",
            success: function (response)
            {
                $('#chkApp1').attr({'checked': ''});
                $('#chkApp2').attr({'checked': ''});
                if (response.status == true) {
                    $('[name="user_id"]').val(response[0].user_id);
                    $('[name="txt_user_name"]').val(response[0].user_name);
                    $('[name="txt_user_email"]').val(response[0].user_email);
                    $('[name="user_name"]').html(response[0].user_name);
                    $('[name="user_email"]').html(response[0].user_email);
                    $('[name="user_branch"]').html(response[0].branch_name);
                    if (response[0].is_app == "" || response[0].is_app == "1" || response[0].is_app == null) {
                        $('#chkApp1').prop("checked", true);
                        $('#chkApp2').prop("checked", false);
                        $('#chkApp3').prop("checked", false);
                        $('#chkApp4').prop("checked", false);
                    } else if (response[0].is_app == "2") {
                        $('#chkApp4').prop("checked", false);
                        $('#chkApp3').prop("checked", false);
                        $('#chkApp2').prop("checked", true);
                        $('#chkApp1').prop("checked", false);
                    }else if (response[0].is_app == "3") {
                        $('#chkApp4').prop("checked", false);
                        $('#chkApp3').prop("checked", true);
                        $('#chkApp2').prop("checked", false);
                        $('#chkApp1').prop("checked", false);
                    }else if (response[0].is_app == "4") {
                        $('#chkApp4').prop("checked", true);
                        $('#chkApp3').prop("checked", false);
                        $('#chkApp2').prop("checked", false);
                        $('#chkApp1').prop("checked", false);
                    }else if (response[0].is_app == "1,2") {
                        $('#chkApp4').prop("checked", false);
                        $('#chkApp3').prop("checked", false);
                        $('#chkApp2').prop("checked", true);
                        $('#chkApp1').prop("checked", true);
                    }else if (response[0].is_app == "1,3") {
                        $('#chkApp4').prop("checked", false);
                        $('#chkApp3').prop("checked", true);
                        $('#chkApp2').prop("checked", false);
                        $('#chkApp1').prop("checked", true);
                    }else if (response[0].is_app == "1,4") {
                        $('#chkApp4').prop("checked", true);
                        $('#chkApp3').prop("checked", false);
                        $('#chkApp2').prop("checked", false);
                        $('#chkApp1').prop("checked", true);
                    }else if (response[0].is_app == "2,3") {
                        $('#chkApp4').prop("checked", false);
                        $('#chkApp3').prop("checked", true);
                        $('#chkApp2').prop("checked", true);
                        $('#chkApp1').prop("checked", false);
                    }else if (response[0].is_app == "2,4") {
                        $('#chkApp4').prop("checked", true);
                        $('#chkApp3').prop("checked", false);
                        $('#chkApp2').prop("checked", true);
                        $('#chkApp1').prop("checked", false);
                    }else if (response[0].is_app == "1,2,3") {
                        $('#chkApp4').prop("checked", false);
                        $('#chkApp3').prop("checked", true);
                        $('#chkApp2').prop("checked", true);
                        $('#chkApp1').prop("checked", true);
                    }else if (response[0].is_app == "1,2,4") {
                        $('#chkApp4').prop("checked", true);
                        $('#chkApp3').prop("checked", false);
                        $('#chkApp2').prop("checked", true);
                        $('#chkApp1').prop("checked", true);
                    }else if (response[0].is_app == "1,3,4") {
                        $('#chkApp4').prop("checked", true);
                        $('#chkApp3').prop("checked", true);
                        $('#chkApp2').prop("checked", false);
                        $('#chkApp1').prop("checked", true);
                    }else if (response[0].is_app == "2,3,4") {
                        $('#chkApp4').prop("checked", true);
                        $('#chkApp3').prop("checked", true);
                        $('#chkApp2').prop("checked", true);
                        $('#chkApp1').prop("checked", false);
                    }

                    $('#modal_form').modal('show');
                    $('.modal-title').text('Update User Apps');
                } else {
                    toastr.warning(response.msg);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    $("#btnSave").click(function () {
        if ($('#chkApp1').prop("checked") == false && $('#chkApp2').prop("checked") == false && $('#chkApp3').prop("checked") == false) {
            alert("Please select your apps");
            return false;
        }

        var url;
        if (save_method == 'update') {
            url = `${webUrl}eleave/userlevelapps/update`;

        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function (data)
            {
                if (data.status)
                {
                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                    $('#modal_form').modal('hide');
                    $table.ajax.reload();
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });

    });
</script>

@endsection
