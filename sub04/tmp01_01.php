<?
	include '../header.php';
?>

<style>
/* 	.diary_nav_sub {display: block;} */
	.tableWrap {margin-top: 20px;}
</style>

<div id="sub_cont">
	<div class="sub_center">
		

		<h3 class="sub_tit">
			손익계산서(연간)
		</h3>

		<?
			$row = sqlArray("select * from api_Financial_Statements_ic_annual where symbol='AAPL' order by year");
		?>
		
		<table cellpadding='0' cellspacing='0' border='0' width='100%' class='pTable'>
			<tr>
				<th>해당연도(year)</th>
			<?
				foreach($row as $v){
			?>
				<td><?=$v['year']?></td>
			<?
				}
			?>
			</tr>
		</table>

	</div>
</div>



<?
	include '../footer.php';
?>