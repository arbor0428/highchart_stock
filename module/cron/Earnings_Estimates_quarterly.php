<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$logFile = '/home/myss/www/module/cron/log/Earnings_Estimates_quarterly.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];
	$freq = 'quarterly';

	$finnhub = "https://finnhub.io/api/v1/stock/eps-estimate";
	$param = "?symbol=".$symbol."&freq=".$freq;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$endtime = microtime();
	$endarray = explode(" ", $endtime);
	$endtime = $endarray[1] + $endarray[0];

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$result = $itemTmp['data'];
		$reSymbol = $itemTmp['symbol'];

		//기존 데이터 삭제
		sqlExe("delete from api_Earnings_Estimates where symbol='".$symbol."' and freq='".$freq."'");

		foreach($result as $item){
			$periodTime = strtotime($item['period']);

			$sql = "insert into api_Earnings_Estimates (symbol,freq,epsAvg,epsHigh,epsLow,numberAnalysts,period,periodTime,reSymbol) values ('".$symbol."','".$freq."','".$item['epsAvg']."','".$item['epsHigh']."','".$item['epsLow']."','".$item['numberAnalysts']."','".$item['period']."','".$periodTime."','".$reSymbol."')";
			sqlExe($sql);
		}

		//이전날짜의 데이터값과 비교하여 증감율 계산
		$list = sqlArray("select * from api_Earnings_Estimates where symbol='".$symbol."' and freq='".$freq."' order by periodTime desc");
		foreach($list as $v){
			$uid = $v['uid'];
			$periodTime = $v['periodTime'];
			$epsAvg = $v['epsAvg'];
			
			$pmData = 0;

			//이전값확인
			$tmpData = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='".$freq."' and periodTime<".$periodTime." order by periodTime desc limit 1");

			//증감율 계산
			if($epsAvg && $tmpData){
				$pmData = Util::fnPercent($tmpData,$epsAvg);
			}

			sqlExe("update api_Earnings_Estimates set pmData='".$pmData."' where uid='".$uid."'");
		}
/*
		echo $symbol;
		if($symbol != $reSymbol)	echo " ==> ".$reSymbol;
		echo "\n";
*/
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>