<!--chart1시작--->
<div id="applCompare" style="width: 500px; height: 250px; "></div>
<script>
	$(function () {
		const chartcom = Highcharts.chart('applCompare', {
			chart: {
				type:'line',
				events: {
					addSeries: function () {
						var label = this.renderer.label('그래프추가', 100, 120)
							.attr({
								fill: Highcharts.getOptions().colors[0],
								padding: 10,
								r: 5,
								zIndex: 8
							})
							.css({
								color: '#FFFFFF'
							})
							.add();

						setTimeout(function () {
							label.fadeOut();
						}, 1000);
					}
				}
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
			  exporting: {
				enabled: false
			  },
			legend: {
				enabled: false
			},
			credits: {
				 enabled: false
			},
			plotOptions: {
				series: {
					borderRadius: 5
				}
			},
			series: [{
				showInLegend: false,
				name: '',
				data: [0, 20,40, 60, 80, 20],
				color: '#f86a87',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }

			}]
		});

		//그래프series추가

		//첫번째 버튼 클릭시
		document.getElementById('addData01').addEventListener('click', e => {

			chartcom.addSeries({
				name: '',
				data: [0, 10,30, 50, 75, 13],
				color: '#39a1e8',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			});

			e.target.disabled = true;
		});
		//두번째 버튼 클릭시
		document.getElementById('addData02').addEventListener('click', e => {

			chartcom.addSeries({
				name: '',
				data: [0, 20,20, 60, 80, 15],
				color: '#970ab0',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			});
			e.target.disabled = true;
		});
		//세번째 버튼 클릭시
		document.getElementById('addData03').addEventListener('click', e => {

			chartcom.addSeries({
				name: '',
				data: [0, 10,40, 60, 80, 5],
				color: '#a1d21e',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			});
			e.target.disabled = true;
		});
		//네번째 버튼 클릭시
		document.getElementById('addData04').addEventListener('click', e => {

			chartcom.addSeries({
				name: '',
				data: [0, 20,50, 60, 80, 10],
				color: '#ffe508',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			});
			e.target.disabled = true;
		});
		//다섯번째 버튼 클릭시
		document.getElementById('addData05').addEventListener('click', e => {

			chartcom.addSeries({
				name: '',
				data: [0, 5,10, 6, 18, 5],
				color: '#28c9cf',
				  marker: {
					enabled: true,
					radius: 3,
					symbol: 'dot'
				  }
			});
			e.target.disabled = true;
		});
	});
</script>
<!--chart1끝--->

