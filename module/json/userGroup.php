<?
include '../class/class.DbCon.php';
include '../class/class.Util.php';
include '../lib.php';

$res = Array();
$res['code'] = '100';	//에러

$userid = $_POST['userid'];
$type = $_POST['type'];

if($userid){
	//그룹추가
	if($type == 'write'){
		$tmpChk = sqlRowOne("select count(*) from ks_userGroup where userid='".$userid."'");

		$maxNum = 10;	//최대 그룹수

		if($tmpChk > $maxNum){
			$res['code'] = '101';		//최대 그룹수 초과

		}else{
			$groupTitle = addslashes($_POST['groupTitle']);
			$groupMemo = $_POST['groupMemo'];

			$userip = $_SERVER['REMOTE_ADDR'];
			$rDate = date('Y-m-d H:i:s');
			$rTime = time();

			//정렬순서
			$sortNum = sqlRowOne("select max(sortNum) from ks_userGroup where userid='".$userid."'");
			$sortNum += 1;

			sqlExe("insert into ks_userGroup (userid,title,memo,sortNum,userip,rDate,rTime) values ('".$userid."','".$groupTitle."','".$groupMemo."','".$sortNum."','".$userip."','".$rDate."','".$rTime."')");

			$res['code'] = '99';
		}

	//그룹변경
	}elseif($type == 'edit'){
		$uid = $_POST['uid'];

		$groupTitle = addslashes($_POST['groupTitle']);
		$groupMemo = $_POST['groupMemo'];
		
		sqlExe("update ks_userGroup set title='".$groupTitle."', memo='".$groupMemo."' where userid='".$userid."' and uid=".$uid."");

		$res['code'] = '99';

	//그룹삭제
	}elseif($type == 'del'){
		$uid = $_POST['uid'];
		sqlExe("delete from ks_userGroup where userid='".$userid."' and uid=".$uid."");

		//그룹내 종목삭제
		sqlExe("delete from ks_userGroupData where userid='".$userid."' and gid=".$uid."");

		//정렬순서 재설정
		$row = sqlArray("select * from ks_userGroup where userid='".$userid."'");
		$sortNum = 1;
		foreach($row as $v){
			sqlExe("update ks_userGroup set sortNum=".$sortNum." where userid='".$userid."' and uid=".$v['uid']."");
			$sortNum++;
		}

		$res['code'] = '99';
	}
}

$json = json_encode($res);
echo $json;
?>