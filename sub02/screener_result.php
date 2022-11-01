<?
$rowArr = Array();		//참고 테이블별 종목
$queryArr = Array();	//테이블별 쿼리 조건문

/*********************************************** 자산운용규모(DB에 원단위로 저장되어있음) / ETFs profile ***********************************************/
if($fs01 == '50')			$queryArr['ETFsProfile'] = "aum>=50000000000";
elseif($fs01 == '10')		$queryArr['ETFsProfile'] = "(aum>=10000000000 and aum<50000000000)";
elseif($fs01 == '2')		$queryArr['ETFsProfile'] = "(aum>=2000000000 and aum<10000000000)";
elseif($fs01 == '0.5')	$queryArr['ETFsProfile'] = "(aum>=500000000 and aum<2000000000)";
elseif($fs01 == '0.1')	$queryArr['ETFsProfile'] = "(aum>=100000000 and aum<500000000)";
elseif($fs01 == '0.0')	$queryArr['ETFsProfile'] = "aum<100000000";


/*********************************************** 순자산가치(DB에 10억단위로 저장되어있음) / ETFs profile ***********************************************/
if($fs02){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";

	if($fs02 == '200')		$queryArr['ETFsProfile'] .= "nav>=200";
	elseif($fs02 == '100')	$queryArr['ETFsProfile'] .= "(nav>=100 and nav<200)";
	elseif($fs02 == '50')		$queryArr['ETFsProfile'] .= "(nav>=50 and nav<100)";
	elseif($fs02 == '25')		$queryArr['ETFsProfile'] .= "(nav>=25 and nav<50)";
	elseif($fs02 == '10')		$queryArr['ETFsProfile'] .= "(nav>=10 and nav<25)";
	elseif($fs02 == '5')		$queryArr['ETFsProfile'] .= "(nav>=5 and nav<10)";
	elseif($fs02 == '5')		$queryArr['ETFsProfile'] .= "nav<5";
}


/*********************************************** 수수료율 / ETFs profile ***********************************************/
if($fs03){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";

	if($fs03 == '1')			$queryArr['ETFsProfile'] .= "expenseRatio>=1";
	elseif($fs03 == '0.5')	$queryArr['ETFsProfile'] .= "(expenseRatio>=0.5 and expenseRatio<1)";
	elseif($fs03 == '0.3')	$queryArr['ETFsProfile'] .= "(expenseRatio>=0.3 and expenseRatio<0.5)";
	elseif($fs03 == '0.2')	$queryArr['ETFsProfile'] .= "(expenseRatio>=0.2 and expenseRatio<0.3)";
	elseif($fs03 == '0.1')	$queryArr['ETFsProfile'] .= "(expenseRatio>=0.1 and expenseRatio<0.2)";
	elseif($fs03 == '0.0')	$queryArr['ETFsProfile'] .= "expenseRatio<0.1";
}


/*********************************************** P/B / ETFs profile ***********************************************/
if($fs04){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";

	if($fs04 == '15')			$queryArr['ETFsProfile'] .= "priceToBook>=15";
	elseif($fs04 == '8')		$queryArr['ETFsProfile'] .= "(priceToBook>=8 and priceToBook<15)";
	elseif($fs04 == '4')		$queryArr['ETFsProfile'] .= "(priceToBook>=4 and priceToBook<8)";
	elseif($fs04 == '2')		$queryArr['ETFsProfile'] .= "(priceToBook>=2 and priceToBook<4)";
	elseif($fs04 == '1')		$queryArr['ETFsProfile'] .= "(priceToBook>=1 and priceToBook<2)";
	elseif($fs04 == '0.5')	$queryArr['ETFsProfile'] .= "(priceToBook>=0.5 and priceToBook<1)";
	elseif($fs04 == '0.4')	$queryArr['ETFsProfile'] .= "priceToBook<0.5";
}


/*********************************************** P/E / ETFs profile ***********************************************/
if($fs05){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";

	if($fs05 == '100')		$queryArr['ETFsProfile'] .= "priceToEarnings>=100";
	elseif($fs05 == '50')		$queryArr['ETFsProfile'] .= "(priceToEarnings>=50 and priceToEarnings<100)";
	elseif($fs05 == '25')		$queryArr['ETFsProfile'] .= "(priceToEarnings>=25 and priceToEarnings<50)";
	elseif($fs05 == '10')		$queryArr['ETFsProfile'] .= "(priceToEarnings>=10 and priceToEarnings<25)";
	elseif($fs05 == '5')		$queryArr['ETFsProfile'] .= "(priceToEarnings>=5 and priceToEarnings<10)";
	elseif($fs05 == '1')		$queryArr['ETFsProfile'] .= "(priceToEarnings>=1 and priceToEarnings<5)";
	elseif($fs05 == '0.9')	$queryArr['ETFsProfile'] .= "priceToEarnings<1";
}








/*********************************************** 특정종목 포함ETF / ETFs Holdings ***********************************************/
if($fs06){
	$tmpArr = Array();
	$row = sqlArray("select * from api_ETFs_Holdings where symbolTxt='".$fs06."' group by symbol");
	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}






/*********************************************** 특정 투자테마 / ETFs profile ***********************************************/
if($fs07){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";
	$queryArr['ETFsProfile'] .= "investmentSegment='".$fs07."'";
}






/*********************************************** 보유종목수 / ETFs Holdings ***********************************************/
if($fs08 == '5000')			$queryArr['ETFsHoldings'] = "cnt>=5000";
elseif($fs08 == '1000')		$queryArr['ETFsHoldings'] = "(cnt>=1000 and cnt<5000)";
elseif($fs08 == '500')		$queryArr['ETFsHoldings'] = "(cnt>=500 and cnt<1000)";
elseif($fs08 == '250')		$queryArr['ETFsHoldings'] = "(cnt>=250 and cnt<500)";
elseif($fs08 == '100')		$queryArr['ETFsHoldings'] = "(cnt>=100 and cnt<250)";
elseif($fs08 == '50')			$queryArr['ETFsHoldings'] = "(cnt>=50 and cnt<100)";
elseif($fs08 == '25')			$queryArr['ETFsHoldings'] = "(cnt>=25 and cnt<50)";
elseif($fs08 == '24')			$queryArr['ETFsHoldings'] = "cnt<25";

if($queryArr['ETFsHoldings']){
	$tmpArr = Array();
	$row = sqlArray("select symbol, count(*) as cnt from api_ETFs_Holdings group by symbol having ".$queryArr['ETFsHoldings']);

	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}






/*********************************************** 추적인덱스 / ETFs profile ***********************************************/
if($fs09){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";
	$queryArr['ETFsProfile'] .= "trackingIndex='".$fs09."'";
}

/*********************************************** 운용회사 / ETFs profile ***********************************************/
if($fs10){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";
	$queryArr['ETFsProfile'] .= "etfCompany='".$fs10."'";
}





/*********************************************** 시가분배율 / ETF SIGA ***********************************************/
if($fs11 == '10')			$queryArr['ETFSIGA'] = "siga>=10";
elseif($fs11 == '5')		$queryArr['ETFSIGA'] = "(siga>=5 and siga<10)";
elseif($fs11 == '3')		$queryArr['ETFSIGA'] = "(siga>=3 and siga<5)";
elseif($fs11 == '2')		$queryArr['ETFSIGA'] = "(siga>=2 and siga<3)";
elseif($fs11 == '1')		$queryArr['ETFSIGA'] = "(siga>=1 and siga<2)";
elseif($fs11 == '0.9')	$queryArr['ETFSIGA'] = "(siga>=0 and siga<1)";
elseif($fs11 == '0.0')	$queryArr['ETFSIGA'] = "siga=0";

if($queryArr['ETFSIGA']){
	$tmpArr = Array();
	$row = sqlArray("select * from etf_siga where ".$queryArr['ETFSIGA']);

	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}







/*********************************************** 1주당 가격 /Stock_Candles_Last ***********************************************/
if($fs12 == '200')		$queryArr['StockCandlesLast'] = "c>=200";
elseif($fs12 == '100')	$queryArr['StockCandlesLast'] = "(c>=100 and c<200)";
elseif($fs12 == '50')		$queryArr['StockCandlesLast'] = "(c>=50 and c<100)";
elseif($fs12 == '20')		$queryArr['StockCandlesLast'] = "(c>=20 and c<50)";
elseif($fs12 == '10'	)	$queryArr['StockCandlesLast'] = "(c>=10 and c<20)";
elseif($fs12 == '1')		$queryArr['StockCandlesLast'] = "c<10";





/*********************************************** 평균거래량 / ETFs profile ***********************************************/
if($fs13){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";

	if($fs13 == '5000')		$queryArr['ETFsProfile'] .= "avgVolume>=50000000";
	elseif($fs13 == '1000')	$queryArr['ETFsProfile'] .= "(avgVolume>=10000000 and avgVolume<50000000)";
	elseif($fs13 == '200')	$queryArr['ETFsProfile'] .= "(avgVolume>=2000000 and avgVolume<10000000)";
	elseif($fs13 == '50')		$queryArr['ETFsProfile'] .= "(avgVolume>=500000 and avgVolume<2000000)";
	elseif($fs13 == '10')		$queryArr['ETFsProfile'] .= "(avgVolume>=100000 and avgVolume<500000)";
	elseif($fs13 == '1')		$queryArr['ETFsProfile'] .= "avgVolume<100000";
}



/*********************************************** 상장일 / ETFs profile ***********************************************/
if($fs14){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";

	if($fs14 == '1990'){
		$tmpStime = strtotime('1990-01-01');
		$queryArr['ETFsProfile'] .= "inceptionDateTime<$tmpStime";

	}elseif($fs14 == '2000'){
		$tmpStime = strtotime('1990-01-01');
		$tmpEtime = strtotime('2000-01-01');
		$queryArr['ETFsProfile'] .= "(inceptionDateTime>=$tmpStime and inceptionDateTime<$tmpEtime)";

	}elseif($fs14 == '2010'){
		$tmpStime = strtotime('2000-01-01');
		$tmpEtime = strtotime('2010-01-01');
		$queryArr['ETFsProfile'] .= "(inceptionDateTime>=$tmpStime and inceptionDateTime<$tmpEtime)";

	}elseif($fs14 == '2020'){
		$tmpStime = strtotime('2010-01-01');
		$tmpEtime = strtotime('2020-01-01');
		$queryArr['ETFsProfile'] .= "(inceptionDateTime>=$tmpStime and inceptionDateTime<$tmpEtime)";

	}elseif($fs14 == '2030'){
		$tmpStime = strtotime('2020-01-01');
		$queryArr['ETFsProfile'] .= "inceptionDateTime>=$tmpStime";
	}
}



/*********************************************** 레버리지/인버스 ETF / ETFs profile ***********************************************/
if($fs15){
	if($queryArr['ETFsProfile'])	$queryArr['ETFsProfile'] .= " and ";

	if($fs15 == 'x2')				$queryArr['ETFsProfile'] .= "x2='Y'";
	elseif($fs15 == 'x3')			$queryArr['ETFsProfile'] .= "x3='Y'";
	elseif($fs15 == 'inverse')	$queryArr['ETFsProfile'] .= "inverse='Y'";
}


/*********************************************** 1달 수익률 /Stock_Candles_Last ***********************************************/
if($fs16){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs16 == '20')			$queryArr['StockCandlesLast'] .= "pmDataMonth>=20";
	elseif($fs16 == '10')		$queryArr['StockCandlesLast'] .= "(pmDataMonth>=10 and pmDataMonth<20)";
	elseif($fs16 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth>=0 and pmDataMonth<10)";
	elseif($fs16 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth>=-10 and pmDataMonth<0)";
	elseif($fs16 == '-10')	$queryArr['StockCandlesLast'] .= "(pmDataMonth>=-20 and pmDataMonth<-10)";
	elseif($fs16 == '-20')	$queryArr['StockCandlesLast'] .= "pmDataMonth<-20";
}

/*********************************************** 3달 수익률 /Stock_Candles_Last ***********************************************/
if($fs17){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs17 == '30')			$queryArr['StockCandlesLast'] .= "pmDataMonth3>=30";
	elseif($fs17 == '15')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=15 and pmDataMonth3<30)";
	elseif($fs17 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=0 and pmDataMonth3<15)";
	elseif($fs17 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=-15 and pmDataMonth3<0)";
	elseif($fs17 == '-15')	$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=-30 and pmDataMonth3<-15)";
	elseif($fs17 == '-30')	$queryArr['StockCandlesLast'] .= "pmDataMonth3<-30";
}

/*********************************************** 6달 수익률 /Stock_Candles_Last ***********************************************/
if($fs18){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs18 == '50')			$queryArr['StockCandlesLast'] .= "pmDataMonth6>=50";
	elseif($fs18 == '25')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=25 and pmDataMonth6<50)";
	elseif($fs18 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=0 and pmDataMonth6<25)";
	elseif($fs18 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=-25 and pmDataMonth6<0)";
	elseif($fs18 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=-50 and pmDataMonth6<-25)";
	elseif($fs18 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataMonth6<-50";
}

/*********************************************** 1년 수익률 /Stock_Candles_Last ***********************************************/
if($fs19){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs19 == '100')		$queryArr['StockCandlesLast'] .= "pmDataYear1>=100";
	elseif($fs19 == '50')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=50 and pmDataYear1<100)";
	elseif($fs19 == '25')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=25 and pmDataYear1<50)";
	elseif($fs19 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=0 and pmDataYear1<25)";
	elseif($fs19 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=-25 and pmDataYear1<0)";
	elseif($fs19 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataYear1>=-50 and pmDataYear1<-25)";
	elseif($fs19 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataYear1<-50";
}

/*********************************************** 5년 수익률 /Stock_Candles_Last ***********************************************/
if($fs20){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs20 == '500')		$queryArr['StockCandlesLast'] .= "pmDataYear5>=500";
	elseif($fs20 == '300')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=300 and pmDataYear5<500)";
	elseif($fs20 == '100')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=100 and pmDataYear5<300)";
	elseif($fs20 == '50')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=50 and pmDataYear5<100)";
	elseif($fs20 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=0 and pmDataYear5<50)";
	elseif($fs20 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=-25 and pmDataYear5<0)";
	elseif($fs20 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=-50 and pmDataYear5<-25)";
	elseif($fs20 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataYear5<-50";
}











if($queryArr['ETFsProfile']){
	$tmpArr = Array();
	$row = sqlArray("select symbol from api_ETFs_Profile where ".$queryArr['ETFsProfile']);

	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}

if($queryArr['StockCandlesLast']){
	$tmpArr = Array();
	$row = sqlArray("select symbol from Stock_Candles_Last where ".$queryArr['StockCandlesLast']);
	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}





//결과 심볼리스트
$sArr = Array();

$arrNum = count($rowArr);
if($arrNum){
	$etfArr = Array();		//ETF=N인 종목
	$row = sqlArray("select * from ks_symbol where etf='Y' order by symbol");
	foreach($row as $v){
		$etfArr[] = $v['symbol'];
	}

	//ETF=N 종목과 테이블별 검색결과 종목의 교집합 배열을 만듬
	foreach($rowArr as $r){
		$etfArr = array_values(array_intersect($etfArr,$r));
	}

	$sArr = $etfArr;
	sort($sArr);
}




//시가분배율 계산을 위한 타임값
$eTime = time();
$sDate = date('Y-m-01', strtotime("-1 year"));
$sTime = strtotime($sDate);



if(!$record_count)		$record_count = 10;		//한 페이지에 출력되는 레코드수
$link_count = 10;		//한 페이지에 출력되는 페이지 링크수

if(!$record_start)	$record_start = 0;

$current_page = ($record_start / $record_count) + 1;

$group = floor($record_start / ($record_count * $link_count));

$total_record = count($sArr);

$total_page = (int)($total_record / $record_count);

if($total_record % $record_count){
	$total_page++;
}

$sKey = $record_start;
$eKey = $record_start + $record_count;
if($eKey > $total_record)	$eKey = $total_record;
?>

<?
//관심종목 or 포트폴리오 페이지 > 그룹내 종목추가
if($call_page == 'GroupPortfolio'){
?>
<script>
function symbolAdd(s){
	parent.$('#groupStock').val(s);
	parent.$('.titleBox_close').click();
	parent.groupStockCheck();
}
</script>
<?
}else{
?>
<script>
function newsList(s){
	parent.$("#newsListBox").css({"width":"90%","max-width":"700px"});
	parent.$('#newsList_ttl').text(s);
	parent.$('#newsListFrame').html("<iframe name='newsList' id='newsList' src='../CompanyNewsList.php?newsSymbol="+s+"' style='width:100%;height:600px;' frameborder='0' scrolling='auto'></iframe>");
	parent.$('.newsListBox_open').click();
}
</script>
<?
}
?>
		<div class="sec_etf_wrap">
			<div class="ora_line"></div>
			<div class="help_rel_flex">
				<h4 class="sub_tit_det">Stock Screener Results</h4>
				<div class="help_wrap">
					<div class="excla_mark help_point">
						<span>i</span>
					</div>
					<div class="helpbox">
						<p>Stock Screener Results 입니다.</p>
					</div>
				</div>
			</div>
			<div class="sec_table stock_table">
				<table class="subtable">
					<tbody>
						<tr>
							<th>티커+ETF이름</th>
							<th>운용사이름</th>
							<th>현재가격+1일가격변동폭+퍼센트</th>
							<th>6개월수익률퍼센트</th>
							<th>AUM</th>
							<th>수수료율</th>
							<th>시가분배율 TTM</th>
							<th>ETF홈페이지</th>
						<?if($call_page != 'GroupPortfolio'){?>
							<th>기사</th>
						<?}?>
						</tr>
					<?
					if($total_record){
						for($k=$sKey; $k<$eKey; $k++){
							$s = $sArr[$k];	//심볼

							$row = sqlRow("select p.*, s.c, s.pmDataDay, s.pmDataMonth6 from api_ETFs_Profile as p left join Stock_Candles_Last as s on p.symbol=s.symbol where p.symbol='".$s."'");

							$nowC = $row['c'];	//최신 c값

							$perData = Util::nf1($row['pmDataDay'],2);
							if($perData > 0){
								$txtClass = 'upClass';
								$txtArrow = '▲';

							}else if($perData < 0){
								$txtClass = 'downClass';
								$txtArrow = '▼';

							}else{
								$txtClass = '';
								$txtArrow = '';
							}

							$aum = $row['aum'] / 1000000;

/*
							//해당 ETF 티커를 dividend api 에서 검색을 하는데, from 은 오늘 날짜에서 1년전 날짜를 포함한 월의 1일 (예를들어 오늘이 2022 0614 면 2021 0601 부터), to 는 오늘 날짜 로 해서 나오는 adjustedAmount 를 전부 다 더한 다음 stock candles D 의 C값 최신값으로 나눈 것을 % 로 표기
							$siga = 0;
							$sumAmount = sqlRowOne("select sum(adjustedAmount) from api_Dividends where symbol='".$s."' and dateTime>='".$sTime."' and dateTime<='".$eTime."'");
							if($sumAmount){
								$siga = ($sumAmount / $nowC) * 100;
							}
*/
							$siga = sqlRowOne("select siga from etf_siga where symbol='".$s."'");

							$udClass01 = UpDownClass($row['pmDataMonth6']);		//상승,하락 색상
					?>
						<tr>
							<td title='티커+ETF이름'>
							<?
								//관심종목 or 포트폴리오 페이지
								if($call_page == 'GroupPortfolio'){
							?>
								<a href="javascript:symbolAdd('<?=$s?>');">
									<span class="blue bb block"><?=$s?></span>
									<span class="block"><?=$row['name']?></span>
								</a>
							<?
								}else{
							?>
								<a href="/sub07/sub01.php?gbl_symbol=<?=$s?>">
									<span class="blue bb block"><?=$s?></span>
									<span class="block"><?=$row['name']?></span>
								</a>
							<?
								}
							?>
							</td>
							<td title='운용사이름'><?=$row['etfCompany']?></td>
							<td title="현재가격+1일가격변동폭+퍼센트"><span class="<?=$txtClass?>"><?=number_format($nowC,2)?> <?=$txtArrow?> (<?=Util::nf1($row['pmDataDay'],2)?>%)</span></td>
							<td title='6개월수익률퍼센트'>
								<span class='<?=$udClass01?>'><?=$row['pmDataMonth6']?>%</span>
								<!--회원가입하면 없어지는 상자
								<div class="blur_box_s">
									<div class="plue_btn help_point">
										<span>+</span>
									</div>
									<div class="helpbox">
										<p>회원가입 하시고 적정주가를 확인해보세요!</p>
									</div>
								</div>
								회원가입하면 없어지는 상자-->
							</td>
							<td title='AUM'><span class="bold">$<?=number_format($aum,2)?></span></td>
							<td title='수수료율'><?=$row['expenseRatio']?>%</td>
							<td title='시가분배율'><?=number_format($siga,2)?>%</td>
							<td title='ETF홈페이지'>
							<?
								if($row['website']){
							?>
								<a href="<?=$row['website']?>" target="_blank">SITE</a>
							<?
								}
							?>
							</td>
						<?if($call_page != 'GroupPortfolio'){?>
							<td title="기사링크"><a href="javascript:newsList('<?=$s?>');"><i class="fas fa-chalkboard-teacher"></i></a></td>
						<?}?>
						</tr>
					<?
						}
					}elseif($listFocus){
					?>
						<tr>
							<td colspan="10" style='text-align:center;font-size:16px;'>검색 조건에 맞는 종목이 없습니다.</td>
						</tr>
					<?
					}else{
					?>
						<tr>
							<td colspan="10" style='text-align:center;font-size:16px;'>검색 조건을 입력해 주세요.</td>
						</tr>
					<?
					}
					?>
					</tbody>
				</table>
			</div>
		</div>

<?
	$fName = 'frm_screener';
	include '../module/pageNumCount.php';
?>

<?
if($listFocus){
?>
<script>
$(document).ready(function(){
	var offset = $(".sec_etf_wrap").offset();
	var menuHeight =$("header").offsetHeight;
	$('html, body').animate({scrollTop : offset.top - 180}, 400);
});
</script>
<?
}
?>