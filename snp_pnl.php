<?
	if(!$snpPnlEdate)		$snpPnlEdate = date('Y-m-d');
	if(!$snpPnlSdate)		$snpPnlSdate = date('Y-m-d', strtotime('-10 year', strtotime($snpPnlEdate)));

	$snpPnlEtime = strtotime($snpPnlEdate) + 86399;
	$snpPnlStime = strtotime($snpPnlSdate);

	if($gbl_symbol)	$snpPnlSymbol01 = $gbl_symbol;	//주식 개별 페이지에서 호출된 경우(/sub06/sub03.php)
	else					$snpPnlSymbol01 = 'AAPL';

	$snpPnlSymbol02 = '^GSPC';


	//첫번째 심볼
	$row = pnlData($snpPnlSymbol01, $snpPnlStime, $snpPnlEtime);

	$pnl01 = $row['pnlPer'];	//수익률
	$cData01 = $row['cData'];


	//두번째 심볼
	$row = pnlData($snpPnlSymbol02, $snpPnlStime, $snpPnlEtime);

	$pnl02 = $row['pnlPer'];	//수익률
	$cData02 = $row['cData'];
?>

					<div class="mdd_top mddTop_flex">
						<div style="display:flex; align-items: center;">
							<div class="mdd_search">
								<div class="search_bar">
									<input type="text" name="snpPnlSymbol01" id="snpPnlSymbol01" list="snpPnlSymbol01List" value="<?=$snpPnlSymbol01?>" placeholder="" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){snpPnlChk('series-1');}" autocomplete="off">
									<a class="search_icon" href="javascript:snpPnlChk();"><!--background 처리--></a>
									<?
										$datalist_ID = 'snpPnlSymbol01List';
										include '/home/myss/www/module/dataList.php';
									?>
								<!--
									<div class="showDown02">
										<div class="item">hello<span class="searWord"></span></div>
										<div class="item">nice to meet<span class="searWord"></span></div>
										<div class="item">hello<span class="searWord"></span></div>
										<div class="item">nice to meet<span class="searWord"></span></div>
										<div class="item">hello<span class="searWord"></span></div>
										<div class="item">nice to meet<span class="searWord"></span></div>
									</div>
								-->
								</div>
							</div>

							<input type='hidden' name="snpPnlSymbol02" id="snpPnlSymbol02" value="<?=$snpPnlSymbol02?>">

							<div class="toggle_selectWrap">
								<div class="toggle_select">
									vs <span class="mdd_top_tit snpPnlTxt">S&P 500</span> (P&L %)<span style="font-size: 13px;">▼</span>
								</div>
								<ul class="select_btn select_btn_s02">
									<li><a href="javascript://" title="^GSPC">S&P 500</a></li>
									<li><a href="javascript://" title="^NDX">nasdaq 100</a></li>
									<li><a href="javascript://" title="^DJI">Dow Jones</a></li>
								</ul>
							</div>
						</div>
						<div class="cal_select" style='display:none;'>
							<div class="calOpenBtn_s">
								<span>날짜 선택</span>
							</div>
							<div class="calFromTo_s">
								<div class="dateWrap">
									<div class="dateBox">
										<input type="text" name="snpPnlSdate" id="snpPnlSdate" value="<?=$snpPnlSdate?>" class="fpicker" placeholder="시작하는 날짜(From)" autocomplete="off">
										<img src="/img/cal_sel.png">
									</div>
									<span>~</span>
									<div class="dateBox">
										<input type="text" name="snpPnlEdate" id="snpPnlEdate" value="<?=$snpPnlEdate?>" class="fpicker" placeholder="끝나는 날짜(To)" autocomplete="off">
										<img src="/img/cal_sel.png">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="mdd_bot pos_rel">
						<?
							include 'graph08.php';
						?>
					</div>

<script>
$(function(){
	//select list click
	$(".select_btn_s02 > li").on("click",function(){
		symbol = $(this).children("a").attr("title");
		$("#snpPnlSymbol02").val(symbol);

		btnCont = $(this).children("a").text();
		$(this).parent().siblings().children(".mdd_top_tit").text(btnCont);

		$(".select_btn_s02").hide();

		snpPnlChk('series-2');
	});
});

//심볼입력
function snpPnlChk(seriesID){
	symbol = '';

	if(seriesID == 'series-1')			symbol = $('#snpPnlSymbol01').val();
	else if(seriesID == 'series-2')	symbol = $('#snpPnlSymbol02').val();

	if(symbol){
		//그래프 생성
		snpPnlData(symbol,seriesID);
	}

	$('#snpPnlSymbol01').blur();
}

//조회기간
function snpPnlPeriod(){
	symbol01 = $('#snpPnlSymbol01').val();
	snpPnlData(symbol01,'series-1');

	symbol02 = $('#snpPnlSymbol02').val();
	snpPnlData(symbol02,'series-2');
}

//심볼 데이터 호출
function snpPnlData(symbol,seriesID){
	if(symbol && seriesID){
		snpPnlSdate = $('#snpPnlSdate').val();
		snpPnlEdate = $('#snpPnlEdate').val();

		//달력 숨기기
		$(".calFromTo").hide();
		$(".calFromTo_s").hide();

		$.post('/module/json/pnlData.php',{'symbol':symbol,'sDate':snpPnlSdate,'eDate':snpPnlEdate}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("종목을 확인해 주시기 바랍니다.");
				return;

			}else if(code == '99'){
				//기존 그래프 삭제
				chart = $('#snpPnlGraph').highcharts();
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


	//그래프 생성(graph08.php)
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
	if(seriesID == 'series-2')		sName = $('.snpPnlTxt').text();

	chart01 = $('#snpPnlGraph').highcharts();
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

	pnlPer = parData['pnlPer'];
	if(seriesID == 'series-1'){
		$('#snpPnlTicker01').text(sName);	//티커
		$('#snpPnlPer01').text('+'+pnlPer+'%');		//수익률

	}else if(seriesID == 'series-2'){
		$('#snpPnlTicker02').text(sName);
		$('#snpPnlPer02').text('+'+pnlPer+'%');
	}
}
</script>