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
				<th>EPS 성장률<br><?=$yArr[0]?></th>
				<th>EPS 성장률<br><?=$yArr[1]?></th>
				<th>EPS 성장률<br><?=$yArr[2]?></th>
				<th>EPS 성장률<br><?=$yArr[3]?></th>
				<th>EPS 성장률<br><?=$yArr[4]?></th>
				<th>평균<br>EPS 성장률</th>
				<th>P/E (FWD)</th>
				<th>PEG Ratio</th>
				<th>섹터 평균<br>PEG Ratio</th>
				<th>성장성 지수<br>Value (PER)</th>
				<th>52주 최고주가</th>
				<th>현재주가</th>
				<th>고점대비 하락율</th>
				<th>적정주가<br>(성장성 반영)</th>
				<th>현재주가 대비<br>적정주가 차이</th>
			</tr>
		<?
			foreach($gArr as $s){
				$cpRow = sqlRow("select * from api_Company_Profile where symbol='".$s."'");
				$gsector = $cpRow['gsector'];

			/*
				종목 EPS GROWTH
				EPS growth 2022 Earnings Estimates -> annual -> epsAvg 값 사용
				EPS growth 2023 = 2023값 / 2022값 -1 을 퍼센트로 표현
				2024 2025 2026 전부 마찬가지
			*/
				$epsGrowthAgo = sqlRowOne("select epsAvg from api_Earnings_Estimates where symbol='".$s."' and freq='annual' and period<".$yArr[0]." order by period desc limit 1");	//작년값

				$epsRow = sqlArray("select * from api_Earnings_Estimates where symbol='".$s."' and freq='annual' and period>=".$yArr[0]." and period<=".$yArr[4]." order by period");

				$epsGrowth = (($epsRow[0]['epsAvg'] / $epsGrowthAgo) - 1) * 100;					//올해값
				$epsGrowth01 = (($epsRow[1]['epsAvg'] / $epsRow[0]['epsAvg']) - 1) * 100;	//+1년값
				$epsGrowth02 = (($epsRow[2]['epsAvg'] / $epsRow[1]['epsAvg']) - 1) * 100;	//+2년값
				$epsGrowth03 = (($epsRow[3]['epsAvg'] / $epsRow[2]['epsAvg']) - 1) * 100;	//+3년값
				$epsGrowth04 = (($epsRow[4]['epsAvg'] / $epsRow[3]['epsAvg']) - 1) * 100;	//+4년값

				//종목 EPS GROWTH 5년치 평균
				$epsGrowthAvg = ($epsGrowth + $epsGrowth01 + $epsGrowth02 + $epsGrowth03 + $epsGrowth04) / 5;

			/*
				P/E (12M Fwd)
				분자 : stock candles D 의 최신C 값
				분모 : Earnings Estimates -> annual -> epsAvg 값 내년수치 (올해가 2022면 2023 사용)
			*/
				$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$s."'");
				$peFWD = $nowC / $epsRow[1]['epsAvg'];

			/*
				PEG Ratio (12M Fwd)
				분자 : P/E (12M Fwd)
				분모 : 종목 EPS GROWTH 5년치 평균
			*/
				$pegRatio = $peFWD / $epsGrowthAvg;

			/*
				섹터 PEG Ratio (12개월 FWD)
				분자 : 섹터 PER GAAP(12개월 FWD)
				분모 : ((각 종목의 Earnings Estimates -> 2023년 값 *발행주식수(Company Profile->shareOutstanding) / (각 종목의 Earnings Estimates -> 2022년 값*발행주식수(Company Profile->shareOutstanding) -1 ) * 100  의 총합-> 퍼센트값에 *100을 한다. 예:63% 면 0.63 이 아니라 63 으로 계산
			*/
				$pegRatio_sector = sqlRowOne("select avg04 from gsectorAvg where gsector='".$gsector."'");


			/*
				성장성 지수 Value (PER)
				종목 EPS GROWTH 5년치 평균 * 섹터 PEG Ratio (12개월 FWD)				
			*/
				$perValue = $epsGrowthAvg * $pegRatio_sector;

				//52주 최고주가
				$WeekHigh52 = sqlRowOne("select WeekHigh52 from api_Basic_Financials where symbol='".$s."'");

				//고점대비 하락율
				$nowPer = Util::fnPercent($WeekHigh52,$nowC);

			/*
				적정주가(성장성 반영)
				현재주가 * (성장성지수 / P/E (12M Fwd))
			*/
				$okStock = $nowC * ($perValue / $peFWD);

			/*
				현재주가 대비 적정주가 차이
				(P/E (12M Fwd) - 성장성지수) / 성장성지수
			*/
				$gapStock = (($peFWD - $perValue) / $perValue) * 100;
		?>
			<tr>
				<td title='Ticker'><?=$s?></td>
				<td title='Sector'><?=$gsector?></td>
				<td title='EPS 성장률 <?=$yArr[0]?>'><?=round($epsGrowth,2)?>%</td>
				<td title='(예상)EPS 성장률 <?=$yArr[1]?>'><?=round($epsGrowth01,2)?>%</td>
				<td title='(예상)EPS 성장률 <?=$yArr[2]?>'><?=round($epsGrowth02,2)?>%</td>
				<td title='(예상)EPS 성장률 <?=$yArr[3]?>'><?=round($epsGrowth03,2)?>%</td>
				<td title='(예상)EPS 성장률 <?=$yArr[4]?>'><?=round($epsGrowth04,2)?>%</td>
				<td title='(예상)평균 EPS 성장률'><?=round($epsGrowthAvg,2)?>%</td>
				<td title='(예상)P/E'><?=round($peFWD,2)?></td>
				<td title='PEG Ratio'><?=round($pegRatio,2)?></td>
				<td title='섹터 평균 PEG Ratio'><?=round($pegRatio_sector,2)?></td>
				<td title='성장성 지수 Value (PER)'><?=round($perValue,2)?></td>
				<td title='52주 최고주가'><?=round($WeekHigh52,2)?></td>
				<td title='현재주가'><?=$nowC?></td>
				<td title='고점대비 하락율'><?=round($nowPer,2)?>%</td>
				<td title='적정주가 (성장성 반영)'><?=round($okStock,2)?></td>
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