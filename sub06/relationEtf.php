<?
//제이쿼리 로드함수를 이용해 페이지가 로딩된 경우
if($_GET['jQueryLoad']){
	include "../module/class/class.DbCon.php";
	include "../module/class/class.Util.php";
	include '../module/lib.php';
?>
<script>
$(document).ready(function(){
	$("#loading").delay("200").fadeOut();
});
</script>
<?
}
	if(!$record_count)		$record_count = 10;		//한 페이지에 출력되는 레코드수

	$link_count = 10; //한 페이지에 출력되는 페이지 링크수

	if(!$record_start){
		$record_start = 0;
	}

	$current_page = ($record_start / $record_count) + 1;

	$group = floor($record_start / ($record_count * $link_count));

	//쿼리조건
	$query_ment = " where symbolTxt='".$gbl_symbol."'";

	$sort_ment = "order by symbol";

	$query = "select * from api_ETFs_Holdings $query_ment";

	$result = mysql_query($query) or die("연결실패");

	$total_record = mysql_num_rows($result);

	$total_page = (int)($total_record / $record_count);

	if($total_record % $record_count){
		$total_page++;
	}

	$query2 = $query." $sort_ment limit $record_start, $record_count";

	$result = mysql_query($query2);
?>


	<div class="etfGroup">
		<h3 class="sub_tit">연관 ETF</h3>
		<table class="subtable">
			<tbody>
				<tr>
					<th>티커+ETF이름</th>
					<th>운용사이름</th>
					<th>해당종목 비중(%)</th>
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

				while($item = mysql_fetch_array($result)){
					$s = $item['symbol'];

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

					//해당 ETF 티커를 dividend api 에서 검색을 하는데, from 은 오늘 날짜에서 1년전 날짜를 포함한 월의 1일 (예를들어 오늘이 2022 0614 면 2021 0601 부터), to 는 오늘 날짜 로 해서 나오는 adjustedAmount 를 전부 다 더한 다음 stock candles D 의 C값 최신값으로 나눈 것을 % 로 표기
					$siga = 0;
					$sumAmount = sqlRowOne("select sum(adjustedAmount) from api_Dividends where symbol='".$s."' and dateTime>='".$sTime."' and dateTime<='".$eTime."'");
					if($sumAmount){
						$siga = ($sumAmount / $nowC) * 100;
					}

					$udClass01 = UpDownClass($row['pmDataMonth6']);		//상승,하락 색상
			?>
				<tr style='height:70px !important;'>
					<td title='티커+ETF이름' style='text-align:left;padding-left:20px;'>
						<span class="blue bb block"><?=$s?></span>
						<span class="block"><?=$row['name']?></span>
					</td>
					<td title='운용사이름'><?=$row['etfCompany']?></td>
					<td title='해당종목 비중'><?=round($item['percent'],2)?>%</td>
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
				</tr>
			<?
					$i--;
				}

			}else{
			?>
				<tr>
					<td colspan='9' height='100'>연관 ETF 데이터가 없습니다.</td>
				</tr>
			<?
			}
			?>
			</tbody>
		</table>

		<!--로그인하면 
		<div class="blur_box">
			<a href="" title="로그인하세요">
				<div class="plue_btn">
					<span>+</span>
				</div>
				<p>회원가입 하시고 더 많은 ETF를 체크해 보세요</p>
			</a>
		</div>
		display:none 처리-->

	</div>

<?
if($total_record){
	include 'relationEtf_pageNum.php';
}
?>