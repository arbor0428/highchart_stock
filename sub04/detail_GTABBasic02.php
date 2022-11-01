<div style="margin-bottom: 50px;">
	<table class="subtable">
		<tbody>
			<tr>
				<th>티커+ETF이름</th>
				<th>운용사이름</th>
				<th>현재가격+1일가격변동폭+퍼센트</th>
				<th>6개월수익률퍼센트</th>
				<th>AUM</th>
				<th>수수료율</th>
				<th>시가분배율 TTM</th>
				<th>ETF홈페이지</th>
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
		if($erow){
			foreach($erow as $k => $v){
				$s = $v['symbol'];
				$percent = str_replace('.0','',$v['percent']);

				$row = sqlRow("select p.*, s.c, s.pmDataDay, s.pmDataMonth6 from api_ETFs_Profile as p left join Stock_Candles_Last as s on p.symbol=s.symbol where p.symbol='".$s."'");

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

				$aum = $row['aum'] / 1000000;

/*
				//해당 ETF 티커를 dividend api 에서 검색을 하는데, from 은 오늘 날짜에서 1년전 날짜를 포함한 월의 1일 (예를들어 오늘이 2022 0614 면 2021 0601 부터), to 는 오늘 날짜 로 해서 나오는 adjustedAmount 를 전부 다 더한 다음 stock candles D 의 C값 최신값으로 나눈 것을 % 로 표기
				$siga = 0;
				$sumAmount = sqlRowOne("select sum(adjustedAmount) from api_Dividends where symbol='".$s."' and dateTime>='".$sTime."' and dateTime<='".$eTime."'");
				if($sumAmount){
					$siga = ($sumAmount / $nowC) * 100;
				}
*/
				$siga = sqlRowOne("select siga from etf_siga where symbol='".$s."'");

				$udClass01 = UpDownClass($row['pmDataMonth6']);		//상승,하락 색상
		?>
			<tr>
				<td title='티커+ETF이름' style="text-align:left;padding:10px 0;">
					<a href="/sub07/sub01.php?gbl_symbol=<?=$s?>">
						<span class="blue bb block"><?=$s?></span>
						<span class="block"><?=$row['name']?></span>
					</a>
				</td>
				<td title='운용사이름'><?=$row['etfCompany']?></td>
				<td title="현재가격+1일가격변동폭+퍼센트"><span class="<?=$txtClass?>"><?=number_format($nowC,2)?> <?=$txtArrow?> (<?=Util::nf1($row['pmDataDay'],2)?>%)</span></td>
				<td title='6개월수익률퍼센트'>
					<span class='<?=$udClass01?>'><?=$row['pmDataMonth6']?>%</span>
					<!--회원가입하면 없어지는 상자
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
				<td title='AUM'><span class="bold">$<?=number_format($aum,2)?></span></td>
				<td title='수수료율'><?=$row['expenseRatio']?>%</td>
				<td title='시가분배율'><?=number_format($siga,2)?>%</td>
				<td title='ETF홈페이지'>
				<?
					if($row['website']){
				?>
					<a href="<?=$row['website']?>" target="_blank">SITE</a>
				<?
					}
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