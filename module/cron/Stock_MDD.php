<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";
include "/home/myss/www/module/lib.php";

$logFile = '/home/myss/www/module/cron/log/Stock_MDD.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$eDate = date('Y-m-d');
$eTime = strtotime($eDate) + 86399;
$sTime = strtotime("$eDate -20 years");

$row = sqlArray("select * from ks_symbol order by symbol");

$etc = Array('^GSPC','^NDX','^DJI','^RUT','^VIX','XIN9.FGI','^HSI','^STOXX50E','^N225','^NSEI');	//기타 심볼 추가
foreach($etc as $v){
	$row[]['symbol'] = $v;
}

foreach($row as $k => $v){
	//Arguments
	$symbol = $v['symbol'];

	if($symbol){
		//심볼 mdd 데이터
		$item = mddData($symbol,$sTime,$eTime);

		$nowPer = $item['nowPer'];	//고점대비 하락률
		$upPer = $item['upPer'];		//상승확률

		//최신정보 변경
		$uid = sqlRowOne("select uid from api_Stock_Candles_D where symbol='".$symbol."' order by t desc limit 1");

		sqlExe("update api_Stock_Candles_D set mddUp='".$upPer."', mddDown='".$nowPer."' where uid='".$uid."'");
		sqlExe("update Stock_Candles_Last set mddUp='".$upPer."', mddDown='".$nowPer."' where symbol='".$symbol."'");

//		echo $symbol."\n";
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>