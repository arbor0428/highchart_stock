<div class="updownPercent">
	<div id="snpMddGraph02" style="margin-top: 20px; width: 500px; height: 250px; "></div>
</div>
<script>
$(function () {
	//첫번째 데이터 값
	datav = "<?=$aData02?>";
	hpp = datav.split(',');
	dataCnt = "<?=$max_percent?>";

	let mddgraphFirst = [];
	for (let i = 0; i < dataCnt; i++) {
	  hppprev = parseFloat(hpp[i]);
	  mddgraphFirst.push({x: i, y: hppprev});
	}

	//두번째 데이터 값
	datav = "<?=$bData02?>";
	hpp = datav.split(',');

	let mddgraphSecond = [];
	for (let i = 0; i < dataCnt; i++) {
	  hppprev = parseFloat(hpp[i]);
	  mddgraphSecond.push({x: i, y: hppprev});
	}

	Highcharts.chart('snpMddGraph02', {
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
		legend: {
			enabled: false
		},
		  exporting: {
			enabled: false
		  },
		credits: {
			 enabled: false
		},
		series: [{
			showInLegend: false,
			name: '<?=$snpMddSymbol01?>',
			id: 'series-1',
			data: mddgraphFirst,
			color: '#f86a87',
			  marker: {
				enabled: true,
				radius: 0,
				symbol: 'dot'
			  }
		}, {
			name: 'S&P 500',
			id: 'series-2',
			data: mddgraphSecond,
			color: '#39a1e8',
			  marker: {
				enabled: true,
				radius: 0,
				symbol: 'dot'
			  }
		}]
	});
});
</script>