<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/ETFs_Holdings.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='Y' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/etf/holdings";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$atDate = $itemTmp['atDate'];
		if($atDate){
			$tmpDate = sqlRowOne("select atDate from api_ETFs_Holdings where symbol='".$symbol."'");

			if($tmpDate != $atDate){
				//기존자료삭제
				sqlExe("delete from api_ETFs_Holdings where symbol='".$symbol."'");

				$atTime = strtotime($atDate);
				$result = $itemTmp['holdings'];

				foreach($result as $item){
					$name = addslashes($item['name']);
					$sql = "insert into api_ETFs_Holdings (symbol,atDate,atTime,cusip,isin,name,percent,share,symbolTxt,value) values  ('".$symbol."','".$atDate."','".$atTime."','".$item['cusip']."','".$item['isin']."','".$name."','".$item['percent']."','".$item['share']."','".$item['symbol']."','".$item['value']."')";
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