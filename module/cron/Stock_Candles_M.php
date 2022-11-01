<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Stock_Candles_M.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$toDay = date('Y-m-d');
$from = strtotime("$toDay -1 day");
$to = strtotime($toDay) + 86399;

$resolution = 'M';		//ex)1, 5, 15, 30, 60, D, W, M

$row = sqlArray("select * from ks_symbol order by symbol");

$etc = Array('^GSPC','^NDX','^DJI','^RUT','^VIX','XIN9.FGI','^HSI','^STOXX50E','^N225','^NSEI');	//기타 심볼 추가
foreach($etc as $v){
	$row[]['symbol'] = $v;
}

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/candle";
	$param = "?symbol=".$symbol."&resolution=".$resolution."&from=".$from."&to=".$to;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$resArr = Array();

		foreach($itemTmp as $key => $item){
			foreach($item as $k1 => $v1){
	//			echo $key.' / '.$k.' / '.$v.'<Br>';

				$resArr[$k1][$key] = $v1;
			}
	//		echo '<br>';
		}

		foreach($resArr as $item){
			$tmpChk = sqlRowOne("select count(*) from api_Stock_Candles_M where symbol='".$symbol."' and t='".$item['t']."'");
			if(!$tmpChk){
				sqlExe("insert into api_Stock_Candles_M (symbol,c,h,l,o,v,t) values ('".$symbol."','".$item['c']."','".$item['h']."','".$item['l']."','".$item['o']."','".$item['v']."','".$item['t']."')");
			}
		}

//		echo $symbol."\n";
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>