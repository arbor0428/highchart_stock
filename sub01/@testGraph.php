	<div class="chart_label">
		<div class="label01">
			<div class="line"></div>
			<span>전통은행(XLF)</span>
		</div>
		<div class="label02">
			<div class="line"></div>
			<span>S&P 500</span>
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
	<div id="whosbetter02" style="width: 780px; height: 170px; "></div>
<script>
	$(function () {
		Highcharts.chart('whosbetter02', {
			chart: {
				type:'line',
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			yAxis: {
				title: {
					text: ''
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
				name: '전통은행',
				data: [0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80],
				color: '#f86a87',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			}, {
				name: 'S&P500',
				data: [20, 20,40, 80, 70, 60, 20, 20,40, 100, 70, 60],
				color: '#39a1e8',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			}]
		});
	});
</script>