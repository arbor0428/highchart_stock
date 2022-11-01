<?
	include '../header.php';

	//심볼체크
	include 'symbolCheck.php';

	//달력
	include '../module/datepicker/Calendar.php';
?>

<div id="sub_cont">
	<div class="inner">
		<?
			include 'ticker_top.php';

			$tabBtn = 1;	//종목정보
			$subBtn = 6;	//주주정보/내부자거래
			include 'tabMenu.php';
		?>	

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">

			<?
				//이 많은 주식 · · · 누구의 손에 있는 걸까요?
				include 'stocksHand.php';
			?>

				<div id='insiderGroup'>
				<?
					if(!$f_symbol && !$f_sTxt)	$f_symbol = $gbl_symbol;

					if(!$f_sDate)	$f_sDate = date('Y-m-d', strtotime('-1 years'));

					//검색
					include '../sub01/insider_search.php';

					//리스트
					include '../sub01/insider_list.php';
				?>
				</div>
			</div>
		</div>

	</div>
</div>
<style>
	.datepicker.dropdown-menu {margin-top: 130px;}
</style>

<?
//내부자거래 페이지 스크롤
if($insiderChk){
?>
<script>
$(document).ready(function(){
	var offset = $("#insiderGroup").offset();
	$('html, body').animate({scrollTop : offset.top - 400}, 400);
});
</script>
<?
}
?>

<?
	include '../footer.php';
?>