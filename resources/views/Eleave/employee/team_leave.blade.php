@extends('Eleave.layout.main')

@section('title','Eleave | Leave List Employee')

@section('style')
<style>
/*.DTFC_LeftBodyLiner,
.DTFC_RightBodyLiner {
    max-height: unset !important;
}

.DTFC_LeftFootWrapper,
.DTFC_RightFootWrapper {
    top: -1px !important;
}

.DTFC_RightFootWrapper .table {
    border-left: unset !important;
}

.DTFC_LeftFootWrapper .table {
    border-right: unset !important;
}

.DTFC_LeftFootWrapper .blank {
    border-right: unset !important;
}

.dataTables_scrollFootInner {
    display: none;
}

.blank {
    border-top: 1px solid #e7ecf1 !important;
    border-right: unset !important;
}

.total {
    border-top: 1px solid #e7ecf1 !important;
    border-right: 1px solid #e7ecf1 !important;
}

.total_day,
.total_bf {
    border: 1px solid #e7ecf1 !important;
    border-bottom: unset !important;
    border-left: unset !important;
}*/
</style>
@endsection

@section('content')
<!-- BEGIN SUMMARY -->
<div class="row">
    <?php
    if (!empty($leave_summary)) {
        ?>
    <div class="col-md-8">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-red-sunglo bold uppercase"><?=$user->user_name?>'s Leave
                        Record</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Join Date</th>
                            <th>Last Contract Start Date</th>
                            <th>Active Until</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$user->user_type?></td>
                            <td><?=$user->user_join_date != '0000-00-00' ? date('j F Y', strtotime($user->user_join_date)) : ''?>
                            </td>
                            <td><?=$user->user_last_contract_start_date != '0000-00-00' ? date('j F Y', strtotime($user->user_last_contract_start_date)) : ''?>
                            </td>
                            <td><?=$user->user_active_until != '0000-00-00' ? ($user->user_type == "Permanent" ? "" : date('j F Y', strtotime($user->user_active_until))) : ''?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php }
?>
<div class="row widget-row">
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
                        <?php if ($user->user_gender == "Female") {?>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_annual'] - $leave_summary['plus']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['last_year_remaining']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-venus-mars"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Marriage Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_maternity']?>">0</span>
                </div>
            </div>
            <?php } else {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-male"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_paternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-book"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Study Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_study']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_annual'] - $leave_summary['plus']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['last_year_remaining']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-venus-mars"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Marriage Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_maternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green fa fa-book"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Study Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_study']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_medical']?>">0</span>
                </div>
            </div>
            <!-- TAKEN PTES Contract/Mitra -->
            <?php } elseif ($leave_summary['user_type'] == "Contract/Mitra") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Annual Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_annual']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Medical Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_medical']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-venus-mars"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Marriage Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_maternity']?>">0</span>
                </div>
            </div>
            <?php } else {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-male"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Paternity Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_paternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-times-circle-o"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Unpaid Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_unpaid']?>">0</span>
                </div>
            </div>
            <!-- TAKEN PTES Permanent -->
            <?php } else {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Annual Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php
                                if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
                                    echo 0;
                                } else {
                                    echo $leave_summary['taken_annual'];
                                }
                                ?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php
                                if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
                                    echo $leave_summary['taken_annual'];
                                } else {
                                    echo $leave_summary['last_year_remaining'] - $leave_summary['plus'];
                                }
                                ?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Medical Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_medical']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-venus-mars"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Marriage Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_maternity']?>">0</span>
                </div>
            </div>
            <?php } else {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-male"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Paternity Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_paternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-book"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Study Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_study']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-times-circle-o"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Unpaid Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_unpaid']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_annual']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Medical Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_medical']?>">0</span>
                </div>
            </div>
            <!-- TAKEN ESI Permanent -->
            <?php if ($leave_summary['user_type'] == "Permanent") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php
                                if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
                                    echo $leave_summary['taken_annual'];
                                } else {
                                    echo $leave_summary['last_year_remaining'] - $leave_summary['plus'];
                                }
                                ?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-venus-mars"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Marriage Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_maternity']?>">0</span>
                </div>
            </div>
            <?php } else {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-male"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Paternity Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_paternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-book"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Study Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_study']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-times-circle-o"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Unpaid Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_unpaid']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_annual']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-ambulance"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Medical Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_medical']?>">0</span>
                </div>
            </div>
            <!-- TAKEN EST Permanent -->
            <?php if ($leave_summary['user_type'] == "Permanent") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-plane"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php
                                if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
                                    echo $leave_summary['taken_annual'];
                                } else {
                                    echo $leave_summary['last_year_remaining'] - $leave_summary['plus'];
                                }
                                ?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-venus-mars"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Marriage Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_maternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-book"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Study Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_study']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red fa fa-times-circle-o"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Unpaid Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['taken_unpaid']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_annual']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_maternity']?>">0</span>
                </div>
            </div>
            <?php } else {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-male"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_paternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_compassionate']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php
                                if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
                                    echo $leave_summary['balance_annual'] - $leave_summary['plus'] + $leave_summary['taken_annual'];
                                } else {
                                    echo $leave_summary['balance_annual'] - $leave_summary['plus'];
                                }
                                ?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-plane"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Bring Forward Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php
                                if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
                                    echo $leave_summary['plus'] - $leave_summary['taken_annual'];
                                } else {
                                    echo $leave_summary['plus'];
                                }
                                ?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_maternity']?>">0</span>
                </div>
            </div>
            <?php } else {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-male"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_paternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-book"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Study Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_study']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_annual'] - $leave_summary['plus']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php
                                if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
                                    echo $leave_summary['plus'] - $leave_summary['taken_annual'];
                                } else {
                                    echo $leave_summary['plus'];
                                }
                                ?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-venus-mars"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Marriage Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_maternity']?>">0</span>
                </div>
            </div>
            <?php } else {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-male"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Paternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_paternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-book"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Study Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_study']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_annual'] - $leave_summary['plus']?>">0</span>
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
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?php
                                if ($leave_summary['plus'] >= $leave_summary['taken_annual']) {
                                    echo $leave_summary['plus'] - $leave_summary['taken_annual'];
                                } else {
                                    echo $leave_summary['plus'];
                                }
                                ?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa fa-venus-mars"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Marriage Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_marriage']?>">0</span>
                </div>
            </div>
            <?php if (session('user_gender') == "Female") {?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-female"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Maternity Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_maternity']?>">0</span>
                </div>
            </div>
            <?php }?>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-heartbeat"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Compassionate Leave <sub>/Case</sub></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['max_compassionate']?>">0</span>
                </div>
            </div>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple fa fa-book"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Study Leave</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                        data-value="<?=$leave_summary['balance_study']?>">0</span>
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
    <?php }
    ?>
</div>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-calendar-times-o"></i>Leave List
        </div>
        <div class="tools"></div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper no-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="dt-buttons">

                    </div>
                </div>
            </div>
            <input type="hidden" name="user_id" id="user_id" value="<?=$userId;?>">
            <table class="table table-striped table-bordered table-condensed nowrap" width="100%" id="usertable">
                <thead>
                    <tr>
                        <th style="width: 5px">No</th>
                        <th style="width: 90px">Type<br />
                            <div class="filter-wrapper-type"></div>
                        </th>
                        <th style="width: 105px">Start Date<br />
                            <div class="filter-wrapper-date-start"></div>
                        </th>
                        <th style="width: 105px">End Date<br />
                            <div class="filter-wrapper-date-end"></div>
                        </th>

                        <th style="width: 65px">Days<br />
                            <div class="filter-wrapper-small"></div>
                        </th>
                        <th style="width: 65px">BF<br />
                            <div class="filter-wrapper-small"></div>
                        </th>
                        <th style="width: 250px">Reason<br />
                            <div class="filter-wrapper"></div>
                        </th>

                        <th style="width: 90px">Submit Date</th>
                        <th style="width: 50px; text-align: left !important">Year<br>
                            <div class="filter-wrapper-year">
                                <select class="filter form-control" style="width:60px" id="slt_year" name="slt_year">
                                    <option value="">All Year</option>
                                    <?php
                                $lastYear = (int) date('Y');
                                for ($i = 2015; $i <= $lastYear; $i++) {
                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </th>
                        <th style="width: 70px">Month<br />
                            <select class="filter form-control" name="slt_month" id="slt_month">
                                <option value="">All Month</option>
                                <?php
                                $getMonthVal = $getMonthName = [];
                                foreach (range(1, 12) as $m) {
                                    $getMonthVal = date('m', mktime(0, 0, 0, $m, 1));
                                    $getMonthName = date('F', mktime(0, 0, 0, $m, 1));
                                    echo "<option value='" . $getMonthVal . "'>" . $getMonthName . "</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th style="width: 240px">Status<br />
                            <div class="filter-wrapper-status"></div>
                        </th>
                        <th style="width: 40px">Action</th>

                    </tr>
                </thead>
<!--                <tfoot>
                    <tr>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="total"></td>
                        <td class="total_day"></td>
                        <td class="total_bf"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                        <td class="blank"></td>
                    </tr>
                </tfoot>-->
                
                 <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right;"></th>
                        <th style="font-size: 12px;" class="text-nowrap"></th>
                        <th style="font-size: 12px;" class="text-nowrap"></th>
                        <th colspan="6" ></th>
                    </tr>
                </tfoot>

                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<script type="text/javascript">
var $table;
var id = $('#user_id').val();

$(document).ready(function() {
    $('#usertable thead th').each(function() {
        setdatepicker();
        var title = $('#usertable thead th').eq($(this).index()).text();
        $(this).find(".filter-wrapper").html(
            '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
        $(this).find(".filter-wrapper-small").html(
            '<input type="text" class="filter form-control" placeholder="Filter ' + title + '" />');
        $(this).find(".filter-wrapper-date-start").html(
            '<input type="text" autocomplete="off" class="filter form-control datepicker" id="src_date" placeholder="Filter ' +
            title + '" />');
        $(this).find(".filter-wrapper-date-end").html(
            '<input type="text" autocomplete="off" class="filter form-control datepicker" id="src_date" placeholder="Filter ' +
            title + '" />');
        $(this).find(".filter-wrapper-type").html(
            '<select class="filter form-control" >\n\
                        <option value="">- Choose -</option>\n\
                        <option value="Annual Leave">Annual Leave</option>\n\
                        <option value="Emergency Leave">Emergency Leave</option>\n\
                        <option value="Unpaid Leave">Unpaid Leave</option>\n\
                        <option value="Medical Leave">Medical Leave</option>\n\
                        <option value="Marriage Leave">Marriage Leave</option>\n\
                        <option value="Maternity Leave">Maternity Leave</option>\n\
                        <option value="Compassionate Leave">Compassionate Leave</option>\n\
                        <option value="Study Leave">Study Leave</option>\n\
                    </select>'

        );
        $(this).find(".filter-wrapper-status").html(
            '<select class="filter form-control">\n\
                        <option value="">- Choose -</option>\n\
                        <option value="1">Rejected</option>\n\
                        <option value="2">Approved</option>\n\
                        <option value="3">Waiting revision</option>\n\
                        <option value="4">Waiting approval</option>\n\
                     </select>'
        );
    });

    $table = $('#usertable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${webUrl}eleave/leave/team_leave`,
            "dataType": "json",
            "type": "POST",
            "data": {
                "_token": "<?=csrf_token()?>",
                "id": id
            },
            dataSrc: function(data) {
                totalDay = data.totalDays;
                totalBf = data.totalBf;
                return data.data;
            },
            error: function (jqXhr, textStatus, errorThrown) //jqXHR, textStatus, errorThrown
            {
                if (jqXhr.status == 419) {//if you get 419 error / page expired
                    toastr.warning("page expired, please login to continue.");
                    location.reload(); 
                }
            }        
        },
        dom: "<'row'<'col-md-6 'l><'col-md-6 pull-right'>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "columns": [{
                "data": "no",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "lv_type",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "lv_start_date",
                "searchable": false,
                "orderable": true
            },
            {
                "data": "lv_end_date",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "days",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "bf",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "detail",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "lv_submit_date",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "year",
                "searchable": false,
                "orderable": false,
                "className": "text-right"
            },
            {
                "data": "month",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "status",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "action",
                "searchable": false,
                "orderable": false
            },
        ],
        columnDefs: [
            {
                "data": "lv_type",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "lv_start_date",
                "searchable": false,
                "orderable": true
            },
            {
                "data": "lv_end_date",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "days",
                "searchable": false,
                "orderable": false,
                "autoWidth": true
            },
            {
                "data": "bf",
                "searchable": false,
                "orderable": false,
                "autoWidth": true
            },
            {
                "data": "detail",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "lv_submit_date",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "year",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "month",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "status",
                "searchable": false,
                "orderable": false
            },
            {
                "data": "action",
                "searchable": false,
                "orderable": false
            },
        ],
        columnDefs: [{
            render: function(data, type, full, meta) {
                return "<div class='text-wrap'>" + data + "</div>";
            },
            targets: [4]
        }],
        scrollY: 350,
        scrollX: true,
        //scrollCollapse: true,
        "pageLength": 10,
        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        order: [[2, "desc"]],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,day(s)]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotalDays = api
                .column(4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                pageTotalBf = api
                .column(5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
         //   $('.total_day').html(pageTotalDays + ' day(s)');
            $(api.column(4).footer()).html(pageTotalDays + " of " + totalDay);
            $(api.column(5).footer()).html(pageTotalBf + " of " + totalBf);
            var tableinfo = $table.page.info();
            if (tableinfo.recordsDisplay == 0 || isNaN(tableinfo.recordsDisplay)) {
                $(".DTFC_Cloned tfoot tr").css("display", "none");
            } else {
                $(".DTFC_LeftWrapper").css({"display": "block"});
                $(".DTFC_LeftWrapper .DTFC_Cloned tfoot tr").css({"display": "block", "height": "28px"});
                $(".DTFC_RightWrapper .DTFC_Cloned tfoot tr").css({"display": "block", "height": "28px"});
                $(".DTFC_LeftFootWrapper").css("display", "none");
                $(".DTFC_RightFootWrapper").css("display", "none");
            }
                
        },
        "fnInitComplete": function () {
            // Disable scrolling in Head
            $('.dataTables_scrollHead').css({
                'overflow-y': 'hidden !important'
            });

            // Disable TBODY scroll bars
            $('.dataTables_scrollBody').css({
                'overflow-y': 'scroll',
                'overflow-x': 'hidden',
                'border': 'none',
            });

            // Enable TFOOT scoll bars
            $('.dataTables_scrollFoot').css('overflow', 'auto');

            //  Sync TFOOT scrolling with TBODY
            $('.dataTables_scrollFoot').on('scroll', function () {
                $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
            });

        },
    });

    new $.fn.dataTable.FixedColumns($table, {
        leftColumns: 4,
        rightColumns: 2
    });
    
    $table.columns().eq(0).each(function(colIdx) {
        $('input', $table.column(colIdx).header()).on('keyup change', function() {
            $table
                .column(colIdx)
                .search(this.value)
                .draw();
        });
        $('input', $table.column(colIdx).header()).on('click', function(e) {
            e.stopPropagation();
        });
        $('select', $table.column(colIdx).header()).on('change', function() {
            $table
                .column(colIdx)
                .search(this.value)
                .draw();
        });
        $('select', $table.column(colIdx).header()).on('click', function(e) {
            e.stopPropagation();
        });
    });

    $.fn.dataTable.ext.errMode = 'none';

});

function setdatepicker() {
    $('.datepicker').datepicker({
            format: 'dd M yy',
            clearBtn: true,
            autoclose: true,
            todayHighlight: true,
            // endDate: "1m"
        })
        .on("change", function() {
            var value = $(this).val();
            var parent_scroll = $(this).parent().attr('class');
            if (parent_scroll == 'filter-wrapper-date-start') {
                $('.DTFC_LeftWrapper .filter-wrapper-date-start #src_date').val(value);
            } else if (parent_scroll == 'filter-wrapper-date-end') {
                $('.DTFC_LeftWrapper .filter-wrapper-date-end #src_date').val(value);
            }
        });
}
</script>

<script>
$(document).on('click', '.reject', function() {
    if (confirm("Are you sure delete ?  ")) {
        var $button = $(this);
        var id = this.id.split('-').pop();
        $.ajax({
            type: 'POST',
            url: `${webUrl}eleave/leave/deleteHr`,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                "_token": "{{ csrf_token() }}"
            },

            success: function(data) {
                if (data.status == true) {
                    $table.row($button.parents('tr')).remove().draw();
                    toastr.success(data.message);
                }
            },
            error: function(data) {
                toastr.error(data.message);
            }
        });
    }
});
</script>
<script>
toastr.options = {
    "closeButton": true,
};

@if(Session::has('message'))
var type = "{{ Session::get('alert-type', 'info') }}";
switch (type) {
    case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
    case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;
    case 'success':
        toastr.success("{{ Session::get('message') }}");
        break;
    case 'error':
        toastr.error("{{ Session::get('message') }}");
        break;
}
@endif
</script>
@endsection