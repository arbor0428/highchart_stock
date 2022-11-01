<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Revenue_Estimates_annual.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];
	$freq = 'annual';

	$finnhub = "https://finnhub.io/api/v1/stock/revenue-estimate";
	$param = "?symbol=".$symbol."&freq=".$freq;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$result = $itemTmp['data'];

		if($result){
			//기존자료삭제
			sqlExe("delete from api_Revenue_Estimates where symbol='".$symbol."' and freq='".$freq."'");

			foreach($result as $item){
				$periodTime = strtotime($item['period']);

				$sql = "insert into api_Revenue_Estimates (symbol,freq,numberAnalysts,period,periodTime,revenueAvg,revenueHigh,revenueLow) values ('".$symbol."','".$freq."','".$item['numberAnalysts']."','".$item['period']."','".$periodTime."','".$item['revenueAvg']."','".$item['revenueHigh']."','".$item['revenueLow']."')";
				sqlExe($sql);
			}
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>