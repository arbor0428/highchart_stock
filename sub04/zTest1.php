<?
$colorArr11 = Array('#ff6384','#ff9f40','#ffcd56','#4bc0c0','#36a2eb','#e85255','#d499d4','#437eb4','#779c74','#6f0c4f','#9e9fae');

$eArr = Array();

$tot = 0;

$k = 0;

//그래프 색상 & 데이터
$pieColorTxt = '';
$pieDataTxt = '';

foreach($gArr as $s => $p){
	$eArr[$k]['s'] = $s;
	$eArr[$k]['p'] = $p;

	if($k > 0){
		$pieColorTxt .= ",";
		$pieDataTxt .= ",";
	}

	$pieColorTxt .= "'".$colorArr11[$k]."'";
	$pieDataTxt .= "['".$s."',".$p."]";

	$tot += $p;

	if($k == 9)	break;

	$k++;
}

$tot = round($tot,2);

if($tot != 100){
	$other = 100 - $tot;
	$eArr[10]['s'] = 'other';
	$eArr[10]['p'] = $other;

	$pieColorTxt = "'".$colorArr11[10]."',".$pieColorTxt;
	$pieDataTxt = "['other',".$other."],".$pieDataTxt;
}

//총운용자산
$aum = $p1Tot;
$aumWonHan = number_format($w1Tot).'원';
?>

<div class="ora_line"></div>					
<h3 style="font-size: 20px; font-weight: 700; padding: 20px 0 0 20px;">
	평가액비중
</h3>
<div class="dp_sb dp_c" style="padding: 0 20px;">
	<?
		include '../sub07/assetCirgraph01.php';
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