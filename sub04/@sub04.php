<?
	include '../header.php';
?>

<style>
/* 	.diary_nav_sub {display: block;} */
</style>

<div id="sub_cont">
	<div class="sub_center">
		<?
			include 'investquote.php';
		?>

		<div class="inter_searchWrap">
			<select>
				<option>바로 가기</option>
			</select>
			<div class="editWrite_wrap">
				<!-- 	<a href="">수정하기</a>  -->
				<a href="">새로 작성하기</a>
			</div>
		</div>

		<!---------------포트폴리오 list 페이지----------------->
		<?
			include 'portfolio_list.php';
		?>

		<!----------------포트폴리오 view 페이지---------------->

		<?
			include 'portfolio_view.php';
		?>


	</div>
</div>

<?
	include '../footer.php';
?>