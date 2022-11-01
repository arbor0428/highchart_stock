<?
include '../class/class.DbCon.php';
include '../class/class.Util.php';
include '../lib.php';

$res = Array();
$res['code'] = '100';	//에러

$userid = $_POST['userid'];
$type = $_POST['type'];
$gid = $_POST['gid'];

if($userid){

	//종목추가
	if($type == 'write'){		

		$gbl_word = str_replace(' ','',strtoupper($_POST['groupStock']));

		//심볼 검색
		$row = sqlRow("select * from ks_symbol where symbol='".$gbl_word."'");

		if(!$row){
			//상호명(영문) 검색
			$row = sqlRow("select s.* from ks_symbol as s left join api_Company_Profile as c on s.symbol=c.symbol where replace(c.name, ' ', '') like '%".$gbl_word."%' order by s.symbol asc limit 1");

			if(!$row){
				//상호명(국문) 검색
				$row = sqlRow("select s.* from ks_symbol as s left join api_Company_Profile as c on s.symbol=c.symbol where replace(c.nameKor, ' ', '') like '%".$gbl_word."%' order by s.symbol asc limit 1");
			}
		}

		if($row){
			$symbol = $row['symbol'];
			$etf = $row['etf'];
			$tmpChk = sqlRowOne("select count(*) from ks_userPortfolioData where userid='".$userid."' and gid=".$gid." and symbol='".$symbol."'");
			
			if($tmpChk){
				$res['code'] = '102';	//그룹내 동일한 종목이 있음

			}else{
				$sExc = $_POST['exRate'];
				$userip = $_SERVER['REMOTE_ADDR'];
				$rDate = date('Y-m-d H:i:s');
				$rTime = time();

				//정렬순서
				$sortNum = sqlRowOne("select max(sortNum) from ks_userPortfolioData where userid='".$userid."' and gid=".$gid."");
				$sortNum += 1;

				sqlExe("insert into ks_userPortfolioData (gid,userid,symbol,etf,sExc,sortNum,userip,rDate,rTime) values ('".$gid."','".$userid."','".$symbol."','".$etf."','".$sExc."','".$sortNum."','".$userip."','".$rDate."','".$rTime."')");

				$res['code'] = '99';
				$res['uid'] = sqlRowOne("select uid from ks_userPortfolioData where userid='".$userid."' and gid=".$gid." and symbol='".$symbol."'");
				$res['symbol'] = $symbol;

			}

		}else{
			$res['code'] = '101';	//해당 종목정보 없음
		}





	//종목변경
	}elseif($type == 'edit'){
		$uid = $_POST['uid'];

		$groupTitle = addslashes($_POST['groupTitle']);
		$groupMemo = $_POST['groupMemo'];
		
		sqlExe("update ks_userPortfolioData set title='".$groupTitle."', memo='".$groupMemo."' where userid='".$userid."' and uid=".$uid."");

		$res['code'] = '99';



	//종목삭제
	}elseif($type == 'del'){
		$uid = $_POST['uid'];

		sqlExe("delete from ks_userPortfolioData where userid='".$userid."' and gid=".$gid." and uid=".$uid."");

		//정렬순서 재설정
		$row = sqlArray("select * from ks_userPortfolioData where userid='".$userid."' and gid=".$gid."");
		$sortNum = 1;
		foreach($row as $v){
			sqlExe("update ks_userPortfolioData set sortNum=".$sortNum." where userid='".$userid."' and uid=".$v['uid']."");
			$sortNum++;
		}

		$res['code'] = '99';


	//종목저장(폼전송 형태)
	}elseif($type == 'save'){
		foreach($chk as $v){
			$memo = addslashes($_POST['msg_'.$v]);
			$sNum = $_POST['sNum_'.$v];
			$sAmt = $_POST['sAmt_'.$v];
			$sExc = $_POST['sExc_'.$v];

			sqlExe("update ks_userPortfolioData set memo='".$memo."', sNum='".$sNum."', sAmt='".$sAmt."', sExc='".$sExc."' where userid='".$userid."' and uid=".$v."");
		}
	}


	//포트폴리오 편입 종목 최종 수정일
	$mDate = date('Y-m-d H:i:s');
	$mTime = time();
	sqlExe("update ks_userPortfolio set mDate='".$mDate."', mTime='".$mTime."' where  userid='".$userid."' and uid='".$gid."'");


	//종목저장(폼전송 형태)
	if($type == 'save'){
		echo "<script>parent.location.href='/sub04/sub04.php';</script>";
		exit;
	}
}

//해당 그룹에 추가된 종목 수
$gsNum = sqlRowOne("select count(*) from ks_userPortfolioData where userid='".$userid."' and gid=".$gid."");
$res['gsNum'] = $gsNum;

$json = json_encode($res);
echo $json;
?>