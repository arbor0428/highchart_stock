<?
	$cArr = Array("costOfGoodsSold","dilutedAverageSharesOutstanding","dilutedEPS","ebit","grossIncome","interestIncomeExpense","netIncome","netIncomeAfterTaxes","period","pretaxIncome","provisionforIncomeTaxes","researchDevelopment","revenue","sgaExpense","totalOperatingExpense","totalOtherIncomeExpenseNet");

	$row = sqlArray("select * from api_Financial_Statements_ic_annual where symbol='".$gbl_symbol."' order by year");

?>

<div style="width: 100%; overflow-x: scroll;">
	<table class="subtable" style="table-layout: fixed;">
		<tbody>
			<tr>
				<th class="widFix01">해당연도(year)</th>
			<?
				foreach($row as $k => $v){
			?>
				<th class="widFix02"><?=$v['year']?></th>
			<?
				}
			?>
			</tr>

		<?
			foreach($cArr as $c){
				if($c == 'dilutedAverageSharesOutstanding')	$unit = "<br>(백만 주)";
				elseif($c == 'dilutedEPS')	$unit = "";
				elseif($c == 'period')	$unit = "";
				else						$unit = "<br>(백만 달러)";
		?>
			<tr>
				<td><?=$c?><?=$unit?></td>
			<?
				foreach($row as $v){
					if($c == 'dilutedEPS')	$vars_ = round($v[$c],2);
					elseif($c == 'period')		$vars_ = $v[$c];
					else							$vars_ = number_format($v[$c]);
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