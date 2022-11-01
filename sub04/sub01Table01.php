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

	$query = "select c.*, p.name from api_Earnings_Calendar as c left join ks_symbol as s on c.symbol=s.symbol left join api_Company_Profile as p on c.symbol=p.symbol $query_ment";

	$result = mysql_query($query) or die("연결실패");

	$total_record = mysql_num_rows($result);

	$total_page = (int)($total_record / $record_count);

	if($total_record % $record_count){
		$total_page++;
	}

	$query2 = $query." $sort_ment limit $record_start, $record_count";

	$result = mysql_query($query2);





	//마감기준(분기) - 실적발표일 전분기
	$y = date('Y',$csTime);
	$m = date('n',$csTime);

	if($m <= 3)			$eqt = ($y-1).'/'.$m;
	elseif($m <= 6)	$eqt = $y.'/3';
	elseif($m <= 9)	$eqt = $y.'/6';
	elseif($m <= 12)	$eqt = $y.'/9';
?>

		<div class="sec_etf_wrap">
			<div class="ora_line"></div>
			<div class="tableWrap sec_table">
				<table class="subtable">
					<tbody>
						<tr>
							<th>실적발표예정일</th>
							<th>티커+회사이름</th>
							<th>마감 기준 (분기)</th>
							<th>YoY EPS</th>
							<th>EPS 예상 (전년 동기대비 증감율)</th>
							<th>EPS 실제 (컨센서스 대비 증감율)</th>
							<th>YoY 매출</th>
							<th>매출 예상 (전년 동기대비 증감율)</th>
							<th>매출 실제 (컨센서스 대비 증감율)</th>
							<th>실적발표예상시각</th>
							<th>애널리스트 컨센서스</th>
						</tr>
				<?
					if($total_record){
						$i = $total_record - ($current_page - 1) * $record_count;

						while($row = mysql_fetch_array($result)){

							//YoY EPS(epsActual 5번째 값(1 번째 epsActual 값은 발표전이면 공란임. 이것도 포함해서 5 번째)
							$eps = sqlRow("select * from api_Earnings_Calendar where symbol='".$row['symbol']."' and dateTime<=".$row['dateTime']." order by dateTime desc limit 4,1");
							$yoyEps = $eps['epsActual'];

							//전년동기대비
							$qArr = sqlRow("select * from api_Earnings_Calendar where symbol='".$row['symbol']."' and dateTime<".$row['dateTime']." and quarter=".$row['quarter']." order by dateTime desc limit 1");

							//EPS 예상(epsEstimate (전년동기대비 증감율))
							$epsEstimate = round($row['epsEstimate'],2);
							$epsEstimateGap = '';
							if($epsEstimate){
								$epsEstimateBefore = $qArr['epsEstimate'];
								$epsEstimateGap = Util::fnPercent(round($epsEstimateBefore,2),$epsEstimate);
								$udClass01 = UpDownClass($epsEstimateGap);		//상승,하락 색상
								$epsEstimateGap = "<br><span class='".$udClass01."'>(".$epsEstimateGap."%)</span>";
							}

							//EPS 실제 epsActual(EPS 실제 (컨센서스 대비 증감율))-> api상 값 + (epsActual/epsEstimate -1 로 % 표기)
							$epsActual = round($row['epsActual'],2);
							$epsActualPer = '';
							if($epsActual){
								$epsActualPer = round((($epsActual / $epsEstimate) - 1) * 100,2);
								$udClass02 = UpDownClass($epsActualPer);		//상승,하락 색상
								$epsActualPer = "<br><span class='".$udClass02."'>(".$epsActualPer."%)</span>";
							}

							//YoY 매출
							$yoyRevenue = $eps['revenueActual'];
							$yoyRevenueHan = '';
							if($yoyRevenue){
								$yoyRevenue = round(($yoyRevenue / 100000000),2).'억 달러';
								$yoyRevenueWon = number_format((float)$yoyRevenue * $exRate, 3, '.', '');	//원화적용 & 소수점 3자리로 표시
								$yoyRevenueHan = "<br>(".Util::num_to_han_s($yoyRevenueWon,5).")";			//한글변환
							}

							//매출 예상
							$revenueEstimate = round($row['revenueEstimate'],2);
							$revenueEstimateCut = round(($revenueEstimate / 100000000),2);
							$revenueEstimateWon = number_format((float)$revenueEstimateCut * $exRate, 3, '.', '');	//원화적용 & 소수점 3자리로 표시
							$revenueEstimateHan = Util::num_to_han_s($revenueEstimateWon,5);							//한글변환
							$revenueEstimateGap = '';
							if($revenueEstimate){
								$revenueEstimateBefore = $qArr['revenueEstimate'];
								$revenueEstimateGap = ", ".Util::fnPercent(round($revenueEstimateBefore,2),$revenueEstimate)."%";
							}

							//매출 실제
							$revenueActual = round($row['revenueActual'],2);
							$revenueActualCut = round(($revenueActual / 100000000),2);
							$revenueActualWon = number_format((float)$revenueActualCut * $exRate, 3, '.', '');		//원화적용 & 소수점 3자리로 표시
							$revenueActualHan = Util::num_to_han_s($revenueActualWon,5);								//한글변환
							$revenueActualPer = ", ".round((($revenueActual / $revenueEstimate) - 1) * 100,2)."%";							
				?>					
						<tr>
							<td title='실적발표예정일'><?=$row['date']?></td>
							<td title='티커+회사이름'><?=$row['name']?><br><?=$row['symbol']?></td>
							<td title='마감 기준 (분기)'><?=$eqt?></td>
							<td title='YoY EPS'><?=$yoyEps?></td>
							<td title='EPS 예상'><?=$epsEstimate?><?=$epsEstimateGap?></td>
							<td title='EPS 실제'><?=$epsActual?><?=$epsActualPer?></td>
							<td title='YoY 매출'><?=$yoyRevenue?><?=$yoyRevenueHan?></td>
							<td title='매출 예상'><?=$revenueEstimateCut?>억 달러<br>(<?=$revenueEstimateHan?>원<?=$revenueEstimateGap?>)</td>
							<td title='매출 실제'><?=$revenueActualCut?>억 달러<br>(<?=$revenueActualHan?>원<?=$revenueActualPer?>)</td>
							<td title='실적발표예상시각'>
							<?
								if($row['hour'] == 'amc')		echo "장마감후";
								elseif($row['hour'] == 'bmo')	echo "장시작전";
								elseif($row['hour'] == 'dmh')	echo "장중";
								else									echo "";
							?>
							</td>
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
							<td colspan='11' height='100'>데이터가 없습니다.</td>
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
	$act = 'sub01Table01.php';
	include '/home/myss/www/sub04/sub01TablePageNum.php';
}
?>