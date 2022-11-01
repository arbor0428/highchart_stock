<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/gsectorAvg.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$gsArr = Array("Communication Services","Consumer Discretionary","Consumer Staples","Energy","Financials","Health Care","Industrials","Information Technology","Materials","Real Estate","Utilities");
//$gsArr = Array("Information Technology","Communication Services","Consumer Discretionary");

$thisYear = date('Y');
$nextYear = $thisYear + 1;

$rDate = date('Y-m-d H:i:s');
$rTime = time();

foreach($gsArr as $gsector){
	$marketCapAll = 0;	//동일한 섹터의 모든 주식 마켓캡 총합
	$bm01 = 0;
	$bm02 = 0;
	$bm03 = 0;
	$bm04 = 0;
	$bm05 = 0;
	$bm06 = 0;
	$bz07 = 0;	$bm07 = 0;
	$bz08 = 0;	$bm08 = 0;
	$bz09 = 0;	$bm09 = 0;
	$bz10 = 0;	$bm10 = 0;
	$bz11 = 0;	$bm11 = 0;		$tz11 = 0;	$tm11 = 0;
	$bz12 = 0;	$bm12 = 0;
	$bz13 = 0;	$bm13 = 0;
	$bz14 = 0;	$bm14 = 0;
	$bz15 = 0;	$bm15 = 0;
	$bm16 = 0;
	$bm17 = 0;
	$avg18 = 0;

	$item = sqlArray("select * from api_Company_Profile where gsector='".$gsector."' order by symbol asc");

	foreach($item as $v){
		$symbol = $v['symbol'];
		$marketCapAll += $v['marketCapitalization'];

		$bfs = sqlRow("select * from api_Basic_Financials where symbol='".$symbol."'");
		$bm01 += ($bfs['epsExclExtraItemsTTM'] * $v['shareOutstanding']);
		$bm02 += ($bfs['epsInclExtraItemsTTM'] * $v['shareOutstanding']);

		$eesNext = sqlRow("select * from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$nextYear."-%' order by periodTime desc limit 1");
		$bm03 += ($eesNext['epsAvg'] * $v['shareOutstanding']);

		$eesThis = sqlRow("select * from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");
		$bm04 += (((($eesNext['epsAvg'] * $v['shareOutstanding']) / ($eesThis['epsAvg'] * $v['shareOutstanding'])) - 1) * 100);

		$bm05 += ($bfs['revenuePerShareTTM'] * $v['shareOutstanding']);
		$bm06 += ($bfs['bookValuePerShareQuarterly'] * $v['shareOutstanding']);

		$fsiq1th = sqlRow("select * from api_Financial_Statements_ic_quarterly where symbol='".$symbol."' order by period desc limit 1");
		$fsiq5th = sqlRow("select * from api_Financial_Statements_ic_quarterly where symbol='".$symbol."' order by period desc limit 4,1");

		$bz07 += $fsiq1th['revenue'];
		$bm07 += $fsiq5th['revenue'];

		$bz08 += $fsiq1th['ebit'];
		$bm08 += $fsiq5th['ebit'];

		$bfq01 = sqlRow("select * from api_Basic_Financials_quarterly where symbol='".$symbol."' and series='operatingMargin' order by periodTime desc limit 1");
		$bfq05 = sqlRow("select * from api_Basic_Financials_quarterly where symbol='".$symbol."' and series='operatingMargin' order by periodTime desc limit 4,1");
		$bz09 += $bfq01['v'];
		$bm09 += $bfq05['v'];

		$bz10 += $fsiq1th['netIncome'];
		$bm10 += $fsiq5th['netIncome'];

		$fsbq1th = sqlRow("select * from api_Financial_Statements_bs_quarterly where symbol='".$symbol."' order by period desc limit 1");
		$fsbq5th = sqlRow("select * from api_Financial_Statements_bs_quarterly where symbol='".$symbol."' order by period desc limit 4,1");

		$tz11 += $fsbq1th['totalEquity'];
		$tm11 += $fsbq5th['totalEquity'];

		$fsit1th = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$symbol."' order by period desc limit 1");
		$fsit5th = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$symbol."' order by period desc limit 4,1");

		$bz12 += $fsit1th['grossIncome'];
		$bm12 += $fsit1th['revenue'];

		$bz13 += $fsit1th['ebit'];
		$bm13 += $fsit1th['revenue'];

		$bz14 += $fsit1th['netIncome'];
		$bm14 += $fsit1th['revenue'];

		$bz15 += $fsit1th['netIncome'];
		$bm15 += $fsbq1th['totalEquity'];



		$resNext = sqlRow("select * from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$nextYear."-%' order by periodTime desc limit 1");
		$bm16 += $resNext['revenueAvg'];

		$resThis = sqlRow("select * from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");
		$bm17 += $resThis['revenueAvg'];

		$avg18 += ($fsit1th['ebit'] / $fsit1th['revenue']);
	}

	$bz11 = $bz10 / $tz11;
	$bm11 = $bm10 / $tm11;



	$avg01 = $marketCapAll / $bm01;				//PER NON GAAP(TTM)
	$avg02 = $marketCapAll / $bm02;				//PER GAAP(TTM)
	$avg03 = $marketCapAll / $bm03;				//PER GAAP(12개월 FWD)
	$avg04 = $avg03 / $bm04;						//PEG GAAP(12개월 FWD)
	$avg05 = $marketCapAll / $bm05;				//섹터 PSR (TTM)
	$avg06 = $marketCapAll / $bm06;				//섹터 PBR (TTM)
	$avg07 = (($bz07 / $bm07) - 1) * 100;		//섹터매출액성장률 (YOY)
	$avg08 = (($bz08 / $bm08) - 1) * 100;		//섹터 EBIT성장률 (YOY)
	$avg09 = (($bz09 / $bm09) - 1) * 100;		//섹터영업이익성장률(YOY)
	$avg10 = (($bz10 / $bm10) - 1) * 100;		//섹터순이익성장률(YOY)
	$avg11 = (($bz11 / $bm11) - 1) * 100;		//섹터 ROE성장률(YOY)
	$avg12 = ($bz12 / $bm12) * 100;				//섹터매출총이익률
	$avg13 = ($bz13 / $bm13) * 100;				//섹터영업이익률(TTM)
	$avg14 = ($bz14 / $bm14) * 100;				//섹터당기순이익률
	$avg15 = ($bz15 / $bm15) * 100;				//섹터 ROE

	$avg16 = $marketCapAll / $bm16;				//섹터 PSR (FWD)
	$tmp16 = explode('.',$avg16);
	$avg16 = $tmp16[0] + (substr($tmp16[1],0,3) / 1000);	//무한소수점이 나오기 때문에 소수점 3자리까지만 가져옴

	$bm17 = (($bm16 / $bm17) - 1) * 100;
	$avg17 = $avg16 / $bm17;						//섹터 PSG Ratio

	$sql = "update gsectorAvg set ";
	$sql .= "avg01=".round($avg01,2).", ";
	$sql .= "avg02=".round($avg02,2).", ";
	$sql .= "avg03=".round($avg03,2).", ";
	$sql .= "avg04=".round($avg04,2).", ";
	$sql .= "avg05=".round($avg05,2).", ";
	$sql .= "avg06=".round($avg06,2).", ";
	$sql .= "avg07=".round($avg07,2).", ";
	$sql .= "avg08=".round($avg08,2).", ";
	$sql .= "avg09=".round($avg09,2).", ";
	$sql .= "avg10=".round($avg10,2).", ";
	$sql .= "avg11=".round($avg11,2).", ";
	$sql .= "avg12=".round($avg12,2).", ";
	$sql .= "avg13=".round($avg13,2).", ";
	$sql .= "avg14=".round($avg14,2).", ";
	$sql .= "avg15=".round($avg15,2).", ";
	$sql .= "avg16=".round($avg16,2).", ";
	$sql .= "avg17=".round($avg17,2).", ";
	$sql .= "avg18=".round($avg18,2).", ";
	$sql .= "rDate='".$rDate."', ";
	$sql .= "rTime=".$rTime." ";
	$sql .= "where gsector='".$gsector."'";
	sqlExe($sql);


/*
	echo $gsector.'<br>';
	for($i=1; $i<=17; $i++){
		$n = sprintf('%02d',$i);
		echo 'avg'.$n.' : '.${'avg'.$n}.'<br>';
	}

	echo '<br><br>';
*/
}


$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);


/*
1. 섹터 PER NON GAAP(TTM) (분자분모둘다백만단위라그냥나누면됨)
분자 : 전체섹터종목마켓캡총합 (Company Profile -> marketCapitalization)
분모 : 각종목의 epsExclExtraItemsTTM*(Company Profile->shareOutstanding) 의총합

2. 섹터 PER GAAP(TTM) (분자분모둘다백만단위라그냥나누면됨)
분자 : 전체섹터종목마켓캡총합 (Company Profile -> marketCapitalization)
분모 : 각종목의 epsInclExtraItemsTTM*(Company Profile->shareOutstanding) 의총합

3. 섹터 PER GAAP(12개월 FWD)
분자 : 전체섹터종목마켓캡총합 (Company Profile -> marketCapitalization)
분모 : 각종목의 Earnings Estimates -> annual -> 내년도(현재기준 2023) epsAvg *(Company Profile->shareOutstanding) 의총합

4. 섹터 PEG GAAP(12개월 FWD)
분자 : 섹터 PER GAAP(12개월 FWD)
분모 : ((각종목의 Earnings Estimates -> 2023년값 *발행주식수(Company Profile->shareOutstanding) / (각종목의 Earnings Estimates -> 2022년값* 발행주식수(Company Profile->shareOutstanding) -1 ) * 100  의총합-> 퍼센트값에 *100을한다.
예:63% 면 0.63 이아니라 63 으로계산

5. 섹터 PSR (TTM) - 현재주식가격 / 한주당매출액
분자 :전체섹터종목마켓캡총합 (Company Profile -> marketCapitalization)
분모 : 각종목의 Basic financials -> revenuePerShareTTM * 발행주식수 (Company Profile->shareOutstanding) 총합

6. 섹터 PBR (TTM)
분자 : 전체섹터종목마켓캡총합 (Company Profile -> marketCapitalization)
분모 : 각종목의 Basic financials -> bookValuePerShareQuarterly* 발행주식수 (Company Profile->shareOutstanding)총합

7. 섹터매출액성장률 (YOY)
분자 / 분모 -1 을 % 로표기한다.
분자 :  각종목의 financial statements -> income statement  -> quarterly 으로 설정한후 revenue 1번째값합산총합
분모 :  각종목의 financial statements -> income statement  -> quarterly 으로 설정한후 revenue 5번째값합산총합

8. 섹터 EBIT성장률 (YOY)
분자 / 분모 -1 을 % 로표기한다.
분자 :  각종목의 financial statements -> income statement  -> quarterly 으로 설정한후 ebit 1번째값합산총합
분모 :  각종목의 financial statements -> income statement  -> quarterly 으로 설정한후 ebit 5번째값합산총합

9. 섹터영업이익성장률(YOY)
분자 / 분모 -1 을 % 로표기한다.
분자 : 각종목의 basic financials -> operatingMargin "quarterly" 아래에있는것 (동일값이 "series": {"annual": 에도있습니다이거쓰면안됩니다)의 1번째값합산
분모 : 각종목의 basic financials -> operatingMargin "quarterly" 아래에있는것 (동일값이 "series": {"annual": 에도있습니다이거쓰면안됩니다)의 5번째값합산

10. 섹터순이익성장률(YOY)
분자 / 분모 -1 을 % 로표기한다.
분자 :  각종목의 financial statements -> income statement  -> quarterly 으로 설정한후 netIncome 1번째값합산총합
분모 :  각종목의 financial statements -> income statement  -> quarterly 으로 설정한후 netIncome 5번째값합산총합

11. 섹터 ROE성장률(YOY)
분자 / 분모 -1 을 % 로표기한다.
분자 : 각종목의 financial statements -> income statement -> ttm->  netIncome 첫번째값의 합산 / 각종목의 financial statements -> BS -> quarterly ->  totalEquity 첫번째값의합산
분모 : 각종목의 financial statements -> income statement -> ttm->  netIncome 다섯번째값 합산/ 각종목의 financial statements -> BS -> quarterly ->  totalEquity 다섯번째값합산


12. 섹터매출총이익률 (매출총이익률 섹터 평균)
분자 / 분모를 % 로표기한다.
분자 : 각종목의 financial statements -> income statement  -> ttm 으로설정한 후 grossIncome 1번째값합산총합
분모 : 각종목의 financial statements -> income statement  -> ttm 으로설정한 후 revenue 1번째값합산총합

13. 섹터영업이익률(TTM) - op마진
financial statements - income statements - ttm 으로설정한후
분자 : 각종목의 첫번째 ebit 값합산
분모 : 각종목의 첫번째 revenue 값합산 을 퍼센트로표현

14. 섹터당기순이익률
분자/분모를 %로표현 (0.3 이면 30%)
분자 : 각종목의 financial statements -> income statement  -> ttm 에서 netIncome 첫번째값의총합
분모 : 각종목의 financial statements -> income statement  -> ttm 으로설정한후 revenue 1번째값합산총합 

15. 섹터 ROE
분자 : 각종목의 financial statements - IS - ttm 에서 netIncome 값합산
분모 : 각종목의 financial statements - BS - quarterly 에서 totalEquity  값합산
이걸퍼센트로나타내면됨 (0.3 이면 30%임)

16. 섹터 PSR (FWD) - 현재주식가격 / 한주당매출액
분자 :전체섹터종목마켓캡총합 (Company Profile -> marketCapitalization)
분모 : 각종목의 Revenue Estimates -> annual -> revenueAvg 내년값합산.

17. 섹터 PSG Ratio
분자 : 섹터 PSR (FWD)
분모 : (각종목의 Revenue Estimates -> annual ->revenueAvg 의내년값합산)/ (각종목의 Revenue Estimates -> annual ->revenueAvg 의올해값합산)-1 * 100

18. 섹터 EBIT이익률(TTM)
분자/분모를 %로표현 (0.3 이면 30%)
각종목의 financial statements -> income statement  -> ttm 으로설정한후 (ebit 1번째값 / revenue 1번째값) 합산총합
*/
?>