<?
	include '../header.php';

	$gbl_symbol = 'V';
?>



<div id="sub_cont">
	<div class="inner">
		<table cellpadding='0' cellspacing='0' border='0' width='100%' class='gTable'>
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
			$row = sqlArray("select * from api_Dividends where symbol='".$gbl_symbol."' and declarationTime>0 order by declarationTime desc");
			foreach($row as $v){
				$nYear = date('Y',$v['recordTime']);
				if($pYear == $nYear)		$nYear = '';	//연도는 한번씩만 출력

				//배당빈도(1년동안 배당횟수)
				$chkTime = strtotime($v['payDate']." -1 years");
				$cnt = sqlRowOne("select count(*) from api_Dividends where symbol='".$gbl_symbol."' and dateTime<='".$v['dateTime']."' and dateTime>'".$chkTime."'");
		?>
			<?if($nYear){?>
			<tr>
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
				<td></td>
				<td><?=$v['declarationDate']?></td>
				<td><?=$v['date']?></td>
				<td><?=$v['recordDate']?></td>
				<td><?=$v['payDate']?></td>
				<td><?=$cnt?></td>
				<td><?=$v['amount']?></td>
				<td><?=$v['adjustedAmount']?></td>
			</tr>
		<?
				$pYear = date('Y',$v['recordTime']);
			}
		?>
		</table>
	</div>
</div>


<?
	include '../footer.php';
?>