<?
	include 'head2.php';
?>

<div id="bar_chart" style="width: 1000px; height: 480px; margin:0 auto;"></div>

<script>
var colors = ['#3B97B2', '#67BC42', '#FF56DE', '#E6D605', '#BC36FE', '#000'];

 $('#bar_chart').highcharts({
        chart: {
            type: 'column'              
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: false                       
                }
            }
        },         

        series: [{
            name: '',
            colorByPoint: true,
            data: [{
                name: 'Blue',
                y: 5.78,
                color: colors[0]

            }, {
                name: 'Green',
                y: 5.19,
                color: colors[1]

            }, {
                name: 'Pink',
                y: 32.11,
                color: colors[2]

            }, {
                name: 'Yellow',
                y: 10.04,
                color: colors[3]

            }, {
                name: 'Purple',
                y: 19.33,
                color: colors[4]

            }]
        }]
    });
</script>