@extends('Eleave.layout.main')

@section('title','Eleave | UserLevel List')

@section('content')

@if ($message = Session::get('success'))
<div class='alert alert-warning'><a href="#" class="close" data-dismiss="alert">&times;</a>
    <i class='fa fa-check'></i>{{ $message }} 
</div>
@endif

<ul class="nav nav-tabs">
    <li class="active">
        <a href="{{URL::to('eleave/userlevel/index')}}" id="tab1" aria-expanded="true"> Userlevel </a>
    </li>
    <li class="">
        <a href="{{URL::to('eleave/userlevel/show_approver')}}" aria-expanded="false"> Approver </a>
    </li>
    <li class="">
        <a href="{{URL::to('eleave/userlevel/show_apps')}}" aria-expanded="false"> Apps Access </a>
    </li>
</ul>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-users font-green"></i>
            <span class="caption-subject font-green bold uppercase">UserLevel List</span>
        </div>
        <div class="actions">
            <?php //if ($this->general->privilege_check(DEPARTMENT, 'add')) {?>
            <a title="Add" class="btn btn-circle green" href="{{ URL::to('eleave/userlevel/add') }}">Add <i class="fa fa-plus"></i> </a>
            <?php //}?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
                <!--                <div class="pull-right search">
                                    <input type="text" class="form-control" id="search" placeholder="Search..." x-webkit-speech>
                                                        <button class="btn btn-default" id="btn-search"><i class="fa fa-search"></i></button>
                                </div>-->
            </div>
            <div class="fixed-table-container" style="height: 186px; padding-bottom: 41px;">

                <div class="fixed-table-body">
                    <div class="fixed-table-loading" style="top: 42px; display: none;">Loading, please wait...</div>
                    <table id="usertable" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Level Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>&nbsp;
                        <tbody>

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

            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('#usertable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${webUrl}eleave/userlevel/getdata`,
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
            {"data": "userlevel_name"},
            {"data": "description", "searchable": false, "orderable": false},
            {"data": "action", "searchable": false, "orderable": false}
        ]
    });
</script>

<script>
    function delete_list(id)
    {
        //alert(id)
        if (confirm("Are you sure delete ?  "))
        {
            $.ajax({
                type: 'DELETE',
                url: `${webUrl}eleave/userlevel/delete`,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: id, "_token": "{{ csrf_token() }}"},

                success: function (data) {
                    if (data.status == true) {
                        location.reload();
                    }
                },

            });

        }
    }
</script>
@endsection