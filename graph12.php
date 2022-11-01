
<canvas id="Chart_c11" width='1195' height='200' style='position:relative; top: -10px; padding-left: 15px; margin: 0 auto'></canvas>
<script>
const data12 = [];
let prev12 = -100;
for (let i = 0; i < 500; i++) {
  prev12 += 5 - Math.random() * 10;
  data12.push({x: i, y: prev12});
}

const totalDuration12 = 10000;
const delayBetweenPoints12 = totalDuration12 / data12.length;
const previous01Y = (ctxc11) => ctxc11.index === 0 ? ctxc11.chart.scales.y.getPixelForValue(100) : ctxc11.chart.getDatasetMeta(ctxc11.datasetIndex).data12[ctxc11.index - 1].getProps(['y'], true).y;


var ctxc11 = document.getElementById('Chart_c11').getContext('2d');
var myChartc11 = new Chart(ctxc11, {
	  type: 'line',
	  data: {
		datasets: [{
			backgroundColor: 'rgba(247, 207, 254, 1)',
		  borderColor: 'rgba(235, 157, 249, 1)',
		  borderWidth: 1,
		  radius: 0,
		  data: data12,
		  fill: true,
		}]
	  },
	  options: {
		animation: {
		  x: {
				type: 'number',
				easing: 'linear',
				duration: delayBetweenPoints12,
				from: NaN, // the point is initially skipped
				delay(ctxc11) {
				  if (ctxc11.type !== 'data' || ctxc11.xStarted) {
					return 0;
				  }
				  ctxc11.xStarted = true;
				  return ctxc11.index * delayBetweenPoints12;
				}
			  },
			  y: {
				type: 'number',
				easing: 'linear',
				duration: delayBetweenPoints12,
				from: previous01Y,
				delay(ctxc11) {
				  if (ctxc11.type !== 'data' || ctxc11.yStarted) {
					return 0;
				  }
				  ctxc11.yStarted = true;
				  return ctxc11.index * delayBetweenPoints12;
				}
			  }
		},
		animation: {
			duration: 0
		},
	    responsive: false,
		interaction: {
		  intersect: false, // 주석 표시 안함
		},
		plugins: {
		  legend: false, // x축 표시 안함
		},
		scales: {

		  x: {
			type: 'linear'
		  },
			y: {
			      ticks: {
					  // y축 단위 설정
					  stepSize: 10,
					suggestedMax: -1,
				    suggestedMin: -200,
				},
			}
		}
	  }
});

</script>