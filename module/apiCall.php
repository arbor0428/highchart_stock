<?
$token = 'c7fe82qad3if3foduhj0';

$param .= "&token=".$token;

$url = $finnhub.$param;

if($_SERVER['REMOTE_ADDR'] == '106.246.92.237'){
	$pathArr = explode("/",$_SERVER['PHP_SELF']);
	if($pathArr[1] == 'adm' && $pathArr[3] != 'pop'){
		echo $url.'<br>';
	}
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$req = curl_exec($curl);
curl_close($curl);


/*
$itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);

echo "count : ".$itemTmp['count'].'<br><br>';
if($itemTmp['count']){
	$item = $itemTmp['result'];

	foreach($item as $k1 => $items){
		foreach($items as $k2 => $v2){
			echo $k2.' : '.$v2.'<br>';
		}
		echo '<br>';
	}
}

exit;
*/
?>