<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$logFile = '/home/myss/www/module/cron/log/Forex_rates.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");



$finnhub = "https://finnhub.io/api/v1/forex/rates";
$param = "?base=USD";

//API 호출
include '/home/myss/www/module/apiCall.php';

$item = json_decode($req,JSON_UNESCAPED_UNICODE);

if($item){
	sqlExe("update api_Forex_rates set upChk=''");

	$rDate = date('Y-m-d H:i:s');
	$rTime = time();

	$row = $item['quote'];

	foreach($row as $k => $v){
		$tmpChk = sqlRowOne("select count(*) from api_Forex_rates where base='".$k."'");
		if($tmpChk)		sqlExe("update api_Forex_rates set q='".$v."', upChk='1', rDate='".$rDate."', rTime='".$rTime."' where base='".$k."'");
		else				sqlExe("insert into api_Forex_rates (base,q,upChk,rDate,rTime) values ('".$k."','".$v."','1','".$rDate."','".$rTime."')");


		//통화목록에는 없지만 company profile등에 있는 통화가 있음.
		//GBX 는 GBP 와 같다고 보시면 되고, ZAC는 ZAR, ILA 는 ILS 로 보시면 됩니다
		if($k == 'GBP' || $k == 'ZAR' || $k == 'ILS'){
			if($k == 'GBP')		$t = 'GBX';
			elseif($k == 'ZAR')	$t = 'ZAC';
			elseif($k == 'ILS')		$t = 'ILA';

			$tmpChk = sqlRowOne("select count(*) from api_Forex_rates where base='".$t."'");
			if($tmpChk)		sqlExe("update api_Forex_rates set q='".$v."', upChk='1', rDate='".$rDate."', rTime='".$rTime."' where base='".$t."'");
			else				sqlExe("insert into api_Forex_rates (base,q,upChk,rDate,rTime) values ('".$t."','".$v."','1','".$rDate."','".$rTime."')");
		}
	}

	sqlExe("delete from api_Forex_rates where upChk=''");
}


$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>