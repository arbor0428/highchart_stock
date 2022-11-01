<div id="mddCompare" style="width: 740px; height: 274px; margin: 0 auto;"></div>

<script>
	$(function () {
		//첫번째 데이터 값
		let mddComFirst = [];
		let mddprev = 100;
		for (let i = 0; i < 1000; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComFirst.push({x: i, y: mddprev});
		}
		
		//두번째 데이터 값
		let mddComSec = [];
		for (let i = 0; i < 1000; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComSec.push({x: i, y: mddprev});
		}

		//세번째 데이터 값
		let mddComThr = [];
		for (let i = 0; i < 1000; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComThr.push({x: i, y: mddprev});
		}

		//네번째 데이터 값
		let mddComFor = [];
		for (let i = 0; i < 1000; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComFor.push({x: i, y: mddprev});
		}

		//다섯번째 데이터 값
		let mddComFif = [];
		for (let i = 0; i < 1000; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComFif.push({x: i, y: mddprev});
		}
		
		//여섯번째 데이터 값
		let mddComSix = [];
		for (let i = 0; i < 1000; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComSix.push({x: i, y: mddprev});
		}

		const mddCom = Highcharts.chart('mddCompare', {
		  chart: {
			type: 'line'
		  },
		  title: {
			text: ''
		  },
		  xAxis: {
			categories: [],
			tickInterval: 50,
			  labels: {
				formatter: function() {
				  return Highcharts.dateFormat('%b %Y', this.value);
				}
			}
		  },
		  yAxis: {
			title: {
			  text: ''
			}
		  },
        tooltip: {
            xDateFormat: '%Y',
            shared: true,
        formatter: function () {
            return this.points.reduce(function (s, point) {
                return s + '<br/>' + point.series.name + ': ' +
                    point.y + 'm';
            }, '<b>' + this.x + '</b>');
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
		  series: [{
			name: '',
			data: mddComFirst,
			color: '#f86a87'
		  }]
		});

		//그래프series추가

		//첫번째 버튼 클릭시
		document.getElementById('addData01').addEventListener('click', e => {
			
			mddCom.addSeries({
				name: '',
				data: mddComSec, 
				color: '#39a1e8',
			});

			e.target.disabled = true;
		});
		//두번째 버튼 클릭시
		document.getElementById('addData02').addEventListener('click', e => {

			mddCom.addSeries({
				name: '',
				data: mddComThr, 
				color: '#970ab0',
			});

			e.target.disabled = true;
		});
		//세번째 버튼 클릭시
		document.getElementById('addData03').addEventListener('click', e => {

			mddCom.addSeries({
				name: '',
				data: mddComFor, 
				color:  '#a1d21e',
			});

			e.target.disabled = true;
		});
		//네번째 버튼 클릭시
		document.getElementById('addData04').addEventListener('click', e => {

			mddCom.addSeries({
				name: '',
				data: mddComFif, 
				color:  '#ffe508',
			});

			e.target.disabled = true;
		});
		//다섯번째 버튼 클릭시
		document.getElementById('addData05').addEventListener('click', e => {

			mddCom.addSeries({
				name: '',
				data: mddComSix, 
				color:  '#28c9cf',
			});

			e.target.disabled = true;
		});
	});
</script>


