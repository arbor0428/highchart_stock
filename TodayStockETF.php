<div class="etf_wrap">
	<ul class="etf_tab_btn">
		<li class="on">주식</li>
		<li>ETF</li>
	</ul>
	<div class="tab_select">
	<?
		//주식
		include 'TabStock.php';

		//ETF
		include 'TabETF.php';
	?>
	</div>
</div>

<script>
$(".etf_tab_btn > li:nth-child(1)").click(function(event){
	event.preventDefault();

	$(".etf_tab_btn > li").removeClass("on");
	$(this).addClass("on");

	$(".tab_select .etf_tab_wrap").stop().hide();
	$(".tab_select .etf_tab_wrap01").stop().show();
});

$(".etf_tab_btn > li:nth-child(2)").click(function(event){
	event.preventDefault();

	$(".etf_tab_btn > li").removeClass("on");
	$(this).addClass("on");

	$(".tab_select .etf_tab_wrap").stop().hide();
	$(".tab_select .etf_tab_wrap02").stop().show();
});
</script>