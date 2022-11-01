<?
$cData = Array();

$row = sqlArray("select * from api_Historical_Market_Cap where symbol='".$gbl_symbol."' order by atTime");
foreach($row as $v){
	$atDate = $v['atDate'];
	$cData[$atDate] = $v['marketCapitalization'];
}
?>
<h3 class="sub_tit">Historical Market Cap</h3>
<div id="HistoricalMarketCapGraph" style="width: 1280px; height: 400px; "></div>
<script>
$(function () {
	//첫번째 데이터 값
	let DataList = [];
<?
	foreach($cData as $k => $v){
?>
	str = "<?=$k?>";
	strArr = str.split('-');
	xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

	DataList.push({x: xData, y: <?=$v?>});
<?
	}
?>

	Highcharts.chart('HistoricalMarketCapGraph', {
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

		navigator: {
			enabled: true      
		},

		navigation: {
			bindingsClassName: 'tools-container-detail' //주식 네비게이션 이름(여러 그래프 이용시 전체화면 오류 해결)
		},
		stockTools: {
			gui: {
				enabled: false //주식 네비게이션 사용여부
			}
		},

		series: [{
			type: 'spline',
			name: '<?=$label01?>',
			id: 'series-1',
			data: DataList, //첫번째 데이터값
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
		}]
	});
});
</script>