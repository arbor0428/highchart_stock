<?
	include '../header.php';

	//심볼체크
	include 'symbolCheck.php';
?>

<div id="sub_cont">
	<div class="inner">
		<?
			include 'ticker_top.php';

			$tabBtn = 1;	//종목정보
			$subBtn = 1;	//전반분석
			include 'tabMenu.php';
		?>	

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">
				<?
					include 'totalAnalysis.php';
				?>
			</div>
		</div>

	</div>
</div>


<?
	include '../footer.php';
?>