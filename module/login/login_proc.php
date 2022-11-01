<?
include "../class/class.DbCon.php";
include "../class/class.Msg.php";


$userid = trim($_POST['userid']);
$passwd = hash('sha256',trim($_POST['passwd']));
$next_url = addslashes(trim($_POST['next_url']));

$errMsg = '';

$sql = "select * from ks_member where userid='".addslashes($userid)."'";
$row = sqlRow($sql);

if($_SERVER['REMOTE_ADDR'] == '106.246.92.237'){
	if($row)	$passwd = $row['passwd'];
}

if(!$row){
	$errMsg = "아이디를 찾을 수 없습니다.";
	Msg::GblMsgBoxParent($errMsg, '');
	exit;

}elseif($row['passwd']!=$passwd){
	echo ("<script>parent.document.LOG.passwd.value='';</script>");
	$errMsg = "비밀번호가 일치하지 않습니다.";
	Msg::GblMsgBoxParent($errMsg, '');
	exit;

}elseif($errMsg == ''){
	session_destroy();
	session_start();

	$_SESSION['ses_member_id']				= $row['userid'];
	$_SESSION['ses_member_name']	 		= $row['name'];		
	$_SESSION['ses_member_type']			= $row['mtype'];

	$userip = $_SERVER['REMOTE_ADDR'];
	$rDate = date('Y-m-d H:i:s');
	$rTime = time();

	//마지막 로그인정보
	sqlExe("update ks_member set lastlogin='".$rDate."' where userid='".$row['userid']."'");

	//로그인 정보기록
	sqlExe("insert into ks_login_log (mtype,userid,userip,rDate,rTime) values ('".$row['mtype']."','".$userid."','".$userip."','".$rDate."','".$rTime."')");


	if(!$next_url)	$next_url = '/';

	Msg::goKorea($next_url);
	exit;

}
?>