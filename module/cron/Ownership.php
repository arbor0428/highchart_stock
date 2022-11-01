<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Ownership.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' and symbol>='GBR' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/ownership";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$item = $itemTmp['ownership'];
		$reSymbol = $itemTmp['symbol'];

		if($item && $reSymbol){
			//기존 데이터 삭제
			sqlExe("delete from api_Ownership where symbol='".$symbol."' and reSymbol='".$reSymbol."'");

			foreach($item as $v){
				$name = addslashes($v['name']);
				$share = $v['share'];
				$changeNum = $v['change'];
				$filingDate = $v['filingDate'];
				$filingTime = strtotime($filingDate);

				$sql = "insert into api_Ownership (symbol,name,share,changeNum,filingDate,filingTime,reSymbol) values ('".$symbol."','".$name."','".$share."','".$changeNum."','".$filingDate."','".$filingTime."','".$reSymbol."')";
				sqlExe($sql);
			}
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>