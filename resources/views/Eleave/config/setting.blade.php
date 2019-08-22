@extends('Eleave.layout.main')

@section('title','Configuration system')

@section('style')

@endsection

@section('content')

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-sliders"></i>Configuration system
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <form id="form_user" action="{{ URL::to(env('APP_URL').'/eleave/setting/update') }}" method="POST" role="form">
            <div class="panel-group accordion" id="accordion1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1"> System Settings </a>
                        </h4>
                    </div>
                    <div id="collapse_1" class="panel-collapse in">
                        <div class="panel-body">
                            <input type="hidden" name="id" value="<?=$global_setting->gs_id;?>" />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Maintenance</label>
                                <div class="col-md-4">
                                    <?php
                                    if ($global_setting->server_maintenance == 1) {
                                        $checked1 = 'checked';
                                    } else {
                                        $checked1 = '';
                                    }
                                    ?>
                                    <div class="bootstrap-switch-container"><input <?php echo $checked1;?> class="make-switch" id="server_status" name="server_status" data-size="mini" type="checkbox"></div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Enable Email Notifications </label>
                                <div class="col-md-4">
                                    <?php
                                    if ($global_setting->flag_email == 1) {
                                        $checked2 = 'checked';
                                    } else {
                                        $checked2 = '';
                                    }
                                    ?>
                                    <div class="bootstrap-switch-container"><input <?php echo $checked2;?> class="make-switch" id="flag_email" name="flag_email" data-size="mini" type="checkbox"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2"> Time Management </a>
                        </h4>
                    </div>
                    <div id="collapse_2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">[Room Booking] Max Forward Day</label>
                                <div class="col-md-4">
                                    <input type="number" name="gs_max_forward_day" value="<?=$global_setting->gs_max_forward_day;?>" min="1" max="10" />
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="col-md-3 control-label">[Room Booking] Min Time </label>
                                <div class="col-md-4">
                                    <input type="number" name="gs_min_time" value="<?=$global_setting->gs_min_time;?>" min="10" max="60"/>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Open Access Overtime </label>
                                <div class="col-md-4">
                                    <?php
                                    if ($global_setting->flag_overtime == 1) {
                                        $checked3 = 'checked';
                                    } else {
                                        $checked3 = '';
                                    }
                                    ?>
                                    <div class="bootstrap-switch-container"><input <?php echo $checked3;?> class="make-switch" id="flag_overtime" name="flag_overtime" data-size="mini" type="checkbox"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3"> Collapsible Group Item #3 </a>
                                    </h4>
                                </div>
                                <div id="collapse_3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                            Brunch 3 wolf moon tempor. </p>
                                        <p> Duis autem vel eum iriure dolor in hendrerit in vulputate. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut. </p>
                                        <p>
                                            <a class="btn green" href="ui_tabs_accordions_navs.html#collapse_3" target="_blank"> Activate this section via URL </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_4"> Collapsible Group Item #4 </a>
                                    </h4>
                                </div>
                                <div id="collapse_4" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p> Duis autem vel eum iriure dolor in hendrerit in vulputate. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut. </p>
                                        <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                            Brunch 3 wolf moon tempor. </p>
                                        <p> Duis autem vel eum iriure dolor in hendrerit in vulputate. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut. </p>
                                        <p>
                                            <a class="btn red" href="ui_tabs_accordions_navs.html#collapse_4" target="_blank"> Activate this section via URL </a>
                                        </p>
                                    </div>
                                </div>
                            </div>-->
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-circle green" id="btnSave"><i class="fa fa-save"></i> Save Changes</button>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>


@endsection

@section('script')
@include('Eleave/notification')
<script type="text/javascript">

</script>
@endsection