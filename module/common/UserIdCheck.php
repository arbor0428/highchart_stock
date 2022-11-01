<?
	include '../class/class.DbCon.php';

	if($userid == 'admin'){
		$cnt = '100';

	}else{
		$cnt = sqlRowOne("select count(*) from tb_member where userid='$userid'");
	}

	echo $cnt;
?>