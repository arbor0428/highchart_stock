<?
if($f_sTxt){
	if(!$record_count)		$record_count = 30;		//한 페이지에 출력되는 레코드수

	$link_count = 10; //한 페이지에 출력되는 페이지 링크수

	if(!$record_start){
		$record_start = 0;
	}

	$current_page = ($record_start / $record_count) + 1;

	$group = floor($record_start / ($record_count * $link_count));

	//쿼리조건
	$query_ment = " where symbol in (".$f_sTxt.")";

	$f_sTime = strtotime($f_sDate);
	$f_eTime = strtotime($f_eDate) + 86399;
	$query_ment .= " and (transactionTime>=$f_sTime and transactionTime<=$f_eTime)";

	$nameQuery = $query_ment;	//내부명검색용

	if($f_name)	$query_ment .= " and name like '%$f_name%'";
	

	//정렬방식
	$thClass01 = 'arrowUpDown';
	$thClass02 = 'arrowUpDown';
	$thClass03 = 'arrowUpDown';
	$thClass04 = 'arrowUpDown';
	$thClass05 = 'arrowUpDown';
	$thClass06 = 'arrowUpDown';
	$thClass07 = 'arrowUpDown';
	$thClass08 = 'arrowUpDown';


	if($f_sortItem == 'name'){
		if($f_sortType == 'asc')		$thClass01 = 'arrowUp';
		else								$thClass01 = 'arrowDown';

	}elseif($f_sortItem == 'symbol'){
		if($f_sortType == 'asc')		$thClass02 = 'arrowUp';
		else								$thClass02 = 'arrowDown';

	}elseif($f_sortItem == 'shareNum'){
		if($f_sortType == 'asc')		$thClass03 = 'arrowUp';
		else								$thClass03 = 'arrowDown';

	}elseif($f_sortItem == 'changeNum'){
		if($f_sortType == 'asc')		$thClass04 = 'arrowUp';
		else								$thClass04 = 'arrowDown';

	}elseif($f_sortItem == 'transactionDate'){
		if($f_sortType == 'asc')		$thClass05 = 'arrowUp';
		else								$thClass05 = 'arrowDown';

	}elseif($f_sortItem == 'transactionPrice'){
		if($f_sortType == 'asc')		$thClass06 = 'arrowUp';
		else								$thClass06 = 'arrowDown';

	}elseif($f_sortItem == 'tradePrice'){
		if($f_sortType == 'asc')		$thClass07 = 'arrowUp';
		else								$thClass07 = 'arrowDown';

	}elseif($f_sortItem == 'marper'){
		if($f_sortType == 'asc')		$thClass08 = 'arrowUp';
		else								$thClass08 = 'arrowDown';
	}

	$sort_ment = "order by $f_sortItem $f_sortType";

	$query = "select * from api_Insider_Transactions $query_ment";

	$result = mysql_query($query) or die("연결실패");

	$total_record = mysql_num_rows($result);

	$total_page = (int)($total_record / $record_count);

	if($total_record % $record_count){
		$total_page++;
	}

	$query2 = $query." $sort_ment limit $record_start, $record_count";

	$result = mysql_query($query2);


	//매도자(변화량-), 매수자(변화량+)
	$crow = sqlRow("select count(if(changeNum<0, 1, null)) as mdCnt from api_Insider_Transactions $query_ment group by name");

	//매도자수(변화량-)
	$mdCnt = sqlRowOne("select count(distinct name) from api_Insider_Transactions $query_ment and changeNum<0");

	//매수자수(변화량+)
	$msCnt = sqlRowOne("select count(distinct name) from api_Insider_Transactions $query_ment and changeNum>0");

	//매도금액
	$mdAmt = sqlRowOne("select sum(changeNum) from api_Insider_Transactions $query_ment and changeNum<0");

	//매수금액
	$msAmt = sqlRowOne("select sum(changeNum) from api_Insider_Transactions $query_ment and changeNum>0");

	//내부자명 리스트(중복제거)
	$nameArr = sqlArray("select name from api_Insider_Transactions $nameQuery group by name order by name");

/*
	//내부자별 매도/매수 횟수
	select name, count(if(changeNum<0, 1, null)) as mdCnt, count(if(changeNum>0, 1, null)) as msCnt from api_Insider_Transactions where symbol in ('KO') and (transactionTime>=1648738800 and transactionTime<=1654095599) group by name;
*/


}else{
	$total_record = '';
}
?>

<style>
.subtable th{
	cursor:pointer;
    background-position: center right;
    background-repeat: no-repeat;
}
.arrowUpDown{background-image: url('data:image/gif;base64,R0lGODlhFQAJAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAkAAAIXjI+AywnaYnhUMoqt3gZXPmVg94yJVQAAOw==');}
.arrowUp{background-image: url('data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjI8Bya2wnINUMopZAQA7');}
.arrowDown{background-image: url('data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjB+gC+jP2ptn0WskLQA7');}
.halfSel {margin-left: 20px; margin-bottom: 30px; width: 280px; border-radius: 5px; padding-left: 10px; border: 1px solid #000;  height: 35px; box-sizing: border-box; box-shadow: rgb(149 157 165 / 20%) 0px 4px 24px; background: url(../img/sel-arrow.png) no-repeat 95% 50%; background-size: 10px; }
.halfTableWrap {margin-bottom: 30px; width: 50%;}
.halfTableWrap .s_deal th {border-bottom: 1px solid #d1d1d1;}
</style>

	<div class="dp_sb" style="align-items: flex-end;">

			<!-- 내부자명 검색 -->
			<?
			if($total_record){
			?>
				<select class="halfSel" name="f_name" id="f_name" onchange="insiderData();">
					<option value=''>내부자명 검색</option>
				<?
				foreach($nameArr as $v){
					if($f_name == $v['name'])		$chk = 'selected';
					else									$chk = '';
				?>
					<option value="<?=$v['name']?>" <?=$chk?>><?=$v['name']?></option>
				<?
				}
				?>
				</select>
			<?
			}
			?>
			<!-- /내부자명 검색 -->

			<div class="halfTableWrap">
				<table cellpadding='0' cellspacing='0' border='0' width='100%' class='s_deal subtable'>
					<tr>
						<th width='25%'>매도자수</th>
						<th width='25%'>매수자수</th>
						<th width='25%'>매도금액</th>
						<th width='25%'>매수금액</th>
					</tr>
					<tr>
						<td><?=number_format($mdCnt)?></td>
						<td><?=number_format($msCnt)?></td>
						<td><?=number_format($mdAmt)?></td>
						<td><?=number_format($msAmt)?></td>
					</tr>
				</table>
			</div>
		</div>

			<div class="insider_table">
				<table class="subtable">
					<thead>
						<tr>
							<th class='<?=$thClass01?>' data-th='name'>내부자명</th>
							<th class='<?=$thClass02?>' data-th='symbol'>회사이름(티커)</th>
							<th class='<?=$thClass03?>' data-th='shareNum'>보유주식수</th>
							<th class='<?=$thClass04?>' data-th='changeNum'>변화량</th>
							<th class='<?=$thClass05?>' data-th='transactionDate'>거래날짜</th>
							<th class='<?=$thClass06?>' data-th='transactionPrice'>거래평단가</th>
							<th class='<?=$thClass07?>' data-th='tradePrice'>거래금액</th>
						<!--
							<th class='<?=$thClass08?>' data-th='marper'>시총대비 거래액(%)</th>
						-->
						</tr>
					</thead>
					<tbody>
<?
if($total_record){
	$i = $total_record - ($current_page - 1) * $record_count;

	while($row = mysql_fetch_array($result)){
?>
						<tr>
							<td title='내부자명'><?=$row['name']?></td>
							<td title='회사이름(티커)'><?=$row['symbol']?></td>
							<td title='보유주식수'><?=number_format($row['shareNum'])?></td>
							<td title='변화량'><?=number_format($row['changeNum'])?></td>
							<td title='거래날짜'><?=$row['transactionDate']?></td>
							<td title='거래평단가'><?=number_format($row['transactionPrice'],2)?></td>
							<td title='거래금액'><?=number_format($row['tradePrice'])?></td>
						<!--
							<td title='시총대비 거래액(%)'><?=$row['marper']?>%</td>
						-->
						</tr>




<?
		$i--;
	}

}else{
?>
						<tr> 
							<td colspan="9" align='center' height='50'>데이터가 없습니다.</td>
						</tr>
<?
}
?>
					</tbody>
				</table>

			</div>
			


<?
if($total_record){
	$fName = 'frm_insider';
	include '../module/pageNumCount.php';
}
?>

</form>

<script>
function insiderSort(s,t){
	form = document.frm_insider;
	form.f_sortItem.value = s;
	form.f_sortType.value = t;
	form.record_start.value = 0;
	form.submit();
}

$(".subtable th").on("click", function () {
	s = $(this).data('th');		//선택한 항목
	cs = $(this).attr('class');	//현재 상태

	if(cs == 'arrowUpDown' || cs == 'arrowDown')	t = 'asc';
	else															t = 'desc';

	insiderSort(s,t);
});
</script>