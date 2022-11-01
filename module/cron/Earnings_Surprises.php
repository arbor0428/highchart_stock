<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$logFile = '/home/myss/www/module/cron/log/Earnings_Surprises.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/earnings";
	$param = "?symbol=".$symbol."&limit=2";

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		foreach($itemTmp as $item){
			foreach($item as $k1 => $v1){
				${$k1} = addslashes($v1);
			}

			if($period){
				$periodTime = strtotime($period);

				$pmData = 0;

				//증감율 계산
				if($actual && $estimate){
					$pmData = Util::fnPercent($estimate,$actual);
				}

				$tmpID = sqlRowOne("select uid from api_Earnings_Surprises where symbol='".$v['symbol']."' and periodTime='".$periodTime."'");
				if(!$tmpID){
					$sql = "insert into api_Earnings_Surprises (symbol,actual,estimate,period,periodTime,surprise,surprisePercent,pmData,reSymbol) values ('".$v['symbol']."','$actual','$estimate','$period','$periodTime','$surprise','$surprisePercent','$pmData','$symbol')";
					sqlExe($sql);

				}else{
					$sql = "update api_Earnings_Surprises set ";
					$sql .= "actual='$actual',";
					$sql .= "estimate='$estimate',";
					$sql .= "period='$period',";
					$sql .= "periodTime='$periodTime',";
					$sql .= "surprise='$surprise',";
					$sql .= "surprisePercent='$surprisePercent', ";
					$sql .= "pmData='$pmData', ";
					$sql .= "reSymbol='$symbol' ";
					$sql .= "where uid='$tmpID'";
					sqlExe($sql);
				}
			}
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>