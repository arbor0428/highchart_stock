<!--chart1 시작-->

<div class="tabBtn">
	<button class="on" id="addData01">Chart1</button>
	<button id="addData02">Chart2</button>
	<button id="addData03">Chart3</button>
	<button id="addData04">Chart4</button>
	<button id="addData05">Chart5</button>
</div>

<style>
	.tabBtn {
		display: flex;
		flex-wrap: wrap;
		box-sizing: border-box;
		border-bottom: 1px solid #e26f12;
		width: 95%;
		margin: 0 auto 30px; 
	}
	.tabBtn button {
		position: relative;
		border-radius: 5px 5px 0 0;
		border-top: 1px solid #e26f12;
		border-right: 1px solid #e26f12;
		border-left: 1px solid #e26f12;
		margin-right: 5px;
		background-color: transparent;
		width: 80px;
		height: 45px;
		line-height: 45px;
		text-align: center;
		font-size: 15px;
		color: #0c1540;
		font-weight: 700;
		cursor: pointer;
	}
	.tabBtn button.on {    
		color: #fff;
		background-color: #e26f12;
	}

	.tabBtn button::after {
		display: block;
		content: "";
		position: absolute;
		bottom: -1px;
		left: 0;
		width: 101%;
		height: 1px;
		background-color: #fff;
	}

	.tabBtn button.on::after {
		background-color: #e26f12;
	}

</style>

<script>
	$(".tabBtn > button").click(function(event){
		event.preventDefault();

		let tabNumber = $(this).index();

		$(".tabBtn > button").removeClass("on");
		$(this).addClass("on");

	});

</script>

<canvas  id="Chart_c01" width='740' height='274' style='margin:0 auto;'></canvas>
<script>
	let data = [];
	let prev = 100;
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  data.push({x: i, y: prev});
	}
	
	let datazero = [];
	for (let i = 0; i < 1000; i++) {
	  prev =0;
	  datazero.push({x: i, y: prev});
	}

	let dataSecond = [];
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  dataSecond.push({x: i, y: prev});
	}

	let dataThird = [];
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  dataThird.push({x: i, y: prev});
	}

	let dataFourth = [];
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  dataFourth.push({x: i, y: prev});
	}

	let dataFifth = [];
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  dataFifth.push({x: i, y: prev});
	}

	let totalDuration = 950;
	let delayBetweenPoints = totalDuration / data.length;
	let previousY = (ctxc01) => ctxc01.index === 0 ? ctxc01.chart.scales.y.getPixelForValue(100) : ctxc01.chart.getDatasetMeta(ctxc01.datasetIndex).data[ctxc01.index - 1].getProps(['y'], true).y;



	var ctxc01 = document.getElementById('Chart_c01').getContext('2d');
	var config04 = {
		  type: 'line',
		 		data: {
			//labels: ['0', '-30', '-40', '-60', '-80','-100'],
			datasets: [
			{
				label: [],
				borderColor: 'rgba(248, 106, 135, 1)',
				borderWidth: 1,
			    pointRadius: 1,
				data: data
			},{
				label: [],
				borderColor: 'rgba(248, 106, 135, 0)',
				borderWidth: 0,
			    pointRadius: 0,
				data: datazero
			},{
				label: [],
				borderColor: 'rgba(248, 106, 135, 0)',
				borderWidth: 0,
			    pointRadius: 0,
				data: datazero
			},{
				label: [],
				borderColor: 'rgba(248, 106, 135, 0)',
				borderWidth: 0,
			    pointRadius: 0,
				data: datazero
			},{
				label: [],
				borderColor: 'rgba(248, 106, 135, 0)',
				borderWidth: 0,
			    pointRadius: 0,
				data: datazero
			}			
		 ]
		},
		  options: {
			animation: {
			  x: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints,
					from: NaN, // the point is initially skipped
					delay(ctxc01) {
					  if (ctxc01.type !== 'data' || ctxc01.xStarted) {
						return 0;
					  }
					  ctxc01.xStarted = true;
					  return ctxc01.index * delayBetweenPoints;
					}
				  },
				  y: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints,
					from: previousY,
					delay(ctxc01) {
					  if (ctxc01.type !== 'data' || ctxc01.yStarted) {
						return 0;
					  }
					  ctxc01.yStarted = true;
					  return ctxc01.index * delayBetweenPoints;
					}
				  }
			},
			interaction: {
			  intersect: false
			},
			plugins: {
			  legend: false
			},
			scales: {
			  x: {
				type: 'linear',
				title: {
				  display: true,
				  text: 'Date'
				}
			  },
				y: {
				title: {
				  display: true,
				  text: 'Value'
				}
			  }
			}
		  }
	};



	var Chart_c01 = new Chart(ctxc01, config04);

	//데이터 추가
	document.getElementById('addData01').onclick = function(){
		
		Chart_c01.data.datasets[1].data = dataSecond;
		Chart_c01.data.datasets[1].borderColor = 'rgba(248, 106, 135, 1)';
		Chart_c01.data.datasets[1].borderWidth = '1';
		Chart_c01.data.datasets[1].pointRadius = '1';

		Chart_c01.update();
	}

	document.getElementById('addData02').onclick = function(){

		Chart_c01.data.datasets[2].data = dataThird;
		Chart_c01.data.datasets[2].borderColor = 'rgba(248, 106, 135, 1)';
		Chart_c01.data.datasets[2].borderWidth = '1';
		Chart_c01.data.datasets[2].pointRadius = '1';


		Chart_c01.update();
	}

	document.getElementById('addData03').onclick = function(){
		
		Chart_c01.data.datasets[3].data = dataFourth;
		Chart_c01.data.datasets[3].borderColor = 'rgba(248, 106, 135, 1)';
		Chart_c01.data.datasets[3].borderWidth = '1';
		Chart_c01.data.datasets[3].pointRadius = '1';

		Chart_c01.update();
	}

	document.getElementById('addData04').onclick = function(){

		Chart_c01.data.datasets[4].data = dataFifth;
		Chart_c01.data.datasets[4].borderColor = 'rgba(248, 106, 135, 1)';
		Chart_c01.data.datasets[4].borderWidth = '1';
		Chart_c01.data.datasets[4].pointRadius = '1';

		Chart_c01.update();
	}

</script>
<!--chart1 끝-->


