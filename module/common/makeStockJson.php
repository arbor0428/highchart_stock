<?
exit;
include '../class/class.DbCon.php';


## ������ �ֻ�� ����ũ���� ����
$st = microtime();
$starray = explode(" ", $st);
$st = $starray[1] + $starray[0];




$symbol = 'AAPL';
$sTime = strtotime('-20 year');

$item = sqlArray("select * from ks_symbol order by symbol");

foreach($item as $s){
	$data = Array();
	$symbol = $s['symbol'];

	## ������ �ֻ�� ����ũ���� ����
	$starttime = microtime();
	$startarray = explode(" ", $starttime);
	$starttime = $startarray[1] + $startarray[0];

	$row = sqlArray("select * from api_Stock_Candles_D where symbol='".$symbol."' and t>=".$sTime." order by t");
	foreach($row as $k => $item){
		$endtime = microtime();
		$endarray = explode(" ", $endtime);
		$endtime = $endarray[1] + $endarray[0];

	//	echo date('Y-m-d',$item['t']).' / '.$item['v'].'<br>';

		$t = $item['t'] * 1000;		//�ڹٽ�ũ��Ʈ Ÿ�Ӱ�����..
		$o = (float)$item['o'];		//����������..
		$h = (float)$item['h'];		//����������..
		$l = (float)$item['l'];		//����������..
		$c = (float)$item['c'];		//����������..
		$v = (float)$item['v'];		//����������..

		$data[$k] = Array($t,$o,$h,$l,$c,$v);
	}

	$json = json_encode($data,JSON_UNESCAPED_UNICODE);
	file_put_contents("/home/myss/www/module/highcharts/".$symbol.".json", $json);

	## ������ ���ϴ� ����ũ���� �� ���
	$totaltime = $endtime - $starttime; 
	$totaltime = round($totaltime,3);
	echo $symbol.' ==> '.$totaltime."sec\n";
}


## ������ ���ϴ� ����ũ���� �� ���
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