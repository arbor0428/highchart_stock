<?
include './class/class.DbCon.php';
include 'lib.php';

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


//echo eps_growth('AAPL','2023').'<br>';
//echo pne_fwd('AAPL').'<br>';
//echo peg_ratio('AAPL').'<br>';
//echo pns_fwd('AAPL').'<br>';
//echo psg_ratio('AAPL').'<br>';
?>