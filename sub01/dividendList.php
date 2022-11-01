<?
//제이쿼리 로드함수를 이용해 페이지가 로딩된 경우
if($_GET['jQueryLoad']){
	include "../module/class/class.DbCon.php";
	include "../module/class/class.Util.php";
	include '../module/lib.php';

	//실시간 환율정보
	$exArr = Util::ExchangeRate();
	$exRate = str_replace(',','',$exArr[1]);
?>
<script>
$(document).ready(function(){
	$("#loading").delay("200").fadeOut();
});
</script>
<?
}

if(!$diviDate)	$diviDate = date('Y-m-d');
$diviTime = strtotime($diviDate);

$joinQuery = " left join ks_symbol as s on c.symbol=s.symbol";
$joinQuery .= " left join api_Company_Profile as p on c.symbol=p.symbol";
$joinQuery .= " left join Stock_Candles_Last as l on c.symbol=l.symbol";
$item = sqlArray("select c.*, p.name, l.c as nowC from api_Dividends as c ".$joinQuery." where c.date='".$diviDate."' and s.snp500=1 order by c.symbol");

$cutLine = 5;	//최초 보여지는 리스트 수
?>


			<div class="ora_line"></div>
			<div class="sec_table stock_table">
				<h4 class="sub_tit_det" style="margin-top: 20px;">Showing companies with ex-dividend date as <?=date('Md, Y',$diviTime)?></h4>
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
						foreach($item as $i => $v){
							$s = $v['symbol'];
							$nowC = $v['nowC'];		//최신 c값

							//배당수익률
							$cdyTTM = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$s."'");

							//시가총액
							$siga = sqlRowOne("select marketCapitalization from api_Company_Profile where symbol='".$s."'");
							$mCap = round(($siga / 100),2);
							$mCapWon = number_format((float)$mCap * $exRate, 3, '.', '');	//원화적용 & 소수점 3자리로 표시

							$mCapHan = Util::num_to_han_s($mCapWon,5);			//한글변환

							//6개월 주가수익률
							$month6 = sqlRowOne("select pmDataMonth6 from Stock_Candles_Last where symbol='".$s."'");

							$udClass01 = UpDownClass($month6);		//상승,하락 색상

							//시가배당율(5년평균)
							$dividendYield5Y = sqlRowOne("select dividendYield5Y from api_Basic_Financials where symbol='".$s."'");

							if($i > ($cutLine-1))		$lineClass = 'cutLine';
							else							$lineClass = '';

					?>
						<tr class='<?=$lineClass?>'>
							<td title="티커+회사이름" style='text-align:left !important;'>
								<a href="/sub06/sub01.php?gbl_symbol=<?=$s?>">
									<span class="blue bb block"><?=$s?></span>
									<span class="block"><?=$v['name']?></span>
								</a>
							</td>
							<td title="배당락일"><?=$v['date']?></td>
							<td title="배당기준일"><?=$v['recordDate']?></td>
							<td title="배당지급일"><?=$v['payDate']?></td>
							<td title="배당금"><?=$v['adjustedAmount']?>달러</td>
							<td title="배당수익률"><?=round($cdyTTM,2)?>%</td>
							<td title="시가총액"><?=number_format($mCap,2)?>억 달러<br>(<?=$mCapHan?>원)</td>
							<td title="6개월 주가수익률" class='<?=$udClass01?>'><?=$month6?>%</td>
							<td title="시가배당율(5년평균)"><?=number_format($dividendYield5Y,2)?>%</td>
							<td title='애널리스트 컨센서스'>
							<?
								//애널리스트 데이터
								$item = recomData($s);
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
						}
					?>
<!--
						<tr>
							<td>
								<span class="blue bb block">AAPL</span>
								<span class="block">Advanced Info Service PCL</span>
							</td>
							<td>
								<span class="bpurple bold" style="margin:0;">$193.32</span>
								<span class="bpurple det_s bold" style="margin:0;">(17.65% downside)</span>
							</td>
							<td><span>Apr 29, 2022</span></td>
							<td>
								<span>-</span>
							</td>
							<td>
								<div class="dp_f dp_c dp_cc">
										<?
											include 'analyst_pie.php';
										?>
									<span class="bgray bold">Hold</span>
								</div>
								<p style="font-size: 14px;">
									<span class="totNumTxt" style="font-weight:700;">52</span>명의 애널리스트의 평가입니다.
								</p>
							</td>
							<td>
								<span>2.52%</span>
							</td>
							<td>
								<span>-</span>
							</td>
						</tr>

						<tr>
							<td>
								<span class="blue bb block">AAPL</span>
								<span class="block bold">Advanced Info Service PCL</span>
							</td>
							<td>
								<span class="bgreen bold" style="margin:0;">$193.32</span>
								<span class="bgreen det_s bold" style="margin:0;">(17.65% upside)</span>
							</td>
							<td><span>Apr 29, 2022</span></td>
							<td>
								<span>-</span>
							</td>
							<td>
								<div class="dp_f dp_c dp_cc">
										<?
											include 'analyst_pie.php';
										?>
									<span class="bgreen">Moderate Buy</span>
								</div>
								<p style="font-size: 14px;">
									<span class="totNumTxt" style="font-weight:700;">52</span>명의 애널리스트의 평가입니다.
								</p>
							</td>
							<td>
								<span>2.52%</span>
							</td>
							<td>
								<span>-</span>
							</td>
						</tr>
-->
					<?
						if($lineClass){
					?>
						<tr class="allBtn">
							<td colspan="10"><a href="javascript:cutOff();">더 보기</a></td>
						</tr>
					<?
						}
					?>
					</tbody>
				</table>
			</div>

<script>
function cutOff(){
	$('.cutLine').show();
	$('.allBtn').hide();
}
</script>