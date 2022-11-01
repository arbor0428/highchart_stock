<?
include '../class/class.DbCon.php';
include '../class/class.Util.php';
include '../lib.php';

/* 호출페이지
/www/snp_pnl.php
*/

$res = Array();
$res['code'] = '100';	//에러

$symbol = str_replace(' ','',strtoupper($_POST['symbol']));

if($symbol){
	$tmpChk = sqlRowOne("select count(*) from ks_symbol where symbol='".$symbol."'");

	if(!$tmpChk){
		$res['code'] = '101';	//데이터가 없는 심볼

	}else{	

		$finnhub = "https://finnhub.io/api/v1/stock/insider-transactions";
		$param = "?symbol=".$symbol."&from=".$_POST['sDate']."&to=".$_POST['eDate'];

		//API 호출
		include '../apiCall.php';

		$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

		$totCnt = count($itemTmp['data']);

		if($totCnt){
			$k = 0;
			$result = $itemTmp['data'];
			foreach($result as $item){
				$transactionPrice = $item['transactionPrice'];		//거래평단가
				if($transactionPrice > 0){
					$tradePrice = $item['change'] * $transactionPrice;		//거래금액
/*
					$marketCapitalization = sqlRowOne("select marketCapitalization from api_Company_Profile where symbol='".$item['symbol']."'");
					$marper = round(($tradePrice / $marketCapitalization) / 1000000, 2);
					if($marper == -0)	$marper = 0;
*/

					$res['insider'][$k]['name'] = $item['name'];		//내부자명
					$res['insider'][$k]['symbol'] = $item['symbol'];		//회사이름(티커)
					$res['insider'][$k]['share'] = number_format($item['share']);		//보유주식수
					$res['insider'][$k]['change'] = number_format($item['change']);	//변화량
					$res['insider'][$k]['transactionDate'] = $item['transactionDate'];				//거래날짜
					$res['insider'][$k]['transactionPrice'] = Util::NumberSet($transactionPrice);	//거래평단가
					$res['insider'][$k]['tradePrice'] = number_format($tradePrice);				//거래금액
//					$res['insider'][$k]['marper'] = $marper.'%';		//시총대비 거래액
					$k++;
				}
			}
		}

		$res['symbol'] = $symbol;
		$res['code'] = '99';
	}
}

$json = json_encode($res);
echo $json;
?>