<?
include '../class/class.DbCon.php';

// 파일명 지정
$filename = "sector13.csv";

header('Content-Type:text/css;charset=utf-8;');
header('Expires: 0');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: private, no-transform, no-store, must-revalidate');
header("Content-disposition: attachment; filename=" . $filename);

// 컬럼명
$aTitles = Array("symbol","operatingMarginTTM","revenue");

$csvData = implode(",", $aTitles);


$gsector = 'Information Technology';

$item = sqlArray("select * from api_Company_Profile where gsector='".$gsector."' order by symbol asc");

$bz13 = 0;
$bm13 = 0;

foreach($item as $v){
	$symbol = $v['symbol'];
	$marketCapAll += $v['marketCapitalization'];

	$bfs = sqlRow("select * from api_Basic_Financials where symbol='".$symbol."'");
	$fsit1th = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$symbol."' order by period desc limit 1");

	$bz13 += ($bfs['operatingMarginTTM'] * $fsit1th['revenue']);
	$bm13 += $fsit1th['revenue'];

	$csvData .= "\r\n";	// 줄바꿈
	$csvData .= $symbol.",".$bfs['operatingMarginTTM'].",".$fsit1th['revenue'];
}

echo $csvData;
?>