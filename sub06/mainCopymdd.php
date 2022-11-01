<?
	//달력
	include '../module/datepicker/Calendar.php';
?>

<section class="cont05" style="margin-top: 100px;">
	<h3 class="sub_tit">
		MDD를 모르면 고점에 물려 고생할 수 있어요!
	</h3>

	<div class="mdd_wrap mb20">
	<?
		//종목 추가 및 데이터 테이블
		include '../mddTable.php';
	?>
	</div>

	<div class="mdd_wrap tabCont">
		<div class="mdd_box brwrap mdd_box01">
			<div class="mdd_top mddTop_flex">
				MDD 차트
				<div class="cal_select" style='display:none;'>
					<div class="calOpenBtn_s">
						<span>날짜 선택</span>
					</div>
					<div class="calFromTo_s">
						<div class="dateWrap">
							<div class="dateBox">
								<input type="text" name="mddSdate2" id="mddSdate2" value="<?=$mddSdate?>" class="fpicker" placeholder="시작하는 날짜(From)" autocomplete="off">
								<img src="../img/cal_sel.png">
							</div>
							<span>~</span>
							<div class="dateBox">
								<input type="text" name="mddEdate2" id="mddEdate2" value="<?=$mddEdate?>" class="fpicker" placeholder="끝나는 날짜(To)" autocomplete="off">
								<img src="../img/cal_sel.png">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mdd_bot pos_rel tabGraph01">
			<?
				include '../mddChart01.php';
				//include 'graph04.php';
			?>
			</div>
		</div>
		<div class="mdd_box brwrap mdd_box02">
			<div class="mdd_top">
				전고점 대비 하락폭 별 상승확률
			</div>
			<div class="mdd_bot pos_rel tabGraph02">
			<?
				include '../mddChart02.php';
				//include 'graph05.php';
			?>
			</div>
		</div>
	</div>
	<div class="mdd_wrap">
		<div class="mdd_box brwrap mdd_box01">
		<?
			include '../snp_mdd.php';
		?>
		</div>

		<div class="mdd_box brwrap mdd_box02">
			<div class="mdd_top">
				전고점 대비 하락폭 별 상승확률
			</div>
			<div class="mdd_bot pos_rel" style="height:240px;">
				<?
					include '../graph07.php';
				?>
			</div>
		</div>
	</div>


	<h3 class="sub_tit">대표지수 대비 종목 수익률</h3>
	<div class="mdd_wrap">

		<div class="mdd_box brwrap mdd_box01">
		<?
			include '../snp_pnl.php';
		?>
		</div>
		<div class="mdd_box mdd_box02">
			<table class="per_chart">
				<colgroup>
					<col style="width: 50%;">
					<col style="width: 50%;">
				</colgroup>
				<tbody>
					<tr>
						<th>티커</th>
						<th>수익률</th>
					</tr>
					<tr style="height:120px;">
						<td id='snpPnlTicker01'><?=$gbl_symbol?></td>
						<td id='snpPnlPer01'>+<?=$pnl01?>%</td>
					</tr>
					<tr style="height:120px;">
						<td id='snpPnlTicker02'>S&P 500</td>
						<td id='snpPnlPer02'>+<?=$pnl02?>%</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</section>

<script>
	$(function(){
		//select open & close
		$(".toggle_select").on("click",function(){
			if($(this).next(".select_btn").css("display") == "none"){
				$(this).next(".select_btn").stop().slideDown();
			} else {
				$(this).next(".select_btn").stop().slideUp();
			}
		});

		//날짜선택
		$(".calOpenBtn_s").click(function(){
			if($(this).next(".calFromTo_s").css("display") == "none"){
				$(this).next(".calFromTo_s").show();
			}else{
				$(this).next(".calFromTo_s").hide();
			}
		});
	});
</script>

<style>
	.datepicker.dropdown-menu {margin-top: 130px;}
</style>