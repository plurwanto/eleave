@extends('layout.main')

@section('title', 'Dashboard')

@section('css')
<!-- Font Awesome -->
<link href="{{ URL::asset(env('PUBLIC_PATH').'css/font-awesome.min.css') }}" rel="stylesheet">
<!-- NProgress -->
<link href="{{ URL::asset(env('PUBLIC_PATH').'css/nprogress.css') }}" rel="stylesheet">
<!-- iCheck -->
<link href="{{ URL::asset(env('PUBLIC_PATH').'css/iCheck/green.css') }}" rel="stylesheet">

<!-- bootstrap-progressbar -->
<link href="{{ URL::asset(env('PUBLIC_PATH').'css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
<!-- JQVMap -->
<link href="{{ URL::asset(env('PUBLIC_PATH').'css/jqvmap.min.css') }}" rel="stylesheet"/>
<!-- bootstrap-daterangepicker -->
<link href="{{ URL::asset(env('PUBLIC_PATH').'css/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ URL::asset(env('PUBLIC_PATH').'css/export.css') }}" rel="stylesheet">
@endsection

@section('content')

<style type="text/css">
	.chartdiv {
		width		: 100%;
		height		: 500px;
		font-size	: 11px;
		margin-bottom: 70px;
	}
</style>

<div id="document-chart">
	<input type="hidden" id="token" value="{{session('token')}}">
	<!-- top tiles -->
	<div class="row tile_count">
	    <div id="chart-model" class="chartdiv">
	    	
	    </div>
	    <div id="chart-detail" class="chartdiv">
	    	
	    </div>
	</div>
</div>

<!-- /top tiles -->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      
    </div>
</div>
<br />
@endsection

@section('script')
<!-- axios -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/axios.js') }}"></script>
<!-- Vue.js -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/vue.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/icheck.min.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/moment.min.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/daterangepicker.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/amcharts.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/serial.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/plugins/export/export.min.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/light.js') }}"></script>
<!-- PNotify -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/pnotify.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/pnotify.buttons.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/pnotify.nonblock.js') }}"></script>
<!-- vue config -->
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/config/config.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/document-chart.js') }}"></script>
<!-- <script>
	$(document).ready(function() {
			AmCharts.makeChart("chart-model", {
				"type": "serial",
			    "theme": "light",
				"categoryField": "month",
				"rotate": false,
				"startDuration": 1,
				"categoryAxis": {
					"gridPosition": "start",
					"position": "bottom"
				},
				"trendLines": [],
				"graphs": [
					{
						"balloonText": "Approved:[[value]]",
						"fillAlphas": 0.8,
						"id": "AmGraph-1",
						"lineAlpha": 0.2,
						"title": "Approved",
						"type": "column",
						"valueField": "approved"
					},
					{
						"balloonText": "Non Approved:[[value]]",
						"fillAlphas": 0.8,
						"id": "AmGraph-2",
						"lineAlpha": 0.2,
						"title": "Non Approved",
						"type": "column",
						"valueField": "nonapproved"
					}
				],
				"guides": [],
				"valueAxes": [
					{
						"id": "ValueAxis-1",
						"position": "left",
						"axisAlpha": 0
					}
				],
				"allLabels": [],
				"balloon": {},
				"titles": [],
				"dataProvider": [
		        {
		            "month": "Jan",
		            "approved": 1,
		            "nonapproved": 1
		        },
		        {
		            "month": "Feb",
		            "approved": 1,
		            "nonapproved": 1
		        },
		        {
		            "month": "Mar",
		            "approved": 5,
		            "nonapproved": 1
		        }],
			    "export": {
			    	"enabled": true
			    },
			    "chartCursor": {
			        "fullWidth": true,
			        "cursorAlpha": 0.1,
			        "leaveCursor": true,
			      }
			});
	});
	
</script> -->
@endsection
