<?
	$cArr = Array("costOfGoodsSold","dilutedAverageSharesOutstanding","dilutedEPS","ebit","grossIncome","interestExpIncNetOperatingTotal","interestIncomeExpense","minorityInterest","netIncome","netIncomeAfterTaxes","otherOperatingExpensesTotal","period","pretaxIncome","provisionforIncomeTaxes","revenue","sgaExpense","totalOperatingExpense","totalOtherIncomeExpenseNet");

	$row = sqlArray("select * from api_Financial_Statements_ic_quarterly where symbol='".$gbl_symbol."' order by period");

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
				if($c == 'dilutedAverageSharesOutstanding')	$unit = "<br>(백만 주)";
				elseif($c == 'dilutedEPS')	$unit = "";
				elseif($c == 'minorityInterest')	$unit = "";			
				elseif($c == 'period')			$unit = "";
				elseif($c == 'otherOperatingExpensesTotal')			$unit = "";
				else								$unit = "<br>(백만 달러)";
		?>
			<tr>
				<td><?=$c?><?=$unit?></td>
			<?
				foreach($row as $v){
					if($c == 'dilutedEPS')				$vars_ = round($v[$c],2);
					elseif($c == 'minorityInterest')		$vars_ =  $v[$c];
					elseif($c == 'period')					$vars_ = $v[$c];
					elseif($c == 'otherOperatingExpensesTotal')		$vars_ =  round($v[$c],2);
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