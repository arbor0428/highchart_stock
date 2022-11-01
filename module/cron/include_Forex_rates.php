<?
$finnhub = "https://finnhub.io/api/v1/forex/rates";
$param = "?base=USD";

//API 호출
include '/home/myss/www/module/apiCall.php';

$item = json_decode($req,JSON_UNESCAPED_UNICODE);

if($item){
	//기존자료삭제
	sqlExe("delete from api_Forex_rates");

	$rDate = date('Y-m-d H:i:s');
	$rTime = time();

	$row = $item['quote'];

	foreach($row as $k => $v){
		sqlExe("insert into api_Forex_rates (base,q,rDate,rTime) values ('".$k."','".$v."','".$rDate."','".$rTime."')");
	}
}
?>