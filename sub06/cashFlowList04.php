<?
	$cArr = Array("capex","cashDividendsPaid","cashInterestPaid","cashTaxesPaid","changeinCash","changesinWorkingCapital","deferredTaxesInvestmentTaxCredit","depreciationAmortization","issuanceReductionCapitalStock","issuanceReductionDebtNet","netCashFinancingActivities","netIncomeStartingLine","netInvestingCashFlow","netOperatingCashFlow","otherFundsFinancingItems","otherFundsNonCashItems","otherInvestingCashFlowItemsTotal","period");

	$row = sqlArray("select * from api_Financial_Statements_cf_ytd where symbol='".$gbl_symbol."' order by period");

?>

<div style="width: 100%; overflow-x: scroll;">
	<table class="subtable" style="table-layout: fixed;">
		<tbody>
			<tr>
				<th class="widFix01">올해(ytd)</th>
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
				if($c == 'period')		$unit = "";
				else						$unit = "<br>(백만 달러)";
		?>
			<tr>
				<td><?=$c?><?=$unit?></td>
			<?
				foreach($row as $v){
					if($c == 'period')		$vars_ = $v[$c];
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