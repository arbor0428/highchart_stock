<?
include '../class/class.DbCon.php';
include '../class/class.Util.php';
include '../lib.php';

$res = Array();
$res['code'] = '100';	//에러

$sList = str_replace(' ','',strtoupper($_POST['sList']));
$sTime = strtotime($_POST['sDate']);
$eTime = strtotime($_POST['eDate']);

if($sList){
	$res['code'] = '99';
	$res['max_percent'] = mddHigh($sList, $sTime, $eTime);
}

$json = json_encode($res);
echo $json;
?>