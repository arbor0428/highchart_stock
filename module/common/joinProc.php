<?
include "../class/class.DbCon.php";
include "../class/class.Msg.php";
include "../class/class.Util.php";
include '../enc_func.php';

$type = trim($_POST['type']);

if($type == 'write' || $type == 'edit'){
	include '../class/class.FileUpload.php';

	$UPLOAD_DIR = '../../upfile/member';
	$tot_num = '1';	//첨부파일갯수

	//파일관련처리
	for($i=1; $i<=$tot_num; $i++){
		$file_num = sprintf("%02d",$i);
		$doc_name	= 'upfile'.$file_num;
		$db_set_file = ${'dbfile'.$file_num};
		$db_real_file = ${'realfile'.$file_num};

		if($_FILES[$doc_name]['name']){
			$temp_doc = $_FILES[$doc_name]['name'];		

			$ext = FileUpload::getFileExtension($_FILES[$doc_name]['name']);
			if($ext != 'jpg' && $ext != 'gif' && $ext != 'png'){
				Msg::GblMsgBoxParent("jpg, gif, png 파일만 등록이 가능합니다.",'');
				exit;
			}

			//이미지의 경우 자동번호 부여
			$fileUpload = new FileUpload($UPLOAD_DIR,$_FILES[$doc_name],'M');

			if($fileUpload->uploadFile()){
				$arr_new_file[$i] = $fileUpload->fileInfo[rename];
			}else{
				Msg::GblMsgBoxParent("파일을 다시 선택해 주십시오",'');
				exit;
			}

			$real_name[$i] = $temp_doc;

			if($db_set_file){
				unlink($UPLOAD_DIR."/".$db_set_file);
			}

		}else{
			$arr_new_file[$i] = $db_set_file;
			$real_name[$i] = $db_real_file;
		}
	}



	$upfile01 = $arr_new_file[1];
	$realfile01 = $real_name[1];
}




if($type == 'write'){
	$mtype = trim($_POST['mtype']);
	$name = trim($_POST['name']);
	$userid = addslashes(trim($_POST['userid']));
	$passwd	= hash('sha256',trim($_POST['passwd']));
	$email = encrypt(trim($_POST['email']));
	$mobile = encrypt(trim($_POST['mobile']));
	$loc01 = trim($_POST['loc01']);
	$loc02 = trim($_POST['loc02']);
	$loc03 = encrypt(trim($_POST['loc03']));
	$receiveMail = trim($_POST['receiveMail']);

	if($userid){
		//회원 중복확인
		$tmpchk = sqlRowOne("select count(*) from tb_member where userid='$userid'");
		if($tmpchk){
			Msg::GblMsgBoxParent('사용할 수 없는 아이디입니다.','');
			exit;
		}

		$userip = $_SERVER['REMOTE_ADDR'];
		$rDate = date('Y-m-d H:i:s');
		$rTime = time();

		if($mtype == 'M'){
			$cType = '';
			$cNum = '';
			$cName = '';
			$ceo = '';
			$upfile01 = '';
			$realfile01 = '';
			$ment = '';

		}elseif($mtype == 'C'){
			$cType = trim($_POST['cType']);
			$cNum = encrypt(trim($_POST['cNum']));
			$cName = trim($_POST['cName']);
			$ceo = trim($_POST['ceo']);
			$ment = trim($_POST['ment']);
			if($ment)		$ment = Util::TextAreaEncodeing($ment);
		}

		//기본정보저장
		$sql = "insert into tb_member (mtype,name,userid,passwd,email,mobile,loc01,loc02,loc03,cType,cNum,cName,ceo,upfile01,realfile01,ment,receiveMail,userip,rDate,rTime) values ";
		$sql .= "('$mtype','$name','$userid','$passwd','$email','$mobile','$loc01','$loc02','$loc03','$cType','$cNum','$cName','$ceo','$upfile01','$realfile01','$ment','$receiveMail','$userip','$rDate','$rTime')";
		sqlExe($sql);



		Msg::GblMsgBoxParent("회원가입이 완료되었습니다.\\n로그인 후 이용해 주시기 바랍니다.","location.href='/';");
		exit;
	}




}elseif($type == 'edit'){
	$ori_passwd	= hash('sha256',trim($_POST['ori_passwd']));

	$tmpchk = sqlRowOne("select count(*) from ona_member where userid='$userid' and passwd='$ori_passwd'");
	if($tmpchk == 0){
		Msg::GblMsgBoxParent('현재 비밀번호를 확인해 주시기 바랍니다.','');
		exit;

	}else{
		$rTime = time();

		$sql = "update ona_member set ";
		if(trim($_POST['passwd'])){
			$passwd	= hash('sha256',trim($_POST['passwd']));
			$sql .= "passwd = '$passwd',";
		}		
		$sql .= "memtype1='$memtype1',";
		$sql .= "email='$email',";
		$sql .= "homephone='$homephone',";
		$sql .= "telType='$telType',";
		$sql .= "mobile='$mobile',";
		$sql .= "homezipcode='$homezipcode',";
		$sql .= "homeaddress='$homeaddress',";
		$sql .= "homeaddress2='$homeaddress2',";
		$sql .= "mailyn='$mailyn',";
		$sql .= "smsyn='$smsyn',";
		$sql .= "job='$job',";
		$sql .= "sisulid='$sisulid',";
		$sql .= "cpName='$cpName',";
		$sql .= "moddate=$rTime";
		$sql .= " where userid='".$userid."'";
		$result = mysql_query($sql);


		//자녀
		if($childName){
			$c_cd = 'EP';
			$s_cd = '01';
			$regdate = $rTime;
			$rent_grade = "준회원";

			foreach($childName as $k => $v){
				if(trim($childName[$k])=="" || trim($cDate[$k])=="" || trim($csex[$k])=="") continue;
				$relation = substr($csex[$k],0,1)%2?"아들":"딸";

				$birthDate = str_replace('-','',$cDate[$k]);
				$cjumin1 = substr($birthDate,2);
				$cjumin2 = $csex[$k];
				if(substr($birthDate,0,4) > 1999)	$cjumin2 += 2;

//				echo $childName[$k].'|'.$cDate[$k].'|'.$csex[$k].'|'.$nursery[$k].'|'.$cjumin1.'|'.$cjumin2.'<br>';

				$jumin = encrypt($cjumin1."-".$cjumin2);

				$sql = "insert into ona_member_family (userid,name,jumin,nursery,relation,memberno,c_cd,s_cd,regdate,rent_grade) values ";
				$sql .= "('$userid','$childName[$k]','$jumin','$nursery[$k]','$relation','','$c_cd','$s_cd','$regdate','$rent_grade')";
				$result = mysql_query($sql);
			}
		}

		if($pageMode == 'm')	$act = '/m/sub07/joinModify.php';
		else							$act = '/sub07/joinModify.php';

		//로그인 세션변경
		session_start();
		$_SESSION['member_level'] = $memtype1;

		Msg::GblMsgBoxParent("회원정보가 수정 되었습니다.","location.href='".$act."';");
		exit;
	}
}
?>