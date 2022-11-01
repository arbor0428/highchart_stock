	<!--chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
	
	<!-- 	<script type="text/javascript" src="http://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script> -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<style>
	#Chart_c15 {width: 89% !important; height: 500px !important; margin: 0 auto;}
</style>

<canvas id="Chart_c15"></canvas>
<script>

	const ctxc15 = document.getElementById('Chart_c15').getContext('2d');
	const myChartc15 = new Chart(ctxc15, {
		data: {
			 labels:  ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'],
			  datasets: [
			{
				 type: 'line',
				label: [],
				data: [95, 109, 80, 91, 156, 155, 140,165, 159, 140, 161, 156, 155, 90],
				backgroundColor: [
				  'rgba(223, 146, 66, 0.5)',
				],
				borderColor: [
				  'rgba(223, 146, 66, 1)',
				],
                fill: false,
				 radius: 0,
				borderWidth: 2
			  },
			{
				type: 'bar',
				label: [],
				data: [65, 59, 40, 41, 56, 55, 40,65, 59, 40, 61, 56, 55, 40],
				backgroundColor: [
				  'rgba(213, 45, 31)',
				],
				borderColor: [
				  'rgb(213, 45, 31)',
				],
				borderWidth: 1
			  },
				{
				    type: 'bar',
					label: [],
					data: [35, 49, 60, 51, 46, 25, 30,55, 39, 60, 51, 56, 45, 20],
					backgroundColor: [
					  'rgba(101, 178, 66)',
					],
					borderColor: [
					  'rgba(101, 178, 66)',
					],
					borderWidth: 1
				},				
				{
				   type: 'bar',
					label: [],
					data: [45, 59, 50, 21, 46, 55, 30,55, 59, 50, 31, 56, 55, 40],
					backgroundColor: [
					  'rgb(213, 45, 31)',
					],
					borderColor: [
					  'rgb(213, 45, 31)',
					],
					borderWidth: 1
				},
				{
				   type: 'bar',
					label: [],
					data: [35, 49, 60, 21, 46, 25, 30,55, 39, 60, 21, 36, 45, 20],
					backgroundColor: [
					  'rgba(101, 178, 66)',
					],
					borderColor: [
					  'rgba(101, 178, 66)',
					],
					borderWidth: 1
				},
				{
				   type: 'bar',
					label: [],
					data: [25, 49, 50, 71, 36, 45, 20,35, 49, 20, 61, 16, 35, 50],
					backgroundColor: [
					  'rgba(101, 178, 66)',
					],
					borderColor: [
					  'rgba(101, 178, 66)',
					],
					borderWidth: 1
				},
				{
				   type: 'bar',
				 	label: [],
					data: [65, 59, 40, 41, 56, 55, 40,65, 59, 50, 21, 56, 55, 40],
					backgroundColor: [
					  'rgb(213, 45, 31)',
					],
					borderColor: [
					 'rgb(213, 45, 31)',
					],
					borderWidth: 1
				},
				{
				    type: 'bar',
					label: [],
					data: [45, 29, 60, 41, 36, 25, 30,25, 49, 60, 41, 26, 15, 30],
					backgroundColor: [
					  'rgb(213, 45, 31)',
					],
					borderColor: [
					  'rgb(213, 45, 31)',
					],
					borderWidth: 1
				},
				{
				type: 'bar',
				label: [],
				data: [65, 59, 30, 21, 56, 55, 40,65, 59, 40, 61, 56, 55, 40],
				backgroundColor: [
				  'rgba(213, 45, 31)',
				],
				borderColor: [
				  'rgb(213, 45, 31)',
				],
				borderWidth: 1
			  },
			 {
				   type: 'bar',
					label: [],
					data: [35, 49, 60, 21, 46, 25, 30,55, 39, 60, 21, 16, 45, 20],
					backgroundColor: [
					  'rgba(101, 178, 66)',
					],
					borderColor: [
					  'rgba(101, 178, 66)',
					],
					borderWidth: 1
				},				
				{
				    type: 'bar',
					label: [],
					data: [45, 59, 30, 51, 16, 55, 30,55, 59, 50, 31, 56, 55, 40],
					backgroundColor: [
					  'rgb(213, 45, 31)',
					],
					borderColor: [
					  'rgb(213, 45, 31)',
					],
					borderWidth: 1
				},
				{
				   type: 'bar',
					label: [],
					data: [35, 49, 60, 51, 46, 25, 30,55, 39, 60, 51, 46, 45, 20],
					backgroundColor: [
					  'rgba(101, 178, 66)',
					],
					borderColor: [
					  'rgba(101, 178, 66)',
					],
					borderWidth: 1
				},
				{
				    type: 'bar',
					label: [],
					data: [25, 69, 50, 71, 16, 45, 20,35, 49, 70, 61, 16, 35, 50],
					backgroundColor: [
					  'rgba(101, 178, 66)',
					],
					borderColor: [
					  'rgba(101, 178, 66)',
					],
					borderWidth: 1
				},
				
		     ]
		},
		options: {
			plugins: {
				  legend: false,
				  responsive: false,
				},
				categoryPercentage : 0.9,
			    barPercentage : 0.5,
			scales: {
				y: {
					beginAtZero: true,
					suggestedMin: 0,
					suggestedMax: 70,
				}
			}
		}
	});
</script>