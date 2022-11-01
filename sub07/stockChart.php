<?
//AUM(총 운용자산)
$aum = $row01['aum'];
$aumHan = Util::convertHan($aum,0,3);

//AUM 순위
$aumRank = sqlRowOne("select count(*) from api_ETFs_Profile where aum>$aum") + 1;

//eft 전체 수
$etfTotNum = sqlRowOne("select count(*) from api_ETFs_Profile");

//NAV
$nav = $row01['nav'] * 1000;

//평균거래량
$avgVolume = $row01['avgVolume'] / 1000000;

//괴리율
$per01 =  Util::infiniteDecimal(($nowC / $row01['nav']) / ($row01['nav'] * 100));

//1년동안 배당금 합계
$brow = sqlRow("select * from api_Dividends where symbol='".$gbl_symbol."' order by dateTime desc limit 1");
$chkTime = strtotime($brow['payDate']." -1 years");
$amount = sqlRowOne("select sum(amount) from api_Dividends where symbol='".$gbl_symbol."' and dateTime<='".$brow['dateTime']."' and dateTime>'".$chkTime."'");
$per02 = ($amount / $nowC) * 100;
?>
<div class="analysis_result" style="margin-bottom: 60px; align-items:center;">
	<div class="analysis_graph">
	<?
		//json 파일확인
		if(is_file('../module/highcharts/'.$gbl_symbol.'.json')){
			include 'stockChart_graph.php';
		}
	?>
	</div>
	<div class="analysis_amount">
		<div class="aa_top">
			<h4 class="box_sub_tit">이것만은 꼭 기억하세요!</h4>
		<!--
			<a class="prog_btn" href="">분석일지<br>작성하기</a>
		-->
		</div>
		<div class="aa_bot">
			<table class="subtable">
				<tbody>
					<tr>
						<th>AUM(총 운용자산)</th>
						<td><span><?=$aumHan?></span><br><span>(<?=number_format($aumRank)?>위 / <?=number_format($etfTotNum)?>)</span></td>
					</tr>
					<tr>
						<th>
							<div class="dp_f" style="justify-content: flex-end;">
								<span style="font-weight: 700;">NAV</span>
							<!--
								<div class="help_wrap">
									<div class="excla_mark help_point" style="top: 0;">
										<span>i</span>
									</div>
									<div class="helpbox" style="display: none;">
										<p>
											순자산가치를 말합니다.<br>
											순자산은 ETF가 편입하고 있는 주식, 현금, 배당, 이자소득 등을 모두 더한
											가치의 합입니다.<br>
											ETF를 처음 시작할 때는 순자산이 크다면 믿고 선택할 수 있는 기준 중 하나가
											될 수 있습니다.
										</p>
									</div>
								</div>
							-->
							</div>
						</th>
						<td><span><?=number_format(round($nav,2),2)?></span></td>
					</tr>
					<tr>
						<th>수수료</th>
						<td><?=$row01['expenseRatio']?>%</td>
					</tr>
					<tr>
						<th>priceToBook</th>
						<td><?=$row01['priceToBook']?></td>
					</tr>
					<tr>
						<th>priceToEarnings</th>
						<td><?=$row01['priceToEarnings']?></td>
					</tr>
					<tr>
						<th>평균거래량</th>
						<td><?=round($avgVolume,2)?></td>
					</tr>
					<tr>
						<th>괴리율</th>
						<td><?=round($per01,2)?>%</td>
					</tr>
					<tr>
						<th>분배율</th>
						<td><?=round($per02,2)?>%</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


<style>
	.analysis_result .aa_top .prog_btn {height: 50px;}
</style>