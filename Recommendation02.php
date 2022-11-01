<?
	if($row){
?>
					<div class="targ_top">
						<div class="top_left">
							<p class="dar">$<span class="targetMeanTxt"><?=$targetMean?></span></p>
							<p class="s_detail"><span>▲</span><span>(<span id="targetPerTxt"><?=$targetPer?></span>%의 상승여력)</span></p>
						</div>
						<div class="top_right">
							<p>
								<span class='companyNameTxt'><?=$companyName?></span>에 대한 목표주가를 제공한 <span class="totNumTxt"><?=number_format($totNum)?></span>명의 애널리스트들의 의견을 바탕으로 합니다.<br>
								평균 목표주가는 <span class="targetMeanTxt"><?=$targetMean?></span> 달러이며, 최고 목표주가는 <span class="targetHighTxt"><?=$targetHigh?></span> 달러이며<br>최저 목표주가는 <span class="targetLowTxt"><?=$targetLow?></span> 달러입니다.<br>
							</p>
						</div>
					</div>

					<?
						include 'graph10.php';
					?>

					<div class="targ_bottom">
						<div class="bot_box">
							<p>Highest Price Target<span> $<span class="targetHighTxt"><?=$targetHigh?></span></span></p>
						</div>
						<div class="bot_box">
							<p>Average Price Target<span> $<span class="targetMeanTxt"><?=$targetMean?></span></span></p>
						</div>
						<div class="bot_box">
							<p>Lowest Price Target<span> $<span class="targetLowTxt"><?=$targetLow?></span></span></p>
						</div>
					</div>
<?
}else{
	echo "<div style='width:100%;height:300px;text-align:center;line-height:300px;'>전문가 분석정보가 없습니다.</div>";
}
?>