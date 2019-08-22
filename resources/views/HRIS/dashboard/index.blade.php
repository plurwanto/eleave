@extends('HRIS/layout.main')
@section('title', 'Dashboard')
@section('breadcrumbs')
<div style="height: 30px;margin: 0px 0px 15px 0px;">
    <div class="page-title" style="
        border-right: 1px solid #cbd4e0;
        display: inline-block;
        float: left;
        padding-right: 15px;
        margin-right: 15px;">
    <h1 style="
        color: #697882;
        font-size: 22px;
        font-weight: 400;
        margin: 0;">{{$title}}</h1>
    </div>
    <ul class="page-breadcrumb breadcrumb pull-left" style="padding: 3px 0;">
        <li style="color: #697882;">{{$title}}</li>
    </ul>
    <div class="actions pull-right">
    <select id="customer" class="form-control input-sm select2-multiple" style="border-radius: 6px !important;" onchange="javascript:handleSelect()">
        <option value="0">ALL</option>
        @for($i = 0; $i < count($customer); $i++)
            @if(md5($customer[$i]->cus_id) == $cus_id)
                <option value="{{md5($customer[$i]->cus_id)}}" selected>{{$customer[$i]->cus_name}}</option>
            @else
                <option value="{{md5($customer[$i]->cus_id)}}">{{$customer[$i]->cus_name}}</option>
            @endif
        @endfor
    </select>
    </div>
 </div>
@endsection





@section('content')
<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 250px;
}
#chartdiv2 {
  width: 100%;
  height: 300px;
}
#chartdiv3 {
  width: 100%;
  height: 300px;
}

#tableinfo {
  width: 100%;
  height: 300px;
}

.dataTables_filter { display: none };

</style>
<div class="page-content">
    <div class="container-fluid">
        <!-- BEGIN PAGE BREADCRUMBS -->
        @yield('breadcrumbs')

        <!-- END PAGE BREADCRUMBS -->


        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green-sharp">
                                    <span data-counter="counterup" data-value="{{$contractActive}}">0</span>
                                </h3>
                                <small>Active Contract</small>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-haze">
                                    <span data-counter="counterup" data-value="{{$contractEnd}}">0</span>
                                </h3>
                                <a href="{{ URL::asset(env('APP_URL').'/hris/employee/others?link=contract-will-end-soon') }}">
                                    <small>Contract Will End Soon</small>
                                </a>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green-sharp">
                                    <span data-counter="counterup" data-value="{{$employeeActive}}"></span>
                                </h3>
                                <a href="{{ URL::asset(env('APP_URL').'/hris/employee/others?link=active') }}">
                                    <small>Employee Active</small>
                                </a>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-soft">
                                    <span data-counter="counterup" data-value="{{$passportEnd}}"></span>
                                </h3>
                                <a href="{{ URL::asset(env('APP_URL').'/hris/employee/others?link=passport-will-end-soon') }}">
                                    <small>Passport Will Expire</small>
                                </a>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-times"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(in_array(3,$div_id) OR in_array(16,$div_id) OR in_array(17,$div_id))
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-body">

                                <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                       KAM Revenue
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="actions pull-left">
                                        <table style="color:red">
                                            <tr>
                                                <td>Total FULL</td>
                                                <td style="width:20px"><center>:</center></td>
                                                <td>IDR.  <span class="pull-right">{{$res->total_full}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Total MF</td>
                                                <td><center>:</center></td>
                                                <td>IDR.  <span class="pull-right">{{$res->total_mf}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Total FULL + MF</td>
                                                <td><center>:</center></td>
                                                <td>IDR.  <span class="pull-right">{{$res->total}}</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="actions pull-right" style="margin-bottom:30px">
                                        <select name="year" id="year" class="form-control"  onchange="javascript:handleSelect()">
                                            @php
                                            $now = date('Y');
                                            for($i=2014; $i <= $now; $i++){
                                                if($i == $year){
                                                    echo '<option value="'.$i.'" selected>'.$i.'</option>';

                                                }else{
                                                    echo '<option value="'.$i.'">'.$i.'</option>';

                                                }
                                            }
                                            @endphp
                                            </select>
                                    </div>
                                    <div class="table-scrollable">
                                        <table class="table table-striped table-bordered table-advance table-hover" style="table-layout:fixed;">
                                            <thead>
                                                <tr>
                                                    <th  style="width:250px"> Name </th>
                                                    <th style="width:80px"> Currency </th>
                                                    <th style="width:150px"> Revenue Target </th>
                                                    <th  style="width:150px"> Achievement </th>
                                                    <th  style="width:150px"> Gap To Go </th>
                                                    <th  style="width:50px"> ( % ) </th>
                                                    <th  style="width:150px"> Jan </th>
                                                    <th  style="width:150px"> Feb </th>
                                                    <th  style="width:150px"> Mar </th>
                                                    <th  style="width:150px"> Apr </th>
                                                    <th  style="width:150px"> May </th>
                                                    <th  style="width:150px"> Jun </th>
                                                    <th  style="width:150px"> Jul </th>
                                                    <th  style="width:150px"> Aug </th>
                                                    <th  style="width:150px"> Sep </th>
                                                    <th  style="width:150px"> Oct </th>
                                                    <th  style="width:150px"> Nov </th>
                                                    <th  style="width:150px"> Des </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                for($i=0; $i < count($kam); $i++){
                                                    echo '<tr>';
                                                    if($kam[$i]->revenue_based == 'FULL'){
                                                        echo '<td  style="table-layout:fixed; width:300px">' . $kam[$i]->nama . '<label class="label label-sm border-rounded  label-danger pull-right"><font style="font-size:10px">' . $kam[$i]->revenue_based . '</font></label></td>';
                                                    }else{
                                                        echo '<td  style="table-layout:fixed; width:300px">' . $kam[$i]->nama . '<label class="label label-sm border-rounded  label-primary pull-right"><font style="font-size:10px">' . $kam[$i]->revenue_based . '</font></label></td>';
                                                    }
                                                    echo '<td>' . $kam[$i]->currency . '</td>';
                                                    echo '<td><span class="pull-right">'.$kam[$i]->revenue_kpi.'</span></td>';
                                                    echo '<td><span class="pull-right">' . $kam[$i]->total . '</span></td>';
                                                    echo '<td><span class="pull-right">' . $kam[$i]->gap . '</span></td>';
                                                    echo '<td><span class="pull-right">' . $kam[$i]->percent . '%</span></td>';
                                                    for ($a = 0; $a < count($kam[$i]->detail); $a++) {
                                                        echo '<td><span class="pull-right">' . $kam[$i]->detail[$a]->total . '</span></td>';
                                                    }

                                                    echo '</tr>';
                                                }
                                                @endphp

                                                <tr>
                                                    <td  style="width:250px"><b>Total</b></td>
                                                    <td style="width:80px"></td>
                                                    <td style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_revenue_kpi}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_total}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_gap}}</b></span></td>
                                                    <td  style="width:50px"></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_jan}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_feb}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_mar}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_apr}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_mei}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_jun}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_jul}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_agt}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_sep}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_okt}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_nov}}</b></span></td>
                                                    <td  style="width:150px"><span class="pull-right"><b>{{$kam_footer->tot_des}}</b></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endif
                @if($payroll)
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-body">

                                <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        Payroll Approval Pending </div>

                                </div>
                                <div class="portlet-body">
                                    <div >
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="dataTable" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th> id </th>
                                                    <th> Request Code </th>
                                                    <th> Title </th>
                                                    <th> Status </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                for($i=0; $i < count($payroll); $i++){
                                                    echo '<tr>';
                                                    echo '<td>'.$payroll[$i]->app_id.'</td>';
                                                    echo '<td style="width:250px">
                                                    <a dataaction="detail" title="detail" dataid="' . $payroll[$i]->app_id . '" onclick="get_modal(this)">'.$payroll[$i]->app_code.'</a>
                                                    </td>';
                                                    echo '<td>'.$payroll[$i]->app_name.'</td>';
                                                    echo '<td>'.$payroll[$i]->status.'</td>';
                                                    echo '</tr>';
                                                }
                                                @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endif
            </div>

            @php
            if(!in_array(3,$div_id)){
            echo ' <div class="row">
                        <div class="col-lg-12 col-xs-12 col-sm-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject bold uppercase font-dark">Top 10 Customer</span>
                                    </div>
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="chartdiv"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xs-12 col-sm-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject bold uppercase font-dark">employee based on branch</span>
                                    </div>
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="chartdiv2"></div>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            @endphp

        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>

@endsection



@section('script')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_SCRIPT_PATH').'datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
<!-- Resources -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/core.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/charts.js') }}"> </script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amchart/animated.js') }}"></script>

<!-- Chart code -->
<script>

$(document).ready(function() {

    table = $('#dataTable').DataTable({
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    	 });

});

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.PieChart);

// Add data
chart.data = {!!$topTen!!};

// Set inner radius
chart.innerRadius = am4core.percent(50);

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "persen";
pieSeries.dataFields.category = "cus_name";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;





// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv2", am4charts.XYChart);


// Add data
chart.data = {!!$employeeBranch!!};

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "type";
categoryAxis.renderer.grid.template.location = 0;


var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.inside = true;
valueAxis.renderer.labels.template.disabled = true;
valueAxis.min = 0;

// Create series
function createSeries(field, name) {

  // Set up series
  var series = chart.series.push(new am4charts.ColumnSeries());
  series.name = name;
  series.dataFields.valueY = field;
  series.dataFields.categoryX = "type";
  series.sequencedInterpolation = true;

  // Make it stacked
  series.stacked = true;

  // Configure columns
  series.columns.template.width = am4core.percent(60);
  series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";

  // Add label
  var labelBullet = series.bullets.push(new am4charts.LabelBullet());
  labelBullet.label.text = "{valueY}";
  labelBullet.locationY = 0.5;

  return series;
}

createSeries("localPersen", "Local");
createSeries("expatPersen", "Expatriate");

// Legend
chart.legend = new am4charts.Legend();
</script>

<script>
function handleSelect()
    {
        var customer = $('#customer').val();
        var year = $('#year').val();
        if (customer == 0 && year == 0) {
            window.location = "{{ URL::asset(env('APP_URL').'/hris/dashboard') }}";
        }else{
            window.location = "{{ URL::asset(env('APP_URL').'/hris/dashboard') }}?customer="+ customer +"&year="+ year;

        }
    }

    function get_modal(e)
            {
                $(".modal-content").html(`<div style="text-align: center"><h2><i class="fa fa-chevron-right-o-notch fa-spin fa-1x fa-fw"></i>
                <span>Loading...</span></h2>
            </div>`);
                linkObj = $(e);
                action = $(e).attr('dataaction');
                dataid = $(e).attr('dataid');
                var arr = dataid.split("|");

                var link = $('#link option:selected').text();
                var id = $(this).attr('data-column');

                if (action == 'detail') {
                    $('#modalAction').modal({backdrop: 'static', show: true, keyboard: false});
                    $.get("{{ URL::asset(env('APP_URL').'/hris/finance/payroll/approval/detail') }}",
                    {
                        link: link,
                        id: arr[0]
                    },
                    function (data) {
                        $(".modal-content").html(data);
                    });
                }

            }
</script>
@endsection
