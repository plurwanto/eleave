@extends('Eleave.layout.main')

@section('title','Eleave | Userlevel Detail')

@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-users font-green"></i>
            <span class="caption-subject font-green bold uppercase">Employee Permissions and Access</span>
        </div>
        <div class="actions">

        </div>
    </div>
    <div class="portlet-body">
        <div class="bootstrap-table">
            <div class="fixed-table-toolbar">
            </div>
            <div class="fixed-table-container" style="height: 186px; padding-bottom: 41px;">
                <input name="level_id" type="hidden" id='level_id' value="{{$userlevelId->id}}">

                <div class="fixed-table-body">
                    <div class="fixed-table-loading" style="top: 42px; display: none;">Loading, please wait...</div>
                    <table id="usertable" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th class="no-sort" style="width: 5%">No</th>
                                <th>Employee Name</th>
                                <th>Position</th>
                            </tr>
                        </thead>&nbsp;
<!--                        <thead>
                            <tr>
                                <td></td>
                                <td><input type="text" data-column="0"  class="search-input-text form-control input-sm" placeholder="Search employee"></td>
                                <th><input type="text" data-column="1"  class="search-input-text form-control input-sm" placeholder="Search position"></td>

                            </tr>
                        </thead>-->
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
    $(document).ready(function () {
        var id = $('#level_id').val();
        var dataTable = $('#usertable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": `${webUrl}eleave/userlevelgroup/getdata`,
                "dataType": "json",
                "type": "POST",
                "data": {"_token": "<?=csrf_token()?>", "id": id},
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
            ],
        });

        //$("#dataTables_filter ").css("display", "none");  // hiding global search box
//        $('.search-input-text').on('keyup click', function () {   // for text boxes
//            var i = $(this).attr('data-column');  // getting column index
//            var v = $(this).val();  // getting search input value
//            dataTable.columns(i).search(v).draw();
//        });
//        $('.search-input-select').on('change', function () {   // for select box
//            var i = $(this).attr('data-column');
//            var v = $(this).val();
//            dataTable.columns(i).search(v).draw();
//        });
    });
</script>

@endsection
