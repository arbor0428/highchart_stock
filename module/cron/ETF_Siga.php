<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/ETF_Siga.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");


$rDate = date('Y-m-d');
$rTime = time();

$eDate = date('Y-m-d',strtotime("$rDate -1 day"));
$eTime = strtotime($eDate) + 86399;

$sDate = date('Y-m-d',strtotime("$rDate -1 year"));
$sTime = strtotime($sDate);

//3월,6월,9월,12월 1일은 sumAmt를 갱신함
$md = date('md');

$row = sqlArray("select * from ks_symbol as s left join Stock_Candles_Last as c on s.symbol=c.symbol where s.etf='Y' order by s.symbol");
foreach($row as $v){
	$siga = 0;

	if($md == '0301' || $md == '0601' || $md == '0901' || $md == '1201'){
		$sumAmt = sqlRowOne("select sum(adjustedAmount) from api_Dividends where symbol='".$v['symbol']."' and dateTime>='".$sTime."' and dateTime<='".$eTime."'");
	}else{
		$sumAmt = sqlRowOne("select sumAmt from etf_siga where symbol='".$v['symbol']."'");
	}

	if($sumAmt){
		$siga = round(($sumAmt / $v['c']) * 100, 2);
	}

	$tmpChk = sqlRowOne("select count(*) from etf_siga where symbol='".$v['symbol']."'");
	if($tmpChk){
		sqlExe("update etf_siga set sumAmt='".$sumAmt."', c='".$v['c']."', siga='".$siga."', rDate='".$rDate."', rTime='".$rTime."' where symbol='".$symbol."'");
	}else{
		$sql = "insert into etf_siga (symbol,sumAmt,c,siga,rDate,rTime) values ('".$v['symbol']."','".$sumAmt."','".$v['c']."','".$siga."','".$rDate."','".$rTime."')";
		sqlExe($sql);
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>