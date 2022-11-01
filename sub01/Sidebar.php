<div class="option_sideBar">
	<div class="sideBar_top">
		<p>주식 필터링</p>
	</div>
	<div class="sideBar_bot">
		<div class="typeBox">
				<h4 class="main_type">지수 편입 종목</h4>
				<div class="side_choice">
					<input id="sc_rd1" type="radio" checked><label for="sc_rd1">S & P 500</label>
				</div>
				<div class="side_choice">
					<input id="sc_rd2" type="radio"><label for="sc_rd2">나스닥 100</label>
				</div>
				<div class="side_choice">
					<input id="sc_rd3" type="radio"><label for="sc_rd3">Rusell 2000</label>
				</div>
				<div class="side_choice">
					<input id="sc_rd4" type="radio"><label for="sc_rd4">미국주식 전체</label>
				</div>
		</div>
		<div class="typeBox">
			<h4 class="main_type">시가 총액</h4>
			<div class="side_choice">
				<input id="sc_rd1" type="radio"><label for="sc_rd1">Mega(2,000억달러 이상)</label>
			</div>
			<div class="side_choice">
				<input id="sc_rd2" type="radio"><label for="sc_rd2">Large(100억~2,000억달러)</label>
			</div>
			<div class="side_choice">
				<input id="sc_rd3" type="radio"><label for="sc_rd3">Medium(20억~100억달러)</label>
			</div>
			<div class="side_choice">
				<input id="sc_rd4" type="radio"><label for="sc_rd4">Small(3억~20억달러)</label>
			</div>
			<div class="side_choice">
				<input id="sc_rd4" type="radio"><label for="sc_rd4">Micro(3억달러 미만)</label>
			</div>
		</div>
		<div class="typeBox">
			<h4 class="main_type">전문가 의견</h4>
			<div class="side_choice">
				<input id="sc_chk1" type="checkbox" checked><label for="sc_chk1">강력매수 : 4.5 이상</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk2" type="checkbox" checked><label for="sc_chk2">매수 이상 : 3.5 ~ 4.5</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk3" type="checkbox"><label for="sc_chk3">중립 이상 : 2.5 ~ 3.5</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk4" type="checkbox"><label for="sc_chk4">중립 미만 : 2.5 미만</label>
			</div>
		</div>
		<div class="typeBox">
			<h4 class="main_type">한주당 가격</h4>
			<div class="side_choice">
				<input id="sc_chk1"" type="checkbox" checked><label for="sc_chk1">10 미만</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk2" type="checkbox" checked><label for="sc_chk2">10 ~ 20 미만</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk3"  type="checkbox" checked><label for="sc_chk3">20 ~ 30 미만</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk4" type="checkbox" checked><label for="sc_chk4">30 ~ 50 미만</label>
			</div>
			<div class="side_choice">
				<input id="sc_chk5" type="checkbox" checked><label for="sc_chk5">50이상</label>
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
	.sideBar_bot {width: 265px; overflow-y: scroll; height: calc(100vh - 110px); }	
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