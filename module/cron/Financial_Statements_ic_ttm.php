<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Financial_Statements_ic_ttm.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];
	$statement = 'ic';
	$freq = 'ttm';

	$finnhub = "https://finnhub.io/api/v1/stock/financials";
	$param = "?symbol=".$symbol."&statement=".$statement."&freq=".$freq;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$result = $itemTmp['financials'];
		$reSymbol = $itemTmp['symbol'];
/*
		if($symbol != $reSymbol){
			sqlExe("update api_Financial_Statements_ic_ttm set reSymbol='".$reSymbol."' where symbol='".$symbol."'");
		}
*/

		foreach($result as $item){
			$costOfGoodsSold = '';

			foreach($item as $k1 => $v1){
				${$k1} = addslashes($v1);
			}

			if($costOfGoodsSold){
				$tmpChk = sqlRowOne("select count(*) from api_Financial_Statements_ic_ttm where symbol='".$symbol."' and period='".$period."'");
				if(!$tmpChk){
					$sql = "insert into api_Financial_Statements_ic_ttm (symbol,costOfGoodsSold,dilutedAverageSharesOutstanding,dilutedEPS,ebit,grossIncome,interestIncomeExpense,netIncome,netIncomeAfterTaxes,period,pretaxIncome,provisionforIncomeTaxes,researchDevelopment,revenue,sgaExpense,totalOperatingExpense,totalOtherIncomeExpenseNet,year,reSymbol) values  ('$symbol','$costOfGoodsSold','$dilutedAverageSharesOutstanding','$dilutedEPS','$ebit','$grossIncome','$interestIncomeExpense','$netIncome','$netIncomeAfterTaxes','$period','$pretaxIncome','$provisionforIncomeTaxes','$researchDevelopment','$revenue','$sgaExpense','$totalOperatingExpense','$totalOtherIncomeExpenseNet','$year','$reSymbol')";
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