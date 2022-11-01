<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$logFile = '/home/myss/www/module/cron/log/Quote.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol order by symbol");

$etc = Array('^GSPC','^NDX','^DJI','^RUT','^VIX','XIN9.FGI','^HSI','^STOXX50E','^N225','^NSEI');	//기타 심볼 추가
$etcArr = Array();
foreach($etc as $k => $v){
	$etcArr[$k]['symbol'] = $v;
}

//기타심볼을 우선 처리한다
$rows = array_merge($etcArr, $row);

foreach($rows as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/quote";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$item = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($item){
//		sqlExe("insert into api_Quote (symbol,c,d,dp,h,l,o,pc,t) values ('".$symbol."','".$item['c']."','".$item['d']."','".$item['dp']."','".$item['h']."','".$item['l']."','".$item['o']."','".$item['pc']."','".$item['t']."')");
		sqlExe("update Stock_Candles_Last set c='".$item['c']."', h='".$item['h']."', l='".$item['l']."', o='".$item['o']."', t='".$item['t']."' where symbol='".$symbol."'");
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>