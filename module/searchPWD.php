<?
	include './class/class.DbCon.php';
	include './class/class.Util.php';
	include './enc_func.php';

	$f_mtype = $_POST['f_mtype'];
	$f_userid = trim($_POST['f_userid']);
	$f_name = trim($_POST['f_name']);

	$row = '';

	//개인회원
	if($f_mtype == 'M'){
		$f_type = $_POST['f_type'];
		$qMent = '';

		//비밀번호 찾기(이메일)
		if($f_type == 'email'){
			$f_email = encrypt(trim($_POST['f_email']));
			$f_mobile = '';
			$qMent = "where mtype='$f_mtype' and userid='$f_userid' and name='$f_name' and email='$f_email'";

		//비밀번호 찾기(휴대폰)
		}elseif($f_type == 'mobile'){
			$f_email = '';
			$f_mobile = encrypt(trim($_POST['f_mobile']));
			$qMent = "where mtype='$f_mtype' and userid='$f_userid' and name='$f_name' and mobile='$f_mobile'";
		}

		if($qMent){
			$row = sqlRow("select * from tb_member $qMent");
		}

	//기업회원
	}elseif($f_mtype == 'C'){
		$f_cType = $_POST['f_cType'];
		$f_cNum = encrypt(trim($_POST['f_cNum']));

		$qMent = "where mtype='$f_mtype' and cType='$f_cType' and userid='$f_userid' and cNum='$f_cNum' and name='$f_name'";
		$row = sqlRow("select * from tb_member $qMent");
	}


	//비밀번호 초기화 및 메일발송
	if($row && $qMent){
		$send_email = decrypt($row['email']);

		//비밀번호 초기화
		$send_passwd = Util::rePassWord();
		$passwd	= hash('sha256',trim($send_passwd));
		sqlExe("update tb_member set passwd='$passwd' $qMent");

		//비밀번호 변경로그
		$userip = $_SERVER['REMOTE_ADDR'];
		$rDate = date('Y-m-d H:i:s');
		$rTime = time();
		$sql = "insert into ks_pass_log (userid,email,mobile,userip,rDate,rTime) values ('$f_userid','$send_email','$f_mobile','$userip','$rDate','$rTime')";
		$result = mysql_query($sql);

		//메일발송
		$to_name = $f_name;
		$to_email = $send_email;

		include 'passEmail.php';

		echo 'ok';
	}
?>