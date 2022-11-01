<?
	include '../header.php';
?>

<style>
	.diary_nav_sub {display: block;}
	.tableWrap {margin-top: 20px;}
</style>

<div id="sub_cont">
	<div class="sub_center">
		<h3 class="sub_tit">
			미국 증시 실적발표, 배당락, IPO 등을 확인하세요
		</h3>
		<?
			include 'investquote.php';
		?>

		<div class="calendarWrap">
			<div class="whtBg"></div>
			<!-- 달력 -->
			<iframe name="ifra_calendar" id="ifra_calendar" src="../calendar.php?path=sub04-sub01" style="width:100%;margin-bottom:160px;" frameborder="0" scrolling="no" onload="iFrameHeight('ifra_calendar')"></iframe>
			<!-- /달력 -->

		</div>


		<div class="sec_etf_wrap">
			<div class="ora_line"></div>
			<div class="tableWrap sec_table">
				<table class="subtable">
					<tbody>
						<tr>
							<th>상장예정일</th>
							<th>회사명/심볼=티커</th>
							<th>상장 예상 주식수</th>
							<th>1주당 가격</th>
							<th>상태 - 상장예정 or 가격 확정</th>
							<th>상장 거래소명</th>
							<th>상장 주식 액면 총합</th>
						</tr>
						<tr>
							<td>2022-07-12</td>
							<td>Nano Labs Ltd NA</td>
							<td>1,770,000 주</td>
							<td>11.50 달러</td>
							<td>상장예정</td>
							<td>NASDAQ Global</td>
							<td>20,355,000 달러<br>
									(266.65억원)
							</td>
						</tr>
						<tr>
							<td>2022-07-12</td>
							<td>Nano Labs Ltd NA</td>
							<td>1,770,000 주</td>
							<td>11.50 달러</td>
							<td>상장예정</td>
							<td>NASDAQ Global</td>
							<td>20,355,000 달러<br>
									(266.65억원)
							</td>
						</tr>
						<tr>
							<td>2022-07-12</td>
							<td>Nano Labs Ltd NA</td>
							<td>1,770,000 주</td>
							<td>11.50 달러</td>
							<td>상장예정</td>
							<td>NASDAQ Global</td>
							<td>20,355,000 달러<br>
									(266.65억원)
							</td>
						</tr>
						<tr>
							<td>2022-07-12</td>
							<td>Nano Labs Ltd NA</td>
							<td>1,770,000 주</td>
							<td>11.50 달러</td>
							<td>상장예정</td>
							<td>NASDAQ Global</td>
							<td>20,355,000 달러<br>
									(266.65억원)
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="sec_etf_wrap">
			<div class="ora_line"></div>
			<div class="tableWrap sec_table">
				<table class="subtable">
					<tbody>
						<tr>
							<th>상장예정일</th>
							<th>회사명/심볼=티커</th>
							<th>마감 기준 (분기)</th>
							<th>YoY EPS</th>
							<th>EPS 예상 (전년 동기대비 증감율)</th>
							<th>EPS 실제 (컨센서스 대비 증감율)</th>
							<th>YoY 매출</th>
							<th>매출 예상 (전년 동기대비 증감율)</th>
							<th>매출 실제 (컨센서스 대비 증감율)</th>
							<th>실적발표예상시각</th>
							<th>애널리스트 컨센서스</th>
						</tr>
						<tr>
							<td>2022-07-12</td>
							<td>apple, inc.<br>AAPL</td>
							<td>2022/6</td>
							<td>1.3</td>
							<td>1.1834<br>(-9.23%)</td>
							<td>1.4(+18.3%)</td>
							<td>81,434,000,000달러<br>(한화 얼마)</td>
							<td>84,082,713,091달러<br>(한화 얼마, +3.25%)</td>
							<td>84,082,713,091달러<br>(한화 얼마, +3.25%)</td>
							<td>장마감후</td>
							<td></td>
						</tr>
						<tr>
							<td>2022-07-12</td>
							<td>apple, inc.<br>AAPL</td>
							<td>2022/6</td>
							<td>1.3</td>
							<td>1.1834<br>(-9.23%)</td>
							<td>1.4(+18.3%)</td>
							<td>81,434,000,000달러<br>(한화 얼마)</td>
							<td>84,082,713,091달러<br>(한화 얼마, +3.25%)</td>
							<td>84,082,713,091달러<br>(한화 얼마, +3.25%)</td>
							<td>장마감후</td>
							<td></td>
						</tr>
						<tr>
							<td>2022-07-12</td>
							<td>apple, inc.<br>AAPL</td>
							<td>2022/6</td>
							<td>1.3</td>
							<td>1.1834<br>(-9.23%)</td>
							<td>1.4(+18.3%)</td>
							<td>81,434,000,000달러<br>(한화 얼마)</td>
							<td>84,082,713,091달러<br>(한화 얼마, +3.25%)</td>
							<td>84,082,713,091달러<br>(한화 얼마, +3.25%)</td>
							<td>장마감후</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="sec_etf_wrap">
			<div class="ora_line"></div>
			<div class="tableWrap sec_table">
				<table class="subtable">
					<tbody>
						<tr>
							<th>회사명/심볼=티커</th>
							<th>배당락일</th>
							<th>배당기준일</th>
							<th>배당지급일</th>
							<th>배당금</th>
							<th>배당수익률</th>
							<th>시가총액</th>
							<th>6개월 주가수익률</th>
							<th>시가배당율(5년평균)</th>
							<th>애널리스트 컨센서스</th>
						</tr>
						<tr>
							<td>Costco
									Wholesale
									Corp
									COST
							</td>
							<td>2022-07-12</td>
							<td>2022-07-29</td>
							<td>2022-08-12</td>
							<td>0.90달러</td>
							<td>0.60%</td>
							<td>228,032.89백만달러<br>(한화계산)</td>
							<td>스톡스크리너 동일값</td>
							<td>스톡스크리너 동일값</td>
							<td></td>
						</tr>
						<tr>
							<td>Costco
									Wholesale
									Corp
									COST
							</td>
							<td>2022-07-12</td>
							<td>2022-07-29</td>
							<td>2022-08-12</td>
							<td>0.90달러</td>
							<td>0.60%</td>
							<td>228,032.89백만달러<br>(한화계산)</td>
							<td>스톡스크리너 동일값</td>
							<td>스톡스크리너 동일값</td>
							<td></td>
						</tr>
						<tr>
							<td>Costco
									Wholesale
									Corp
									COST
							</td>
							<td>2022-07-12</td>
							<td>2022-07-29</td>
							<td>2022-08-12</td>
							<td>0.90달러</td>
							<td>0.60%</td>
							<td>228,032.89백만달러<br>(한화계산)</td>
							<td>스톡스크리너 동일값</td>
							<td>스톡스크리너 동일값</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?
	include '../footer.php';
?>