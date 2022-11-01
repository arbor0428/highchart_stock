<?
	include './class/class.DbCon.php';

	//지역
	$sql = "select distinct(loc02) from locArea where loc01='$c1' order by loc02";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);

	$loc02List = Array();

	for($i=0; $i<$num; $i++){
		$row = mysql_fetch_array($result);
		$loc02 = $row['loc02'];

		$loc02List[$i] = urlencode($loc02);
	}

	$json = json_encode($loc02List);
	echo $json;
?>