<?
include "../module/class/class.DbCon.php";
include "../module/class/class.Msg.php";
include "../module/class/class.Util.php";

$_POST = sql_injection($_POST);

$userid = trim($_POST['mem_id']);
$name = trim($_POST['mem_name']);
$type = trim($_POST['type']);
$phone = trim($_POST['mem_phone']);

if($type == 'write' || $type == 'edit'){
	if($_POST['pwd1'])	$passwd = hash('sha256',trim($_POST['pwd1']));
	else						$passwd = '';

	$userip = $_SERVER['REMOTE_ADDR'];
	$rDate = date('Y-m-d H:i:s');
	$rTime = time();
}

if($type == 'write'){
	$tmpchk = sqlRowOne("select count(*) from ks_member where userid='$userid'");
	if($tmpchk){
		Msg::backMsg('사용할 수 없는 아이디입니다.','');
		exit;
	}

	$mtype = 'M';
	$lastLogin = '';

	$sql = "insert into ks_member (mtype,name,phone,userid,passwd,userip,rDate,rTime,lastLogin) values ('$mtype','$name','$phone','$userid','$passwd','$userip','$rDate','$rTime','$lastLogin')";
	sqlExe($sql);

}elseif($type == 'edit'){
	$sql = "update ks_member set ";
	if($passwd){
		$sql .= "passwd='$passwd',";
	}
	$sql .= "name='$name', ";
	$sql .= "phone='$phone' ";
	$sql .= "where uid='$uid'";
	sqlExe($sql);


}elseif($type == 'del'){
	$sql = "delete from ks_member where uid='$uid'";
	sqlExe($sql);

}
?>

<script>
top.location.href = '/member/';
</script>