<?
	include '../header.php';

	//달력
	include '../module/datepicker/Calendar.php';
?>

<div id="sub_cont">
	<?
		include 'Sidebar.php';
	?>
	<div class="sub_center">
		<div class="insiderTrade">
		<?
			//검색
			include 'insider_search.php';

			//리스트
			include 'insider_list.php';
		?>
		</div>
	</div>
</div>
<style>
	.datepicker.dropdown-menu {margin-top: 130px;}
</style>
<?
	include '../footer.php';
?>