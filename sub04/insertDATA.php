<?
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

if($tot < 100 && count($gArr) != count($eArr)){
	$other = 100 - $tot;
	$other = round($other,2);

	$eArr[10]['s'] = 'other';
	$eArr[10]['p'] = $other;

	$pieColorTxt = "'".$colorArr11[10]."',".$pieColorTxt;
	$pieDataTxt = "['other',".$other."],".$pieDataTxt;
}
?>

		<div class="cirTabGraph">
			<div class="dp_sb dp_c" style="padding: 0 20px;min-height:408px;">
				<?
					include 'insertCirgraph.php';
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
		</div>