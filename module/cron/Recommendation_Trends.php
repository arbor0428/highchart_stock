<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Recommendation_Trends.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/recommendation";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		foreach($itemTmp as $item){
			foreach($item as $k1 => $v1){
				${$k1} = addslashes($v1);
			}

			if($period){
				$periodTime = strtotime($period);

				$tmpChk = sqlRowOne("select count(*) from api_Recommendation_Trends where symbol='".$v['symbol']."' and periodTime='".$periodTime."'");
				if(!$tmpChk){
					$totNum = $strongSell + $sell + $hold + $buy + $strongBuy;

					$strongSellScore = round((1 * $strongSell) / $totNum,2);
					$sellScore = round((2 * $sell) / $totNum,2);
					$holdScore = round((3 * $hold) / $totNum,2);
					$buyScore = round((4 * $buy) / $totNum,2);
					$strongBuyScore = round((5 * $strongBuy) / $totNum,2);

					$score = $strongSellScore + $sellScore + $holdScore + $buyScore + $strongBuyScore;

					$sql = "insert into api_Recommendation_Trends (symbol,buy,hold,period,periodTime,sell,strongBuy,strongSell,score,reSymbol) values ('".$v['symbol']."','$buy','$hold','$period','$periodTime','$sell','$strongBuy','$strongSell','$score','$symbol')";
					sqlExe($sql);
					
				}else{
					break;
				}
			}
		}
/*
		echo $v['symbol'];
		if($v['symbol'] != $symbol)	echo " ==> ".$symbol;
		echo "\n";
*/
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>