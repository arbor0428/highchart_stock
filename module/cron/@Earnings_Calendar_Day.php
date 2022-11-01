<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$logFile = '/home/myss/www/module/cron/log/Earnings_Calendar_Day.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

$toDay = date('Y-m-d');
$from = strtotime("$toDay -1 day");
$to = strtotime($toDay);

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/calendar/earnings";
	$param = "?symbol=".$symbol."&from=".$from."&to=".$to;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	$upChk = true;

	if($itemTmp){
		$result = $itemTmp['earningsCalendar'];
		foreach($result as $item){
			foreach($item as $k1 => $v1){
				${$k1} = addslashes($v1);
			}

			if($date){
				$dateTime = strtotime($date);

				$pmData = 0;

				//증감율 계산
				if($epsActual && $epsEstimate){
					$pmData = Util::fnPercent($epsEstimate,$epsActual);
				}

				$tmpID = sqlRowOne("select uid from api_Earnings_Calendar where symbol='".$v['symbol']."' and dateTime='".$dateTime."'");
				if(!$tmpID){
					$sql = "insert into api_Earnings_Calendar (symbol,date,dateTime,epsActual,epsEstimate,hour,quarter,revenueActual,revenueEstimate,year,pmData,reSymbol) values ('".$v['symbol']."','$date','$dateTime','$epsActual','$epsEstimate','$hour','$quarter','$revenueActual','$revenueEstimate','$year','$pmData','$symbol')";
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
					$sql .= "pmData='$pmData' ";
					$sql .= "where uid='$uid'";
					sqlExe($sql);
				}
			}
		}
/*
		echo $v['symbol'];
		if($v['symbol'] != $symbol)	echo " ==> ".$symbol;
		echo "\n";
*/
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>