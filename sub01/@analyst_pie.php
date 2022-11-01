<div id="analyst_pie<?=$k?>" style="width: 80px; height: 60px; "></div>
<script>
	$(function () {
		Highcharts.chart('analyst_pie<?=$k?>', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie',
				spacingTop: 0,
				spacingBottom: 0,
				spacingRight: 0,
				spacingLeft: 0
			},
			title: {
				text: ''
			},
			tooltip: {
			  enabled: false
			  },
			plotOptions: {
			  series:  {
				states: {
					hover: {
						enabled: false
					}
					}
			  },
			  pie: {
				innerSize: '0%',
			   colors: [
				 '#ff6384', 
				 '#ff9f40', 
				 '#ffcd56', 
				 '#4bc0c0', 
				 '#36a2eb'
			   ],
                allowPointSelect: false,
                cursor: 'pointer',
                dataLabels: {
					enabled: false
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
			  data: [
				['강력매도', 5],
				['매도', 10],
				['중립', 2],
				['매수', 20],
				['강력매수', 15]
			  ]
			}]
		});
	});
</script>