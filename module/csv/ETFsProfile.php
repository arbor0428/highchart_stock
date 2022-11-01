<?
include '../class/class.DbCon.php';

// 파일명 지정
$filename = "ETFsProfile.csv";

header('Content-Type:text/css;charset=utf-8;');
header('Expires: 0');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: private, no-transform, no-store, must-revalidate');
header("Content-disposition: attachment; filename=" . $filename);

// 컬럼명
$aTitles = Array("symbol","assetClass","aum","avgVolume","cusip","description","domicile","etfCompany","expenseRatio","inceptionDate","inceptionDateTime","investmentSegment","isin","name","nav","navCurrency","priceToBook","priceToEarnings","trackingIndex","website","2x","3x","inverse");

$csvData = implode(",", $aTitles);

$row = sqlArray("select * from api_ETFs_Profile order by symbol");

foreach($row as $v){
	$csvData .= "\r\n";	// 줄바꿈

	$i = 0;
	foreach($aTitles as $t){
		$txt = str_replace(',','',strip_tags($v[$t]));
		$txt = preg_replace('/\r\n|\r|\n/','',$txt);

		if($i > 0)		$csvData .= ",";
		$csvData .= $txt;

		$i++;		
	}	
}

echo $csvData;
?>