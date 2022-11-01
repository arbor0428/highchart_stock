<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/ETFs_Country_Exposure.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='Y' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/etf/country";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$result = $itemTmp['countryExposure'];

		if($result){
			//기존자료삭제
			sqlExe("delete from api_ETFs_Country_Exposure where symbol='".$symbol."'");

			foreach($result as $item){
				foreach($item as $k1 => $v1){
					${$k1} = addslashes($v1);
				}

				if($country){
					$sql = "insert into api_ETFs_Country_Exposure (symbol,country,countryCode,exposure) values ('".$symbol."','".$country."','".$countryCode."','".$exposure."')";
					sqlExe($sql);
				}
			}
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>