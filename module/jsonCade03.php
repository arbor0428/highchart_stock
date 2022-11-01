<?
	include './class/class.DbCon.php';

	$c1 = $_POST['c1'];
	$c2 = $_POST['c2'];

	$res = Array();

	$item = sqlArray("select * from ks_job_cade03 where cade01='$c1' and cade02='$c2' order by sort");
	foreach($item as $k => $v){
		$res[] = urlencode($v['cade03']);
	}

	$json = json_encode($res);
	echo $json;
?>