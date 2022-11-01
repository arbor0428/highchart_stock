<?
	include '../header.php';
?>

<div id="sub_cont">
	<div class="sub_center">
		<?
			include 'investquote.php';
		?>
		<div class="searchWrap">
			<?
				include 'searchBar.php';
			?>	
			<div class="dp_sb dp_c" style="margin-top: 30px;">
				<table class="subtable">
					<tbody>
						<tr>
							<th>그룹명</th>
							<th>그룹 메모</th>
							<th>종목수</th>
						</tr>
						<tr>
							<td>10년존버</td>
							<td>그룹 메모입니다.</td>
							<td>0</td>
						</tr>
						<tr>
							<td colspan="3">
								<table class="subtable jong">
										<colgroup>
											<col style="width: 363px;">
											<col style="width: 657px;">
											<col style="width: 260px;">
										</colgroup>
										<tr>
											<th>종목명</th>
											<th>종목 메모</th>
											<th>
												<div class="optTit dp_f dp_c dp_cc">
													<span style="font-weight: 700;">종목 비중(옵션)</span>
													<div class="help_wrap">
														<div class="excla_mark help_point">
															<span>?</span>
														</div>
														<div class="helpbox" style="display: none;">
															<p>종목 비중을 설정하면 관심그룹의 지난 수익률과 예상배당률 등을 
															알 수 있어요 100%를 맞춰야 작동해요
															</p>
														</div>
													</div>
												</div>
												<a class="sameR" href="" title="균등비중적용">균등비중적용</a>
											</th>
										</tr>
										<tr>
											<td><a href="" title=""></a>애플</td>
											<td>갓플!</td>
											<td>
												40%
												<a class="delbtn" href="" title="제거">-</a>
											</td>
										</tr>
										<tr>
											<td>앤비디아</td>
											<td>코인은 갔지만 메타버스가 오겠지?</td>
											<td>
												60%
												<a class="delbtn" href="" title="제거">-</a>
											</td>
										</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
<!-- 				<a class="blueBtn" href="sub03_search.php" title="종목 추가/편집">종목 추가/편집</a> -->
			</div>
		</div>
	</div>
</div>

<?
	include '../footer.php';
?>