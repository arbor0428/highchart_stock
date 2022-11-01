<?
include "../class/class.DbCon.php";

$rid = trim($_POST['rid']);
$userid = trim($_POST['userid']);

if($rid && $userid){
	$tmpchk = sqlRowOne("select count(*) from ks_recruit_scrap where userid='$userid' and rid='$rid'");
	if($tmpchk){
		sqlExe("delete from ks_recruit_scrap where userid='$userid' and rid='$rid'");
	}else{

		$userip = $_SERVER['REMOTE_ADDR'];
		$rDate = date('Y-m-d H:i:s');
		$rTime = time();

		sqlExe("insert into ks_recruit_scrap (rid,userid,userip,rDate,rTime) values ('$rid','$userid','$userip','$rDate','$rTime')");

		echo "ok";
	}
}
?>