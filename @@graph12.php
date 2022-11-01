
<style>
	#Chart_c11 {width: 91% !important; height: 350px !important; margin: 0 auto;}
</style>
<canvas id="Chart_c11"></canvas>
<script>
const data3 = [];
const data4 = [];
let prev3 = 80;
let prev4 = -100;
for (let i = 0; i < 1000; i++) {
  prev3 += 5 - Math.random() * 10;
  data3.push({x: i, y: prev3});
  prev4 += 5 - Math.random() * 10;
  data4.push({x: i, y: prev4});
}

const totalDuration02 = 10000;
const delayBetweenPoints02 = totalDuration02 / data3.length;
const previous01Y = (ctxc11) => ctxc11.index === 0 ? ctxc11.chart.scales.y.getPixelForValue(100) : ctxc11.chart.getDatasetMeta(ctxc11.datasetIndex).data3[ctxc11.index - 1].getProps(['y'], true).y;


var ctxc11 = document.getElementById('Chart_c11').getContext('2d');
var myChartc11 = new Chart(ctxc11, {
	  type: 'line',
	  data: {
		datasets: [{
		  borderColor: 'rgba(38, 198, 218, 1)',
		  borderWidth: 1,
		  radius: 0,
		  data: data3,
	  },
	{
	   //  yAxisID: 'y-b',
		 backgroundColor: 'rgba(247, 207, 254, 1)',
		  borderColor: 'rgba(235, 157, 249, 1)',
		  borderWidth: 1,
		  radius: 0,
		  data: data4,
		  fill: true,
		}]
	  },
	  options: {
		animation: {
		  x: {
				type: 'number',
				easing: 'linear',
				duration: delayBetweenPoints02,
				from: NaN, // the point is initially skipped
				delay(ctxc11) {
				  if (ctxc11.type !== 'data' || ctxc11.xStarted) {
					return 0;
				  }
				  ctxc11.xStarted = true;
				  return ctxc11.index * delayBetweenPoints02;
				}
			  },
			  y: {
				type: 'number',
				easing: 'linear',
				duration: delayBetweenPoints02,
				from: previous01Y,
				delay(ctxc11) {
				  if (ctxc11.type !== 'data' || ctxc11.yStarted) {
					return 0;
				  }
				  ctxc11.yStarted = true;
				  return ctxc11.index * delayBetweenPoints02;
				}
			  }
		},
		animation: {
			duration: 0
		},
		interaction: {
		  intersect: false
		},
		plugins: {
		  legend: false  // 주석 표시 안함
		},
		scales: {

		  x: {
			type: 'linear'
		  },
		// 'y-a' : {
			 // position: 'left',
		  	  //ticks: {
					   // y축 단위 설정
					//  stepSize: 100
				//},
		//  },
		// 'y-b' : {
			//  position: 'right',
		  	//	 ticks: {
					   // y축 단위 설정
					//  stepSize: 10
				//}
		//  }
		}
	  }
});

</script>