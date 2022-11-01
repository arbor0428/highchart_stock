<?
	include 'header.php';

	//달력
	include './module/datepicker/Calendar.php';
?>

<div class="content">
	<div class="inner">
		<!-- 지수 그래프 -->
		<iframe name='graph01' src='graph01.php' style='width:1280px;height:160px;' frameborder='0' scrolling='no'></iframe>
		<!-- /지수 그래프 -->

		<section class="cont01">
			<h3 class="sub_tit">
				오늘의 특징주와 ETF
			</h3>
			<?
//				include 'tab01.php';
				include 'TodayStockETF.php';
			?>
		</section>
		
		<section class="cont02">
			<h3 class="sub_tit">
				누가누가 잘하나!?
			</h3>

			<div class="tema_btn">
				<a href="/sub01/sub04.php" title="더 많은 테마보기">+ 더 많은 테마보기</a>
			</div>
			
			<div class="joo_api_wrap">
				<div class="joo_wrap">					
				<?
					//관리자에서 설정한 첫번째 데이터
					$row = sqlRow("select * from ks_thema order by uid asc limit 1");

					if($row){
						//좌측 데이터
						$uid01 = $row['uid'];
						$symbol01 = $row['symbol01'];
						$label01 = $row['label01'];
						$title01 = $row['title01'];
						$msg01 = $row['msg01'];						

						//우측 데이터
						$uid02 = $row['uid'];
						$symbol02 = $row['symbol02'];
						$label02 = $row['label02'];
						$title02 = $row['title02'];
						$msg02 = $row['msg02'];

						$graphID = 'whosbetter01';		//그래프ID

						include 'isGood.php';
					}
				?>
				</div>

				<div class="joo_wrap">
				<?
					//관리자에서 설정한 첫번째 데이터
					$row = sqlRow("select * from ks_thema order by uid asc limit 1, 1");

					if($row){
						//좌측 데이터
						$uid01 = $row['uid'];
						$symbol01 = $row['symbol01'];
						$label01 = $row['label01'];
						$title01 = $row['title01'];
						$msg01 = $row['msg01'];						

						//우측 데이터
						$uid02 = $row['uid'];
						$symbol02 = $row['symbol02'];
						$label02 = $row['label02'];
						$title02 = $row['title02'];
						$msg02 = $row['msg02'];

						$graphID = 'whosbetter02';		//그래프ID

						include 'isGood.php';
					}
				?>
				</div>

			</div>
		</section>

		<script>
		function tema(t){
			$("#multiBox").css({"width":"90%","max-width":"1280px"});
			//$('#multi_ttl').text('test');
			$('#multiFrame').html("<iframe src='/sub01/temaframe.php?uid="+t+"' name='' style='width:100%;height:650px;' frameborder='0' scrolling='auto'></iframe>");
			$('.multiBox_open').click();
		}

		$(".joo_top > .modeBtn").click(function(event){
			tid = $(this).data('tid');
			tema(tid);
			event.preventDefault();
		});
		</script>


		<section class="cont03">
			<h3 class="sub_tit">
				테마별 종목도 뽑아보았어요!
			</h3>

			<div class="tema_btn">
				<a href="/sub01/sub04.php?seq=2" title="더 많은 테마보기">+ 더 많은 테마보기</a>
			</div>
			
			<div class="kind_invest_api">
				<?
					$item = sqlRow("select * from ks_invest order by uid asc limit 1");
					if($item){
						include 'byTheme.php';
					}

					$item = sqlRow("select * from ks_invest order by uid asc limit 1, 1");
					if($item){
						include 'byTheme.php';
					}

					$item = sqlRow("select * from ks_invest order by uid asc limit 2, 1");
					if($item){
						include 'byTheme.php';
					}

					$item = sqlRow("select * from ks_invest order by uid asc limit 3, 1");
					if($item){
						include 'byTheme.php';
					}
				?>
			</div>
		</section>

		<script>
		function tema02(t){
			$("#multiBox").css({"width":"90%","max-width":"1280px"});
			//$('#multi_ttl').text('test');
			$('#multiFrame').html("<iframe src='/sub01/temaframe02.php?uid="+t+"' name='calendarData' style='width:100%;height:650px;' frameborder='0' scrolling='auto'></iframe>");
			$('.multiBox_open').click();
		}

		$(".kind_invest_api > .investBtn").click(function(event){
			tid = $(this).data('tid');
			tema02(tid);
			event.preventDefault();
		});
		</script>

		<section class="cont04">
			<h3 class="sub_tit">
				미국 증시 실적발표, 배당락, IPO 등을 확인하세요
			</h3>
			<div class="sub_inner">
				<div class="invest_info_wrap">
						<div class="fix_tit">
							투자원칙
						</div>
						<div class="invest_info">
							<ul class="invest_slick">
									<li>내 돈이 들어가고 나면 나는 원숭이가 된다 by 강환국 - 반드시 투자 전에 원칙부터 세우고 지키자! -</li>
									<li>내 돈이 들어가고 나면 나는 원숭이가 된다 by 강환국 - 반드시 투자 전에 원칙부터 세우고 지키자! -</li>
									<li>내 돈이 들어가고 나면 나는 원숭이가 된다 by 강환국 - 반드시 투자 전에 원칙부터 세우고 지키자! -</li>
									<li>내 돈이 들어가고 나면 나는 원숭이가 된다 by 강환국 - 반드시 투자 전에 원칙부터 세우고 지키자! -</li>
							</ul>
							<a class="write_btn" href="" title="찾기"><img src="./img/write_icon.png"></a>
						</div>
				</div>
				<script>
				//투자원칙slick 
				$('.invest_slick').slick({ 
					infinite: true,
					slidesToShow: 1, 
					slidesToScroll: 1, 
					arrows: true,
					vertical: true,
					autoplay: true,
					autoplaySpeed: 1000,
				});
				</script>

				<!-- 달력 -->
				<iframe name="ifra_calendar" id="ifra_calendar" src="calendar.php?path=main" style="width:100%;margin-bottom:160px;" frameborder="0" scrolling="no" onload="iFrameHeight('ifra_calendar')"></iframe>
				<!-- /달력 -->
			</div>
		</section>

<!--
section 05, 06, 07 삭제
-->


		<section class="cont08">
			<h3 class="sub_tit">
				미국 주식 산업별 분위기는 어떨까요?
			</h3>
			<div class="sec_etf_wrap">
				<div class="ora_line"></div>
				<div class="sec_table">
				<?
					include 'industry.php';
				?>
				</div>
			</div>
		</section>

		<script>
		function companyNews(){
			s = $('#newsSymbol').val();
			if(s == ''){
				GblMsgBox('찾으시려는 종목을 입력해 주세요','');
				return;

			}else{
				$('#CompanyNews').contents().find('#loading').show();

				url = 'CompanyNews.php?newsSymbol='+s;
				$('#CompanyNews').attr('src', url);
			}
		}
		</script>

		<section class="cont09">
			<div class="mdd_wrap">
				<div class="mdd_box brwrap">
					<div class="mdd_top">
						<p>종목뉴스<p>
						<div class="search_bar">
							<input type="text" name="newsSymbol" id="newsSymbol" list="newsSymbolList" value="AAPL" placeholder="" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){companyNews();}" autocomplete="off">
							<a class="search_icon" href="javascript:companyNews();"><img src="./img/search_icon.png"></a>
							<?
								$datalist_ID = 'newsSymbolList';
								include './module/dataList.php';
							?>
						<!--
							<div class="showDown03">
								<div class="item">hello<span class="searWord"></span></div>
								<div class="item">nice to meet<span class="searWord"></span></div>
								<div class="item">hello<span class="searWord"></span></div>
								<div class="item">nice to meet<span class="searWord"></span></div>
								<div class="item">hello<span class="searWord"></span></div>
								<div class="item">nice to meet<span class="searWord"></span></div>
							</div>
						-->
						</div>
					</div>
					<div class="mdd_bot">
						<iframe name='CompanyNews' id='CompanyNews' src='CompanyNews.php' style='width:100%;height:752px;' frameborder='0' scrolling='no'></iframe>
					</div>
				</div>

				<div class="mdd_box brwrap">
					<div class="mdd_top">미국증시뉴스</div>
					<div class="mdd_bot">
						<iframe name='MarketNews' src='MarketNews.php' style='width:100%;height:752px;' frameborder='0' scrolling='no'></iframe>
					</div>
				</div>
			</div>
		</section>

	</div>

</div>

<?
	include 'footer.php';
?>