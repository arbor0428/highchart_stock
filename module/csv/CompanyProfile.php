<?
exit;
include '../class/class.DbCon.php';

// 파일명 지정
$filename = "CompanyProfile.csv";

header('Content-Type:text/css;charset=utf-8;');
header('Expires: 0');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: private, no-transform, no-store, must-revalidate');
header("Content-disposition: attachment; filename=" . $filename);

// 컬럼명
$aTitles = Array("symbol","address","city","country","currency","cusip","description","employeeTotal","exchange","finnhubIndustry","floatingShare","ggroup","gind","gsector","gsubind","ipo","isin","logo","marketCapitalization","naics","naicsNationalIndustry","naicsSector","naicsSubsector","name","phone","sedol","shareOutstanding","state","ticker","usShare","weburl");

$csvData = implode(",", $aTitles);

$row = sqlArray("select * from api_Company_Profile order by symbol");

foreach($row as $v){
	$csvData .= "\r\n";	// 줄바꿈

	$i = 0;
	foreach($aTitles as $t){
		$txt = str_replace(',','',$v[$t]);

		if($i > 0)		$csvData .= ",";
		$csvData .= $txt;

		$i++;		
	}	
}

echo $csvData;
?>