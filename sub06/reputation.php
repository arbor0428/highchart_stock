<?
//섹터평균
$gsArr = sqlRow("select * from gsectorAvg where gsector='".$row01['gsector']."'");
?>

<div class="openHide" style="cursor:pointer;margin-bottom: 20px; border-radius: 40px; width: 150px; height: 40px; line-height: 40px; text-align: center; color: #fff; background-color: #0c1540;">
	회사개요 접기
</div>

<div class="tickerDetailInfo" style="margin-bottom: 0;">
	<div class="ora_line"></div>
	<div class="detail_wrap">
		<div class="txtBox">
			<div class="titWrap">
				<p class="ticker_tit"><?=$gbl_symbol?></p>
				<p class="ticker_sub"><?=$row01['nameKor']?><br><?=$row01['name']?></p>
			</div>
			<p class="ticker_det">
			<?
				if($row01['descriptionKor'])	echo $row01['descriptionKor'];	//번역자료(국문)
				else									echo $row01['description'];		//영문
			?>
			</p>
		</div>
		<div class="tableWrap">
			<table class="smallTable">
				<tbody>
					<tr>
						<th>섹터</th>
						<td><?=$row01['gsector']?></td>
					</tr>
					<tr>
						<th>산업군</th>
						<td><?=$row01['gind']?></td>
					</tr>
					<tr>
						<th>종업원수</th>
						<td><?=number_format($row01['employeeTotal'])?></td>
					</tr>
					<tr>
						<th>홈페이지</th>
						<td><a href="<?=$row01['weburl']?>" target="_blank" title="site"><?=$row01['weburl']?></a></td>
					</tr>
					<tr>
						<th>본사주소</th>
						<td><?=$row01['address']?>, <?=$row01['city']?>, <?=$row01['country']?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	var flag = true;
	$(".openHide").on("click",function(){

		if(flag){

			$(".tickerDetailInfo").stop().slideUp();
			$(".openHide").text("회사개요 펼치기");
			flag= false;
		} else {

			$(".tickerDetailInfo").stop().slideDown();
			$(".openHide").text("회사개요 접기");
			flag= true;
		}

	});
</script>


<?
//PER Non-GAAP
$per01 = $nowC / $row03['epsExclExtraItemsTTM'];

//PER GAAP
$actual = 0;
$itemTmp = EarningsAPI($gbl_symbol,4);
if($itemTmp){
	foreach($itemTmp as $item){
		$actual += $item['actual'];
	}
}

//$per02 = $nowC / $row03['epsInclExtraItemsTTM'];
$per02 = $nowC / $actual;

//PEG GAAP
$per03 = ($nowC / $row03['epsInclExtraItemsTTM']) / $row03['epsGrowthTTMYoy'];

//PSR
$per04 = $nowC / $row03['revenuePerShareTTM'];

//PBR
$per05 = $nowC / $row03['bookValuePerShareQuarterly'];
?>

<div class="anal_tableWrap">
	<div class="analysis_table">
		<h3 class="sub_tit">고평가/저평가...확인해 보셨나요?</h3>
		<table class="subtable">
			<tbody>
				<tr>
					<th colspan="2">*지난 12개월 기준</th>
					<th>섹터 평균</th>
				</tr>
				<tr>
					<td>PER Non GAAP(TTM)</td>
					<td><?=round($per01,2)?></td>
					<td><?=$gsArr['avg01']?></td>
				</tr>
				<tr>
					<td>PER GAAP(TTM)</td>
					<td><?=round($per02,2)?></td>
					<td><?=$gsArr['avg02']?></td>
				</tr>
				<tr>
					<td>PEG GAAP(TTM)</td>
					<td><?=round($per03,2)?></td>
					<td><?=$gsArr['avg04']?></td>
				</tr>
				<tr>
					<td>PSR(TTM)</td>
					<td><?=round($per04,2)?></td>
					<td><?=$gsArr['avg05']?></td>
				</tr>
				<tr>
					<td>PBR(TTM)</td>
					<td><?=round($per05,2)?></td>
					<td><?=$gsArr['avg06']?></td>
				</tr>
			</tbody>
		</table>
	</div>

<?
//매출액성장률(YOY)
$per01 = $row03['revenueGrowthQuarterlyYoy'];


/*
/EBIT성장률(YOY)
분자 / 분모 -1 을 % 로표기한다.
분자 : basic financials -> ebitPerShare 2번째 ("quarterly" 아래에있는것, 동일 값이 "series": {"annual": 에도있습니다주의)의 1번째
분모 : basic financials -> ebitPerShare 2번째 ("quarterly" 아래에있는것, 동일 값이 "series": {"annual": 에도있습니다주의)의 5번째
*/
$bz = sqlRowOne("select v from api_Basic_Financials_quarterly where symbol='".$gbl_symbol."' and series='ebitPerShare' order by periodTime desc limit 1");
$bm = sqlRowOne("select v from api_Basic_Financials_quarterly where symbol='".$gbl_symbol."' and series='ebitPerShare' order by periodTime desc limit 4,1");
$per02 = (($bz/$bm) - 1) * 100;



/*
영업이익성장률(YOY)
Basic financials -> operatingMargin 값중 “quarterly" 아래에 있는
첫번째값/ 다섯번째값 -1 해서 %로나타냅니다
*/
$bfq01 = sqlRow("select * from api_Basic_Financials_quarterly where symbol='".$gbl_symbol."' and series='operatingMargin' order by periodTime desc limit 1");
$bfq05 = sqlRow("select * from api_Basic_Financials_quarterly where symbol='".$gbl_symbol."' and series='operatingMargin' order by periodTime desc limit 4,1");
$per03 = (($bfq01['v']/$bfq05['v']) - 1) * 100;



/*순이익성장률(YOY)
분자 :  financial statements -> income statement  -> quarterly 로설정한후 netIncome 1번째
분모 :  financial statements -> income statement  -> quarterly 로설정한후 netIncome 5번째
분자/분모 -1 값을 %로표현
*/
$fsiq01 = sqlRow("select * from api_Financial_Statements_ic_quarterly where symbol='".$gbl_symbol."' order by period desc limit 1");
$fsiq05 = sqlRow("select * from api_Financial_Statements_ic_quarterly where symbol='".$gbl_symbol."' order by period desc limit 4,1");
$per04 = (($fsiq01['netIncome']/$fsiq05['netIncome']) - 1) * 100;



/*
ROE성장률(YOY)
분자 : financial statements -> IS -> ttm->  netIncome 첫번째값 / financial statements -> BS -> quarterly ->  totalEquity 첫번째값
분모 : financial statements -> IS -> ttm->  netIncome 다섯번째값 / financial statements -> BS -> quarterly ->  totalEquity 다섯번째값
분자/분모 -1 값을 %로표현
*/
$fsit01 = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$gbl_symbol."' order by period desc limit 1");
$fsbq01 = sqlRow("select * from api_Financial_Statements_bs_quarterly where symbol='".$gbl_symbol."' order by uid desc limit 1");

$fsit05 = sqlRow("select * from api_Financial_Statements_ic_ttm where symbol='".$gbl_symbol."' order by period desc limit 4,1");
$fsbq05 = sqlRow("select * from api_Financial_Statements_bs_quarterly where symbol='".$gbl_symbol."' order by uid desc limit 4,1");

$bz = $fsit01['netIncome'] / $fsbq01['totalEquity'];
$bm = $fsit05['netIncome'] / $fsbq05['totalEquity'];
$per05 = (($bz/$bm) - 1) * 100;
?>
	<div class="analysis_table">
		<h3 class="sub_tit">성장하고 있는 기업인가요?</h3>
		<table class="subtable">
			<tbody>
				<tr>
					<th colspan="2">*전년대비 기준</th>
					<th>섹터 평균</th>
				</tr>
				<tr>
					<td>매출액성장률(YOY)</td>
					<td><?=round($per01,2)?>%</td>
					<td><?=$gsArr['avg07']?>%</td>
				</tr>
				<tr>
					<td>EBIT성장률(YOY)</td>
					<td><?=round($per02,2)?>%</td>
					<td><?=$gsArr['avg08']?>%</td>
				</tr>
				<tr>
					<td>영업이익성장률(YOY)</td>
					<td><?=round($per03,2)?>%</td>
					<td><?=$gsArr['avg09']?>%</td>
				</tr>
				<tr>
					<td>순이익성장률(YOY)</td>
					<td><?=round($per04,2)?>%</td>
					<td><?=$gsArr['avg10']?>%</td>
				</tr>
				<tr>
					<td>ROE성장률(YOY)</td>
					<td><?=round($per05,2)?>%</td>
					<td><?=$gsArr['avg11']?>%</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


<?
//매출총이익률
$per01 = $row03['grossMarginTTM'];


/*
EBIT이익률(TTM)
financial statements - income statements - ttm 으로 설정한 후
분자 : 첫번째 ebit 값
분모 : 첫번째revenue 값 을 퍼센트로 표현
*/
$per02 = ($fsit01['ebit']/$fsit01['revenue']) * 100;


//영업이익률(TTM)
$per03 = $row03['operatingMarginTTM'];


//당기순이익률
$per04 = $row03['netProfitMarginTTM'];


//ROE
$per05 = $coRoe;	//stockChart.php에서 선언됨

?>
<div class="anal_tableWrap">
	<div class="analysis_table">
		<h3 class="sub_tit">이익을 내고 있는 기업인가요?</h3>
		<table class="subtable">
			<tbody>
				<tr>
					<th colspan="2">*지난 12개월 기준</th>
					<th>섹터 평균</th>
				</tr>
				<tr>
					<td>매출총이익률</td>
					<td><?=round($per01,2)?>%</td>
					<td><?=$gsArr['avg12']?>%</td>
				</tr>
				<tr>
					<td>EBIT이익률(TTM)</td>
					<td><?=round($per02,2)?>%</td>
					<td><?=$gsArr['avg18']?>%</td>
				</tr>
				<tr>
					<td>영업이익률(TTM)</td>
					<td><?=round($per03,2)?>%</td>
					<td><?=$gsArr['avg13']?>%</td>
				</tr>
				<tr>
					<td>당기순이익률</td>
					<td><?=round($per04,2)?>%</td>
					<td><?=$gsArr['avg14']?>%</td>
				</tr>
				<tr>
					<td>ROE</td>
					<td><?=round($per05,2)?>%</td>
					<td><?=$gsArr['avg15']?>%</td>
				</tr>
			</tbody>
		</table>
	</div>

<?
//배당수익률
$per01 = $row03['currentDividendYieldTTM'];


//배당지급액
$per02 = 0;
$tmp = sqlArray("select * from api_Dividends where symbol='".$gbl_symbol."' order by dateTime desc limit 4");
foreach($tmp as $v){
	$per02 += $v['adjustedAmount'];
}


//배당성향(payout ratio)
$bz = $per02 * $row01['shareOutstanding'];
$bm = 0;
$tmp = sqlArray("select * from api_Financial_Statements_ic_quarterly where symbol='".$gbl_symbol."' order by period desc limit 4");
foreach($tmp as $v){
	$bm += $v['netIncome'];
}
$per03 = ($bz / $bm) * 100;


//배당성장률
$per04 = $row03['dividendGrowthRate5Y'];
?>
	<div class="analysis_table">
		<h3 class="sub_tit">배당금을 주는 기업인가요?</h3>
		<table class="subtable">
			<tbody>
				<tr>
					<th colspan="3">*추정치</th>
				</tr>
				<tr>
					<td>배당수익률</td>
					<td><?=round($per01,2)?>%</td>
				</tr>
				<tr>
					<td>배당지급액(DPS,1년)</td>
					<td><?=round($per02,2)?></td>
				</tr>
				<tr>
					<td>배당성향(payout ratio)</td>
					<td><?=round($per03,2)?>%</td>
				</tr>
				<tr>
					<td>배당성장률</td>
					<td><?=round($per04,2)?>%</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>