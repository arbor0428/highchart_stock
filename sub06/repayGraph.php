<div id="repaygraph"></div>

<script>
$(function(){
	repayGap = "<?=$repayData02?>";
	var repayGapArr = repayGap.split(',');

	const repayGraph = Highcharts.chart('repaygraph', {
		title: {
			text: ''
		},
		xAxis: {
			categories: [<?=$repayX?>],
            min: 0,
            max: <?=$cashGraphNum?>,
			scrollbar: {
				enabled: true
			},
			tickLength : 0
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
		navigator: {
			enabled: false
		},
		rangeSelector:{
			enabled:false
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
			 type: 'column',
			data: [<?=$repayData01?>],
			color: '#36a2eb',
			dataLabels: {
			  enabled: true,
			  color: '#36a2eb',
			  formatter: function() {
				if (this.y != 0) {
					p = repayGapArr[this.point.index];
					if(p){
						return "<span>"+p+"%</span>";
					}else{
						return '';
					}
				}
			  },
			  y: -1,
			  style: {
				fontSize: '13px',
				textOutline: false 
			  }
			}
		}]
	});
});
</script>