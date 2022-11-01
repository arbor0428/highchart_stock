<?
	include './class/class.DbCon.php';

	$c1 = $_POST['c1'];

	$res = Array();

	$item = sqlArray("select * from ks_job_cade02 where cade01='$c1' order by sort");
	foreach($item as $k => $v){
		$res[] = urlencode($v['cade02']);
	}

	$json = json_encode($res);
	echo $json;
?>