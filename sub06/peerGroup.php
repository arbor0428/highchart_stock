<style>
.peerGroup .highcharts-bindings-wrapper {display: none;}
</style>

<script>
function newsList(s){
	parent.$("#newsListBox").css({"width":"90%","max-width":"700px"});
	parent.$('#newsList_ttl').text(s);
	parent.$('#newsListFrame').html("<iframe name='newsList' id='newsList' src='../CompanyNewsList.php?newsSymbol="+s+"' style='width:100%;height:600px;' frameborder='0' scrolling='auto'></iframe>");
	parent.$('.newsListBox_open').click();
}
</script>

	<div class="peerGroup">
		<h3 class="sub_tit">피어그룹</h3>
		<table class="subtable">
			<tbody>
				<tr>
					<th>티커+<br>회사이름</th>
					<th> 현재가격+1일가격변동폭+퍼센트</th>
					<th>6개월<br>수익률퍼센트</th>
					<th>시가총액</th>
					<th>섹터+6개월수익률퍼센트</th>
					<th>애널리스트컨센서스</th>
					<th>애널리스트<br>목표가격업사이드</th>
					<th>적정주가 성장성<br>+수익성</th>
					<th>시가배당율(5년 평균)</th>
					<th>기사</th>
				</tr>
			<?
				//checkList.php 에서 peer api 호출 후 $peer 배열이 생성됨
				foreach($peer as $k => $s){
					$tmpChk = sqlRowOne("select count(*) from ks_symbol where symbol='".$s."'");
					if($tmpChk){
						$row = sqlRow("select s.*, c.name, c.floatingShare, c.gsector from Stock_Candles_Last as s left join api_Company_Profile as c on s.symbol=c.symbol where s.symbol='".$s."'");

						$nowC = $row['c'];	//최신 c값

						$perData = Util::nf1($row['pmDataDay'],2);
						if($perData > 0){
							$txtClass = 'upClass';
							$txtArrow = '▲';

						}else if($perData < 0){
							$txtClass = 'downClass';
							$txtArrow = '▼';

						}else{
							$txtClass = '';
							$txtArrow = '';
						}

						//시가총액
						$sgT = $nowC * $row['floatingShare'];

						//섹터
						$gsectorTmp = $row['gsector'];

						//섹터에 해당하는 대표 ETF
						$gsectorETF = $gsSectorEtfArr[$gsectorTmp];

						$udClass01 = UpDownClass($row['pmDataMonth6']);		//상승,하락 색상
			?>
				<tr>
					<td title="티커+회사이름" style='text-align:left;padding-left:20px;'>
						<span class="blue bb block"><?=$s?></span>
						<span class="block"><?=$row['name']?></span>
					</td>
					<td title="현재가격+1일가격변동폭+퍼센트">
						<span class="green"><span class="<?=$txtClass?>"><?=number_format($nowC,2)?> <?=$txtArrow?> (<?=Util::nf1($row['pmDataDay'],2)?>%)</span></span>
					</td>
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
					<td title="시가총액">
						<span class="bold">$<?=number_format($sgT,2)?></span>
					</td>
					<td title="섹터+6개월수익률퍼센트">
					<?
						//섹터값이 없는 경우가 있음(N/A)
						if($gsectorETF){
							//대표 ETF의 6개월 수익률
							$etfMonth6 = sqlRowOne("select pmDataMonth6 from Stock_Candles_Last where symbol='".$gsectorETF."'");
							$udClass02 = UpDownClass($row['etfMonth6']);		//상승,하락 색상
					?>
						<span><?=$gsectorTmp?><br><span class='<?=$udClass02?>'><?=$etfMonth6?>%</span></span>
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
				</tr>
			<?
					}
				}
			?>
			</tbody>
		</table>
	</div>
