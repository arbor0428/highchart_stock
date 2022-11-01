<?
if($etf == 'N'){
	//회사정보
	$row01 = sqlRow("select * from api_Company_Profile where symbol='".$symbol."'");
	$marketCapitalization = $row01['marketCapitalization'];	//시가총액

	//quote(실시간)
	$row02 = QuoteAPI($symbol); //(c:가격, d:전날과의 가격차, dp:가격차%)
	$lowC = round($row02['l'],2);
	$nowC = round($row02['c'],2);
	$highC = round($row02['h'],2);
	$perC = Util::fnPercentage($lowC,$nowC,$highC);
	if($perC > 93)		$perC = 93;	//포인트가 93이 넘어가면 최고값 숫자를 가림..


	$row03 = sqlRow("select * from api_Basic_Financials where symbol='".$symbol."'");
	$WeekLow52 = round($row03['WeekLow52'],2);
	$WeekHigh52 = round($row03['WeekHigh52'],2);
	$perWeek = Util::fnPercentage($WeekLow52,$nowC,$WeekHigh52);
	if($perWeek > 93)		$perWeek = 93;	//포인트가 93이 넘어가면 최고값 숫자를 가림..

}elseif($etf == 'Y'){
	//회사정보
	$row01 = sqlRow("select * from api_ETFs_Profile where symbol='".$symbol."'");

	//quote(실시간) = 일일 변동폭
	$row02 = QuoteAPI($symbol); //(c:가격, d:전날과의 가격차, dp:가격차%)
	$lowC = round($row02['l'],2);
	$nowC = round($row02['c'],2);
	$highC = round($row02['h'],2);
	$perC = Util::fnPercentage($lowC,$nowC,$highC);
	if($perC > 93)		$perC = 93;	//포인트가 93이 넘어가면 최고값 숫자를 가림..

	//52주 변동폭
	$t = sqlRowOne("select t from api_Stock_Candles_W where symbol='".$symbol."' order by t desc limit 51,1");
	$row03 = sqlRow("select min(c) as minC, max(c) as maxC from api_Stock_Candles_W where symbol='".$symbol."' and t>='".$t."'");
	$WeekLow52 = $row03['minC'];
	$WeekHigh52 = $row03['maxC'];
	$perWeek = Util::fnPercentage($WeekLow52,$nowC,$WeekHigh52);
	if($perWeek > 93)		$perWeek = 93;	//포인트가 93이 넘어가면 최고값 숫자를 가림..
}
?>

<div class="detail_ticker">
	<div class="ticker_left">
		<div class="ticker_left_top">
			<div class="ticker_tit">
				<p><?=$symbol?></p>
				<span><?=$row01['nameKor']?><br><?=$row01['name']?></span>
			</div>
			<div class="ticker_markWrap">
				<div class="ticker_mark">
					<button type="button" title="스크랩" class="bookmark active"></button>
					<span>관심종목</span>
				</div>
				<div class="ticker_mark">
					<button type="button" title="스크랩" class="bookmark"></button>
					<span>보유종목</span>
				</div>
			</div>
		<?
			$tmpChk = sqlRowOne("select count(*) from koreanBuy where symbol='".$symbol."'");
			if($tmpChk){
		?>
			<div>
				<p>*한국인 매수 상위 50종목*</p>
			</div>
		<?
			}
		?>
		</div>
		<div class="ticker_left_bot">
			<div class="ticker_num">
				<span class="num_amount"><?=$nowC?></span>
			<?
				if($row02['d'] > 0){
			?>
				<span class="updown_arrow" style="color:#eb0828;">▲</span>
			<?
				}elseif($row02['d'] < 0){
			?>
				<span class="updown_arrow" style="color:#1000ff;">▼</span>
			<?
				}else{
			?>
				<span class="updown_arrow" style="color:#222;">-</span>
			<?
				}
			?>
			</div>
			<div class="updown_amnt">
				<div class="updown">
					<p><?=round($row02['d'],2)?></p>
					<p><?=round($row02['dp'],2)?>%</p>
				</div>
				<div class="updown">
					<p>일일 변동폭</p>
					<p>52주 변동폭</p>
				</div>
			</div>
			<div class="slider-cont">
				<div class="slider_updown">
					<span class="rtext updown_num"><?=$lowC?></span>
					<div class="updown_bar">
						<div class="bar_back"></div><!--뒤에 막대기-->
						<div class="bar_front" style="left:<?=$perC?>%;"></div> <!--점-->
					</div>
					<span class="updown_num"><?=$highC?></span>
				</div>
				<div class="slider_updown">
					<span  class="rtext updown_num"><?=$WeekLow52?></span>
					<div class="updown_bar">
						<div class="bar_back"></div><!--뒤에 막대기-->
						<div class="bar_front" style="left:<?=$perWeek?>%;"></div><!--점-->
					</div>
					<span class="updown_num"><?=$WeekHigh52?></span>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.detail_ticker .ticker_left {width: 100%;}
	.detail_ticker .ticker_left .ticker_left_top .ticker_tit {margin-right: 10px;}
	.detail_ticker .ticker_left .ticker_left_top .ticker_tit p {font-size: 35px;}
	.detail_ticker .ticker_left .ticker_left_top .ticker_tit span {font-size: 16px;}
	.detail_ticker .ticker_left .ticker_left_bot .ticker_num .num_amount {font-size: 28px;}
	.detail_ticker .ticker_left .ticker_left_bot .updown_amnt .updown {width: 84px;}
	.detail_ticker .ticker_left .ticker_left_bot .updown_bar {width: 160px;}
</style>