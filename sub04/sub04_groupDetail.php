<?
	include '../header.php';
?>
<style>
.blueBtn {display: block; margin: 150px auto 0; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
.blueBtn2 {display: inline-block; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
.subtable .tot > th{font-weight:normal;}
.sub_tit3{font-size:24px;margin:50px 0 10px 0;font-weight:800;}
</style>

<script>
function groupType(t){
	form = document.frm_group;
	form.type.value = t;
	form.target = '';
	form.action = "<?=$_SERVER['PHP_SELF']?>";
	form.submit();
}

function groupDetail(){
	form = document.frm_group;
	form.type.value = 'detail';
	form.target = '';
	form.action = "/sub04/sub04.php";
	form.submit();
}

function newsList(s){
	$("#newsListBox").css({"width":"90%","max-width":"700px"});
	$('#newsList_ttl').text(s);
	$('#newsListFrame').html("<iframe name='newsList' id='newsList' src='../CompanyNewsList.php?newsSymbol="+s+"' style='width:100%;height:600px;' frameborder='0' scrolling='auto'></iframe>");
	$('.newsListBox_open').click();
}
</script>

<div id="sub_cont">
	<div class="sub_center">
		<?
			include 'investquote.php';

			if(!$type)	$type = 'default';
		?>

		<form name='frm_group' id='frm_group' method='post' action="<?=$_SERVER['PHP_SELF']?>">
		<input type='text' style='display:none;'>
		<input type='hidden' name='type' value='<?=$type?>'>

		<div class="interestList">
			<table class="subtable">
				<colgroup>
					<col style="width:17%;">
					<col style="width:*;">
					<col style="width:14%;">
					<col style="width:14%;">
				</colgroup>
				<tbody>
					<tr>	
						<th>포트폴리오명</th>
						<th>포트폴리오 메모</th>
						<th>종목수</th>
						<th>현재환율</th>
					</tr>
					<tr>	
						<td>
						<?
							//등록된 관심종목
							$grow = sqlArray("select * from ks_userPortfolio where userid='".$GBL_USERID."' order by sortNum");
						?>
							<select name='gid' onchange="document.frm_group.submit();">
							<?
								foreach($grow as $v){
									if($v['uid'] == $gid)	$chk = 'selected';
									else						$chk = '';
							?>
								<option value="<?=$v['uid']?>" <?=$chk?>><?=$v['title']?></option>
							<?
								}
							?>
							</select>
						</td>
						<?
							//포트폴리오정보
							$grow = sqlRow("select * from ks_userPortfolio where userid='".$GBL_USERID."' and uid=".$gid);

							//종목수
							$sCnt = sqlRowOne("select count(*) from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gid);
						?>
						<td><?=$grow['memo']?></td>
						<td><?=$sCnt?></td>
						<td><?=$exRate?></td>
					</tr>
				</tbody>
			</table>

			<h3 class="sub_tit3"><?=$grow['title']?> 포트폴리오 편입 종목 (업데이트 날짜 : <?=date('Y.m.d',$grow['mTime'])?>)</h3>

			<table class="subtable">
				<colgroup>
					<col style="width:8%;">
					<col style="width:*;">
					<col style="width:7%;">
					<col style="width:7%;">
					<col style="width:7%;">
					<col style="width:9%;">
					<col style="width:9%;">
					<col style="width:9%;">
					<col style="width:7%;">
					<col style="width:7%;">
					<col style="width:7%;">
					<col style="width:7%;">
					<col style="width:7%;">
				</colgroup>
				<tbody>
					<tr>	
						<th>종목명</th>
						<th>종목 메모</th>
						<th>보유 갯수</th>
						<th>보유 평단<br>(달러기준)</th>
						<th>매수환율</th>
						<th>총 매수금액</th>
						<th>현재 총평가액</th>
						<th>수익금</th>
						<th>수익률</th>
						<th>연간배당률<br>(현재 예상치)</th>
						<th>연간배당금<br>(현재 예상)</th>
						<th>종목 비중<br>(매수기준)</th>
						<th>종목 비중<br>(현재기준)</th>
					</tr>
				<?
					//종목비중(매수,현재기준) 계산을 위해 총 매수금액과 현재 총평가액 합산을 먼저 해야 한다.
					$p1Sum = 0;					$w1Sum = 0;
					$p2Sum = 0;					$w2Sum = 0;
					$row = sqlArray("select * from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gid." and sNum>0 and sAmt>0 order by sortNum");
					foreach($row as $v){
						$sNum = $v['sNum'];
						$sAmt = $v['sAmt'];
						$sExc = $v['sExc'];

						//총 매수금액
						$p1 = $sNum * $sAmt;
						$w1 = $p1 * $sExc;		//매수환율로 계산

						$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$v['symbol']."'");	//최근 주가

						//현재 총평가액
						$p2 = $sNum * $nowC;
						$w2 = $p2 * $exRate;	//현재환율로 계산

						$p1Sum += $p1;
						$w1Sum += $w1;
						$p2Sum += $p2;
						$w2Sum += $w2;
					}




					//평가액비중 그래프 데이터
					$gArr0101 = Array();		//매수기준
					$gArr0102 = Array();		//현재기준

					//섹터비중 그래프 데이터
					$gArr0201 = Array();		//매수기준
					$gArr0202 = Array();		//현재기준

					//예상 배당추이 그래프 데이터
					$gArr03 = Array();
					$gArr03Tmp = Array();

					//배당금 분포 그래프 데이터
					$gArr04 = Array();

					//작년도 배당금 확인을 위한 타임값
					$ys = date('Y')-1;
					$ysTime = strtotime($ys.'-01-01');
					$yeTime = strtotime($ys.'-12-31');


					//1년전 타임값(연간배당금 확인을 위한)
					$yTime = strtotime(date('Y-m-d',strtotime("-1 years")));

					$cnt = 0;

					$sNumTot = 0;
					$sAmtTot = 0;
					$p1Tot = 0;					$w1Tot = 0;
					$p2Tot = 0;					$w2Tot = 0;
					$p3Tot = 0;					$w3Tot = 0;
					$p6Tot = 0;

					//종목정보
					$row = sqlArray("select * from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gid." order by sortNum");
					foreach($row as $v){
						$sNum = $v['sNum'];
						$sAmt = $v['sAmt'];
						$sExc = $v['sExc'];
						$sEtf = $v['etf'];
				?>
					<tr>	
						<td title="종목명"><?=$v['symbol']?></td>
						<td title="종목 메모"><?=$v['memo']?></td>
						<td title="보유 갯수"><?=number_format($sNum)?></td>
						<td title="보유 평단(달러기준)">$<?=Util::NumberSet2($sAmt)?></td>
						<td title="매수환율"><?=Util::NumberSet2($sExc)?>원</td>
					<?
						if($sNum && $sAmt){
							$cnt++;

							//총 매수금액
							$p1 = $sNum * $sAmt;
							$w1 = $p1 * $sExc;		//매수환율로 계산

							$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$v['symbol']."'");	//최근 주가

							//현재 총평가액
							$p2 = $sNum * $nowC;
							$w2 = $p2 * $exRate;	//현재환율로 계산

							//수익금(달러)
							$p3 = $p2 - $p1;
							$p3 = round($p3,2);

							//수익금(한화) ((현재 총평가액 * 현재환율) - (총매수금액 * 매수환율))
							$w3 = ($p2 * $exRate) - ($p1 * $sExc);
							$w3 = round($w3,2);

							//수익률
							$p4 = (($p2 / $p1) - 1) * 100;
							$p4 = round($p4,2);
							$w4 = (($w2 / $w1) - 1) * 100;
							$w4 = round($w4,2);

							//연간배당률
							$p5 = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$v['symbol']."'");
							$p5 = round($p5,2);

							//연간배당금(최근 1년 배당금합 * 보유갯수)
							$p6 = sqlRowOne("select sum(amount) from api_Dividends where symbol='".$v['symbol']."' and dateTime>='".$yTime."'");
							$p6 = round(($p6*$sNum),2);

							//종목비중(매수기준)
							$p7 = Util::fnPercent2($p1Sum,$p1);
							$w7 = Util::fnPercent2($w1Sum,$w1);

							//종목비중(현재기준)
							$p8 = Util::fnPercent2($p2Sum,$p2);
//							$w8 = Util::fnPercent2($w2Sum,$w2);	//현재 기준이기 때문에 한화로 계산해도 p8값과 동일함


							//합계 계산
							$sNumTot += $sNum;
							$sAmtTot += $sAmt;
							$p1Tot += $p1;
							$w1Tot += $w1;
							$p2Tot += $p2;
							$w2Tot += $w2;
							$p3Tot += $p3;
							$w3Tot += $w3;
							$p6Tot += $p6;


							//평가액비중 그래프 데이터
							$gArr0101[$v['symbol']] = $p7;
							$gArr0102[$v['symbol']] = $p8;

							//섹터비중 그래프 데이터
							if($sEtf == 'N')		$gsector = sqlRowOne("select gsector from api_Company_Profile where symbol='".$v['symbol']."'");
							else					$gsector = 'ETF';

							$gArr0201[$gsector] += $p7;
							$gArr0202[$gsector] += $p8;

							//예상 배당추이 그래프 데이터 계산용
							$gArr03Tmp[$v['symbol']] = $p6;

							//배당금 분포 그래프 데이터
							$drow = sqlArray("select * from api_Dividends where symbol='".$v['symbol']."' and payTime>='".$ysTime."' and payTime<='".$yeTime."'");
							foreach($drow as $d){
								$m = date('n',$d['payTime']);
								$gArr04[$m] += ($sNum * $d['amount']);
							}

					?>
						<td title="총 매수금액">$<?=Util::NumberSet2($p1)?><br>(<?=number_format($w1)?>원)</td>
						<td title="현재 총평가액">$<?=Util::NumberSet2($p2)?><br>(<?=number_format($w2)?>원)</td>
						<td title="수익금">$<?=Util::NumberSet2($p3)?><br>(<?=number_format($w3)?>원)</td>
						<td title="수익률"><?=$p4?>%<br>(<?=$w4?>%)</td>
						<td title="연간배당률"><?=$p5?>%</td>
						<td title="연간배당금">$<?=$p6?></td>
						<td title="종목 비중(매수기준)"><?=$p7?>%<br>(<?=$w7?>%)</td>
						<td title="종목 비중(현재기준)"><?=$p8?>%</td>
					<?
						}else{
					?>
						<td colspan='8' style='color:#d1d1d1;'>보유 갯수 및 평단을 입력해 주세요.</td>
					<?
						}
					?>
					</tr>
				<?
					}

					if($cnt > 0){
						//보유 평단
						$sAmtTot = $sAmtTot / $cnt;

						//수익률
						$p4Tot = (($p2Tot / $p1Tot) - 1) * 100;
						$p4Tot = round($p4Tot,2);
						$w4Tot = (($w2Tot / $w1Tot) - 1) * 100;
						$w4Tot = round($w4Tot,2);

						//연간배당률
						$p5Tot = round((($p6Tot / $p2Tot) * 100),2);
				?>
					<tr class='tot'>	
						<th colspan='2'></th>
						<th title="보유 갯수"><?=$sNumTot?></th>
						<th title="보유 평단">$<?=Util::NumberSet2($sAmtTot)?></th>
						<th></th>
						<th title="총 매수금액">$<?=Util::NumberSet2($p1Tot)?><br>(<?=number_format($w1Tot)?>원)</th>
						<th title="현재 총평가액">$<?=Util::NumberSet2($p2Tot)?><br>(<?=number_format($w2Tot)?>원)</th>
						<th title="수익금">$<?=Util::NumberSet2($p3Tot)?><br>(<?=number_format($w3Tot)?>원)</th>
						<th title="수익률"><?=$p4Tot?>%<br>(<?=$w4Tot?>%)</th>
						<th title="연간배당률"><?=$p5Tot?>%</th>
						<th title="연간배당금">$<?=$p6Tot?></th>
						<th title="종목 비중(매수기준)">100%</th>
						<th title="종목 비중(현재기준)">100%</th>
					</tr>
				<?
					}
				?>
				</tbody>
			</table>
		</div>

		</form>

		<ul class="g_tabBtn dp_f">
			<li><a class="dp_f dp_c dp_cc" href="javascript:groupType('default');">기본 보기</a></li>
			<li><a class="dp_f dp_c dp_cc" href="javascript:groupType('graph');">그래프로 보기</a></li>
			<li><a class="dp_f dp_c dp_cc" href="javascript:groupType('sum');">요약 보기</a></li>
		</ul>

		<div class="g_tabContWrap">
			<div class="g_tabCont">
			<?
				if($type == 'default'){

					//종목정보(주식)
					$srow = sqlArray("select * from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gid." and etf='N' order by sortNum");
					if($srow)		include 'detail_GTABBasic01.php';		//기본보기(주식)

					//종목정보(etf)
					$erow = sqlArray("select * from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gid." and etf='Y' order by sortNum");
					if($erow)		include 'detail_GTABBasic02.php';		//기본보기(etf)

				}elseif($type == 'graph'){
					include 'detail_GTABGraph.php';		//그래프로 보기(주식, etf)


				}elseif($type == 'sum'){
					include 'detail_GTABSum.php';		//요약 보기

				}
			?>
			</div>
		</div>


		<div style='width:305px;margin:0 auto;'>
			<a class="blueBtn2" href="sub04.php" title="포트폴리오 목록" style="margin: 70px auto 0;">포트폴리오 목록</a>
			<a class="blueBtn2" href="javascript:groupDetail();" title="종목 추가/편집" style="margin: 70px auto 0;">종목 추가/편집</a>
		</div>

	</div>
</div>

<?
	include '../footer.php';
?>