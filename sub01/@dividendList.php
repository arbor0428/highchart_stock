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

if(!$diviDate)	$diviDate = date('Y-m-d');
$diviTime = strtotime($diviDate);

$joinQuery = " left join ks_symbol as s on c.symbol=s.symbol";
$joinQuery .= " left join api_Company_Profile as p on c.symbol=p.symbol";
$joinQuery .= " left join Stock_Candles_Last as l on c.symbol=l.symbol";
$item = sqlArray("select c.*, p.name, l.c as nowC from api_Dividends as c ".$joinQuery." where c.date='".$diviDate."' and s.snp500=1");

$cutLine = 5;	//최초 보여지는 리스트 수
?>


			<div class="ora_line"></div>
			<div class="sec_table stock_table">
				<h4 class="sub_tit_det" style="margin-top: 20px;">Showing companies with ex-dividend date as <?=date('Md, Y',$diviTime)?></h4>
				<table class="subtable">
					<tbody>
						<tr>
							<th>티커+회사이름</th>
							<th>배당락</th>
							<th>배당지급일</th>
							<th>배당금액+배당율</th>
							<th>애널리스트<br>컨센서스</th>
							<th>애널리스트<br>목표가격업사이드</th>
							<th>적정주가 성장성+수익성</th>
						</tr>
					<?
						foreach($item as $k => $v){
							$s = $v['symbol'];
							$nowC = $v['nowC'];		//최신 c값

							if($k > ($cutLine-1))		$lineClass = 'cutLine';
							else							$lineClass = '';

					?>
						<tr class='<?=$lineClass?>'>
							<td title="티커+회사이름">
								<span class="blue bb block"><?=$s?></span>
								<span class="block"><?=$v['name']?></span>
							</td>
							<td title="배당락">
								<span><?=$v['date']?></span>
							<!--
								<span class="bgreen bold" style="margin:0;">$193.32</span>
								<span class="bgreen det_s bold" style="margin:0;">(17.65% upside)</span>
							-->
							</td>
							<td title="배당지급일"><span><?=$v['payDate']?></span></td>
							<td title="배당금액+배당율">
								<span>$<?=$v['adjustedAmount']?></span>
							</td>
							<td title="애널리스트컨센서스">
							<?
								//애널리스트 데이터
								$row = recomData($s);
								if($row['totScore']){
							?>
								<div class="dp_f dp_c dp_cc">
									<?
										//그래프 데이터
										$pieColor = $row['pieColor'];
										$pieData = $row['pieData'];
										include 'analyst_pie.php';
									?>
									<span class="<?=$row['investmentEng']?>"><?=$row['investmentEng']?></span>
								</div>
								<p style="font-size: 14px;">
									<span class="totNumTxt" style="font-weight:700;"><?=number_format($row['totNum'])?></span>명의 애널리스트의 평가입니다.
								</p>
							<?
								}
							?>
							</td>
							<td title="애널리스트목표가격업사이드">
							<?
								$targetMean = sqlRowOne("select targetMean from api_Price_Target where symbol='".$s."' order by uid desc limit 1");
							?>
								<span class="bgreen block bold">$<?=$targetMean?></span>
								<span class="bgreen det_s bold">(<?=Util::fnPercent($nowC,$targetMean)?>%)</span>
							</td>
							<td title="적정주가 성장성+수익성">
								<span>-</span>
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
							<td colspan="7"><a href="javascript:cutOff();">더 보기</a></td>
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