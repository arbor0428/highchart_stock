<script>
function etfFilter(){
	$('#loading').show();
	$('#TabEtfResult').load('TabETFResult.php?jQueryLoad=1',$('#frm_etf_filter').serialize());
}
</script>

<?
	//필터 기본값
	if($fe01_01 == '' && $fe01_02 == '' && $fe01_03 == '' && $fe01_04 == '' && $fe01_05 == '' && $fe01_06 == ''){
		$fe01_01 = '1';
		$fe01_02 = '1';
	}

	if($fe02_01 == '' && $fe02_02 == '' && $fe02_03 == '' && $fe02_04 == '' && $fe02_05 == '' && $fe02_06 == ''){
		$fe02_01 = '1';
		$fe02_02 = '1';
		$fe02_03 = '1';
		$fe02_04 = '1';
		$fe02_05 = '1';
		$fe02_06 = '1';
	}

	if($fe03_01 == '' && $fe03_02 == '' && $fe03_03 == '' && $fe03_04 == '' && $fe03_05 == '' && $fe03_06 == ''){
		$fe03_01 = '1';
		$fe03_02 = '1';
		$fe03_03 = '1';
	}

	if($fe04_01 == '' && $fe04_02 == '' && $fe04_03 == '' && $fe04_04 == '' && $fe04_05 == '' && $fe04_06 == ''){
		$fe04_01 = '1';
		$fe04_02 = '1';
		$fe04_03 = '1';
		$fe04_04 = '1';
		$fe04_05 = '1';
		$fe04_06 = '1';
	}
?>

		<div class="etf_tab_wrap etf_tab_wrap02">
			<div class="tab_flex_wrap">

				<form name='frm_etf_filter' id='frm_etf_filter' method='post'>
				<input type='text' style='display:none;'>

				<div class="option_sideBar">
					<div class="sideBar_top">
						<p>ETF 필터링</p>
					</div>
					<div class="sideBar_bot wid100">
						<div class="typeBox">
							<h4 class="main_type">자산운영규모</h4>
							<div class="sub_type">
								<div class="side_choice">
									<input id="ec_a1" type="checkbox" name="fe01_01" value="1" <?if($fe01_01 == "1"){echo "checked";}?>><label for="ec_a1">50B 이상</label>
								</div>
								<div class="side_choice">
									<input id="ec_a2" type="checkbox" name="fe01_02" value="1" <?if($fe01_02 == "1"){echo "checked";}?>><label for="ec_a2">10~50B</label>
								</div>
								<div class="side_choice">
									<input id="ec_a3" type="checkbox" name="fe01_03" value="1" <?if($fe01_03 == "1"){echo "checked";}?>><label for="ec_a3">2~10B</label>
								</div>
								<div class="side_choice">
									<input id="ec_a4" type="checkbox" name="fe01_04" value="1" <?if($fe01_04 == "1"){echo "checked";}?>><label for="ec_a4">0.5~2B</label>
								</div>
								<div class="side_choice">
									<input id="ec_a5" type="checkbox" name="fe01_05" value="1" <?if($fe01_05 == "1"){echo "checked";}?>><label for="ec_a5">0.1~0.5B</label>
								</div>
								<div class="side_choice">
									<input id="ec_a6" type="checkbox" name="fe01_06" value="1" <?if($fe01_06 == "1"){echo "checked";}?>><label for="ec_a6">0.1B 미만</label>
								</div>
							</div>
							<h4 class="main_type">수수료율</h4>
							<div class="sub_type">
								<div class="side_choice">
									<input id="ec_b1" type="checkbox" name="fe02_01" value="1" <?if($fe02_01 == "1"){echo "checked";}?>><label for="ec_b1">1% 이상</label>
								</div>
								<div class="side_choice">
									<input id="ec_b2" type="checkbox" name="fe02_02" value="1" <?if($fe02_02 == "1"){echo "checked";}?>><label for="ec_b2">0.5%~1%</label>
								</div>
								<div class="side_choice">
									<input id="ec_b3" type="checkbox" name="fe02_03" value="1" <?if($fe02_03 == "1"){echo "checked";}?>><label for="ec_b3">0.3%~0.5%</label>
								</div>
								<div class="side_choice">
									<input id="ec_b4" type="checkbox" name="fe02_04" value="1" <?if($fe02_04 == "1"){echo "checked";}?>><label for="ec_b4">0.2%~0.3%</label>
								</div>
								<div class="side_choice">
									<input id="ec_b5" type="checkbox" name="fe02_05" value="1" <?if($fe02_05 == "1"){echo "checked";}?>><label for="ec_b5">0.1%~0.2%</label>
								</div>
								<div class="side_choice">
									<input id="ec_b6" type="checkbox" name="fe02_06" value="1" <?if($fe02_06 == "1"){echo "checked";}?>><label for="ec_b6">0.1% 미만</label>
								</div>
							</div>
						</div>
						<div class="typeBox">
							<h4 class="main_type">평균거래량</h4>
							<div class="sub_type">
								<div class="side_choice">
									<input id="ec_c1" type="checkbox" name="fe03_01" value="1" <?if($fe03_01 == "1"){echo "checked";}?>><label for="ec_c1">5,000만 이상</label>
								</div>
								<div class="side_choice">
									<input id="ec_c2" type="checkbox" name="fe03_02" value="1" <?if($fe03_02 == "1"){echo "checked";}?>><label for="ec_c2">1,000만~5,000만</label>
								</div>
								<div class="side_choice">
									<input id="ec_c3"  type="checkbox" name="fe03_03" value="1" <?if($fe03_03 == "1"){echo "checked";}?>><label for="ec_c3">200만~1,000만</label>
								</div>
								<div class="side_choice">
									<input id="ec_c4" type="checkbox" name="fe03_04" value="1" <?if($fe03_04 == "1"){echo "checked";}?>><label for="ec_c4">50만~200만</label>
								</div>
								<div class="side_choice">
									<input id="ec_c5" type="checkbox" name="fe03_05" value="1" <?if($fe03_05 == "1"){echo "checked";}?>><label for="ec_c5">10만~50만</label>
								</div>
								<div class="side_choice">
									<input id="ec_c6" type="checkbox" name="fe03_06" value="1" <?if($fe03_06 == "1"){echo "checked";}?>><label for="ec_c6">10만 미만</label>
								</div>
							</div>
						</div>
						<div class="typeBox">
							<h4 class="main_type">한주당 가격</h4>
							<div class="sub_type">
								<div class="side_choice">
									<input id="ec_d1" type="checkbox" name="fe04_01" value="1" <?if($fe04_01 == "1"){echo "checked";}?>><label for="ec_d1">200$ 이상</label>
								</div>
								<div class="side_choice">
									<input id="ec_d2" type="checkbox" name="fe04_02" value="1" <?if($fe04_02 == "1"){echo "checked";}?>><label for="ec_d2">100$~200$</label>
								</div>
								<div class="side_choice">
									<input id="ec_d3"  type="checkbox" name="fe04_03" value="1" <?if($fe04_03 == "1"){echo "checked";}?>><label for="ec_d3">50$~100$</label>
								</div>
								<div class="side_choice">
									<input id="ec_d4" type="checkbox" name="fe04_04" value="1" <?if($fe04_04 == "1"){echo "checked";}?>><label for="ec_d4">20$~50$</label>
								</div>
								<div class="side_choice">
									<input id="ec_d5" type="checkbox" name="fe04_05" value="1" <?if($fe04_05 == "1"){echo "checked";}?>><label for="ec_d5">10$~20$</label>
								</div>
								<div class="side_choice">
									<input id="ec_d6" type="checkbox" name="fe04_06" value="1" <?if($fe04_06 == "1"){echo "checked";}?>><label for="ec_d6">10$ 미만</label>
								</div>
							</div>
						</div>
						<a class="submitBtn dp_f dp_cc dp_c" href="javascript:etfFilter();" title="적용하기">적용하기</a>
					</div>
				</div>
				</form>


				<div class="etf_tab_flex wid951" id='TabEtfResult'>
				<?
					//결과값
					include 'TabETFResult.php';
				?>
				</div>
			</div>
		</div>