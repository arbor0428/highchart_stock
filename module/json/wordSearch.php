<?
include '../class/class.DbCon.php';
include '../class/class.Util.php';
include '../lib.php';

$res = Array();
$res['code'] = '100';	//에러
$res['url'] = '';

$gbl_word = str_replace(' ','',strtoupper($_POST['gbl_word']));

if($gbl_word){

	//심볼 검색
	$row = sqlRow("select * from ks_symbol where symbol='".$gbl_word."'");

	if(!$row){
		//상호명(영문) 검색
		$row = sqlRow("select s.* from ks_symbol as s left join api_Company_Profile as c on s.symbol=c.symbol where replace(c.name, ' ', '') like '%".$gbl_word."%' order by s.symbol asc limit 1");

		if(!$row){
			//상호명(국문) 검색
			$row = sqlRow("select s.* from ks_symbol as s left join api_Company_Profile as c on s.symbol=c.symbol where replace(c.nameKor, ' ', '') like '%".$gbl_word."%' order by s.symbol asc limit 1");
		}
	}

	if($row){
		$res['code'] = '99';

		if($row['etf'] == 'N'){
			$res['url'] = '/sub06/sub01.php?gbl_symbol='.$row['symbol'];

		}elseif($row['etf'] == 'Y'){
			$res['url'] = '/sub07/sub01.php?gbl_symbol='.$row['symbol'];
		}
	}else{
		$res['code'] = '101';
	}
}

$json = json_encode($res);
echo $json;
?>