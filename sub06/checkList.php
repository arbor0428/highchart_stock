<div class="anal_checkList">
	<h3 class="sub_tit">한 눈에 분석이 되는 체크리스트</h3>
	<table class="subtable backBar_table">
		<tbody>
			<tr style="height: 72px;">
				<td colspan="2"></td>
				<td colspan="2"><span class="bold">Check Point 1.<br>주가가 싼지 비싼지</span></td>
				<td colspan="2"><span class="bold">Check Point 2.<br>이 기업이 돈을 잘 버는지</span></td>
				<td colspan="2"><span class="bold">Check Point 3.<br>이 기업이 앞으로 성장하기 좋은지</span></td>
				<td></td>
				<td colspan="3"><span class="bold">Check Point 4.<br>외부 전문가의 의견도 들어보자</span></td>
			</tr>
			<tr>
				<th>티커</th>
				<th>종목명</th>
				<th>PER<br>(TTM)</th>
				<th>PSR<br>(TTM)</th>
				<th>매출이익률</th>
				<th>영업이익률</th>
				<th>매출성장률<br>(향후 3년 평균)</th>
				<th>순이익성장률<br>(향후 3년 평균)</th>
				<th>고점대비<br>하락률</th>
				<th>현재주가</th>
				<th>목표주가</th>
				<th>상승여력</th>
			</tr>
		<?
			$sTime = strtotime('-20 year');
			$eTime = time();
			$thisYear = date('Y');

			$peer = PeerAPI($gbl_symbol);
			foreach($peer as $s){
				$tmpChk = sqlRowOne("select count(*) from ks_symbol where symbol='".$s."'");
				if($tmpChk){
					//회사명
					$cpArr = sqlRow("select * from api_Company_Profile where symbol='".$s."'");
					
					$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$s."'");
					$bfArr = sqlRow("select * from api_Basic_Financials where symbol='".$s."'");
					$epsBasicExclExtraItemsTTM = $bfArr['epsBasicExclExtraItemsTTM'];
					$revenuePerShareTTM = $bfArr['revenuePerShareTTM'];
					$grossMarginTTM = $bfArr['grossMarginTTM'];
					$operatingMarginTTM = $bfArr['operatingMarginTTM'];

					$per = $nowC / $epsBasicExclExtraItemsTTM;	//PER(TTM)
					$psr = $nowC / $revenuePerShareTTM;			//PSR(TTM)

					//매출성장률(향후 3년 평균)
					$resThis = sqlRow("select * from api_Revenue_Estimates where symbol='".$s."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");

					if($resThis){
						$resThree = sqlRow("select * from api_Revenue_Estimates where symbol='".$s."' and freq='annual' and periodTime > ".$resThis['periodTime']." order by periodTime asc limit 2,1");
						$jegop = $resThree['revenueAvg'] / $resThis['revenueAvg'];
						$revenueAvg = (pow($jegop, 1/3) - 1) * 100;

						//순이익성장률(향후 3년 평균)
						$resThis = sqlRow("select * from api_Earnings_Estimates where symbol='".$s."' and freq='annual' and period like '".$thisYear."-%' order by periodTime desc limit 1");
						$resThree = sqlRow("select * from api_Earnings_Estimates where symbol='".$s."' and freq='annual' and periodTime > ".$resThis['periodTime']." order by periodTime asc limit 2,1");
						$jegop = $resThree['epsAvg'] / $resThis['epsAvg'];
						$epsAvg = (pow($jegop, 1/3) - 1) * 100;

						//고점대비 하락률(20년)
						$row = sqlRow("select max(c) as HighC from api_Stock_Candles_D where symbol='".$s."' and t>='".$sTime."' and t<='".$eTime."'");
						$nowPer = Util::fnPercent($row['HighC'],$nowC);

						//현재주가(
						if($QuoteCall){
							$row = QuoteAPI($s); //(c:가격, d:전날과의 가격차, dp:가격차%)
							$nowC = round($row['c'],2);
						}else{
							$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$s."'");
						}

						//목표주가
						$targetMean = sqlRowOne("select targetMean from api_Price_Target where symbol='".$s."' order by lastUpdatedTime desc limit 1");

						//상승여력
						$upPer = (($targetMean / $nowC) - 1) * 100;
		?>
			<tr>
				<td title='티커'><span class="bb"><?=$s?></span></td>
				<td title='종목명'><?=$cpArr['name']?></td>
				<td title='PER'>
				<?
					if($per > 100)	$perWidth = 100;
					else				$perWidth = $per;
				?>
					<div class="backBar green" style="width:<?=round($perWidth,2)?>%;"></div>
					<span class="posi_ab"><?=round($per,2)?></span>
				</td>
				<td title='PSR'>
				<?
					if($psr > 100)	$psrWidth = 100;
					else				$psrWidth = $psr;
				?>
					<div class="backBar green" style="width:<?=round($psrWidth,2)?>%;"></div>
					<span class="posi_ab"><?=round($psr,2)?></span>
				</td>
				<td title='매출이익률'>
					<div class="half_backWrap">
						<div class="half_back_bar">
						<?
							if($grossMarginTTM < 0){
								if($grossMarginTTM < -100)	$grossMarginTTMWidth = -100;
								else									$grossMarginTTMWidth = $grossMarginTTM;
						?>
							<div class="halfBar halfBar_nega" style="width:<?=round($grossMarginTTMWidth*-1,2)?>%;"></div>
						<?
							}
						?>
						</div>
						<div class="half_back_bar">
						<?
							if($grossMarginTTM > 0){
								if($grossMarginTTM > 100)	$grossMarginTTMWidth = 100;
								else									$grossMarginTTMWidth = $grossMarginTTM;
						?>
							<div class="halfBar halfBar_posi" style="width:<?=round($grossMarginTTMWidth,2)?>%;"></div>
						<?
							}
						?>
						</div>
					</div>
					<span class="posi_ab"><?=round($grossMarginTTM,2)?>%</span>
				</td>
				<td title='영업이익률'>
					<div class="half_backWrap">
						<div class="half_back_bar">
						<?
							if($operatingMarginTTM < 0){
								if($operatingMarginTTM < -100)	$operatingMarginTTMWidth = -100;
								else										$operatingMarginTTMWidth = $operatingMarginTTM;
						?>
							<div class="halfBar halfBar_nega" style="width:<?=round($operatingMarginTTMWidth*-1,2)?>%;"></div>
						<?
							}
						?>
						</div>
						<div class="half_back_bar">
						<?
							if($operatingMarginTTM > 0){
								if($operatingMarginTTM > 100)	$operatingMarginTTMWidth = 100;
								else										$operatingMarginTTMWidth = $operatingMarginTTM;
						?>
							<div class="halfBar halfBar_posi" style="width:<?=round($operatingMarginTTMWidth,2)?>%;"></div>
						<?
							}
						?>
						</div>
					</div>
					<span class="posi_ab"><?=round($operatingMarginTTM,2)?>%</span>
				</td>
				<td title='매출성장률'>
				<?
					if($revenueAvg > 100)	$revenueAvgWidth = 100;
					else							$revenueAvgWidth = $revenueAvg;
				?>
					<div class="backBar blue" style="width:<?=round($revenueAvgWidth,2)?>%;"></div>
					<span class="posi_ab"><?=round($revenueAvg,2)?>%</span>
				</td>
				<td title='순이익성장률'>
				<?
					if($epsAvg > 100)	$epsAvgWidth = 100;
					else						$epsAvgWidth = $epsAvg;
				?>
					<div class="backBar blue" style="width:<?=round($epsAvgWidth,2)?>%;"></div>
					<span><?=round($epsAvg,2)?>%</span>
				</td>
				<td title='고점대비 하락률'>
				<?
					if($nowPer < -100)	$nowPerWidh = -100;
					else						$nowPerWidh = $nowPer;
				?>
					<div class="negative_backBar" style="width:<?=$nowPerWidh*-1?>%;"></div>
					<span><?=$nowPer?>%</span>
				</td>
				<td title='현재주가'>$<?=$nowC?></td>
				<td title='목표주가'>$<?=round($targetMean,2)?></td>
				<td title='상승여력'>
					<div class="half_backWrap">
						<div class="half_back_bar">
						<?
							if($upPer < 0){
								if($upPer < -100)	$upPerWidth = 100;
								else						$upPerWidth = $upPer;
						?>
							<div class="halfBar halfBar_nega" style="width:<?=round($upPerWidth*-1,2)?>%;"></div>
						<?
							}
						?>
						</div>
						<div class="half_back_bar">
						<?
							if($upPer > 0){
								if($upPer > 100)	$upPerWidth = 100;
								else					$upPerWidth = $upPer;
						?>
							<div class="halfBar halfBar_posi green" style="width:<?=round($upPerWidth,2)?>%;"></div>
						<?
							}
						?>
						</div>
					</div>
					<span><?=round($upPer,2)?>%</span>
				</td>
			</tr>
		<?
					}
				}
			}
		?>
		</tbody>
	</table>
</div>