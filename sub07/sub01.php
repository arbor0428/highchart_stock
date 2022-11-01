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
			$subBtn02 = 1;	//전반분석
			include 'tabMenu.php';
		?>	

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">
				<div class="ticker_section">
				<?
					//그래프 & 이것만은 꼭 기업하세요!
					include 'stockChart.php';
				?>

				<div class="openHide" style="margin-bottom: 20px; border-radius: 40px; width: 150px; height: 40px; line-height: 40px; text-align: center; color: #fff; background-color: #0c1540;">
					회사개요 접기
				</div>

				<div class="tickerDetailInfo" style="margin-bottom: 0;">
					<div class="ora_line"></div>
					<div class="detail_wrap">
						<div class="txtBox">
							<div class="titWrap">
								<p class="ticker_tit"><?=$gbl_symbol?></p>
								<p class="ticker_sub"><?=$row01['nameKor']?><br><?=$row01['name']?></p>
							</div>
							<p class="ticker_det"><?=str_replace('주식','자산',$row01['descriptionKor'])?></p>
						</div>
					</div>
				</div>

				<script>
					var flag = true;
					$(".openHide").on("click",function(){

						if(flag){

							$(".tickerDetailInfo").stop().slideUp();
							$(".openHide").text("회사개요 펼치기");
							flag= false;
						} else {

							$(".tickerDetailInfo").stop().slideDown();
							$(".openHide").text("회사개요 접기");
							flag= true;
						}

					});
				</script>

				<?
					//OOO은 이러한 종목입니다 & 숫자로 보는 OOO
					include 'twoTblWrap.php';

					//total return
					include 'totalReturn.php';
				?>


				</div>
			</div>
		</div>
	</div>
</div>


<?
	include '../footer.php';
?>