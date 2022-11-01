<?
	include './class/class.DbCon.php';
	include './class/class.Util.php';
	include './enc_func.php';

	$f_mtype = $_POST['f_mtype'];
	$f_name = trim($_POST['f_name']);

	//개인회원
	if($f_mtype == 'M'){
		$f_type = $_POST['f_type'];

		//아이디 찾기(이메일)
		if($f_type == 'email'){
			$f_email = encrypt(trim($_POST['f_email']));
			$row = sqlRow("select * from tb_member where mtype='$f_mtype' and name='$f_name' and email='$f_email'");
			if($row){
				$userid = Util::NameCutStr($row['userid'],2,'*');

				echo $userid;
			}

		//아이디 찾기(휴대폰)
		}elseif($f_type == 'mobile'){
			$f_mobile = encrypt(trim($_POST['f_mobile']));
			$row = sqlRow("select * from tb_member where mtype='$f_mtype' and name='$f_name' and mobile='$f_mobile'");
			if($row){
				$userid = Util::NameCutStr($row['userid'],2,'*');

				echo $userid;
			}
		}

	//기업회원
	}elseif($f_mtype == 'C'){
		$f_cType = $_POST['f_cType'];
		$f_cNum = encrypt(trim($_POST['f_cNum']));

		$row = sqlRow("select * from tb_member where mtype='$f_mtype' and cType='$f_cType' and cNum='$f_cNum' and name='$f_name'");
		if($row){
			$userid = Util::NameCutStr($row['userid'],2,'*');

			echo $userid;
		}
	}
?>