<div class="option_sideBar">
	<div class="sideBar_top">
		<p>주식 필터링</p>
	</div>
	<div class="sideBar_bot">
		<div class="typeBox">
				<h4 class="main_type">자산운영규모</h4>
				<div class="side_choice">
					<input id="sc_chk1" type="checkbox" checked><label for="sc_chk1">50B 이상</label>
				</div>
				<div class="side_choice">
					<input id="sc_chk2" type="checkbox"><label for="sc_chk2">10~50B</label>
				</div>
				<div class="side_choice">
					<input id="sc_chk3" type="checkbox"><label for="sc_chk3">2~10B</label>
				</div>
				<div class="side_choice">
					<input id="sc_chk4" type="checkbox"><label for="sc_chk4">0.5~2B</label>
				</div>
				<div class="side_choice">
					<input id="sc_chk5" type="checkbox"><label for="sc_chk5">0.1~0.5B</label>
				</div>
				<div class="side_choice">
					<input id="sc_chk6" type="checkbox"><label for="sc_chk6">0.1B 미만</label>
				</div>
		</div>
		<div class="typeBox">
			<h4 class="main_type">수수료율</h4>
			<div class="side_choice">
				<input id="sc_chk1" type="checkbox" checked><label for="sc_chk1">1% 이상</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk2" type="checkbox" checked><label for="sc_chk2">0.5%~1%</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk3" type="checkbox" checked><label for="sc_chk3">0.3%~0.5%</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk4" type="checkbox" checked><label for="sc_chk4">0.2%~0.3%</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk5" type="checkbox" checked><label for="sc_chk5">0.1%~0.2%</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk6" type="checkbox" checked><label for="sc_chk6">0.1% 미만</label>
			</div>
		</div>
		<div class="typeBox">
			<h4 class="main_type">평균거래량</h4>
			<div class="side_choice">
				<input id="sc_chk1" type="checkbox" checked><label for="sc_chk1">5,000만 이상</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk2" type="checkbox" checked><label for="sc_chk2">1,000만~5,000만</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk3"  type="checkbox" checked><label for="sc_chk3">200만~1,000만</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk4" type="checkbox" checked><label for="sc_chk4">50만~200만</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk5" type="checkbox" checked><label for="sc_chk5">10만~50만</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk6" type="checkbox" checked><label for="sc_chk6">10만 미만</label>
			</div>
		</div>
		<div class="typeBox">
			<h4 class="main_type">한주당 가격</h4>
			<div class="side_choice">
				<input id="sc_chk1"" type="checkbox" checked><label for="sc_chk1">200$ 이상</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk2" type="checkbox" checked><label for="sc_chk2">100$~200$</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk3"  type="checkbox" checked><label for="sc_chk3">50$~100$</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk4" type="checkbox" checked><label for="sc_chk4">20$~50$</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk5" type="checkbox" checked><label for="sc_chk5">10$~20$</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk6" type="checkbox" checked><label for="sc_chk6">10$ 미만</label>
			</div>
		</div>
		<a class="submitBtn dp_f dp_cc dp_c" href="" title="">적용하기</a>
	</div>
	<div class="openClose"><img src="../img/sideArrow_next.svg"></div>
</div>

<style>
	.option_sideBar {position:fixed; height: 100vh;left:0; top:0; z-index: 99;}
	.openClose {position: absolute; right:-50px; top: 50%; transform: translateY(-50%); width: 50px; height: 70px; background-color: #74757c; text-align: center; /* background-image:url("../img/sideArrow.svg"); background-repeat: no-repeat; background-position: center center; background-size: contain;  */cursor:pointer; }
	.openClose img {position: absolute; top: 50%; left: 50%; transform: rotate(180deg) translate(50%,50%); width: 20px;}
	.sideBar_bot {width: 265px;  overflow-y: scroll; height: calc(100vh - 110px); }	
</style>

<script>
    $(window).on("load",function(){

        $(".option_sideBar").stop().animate({"left":"-265px"},2000);
		$(".openClose img").css({"transform":"rotate(0deg) translate(-50%,-50%)"});

    });

	var ftrue = true;
	$(".openClose").click(function(){

		if(ftrue){
		  $(".option_sideBar").stop().animate({"left":"0"},1000);
		   $(".openClose img").css({"transform":"rotate(180deg) translate(50%,50%)"});

			ftrue= false;
		} else {
		   $(".option_sideBar").stop().animate({"left":"-265px"},1000);
		   $(".openClose img").css({"transform":"rotate(0deg) translate(-50%,-50%)"});

			ftrue= true;
		}
	});
</script>