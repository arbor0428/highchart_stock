<?
//API 목록
$finArr = Array("Symbol Lookup","Stock Symbol","Company Profile","Market News","Company News","News Sentiment","Peers","Basic Financials","Ownership","Fund Ownership","Insider Transactions","Financial Statements","SEC Filings","IPO Calendar","Dividends","Recommendation Trends","Price Target","Stock Up Down","Revenue Estimates","Earnings Estimates","Earnings Surprises","Earnings Calendar","Quote","Stock Candles","Splits","ETFs Profile","ETFs Holdings","ETFs Sector Exposure","ETFs Country Exposure","Forex rates","Technical Indicators","Indices Constituents","Revenue Breakdown","Historical Market Cap","Financials As Reported","Institutional Profile","Institutional Portfolio","Institutional Ownership","SEC Sentiment Analysis","Similarity Index","Price Metrics");
//,"Indices Constituents"

//API 호출주소
$dirArr = Array("/search","/stock/symbol","/stock/profile","/news","/company-news","/news-sentiment","/stock/peers","/stock/metric","/stock/ownership","/stock/fund-ownership","/stock/insider-transactions","/stock/financials","/stock/filings","/calendar/ipo","/stock/dividend","/stock/recommendation","/stock/price-target","/stock/upgrade-downgrade","/stock/revenue-estimate","/stock/eps-estimate","/stock/earnings","/calendar/earnings","/quote","/stock/candle","/stock/split","/etf/profile","/etf/holdings","/etf/sector","/etf/country","/forex/rates","/indicator","/index/constituents","/stock/revenue-breakdown","/stock/historical-market-cap","/stock/financials-reported","/institutional/profile","/institutional/portfolio","/institutional/ownership","/stock/filings-sentiment","/stock/similarity-index","/stock/price-metric");

$etcSymbol = Array("^GSPC"=>"S&P 500", "^NDX"=>"nasdaq 100", "^DJI"=>"Dow Jones", "^RUT"=>"Russell 2000", "^VIX"=>"VIX", "XIN9.FGI"=>"China A50", "^HSI"=>"Hang Seng", "^STOXX50E"=>"Euro Stoxx 50", "^N225"=>"Nikkei 225", "^NSEI"=>"Nifty 50");

//섹터 이름과 ETF 이름(api_Company_Profile의 gsector값에 따른 ETF)
$gsSectorEtfArr = Array("Communication Services"=>"XLC","Consumer Staples"=>"XLP","Consumer Discretionary"=>"XLY","Energy"=>"XLE","Financials"=>"XLF","Health Care"=>"XLV","Industrials"=>"XLI","Materials"=>"XLB","Real Estate"=>"XLRE","Information Technology"=>"XLK","Utilities"=>"XLU");

//상세 산업군(api_Company_Profile의 gind 값)
$gindArr = Array("Aerospace & Defense","Air Freight & Logistics","Airlines","Auto Components","Automobiles","Banks","Beverages","Biotechnology","Building Products","Capital Markets","Chemicals","Commercial Services & Supplies","Communications Equipment","Construction & Engineering","Construction Materials","Consumer Finance","Containers & Packaging","Distributors","Diversified Consumer Services","Diversified Financial Services","Diversified Telecommunication Services","Electric Utilities","Electrical Equipment","Electronic Equipment, Instruments & Components","Energy Equipment & Services","Entertainment","Equity Real Estate Investment Trusts (REITs)","Food & Staples Retailing","Food Products","Gas Utilities","Health Care Equipment & Supplies","Health Care Providers & Services","Health Care Technology","Hotels, Restaurants & Leisure","Household Durables","Household Products","Independent Power and Renewable Electricity Producers","Industrial Conglomerates","Insurance","Interactive Media & Services","Internet & Direct Marketing Retail","IT Services","Leisure Products","Life Sciences Tools & Services","Machinery","Marine","Media","Metals & Mining","Mortgage Real Estate Investment Trusts (REITs)","Multi-Utilities","Multiline Retail","Oil, Gas & Consumable Fuels","Paper & Forest Products","Personal Products","Pharmaceuticals","Professional Services","Real Estate Management & Development","Road & Rail","Semiconductors & Semiconductor Equipment","Software","Specialty Retail","Technology Hardware, Storage & Peripherals","Textiles, Apparel & Luxury Goods","Thrifts & Mortgage Finance","Tobacco","Trading Companies & Distributors","Transportation Infrastructure","Water Utilities","Wireless Telecommunication Services");

//심볼목록(datalist 용)
$slistArr = sqlArray("select s.*, c.name, c.nameKor, e.name as eftName from ks_symbol as s left join api_Company_Profile as c on s.symbol=c.symbol left join api_ETFs_Profile as e on s.symbol=e.symbol order by s.symbol");

$monthArr = Array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');


//quote API(실시간 주가) 호출(오후 22시30분 ~ 익일 오전5시)
$QuoteCall = false;

$timeChk = mktime(22,30,00,date('m'),date('d'),date('Y'));

if(date('H',$GBL_TIME) < 5 || $GBL_TIME > $timeChk){
	$QuoteCall = true;
}

//상승,하락에 따른 색상
function UpDownClass($p){
	if($p > 0)		$className = 'upClass';
	elseif($p < 0)	$className = 'downClass';
	else				$className = 'zeroClass';

	return $className;
}

function QuoteAPI($symbol){
	$finnhub = "https://finnhub.io/api/v1/quote";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$json = json_decode($req,JSON_UNESCAPED_UNICODE);
	return $json;
}

function PeerAPI($symbol){
	$finnhub = "https://finnhub.io/api/v1/stock/peers";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$json = json_decode($req,JSON_UNESCAPED_UNICODE);
	return $json;
}


function SectorExposure($symbol){
	$finnhub = "https://finnhub.io/api/v1/etf/sector";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$json = json_decode($req,JSON_UNESCAPED_UNICODE);
	return $json;
}

function CountryExposure($symbol){
	$finnhub = "https://finnhub.io/api/v1/etf/country";
	$param = "?symbol=".$symbol;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$json = json_decode($req,JSON_UNESCAPED_UNICODE);
	return $json;
}

function EarningsAPI($symbol,$limit){
	$finnhub = "https://finnhub.io/api/v1/stock/earnings";
	$param = "?symbol=".$symbol."&limit=".$limit;

	//API 호출
	include '/home/myss/www/module/apiCall.php';

	$json = json_decode($req,JSON_UNESCAPED_UNICODE);
	return $json;
}



//mdd Data
function mddData($symbol, $sTime, $eTime){
	$mddQuery = "where symbol='".$symbol."' and t>='".$sTime."' and t<='".$eTime."'";

	$pmTime = 0;	//최대낙폭일
	$pmPer = 0;	//최대낙폭
	$HighC = 0;		//기간내 최고점
	$nowPer = 0;	//고점대비 하락률
	$upPer = 0;		//상승확률(최신값(c) 보다 큰(c)값의 일수)

	$cData01 = '';		//MDD 차트 데이터(값)
	$cData01x = '';	//MDD 차트 데이터(x라벨)
	$cData02 = Array();	//전고점 대비 하락폭 별 상승확률 데이터

	$row = sqlArray("select * from api_Stock_Candles_D $mddQuery order by t asc");
	$rNum = count($row);

	foreach($row as $v){
		if($v['c'] > $HighC)	$HighC = $v['c'];

		$mddPer = Util::fnPercent($HighC,$v['c']);	//고점대비 일별 하락률

		if($pmPer > $mddPer){
			$pmTime = $v['t'];	//기간내 최대낙폭일
			$pmPer = $mddPer;	//기간내 최대낙폭
		}

		if($cData01)	$cData01 .= ',';
		$cData01 .= $mddPer;

		if($cData01x)	$cData01x .= ',';
		$cData01x .= date('Y-m-d',$v['t']);

		$mddTmp = $mddPer * -1;

		for($i=1; $i<=100; $i++){
			if($mddTmp <= $i){
				if($cData02[$i] == '')	$cData02[$i] = 0;
				$cData02[$i] += 1;
			}
		}

//		echo date('Y.m.d',$v['t']).' / '.$v['c'].' / '.$HighC.' / '.$mddPer.'<br>';
	}

	$nowC = $v['c'];		//최신값(c)

	//최고점대비 최신값(c) 하락률
	$nowPer = Util::fnPercent($HighC,$nowC);

	//상승확률(최신값(c) 보다 큰(c)값의 일수)
//	$upDay = sqlRowOne("select count(*) from api_Stock_Candles_D $mddQuery and c>='".$nowC."'");
//	$upPer = round(($upDay / $rNum) * 100,2);

	//결과값 리턴
	$res = Array();
	$res['symbol'] = $symbol;
	$res['pmTime'] = $pmTime;
	$res['pmDate'] = date('Y/m/d',$pmTime);
	$res['pmPer'] = $pmPer;
	$res['HighC'] = $HighC;
	$res['nowC'] = number_format($nowC,2);
	$res['nowPer'] = $nowPer;
//	$res['upPer'] = $upPer;
	$upPer = 0;
	$tmpPer = (round($nowPer) * -1) + 1;

	$res['cData01'] = $cData01;
	$res['cData01x'] = $cData01x;

	$max_percent = 0;

	//상승확률 그래프 데이터
	$xAxis = '';
	$i = 0;
	foreach($cData02 as $k => $v){
		$xp = round(($v / $rNum) * 100,2);

		if($xAxis)	$xAxis .= ",";
		$xAxis .= $xp;

		//최대치
		if($v == $rNum && $max_percent == 0){
			$max_percent = $k;
		}

		if($tmpPer == $k)	$upPer = $xp;

		$i++;
	}

	$res['cData02'] = $xAxis;
	$res['max_percent'] = $max_percent;
	$res['upPer'] = $upPer;

	return $res;
}

//mdd High percent(여러 심볼중 상승확률이 100%가 되는 가장 큰 하락률(mddChart02.php 를 그리기 위함))
function mddHigh($sList, $sTime, $eTime){
	$max_percent = 0;
	$sArr = explode(',',$sList);

	foreach($sArr as $s){
		$HighC = 0;		//기간내 최고점
		$mddArr = Array();

		$mddQuery = "where symbol='".$s."' and t>='".$sTime."' and t<='".$eTime."'";

		$row = sqlArray("select * from api_Stock_Candles_D $mddQuery order by t asc");
		$rNum = count($row);			

		foreach($row as $v){
			if($v['c'] > $HighC)	$HighC = $v['c'];

			$mddPer = Util::fnPercent($HighC,$v['c']);	//고점대비 일별 하락률

			$mddTmp = $mddPer * -1;

			for($i=1; $i<=100; $i++){
				if($mddTmp <= $i){
					if($mddArr[$i] == '')	$mddArr[$i] = 0;
					$mddArr[$i] += 1;
				}
			}
		}

		foreach($mddArr as $k => $v){
			if($v == $rNum){
				if($max_percent < $k){
					$max_percent = $k;
				}
				break;
			}
		}
	}

	return $max_percent;
}








//Recommendation Data
function recomData($symbol){
	$res = '';

	$row = sqlRow("select r.*, p.name from api_Recommendation_Trends as r left join api_Company_Profile as p on r.symbol=p.symbol where r.symbol='".$symbol."' order by r.periodTime desc limit 1");

	if($row){
		$period = $row["period"];
		$strongSell = $row["strongSell"];		//강력매도
		$sell = $row["sell"];						//매도
		$hold = $row["hold"];					//중립
		$buy = $row["buy"];						//매수
		$strongBuy = $row["strongBuy"];	//강력매수
		$name = $row["name"];					//회사명

		$totNum = $strongSell + $sell + $hold + $buy + $strongBuy;

		$strongSellScore = round((1 * $strongSell) / $totNum,2);
		$sellScore = round((2 * $sell) / $totNum,2);
		$holdScore = round((3 * $hold) / $totNum,2);
		$buyScore = round((4 * $buy) / $totNum,2);
		$strongBuyScore = round((5 * $strongBuy) / $totNum,2);

		$totScore = $strongSellScore + $sellScore + $holdScore + $buyScore + $strongBuyScore;

		if($totScore < 1.5){
			$investment = '강력매도';
			$investmentEng = 'strongSell';
			$investmentColor = '#ff6384';

		}elseif($totScore < 2.5){
			$investment = '매도';
			$investmentEng = 'Sell';
			$investmentColor = '#ff9f40';

		}elseif($totScore < 3.5){
			$investment = '중립';
			$investmentEng = 'Hold';
			$investmentColor = '#ffcd56';

		}elseif($totScore < 4.5){
			$investment = '매수';
			$investmentEng = 'Buy';
			$investmentColor = '#4bc0c0';

		}else{
			$investment = '강력매수';
			$investmentEng = 'strongBuy';
			$investmentColor = '#36a2eb';
		}

		//상태별 퍼센트 구하기
		$pArr = Array();
		$pArr['strongSell'] = round(($strongSell / $totNum) * 100);
		$pArr['sell'] = round(($sell / $totNum) * 100);
		$pArr['hold'] = round(($hold / $totNum) * 100);
		$pArr['buy'] = round(($buy / $totNum) * 100);
		$pArr['strongBuy'] = round(($strongBuy / $totNum) * 100);

		$pieColor = Array();		//	'#ff6384','#ff9f40','#ffcd56','#4bc0c0','#36a2eb'
		$pieData = Array();

		//값이 있는 데이터만 그래프에 표기해야한다.
		$i = 0;
		foreach($pArr as $k => $v){
			if($v > 0){

				if($k == 'strongSell'){
					$pieColor[$i] = "#ff6384";
					$pieData[$i] = Array("강력매도(".$strongSell."명)",$v);

				}elseif($k == 'sell'){
					$pieColor[$i] = "#ff9f40";
					$pieData[$i] = Array("매도(".$sell."명)",$v);

				}elseif($k == 'hold'){
					$pieColor[$i] = "#ffcd56";
					$pieData[$i] = Array("중립(".$hold."명)",$v);

				}elseif($k == 'buy'){
					$pieColor[$i] = "#4bc0c0";
					$pieData[$i] = Array("매수(".$buy."명)",$v);

				}elseif($k == 'strongBuy'){
					$pieColor[$i] = "#36a2eb";
					$pieData[$i] = Array("강력매수(".$strongBuy."명)",$v);
				}

				$i++;
			}
		}


		$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$symbol."' order by uid desc limit 1");
		$row = sqlRow("select * from api_Price_Target where symbol='".$symbol."' order by lastUpdatedTime desc limit 1");
		$targetMean = $row['targetMean'];
		$targetHigh = $row['targetHigh'];
		$targetLow = $row['targetLow'];

		$targetPer = Util::fnPercent($nowC,$targetMean);	//Price_Target의 평균값과 Stock_Candles_D의 최신 c값



		//그래프 데이터(graph10.php)
		$row = sqlArray("select * from api_Price_Target where symbol='".$symbol."' order by lastUpdatedTime desc limit 12");
		$rNum = count($row);

		$cateArr = Array();	//x축
		$dataArr = Array();	//Average
		$LowArr = Array();		//Lowest(마지막 2개값만 표시)
		$HighArr = Array();	//Highest(마지막 2개값만 표시)

		$i = 1;
		foreach($row as $v){
		//	echo $i.' / '.$v['lastUpdated'].' / '.$v['targetMean'].'<Br>';

			$monthTxt = date('M',$v['lastUpdatedTime']);	//월 영문표기(Jan, Feb..)
			$cateArr[$i] = $monthTxt;

			$dataArr[$i] = $v['targetMean'];

			//마지막값은 최저값, 최대값을 표시
			if($i == 1){
				$LowData = $v['targetLow'];
				$HighData = $v['targetHigh'];

			//마지막에서 2번째값은 평균값으로 표시
			}elseif($i == 2){
				$LowData = $v['targetMean'];
				$HighData = $v['targetMean'];

			//그외에는 null 처리(평균값만 그래프에 표시)
			}else{
				$LowData = "null";
				$HighData = "null";
			}

			$LowArr[$i] = $LowData;
			$HighArr[$i] = $HighData;

			$i++;
		}

		//결과값 리턴
		$res = Array();
		$res['symbol'] = $symbol;
		$res['period'] = $period;
		$res['strongSell'] = $strongSell;
		$res['sell'] = $sell;
		$res['hold'] = $hold;
		$res['buy'] = $buy;
		$res['strongBuy'] = $strongBuy;
		$res['name'] = $name;
		$res['totNum'] = $totNum;
		$res['strongSellScore'] = $strongSellScore;
		$res['sellScore'] = $sellScore;
		$res['holdScore'] = $holdScore;
		$res['buyScore'] = $buyScore;
		$res['strongBuyScore'] = $strongBuyScore;
		$res['totScore'] = $totScore;
		$res['investment'] = $investment;
		$res['investmentEng'] = $investmentEng;
		$res['investmentColor'] = $investmentColor;
		$res['pieColor'] = $pieColor;
		$res['pieData'] = $pieData;

		$res['targetMean'] = $targetMean;
		$res['targetHigh'] = $targetHigh;
		$res['targetLow'] = $targetLow;
		$res['targetPer'] = $targetPer;

		//최신순으로 데이터를 불러왔기 때문에 출력은 역순(오래된순)으로 정렬한다
		$cateArr = array_reverse($cateArr);
		$dataArr = array_reverse($dataArr);
		$LowArr = array_reverse($LowArr);
		$HighArr = array_reverse($HighArr);

		$cateList = '';
		$dataList = '';
		$LowList = '';
		$HighList = '';

		foreach($cateArr as $k => $v){
			if($cateList)		$cateList .= ",";
			$cateList .= "'".$cateArr[$k]."'";

			if($dataList)		$dataList .= ",";
			$dataList .= $dataArr[$k];

			if($LowList)		$LowList .= ",";
			$LowList .= $LowArr[$k];

			if($HighList)		$HighList .= ",";
			$HighList .= $HighArr[$k];
		}

		$res['cateList'] = $cateList;
		$res['dataList'] = $dataList;
		$res['LowList'] = $LowList;
		$res['HighList'] = $HighList;
	}

	return $res;
}








//P&L Data
function pnlData($symbol, $sTime, $eTime){
	$stockQuery = "and t>='".$sTime."' and t<='".$eTime."'";

	//기간내 첫번째값
	$firstC = sqlRowOne("select c from api_Stock_Candles_D where symbol='".$symbol."' and t>='".$sTime."' order by t asc limit 1");

	//기간내 마지막값
	$lastC = sqlRowOne("select c from api_Stock_Candles_D where symbol='".$symbol."' and t<='".$eTime."' order by t desc limit 1");

	//수익률
	$pnlPer = number_format(Util::fnPercent($firstC,$lastC),2);

	$cData = Array();

	$row = sqlArray("select * from api_Stock_Candles_D where symbol='".$symbol."' $stockQuery order by t");
	foreach($row as $v){
		$k = date('Y-m-d',$v['t']);
		$pnl = Util::fnPercent($firstC,$v['c']);	//첫번째값 대비 %
		$cData[$k] = $pnl;
	}

	//결과값 리턴
	$res = Array();
	$res['pnlPer'] = $pnlPer;
	$res['cData'] = $cData;

	return $res;
}






//종목 EPS GROWTH
function eps_growth($symbol,$thisYear){
/*
	Earnings Estimates -> annual -> epsAvg 값사용
	EPS growth 2023 = 2023값 / 2022값 -1 을퍼센트로표현
	2024 2025 2026 전부마찬가지
*/
	$lastYear = $thisYear - 1;

	$epsAvg01 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");
	$epsAvg02 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$lastYear."-%' order by periodTime desc limit 1");

	$res = (($epsAvg01 / $epsAvg02) - 1) * 100;

	return $res;
}


//종목 P/E (12M Fwd)
function pne_fwd($symbol){
/*
	분자 : stock candles D 의최신C 값
	분모 : Earnings Estimates -> annual -> epsAvg 값내년수치 (올해가 2022면 2023 사용)
*/
	$chkYear = date('Y') + 1;

	$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$symbol."'");
	$epsAvg = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$chkYear."-%' order by periodTime desc limit 1");

	$res = $nowC / $epsAvg;

	return $res;
}


//종목 PEG Ratio (12M Fwd)
function peg_ratio($symbol){
/*
	분자 : P/E (12M Fwd)
	분모 : ((Earnings Estimates -> 2023년값 / Earnings Estimates -> 2022년 값)-1 )* 100 (퍼센트값에 *100을한다. 예:63% 면 0.63 이아니라 63 으로계산)
*/
	$thisYear = date('Y');
	$lastYear = $thisYear - 1;

	$epsAvg01 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");
	$epsAvg02 = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$lastYear."-%' order by periodTime desc limit 1");

	$bz = pne_fwd($symbol);
	$bm = (($epsAvg01 / $epsAvg02) - 1) * 100;

	$res = $bz / $bm;

	return $res;
}


//종목 P/S (12M Fwd)
function pns_fwd($symbol){
/*
	분자 : stock candles D 의최신C 값
	분모 : Revenue Estimates -> annual ->revenueAvg 의내년값 / 발행주식수 (Company Profile->shareOutstanding)
*/
	$chkYear = date('Y') + 1;

	$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$symbol."'");
	$revenueAvg = sqlRowOne("select revenueAvg from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$chkYear."-%' order by periodTime desc limit 1");
	$shareOutstanding = sqlRowOne("select shareOutstanding from api_Company_Profile where symbol='".$symbol."'");

	$bm = $revenueAvg / $shareOutstanding;

	$tmp = $nowC / $bm;
	$tmpArr = explode('.',$tmp);
	$res = $tmpArr[0] + (substr($tmpArr[1],0,3) / 1000);	//무한소수점이 나오기 때문에 소수점 3자리까지만 가져옴

	return $res;
}


//종목 PSG Ratio (12M Fwd)
function psg_ratio($symbol){
/*
	분자 : P/S (12M Fwd)
	분모 : (Revenue Estimates -> annual ->revenueAvg 의내년값 / Revenue Estimates -> annual ->revenueAvg 의올해값)-1 * 100
*/
	$thisYear = date('Y');
	$nextYear = $thisYear + 1;

	$revenueAvg01 = sqlRowOne("select revenueAvg from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$nextYear."-%' order by periodTime desc limit 1");
	$revenueAvg02 = sqlRowOne("select revenueAvg from api_Revenue_Estimates where symbol='".$symbol."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");

	$bz = pns_fwd($symbol);
	$bm = (($revenueAvg01 / $revenueAvg02) - 1) * 100;

	$res = $bz / $bm;

	return $res;
}
?>