<?
if($graphID){
?>
<div id="<?=$graphID?>" style="margin-top: 15px; width: 100%; height: 60px;"></div>
<script>
		Highcharts.chart('<?=$graphID?>', {
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
				categories: [<?=$xAxisList?>],
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
				data: [<?=$dataList?>],
				color: '#f86a87',
				  marker: {
					enabled: true,
					radius: 0,
					symbol: 'dot'
				  }
			}]
		});
</script>
<?
}
?>