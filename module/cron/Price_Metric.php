<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Price_Metric.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$rDate = date('Y-m-d H:i:s');
$rTime = time();

$row = sqlArray("select * from ks_symbol order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/price-metric";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$item = $itemTmp['data'];
		$reSymbol = $itemTmp['symbol'];

		$tmpChk = sqlRowOne("select count(*) from api_price_metric where symbol='".$symbol."'");
		if(!$tmpChk){
			sqlExe("insert into api_price_metric (symbol,DayEMA100,DaySMA100,DayAverageTradingVolume10,DayEMA10,DaySMA10,MonthPriceReturn12,DayRSI14,MonthHigh1,MonthHighDate1,MonthLow1,MonthLowDate1,MonthPriceReturn1,DayEMA200,DaySMA200,DayEMA20,DaySMA20,DayAverageTradingVolume30,DayEMA30,DaySMA30,MonthHigh3,MonthHighDate3,MonthLow3,MonthLowDate3,MonthPriceReturn3,DayEMA50,DaySMA50,WeekHigh52,WeekHighDate52,WeekLow52,WeekLowDate52,DayEMA5,DayPriceReturn5,DaySMA5,DayAverageTradingVolume60,MonthHigh6,MonthHighDate6,MonthLow6,MonthLowDate6,MonthPriceReturn6,DayAverageTradingVolume90,ytdPriceReturn,reSymbol,rDate,rTime) values ('".$symbol."','".$item['100DayEMA']."','".$item['100DaySMA']."','".$item['10DayAverageTradingVolume']."','".$item['10DayEMA']."','".$item['10DaySMA']."','".$item['12MonthPriceReturn']."','".$item['14DayRSI']."','".$item['1MonthHigh']."','".$item['1MonthHighDate']."','".$item['1MonthLow']."','".$item['1MonthLowDate']."','".$item['1MonthPriceReturn']."','".$item['200DayEMA']."','".$item['200DaySMA']."','".$item['20DayEMA']."','".$item['20DaySMA']."','".$item['30DayAverageTradingVolume']."','".$item['30DayEMA']."','".$item['30DaySMA']."','".$item['3MonthHigh']."','".$item['3MonthHighDate']."','".$item['3MonthLow']."','".$item['3MonthLowDate']."','".$item['3MonthPriceReturn']."','".$item['50DayEMA']."','".$item['50DaySMA']."','".$item['52WeekHigh']."','".$item['52WeekHighDate']."','".$item['52WeekLow']."','".$item['52WeekLowDate']."','".$item['5DayEMA']."','".$item['5DayPriceReturn']."','".$item['5DaySMA']."','".$item['60DayAverageTradingVolume']."','".$item['6MonthHigh']."','".$item['6MonthHighDate']."','".$item['6MonthLow']."','".$item['6MonthLowDate']."','".$item['6MonthPriceReturn']."','".$item['90DayAverageTradingVolume']."','".$item['ytdPriceReturn']."','".$reSymbol."','".$rDate."','".$rTime."')");

		}else{
			sqlExe("update api_price_metric set DayEMA100='".$item['100DayEMA']."', DaySMA100='".$item['100DaySMA']."', DayAverageTradingVolume10='".$item['10DayAverageTradingVolume']."', DayEMA10='".$item['10DayEMA']."', DaySMA10='".$item['10DaySMA']."', MonthPriceReturn12='".$item['12MonthPriceReturn']."', DayRSI14='".$item['14DayRSI']."', MonthHigh1='".$item['1MonthHigh']."', MonthHighDate1='".$item['1MonthHighDate']."', MonthLow1='".$item['1MonthLow']."', MonthLowDate1='".$item['1MonthLowDate']."', MonthPriceReturn1='".$item['1MonthPriceReturn']."', DayEMA200='".$item['200DayEMA']."', DaySMA200='".$item['200DaySMA']."', DayEMA20='".$item['20DayEMA']."', DaySMA20='".$item['20DaySMA']."', DayAverageTradingVolume30='".$item['30DayAverageTradingVolume']."', DayEMA30='".$item['30DayEMA']."', DaySMA30='".$item['30DaySMA']."', MonthHigh3='".$item['3MonthHigh']."', MonthHighDate3='".$item['3MonthHighDate']."', MonthLow3='".$item['3MonthLow']."', MonthLowDate3='".$item['3MonthLowDate']."', MonthPriceReturn3='".$item['3MonthPriceReturn']."', DayEMA50='".$item['50DayEMA']."', DaySMA50='".$item['50DaySMA']."', WeekHigh52='".$item['52WeekHigh']."', WeekHighDate52='".$item['52WeekHighDate']."', WeekLow52='".$item['52WeekLow']."', WeekLowDate52='".$item['52WeekLowDate']."', DayEMA5='".$item['5DayEMA']."', DayPriceReturn5='".$item['5DayPriceReturn']."', DaySMA5='".$item['5DaySMA']."', DayAverageTradingVolume60='".$item['60DayAverageTradingVolume']."', MonthHigh6='".$item['6MonthHigh']."', MonthHighDate6='".$item['6MonthHighDate']."', MonthLow6='".$item['6MonthLow']."', MonthLowDate6='".$item['6MonthLowDate']."', MonthPriceReturn6='".$item['6MonthPriceReturn']."', DayAverageTradingVolume90='".$item['90DayAverageTradingVolume']."', ytdPriceReturn='".$item['ytdPriceReturn']."', reSymbol='".$reSymbol."', rDate='".$rDate."', rTime='".$rTime."' where symbol='".$symbol."'");
		}
	}

//	echo $symbol."\n";
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>