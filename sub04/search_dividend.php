<?
	include '../head2.php';

	$call_page = 'GroupPortfolio';
?>


<div id="cont3" class="dividend_box">
	<?
		//배당주 검색
		include '../sub01/dividend_search.php';
	?>

	<div class="ex_dividend_result">
		<div id='dividend_listTable' class="sec_etf_wrap">
		<?
			//배당주 검색결과
			include '../sub01/dividend_result.php';
		?>
		</div>
	</div>
</div>