<?
	include '../header.php';
?>

<style>
.pTable td{text-align:right;}
</style>

<form name='frm' id='frm' method='post' action="<?=$_SERVER['PHP_SELF']?>">

<div id="sub_cont">
	<div class="busiAnalWrap">
	<h3>예상 매출 / 예상 영업이익(EPS)</h3>
<?
	$gbl_symbol = 'AAPL';

	if(!$f_period)	$f_period = '10';
	if(!$f_type)		$f_type = 'quarter';


	//분기
	if($f_type == 'quarter'){
		if($f_period == '1')			$sTime = strtotime('-1 years');
		elseif($f_period == '3')		$sTime = strtotime('-3 years');
		elseif($f_period == '5')		$sTime = strtotime('-5 years');
		elseif($f_period == '10')	$sTime = strtotime('-10 years');

		$eTime = time();

		$row = sqlArray("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and dateTime>'".$sTime."' and dateTime<='".$eTime."' order by dateTime");

		$item = Array();
		$c = 0;

		foreach($row as $v){
			$epsActual = round($v['epsActual'],2);
			$revenueActual = round($v['revenueActual'] / 100000000,2);

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

			$c++;
		}

	//연간
	}elseif($f_type == 'year'){
		if($f_period == '1')			$sYear = date('Y') - 1;
		elseif($f_period == '3')		$sYear = date('Y') - 3;
		elseif($f_period == '5')		$sYear = date('Y') - 5;
		elseif($f_period == '10')	$sYear = date('Y') - 10;

		$eTime = time();

		$row = sqlArray("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and date>='".$sYear."' and dateTime<='".$eTime."' order by dateTime");

		$item = Array();

		foreach($row as $v){
			$y = date('Y',$v['dateTime']);
			$epsActual = round($v['epsActual'],2);
			$revenueActual = round($v['revenueActual'] / 100000000,2);

			$item[$y]['date'] = $y;
			$item[$y]['epsActual'] += $epsActual;
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
		}
	}
?>

		<select name='f_period' id='f_period' onchange="$('#frm').submit();">
			<option value='1' <?if($f_period == '1'){echo 'selected';}?>>1년</option>
			<option value='3' <?if($f_period == '3'){echo 'selected';}?>>3년</option>
			<option value='5' <?if($f_period == '5'){echo 'selected';}?>>5년</option>
			<option value='10' <?if($f_period == '10'){echo 'selected';}?>>10년</option>
		</select>

		<select name='f_type' id='f_type' onchange="$('#frm').submit();">
			<option value='quarter' <?if($f_type == 'quarter'){echo 'selected';}?>>분기</option>
			<option value='year' <?if($f_type == 'year'){echo 'selected';}?>>연간</option>
		</select>

		<table cellpadding='0' cellspacing='0' border='0' width='100%' class='subtable'>
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
</div>

</form>

<?
	include '../footer.php';
?>