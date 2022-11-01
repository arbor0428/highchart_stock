<p style="margin: 50px 0 15px 0; padding: 0 0 0 40px;">※ 월간 예상 배당금 분포 (단위: USD)</p>
<div id="expectMonth" style="width: 615px; height: 260px; "></div>
<script>
		Highcharts.chart('expectMonth', {
			chart: {
				type: 'column'
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
				labels: {
					style: {
						fontSize: '14'
					}
				}
			},
			yAxis: {
				title: {
					text: ''
				},
				labels: {
					style: {
						fontSize: '14'
					}
				}
			},
			legend: {
				enabled: false
			},
			  plotOptions: {
				series: {
				  borderWidth: 0,
				  dataLabels: {
					enabled: true,
					format: '{y}'
				  }
				}
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
				data: [<?=$lineData?>],
				color: '#0c1540'
			}]
		});
</script>