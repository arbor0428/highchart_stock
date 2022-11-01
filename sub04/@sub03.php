<?
	include '../header.php';
?>

<style>
	.diary_nav_sub {display: block;}
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

		<!---------------관심종목 list 페이지----------------->
		<?
			include 'inter_list.php';
		?>

		<!----------------관심종목 view 페이지---------------->

		<?
			include 'inter_view.php';
		?>
	</div>
</div>

<?
	include '../footer.php';
?>