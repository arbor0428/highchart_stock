<?
//제이쿼리 로드함수를 이용해 페이지가 로딩된 경우
if($_GET['jQueryLoad']){
	include "../module/class/class.DbCon.php";
	include "../module/class/class.Util.php";
	include '../module/lib.php';

	//실시간 환율정보
	$exArr = Util::ExchangeRate();
	$exRate = str_replace(',','',$exArr[1]);
?>
<script>
$(document).ready(function(){
	$("#loading").delay("200").fadeOut();
});
</script>
<?
}


$rowArr = Array();		//참고 테이블별 종목
$queryArr = Array();	//테이블별 쿼리 조건문


/*********************************************** 주당 배당금 ***********************************************/
if($fs01 == '0.1')		$queryArr['Dividends'] = "adjustedAmountYear<0.1";
elseif($fs01 == '1')	$queryArr['Dividends'] = "(adjustedAmountYear>=0.1 and adjustedAmountYear<1)";
elseif($fs01 == '2')	$queryArr['Dividends'] = "(adjustedAmountYear>=1 and adjustedAmountYear<2)";
elseif($fs01 == '5')	$queryArr['Dividends'] = "(adjustedAmountYear>=2 and adjustedAmountYear<5)";
elseif($fs01 == '10')	$queryArr['Dividends'] = "(adjustedAmountYear>=5 and adjustedAmountYear<10)";
elseif($fs01 == '11')	$queryArr['Dividends'] = "adjustedAmountYear>=10";



/*********************************************** 시가 배당율 (연간) ***********************************************/
if($fs02 == '0.5')			$queryArr['BasicFinancials'] .= "currentDividendYieldTTM<0.5";
elseif($fs02 == '1')		$queryArr['BasicFinancials'] .= "(currentDividendYieldTTM>=0.5 and currentDividendYieldTTM<1)";
elseif($fs02 == '2')		$queryArr['BasicFinancials'] .= "(currentDividendYieldTTM>=1 and currentDividendYieldTTM<2)";
elseif($fs02 == '3')		$queryArr['BasicFinancials'] .= "(currentDividendYieldTTM>=2 and currentDividendYieldTTM<3)";
elseif($fs02 == '5')		$queryArr['BasicFinancials'] .= "(currentDividendYieldTTM>=3 and currentDividendYieldTTM<5)";
elseif($fs02 == '10')		$queryArr['BasicFinancials'] .= "(currentDividendYieldTTM>=5 and currentDividendYieldTTM<10)";
elseif($fs02 == '11')		$queryArr['BasicFinancials'] .= "currentDividendYieldTTM>=10";



/*********************************************** 배당빈도 ***********************************************/
if($fs03){
	if($queryArr['Dividends'])	$queryArr['Dividends'] .= " and ";

	if($fs03 == 'annual')			$queryArr['Dividends'] .= "dNum=1";
	elseif($fs03 == 'half')		$queryArr['Dividends'] .= "dNum=2";
	elseif($fs03 == 'quarterly')	$queryArr['Dividends'] .= "dNum=4";
	elseif($fs03 == 'etc')			$queryArr['Dividends'] .= "dNum>4";
}


/*********************************************** 5년간 평균 배당 성장율 ***********************************************/
if($fs04){
	if($queryArr['BasicFinancials'])	$queryArr['BasicFinancials'] .= " and ";

	if($fs04 == '1')			$queryArr['BasicFinancials'] .= "dividendGrowthRate5Y<5";
	elseif($fs04 == '5')		$queryArr['BasicFinancials'] .= "(dividendGrowthRate5Y>=5 and dividendGrowthRate5Y<10)";
	elseif($fs04 == '10')		$queryArr['BasicFinancials'] .= "(dividendGrowthRate5Y>=10 and dividendGrowthRate5Y<15)";
	elseif($fs04 == '15')		$queryArr['BasicFinancials'] .= "(dividendGrowthRate5Y>=15 and dividendGrowthRate5Y<20)";
	elseif($fs04 == '20')		$queryArr['BasicFinancials'] .= "(dividendGrowthRate5Y>=20 and dividendGrowthRate5Y<25)";
	elseif($fs04 == '25')		$queryArr['BasicFinancials'] .= "dividendGrowthRate5Y>=25";
}



/*********************************************** 고점대비 하락률 ***********************************************/
if($fs05 == '1')			$queryArr['StockCandlesLast'] .= "mddDown>=-20";
elseif($fs05 == '20')		$queryArr['StockCandlesLast'] .= "(mddDown>=-40 and mddDown<-20)";
elseif($fs05 == '40')		$queryArr['StockCandlesLast'] .= "(mddDown>=-60 and mddDown<-40)";
elseif($fs05 == '60')		$queryArr['StockCandlesLast'] .= "(mddDown>=-80 and mddDown<-60)";
elseif($fs05 == '80')		$queryArr['StockCandlesLast'] .= "mddDown<-80";



/*********************************************** 3달 수익률 /Stock_Candles_Last ***********************************************/
if($fs06){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs06 == '30')			$queryArr['StockCandlesLast'] .= "pmDataMonth3>=30";
	elseif($fs06 == '15')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=15 and pmDataMonth3<30)";
	elseif($fs06 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=0 and pmDataMonth3<15)";
	elseif($fs06 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=-15 and pmDataMonth3<0)";
	elseif($fs06 == '-15')	$queryArr['StockCandlesLast'] .= "(pmDataMonth3>=-30 and pmDataMonth3<-15)";
	elseif($fs06 == '-30')	$queryArr['StockCandlesLast'] .= "pmDataMonth3<-30";
}

/*********************************************** 6달 수익률 /Stock_Candles_Last ***********************************************/
if($fs07){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs07 == '50')			$queryArr['StockCandlesLast'] .= "pmDataMonth6>=50";
	elseif($fs07 == '25')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=25 and pmDataMonth6<50)";
	elseif($fs07 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=0 and pmDataMonth6<25)";
	elseif($fs07 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=-25 and pmDataMonth6<0)";
	elseif($fs07 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataMonth6>=-50 and pmDataMonth6<-25)";
	elseif($fs07 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataMonth6<-50";
}

/*********************************************** 1년 수익률 /Stock_Candles_Last ***********************************************/
if($fs08){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs08 == '100')		$queryArr['StockCandlesLast'] .= "pmDataYear1>=100";
	elseif($fs08 == '50')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=50 and pmDataYear1<100)";
	elseif($fs08 == '25')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=25 and pmDataYear1<50)";
	elseif($fs08 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=0 and pmDataYear1<25)";
	elseif($fs08 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataYear1>=-25 and pmDataYear1<0)";
	elseif($fs08 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataYear1>=-50 and pmDataYear1<-25)";
	elseif($fs08 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataYear1<-50";
}

/*********************************************** 5년 수익률 /Stock_Candles_Last ***********************************************/
if($fs09){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs09 == '500')		$queryArr['StockCandlesLast'] .= "pmDataYear5>=500";
	elseif($fs09 == '300')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=300 and pmDataYear5<500)";
	elseif($fs09 == '100')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=100 and pmDataYear5<300)";
	elseif($fs09 == '50')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=50 and pmDataYear5<100)";
	elseif($fs09 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=0 and pmDataYear5<50)";
	elseif($fs09 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataYear5>=-25 and pmDataYear5<0)";
	elseif($fs09 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataYear5>=-50 and pmDataYear5<-25)";
	elseif($fs09 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataYear5<-50";
}

/*********************************************** 5년 수익률 /Stock_Candles_Last ***********************************************/
if($fs10){
	if($queryArr['StockCandlesLast'])	$queryArr['StockCandlesLast'] .= " and ";

	if($fs10 == '500')		$queryArr['StockCandlesLast'] .= "pmDataYear10>=500";
	elseif($fs10 == '300')	$queryArr['StockCandlesLast'] .= "(pmDataYear10>=300 and pmDataYear10<500)";
	elseif($fs10 == '100')	$queryArr['StockCandlesLast'] .= "(pmDataYear10>=100 and pmDataYear10<300)";
	elseif($fs10 == '50')		$queryArr['StockCandlesLast'] .= "(pmDataYear10>=50 and pmDataYear10<100)";
	elseif($fs10 == '1')		$queryArr['StockCandlesLast'] .= "(pmDataYear10>=0 and pmDataYear10<50)";
	elseif($fs10 == '-1')		$queryArr['StockCandlesLast'] .= "(pmDataYear10>=-25 and pmDataYear10<0)";
	elseif($fs10 == '-25')	$queryArr['StockCandlesLast'] .= "(pmDataYear10>=-50 and pmDataYear10<-25)";
	elseif($fs10 == '-50')	$queryArr['StockCandlesLast'] .= "pmDataYear10<-50";
}




if($queryArr['Dividends']){
	$tmpArr = Array();
	$row = sqlArray("select symbol from api_Dividends where ".$queryArr['Dividends']);

	foreach($row as $v){
		$tmpArr[] = $v['symbol'];
	}
	$rowArr[] = $tmpArr;
}

if($queryArr['BasicFinancials']){
	$tmpArr = Array();
	$row = sqlArray("select symbol from api_Basic_Financials where ".$queryArr['BasicFinancials']);
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
	$row = sqlArray("select s.symbol from ks_symbol as s left join api_Company_Profile as c on s.symbol=c.symbol where s.etf='N' and c.symbol!='' order by s.symbol");
	foreach($row as $v){
		$cnt = sqlRowOne("select count(*) from api_Dividends where symbol='".$v['symbol']."' and declarationTime>0");
		if($cnt){
			$etfArr[] = $v['symbol'];
		}
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
}
?>

			<div class="ora_line"></div>
			<div class="sec_table stock_table">
				<h4 class="sub_tit_det" style="margin-top: 20px;">Showing companies with ex-dividend</h4>
				<table class="subtable">
					<tbody>
						<tr>
							<th>티커+<br>회사이름</th>
							<th>배당락일</th>
							<th>배당기준일</th>
							<th>배당지급일</th>
							<th>배당금</th>
							<th>배당수익률</th>
							<th>시가총액</th>
							<th>6개월<br>주가수익률</th>
							<th>시가배당율<br>(5년평균)</th>
							<th>애널리스트 컨센서스</th>
						</tr>

					<?
					if($total_record){

						$joinQuery = " left join ks_symbol as s on c.symbol=s.symbol";
						$joinQuery .= " left join api_Company_Profile as p on c.symbol=p.symbol";
						$joinQuery .= " left join Stock_Candles_Last as l on c.symbol=l.symbol";

						for($i=$sKey; $i<$eKey; $i++){
							$s = $sArr[$i];	//심볼

							$item = sqlRow("select c.*, p.name, l.c as nowC from api_Dividends as c ".$joinQuery." where c.symbol='".$s."' order by dateTime desc limit 1");

							$nowC = $item['nowC'];		//최신 c값

							//배당수익률
							$cdyTTM = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$s."'");

							//시가총액
							$siga = sqlRowOne("select marketCapitalization from api_Company_Profile where symbol='".$s."'");
							$mCap = round(($siga / 100),2);
							$mCapWon = number_format((float)$mCap * $exRate, 3, '.', '');	//원화적용 & 소수점 3자리로 표시

							$mCapHan = Util::num_to_han_s($mCapWon,5);			//한글변환

							//6개월 주가수익률
							$month6 = sqlRowOne("select pmDataMonth6 from Stock_Candles_Last where symbol='".$s."'");

							$udClass01 = UpDownClass($month6);		//상승,하락 색상

							//시가배당율(5년평균)
							$dividendYield5Y = sqlRowOne("select dividendYield5Y from api_Basic_Financials where symbol='".$s."'");

							if($i > ($cutLine-1))		$lineClass = 'cutLine';
							else							$lineClass = '';

					?>
						<tr>
							<td title="티커+회사이름" style='text-align:left !important;'>
							<?
								//관심종목 & 포트폴리오 페이지
								if($call_page == 'GroupPortfolio'){
							?>
								<a href="javascript:symbolAdd('<?=$s?>');">
									<span class="blue bb block"><?=$s?></span>
									<span class="block"><?=$item['name']?></span>
								</a>
							<?
								}else{
							?>
								<a href="/sub06/sub01.php?gbl_symbol=<?=$s?>">
									<span class="blue bb block"><?=$s?></span>
									<span class="block"><?=$item['name']?></span>
								</a>
							<?
								}
							?>
							</td>
							<td title="배당락일"><?=$item['date']?></td>
							<td title="배당기준일"><?=$item['recordDate']?></td>
							<td title="배당지급일"><?=$item['payDate']?></td>
							<td title="배당금"><?=$item['adjustedAmount']?>달러</td>
							<td title="배당수익률"><?=round($cdyTTM,2)?>%</td>
							<td title="시가총액"><?=number_format($mCap,2)?>억 달러<br>(<?=$mCapHan?>원)</td>
							<td title="6개월 주가수익률" class='<?=$udClass01?>'><?=$month6?>%</td>
							<td title="시가배당율(5년평균)"><?=number_format($dividendYield5Y,2)?>%</td>
							<td title='애널리스트 컨센서스'>
							<?
								//애널리스트 데이터
								$item = recomData($s);
								if($item['totScore']){
							?>
								<div class="dp_f dp_c dp_cc">
									<?
										//그래프 데이터
										$pieColor = $item['pieColor'];
										$pieData = $item['pieData'];
										$k = '_'.$i;
										include '/home/myss/www/sub01/analyst_pie.php';
									?>
									<span class="<?=$item['investmentEng']?>"><?=$item['investmentEng']?></span>
								</div>
								<p style="font-size: 14px;">
									<span class="totNumTxt" style="font-weight:700;"><?=number_format($item['totNum'])?></span>명의 애널리스트의 평가입니다.
								</p>
							<?
								}
							?>
							</td>
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

<?
if($total_record){
	include '/home/myss/www/sub01/dividend_pageNum.php';
}
?>