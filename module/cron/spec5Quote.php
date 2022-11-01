<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$row = Array('^GSPC','^NDX','^DJI','^RUT','^VIX','XLK','XLV','XLP','XLU','XLY','XLC','XLB','XLF','XLI','XLE','XLRE');

$rDate = date('Y-m-d H:i:s');
$rTime = time();

foreach($row as $v){

	//Arguments
	$symbol = $v;

	$finnhub = "https://finnhub.io/api/v1/quote";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$item = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($item){
//		sqlExe("insert into spec5Quote (symbol,c,d,dp,h,l,o,pc,t,rDate,rTime) values ('".$symbol."','".$item['c']."','".$item['d']."','".$item['dp']."','".$item['h']."','".$item['l']."','".$item['o']."','".$item['pc']."','".$item['t']."','".$rDate."','".$rTime."')");
		sqlExe("update spec5Quote set c='".$item['c']."', d='".$item['d']."', dp='".$item['dp']."', h='".$item['h']."', l='".$item['l']."', o='".$item['o']."', pc='".$item['pc']."', t='".$item['t']."', rDate='".$rDate."', rTime='".$rTime."' where symbol='".$symbol."'");
	}
}
?>

<!--
# spec quote
*/5 0-4 * * 2-6 /usr/bin/php -q /home/myss/www/module/cron/spec5Quote.php
30,35,40,45,50,55 22 * * 2-6 /usr/bin/php -q /home/myss/www/module/cron/spec5Quote.php
*/5 23 * * 2-6 /usr/bin/php -q /home/myss/www/module/cron/spec5Quote.php
-->