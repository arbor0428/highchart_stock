<script>
function screenerChk(){
	fChk = false;

	if($("#fs01 option:selected").val())	fChk = true;
	if($("#fs02 option:selected").val())	fChk = true;
	if($("#fs03 option:selected").val())	fChk = true;
	if($("#fs04 option:selected").val())	fChk = true;
	if($("#fs05 option:selected").val())	fChk = true;
	if($("#fs06 option:selected").val())	fChk = true;
	if($("#fs07 option:selected").val())	fChk = true;
	if($("#fs08 option:selected").val())	fChk = true;
	if($("#fs09 option:selected").val())	fChk = true;
	if($("#fs10 option:selected").val())	fChk = true;
	if($("#fs11 option:selected").val())	fChk = true;
	if($("#fs12 option:selected").val())	fChk = true;
	if($("#fs13 option:selected").val())	fChk = true;
	if($("#fs14 option:selected").val())	fChk = true;
	if($("#fs15 option:selected").val())	fChk = true;
	if($("#fs16 option:selected").val())	fChk = true;
	if($("#fs17 option:selected").val())	fChk = true;
	if($("#fs18").val())						fChk = true;
	if($("#fs19 option:selected").val())	fChk = true;
	if($("#fs20 option:selected").val())	fChk = true;

	if(fChk == false){
		GblMsgBox("1개 이상의 검색 조건을 입력해 주시기 바랍니다.","");
	}else{
		form = document.frm_screener;
		form.record_start.value = 0;
		form.submit();
	}
}

function screenerReset(){
	$("#fs01 option:eq(0)").prop("selected", true);
	$("#fs02 option:eq(0)").prop("selected", true);
	$("#fs03 option:eq(0)").prop("selected", true);
	$("#fs04 option:eq(0)").prop("selected", true);
	$("#fs05 option:eq(0)").prop("selected", true);
	$("#fs06 option:eq(0)").prop("selected", true);
	$("#fs07 option:eq(0)").prop("selected", true);
	$("#fs08 option:eq(0)").prop("selected", true);
	$("#fs09 option:eq(0)").prop("selected", true);
	$("#fs10 option:eq(0)").prop("selected", true);
	$("#fs11 option:eq(0)").prop("selected", true);
	$("#fs12 option:eq(0)").prop("selected", true);
	$("#fs13 option:eq(0)").prop("selected", true);
	$("#fs14 option:eq(0)").prop("selected", true);
	$("#fs15 option:eq(0)").prop("selected", true);
	$("#fs16 option:eq(0)").prop("selected", true);
	$("#fs17 option:eq(0)").prop("selected", true);
	$("#fs18").val('');
	$("#fs19 option:eq(0)").prop("selected", true);
	$("#fs20 option:eq(0)").prop("selected", true);
}
</script>

<form name='frm_screener' id='frm_screener' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type='text' style='display:none;'>
<input type='hidden' name='type' value=''>
<input type='hidden' name='listFocus' value='1'>
<input type='hidden' name='next_url' value="<?=$_SERVER['PHP_SELF']?>">
<input type='hidden' name='record_count' value='<?=$record_count?>'>
<input type='hidden' name='record_start' value='<?=$record_start?>'>

<input type='hidden' name='call_page' value='<?=$call_page?>'><!-- GroupPortfolio(관심종목 or 포트폴리오) -->



		<h3 class="sub_tit mar20">Stock Screener</h3>
		<p class="sub_tit_p">Unique signals와 데이터가 있는 사용하기 쉬운 스크리너. 주식 성과에 대한 포괄적인 개요를 참조하십시오. 미국에서 가장 실적이 좋은 분석가가 추천하는 주식을 보려면 필터링하십시오.</p>
		<div class="stock_filter_wrap">

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">시가총액</p>
					<!--
					<div class="help_wrap">
						<div class="ques_mark help_point">
							<span>?</span>
						</div>
						<div class="helpbox">
							<p>Stock Screener Results 입니다.</p>
						</div>
					</div>
					-->
				</div>
				<div class="filterSec_wrap">
					<select name="fs01" id="fs01">
						<option value=''>==</option>
						<option value="Mega" <?if($fs01 == "Mega"){echo "selected";}?>>Mega(2,000억달러 이상)</option>
						<option value="Large" <?if($fs01 == "Large"){echo "selected";}?>>Large(100억~2,000억달러)</option>
						<option value="Medium" <?if($fs01 == "Medium"){echo "selected";}?>>Medium(20억~100억달러</option>
						<option value="Small" <?if($fs01 == "Small"){echo "selected";}?>>Small(3억~20억달러</option>
						<option value="Micro" <?if($fs01 == "Micro"){echo "selected";}?>>Micro(3억달러 미만)</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">섹터</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs02" id="fs02">
						<option value=''>==</option>
					<?
						foreach($gsSectorEtfArr as $k => $v){
							if($k == $fs02)		$chk = 'selected';
							else					$chk ='';

							echo ("<option value='$k' $chk>$k</option>");
						}
					?>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">대표지수종목</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs03" id="fs03">
						<option value=''>==</option>
						<option value="^GSPC" <?if($fs03 == "^GSPC"){echo "selected";}?>>S&P 500</option>
						<option value="^NDX" <?if($fs03 == "^NDX"){echo "selected";}?>>nasdaq 100</option>
						<option value="^DJI" <?if($fs03 == "^DJI"){echo "selected";}?>>Dow Jones</option>
						<option value="^RUT" <?if($fs03 == "^RUT"){echo "selected";}?>>Russell 2000</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">5년간 평균 배당수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs04" id="fs04">
						<option value=''>==</option>
						<option value="1" <?if($fs04 == "1"){echo "selected";}?>>0%</option>
						<option value="2" <?if($fs04 == "2"){echo "selected";}?>>0~2%</option>
						<option value="3" <?if($fs04 == "3"){echo "selected";}?>>2~4%</option>
						<option value="4" <?if($fs04 == "4"){echo "selected";}?>>2~4%</option>
						<option value="6" <?if($fs04 == "6"){echo "selected";}?>>6% 이상</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">S&P500 대비 아웃퍼폼(6개월)</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs05" id="fs05">
						<option value=''>==</option>
						<option value="20" <?if($fs05 == "20"){echo "selected";}?>>+20% 이상</option>
						<option value="10" <?if($fs05 == "10"){echo "selected";}?>>+10~20%</option>
						<option value="1" <?if($fs05 == "1"){echo "selected";}?>>+0%~10%</option>
						<option value="-1" <?if($fs05 == "-1"){echo "selected";}?>>-10%~0%</option>
						<option value="-10" <?if($fs05 == "-10"){echo "selected";}?>>-20%~-10%</option>
						<option value="-20" <?if($fs05 == "-20"){echo "selected";}?>>-20% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">현주가 대비 목표주가</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs06" id="fs06">
						<option value=''>==</option>
						<option value="20" <?if($fs06 == "20"){echo "selected";}?>>+20% 이상</option>
						<option value="10" <?if($fs06 == "10"){echo "selected";}?>>+10~20%</option>
						<option value="1" <?if($fs06 == "1"){echo "selected";}?>>+0%~10%</option>
						<option value="-1" <?if($fs06 == "-1"){echo "selected";}?>>-10%~0%</option>
						<option value="-10" <?if($fs06 == "-10"){echo "selected";}?>>-20%~-10%</option>
						<option value="-20" <?if($fs06 == "-20"){echo "selected";}?>>-20% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">에널리스트 컨센서스</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs07" id="fs07">
						<option value=''>==</option>
						<option value="strongSell" <?if($fs07 == "strongSell"){echo "selected";}?>>강력매도</option>
						<option value="sell" <?if($fs07 == "sell"){echo "selected";}?>>매도</option>
						<option value="hold" <?if($fs07 == "hold"){echo "selected";}?>>중립</option>
						<option value="buy" <?if($fs07 == "buy"){echo "selected";}?>>매수</option>
						<option value="strongBuy" <?if($fs07 == "strongBuy"){echo "selected";}?>>강력매수</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">최근 에널리스트 컨센서스 변화</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs08" id="fs08">
						<option value=''>==</option>
						<option value="up" <?if($fs08 == "up"){echo "selected";}?>>상향</option>
						<option value="down" <?if($fs08 == "down"){echo "selected";}?>>하향</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">과거 3년간 연간 평균 EPS 상승률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs09" id="fs09">
						<option value=''>==</option>
						<option value="1" <?if($fs09 == "1"){echo "selected";}?>>0%~5%</option>
						<option value="5" <?if($fs09 == "5"){echo "selected";}?>>5%~10%</option>
						<option value="10" <?if($fs09 == "10"){echo "selected";}?>>10%~15%</option>
						<option value="15" <?if($fs09 == "15"){echo "selected";}?>>15%~20%</option>
						<option value="20" <?if($fs09 == "20"){echo "selected";}?>>20%~25%</option>
						<option value="25" <?if($fs09 == "25"){echo "selected";}?>>25% 이상</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">미래 3년간 EPS 예상 상승률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs10" id="fs10">
						<option value=''>==</option>
						<option value="1" <?if($fs10 == "1"){echo "selected";}?>>0%~5%</option>
						<option value="5" <?if($fs10 == "5"){echo "selected";}?>>5%~10%</option>
						<option value="10" <?if($fs10 == "10"){echo "selected";}?>>10%~15%</option>
						<option value="15" <?if($fs10 == "15"){echo "selected";}?>>15%~20%</option>
						<option value="20" <?if($fs10 == "20"){echo "selected";}?>>20%~25%</option>
						<option value="25" <?if($fs10 == "25"){echo "selected";}?>>25% 이상</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">1달 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs11" id="fs11">
						<option value=''>==</option>
						<option value="20" <?if($fs11 == "20"){echo "selected";}?>>+20% 이상</option>
						<option value="10" <?if($fs11 == "10"){echo "selected";}?>>+10~20%</option>
						<option value="1" <?if($fs11 == "1"){echo "selected";}?>>+0%~10%</option>
						<option value="-1" <?if($fs11 == "-1"){echo "selected";}?>>-10%~0%</option>
						<option value="-10" <?if($fs11 == "-10"){echo "selected";}?>>-20%~-10%</option>
						<option value="-20" <?if($fs11 == "-20"){echo "selected";}?>>-20% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">3달 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs12" id="fs12">
						<option value=''>==</option>
						<option value="30" <?if($fs12 == "30"){echo "selected";}?>>+30% 이상</option>
						<option value="15" <?if($fs12 == "15"){echo "selected";}?>>+15~30%</option>
						<option value="1" <?if($fs12 == "1"){echo "selected";}?>>+0%~15%</option>
						<option value="-1" <?if($fs12 == "-1"){echo "selected";}?>>-15%~0%</option>
						<option value="-15" <?if($fs12 == "-15"){echo "selected";}?>>-30%~-15%</option>
						<option value="-30" <?if($fs12 == "-30"){echo "selected";}?>>-30% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">6달 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs13" id="fs13">
						<option value=''>==</option>
						<option value="50" <?if($fs13 == "50"){echo "selected";}?>>+50% 이상</option>
						<option value="25" <?if($fs13 == "25"){echo "selected";}?>>+25~50%</option>
						<option value="1" <?if($fs13 == "1"){echo "selected";}?>>+0%~25%</option>
						<option value="-1" <?if($fs13 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs13 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs13 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">1년 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs14" id="fs14">
						<option value=''>==</option>
						<option value="100" <?if($fs14 == "100"){echo "selected";}?>>+100% 이상</option>
						<option value="50" <?if($fs14 == "50"){echo "selected";}?>>+50~100%</option>
						<option value="25" <?if($fs14 == "25"){echo "selected";}?>>+25~50%</option>
						<option value="1" <?if($fs14 == "1"){echo "selected";}?>>+0%~25%</option>
						<option value="-1" <?if($fs14 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs14 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs14 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">5년 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs15" id="fs15">
						<option value=''>==</option>
						<option value="500" <?if($fs15 == "500"){echo "selected";}?>>+500% 이상</option>
						<option value="300" <?if($fs15 == "300"){echo "selected";}?>>+300~500%</option>
						<option value="100" <?if($fs15 == "100"){echo "selected";}?>>+100~300%</option>
						<option value="50" <?if($fs15 == "50"){echo "selected";}?>>+50~100%</option>
						<option value="1" <?if($fs15 == "1"){echo "selected";}?>>+0%~50%</option>
						<option value="-1" <?if($fs15 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs15 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs15 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">상세 산업군</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs16" id="fs16">
						<option value=''>==</option>
					<?
						foreach($gindArr as $v){
							if($v == $fs16)	$chk = 'selected';
							else					$chk ='';

							echo ("<option value='$v' $chk>$v</option>");
						}
					?>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">전고점 대비 하락률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs17" id="fs17">
						<option value=''>==</option>
						<option value="1" <?if($fs17 == "1"){echo "selected";}?>>-20%~0%</option>
						<option value="20" <?if($fs17 == "20"){echo "selected";}?>>-40%~-20%</option>
						<option value="40" <?if($fs17 == "40"){echo "selected";}?>>-60%~-40%</option>
						<option value="60" <?if($fs17 == "60"){echo "selected";}?>>-80%~-60%</option>
						<option value="80" <?if($fs17 == "80"){echo "selected";}?>>-80% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">특정 ETF 구성종목만 보기</p>
				</div>
				<div class="filterSec_wrap">
					<input type='text' name='fs18' id='fs18' list='fs18List' value="<?=$fs18?>" placeholder="종목검색" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){screenerChk();}">
					<?
						$datalist_ID = 'fs18List';
						include '../module/dataList.php';
					?>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">베타(지수대비 변동성지수)</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs19" id="fs19">
						<option value=''>==</option>
						<option value="3.5" <?if($fs19 == "3.5"){echo "selected";}?>>3.5 이상</option>
						<option value="2" <?if($fs19 == "2"){echo "selected";}?>>2 이상~3.5 미만</option>
						<option value="1.5" <?if($fs19 == "1.5"){echo "selected";}?>>1.5 이상~2 미만</option>
						<option value="1" <?if($fs19 == "1"){echo "selected";}?>>1 이상~1.5 미만</option>
						<option value="0.5" <?if($fs19 == "0.5"){echo "selected";}?>>0.5 이상~1 미만</option>
						<option value="0.4" <?if($fs19 == "0.4"){echo "selected";}?>>0.5 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">NLP모델로 분석한 종목 뉴스 스코어</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs20" id="fs20">
						<option value=''>==</option>
						<option value="0.8" <?if($fs20 == "0.8"){echo "selected";}?>>0.8 이상</option>
						<option value="0.6" <?if($fs20 == "0.6"){echo "selected";}?>>0.6~0.8</option>
						<option value="0.4" <?if($fs20 == "0.4"){echo "selected";}?>>0.4~0.6</option>
						<option value="0.2" <?if($fs20 == "0.2"){echo "selected";}?>>0.2~0.4</option>
						<option value="0.1" <?if($fs20 == "0.1"){echo "selected";}?>>0.2 미만</option>
					</select>
				</div>
			</div>
			<div class="dp_f dp_cc" style="margin-top:30px; width: 100%;">
				<a href="javascript:screenerChk();" style="margin:0 10px; border-radius: 10px; width: 180px; height: 40px; line-height: 40px; background-color: #0c1540; color: #fff; text-align: center; ">검색하기</a>
				<a href="javascript:screenerReset();" style="margin: 0 10px; border-radius: 10px; width: 180px; height: 40px; line-height: 40px; background-color: #0c1540; color: #fff; text-align: center; ">초기화</a>
			</div>
		</div>

</form>