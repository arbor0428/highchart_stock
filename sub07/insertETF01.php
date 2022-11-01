<?
$colorArr11 = Array('#ff6384','#ff9f40','#ffcd56','#4bc0c0','#36a2eb','#e85255','#d499d4','#437eb4','#779c74','#6f0c4f','#9e9fae');

$eArr = Array();

$tot = 0;

//Top10 데이터
$row = sqlArray("select * from api_ETFs_Holdings where symbol='".$gbl_symbol."' order by uid asc limit 10");

foreach($row as $k => $v){
	$s = $v['symbolTxt'];
	$percent = round($v['percent'],2);

	if(!$s)	$s = $v['name'];

	$eArr[$k]['s'] = $s;
	$eArr[$k]['p'] = $percent;

	$tot += $percent;
}

//그래프 색상 & 데이터
$pieColorTxt = '';
$pieDataTxt = '';

for($i=0; $i<10; $i++){
	$v = $eArr[$i];

	if($i > 0){
		$pieColorTxt .= ",";
		$pieDataTxt .= ",";
	}

	$pieColorTxt .= "'".$colorArr11[$i]."'";
	$pieDataTxt .= "['".$v['s']."',".$v['p']."]";
}

//Top10을 제외한 나머지 비율
$other = 100 - $tot;
$eArr[10]['s'] = 'other';
$eArr[10]['p'] = $other;

$pieColorTxt = "'".$colorArr11[10]."',".$pieColorTxt;
$pieDataTxt = "['other',".$other."],".$pieDataTxt;

//총운용자산
$aum = round(($row01['aum'] / 1000000),2);
$aumWon = $aum * $exRate;
$aumWonHan = Util::convertHan($aumWon,6,2);
?>

<div class="ora_line"></div>					
<h3 style="font-size: 20px; font-weight: 700; padding: 20px 0 0 20px;">
	자산구성
</h3>
<div class="dp_sb dp_c" style="padding: 0 20px;">
	<?
		include 'assetCirgraph01.php';
	?>
	<ul class="targ_label">
	<?
		foreach($eArr as $k => $v){
	?>
		<li>
			<div class="line" style="background:<?=$colorArr11[$k]?>;"></div>
			<span><?=Util::Shorten_String($v['s'],30,'..')?> (<?=$v['p']?>%)</span>
		</li>
	<?
		}
	?>
	</ul>
</div>