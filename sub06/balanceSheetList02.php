<?
	$cArr = Array("accountsPayable","accountsReceivables","accumulatedDepreciation","cash","cashEquivalents","cashShortTermInvestments","commonStock","currentAssets","currentLiabilities","currentPortionLongTermDebt","inventory","liabilitiesShareholdersEquity","longTermDebt","longTermInvestments","otherCurrentAssets","otherCurrentliabilities","otherEquity","otherLiabilities","otherLongTermAssets","otherReceivables","period","propertyPlantEquipment","retainedEarnings","sharesOutstanding","shortTermDebt","shortTermInvestments","tangibleBookValueperShare","totalAssets","totalDebt","totalEquity","totalLiabilities","totalReceivables");

	$row = sqlArray("select * from api_Financial_Statements_bs_quarterly where symbol='".$gbl_symbol."' order by period");

?>

<div style="width: 100%; overflow-x: scroll;">
	<table class="subtable" style="table-layout: fixed;">
		<tbody>
			<tr>
				<th class="widFix01">해당분기(quarter)</th>
			<?
				foreach($row as $k => $v){
			?>
				<th class="widFix02"><?=$v['period']?></th>
			<?
				}
			?>
			</tr>

		<?
			foreach($cArr as $c){
				if($c == 'period')	$unit = "";
				elseif($c == 'tangibleBookValueperShare')	$unit = '';
				else					$unit = "<br>(백만 달러)";
		?>
			<tr>
				<td><?=$c?><?=$unit?></td>
			<?
				foreach($row as $v){
					if($c == 'period')		$vars_ = $v[$c];
					elseif($c == 'tangibleBookValueperShare')	$vars_ = round($v[$c],2);
					else						$vars_ = number_format($v[$c]);

			?>
				<td><?=$vars_?></td>
			<?
				}
			?>
			</tr>
		<?
			}
		?>
		</tbody>
	</table>
</div>