<?
/*********************************************************************************************************************
Z:\3_외부개발\고객사자료\독립형\ㅁ\마이셀프스탁\20221004_mss용어개념_계산법
2022 1004 mss 전체 용어 개념과 계산법 정리 - 김상현이사 IT섹터 요청.xlsx
*********************************************************************************************************************/

include "/home/myss/www/module/class/class.DbCon.php";


$logFile = '/home/myss/www/module/cron/log/sectorData.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$gsArr = Array("Communication Services","Consumer Discretionary","Consumer Staples","Energy","Financials","Health Care","Industrials","Information Technology","Materials","Real Estate","Utilities");
//$gsArr = Array("Information Technology");

$thisYear = date('Y');
$nextYear = $thisYear + 1;

$rDate = date('Y-m-d H:i:s');
$rTime = time();

$yTime = strtotime("-1 years");

foreach($gsArr as $gsector){
	$res = Array();

	$item = sqlArray("select c.*, s.c from api_Company_Profile as c left join Stock_Candles_Last as s on c.symbol=s.symbol where c.gsector='".$gsector."' order by c.symbol asc");
	$sNum = count($item);	//섹터내 종목 수

	foreach($item as $v){
		$symbol = $v['symbol'];
		$nowC = $v['c'];

		$fscfttm1th = sqlRow("select * from api_Financial_Statements_cf_ttm where symbol='".$symbol."' order by period desc limit 1");
		$fscfttm5th = sqlRow("select * from api_Financial_Statements_cf_ttm where symbol='".$symbol."' order by period desc limit 4, 1");

		//financial statements -> cash flow -> ttm -> 첫번째 capex 값
		$res[2] = $fscfttm1th['capex'];

		//Earnings Surprises ->actual 최신값 4개 합
		$res[3] = 0;
		$tmpArr = sqlArray("select * from api_Earnings_Surprises where symbol='".$symbol."' order by uid asc limit 4");
		foreach($tmpArr as $tmp){
			$res[3] += $tmp['actual'];
		}

		//Earnings Estimates->annual ->epsAvg 현재 해의 다음해 (올해 2022 면 2023)
		$res[4] = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$nextYear."-%' order by periodTime desc limit 1");

		//Basic Financials
		$bfs = sqlRow("select * from api_Basic_Financials where symbol='".$symbol."'");
		$res[5] = $bfs['epsExclExtraItemsTTM'];
		$res[6] = $bfs['epsGrowthTTMYoy'] / 100;
		$res[7] = $bfs['epsGrowth3Y'] / 100;
		$res[8] = $bfs['epsGrowth5Y'] / 100;
		$res[9] = $bfs['peBasicExclExtraTTM'];
		$res[10] = $bfs['beta'];
		$res[11] = $v['marketCapitalization'];
		$res[12] = $bfs['netDebtQuarterly'];
		$res[13] = $bfs['revenuePerShareTTM'];
		$res[14] = $bfs['revenueShareGrowth5Y'] / 100;

		//Revenue Estimates->annual 의 revenueAvg 내년값
		$res[15] = sqlRowOne("select revenueAvg from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$nextYear."-%' order by periodTime desc limit 1");

		$res[16] = $v['shareOutstanding'];
		$res[17] = $bfs['bookValuePerShareQuarterly'];
		$res[18] = $bfs['currentDividendYieldTTM'] / 100;
		$res[19] = $bfs['dividendYield5Y'] / 100;
		$res[20] = $bfs['revenueGrowth3Y'] / 100;

		//Revenue Estimates->annual 의 (revenueAvg 올해+3년값)/(revenueAvg 올해값) 을 루트3 으로 계산 후 -1
		$resThis = sqlRow("select * from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");
		if($resThis){
			$resThree = sqlRow("select * from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and periodTime > ".$resThis['periodTime']." order by periodTime asc limit 2,1");
			$jegop = $resThree['revenueAvg'] / $resThis['revenueAvg'];
			$res[21] = pow($jegop, 1/3) - 1;
		}else{
			$res[21] = 0;
		}

		$fsit1th = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$symbol."' order by period desc limit 1");
		$fsit5th = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$symbol."' order by period desc limit 4,1");
		$fsit13th = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$symbol."' order by period desc limit 12,1");

		//financial statements -> income statements -> ttm -> 첫번째 revenue 값
		$res[22] = $fsit1th['revenue'];

		//Revenue Estimates->annual 의 내년값
		$res[23] = sqlRowOne("select revenueAvg from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$nextYear."-%' order by periodTime desc limit 1");

		$res[24] = $bfs['netMarginGrowth5Y'] / 100;

		//earnings Estimates->annual 의 (epsAvg 올해+3년값)/(epsAvg 올해값) 을 루트3 으로 계산 후 -1
		$resThis = sqlRow("select * from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");
		if($resThis){
			$resThree = sqlRow("select * from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and periodTime > ".$resThis['periodTime']." order by periodTime asc limit 2,1");
			$jegop = $resThree['epsAvg'] / $resThis['epsAvg'];
			$res[25] = pow($jegop, 1/3) - 1;
		}else{
			$res[25] = 0;
		}

		$res[26] = $bfs['netProfitMarginTTM'] / 100;
		$res[27] = $fsit1th['sgaExpense'];
		$res[28] = $fsit1th['researchDevelopment'];

		$fsbq1th = sqlRow("select * from api_Financial_Statements_bs_quarterly where symbol='".$symbol."' order by period desc limit 1");

		$res[29] = $fsbq1th['totalDebt'];
		$res[30] = $fsbq1th['totalEquity'];
		$res[31] = $fsit1th['netIncome'];
		$res[32] = $fsbq1th['accountsReceivables'];
		$res[33] = $fsbq1th['accountsPayable'];
		$res[34] = $bfs['revenueGrowthTTMYoy'] / 100;
		$res[35] = $bfs['grossMarginTTM'] / 100;
		$res[36] = $bfs['operatingMarginTTM'] / 100;
		$res[37] = $bfs['netProfitMarginTTM'] / 100;

		//DB에 쌓은 dividend 1년치
		$res[38] = sqlRowOne("select sum(amount) from api_Dividends where symbol='".$symbol."' and dateTime>='".$yTime."'");

		$res[39] = $bfs['dividendGrowthRate5Y'] / 100;

		$res[40] = sqlRowOne("select targetMean from api_Price_Target where symbol='".$symbol."' order by uid desc limit 1");

		$res[41] = $bfs['WeekHigh52'];
		$res[42] = $fsit1th['ebit'];


		//Earnings Surprises ->actual 에서 최신값4개 합산/5~8번째 갑 합산) -1 %
		$tmp01 = 0;
		$tmpArr = sqlArray("select * from api_Earnings_Surprises where symbol='".$symbol."' order by uid asc limit 4");
		foreach($tmpArr as $tmp){
			$tmp01 += $tmp['actual'];
		}

		$tmp02 = 0;
		$tmpArr = sqlArray("select * from api_Earnings_Surprises where symbol='".$symbol."' order by uid asc limit 4, 4");
		foreach($tmpArr as $tmp){
			$tmp02 += $tmp['actual'];
		}

		$res[43] = ($tmp01 / $tmp02) - 1;

		$res[44] = $bfs['cashFlowPerShareTTM'];

		//Earnings Surprises ->actual 최신값 20개를 합한 후 /5 를 한 값
		$tmp01 = 0;
		$tmpArr = sqlArray("select * from api_Earnings_Surprises where symbol='".$symbol."' order by uid asc limit 20");
		foreach($tmpArr as $tmp){
			$tmp01 += $tmp['actual'];
		}
		$res[45] = $tmp01 / 5;

		$res[46] = $fsbq1th['totalAssets'];

		//Earnings Estimates -> annual 에서 (epsAvg 내년값/epsAvg 올해값)-1
		$eesNext = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$nextYear."-%' order by periodTime desc limit 1");
		$eesThis = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");
		$res[47] = ($eesNext / $eesThis) - 1;


		$res[48] = 0;


		//financial statement -> Bs -> quarterly 로 설정하고 첫번째 값 사용 currentAssets/currentLiabilities
		$res[49] = $fsbq1th['currentAssets'] / $fsbq1th['currentLiabilities'];

		//financial statement -> Bs -> quarterly 로 설정하고 첫번째 값 사용 (currentAssets - inventory)/currentLiabilities
		$res[50] = ($fsbq1th['currentAssets'] - $fsbq1th['inventory']) / $fsbq1th['currentLiabilities'];

		//(financial statements -> income statements -> ttm -> 첫번째 ebit 값) / (financial statements -> income statements -> ttm -> 다섯번째 ebit 값) -1 %
		$res[51] = ($fsit1th['ebit'] / $fsit5th['ebit']) - 1;

		//EBIT (TTM) + (financial statements -> cash flow-> ttm -> depreciationAmortization)
		$res[52] = $res[42] + $fscfttm1th['depreciationAmortization'];

		//(financial statements -> income statements -> ttm -> 첫번째 netIncome) / (financial statements -> income statements -> ttm -> 다섯번째 netIncome) -1 %
		$res[53] = ($fsit1th['netIncome'] / $fsit5th['netIncome']) - 1;

		//(financial statements -> income statements -> ttm -> 첫번째 netIncome) / (financial statements -> income statements -> ttm -> 열세번째 netIncome) 값을 세제곱근 하고 -1 을 해서 % 로 표기
		$jegop = $fsit1th['netIncome'] / $fsit13th['netIncome'];
		$res[54] = pow($jegop, 1/3) - 1;

		$res[55] = $bfs['revenueGrowth3Y'] / 100;
		$res[56] = $bfs['revenueGrowth5Y'] / 100;


/*
		(financial statements -> income statements -> ttm -> 첫번째 ebit 값) + (financial statements -> cash flow-> ttm -> 첫번째 depreciationAmortization 값) /
		(financial statements -> income statements -> ttm -> 다섯번째 ebit 값) +(financial statements -> cash flow-> ttm -> 다섯번째 depreciationAmortization 값) -1 (결과값이 0.1 이면 10% 로 표기)
*/


		$tmp01 = $fsit1th['ebit'] + $fscfttm1th['depreciationAmortization'];
		$tmp02 = $fsit5th['ebit'] + $fscfttm5th['depreciationAmortization'];
		$res[57] = ($tmp01 / $tmp02) - 1;

		$res[58] = 0;

		$tmpArrB = sqlArray("select * from api_Basic_Financials_quarterly where symbol='".$symbol."' and series='operatingMargin' order by periodTime desc limit 8");
		$tmpArrF = sqlArray("select * from api_Financial_Statements_ic_quarterly where symbol='".$symbol."' order by period desc limit 8");


		//basic financials ->   ""quarterly"": 아래 operatingMargin 첫번째값 (operatingMargin 값 중 2번째 항목들) * financial statements -> IS -> Q -> revenue 첫번째값
		$res[59] = $tmpArrB[0]['v'] * $tmpArrF[0]['revenue'];

/*
		영업이익 (분기) 계산을 4번 해서 합산한다.
		operatingMargin 첫번째값 * revenue 첫번째값 + 
		operatingMargin 두번째값 * revenue 두번째값 + 
		operatingMargin 세번째값 * revenue 세번째값 + 
		operatingMargin 네번째값 * revenue 네번째값"
*/
		$res[60] = 0;
		for($i=0; $i<4; $i++){
			$res[60] += $tmpArrB[$i]['v'] * $tmpArrF[$i]['revenue'];
		}

/*
		분자 : 영업이익 (TTM)
		분모 : 영업이익 (분기) 방식으로 다섯번째값~여덟번째값 합산
		(분자/분모) -1 을 % 표현"
*/
		$tmp02 = 0;
		for($i=4; $i<8; $i++){
			$tmp02 += $tmpArrB[$i]['v'] * $tmpArrF[$i]['revenue'];
		}
		$res[58] = ($res[60] / $tmp02) - 1;

		$res[61] = $fsit1th['grossIncome'];

		$res[62] = $res[38] * $res[16];
		$res[63] = $res[62] / $res[31];
		$res[64] = $nowC / $res[3];
		$res[65] = $res[64] / ($res[43] * 100);
		$res[66] = $nowC / $res[4];
		
		//Price / (financial statements -> income statements -> ttm -> dilutedEPS 첫번째값)
		$tmp02 = $fsit1th['dilutedEPS'];
		$res[67] = $nowC / $tmp02;

		$res[68] = $res[15] / ($res[16] * 1000000);
		$res[69] = $nowC / $res[68];
		$res[70] = $nowC / $res[17];
		$res[71] = $res[66] / ($res[47] * 100);
		$res[72] = $res[27] / $res[22];
		$res[73] = $res[28] / $res[22];

		$res[74] = $bfs['totalDebt_totalEquityQuarterly'] / 100;

		$res[75] = $res[31] / $res[30];
		$res[76] = $res[52] / $res[22];
		$res[77] = $res[11] + $res[12];
		$res[78] = $res[77] / $res[22];
		$res[79] = ($res[77] * 1000000) / $res[15];
		$res[80] = $res[77] / $res[52];
		$res[81] = $res[77] / $res[42];

		$res[82] = $bfs['psTTM'];

		$res[83] = $nowC / $res[44];
		$res[84] = ($res[9] / ($res[6] * 100)) * 100;

		$res[85] = $bfs['currentEv_freeCashFlowTTM'];







/****************************** PEG Non-GAAP(5년평균) *******************************/
		$aData01 = 0;
		$tmpArr = sqlArray("select * from api_Earnings_Surprises where symbol='".$symbol."' order by uid asc limit 4");
		foreach($tmpArr as $tmp){
			$aData01 += $tmp['actual'];
		}
		$aData02 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$nextYear."-%' order by periodTime desc limit 1");
		$aData03 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".($nextYear+1)."-%' order by periodTime desc limit 1");
		$aData04 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".($nextYear+2)."-%' order by periodTime desc limit 1");
		$aData05 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".($nextYear+3)."-%' order by periodTime desc limit 1");

		$bData01 = $nowC / $aData01;
		$bData02 = $nowC / $aData02;
		$bData03 = $nowC / $aData03;
		$bData04 = $nowC / $aData04;
		$bData05 = $nowC / $aData05;

		$cData01 = $res[43] * 100;
		$cData02 = (($aData02 / $eesThis) - 1) * 100;
		$cData03 = (($aData03 / $aData02) - 1) * 100;
		$cData04 = (($aData04 / $aData03) - 1) * 100;
		$cData05 = (($aData05 / $aData04) - 1) * 100;

		$dData01 = ($bData01 / ($cData01 * 100)) * 100;
		$dData02 = ($bData02 / ($cData02 * 100)) * 100;
		$dData03 = ($bData03 / ($cData03 * 100)) * 100;
		$dData04 = ($bData04 / ($cData04 * 100)) * 100;
		$dData05 = ($bData05 / ($cData05 * 100)) * 100;

		$res[48] = ($dData01 + $dData02 + $dData03 + $dData04 + $dData05) / 5;


		foreach($res as $key => $val){
			$res[$key] = round($val,4);
		}


		$tmpID = sqlRowOne("select uid from sectorData where symbol='".$symbol."'");
		if(!$tmpID){
			$sql = "insert into sectorData (gsector,symbol,nowC,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31,d32,d33,d34,d35,d36,d37,d38,d39,d40,d41,d42,d43,d44,d45,d46,d47,d48,d49,d50,d51,d52,d53,d54,d55,d56,d57,d58,d59,d60,d61,d62,d63,d64,d65,d66,d67,d68,d69,d70,d71,d72,d73,d74,d75,d76,d77,d78,d79,d80,d81,d82,d83,d84,d85,rDate,rTime) values ('$gsector','$symbol','$nowC','$res[2]','$res[3]','$res[4]','$res[5]','$res[6]','$res[7]','$res[8]','$res[9]','$res[10]','$res[11]','$res[12]','$res[13]','$res[14]','$res[15]','$res[16]','$res[17]','$res[18]','$res[19]','$res[20]','$res[21]','$res[22]','$res[23]','$res[24]','$res[25]','$res[26]','$res[27]','$res[28]','$res[29]','$res[30]','$res[31]','$res[32]','$res[33]','$res[34]','$res[35]','$res[36]','$res[37]','$res[38]','$res[39]','$res[40]','$res[41]','$res[42]','$res[43]','$res[44]','$res[45]','$res[46]','$res[47]','$res[48]','$res[49]','$res[50]','$res[51]','$res[52]','$res[53]','$res[54]','$res[55]','$res[56]','$res[57]','$res[58]','$res[59]','$res[60]','$res[61]','$res[62]','$res[63]','$res[64]','$res[65]','$res[66]','$res[67]','$res[68]','$res[69]','$res[70]','$res[71]','$res[72]','$res[73]','$res[74]','$res[75]','$res[76]','$res[77]','$res[78]','$res[79]','$res[80]','$res[81]','$res[82]','$res[83]','$res[84]','$res[85]','$rDate','$rTime')";
			sqlExe($sql);

		}else{
			$sql = "update sectorData set ";
			$sql .= "nowC='$nowC',";
			for($i=2; $i<=85; $i++){
				$sql .= "d".$i."='$res[$i]',";
			}
			$sql .= "rDate='$rDate',";
			$sql .= "rTime='$rTime' ";
			$sql .= "where uid='$tmpID'";
			sqlExe($sql);
		}

//		echo $symbol."\n";
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>