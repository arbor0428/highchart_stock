<?
$etfUpdate = sqlRowOne("select atDate from api_ETFs_Holdings where symbol='".$gbl_symbol."' order by uid asc limit 1");
?>

<h3 class="sub_tit"><?=$gbl_symbol?> 편입 종목 (ETF 종목 상세 업데이트 날짜: <?=$etfUpdate?>)</h3>
<div class="dp_sb">
<div id='etfList01' class="s_tableWrap">
<?
	//리스트
	include 'etfList01.php';
?>
</div>
<div class="cirGraphwrap">
<?
	//그래프
	include 'insertETF01.php';
?>
</div>
</div>