<?
	include '../header.php';

	$_GET['gbl_symbol'] = 'AAPL';
	$gbl_symbol = strtoupper($_GET['gbl_symbol']);
	$tmpChk = sqlRowOne("select * from ks_symbol where symbol='".$gbl_symbol."'");
	if(!$tmpChk){
		Msg::backMsg('접근오류');
		exit;
	}
?>

<div id="sub_cont">
	<div class="inner">
		<?
			include 'ticker_top.php';
		?>

		<div class="ticker_tabBtnWrap">
				<div class="ticker_tabBtn">
					<div class="tabBtn on">종목정보</div>
					<div class="tabBtn">재무제표</div>
				</div>

				<div class="ticker_subBtn">
					<ul class="subBtn on">
						<li class="on">전반분석</li>
						<li>전문가분석</li>
						<li>적정주가/MDD</li>
						<li>기업실적</li>
						<li>배당정보</li>
						<li>주주정보/내부자거래</li>
					</ul>
					<ul class="subBtn">
						<li>전반분석</li>
						<li>전문가분석</li>
						<li>적정주가/MDD</li>
						<li>기업실적</li>
						<li>배당정보</li>
						<li>주주정보/내부자거래</li>
					</ul>
				</div>
		</div>

		<script>
		 $(window).scroll(function(){
			 if (matchMedia("screen and (min-width: 1200px)").matches) {
				var height = $(document).scrollTop(); //실시간으로 스크롤의 높이를 측정
				if(height < 123){
				  $('.ticker_tabBtnWrap').removeClass('scroll_tabs');
				}else if(height > 123){
				  $('.ticker_tabBtnWrap').addClass('scroll_tabs')
				};
			  };
		  });
		</script>

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">
				<?
					//그래프 ~ 연관 ETF
					include 'totalAnalysis.php';

					//투자의견 / 목표주가
					include 'expertAnalysis.php';

					include 'properMDD.php';

					include 'business.php';

					include 'allocation.php';

					include 'stockholder.php';

				?>
			</div>
			<div class="ticker_tabBox">
				
			</div>
		</div>

	</div>
</div>


<?
	include '../footer.php';
?>