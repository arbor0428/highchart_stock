<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Dividends.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$toDay = date('Y-m-d');
$yTime = strtotime("$toDay -1 day");
$from = date('Y-m-d',$yTime);
$to = date('Y-m-d', strtotime("$toDay +1 month"));

$row = sqlArray("select * from ks_symbol order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/dividend";
	$param = "?symbol=".$symbol."&from=".$from."&to=".$to;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);


	if($itemTmp){
		foreach($itemTmp as $item){
			$dateTime = strtotime($item['date']);
			$payTime = strtotime($item['payDate']);
			$recordTime = strtotime($item['recordDate']);
			$declarationTime = strtotime($item['declarationDate']);

			$tmpID = sqlRowOne("select uid from api_Dividends where symbol='".$symbol."' and date='".$item['date']."'");
			if(!$tmpID){
				$sql = "insert into api_Dividends (symbol,date,dateTime,amount,adjustedAmount,payDate,payTime,recordDate,recordTime,declarationDate,declarationTime,currency) values ('".$symbol."','".$item['date']."','".$dateTime."','".$item['amount']."','".$item['adjustedAmount']."','".$item['payDate']."','".$payTime."','".$item['recordDate']."','".$recordTime."','".$item['declarationDate']."','".$declarationTime."','".$item['currency']."')";
				sqlExe($sql);

			}else{
				$sql = "update api_Dividends set amount='".$item['amount']."', adjustedAmount='".$item['adjustedAmount']."', payDate='".$item['payDate']."', payTime='".$payTime."', recordDate='".$item['recordDate']."', recordTime='".$recordTime."', declarationDate='".$item['declarationDate']."', declarationTime='".$declarationTime."', currency='".$item['currency']."' where uid='".$tmpID."'";
				sqlExe($sql);
			}

			//주식 > 배당주 검색(주당 배당금)에서 사용되는 값
			$chkTime = strtotime($item['payDate']." -1 years");
			$row = sqlRow("select sum(adjustedAmount) as a, count(*) as b from api_Dividends where symbol='".$symbol."' and dateTime<='".$dateTime."' and dateTime>'".$chkTime."' and declarationTime>0");
			sqlExe("update api_Dividends set adjustedAmountYear='".$row['a']."', dNum='".$row['b']."' where symbol='".$symbol."' and date='".$item['date']."'");
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>