<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Stock_up_down.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$toDay = date('Y-m-d');
$yTime = strtotime("$toDay -1 day");
$from = date('Y-m-d',$yTime);
$to = $toDay;

$finnhub = "https://finnhub.io/api/v1/stock/upgrade-downgrade";
$param = "?symbol=".$symbol."&from=".$from."&to=".$to;

//API 호출
include '/home/myss/www/module/apiCall.php';

$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

if($itemTmp){
	foreach($itemTmp as $item){
		foreach($item as $k1 => $v1){
			${$k1} = addslashes($v1);
		}

		//심볼확인
		$sChk = sqlRowOne("select count(*) from ks_symbol where symbol='".$symbol."'");
		if($sChk){
			$tmpChk = sqlRowOne("select count(*) from api_Stock_Up_Down where symbol='".$symbol."' and gradeTime='".$gradeTime."' and company='".$company."'");
			if(!$tmpChk){
				$sql = "insert into api_Stock_Up_Down (symbol,gradeTime,company,fromGrade,toGrade,action) values ('".$symbol."','".$gradeTime."','".$company."','".$fromGrade."','".$toGrade."','".$action."')";
				sqlExe($sql);
			}
		}
//		echo $symbol."\n";
	}
}
$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>