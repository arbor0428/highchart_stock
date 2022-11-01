<div class="chart_label">
	<div class="label01">
		<div class="line"></div>
		<span><?=$label01?></span>
	</div>
	<div class="label02">
		<div class="line"></div>
		<span><?=$label02?></span>
	</div>
</div>
<style>
	.chart_label {margin-bottom: 20px; display: flex; flex-wrap: wrap; justify-content: right;}
	.chart_label > div {display: flex; flex-wrap: wrap; margin: 0 5px;}
	.chart_label .line {position:relative; top: 8px; margin-right: 10px; width: 30px; height: 6px;}
	.chart_label span {font-size: 18px; font-weight: 700;}
	.chart_label .label01 .line {background-color: #f86a87;}
	.chart_label .label02 .line {background-color: #39a1e8;}
</style>
<?
if(!$graphWidth)	$graphWidth = '627px';
if(!$graphHeight)	$graphHeight = '240px';
?>
<div class="graph02" id="<?=$graphID?>" style="width: <?=$graphWidth?>; height: <?=$graphHeight?>; "></div>
<script>
$(function () {
	//첫번째 데이터 값
	let DataList01 = [];
<?
	foreach($cData01 as $k => $v){
?>
	str = "<?=$k?>";
	strArr = str.split('-');
	xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

	DataList01.push({x: xData, y: <?=$v?>});
<?
	}
?>

	//두번째 데이터 값
	let DataList02 = [];
<?
	foreach($cData02 as $k => $v){
?>
	str = "<?=$k?>";
	strArr = str.split('-');
	xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

	DataList02.push({x: xData, y: <?=$v?>});
<?
	}
?>

	Highcharts.chart('<?=$graphID?>', {
		chart: {
			type:'line'
		},
		title: {
			text: ''
		},
		xAxis: {
			type: 'datetime',
			crosshair: true,
			labels: {
				formatter: function() {
					return Highcharts.dateFormat('%b %Y', this.value);
				}
			}
		},
		yAxis: {
			title: {
				text: ''
			},
			crosshair: true,
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		rangeSelector:{
			enabled:true
		},
		tooltip: {
			xDateFormat: '%Y',
			shared: true,
			formatter: function () {
				var s = '<b>' + Highcharts.dateFormat('%Y.%m.%d', this.x) + '</b>';
				$.each(this.points, function (idx, point) {
					s += "<br/><span style='color: #000;'>" + this.series.name +" : "+ point.y  +"</span>";
				});
				return s;
			}
		},
		  exporting: {
			enabled: false
		  },
		legend: {
			enabled: false
		},
		credits: {
			 enabled: false
		},
		plotOptions: {
			area: {
				marker: {
					radius: 2
				},
				lineWidth: 1,
			},
			series: {
				turboThreshold:10000,
				label: {
					enabled: false
				}
			}
		},

		series: [{
			type: 'spline',
			name: '<?=$label01?>',
			id: 'series-1',
			data: DataList01, //첫번째 데이터값
			color: '#f86a87',
			fillColor: {
				linearGradient: {
					x1: 0,
					y1: 0,
					x2: 0,
					y2: 1
				},
				stops: [
					[0, 'rgb(248,106,135,0.7)'],
					[1, 'rgb(255,255,255,0.5)']
				]
			}
		}, {
			type: 'spline',
			name: '<?=$label02?>',
			id: 'series-2',
			data: DataList02,  //두번째 데이터값
			fillColor: {
				linearGradient: {
					x1: 0,
					y1: 0,
					x2: 0,
					y2: 1
				},
				stops: [
					[0, 'rgb(57,161,232,0.7)'],
					[1, 'rgb(255,255,255,0.5)']
				]
			}
		}]
	});
});
</script>

<style>
.highcharts-input-group {display: none;}
.joo_wrap .joo_bottom {margin-top: 50px; height: 180px;}
.chart_label {position: absolute; top:0; right: 0; z-index: 33;}
.graph02 {position: absolute; top: 0;}
</style>