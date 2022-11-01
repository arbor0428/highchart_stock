<?
include "/home/myss/www/module/class/class.DbCon.php";

$logFile = '/home/myss/www/module/cron/log/Company_Profile.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

//통화별 금액
$qArr = Array();
$row = sqlArray("select * from api_Forex_rates");
foreach($row as $v){
	$qArr[$v['base']] = $v['q'];
}

$row = sqlArray("select * from ks_symbol where etf='N' order by symbol");

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/profile";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';


	$item = json_decode($req,JSON_UNESCAPED_UNICODE);
	if($item){
		foreach($item as $k1 => $v1){
			${$k1} = addslashes($v1);
		}

		//넘어오는 값에 엔터키가 포함되어있음.
		if(strpos($gind, "Mortgage Real") !== false){
			$gind = "Mortgage Real Estate Investment Trusts (REITs)";
		}

		//한글원본
		$descriptionKor = sqlRowOne("select descriptionKor from Company_Profile_kor where symbol='".$symbol."'");

		//정규직 직원 수 데이터 변환
		preg_match('/currently employs (.*?) full-time/',$description,$match);

		$repA = number_format($match[1]);
		$descriptionKor = str_replace('#C',$repA,$descriptionKor);
		$descriptionKor = addslashes($descriptionKor);

		$marketAPI = $marketCapitalization;

		//시가총액 통화변환
		if($currency != 'USD'){
			$q = $qArr[$currency];
			if($q){
				$marketCapitalization = $marketCapitalization / $q;
			}
		}

		$row = sqlRow("select * from api_Company_Profile where symbol='".$symbol."'");
		if($row){
			sqlExe("update api_Company_Profile set address='".$address."', city='".$city."', country='".$country."', currency='".$currency."', cusip='".$cusip."', description='".$description."', descriptionKor='".$descriptionKor."', employeeTotal='".$employeeTotal."', estimateCurrency='".$estimateCurrency."', exchange='".$exchange."', finnhubIndustry='".$finnhubIndustry."', floatingShare='".$floatingShare."', ggroup='".$ggroup."', gind='".$gind."', gsector='".$gsector."', gsubind='".$gsubind."', ipo='".$ipo."', isin='".$isin."', logo='".$logo."', marketCapitalization='".$marketCapitalization."', marketAPI='".$marketAPI."', naics='".$naics."', naicsNationalIndustry='".$naicsNationalIndustry."', naicsSector='".$naicsSector."', naicsSubsector='".$naicsSubsector."', name='".$name."', phone='".$phone."', sedol='".$sedol."', shareOutstanding='".$shareOutstanding."', state='".$state."', ticker='".$ticker."', usShare='".$usShare."', weburl='".$weburl."' where symbol='".$symbol."'");

		}else{
			$sql = "insert into api_Company_Profile (symbol,address,city,country,currency,cusip,description,descriptionKor,employeeTotal,estimateCurrency,exchange,finnhubIndustry,floatingShare,ggroup,gind,gsector,gsubind,ipo,isin,logo,marketCapitalization,marketAPI,naics,naicsNationalIndustry,naicsSector,naicsSubsector,name,phone,sedol,shareOutstanding,state,ticker,usShare,weburl) values ('".$symbol."','".$address."','".$city."','".$country."','".$currency."','".$cusip."','".$description."','".$descriptionKor."','".$employeeTotal."','".$estimateCurrency."','".$exchange."','".$finnhubIndustry."','".$floatingShare."','".$ggroup."','".$gind."','".$gsector."','".$gsubind."','".$ipo."','".$isin."','".$logo."','".$marketCapitalization."','".$marketAPI."','".$naics."','".$naicsNationalIndustry."','".$naicsSector."','".$naicsSubsector."','".$name."','".$phone."','".$sedol."','".$shareOutstanding."','".$state."','".$ticker."','".$usShare."','".$weburl."')";

			sqlExe($sql);
		}
	}

//	echo $symbol."\n";
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>