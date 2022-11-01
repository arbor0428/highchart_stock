<div id="analyst_cir" style="margin: 0 auto; width: 150px; height: 150px; "></div>
<script>
	$(function () {
		Highcharts.chart('analyst_cir', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie',
				spacingTop: 0,
				spacingRight: 0,
				spacingLeft: 0
			},
			title: {
				text: ''
			},
			plotOptions: {
			  pie: {
				innerSize: '50%',
			   colors: [
				 '#4bc0c0', 
				 '#36a2eb',
				'#ffcd56'
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
				['주주 (기관,내부자)', <?=$per01?>],
				['펀드, ETF 등', <?=$per02?>],
				['개인 투자자, 기타', <?=$per03?>],
			  ]
			}]
		});
	});
</script>