<div class="ticker_section">
	<div class="dp_f">
		<ul class="s_tabBtn dp_f">
			<li class="on"><a class="dp_f dp_c dp_cc" href="" title="">연간(annual)</a></li>
			<li><a class="dp_f dp_c dp_cc" href="" title="">분기별(quarterly)</a></li>
			<li><a class="dp_f dp_c dp_cc" href="" title="">과거12개월(TTM)</a></li>
		</ul>
		<ul class="noneBtn dp_f">
			<li class="off"><a class="dp_f dp_c dp_cc" href="javascript:void(0);" title="" style='cursor:default;'>올해(ytd)</a></li>
		</ul>
	</div>
	<div class="s_tabContWrap">
		<div class="s_tabCont">
			<div class="annual">
			<?
				//연간(annual)
				include 'incomeStateList01.php';
			?>
			</div>
		</div>
		<div class="s_tabCont">
			<div class="quarterly">
			<?
				//분기별(quarterly)
				include 'incomeStateList02.php';
			?>
			</div>
		</div>
		<div class="s_tabCont">
			<div class="ttm">
			<?
				//과거12개월(TTM)
				include 'incomeStateList03.php';
			?>
			</div>
		</div>
	</div>

	<div style='float:right;margin-top:10px;'><img src='/img/scroll_hand.gif' style='width:40px;'></div>

	<script>
			$(".s_tabBtn > li").on("click",function(event){

				event.preventDefault();

				let tabNumber = $(this).index();

				$(".s_tabBtn > li").removeClass("on");
				$(this).addClass("on");

				$(".s_tabContWrap .s_tabCont").hide();
				$(".s_tabContWrap .s_tabCont").eq(tabNumber).show();

			});
	</script>
	<style>
		.s_tabBtn li,
		.noneBtn li {margin-right: 10px; margin-bottom: 30px;}
		.noneBtn li:last-child {margin-right: 0;}
		.s_tabBtn li a,
		.noneBtn li a {width: 150px; padding: 10px 0; border-radius: 45px; color: #fff; background-color: #3146a9;}
		.s_tabBtn li.on a {background-color:#0c1540;}
		.noneBtn li.off a {opacity:0.5;}
		.s_tabContWrap .s_tabCont {display: none;}
		.s_tabContWrap .s_tabCont:nth-child(1) {display: block;}
		.s_tabContWrap .subtable th.widFix01 {width: 260px;}
		.s_tabContWrap .subtable th.widFix02 {width: 110px;}
	</style>
</div>