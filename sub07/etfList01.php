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
	$record_count = 10;  //한 페이지에 출력되는 레코드수

	$link_count = 10; //한 페이지에 출력되는 페이지 링크수

	if(!$record_start){
		$record_start = 0;
	}

	$current_page = ($record_start / $record_count) + 1;

	$group = floor($record_start / ($record_count * $link_count));

	//쿼리조건
	$query_ment = " where symbol='".$gbl_symbol."'";

	$sort_ment = "order by uid";

	$query = "select * from api_ETFs_Holdings $query_ment";

	$result = mysql_query($query) or die("연결실패");

	$total_record = mysql_num_rows($result);

	$total_page = (int)($total_record / $record_count);

	if($total_record % $record_count){
		$total_page++;
	}

	$query2 = $query." $sort_ment limit $record_start, $record_count";

	$result = mysql_query($query2);
?>

	<table class="subtable">
		<tbody>
			<tr>
				<th>순위</th>
				<th>이름</th>
				<th>비중</th>
				<th>주식수량</th>
				<th>티커</th>
				<th>주식가치</th>
			</tr>

	<?
		if($total_record){
			$i = $total_record - ($current_page - 1) * $record_count;

			while($row = mysql_fetch_array($result)){
				$no = ($total_record - $i) + 1;

				$vTxt = round(($row['value'] / 1000000),2);
		?>
			<tr>
				<td title='순위'><?=$no?></td>
				<td title='이름'><?=$row['name']?></td>
				<td title='비중'><?=round($row['percent'],2)?>%</td>
				<td title='주식수량'><?=number_format($row['share'])?></td>
				<td title='티커'><?=$row['symbolTxt']?></td>
				<td title='주식가치'><?=number_format($vTxt,2)?></td>
			</tr>
		<?
				$i--;
			}

		}else{
		?>
			<tr>
				<td colspan='6' height='100'>데이터가 없습니다.</td>
			</tr>
		<?
		}
		?>
		</tbody>
	</table>

<?
if($total_record){
	include 'erfList01_pageNum.php';
}
?>