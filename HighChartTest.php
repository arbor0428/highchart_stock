<?
	include 'head2.php';
?>
<div style="width: 100%; height: 200px;"></div>
			<div class="tabBtn">
				<button id="addData01">999개</button>
				<button id="addData02">1,000개</button>
				<button id="addData03">1,001개</button>
			</div>

			<style>
				.tabBtn {
					display: flex;
					flex-wrap: wrap;
					box-sizing: border-box;
					border-bottom: 1px solid #e26f12;
					margin: 70px auto 30px; 
					width: 1280px;
				}
				.tabBtn button {
					position: relative;
					border-radius: 5px 5px 0 0;
					border-top: 1px solid #e26f12;
					border-right: 1px solid #e26f12;
					border-left: 1px solid #e26f12;
					margin-right: 5px;
					background-color: transparent;
					width: 120px;
					height: 45px;
					line-height: 45px;
					text-align: center;
					font-size: 15px;
					color: #0c1540;
					font-weight: 700;
					cursor: pointer;
				}
				.tabBtn button.on {    
					color: #fff;
					background-color: #e26f12;
				} 

				.tabBtn button::after {
					display: block;
					content: "";
					position: absolute;
					bottom: -1px;
					left: 0;
					width: 101%;
					height: 1px;
					background-color: #fff;
				}

				.tabBtn button.on::after {
					background-color: #e26f12;
				}

			</style>

			<script>
				// 버튼 눌렀을 때 style 변경
				$(".tabBtn > button").click(function(event){
					event.preventDefault();
			
					let tabNumber = $(this).index();
			
					$(".tabBtn > button").removeClass("on");
					$(this).addClass("on");
			
				});
			</script>
<div id="mddCompare" style="width: 1200px; height: 274px; margin: 0 auto;"></div>

<script>
	$(function () {
		//첫번째 데이터 값
		let mddComFirst = [];
		let mddprev = 100;
		for (let i = 1; i <= 999; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComFirst.push({x: i, y: mddprev});
		}
		
		//두번째 데이터 값
		let mddComSec = [];
		for (let i = 1; i <= 1000; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComSec.push({x: i, y: mddprev});
		}

		//세번째 데이터 값
		let mddComThr = [];
		for (let i = 1; i <= 2000; i++) {
		  mddprev += 5 - Math.random() * 10;
		  mddComThr.push({x: i, y: mddprev});
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
			tickInterval: 10,

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

	  plotOptions: {
		  series: {
			turboThreshold:2000
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
		  series: []
		});

		//그래프series추가

		//첫번째 버튼 클릭시
		document.getElementById('addData01').addEventListener('click', e => {
			
			mddCom.addSeries({
				name: '',
				data: mddComFirst, 
				color: '#39a1e8',
			});

			e.target.disabled = true;
		});
		//두번째 버튼 클릭시
		document.getElementById('addData02').addEventListener('click', e => {

			mddCom.addSeries({
				name: '',
				data: mddComSec, 
				color: '#970ab0',
			});

			e.target.disabled = true;
		});
		//세번째 버튼 클릭시
		document.getElementById('addData03').addEventListener('click', e => {

			mddCom.addSeries({
				name: '',
				data: mddComThr, 
				color:  '#a1d21e',
			});

			e.target.disabled = true;
		});
	});
</script>