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

//지수편입종목 쿼리
$csArr01 = Array();
$fsWhere01 = '';

if($fs01_01){
	$fsWhere01 = "symbol='^GSPC'";			//S&P500
}

if($fs01_02){
	if($fsWhere01)		$fsWhere01 .= " or ";
	$fsWhere01 .= "symbol='^NDX'";				//나스닥100
}

if($fs01_03){
	if($fsWhere01)		$fsWhere01 .= " or ";
	$fsWhere01 .= "symbol='^RUT'";				//Rusell 2000
}

if($fs01_04){
	if($fsWhere01)		$fsWhere01 .= " or ";
	$fsWhere01 .= "symbol!=''";					//미국주식 전체
}

if($fsWhere01){
	$row = sqlArray("select * from api_Indices_Constituents where ".$fsWhere01." order by stxt");

	foreach($row as $v){
		$csArr01[] = $v['stxt'];
	}
}

array_unique($csArr01);	//중복제거


//시가총액 쿼리
$fsWhere02 = '';

if($fs02_01){
	if($fsWhere02 == '')	$fsWhere02 = " and (";
	$fsWhere02 .= "c.marketCapitalization>=200000";														//Mega
}

if($fs02_02){
	if($fsWhere02 == '')	$fsWhere02 = "and (";
	else						$fsWhere02 .= " or ";
	$fsWhere02 .= "(c.marketCapitalization>=10000 and c.marketCapitalization<200000)";		//Large
}

if($fs02_03){
	if($fsWhere02 == '')	$fsWhere02 = "and (";
	else						$fsWhere02 .= " or ";
	$fsWhere02 .= "(c.marketCapitalization>=20000 and c.marketCapitalization<10000)";		//Medium
}

if($fs02_04){
	if($fsWhere02 == '')	$fsWhere02 = "and (";
	else						$fsWhere02 .= " or ";
	$fsWhere02 .= "(c.marketCapitalization>=300 and c.marketCapitalization<2000)";				//Small
}

if($fs02_05){
	if($fsWhere02 == '')	$fsWhere02 = "and (";
	else						$fsWhere02 .= " or ";
	$fsWhere02 .= "c.marketCapitalization<300";																//Micro
}

if($fsWhere02)		$fsWhere02 .= ") ";




//전문가 의견 쿼리
$csArr03 = Array();
$fsWhere03 = '';

if($fs03_01){
	$fsWhere03 = "t.score>=4.5";									//강력매수
}

if($fs03_02){
	if($fsWhere03)		$fsWhere03 .= " or ";
	$fsWhere03 .= "(t.score>=3.5 and t.score<4.5)";		//매수이상
}

if($fs03_03){
	if($fsWhere03)		$fsWhere03 .= " or ";
	$fsWhere03 .= "(t.score>=2.5 and t.score<3.5)";		//중립이상
}

if($fs03_04){
	if($fsWhere03)		$fsWhere03 .= " or ";
	$fsWhere03 .= "t.score<2.5";									//중립미만
}

if($fsWhere03){
	$row = sqlArray("select * from (select * from api_Recommendation_Trends where (symbol, period) in (select symbol, max(period) as period from api_Recommendation_Trends group by symbol) order by period desc) t where ".$fsWhere03." group by t.symbol");

	foreach($row as $v){
		$csArr03[] = $v['symbol'];
	}
}

array_unique($csArr03);	//중복제거


//한주당 가격
$fsWhere04 = '';

if($fs04_01){
	if($fsWhere04 == '')	$fsWhere04 = " and (";
	$fsWhere04 .= "s.c<10";								//10미만
}

if($fs04_02){
	if($fsWhere04 == '')	$fsWhere04 = "and (";
	else						$fsWhere04 .= " or ";
	$fsWhere04 .= "(s.c>=10 and s.c<20)";			//10~20미만
}

if($fs04_03){
	if($fsWhere04 == '')	$fsWhere04 = "and (";
	else						$fsWhere04 .= " or ";
	$fsWhere04 .= "(s.c>=20 and s.c<30)";			//20~30미만
}

if($fs04_04){
	if($fsWhere04 == '')	$fsWhere04 = "and (";
	else						$fsWhere04 .= " or ";
	$fsWhere04 .= "(s.c>=30 and s.c<50)";			//30~50미만
}

if($fs04_05){
	if($fsWhere04 == '')	$fsWhere04 = "and (";
	else						$fsWhere04 .= " or ";
	$fsWhere04 .= "s.c>=50";								//50이상
}

if($fsWhere04)		$fsWhere04 .= ") ";




//지수편입종목 & 전문가의견 필터링 결과 교집합 배열 만들기
$slistArr = Array();
if(count($csArr01) > 0 && count($csArr03) > 0){
	$slistArr = array_values(array_intersect($csArr01,$csArr03));

}elseif(count($csArr01) > 0){
	$slistArr = $csArr01;

}elseif(count($csArr03) > 0){
	$slistArr = $csArr03;
}
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
								//급등주(ETF == N)
								$no = 0;
								$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol where t.etf='N' ".$fsWhere02.$fsWhere04." order by s.pmDataDay desc");								

								foreach($row as $v){
									if(in_array($v['symbol'],$slistArr) || count($slistArr) == 0){
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
																		<th>배당락</th>
																		<th>실적발표</th>
																		<th>컨센서스<br>상향/하향</th>
																		<th>내부자거래</th>
																		<th>적정주가</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr1" type="checkbox">
																				<label for="alr1"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr2" type="checkbox">
																				<label for="alr2"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr3" type="checkbox">
																				<label for="alr3"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr4" type="checkbox">
																				<label for="alr4"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr5" type="checkbox">
																				<label for="alr5"></label>
																			</div>
																		</td>
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
										$no++;
										if($no == 4)	break;
									}
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
								//거래량 급등주(ETF == N)
								$no = 0;
								$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol where t.etf='N' ".$fsWhere02.$fsWhere04." order by s.vDataDay desc");

								foreach($row as $v){
									if(in_array($v['symbol'],$slistArr) || count($slistArr) == 0){
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
																		<th>배당락</th>
																		<th>실적발표</th>
																		<th>컨센서스<br>상향/하향</th>
																		<th>내부자거래</th>
																		<th>적정주가</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr6" type="checkbox">
																				<label for="alr6"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr7" type="checkbox">
																				<label for="alr7"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr8" type="checkbox">
																				<label for="alr8"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr9" type="checkbox">
																				<label for="alr9"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr10" type="checkbox">
																				<label for="alr10"></label>
																			</div>
																		</td>
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
										$no++;
										if($no == 4)	break;
									}
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
								//52주 신고가(ETF == N)
								$no = 0;
//								$row = sqlArray("select s.*, c.name, round(s.h-b.WeekHigh52, 2) as weekHigh from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol left join api_Basic_Financials as b on s.symbol=b.symbol where t.etf='N' and b.WeekHigh52 is not null order by weekHigh desc limit 4");
								$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol left join api_Basic_Financials as b on s.symbol=b.symbol ".$fsQuery01." where t.etf='N' and s.high52='1' ".$fsWhere02.$fsWhere04." order by c.marketCapitalization desc");

								foreach($row as $v){
									if(in_array($v['symbol'],$slistArr) || count($slistArr) == 0){
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
																		<th>배당락</th>
																		<th>실적발표</th>
																		<th>컨센서스<br>상향/하향</th>
																		<th>내부자거래</th>
																		<th>적정주가</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr11" type="checkbox">
																				<label for="alr11"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr12" type="checkbox">
																				<label for="alr12"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr13" type="checkbox">
																				<label for="alr13"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr14" type="checkbox">
																				<label for="alr14"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr15" type="checkbox">
																				<label for="alr15"></label>
																			</div>
																		</td>
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
										$no++;
										if($no == 4)	break;
									}
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
								//급락주(ETF == N)
								$no = 0;
								$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol where t.etf='N' and s.c>0 ".$fsWhere02.$fsWhere04." order by s.pmDataDay");

								foreach($row as $v){
									if(in_array($v['symbol'],$slistArr) || count($slistArr) == 0){
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
																		<th>배당락</th>
																		<th>실적발표</th>
																		<th>컨센서스<br>상향/하향</th>
																		<th>내부자거래</th>
																		<th>적정주가</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr16" type="checkbox">
																				<label for="alr16"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr17" type="checkbox">
																				<label for="alr17"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr18" type="checkbox">
																				<label for="alr18"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr19" type="checkbox">
																				<label for="alr19"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr20" type="checkbox">
																				<label for="alr20"></label>
																			</div>
																		</td>
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
										$no++;
										if($no == 4)	break;
									}
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
								$no = 0;
								$row = sqlArray("select s.*, k.name from koreanBuy as k left join Stock_Candles_Last as s on k.symbol=s.symbol left join api_Company_Profile as c on s.symbol=c.symbol where s.c>0 ".$fsWhere02.$fsWhere04." order by k.uid");

								foreach($row as $v){
									if(in_array($v['symbol'],$slistArr) || count($slistArr) == 0){
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
																		<th>배당락</th>
																		<th>실적발표</th>
																		<th>컨센서스<br>상향/하향</th>
																		<th>내부자거래</th>
																		<th>적정주가</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr21" type="checkbox">
																				<label for="alr21"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr22" type="checkbox">
																				<label for="alr22"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr23" type="checkbox">
																				<label for="alr23"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr24" type="checkbox">
																				<label for="alr24"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr25" type="checkbox">
																				<label for="alr25"></label>
																			</div>
																		</td>
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
										$no++;
										if($no == 4)	break;
									}
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
								//52주 신저가(ETF == N)
								$no = 0;
//								$row = sqlArray("select s.*, c.name, round(s.l-b.WeekLow52, 2) as WeekLow from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol left join api_Basic_Financials as b on s.symbol=b.symbol where t.etf='N' and b.WeekLow52 is not null order by WeekLow desc limit 4");
								$row = sqlArray("select s.*, c.name from Stock_Candles_Last as s left join ks_symbol as t on s.symbol=t.symbol left join api_Company_Profile as c on s.symbol=c.symbol left join api_Basic_Financials as b on s.symbol=b.symbol  where t.etf='N' and s.low52='1' ".$fsWhere02.$fsWhere04." order by c.marketCapitalization desc");

								foreach($row as $v){
									if(in_array($v['symbol'],$slistArr) || count($slistArr) == 0){
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
																		<th>배당락</th>
																		<th>실적발표</th>
																		<th>컨센서스<br>상향/하향</th>
																		<th>내부자거래</th>
																		<th>적정주가</th>
																	</tr>
																	<tr>
																		<td>CNWGY</td>
																		<td></td>
																		<td></td>
																		<td>+10%/-10%</td>
																		<td>평균의 5배</td>
																		<td>85%(상승확률)</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr26" type="checkbox">
																				<label for="alr26"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr27" type="checkbox">
																				<label for="alr27"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr28" type="checkbox">
																				<label for="alr28"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr29" type="checkbox">
																				<label for="alr29"></label>
																			</div>
																		</td>
																		<td>
																			<div class="side_choice">
																				<input id="alr30" type="checkbox">
																				<label for="alr30"></label>
																			</div>
																		</td>
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
										$no++;
										if($no == 4)	break;
									}
								}
							?>
						</div>
					</div>