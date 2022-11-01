<?
/*
$cateList = "'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'";
$dataList = "0,40,20,60,80,80,30";
$LowList = "null,null,null,null,null,80,10";
$HighList = "null,null,null,null,null,80,50";
*/
?>

<div id="priceTargetGraph" style="width: 658px; height: 300px; margin: 13px auto;"></div>
<script>
	$(function () {
		Highcharts.chart('priceTargetGraph', {
			chart: {
				type:'line',
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: [<?=$cateList?>]
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
			credits: {
				 enabled: false
			},
		  exporting: {
			enabled: false
		  },
			series: [{
				showInLegend: false,
				name: 'Lowest ',
				data: [<?=$LowList?>],
				color: '#39a1e8',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			}, {
				name: 'Highest',
				data: [<?=$HighList?>],
				color: '#4bc0c0',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			}, {
				name: 'Average',
				data: [<?=$dataList?>],
				color: '#f86a87',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			}]
		});
	});
</script>