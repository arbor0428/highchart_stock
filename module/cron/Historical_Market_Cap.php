<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Historical_Market_Cap.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$toDay = date('Y-m-d');
$yTime = strtotime("$toDay -1 day");
$from = date('Y-m-d',$yTime);
$to = $toDay;

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

	$finnhub = "https://finnhub.io/api/v1/stock/historical-market-cap";
	$param = "?symbol=".$symbol."&from=".$from."&to=".$to;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$currency = $itemTmp['currency'];
		$result = $itemTmp['data'];

		foreach($result as $k1 => $v1){
			$atDate = $v1['atDate'];
			$marketCapitalization = $v1['marketCapitalization'];
			$marketAPI = $marketCapitalization;

			//시가총액 통화변환
			if($currency != 'USD'){
				$q = $qArr[$currency];
				if($q){
					$marketCapitalization = $marketCapitalization / $q;					
				}
			}

			sqlExe("update api_Company_Profile set marketCapitalization='".$marketCapitalization."', marketAPI='".$marketAPI."' where symbol='".$symbol."'");

			if($atDate){
				$atTime = strtotime($atDate);
				$tmpChk = sqlRowOne("select count(*) from api_Historical_Market_Cap where symbol='".$symbol."' and atTime='".$atTime."'");
				if(!$tmpChk){
					$sql = "insert into api_Historical_Market_Cap (symbol,currency,atDate,atTime,marketCapitalization) values ('".$symbol."','".$currency."','".$atDate."','".$atTime."','".$marketCapitalization."')";
					sqlExe($sql);

					//심볼별 가장 최근 데이터
					$lastChk = sqlRowOne("select count(*) from Historical_Market_Cap_Last where symbol='".$symbol."'");
					if($lastChk){
						$sql = "update Historical_Market_Cap_Last set currency='".$currency."', atDate='".$atDate."', atTime='".$atTime."', marketCapitalization='".$marketCapitalization."' where symbol='".$symbol."'";
						sqlExe($sql);

					}else{
						sqlExe("insert into Historical_Market_Cap_Last (symbol,currency,atDate,atTime,marketCapitalization) values ('".$symbol."','".$currency."','".$atDate."','".$atTime."','".$marketCapitalization."')");
					}
				}
			}
		}
	}

//	echo $symbol." / ".$currency."\n";
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>