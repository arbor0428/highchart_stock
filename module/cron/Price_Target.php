<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Price_Target.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/price-target";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		foreach($itemTmp as $k1 => $v1){
			${$k1} = addslashes($v1);
		}

		if($symbol){
			$lastUpdatedTime = strtotime($lastUpdated);

			$tmpChk = sqlRowOne("select uid from api_Price_Target where symbol='".$symbol."' and lastUpdatedTime='".$lastUpdatedTime."'");
			if(!$tmpChk){
				$sql = "insert into api_Price_Target (symbol,lastUpdated,lastUpdatedTime,targetHigh,targetLow,targetMean,targetMedian) values ('".$symbol."','".$lastUpdated."','".$lastUpdatedTime."','".$targetHigh."','".$targetLow."','".$targetMean."','".$targetMedian."')";
				sqlExe($sql);
			}else{
				sqlExe("update api_Price_Target set targetHigh='".$targetHigh."', targetLow='".$targetLow."', targetMean='".$targetMean."', targetMedian='".$targetMedian."' where uid='".$tmpChk."'");

//				echo $symbol."\n";
			}
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>