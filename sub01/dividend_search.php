<script>
function dividendChk(){
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

	if(fChk == false){
		GblMsgBox("1개 이상의 검색 조건을 입력해 주시기 바랍니다.","");
	}else{
		form = document.frm_dividend;
		form.record_start.value = 0;

		$('#loading').show();
		$('#dividend_listTable').load('/sub01/dividend_result.php?jQueryLoad=1',$('#frm_dividend').serialize());
	}
}

function dividendReset(){
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
}
</script>

<form name='frm_dividend' id='frm_dividend' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type='text' style='display:none;'>
<input type='hidden' name='type' value=''>
<input type='hidden' name='next_url' value="<?=$_SERVER['PHP_SELF']?>">
<input type='hidden' name='record_count' value='<?=$record_count?>'>
<input type='hidden' name='record_start' value='<?=$record_start?>'>

<input type='hidden' name='call_page' value='<?=$call_page?>'><!-- GroupPortfolio(관심종목 or 포트폴리오) -->

	<div class="dividend_search">
		<div class="stock_filter_wrap">
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">주당 배당금</p>
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
						<option value="">==</option>
						<option value="0.1" <?if($fs01 == "0.1"){echo "selected";}?>>0.1$ 미만</option>
						<option value="1" <?if($fs01 == "1"){echo "selected";}?>>0.1~1$ 미만</option>
						<option value="2" <?if($fs01 == "2"){echo "selected";}?>>1~2$ 미만</option>
						<option value="5" <?if($fs01 == "5"){echo "selected";}?>>2~5$ 미만</option>
						<option value="10" <?if($fs01 == "10"){echo "selected";}?>>5~10$ 미만</option>
						<option value="11" <?if($fs01 == "11"){echo "selected";}?>>10$ 이상</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">시가 배당율 (연간)</p>
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
					<select name="fs02" id="fs02">
						<option value="">==</option>
						<option value="0.5" <?if($fs02 == "0.5"){echo "selected";}?>>0.5% 미만</option>
						<option value="1" <?if($fs02 == "1"){echo "selected";}?>>0.5~1% 미만</option>
						<option value="2" <?if($fs02 == "2"){echo "selected";}?>>1~2% 미만</option>
						<option value="3" <?if($fs02 == "3"){echo "selected";}?>>2~3% 미만</option>
						<option value="5" <?if($fs02 == "5"){echo "selected";}?>>3~5% 미만</option>
						<option value="10" <?if($fs02 == "10"){echo "selected";}?>>5~10% 미만</option>
						<option value="11" <?if($fs02 == "11"){echo "selected";}?>>10% 이상</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">배당빈도</p>
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
					<select name="fs03" id="fs03">
						<option value="">==</option>
						<option value="annual" <?if($fs03 == "annual"){echo "selected";}?>>연간배당</option>
						<option value="half" <?if($fs03 == "half"){echo "selected";}?>>반기배당</option>
						<option value="quarterly" <?if($fs03 == "quarterly"){echo "selected";}?>>분기배당</option>
						<option value="etc" <?if($fs03 == "etc"){echo "selected";}?>>연간 5회이상 배당</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">5년간 평균 배당 성장율</p>
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
					<select name="fs04" id="fs04">
						<option value="">==</option>
						<option value="1" <?if($fs04 == "1"){echo "selected";}?>>0%~5%</option>
						<option value="5" <?if($fs04 == "5"){echo "selected";}?>>5%~10%</option>
						<option value="10" <?if($fs04 == "10"){echo "selected";}?>>10%~15%</option>
						<option value="15" <?if($fs04 == "15"){echo "selected";}?>>15%~20%</option>
						<option value="20" <?if($fs04 == "20"){echo "selected";}?>>20%~25%</option>
						<option value="25" <?if($fs04 == "25"){echo "selected";}?>>25% 이상</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">고점대비 하락률 (MDD, 20년)</p>
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
					<select name="fs05" id="fs05">
						<option value="">==</option>
						<option value="1" <?if($fs05 == "1"){echo "selected";}?>>-20%~0%</option>
						<option value="20" <?if($fs05 == "20"){echo "selected";}?>>-40%~-20%</option>
						<option value="40" <?if($fs05 == "40"){echo "selected";}?>>-60%~-40%</option>
						<option value="60" <?if($fs05 == "60"){echo "selected";}?>>-80%~-60%</option>
						<option value="80" <?if($fs05 == "80"){echo "selected";}?>>-80% 미만</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">3달 수익률</p>
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
					<select name="fs06" id="fs06">
						<option value="">==</option>
						<option value="30" <?if($fs06 == "30"){echo "selected";}?>>+30% 이상</option>
						<option value="15" <?if($fs06 == "15"){echo "selected";}?>>+15~30%</option>
						<option value="1" <?if($fs06 == "1"){echo "selected";}?>>+0%~15%</option>
						<option value="-1" <?if($fs06 == "-1"){echo "selected";}?>>-15%~0%</option>
						<option value="-15" <?if($fs06 == "-15"){echo "selected";}?>>-30%~-15%</option>
						<option value="-30" <?if($fs06 == "-30"){echo "selected";}?>>-30% 미만</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">6달 수익률</p>
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
					<select name="fs07" id="fs07">
						<option value="">==</option>
						<option value="50" <?if($fs07 == "50"){echo "selected";}?>>+50% 이상</option>
						<option value="25" <?if($fs07 == "25"){echo "selected";}?>>+25~50%</option>
						<option value="1" <?if($fs07 == "1"){echo "selected";}?>>+0%~25%</option>
						<option value="-1" <?if($fs07 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs07 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs07 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">1년 수익률</p>
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
					<select name="fs08" id="fs08">
						<option value="">==</option>
						<option value="100" <?if($fs08 == "100"){echo "selected";}?>>+100% 이상</option>
						<option value="50" <?if($fs08 == "50"){echo "selected";}?>>+50~100%</option>
						<option value="25" <?if($fs08 == "25"){echo "selected";}?>>+25~50%</option>
						<option value="1" <?if($fs08 == "1"){echo "selected";}?>>+0%~25%</option>
						<option value="-1" <?if($fs08 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs08 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs08 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">5년 수익률</p>
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
					<select name="fs09" id="fs09">
						<option value="">==</option>
						<option value="500" <?if($fs09 == "500"){echo "selected";}?>>+500% 이상</option>
						<option value="300" <?if($fs09 == "300"){echo "selected";}?>>+300~500%</option>
						<option value="100" <?if($fs09 == "100"){echo "selected";}?>>+100~300%</option>
						<option value="50" <?if($fs09 == "50"){echo "selected";}?>>+50~100%</option>
						<option value="1" <?if($fs09 == "1"){echo "selected";}?>>+0%~50%</option>
						<option value="-1" <?if($fs09 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs09 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs09 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>
			<div class="filter_select">
				<div class="help_rel_flex">
					<p class="filterSec_tit">10년 수익률</p>
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
					<select name="fs10" id="fs10">
						<option value="">==</option>
						<option value="500" <?if($fs09 == "500"){echo "selected";}?>>+500% 이상</option>
						<option value="300" <?if($fs09 == "300"){echo "selected";}?>>+300~500%</option>
						<option value="100" <?if($fs09 == "100"){echo "selected";}?>>+100~300%</option>
						<option value="50" <?if($fs09 == "50"){echo "selected";}?>>+50~100%</option>
						<option value="1" <?if($fs09 == "1"){echo "selected";}?>>+0%~50%</option>
						<option value="-1" <?if($fs09 == "-1"){echo "selected";}?>>-25%~0%</option>
						<option value="-25" <?if($fs09 == "-25"){echo "selected";}?>>-50%~-25%</option>
						<option value="-50" <?if($fs09 == "-50"){echo "selected";}?>>-50% 미만</option>
					</select>
				</div>
			</div>

			<div class="dp_f dp_cc" style="margin-top:30px; width: 100%;">
				<a href="javascript:dividendChk();" style="margin:0 10px; border-radius: 10px; width: 180px; height: 40px; line-height: 40px; background-color: #0c1540; color: #fff; text-align: center; ">검색하기</a>
				<a href="javascript:dividendReset();" style="margin: 0 10px; border-radius: 10px; width: 180px; height: 40px; line-height: 40px; background-color: #0c1540; color: #fff; text-align: center; ">초기화</a>
			</div>
		</div>
	</div>

</form>