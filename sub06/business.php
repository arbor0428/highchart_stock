<?
//최근실적
$row01 = sqlRow("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and epsActual!=0 order by dateTime desc limit 1");
$epsEstimate = round($row01['epsEstimate'],2);		//이익(예상)
$epsActual = round($row01['epsActual'],2);				//이익(실제)
$epsGap = Util::fnPercent($epsEstimate,$epsActual);

$revenueEstimate = round($row01['revenueEstimate'],2);	//매출(예상)
$revenueActual = round($row01['revenueActual'],2);			//매출(실제)
$revenueGap = Util::fnPercent($revenueEstimate,$revenueActual);

$revenueEstimateCut = round(($revenueEstimate / 100000000),2);
$revenueActualCut = round(($revenueActual / 100000000),2);

$revenueEstimateWon = Util::num_to_han_s($revenueEstimateCut * $exRate,5);		//원화적용
$revenueActualWon = Util::num_to_han_s($revenueActualCut * $exRate,5);				//원화적용


//다음분기실적(예상)
$row02 = sqlRow("select * from api_Earnings_Calendar where symbol='".$gbl_symbol."' and dateTime>'".$row01['dateTime']."' order by dateTime asc limit 1");
$epsEstimateNext = $row02['epsEstimate'];
$epsGapNext = Util::fnPercent($epsActual,$epsEstimateNext);

$revenueEstimateNext = $row02['revenueEstimate'];
$revenueEstimateNextCut = round(($revenueEstimateNext / 100000000),2);
$revenueNext = Util::fnPercent($revenueActualCut,$revenueEstimateNextCut);
?>

<div class="ticker_section">
	<h3 class="sub_tit">벌어들여 오는 실적도 따져 보아야겠죠?</h3>
	<div class="epsBeWrap dp_sb">
		<div class="epsBeBox epsBox01">
			<table class="subtable">
				<tbody>
					<tr>
						<th>
							최근실적 발표일<br>
							<span><?=$row01['date']?></span>
						</th>
						<th>예상</th>
						<th>실제</th>
						<th>등락율</th>
					</tr>
					<tr>
						<th>이익(EPS)</th>
						<td>$<?=$epsEstimate?></td>
						<td>$<?=$epsActual?></td>
						<td>
						<?if($epsGap > 0){?>
							<span class="red">+<?=$epsGap?>%</span>
						<?}elseif($epsGap < 0){?>
							<span class="blue">-<?=$epsGap?>%</span>
						<?}?>
						</td>
					</tr>
					<tr>
						<th>매출</th>
						<td>
							<?=$revenueEstimateCut?>억 달러<br>
							(<?=$revenueEstimateWon?>원)
						</td>
						<td>
							<?=$revenueActualCut?>억 달러<br>
							(<?=$revenueActualWon?>조원)
						</td>
						<td>
						<?if($revenueGap > 0){?>
							<span class="red">+<?=$revenueGap?>%</span>
						<?}elseif($revenueGap < 0){?>
							<span class="blue"><?=$revenueGap?>%</span>
						<?}?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="epsBeBox epsBox02">
			<table class="subtable">
				<tbody>
					<tr>
						<th colspan="2">다음 분기 실적(예상)</th>
					</tr>
					<tr>
						<td>실적발표일</td>
						<td><?=$row02['date']?></td>
					</tr>
					<tr>
						<td>예상 EPS</td>
						<td>
							<?=round($epsEstimateNext,2)?> 달러
							
						<?if($epsGapNext > 0){?>
							(전분기대비 :<span class="red"><?=$epsGapNext?>%</span>)
						<?}elseif($epsGapNext < 0){?>
							(전분기대비 :<span class="blue"><?=$epsGapNext?>%</span>)
						<?}?>
						</td>
					</tr>
					<tr>
						<td>예상 매출</td>
						<td>
						<?=$revenueEstimateNextCut?>억 달러
						<?if($revenueNext > 0){?>
							(전분기대비:<span class="red"><?=$revenueNext?>%</span>)
						<?}elseif($revenueNext < 0){?>
							(전분기대비:<span class="blue"><?=$revenueNext?>%</span>)
						<?}?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<p class="sub_tit_det" style="margin-left: 0;">예상 매출 / 예상 영업이익(EPS)</p>
	<div id='epsGroup'>
	<?
		//이익(EPS) & 매출
		include 'epsData.php';
	?>
	</div>


	<div id='cashGroup'>
	<?
		//영업현금흐름 & 기업부채
		include 'cashData.php';
	?>
	</div>
</div>