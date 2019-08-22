@extends('Eleave.layout.main')

@section('title','Eleave | Approver Detail')

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
    <li class="active">
        <a href="{{URL::to('eleave/userlevel/show_approver')}}" aria-expanded="true"> Approver </a>
    </li>
    <li class="">
        <a href="{{URL::to('eleave/userlevel/show_apps')}}" aria-expanded="false"> Apps Access </a>
    </li>
</ul>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-users font-green"></i>
            <span class="caption-subject font-green bold uppercase">Approver</span>
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
                    <table id="usertable" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee Name</th>
                                <th>Position</th>
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

@endsection
@section('script')

<script type="text/javascript">
    //var id = $('#level_id').val();
    $('#usertable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${webUrl}eleave/userlevelapprover/getdata`,
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
            {"data": "user_name"},
            {"data": "user_position", "orderable": false},
            {"data": "action", "searchable": false, "orderable": false},
        ]
    });
</script>

@endsection
