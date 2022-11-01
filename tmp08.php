<?
	include 'head2.php';
?>

<div class="top_bnr_slick clearfix">

<?
//quoteAPI를 호출해서 실시간 데이터를 21번째로 추가
if($QuoteCall){
	$QuoteArr = Array();

	$i = 1;

	foreach($etcSymbol as $s => $t){
		$v = QuoteAPI($s);

		echo $s.' ==> '.$v['c'].' ['.date('n/d',$v['t']).']<br>';
		$i++;
	}
}
