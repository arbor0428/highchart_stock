<?
//회사정보
$row01 = sqlRow("select * from api_Company_Profile where symbol='".$gbl_symbol."'");
$marketCapitalization = $row01['marketCapitalization'];	//시가총액

//quote(실시간)
$row02 = QuoteAPI($gbl_symbol); //(c:가격, d:전날과의 가격차, dp:가격차%)
$lowC = round($row02['l'],2);
$nowC = round($row02['c'],2);
$highC = round($row02['h'],2);
$perC = Util::fnPercentage($lowC,$nowC,$highC);
if($perC > 93)		$perC = 93;	//포인트가 93이 넘어가면 최고값 숫자를 가림..


$row03 = sqlRow("select * from api_Basic_Financials where symbol='".$gbl_symbol."'");
$WeekLow52 = round($row03['WeekLow52'],2);
$WeekHigh52 = round($row03['WeekHigh52'],2);
$perWeek = Util::fnPercentage($WeekLow52,$nowC,$WeekHigh52);
if($perWeek > 93)		$perWeek = 93;	//포인트가 93이 넘어가면 최고값 숫자를 가림..
?>

<div class="detail_ticker">
	<div class="ticker_left">
		<div class="ticker_left_top">
			<div class="ticker_tit">
				<p><?=$gbl_symbol?></p>
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
			$tmpChk = sqlRowOne("select count(*) from koreanBuy where symbol='".$gbl_symbol."'");
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
	<div class="ticker_right">
		<p><?=$row01['name']?></p>
		<table class="subtable">
			<tbody>
				<tr>
					<td>
					<?
						$item = sqlArray("select * from api_Indices_Constituents where stxt='".$gbl_symbol."' order by uid");
						foreach($item as $v){
							echo $v['name'].'<br>';
						}
					?>
					</td>
					<td><?=$row01['gsector']?></td>
					<td><?=$row01['gind']?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>