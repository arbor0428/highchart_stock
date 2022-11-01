<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/insider-transactions.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$to = date('Y-m-d');
$from = date('Y-m-d',strtotime("$to -3 day"));

$finnhub = "https://finnhub.io/api/v1/stock/insider-transactions";
$param = "?from=".$from."&to=".$to;

//API 호출
include '/home/myss/www/module/apiCall.php';

$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

$totCnt = count($itemTmp['data']);

if($totCnt){
	$result = $itemTmp['data'];
	
	foreach($result as $item){
		$transactionPrice = $item['transactionPrice'];		//거래평단가
		if($transactionPrice > 0){
			$symbol = $item['symbol'];
			$name = addslashes($item['name']);
			$shareNum = $item['share'];
			$changeNum = $item['change'];
			$filingDate = $item['filingDate'];
			$filingTime = strtotime($filingDate);
			$transactionDate = $item['transactionDate'];
			$transactionTime = strtotime($transactionDate);
			$transactionCode = $item['transactionCode'];
			$tradePrice = $changeNum * $transactionPrice;		//거래금액
			$marketCapitalization = sqlRowOne("select marketCapitalization from api_Company_Profile where symbol='".$symbol."'");
			$marper = round(($tradePrice / $marketCapitalization) / 1000000, 2);	//시총대비 거래액
			if($marper == -0)	$marper = 0;
			$reSymbol = $item['symbol'];

			$tmpID = sqlRowOne("select uid from api_Insider_Transactions where symbol='".$symbol."' and name='".$name."' and shareNum='".$shareNum."' and changeNum='".$changeNum."' and filingDate='".$filingDate."' and transactionDate='".$transactionDate."' and transactionCode='".$transactionCode."' and transactionPrice='".$transactionPrice."'");
			if(!$tmpID){
				$sql = "insert into api_Insider_Transactions (symbol,name,shareNum,changeNum,filingDate,filingTime,transactionDate,transactionTime,transactionCode,transactionPrice,tradePrice,marper,reSymbol) values ('".$symbol."','".$name."','".$shareNum."','".$changeNum."','".$filingDate."','".$filingTime."','".$transactionDate."','".$transactionTime."','".$transactionCode."','".$transactionPrice."','".$tradePrice."','".$marper."','".$reSymbol."')";
				sqlExe($sql);
			}
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>