<?
	include 'header.php';

	//달력
	include './module/datepicker/Calendar.php';
?>

<div class="content">
	<div class="inner">
		<!-- S&P 500 그래프 -->
		<iframe name='graph01' src='graph01.php' style='width:1280px;height:80px;' frameborder='0' scrolling='no'></iframe>
		<!-- /S&P 500 그래프 -->


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
						$symbol01 = $row['symbol01'];
						$label01 = $row['label01'];
						$title01 = $row['title01'];
						$msg01 = $row['msg01'];						

						//우측 데이터
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
						$symbol01 = $row['symbol01'];
						$label01 = $row['label01'];
						$title01 = $row['title01'];
						$msg01 = $row['msg01'];						

						//우측 데이터
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

		<section class="cont03">
			<h3 class="sub_tit">
				테마별 종목도 뽑아보았어요!
			</h3>

			<div class="tema_btn">
				<a href="/sub01/sub04.php?seq=2" title="더 많은 테마보기">+ 더 많은 테마보기</a>
			</div>
			
			<div class="kind_invest_api">
				<?
					$ThemeSymbol = sqlRowOne("select symbol01 from ks_invest order by uid asc limit 1");
					if($ThemeSymbol){
						include 'byTheme.php';
					}

					$ThemeSymbol = sqlRowOne("select symbol01 from ks_invest order by uid asc limit 1, 1");
					if($ThemeSymbol){
						include 'byTheme.php';
					}

					$ThemeSymbol = sqlRowOne("select symbol01 from ks_invest order by uid asc limit 2, 1");
					if($ThemeSymbol){
						include 'byTheme.php';
					}

					$ThemeSymbol = sqlRowOne("select symbol01 from ks_invest order by uid asc limit 3, 1");
					if($ThemeSymbol){
						include 'byTheme.php';
					}
				?>
			</div>
		</section>

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

		<section class="cont05">
			<h3 class="sub_tit">
				MDD를 모르면 고점에 물려 고생할 수 있어요!
			</h3>

			<div class="mdd_wrap mb20">
			<?
				//종목 추가 및 데이터 테이블
				include 'mddTable.php';
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
										<img src="/img/cal_sel.png">
									</div>
									<span>~</span>
									<div class="dateBox">
										<input type="text" name="mddEdate2" id="mddEdate2" value="<?=$mddEdate?>" class="fpicker" placeholder="끝나는 날짜(To)" autocomplete="off">
										<img src="/img/cal_sel.png">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="mdd_bot pos_rel tabGraph01">
					<?
						include 'mddChart01.php';
//						include 'graph04.php';
					?>
					</div>
				</div>
				<div class="mdd_box brwrap mdd_box02">
					<div class="mdd_top">
						전고점 대비 하락폭 별 상승확률
					</div>
					<div class="mdd_bot pos_rel tabGraph02">
					<?
						include 'mddChart02.php';
//						include 'graph05.php';
					?>
					</div>
				</div>
			</div>
<!--
			<div class="mdd_wrap">
				<div class="mdd_box wid100 brwrap">
					<div class="mdd_top">
						추가 그래프 01
					</div>
					<div class="mdd_bot pos_rel">
						<?
							include 'graph11.php';
						?>
					</div>
				</div>
			</div>

			<div class="mdd_wrap">
				<div class="mdd_box wid100 brwrap">
					<div class="mdd_top">
						추가 그래프 02
					</div>
					<div class="mdd_bot pos_rel">
						<?
							include 'graph13.php';
						?>
					</div>
				</div>
			</div>
-->

		<!--
			<h3 class="sub_tit">
				종목과지수의 MDD,수익률비교
			</h3>
		-->

			<div class="mdd_wrap">
				<div class="mdd_box brwrap mdd_box01">
				<?
					include 'snp_mdd.php';
				?>
				</div>

				<div class="mdd_box brwrap mdd_box02">
					<div class="mdd_top">
						전고점 대비 하락폭 별 상승확률
					</div>
					<div class="mdd_bot pos_rel" style="height:240px;">
						<?
							include 'graph07.php';
						?>
					</div>
				</div>
			</div>



			<div class="mdd_wrap">
				<div class="mdd_box brwrap mdd_box01">
				<?
					include 'snp_pnl.php';
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
								<td id='snpPnlTicker01'>AAPL</td>
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

		<?
			$recomSymbol = 'AAPL';
		?>

		<section class="cont06">
			<h3 class="sub_tit">
				투자의견 / 목표주가
			</h3>
			<div class="invest_searchWrap">
				<div class="search_box">
					<input type="text" name="recomSymbol" id="recomSymbol" list="recomSymbolList" value="<?=$recomSymbol?>" placeholder="종목을 검색하세요"  style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){recomData();}" autocomplete="off">
					<button onclick='recomData();'>
						<img src="/img/search_icon.png">
					</button>
					<?
						$datalist_ID = 'recomSymbolList';
						include './module/dataList.php';
					?>
				<!--
					<div class="showDown">
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
			<div class="targ_wrap">
				<div class="targ_box tar_left">
				<?
					//도넛 그래프
					include 'Recommendation01.php';
				?>
				</div>
				<div class="targ_box tar_right">
				<?
					//평균 그래프
					include 'Recommendation02.php';
				?>
				</div>
			</div>
		</section>

		<section class="cont07">
			<h3 class="sub_tit">
				지금 가격.. 매수하기 적절할까요?
			</h3>

			<div class="big_buy_box">
				<a href="" title="로그인하세요">
					<div class="plue_btn">
						<span>+</span>
					</div>
					<p>회원가입 하시고 향후 5년간의 애널리스트 컨센서스를 확인해보세요!</p>
				</a>
			</div>

			<div class="buy_box_wrap">
				<div class="buy_box">
					<h4>적정주가 - 순이익관점</h4>
					<table>
						<colgroup>
							<col style="width: 33.333%;"></col>
							<col style="width: 33.333%;"></col>
							<col style="width: 33.333%;"></col>
						</colgroup>
						<tbody>
							<tr>
								<th>적정주가<br>(성장성)</th>
								<th>적정주가<br>(성장성+수익성)</th>
								<th>현재주가 대비<br>적정주가 차이</th>
							</tr>
							<tr>
								<td>$1<br>- 48.77<br>$1</td>
								<td>$1<br>- 48.77<br>$1</td>
								<td>$1<br>- 48.77<br>$1</td>
							</tr>
						</tbody>
					</table>
					<!--------------------------로그인하면 안보이는 상자----------------------------->
					<div class="blur_box">
						<a href="" title="로그인하세요">
							<div class="plue_btn">
								<span>+</span>
							</div>
							<p>회원가입 하시고 적정주가를 확인해보세요!</p>
						</a>
					</div>
					<!--------------------------로그인하면 안보이는 상자----------------------------->
				</div>
				<div class="buy_box">
					<h4>적정주가 - 매출관점</h4>
					<table>
						<colgroup>
							<col style="width: 50%;"></col>
							<col style="width: 50%;"></col>
						</colgroup>
						<tbody>
							<tr>
								<th>적정주가<br>(성장성)</th>
								<th>현재주가 대비<br>적정주가 차이</th>
							</tr>
							<tr>
								<td>$248.77</td>
								<td>-46.64%</td>
							</tr>
						</tbody>
					</table>
					<!--------------------------로그인하면 안보이는 상자----------------------------->
					<div class="blur_box">
						<a href="" title="로그인하세요">
							<div class="plue_btn">
								<span>+</span>
							</div>
							<p>회원가입 하시고 적정주가를 확인해보세요!</p>
						</a>
					</div>
					<!--------------------------로그인하면 안보이는 상자----------------------------->

				</div>
			</div>
		</section>

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