<style>
/* 	.diary_nav_sub {display: block;} */
.jongmok_no {padding: 150px 0; border-top: 4px solid #eaebee; text-align: center;}
.jongmok_no p {font-size: 20px; font-weight: 500;}
.blueBtn {display: block; margin: 150px auto 0; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
.subtable .tot > th{font-weight:normal;}
</style>

<?
	//등록된 포트폴리오 확인
	$grow = sqlArray("select * from ks_userPortfolio where userid='".$GBL_USERID."' order by sortNum");

	if(!$grow){
?>


<div class="jongmok_no">
	<p>현재 포트폴리오가 없습니다.</p>
	<a class="blueBtn" href="<?=$_SERVER['PHP_SELF']?>?type=write" title="새로 작성하기">새로 작성하기</a>
</div>

<?
	}else{
?>
<script>
function groupDel(uid){
	GblMsgConfirmBox("해당 포트폴리오를 삭제하시겠습니까?","groupDelOk("+uid+")");
}

function groupDelOk(uid){
	$.post('/module/json/userPortfolio.php',{'userid':'<?=$GBL_USERID?>','type':'del','uid':uid}, function(result){
		parData = JSON.parse(result);
		code = parData['code'];

		if(code == '99'){
			$('#groupList_'+uid).remove();

		}else{
			GblMsgBox("Error");
			return;
		}
	});	
}

function groupEdit(uid){
	$("#titleBox").css({"width":"90%","max-width":"700px"});
	$('#titleFrame').html("<iframe name='gEdit' id='gEdit' src='sub04_groupEdit.php?uid="+uid+"' style='width:100%;height:250px;' frameborder='0' scrolling='auto'></iframe>");
	$('.titleBox_open').click();
}

function groupDetail(gid){
	form = document.frm_group;
	form.type.value = '';
	form.gid.value = gid;
	form.target = '';
	form.action = "sub04_groupDetail.php";
	form.submit();
}
</script>

<form name='frm_group' id='frm_group' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type='text' style='display:none;'>
<input type='hidden' name='type' value=''>
<input type='hidden' name='gid' value=''>

<div class="interestList">
	<table class="subtable">
		<colgroup>
			<col style="width:15%;">
			<col style="width:*;">
			<col style="width:6%;">
			<col style="width:9%;">
			<col style="width:9%;">
			<col style="width:9%;">
			<col style="width:8%;">
			<col style="width:8%;">
			<col style="width:8%;">
			<col style="width:8%;">
			<col style="width:8%;">
		</colgroup>
		<tbody>
			<tr>	
				<th>포트폴리오명</th>
				<th>포트폴리오 메모</th>
				<th>종목수</th>
				<th>총 매수금액</th>
				<th>현재 총평가액</th>
				<th>수익금</th>
				<th>수익률</th>
				<th>연간배당률<br>(현재 예상치)</th>
				<th>연간배당금<br>(현재 예상)</th>
				<th>포트폴리오 비중<br>(매수기준)</th>
				<th>포트폴리오 비중<br>(현재기준)</th>
			</tr>
		<?
			//1년전 타임값(연간배당금 확인을 위한)
			$yTime = strtotime(date('Y-m-d',strtotime("-1 years")));

			$cnt = 0;

			//종목비중(매수,현재기준) 계산을 위해 모든 포트폴리오의 총 매수금액과 현재 총평가액 합산을 먼저 해야 한다.
			$p1Sum = 0;					$w1Sum = 0;
			$p2Sum = 0;					$w2Sum = 0;
			foreach($grow as $gv){
				//포트폴리오내 전체 종목수
				$sCnt = sqlRowOne("select count(*) from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gv['uid']);

				//포트폴리오내 보유갯수 및 평단이 입력된 종목만 가져온다.
				$row = sqlArray("select * from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gv['uid']." and sNum>0 and sAmt>0 order by sortNum");

				if($sCnt == count($row)){
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
				}
			}




			$sCntSum = 0;

			$p3Sum = 0;					$w3Sum = 0;

			foreach($grow as $gv){
				//포트폴리오내 전체 종목수
				$sCnt = sqlRowOne("select count(*) from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gv['uid']);
				$sCntSum += $sCnt;	//종목합계
		?>
			<tr id="groupList_<?=$gv['uid']?>">	
				<td>
					<div class="groupTit dp_sb dp_c" >
						<a class="editBtn dp_f dp_c" href="javascript:groupEdit('<?=$gv['uid']?>')" title="수정"><span class="lnr lnr-pencil"></span></a>
						<a class="detailMove" href="javascript:groupDetail(<?=$gv['uid']?>)"><?=$gv['title']?></a>
						<a class="delbtn" href="javascript:groupDel('<?=$gv['uid']?>')" title="제거">-</a>
					</div>
				</td>
				<td><?=$gv['memo']?></td>
				<td><?=$sCnt?></td>
			<?
				//포트폴리오내 보유갯수 및 평단이 입력된 종목만 가져온다.
				$row = sqlArray("select * from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gv['uid']." and sNum>0 and sAmt>0 order by sortNum");

				if($sCnt > 0 && $sCnt == count($row)){
					$cnt++;

					$p1Tot = 0;					$w1Tot = 0;
					$p2Tot = 0;					$w2Tot = 0;
					$p3Tot = 0;					$w3Tot = 0;
					$p6Tot = 0;

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

						//수익금(달러)
						$p3 = $p2 - $p1;
						$p3 = round($p3,2);

						//수익금(한화) ((현재 총평가액 * 현재환율) - (총매수금액 * 매수환율))
						$w3 = ($p2 * $exRate) - ($p1 * $sExc);
						$w3 = round($w3,2);

						//연간배당률
						$p5 = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$v['symbol']."'");
						$p5 = round($p5,2);

						//연간배당금
						$p6 = sqlRowOne("select sum(amount) from api_Dividends where symbol='".$v['symbol']."' and dateTime>='".$yTime."'");
						$p6 = round($p6,2);

						//합계 계산
						$p1Tot += $p1;
						$w1Tot += $w1;
						$p2Tot += $p2;
						$w2Tot += $w2;
						$p3Tot += $p3;
						$w3Tot += $w3;
						$p6Tot += $p6;
					}

					//수익률
					$p4Tot = (($p2Tot / $p1Tot) - 1) * 100;
					$p4Tot = round($p4Tot,2);
					$w4Tot = (($w2Tot / $w1Tot) - 1) * 100;
					$w4Tot = round($w4Tot,2);

					//연간배당률
					$p5Tot = round((($p6Tot / $p2Tot) * 100),2);

					//종목비중(매수기준)
					$p7Tot = Util::fnPercent2($p1Sum,$p1Tot);
					$w7Tot = Util::fnPercent2($w1Sum,$w1Tot);

					//종목비중(현재기준)
					$p8Tot = Util::fnPercent2($p2Sum,$p2Tot);
//					$w8Tot = Util::fnPercent2($w2Sum,$w2Tot);	//현재 기준이기 때문에 한화로 계산해도 p8값과 동일함


					//합계 계산
					$p3Sum += $p3Tot;
					$w3Sum += $w3Tot;
					$p6Sum += $p6Tot;
			?>
				<td title="총 매수금액">$<?=Util::NumberSet2($p1Tot)?><br>(<?=number_format($w1Tot)?>원)</td>
				<td title="현재 총평가액">$<?=Util::NumberSet2($p2Tot)?><br>(<?=number_format($w2Tot)?>원)</td>
				<td title="수익금">$<?=Util::NumberSet2($p3Tot)?><br>(<?=number_format($w3Tot)?>원)</td>
				<td title="수익률"><?=$p4Tot?>%<br>(<?=$w4Tot?>%)</td>
				<td title="연간배당률"><?=$p5Tot?>%</td>
				<td title="연간배당금">$<?=$p6Tot?></td>
				<td title="포트폴리오 비중(매수기준)"><?=$p7Tot?>%<br>(<?=$w7Tot?>%)</td>
				<td title="포트폴리오 비중(현재기준)"><?=$p8Tot?>%</td>
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
				//수익률
				$p4Sum = (($p2Sum / $p1Sum) - 1) * 100;
				$p4Sum = round($p4Sum,2);
				$w4Sum = (($w2Sum / $w1Sum) - 1) * 100;
				$w4Sum = round($w4Sum,2);

				//연간배당률
				$p5Sum = round((($p6Sum / $p2Sum) * 100),2);
		?>
			<tr class='tot'>	
				<th colspan='2'></th>
				<th title="종목수"><?=$sCntSum?></th>
				<th title="총 매수금액">$<?=Util::NumberSet2($p1Sum)?><br>(<?=number_format($w1Sum)?>원)</th>
				<th title="현재 총평가액">$<?=Util::NumberSet2($p2Sum)?><br>(<?=number_format($w2Sum)?>원)</th>
				<th title="수익금">$<?=Util::NumberSet2($p3Sum)?><br>(<?=number_format($w3Sum)?>원)</th>
				<th title="수익률"><?=$p4Sum?>%<br>(<?=$w4Sum?>%)</th>
				<th title="연간배당률"><?=$p5Sum?>%</th>
				<th title="연간배당금">$<?=$p6Sum?></th>
				<th title="포트폴리오 비중(매수기준)">100%</th>
				<th title="포트폴리오 비중(현재기준)">100%</th>
			</tr>
		<?
			}
		?>
		</tbody>
	</table>

	<a class="blueBtn" href="<?=$_SERVER['PHP_SELF']?>?type=write" title="포트폴리오 추가" style="margin: 70px auto 0;">포트폴리오 추가</a>
</div>

</form>

<?
	}
?>
	<!---그룹명 눌렀을 때 각각 나타나는 종목 상세 테이블
	<div class="jongmokList">
		<table class="subtable">
				<tr>
					<th>그룹명</th>
					<th>그룹 메모</th>
					<th>종목수</th>
				</tr>
				<tr>
					<td>10년 존버</td>
					<td>10배 가즈아 떨어질때만 분할매수하기 노매도</td>
					<td>2</td>
				</tr>
				<tr>
					<td colspan="3">
						<table class="subtable jong">
								<colgroup>
									<col style="width: 207px;">
								</colgroup>
								<tr>
									<th>종목명</th>
									<th>종목 메모</th>
									<th>
										<div class="optTit ">
											종목 비중(옵션)
										</div>
										<a class="sameR" href="" title="균등비중적용">균등비중적용</a>
									</th>
								</tr>
								<tr>
									<td>애플</td>
									<td>갓플!</td>
									<td>
										40%
									</td>
								</tr>
								<tr>
									<td>앤비디아</td>
									<td>코인은 갔지만 메타버스가 오겠지?</td>
									<td>
										60%
									</td>
								</tr>
						</table>
					</td>
				</tr>
		</table>
	</div>
--->

