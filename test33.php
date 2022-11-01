<?
include './head2.php';
?>

<style>
#container {
  height: 400px;
  min-width: 310px;
}

.highcharts-range-input{display:none;}
</style>

<div id="container"></div>

<script>
Highcharts.getJSON('https://demo-live-data.highcharts.com/aapl-c.json', function (data) {
  // Create the chart
  Highcharts.stockChart('container', {
		chart: {
			type:'line'
		},
    title: {
      text: 'AAPL Stock Price'
    },

rangeSelector: {
    buttons: [{
        type: 'month',
        count: 1,
        text: '1m',
        events: {
            click: function() {
                alert('Clicked button');
            }
        }
    }, {
        type: 'month',
        count: 3,
        text: '3m'
    }, {
        type: 'month',
        count: 6,
        text: '6m'
    }, {
        type: 'ytd',
        text: 'YTD'
    }, {
        type: 'year',
        count: 1,
        text: '1y'
    }, {
        type: 'all',
        text: 'All'
    }]
},

		navigator: {
			enabled: false      
		},

		navigation: {
			bindingsClassName: 'tools-container-detail' //주식 네비게이션 이름(여러 그래프 이용시 전체화면 오류 해결)
		},
		stockTools: {
			gui: {
				enabled: false //주식 네비게이션 사용여부
			}
		},
    series: [{
      name: 'AAPL',
      data: data,
      tooltip: {
        valueDecimals: 2
      }
    }]
  });
});


</script>