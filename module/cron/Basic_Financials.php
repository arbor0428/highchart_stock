<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Basic_Financials.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

//통화별 금액
$qArr = Array();
$row = sqlArray("select * from api_Forex_rates");
foreach($row as $v){
	$qArr[$v['base']] = $v['q'];
}

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/metric";
	$param = "?symbol=".$symbol."&metric=all";

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);


	if($itemTmp){
		$metricArr = $itemTmp['metric'];

		if(count($metricArr)){
			foreach($metricArr as $key => $item){
				${$key} = addslashes($item);

				if($key == "10DayAverageTradingVolume")				$DayAverageTradingVolume10 = $item;
				if($key == "13WeekPriceReturnDaily")					$WeekPriceReturnDaily13 = $item;
				if($key == "26WeekPriceReturnDaily")					$WeekPriceReturnDaily26 = $item;
				if($key == "3MonthAverageTradingVolume")			$MonthAverageTradingVolume3 = $item;
				if($key == "52WeekHigh")									$WeekHigh52 = $item;
				if($key == "52WeekHighDate")							$WeekHighDate52 = $item;
				if($key == "52WeekLow")									$WeekLow52 = $item;
				if($key == "52WeekLowDate")								$WeekLowDate52 = $item;
				if($key == "52WeekPriceReturnDaily")					$WeekPriceReturnDaily52 = $item;
				if($key == "5DayPriceReturnDaily")						$PriceReturnDaily5Day = $item;

				if($key == "currentEv/freeCashFlowAnnual")			$currentEv_freeCashFlowAnnual = $item;
				if($key == "currentEv/freeCashFlowTTM")				$currentEv_freeCashFlowTTM = $item;
				if($key == "freeOperatingCashFlow/revenue5Y")		$freeOperatingCashFlow_revenue5Y = $item;
				if($key == "freeOperatingCashFlow/revenueTTM")	$freeOperatingCashFlow_revenueTTM = $item;
				if($key == "longTermDebt/equityAnnual")				$longTermDebt_equityAnnual = $item;
				if($key == "longTermDebt/equityQuarterly")			$longTermDebt_equityQuarterly = $item;
				if($key == "totalDebt/totalEquityAnnual")				$totalDebt_totalEquityAnnual = $item;
				if($key == "totalDebt/totalEquityQuarterly")				$totalDebt_totalEquityQuarterly = $item;

				if($key == "priceRelativeToS&P50013Week")			$priceRelativeToS_P50013Week = $item;
				if($key == "priceRelativeToS&P50026Week")			$priceRelativeToS_P50026Week = $item;
				if($key == "priceRelativeToS&P5004Week")			$priceRelativeToS_P5004Week = $item;
				if($key == "priceRelativeToS&P50052Week")			$priceRelativeToS_P50052Week = $item;
				if($key == "priceRelativeToS&P500Ytd")				$priceRelativeToS_P500Ytd = $item;
			}

			$currency = sqlRowOne("select currency from api_Company_Profile where symbol='".$symbol."'");
			if($currency != 'USD'){
				$q = $qArr[$currency];
				if($q){
					$bookValuePerShareAnnual = $bookValuePerShareAnnual / $q;
					$bookValuePerShareQuarterly = $bookValuePerShareQuarterly / $q;
					$cashFlowPerShareAnnual = $cashFlowPerShareAnnual / $q;
					$cashFlowPerShareTTM = $cashFlowPerShareTTM / $q;
					$cashPerSharePerShareAnnual = $cashPerSharePerShareAnnual / $q;
					$cashPerSharePerShareQuarterly = $cashPerSharePerShareQuarterly / $q;
					$dividendPerShare5Y = $dividendPerShare5Y / $q;
					$dividendPerShareAnnual = $dividendPerShareAnnual / $q;
					$epsBasicExclExtraItemsAnnual = $epsBasicExclExtraItemsAnnual / $q;
					$epsBasicExclExtraItemsTTM = $epsBasicExclExtraItemsTTM / $q;
					$epsExclExtraItemsAnnual = $epsExclExtraItemsAnnual / $q;
					$epsExclExtraItemsTTM = $epsExclExtraItemsTTM / $q;
					$epsInclExtraItemsAnnual = $epsInclExtraItemsAnnual / $q;
					$epsInclExtraItemsTTM = $epsInclExtraItemsTTM / $q;
					$epsNormalizedAnnual = $epsNormalizedAnnual / $q;
					$marketCapitalization = $marketCapitalization / $q;
					$netIncomeEmployeeAnnual = $netIncomeEmployeeAnnual / $q;
					$netIncomeEmployeeTTM = $netIncomeEmployeeTTM / $q;
					$pfcfShareAnnual = $pfcfShareAnnual / $q;
					$pfcfShareTTM = $pfcfShareTTM / $q;
					$revenueEmployeeAnnual = $revenueEmployeeAnnual / $q;
					$revenueEmployeeTTM = $revenueEmployeeTTM / $q;
					$revenuePerShareAnnual = $revenuePerShareAnnual / $q;
					$revenuePerShareTTM = $revenuePerShareTTM / $q;
					$tangibleBookValuePerShareAnnual = $tangibleBookValuePerShareAnnual / $q;
					$tangibleBookValuePerShareQuarterly = $tangibleBookValuePerShareQuarterly / $q;
				}
			}

			$tmpChk = sqlRowOne("select count(*) from api_Basic_Financials where symbol='".$symbol."'");

			if($tmpChk){
				$sql = "update api_Basic_Financials set DayAverageTradingVolume10='".$DayAverageTradingVolume10."',WeekPriceReturnDaily13='".$WeekPriceReturnDaily13."',WeekPriceReturnDaily26='".$WeekPriceReturnDaily26."',MonthAverageTradingVolume3='".$MonthAverageTradingVolume3."',WeekHigh52='".$WeekHigh52."',WeekHighDate52='".$WeekHighDate52."',WeekLow52='".$WeekLow52."',WeekLowDate52='".$WeekLowDate52."',WeekPriceReturnDaily52='".$WeekPriceReturnDaily52."',PriceReturnDaily5Day='".$PriceReturnDaily5Day."',assetTurnoverAnnual='".$assetTurnoverAnnual."',assetTurnoverTTM='".$assetTurnoverTTM."',beta='".$beta."',bookValuePerShareAnnual='".$bookValuePerShareAnnual."',bookValuePerShareQuarterly='".$bookValuePerShareQuarterly."',bookValueShareGrowth5Y='".$bookValueShareGrowth5Y."',capitalSpendingGrowth5Y='".$capitalSpendingGrowth5Y."',cashFlowPerShareAnnual='".$cashFlowPerShareAnnual."',cashFlowPerShareTTM='".$cashFlowPerShareTTM."',cashPerSharePerShareAnnual='".$cashPerSharePerShareAnnual."',cashPerSharePerShareQuarterly='".$cashPerSharePerShareQuarterly."',currentDividendYieldTTM='".$currentDividendYieldTTM."',currentEv_freeCashFlowAnnual='".$currentEv_freeCashFlowAnnual."',currentEv_freeCashFlowTTM='".$currentEv_freeCashFlowTTM."',currentRatioAnnual='".$currentRatioAnnual."',currentRatioQuarterly='".$currentRatioQuarterly."',dividendGrowthRate5Y='".$dividendGrowthRate5Y."',dividendPerShare5Y='".$dividendPerShare5Y."',dividendPerShareAnnual='".$dividendPerShareAnnual."',dividendYield5Y='".$dividendYield5Y."',dividendYieldIndicatedAnnual='".$dividendYieldIndicatedAnnual."',dividendsPerShareTTM='".$dividendsPerShareTTM."',ebitdPerShareTTM='".$ebitdPerShareTTM."',ebitdaCagr5Y='".$ebitdaCagr5Y."',ebitdaInterimCagr5Y='".$ebitdaInterimCagr5Y."',epsBasicExclExtraItemsAnnual='".$epsBasicExclExtraItemsAnnual."',epsBasicExclExtraItemsTTM='".$epsBasicExclExtraItemsTTM."',epsExclExtraItemsAnnual='".$epsExclExtraItemsAnnual."',epsExclExtraItemsTTM='".$epsExclExtraItemsTTM."',epsGrowth3Y='".$epsGrowth3Y."',epsGrowth5Y='".$epsGrowth5Y."',epsGrowthQuarterlyYoy='".$epsGrowthQuarterlyYoy."',epsGrowthTTMYoy='".$epsGrowthTTMYoy."',epsInclExtraItemsAnnual='".$epsInclExtraItemsAnnual."',epsInclExtraItemsTTM='".$epsInclExtraItemsTTM."',epsNormalizedAnnual='".$epsNormalizedAnnual."',focfCagr5Y='".$focfCagr5Y."',freeCashFlowAnnual='".$freeCashFlowAnnual."',freeCashFlowPerShareTTM='".$freeCashFlowPerShareTTM."',freeCashFlowTTM='".$freeCashFlowTTM."',freeOperatingCashFlow_revenue5Y='".$freeOperatingCashFlow_revenue5Y."',freeOperatingCashFlow_revenueTTM='".$freeOperatingCashFlow_revenueTTM."',grossMargin5Y='".$grossMargin5Y."',grossMarginAnnual='".$grossMarginAnnual."',grossMarginTTM='".$grossMarginTTM."',inventoryTurnoverAnnual='".$inventoryTurnoverAnnual."',inventoryTurnoverTTM='".$inventoryTurnoverTTM."',longTermDebt_equityAnnual='".$longTermDebt_equityAnnual."',longTermDebt_equityQuarterly='".$longTermDebt_equityQuarterly."',marketCapitalization='".$marketCapitalization."',monthToDatePriceReturnDaily='".$monthToDatePriceReturnDaily."',netDebtAnnual='".$netDebtAnnual."',netDebtQuarterly='".$netDebtQuarterly."',netIncomeEmployeeAnnual='".$netIncomeEmployeeAnnual."',netIncomeEmployeeTTM='".$netIncomeEmployeeTTM."',netInterestCoverageAnnual='".$netInterestCoverageAnnual."',netInterestCoverageTTM='".$netInterestCoverageTTM."',netMarginGrowth5Y='".$netMarginGrowth5Y."',netProfitMargin5Y='".$netProfitMargin5Y."',netProfitMarginAnnual='".$netProfitMarginAnnual."',netProfitMarginTTM='".$netProfitMarginTTM."',operatingMargin5Y='".$operatingMargin5Y."',operatingMarginAnnual='".$operatingMarginAnnual."',operatingMarginTTM='".$operatingMarginTTM."',payoutRatioAnnual='".$payoutRatioAnnual."',payoutRatioTTM='".$payoutRatioTTM."',pbAnnual='".$pbAnnual."',pbQuarterly='".$pbQuarterly."',pcfShareTTM='".$pcfShareTTM."',peBasicExclExtraTTM='".$peBasicExclExtraTTM."',peExclExtraAnnual='".$peExclExtraAnnual."',peExclExtraHighTTM='".$peExclExtraHighTTM."',peExclExtraTTM='".$peExclExtraTTM."',peExclLowTTM='".$peExclLowTTM."',peInclExtraTTM='".$peInclExtraTTM."',peNormalizedAnnual='".$peNormalizedAnnual."',pfcfShareAnnual='".$pfcfShareAnnual."',pfcfShareTTM='".$pfcfShareTTM."',pretaxMargin5Y='".$pretaxMargin5Y."',pretaxMarginAnnual='".$pretaxMarginAnnual."',pretaxMarginTTM='".$pretaxMarginTTM."',priceRelativeToS_P50013Week='".$priceRelativeToS_P50013Week."',priceRelativeToS_P50026Week='".$priceRelativeToS_P50026Week."',priceRelativeToS_P5004Week='".$priceRelativeToS_P5004Week."',priceRelativeToS_P50052Week='".$priceRelativeToS_P50052Week."',priceRelativeToS_P500Ytd='".$priceRelativeToS_P500Ytd."',psAnnual='".$psAnnual."',psTTM='".$psTTM."',ptbvAnnual='".$ptbvAnnual."',ptbvQuarterly='".$ptbvQuarterly."',quickRatioAnnual='".$quickRatioAnnual."',quickRatioQuarterly='".$quickRatioQuarterly."',receivablesTurnoverAnnual='".$receivablesTurnoverAnnual."',receivablesTurnoverTTM='".$receivablesTurnoverTTM."',revenueEmployeeAnnual='".$revenueEmployeeAnnual."',revenueEmployeeTTM='".$revenueEmployeeTTM."',revenueGrowth3Y='".$revenueGrowth3Y."',revenueGrowth5Y='".$revenueGrowth5Y."',revenueGrowthQuarterlyYoy='".$revenueGrowthQuarterlyYoy."',revenueGrowthTTMYoy='".$revenueGrowthTTMYoy."',revenuePerShareAnnual='".$revenuePerShareAnnual."',revenuePerShareTTM='".$revenuePerShareTTM."',revenueShareGrowth5Y='".$revenueShareGrowth5Y."',roaRfy='".$roaRfy."',roaa5Y='".$roaa5Y."',roae5Y='".$roae5Y."',roaeTTM='".$roaeTTM."',roeRfy='".$roeRfy."',roeTTM='".$roeTTM."',roi5Y='".$roi5Y."',roiAnnual='".$roiAnnual."',roiTTM='".$roiTTM."',tangibleBookValuePerShareAnnual='".$tangibleBookValuePerShareAnnual."',tangibleBookValuePerShareQuarterly='".$tangibleBookValuePerShareQuarterly."',tbvCagr5Y='".$tbvCagr5Y."',totalDebt_totalEquityAnnual='".$totalDebt_totalEquityAnnual."',totalDebt_totalEquityQuarterly='".$totalDebt_totalEquityQuarterly."',totalDebtCagr5Y='".$totalDebtCagr5Y."',yearToDatePriceReturnDaily='".$yearToDatePriceReturnDaily."' where symbol='".$symbol."'";
				sqlExe($sql);

			}else{
				$sql = "insert into api_Basic_Financials (symbol,DayAverageTradingVolume10,WeekPriceReturnDaily13,WeekPriceReturnDaily26,MonthAverageTradingVolume3,WeekHigh52,WeekHighDate52,WeekLow52,WeekLowDate52,WeekPriceReturnDaily52,PriceReturnDaily5Day,assetTurnoverAnnual,assetTurnoverTTM,beta,bookValuePerShareAnnual,bookValuePerShareQuarterly,bookValueShareGrowth5Y,capitalSpendingGrowth5Y,cashFlowPerShareAnnual,cashFlowPerShareTTM,cashPerSharePerShareAnnual,cashPerSharePerShareQuarterly,currentDividendYieldTTM,currentEv_freeCashFlowAnnual,currentEv_freeCashFlowTTM,currentRatioAnnual,currentRatioQuarterly,dividendGrowthRate5Y,dividendPerShare5Y,dividendPerShareAnnual,dividendYield5Y,dividendYieldIndicatedAnnual,dividendsPerShareTTM,ebitdPerShareTTM,ebitdaCagr5Y,ebitdaInterimCagr5Y,epsBasicExclExtraItemsAnnual,epsBasicExclExtraItemsTTM,epsExclExtraItemsAnnual,epsExclExtraItemsTTM,epsGrowth3Y,epsGrowth5Y,epsGrowthQuarterlyYoy,epsGrowthTTMYoy,epsInclExtraItemsAnnual,epsInclExtraItemsTTM,epsNormalizedAnnual,focfCagr5Y,freeCashFlowAnnual,freeCashFlowPerShareTTM,freeCashFlowTTM,freeOperatingCashFlow_revenue5Y,freeOperatingCashFlow_revenueTTM,grossMargin5Y,grossMarginAnnual,grossMarginTTM,inventoryTurnoverAnnual,inventoryTurnoverTTM,longTermDebt_equityAnnual,longTermDebt_equityQuarterly,marketCapitalization,monthToDatePriceReturnDaily,netDebtAnnual,netDebtQuarterly,netIncomeEmployeeAnnual,netIncomeEmployeeTTM,netInterestCoverageAnnual,netInterestCoverageTTM,netMarginGrowth5Y,netProfitMargin5Y,netProfitMarginAnnual,netProfitMarginTTM,operatingMargin5Y,operatingMarginAnnual,operatingMarginTTM,payoutRatioAnnual,payoutRatioTTM,pbAnnual,pbQuarterly,pcfShareTTM,peBasicExclExtraTTM,peExclExtraAnnual,peExclExtraHighTTM,peExclExtraTTM,peExclLowTTM,peInclExtraTTM,peNormalizedAnnual,pfcfShareAnnual,pfcfShareTTM,pretaxMargin5Y,pretaxMarginAnnual,pretaxMarginTTM,priceRelativeToS_P50013Week,priceRelativeToS_P50026Week,priceRelativeToS_P5004Week,priceRelativeToS_P50052Week,priceRelativeToS_P500Ytd,psAnnual,psTTM,ptbvAnnual,ptbvQuarterly,quickRatioAnnual,quickRatioQuarterly,receivablesTurnoverAnnual,receivablesTurnoverTTM,revenueEmployeeAnnual,revenueEmployeeTTM,revenueGrowth3Y,revenueGrowth5Y,revenueGrowthQuarterlyYoy,revenueGrowthTTMYoy,revenuePerShareAnnual,revenuePerShareTTM,revenueShareGrowth5Y,roaRfy,roaa5Y,roae5Y,roaeTTM,roeRfy,roeTTM,roi5Y,roiAnnual,roiTTM,tangibleBookValuePerShareAnnual,tangibleBookValuePerShareQuarterly,tbvCagr5Y,totalDebt_totalEquityAnnual,totalDebt_totalEquityQuarterly,totalDebtCagr5Y,yearToDatePriceReturnDaily) values ('$symbol','$DayAverageTradingVolume10','$WeekPriceReturnDaily13','$WeekPriceReturnDaily26','$MonthAverageTradingVolume3','$WeekHigh52','$WeekHighDate52','$WeekLow52','$WeekLowDate52','$WeekPriceReturnDaily52','$PriceReturnDaily5Day','$assetTurnoverAnnual','$assetTurnoverTTM','$beta','$bookValuePerShareAnnual','$bookValuePerShareQuarterly','$bookValueShareGrowth5Y','$capitalSpendingGrowth5Y','$cashFlowPerShareAnnual','$cashFlowPerShareTTM','$cashPerSharePerShareAnnual','$cashPerSharePerShareQuarterly','$currentDividendYieldTTM','$currentEv_freeCashFlowAnnual','$currentEv_freeCashFlowTTM','$currentRatioAnnual','$currentRatioQuarterly','$dividendGrowthRate5Y','$dividendPerShare5Y','$dividendPerShareAnnual','$dividendYield5Y','$dividendYieldIndicatedAnnual','$dividendsPerShareTTM','$ebitdPerShareTTM','$ebitdaCagr5Y','$ebitdaInterimCagr5Y','$epsBasicExclExtraItemsAnnual','$epsBasicExclExtraItemsTTM','$epsExclExtraItemsAnnual','$epsExclExtraItemsTTM','$epsGrowth3Y','$epsGrowth5Y','$epsGrowthQuarterlyYoy','$epsGrowthTTMYoy','$epsInclExtraItemsAnnual','$epsInclExtraItemsTTM','$epsNormalizedAnnual','$focfCagr5Y','$freeCashFlowAnnual','$freeCashFlowPerShareTTM','$freeCashFlowTTM','$freeOperatingCashFlow_revenue5Y','$freeOperatingCashFlow_revenueTTM','$grossMargin5Y','$grossMarginAnnual','$grossMarginTTM','$inventoryTurnoverAnnual','$inventoryTurnoverTTM','$longTermDebt_equityAnnual','$longTermDebt_equityQuarterly','$marketCapitalization','$monthToDatePriceReturnDaily','$netDebtAnnual','$netDebtQuarterly','$netIncomeEmployeeAnnual','$netIncomeEmployeeTTM','$netInterestCoverageAnnual','$netInterestCoverageTTM','$netMarginGrowth5Y','$netProfitMargin5Y','$netProfitMarginAnnual','$netProfitMarginTTM','$operatingMargin5Y','$operatingMarginAnnual','$operatingMarginTTM','$payoutRatioAnnual','$payoutRatioTTM','$pbAnnual','$pbQuarterly','$pcfShareTTM','$peBasicExclExtraTTM','$peExclExtraAnnual','$peExclExtraHighTTM','$peExclExtraTTM','$peExclLowTTM','$peInclExtraTTM','$peNormalizedAnnual','$pfcfShareAnnual','$pfcfShareTTM','$pretaxMargin5Y','$pretaxMarginAnnual','$pretaxMarginTTM','$priceRelativeToS_P50013Week','$priceRelativeToS_P50026Week','$priceRelativeToS_P5004Week','$priceRelativeToS_P50052Week','$priceRelativeToS_P500Ytd','$psAnnual','$psTTM','$ptbvAnnual','$ptbvQuarterly','$quickRatioAnnual','$quickRatioQuarterly','$receivablesTurnoverAnnual','$receivablesTurnoverTTM','$revenueEmployeeAnnual','$revenueEmployeeTTM','$revenueGrowth3Y','$revenueGrowth5Y','$revenueGrowthQuarterlyYoy','$revenueGrowthTTMYoy','$revenuePerShareAnnual','$revenuePerShareTTM','$revenueShareGrowth5Y','$roaRfy','$roaa5Y','$roae5Y','$roaeTTM','$roeRfy','$roeTTM','$roi5Y','$roiAnnual','$roiTTM','$tangibleBookValuePerShareAnnual','$tangibleBookValuePerShareQuarterly','$tbvCagr5Y','$totalDebt_totalEquityAnnual','$totalDebt_totalEquityQuarterly','$totalDebtCagr5Y','$yearToDatePriceReturnDaily')";
				sqlExe($sql);
			}


			$annualArr = $itemTmp['series']['annual'];
			foreach($annualArr as $key => $item){
				$series = $key;

				//기존데이터 삭제
				sqlExe("delete from api_Basic_Financials_annual where symbol='".$symbol."' and series='".$series."'");

				foreach($item as $p){
					$period = $p['period'];
					$periodTime = strtotime($period);
					$v = $p['v'];

					sqlExe("insert into api_Basic_Financials_annual (symbol,series,period,periodTime,v) values ('$symbol','$series','$period','$periodTime','$v')");
				}
			}

			$quarterlyArr = $itemTmp['series']['quarterly'];
			foreach($quarterlyArr as $key => $item){
				$series = $key;

				//기존데이터 삭제
				sqlExe("delete from api_Basic_Financials_quarterly where symbol='".$symbol."' and series='".$series."'");

				foreach($item as $p){
					$period = $p['period'];
					$periodTime = strtotime($period);
					$v = $p['v'];

					sqlExe("insert into api_Basic_Financials_quarterly (symbol,series,period,periodTime,v) values ('$symbol','$series','$period','$periodTime','$v')");
				}
			}
		}

//		echo $symbol."\n";
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>