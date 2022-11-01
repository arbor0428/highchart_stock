<?
$colorArr12 = Array('#ff6384','#ff9f40','#ffcd56','#4bc0c0','#36a2eb','#e85255','#d499d4','#437eb4','#779c74','#6f0c4f','#230858','#9e9fae');

$eArr = Array();

//그래프 색상 & 데이터
$pieColorTxt = '';
$pieDataTxt = '';


foreach($items as $k => $v){
	if($k > 0){
		$pieColorTxt .= ",";
		$pieDataTxt .= ",";
	}

	$pieColorTxt .= "'".$colorArr12[$k]."'";
	$pieDataTxt .= "['".$v['industry']."',".$v['exposure']."]";
}
?>

<div class="ora_line"></div>					
<h3 style="font-size: 20px; font-weight: 700; padding: 20px 0 0 20px;">
	자산구성
</h3>
<div class="dp_sb dp_c" style="padding: 0 20px;min-height:408px;">
	<?
		include 'assetCirgraph02.php';
	?>

	<ul class="targ_label">
	<?
		foreach($items as $k => $v){
	?>
		<li>
			<div class="line" style="background:<?=$colorArr12[$k]?>;"></div>
			<span><?=$v['industry']?> (<?=$v['exposure']?>%)</span>
		</li>
	<?
		}
	?>
	</ul>
</div>
