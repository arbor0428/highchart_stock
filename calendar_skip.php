<?
for($i=1;$i<=$no;$i++) { 
	$ck = $no-$i+1;

	//첫째주 이전월 일자 표기용
	if($sdate){
		$snum = date('d',$sdate-((3600*24)*$ck));
		$sy = date('Y',$sdate);
		$sm = date('m',$sdate);
		$smk = mktime(0,0,0,$sm-1,1,$sy);
		$yy = date('Y',$smk);
		$mm = date('m',$smk);
	}

	//마지막주 다음달 일자 표기용
	if($edate){
		$snum=$i;
		$sy = date('Y',$edate);
		$sm = date('m',$edate);
		$smk = mktime(0,0,0,$sm,1,$sy);
		$yy = date('Y',$smk);
		$mm = date('m',$smk);
	}
?>

		<td style='vertical-align:top;'>
			<table class='tableOnly'>
				<tr>
					<td style='font-size:13px;padding:5px;' class='snum2'><?=$snum?></td>
				</tr>
<!--
			<?
				$ymd = $yy.sprintf('%02d',$mm).sprintf('%02d',$snum);
				$vArr = $sArr[$ymd];

				for($s=0; $s<count($vArr); $s++){
					$info = $vArr[$s];

					$uid = $info['uid'];
					$title = $info['title'];
					$color = $info['color'];
			?>
				<tr>
					<td onclick="clasView('<?=$uid?>');" style="font-size:13px;"><div class='scBox'><span style='color:<?=$color?>;'>●</span> <?=$title?></div></td>
				</tr>
			<?
				}
			?>
-->
			</table>
		</td>
<?
	}
?>