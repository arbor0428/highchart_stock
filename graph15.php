<canvas id="Chart_c0102" width='700' height='260' style='margin:0 auto;'></canvas>
<script>
	const data = [];
	let prev = 100;
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  data.push({x: i, y: prev});
	}

	const totalDuration = 950;
	const delayBetweenPoints = totalDuration / data.length;
	const previousY = (ctxc0102) => ctxc0102.index === 0 ? ctxc0102.chart.scales.y.getPixelForValue(100) : ctxc0102.chart.getDatasetMeta(ctxc0102.datasetIndex).data[ctxc0102.index - 1].getProps(['y'], true).y;



	var ctxc0102 = document.getElementById('Chart_c0102').getContext('2d');
	var myChartc01 = new Chart(ctxc0102, {
		  type: 'line',
		  data: {
			datasets: [{
			  borderColor: 'rgba(248, 106, 135, 1)',
			  borderWidth: 1.5,
			  radius: 0,
			  data: data,
			}]
		  },
		  options: {
			animation: {
			  x: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints,
					from: NaN, // the point is initially skipped
					delay(ctxc0102) {
					  if (ctxc0102.type !== 'data' || ctxc0102.xStarted) {
						return 0;
					  }
					  ctxc0102.xStarted = true;
					  return ctxc0102.index * delayBetweenPoints;
					}
				  },
				  y: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints,
					from: previousY,
					delay(ctxc0102) {
					  if (ctxc0102.type !== 'data' || ctxc0102.yStarted) {
						return 0;
					  }
					  ctxc0102.yStarted = true;
					  return ctxc0102.index * delayBetweenPoints;
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
	});

</script>