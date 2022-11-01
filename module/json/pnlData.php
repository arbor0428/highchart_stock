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
		//snp500, nasdaq등 기타 종목 10개인지 확인
		if(array_key_exists($symbol,$etcSymbol)){
			$tmpChk = true;
		}
	}

	if(!$tmpChk){
		$res['code'] = '101';	//데이터가 없는 심볼

	}else{	
		$sTime = strtotime($_POST['sDate']);
		$eTime = strtotime($_POST['eDate']);

		$res = pnlData($symbol, $sTime, $eTime);
		$res['symbol'] = $symbol;
		$res['code'] = '99';
	}
}

$json = json_encode($res);
echo $json;
?>