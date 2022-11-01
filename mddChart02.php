<div id="mddGraph02" style="margin-top: 20px; width: 500px; height: 250px; "></div>
<script>
$(function () {

	cData02 = "<?=$cData02?>";
	hpp = cData02.split(',');
	dataCnt = "<?=$max_percent?>";

	let hppData = [];
	for (let i = 0; i < dataCnt; i++) {
	  hppprev = parseFloat(hpp[i]);
	  hppData.push({x: i, y: hppprev});
	}


	const chartcom = Highcharts.chart('mddGraph02', {
		chart: {
			type:'line',
		},
		title: {
			text: ''			
		},
		xAxis: {
			title: {
				text: '고점대비 하락률(%)'
			},
			crosshair: true,
			tickInterval: 2,
//			categories: ['5','10','15','20','25','30','35','40','45','50','55','60','65','70','75','80','85','90','95','100']
		},
		yAxis: {
			title: {
				text: '상승확률(%)'
			},
			max: 100,
			crosshair: true,
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
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
			series: {
				borderRadius: 5
			}
		},
		series: [{
			showInLegend: false,
			name: '<?=$mddSymbol?>',
			data: hppData,
			color: '#f86a87',
			marker: {
				enabled: true,
				radius: 0,
				symbol: 'dot'
			}

		}]
	});
});
</script>