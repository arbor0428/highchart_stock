<?
include '../class/class.DbCon.php';
include '../class/class.Util.php';
include '../lib.php';

$res = Array();
$res['code'] = '100';	//에러

$userid = $_POST['userid'];
$type = $_POST['type'];

if($userid){
	//포트폴리오추가
	if($type == 'write'){
		$tmpChk = sqlRowOne("select count(*) from ks_userPortfolio where userid='".$userid."'");

		$maxNum = 10;	//최대 포트폴리오수

		if($tmpChk > $maxNum){
			$res['code'] = '101';		//최대 포트폴리오수 초과

		}else{
			$groupTitle = addslashes($_POST['groupTitle']);
			$groupMemo = $_POST['groupMemo'];

			$userip = $_SERVER['REMOTE_ADDR'];
			$mDate = date('Y-m-d H:i:s');
			$mTime = time();
			$rDate = date('Y-m-d H:i:s');
			$rTime = time();

			//정렬순서
			$sortNum = sqlRowOne("select max(sortNum) from ks_userPortfolio where userid='".$userid."'");
			$sortNum += 1;

			sqlExe("insert into ks_userPortfolio (userid,title,memo,sortNum,userip,mDate,mTime,rDate,rTime) values ('".$userid."','".$groupTitle."','".$groupMemo."','".$sortNum."','".$userip."','".$mDate."','".$mTime."','".$rDate."','".$rTime."')");

			$res['code'] = '99';
		}

	//포트폴리오변경
	}elseif($type == 'edit'){
		$uid = $_POST['uid'];

		$groupTitle = addslashes($_POST['groupTitle']);
		$groupMemo = $_POST['groupMemo'];
		
		sqlExe("update ks_userPortfolio set title='".$groupTitle."', memo='".$groupMemo."' where userid='".$userid."' and uid=".$uid."");

		$res['code'] = '99';

	//포트폴리오삭제
	}elseif($type == 'del'){
		$uid = $_POST['uid'];
		sqlExe("delete from ks_userPortfolio where userid='".$userid."' and uid=".$uid."");

		//포트폴리오내 종목삭제
		sqlExe("delete from ks_userPortfolioData where userid='".$userid."' and gid=".$uid."");

		//정렬순서 재설정
		$row = sqlArray("select * from ks_userPortfolio where userid='".$userid."'");
		$sortNum = 1;
		foreach($row as $v){
			sqlExe("update ks_userPortfolio set sortNum=".$sortNum." where userid='".$userid."' and uid=".$v['uid']."");
			$sortNum++;
		}

		$res['code'] = '99';
	}
}

$json = json_encode($res);
echo $json;
?>