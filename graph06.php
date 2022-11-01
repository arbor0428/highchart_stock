<div class="mdd_graph">
	<div id="snpMddGraph01" style="width: 740px; height: 274px; margin: 0 auto;"></div>
</div>
<script>
	$(function () {
		//첫번째 데이터 값
		datav = "<?=$aData01?>";
		datax = "<?=$aData01x?>";

		mdd = datav.split(',');
		mddx = datax.split(',');

		let mddgraphFirst = [];
		for (let i = 0; i < mdd.length; i++) {
			str = mddx[i];
			strArr = str.split('-');
			xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

			mddprev = parseFloat(mdd[i]);
			mddgraphFirst.push({x: xData, y: mddprev});
		}

		//두번째 데이터 값
		datav = "<?=$bData01?>";
		datax = "<?=$bData01x?>";

		mdd = datav.split(',');
		mddx = datax.split(',');

		let mddgraphSecond = [];
		for (let i = 0; i < mdd.length; i++) {
			str = mddx[i];
			strArr = str.split('-');
			xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

			mddprev = parseFloat(mdd[i]);
			mddgraphSecond.push({x: xData, y: mddprev});
		}

		Highcharts.chart('snpMddGraph01', {
			chart: {
				type: 'line'
			},
			title: {
				text: ''
			},
			xAxis: {
				type: 'datetime',
				crosshair: true,
				labels: {
					formatter: function() {
						return Highcharts.dateFormat('%b %Y', this.value);
					}
				}
			},
			yAxis: {
				title: {
					text: ''
				},
				crosshair: true
			},
			tooltip: {
				xDateFormat: '%Y',
				shared: true,
				formatter: function () {
					var s = '<b>' + Highcharts.dateFormat('%Y.%m.%d', this.x) + '</b>';
					$.each(this.points, function (idx, point) {
						s += "<br/>" +"<span style='color:#0048df;'>" + this.series.name + "</span>" +" : "+ "<span style='color: #000;'>" + point.y  +"%</span>";
					});
					return s;
				}
			},
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
				},
				series: {
					turboThreshold:10000,
					label: {
						enabled: false
					}
				}
			},
			series: [{
				type: 'area',
				name: '<?=$snpMddSymbol01?>',
				id: 'series-1',
				data: mddgraphFirst, //첫번째 데이터값
				color: '#f86a87',
				fillColor: {
					linearGradient: {
						x1: 0,
						y1: 0,
						x2: 0,
						y2: 1
					},
					stops: [
						[0, 'rgb(248,106,135,0.7)'],
						[1, 'rgb(255,255,255,0.5)']
					]
				}
			},{
				type: 'area',
				name: 'S&P 500',
				id: 'series-2',
				data: mddgraphSecond,  //두번째 데이터값
				fillColor: {
					linearGradient: {
						x1: 0,
						y1: 0,
						x2: 0,
						y2: 1
					},
					stops: [
						[0, 'rgb(57,161,232,0.7)'],
						[1, 'rgb(255,255,255,0.5)']
					]
				}
			}]
		});
	});
</script>