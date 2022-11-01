<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Financial_Statements_ic_annual.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){
	## 페이지 최상단 마이크로초 시작
	$starttime = microtime();
	$startarray = explode(" ", $starttime);
	$starttime = $startarray[1] + $startarray[0];

	//Arguments
	$symbol = $v['symbol'];
	$statement = 'ic';
	$freq = 'annual';

	$finnhub = "https://finnhub.io/api/v1/stock/financials";
	$param = "?symbol=".$symbol."&statement=".$statement."&freq=".$freq;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$endtime = microtime();
	$endarray = explode(" ", $endtime);
	$endtime = $endarray[1] + $endarray[0];

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$result = $itemTmp['financials'];
		$reSymbol = $itemTmp['symbol'];
/*
		if($symbol != $reSymbol){
			sqlExe("update api_Financial_Statements_ic_annual set reSymbol='".$reSymbol."' where symbol='".$symbol."'");
		}
*/

		foreach($result as $item){
			$costOfGoodsSold = '';

			foreach($item as $k1 => $v1){
				${$k1} = addslashes($v1);
			}

			if($costOfGoodsSold){
				$tmpChk = sqlRowOne("select count(*) from api_Financial_Statements_ic_annual where symbol='".$symbol."' and period='".$period."'");
				if(!$tmpChk){
					$sql = "insert into api_Financial_Statements_ic_annual (symbol,costOfGoodsSold,dilutedAverageSharesOutstanding,dilutedEPS,ebit,grossIncome,interestIncomeExpense,netIncome,netIncomeAfterTaxes,period,pretaxIncome,provisionforIncomeTaxes,researchDevelopment,revenue,sgaExpense,totalOperatingExpense,totalOtherIncomeExpenseNet,year,reSymbol) values  ('$symbol','$costOfGoodsSold','$dilutedAverageSharesOutstanding','$dilutedEPS','$ebit','$grossIncome','$interestIncomeExpense','$netIncome','$netIncomeAfterTaxes','$period','$pretaxIncome','$provisionforIncomeTaxes','$researchDevelopment','$revenue','$sgaExpense','$totalOperatingExpense','$totalOtherIncomeExpenseNet','$year','$reSymbol')";
					sqlExe($sql);
				}else{
					break;
				}
			}
		}
/*		
		echo $symbol;
		if($symbol != $reSymbol)	echo " ==> ".$reSymbol;
		echo "\n";
*/
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>