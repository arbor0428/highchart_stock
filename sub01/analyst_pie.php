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
			   colors:[<?=$pieColorTxt?>],
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

			navigation: {
				bindingsClassName: 'tools-container-analyst_pie<?=$k?>' //주식 네비게이션 이름(여러 그래프 이용시 전체화면 오류 해결)
			},
			stockTools: {
				gui: {
					enabled: false //주식 네비게이션 사용여부
				}
			},
			series: [{
			  data: [<?=$pieDataTxt?>]
			}]
		});
	});
</script>