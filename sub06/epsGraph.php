<input type='hidden' name='epsTabNumber' id='epsTabNumber' value='<?=$epsTabNumber?>'>

<div class="epsShadow">
	<div class="benefitBtn dp_f">
		<div class="beBtn <?if(!$epsTabNumber){echo 'show';}?>">이익(EPS)</div>
		<div class="beBtn <?if($epsTabNumber){echo 'show';}?>">매출</div>
	</div>


	<div class="benefitWrap">

		<div class="benefitGraph" <?if($epsTabNumber){echo "style='display:none;'";}?>>
			<ul class="legendWrap dp_f">
				<li class="dp_f dp_c">
					<span class="sqre grr"></span>
					<span>예상이익<br>(컨센서스)</span>
				</li>
				<li class="dp_f dp_c">
					<span  class="sqre ora"></span>
					<span>실제이익<br>(컨센대비 상승하락폭)</span>
				</li>
			</ul>
			<div id="epsAnalysis" style="min-width: 1240px; margin: 0 auto;"></div>
		</div>

		<div class="benefitGraph" <?if(!$epsTabNumber){echo "style='display:none;'";}?>>
			<ul class="legendWrap dp_f">
				<li class="dp_f dp_c">
					<span class="sqre grr"></span>
					<span>예상매출<br>(컨센서스)</span>
				</li>
				<li class="dp_f dp_c">
					<span  class="sqre ora"></span>
					<span>실제매출<br>(컨센대비 상승하락폭)</span>
				</li>
			</ul>
			<div id="salesAnalysis" style="min-width: 1240px; margin: 0 auto;"></div>
		</div>

	</div>
</div>



<script>

$(function () {
	//이익(EPS) 증감율
	epsGap = "<?=$epsData03?>";
	var epsGapArr = epsGap.split(',');

	//이익(EPS) 증감율(미래 데이터용)
	epsGap2 = "<?=$epsData04?>";
	var epsGap2Arr = epsGap2.split(',');

	//매출 증감율
	revenueGap = "<?=$revenueData03?>";
	var revenueGapArr = revenueGap.split(',');

	//매출 증감율(미래 데이터용)
	revenueGap2 = "<?=$revenueData04?>";
	var revenueGap2Arr = revenueGap2.split(',');

	$(".benefitBtn > div").on("click",function(event){
		event.preventDefault();
		
		let tabNumber = $(this).index();

		$(".benefitBtn > div").removeClass("show");
		$(this).addClass("show");

		$(".benefitWrap > div").hide();
		$(".benefitWrap > div").eq(tabNumber).show();

		$('#epsTabNumber').val(tabNumber);
	});


	const epsGraph = Highcharts.chart('epsAnalysis', {
		chart: {
			type:'column',
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: [<?=$epsX?>],
            min: 0,
            max: <?=$epsGraphNum?>,
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
			name: '예상이익',
			data: [<?=$epsData01?>],
			color: '#179da5',
			dataLabels: {
			  enabled: true,
			  color: '#ff0000',
			  formatter: function() {
				if (this.y != 0) {
					p = epsGap2Arr[this.point.index];
					if(p){
						return "<span>"+p+"%</span>";
					}else{
						return '';
					}
				}
			},
			  y: -10,
			  style: {
				fontSize: '13px',
				textOutline: false 
			  }
			},
		}, 
		{
			name: '실제이익',
			data: [<?=$epsData02?>],
			color: '#f66110',
			dataLabels: {
			  enabled: true,
			  color: '#ff0000',
			  formatter: function() {
				if (this.y != 0) {
					p = epsGapArr[this.point.index];
					if(p){
						return "<span>"+p+"%</span>";
					}else{
						return '';
					}
				}
			},
			  y: -10,
			  style: {
				fontSize: '13px',
				textOutline: false 
			  }
			},
		}]
	});

	const salesGraph = Highcharts.chart('salesAnalysis', {
		chart: {
			type:'column',
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: [<?=$revenueX?>],
            min: 0,
            max: <?=$epsGraphNum?>,
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
			name: '예상매출',
			data: [<?=$revenueData01?>],
			color: '#179da5',
			dataLabels: {
			  enabled: true,
			  color: '#ff0000',
			  formatter: function() {
				if (this.y != 0) {
					p = revenueGap2Arr[this.point.index];
					if(p){
						return "<span>"+p+"%</span>";
					}else{
						return '';
					}
				}
			},
			  y: -10,
			  style: {
				fontSize: '13px',
				textOutline: false 
			  }
			},

		}, 
		{
			name: '실제매출',
			data: [<?=$revenueData02?>],
			color: '#f66110',
			dataLabels: {
			  enabled: true,
			  color: '#ff0000',
			  formatter: function() {
				if (this.y != 0) {
					p = revenueGapArr[this.point.index];
					if(p){
						return "<span>"+p+"%</span>";
					}else{
						return '';
					}
				}
			},
			  y: -10,
			  style: {
				fontSize: '13px',
				textOutline: false 
			  }
			},
		}]
	});


/*
//1년
	$("#oneyear").on("click",function(event){
		epsGraph.series[0].setData([20, 20,40, 80, 70, 60, 20, 20,40, 100, 70, 60]);
		epsGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);

		salesGraph.series[0].setData([20, 20,40, 80, 70, 60, 20, 20,40, 100, 70, 60,10, 10, 10, 10]);
		salesGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);

		event.preventDefault();
	});

//3년
	$("#threeyear").on("click",function(event){
		epsGraph.series[0].setData([20, 20,40, 80, 70, 60, 20, 20,40, 100, 70, 60,10, 10, 10, 10]);
		epsGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);

		salesGraph.series[0].setData([20, 20,40, 80, 70, 60, 20, 20,40, 100, 70, 60]);
		salesGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);
		
		event.preventDefault();
	});

//5년
	$("#fiveyear").on("click",function(event){
		epsGraph.series[0].setData([20, 20,40, 80, 70, 60, 20, 20,40, 100, 70, 60]);
		epsGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);

		salesGraph.series[0].setData([]);
		salesGraph.series[1].setData([]);

		event.preventDefault();
	});

//10년
	$("#tenyear").on("click",function(event){

		epsGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		epsGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);

		salesGraph.series[0].setData([]);
		salesGraph.series[1].setData([]);

		event.preventDefault();
	});

//분기
	$("#quarterBtn").on("click",function(event){

		epsGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		epsGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);

		salesGraph.series[0].setData([]);
		salesGraph.series[1].setData([]);

		$(".twoKindWrap > div").removeClass("on");
		$(this).addClass("on");

		event.preventDefault();
	});

//연간
	$("#yearlyBtn").on("click",function(event){
		epsGraph.series[0].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80,10, 10, 10, 10]);
		epsGraph.series[1].setData([0, 40,20, 60, 80, 80,0, 40,20, 60, 80, 80]);			

		salesGraph.series[0].setData([]);
		salesGraph.series[1].setData([]);
		
		$(".twoKindWrap > div").removeClass("on");
		$(this).addClass("on");

		event.preventDefault();
	});
*/
});
</script>

<!--
{y:1,dataLabels: {color: '#000'}}
-->