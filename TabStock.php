<script>
function stockFilter(){
	$('#loading').show();
	$('#TabStockResult').load('TabStockResult.php?jQueryLoad=1',$('#frm_stock_filter').serialize());
}
</script>

<?
	//필터 기본값
	if($fs01_01 == '' && $fs01_02 == '' && $fs01_03 == '' && $fs01_04 == ''){
		$fs01_01 = '1';
	}

	if($fs02_01 == '' && $fs02_02 == '' && $fs02_03 == '' && $fs02_04 == '' && $fs02_05 == ''){
		$fs02_01 = '1';
		$fs02_02 = '1';
		$fs02_03 = '1';
		$fs02_04 = '1';
		$fs02_05 = '1';
	}

	if($fs03_01 == '' && $fs03_02 == '' && $fs03_03 == '' && $fs03_04 == ''){
		$fs03_01 = '1';
		$fs03_02 = '1';
	}

	if($fs04_01 == '' && $fs04_02 == '' && $fs04_03 == '' && $fs04_04 == '' && $fs04_05 == ''){
		$fs04_01 = '1';
		$fs04_02 = '1';
		$fs04_03 = '1';
		$fs04_04 = '1';
		$fs04_05 = '1';
	}
?>

		<div class="etf_tab_wrap etf_tab_wrap01">
			<div class="tab_flex_wrap">

				<form name='frm_stock_filter' id='frm_stock_filter' method='post'>
				<input type='text' style='display:none;'>

				<div class="option_sideBar">
					<div class="sideBar_top">
						<p>주식 필터링</p>
					</div>
					<div class="sideBar_bot wid100">
						<div class="typeBox">
							<h4 class="main_type">지수 편입 종목</h4>
							<div class="sub_type">
								<div class="side_choice">
									<input id="sc_a1" type="checkbox" name="fs01_01" value="1" <?if($fs01_01 == "1"){echo "checked";}?>><label for="sc_a1">S & P 500</label>
								</div>
								<div class="side_choice">
									<input id="sc_a2" type="checkbox" name="fs01_02" value="2" <?if($fs01_02 == "2"){echo "checked";}?>><label for="sc_a2">나스닥 100</label>
								</div>
								<div class="side_choice">
									<input id="sc_a3" type="checkbox" name="fs01_03" value="3" <?if($fs01_03 == "3"){echo "checked";}?>><label for="sc_a3">Rusell 2000</label>
								</div>
								<div class="side_choice">
									<input id="sc_a4" type="checkbox" name="fs01_04" value="4" <?if($fs01_04 == "4"){echo "checked";}?>><label for="sc_a4">미국주식 전체</label>
								</div>
							</div>
							<div class="sub_type">
								<p class="sub_type_tit">시가 총액</p>
								<div class="side_choice">
									<input id="sc_b1" type="checkbox" name="fs02_01" value="1" <?if($fs02_01){echo "checked";}?>><label for="sc_b1">Mega (<span style='font-size:14px;'>2,000억달러 이상</span>)</label>
								</div>
								<div class="side_choice">
									<input id="sc_b2" type="checkbox" name="fs02_02" value="1" <?if($fs02_02){echo "checked";}?>><label for="sc_b2">Large (<span style='font-size:14px;'>100억~2,000억달러</span>)</label>
								</div>
								<div class="side_choice">
									<input id="sc_b3" type="checkbox" name="fs02_03" value="1" <?if($fs02_03){echo "checked";}?>><label for="sc_b3">Medium (<span style='font-size:14px;'>20억~100억달러</span>)</label>
								</div>
							<!--
								<div class="side_choice">
									<input id="sc_b4" type="checkbox" name="fs02_04" value="1" <?if($fs02_04){echo "checked";}?>><label for="sc_b4">Small (<span style='font-size:14px;'>3억~20억달러</span>)</label>
								</div>
								<div class="side_choice">
									<input id="sc_b5" type="checkbox" name="fs02_05" value="1" <?if($fs02_05){echo "checked";}?>><label for="sc_b5">Micro (<span style='font-size:14px;'>3억달러 미만</span>)</label>
								</div>
							-->
							</div>
						</div>
						<div class="typeBox">
							<h4 class="main_type">전문가 의견</h4>
							<div class="sub_type">
								<div class="side_choice">
									<input id="sc_c1" type="checkbox" name="fs03_01" value="1" <?if($fs03_01){echo "checked";}?>><label for="sc_c1">강력매수 (<span style='font-size:14px;'>4.5 이상</span>)</label>
								</div>
								<div class="side_choice">
									<input id="sc_c2" type="checkbox" name="fs03_02" value="1" <?if($fs03_02){echo "checked";}?>><label for="sc_c2">매수 이상 (<span style='font-size:14px;'>3.5 ~ 4.5</span>)</label>
								</div>
								<div class="side_choice">
									<input id="sc_c3" type="checkbox" name="fs03_03" value="1" <?if($fs03_03){echo "checked";}?>><label for="sc_c3">중립 이상 (<span style='font-size:14px;'>2.5 ~ 3.5</span>)</label>
								</div>
								<div class="side_choice">
									<input id="sc_c4" type="checkbox" name="fs03_04" value="1" <?if($fs03_04){echo "checked";}?>><label for="sc_c4">중립 미만 (<span style='font-size:14px;'>2.5 미만</span>)</label>
								</div>
							</div>
						</div>
						<div class="typeBox">
							<h4 class="main_type">한주당 가격</h4>
							<div class="sub_type">
								<div class="side_choice">
									<input id="sc_d1" type="checkbox" name="fs04_01" value="1" <?if($fs04_01){echo "checked";}?>><label for="sc_d1">10 미만</label>
								</div>
								<div class="side_choice">
									<input id="sc_d2" type="checkbox" name="fs04_02" value="1" <?if($fs04_02){echo "checked";}?>><label for="sc_d2">10 ~ 20 미만</label>
								</div>
								<div class="side_choice">
									<input id="sc_d3" type="checkbox" name="fs04_03" value="1" <?if($fs04_03){echo "checked";}?>><label for="sc_d3">20 ~ 30 미만</label>
								</div>
								<div class="side_choice">
									<input id="sc_d4" type="checkbox" name="fs04_04" value="1" <?if($fs04_04){echo "checked";}?>><label for="sc_d4">30 ~ 50 미만</label>
								</div>
								<div class="side_choice">
									<input id="sc_d5" type="checkbox" name="fs04_05" value="1" <?if($fs04_05){echo "checked";}?>><label for="sc_d5">50이상</label>
								</div>
							</div>
						</div>
						<a class="submitBtn dp_f dp_cc dp_c" href="javascript:stockFilter();" title="적용하기">적용하기</a>
					</div>
				</div>
				</form>


				<div class="etf_tab_flex wid951" id='TabStockResult'>
				<?
					//결과값
					include 'TabStockResult.php';
				?>
				</div>
			</div>
		</div>