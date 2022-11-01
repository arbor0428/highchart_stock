<?
/**************************************************** 그래프 관련 데이터s ****************************************************/
$geDate = date('Y-m-d');
$gsDate = date('Y-m-d', strtotime('-1 year', strtotime($geDate)));

$geTime = strtotime($geDate) + 86399;
$gsTime = strtotime($gsDate);

//첫번째 심볼
$row = pnlData($symbol01, $gsTime, $geTime);

$pnl01 = $row['pnlPer'];	//수익률
$cData01 = $row['cData'];

//두번째 심볼
$row = pnlData($symbol02, $gsTime, $geTime);

$pnl02 = $row['pnlPer'];	//수익률
$cData02 = $row['cData'];
/**************************************************** 그래프 관련 데이터e ****************************************************/
?>

				
					<div class="joo_top">
						<!-- 좌측 데이터 -->
						<div class="joo_box modeBtn <?=$bgClass?>" data-tid="<?=$uid01?>">
							<h4><?=$title01?> (<?=$symbol01?>)</h4>
							<p class="joo_detail"><?=$msg01?></p>
							<div class="api_box">
								<a href="javascript://" style="cursor:default;">
									<ul>
									<?
										//ETFs Holdings 에서 상위 5개 주식심볼(ks_symbol에 없는 경우도 있으니 10개를 가져와서 심볼 데이터가 있는 5개를 노출)
										$row = sqlArray("select h.symbolTxt, p.* from api_ETFs_Holdings as h left join api_Company_Profile as p on h.symbolTxt=p.symbol where h.symbol='".$symbol01."' order by h.uid asc limit 20");

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
									<?
//										$row = sqlRow("select * from Stock_Candles_Last where symbol='".$symbol01."'");
//										$perData = Util::nf1($row['pmDataYear1'],2);
									?>
									<div class="pergo">
										<div class="percent">
											<?
												$udClass = UpDownClass($pnl01);
											?>
											<span class="<?=$udClass?>"><?=$pnl01?>%</span>
											<p>(1년 수익률)</p>
										</div>
										<span class="lnr lnr-chevron-right"></span>
									</div>
								</a>
							</div>
						</div>
						<!-- /좌측 데이터 -->

						<div class="vs_img">
							<img src="/img/vs_icon.png">
						</div>

						<!-- 우측 데이터 -->
						<div class="joo_box modeBtn <?=$bgClass?>" data-tid="<?=$uid02?>">
							<h4><?=$title02?> (<?=$symbol02?>)</h4>
							<p class="joo_detail"><?=$msg02?></p>
							<div class="api_box">
								<a href="javascript://" style="cursor:default;">
									<ul>
									<?
										//ETFs Holdings 에서 상위 5개 주식심볼(ks_symbol에 없는 경우도 있으니 10개를 가져와서 심볼 데이터가 있는 5개를 노출)
										$row = sqlArray("select h.symbolTxt, p.* from api_ETFs_Holdings as h left join api_Company_Profile as p on h.symbolTxt=p.symbol where h.symbol='".$symbol02."' order by h.uid asc limit 20");

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
									<?
//										$row = sqlRow("select * from Stock_Candles_Last where symbol='".$symbol02."'");
//										$perData = Util::nf1($row['pmDataYear1'],2);
									?>
									<div class="pergo">
										<div class="percent">
											<?
												$udClass = UpDownClass($pnl02);
											?>
											<span class="<?=$udClass?>"><?=$pnl02?>%</span>
											<p>(1년 수익률)</p>
										</div>
										<span class="lnr lnr-chevron-right"></span>
									</div>
								</a>
							</div>
						</div>
						<!-- /우측 데이터 -->
					</div>

					<div class="joo_bottom">
					<?							
						include '/home/myss/www/graph02.php';
					?>
					</div>