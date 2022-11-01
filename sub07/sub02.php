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
			$subBtn02 = 2;	//편입종목
			include 'tabMenu.php';
		?>	

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">
				<div class="ticker_section">
				<?
					//편입 종목
					include 'etfTransfer01.php';

					//편입종목 섹터비중 & 편입종목 국가비중
					include 'etfTransfer02.php';
				?>
				</div>
			</div>
		</div>

	</div>
</div>


<?
	include '../footer.php';
?>