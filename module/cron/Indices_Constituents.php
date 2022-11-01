<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/indices-constituents.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

//$row = Array("^GSPC"=>"S&P 500","^NDX"=>"나스닥 100","^DJI"=>"Dow Jones Industrial Average","^SP500-50"=>"S&P Communication Services Select Sector","^SP500-25"=>"S&P Consumer Discretionary Select Sector","^SP500-30"=>"S&P Consumer Staples Select Sector","^GSPE"=>"S&P Energy Select Sector","^SP500-40"=>"S&P Financial Select Sector","^SP500-35"=>"S&P Health Care Select Sector","^SP500-20"=>"S&P Industrial Select Sector","^SP500-15"=>"S&P Materials Select Sector","^SP500-60"=>"S&P Real Estate Select Sector","^SP500-45"=>"S&P Technology Select Sector","^SP500-55"=>"S&P Utilities Select Sector","^MID"=>"S&P Mid-Cap 400","^SP600"=>"S&P SmallCap 600","^OEX"=>"S&P 100","^RUI"=>"Russell 1000","^RUT"=>"Russell 2000","^R25I"=>"Russell 2500","^RUA"=>"Russell 3000","^RUMIC"=>"Russell Microcap","^RMCC"=>"Russell Midcap","^RT200"=>"Russell Top 200","^NDUEEGF"=>"MSCI Emerging Market","^NR736471"=>"MSCI Frontier and Select EM","^NDUEACWF"=>"MSCI All Country World (ACWI)","^NDDUEAFE"=>"MSCI EAFE Index","^M7CN"=>"MSCI China Index","^NDDUEMU"=>"MSCI Europe","^STOXX50E"=>"Euro Stoxx 50","^STOXX"=>"Euro Stoxx 600","^GDAXI"=>"DAX","^AXJO"=>"S&P/ASX 200","TX60.TS"=>"S&P/TSX 60","^FTSE"=>"FTSE 100");

$row = Array("^GSPC"=>"S&P 500","^NDX"=>"나스닥 100","^DJI"=>"Dow Jones Industrial Average","^RUT"=>"Russell 2000");

foreach($row as $k => $v){

	$finnhub = "https://finnhub.io/api/v1/index/constituents";
	$param = "?symbol=".$k;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	$item = $itemTmp['constituents'];
	$symbol = $itemTmp['symbol'];

	if($symbol){
		//기존 데이터 삭제
		sqlExe("delete from api_Indices_Constituents where symbol='".$k."'");

		foreach($item as $s){
			sqlExe("insert into api_Indices_Constituents (symbol,name,stxt) values ('".$k."','".$v."','".$s."')");
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>