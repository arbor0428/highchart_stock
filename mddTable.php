<?
	if(!$mddEdate)		$mddEdate = date('Y-m-d');
	if(!$mddSdate)		$mddSdate = date('Y-m-d', strtotime('-10 year', strtotime($mddEdate)));

//	$mddEdate = date('2022-03-01');
//	$mddSdate = date('2011-01-01');

	$mddEtime = strtotime($mddEdate) + 86399;
	$mddStime = strtotime($mddSdate);

	if($gbl_symbol)	$mddSymbol = $gbl_symbol;	//주식 개별 페이지에서 호출된 경우(/sub06/sub03.php)
	else					$mddSymbol = 'AAPL';

	//심볼 mdd 데이터
	$item = mddData($mddSymbol,$mddStime,$mddEtime);

	$pmDate = $item['pmDate'];	//최대낙폭일
	$pmPer = $item['pmPer'];		//최대낙폭
	$HighC = $item['HighC'];		//기간내 최고점
	$nowC = $item['nowC'];		//최신값(c)
	$nowPer = $item['nowPer'];	//고점대비 하락률
	$upPer = $item['upPer'];		//상승확률

	$cData01 = $item['cData01'];		//MDD 차트 데이터(값)
	$cData01x = $item['cData01x'];		//MDD 차트 데이터(x라벨)
	$cData02 = $item['cData02'];		//전고점 대비 하락폭 별 상승확률 데이터



	$max_percent = $item['max_percent'];

//	echo mddHigh('AAPL,A,B',$mddStime,$mddEtime);
?>


				<div class="mdd_box mdd_box01 mddTableDiv">
				<!--
					<div style="margin-bottom:10px; width: 100%; display:flex; flex-direction: row-reverse;">
						<div class="mdd_series_del" style="padding: 5px 18px; border-radius: 5px; background-color: #d11313; color: #fff; box-sizing:border-box; height: 35px; line-height: 25px; text-align: center; cursor:pointer;">그래프 모두 삭제</div>
					</div>
				-->
					<table class="tiker" id='mddTable'>
						<colgroup>
							<col style="width:11.5%;"></col>
							<col style="width:13.5%;"></col>
							<col style="width:13.5%;"></col>
							<col style="width:11.5%;"></col>
							<col style="width:10.5%;"></col>
							<col style="width:10.5%;"></col>
							<col style="width:13.5%;"></col>
							<col style="width:10.5%;"></col>
							<col style="width:5%;"></col>
						</colgroup>
						<tbody>
							<tr>
								<th>티커</th>
								<th>From</th>
								<th>To</th>
								<th>현재주가</th>
								<th>고점대비<br>하락률</th>
								<th>상승확률</th>
								<th>최대낙폭일</th>
								<th>최대낙폭(MDD)</th>
								<th></th>
							</tr>
							<tr id='mddTr1' class='mddTr' style="background-color:rgb(255,196,208,0.7);" data-symbol="<?=$mddSymbol?>" data-hex="#f86a87" data-c2="<?=$cData02?>">
								<td><?=$mddSymbol?></td>
								<td><?=date('Y/m/d',$mddStime)?></td>
								<td><?=date('Y/m/d',$mddEtime)?></td>
								<td><?=$nowC?></td>
								<td><?=$nowPer?>%</td>
								<td><?=$upPer?>%</td>
								<td><?=$pmDate?></td>
								<td><?=$pmPer?>%</td>
								<td><a href="javascript://" class="mddDel" title="그래프제거">-</a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="mdd_box mdd_box02">
					<div class="jm_search">
						<div class="top_jmSearch">
							<div class="cal_select">
								<div class="calOpenBtn">
									<span>날짜 선택</span>
<!-- 									<img src="/img/cal_sel_wt.png" style="width: 20px;"> -->
								</div>
								<div class="calFromTo">
									<div class="dateWrap">
										<div class="dateBox">
											<input type="text" name="mddSdate" id="mddSdate" value="<?=$mddSdate?>" class="fpicker" onchange="allCals(1);" placeholder="시작하는 날짜(From)">
											<img src="/img/cal_sel.png">
										</div>
										<span>~</span>
										<div class="dateBox">
											<input type="text" name="mddEdate" id="mddEdate" value="<?=$mddEdate?>" class="fpicker" onchange="allCals(1);" placeholder="끝나는 날짜(To)">
											<img src="/img/cal_sel.png">
										</div>
									</div>
								</div>
							</div>

							<script>
							// 버튼 눌렀을 때 calFromTo 열고 닫기
							$(".calOpenBtn").click(function(){
								if($(".calFromTo").css("display") == "none"){
									$(".calFromTo").show();
								}else{
									$(".calFromTo").hide();
								}
							});
							</script>

							<div class="search_bar search_mdd">
								<input type="text" name="mddSymbol" id="mddSymbol" list="mddSymbolList" value="" placeholder="이 종목 지금 사도될까? 종목을 검색하세요" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){mddChk();}">
								<a class="search_icon" href="javascript:mddChk();"><!--background로 처리--></a>
								<?
									$datalist_ID = 'mddSymbolList';
									include '/home/myss/www/module/dataList.php';
								?>
							<!--
								<div class="showDown invisible" id="recommend">
									<div class="item">hello<span class="searWord"></span></div>
									<div class="item">nice to meet<span class="searWord"></span></div>
									<div class="item">hello<span class="searWord"></span></div>
									<div class="item">nice to meet<span class="searWord"></span></div>
									<div class="item">hello<span class="searWord"></span></div>
									<div class="item">nice to meet<span class="searWord"></span></div>
								</div>
							-->
							</div>

							<!--임시 연관검색 스크립트-->
							<script>
								const inputBox = document.querySelector(".search_mdd input");
								const recommendBox = document.querySelector("#recommend");
								const texts = document.querySelectorAll("#recommend .searWord");

								inputBox.addEventListener("keyup", (e) => {
									if (e.target.value.length > 0) {
										recommendBox.classList.remove('invisible');
										texts.forEach((textEl) => {
											textEl.textContent = e.target.value;
										})
									} else {
										recommendBox.classList.add('invisible');
									}
								})
							</script>


						</div>
						<p class='mddMsg'>* <?=$mddSymbol?> 현재 주가는 전고점대비 <span class="blue"><?=$nowPer?>%</span>이고, 과거 데이터를 기반으로<br>보았을 때 상승확률은 <span class="red"><?=$upPer?>%</span>입니다.</p>
					</div>
				</div>

<script>
//날짜선택 통합
function allCals(c){
	sd = '';
	ed = '';

	//mddTable.php
	if(c == 1){
		sd = $('#mddSdate').val();
		ed = $('#mddEdate').val();

	//main2.php
	}else if(c == 2){
		sd = $('#mddSdate2').val();
		ed = $('#mddEdate2').val();

	//snp_mdd.php
	}else if(c == 3){
		sd = $('#snpMddSdate').val();
		ed = $('#snpMddEdate').val();

	//snp_pbl.php
	}else if(c == 4){
		sd = $('#snpPnlSdate').val();
		ed = $('#snpPnlEdate').val();

	}

	$('#mddSdate').val(sd);
	$('#mddEdate').val(ed);
	$('#mddSdate2').val(sd);
	$('#mddEdate2').val(ed);
	mddPeriod();	//MDD차트

	$('#snpMddSdate').val(sd);
	$('#snpMddEdate').val(ed);
	snpMddPeriod();	//snp_mdd

	$('#snpPnlSdate').val(sd);
	$('#snpPnlEdate').val(ed);
	snpPnlPeriod();	//snp_pnl
}

//심볼입력
function mddChk(){
	symbol = $('#mddSymbol').val().toUpperCase();

	if(symbol){
		$('.mddTr').each(function(){
			if(symbol == $(this).data('symbol')){
				symbol = '';
				return false;
			}
		});

		if(symbol){
			mddData(symbol,1);

		}else{
			GblMsgBox("중복된 종목입니다.","");
			return;
		}
	}

	$('#mddSymbol').blur();

}

//조회기간
function mddPeriod(){
	sArr = new Array();
	c = 0;
	$('.mddTr').each(function(){
		sArr[c] = $(this).data('symbol');
		c++;
	});

	h = 46 + (70 * c);
	$('.mddTableDiv').css('min-height',''+h+'px');

	//기존 데이터 삭제
	$('.mddTr').remove();
	$('.mddMsg').remove();

	var chart01 = $('#mddGraph01').highcharts();
	var seriesLength = chart01.series.length;
	for(var i = seriesLength -1; i > -1; i--) {
		chart01.series[i].remove();
	}

	//달력 숨기기
	$(".calFromTo").hide();
	$(".calFromTo_s").hide();
	

	for(i=0; i<sArr.length; i++){
		symbol = sArr[i];

		if(symbol){
			if((i+1) == sArr.length){
				mddData(symbol,1);		//상승확률 그래프 그리기

			}else{
				mddData(symbol,0);
			}
		}

		sleep(200);		//지연함수
	}
}

//심볼 데이터 호출
function mddData(symbol,p){
	if(symbol){
		mddSdate = $('#mddSdate').val();
		mddEdate = $('#mddEdate').val();

		$.post('/module/json/mddData.php',{'symbol':symbol,'mddSdate':mddSdate,'mddEdate':mddEdate}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("종목을 확인해 주시기 바랍니다.");
				return;

			}else if(code == '99'){
				mddAdd(parData,p);

			}else{
				GblMsgBox("Error");
				return;
			}
		});	
	}
}

//테이블 & 그래프 추가
function mddAdd(parData,p){
	listNum = $("#mddTable tr").length;

	if(listNum > 3){
		GblMsgBox("최대 3개까지 확인이 가능합니다.",'');
		return;

	}else{
		//테이블 배경색
		trArr = new Array('','255,196,208,0.7','198,232,255,0.7','207,255,228,0.7');	//빨,파,초

		//그래프 색상
		lineArr = new Array('','#f86a87','#7cb5ec','#4bc0c0');	//빨,파,초
		bgArr = new Array('','248,106,135,0.7','57,161,232,0.7','64,255,149,0.7');	//빨,파,초

		//조회기간
		mddSdate = $('#mddSdate').val();
		mddEdate = $('#mddEdate').val();

		for(i=1; i<=3; i++){
			if($("#mddTr"+i).length == 0){

				trColor = trArr[i];
				lineColor = lineArr[i];
				bgColor = bgArr[i];

				//테이블(티커, From ~ 최대낙폭) 추가
				strHtml = "<tr id='mddTr"+i+"' class='mddTr' style='background-color:rgb("+trColor+");' data-symbol='"+parData['symbol']+"' data-hex='"+lineColor+"' data-c2='"+parData['cData02']+"'>";
				strHtml += "<td>"+parData['symbol']+"</td>";
				strHtml += "<td>"+mddSdate+"</td>";
				strHtml += "<td>"+mddEdate+"</td>";
				strHtml += "<td>"+parData['nowC']+"</td>";
				strHtml += "<td>"+parData['nowPer']+"%</td>";
				strHtml += "<td>"+parData['upPer']+"%</td>";
				strHtml += "<td>"+parData['pmDate']+"</td>";
				strHtml += "<td>"+parData['pmPer']+"%</td>";
				strHtml += "<td><a href='javascript://' class='mddDel' title='그래프제거'>-</a></td>"
				strHtml += "</tr>";
				$("#mddTable").append($(strHtml).fadeIn(200));

				strHtml = "<p class='mddMsg'>* "+parData['symbol']+" 현재 주가는 전고점대비 <span class='blue'>"+parData['nowPer']+"%</span>이고, 과거 데이터를 기반으로<br>보았을 때 상승확률은 <span class='red'>"+parData['upPer']+"%</span>입니다.</p>";
				$(".jm_search").append($(strHtml).fadeIn(200));




				//MDD 차트 추가(mddChart01.php)
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

				chart01 = $('#mddGraph01').highcharts();
				chart01.addSeries({
					type: 'area',
					name: parData['symbol'],
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


				//상승확률 그래프 추가(mddChart02.php)
				if(p){
					mddPer();
				}


				
				//사용자가 입력한 심볼값 초기화
				$('#mddSymbol').val('');

//				$('.remove').removeAttr('disabled');
				return;
			}
		}
	}
}

function mddPer(){
	var chart02 = $('#mddGraph02').highcharts();
	var seriesLength = chart02.series.length;
	for(var i = seriesLength -1; i > -1; i--) {
		chart02.series[i].remove();
	}

	sList = '';
	sArr = new Array();	//심볼
	cArr = new Array();	//색상
	dArr = new Array();	//x축 데이터
	c = 0;

	$('.mddTr').each(function(){
		if(sList)	sList += ',';
		sList += $(this).data('symbol');

		sArr[c] = $(this).data('symbol');
		cArr[c] = $(this).data('hex');
		dArr[c] = $(this).data('c2');

		c++;
	});

	

	if(sList){
		sDate = $('#mddSdate').val();
		eDate = $('#mddEdate').val();

		$.post('/module/json/mddDataCnt.php',{'sList':sList,'sDate':sDate,'eDate':eDate}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("종목을 확인해 주시기 바랍니다.");
				return;

			}else if(code == '99'){
				dataCnt = parData['max_percent'];

				for(c=0; c<sArr.length; c++){
					symbol = sArr[c];
					lineColor = cArr[c];
					hpp = dArr[c].split(',');


					let hppData = [];
					for (let i = 0; i < dataCnt; i++) {
					  hppprev = parseFloat(hpp[i]);
					  hppData.push({x: i, y: hppprev});
					}

					chart02 = $('#mddGraph02').highcharts();
					chart02.addSeries({
						type: 'spline',
						name: symbol,
						data: hppData, //첫번째 데이터값
						color: lineColor,
						marker: {
							enabled: true,
							radius: 0,
							symbol: 'dot'
						},
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
					});
				}


			}else{
				GblMsgBox("Error");
				return;
			}
		});	
	}
}

//선택 심볼(테이블, 그래프) 삭제
$(document).on('click', '.mddDel', function(){
	idx = $(".mddDel").index(this);

	//테이블 삭제
	tr = $(this).parent().parent();
	tr.remove();

	//현재주가 텍스트 삭제
	$('.mddMsg').eq(idx).remove();

	//mdd차트 삭제
	chart01 = $('#mddGraph01').highcharts();
	chart01.series[idx].remove();

	//mdd차트 삭제
	chart02 = $('#mddGraph02').highcharts();
	chart02.series[idx].remove();
});
</script>