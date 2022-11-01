<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/snp500.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");


//Arguments
$symbol = "^GSPC";

$finnhub = "https://finnhub.io/api/v1/index/constituents";
$param = "?symbol=".$symbol;

//API 호출
include '/home/myss/www/module/apiCall.php';

$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);


if($itemTmp){
	$item = $itemTmp['constituents'];
	if(count($item) > 0){
		//기존 snp500 정보 초기화
		sqlExe("update ks_symbol set snp500=''");

		foreach($item as $v){
			sqlExe("update ks_symbol set snp500='1' where symbol='".$v."'");
		}


	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>