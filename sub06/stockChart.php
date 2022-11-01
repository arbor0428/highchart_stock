<?
/*
//시가총액
$tmpM = $marketCapitalization * 100;
if($tmpM >= 1000000)	$mcz = Util::num_to_han_s($tmpM,6);
else							$mcz = Util::num_to_han_s($tmpM);

//시가총액(KWR)
$tmpW = $tmpM * $exRate;
if($tmpW >= 1000000)	$mczWon = Util::num_to_han_s($tmpW,6);
else							$mczWon = Util::num_to_han_s($tmpW);
*/

//시가총액
$mcz = Util::convertHan($marketCapitalization,6,2);

//시가총액(KWR)
$tmpW = $marketCapitalization * $exRate;
$mczWon = Util::convertHan($tmpW,6,2);



//기업가치 EV
$fsbq01 = sqlRow("select * from api_Financial_Statements_bs_quarterly where symbol='".$gbl_symbol."' order by uid desc limit 1");
$totalDebt = $fsbq01['totalDebt'];
$cash = $fsbq01['cash'];
$cashEquivalents = $fsbq01['cashEquivalents'];

$evNum = ($marketCapitalization + $totalDebt) - ($cash + $cashEquivalents);

/*
$tmpM = $evNum * 100;
if($tmpM >= 1000000)	$coEv = Util::num_to_han_s($tmpM,6);
else							$coEv = Util::num_to_han_s($tmpM);

//기업가치 EV(KWR)
$tmpW = $tmpM * $exRate;
if($tmpW >= 1000000)	$coEvWon = Util::num_to_han_s($tmpW,6);
else							$coEvWon = Util::num_to_han_s($tmpW);
*/

$coEv = Util::convertHan($evNum,6,2);

//기업가치 EV(KWR)
$tmpW = $evNum * $exRate;
$coEvWon = Util::convertHan($tmpW,6,2);


//PER
$coPer = round(($nowC / $row03['epsExclExtraItemsTTM']),2);




//PBR
$coPbr = round(($nowC / $row03['bookValuePerShareQuarterly']),2);




//ROE
$fsit01 = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$gbl_symbol."' order by period desc limit 1");
$coRoe = ($fsit01['netIncome'] / $fsbq01['totalEquity']) * 100;



//부채비율
$coBoo = sqlRowOne("select v from api_Basic_Financials_quarterly where symbol='".$gbl_symbol."' and series='totalDebtToTotalAsset' order by periodTime desc limit 1");
?>
<div class="analysis_result" style="margin-bottom: 60px; align-items:center;">
	<div class="analysis_graph">
	<?
		//json 파일확인
		if(is_file('/home/myss/www/module/highcharts/'.$gbl_symbol.'.json')){
			include 'stockChart_graph.php';
		}
	?>
	</div>
	<div class="analysis_amount">
		<div class="aa_top">
			<h4 class="box_sub_tit">이것만은 꼭 기억하세요!</h4>
		</div>
		<div class="aa_bot">
			<table class="subtable">
				<tbody>
					<tr>
						<th>시가총액</th>
						<td><span><?=$mcz?> 달러</span><br><span>(<?=$mczWon?> 원)</span></td>
					</tr>
					<tr>
						<th>기업가치 EV</th>
						<td><span><?=$coEv?> 달러</span><span>(<?=$coEvWon?> 원)</span></td>
					</tr>
					<tr>
						<th>PER</th>
						<td><?=$coPer?> 배</td>
					</tr>
					<tr>
						<th>PBR</th>
						<td><?=$coPbr?> 배</td>
					</tr>
					<tr>
						<th>EPS</th>
						<td><?=round($row03['epsExclExtraItemsTTM'],2)?> 달러</td>
					</tr>
					<tr>
						<th>ROE</th>
						<td><?=round($coRoe,2)?>%</td>
					</tr>
					<tr>
						<th>배당률</th>
						<td><?=round($row03['currentDividendYieldTTM'],2)?>%</td>
					</tr>
					<tr>
						<th>부채비율</th>
						<td><?=round(($coBoo*100),2)?>%</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


<style>
	.analysis_result .aa_top .prog_btn {height: 50px;}
</style>