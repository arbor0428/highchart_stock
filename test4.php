<?
	include 'header.php';
?>
<div style="width: 100%; height: 200px;"></div>

<div id="container" style="width: 550px; height: 400px; margin: 0 auto"></div>
<script language="JavaScript">
$(document).ready(function() {  
   var chart = {
      type: 'spline'      
   }; 
   var title = {
      text: 'Snow depth at Vikjafjellet, Norway'   
   };
   var subtitle = {
      text: 'Irregular time data in Highcharts JS'
   };
   var xAxis = {
      type: 'datetime',
      dateTimeLabelFormats: { // don't display the dummy year
         month: '%e. %b',
         year: '%b'
      },
      title: {
         text: 'Date'
      }
   };
   var yAxis = {
      title: {
         text: 'Snow depth (m)'
      },
      min: 0
   };
   var tooltip = {
      headerFormat: '<b>'+Highcharts.dateFormat('%Y.%m.%d',this.x)+'</b><br>',
   };
   var plotOptions = {
      spline: {
         marker: {
            enabled: true
         }
      }
   };
   var series= [{
         name: 'Winter 2007-2008',
            // Define the data points. All series have a dummy year
            // of 1970/71 in order to be compared on the same x axis. Note
            // that in JavaScript, months start at 0 for January, 1 for February etc.
         data: [
             [Date.UTC(1970,  9, 27), 0   ],
             [Date.UTC(1970, 10, 10), 0.6 ],
             [Date.UTC(1970, 10, 18), 0.7 ],
             [Date.UTC(1970, 11,  2), 0.8 ],
             [Date.UTC(1970, 11,  9), 0.6 ],
             [Date.UTC(1970, 11, 16), 0.6 ],
             [Date.UTC(1970, 11, 28), 0.67],
             [Date.UTC(1971,  0,  1), 0.81],
             [Date.UTC(1971,  0,  8), 0.78],
             [Date.UTC(1971,  0, 12), 0.98],
             [Date.UTC(1971,  0, 27), 1.84],
             [Date.UTC(1971,  1, 10), 1.80],
             [Date.UTC(1971,  1, 18), 1.80],
             [Date.UTC(1971,  1, 24), 1.92],
             [Date.UTC(1971,  2,  4), 2.49],
             [Date.UTC(1971,  2, 11), 2.79],
             [Date.UTC(1971,  2, 15), 2.73],
             [Date.UTC(1971,  2, 25), 2.61],
             [Date.UTC(1971,  3,  2), 2.76],
             [Date.UTC(1971,  3,  6), 2.82],
             [Date.UTC(1971,  3, 13), 2.8 ],
             [Date.UTC(1971,  4,  3), 2.1 ],
             [Date.UTC(1971,  4, 26), 1.1 ],
             [Date.UTC(1971,  5,  9), 0.25],
             [Date.UTC(1971,  5, 12), 0   ]
         ]
      }, {
         name: 'Winter 2008-2009',
         data: [
             [Date.UTC(1970,  9, 18), 0   ],
             [Date.UTC(1970,  9, 26), 0.2 ],
             [Date.UTC(1970, 11,  1), 0.47],
             [Date.UTC(1970, 11, 11), 0.55],
             [Date.UTC(1970, 11, 25), 1.38],
             [Date.UTC(1971,  0,  8), 1.38],
             [Date.UTC(1971,  0, 15), 1.38],
             [Date.UTC(1971,  1,  1), 1.38],
             [Date.UTC(1971,  1,  8), 1.48],
             [Date.UTC(1971,  1, 21), 1.5 ],
             [Date.UTC(1971,  2, 12), 1.89],
             [Date.UTC(1971,  2, 25), 2.0 ],
             [Date.UTC(1971,  3,  4), 1.94],
             [Date.UTC(1971,  3,  9), 1.91],
             [Date.UTC(1971,  3, 13), 1.75],
             [Date.UTC(1971,  3, 19), 1.6 ],
             [Date.UTC(1971,  4, 25), 0.6 ],
             [Date.UTC(1971,  4, 31), 0.35],
             [Date.UTC(1971,  5,  7), 0   ]
         ]
      }, {
         name: 'Winter 2009-2010',
         data: [
             [Date.UTC(1970,  9,  9), 0   ],
             [Date.UTC(1970,  9, 14), 0.15],
             [Date.UTC(1970, 10, 28), 0.35],
             [Date.UTC(1970, 11, 12), 0.46],
             [Date.UTC(1971,  0,  1), 0.59],
             [Date.UTC(1971,  0, 24), 0.58],
             [Date.UTC(1971,  1,  1), 0.62],
             [Date.UTC(1971,  1,  7), 0.65],
             [Date.UTC(1971,  1, 23), 0.77],
             [Date.UTC(1971,  2,  8), 0.77],
             [Date.UTC(1971,  2, 14), 0.79],
             [Date.UTC(1971,  2, 24), 0.86],
             [Date.UTC(1971,  3,  4), 0.8 ],
             [Date.UTC(1971,  3, 18), 0.94],
             [Date.UTC(1971,  3, 24), 0.9 ],
             [Date.UTC(1971,  4, 16), 0.39],
             [Date.UTC(1971,  4, 21), 0   ]
         ]
      }
   ];     
      
   var json = {};
   json.chart = chart;
   json.title = title;
   json.subtitle = subtitle;
   json.tooltip = tooltip;
   json.xAxis = xAxis;
   json.yAxis = yAxis;  
   json.series = series;
   json.plotOptions = plotOptions;
   $('#container').highcharts(json);
  
});
</script>
<!-- 
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
				  return Highcharts.dateFormat('%b', this.value);
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
            shared: true
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



<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script>
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Stacked column chart'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Highchart test'
            },
            stackLabels: {
              enabled: true,
              style: {
              	fontWeight: 'bold'
            	}
           }
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'AAA',
            data: [{
                name: 'Name 1',
                y: 5,
                drilldown: 'Name1AAA'
            }, {
                name: 'Name 4',
                y: 0
            }, {
                name: 'Name 3',
                y: 2
            }, {
                name: 'Name 2',
                y: 2
            }]
        }, {
            name: 'BBB',
            data: [{
                name: 'Name 1',
                y: 10,
                drilldown: 'Name1BBB'
            }, {
                name: 'Name 4',
                y: 0
            }, {
                name: 'Name 3',
                y: 0
            }, {
                name: 'Name 2',
                y: 5
            }]
        }, {
            name: 'CCC',
            data: [{
                name: 'Name 1',
                y: 4,
                drilldown: 'Name1CCC'
            }, {
                name: 'Name 4',
                y: 12
            }, {
                name: 'Name 3',
                y: 8
            }, {
                name: 'Name 2',
                y: 1
            }]
        }],
        
        drilldown: {
            series: [{
                name: 'Name 1 - AAA',
                id: 'Name1AAA',
                data: [
                    ['Name 1/1', 2],
                    ['Name 1/2', 2],
                    ['Name 1/3', 1],
                ]
            }, {
                name: 'Name 1 - BBB',
                id: 'Name1BBB',
                data: [
                    ['Name 1/1', 7],
                    ['Name 1/2', 2],
                    ['Name 1/3', 1],
                ]
            }, {
                name: 'Name 1 - CCC',
                id: 'Name1CCC',
                data: [
                    ['Name 1/1', 2],
                    ['Name 1/2', 3],
                    ['Name 1/3', 4],
                ]
            }]
        }
    });
});
</script>
 -->



<?
	echo date('Y-m-d','158998140');

1167609600000

?>

<?
	include 'footer.php';
?>