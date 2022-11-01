<?
include "../class/class.DbCon.php";
include "../class/class.Msg.php";

$_POST = sql_injection($_POST);

$userid = trim($_POST['mem_id']);
$name = trim($_POST['mem_name']);
$phone = trim($_POST['mem_phone']);
$n_pwd1 = trim($_POST['n_pwd1']);
$n_pwd2 = trim($_POST['n_pwd2']);
$passwd = hash('sha256',trim($_POST['o_pwd']));

$errMsg = '';

$sql = "select * from ks_member where userid='".addslashes($userid)."'";
$row = sqlRow($sql);

if(!$row)										$errMsg = '현재 비밀번호를';
elseif($row['passwd'] != $passwd)	$errMsg = '현재 비밀번호를';
elseif($n_pwd1 != $n_pwd2)			$errMsg = '신규 비밀번호를';


if($errMsg){
	Msg::onlyMsg($errMsg." 확인해 주시기 바랍니다.", '');
	exit;

}else{
	//비밀번호 변경
	if($n_pwd1){
		$new_passwd = hash('sha256',trim($_POST['n_pwd1']));
		sqlExe("update ks_member set name='".$name."', phone='".$phone."', passwd='".$new_passwd."' where userid='".$userid."'");
	}else{
		sqlExe("update ks_member set name='".$name."', phone='".$phone."' where userid='".$userid."'");
	}

	session_start();

	$_SESSION['ses_member_name'] = $name;
?>
<script src="/vendor/jquery/jquery.min.js"></script>
<script>
$(document).ready(function(){
	alert('정보가 변경되었습니다');
	parent.parent.$('#GBL_NAME').text("<?=$name?>");
	parent.parent.$('.multiBox_close').click();
});
</script>
<?
}
?>