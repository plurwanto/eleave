@extends('Eleave.layout.main')

@section('title','Eleave | Privilege Management')

@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-key font-green"></i>
            <span class="caption-subject font-green bold uppercase">Check the boxes below to grant access to modules </span>
        </div>
        <div class="actions">
            <b>
                <span style="color:#428bca">
                    <?php echo $jabatan;?>
                </span>
              
            </b>
        </div>
    </div>
    <div class="portlet-body">
        <form id="form1" method="post" action="{{ URL::to(env('APP_URL').'/eleave/privilege/save') }}">
            <input type="hidden" name="level_id" value="{{$id}}">
            <input type="hidden" name="txtjabatan" value="{{$jabatan}}">
            <input type="hidden" name="txtuserid" value="{{ Request::segment(5) }} ">
            <table id="data-table" class="table table-bordered table-hover" >
                <thead>
                    <tr>
                        <th>Modul / Menu
                            <br/>&nbsp;
                        </th>
                        <th class="text-center">View
                            <br>
                            <input value="1" type="checkbox" onClick="checkAll('View', this.checked)">
                        </th>
                        <th class="text-center">Add
                            <br>
                            <input value="1" type="checkbox" onClick="checkAll('Add', this.checked)">
                        </th>
                        <th class="text-center">Edit
                            <br>
                            <input value="1" type="checkbox" onClick="checkAll('Edit', this.checked)">
                        </th>
                        <th class="text-center">Delete
                            <br>
                            <input value="1" type="checkbox" onClick="checkAll('Remove', this.checked)">
                        </th>
<!--                                                                    <th>Cetak
                            <br>
                            <input value="1" type="checkbox" onClick="checkAll('Cetak', this.checked)">
                        </th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php echo $tr;?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-circle green">
                <i class="fa fa-save">
                </i> Save
            </button>
            <?php if ($id != 3) {?>
            <a href="{{ URL::to('eleave/userlevel/index') }}" class="btn btn-circle grey-salsa btn-outline">
                <i class="fa fa-times">
                </i> Cancel
            </a>
            <?php } else {?>
            <a href="{{ URL::to('eleave/userlevel/show_approver') }}" class="btn btn-circle grey-salsa btn-outline">
                <i class="fa fa-times">
                </i> Cancel
            </a>
            <?php }?>
             {{ csrf_field() }}
        </form>
        <div class="clearfix"></div>
        
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('input.child#View').on('change', function () {
            var data = $(this).data('name');

            if (this.checked) {
                $('input.parent:checkbox[data-name="' + data + '"]').prop('checked', true);
            } else {
                var len = ($('input.child:checkbox[data-name="' + data + '"]:checked').length);
              //  alert(len);
                if (len < 1) {
                    $('input.parent:checkbox[data-name="' + data + '"]').prop('checked', false);
                }
            }
        });

    });

    function checkAll(type, condition)
    {
        formz = document.forms['form1'];
        len = formz.elements.length;
        for (i = 0; i < len; i++)
        {
            if (formz.elements[i] && formz.elements[i].type == 'checkbox')
            {
                if (formz.elements[i].id == type)
                    formz.elements[i].checked = condition;
            }
        }
    }
</script>
@endsection