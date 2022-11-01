<div id="updowncpr" style="width: 1160px; height: 400px; margin: 0 auto;"></div>
<script>
	$(function () {
		//첫번째 데이터 값
		let updowncprFirst = [];
		let prev = -100;
		for (let i = 0; i < 500; i++) {
		  prev += 5 - Math.random() * 10;
		  updowncprFirst.push({x: i, y: prev});
		}

		//두번째 데이터 값
		let updowncprSecond = [];
		let prev2 = 100;
		for (let i = 0; i < 500; i++) {
		  prev2 += 5 - Math.random() * 10;
		  updowncprSecond.push({x: i, y: prev2});
		}

		Highcharts.chart('updowncpr', {
		  chart: {
			zoomType: 'x'
		  },
		  title: {
			text: ''
		  },
		  xAxis: [{
			type: 'datetime',
			height: '50%',
			opposite: true,
			reversed: true,
			reversedStacks: false,
			  labels: {
				formatter: function() {
				  return Highcharts.dateFormat('%b %Y', this.value);
				}
			}
		  },{
		type: 'datetime',
        top: '50%',
        height: '50%',
        reversed: true,
        reversedStacks: true,
			  labels: {
				formatter: function() {
				  return Highcharts.dateFormat('%b %Y', this.value);
				}
			}
		  }
		  
		  ],
		  yAxis: [{
			title: {
			  text: ''
			},
			height: '50%',
			offset: 0
		  },{
			title: {
			  text: ''
			},
			height: '50%',
			top: '50%',
			offset: 0,
			reversed: true,
		  }],
		  legend: {
			enabled: false
		  },
			credits: {
				 enabled: false
			},
		  exporting: {
			enabled: false
		  },
		  plotOptions: {
			area: {
			  marker: {
				radius: 2
			  },
			  lineWidth: 1,
			  states: {
				hover: {
				  lineWidth: 1
				}
			  },
			  threshold: null
			}
		  },
		  series: [{
			type: 'area',
			name: '',
			data: updowncprFirst, //첫번째 데이터값
			color: '#26c6da',
			 fillColor: {
				linearGradient: {
				  x1: 0,
				  y1: 0,
				  x2: 0,
				  y2: 1
			 },
			stops: [
			  [0, 'rgb(38, 198, 218,0.7)'],
			  [1, 'rgb(38, 198, 218,0.5)']
			]
		  }
		  },{
			type: 'area',
			xAxis: 1,
			yAxis: 1,
			name: '',
			data: updowncprSecond,  //두번째 데이터값
			color: '#eb9df9',
		  fillColor: {
			linearGradient: {
			  x1: 0,
			  y1: 0,
			  x2: 0,
			  y2: 1
			},
			stops: [
			  [0, 'rgb(247, 207, 254,0.7)'],
			  [1, 'rgb(247, 207, 254,0.5)']
			]
		  }
		  }]
		});
	});
</script>