<?
	include '../header.php';

	//적정주가 - 순이익 관점
	$gArr = Array("AAPL","TSLA","AMZN","V");

	$yArr = Array();
	for($i=0; $i<5; $i++){
		$yArr[$i] = date('Y') + $i;
	}
?>


<div id="sub_cont">
	<div class="inner">
		<table cellpadding='0' cellspacing='0' border='0' width='100%' class='gTable'>
			<tr>
				<th>Ticker</th>
				<th>Sector</th>
				<th>매출성장률<br><?=$yArr[0]?></th>
				<th>매출성장률<br><?=$yArr[1]?></th>
				<th>매출성장률<br><?=$yArr[2]?></th>
				<th>매출성장률<br><?=$yArr[3]?></th>
				<th>매출성장률<br><?=$yArr[4]?></th>
				<th>평균<br>매출성장률</th>
				<th>P/S<br>(Fwd)</th>
				<th>PSG<br>Ratio</th>
				<th>Operating<br>Margin</th>
				<th>섹터 PSG<br>Ratio</th>
				<th>섹터 Operating<br>Margin</th>
				<th>40%<br>Rule</th>
				<th>성장성 지수<br>Value(PSR)</th>
				<th>Valuation<br>할인률</th>
				<th>성장성+수익성<br>Value(PSR)</th>
				<th>52주<br>최고주가</th>
				<th>현재주가</th>
				<th>고점대비 하락률</th>
				<th>적정주가<br>(성장성 반영)</th>
				<th>적정주가<br>(성장성+수익성 반영)</th>
				<th>현재주가 대비<br>적정주가 차이</th>
			</tr>
		<?
			foreach($gArr as $s){
				$cpRow = sqlRow("select * from api_Company_Profile where symbol='".$s."'");
				$gsector = $cpRow['gsector'];

				$bfs = sqlRow("select * from api_Basic_Financials where symbol='".$s."'");

			/*
				종목 Sales GROWTH (revenue = sales 입니다)
				Revenue Estimates -> annual -> revenueAvg

				Sales growth 2023 = 2023값 / 2022값 -1 을 퍼센트로 표현
				2024 2025 2026 전부 마찬가지
			*/
				$salesGrowthAgo = sqlRowOne("select revenueAvg from api_Revenue_Estimates where symbol='".$s."' and freq='annual' and period<".$yArr[0]." order by period desc limit 1");	//작년값

				$revRow = sqlArray("select * from api_Revenue_Estimates where symbol='".$s."' and freq='annual' and period>=".$yArr[0]." and period<=".$yArr[4]." order by period");

				$salesGrowth = (($revRow[0]['revenueAvg'] / $salesGrowthAgo) - 1) * 100;						//+올해값
				$salesGrowth01 = (($revRow[1]['revenueAvg'] / $revRow[0]['revenueAvg']) - 1) * 100;	//+1년값
				$salesGrowth02 = (($revRow[2]['revenueAvg'] / $revRow[1]['revenueAvg']) - 1) * 100;	//+2년값
				$salesGrowth03 = (($revRow[3]['revenueAvg'] / $revRow[2]['revenueAvg']) - 1) * 100;	//+3년값
				$salesGrowth04 = (($revRow[4]['revenueAvg'] / $revRow[3]['revenueAvg']) - 1) * 100;	//+4년값

				//종목 EPS GROWTH 5년치 평균
				$salesGrowthAvg = ($salesGrowth + $salesGrowth01 + $salesGrowth02 + $salesGrowth03 + $salesGrowth04) / 5;

			/*
				P/S (12M Fwd)
				분자 : stock candles D 의 최신C 값
				분모 : Revenue Estimates -> annual -> revenueAvg 값 내년수치 (올해가 2022면 2023 사용)"
			*/
				$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$s."'");
				$psFWD = Util::infiniteDecimal($nowC / $revRow[1]['revenueAvg']);		//무한 소수점 변환

			/*
				PSG Ratio (12M Fwd)
				P/S (12M Fwd) / 종목 EPS GROWTH 5년치 평균
			*/
				$psgRatio = $psFWD / $salesGrowthAvg;

			/*
				Operating Margin = 영업이익률(TTM) - op마진
				basic financials - operatingMarginTTM 을 숫자 그대로 퍼센트로 표현 (30 이면 30%)
			*/
				$opMargin = $bfs['operatingMarginTTM'];

			/*
				Sector PSG Ratio
				분자 : 섹터 PSR (FWD)
				분모 : (각 종목의 Revenue Estimates -> annual ->revenueAvg 의 내년값 합산)/ (각 종목의 Revenue Estimates -> annual ->revenueAvg 의 올해값 합산)-1 * 100
			*/
				$gsa = sqlRow("select * from gsectorAvg where gsector='".$gsector."'");
				$psgRatio_sector = $gsa['avg17'];

			/*
				Sector Operating Margin
			*/
				$opMargin_sector = $gsa['avg13'];

			/*
				40% Rule
				Sales growth 올해 + Operating Margin
			*/
				$rule40 = $salesGrowth + $opMargin;


			/*
				성장성 지수 Value (PSR)
				종목 EPS GROWTH 5년치 평균 * 100) * Sector PSG Ratio
			*/
				$psrValue = $salesGrowthAvg * $psgRatio_sector;

			/*
				Valuation 할인률
				K8 = $opMargin
				M8 = $opMargin_sector
				=IF(K8<M8,IF(K8<0,(K8+M8)/2,(K8-M8)/2),(K8-M8)/2)
			*/
				if($opMargin < $opMargin_sector){
					if($opMargin < 0){
						$saleValue = ($opMargin + $opMargin_sector) / 2;
					}else{
						$saleValue = ($opMargin - $opMargin_sector) / 2;
					}

				}else{
					$saleValue = ($opMargin - $opMargin_sector) / 2;
				}

			/*
				성장성+수익성 Value (PSR)
				성장성 지수 Value (PER) + (성장성 지수 Value (PER) * Valuation 할인률)
			*/
				$psrValue2 = $psrValue + ($psrValue * ($saleValue / 100));

				//52주 최고주가
				$WeekHigh52 = sqlRowOne("select WeekHigh52 from api_Basic_Financials where symbol='".$s."'");

				//고점대비 하락률
				$nowPer = Util::fnPercent($WeekHigh52,$nowC);

			/*
				적정주가(성장성 반영)
				현재주가 * (성장성 지수 Value (PSR) / P/S (12M Fwd))
			*/
				$okStock = $nowC * ($psrValue / $psFWD);

			/*
				적정주가(성장성+수익성 반영)
				현재주가 * (성장성+수익성 Value (PSR) / P/S (12M Fwd))
			*/
				$okStock2 = $nowC * ($psrValue2 / $psFWD);

			/*
				현재주가 대비 적정주가 차이
				(P/S (12M Fwd) - 성장성+수익성 Value (PSR)) / P/S (12M Fwd)
			*/
				$gapStock = (($psFWD - $psrValue2) / $psFWD) * 100;
		?>
			<tr>
				<td title='Ticker'><?=$s?></td>
				<td title='Sector'><?=$gsector?></td>
				<td title='매출성장률 <?=$yArr[0]?>'><?=round($salesGrowth,2)?>%</td>
				<td title='매출성장률 <?=$yArr[1]?>'><?=round($salesGrowth01,2)?>%</td>
				<td title='매출성장률 <?=$yArr[2]?>'><?=round($salesGrowth02,2)?>%</td>
				<td title='매출성장률 <?=$yArr[3]?>'><?=round($salesGrowth03,2)?>%</td>
				<td title='매출성장률 <?=$yArr[4]?>'><?=round($salesGrowth04,2)?>%</td>
				<td title='평균 매출성장률'><?=round($salesGrowthAvg,2)?>%</td>
				<td title='P/S (Fwd)'><?=round($psFWD,2)?></td>
				<td title='PSG Ratio'><?=round($psgRatio,2)?></td>
				<td title='Operating Margin'><?=round($opMargin,2)?>%</td>
				<td title='섹터 PSG Ratio'><?=round($psgRatio_sector,2)?></td>
				<td title='섹터 Operating Margin'><?=round($opMargin_sector,2)?></td>
				<td title='40% Rule'><?=round($rule40,2)?>%</td>
				<td title='성장성 지수 Value(PSR)'><?=round($psrValue,2)?></td>
				<td title='Valuation 할인률'><?=round($saleValue,2)?></td>
				<td title='성장성+수익성 Value(PSR)'><?=round($psrValue2,2)?></td>
				<td title='52주 최고주가'><?=round($WeekHigh52,2)?></td>
				<td title='현재주가'><?=$nowC?></td>
				<td title='고점대비 하락률'><?=round($nowPer,2)?>%</td>
				<td title='적정주가 (성장성 반영)'><?=round($okStock,2)?></td>
				<td title='적정주가 (성장성+수익성 반영)'><?=round($okStock2,2)?></td>
				<td title='현재주가 대비 적정주가 차이'><?=round($gapStock,2)?>%</td>
			</tr>
		<?
			}
		?>

		</table>
	</div>
</div>


<?
	include '../footer.php';
?>