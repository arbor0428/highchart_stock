<script>
function checkList(s){
	$("#titleBox").css({"width":"1380px"});
	$('#titleFrame').html("<iframe name='spop' id='spop' src='detail_checkList.php?gbl_symbol="+s+"' style='width:100%;height:650px;' frameborder='0' scrolling='auto'></iframe>");
	$('.titleBox_open').click();
}
</script>

<div style="margin-bottom: 50px;">
	<table class="subtable">
		<tbody>
			<tr>
				<th>티커+<br>회사이름</th>
				<th> 현재가격+1일가격변동폭+퍼센트</th>
				<th>6개월<br>수익률퍼센트</th>
				<th>시가총액</th>
				<th>섹터+6개월수익률퍼센트</th><!-- (대표ETF로 계산) -->
				<th>애널리스트컨센서스</th><!-- (평가인원+그래프작은거+최종의견제시) -->
				<th>애널리스트<br>목표가격업사이드</th>
				<th>적정주가 성장성<br>+수익성</th><!-- (2줄,유료) -->
				<th>시가배당율(5년 평균)</th>
				<th>기사</th>
			<?
				//관심종목에서만 노출(포트폴리오에서는 노출안함)
				if($_SERVER['PHP_SELF'] == '/sub04/sub03_groupDetail.php'){
			?>
				<th>비중</th>
			<?
				}
			?>
			</tr>

		<?
		if($srow){
			foreach($srow as $k => $v){
				$s = $v['symbol'];
				$percent = str_replace('.0','',$v['percent']);

				$row = sqlRow("select s.*, c.name, c.floatingShare, c.gsector, c.marketCapitalization from Stock_Candles_Last as s left join api_Company_Profile as c on s.symbol=c.symbol where s.symbol='".$s."'");

				$nowC = $row['c'];	//최신 c값

				if($nowC){
					$perData = Util::nf1($row['pmDataDay'],2);
					if($perData > 0){
						$txtClass = 'upClass';
						$txtArrow = '▲';

					}else if($perData < 0){
						$txtClass = 'blue';
						$txtArrow = '▼';

					}else{
						$txtClass = '';
						$txtArrow = '';
					}

					//시가총액
//								$sgT = $nowC * $row['floatingShare'];
					$sgT = $row['marketCapitalization'];

					//섹터
					$gsector = $row['gsector'];

					//섹터에 해당하는 대표 ETF
					$gsectorETF = $gsSectorEtfArr[$gsector];

					$udClass01 = UpDownClass($row['pmDataMonth6']);		//상승,하락 색상
		?>
			<tr>

				<td title="티커+회사이름" style="text-align:left;">
					<table cellpadding='0' cellspacing='0' border='0'>
						<tr>
							<td style="text-align:left;border:0;">
								<a href="/sub06/sub01.php?gbl_symbol=<?=$s?>">
									<span class="blue bb block"><?=$s?></span>
									<span class="block"><?=$row['name']?></span>
								</a>
							</td>
							<td style='border:0;'>
								<div style='background:#0c1540;border-radius: 45px; width: 38px; height: 38px; text-align: center;'>
									<a href="javascript:checkList('<?=$s?>');"><img src='/img/h_icon02.png' style='margin-top:5px;width:25px;'></a>
								</div>
							</td>						
						</tr>
					</table>
				</td>


				<td title="현재가격+1일가격변동폭+퍼센트"><span class="<?=$txtClass?>"><?=number_format($nowC,2)?> <?=$txtArrow?> (<?=Util::nf1($row['pmDataDay'],2)?>%)</span></td>


				<td title="6개월수익률퍼센트">
					<span class='<?=$udClass01?>'><?=$row['pmDataMonth6']?>%</span>
					<!--회원가입하면 없어지는
					<div class="blur_box_s">
						<div class="plue_btn help_point">
							<span>+</span>
						</div>
						<div class="helpbox">
							<p>회원가입 하시고 적정주가를 확인해보세요!</p>
						</div>
					</div>
					회원가입하면 없어지는 상자-->
				</td>


				<td title="시가총액"><span class="bold">$<?=number_format($sgT,2)?></span></td>


				<td title="섹터+6개월수익률퍼센트">
				<?
					//섹터값이 없는 경우가 있음(N/A)
					if($gsectorETF){
						//대표 ETF의 6개월 수익률
						$etfMonth6 = sqlRowOne("select pmDataMonth6 from Stock_Candles_Last where symbol='".$gsectorETF."'");
						$udClass02 = UpDownClass($row['etfMonth6']);		//상승,하락 색상
				?>
					<span><?=$gsector?><br><span class='<?=$udClass02?>'><?=$etfMonth6?>%</span></span>
				<?
					}
				?>
				</td>


				<td title="애널리스트컨센서스">
				<?
					//애널리스트 데이터
					$row = recomData($s);
					if($row['totScore']){
				?>
					<div class="dp_f dp_c dp_cc">
						<?
							//그래프 데이터
							$pieColor = $row['pieColor'];
							$pieData = $row['pieData'];
							include '../sub01/analyst_pie.php';
						?>
						<span class="<?=$row['investmentEng']?>"><?=$row['investmentEng']?></span>
					</div>
					<p style="font-size: 14px;">
						<span class="totNumTxt" style="font-weight:700;"><?=number_format($row['totNum'])?></span>명의 애널리스트의 평가입니다.
					</p>
				<?
					}
				?>
				</td>


				<td title="애널리스트목표가격업사이드">
				<?
					$targetMean = sqlRowOne("select targetMean from api_Price_Target where symbol='".$s."' order by uid desc limit 1");
				?>
					<span class="bgreen block bold">$<?=$targetMean?></span>
					<span class="bgreen det_s bold">(<?=Util::fnPercent($nowC,$targetMean)?>%)</span>
				</td>


				<td title="적정주가 성장성+수익성">
					<span>29.12%</span>
					<!--회원가입하면 없어지는 상자-->
					<div class="blur_box_s">
						<div class="plue_btn help_point">
							<span>+</span>
						</div>
						<div class="helpbox">
							<p>회원가입 하시고 적정주가를 확인해보세요!</p>
						</div>
					</div>
					<!--회원가입하면 없어지는 상자-->
				</td>


				<td title="시가배당율(5년 평균)">
				<?
					$dividendYield5Y = sqlRowOne("select dividendYield5Y from api_Basic_Financials where symbol='".$s."'");

					echo number_format($dividendYield5Y,2).'%';
				?>
				</td>

				<td title="기사링크"><a href="javascript:newsList('<?=$s?>');"><i class="fas fa-chalkboard-teacher"></i></a></td>
			<?
				//관심종목에서만 노출(포트폴리오에서는 노출안함)
				if($_SERVER['PHP_SELF'] == '/sub04/sub03_groupDetail.php'){
			?>
				<td title="비중"><?=$percent?>%</td>
			<?
				}
			?>
			</tr>
		<?
				}
			}
		}
		?>
		</tbody>
	</table>
<!--
	<a class="moreBtn dp_f dp_c dp_cc" href="" title="">+</a>
-->
</div>

<style>
	.moreBtn {margin: 20px auto 50px; width: 30px; height: 30px; border-radius: 50%;  background-color: #000; color: #fff; font-size: 20px; font-weight: 700;}
</style>