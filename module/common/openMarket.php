<?
//남은시간
function timeDiff($sTime,$eTime){
	$diff = $eTime - $sTime;

	$h = floor($diff / 3600);
	$diff = $diff - ($h * 3600);
	$m = floor($diff / 60);
//	$s = $diff - ($m * 60);

	$res = '';

	if($h > 0)	$res = $h.'시간 ';
	if($m > 0)	$res .= $m.'분 ';

	$res .= '뒤에';

	return $res;
}



/*
우리나라 월~금 사이에 표기합니다. 

월요일 오후 5시~ 오후 10시반 프리장
오후 10시반~ 화요일 오전 5시 = 정규장
화요일 오전 5시 ~ 오전9시 = 애프터장 

예 : 화요일 오후 4시 -> 1시간 뒤에 프리장 시작됩니다. 현재는 장전 입니다. 
수요일 오후 6시반 -> 4시간 뒤에 정규장 시작됩니다. 현재는 프리장 입니다. 
목요일 오전 2시 -> 3시간 뒤에 정규장 마감입니다. 현재는 정규장 입니다.
금요일 오전 6시 -> 3시간 뒤에 애프터장 마감입니다. 현재는 애프터장 입니다.
정확히는 월요일 오후 ~ 토요일오전 까지 적용됩니다. 

토요일 오전 9시 ~ 일요일 까지는 '오늘은 휴장입니다' 라고 표기하겠습니다. 
*/

function marketTime(){

	$w = date('w');	//요일
	$nTime = strtotime(date('His'));	//현재시간 타임값

	$freeOn = strtotime(date('170000'));	//프리장 오픈 타임값
	$freeOff = strtotime(date('223000'));	//프리장 마감 타임값

	$realOn = $freeOff;							//정규장 오픈 타임값
	$realOff = strtotime(date('050000'));	//정규장 마감 타임값

	$afterOn = $realOff;							//애프터장 오픈 타임값
	$afterOff = strtotime(date('090000'));	//애프터장 마감 타임값


	$txt = '';

/*
	//작업용 데이터
	$nTime = strtotime('2022-08-09 23:20:00');
	$w = date('w',$nTime);

	$d1 = date('Y-m-d',$nTime);

	$freeOn = strtotime(date($d1.' 17:00:00'));	//프리장 오픈 타임값
	$freeOff = strtotime(date($d1.' 22:30:00'));	//프리장 마감 타임값

	$realOn = $freeOff;							//정규장 오픈 타임값
	$realOff = strtotime(date($d1.' 05:00:00'));	//정규장 마감 타임값

	$afterOn = $realOff;							//애프터장 오픈 타임값
	$afterOff = strtotime(date($d1.' 09:00:00'));	//애프터장 마감 타임값
*/


	//일요일
	if($w == 0){
		$txt = '오늘은 휴장입니다.';

	//월요일
	}elseif($w == 1){
		//프리장 오픈전
		if($nTime < $freeOn){
			$tc = timeDiff($nTime,$freeOn);
			$txt = $tc.' 프리장이 시작됩니다.';

			$txt .= ' 현재는 장전 입니다.';

		}elseif($nTime < $freeOff){
			$tc = timeDiff($nTime,$realOn);
			$txt = $tc.' 정규장이 시작됩니다.';

			$txt .= ' 현재는 프리장 입니다.';

		}else{
			$txt = '현재는 정규장 입니다.';
		}

	//화~금요일
	}elseif($w < 6){
		if($nTime < $realOff){
			$tc = timeDiff($nTime,$realOff);
			$txt = $tc.' 정규장 마감입니다.';

			$txt .= '현재는 정규장 입니다.';

		}elseif($nTime < $afterOff){
			$tc = timeDiff($nTime,$afterOff);
			$txt = $tc.' 애프터장 마감입니다.';

			$txt .= ' 현재는 애프터장 입니다.';

		}elseif($nTime < $freeOff){
			$tc = timeDiff($nTime,$realOn);
			$txt = $tc.' 정규장이 시작됩니다.';

			$txt .= ' 현재는 프리장 입니다.';

		}elseif($nTime > $realOn){
			$tc = timeDiff($nTime,$realOff+86400);
			$txt = $tc.' 정규장 마감입니다.';

			$txt .= ' 현재는 정규장 입니다.';

		}else{
			$tc = timeDiff($nTime,$freeOn);
			$txt = $tc.' 프리장이 시작됩니다.';

			$txt .= ' 현재는 장전 입니다.';
		}

	//토요일
	}elseif($w == 6){
		if($nTime < $realOff){
			$tc = timeDiff($nTime,$realOff);
			$txt = $tc.' 정규장 마감입니다.';

			$txt .= ' 현재는 정규장 입니다.';

		}else{
			$txt = '오늘은 휴장입니다.';
		}
	}

	return $txt;
}

$marketTime = marketTime();

if($marketTime){
	echo "<span>* ".$marketTime."</span>";
}
?>

