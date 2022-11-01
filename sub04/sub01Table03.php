<?
//제이쿼리 로드함수를 이용해 페이지가 로딩된 경우
if($_GET['jQueryLoad']){
	include "../module/class/class.DbCon.php";
	include "../module/class/class.Util.php";
	include '../module/lib.php';

	//실시간 환율정보
	$exArr = Util::ExchangeRate();
	$exRate = str_replace(',','',$exArr[1]);

	$csTime = strtotime($year.'-'.$month.'-01');
	$ceTime = strtotime($year.'-'.$month.'-'.$maxdate) + 86399;
}

	if(!$record_count)		$record_count = 10;		//한 페이지에 출력되는 레코드수

	$link_count = 10; //한 페이지에 출력되는 페이지 링크수

	if(!$record_start){
		$record_start = 0;
	}

	$current_page = ($record_start / $record_count) + 1;

	$group = floor($record_start / ($record_count * $link_count));

	//쿼리조건
	$query_ment = " where c.exchange!='' and (c.status='priced' or c.status='expected') and c.dateTime>='".$csTime."' and c.dateTime<='".$ceTime."'";

	$sort_ment = "order by c.dateTime, c.symbol";

	$query = "select c.*, p.name from api_IPO_Calendar as c left join ks_symbol as s on c.symbol=s.symbol left join api_Company_Profile as p on c.symbol=p.symbol $query_ment";

	$result = mysql_query($query) or die("연결실패");

	$total_record = mysql_num_rows($result);

	$total_page = (int)($total_record / $record_count);

	if($total_record % $record_count){
		$total_page++;
	}

	$query2 = $query." $sort_ment limit $record_start, $record_count";

	$result = mysql_query($query2);
?>

		<div class="sec_etf_wrap">
			<div class="ora_line"></div>
			<div class="tableWrap sec_table">
				<table class="subtable">
					<tbody>
						<tr>
							<th>상장예정일</th>
							<th>티커</th>
							<th>상장 예상 주식수</th>
							<th>1주당 가격</th>
							<th>상태</th>
							<th>상장 거래소명</th>
							<th>상장 주식 액면 총합</th>
						</tr>
				<?
					if($total_record){
						$i = $total_record - ($current_page - 1) * $record_count;

						while($row = mysql_fetch_array($result)){

							$totalSharesValue = $row['totalSharesValue'];
							$tsvWon = ($totalSharesValue * $exRate) / 10000;	//원화적용
							$tsvHan = Util::num_to_han_s($tsvWon);					//한글변환
				?>
						<tr>
							<td title="상장예정일"><?=$row['date']?></td>
							<td title="티커" style='text-align:left !important;'>
								<span class="blue bb block"><?=$row['symbol']?></span>
								<span class="block"><?=$row['name']?></span>
							</td>
							<td title="상장 예상 주식수"><?=number_format($row['numberOfShares'])?> 주</td>
							<td title="1주당 가격"><?=number_format($row['price'])?> 달러</td>
							<td title="상태">
							<?
								if($row['status'] == 'expected')	echo '상장예정';
								elseif($row['status'] == 'priced')	echo '가격확정';
							?>
							</td>
							<td title="상장 거래소명"><?=$row['exchange']?></td>
							<td title="상장 주식 액면 총합"><?=number_format($row['totalSharesValue'])?> 달러<br>(<?=$tsvHan?>원)</td>
						</tr>
				<?
							$i--;
						}

					}else{
				?>
						<tr>
							<td colspan='7' height='100'>데이터가 없습니다.</td>
						</tr>
				<?
					}
				?>
					</tbody>
				</table>
			</div>
		</div>

<?
if($total_record){
	$act = 'sub01Table03.php';
	include '/home/myss/www/sub04/sub01TablePageNum.php';
}
?>