<?
include "/home/myss/www/module/class/class.DbCon.php";
include "/home/myss/www/module/class/class.Util.php";

$logFile = '/home/myss/www/module/cron/log/Stock_Candles_D.log';
$fp = fopen($logFile, "a");		//로그기록을 위한 파일 열기
$sLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$sLogTime ~ ");

$toDay = date('Y-m-d');
$from = strtotime("$toDay -5 day");
$to = strtotime($toDay) + 86399;

$resolution = 'D';		//ex)1, 5, 15, 30, 60, D, W, M

$row = sqlArray("select * from ks_symbol order by symbol");

$etc = Array('^GSPC','^NDX','^DJI','^RUT','^VIX','XIN9.FGI','^HSI','^STOXX50E','^N225','^NSEI');	//기타 심볼 추가
foreach($etc as $v){
	$row[]['symbol'] = $v;
}

//Earnings Estimates 3제곱근 구할때 필요한 변수
$y1 = date('Y');
$y3 = $y1 + 3;

//봉차트 Data
$jsonTime = strtotime('-20 year');

foreach($row as $k => $v){

	//Arguments
	$symbol = $v['symbol'];

	$finnhub = "https://finnhub.io/api/v1/stock/candle";
	$param = "?symbol=".$symbol."&resolution=".$resolution."&from=".$from."&to=".$to;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

	if($itemTmp){
		$resArr = Array();

		foreach($itemTmp as $key => $item){
			foreach($item as $k1 => $v1){
				$resArr[$k1][$key] = $v1;
			}
		}

		if(count($resArr) == 0){
			//심볼별 가장 최근 데이터
			sqlExe("delete from Stock_Candles_Last where symbol='".$symbol."'");	//기존 데이터 삭제
		}

		foreach($resArr as $item){

			$tmpChk = sqlRowOne("select count(*) from api_Stock_Candles_D where symbol='".$symbol."' and t='".$item['t']."'");
			if(!$tmpChk){
				$pmDataDay = 0;
				$pmDataWeek = 0;
				$pmDataMonth = 0;
				$pmDataMonth3 = 0;
				$pmDataMonth6 = 0;
				$pmDataYearFirst = 0;
				$pmDataYear1 = 0;
				$pmDataYear3 = 0;
				$pmDataYear5 = 0;
				$pmDataYear10 = 0;
				$vDataDay = 0;
				$targetMean = 0;
				$epsAvg = 0;
				$highDown = 0;

				$c = $item['c'];
				$t = $item['t'];
				$v = $item['v'];

				if($c){
					//(-1)값확인 - 전날
					$tmpRow = sqlRow("select c, v from api_Stock_Candles_D where symbol='".$symbol."' and t<".$t." order by t desc limit 1");

					$tmpC = $tmpRow['c'];
					$tmpV = $tmpRow['v'];

					//c 증감율 계산
					if($tmpC)	$pmDataDay = Util::fnPercent($tmpC,$c);

					//v 증감율 계산
					if($tmpV)		$vDataDay = Util::fnPercent($tmpV,$v);



					//(-6)값확인 - 일주일전
					$tmpData = sqlRowOne("select c from api_Stock_Candles_D where symbol='".$symbol."' and t<".$t." order by t desc limit 5, 1");
					if($tmpData)		$pmDataWeek = Util::fnPercent($tmpData,$c);

					
					//(-22)값확인 - 한달전
					$tmpData = sqlRowOne("select c from api_Stock_Candles_D where symbol='".$symbol."' and t<".$t." order by t desc limit 21, 1");
					if($tmpData)		$pmDataMonth = Util::fnPercent($tmpData,$c);


					//(-w13) - 3개월전
					$tmpData = sqlRowOne("select c from api_Stock_Candles_W where symbol='".$symbol."' and t<".$t." order by t desc limit 12, 1");
					if($tmpData)		$pmDataMonth3 = Util::fnPercent($tmpData,$c);


					//(-w26) - 6개월전
					$tmpData = sqlRowOne("select c from api_Stock_Candles_W where symbol='".$symbol."' and t<".$t." order by t desc limit 25, 1");
					if($tmpData)		$pmDataMonth6 = Util::fnPercent($tmpData,$c);

					
					//해당연도의 첫번째 값
					$year = date('Y',$t);
					$yTime = mktime(0,0,0,1,1,$year);	//해당연도의 1/1일 타입값
					$tmpData = sqlRowOne("select c from api_Stock_Candles_D where symbol='".$symbol."' and t>".$yTime." order by t asc limit 1");
					if($tmpData)		$pmDataYearFirst = Util::fnPercent($tmpData,$c);
					

					//(-w52) - 1년전
					$tmpData = sqlRowOne("select c from api_Stock_Candles_W where symbol='".$symbol."' and t<".$t." order by t desc limit 51, 1");
					if($tmpData)		$pmDataYear1 = Util::fnPercent($tmpData,$c);

					
					//(-w156) - 3년전
					$tmpData = sqlRowOne("select c from api_Stock_Candles_W where symbol='".$symbol."' and t<".$t." order by t desc limit 155, 1");
					if($tmpData)		$pmDataYear3 = Util::fnPercent($tmpData,$c);

					
					//(-w260) - 5년전
					$tmpData = sqlRowOne("select c from api_Stock_Candles_W where symbol='".$symbol."' and t<".$t." order by t desc limit 259, 1");
					if($tmpData)		$pmDataYear5 = Util::fnPercent($tmpData,$c);

					
					//(-m120) - 10년전
					$tmpData = sqlRowOne("select c from api_Stock_Candles_M where symbol='".$symbol."' and t<".$t." order by t desc limit 119, 1");
					if($tmpData)		$pmDataYear10 = Util::fnPercent($tmpData,$c);


					//Price Target Mean값과 비교
					$tmpData = sqlRowOne("select targetMean from api_Price_Target where symbol='".$symbol."' order by uid desc limit 1");
					if($tmpData)		$targetMean = Util::fnPercent($c,$tmpData);


					//Earnings Estimates 올해와 3년후 epsAvg을 비교하여 3제곱근 구하기
					$eAvg1 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$y1."-%' order by period desc limit 1");
					$eAvg3 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$y3."-%' order by period desc limit 1");

					if($eAvg1 && $eAvg3){
						$eAvg1 = round($eAvg1,2);
						$eAvg3 = round($eAvg3,2);
						$jegop = round(($eAvg3/$eAvg1),2);
						$epsAvg = (round(pow($jegop, 1/3),2) -1) * 100;
					}


					//Basic Financials 52주 최고가와 비료
					$tmpData = sqlRowOne("select WeekHigh52 from api_Basic_Financials where symbol='".$symbol."' order by uid desc limit 1");
					if($tmpData)		$highDown = Util::fnPercent($tmpData,$c);


//					echo date('Y-m-d',$item['t']).' / '.$c .' / '.$tmpData01.'('.$pmDataWeek.') / '.$tmpData02.'('.$pmDataMonth.") / ".$tmpData03.'('.$pmDataYearFirst.")";
//					echo $tmpData04.'('.$pmDataYear1.') / '.$tmpData05.'('.$pmDataYear3.") / ".$tmpData06.'('.$pmDataYear5.") / ".$t."<br><br>";

					sqlExe("insert into api_Stock_Candles_D (symbol,c,h,l,o,v,t,vDataDay,pmDataDay,pmDataWeek,pmDataMonth,pmDataMonth3,pmDataMonth6,pmDataYear1,pmDataYear3,pmDataYear5,pmDataYear10,pmDataYearFirst,targetMean,epsAvg,highDown) values ('".$symbol."','".$item['c']."','".$item['h']."','".$item['l']."','".$item['o']."','".$item['v']."','".$item['t']."','".$vDataDay."','".$pmDataDay."','".$pmDataWeek."','".$pmDataMonth."','".$pmDataMonth3."','".$pmDataMonth6."','".$pmDataYear1."','".$pmDataYear3."','".$pmDataYear5."','".$pmDataYear10."','".$pmDataYearFirst."','".$targetMean."','".$epsAvg."','".$highDown."')");

					//52주 신고가 & 신저가
					$high52 = '';
					$low52 = '';

					$wData = sqlRow("select max(c) as maxC, min(c) as minC from api_Stock_Candles_D where symbol='".$symbol."' order by t desc limit 250");

					if($item['c'] == $wData['maxC'])	$high52 = '1';
					if($item['c'] == $wData['minC'])		$low52 = '1';

					//심볼별 가장 최근 데이터
					$lastChk = sqlRowOne("select count(*) from Stock_Candles_Last where symbol='".$symbol."'");
					if($lastChk){
						$sql = "update Stock_Candles_Last set c='".$item['c']."', h='".$item['h']."', l='".$item['l']."', o='".$item['o']."', v='".$item['v']."', t='".$item['t']."', vDataDay='".$vDataDay."', pmDataDay='".$pmDataDay."', pmDataWeek='".$pmDataWeek."', pmDataMonth='".$pmDataMonth."', pmDataMonth3='".$pmDataMonth3."', pmDataMonth6='".$pmDataMonth6."', pmDataYear1='".$pmDataYear1."', pmDataYear3='".$pmDataYear3."', pmDataYear5='".$pmDataYear5."', pmDataYear10='".$pmDataYear10."', pmDataYearFirst='".$pmDataYearFirst."', targetMean='".$targetMean."', epsAvg='".$epsAvg."', highDown='".$highDown."', high52='".$high52."', low52='".$low52."' where symbol='".$symbol."'";
						sqlExe($sql);

					}else{
						sqlExe("insert into Stock_Candles_Last (symbol,c,h,l,o,v,t,vDataDay,pmDataDay,pmDataWeek,pmDataMonth,pmDataMonth3,pmDataMonth6,pmDataYear1,pmDataYear3,pmDataYear5,pmDataYear10,pmDataYearFirst,targetMean,epsAvg,highDown,high52,low52) values ('".$symbol."','".$item['c']."','".$item['h']."','".$item['l']."','".$item['o']."','".$item['v']."','".$item['t']."','".$vDataDay."','".$pmDataDay."','".$pmDataWeek."','".$pmDataMonth."','".$pmDataMonth3."','".$pmDataMonth6."','".$pmDataYear1."','".$pmDataYear3."','".$pmDataYear5."','".$pmDataYear10."','".$pmDataYearFirst."','".$targetMean."','".$epsAvg."','".$highDown."','".$high52."','".$low52."')");
					}
				}
			}
		}

		//봉차트 Data
		$jsonData = Array();
		$rowData = sqlArray("select * from api_Stock_Candles_D where symbol='".$symbol."' and t>=".$jsonTime." order by t");
		foreach($rowData as $n => $bong){
			$t = $bong['t'] * 1000;		//자바스크립트 타임값으로..
			$o = (float)$bong['o'];		//숫자형으로..
			$h = (float)$bong['h'];		//숫자형으로..
			$l = (float)$bong['l'];		//숫자형으로..
			$c = (float)$bong['c'];		//숫자형으로..
			$v = (float)$bong['v'];		//숫자형으로..

			$jsonData[$n] = Array($t,$o,$h,$l,$c,$v);
		}

		$json = json_encode($jsonData,JSON_UNESCAPED_UNICODE);
		file_put_contents("/home/myss/www/module/highcharts/".$symbol.".json", $json);

//		echo $symbol."\n";
	}
}

$eLogTime = date('Y-m-d H:i:s');
fwrite($fp, "$eLogTime \n");
fclose($fp);
?>