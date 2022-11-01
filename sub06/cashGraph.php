<div id="cashgraph"></div>

<script>
$(function(){
	cashGap = "<?=$cashData02?>";
	var cashGapArr = cashGap.split(',');

	const cashGraph = Highcharts.chart('cashgraph', {
		title: {
			text: ''
		},
		xAxis: {
			categories: [<?=$cashX?>],
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
			data: [<?=$cashData01?>],
			color: '#4bc0c0',
			dataLabels: {
			  enabled: true,
			  color: '#4bc0c0',
			  formatter: function() {
				if (this.y != 0) {
					p = cashGapArr[this.point.index];
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
		}, 
/*
		{
			name: '',
			  type: 'line',
			  marker: {
				enabled: true,
				radius: 0,
				symbol: 'dot'
			  },
			data: [<?=$cashData01?>],
			color: '#ff6384'
		}
*/
		]
	});
/*
//1년
	$("#oneyear02").on("click",function(event){
		//영업현금흐름
		cashGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		cashGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);
		//부채상환흐름
		repayGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);

		event.preventDefault();
	});
//3년
	$("#threeyear02").on("click",function(event){
		//영업현금흐름
		cashGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		cashGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);
		//부채상환흐름
		repayGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		
		event.preventDefault();
	});
//5년
	$("#fiveyear02").on("click",function(event){
		//영업현금흐름
		cashGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		cashGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);
		//부채상환흐름
		repayGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);

		event.preventDefault();
	});
//10년
	$("#tenyear02").on("click",function(event){
		//영업현금흐름
		cashGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		cashGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);
		//부채상환흐름
		repayGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);

		event.preventDefault();
	});


//분기
	$("#quarterBtn02").on("click",function(event){
		//영업현금흐름
		cashGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		cashGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);
		//부채상환흐름
		repayGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);


		$(".twoKindWrap > div").removeClass("on02");
		$(this).addClass("on02");

		event.preventDefault();
	});
//연간
	$("#yearlyBtn02").on("click",function(event){
		//영업현금흐름
		cashGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		cashGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);		
		//부채상환흐름
		repayGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		
		$(".twoKindWrap > div").removeClass("on02");
		$(this).addClass("on02");

		event.preventDefault();
	});
*/

});
</script>