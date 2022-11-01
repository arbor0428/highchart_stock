<?
include "../class/class.DbCon.php";

$cid = trim($_POST['cid']);
$userid = trim($_POST['userid']);

if($cid && $userid){
	$tmpchk = sqlRowOne("select count(*) from ks_company_scrap where userid='$userid' and cid='$cid'");
	if($tmpchk){
		sqlExe("delete from ks_company_scrap where userid='$userid' and cid='$cid'");
	}else{

		$userip = $_SERVER['REMOTE_ADDR'];
		$rDate = date('Y-m-d H:i:s');
		$rTime = time();

		sqlExe("insert into ks_company_scrap (cid,userid,userip,rDate,rTime) values ('$cid','$userid','$userip','$rDate','$rTime')");

		echo "ok";
	}
}
?>