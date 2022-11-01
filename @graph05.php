<!--chart1시작--->
<canvas id="Chart_c02" width='500' height='216' style='margin: 10px auto;'></canvas>
<script>
	const ctxc02 = document.getElementById('Chart_c02').getContext('2d');
	const myChartc02 = new Chart(ctxc02, {
		type: 'line',
		data: {
			labels: ['0', '-30', '-40', '-60', '-80','-100'],
			datasets: [{
				label: [],
				data: [0, 20,40, 60, 80, 20],
				borderColor: 'rgba(248, 106, 135, 1)',
				borderWidth: 2.5,
			    pointRadius: 2.5
			}]
		},
		options: {
			plugins: {
				  legend: false,
				},
			scales: {
				y: {
					suggestedMin: 0,
					suggestedMax: 100
				}
			}
		}
	});
</script>
<!--chart1끝--->


<!--chart2시작--->
<canvas id="Chart_c0202" width='500' height='216' style='margin: 10px auto;'></canvas>
<script>
	const ctxc0202 = document.getElementById('Chart_c0202').getContext('2d');
	const myChartc0202 = new Chart(ctxc0202, {
		type: 'line',
		data: {
			labels: ['0', '-30', '-40', '-60', '-80','-100'],
			datasets: [{
				label: [],
				data: [0, 20,30, 60, 70, 20],
				borderColor: 'rgba(248, 106, 135, 1)',
				borderWidth: 2.5,
			    pointRadius: 2.5
			}]
		},
		options: {
			plugins: {
				  legend: false,
				},
			scales: {
				y: {
					suggestedMin: 0,
					suggestedMax: 100
				}
			}
		}
	});
</script>
<!--chart2끝--->



<!--chart3시작--->
<canvas id="Chart_c0203" width='500' height='216' style='margin: 10px auto;'></canvas>
<script>
	const ctxc0203 = document.getElementById('Chart_c0203').getContext('2d');
	const myChartc0203 = new Chart(ctxc0203, {
		type: 'line',
		data: {
			labels: ['0', '-30', '-40', '-60', '-80','-100'],
			datasets: [{
				label: [],
				data: [0, 30,40, 60, 90, 15],
				borderColor: 'rgba(248, 106, 135, 1)',
				borderWidth: 2.5,
			    pointRadius: 2.5
			}]
		},
		options: {
			plugins: {
				  legend: false,
				},
			scales: {
				y: {
					suggestedMin: 0,
					suggestedMax: 100
				}
			}
		}
	});
</script>
<!--chart3끝--->



<!--chart4시작--->
<canvas id="Chart_c0204" width='500' height='216' style='margin: 10px auto;'></canvas>
<script>
	const ctxc0204 = document.getElementById('Chart_c0204').getContext('2d');
	const myChartc0204 = new Chart(ctxc0204, {
		type: 'line',
		data: {
			labels: ['0', '-30', '-40', '-60', '-80','-100'],
			datasets: [{
				label: [],
				data: [0, 20,40, 70, 80, 10],
				borderColor: 'rgba(248, 106, 135, 1)',
				borderWidth: 2.5,
			    pointRadius: 2.5
			}]
		},
		options: {
			plugins: {
				  legend: false,
				},
			scales: {
				y: {
					suggestedMin: 0,
					suggestedMax: 100
				}
			}
		}
	});
</script>
<!--chart4끝--->



<!--chart5시작--->
<canvas id="Chart_c0205" width='500' height='216' style='margin: 10px auto;'></canvas>
<script>
	const ctxc0205 = document.getElementById('Chart_c0205').getContext('2d');
	const myChartc0205 = new Chart(ctxc0205, {
		type: 'line',
		data: {
			labels: ['0', '-30', '-40', '-60', '-80','-100'],
			datasets: [{
				label: [],
				data: [0, 20,40, 60, 80, 20],
				borderColor: 'rgba(248, 106, 135, 1)',
				borderWidth: 2.5,
			    pointRadius: 2.5
			}]
		},
		options: {
			plugins: {
				  legend: false,
				},
			scales: {
				y: {
					suggestedMin: 0,
					suggestedMax: 100
				}
			}
		}
	});
</script>
<!--chart5끝--->
