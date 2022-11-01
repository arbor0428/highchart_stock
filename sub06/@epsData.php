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

//그래프 데이터
$epsX = '';
$epsData01 = '';		//예상이익
$epsData02 = '';		//실제이익
$epsData03 = '';		//실제이익(이전값 비교 증감율)

$revenueX = '';
$revenueData01 = '';		//예상매출
$revenueData02 = '';		//실제매출
$revenueData03 = '';		//실제매출(이전값 비교 증감율)

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

	$row = sqlArray("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and dateTime>'".$sTime."' and dateTime<='".$eTime."' order by dateTime");

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

			$revenueX .= ',';
			$revenueData01 .= ',';
			$revenueData02 .= ',';
			$revenueData03 .= ',';
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

		
		$epsData01 .= $epsEstimate;

		$revenueData01 .= $revenueEstimate;

		$item[$c]['date'] = date('Y.m',$v['dateTime']);
		$item[$c]['epsActual'] = $epsActual;
		$item[$c]['revenueActual'] = $revenueActual;

		if($c > 0){
			//이전값 대비 퍼센트
			$item[$c]['epsGap'] = Util::fnPercent($item[$c-1]['epsActual'],$epsActual);
			$item[$c]['revenueGap'] = Util::fnPercent($item[$c-1]['revenueActual'],$revenueActual);

		}else{
			$info = sqlRow("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and dateTime<'".$v['dateTime']."' order by dateTime desc limit 1");
			if($info){
				$item[$c]['epsGap'] = Util::fnPercent(round($info['epsActual'],2),$epsActual);
				$item[$c]['revenueGap'] = Util::fnPercent(round($info['revenueActual'] / 100000000,2),$revenueActual);
			}
		}

		if($item[$c]['epsGap'] > 0){
			$epsData02 .= "{y:".$epsActual.",dataLabels: {color: '#eb0828'}}";
			$epsData03 .= "+".$item[$c]['epsGap'];

		}else{
			$epsData02 .= "{y:".$epsActual.",dataLabels: {color: '#5689f5'}}";
			$epsData03 .= $item[$c]['epsGap'];
		}

		if($item[$c]['revenueGap'] > 0){
			$revenueData02 .= "{y:".$revenueActual.",dataLabels: {color: '#eb0828'}}";
			$revenueData03 .= "+".$item[$c]['revenueGap'];

		}else{
			$revenueData02 .= "{y:".$revenueActual.",dataLabels: {color: '#5689f5'}}";
			$revenueData03 .= $item[$c]['revenueGap'];
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

	$row = sqlArray("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and date>='".$sYear."' and dateTime<='".$eTime."' order by dateTime");

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
	}

	//이전값 대비 퍼센트
	for($i=$sYear; $i<=date('Y'); $i++){
		if($i > $sYear){
			$item[$i]['epsGap'] = Util::fnPercent($item[$i-1]['epsActual'],$item[$i]['epsActual']);
			$item[$i]['revenueGap'] = Util::fnPercent($item[$i-1]['revenueActual'],$item[$i]['revenueActual']);

		}else{
			$info = sqlRow("select sum(epsActual) as epsActualSum, sum(revenueActual) as revenueActualSum from api_Earnings_Calendar where symbol='".$gbl_symbol."' and year='".($i-1)."' order by dateTime");
			$epsActualSum = round($info['epsActualSum'],2);
			$revenueActualSum = round($info['revenueActualSum'] / 100000000,2);

			$item[$i]['epsGap'] = Util::fnPercent($epsActualSum,$item[$i]['epsActual']);
			$item[$i]['revenueGap'] = Util::fnPercent($revenueActualSum,$item[$i]['revenueActual']);
		}

		//그래프 데이터
		if($epsX){
			$epsX .= ',';
			$epsData01 .= ',';
			$epsData02 .= ',';
			$epsData03 .= ',';

			$revenueX .= ',';
			$revenueData01 .= ',';
			$revenueData02 .= ',';
			$revenueData03 .= ',';
		}
		$epsX .= "'".$i."'";
		$epsData01 .= $item[$i]['epsEstimate'];

		if($item[$i]['epsGap'] > 0){
			$epsData02 .= "{y:".$item[$i]['epsActual'].",dataLabels: {color: '#eb0828'}}";
			$epsData03 .= "+".$item[$i]['epsGap'];
		}else{
			$epsData02 .= "{y:".$item[$i]['epsActual'].",dataLabels: {color: '#5689f5'}}";
			$epsData03 .= $item[$i]['epsGap'];
		}

		$revenueX .= "'".$i."'";
		$revenueData01 .= $item[$i]['revenueEstimate'];

		if($item[$i]['revenueGap'] > 0){
			$revenueData02 .= "{y:".$item[$i]['revenueActual'].",dataLabels: {color: '#eb0828'}}";
			$revenueData03 .= "+".$item[$i]['revenueGap'];
		}else{
			$revenueData02 .= "{y:".$item[$i]['revenueActual'].",dataLabels: {color: '#5689f5'}}";
			$revenueData03 .= $item[$i]['revenueGap'];
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
					<th>영업이익</th>
				<?
					foreach($item as $v){
						$epsGap = $v['epsGap'];
						if($epsGap < 0)		$epsGapTxt = "(<span class='blue'>".$epsGap."%</span>)";
						elseif($epsGap > 0)	$epsGapTxt = "(<span class='red'>+".$epsGap."%</span>)";
						else						$epsGapTxt = '';
				?>
					<td><?=$v['epsActual']?> <?=$epsGapTxt?></td>
				<?
					}
				?>
				</tr>
				<tr>
					<th>매출액</th>
				<?
					foreach($item as $v){
						$revenueGap = $v['revenueGap'];
						if($revenueGap < 0)			$revenueGapTxt = "(<span class='blue'>".$revenueGap."%</span>)";
						elseif($revenueGap > 0)	$revenueGapTxt = "(<span class='red'>+".$revenueGap."%</span>)";
						else								$revenueGapTxt = '';
				?>
					<td><?=$v['revenueActual']?> <?=$revenueGapTxt?></td>
				<?
					}
				?>
				</tr>
			</tbody>
		</table>
	</div>