<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$logFile = '/home/myss/www/module/cron/log/Earnings_Calendar_Day.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$to = date('Y-m-d');
$from = date('Y-m-d',strtotime("$to -30 day"));

$toTime = strtotime($to);
$fromTime = strtotime($from);

for($t=$fromTime; $t<=$toTime; $t+=86400){
	$sTime = $t;
	$eTime = $t + 86399;

	$callDate = date('Y-m-d',$t);

	$finnhub = "https://finnhub.io/api/v1/calendar/earnings";
	$param = "?from=".$callDate."&to=".$callDate;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	//기존 데이터(api 호출 후 upChk값이 null이면 삭제)
	sqlExe("update api_Earnings_Calendar set upChk='' where dateTime>='".$sTime."' and dateTime<='".$eTime."'");

	if($itemTmp){
		$result = $itemTmp['earningsCalendar'];
		$upChk = '1';

		foreach($result as $item){
			foreach($item as $k1 => $v1){
				${$k1} = addslashes($v1);
			}

			if($date && $symbol){
				$dateTime = strtotime($date);

				$pmData = 0;

				//증감율 계산
				if($epsActual && $epsEstimate){
					$pmData = Util::fnPercent($epsEstimate,$epsActual);
				}			

				$tmpID = sqlRowOne("select uid from api_Earnings_Calendar where symbol='".$symbol."' and dateTime='".$dateTime."'");
				if(!$tmpID){
					$sql = "insert into api_Earnings_Calendar (symbol,date,dateTime,epsActual,epsEstimate,hour,quarter,revenueActual,revenueEstimate,year,pmData,reSymbol,upChk) values ('".$symbol."','$date','$dateTime','$epsActual','$epsEstimate','$hour','$quarter','$revenueActual','$revenueEstimate','$year','$pmData','$symbol','$upChk')";
					sqlExe($sql);

				}else{
					$sql = "update api_Earnings_Calendar set ";
					$sql .= "epsActual='$epsActual',";
					$sql .= "epsEstimate='$epsEstimate',";
					$sql .= "hour='$hour',";
					$sql .= "quarter='$quarter',";
					$sql .= "revenueActual='$revenueActual',";
					$sql .= "revenueEstimate='$revenueEstimate',";
					$sql .= "year='$year', ";
					$sql .= "pmData='$pmData', ";
					$sql .= "upChk='$upChk' ";
					$sql .= "where uid='$tmpID'";
					sqlExe($sql);
				}

//				echo $symbol." / ".$date."\n";
			}
		}
	}

	//데이터 삭제
	sqlExe("delete from api_Earnings_Calendar where upChk='' and dateTime>='".$sTime."' and dateTime<='".$eTime."'");
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>