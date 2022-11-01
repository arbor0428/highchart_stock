<script src="/module/js/highchart/stock-tools.js"></script>

<div id="lineBarChart1" style="width: 800px; height: 480px; margin:0 auto;"></div>
<script>
Highcharts.getJSON('/module/highcharts/<?=$gbl_symbol?>.json?v=<?=time()?>', function (data) {

  // split the data set into ohlc and volume
  var ohlc = [],
    volume = [],
    dataLength = data.length,
    i = 0;

//  console.log(data[i][0]);

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

  //데이터를 이렇게 넣는데..

 const stockChart = Highcharts.stockChart('lineBarChart1', {
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
	  exporting: {
		enabled: false
	  },
	credits: {
		 enabled: false
	},
	plotOptions: {
		candlestick: {
			color: '#0048df',
			upColor: '#eb0828',
			upLineColor: '#eb0828',
			lineColor: '#0048df'
		}
	},
    series: [{
      type: 'candlestick',
      id: 'aapl-ohlc',
      name: '',
      data: ohlc,
	color: '#0048df',
	  marker: {
		lineWidth: 0.3
	  },
	 fillColor: {
			linearGradient: {
			  x1: 0,
			  y1: 0,
			  x2: 0,
			  y2: 1
		 },
		stops: [
		  [0, 'rgb(223, 146, 66,0.7)'],
		  [1, 'rgb(223, 146, 66,0.3)']
		]
	  }
    }, {
      type: 'column',
      id: 'aapl-volume',
      name: '',
      data: volume,
      yAxis: 1
    }],
	color:'#d52d1f',
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
