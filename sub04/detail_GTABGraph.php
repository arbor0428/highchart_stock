<script src="/module/js/highchart/stock-tools.js"></script>

<style>
.halfDetail  {width: 49.5%; border-radius: 4px; padding: 10px; border:1px solid #ddd; box-sizing: border-box;}
</style>

<div class="dp_sb dp_wrap" style="margin-bottom: 80px;">
<?
if($row){
	foreach($row as $k => $v){
		$symbol = $v['symbol'];
		$etf = $v['etf'];
?>
	<div class="halfDetail" style="margin: 15px 0;">
	<?
		include 'jonmokTop.php';

		$graphID = 'lineBarChart'.$k;
		$graphSymbol = $symbol;
		include 'jonmokBot.php';
	?>	
	</div>
<?
	}
}
?>
</div>

