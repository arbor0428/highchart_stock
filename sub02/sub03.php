<?
	include '../header.php';
?>

<div id="sub_cont">
	<?
		include 'Sidebar.php';
	?>
	<div class="sub_center">
		<div class="searchInvest">
			<?
				//검색
				include 'Invest_Inverse_search.php';

				//검색결과
				include 'Invest_Inverse_result.php';
			?>
		</div>
	</div>
</div>

<?
	include '../footer.php';
?>