@extends('Eleave.layout.main')

@section('title')
Dashboard
@endsection

@section('content')

<!-- LEAVE SUMMARY -->
<?php
$today = date("Y-m-d");
$date1 = new DateTime(session("user_join_date"));
$date2 = new DateTime($today);
$interval = $date1->diff($date2);
?>
<!-- WORK DURATION -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display" style="margin-bottom:0;">
                <h4 class="widget-thumb-heading">Duration of Contribution</h4>
                <div class="number" style="margin-right: 25px;">
                    <h3 class="font-red-haze">
                        <span data-counter="counterup" data-value="{{$interval->y}}">0</span>
                        <!--<small class="font-green-sharp">$</small>-->
                    </h3>
                    <small>YEAR</small>
                </div>
                <div class="number" style="margin-right: 25px;">
                    <h3 class="font-blue-sharp">
                        <span data-counter="counterup" data-value="{{$interval->m}}">0</span>
                    </h3>
                    <small>MONTH</small>
                </div>
                <div class="number" style="margin-right: 25px;">
                    <h3 class="font-green-sharp">
                        <span data-counter="counterup" data-value="{{$interval->d}}"></span>
                    </h3>
                    <small>DAY</small>
                </div>
                <div class="icon">
                    <i class="fa fa-hourglass"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row widget-row">
    <!--POLICY-->
    <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed"> 
            <div class="tab-content" style="padding: 10px 0px 5px 0px;">
                <div class="tab-pane active" id="tab_0">
                    <?php if (!empty($policy)) {?>
                        <a href="{{url($policy['pol_attendance'])}}" class="btn red" style="margin-bottom:10px;" target="_blank">Download Attendance Policy</a>
                        <a href="{{url($policy['pol_leave'])}}" class="btn blue" style="margin-bottom:10px;" target="_blank">Download Leave Policy</a>
                        <a href="{{url($policy['pol_workplace'])}}" class="btn yellow" style="margin-bottom:10px;" target="_blank">Download Workplace Policy</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!empty($leave_summary)) {
        if (!isset($leave_summary['plus'])) {
            $leave_summary['plus'] = 0;
        } 
        ?>

    <div class="col-md-4">
        <!-- BEGIN WIDGET THUMB -->
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <!-- ===================================================== ENTITLE =============================================== -->
            <h4 class="widget-thumb-heading">Entitle</h4>

            <!-- ENTITLE PTES -->
            <?php if ($leave_summary['branch_id'] == 2) {?>
                <!-- ENTITLE PTES Probation -->
                <?php if ($leave_summary['user_type'] == "Probation") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                    <!-- ENTITLE PTES Contract/Mitra -->
                <?php } elseif ($leave_summary['user_type'] == "Contract/Mitra") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Annual Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_annual']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                            <!--<i class="widget-thumb-icon bg-green icon-bulb"></i>-->
                        <i class="widget-thumb-icon bg-green fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_marriage']?>">0</span>
                        </div>
                    </div>
                    <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_maternity']?>">0</span>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_paternity']?>">0</span>
                            </div>
                        </div>
                    <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                    <!-- ENTITLE PTES Permanent -->
                <?php } else {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Annual Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_annual'] - $leave_summary['plus']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['last_year_remaining']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_marriage']?>">0</span>
                        </div>
                    </div>
                    <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_maternity']?>">0</span>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_paternity']?>">0</span>
                            </div>
                        </div>
                    <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                <?php }?>
            <?php }?>

            <!-- ENTITLE ESI -->
            <?php if ($leave_summary['branch_id'] == 3) {?>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-plane"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Annual Leave</span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_annual'] - $leave_summary['plus']?>">0</span>
                    </div>
                </div>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-ambulance"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Medical Leave</span>
                        <span class="widget-thumb-body-stat">&infin;</span>
                    </div>
                </div>
                <!-- ENTITLE ESI Permanent -->
                <?php if ($leave_summary['user_type'] == "Permanent") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['last_year_remaining']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_marriage']?>">0</span>
                        </div>
                    </div>
                    <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_maternity']?>">0</span>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_paternity']?>">0</span>
                            </div>
                        </div>
                    <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                <?php }?>
            <?php }?>

            <!-- ENTITLE EST -->
            <?php if ($leave_summary['branch_id'] == 4) {?>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-plane"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Annual Leave</span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_annual'] - $leave_summary['plus']?>">0</span>
                    </div>
                </div>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-ambulance"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Medical Leave</span>
                        <span class="widget-thumb-body-stat">&infin;</span>
                    </div>
                </div>
                <!-- ENTITLE EST Permanent -->
                <?php if ($leave_summary['user_type'] == "Permanent") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['last_year_remaining']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_marriage']?>">0</span>
                        </div>
                    </div>
                    <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_maternity']?>">0</span>
                            </div>
                        </div>
                    <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-green fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
        </div>
        <!-- END WIDGET THUMB -->
    </div>


    <div class="col-md-4">
        <!-- BEGIN WIDGET THUMB -->
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <!-- ====================================================== TAKEN =============================================== -->
            <h4 class="widget-thumb-heading">Taken</h4>

            <!-- TAKEN PTES -->
            <?php if ($leave_summary['branch_id'] == 2) {?>
                <!-- TAKEN PTES Probation -->
                <?php if ($leave_summary['user_type'] == "Probation") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_medical']?>">0</span>
                        </div>
                    </div>
                    <!-- TAKEN PTES Contract/Mitra -->
                <?php } elseif ($leave_summary['user_type'] == "Contract/Mitra") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Annual Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_annual']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_medical']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_marriage']?>">0</span>
                        </div>
                    </div>
                    <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave</span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_maternity']?>">0</span>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave</span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_paternity']?>">0</span>
                            </div>
                        </div>
                    <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_unpaid']?>">0</span>
                        </div>
                    </div>
                    <!-- TAKEN PTES Permanent -->
                <?php } else {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Annual Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" 
                                data-value="{{ ($leave_summary['plus'] >= $leave_summary['taken_annual']) ? 0 : $leave_summary['taken_annual'] }}">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{ ($leave_summary['plus'] >= $leave_summary['taken_annual']) ?  $leave_summary['taken_annual'] : $leave_summary['last_year_remaining'] - $leave_summary['plus']}}">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_medical']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_marriage']?>">0</span>
                        </div>
                    </div>
                    <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave</span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_maternity']?>">0</span>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave</span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_paternity']?>">0</span>
                            </div>
                        </div>
        <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_unpaid']?>">0</span>
                        </div>
                    </div>
    <?php }?>
<?php }?>

            <!-- TAKEN ESI -->
<?php if ($leave_summary['branch_id'] == 3) {?>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Annual Leave</span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_annual']?>">0</span>
                    </div>
                </div>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Medical Leave</span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_medical']?>">0</span>
                    </div>
                </div>
                <!-- TAKEN ESI Permanent -->
    <?php if ($leave_summary['user_type'] == "Permanent") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
            echo $leave_summary['taken_annual'];
        } else {
            echo $leave_summary['last_year_remaining'] - $leave_summary['plus'];
        }?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_marriage']?>">0</span>
                        </div>
                    </div>
        <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave</span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_maternity']?>">0</span>
                            </div>
                        </div>
        <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave</span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_paternity']?>">0</span>
                            </div>
                        </div>
        <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_unpaid']?>">0</span>
                        </div>
                    </div>
    <?php }?>
<?php }?>

            <!-- TAKEN EST -->
<?php if ($leave_summary['branch_id'] == 4) {?>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Annual Leave</span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_annual']?>">0</span>
                    </div>
                </div>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Medical Leave</span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_medical']?>">0</span>
                    </div>
                </div>
                <!-- TAKEN EST Permanent -->
    <?php if ($leave_summary['user_type'] == "Permanent") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
            echo $leave_summary['taken_annual'];
        } else {
            echo $leave_summary['last_year_remaining'] - $leave_summary['plus'];
        }?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_marriage']?>">0</span>
                        </div>
                    </div>
        <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave</span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_maternity']?>">0</span>
                            </div>
                        </div>
        <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-red fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['taken_unpaid']?>">0</span>
                        </div>
                    </div>
    <?php }?>
<?php }?>
        </div>
        <!-- END WIDGET THUMB -->
    </div>

    <div class="col-md-4">
        <!-- BEGIN WIDGET THUMB -->
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <!-- ============================================= BALANCE ==================================================== -->
            <h4 class="widget-thumb-heading">Balance</h4>

            <!-- BALANCE PTES -->
<?php if ($leave_summary['branch_id'] == 2) {?>
                <!-- BALANCE PTES Probation -->
    <?php if ($leave_summary['user_type'] == "Probation") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                    <!-- BALANCE PTES Contract/Mitra -->
    <?php } elseif ($leave_summary['user_type'] == "Contract/Mitra") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Annual Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_annual']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_marriage']?>">0</span>
                        </div>
                    </div>
                    <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_maternity']?>">0</span>
                            </div>
                        </div>
        <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_paternity']?>">0</span>
                            </div>
                        </div>
                    <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                    <!-- BALANCE PTES Permanent -->
    <?php } else {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Annual Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{ ($leave_summary['plus'] >= $leave_summary['taken_annual']) ? $leave_summary['balance_annual'] - $leave_summary['plus'] + $leave_summary['taken_annual'] : $leave_summary['balance_annual'] - $leave_summary['plus'] }}">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{ ($leave_summary['plus'] >= $leave_summary['taken_annual']) ? $leave_summary['plus'] - $leave_summary['taken_annual'] : $leave_summary['plus'] }}">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-ambulance"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Medical Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_marriage']?>">0</span>
                        </div>
                    </div>
        <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_maternity']?>">0</span>
                            </div>
                        </div>
        <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_paternity']?>">0</span>
                            </div>
                        </div>
        <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
    <?php }?>
<?php }?>

            <!-- BALANCE ESI -->
<?php if ($leave_summary['branch_id'] == 3) {?>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple fa fa-plane"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Annual Leave</span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_annual'] - $leave_summary['plus']?>">0</span>
                    </div>
                </div>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple fa fa-ambulance"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Medical Leave</span>
                        <span class="widget-thumb-body-stat">&infin;</span>
                    </div>
                </div>
                <!-- BALANCE ESI Permanent -->
    <?php if ($leave_summary['user_type'] == "Permanent") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
            echo $leave_summary['plus'] - $leave_summary['taken_annual'];
        } else {
            echo $leave_summary['plus'];
        }?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_marriage']?>">0</span>
                        </div>
                    </div>
        <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_maternity']?>">0</span>
                            </div>
                        </div>
        <?php } else {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple fa fa-male"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_paternity']?>">0</span>
                            </div>
                        </div>
        <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
    <?php }?>
<?php }?>

            <!-- BALANCE EST -->
<?php if ($leave_summary['branch_id'] == 4) {?>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple fa fa-plane"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Annual Leave</span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_annual'] - $leave_summary['plus']?>">0</span>
                    </div>
                </div>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple fa fa-ambulance"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle">Medical Leave</span>
                        <span class="widget-thumb-body-stat">&infin;</span>
                    </div>
                </div>
                <!-- BALANCE EST Permanent -->
    <?php if ($leave_summary['user_type'] == "Permanent") {?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-plane"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
            echo $leave_summary['plus'] - $leave_summary['taken_annual'];
        } else {
            echo $leave_summary['plus'];
        }?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa fa-venus-mars"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Marriage Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_marriage']?>">0</span>
                        </div>
                    </div>
        <?php if (session('user_gender') == "Female") {?>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple fa fa-female"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_maternity']?>">0</span>
                            </div>
                        </div>
        <?php }?>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-heartbeat"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-book"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Study Leave</span>
                            <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?=$leave_summary['balance_study']?>">0</span>
                        </div>
                    </div>
                    <div class="widget-thumb-wrap">
                        <i class="widget-thumb-icon bg-purple fa fa-times-circle-o"></i>
                        <div class="widget-thumb-body">
                            <span class="widget-thumb-subtitle">Unpaid Leave</span>
                            <span class="widget-thumb-body-stat">&infin;</span>
                        </div>
                    </div>
    <?php }?>
<?php }?>
        </div>
        <!-- END WIDGET THUMB -->
    </div>
    <?php } ?>
</div>

@section('script')
@include('Eleave/notification')
@endsection
@endsection
