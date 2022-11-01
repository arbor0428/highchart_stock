<?
	if(!$record_count)		$record_count = 30;		//한 페이지에 출력되는 레코드수

	$link_count = 10; //한 페이지에 출력되는 페이지 링크수

	if(!$record_start){
		$record_start = 0;
	}

	$current_page = ($record_start / $record_count) + 1;

	$group = floor($record_start / ($record_count * $link_count));

	//쿼리조건
	$query_ment = "where p.uid>0";

	if($f_invest)		$query_ment .= " and p.investmentSegment='".$f_invest."'";	//검색어

	if($fxType == 'x2')					$query_ment .= " and p.x2='Y' and p.x3='N' and p.inverse='N'";
	elseif($fxType == 'x3')				$query_ment .= " and p.x2='N' and p.x3='Y' and p.inverse='N'";
	elseif($fxType == 'inverse')		$query_ment .= " and p.x2='N' and p.x3='N' and p.inverse='Y'";
	elseif($fxType == 'x2_inverse')	$query_ment .= " and p.x2='Y' and p.x3='N' and p.inverse='Y'";
	elseif($fxType == 'x3_inverse')	$query_ment .= " and p.x2='N' and p.x3='Y' and p.inverse='Y'";



	if($query_ment == 'where p.uid>0')		$query_ment = "where 1=0";

	//정렬방식
	$sort_ment = "order by p.symbol";

	$query = "select p.*, s.c, s.pmDataDay, s.pmDataMonth6 from api_ETFs_Profile as p left join Stock_Candles_Last as s on p.symbol=s.symbol $query_ment";

	$result = mysql_query($query) or die("연결실패");

	$total_record = mysql_num_rows($result);

	$total_page = (int)($total_record / $record_count);

	if($total_record % $record_count){
		$total_page++;
	}

	$query2 = $query." $sort_ment limit $record_start, $record_count";

	$result = mysql_query($query2);
?>
	<table class="subtable inverse_result">
		<tbody>
			<tr>
				<th>티커+ETF이름</th>
				<th>운용사이름</th>
				<th>현재가격+1일가격변동폭+퍼센트</th>
				<th>6개월수익률퍼센트</th>
				<th>AUM</th>
				<th>수수료율</th>
				<th>시가분배율</th>
				<th>ETF홈페이지</th>
				<th>기사</th>
			</tr>
<?
if($total_record){
	$i = $total_record - ($current_page - 1) * $record_count;

	while($row = mysql_fetch_array($result)){
		$symbol = $row['symbol'];
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

		//해당 ETF 티커를 dividend api 에서 검색을 하는데, from 은 오늘 날짜에서 1년전 날짜를 포함한 월의 1일 (예를들어 오늘이 2022 0614 면 2021 0601 부터), to 는 오늘 날짜 로 해서 나오는 adjustedAmount 를 전부 다 더한 다음 stock candles D 의 C값 최신값으로 나눈 것을 % 로 표기
		$siga = 0;
		$sumAmount = sqlRowOne("select sum(adjustedAmount) from api_Dividends where symbol='".$symbol."' and dateTime>='".$sTime."' and dateTime<='".$eTime."'");
		if($sumAmount){
			$siga = ($sumAmount / $nowC) * 100;
		}

		if(!$row['pmDataMonth6'])		$row['pmDataMonth6'] = 0;

		$udClass01 = UpDownClass($row['pmDataMonth6']);		//상승,하락 색상
?>
			<tr>
				<td style='text-align:left;' title='티커+ETF이름'>
					<a href="/sub07/sub01.php?gbl_symbol=<?=$symbol?>">
						<span class="blue bb block"><?=$symbol?></span>
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
				<td title="기사링크"><a href="javascript:newsList('<?=$symbol?>');"><i class="fas fa-chalkboard-teacher"></i></a></td>
			</tr>
<?
		$i--;
	}

}else{
?>
			<tr> 
				<td colspan="9" align='center' height='50'>데이터가 없습니다.</td>
			</tr>
<?
}
?>
		</tbody>
	</table>

<?
	$fName = 'frm_invest';
	include '../module/pageNumCount.php';
?>