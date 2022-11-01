<?
	include '../header.php';
?>

<style>
/* 	.diary_nav_sub {display: block;} */
	.tableWrap {margin-top: 20px;}
</style>

<div id="sub_cont">
	<div class="sub_center">
		
		<?
			include 'tabMenu.php';
		?>

		<h3 class="sub_tit">
			미국 증시 실적발표, 배당락, IPO 등을 확인하세요
		</h3>
		<div class="calendarCheck dp_f dp_cc">
			<?
				include 'investquote.php';
			?>
			<div class="ameriCalTop">
				<div class="calChkWrap">
					<div class="calChk">
						<input type="checkbox" name="dataType" id="dt1" class="dataType" value="mySymbol">
						<label for="dt1">관심종목만 보기</label>
					</div>
					<div class="calChk">
						<input type="checkbox" name="dataType" id="dt2" class="dataType" value="myDiary">
						<label for="dt2">작성한 다이어리</label>
					</div>
					<div class="calChk">
						<input type="checkbox" name="dataType" id="dt3" class="dataType" value="earnings">
						<label for="dt3">실적발표</label>
					</div>
					<div class="calChk">
						<input type="checkbox" name="dataType" id="dt4" class="dataType" value="dividends">
						<label for="dt4">배당</label>
					</div>
					<div class="calChk">
						<input type="checkbox" name="dataType" id="dt5" class="dataType" value="ipo" checked="">
						<label for="dt5">IPO</label>
					</div>
<!-- 					<div class="calChk">
						<input type="checkbox" name="dataType" id="dt6" class="dataType" value="ok">
						<label for="dt6">적정주가 도달주식</label>
					</div> -->
				</div>
			</div>
		</div>

		<div class="calendarWrap">
			<div class="whtBg"></div>
			<!-- 달력 -->
			<iframe name="ifra_calendar" id="ifra_calendar" src="../calendar.php?path=sub04-sub01" style="width:100%;margin-bottom:160px;" frameborder="0" scrolling="no" onload="iFrameHeight('ifra_calendar')"></iframe>
			<!-- /달력 -->

		</div>			
	</div>
</div>

<script>
$(function(){
	$('.dataType').click(function(){
		c = $(this).is(":checked");
		d = $(this).attr('id');

		if(c){
			$('.dataType').each(function(){
				if($(this).attr('id') != d){
					$(this).prop('checked', false);
				}
			});

			//아이프레임내 체크박스 컨트롤
			$('#ifra_calendar').contents().find('.dataType').prop('checked', false);
			$('#ifra_calendar').contents().find('#'+d).prop('checked', true);

			$('#ifra_calendar').contents().find('#frm_cals').submit();


		}else{
			$(this).prop('checked', true);
		}		
	});
});

 $(window).scroll(function(){
	 if (matchMedia("screen and (min-width: 1200px)").matches) {
		var height = $(document).scrollTop(); //실시간으로 스크롤의 높이를 측정
		if(height < 500){
		  $('.calendarCheck').removeClass('scroll_tabs');
		}else if(height > 500){
		  $('.calendarCheck').addClass('scroll_tabs')
		};
	  };
  });
</script>

<?
	include '../footer.php';
?>