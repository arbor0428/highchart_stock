<div id="priceChart01" style="margin-top: 15px; width: 100%; height: 60px;"></div>
<script>
		Highcharts.chart('priceChart01', {
			chart: {
				type: 'spline',
				width: 120,
				spacingTop: 0,
				spacingRight: 0,
				spacingLeft: 0
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: ['1', '2', '3', '4', '5', '6'],
				labels: {
					style: {
						fontSize: '7'
					}
				}
			},
			yAxis: {
				title: {
					text: ''
				},
				labels: {
					style: {
						fontSize: '6'
					}
				},
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
				name: '',
				data: [0, 40,20, 60, 80, 80],
				color: '#f86a87',
				  marker: {
					enabled: true,
					radius: 0,
					symbol: 'dot'
				  }
			}]
		});
</script>