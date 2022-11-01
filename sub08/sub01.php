<?
	include '../header.php';
?>

<div id="sub_cont">
	<div class="sub_center">
		<div class="gryWrap">
			<div class="getAlrmTit">
				<p>관심종목/포트폴리오종목알림설정을해보세요.</p>
				<p>배당락, 급등/급락, 실적발표등 다양한 알림을 놓치지 않고 받을 수 있습니다.</p>
			</div>
			<div class="getAlrm_main_Tbl">
				<table class="subtable">
					<tbody>
						<tr>
							<th>알림 On/Off</th>
							<th>이메일로 받기</th>
							<th>문자로 받기</th>
							<th>카카오톡으로 받기</th>
							<th>알림 받을 시각 설정</th>
						</tr>
						<tr>
							<td>
								<div class="side_choice">
									<input id="alrt1" type="checkbox">
									<label for="alrt1"></label>
								</div>
							</td>
							<td>
								<div class="side_choice">
									<input id="alrt2" type="checkbox">
									<label for="alrt2"></label>
								</div>
							</td>
							<td>
								<div class="side_choice">
									<input id="alrt3" type="checkbox">
									<label for="alrt3"></label>
								</div>
							</td>
							<td>
								<div class="side_choice">
									<input id="alrt4" type="checkbox">
									<label for="alrt4"></label>
								</div>
							</td>
							<td>오후 2시</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>


		<div class="alrt_tblWrap">
			<h3 class="sub_tit">개별 주식 알림 설정</h3>
			<table class="subtable">
				<tbody>
					<tr>
						<th>회사이름(티커)</th>
						<th>가격알림1</th>
						<th>가격알림2</th>
						<th>급등/급락</th>
						<th>거래량증가</th>
						<th>mdd(하락폭 or 상승확률)</th>
						<th>배당락</th>
						<th>실적발표</th>
						<th>컨센서스<br>상향/하향</th>
						<th>내부자거래</th>
						<th>적정주가</th>
					</tr>
					<tr>
						<td colspan="11">
							<a class="regiBtn dp_f dp_c dp_cc" href="" title="">등록 하기</a>
						</td>
					</tr>
					<!--등록후 생기는 내용-->
					<tr>
						<td>AAPL</td>
						<td></td>
						<td></td>
						<td>+10%/-10%</td>
						<td>평균의 5배</td>
						<td>85%(상승확률)</td>
						<td>
							<div class="side_choice">
								<input id="alrt1_1" type="checkbox">
								<label for="alrt1_1"></label>
							</div>
						</td>
						<td>
							<div class="side_choice">
								<input id="alrt1_2" type="checkbox">
								<label for="alrt1_2"></label>
							</div>
						</td>
						<td>
							<div class="side_choice">
								<input id="alrt1_3" type="checkbox">
								<label for="alrt1_3"></label>
							</div>
						</td>
						<td>
							<div class="side_choice">
								<input id="alrt1_4" type="checkbox">
								<label for="alrt1_4"></label>
							</div>
						</td>
						<td>
							<div class="side_choice">
								<input id="alrt1_5" type="checkbox">
								<label for="alrt1_5"></label>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="alrt_tblWrap">
			<h3 class="sub_tit">개별 ETF 알림 설정</h3>
			<table class="subtable">
				<tbody>
					<tr>
						<th>회사이름(티커)</th>
						<th>가격알림1</th>
						<th>가격알림2</th>
						<th>급등/급락</th>
						<th>거래량폭등</th>
						<th>mdd(하락폭 or 상승확률)</th>
					</tr>
					<tr>
						<td colspan="11">
							<a class="regiBtn dp_f dp_c dp_cc" href="" title="">등록 하기</a>
						</td>
					</tr>
					<!--등록후 생기는 내용-->
<!-- 					<tr>
						<td>SPY</td>
						<td></td>
						<td></td>
						<td>+10%/-10%</td>
						<td>평균의 5배</td>
						<td>85%(상승확률)</td>
					</tr> -->
				</tbody>
			</table>
		</div>
		<div class="alrt_tblWrap">
			<h3 class="sub_tit">캘린더 메모 및 알림</h3>
			<table class="subtable">
				<tbody>
					<tr>
						<th>날짜</th>
						<th>메모</th>
						<th>알림 여부</th>
					</tr>
					<tr>
						<td colspan="11">
							<a class="regiBtn dp_f dp_c dp_cc" href="" title="">등록 하기</a>
						</td>
					</tr>
					<!--등록후 생기는 내용-->
					<tr>
						<td>2022/8/3</td>
						<td>이날 애플 기사 찾아볼 것</td>
						<td>
							<div class="side_choice">
								<input id="calalrt1" type="checkbox">
								<label for="calalrt1"></label>
							</div>
						</td>
					</tr>
					<tr>
						<td>2022/8/3</td>
						<td>애플 협력업체 발표나나?</td>
						<td>
							<div class="side_choice">
								<input id="calalrt2" type="checkbox">
								<label for="calalrt2"></label>
							</div>
						</td>
					</tr>
					<tr>
						<td>2022/8/31</td>
						<td>잭슨홀 미팅이라는데?</td>
						<td>
							<div class="side_choice">
								<input id="calalrt3" type="checkbox">
								<label for="calalrt3"></label>
							</div>
						</td>
					</tr>
					<tr>
						<td>2023/3/1</td>
						<td>프리포트 ing 100% 가동된다는데 확인하자</td>
						<td>
							<div class="side_choice">
								<input id="calalrt4" type="checkbox">
								<label for="calalrt4"></label>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?
	include '../footer.php';
?>