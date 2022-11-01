	<div class="chart_label">
		<div class="label01">
			<div class="line"></div>
			<span><?=$title01?> (<?=$symbol01?>)</span>
		</div>
		<div class="label02">
			<div class="line"></div>
		<!--
			<span>S&P 500</span>
		-->
			<select name='symbol02' id='symbol02' onchange="snpPnlChk();" style="cursor:pointer;">
			<?
				foreach($sArr as $k => $v){
			?>
				<option value='<?=$k?>'><?=$v?></option>
			<?
				}
			?>
			</select>
		</div>
	</div>
	<style>
		.chart_label {margin-bottom: 20px;}
		.chart_label > div {margin-bottom: 20px; padding-right: 20px; box-sizing:border-box; width: 100%; display: flex; flex-wrap: wrap; justify-content:right;}
		.chart_label .line {position:relative; top: 8px; margin-right: 10px; width: 30px; height: 6px;}
		.chart_label span {font-size: 18px; font-weight: 700;}
		.chart_label .label01 .line {background-color: #f86a87;}
		.chart_label .label01 span {width: 160px;}
		.chart_label .label02 .line {background-color: #39a1e8;}
		.chart_label .label02 select {width: 160px; border:none; font-size: 18px; font-weight: 700;}
	</style>
	<div id="<?=$graphID?>" style="width: 780px; height: 230px; "></div>

<script>
$(function () {
	//첫번째 데이터 값
	let DataList01 = [];
<?
	foreach($cData01 as $k => $v){
?>
	str = "<?=$k?>";
	strArr = str.split('-');
	xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

	DataList01.push({x: xData, y: <?=$v?>});
<?
	}
?>

	//두번째 데이터 값
	let DataList02 = [];
<?
	foreach($cData02 as $k => $v){
?>
	str = "<?=$k?>";
	strArr = str.split('-');
	xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

	DataList02.push({x: xData, y: <?=$v?>});
<?
	}
?>


	Highcharts.chart('<?=$graphID?>', {
		chart: {
			type: 'line'
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
		tooltip: {
			xDateFormat: '%Y',
			shared: true,
			formatter: function () {
				var s = '<b>' + Highcharts.dateFormat('%Y.%m.%d', this.x) + '</b>';
				$.each(this.points, function (idx, point) {
					s += "<br/><span style='color: #000;'>" + this.series.name +" : "+ point.y  +"</span>";
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
			type: 'spline',
			name: '<?=$symbol01?>',
			id: 'series-1',
			data: DataList01, //첫번째 데이터값
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
			type: 'spline',
			name: 'S&P 500',
			id: 'series-2',
			data: DataList02,  //두번째 데이터값
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









//s&p500 변경
function snpPnlChk(){
//	symbol01 = "<?=$symbol01?>";
//	snpPnlData(symbol01,'series-1');

	symbol02 = $("#symbol02 option:selected").val();
	snpPnlData(symbol02,'series-2');
}

//심볼 데이터 호출
function snpPnlData(symbol,seriesID){
	if(symbol && seriesID){
		snpPnlSdate = "<?=$gsDate?>";
		snpPnlEdate = "<?=$geDate?>";

		$.post('../module/json/pnlData.php',{'symbol':symbol,'sDate':snpPnlSdate,'eDate':snpPnlEdate}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("종목을 확인해 주시기 바랍니다.");
				return;

			}else if(code == '99'){
				//기존 그래프 삭제
				chart = $('#<?=$graphID?>').highcharts();
				chart.get(seriesID).remove();

				snpPnlAdd(parData,seriesID);

			}else{
				GblMsgBox("Error");
				return;
			}
		});	
	}
}

//그래프 생성
function snpPnlAdd(parData,seriesID){

	//그래프 색상
	lineArr = new Array('','#f86a87','#7cb5ec','#4bc0c0');	//빨,파,초
	bgArr = new Array('','248,106,135,0.7','57,161,232,0.7','64,255,149,0.7');	//빨,파,초

	if(seriesID == 'series-1'){
		lineColor = lineArr[1];
		bgColor = bgArr[1];

	}else if(seriesID == 'series-2'){
		lineColor = lineArr[2];
		bgColor = bgArr[2];
	}

	let candleData = [];

	cData = parData['cData'];
	for(const [key, value] of Object.entries(cData)){
		k = `${key}`;
		v = `${value}`;

		str = k;
		strArr = str.split('-');
		xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

		mddprev = parseFloat(v);
		candleData.push({x: xData, y: mddprev});
	}

	sName = parData['symbol'];
	if(seriesID == 'series-2'){
		sName = $("#symbol02 option:selected").text();
		$("#snpName").text(sName);
	}

	chart01 = $('#<?=$graphID?>').highcharts();
	chart01.addSeries({
		type: 'spline',
		name: sName,
		id: seriesID,
		data: candleData, 
		color:lineColor,
		fillColor: {
			linearGradient: {
				x1: 0,
				y1: 0,
				x2: 0,
				y2: 1
			},
			stops: [
				[0, 'rgb('+bgColor+')'],
				[1, 'rgb(255,255,255,0.5)']
			]
		}
	});
}
</script>