<script>
function dividendCall(r){
	$('#loading').show();
	$('#dividendTable').load('/sub01/dividendList.php?jQueryLoad=1&diviDate='+r);
	var offset = $("#dividendTable").offset();
	var menuHeight =$("header").offsetHeight;
	$('html, body').animate({scrollTop : offset.top - 250}, 400);
}
</script>




<div id="cont2" class="dividend_box">

	<!-- 달력 -->
	<iframe name="ifra_calendar" id="ifra_calendar" src="../calendar.php?path=sub01-sub02" style="width:100%;margin-bottom:160px;" frameborder="0" scrolling="no" onload="iFrameHeight('ifra_calendar')"></iframe>
	<!-- /달력 -->
	
	<div class="ex_dividend_calendar">
		<div class="sec_etf_wrap" id="dividendTable">			
		<?
			//선택된 일자의 배당주정보
			include 'dividendList.php';
		?>
		</div>
	</div>
</div>