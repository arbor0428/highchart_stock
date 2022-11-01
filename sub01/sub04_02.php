<div id="cont2" class="whobetter whobetter02">
	<h3 class="sub_tit">투자할 만한 테마 어디 없을까?</h3>

	<div class="kind_invest_api">
	<?
		$geDate = date('Y-m-d');
		$gsDate = date('Y-m-d', strtotime('-1 year', strtotime($geDate)));

		$geTime = strtotime($geDate) + 86399;
		$gsTime = strtotime($gsDate);

		$item = sqlArray("select * from ks_invest order by uid");
		foreach($item as $s){
			$symbol = $s['symbol01'];
			$pData = pnlData($symbol, $gsTime, $geTime);
			$pnlPer = $pData['pnlPer'];	//수익률
	?>
		<div class="joo_box bg_gry investBtn" data-tid="<?=$s['uid']?>">
			<h4><?=$s['title01']?></h4>
			<p class="joo_detail"><?=$s['msg01']?></p>
			<div class="api_box">
				<a href="">
					<ul>
					<?
						//ETFs Holdings 에서 상위 5개 주식심볼(ks_symbol에 없는 경우도 있으니 10개를 가져와서 심볼 데이터가 있는 5개를 노출)
						$row = sqlArray("select h.symbolTxt, p.* from api_ETFs_Holdings as h left join api_Company_Profile as p on h.symbolTxt=p.symbol where h.symbol='".$symbol."' order by h.uid asc limit 20");

						$c = 1; 

						if($row){
							foreach($row as $v){
								if($v['uid']){
					?>
						<li><img src="<?=$v['logo']?>" onerror="this.style.display='none'"></li>
					<?
									if($c == 5)	break;
									$c++;
								}
							}
						}
					?>
					</ul>
					<div class="pergo">
						<div class="percent">
							<?
								$udClass = UpDownClass($pnlPer);
							?>
							<span class="<?=$udClass?>"><?=$pnlPer?>%</span>
							<p>(1년 수익률)</p>
						</div>
						<span class="lnr lnr-chevron-right"></span>
					</div>
				</a>
			</div>
		</div>
	<?
		}
	?>

	</div>

</div>

<script>
function tema02(t){
	$("#multiBox").css({"width":"90%","max-width":"1280px"});
	//$('#multi_ttl').text('test');
	$('#multiFrame').html("<iframe src='/sub01/temaframe02.php?uid="+t+"' name='calendarData' style='width:100%;height:650px;' frameborder='0' scrolling='auto'></iframe>");
	$('.multiBox_open').click();
}

$(".kind_invest_api > .investBtn").click(function(event){
	tid = $(this).data('tid');
	tema02(tid);
	event.preventDefault();
});
</script>