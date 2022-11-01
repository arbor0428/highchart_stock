<?
	include '../header.php';
?>

<style>
header .h_bot .nav > li:nth-child(2) > a {    
	background-color: #e26f12;
    color: #0c1540;
    font-weight: 700;
}
header .nav_sub_wrap .nav_sub:nth-child(2) {
	display: block;
}
header .nav_sub_wrap .nav_sub:nth-child(2) .depth3_bg {
	display: block;
}

header .nav_sub_wrap .nav_sub:nth-child(2) .inner > ul > li:nth-child(2) .nav_depth3 {
	display: block;
}
</style>


<div id="sub_cont">
	<?
		include 'Sidebar.php';
	?>
	<div class="sub_center">
		<div class="dividend_wrap">
			<?
				//배당킹 & 배당귀족주
				include 'sub02_01.php';

				//캘린더 & 배당주 정보
				include 'sub02_02.php';

				//배당주 검색
				include 'sub02_03.php';
			?>
		</div>
	</div>
</div>

<script>
	//3차 메뉴를 눌렀을 때 스크롤 이동
    function fnMove(seq){
        var offset = $("#cont" + seq).offset();
		var menuHeight =$("header").offsetHeight;
        $('html, body').animate({scrollTop : offset.top - 250}, 400);
    }

	//3차 메뉴 눌렀을 때 색 변경
	$(".nav_depth3 > li").click(function(event){

		event.preventDefault();

		$(".nav_depth3 > li").removeClass("on");
		$(this).addClass("on");

	});

	//3차 메뉴 스크롤 시 색 변경
	$(window).scroll(function(){

		let scTop = $(this).scrollTop();

		let offset01 = $(".dividend_wrap #cont1").offset().top;
		let offset02 = $(".dividend_wrap #cont2").offset().top;
		let offset03 = $(".dividend_wrap #cont3").offset().top;

		$("header .nav_depth3 > li").removeClass("on"); 

		if(scTop <= offset01 + 20) {
			$("header .nav_depth3 > li:nth-child(1)").addClass("on"); 
		}
		else if(scTop >= offset02 - 300 && scTop < offset03 - 400) {
			$("header .nav_depth3 > li:nth-child(2)").addClass("on"); 
		}
		else if(scTop >= offset03 - 400) {
			$("header .nav_depth3 > li:nth-child(3)").addClass("on"); 
		}
	});

</script>

<?
	include '../footer.php';
?>