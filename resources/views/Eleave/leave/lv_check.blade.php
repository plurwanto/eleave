@extends('Eleave.layout.main')

@section('title','Eleave | Leave Add')

@section('style')

@endsection

@section('content')


<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-clock-o"></i>Add Leave Form
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <!-- BEGIN FORM-->
        <form action="{{ url('eleave/leave/add') }}" class="form-horizontal" method="post">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Leave Type</label>
                    <div class="col-md-4">
                        <select class="form-control" name="lv_type">
                            <!-- PTES -->
                            <?php if (session('branch_id') == 2) {?>
                                <?php if (session('user_type') == "Probation") {?>
                                    <option value="Medical Leave">Medical Leave</option>
                                <?php } else {?>
                                    <option value="Annual Leave">Annual Leave</option>
                                    <option value="Emergency Leave">Emergency Leave</option>
                                    <option value="Unpaid Leave">Unpaid Leave</option>
                                    <option value="Medical Leave">Medical Leave</option>
                                    <option value="Marriage Leave">Marriage Leave</option>
                                    <?php if (session('user_gender') == "Female") {?>
                                        <option value="Maternity Leave">Maternity Leave</option>
                                    <?php } else {?>
                                        <option value="Paternity Leave">Paternity Leave</option>
                                    <?php }?>
                                    <option value="Compassionate Leave">Compassionate Leave</option>	
                                <?php }?>
                                <?php if (session('user_type') == "Permanent") {?>
                                    <option value="Study Leave">Study Leave</option>
                                <?php }?>
                            <?php }?>

                            <!-- ESI -->
                            <?php if (session('branch_id') == 3) {?>
                                <option value="Annual Leave">Annual Leave</option>
                                <option value="Emergency Leave">Emergency Leave</option>
                                <option value="Unpaid Leave">Unpaid Leave</option>
                                <option value="Medical Leave">Medical Leave</option>
                                <?php if (session('user_type') == "Permanent") {?>
                                    <option value="Marriage Leave">Marriage Leave</option>
                                    <?php if (session('user_gender') == "Female") {?>
                                        <option value="Maternity Leave">Maternity Leave</option>
                                    <?php } else {?>
                                        <option value="Paternity Leave">Paternity Leave</option>
                                    <?php }?>
                                    <option value="Compassionate Leave">Compassionate Leave</option>
                                    <option value="Study Leave">Study Leave</option>
                                <?php }?>
                            <?php }?>

                            <!-- EST -->
                            <?php if (session('branch_id') == 4) {?>
                                <option value="Annual Leave">Annual Leave</option>
                                <option value="Emergency Leave">Emergency Leave</option>
                                <option value="Unpaid Leave">Unpaid Leave</option>
                                <option value="Medical Leave">Medical Leave</option>
                                <?php if (session('user_type') == "Permanent") {?>
                                    <option value="Marriage Leave">Marriage Leave</option>
                                    <?php if (session('user_gender') == "Female") {?>
                                        <option value="Maternity Leave">Maternity Leave</option>
                                    <?php }?>
                                    <option value="Compassionate Leave">Compassionate Leave</option>
                                    <option value="Study Leave">Study Leave</option>
                                <?php }?>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-circle green">Apply Leave</button>
                        <!--<button type="reset" class="btn btn-circle grey-salsa btn-outline">Reset</button>-->
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
        <!-- END FORM-->
    </div>
</div>
@endsection