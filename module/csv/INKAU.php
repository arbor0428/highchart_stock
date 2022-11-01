<?
exit;
include '../class/class.DbCon.php';

// 파일명 지정
$filename = "INKAU.csv";

header('Content-Type:text/css;charset=utf-8;');
header('Expires: 0');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: private, no-transform, no-store, must-revalidate');
header("Content-disposition: attachment; filename=" . $filename);

$sTime = strtotime('2022-06-01');
$eTime = strtotime('2022-06-30')+86399;

// 컬럼명
$aTitles = Array("symbol","c","h","l","o","v","date");

$csvData = implode(",", $aTitles);

$row = sqlArray("select * from api_Stock_Candles_D where symbol='INKAU' and t>=$sTime and t<=$eTime order by t");

$i = 0;

foreach($row as $v){
	$csvData .= "\r\n";	// 줄바꿈

	$csvData .= $v['symbol'].",".$v['c'].",".$v['h'].",".$v['l'].",".$v['o'].",".$v['v'].",".date('Y-m-d',$v['t']);

	$i++;
}

echo $csvData;
?>