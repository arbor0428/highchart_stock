<!--chart1 시작-->
<canvas  id="Chart_c01" width='740' height='274' style='margin:0 auto;'></canvas>
<script>
	const data = [];
	let prev = 100;
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  data.push({x: i, y: prev});
	}

	const totalDuration = 950;
	const delayBetweenPoints = totalDuration / data.length;
	const previousY = (ctxc01) => ctxc01.index === 0 ? ctxc01.chart.scales.y.getPixelForValue(100) : ctxc01.chart.getDatasetMeta(ctxc01.datasetIndex).data[ctxc01.index - 1].getProps(['y'], true).y;



	var ctxc01 = document.getElementById('Chart_c01').getContext('2d');
	var myChartc01 = new Chart(ctxc01, {
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
	});

</script>
<!--chart1 끝-->


<!--chart2 시작-->
<canvas  id="Chart_c0102" width='740' height='274' style='margin:0 auto;'></canvas>
<script>
	const data2 = [];
	let prev2 = 100;
	for (let i = 0; i < 1000; i++) {
	  prev2 += 5 - Math.random() * 10;
	  data2.push({x: i, y: prev2});
	}

	const totalDuration2 = 950;
	const delayBetweenPoints2 = totalDuration2 / data2.length;
	const previousY2 = (ctxc0102) => ctxc0102.index === 0 ? ctxc0102.chart.scales.y.getPixelForValue(100) : ctxc0102.chart.getDatasetMeta(ctxc0102.datasetIndex).data[ctxc0102.index - 1].getProps(['y'], true).y;



	var ctxc0102 = document.getElementById('Chart_c0102').getContext('2d');
	var myChartc0102 = new Chart(ctxc0102, {
		  type: 'line',
		  data: {
			datasets: [{
			  borderColor: 'rgba(248, 106, 135, 1)',
			  borderWidth: 1.5,
			  radius: 0,
			  data: data2,
			}]
		  },
		  options: {
			animation: {
			  x: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints2,
					from: NaN, // the point is initially skipped
					delay(ctxc0102) {
					  if (ctxc0102.type !== 'data2' || ctxc0102.xStarted) {
						return 0;
					  }
					  ctxc0102.xStarted = true;
					  return ctxc0102.index * delayBetweenPoints2;
					}
				  },
				  y: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints2,
					from: previousY2,
					delay(ctxc0102) {
					  if (ctxc0102.type !== 'data2' || ctxc0102.yStarted) {
						return 0;
					  }
					  ctxc0102.yStarted = true;
					  return ctxc0102.index * delayBetweenPoints2;
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
<!--chart2 끝-->


<!--chart3 시작-->
<canvas  id="Chart_c0103" width='740' height='274' style='margin:0 auto;'></canvas>
<script>
	const data3 = [];
	let prev3 = 100;
	for (let i = 0; i < 1000; i++) {
	  prev3 += 5 - Math.random() * 10;
	  data3.push({x: i, y: prev3});
	}

	const totalDuration3 = 950;
	const delayBetweenPoints3 = totalDuration3 / data3.length;
	const previousY3 = (ctxc0103) => ctxc0103.index === 0 ? ctxc0103.chart.scales.y.getPixelForValue(100) : ctxc0103.chart.getDatasetMeta(ctxc0103.datasetIndex).data[ctxc0103.index - 1].getProps(['y'], true).y;



	var ctxc0103 = document.getElementById('Chart_c0103').getContext('2d');
	var myChartc0103 = new Chart(ctxc0103, {
		  type: 'line',
		  data: {
			datasets: [{
			  borderColor: 'rgba(248, 106, 135, 1)',
			  borderWidth: 1.5,
			  radius: 0,
			  data: data3,
			}]
		  },
		  options: {
			animation: {
			  x: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints3,
					from: NaN, // the point is initially skipped
					delay(ctxc0103) {
					  if (ctxc0103.type !== 'data3' || ctxc0103.xStarted) {
						return 0;
					  }
					  ctxc0103.xStarted = true;
					  return ctxc0103.index * delayBetweenPoints3;
					}
				  },
				  y: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints3,
					from: previousY3,
					delay(ctxc0103) {
					  if (ctxc0103.type !== 'data3' || ctxc0103.yStarted) {
						return 0;
					  }
					  ctxc0103.yStarted = true;
					  return ctxc0103.index * delayBetweenPoints3;
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
<!--chart3 끝-->


<!--chart4 시작-->
<canvas  id="Chart_c0104" width='740' height='274' style='margin:0 auto;'></canvas>
<script>
	const data4 = [];
	let prev4 = 100;
	for (let i = 0; i < 1000; i++) {
	  prev4 += 5 - Math.random() * 10;
	  data4.push({x: i, y: prev4});
	}

	const totalDuration4 = 950;
	const delayBetweenPoints4 = totalDuration4 / data4.length;
	const previousY4 = (ctxc0104) => ctxc0104.index === 0 ? ctxc0104.chart.scales.y.getPixelForValue(100) : ctxc0104.chart.getDatasetMeta(ctxc0104.datasetIndex).data[ctxc0104.index - 1].getProps(['y'], true).y;



	var ctxc0104 = document.getElementById('Chart_c0104').getContext('2d');
	var myChartc0104 = new Chart(ctxc0104, {
		  type: 'line',
		  data: {
			datasets: [{
			  borderColor: 'rgba(248, 106, 135, 1)',
			  borderWidth: 1.5,
			  radius: 0,
			  data: data4,
			}]
		  },
		  options: {
			animation: {
			  x: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints4,
					from: NaN, // the point is initially skipped
					delay(ctxc0104) {
					  if (ctxc0104.type !== 'data4' || ctxc0104.xStarted) {
						return 0;
					  }
					  ctxc0104.xStarted = true;
					  return ctxc0104.index * delayBetweenPoints4;
					}
				  },
				  y: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints4,
					from: previousY4,
					delay(ctxc0104) {
					  if (ctxc0104.type !== 'data4' || ctxc0104.yStarted) {
						return 0;
					  }
					  ctxc0104.yStarted = true;
					  return ctxc0104.index * delayBetweenPoints4;
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
<!--chart4 끝-->


<!--chart5 시작-->
<canvas  id="Chart_c0105" width='740' height='274' style='margin:0 auto;'></canvas>
<script>
	const data5 = [];
	let prev5 = 100;
	for (let i = 0; i < 1000; i++) {
	  prev5 += 5 - Math.random() * 10;
	  data5.push({x: i, y: prev5});
	}

	const totalDuration5 = 950;
	const delayBetweenPoints5 = totalDuration5 / data5.length;
	const previousY5 = (ctxc0105) => ctxc0105.index === 0 ? ctxc0105.chart.scales.y.getPixelForValue(100) : ctxc0105.chart.getDatasetMeta(ctxc0105.datasetIndex).data[ctxc0105.index - 1].getProps(['y'], true).y;



	var ctxc0105 = document.getElementById('Chart_c0105').getContext('2d');
	var myChartc0105 = new Chart(ctxc0105, {
		  type: 'line',
		  data: {
			datasets: [{
			  borderColor: 'rgba(248, 106, 135, 1)',
			  borderWidth: 1.5,
			  radius: 0,
			  data: data5,
			}]
		  },
		  options: {
			animation: {
			  x: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints5,
					from: NaN, // the point is initially skipped
					delay(ctxc0105) {
					  if (ctxc0105.type !== 'data5' || ctxc0105.xStarted) {
						return 0;
					  }
					  ctxc0105.xStarted = true;
					  return ctxc0105.index * delayBetweenPoints5;
					}
				  },
				  y: {
					type: 'number',
					easing: 'linear',
					duration: delayBetweenPoints5,
					from: previousY5,
					delay(ctxc0105) {
					  if (ctxc0105.type !== 'data5' || ctxc0105.yStarted) {
						return 0;
					  }
					  ctxc0105.yStarted = true;
					  return ctxc0105.index * delayBetweenPoints5;
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
<!--chart5 끝-->

