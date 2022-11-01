<?
	include 'head2.php';
?>
<style>
#loading{display:none;}
</style>
<?
	include '/home/myss/www/module/loading.php';
?>


<body>

<style>
.showDown, .showDown02, .showDown03{display:none;}
</style>

<header>
	<div class="h_top">
		<div class="inner">
			<h1 class="logo"><a href="/" title="logo"><img src="/img/logo.png"></a></h1>
			<div class="search_box">
			<?
				//검색창
				include '/home/myss/www/module/gbl_search.php';
			?>
			</div>
			<ul class="quick_mn">
				<li class="investDiary">
					<a href="javascript:void(0);" title="투자다이어리">
						<img src="/img/h_icon01.png">
						<p>투자다이어리</p>
					</a>
				</li>
				<li>
					<a href="/sub04/sub03.php" title="관심종목">
						<img src="/img/h_icon02.png">
						<p>관심종목</p>
					</a>
				</li>
				<li>
					<a href="/sub01/sub01.php" title="조건맞는주식찾기">
						<img src="/img/h_icon03.png">
						<p>조건맞는주식찾기</p>
					</a>
				</li>
			</ul>

			<ul class="user_mn">
<?
           if($_SERVER['REMOTE_ADDR'] == '106.246.92.237'){
?>

				<li class="alrmBtn"><a class="dp_f dp_c dp_cc" href="/sub08/sub01.php"><img src="/img/alrm.png"></a></li>
<?
	}	
?>

				<li><a href="/member/login.php" title="로그인">로그인</a></li>
				<li><a href="/member/join.php" title="회원가입">회원가입</a></li>
			</ul>
		</div>
	</div>
	<div class="h_bot">
		<div class="inner">
			<ul class="nav">
				<li>
					<a href="/" title="홈" style="background-color: transparent; color: #fff;">HOME</a>
					<div class="depth2">
						<div class="tan_img" style="background-image:url(/img/user_arrow.png);"></div>
						<div class="follow_menu">
							<ul class="f_m_wrap">
								<li><a href="/sub01/sub03.php" title="특징주">- 특징주</a></li>
								<li><a href="/sub01/sub02.php" title="배당주">- 배당주</a></li>
								<li><a href="" title="투자자산별/레버리지/인버스">- 투자자산별/레버리지/인버스</a></li>
								<li><a href="/sub01/sub01.php" title="주식screener">- 주식screener</a></li>
								<li><a href="/sub02/sub01.php" title="ETFscreener">- ETFscreener</a></li>
								<li><a href="/sub03/sub01.php" title="테마">- 테마</a></li>
								<li><a href="/sub06/sub01.php?gbl_symbol=AAPL" title="AAPL">- AAPL</a></li>
								<li><a href="/sub06/sub01.php?gbl_symbol=TSLA" title="TSLA">- TSLA</a></li>
								<li><a href="/sub06/sub01.php?gbl_symbol=AMZN" title="AMZN">- AMZN</a></li>
								<li><a href="/sub06/sub01.php?gbl_symbol=MSFT" title="MSFT">- MSFT</a></li>
								<li><a href="/sub06/sub01.php?gbl_symbol=NVDA" title="NVDA">- NVDA</a></li>
								<li><a href="/sub07/sub01.php?gbl_symbol=SPY" title="SPY">- SPY</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<a href="javascript:void(0);" title="주식">주식</a>
						<div class="depth2">
						<div class="tan_img" style="background-image:url(/img/user_arrow.png);"></div>
						<div class="follow_menu">
							<ul class="f_m_wrap">
								<li><a href="/sub01/sub01.php" title="주식screener">- 주식screener</a></li>
								<li><a href="/sub01/sub02.php" title="배당주">- 배당주</a></li>
								<li><a href="/sub01/sub03.php" title="특징주">- 특징주</a></li>
								<li><a href="/sub01/sub04.php" title="테마">- 테마</a></li>
								<li><a href="/sub01/sub05.php" title="내부자거래">- 내부자거래</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<a href="javascript:void(0);" title="ETF">ETF</a>
						<div class="depth2">
						<div class="tan_img" style="background-image:url(/img/user_arrow.png);"></div>
						<div class="follow_menu">
							<ul class="f_m_wrap">
								<li><a href="/sub02/sub01.php" title="ETFscreener">- ETFscreener</a></li>
								<li><a href="/sub02/sub02.php" title="특징ETF">- 특징ETF</a></li>
								<li><a href="/sub02/sub03.php" title="투자자산별/레버리지/인버스">- 투자자산별/레버리지/인버스</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<a href="javascript:void(0);" title="테마">테마</a>
	 					<div class="depth2">
						<div class="tan_img" style="background-image:url(/img/user_arrow.png);"></div>
						<div class="follow_menu">
							<ul class="f_m_wrap">
								<li><a href="/sub03/sub01.php" title="누가누가잘하나">- 누가누가잘하나</a></li>
								<li><a href="/sub03/sub02.php" title="테마별 종목">- 테마별 종목</a></li>
								<li><a href="/sub02/sub03.php" title="투자자산별 종목">- 투자자산별 종목</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<a href="javascript:void(0);" title="캘린더">캘린더</a>
	 					<div class="depth2">
 						<div class="tan_img" style="background-image:url(/img/user_arrow.png);"></div>
						<div class="follow_menu">
							<ul class="f_m_wrap">
								<li><a href="/sub04/sub01_01.php" title="실적발표 캘린더">실적발표 캘린더</a></li>
								<li><a href="/sub04/sub01_02.php" title="배당 캘린더">배당 캘린더</a></li>
								<li><a href="/sub04/sub01_03.php" title="IPO 캘린더">IPO 캘린더</a></li>
							<!--
								<li><a href="/sub04/sub02.php" title="다이어리">다이어리</a></li>
								<li><a href="/sub04/sub03.php" title="관심종목">관심종목</a></li>
								<li><a href="/sub04/sub04.php" title="포트폴리오">포트폴리오</a></li>
							-->
							</ul>
						</div>
					</div>
				</li>
				<li>
					<a href="javascript:void(0);" title="서비스소개">서비스소개</a>
						<div class="depth2">
						<div class="tan_img" style="background-image:url(/img/user_arrow.png);"></div>
						<div class="follow_menu">
							<ul class="f_m_wrap">
								<li><a href="/sub05/sub01.php" title="서비스소개">- 서비스소개</a></li>
								<li><a href="/sub05/sub02.php" title="Q&A">- Q&A</a></li>
								<li><a href="/sub05/sub03.php" title="개발중인서비스">- 개발중인서비스</a></li>
								<li><a href="/sub05/sub04.php" title="제휴문의">- 제휴문의</a></li>
							</ul>
						</div>
					</div>
				</li>
			</ul>
			<div class="info_sec">
			<?
				include '/home/myss/www/module/common/openMarket.php';
			?>
				<ul class="per_chk">
				<?
					//실시간 환율정보
					$exArr = Util::ExchangeRate();
					if($exArr[0] == '▲')		$exColor = '#ff0000';
					elseif($exArr[0] == '▼')	$exColor = '#6060ff';
					else							$exColor = '#fff';

					$exRate = str_replace(',','',$exArr[1]);
				?>
					<li>
						<span>원달러</span>
						<span style="color: #cccccc;">미국USD</span>
						<span style="margin: 0 10px;color:<?=$exColor?>;"><?=$exArr[1]?></span>
						<span style="font-weigth: 700;color:<?=$exColor?>;"><?=$exArr[0]?> <?=$exArr[2]?> (<?=$exArr[3]?>%)</span>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="nav_sub_wrap">
		<div class="nav_sub" style="width:0; overflow:hidden;">
			<div class="inner">
				<ul>
					<li><a href="/sub06/sub01.php?gbl_symbol=AAPL" title="AAPL">AAPL</a></li>
					<li><a href="/sub06/sub01.php?gbl_symbol=TSLA" title="TSLA">TSLA</a></li>
					<li><a href="/sub06/sub01.php?gbl_symbol=AMZN" title="AMZN">AMZN</a></li>
					<li><a href="/sub06/sub01.php?gbl_symbol=MSFT" title="MSFT">MSFT</a></li>
					<li><a href="/sub06/sub01.php?gbl_symbol=NVDA" title="NVDA">NVDA</a></li>
					<li><a href="/sub07/sub01.php?gbl_symbol=SPY" title="SPY">SPY</a></li>
				</ul>
			</div>
		</div>
		<div class="nav_sub">
		<div class="depth3_bg"></div>
			<div class="inner">
				<ul>
					<li>
						<a href="/sub01/sub01.php" title="주식screener">주식screener</a>
					</li>
					<li>
						<a href="/sub01/sub02.php" title="배당주">배당주</a>
						<ul class="nav_depth3">
							<li class="depth3_1 on"><a href="" onclick="fnMove('1')">배당킹/배당귀족주</a></li>
							<li class="depth3_2"><a href="" onclick="fnMove('2')">배당캘린더</a></li>
							<li class="depth3_3"><a href="" onclick="fnMove('3')">배당주 검색</a></li>
						</ul>
					</li>
					<li>
						<a href="/sub01/sub03.php" title="특징주">특징주</a>
						<ul class="nav_depth3">
							<li><a href="javascript:void(0);" onclick="fnMove('1')">투자의견 상향/하향</a></li>
							<li><a href="javascript:void(0);" onclick="fnMove('2')">급등락주</a></li>
							<li><a href="javascript:void(0);" onclick="fnMove('3')">52주 신고가/신저가</a></li>
							<li><a href="javascript:void(0);" onclick="fnMove('4')">거래량 급등</a></li>
							<li><a href="javascript:void(0);" onclick="fnMove('5')">한국인 매매</a></li>
						</ul>
					</li>
					<li>
						<a href="/sub01/sub04.php" title="테마">테마</a>
						<ul class="nav_depth3">
							<li class="on"><a href="javascript:void(0);" onclick="fnMove('1')">누가누가잘하나</a></li>
							<li><a href="javascript:void(0);" onclick="fnMove('2')">이런 테마 어때요?</a></li>
						</ul>
					</li>
					<li><a href="/sub01/sub05.php" title="내부자거래">내부자거래</a></li>
				</ul>
			</div>
		</div>
		<div class="nav_sub">
			<div class="inner">
				<ul>
					<li><a href="/sub02/sub01.php" title="ETFscreener">ETFscreener</a></li>
					<li><a href="/sub02/sub02.php" title="특징ETF">특징ETF</a></li>
					<li><a href="/sub02/sub03.php" title="투자자산별ETF">투자자산별ETF</a></li>
					<li><a href="/sub02/sub04.php" title="레버리지/인버스">레버리지/인버스</a></li>
				</ul>
			</div>
		</div>
		<div class="nav_sub">
			<div class="inner">
				<ul>
					<li><a href="/sub03/sub01.php" title="누가누가잘하나">누가누가잘하나</a></li>
					<li><a href="/sub03/sub02.php" title="테마별 종목">테마별 종목</a></li>
					<li><a href="/sub03/sub03.php" title="투자자산별 종목">투자자산별 종목</a></li>
				</ul>
			</div>
		</div>
		<div class="nav_sub">
           <div class="inner">
				<ul>
					<li><a href="/sub04/sub01_01.php" title="실적발표 캘린더">실적발표 캘린더</a></li>
					<li><a href="/sub04/sub01_02.php" title="배당 캘린더">배당 캘린더</a></li>
					<li><a href="/sub04/sub01_03.php" title="IPO 캘린더">IPO 캘린더</a></li>
					<li><a href="/sub04/sub02.php" title="다이어리">다이어리</a></li>
					<li><a href="/sub04/sub03.php" title="관심종목">관심종목</a></li>
					<li><a href="/sub04/sub04.php" title="포트폴리오">포트폴리오</a></li>
				</ul>
			</div>
		</div>
		<div class="nav_sub">
			<div class="inner">
				<ul>
					<li><a href="/sub05/sub01.php" title="서비스소개">서비스소개</a></li>
					<li><a href="/sub05/sub02.php" title="Q&A">Q&A</a></li>
					<li><a href="/sub05/sub03.php" title="개발중인서비스">개발중인서비스</a></li>
					<li><a href="/sub05/sub04.php" title="제휴문의">제휴문의</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="diary_nav_sub">
		<div class="inner">
			<ul>
				<li><a href="/sub04/sub02.php" title="다이어리">다이어리</a></li>
				<li><a href="/sub04/sub03.php" title="관심종목">관심종목</a></li>
				<li><a href="/sub04/sub04.php" title="포트폴리오">포트폴리오</a></li>
			</ul>
		</div>
	</div>
</header>

<script>
    $("header .h_bot .nav > li").click(function(){

        let tabNumber = $(this).index();

		if($(this).hasClass("on")){
				
			  $(".nav > li").removeClass("on");
			  $(this).removeClass("on");

			 $(".nav_sub_wrap .nav_sub").css({"display":"none"});
			 $(".nav_sub_wrap .nav_sub").eq(tabNumber).css({"display":"none"});
							
		}else{
				
			  $(".nav > li").removeClass("on");
			  $(this).addClass("on");

			 $(".nav_sub_wrap .nav_sub").css({"display":"none"});
			 $(".nav_sub_wrap .nav_sub").eq(tabNumber).css({"display":"block"});
			 $(".diary_nav_sub").css({"display":"none"});
		}

    });


	$("header .h_bot .nav > li").on("mouseenter",function(){

        let tabNumber = $(this).index();

		$(".depth2").stop().fadeOut(100);
		$(".depth2").eq(tabNumber).stop().fadeIn(100);

	});

	$("header .h_bot .nav > li").on("mouseleave",function(){

		$(".depth2").stop().fadeOut(100);

	});

	//투자다이어리 2차 메뉴
	var flag = true;
    $(".investDiary").click(function(){

        let tabNumber = $(this).index();

		if(flag){

			$(".diary_nav_sub").css({"display":"block"});
			$("header .h_bot .nav > li").removeClass("on");
			$(".nav_sub_wrap .nav_sub").css({"display":"none"});

			flag= false;
		}else{
				
			$(".diary_nav_sub").css({"display":"none"});

			flag= true;
		}

    });


	//3차 메뉴
	$("header .nav_sub_wrap .nav_sub > ul > li > a").on("click",function(){

		$(".nav_depth3").not($(this).siblings(".nav_depth3")).stop().fadeOut();
		$(this).siblings(".nav_depth3").stop().fadeIn();
		$(".depth3_bg").stop().fadeIn();

	});

</script>