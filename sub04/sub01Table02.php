<?
//제이쿼리 로드함수를 이용해 페이지가 로딩된 경우
if($_GET['jQueryLoad']){
	include "../module/class/class.DbCon.php";
	include "../module/class/class.Util.php";
	include '../module/lib.php';

	//실시간 환율정보
	$exArr = Util::ExchangeRate();
	$exRate = str_replace(',','',$exArr[1]);

	if(!$cDate)	$cDate = date('Y-m-d');
	$csTime = strtotime($cDate);
	$ceTime = $csTime + 86399;
}


	if(!$record_count)		$record_count = 10;		//한 페이지에 출력되는 레코드수

	$link_count = 10; //한 페이지에 출력되는 페이지 링크수

	if(!$record_start){
		$record_start = 0;
	}

	$current_page = ($record_start / $record_count) + 1;

	$group = floor($record_start / ($record_count * $link_count));

	//쿼리조건
	$query_ment = " where c.dateTime>='".$csTime."' and c.dateTime<='".$ceTime."' and s.snp500=1";

	$sort_ment = "order by c.symbol";

	$query = "select c.*, p.name from api_Dividends as c left join ks_symbol as s on c.symbol=s.symbol left join api_Company_Profile as p on c.symbol=p.symbol $query_ment";

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
								<th>티커+<br>회사이름</th>
								<th>배당락일</th>
								<th>배당기준일</th>
								<th>배당지급일</th>
								<th>배당금</th>
								<th>배당수익률</th>
								<th>시가총액</th>
								<th>6개월<br>주가수익률</th>
								<th>시가배당율<br>(5년평균)</th>
								<th>애널리스트 컨센서스</th>
							</tr>
				<?
					if($total_record){
						$i = $total_record - ($current_page - 1) * $record_count;

						while($row = mysql_fetch_array($result)){
							//배당수익률
							$cdyTTM = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$row['symbol']."'");

							//시가총액
							$siga = sqlRowOne("select marketCapitalization from api_Company_Profile where symbol='".$row['symbol']."'");
							$mCap = round(($siga / 100),2);
							$mCapWon = number_format((float)$mCap * $exRate, 3, '.', '');	//원화적용 & 소수점 3자리로 표시
							$mCapHan = Util::num_to_han_s($mCapWon,5);			//한글변환

							//6개월 주가수익률
							$month6 = sqlRowOne("select pmDataMonth6 from Stock_Candles_Last where symbol='".$row['symbol']."'");

							$udClass01 = UpDownClass($month6);		//상승,하락 색상

							//시가배당율(5년평균)
							$dividendYield5Y = sqlRowOne("select dividendYield5Y from api_Basic_Financials where symbol='".$row['symbol']."'");
				?>
							<tr>
								<td title="티커+회사이름" style='text-align:left !important;'>
									<span class="blue bb block"><?=$row['symbol']?></span>
									<span class="block"><?=$row['name']?></span>
								</td>
								<td title="배당락일"><?=$row['date']?></td>
								<td title="배당기준일"><?=$row['recordDate']?></td>
								<td title="배당지급일"><?=$row['payDate']?></td>
								<td title="배당금"><?=$row['adjustedAmount']?>달러</td>
								<td title="배당수익률"><?=round($cdyTTM,2)?>%</td>
								<td title="시가총액"><?=number_format($mCap,2)?>억 달러<br>(<?=$mCapHan?>원)</td>
								<td title="6개월 주가수익률" class='<?=$udClass01?>'><?=$month6?>%</td>
								<td title="시가배당율(5년평균)"><?=number_format($dividendYield5Y,2)?>%</td>
								<td title='애널리스트 컨센서스'>
								<?
									//애널리스트 데이터
									$item = recomData($row['symbol']);
									if($item['totScore']){
								?>
									<div class="dp_f dp_c dp_cc">
										<?
											//그래프 데이터
											$pieColor = $item['pieColor'];
											$pieData = $item['pieData'];
											$k = $i;
											include '/home/myss/www/sub01/analyst_pie.php';
										?>
										<span class="<?=$item['investmentEng']?>"><?=$item['investmentEng']?></span>
									</div>
									<p style="font-size: 14px;">
										<span class="totNumTxt" style="font-weight:700;"><?=number_format($item['totNum'])?></span>명의 애널리스트의 평가입니다.
									</p>
								<?
									}
								?>
								</td>
							</tr>
				<?
							$i--;
						}

					}else{
				?>
						<tr>
							<td colspan='10' height='100'>데이터가 없습니다.</td>
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
	$act = 'sub01Table02.php';
	include '/home/myss/www/sub04/sub01TablePageNum.php';
}
?>
