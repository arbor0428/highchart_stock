<?
	if(!$snpMddEdate)		$snpMddEdate = date('Y-m-d');
	if(!$snpMddSdate)		$snpMddSdate = date('Y-m-d', strtotime('-10 year', strtotime($snpMddEdate)));

//	$snpMddEdate = date('2022-03-01');
//	$snpMddSdate = date('2011-01-01');

	$snpMddEtime = strtotime($snpMddEdate) + 86399;
	$snpMddStime = strtotime($snpMddSdate);

	if($gbl_symbol)				$snpMddSymbol01 = $gbl_symbol;	//주식 개별 페이지에서 호출된 경우(/sub06/sub03.php)
	elseif(!$snpMddSymbol01)	$snpMddSymbol01 = 'AAPL';

	if(!$snpMddSymbol02)	$snpMddSymbol02 = '^GSPC';

	//첫번째 심볼 mdd 데이터(graph06.php)
	$item = mddData($snpMddSymbol01,$snpMddStime,$snpMddEtime);
	$aData01 = $item['cData01'];		//MDD 차트 데이터(값)
	$aData01x = $item['cData01x'];		//MDD 차트 데이터(x라벨)
	$aData02 = $item['cData02'];		//전고점 대비 하락폭 별 상승확률 데이터
	$max_percent01 = $item['max_percent'];

	//두번째 심볼 mdd 데이터(graph07.php)
	$item = mddData($snpMddSymbol02,$snpMddStime,$snpMddEtime);
	$bData01 = $item['cData01'];		//MDD 차트 데이터(값)
	$bData01x = $item['cData01x'];		//MDD 차트 데이터(x라벨)
	$bData02 = $item['cData02'];		//전고점 대비 하락폭 별 상승확률 데이터
	$max_percent02 = $item['max_percent'];

	//상승확률 그래프 x축 최대값
	if($max_percent01 > $max_percent02)		$max_percent = $max_percent01;
	else													$max_percent = $max_percent02;
?>

					<div class="mdd_top mddTop_flex">
						<div style="display:flex; align-items: center;">
							<div class="mdd_search">
								<div class="search_bar">
									<input type="text" name="snpMddSymbol01" id="snpMddSymbol01" list="snpMddSymbol01List" value="<?=$snpMddSymbol01?>" placeholder="" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){snpMddChk('series-1');}" autocomplete="off">
									<a class="search_icon" href="javascript:snpMddChk();"><!--background로 처리--></a>
									<?
										$datalist_ID = 'snpMddSymbol01List';
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

							<input type='hidden' name="snpMddSymbol02" id="snpMddSymbol02" value="<?=$snpMddSymbol02?>">

							<input type='hidden' name="snpMddPerData1" id="snpMddPerData1" value="<?=$aData02?>">
							<input type='hidden' name="snpMddPerData2" id="snpMddPerData2" value="<?=$bData02?>">

							<div class="toggle_selectWrap">
								<div class="toggle_select">
									vs <span class="mdd_top_tit snpMddTxt">S&P 500</span> (MDD)<span style="font-size: 13px;">▼</span>
								</div>
								<ul class="select_btn select_btn_s01">
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
										<input type="text" name="snpMddSdate" id="snpMddSdate" value="<?=$snpMddSdate?>" class="fpicker" placeholder="시작하는 날짜(From)" autocomplete="off">
										<img src="/img/cal_sel.png">
									</div>
									<span>~</span>
									<div class="dateBox">
										<input type="text" name="snpMddEdate" id="snpMddEdate" value="<?=$snpMddEdate?>" class="fpicker" placeholder="끝나는 날짜(To)" autocomplete="off">
										<img src="/img/cal_sel.png">
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="mdd_bot pos_rel">
						<?
							include 'graph06.php';
						?>
					</div>



<script>
$(function(){
	//select list click
	$(".select_btn_s01 > li").on("click",function(){
		symbol = $(this).children("a").attr("title");
		$("#snpMddSymbol02").val(symbol);

		btnCont = $(this).children("a").text();
		$(this).parent().siblings().children(".mdd_top_tit").text(btnCont);

		$(".select_btn_s01").hide();

		snpMddChk('series-2');

		//달력 숨기기
		$(".calFromTo").hide();
		$(".calFromTo_s").hide();
	});

	$("#snpMddSymbol01List").on("change",function(){
		etf = $(this).data('etf');
		alert(etf);
	});
});

//심볼입력
function snpMddChk(seriesID){
	symbol = '';

	if(seriesID == 'series-1')			symbol = $('#snpMddSymbol01').val();
	else if(seriesID == 'series-2')	symbol = $('#snpMddSymbol02').val();

	if(symbol){
		//그래프 생성
		snpMddData(symbol,seriesID,1);
	}

	$('#snpMddSymbol01').blur();
}

//조회기간
function snpMddPeriod(){
	symbol01 = $('#snpMddSymbol01').val();
	snpMddData(symbol01,'series-1',0);	//상승확률 그래프 안그림

	symbol02 = $('#snpMddSymbol02').val();
	snpMddData(symbol02,'series-2',1);	//상승확률 그래프 그림
}

//심볼 데이터 호출
function snpMddData(symbol,seriesID,p){
	if(symbol && seriesID){
		snpMddSdate = $('#snpMddSdate').val();
		snpMddEdate = $('#snpMddEdate').val();

		//달력 숨기기
		$(".calFromTo").hide();
		$(".calFromTo_s").hide();

		$.post('/module/json/mddData.php',{'symbol':symbol,'mddSdate':snpMddSdate,'mddEdate':snpMddEdate}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("종목을 확인해 주시기 바랍니다.");
				return;

			}else if(code == '99'){
				//기존 mdd 그래프 삭제
				chart01 = $('#snpMddGraph01').highcharts();
				chart01.get(seriesID).remove();

				//기존 상승확률 그래프 삭제
//				chart02 = $('#snpMddGraph02').highcharts();
//				chart02.get(seriesID).remove();

				snpMddAdd(parData,seriesID,p);

			}else{
				GblMsgBox("Error");
				return;
			}
		});	
	}
}

//그래프 생성
function snpMddAdd(parData,seriesID,p){

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


	//MDD 차트 생성(graph06.php)
	mdd = parData['cData01'].split(',');
	mddx = parData['cData01x'].split(',');

	let mddData = [];
	for (let i = 0; i < mdd.length; i++) {
		str = mddx[i];
		strArr = str.split('-');
		xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

		mddprev = parseFloat(mdd[i]);
		mddData.push({x: xData, y: mddprev});
	}

	sName = parData['symbol'];
	if(seriesID == 'series-2')		sName = $('.snpMddTxt').text();

	chart01 = $('#snpMddGraph01').highcharts();
	chart01.addSeries({
		type: 'area',
		name: sName,
		id: seriesID,
		data: mddData, 
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

	if(seriesID == 'series-1')			$('#snpMddPerData1').val(parData['cData02']);
	else if(seriesID == 'series-2')	$('#snpMddPerData2').val(parData['cData02']);

	//상승확률 그래프 생성(graph07.php)
	if(p){
		snpMddPer();
	}
/*
	hpp = parData['cData02'].split(',');

	let hppData = [];
	for (let i = 0; i < hpp.length; i++) {
	  hppprev = parseFloat(hpp[i]);
	  hppData.push({x: i, y: hppprev});
	}

	chart02 = $('#snpMddGraph02').highcharts();
	chart02.addSeries({
		name: sName,
		data: hppData,
		id: seriesID,
		color:lineColor,
		marker: {
			enabled: true,
			radius: 0,
			symbol: 'dot'
		}
	});
*/
}


//상승확률 그래프 생성(graph07.php)
function snpMddPer(){
	//기존 그래프 삭제
	var chart02 = $('#snpMddGraph02').highcharts();
	var seriesLength = chart02.series.length;
	for(var i = seriesLength -1; i > -1; i--) {
		chart02.series[i].remove();
	}

	//그래프 색상
	lineArr = new Array('','#f86a87','#7cb5ec','#4bc0c0');	//빨,파,초
	bgArr = new Array('','248,106,135,0.7','57,161,232,0.7','64,255,149,0.7');	//빨,파,초

	//x축 최대값 가져오기
	sList = $('#snpMddSymbol01').val()+','+$('#snpMddSymbol02').val();
	sDate = $('#snpMddSdate').val();
	eDate = $('#snpMddEdate').val();

	$.post('/module/json/mddDataCnt.php',{'sList':sList,'sDate':sDate,'eDate':eDate}, function(result){
		parData = JSON.parse(result);
		code = parData['code'];

		if(code == '101'){
			GblMsgBox("종목을 확인해 주시기 바랍니다.");
			return;

		}else if(code == '99'){
			dataCnt = parData['max_percent'];

			for(c=1; c<=2; c++){
				lineColor = lineArr[c];
				bgColor = bgArr[c];
				seriesID = 'series-'+c;
				
				if(c == 1)	sName = $('#snpMddSymbol01').val();
				else			sName = $('.snpMddTxt').text();

				hpp = $('#snpMddPerData'+c).val().split(',');

				let hppData = [];
				for (let i = 0; i < dataCnt; i++) {
				  hppprev = parseFloat(hpp[i]);
				  hppData.push({x: i, y: hppprev});
				}

				chart02 = $('#snpMddGraph02').highcharts();
				chart02.addSeries({
					name: sName,
					data: hppData,
					id: seriesID,
					color:lineColor,
					marker: {
						enabled: true,
						radius: 0,
						symbol: 'dot'
					}
				});
			}


		}else{
			GblMsgBox("Error");
			return;
		}
	});	




}
</script>