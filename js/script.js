$(function(){

	//cursor:help; 내용 열기
	$(".help_point").on("mouseenter",function(event){

		event.preventDefault();

		$(".helpbox").hide();
		$(this).siblings(".helpbox").show();


	});
	//cursor:help; 내용 닫기
	$(".help_point").on("mouseleave",function(){

		$(".helpbox").hide();


	});

	//cursor:help; 내용 열기
	$(".help_point03").on("click",function(event){

		event.preventDefault();

		$(this).siblings(".helpbox").show();


	});
	//cursor:help; 내용 닫기
	$(".blue_tit").on("mouseleave",function(){

		$(".helpbox").hide();

	});

	//cursor:help; 내용 열기
	$(".click_show_check").on("click",function(){

		$(this).siblings(".click_show_check_tbl").show();
		$(this).addClass("on");


	});
	//cursor:help; 내용 닫기
	$(".click_show_check_tbl .closeBtn").on("click",function(){

		$(".click_show_check_tbl").hide();
		$(".click_show_check").removeClass("on");

	});

	//cursor:help; 내용 닫기
	$(".click_show_wrap").on("mouseleave",function(){

		$(".click_show_check_tbl").hide();
		$(".click_show_check").removeClass("on");

	});

});