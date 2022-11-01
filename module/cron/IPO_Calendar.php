<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$logFile = '/home/myss/www/module/cron/log/IPO_Calendar.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");


$to = date('Y-m-d');
$from = date('Y-m-d',strtotime("$from -300 day"));

$finnhub = "https://finnhub.io/api/v1/calendar/ipo";
$param = "?from=".$from."&to=".$to;

//API 호출
include '/home/myss/www/module/apiCall.php';

$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

if($itemTmp){
	$result = $itemTmp['ipoCalendar'];

	foreach($result as $item){
		foreach($item as $k1 => $v1){
			${$k1} = addslashes($v1);
		}

		if($date && $symbol){
			$dateTime = strtotime($date);

			$tmpID = sqlRowOne("select uid from api_IPO_Calendar where symbol='".$symbol."' and dateTime='".$dateTime."'");
			if(!$tmpID){
				$sql = "insert into api_IPO_Calendar (symbol,date,dateTime,exchange,name,numberOfShares,price,status,totalSharesValue) values ('".$symbol."','".$date."','".$dateTime."','".$exchange."','".$name."','".$numberOfShares."','".$price."','".$status."','".$totalSharesValue."')";
				sqlExe($sql);

			}else{
				$sql = "update api_IPO_Calendar set ";
				$sql .= "exchange='$exchange',";
				$sql .= "name='$name',";
				$sql .= "numberOfShares='$numberOfShares',";
				$sql .= "price='$price',";
				$sql .= "status='$status',";
				$sql .= "totalSharesValue='$totalSharesValue'";
				$sql .= "where uid='$uid'";
				sqlExe($sql);
			}
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>