<?
	$geDate = date('Y-m-d');
	$gsDate = date('Y-m-d', strtotime('-1 year', strtotime($geDate)));

	$geTime = strtotime($geDate) + 86399;
	$gsTime = strtotime($gsDate);

	$symbol = $item['symbol01'];
	$pData = pnlData($symbol, $gsTime, $geTime);
	$pnlPer = $pData['pnlPer'];	//수익률
?>
				<div class="joo_box bg_gry investBtn" data-tid="<?=$item['uid']?>">
					<h4><?=$item['title01']?></h4>
					<p class="joo_detail"><?=$item['msg01']?></p>
					<div class="api_box">
						<a href="javascript://" style="cursor:default;">
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