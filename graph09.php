<?
$pieColorTxt = '';		//그래프 색상
$pieDataTxt = '';		//그래프 값

for($p=0; $p<count($pieColor); $p++){
	if($p > 0){
		$pieColorTxt .= ",";
		$pieDataTxt .= ",";
	}

	$pieColorTxt .= "'".$pieColor[$p]."'";
	$pieDataTxt .= "['".$pieData[$p][0]."',".$pieData[$p][1]."]";
}
?>

<div id="investGraph" style="margin: 0 auto; width: 260px; height: 260px; "></div>

<script>
$(function () {
	Highcharts.chart('investGraph', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: ''
		},
		plotOptions: {
			pie: {
				innerSize: '50%',
				colors:[<?=$pieColorTxt?>],
				allowPointSelect: false,
				cursor: 'pointer',
				dataLabels: {
					distance: -30,
					format: '{y}%',
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