<?
$item = sqlRow("select * from Stock_Candles_Last where symbol='".$gbl_symbol."'");
?>

<div class="etfGroup">
	<h3 class="sub_tit">Total Return</h3>
	<table class="subtable">
		<tbody>
			<tr>
				<th>Fund</th>
				<th>1m</th>
				<th>3m</th>
				<th>6m</th>
				<th>YTD</th>
				<th>1y</th>
				<th>3y</th>
				<th>5y</th>
				<th>10y</th>
				<th>Since Inception</th>
			</tr>
			<tr>
				<td><?=$gbl_symbol?></td>
				<td><?=$item['pmDataMonth']?>%</td>
				<td><?=$item['pmDataMonth3']?>%</td>
				<td><?=$item['pmDataMonth6']?>%</td>
				<td><?=$item['pmDataYearFirst']?>%</td>
				<td><?=$item['pmDataYear1']?>%</td>
				<td><?=$item['pmDataYear3']?>%</td>
				<td><?=$item['pmDataYear5']?>%</td>
				<td><?=$item['pmDataYear10']?>%</td>
				<td>N/A</td>
		</tbody>
	</table>
</div>