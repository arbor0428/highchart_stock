<?
$rowArr = Array();		//참고 테이블별 종목
$queryArr = Array();	//테이블별 쿼리 조건문

/*********************************************** 시가총액(DB에100만 USD 단위로 저장되어 있음) / Company profile ***********************************************/
if($fs01 == 'Mega')			$queryArr['CompanyProfile'] = "marketCapitalization>=200000";
elseif($fs01 == 'Large')		$queryArr['CompanyProfile'] = "(marketCapitalization>=10000 and marketCapitalization<200000)";
elseif($fs01 == 'Medium')	$queryArr['CompanyProfile'] = "(marketCapitalization>=20000 and marketCapitalization<10000)";
elseif($fs01 == 'Small')		$queryArr['CompanyProfile'] = "(marketCapitalization>=300 and marketCapitalization<2000)";
elseif($fs01 == 'Micro')		$queryArr['CompanyProfile'] = "marketCapitalization<300";



/*********************************************** 섹터 / Company profile ***********************************************/
if($fs02){
	if($queryArr['CompanyProfile'])	$queryArr['CompanyProfile'] .= " and ";
	$queryArr['CompanyProfile'] .= "gsector='".$fs02."'";
}





/*********************************************** 대표지수종목 ***********************************************/
if($fs03){
/*
	$finnhub = "https://finnhub.io/api/v1/index/constituents";
	$param = "?symbol=".$fs03;

	//API 호출
	include '../module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);
	$result = $itemTmp['constituents'];

	$tmpArr = Array();

	foreach($result as $item){
		$tmpArr[] = $item;
	}
	$rowArr[] = $tmpArr;
*/

	$row = sqlArray("select * from api_Indices_Constituents where symbol='".$fs03."' order by stxt");
	$tmpArr = Array();
	foreach($row as $v){
		$tmpArr[] = $v['stxt'];
	}
	$rowArr[] = $tmpArr;
}



/*********************************************** 5년간 평균 배당수익률 /BasicFinancials ***********************************************/
if($fs04 == '1')		$queryArr['BasicFinancials'] = "dividendYield5Y=0";
elseif($fs04 == '2')	$queryArr['BasicFinancials'] = "(dividendYield5Y>0 and dividendYield5Y<2)";
elseif($fs04 == '3')	$queryArr['BasicFinancials'] = "(dividendYield5Y>=2 and dividendYield5Y<4)";
elseif($fs04 == '4')	$queryArr['BasicFinancials'] = "(dividendYield5Y>=4 and dividendYield5Y<6)";
elseif($fs04 == '6')	$queryArr['BasicFinancials'] = "dividendYield5Y>=6";


/*********************************************** S&P500 대비 아웃퍼폼(6개월) /BasicFinancials ***********************************************/
if($fs05){
	if($queryArr['BasicFinancials'])	$queryArr['BasicFinancials'] .= " and ";

	if($fs05 == '20')			$queryArr['BasicFinancials'] .= "priceRelativeToS_P50026Week>=20";
	elseif($fs05 == '10')		$queryArr['BasicFinancials'] .= "(priceRelativeToS_P50026Week>=10 and priceRelativeToS_P50026Week<20)";
	elseif($fs05 == '1')		$queryArr['BasicFinancials'] .= "(priceRelativeToS_P50026Week>=0 and priceRelativeToS_P50026Week<10)";
	elseif($fs05 == '-1')		$queryArr['BasicFinancials'] .= "(priceRelativeToS_P50026Week>=-10 and priceRelativeToS_P50026Week<0)";
	elseif($fs05 == '-10')	$queryArr['BasicFinancials'] .= "(priceRelativeToS_P50026Week>=-20 and priceRelativeToS_P50026Week<-10)";
	elseif($fs05 == '-20')	$queryArr['BasicFinancials'] .= "priceRelativeToS_P50026Week<-20";
}







/*********************************************** 현주가 대비 목표주가 /Stock_Candles_Last ***********************************************/
if($fs06 == '20')			$queryArr['StockCandlesLast'] = "targetMean>=20";
elseif($fs06 == '10')		$queryArr['StockCandlesLast'] = "(targetMean>=10 and targetMean<20)";
elseif($fs06 == '1')		$queryArr['StockCandlesLast'] = "(targetMean>=0 and targetMean<10)";
elseif($fs06 == '-1')		$queryArr['StockCandlesLast'] = "(targetMean>=-10 and targetMean<0)";
elseif($fs06 == '-10')	$queryArr['StockCandlesLast'] = "(targetMean>=-20 and targetMean<-10)";
elseif($fs06 == '-20')	$queryArr['StockCandlesLast'] = "targetMean<-20";







/*********************************************** 에널리스트 컨센서스 /Recommendation_Trends ***********************************************/
if($fs07 == 'strongSell')			$queryArr['RecommendationTrends'] = "t.score<1.5";
elseif($fs07 == 'sell')			$queryArr['RecommendationTrends'] = "(t.score>=1.5 and t.score<2.5)";
elseif($fs07 == 'hold')			$queryArr['RecommendationTrends'] = "(t.score>=2.5 and t.score<3.5)";
elseif($fs07 == 'buy')			$queryArr['RecommendationTrends'] = "(t.score>=3.5 and t.score<4.5)";
elseif($fs07 == 'strongBuy')	$queryArr['RecommendationTrends'] = "t.score>=4.5";

if($queryArr['RecommendationTrends']){
	$tmpArr = Array();
//	$row = sqlArray("select symbol from api_Recommendation_Trends where ".$queryArr['RecommendationTrends']);
	$row = sqlArray("select * from (select * from api_Recommendation_Trends where (symbol, period) in (select symbol, max(period) as period from api_Recommendation_Trends group by symbol) order by period desc) t where ".$queryArr['RecommendationTrends']." group by t.symbol");

	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}


/*********************************************** 최근 에널리스트 컨센서스 변화 /Stock_Up_Down ***********************************************/
if($fs08){
	$tmpArr = Array();
	$row = sqlArray("select * from(select * from api_Stock_Up_Down where action='".$fs08."' and (symbol, gradeTime) in (select symbol, max(gradeTime) as gradeTime from api_Stock_Up_Down group by symbol) order by gradeTime desc) t group by t.symbol");
	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}





/*********************************************** 과거 3년간 연간 평균 EPS 상승률 /BasicFinancials ***********************************************/
if($fs09){
	if($queryArr['BasicFinancials'])	$queryArr['BasicFinancials'] .= " and ";

	elseif($fs09 == '1')		$queryArr['BasicFinancials'] .= "(epsGrowth3Y>=0 and epsGrowth3Y<5)";
	elseif($fs09 == '5')		$queryArr['BasicFinancials'] .= "(epsGrowth3Y>=5 and epsGrowth3Y<10)";
	elseif($fs09 == '10')		$queryArr['BasicFinancials'] .= "(epsGrowth3Y>=10 and epsGrowth3Y<15)";
	elseif($fs09 == '15')		$queryArr['BasicFinancials'] .= "(epsGrowth3Y>=15 and epsGrowth3Y<20)";
	elseif($fs09 == '20')		$queryArr['BasicFinancials'] .= "(epsGrowth3Y>=20 and epsGrowth3Y<25)";
	elseif($fs09 == '25')		$queryArr['BasicFinancials'] .= "epsGrowth3Y>=25";
}


/*********************************************** 미래 3년간 EPS 예상 상승률 /Stock_Candles_Last ***********************************************/
if($fs10){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	elseif($fs10 == '1')		$queryArr['StockCandlesLast'] .= "(epsAvg>=0 and epsAvg<5)";
	elseif($fs10 == '5')		$queryArr['StockCandlesLast'] .= "(epsAvg>=5 and epsAvg<10)";
	elseif($fs10 == '10')		$queryArr['StockCandlesLast'] .= "(epsAvg>=10 and epsAvg<15)";
	elseif($fs10 == '15')		$queryArr['StockCandlesLast'] .= "(epsAvg>=15 and epsAvg<20)";
	elseif($fs10 == '20')		$queryArr['StockCandlesLast'] .= "(epsAvg>=20 and epsAvg<25)";
	elseif($fs10 == '25')		$queryArr['StockCandlesLast'] .= "epsAvg>=25";
}

/*********************************************** 1달 수익률 /Stock_Candles_Last ***********************************************/
if($fs11){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs11 == '20')			$queryArr['StockCandlesLast'] .= "pmDataMonth>=20";
	elseif($fs11 == '10')		$queryArr['StockCandlesLast'] .= "(pmDataMonth>=10 and pmDataMonth<20)";
	elseif($fs11 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth>=0 and pmDataMonth<10)";
	elseif($fs11 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth>=-10 and pmDataMonth<0)";
	elseif($fs11 == '-10')	$queryArr['StockCandlesLast'] .= "(pmDataMonth>=-20 and pmDataMonth<-10)";
	elseif($fs11 == '-20')	$queryArr['StockCandlesLast'] .= "pmDataMonth<-20";
}

/*********************************************** 3달 수익률 /Stock_Candles_Last ***********************************************/
if($fs12){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs12 == '30')			$queryArr['StockCandlesLast'] .= "pmDataMonth3>=30";
	elseif($fs12 == '15')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=15 and pmDataMonth3<30)";
	elseif($fs12 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=0 and pmDataMonth3<15)";
	elseif($fs12 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=-15 and pmDataMonth3<0)";
	elseif($fs12 == '-15')	$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=-30 and pmDataMonth3<-15)";
	elseif($fs12 == '-30')	$queryArr['StockCandlesLast'] .= "pmDataMonth3<-30";
}

/*********************************************** 6달 수익률 /Stock_Candles_Last ***********************************************/
if($fs13){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs13 == '50')			$queryArr['StockCandlesLast'] .= "pmDataMonth6>=50";
	elseif($fs13 == '25')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=25 and pmDataMonth6<50)";
	elseif($fs13 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=0 and pmDataMonth6<25)";
	elseif($fs13 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=-25 and pmDataMonth6<0)";
	elseif($fs13 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=-50 and pmDataMonth6<-25)";
	elseif($fs13 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataMonth6<-50";
}

/*********************************************** 1년 수익률 /Stock_Candles_Last ***********************************************/
if($fs14){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs14 == '100')		$queryArr['StockCandlesLast'] .= "pmDataYear1>=100";
	elseif($fs14 == '50')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=50 and pmDataYear1<100)";
	elseif($fs14 == '25')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=25 and pmDataYear1<50)";
	elseif($fs14 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=0 and pmDataYear1<25)";
	elseif($fs14 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=-25 and pmDataYear1<0)";
	elseif($fs14 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataYear1>=-50 and pmDataYear1<-25)";
	elseif($fs14 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataYear1<-50";
}

/*********************************************** 5년 수익률 /Stock_Candles_Last ***********************************************/
if($fs15){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs15 == '500')		$queryArr['StockCandlesLast'] .= "pmDataYear5>=500";
	elseif($fs15 == '300')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=300 and pmDataYear5<500)";
	elseif($fs15 == '100')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=100 and pmDataYear5<300)";
	elseif($fs15 == '50')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=50 and pmDataYear5<100)";
	elseif($fs15 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=0 and pmDataYear5<50)";
	elseif($fs15 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=-25 and pmDataYear5<0)";
	elseif($fs15 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=-50 and pmDataYear5<-25)";
	elseif($fs15 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataYear5<-50";
}








/*********************************************** 상세 산업군 /CompanyProfile ***********************************************/

if($fs16){
	if($queryArr['CompanyProfile'])	$queryArr['CompanyProfile'] .= " and ";
	$queryArr['CompanyProfile'] .= " gind='".$fs16."'";
}


if($queryArr['CompanyProfile']){
	$tmpArr = Array();
	$row = sqlArray("select symbol from api_Company_Profile where ".$queryArr['CompanyProfile']);

	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}






/*********************************************** 전고점 대비 하락률 /Stock_Candles_Last ***********************************************/
if($fs17){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs17 == '1')			$queryArr['StockCandlesLast'] .= "(highDown>=-20 and highDown<=0)";
	elseif($fs17 == '20')		$queryArr['StockCandlesLast'] .= "(highDown>=-40 and highDown<-20)";
	elseif($fs17 == '40')		$queryArr['StockCandlesLast'] .= "(highDown>=-60 and highDown<-40)";
	elseif($fs17 == '60')		$queryArr['StockCandlesLast'] .= "(highDown>=-80 and highDown<-60)";
	elseif($fs17 == '80')		$queryArr['StockCandlesLast'] .= "highDown<-80";
}

if($queryArr['StockCandlesLast']){
	$tmpArr = Array();
	$row = sqlArray("select symbol from Stock_Candles_Last where ".$queryArr['StockCandlesLast']);
	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}






/*********************************************** 특정 ETF 구성종목만 보기 /ETFs_Holdings ***********************************************/
if($fs18){
	$tmpArr = Array();
	$row = sqlArray("select symbol from api_ETFs_Holdings where symbol='".$fs18."'");
	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}






/*********************************************** 베타(지수대비 변동성지수) /BasicFinancials ***********************************************/
if($fs19){
	if($queryArr['BasicFinancials'])	$queryArr['BasicFinancials'] .= " and ";

	if($fs19 == '3.5')			$queryArr['BasicFinancials'] .= "beta>=3.5";
	elseif($fs19 == '2')		$queryArr['BasicFinancials'] .= "(beta>=2 and beta<3.5)";
	elseif($fs19 == '1.5')	$queryArr['BasicFinancials'] .= "(beta>=1.5 and beta<2)";
	elseif($fs19 == '1')		$queryArr['BasicFinancials'] .= "(beta>=1 and beta<1.5)";
	elseif($fs19 == '0.5')	$queryArr['BasicFinancials'] .= "(beta>=0.5 and beta<1)";
	elseif($fs19 == '0.4')	$queryArr['BasicFinancials'] .= "beta<0.5";
}

if($queryArr['BasicFinancials']){
	$tmpArr = Array();
	$row = sqlArray("select symbol from api_Basic_Financials where ".$queryArr['BasicFinancials']);
	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}






/*********************************************** NLP모델로 분석한 종목 뉴스 스코어 /News_Sentiment ***********************************************/
if($fs20 == '0.8')			$queryArr['NewsSentiment'] = "companyNewsScore>=0.8";
elseif($fs20 == '0.6')	$queryArr['NewsSentiment'] = "(companyNewsScore>=0.6 and companyNewsScore<0.8)";
elseif($fs20 == '0.4')	$queryArr['NewsSentiment'] = "(companyNewsScore>=0.4 and companyNewsScore<0.6)";
elseif($fs20 == '0.2')	$queryArr['NewsSentiment'] = "(companyNewsScore>=0.2 and companyNewsScore<0.4)";
elseif($fs20 == '0.1')	$queryArr['NewsSentiment'] = "companyNewsScore<0.2";

if($queryArr['NewsSentiment']){
	$tmpArr = Array();
	$row = sqlArray("select symbol from api_News_Sentiment where ".$queryArr['NewsSentiment']);
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
	$row = sqlArray("select s.symbol from ks_symbol as s left join api_Company_Profile as c on s.symbol=c.symbol where s.etf='N' and c.symbol!='' order by s.symbol");
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
							<th>티커+<br>회사이름</th>
							<th> 현재가격+1일가격변동폭+퍼센트</th>
							<th>6개월<br>수익률퍼센트</th>
							<th>시가총액</th>
							<th>섹터+6개월수익률퍼센트</th><!-- (대표ETF로 계산) -->
							<th>애널리스트컨센서스</th><!-- (평가인원+그래프작은거+최종의견제시) -->
							<th>애널리스트<br>목표가격업사이드</th>
							<th>적정주가 성장성<br>+수익성</th><!-- (2줄,유료) -->
							<th>시가배당율(5년 평균)</th>
						<?if($call_page != 'GroupPortfolio'){?>
							<th>기사</th>
						<?}?>
						</tr>

					<?
					if($total_record){
						for($k=$sKey; $k<$eKey; $k++){
							$s = $sArr[$k];	//심볼

							$row = sqlRow("select s.*, c.name, c.floatingShare, c.gsector, c.marketCapitalization from Stock_Candles_Last as s left join api_Company_Profile as c on s.symbol=c.symbol where s.symbol='".$s."'");

							$nowC = $row['c'];	//최신 c값

							if($nowC){
								$perData = Util::nf1($row['pmDataDay'],2);
								if($perData > 0){
									$txtClass = 'upClass';
									$txtArrow = '▲';

								}else if($perData < 0){
									$txtClass = 'blue';
									$txtArrow = '▼';

								}else{
									$txtClass = '';
									$txtArrow = '';
								}

								//시가총액
//								$sgT = $nowC * $row['floatingShare'];
								$sgT = $row['marketCapitalization'];

								//섹터
								$gsector = $row['gsector'];

								//섹터에 해당하는 대표 ETF
								$gsectorETF = $gsSectorEtfArr[$gsector];

								$udClass01 = UpDownClass($row['pmDataMonth6']);		//상승,하락 색상
					?>
						<tr>

							<td title="티커+회사이름">
							<?
								//관심종목 페이지
								if($call_page == 'GroupPortfolio'){
							?>
								<a href="javascript:symbolAdd('<?=$s?>');">
									<span class="blue bb block"><?=$s?></span>
									<span class="block"><?=$row['name']?></span>
								</a>
							<?
								}else{
							?>
								<a href="/sub06/sub01.php?gbl_symbol=<?=$s?>">
									<span class="blue bb block"><?=$s?></span>
									<span class="block"><?=$row['name']?></span>
								</a>
							<?
								}
							?>
							</td>


							<td title="현재가격+1일가격변동폭+퍼센트"><span class="<?=$txtClass?>"><?=number_format($nowC,2)?> <?=$txtArrow?> (<?=Util::nf1($row['pmDataDay'],2)?>%)</span></td>


							<td title="6개월수익률퍼센트">
								<span class='<?=$udClass01?>'><?=$row['pmDataMonth6']?>%</span>
								<!--회원가입하면 없어지는
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


							<td title="시가총액"><span class="bold">$<?=number_format($sgT,2)?></span></td>


							<td title="섹터+6개월수익률퍼센트">
							<?
								//섹터값이 없는 경우가 있음(N/A)
								if($gsectorETF){
									//대표 ETF의 6개월 수익률
									$etfMonth6 = sqlRowOne("select pmDataMonth6 from Stock_Candles_Last where symbol='".$gsectorETF."'");
									$udClass02 = UpDownClass($row['etfMonth6']);		//상승,하락 색상
							?>
								<span><?=$gsector?><br><span class='<?=$udClass02?>'><?=$etfMonth6?>%</span></span>
							<?
								}
							?>
							</td>


							<td title="애널리스트컨센서스">
							<?
								//애널리스트 데이터
								$row = recomData($s);
								if($row['totScore']){
							?>
								<div class="dp_f dp_c dp_cc">
									<?
										//그래프 데이터
										$pieColor = $row['pieColor'];
										$pieData = $row['pieData'];
										include 'analyst_pie.php';
									?>
									<span class="<?=$row['investmentEng']?>"><?=$row['investmentEng']?></span>
								</div>
								<p style="font-size: 14px;">
									<span class="totNumTxt" style="font-weight:700;"><?=number_format($row['totNum'])?></span>명의 애널리스트의 평가입니다.
								</p>
							<?
								}
							?>
							</td>


							<td title="애널리스트목표가격업사이드">
							<?
								$targetMean = sqlRowOne("select targetMean from api_Price_Target where symbol='".$s."' order by uid desc limit 1");
							?>
								<span class="bgreen block bold">$<?=$targetMean?></span>
								<span class="bgreen det_s bold">(<?=Util::fnPercent($nowC,$targetMean)?>%)</span>
							</td>


							<td title="적정주가 성장성+수익성">
								<span>29.12%</span>
								<!--회원가입하면 없어지는 상자-->
								<div class="blur_box_s">
									<div class="plue_btn help_point">
										<span>+</span>
									</div>
									<div class="helpbox">
										<p>회원가입 하시고 적정주가를 확인해보세요!</p>
									</div>
								</div>
								<!--회원가입하면 없어지는 상자-->
							</td>


							<td title="시가배당율(5년 평균)">
							<?
								$dividendYield5Y = sqlRowOne("select dividendYield5Y from api_Basic_Financials where symbol='".$s."'");

								echo number_format($dividendYield5Y,2).'%';
							?>
							</td>

						<?if($call_page != 'GroupPortfolio'){?>
							<td title="기사링크"><a href="javascript:newsList('<?=$s?>');"><i class="fas fa-chalkboard-teacher"></i></a></td>
						<?}?>
						</tr>
					<?
							}
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