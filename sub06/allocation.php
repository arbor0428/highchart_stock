<?
	$row = sqlArray("select * from api_Dividends where symbol='".$gbl_symbol."' and declarationTime>0 order by declarationTime desc");
?>

<style>
.subtable .n td{border-left:0;border-right:0;}
</style>

<div class="ticker_section">
<?
	if(!$row){
?>
	<div class="nothShow">
		<p>해당종목은 최근<br>배당을 진행한 이력이 없습니다.</p>
	</div>
<?
	}else{
?>
	<div class="allocWrap">
		<h3 class="sub_tit">배당이력···확인하고 가세요.</h3>
		<div class="allocTable">
			<table class="subtable">
				<tbody>
					<tr>
						<th>연도</th>
						<th>배당발표일</th>
						<th>배당락일</th>
						<th>주주명부확정일</th>
						<th>배당지급일</th>
						<th>배당빈도</th>
						<th>배당금액</th>
						<th>주식분할조정배당금</th>
					</tr>
				<?
					$pYear = '';
					$limit = count($row) - 4;

					foreach($row as $k => $v){
						$nYear = date('Y',$v['recordTime']);
						if($pYear == $nYear)		$nYear = '';	//연도는 한번씩만 출력

						//배당빈도(연도기준 배당횟수)
						if($nYear){
//							$cnt = sqlRowOne("select count(*) from api_Dividends where symbol='".$gbl_symbol."' and date like '".$nYear."%' and declarationTime>0");
						}

						//배당빈도(1년동안 배당횟수)
						$chkTime = strtotime($v['payDate']." -1 years");
						$cnt = sqlRowOne("select count(*) from api_Dividends where symbol='".$gbl_symbol."' and dateTime<='".$v['dateTime']."' and dateTime>'".$chkTime."'");

						if($cnt == 1)			$cntTxt = '연간배당';
						elseif($cnt == 2)		$cntTxt = '반기배당';
						elseif($cnt == 4)		$cntTxt = '분기배당';
						elseif($cnt == 12)		$cntTxt = '월배당';
						else						$cntTxt = '';
				?>
					<?if($nYear){?>
					<tr class='n'>
						<td><?=$nYear?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?}?>
					<tr>
						<td title='연도'></td>
						<td title='배당발표일'><?=$v['declarationDate']?></td>
						<td title='배당락일'><?=$v['date']?></td>
						<td title='주주명부확정일'><?=$v['recordDate']?></td>
						<td title='배당지급일'><?=$v['payDate']?></td>
						<td title='배당빈도'><?=$cntTxt?></td>
						<td title='배당금액'><?=$v['amount']?> 달러</td>
						<td title='주식분할조정배당금'><?=$v['adjustedAmount']?> 달러</td>
					</tr>
				<?
						$pYear = date('Y',$v['recordTime']);

						//마지막 3개는 노출하지 않음(1년 기준으로 배당주기 계산불가)
						if($limit == $k){
							break;
						}
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
<?
	}
?>
	<div class="">
		
	</div>
</div>