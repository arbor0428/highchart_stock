
<canvas id="Chart_c14" width='1155' height='90' style='position: relative; top: -20px; padding-left: 15px; margin: 0 auto'></canvas>
<script>

	const ctxc14 = document.getElementById('Chart_c14').getContext('2d');
	const myChartc14 = new Chart(ctxc14, {
		 type: 'bar',
		data: {
			 labels:  ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'],
			  datasets: [
			{
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
				},
				categoryPercentage : 0.9,
			    barPercentage : 0.5,
			scales: {
				y: {
					suggestedMin: 0,
					suggestedMax: 70,
					  ticks: {
						   // y축 단위 설정
						  stepSize: 5,
						 callback: function(value, index, values) {
							return ' $' + value;
						  }
					}
				}
			}
		}
	});
</script>