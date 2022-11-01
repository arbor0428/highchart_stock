<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/ETFs_Profile.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$row = sqlArray("select * from ks_symbol where etf='Y' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/etf/profile";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$result = $itemTmp['profile'];
		$assetClass = '';
		foreach($result as $k1 => $v1){
			${$k1} = addslashes($v1);
		}

		if($assetClass){
			$inceptionDateTime = strtotime($inceptionDate);

			//한글원본
			$descriptionKor = sqlRowOne("select descriptionKor from ETFs_Profile_kor where symbol='".$symbol."'");

			//운용자산 데이터 변환
			preg_match('/The ETF currently has (.*?) in AUM/',$description,$match);
			$repA = str_replace('m','',$match[1]);
			$repA = round(($repA / 100),2).'억 달러';

			$descriptionKor = str_replace('#A ',$repA,$descriptionKor);

			//보유주식 데이터 변환
			preg_match('/in AUM and (.*?) holdings./',$description,$match);
			$repB = $match[1];

			$descriptionKor = str_replace('#B',$repB,$descriptionKor);
			$descriptionKor = addslashes($descriptionKor);

			$row = sqlRow("select * from api_ETFs_Profile where symbol='".$symbol."'");
			if($row){
				sqlExe("update api_ETFs_Profile set assetClass='".$assetClass."', aum='".$aum."', avgVolume='".$avgVolume."', cusip='".$cusip."', description='".$description."', descriptionKor='".$descriptionKor."', domicile='".$domicile."', etfCompany='".$etfCompany."', expenseRatio='".$expenseRatio."', inceptionDate='".$inceptionDate."', inceptionDateTime='".$inceptionDateTime."', investmentSegment='".$investmentSegment."', isin='".$isin."', name='".$name."', nav='".$nav."', navCurrency='".$navCurrency."', priceToBook='".$priceToBook."', priceToEarnings='".$priceToEarnings."', trackingIndex='".$trackingIndex."', website='".$website."' where symbol='".$symbol."'");

			}else{
				$sql = "insert into api_ETFs_Profile (symbol,assetClass,aum,avgVolume,cusip,description,descriptionKor,domicile,etfCompany,expenseRatio,inceptionDate,inceptionDateTime,investmentSegment,isin,name,nav,navCurrency,priceToBook,priceToEarnings,trackingIndex,website) values  ('".$symbol."','".$assetClass."','".$aum."','".$avgVolume."','".$cusip."','".$description."','".$descriptionKor."','".$domicile."','".$etfCompany."','".$expenseRatio."','".$inceptionDate."','".$inceptionDateTime."','".$investmentSegment."','".$isin."','".$name."','".$nav."','".$navCurrency."','".$priceToBook."','".$priceToEarnings."','".$trackingIndex."','".$website."')";
				sqlExe($sql);
			}
		}
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>