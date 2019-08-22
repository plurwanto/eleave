@extends('Eleave.layout.main')

@section('title','Eleave | title here')

@section('style')
<link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-users font-green"></i>
            <span class="caption-subject font-green bold uppercase">UserLevel List</span>
        </div>
        <div class="actions">
            <?php //if ($this->general->privilege_check(DEPARTMENT, 'add')) {?>
            <a title="Add" class="btn btn-circle green" href="{{ URL::to('userlevel/add') }}">Add <i class="fa fa-plus"></i> </a>
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
                                <th>Action</th>
<!--                                <th>Action</th>-->
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
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables//plugins/bootstrap/datatables.bootstrap.js') }}"  type="text/javascript"></script>
<script type="text/javascript">
    			$('#usertable').DataTable( {
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url":"<?= route('department.getdata') ?>",
					"dataType":"json",
					"type":"POST",
					"data":{"_token":"<?= csrf_token() ?>"}
				},
				"columns":[
                                        {"data":"no"},
					{"data":"department_name"},
					{"data":"action","searchable":false,"orderable":false}
				]
			} );
		</script>

@endsection
<script>
    function delete_list(id)
    {
        //alert(id)
        if (confirm("Are you sure delete ?  "))
        {
            $.ajax({
                type: 'DELETE',
                url: '/userlevelDelete',
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