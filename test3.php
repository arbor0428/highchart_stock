<?
	include 'header.php';
?>

<div id="container" style="margin: 123px auto 0; min-width: 310px; height: 400px; "></div>
<script>
	$(function () {
		Highcharts.chart('container', {
			chart: {
				type:'spline'
			},
			title: {
				text: 'Monthly Average Temperature',
				x: -20 //center
			},
			subtitle: {
				text: 'Source: WorldClimate.com',
				x: -20
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			yAxis: {
				title: {
					text: 'Temperature (°C)'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: '°C'
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			},
			series: [{
				showInLegend: false,
				name: 'Tokyo',
				data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
			}, {
				name: 'New York',
				data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
			}, {
				name: 'Berlin',
				data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
			}, {
				name: 'London',
				data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
			}]
		});
	});
</script>


<div id="investOpinion" style="width: 260px; height: 260px; "></div>
<script>
	$(function () {
		Highcharts.chart('investOpinion', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: ''
			},
			plotOptions: {
			  pie: {
				innerSize: '50%',
			   colors: [
				 '#ff6384', 
				 '#ff9f40', 
				 '#ffcd56', 
				 '#4bc0c0', 
				 '#36a2eb'
			   ],
                allowPointSelect: false,
                cursor: 'pointer',
                dataLabels: {
					distance: -30,
					format: '{y}',
					color: '#fff',
                style: {
					fontSize:'16',
                    fontWeight: 'bold',
					textOutline: 'none'
                }
                }
			  }
			},
			series: [{
			  data: [
				['강력매도', 5],
				['매도', 10],
				['중립', 2],
				['매수', 20],
				['강력매수', 15]
			  ]
			}]
		});
	});
</script>

<div id="lineBarChart1" class="chart" style="width: 1160px; height: 300px;"></div>
<script>
function (data) {

  // split the data set into ohlc and volume
  var ohlc = [],
    volume = [],
    dataLength = data.length,
    i = 0;

  for (i; i < dataLength; i += 1) {
    ohlc.push([
      data[i][0], // the date
      data[i][1], // open
      data[i][2], // high
      data[i][3], // low
      data[i][4] // close
    ]);

    volume.push([
      data[i][0], // the date
      data[i][5] // the volume
    ]);
  }

  Highcharts.chart('lineBarChart1', {
    yAxis: [{
      labels: {
        align: 'left'
      },
      height: '80%',
      resize: {
        enabled: true
      }
    }, {
      labels: {
        align: 'left'
      },
      top: '80%',
      height: '20%',
      offset: 0
    }],
    tooltip: {
      shape: 'square',
      headerShape: 'callout',
      borderWidth: 0,
      shadow: false,
      positioner: function (width, height, point) {
        var chart = this.chart,
          position;

        if (point.isHeader) {
          position = {
            x: Math.max(
              // Left side limit
              chart.plotLeft,
              Math.min(
                point.plotX + chart.plotLeft - width / 2,
                // Right side limit
                chart.chartWidth - width - chart.marginRight
              )
            ),
            y: point.plotY
          };
        } else {
          position = {
            x: point.series.chart.plotLeft,
            y: point.series.yAxis.top - chart.plotTop
          };
        }

        return position;
      }
    },
    series: [{
      type: 'ohlc',
      id: 'aapl-ohlc',
      name: 'AAPL Stock Price',
      data: ohlc
    }, {
      type: 'column',
      id: 'aapl-volume',
      name: 'AAPL Volume',
      data: volume,
      yAxis: 1
    }],
    responsive: {
      rules: [{
        condition: {
          maxWidth: 800
        },
        chartOptions: {
          rangeSelector: {
            inputEnabled: false
          }
        }
      }]
    }
  });
});
</script>


<div id="container03"></div>

<script>

	//첫번째 데이터 값
	let dataFirst = [];
	let prev = 100;
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  dataFirst.push({x: i, y: prev});
	}

	//두번째 데이터 값
	let dataSecond = [];
	for (let i = 0; i < 1000; i++) {
	  prev += 5 - Math.random() * 10;
	  dataSecond.push({x: i, y: prev});
	}

    Highcharts.chart('container03', {
      chart: {
        zoomType: 'x'
      },
      title: {
        text: ''
      },
      xAxis: {
        type: 'datetime',
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
        data: dataFirst, //첫번째 데이터값
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
      },{
        type: 'area',
        name: '',
        data: dataSecond,  //두번째 데이터값
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
</script>

<div id="smallChart01" style="width: 100px; height: 45px;"></div>
<script>
		Highcharts.chart('smallChart01', {
			chart: {
				type: 'spline',
				width: 100
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: ['1', '2', '3', '4', '5', '6','7', '8', '9', '10', '11', '12']
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
			legend: {
				enabled: false
			},
		  exporting: {
			enabled: false
		  },
			credits: {
				 enabled: false
			},
			series: [{
				showInLegend: false,
				name: 'graph',
				data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
			}]
		});
</script>

<?
	include 'footer.php';
?>