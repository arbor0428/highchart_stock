<?
//	$_GET['gbl_symbol'] = 'AAPL';
	$gbl_symbol = strtoupper($_REQUEST['gbl_symbol']);
	$tmpChk = sqlRowOne("select * from ks_symbol where symbol='".$gbl_symbol."'");
	if(!$tmpChk){
		Msg::backMsg('접근오류');
		exit;
	}
?>