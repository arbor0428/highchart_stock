<div id="mddGraph01" style="width: 740px; height: 274px; margin: 0 auto;"></div>

<script>
$(function () {
	cData01 = "<?=$cData01?>";
	cData01x = "<?=$cData01x?>";

	mdd = cData01.split(',');
	mddx = cData01x.split(',');

	let mddData = [];
	for (let i = 0; i < mdd.length; i++) {
		str = mddx[i];
		strArr = str.split('-');
		xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

		mddprev = parseFloat(mdd[i]);
		mddData.push({x: xData, y: mddprev});
	}


	const mddCom = Highcharts.chart('mddGraph01', {
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
			crosshair: true,
			title: {
				text: ''
			}
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
			name: '<?=$mddSymbol?>',
			data: mddData, //첫번째 데이터값
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
		}]
	});
});
</script>