<?
exit;
include '../class/class.DbCon.php';


## 페이지 최상단 마이크로초 시작
$st = microtime();
$starray = explode(" ", $st);
$st = $starray[1] + $starray[0];




$symbol = 'AAPL';
$sTime = strtotime('-20 year');

$item = sqlArray("select * from ks_symbol order by symbol");

foreach($item as $s){
	$data = Array();
	$symbol = $s['symbol'];

	## 페이지 최상단 마이크로초 시작
	$starttime = microtime();
	$startarray = explode(" ", $starttime);
	$starttime = $startarray[1] + $startarray[0];

	$row = sqlArray("select * from api_Stock_Candles_D where symbol='".$symbol."' and t>=".$sTime." order by t");
	foreach($row as $k => $item){
		$endtime = microtime();
		$endarray = explode(" ", $endtime);
		$endtime = $endarray[1] + $endarray[0];

	//	echo date('Y-m-d',$item['t']).' / '.$item['v'].'<br>';

		$t = $item['t'] * 1000;		//자바스크립트 타임값으로..
		$o = (float)$item['o'];		//숫자형으로..
		$h = (float)$item['h'];		//숫자형으로..
		$l = (float)$item['l'];		//숫자형으로..
		$c = (float)$item['c'];		//숫자형으로..
		$v = (float)$item['v'];		//숫자형으로..

		$data[$k] = Array($t,$o,$h,$l,$c,$v);
	}

	$json = json_encode($data,JSON_UNESCAPED_UNICODE);
	file_put_contents("/home/myss/www/module/highcharts/".$symbol.".json", $json);

	## 페이지 최하단 마이크로초 끝 출력
	$totaltime = $endtime - $starttime; 
	$totaltime = round($totaltime,3);
	echo $symbol.' ==> '.$totaltime."sec\n";
}


## 페이지 최하단 마이크로초 끝 출력
$et = microtime();
$etarray = explode(" ", $et);
$et = $etarray[1] + $etarray[0];
$tt = $et - $st; 
$tt = round($tt,3);
echo $tt."sec\n";

/*
$data[] = $_POST['data'];

$inp = file_get_contents('results.json');
$tempArray = json_decode($inp);
array_push($tempArray, $data);
$jsonData = json_encode($tempArray);
file_put_contents('results.json', $jsonData);
*/
?>