<div id="<?=$graphID?>" style="margin: 0 auto; width: 260px; height: 260px; "></div>
<script>
	$(function () {
		Highcharts.chart('<?=$graphID?>', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie',
				spacingTop: 0,
				spacingRight: 0,
				spacingLeft: 0,
				events: {
					load: function() {
						var chart = this,
					/*
						value = 0;
						chart.series[0].yData.forEach(function(point, index) {
							if(index == 0){
								value += point;
							}
						});
					*/

						value = "<?=$cirTitle?>";
						
						//파이챠트 중간에 텍스트 추가 후 상,하 센터정렬
						chart.renderer.text(value, null, null, chart.resetZoom, {
							}).attr({
							   align: 'center',
							   verticalAlign: 'middle'
							}).add().css({fontSize: '13px'}).align({
							   align: 'center',
							   verticalAlign: 'middle',
							   x: 0,
							   y: -10
							}, false, null);
						
					}
				}
			},
			title: {
				text: ''
			},
			plotOptions: {
			  pie: {
				innerSize: '50%',
			   colors: [<?=$pieColorTxt?>],
                allowPointSelect: false,
                cursor: 'pointer',
                dataLabels: {
					enabled:false,
					distance: -30,
					format: '{y}',
					color: '#fff',
                style: {
					fontSize:'16',
                    fontWeight: 'bold',
					textOutline: 'none'
                }
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
			  data: [<?=$pieDataTxt?>]
			}]
		});
	});
</script>