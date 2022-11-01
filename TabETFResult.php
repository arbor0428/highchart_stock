<?
//제이쿼리 로드함수를 이용해 페이지가 로딩된 경우
if($_GET['jQueryLoad']){
	include "./module/class/class.DbCon.php";
	include "./module/class/class.Util.php";
	include './module/lib.php';
?>
<script>
$(document).ready(function(){
	$("#loading").delay("200").fadeOut();
});
</script>
<?
}

//자산운영규모 쿼리
$feWhere01 = '';

if($fe01_01){
	$feWhere01 = "(";
	$feWhere01 .= "e.aum>=50000000000";
}

if($fe01_02){
	if($feWhere01)	$feWhere01 .= " or ";
	else					$feWhere01 = "(";
	$feWhere01 .= "(e.aum>=10000000000 and e.aum<50000000000)";
}

if($fe01_03){
	if($feWhere01)	$feWhere01 .= " or ";
	else					$feWhere01 = "(";
	$feWhere01 .= "(e.aum>=2000000000 and e.aum<10000000000)";
}

if($fe01_04){
	if($feWhere01)	$feWhere01 .= " or ";
	else					$feWhere01 = "(";
	$feWhere01 .= "(e.aum>=500000000 and e.aum<2000000000)";
}

if($fe01_05){
	if($feWhere01)	$feWhere01 .= " or ";
	else					$feWhere01 = "(";
	$feWhere01 .= "(e.aum>=100000000 and e.aum<500000000)";
}

if($fe01_06){
	if($feWhere01)	$feWhere01 .= " or ";
	else					$feWhere01 = "(";
	$feWhere01 .= "e.aum<100000000";
}

if($feWhere01)	$feWhere01 = " and ".$feWhere01.")";




//수수료율 쿼리
$feWhere02 = '';

if($fe02_01){
	$feWhere02 = "(";
	$feWhere02 .= "e.expenseRatio>=1";
}

if($fe02_02){
	if($feWhere02)	$feWhere02 .= " or ";
	else					$feWhere02 = "(";
	$feWhere02 .= "(e.expenseRatio>=0.5 and e.expenseRatio<1)";
}

if($fe02_03){
	if($feWhere02)	$feWhere02 .= " or ";
	else					$feWhere02 = "(";
	$feWhere02 .= "(e.expenseRatio>=0.3 and e.expenseRatio<0.5)";
}

if($fe02_04){
	if($feWhere02)	$feWhere02 .= " or ";
	else					$feWhere02 = "(";
	$feWhere02 .= "(e.expenseRatio>=0.2 and e.expenseRatio<0.3)";
}

if($fe02_05){
	if($feWhere02)	$feWhere02 .= " or ";
	else					$feWhere02 = "(";
	$feWhere02 .= "(e.expenseRatio>=0.1 and e.expenseRatio<0.2)";
}

if($fe02_06){
	if($feWhere02)	$feWhere02 .= " or ";
	else					$feWhere02 = "(";
	$feWhere02 .= "e.expenseRatio<0.1";
}

if($feWhere02)	$feWhere02 = " and ".$feWhere02.")";




//평균거래량 쿼리
$feWhere03 = '';

if($fe03_01){
	$feWhere03 = "(";
	$feWhere03 .= "e.avgVolume>=50000000";
}

if($fe03_02){
	if($feWhere03)	$feWhere03 .= " or ";
	else					$feWhere03 = "(";
	$feWhere03 .= "(e.avgVolume>=10000000 and e.avgVolume<50000000)";
}

if($fe03_03){
	if($feWhere03)	$feWhere03 .= " or ";
	else					$feWhere03 = "(";
	$feWhere03 .= "(e.avgVolume>=2000000 and e.avgVolume<10000000)";
}

if($fe03_04){
	if($feWhere03)	$feWhere03 .= " or ";
	else					$feWhere03 = "(";
	$feWhere03 .= "(e.avgVolume>=500000 and e.avgVolume<2000000)";
}

if($fe03_05){
	if($feWhere03)	$feWhere03 .= " or ";
	else					$feWhere03 = "(";
	$feWhere03 .= "(e.avgVolume>=100000 and e.avgVolume<500000)";
}

if($fe03_06){
	if($feWhere03)	$feWhere03 .= " or ";
	else					$feWhere03 = "(";
	$feWhere03 .= "e.avgVolume<100000";
}

if($feWhere03)	$feWhere03 = " and ".$feWhere03.")";


$feQuery = '';
if($feWhere01 || $feWhere02 || $feWhere03)	$feQuery = "left join api_ETFs_Profile as e on s.symbol=e.symbol";



//한주당 가격
$feWhere04 = '';

if($fs04_01){
	if($feWhere04 == '')	$feWhere04 = " and (";
	$feWhere04 .= "s.c>=200";							//200이상
}

if($fs04_02){
	if($feWhere04 == '')	$feWhere04 = "and (";
	else						$feWhere04 .= " or ";
	$feWhere04 .= "(s.c>=100 and s.c<200)";		//100~200미만
}

if($fs04_03){
	if($feWhere04 == '')	$feWhere04 = "and (";
	else						$feWhere04 .= " or ";
	$feWhere04 .= "(s.c>=50 and s.c<100)";			//50~100미만
}

if($fs04_04){
	if($feWhere04 == '')	$feWhere04 = "and (";
	else						$feWhere04 .= " or ";
	$feWhere04 .= "(s.c>=20 and s.c<50)";			//20~50미만
}

if($fs04_05){
	if($feWhere04 == '')	$feWhere04 = "and (";
	else						$feWhere04 .= " or ";
	$feWhere04 .= "(s.c>=10 and s.c<20)";			//10~20미만
}

if($fs04_06){
	if($feWhere04 == '')	$feWhere04 = "and (";
	else						$feWhere04 .= " or ";
	$feWhere04 .= "s.c<10";								//10미만
}

if($feWhere04)		$feWhere04 .= ") ";
?>

					<div class="etf_tab_box">
						<div class="etf">
							<div class="row row_tit">
								<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
									<div class="col">급등주</div>
									<div class="col">현재가 대비(등락)</div>
									<div class="col">거래량(등락)</div>
								</div>
							</div>
							<?
								//급등주(ETF == Y)
								$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol ".$feQuery." where t.etf='Y' ".$feWhere01.$feWhere02.$feWhere03.$feWhere04." order by s.pmDataDay desc limit 4");

								foreach($row as $v){
									$perData = Util::nf1($v['pmDataDay'],2);
									if($perData > 0){
										$txtClass = 'red';
										$txtArrow = '▲';

									}else if($perData < 0){
										$txtClass = 'blue';
										$txtArrow = '▼';

									}else{
										$txtClass = '';
										$txtArrow = '';
									}
							?>
							<div class="row row_cont">
								<div class="dp_sb dp_c dp_wrap">
									<div  class="col">
										<div class="blue_tit">
											<a class="help_point03" href="javascript:void(0);"><?=$v['symbol']?></a>
											<!--클릭시 생기는 박스-->
											<div class="helpbox">
												<ul class="small_ticker_menu">
													<li><a href="/sub07/sub01.php?gbl_symbol=<?=$v['symbol']?>" title="종목 정보보기">- 종목 정보보기</a></li>
													<li class="click_show_wrap">
														<span class="click_show_check">- 알림설정하기</span>
														<!--클릭시 생기는 테이블-->
														<div class="click_show_check_tbl">
															<div class="closeBtn"><span class="lnr lnr-cross"></span></div>
															<table class="subtable">
																<tbody>
																	<tr>
																		<th>회사이름(티커)</th>
																		<th>가격알림1</th>
																		<th>가격알림2</th>
																		<th>급등/급락</th>
																		<th>거래량증가</th>
																		<th>mdd<br>(하락폭 or 상승확률)</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																	</tr>
																</tbody>
															</table>
														</div>

													</li>
													<li><a href="/sub04/sub03.php" title="관심종목 등록하기">- 관심종목 등록하기</a></li>
													<li><a href="/sub04/sub04.php" title="포트폴리오 등록하기">- 포트폴리오 등록하기</a></li>
												</ul>
											</div>

										</div>
										<p class="ellipsis"><?=$v['name']?></p>
									</div>
									<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <span><?=$txtArrow?></span> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
									<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
								</div>
							</div>
							<?
								}
							?>
						</div>
					</div>

					<div class="etf_tab_box">
						<div class="etf">
							<div class="row row_tit">
								<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
									<div class="col">거래량 급등</div>
									<div class="col">현재가 대비(등락)</div>
									<div class="col">거래량(등락)</div>
								</div>
							</div>
							<?
								//거래량 급등주(ETF == Y)
								$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol ".$feQuery." where t.etf='Y' ".$feWhere01.$feWhere02.$feWhere03.$feWhere04." order by s.vDataDay desc limit 4");

								foreach($row as $v){
									$perData = Util::nf1($v['pmDataDay'],2);
									if($perData > 0){
										$txtClass = 'red';
										$txtArrow = '▲';

									}else if($perData < 0){
										$txtClass = 'blue';
										$txtArrow = '▼';

									}else{
										$txtClass = '';
										$txtArrow = '';
									}
							?>
							<div class="row row_cont">
								<div class="dp_sb dp_c dp_wrap">
									<div  class="col">
										<div class="blue_tit">
											<a class="help_point03" href="javascript:void(0);"><?=$v['symbol']?></a>
											<!--클릭시 생기는 박스-->
											<div class="helpbox">
												<ul class="small_ticker_menu">
													<li><a href="/sub07/sub01.php?gbl_symbol=<?=$v['symbol']?>" title="종목 정보보기">- 종목 정보보기</a></li>
													<li class="click_show_wrap">
														<span class="click_show_check">- 알림설정하기</span>
														<!--클릭시 생기는 테이블-->
														<div class="click_show_check_tbl">
															<div class="closeBtn"><span class="lnr lnr-cross"></span></div>
															<table class="subtable">
																<tbody>
																	<tr>
																		<th>회사이름(티커)</th>
																		<th>가격알림1</th>
																		<th>가격알림2</th>
																		<th>급등/급락</th>
																		<th>거래량증가</th>
																		<th>mdd<br>(하락폭 or 상승확률)</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																	</tr>
																</tbody>
															</table>
														</div>

													</li>
													<li><a href="/sub04/sub03.php" title="관심종목 등록하기">- 관심종목 등록하기</a></li>
													<li><a href="/sub04/sub04.php" title="포트폴리오 등록하기">- 포트폴리오 등록하기</a></li>
												</ul>
											</div>

										</div>
										<p class="ellipsis"><?=$v['name']?></p>
									</div>
									<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <span><?=$txtArrow?></span> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
									<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
								</div>
							</div>
							<?
								}
							?>
						</div>
					</div>

					<div class="etf_tab_box">
						<div class="etf">
							<div class="row row_tit">
								<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
									<div class="col">52주 신고가</div>
									<div class="col">현재가 대비(등락)</div>
									<div class="col">거래량(등락)</div>
								</div>
							</div>
							<?
								//52주 신고가(ETF == Y)
								$row = sqlArray("select s.*, e.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_ETFs_Profile as e on s.symbol=e.symbol where t.etf='Y' and s.high52='1' ".$feWhere01.$feWhere02.$feWhere03.$feWhere04." order by e.aum desc limit 4");

								foreach($row as $v){
									$perData = Util::nf1($v['pmDataDay'],2);
									if($perData > 0){
										$txtClass = 'red';
										$txtArrow = '▲';

									}else if($perData < 0){
										$txtClass = 'blue';
										$txtArrow = '▼';

									}else{
										$txtClass = '';
										$txtArrow = '';
									}
							?>
							<div class="row row_cont">
								<div class="dp_sb dp_c dp_wrap">
									<div  class="col">
										<div class="blue_tit">
											<a class="help_point03" href="javascript:void(0);"><?=$v['symbol']?></a>
											<!--클릭시 생기는 박스-->
											<div class="helpbox">
												<ul class="small_ticker_menu">
													<li><a href="/sub07/sub01.php?gbl_symbol=<?=$v['symbol']?>" title="종목 정보보기">- 종목 정보보기</a></li>
													<li class="click_show_wrap">
														<span class="click_show_check">- 알림설정하기</span>
														<!--클릭시 생기는 테이블-->
														<div class="click_show_check_tbl">
															<div class="closeBtn"><span class="lnr lnr-cross"></span></div>
															<table class="subtable">
																<tbody>
																	<tr>
																		<th>회사이름(티커)</th>
																		<th>가격알림1</th>
																		<th>가격알림2</th>
																		<th>급등/급락</th>
																		<th>거래량증가</th>
																		<th>mdd<br>(하락폭 or 상승확률)</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																	</tr>
																</tbody>
															</table>
														</div>

													</li>
													<li><a href="/sub04/sub03.php" title="관심종목 등록하기">- 관심종목 등록하기</a></li>
													<li><a href="/sub04/sub04.php" title="포트폴리오 등록하기">- 포트폴리오 등록하기</a></li>
												</ul>
											</div>

										</div>
										<p class="ellipsis"><?=$v['name']?></p>
									</div>
									<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <span><?=$txtArrow?></span> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
									<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
								</div>
							</div>
							<?
								}
							?>
						</div>
					</div>

					<div class="etf_tab_box">
						<div class="etf">
							<div class="row row_tit">
								<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
									<div class="col">급락주</div>
									<div class="col">현재가 대비(등락)</div>
									<div class="col">거래량(등락)</div>
								</div>
							</div>
							<?
								//급락주(ETF == Y)
								$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol ".$feQuery." where t.etf='Y' and s.c>0 ".$feWhere01.$feWhere02.$feWhere03.$feWhere04." order by s.pmDataDay asc limit 4");

								foreach($row as $v){
									$perData = Util::nf1($v['pmDataDay'],2);
									if($perData > 0){
										$txtClass = 'red';
										$txtArrow = '▲';

									}else if($perData < 0){
										$txtClass = 'blue';
										$txtArrow = '▼';

									}else{
										$txtClass = '';
										$txtArrow = '';
									}
							?>
							<div class="row row_cont">
								<div class="dp_sb dp_c dp_wrap">
									<div  class="col">
										<div class="blue_tit">
											<a class="help_point03" href="javascript:void(0);"><?=$v['symbol']?></a>
											<!--클릭시 생기는 박스-->
											<div class="helpbox">
												<ul class="small_ticker_menu">
													<li><a href="/sub07/sub01.php?gbl_symbol=<?=$v['symbol']?>" title="종목 정보보기">- 종목 정보보기</a></li>
													<li class="click_show_wrap">
														<span class="click_show_check">- 알림설정하기</span>
														<!--클릭시 생기는 테이블-->
														<div class="click_show_check_tbl">
															<div class="closeBtn"><span class="lnr lnr-cross"></span></div>
															<table class="subtable">
																<tbody>
																	<tr>
																		<th>회사이름(티커)</th>
																		<th>가격알림1</th>
																		<th>가격알림2</th>
																		<th>급등/급락</th>
																		<th>거래량증가</th>
																		<th>mdd<br>(하락폭 or 상승확률)</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																	</tr>
																</tbody>
															</table>
														</div>

													</li>
													<li><a href="/sub04/sub03.php" title="관심종목 등록하기">- 관심종목 등록하기</a></li>
													<li><a href="/sub04/sub04.php" title="포트폴리오 등록하기">- 포트폴리오 등록하기</a></li>
												</ul>
											</div>

										</div>
										<p class="ellipsis"><?=$v['name']?></p>
									</div>
									<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <span><?=$txtArrow?></span> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
									<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
								</div>
							</div>
							<?
								}
							?>
						</div>
					</div>

					<div class="etf_tab_box">
						<div class="etf">
							<div class="row row_tit">
								<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
									<div class="col">한국인 매수 상위</div>
									<div class="col">현재가 대비(등락)</div>
									<div class="col">거래량(등락)</div>
								</div>
							</div>
							<?
								//한국인 매수 상위
								$row = sqlArray("select s.*, k.name from koreanBuy as k left join Stock_Candles_Last as s on k.symbol=s.symbol ".$feQuery." where s.c>0 ".$feWhere01.$feWhere02.$feWhere03.$feWhere04." order by k.uid asc limit 4");

								foreach($row as $v){
									$perData = Util::nf1($v['pmDataDay'],2);
									if($perData > 0){
										$txtClass = 'red';
										$txtArrow = '▲';

									}else if($perData < 0){
										$txtClass = 'blue';
										$txtArrow = '▼';

									}else{
										$txtClass = '';
										$txtArrow = '';
									}
							?>
							<div class="row row_cont">
								<div class="dp_sb dp_c dp_wrap">
									<div  class="col">
										<div class="blue_tit">
											<a class="help_point03" href="javascript:void(0);"><?=$v['symbol']?></a>
											<!--클릭시 생기는 박스-->
											<div class="helpbox">
												<ul class="small_ticker_menu">
													<li><a href="/sub06/sub01.php?gbl_symbol=<?=$v['symbol']?>" title="종목 정보보기">- 종목 정보보기</a></li>
													<li class="click_show_wrap">
														<span class="click_show_check">- 알림설정하기</span>
														<!--클릭시 생기는 테이블-->
														<div class="click_show_check_tbl">
															<div class="closeBtn"><span class="lnr lnr-cross"></span></div>
															<table class="subtable">
																<tbody>
																	<tr>
																		<th>회사이름(티커)</th>
																		<th>가격알림1</th>
																		<th>가격알림2</th>
																		<th>급등/급락</th>
																		<th>거래량증가</th>
																		<th>mdd<br>(하락폭 or 상승확률)</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																	</tr>
																</tbody>
															</table>
														</div>

													</li>
													<li><a href="/sub04/sub03.php" title="관심종목 등록하기">- 관심종목 등록하기</a></li>
													<li><a href="/sub04/sub04.php" title="포트폴리오 등록하기">- 포트폴리오 등록하기</a></li>
												</ul>
											</div>

										</div>
										<p class="ellipsis"><?=$v['name']?></p>
									</div>
									<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <span><?=$txtArrow?></span> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
									<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
								</div>
							</div>
							<?
								}
							?>
						</div>
					</div>

					<div class="etf_tab_box">
						<div class="etf">
							<div class="row row_tit">
								<div class="dp_sb dp_c dp_wrap dp_cc" style="height: 100%;">
									<div class="col">52주 신저가</div>
									<div class="col">현재가 대비(등락)</div>
									<div class="col">거래량(등락)</div>
								</div>
							</div>
							<?
								//52주 신저가(ETF == Y)
								$row = sqlArray("select s.*, e.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_ETFs_Profile as e on s.symbol=e.symbol where t.etf='Y' and s.low52='1' ".$feWhere01.$feWhere02.$feWhere03.$feWhere04." order by e.aum desc limit 4");

								foreach($row as $v){
									$perData = Util::nf1($v['pmDataDay'],2);
									if($perData > 0){
										$txtClass = 'red';
										$txtArrow = '▲';

									}else if($perData < 0){
										$txtClass = 'blue';
										$txtArrow = '▼';

									}else{
										$txtClass = '';
										$txtArrow = '';
									}
							?>
							<div class="row row_cont">
								<div class="dp_sb dp_c dp_wrap">
									<div  class="col">
										<div class="blue_tit">
											<a class="help_point03" href="javascript:void(0);"><?=$v['symbol']?></a>
											<!--클릭시 생기는 박스-->
											<div class="helpbox">
												<ul class="small_ticker_menu">
													<li><a href="/sub06/sub01.php?gbl_symbol=<?=$v['symbol']?>" title="종목 정보보기">- 종목 정보보기</a></li>
													<li class="click_show_wrap">
														<span class="click_show_check">- 알림설정하기</span>
														<!--클릭시 생기는 테이블-->
														<div class="click_show_check_tbl">
															<div class="closeBtn"><span class="lnr lnr-cross"></span></div>
															<table class="subtable">
																<tbody>
																	<tr>
																		<th>회사이름(티커)</th>
																		<th>가격알림1</th>
																		<th>가격알림2</th>
																		<th>급등/급락</th>
																		<th>거래량증가</th>
																		<th>mdd<br>(하락폭 or 상승확률)</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																	</tr>
																</tbody>
															</table>
														</div>

													</li>
													<li><a href="/sub04/sub03.php" title="관심종목 등록하기">- 관심종목 등록하기</a></li>
													<li><a href="/sub04/sub04.php" title="포트폴리오 등록하기">- 포트폴리오 등록하기</a></li>
												</ul>
											</div>

										</div>
										<p class="ellipsis"><?=$v['name']?></p>
									</div>
									<div class="col <?=$txtClass?>"><?=number_format($v['c'],2)?> <span><?=$txtArrow?></span> (<?=Util::nf1($v['pmDataDay'],2)?>%)</div>
									<div class="col"><?=Util::nf1($v['vDataDay'],2)?>%</div>
								</div>
							</div>
							<?
								}
							?>
						</div>
					</div>