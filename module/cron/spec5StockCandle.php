<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$toDay = date('Y-m-d');
$from = strtotime("$toDay");
$to = strtotime($toDay) + 86399;

$resolution = '1';		//ex)1, 5, 15, 30, 60, D, W, M

$row = Array('^GSPC','^NDX','^DJI','^RUT','^VIX','XLK','XLV','XLP','XLU','XLY','XLC','XLB','XLF','XLI','XLE','XLRE');

$rDate = date('Y-m-d H:i:s');
$rTime = time();
$callTime = date('Hi');

foreach($row as $v){

	//Arguments
	$symbol = $v;

	$finnhub = "https://finnhub.io/api/v1/stock/candle";
	$param = "?symbol=".$symbol."&resolution=".$resolution."&from=".$from."&to=".$to;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$resArr = Array();

		//오전5시, 오후5시 기준 첫번째 데이터
		$fo = 0;
		$fc = 0;

		foreach($itemTmp as $key => $item){
			foreach($item as $k1 => $v1){
				$resArr[$k1][$key] = $v1;
			}
		}

		$n = count($itemTmp['c']) - 1;	//마지막값(최신값)

/*
		echo $resArr[$n]['c'].'<Br>';
		echo $symbol.' / '.$k1.'<br>';

		foreach($resArr as $item){
			echo date('Y.m.d H:i:s',$item['t']).' / '.$item['c'].' / '.$item['o'].'<Br>';
		}
*/

		$dataC = $resArr[$n]['c'];
		$dataH = $resArr[$n]['h'];
		$dataL = $resArr[$n]['l'];
		$dataO = $resArr[$n]['o'];
		$dataT = $resArr[$n]['t'];
		$dataV = $resArr[$n]['v'];

//		sqlExe("insert into sec5StockCandle (symbol,fo,fc,c,h,l,o,t,v,rDate,rTime) values ('".$symbol."','".$fo."','".$fc."','".$dataC."','".$dataH."','".$dataL."','".$dataO."','".$dataT."','".$dataV."','".$rDate."','".$rTime."')");

		$sql = "update spec5StockCandle set ";

		//오전5시, 오후5시 기준 첫번째 데이터
		if($callTime == '0500' || $callTime == '1700'){
			$sql .= "fo='".$dataO."',";
			$sql .= "fc='".$dataC."',";
		}

		$sql .= "c='".$dataC."',";
		$sql .= "h='".$dataH."',";
		$sql .= "l='".$dataL."',";
		$sql .= "o='".$dataO."',";
		$sql .= "t='".$dataT."',";
		$sql .= "v='".$dataV."',";
		$sql .= "rDate='".$rDate."',";
		$sql .= "rTime='".$rTime."'";
		$sql .= " where symbol='".$symbol."'";

		sqlExe($sql);
	}
}
?>


<!--
# spec stock candles m
*/5 5,6 * * 2-6 /usr/bin/php -q /home/myss/www/module/cron/spec5StockCandle.php
*/5 17-21 * * 2-6 /usr/bin/php -q /home/myss/www/module/cron/spec5StockCandle.php
0,5,10,15,20,25 22 * * 2-6 /usr/bin/php -q /home/myss/www/module/cron/spec5StockCandle.php
-->