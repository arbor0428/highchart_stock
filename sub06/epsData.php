<?
//제이쿼리 로드함수를 이용해 페이지가 로딩된 경우
if($_GET['jQueryLoad']){
	include "../module/class/class.DbCon.php";
	include "../module/class/class.Util.php";
	include '../module/lib.php';
?>
<script>
$(document).ready(function(){
	$("#loading").delay("200").fadeOut();
});
</script>
<?
}

$nTime = strtotime(date('Y-m-d'));	//금일 0시 타임값

//그래프 데이터
$epsX = '';
$epsData01 = '';		//예상이익
$epsData02 = '';		//실제이익
$epsData03 = '';		//실제이익(이전값 비교 증감율)
$epsData04 = '';		//미래 예상이익 상승하락폭

$revenueX = '';
$revenueData01 = '';		//예상매출
$revenueData02 = '';		//실제매출
$revenueData03 = '';		//실제매출(이전값 비교 증감율)
$revenueData04 = '';		//미래 예상매출 상승하락폭

if(!$eps_period)	$eps_period = '3';
if(!$eps_type)		$eps_type = 'quarter';

//분기
if($eps_type == 'quarter'){
	if($eps_period == '1'){
		$sTime = strtotime('-1 years');
		$epsGraphNum = 4;

	}elseif($eps_period == '3'){
		$sTime = strtotime('-3 years');
		$epsGraphNum = 8;

	}elseif($eps_period == '5'){
		$sTime = strtotime('-5 years');
		$epsGraphNum = 12;

	}elseif($eps_period == '10'){
		$sTime = strtotime('-10 years');
		$epsGraphNum = 16;
	}

	$eTime = time();

//	$row = sqlArray("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and dateTime>'".$sTime."' and dateTime<='".$eTime."' order by dateTime");
	$row = sqlArray("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and dateTime>'".$sTime."' order by dateTime");

	$item = Array();
	$c = 0;

	foreach($row as $v){
		$epsEstimate = round($v['epsEstimate'],2);	//예상이익
		$epsActual = round($v['epsActual'],2);		//실제이익
		$revenueEstimate = round($v['revenueEstimate'] / 100000000,2);	//예상매출
		$revenueActual = round($v['revenueActual'] / 100000000,2);			//실제매출

		//그래프 데이터
		if($c > 0){
			$epsX .= ',';
			$epsData01 .= ',';
			$epsData02 .= ',';
			$epsData03 .= ',';
			$epsData04 .= ',';

			$revenueX .= ',';
			$revenueData01 .= ',';
			$revenueData02 .= ',';
			$revenueData03 .= ',';
			$revenueData04 .= ',';
		}

		$y = date('Y',$v['dateTime']);

		if(date('m',$v['dateTime']) <= 3){
			$epsX .= "'Q1 ".$y."'";
			$revenueX .= "'Q1 ".$y."'";

		}elseif(date('m',$v['dateTime']) <= 6){
			$epsX .= "'Q2 ".$y."'";
			$revenueX .= "'Q2 ".$y."'";

		}elseif(date('m',$v['dateTime']) <= 9){
			$epsX .= "'Q3 ".$y."'";
			$revenueX .= "'Q3 ".$y."'";

		}elseif(date('m',$v['dateTime']) <= 12){
			$epsX .= "'Q4 ".$y."'";
			$revenueX .= "'Q4 ".$y."'";
		}

		
//		$epsData01 .= $epsEstimate;
//		$revenueData01 .= $revenueEstimate;

		//전분기 실적발표이기 때문에 3,6,9,12월로 고정해서 표기
		$mm = date('n',$v['dateTime']);
		if($mm <= 3)			$dateTxt = date('Y',$v['dateTime']).'.03';
		elseif($mm <= 6)		$dateTxt = date('Y',$v['dateTime']).'.06';
		elseif($mm <= 9)		$dateTxt = date('Y',$v['dateTime']).'.09';
		elseif($mm <= 12)	$dateTxt = date('Y',$v['dateTime']).'.12';

		//CTAS는 특이하게 3,7,9,12여서 7월은 강제로 6월로 표시
		if($gbl_symbol == 'CTAS' && date('n',$v['dateTime']) == '7'){
			$dateTxt = date('Y',$v['dateTime']).'.06';
		}

		$item[$c]['date'] = $dateTxt;
//		$item[$c]['date'] = date('Y.m',$v['dateTime']);

		$item[$c]['epsEstimate'] = $epsEstimate;
		$item[$c]['epsActual'] = $epsActual;
		$item[$c]['revenueEstimate'] = $revenueEstimate;
		$item[$c]['revenueActual'] = $revenueActual;

		//미래는 테이블(영업이익/매출액)에 N/A로 표기
		if($nTime <= $v['dateTime'])	$disChk = '1';
		else									$disChk = '';
		$item[$c]['disChk'] = $disChk;


		if($c > 0){
			//이전값 대비 퍼센트
			$item[$c]['epsGap'] = Util::fnPercent($item[$c-1]['epsActual'],$epsActual);
			$item[$c]['revenueGap'] = Util::fnPercent($item[$c-1]['revenueActual'],$revenueActual);

		}else{
			$info = sqlRow("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and dateTime<'".$v['dateTime']."' order by dateTime desc limit 1");
			if($info){
				//이전값 대비 퍼센트
				$item[$c]['epsGap'] = Util::fnPercent(round($info['epsActual'],2),$epsActual);
				$item[$c]['revenueGap'] = Util::fnPercent(round($info['revenueActual'] / 100000000,2),$revenueActual);
			}
		}

		//미래인 경우 이전 실제이익과 미래 예상이익값을 비교
		if($disChk){
			//예상값과 실제값 상승하락폭
			if($item[$c-1]['epsActual'])	$epsTmp = $item[$c-1]['epsActual'];
			else									$epsTmp = $item[$c-1]['epsEstimate'];
			$item[$c]['epsGap2'] = Util::fnPercent($epsTmp,$epsEstimate);

			if($item[$c-1]['revenueActual'])		$revenueTmp = $item[$c-1]['revenueActual'];
			else											$revenueTmp = $item[$c-1]['revenueEstimate'];
			$item[$c]['revenueGap2'] = Util::fnPercent($revenueTmp,$revenueEstimate);

		}else{
			//예상값과 실제값 상승하락폭
			$item[$c]['epsGap2'] = Util::fnPercent($epsEstimate,$epsActual);
			$item[$c]['revenueGap2'] = Util::fnPercent($revenueEstimate,$revenueActual);

		}

		if($item[$c]['epsGap2'] > 0){
			$epsData01 .= "{y:".$epsEstimate.",dataLabels: {color: '#eb0828'}}";
			$epsData02 .= "{y:".$epsActual.",dataLabels: {color: '#eb0828'}}";
			$epsData03 .= "+".$item[$c]['epsGap2'];
			if($disChk)	$epsData04 .= "+".$item[$c]['epsGap2'];

		}elseif($item[$c]['epsGap2'] < 0){
			$epsData01 .= "{y:".$epsEstimate.",dataLabels: {color: '#5689f5'}}";
			$epsData02 .= "{y:".$epsActual.",dataLabels: {color: '#5689f5'}}";
			$epsData03 .= $item[$c]['epsGap2'];
			if($disChk)	$epsData04 .= $item[$c]['epsGap2'];

		}else{
			$epsData01 .= "{y:".$epsEstimate.",dataLabels: {color: '#666'}}";
			$epsData02 .= "{y:".$epsActual.",dataLabels: {color: '#666'}}";
			$epsData03 .= $item[$c]['epsGap2'];
			if($disChk)	$epsData04 .= $item[$c]['epsGap2'];
		}


		if($item[$c]['revenueGap2'] > 0){
			$revenueData01 .= "{y:".$revenueEstimate.",dataLabels: {color: '#eb0828'}}";
			$revenueData02 .= "{y:".$revenueActual.",dataLabels: {color: '#eb0828'}}";
			$revenueData03 .= "+".$item[$c]['revenueGap2'];
			if($disChk)	$revenueData04 .= "+".$item[$c]['revenueGap2'];

		}elseif($item[$c]['revenueGap2'] < 0){
			$revenueData01 .= "{y:".$revenueEstimate.",dataLabels: {color: '#5689f5'}}";
			$revenueData02 .= "{y:".$revenueActual.",dataLabels: {color: '#5689f5'}}";
			$revenueData03 .= $item[$c]['revenueGap2'];
			if($disChk)	$revenueData04 .= $item[$c]['revenueGap2'];

		}else{
			$revenueData01 .= "{y:".$revenueEstimate.",dataLabels: {color: '#666'}}";
			$revenueData02 .= "{y:".$revenueActual.",dataLabels: {color: '#666'}}";
			$revenueData03 .= $item[$c]['revenueGap2'];
			if($disChk)	$revenueData04 .= $item[$c]['revenueGap2'];
		}

		$c++;
	}
//연간
}elseif($eps_type == 'year'){
	if($eps_period == '1'){
		$sYear = date('Y') - 1;
		$epsGraphNum = 2;

	}elseif($eps_period == '3'){
		$sYear = date('Y') - 3;
		$epsGraphNum = 4;

	}elseif($eps_period == '5'){
		$sYear = date('Y') - 5;
		$epsGraphNum = 6;

	}elseif($eps_period == '10'){
		$sYear = date('Y') - 10;
		$epsGraphNum = 11;
	}

	$eTime = time();

//	$row = sqlArray("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and date>='".$sYear."' and dateTime<='".$eTime."' order by dateTime");
	$row = sqlArray("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and date>='".$sYear."' order by dateTime");

	$item = Array();

	foreach($row as $v){
		$y = date('Y',$v['dateTime']);
		$epsEstimate = round($v['epsEstimate'],2);	//예상이익
		$epsActual = round($v['epsActual'],2);		//실제이익
		$revenueEstimate = round($v['revenueEstimate'] / 100000000,2);	//예상매출
		$revenueActual = round($v['revenueActual'] / 100000000,2);			//실제매출

		$item[$y]['date'] = $y;
		$item[$y]['epsEstimate'] += $epsEstimate;
		$item[$y]['epsActual'] += $epsActual;
		$item[$y]['revenueEstimate'] += $revenueEstimate;
		$item[$y]['revenueActual'] += $revenueActual;

		//미래는 테이블(영업이익/매출액)에 N/A로 표기
		if(date('Y') < $y)		$disChk = '1';
		else						$disChk = '';
		$item[$y]['disChk'] = $disChk;
	}

	//이전값 대비 퍼센트
	for($i=$sYear; $i<=$y; $i++){
		if($i > $sYear){
			//이전값 대비 퍼센트
			$item[$i]['epsGap'] = Util::fnPercent($item[$i-1]['epsActual'],$item[$i]['epsActual']);
			$item[$i]['revenueGap'] = Util::fnPercent($item[$i-1]['revenueActual'],$item[$i]['revenueActual']);

		}else{
			$info = sqlRow("select sum(epsActual) as epsActualSum, sum(revenueActual) as revenueActualSum from api_Earnings_Calendar where symbol='".$gbl_symbol."' and year='".($i-1)."' order by dateTime");
			$epsActualSum = round($info['epsActualSum'],2);
			$revenueActualSum = round($info['revenueActualSum'] / 100000000,2);

			$item[$i]['epsGap'] = Util::fnPercent($epsActualSum,$item[$i]['epsActual']);
			$item[$i]['revenueGap'] = Util::fnPercent($revenueActualSum,$item[$i]['revenueActual']);
		}

		//미래인 경우 이전 실제매출과 미래 예상매출값을 비교
		if($item[$i]['disChk']){
			//예상값과 실제값 상승하락폭
			if($item[$i-1]['epsActual'])	$epsTmp = $item[$i-1]['epsActual'];
			else									$epsTmp = $item[$i-1]['epsEstimate'];
			$item[$i]['epsGap2'] = Util::fnPercent($epsTmp,$item[$i]['epsEstimate']);

			if($item[$i-1]['revenueActual'])		$revenueTmp = $item[$i-1]['revenueActual'];
			else											$revenueTmp = $item[$i-1]['revenueEstimate'];
			$item[$i]['revenueGap2'] = Util::fnPercent($revenueTmp,$item[$i]['revenueEstimate']);

		}else{
			//예상값과 실제값 상승하락폭
			$item[$i]['epsGap2'] = Util::fnPercent($item[$i]['epsEstimate'],$item[$i]['epsActual']);
			$item[$i]['revenueGap2'] = Util::fnPercent($item[$i]['revenueEstimate'],$item[$i]['revenueActual']);
		}





		//그래프 데이터
		if($epsX){
			$epsX .= ',';
			$epsData01 .= ',';
			$epsData02 .= ',';
			$epsData03 .= ',';
			$epsData04 .= ',';

			$revenueX .= ',';
			$revenueData01 .= ',';
			$revenueData02 .= ',';
			$revenueData03 .= ',';
			$revenueData04 .= ',';
		}
		$epsX .= "'".$i."'";
//		$epsData01 .= $item[$i]['epsEstimate'];

		if($item[$i]['epsGap2'] > 0){
			$epsData01 .= "{y:".$item[$i]['epsEstimate'].",dataLabels: {color: '#eb0828'}}";
			$epsData02 .= "{y:".$item[$i]['epsActual'].",dataLabels: {color: '#eb0828'}}";
			$epsData03 .= "+".$item[$i]['epsGap2'];
			if($item[$i]['disChk'])	$epsData04 .= "+".$item[$i]['epsGap2'];

		}elseif($item[$i]['epsGap2'] < 0){
			$epsData01 .= "{y:".$item[$i]['epsEstimate'].",dataLabels: {color: '#5689f5'}}";
			$epsData02 .= "{y:".$item[$i]['epsActual'].",dataLabels: {color: '#5689f5'}}";
			$epsData03 .= $item[$i]['epsGap2'];
			if($item[$i]['disChk'])	$epsData04 .= $item[$i]['epsGap2'];

		}else{
			$epsData01 .= "{y:".$item[$i]['epsEstimate'].",dataLabels: {color: '#666'}}";
			$epsData02 .= "{y:".$item[$i]['epsActual'].",dataLabels: {color: '#666'}}";
			$epsData03 .= $item[$i]['epsGap2'];
			if($item[$i]['disChk'])	$epsData04 .= $item[$i]['epsGap2'];
		}

		$revenueX .= "'".$i."'";
//		$revenueData01 .= $item[$i]['revenueEstimate'];

		if($item[$i]['revenueGap2'] > 0){
			$revenueData01 .= "{y:".$item[$i]['revenueEstimate'].",dataLabels: {color: '#eb0828'}}";
			$revenueData02 .= "{y:".$item[$i]['revenueActual'].",dataLabels: {color: '#eb0828'}}";
			$revenueData03 .= "+".$item[$i]['revenueGap2'];
			if($item[$i]['disChk'])	$revenueData04 .= "+".$item[$i]['revenueGap2'];

		}elseif($item[$i]['revenueGap2'] < 0){
			$revenueData01 .= "{y:".$item[$i]['revenueEstimate'].",dataLabels: {color: '#5689f5'}}";
			$revenueData02 .= "{y:".$item[$i]['revenueActual'].",dataLabels: {color: '#5689f5'}}";
			$revenueData03 .= $item[$i]['revenueGap2'];
			if($item[$i]['disChk'])	$revenueData04 .= $item[$i]['revenueGap2'];

		}else{
			$revenueData01 .= "{y:".$item[$i]['revenueEstimate'].",dataLabels: {color: '#666'}}";
			$revenueData02 .= "{y:".$item[$i]['revenueActual'].",dataLabels: {color: '#666'}}";
			$revenueData03 .= $item[$i]['revenueGap2'];
			if($item[$i]['disChk'])	$revenueData04 .= $item[$i]['revenueGap2'];
		}
	}
}

if(!$epsGraphNum)	$epsGraphNum = 4;	//화면에 노출되는 x축 개수
$epsGraphNum -= 1;	//실제 적용은 -1개

/*
echo $epsX."<br>";
echo "예상이익 : ".$epsData01."<br>";
echo "실제이익 : ".$epsData02."<br>";

echo $revenueX."<br>";
echo "예상매출 : ".$revenueData01."<br>";
echo "실제매출 : ".$revenueData02."<br>";
*/
?>

<style>
.subtable th{min-width:130px !important;}
</style>


<script>
function epsCall(p,t){
	$('#loading').show();

	if(p == '')	p = $('#eps_period').val();
	if(t == '')		t = $('#eps_type').val();

	epsTabNumber = $('#epsTabNumber').val();

	$('#epsGroup').load('epsData.php?jQueryLoad=1&gbl_symbol=<?=$gbl_symbol?>&eps_period='+p+'&eps_type='+t+'&epsTabNumber='+epsTabNumber);
//	var offset = $("#epsGroup").offset();
//	$('html, body').animate({scrollTop : offset.top - 300}, 400);
}
</script>

<input type='hidden' name='eps_period' id='eps_period' value='<?=$eps_period?>'>
<input type='hidden' name='eps_type' id='eps_type' value='<?=$eps_type?>'>

	<div class="epsgraphWrap">
		<div class="btnsWrap dp_sb">
			<div class="twoKindWrap dp_f">
				<div id="quarterBtn" class="<?if($eps_type == 'quarter'){echo 'on';}?> dp_f dp_c dp_cc" onclick="epsCall('','quarter');">분기</div>
				<div id="yearlyBtn" class="<?if($eps_type == 'year'){echo 'on';}?> dp_f dp_c dp_cc" onclick="epsCall('','year');">연간</div>
			</div>
			<div class="yearKind dp_f">
				<div id="oneyear" class="<?if($eps_period == '1'){echo 'on';}?> dp_f dp_cc" onclick="epsCall('1','');">1년</div>
				<div id="threeyear" class="<?if($eps_period == '3'){echo 'on';}?> dp_f dp_cc" onclick="epsCall('3','');">3년</div>
				<div id="fiveyear" class="<?if($eps_period == '5'){echo 'on';}?> dp_f dp_cc" onclick="epsCall('5','');">5년</div>
				<div id="tenyear" class="<?if($eps_period == '10'){echo 'on';}?> dp_f dp_cc" onclick="epsCall('10','');">10년</div>
			</div>
		</div>
		<?
			include 'epsGraph.php';
		?>
	</div>
	<div class="busiAnalWrap">
		<table class="subtable">
			<tbody>
				<tr>
					<th>기업실적<br>재무정보</th>
				<?
					foreach($item as $v){
				?>
					<th><?=$v['date']?></th>
				<?
					}
				?>
				</tr>
				<tr>
					<th>영업이익<br>컨센대비<br>전분기(전년)대비</th>
				<?
					foreach($item as $v){
						$epsGap = $v['epsGap'];
						if($epsGap < 0)		$epsGapTxt = "<br><span class='blue'>".$epsGap."%</span>";
						elseif($epsGap > 0)	$epsGapTxt = "<br><span class='red'>+".$epsGap."%</span>";
						else						$epsGapTxt = "<br>-";

						$epsGap2 = $v['epsGap2'];
						if($epsGap2 < 0)			$epsGap2Txt = "<br><span class='blue'>".$epsGap2."%</span>";
						elseif($epsGap2 > 0)	$epsGap2Txt = "<br><span class='red'>+".$epsGap2."%</span>";
						else							$epsGap2Txt = "<br>-";
				?>
					<td>
					<?
						if($v['disChk'])	echo 'N/A';
						else					echo $v['epsActual'].' '.$epsGap2Txt.' '.$epsGapTxt;
					?>
					</td>
				<?
					}
				?>
				</tr>
				<tr>
					<th>매출액<br>컨센대비<br>전분기(전년)대비</th>
				<?
					foreach($item as $v){
						$revenueGap = $v['revenueGap'];
						if($revenueGap < 0)			$revenueGapTxt = "<br><span class='blue'>".$revenueGap."%</span>";
						elseif($revenueGap > 0)	$revenueGapTxt = "<br><span class='red'>+".$revenueGap."%</span>";
						else								$revenueGapTxt = "<br>-";

						$revenueGap2 = $v['revenueGap2'];
						if($revenueGap2 < 0)		$revenueGap2Txt = "<br><span class='blue'>".$revenueGap2."%</span>";
						elseif($revenueGap2 > 0)	$revenueGap2Txt = "<br><span class='red'>+".$revenueGap2."%</span>";
						else								$revenueGap2Txt = "<br>-";
				?>
					<td>
					<?
						if($v['disChk'])	echo 'N/A';
						else					echo $v['revenueActual'].' '.$revenueGap2Txt.' '.$revenueGapTxt;
					?>
					</td>
				<?
					}
				?>
				</tr>
			</tbody>
		</table>
	</div>