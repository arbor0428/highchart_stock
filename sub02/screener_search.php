<script>
function screenerChk(){
	fChk = false;

	if($("#fs01 option:selected").val())	fChk = true;
	if($("#fs02 option:selected").val())	fChk = true;
	if($("#fs03 option:selected").val())	fChk = true;
	if($("#fs04 option:selected").val())	fChk = true;
	if($("#fs05 option:selected").val())	fChk = true;
	if($("#fs06").val())						fChk = true;
	if($("#fs07").val())						fChk = true;
	if($("#fs08 option:selected").val())	fChk = true;
	if($("#fs09 option:selected").val())	fChk = true;
	if($("#fs10").val())						fChk = true;
	if($("#fs11 option:selected").val())	fChk = true;
	if($("#fs12 option:selected").val())	fChk = true;
	if($("#fs13 option:selected").val())	fChk = true;
	if($("#fs14 option:selected").val())	fChk = true;
	if($("#fs15 option:selected").val())	fChk = true;
	if($("#fs16 option:selected").val())	fChk = true;
	if($("#fs17 option:selected").val())	fChk = true;
	if($("#fs18 option:selected").val())	fChk = true;
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
	$("#fs06").val('');
	$("#fs07").val('');
	$("#fs08 option:eq(0)").prop("selected", true);
	$("#fs09 option:eq(0)").prop("selected", true);
	$("#fs10").val('');
	$("#fs11 option:eq(0)").prop("selected", true);
	$("#fs12 option:eq(0)").prop("selected", true);
	$("#fs13 option:eq(0)").prop("selected", true);
	$("#fs14 option:eq(0)").prop("selected", true);
	$("#fs15 option:eq(0)").prop("selected", true);
	$("#fs16 option:eq(0)").prop("selected", true);
	$("#fs17 option:eq(0)").prop("selected", true);
	$("#fs18 option:eq(0)").prop("selected", true);
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
					<p class="filterSec_tit">자산운용규모</p>
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
						<option value="50" <?if($fs01 == "50"){echo "selected";}?>>50B 이상</option>
						<option value="10" <?if($fs01 == "10"){echo "selected";}?>>10~50B</option>
						<option value="2" <?if($fs01 == "2"){echo "selected";}?>>2~10B</option>
						<option value="0.5" <?if($fs01 == "0.5"){echo "selected";}?>>0.5~2B</option>
						<option value="0.1" <?if($fs01 == "0.1"){echo "selected";}?>>0.1~0.5B</option>
						<option value="0.0" <?if($fs01 == "0.0"){echo "selected";}?>>0.1B 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">순자산가치</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs02" id="fs02">
						<option value=''>==</option>
						<option value="200" <?if($fs02 == "200"){echo "selected";}?>>200B 이상</option>
						<option value="100" <?if($fs02 == "100"){echo "selected";}?>>100~200B</option>
						<option value="50" <?if($fs02 == "50"){echo "selected";}?>>50~100B</option>
						<option value="25" <?if($fs02 == "25"){echo "selected";}?>>25~50B</option>
						<option value="10" <?if($fs02 == "10"){echo "selected";}?>>10~25B</option>
						<option value="5" <?if($fs02 == "5"){echo "selected";}?>>5~10B</option>
						<option value="4" <?if($fs01 == "4"){echo "selected";}?>>5B 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">수수료율</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs03" id="fs03">
						<option value=''>==</option>
						<option value="1" <?if($fs03 == "1"){echo "selected";}?>>1% 이상</option>
						<option value="0.5" <?if($fs03 == "0.5"){echo "selected";}?>>0.5%~1%</option>
						<option value="0.3" <?if($fs03 == "0.3"){echo "selected";}?>>0.3%~0.5%</option>
						<option value="0.2" <?if($fs03 == "0.2"){echo "selected";}?>>0.2%~0.3%</option>
						<option value="0.1" <?if($fs03 == "0.1"){echo "selected";}?>>0.1%~0.2%</option>
						<option value="0.0" <?if($fs03 == "0.0"){echo "selected";}?>>0.1% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">P/B</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs04" id="fs04">
						<option value=''>==</option>
						<option value="15" <?if($fs04 == "15"){echo "selected";}?>>15 이상</option>
						<option value="8" <?if($fs04 == "8"){echo "selected";}?>>8~15</option>
						<option value="4" <?if($fs04 == "4"){echo "selected";}?>>4~8</option>
						<option value="2" <?if($fs04 == "2"){echo "selected";}?>>2~4</option>
						<option value="1" <?if($fs04 == "1"){echo "selected";}?>>1~2</option>
						<option value="0.5" <?if($fs04 == "0.5"){echo "selected";}?>>0.5~1</option>
						<option value="0.4" <?if($fs04 == "0.4"){echo "selected";}?>>0.5 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">P/E</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs05" id="fs05">
						<option value=''>==</option>
						<option value="100" <?if($fs05 == "100"){echo "selected";}?>>100 이상</option>
						<option value="50" <?if($fs05 == "50"){echo "selected";}?>>50~100</option>
						<option value="25" <?if($fs05 == "25"){echo "selected";}?>>25~50</option>
						<option value="10" <?if($fs05 == "10"){echo "selected";}?>>10~25</option>
						<option value="5" <?if($fs05 == "5"){echo "selected";}?>>5~10</option>
						<option value="1" <?if($fs05 == "1"){echo "selected";}?>>1~5</option>
						<option value="0.9" <?if($fs05 == "0.9"){echo "selected";}?>>1 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">특정종목 포함 ETF</p>
				</div>
				<div class="filterSec_wrap">
					<input type='text' name='fs06' id='fs06' list='fs06List' value="<?=$fs06?>" placeholder="종목검색" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){screenerChk();}">
					<?
						$datalist_ID = 'fs06List';
						include '../module/dataList.php';
					?>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">특정 투자테마 ETF</p>
				</div>
				<div class="filterSec_wrap">
					<input type='text' name='fs07' id='fs07' list='fs07List' value="<?=$fs07?>" placeholder="검색" onkeypress="if(event.keyCode==13){screenerChk();}">
					<datalist id="fs07List">
					<?
						$dd = sqlArray("select investmentSegment from api_ETFs_Profile where investmentSegment!='' group by investmentSegment order by investmentSegment");
						foreach($dd as $v){
							echo "<option value='".$v['investmentSegment']."'>".$v['investmentSegment']."</option>";
						}
					?>
					</datalist>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">보유종목수</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs08" id="fs08">
						<option value=''>==</option>
						<option value="5000" <?if($fs08 == "5000"){echo "selected";}?>>5000 이상</option>
						<option value="1000" <?if($fs08 == "1000"){echo "selected";}?>>1000~5000</option>
						<option value="500" <?if($fs08 == "500"){echo "selected";}?>>500~1000</option>
						<option value="250" <?if($fs08 == "250"){echo "selected";}?>>250~500</option>
						<option value="100" <?if($fs08 == "100"){echo "selected";}?>>100~250</option>
						<option value="50" <?if($fs08 == "50"){echo "selected";}?>>50~100</option>
						<option value="25" <?if($fs08 == "25"){echo "selected";}?>>25~50</option>
						<option value="24" <?if($fs08 == "24"){echo "selected";}?>>25 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">추적인덱스</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs09" id="fs09">
						<option value=''>==</option>
					<?
						$trackArr = Array("S&P 500","Russell 2000","S&P Mid Cap 400","LBMA Gold Price PM ($/ozt)","NASDAQ-100 Index","S&P Small Cap 600","U.S. Treasury 20+ Year Index","DJ Industrial Average","FTSE China 50 Net Tax USD (TR)","ICE BofA US Treasury (7-10 Y)","MSCI EM (Emerging Markets)","Bloomberg US Aggregate","MSCI Brazil 25-50","MSCI EAFE","NYSE FANG (TR)","Russell 1000 Growth","S&P 500 VIX SHORT-TERM FUTURES  TR","USD/EUR Exchange Rate");

						foreach($trackArr as $v){
							if($fs09 == $v)	$chk = 'selected';
							else					$chk = '';

							echo ("<option value='$v' $chk>$v</option>");
						}
					?>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">운용회사</p>
				</div>
				<div class="filterSec_wrap">
					<input type='text' name='fs10' id='fs10' list='fs10List' value="<?=$fs10?>" placeholder="검색" onkeypress="if(event.keyCode==13){screenerChk();}">
					<datalist id="fs10List">
					<?
						$dd = sqlArray("select etfCompany from api_ETFs_Profile where etfCompany!='' group by etfCompany order by etfCompany");
						foreach($dd as $v){
							echo "<option value='".$v['etfCompany']."'>".$v['etfCompany']."</option>";
						}
					?>
					</datalist>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">시가분배율 TTM</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs11" id="fs11">
						<option value=''>==</option>
						<option value="10" <?if($fs11 == "10"){echo "selected";}?>>10% 이상</option>
						<option value="5" <?if($fs11 == "5"){echo "selected";}?>>5%~10%</option>
						<option value="3" <?if($fs11 == "3"){echo "selected";}?>>3%~5%</option>
						<option value="2" <?if($fs11 == "2"){echo "selected";}?>>2%~3%</option>
						<option value="1" <?if($fs11 == "1"){echo "selected";}?>>1%~2%</option>
						<option value="0.9" <?if($fs11 == "0.9"){echo "selected";}?>>0%~1%</option>
						<option value="0.0" <?if($fs11 == "0.0"){echo "selected";}?>>0%</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">1주당 가격</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs12" id="fs12">
						<option value=''>==</option>
						<option value="200" <?if($fs12 == "200"){echo "selected";}?>>200$ 이상</option>
						<option value="100" <?if($fs12 == "100"){echo "selected";}?>>100$~200$</option>
						<option value="50" <?if($fs12 == "50"){echo "selected";}?>>50$~100$</option>
						<option value="20" <?if($fs12 == "20"){echo "selected";}?>>20$~50$</option>
						<option value="10" <?if($fs12 == "10"){echo "selected";}?>>10$~20$</option>
						<option value="1" <?if($fs12 == "1"){echo "selected";}?>>10$ 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">평균거래량</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs13" id="fs13">
						<option value=''>==</option>
						<option value="5000" <?if($fs13 == "5000"){echo "selected";}?>>5,000만 이상</option>
						<option value="1000" <?if($fs13 == "1000"){echo "selected";}?>>1,000만~5,000만</option>
						<option value="200" <?if($fs13 == "200"){echo "selected";}?>>200만~1,000만</option>
						<option value="50" <?if($fs13 == "50"){echo "selected";}?>>50만~200만</option>
						<option value="10" <?if($fs13 == "10"){echo "selected";}?>>10만~50만</option>
						<option value="1" <?if($fs13 == "1"){echo "selected";}?>>10만 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">상장일</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs14" id="fs14">
						<option value=''>==</option>
						<option value="1990" <?if($fs14 == "1990"){echo "selected";}?>>1990년 이전</option>
						<option value="2000" <?if($fs14 == "2000"){echo "selected";}?>>1990년~2000년</option>
						<option value="2010" <?if($fs14 == "2010"){echo "selected";}?>>2000년~2010년</option>
						<option value="2020" <?if($fs14 == "2020"){echo "selected";}?>>2010년~2020년</option>
						<option value="2030" <?if($fs14 == "2030"){echo "selected";}?>>2020년 이후</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">레버리지/인버스 ETF</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs15" id="fs15">
						<option value=''>==</option>
						<option value="x2" <?if($fs15 == "x2"){echo "selected";}?>>2x</option>
						<option value="x3" <?if($fs15 == "x3"){echo "selected";}?>>3x</option>
						<option value="inverse" <?if($fs15 == "inverse"){echo "selected";}?>>인버스</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">1달 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs16" id="fs16">
						<option value=''>==</option>
						<option value="20" <?if($fs16 == "20"){echo "selected";}?>>+20% 이상</option>
						<option value="10" <?if($fs16 == "10"){echo "selected";}?>>+10~20%</option>
						<option value="1" <?if($fs16 == "1"){echo "selected";}?>>+0%~10%</option>
						<option value="-1" <?if($fs16 == "-1"){echo "selected";}?>>-10%~0%</option>
						<option value="-10" <?if($fs16 == "-10"){echo "selected";}?>>-20%~-10%</option>
						<option value="-20" <?if($fs16 == "-20"){echo "selected";}?>>-20% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">3달 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs17" id="fs17">
						<option value=''>==</option>
						<option value="30" <?if($fs17 == "30"){echo "selected";}?>>+30% 이상</option>
						<option value="15" <?if($fs17 == "15"){echo "selected";}?>>+15~30%</option>
						<option value="1" <?if($fs17 == "1"){echo "selected";}?>>+0%~15%</option>
						<option value="-1" <?if($fs17 == "-1"){echo "selected";}?>>-15%~0%</option>
						<option value="-15" <?if($fs17 == "-15"){echo "selected";}?>>-30%~-15%</option>
						<option value="-30" <?if($fs17 == "-30"){echo "selected";}?>>-30% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">6달 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs18" id="fs18">
						<option value=''>==</option>
						<option value="50" <?if($fs18 == "50"){echo "selected";}?>>+50% 이상</option>
						<option value="25" <?if($fs18 == "25"){echo "selected";}?>>+25~50%</option>
						<option value="1" <?if($fs18 == "1"){echo "selected";}?>>+0%~25%</option>
						<option value="-1" <?if($fs18 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs18 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs18 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">1년 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs19" id="fs19">
						<option value=''>==</option>
						<option value="100" <?if($fs19 == "100"){echo "selected";}?>>+100% 이상</option>
						<option value="50" <?if($fs19 == "50"){echo "selected";}?>>+50~100%</option>
						<option value="25" <?if($fs19 == "25"){echo "selected";}?>>+25~50%</option>
						<option value="1" <?if($fs19 == "1"){echo "selected";}?>>+0%~25%</option>
						<option value="-1" <?if($fs19 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs19 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs19 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>

			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">5년 수익률</p>
				</div>
				<div class="filterSec_wrap">
					<select name="fs20" id="fs20">
						<option value=''>==</option>
						<option value="500" <?if($fs20 == "500"){echo "selected";}?>>+500% 이상</option>
						<option value="300" <?if($fs20 == "300"){echo "selected";}?>>+300~500%</option>
						<option value="100" <?if($fs20 == "100"){echo "selected";}?>>+100~300%</option>
						<option value="50" <?if($fs20 == "50"){echo "selected";}?>>+50~100%</option>
						<option value="1" <?if($fs20 == "1"){echo "selected";}?>>+0%~50%</option>
						<option value="-1" <?if($fs20 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs20 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs20 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>

			<div class="dp_f dp_cc" style="margin-top:30px; width: 100%;">
				<a href="javascript:screenerChk();" style="margin:0 10px; border-radius: 10px; width: 180px; height: 40px; line-height: 40px; background-color: #0c1540; color: #fff; text-align: center; ">검색하기</a>
				<a href="javascript:screenerReset();" style="margin: 0 10px; border-radius: 10px; width: 180px; height: 40px; line-height: 40px; background-color: #0c1540; color: #fff; text-align: center; ">초기화</a>
			</div>
		</div>

</form>