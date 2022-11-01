<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/NewsSentiment.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/news-sentiment";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);


	if($itemTmp){
		$articlesInLastWeek = $itemTmp['buzz']['articlesInLastWeek'];
		$buzz = $itemTmp['buzz']['buzz'];
		$weeklyAverage = $itemTmp['buzz']['weeklyAverage'];

		$companyNewsScore = $itemTmp['companyNewsScore'];
		$sectorAverageBullishPercent = $itemTmp['sectorAverageBullishPercent'];
		$sectorAverageNewsScore = $itemTmp['sectorAverageNewsScore'];

		$bearishPercent = $itemTmp['sentiment']['bearishPercent'];
		$bullishPercent = $itemTmp['sentiment']['bullishPercent'];

		$reSymbol = $itemTmp['symbol'];

		$tmpID = sqlRowOne("select uid from api_News_Sentiment where symbol='".$symbol."'");
		if(!$tmpID){
			$sql = "insert into api_News_Sentiment (symbol,articlesInLastWeek,buzz,weeklyAverage,companyNewsScore,sectorAverageBullishPercent,sectorAverageNewsScore,bearishPercent,bullishPercent,reSymbol) values ('".$symbol."','".$articlesInLastWeek."','".$buzz."','".$weeklyAverage."','".$companyNewsScore."','".$sectorAverageBullishPercent."','".$sectorAverageNewsScore."','".$bearishPercent."','".$bullishPercent."','".$reSymbol."')";
			sqlExe($sql);

		}else{
			$sql = "update api_News_Sentiment set articlesInLastWeek='".$articlesInLastWeek."', buzz='".$buzz."', weeklyAverage='".$weeklyAverage."', companyNewsScore='".$companyNewsScore."', sectorAverageBullishPercent='".$sectorAverageBullishPercent."', sectorAverageNewsScore='".$sectorAverageNewsScore."', bearishPercent='".$bearishPercent."', bullishPercent='".$bullishPercent."' where uid='".$tmpID."'";
			sqlExe($sql);
		}

//		echo $symbol."\n";
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>