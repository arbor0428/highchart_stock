<div id="cont3" class="dividend_box">
	<div class="dividend_search">
		<table class="divi_searchBar subtable">
			<tbody>
				<colgroup>
					<col style="width:20%;">
					<col style="width:20%;">
					<col style="width:20%;">
					<col style="width:40%;">
				</colgroup>
				<tr>
					<th colspan="4">조건1</th>
				</tr>
				<tr>
					<th class="sub_tit_bg">주당 배당금</th>
					<td>주당 최소 <input id="info01" name="info01" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set01();" value='0.1'>$</td>
					<td>주당 최대 <input id="info02" name="info02" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set01();" value='10'>$</td>
					<td>
						<div class="slider-cont">
							<span id="in3SliderVal01" style="margin-left:15px; color:#1b00ff;">0.1</span>
							<span style="margin-right:15px;">$</span>
							<input id="ex12c" type="text"/>
							<span id="ex3SliderVal01" style="margin-left:15px; color:#1b00ff;">10</span>
							<span>$</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="sub_tit_bg">시가 배당율</th>
					<td>최소 <input id="info03" name="info03" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set02();" value='2'>%</td>
					<td>최대 <input id="info04" name="info04" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set02();"  value='10'>%</td>
					<td>
						<div class="slider-cont">
							<span id="in3SliderVal02" style="margin-left:15px; color:#1b00ff;">2</span>
							<span style="margin-right:15px;">%</span>
							<input id="ex12c02" type="text"/>
							<span id="ex3SliderVal02" style="margin-left:15px; color:#1b00ff;">10</span>
							<span>%</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="sub_tit_bg">배당금 유지/상승 기간</th>
					<td>최소 <input id="info05" name="info05" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set03();"  value='1'>년</td>
					<td>최대 <input id="info06" name="info06" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set03();"  value='10'>년</td>
					<td>
						<div class="slider-cont">
							<span id="in3SliderVal03" style="margin-left:15px; color:#1b00ff;">1</span>
							<span style="margin-right:15px;">년</span>
							<input id="ex12c03" type="text"/>
							<span id="ex3SliderVal03" style="margin-left:15px; color:#1b00ff;">10</span>
							<span>년</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="sub_tit_bg">1년간 주가수익률</th>
					<td>최소 <input id="info07" name="info07" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set04();"  value='1'>%</td>
					<td>최대 <input id="info08" name="info08" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set04();"  value='10'>%</td>
					<td>
						<div class="slider-cont">
							<span id="in3SliderVal04" style="margin-left:15px; color:#1b00ff;">1</span>
							<span style="margin-right:15px;">%</span>
							<input id="ex12c04" type="text"/>
							<span id="ex3SliderVal04" style="margin-left:15px; color:#1b00ff;">10</span>
							<span>%</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="sub_tit_bg">10년간 주가수익률</th>
					<td>최소 <input id="info09" name="info09" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set05();"  value='1'>%</td>
					<td>최대 <input id="info10" name="info10" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set05();"  value='10'>%</td>
					<td>
						<div class="slider-cont">
							<span id="in3SliderVal05" style="margin-left:15px; color:#1b00ff;">1</span>
							<span style="margin-right:15px;">%</span>
							<input id="ex12c05" type="text"/>
							<span id="ex3SliderVal05" style="margin-left:15px; color:#1b00ff;">10</span>
							<span>%</span>
						</div>
					</td>
				</tr>
				<tr>
					<th class="sub_tit_bg">고참대비 최대낙폭(MDD)</th>
					<td>최소 <input id="info11" name="info07" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set06();"  value='1'>%</td>
					<td>최대 <input id="info12" name="info08" type="text" style="width: 60px; border-bottom: 1px solid #000; text-align: center; color:#1b00ff;" onkeyup="set06();"  value='10'>%</td>
					<td>
						<div class="slider-cont">
							<span id="in3SliderVal06" style="margin-left:15px; color:#1b00ff;">1</span>
							<span style="margin-right:15px;">년</span>
							<input id="ex12c06" type="text"/>
							<span id="ex3SliderVal06" style="margin-left:15px; color:#1b00ff;">10</span>
							<span>년</span>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<a class="searchBtn" href="">검색하기</a>
	</div>

	<div class="ex_dividend_result">
		<div class="sec_etf_wrap">
			<div class="ora_line"></div>
			<h4 class="sub_tit_det" style="margin-top: 20px;">Showing companies with ex-dividend date as Feb23, 2022</h4>
			<div class="sec_table stock_table">
				<table class="subtable">
					<tbody>
						<tr>
							<th>티커+회사이름</th>
							<th>배당락</th>
							<th>배당지급일</th>
							<th>배당금액+배당율</th>
							<th>애널리스트<br>컨센서스</th>
							<th>애널리스트<br>목표가격업사이드</th>
							<th>적정주가 성장성+수익성</th>
						</tr>
						<tr>
							<td>
								<span class="blue bb block">AAPL</span>
								<span class="block">Advanced Info Service PCL</span>
							</td>
							<td>
								<span class="bgreen bold" style="margin:0;">$193.32</span>
								<span class="bgreen det_s bold" style="margin:0;">(17.65% upside)</span>
							</td>
							<td><span>Apr 29, 2022</span></td>
							<td>
								<span>$0.1</span>
							</td>
							<td>
								<span>-</span>
							</td>
							<td>
								<span>2.52%</span>
							</td>
							<td>
								<span>-</span>
							</td>
						</tr>
						<tr>
							<td>
								<span class="blue bb block">AAPL</span>
								<span class="block">Advanced Info Service PCL</span>
							</td>
							<td>
								<span class="bpurple bold" style="margin:0;">$193.32</span>
								<span class="bpurple det_s bold" style="margin:0;">(17.65% downside)</span>
							</td>
							<td><span>Apr 29, 2022</span></td>
							<td>
								<span>$0.1</span>
							</td>
							<td>
								<div class="dp_f dp_c dp_cc">
									<?
										include 'analyst_pie.php';
									?>
									<span class="bgray bold">Hold</span>
								</div>
								<p style="font-size: 14px;">
									<span class="totNumTxt" style="font-weight:700;">52</span>명의 애널리스트의 평가입니다.
								</p>
							</td>
							<td>
								<span>2.52%</span>
							</td>
							<td>
								<span>-</span>
							</td>
						</tr>
						<tr>
							<td>
								<span class="blue bb block">AAPL</span>
								<span class="block bold">Advanced Info Service PCL</span>
							</td>
							<td>
								<span class="bgreen bold" style="margin:0;">$193.32</span>
								<span class="bgreen det_s bold" style="margin:0;">(17.65% upside)</span>
							</td>
							<td><span>Apr 29, 2022</span></td>
							<td>
								<span>$0.1</span>
							</td>
							<td>
								<div class="dp_f dp_c dp_cc">
									<?
										include 'analyst_pie.php';
									?>
									<span class="bgreen">Moderate Buy</span>
								</div>
								<p style="font-size: 14px;">
									<span class="totNumTxt" style="font-weight:700;">52</span>명의 애널리스트의 평가입니다.
								</p>
							</td>
							<td>
								<span>2.52%</span>
							</td>
							<td>
								<span>-</span>
							</td>
						</tr>

						<tr class="allBtn">
							<td colspan="7"><a href="">더 보기</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!--
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
-->
<script src="https://www.jqueryscript.net/demo/Highly-Customizable-Range-Slider-Plugin-For-Bootstrap-Bootstrap-Slider/dist/bootstrap-slider.js"></script>
<link href="https://www.jqueryscript.net/demo/Highly-Customizable-Range-Slider-Plugin-For-Bootstrap-Bootstrap-Slider/dist/css/bootstrap-slider.css" rel="stylesheet" type="text/css">

<style>
.slider .tooltip.top {display: none;}
.slider-handle{
	background: #ffffff;
	border:2px solid #e26f12;
	box-sizing:border-box;
}
.slider-selection {
	background: #e26f12;
}
.slider.slider-horizontal {width:300px;}

</style>

<script>

set01()
function set01(){
	a = parseFloat($("#info01").val())
	b = parseFloat($("#info02").val())
	$("#ex12c").slider({ id: "slider12c", min: a, max: b, range: true, step:0.1, value: [a, b] });
	$("#ex12c").on("slide", function(slideEvt) {
		$("#in3SliderVal01").text(slideEvt.value[0]);
		$("#ex3SliderVal01").text(slideEvt.value[1]);
		$("#info01").val(slideEvt.value[0]);
		$("#info02").val(slideEvt.value[1]);
	});

}

set02()
function set02(){
	a = parseFloat($("#info03").val())
	b = parseFloat($("#info04").val())
	$("#ex12c02").slider({ id: "slider12c02", min: a, max: b, range: true, step:0.1, value: [a, b] });
	$("#ex12c02").on("slide", function(slideEvt) {
		$("#in3SliderVal02").text(slideEvt.value[0]);
		$("#ex3SliderVal02").text(slideEvt.value[1]);
		$("#info03").val(slideEvt.value[0]);
		$("#info04").val(slideEvt.value[1]);
	});
}

set03()
function set03(){
	a = parseFloat($("#info05").val())
	b = parseFloat($("#info06").val())
	$("#ex12c03").slider({ id: "slider12c03", min: a, max: b, range: true, step:0.1, value: [a, b] });
	$("#ex12c03").on("slide", function(slideEvt) {
		$("#in3SliderVal03").text(slideEvt.value[0]);
		$("#ex3SliderVal03").text(slideEvt.value[1]);
		$("#info05").val(slideEvt.value[0]);
		$("#info06").val(slideEvt.value[1]);
	});
}

set04()
function set04(){
	a = parseFloat($("#info07").val())
	b = parseFloat($("#info08").val())
	$("#ex12c04").slider({ id: "slider12c04", min: a, max: b, range: true, step:0.1, value: [a, b] });
	$("#ex12c04").on("slide", function(slideEvt) {
		$("#in3SliderVal04").text(slideEvt.value[0]);
		$("#ex3SliderVal04").text(slideEvt.value[1]);
		$("#info07").val(slideEvt.value[0]);
		$("#info08").val(slideEvt.value[1]);
	});
}

set05()
function set05(){
	a = parseFloat($("#info09").val())
	b = parseFloat($("#info10").val())
	$("#ex12c05").slider({ id: "slider12c05", min: a, max: b, range: true, step:0.1, value: [a, b] });
	$("#ex12c05").on("slide", function(slideEvt) {
		$("#in3SliderVal05").text(slideEvt.value[0]);
		$("#ex3SliderVal05").text(slideEvt.value[1]);
		$("#info09").val(slideEvt.value[0]);
		$("#info10").val(slideEvt.value[1]);
	});
}

set06()
function set06(){
	a = parseFloat($("#info11").val())
	b = parseFloat($("#info12").val())
	$("#ex12c06").slider({ id: "slider12c06", min: a, max: b, range: true, step:0.1, value: [a, b] });
	$("#ex12c06").on("slide", function(slideEvt) {
		$("#in3SliderVal06").text(slideEvt.value[0]);
		$("#ex3SliderVal06").text(slideEvt.value[1]);
		$("#info11").val(slideEvt.value[0]);
		$("#info12").val(slideEvt.value[1]);
	});
}
</script>



