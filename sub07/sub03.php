<?
	include '../header.php';

	//심볼체크
	include 'symbolCheck.php';
?>

<div id="sub_cont">
	<div class="inner">
		<?
			include 'ticker_top.php';

			$tabBtn02 = 1;	//ETF정보
			$subBtn02 = 3;	//MDD
			include 'tabMenu.php';
		?>	

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">
				<?
					include 'mainCopymdd.php';
				?>
			</div>
		</div>

	</div>
</div>


<?
	include '../footer.php';
?>