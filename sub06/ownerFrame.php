<?
	include'../head2.php';

	//현재주가
	$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$symbol."'");

	//실시간 환율정보
	$exArr = Util::ExchangeRate();
	$exRate = str_replace(',','',$exArr[1]);

	//전체 주식수
	$shareOutstanding = sqlRowOne("select shareOutstanding from api_Company_Profile where symbol='".$symbol."'");
	$shareTot = $shareOutstanding * 1000000;		//총 주식수







	if(!$f_sortItem)		$f_sortItem = 'share';
	if(!$f_sortType)	$f_sortType = 'desc';


	$record_count = 10;  //한 페이지에 출력되는 레코드수

	$link_count = 10; //한 페이지에 출력되는 페이지 링크수

	if(!$record_start){
		$record_start = 0;
	}

	$current_page = ($record_start / $record_count) + 1;

	$group = floor($record_start / ($record_count * $link_count));

	//쿼리조건
	$query_ment = " where symbol='".$symbol."'";

	//정렬방식
	$thClass01 = 'arrowUpDown';
	$thClass02 = 'arrowUpDown';
	$thClass03 = 'arrowUpDown';


	if($f_sortItem == 'name'){
		if($f_sortType == 'asc')		$thClass01 = 'arrowUp';
		else								$thClass01 = 'arrowDown';

	}elseif($f_sortItem == 'share'){
		if($f_sortType == 'asc')		$thClass02 = 'arrowUp';
		else								$thClass02 = 'arrowDown';

	}elseif($f_sortItem == 'changeNum'){
		if($f_sortType == 'asc')		$thClass03 = 'arrowUp';
		else								$thClass03 = 'arrowDown';
	}

	$sort_ment = "order by $f_sortItem $f_sortType";

	$query = "select * from api_Ownership $query_ment";

	$result = mysql_query($query) or die("연결실패");

	$total_record = mysql_num_rows($result);

	$total_page = (int)($total_record / $record_count);

	if($total_record % $record_count){
		$total_page++;
	}

	$query2 = $query." $sort_ment limit $record_start, $record_count";

	$result = mysql_query($query2);
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
</style>

<form name='frm_owner' id='frm_owner' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type="text" style="display: none;">  <!-- 텍스트박스 1개이상 처리.. 자동전송방지 -->
<input type='hidden' name='type' value=''>
<input type='hidden' name='record_start' value='<?=$record_start?>'>
<input type='hidden' name='next_url' value="<?=$_SERVER['PHP_SELF']?>">
<input type='hidden' name='f_sortItem' value='<?=$f_sortItem?>'>
<input type='hidden' name='f_sortType' value='<?=$f_sortType?>'>
<input type='hidden' name='symbol' value='<?=$symbol?>'>

<div>
	<table class="subtable">
		<tr>
			<th class='<?=$thClass01?>' data-th='name'>순위/주주(기관)명</th>
			<th class='<?=$thClass02?>' data-th='share'>보유 주식수</th>
			<th data-th='value'>시장가치</th>
			<th data-th='percent'>전체주식 대비 비중</th>
			<th class='<?=$thClass03?>' data-th='changeNum'>최근변경량/날짜</th>
		</tr>
<?
if($total_record){
	$i = $total_record - ($current_page - 1) * $record_count;

	while($row = mysql_fetch_array($result)){

		//보유 주식수
		$sArr = Util::unitNum($row['share']);
		$shareTxt = number_format($sArr[0],2).$sArr[1];

		//순위
		$cnt = sqlRowOne("select count(*) from api_Ownership where symbol='".$symbol."' and share<'".$row['share']."'");
		$rank = $total_record - $cnt;

		//시장가치
		$value = $nowC * $row['share'];
		$vArr = Util::unitNum($value);
		$valueTxt = number_format($vArr[0],2).$vArr[1];
		$won = $vArr[0] * $exRate;
		$wonTxt = Util::convertHan($won,8,1);

		//전체주식 대비 비중
		$percent = Util::fnPercent2($shareTot,$row['share']);
?>
		<tr>
			<td title='순위'><?=number_format($rank)?></td>
			<td rowspan="2" title='보유 주식수'><?=$shareTxt?> 주</td>
			<td rowspan="2" title='시장가치'><?=$valueTxt?> 달러<br><?=$wonTxt?>원</td>
			<td rowspan="2" title='전체주식 대비 비중'><?=$percent?>%</td>
			<td title='최근변경량'><?=number_format($row['changeNum'])?></td>
		</tr>
		<tr>
			<td title='주주(기관)명'><?=$row['name']?></td>
			<td title='날짜'><?=$row['filingDate']?></td>
		</tr>
<?
		$i--;
	}

}else{
?>
		<tr> 
			<td colspan="5" align='center' height='50'>데이터가 없습니다.</td>
		</tr>
<?
}
?>
	</table>
</div>

<?
if($total_record){
	$fName = 'frm_owner';
	include '../module/pageNum.php';
}
?>

</form>

<script>
function ownerSort(s,t){
	form = document.frm_owner;
	form.f_sortItem.value = s;
	form.f_sortType.value = t;
	form.record_start.value = 0;
	form.submit();
}

$(".subtable th").on("click", function () {
	s = $(this).data('th');		//선택한 항목
	cs = $(this).attr('class');	//현재 상태

	if(s == 'name' || s == 'share' || s == 'changeNum'){
		if(cs == 'arrowUpDown' || cs == 'arrowDown')	t = 'asc';
		else															t = 'desc';

		ownerSort(s,t);
	}
});
</script>