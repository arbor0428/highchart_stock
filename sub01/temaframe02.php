<?
	include'../head2.php';

	$uid = $_GET['uid'];
	if(!$uid){
		Msg::backMsg('접근오류');
		exit;
	}

	$geDate = date('Y-m-d');
	$gsDate = date('Y-m-d', strtotime('-1 year', strtotime($geDate)));

	$geTime = strtotime($geDate) + 86399;
	$gsTime = strtotime($gsDate);

	$row = sqlRow("select * from ks_invest where uid='".$uid."'");
	$symbol01 = $row['symbol01'];
	$title01 = $row['title01'];
	$msg01 = $row['msg01'];

	//테마종목
	$row = pnlData($symbol01, $gsTime, $geTime);
	$pnl01 = $row['pnlPer'];		//수익률
	$cData01 = $row['cData'];	//그래프 데이터

	if(!$symbol02)		$symbol02 = "^GSPC";

	//snp종목
	$row = pnlData($symbol02, $gsTime, $geTime);
	$pnl02 = $row['pnlPer'];		//수익률
	$cData02 = $row['cData'];	//그래프 데이터

	$sArr = Array("^GSPC"=>"S&P 500", "^NDX"=>"nasdaq 100", "^DJI"=>"Dow Jones");
?>

<div class="modalTema_box modalTema_box02">
	<h3 class="sub_tit help_point02"><?=$title01?> (<?=$symbol01?>)</h3>
	<div class="dp_sb">
		<div class="joo_box bg_gry investBtn">
			<h4><?=$title01?></h4>
			<p class="joo_detail"><?=$msg01?></p>
			<div class="api_box">
				<a href="">
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
		<div>
		<?
			$graphID = 'temaSnpGraph';
			include 'temaSnpGraph.php';
		?>
		</div>
	</div>

	<div class="tema_tableWrap" style="margin-top:80px;">
		<div class="tema_table">
			<h3 class="sub_tit help_point02"><?=$title01?> (<?=$symbol01?>)</h3>
			<table class="subtable">
				<tbody>
					<tr>
						<th>+티커<br>회사이름</th>
						<th>현재가격<br>+1일가격변동폭<br>+퍼센트</th>
						<th>1달수익</th>
						<th>3개월수익</th>
						<th>6개월수익</th>
						<th>1년그래프단순</th>
					</tr>
				<?
					//ETFs Holdings 에서 상위 5개 주식심볼(ks_symbol에 없는 경우도 있으니 10개를 가져와서 심볼 데이터가 있는 5개를 노출)
					$item = sqlArray("select h.symbolTxt, p.*, c.c, c.pmDataDay, c.pmDataMonth, c.pmDataMonth3, c.pmDataMonth6 from api_ETFs_Holdings as h left join api_Company_Profile as p on h.symbolTxt=p.symbol left join Stock_Candles_Last as c on h.symbolTxt=c.symbol where h.symbol='".$symbol01."' order by h.uid asc limit 20");

					$c = 1; 

					if($item){
						foreach($item as $v){
							if($v['uid']){
								$nowC = $v['c'];	//최신 c값
								$pmDataDay = $v['pmDataDay'];

								$perData = Util::nf1($pmDataDay,2);
								if($perData > 0){
									$txtClass = 'upClass';
									$txtArrow = '▲';

								}else if($perData < 0){
									$txtClass = 'downClass';
									$txtArrow = '▼';

								}else{
									$txtClass = '';
									$txtArrow = '';
								}
				?>
					<tr>
						<td title="티커+회사이름">								
							<span class="blue bb block"><?=$v['symbol']?></span>
							<span class="block"><?=$v['name']?></span>
						</td>
						<td title="현재가격+1일가격변동폭+퍼센트"><span class="<?=$txtClass?>"><?=number_format($nowC,2)?><br><?=$txtArrow?> (<?=Util::nf1($pmDataDay,2)?>%)</span></td>
						<td title="1달수익"><?=$v['pmDataMonth']?>%</td>
						<td title="3개월수익"><?=$v['pmDataMonth3']?>%</td>
						<td title="6개월수익"><?=$v['pmDataMonth6']?>%</td>
						<td title="1년그래프단순">
						<?
							$dataList = '';
							$xAxisList = '';

							$grow = sqlArray("select * from api_Stock_Candles_D where symbol='".$v['symbol']."' order by t desc limit 52");

							foreach($grow as $g){
								if($dataList){
									$dataList .= ",";
									$xAxisList .= ",";
								}

								$dataList .= $g['c'];								//그래프 value
								$xAxisList .= "'".date('n/d',$g['t'])."'";		//x축
							}

							$graphID = 'ymdLeft'.$c;
							include 'analyst_graph.php';
						?>
						</td>
					</tr>
				<?
								if($c == 5)	break;
								$c++;
							}
						}
					}
				?>
				</tbody>
			</table>
		</div>

		<div class="tema_table">
			<h3 class="sub_tit help_point02" id="snpName">S&P 500</h3>
			<table class="subtable">
				<tbody>
					<tr>
						<th>지수</th>
						<th>현재가격<br>+1일가격변동폭<br>+퍼센트</th>
						<th>1달수익</th>
						<th>3개월수익</th>
						<th>6개월수익</th>
						<th>1년그래프단순</th>
					</tr>

				<?
				$c = 1;

				foreach($sArr as $k1 => $v1){
					$symbol = $k1;

					//ETFs Holdings 에서 상위 5개 주식심볼(ks_symbol에 없는 경우도 있으니 10개를 가져와서 심볼 데이터가 있는 5개를 노출)
					$row = sqlArray("select * from Stock_Candles_Last where symbol='".$symbol."'");

					if($row){
						foreach($row as $v){
							$nowC = $v['c'];	//최신 c값
							$pmDataDay = $v['pmDataDay'];

							$perData = Util::nf1($pmDataDay,2);
							if($perData > 0){
								$txtClass = 'upClass';
								$txtArrow = '▲';

							}else if($perData < 0){
								$txtClass = 'downClass';
								$txtArrow = '▼';

							}else{
								$txtClass = '';
								$txtArrow = '';
							}
				?>
					<tr>
						<td title="지수">
							<span class="blue bb block"><?=$v1?></span>
						<!--
							<span class="block"><?=$v1?></span>
						-->
						</td>
						<td title="현재가격+1일가격변동폭+퍼센트"><span class="<?=$txtClass?>"><?=number_format($nowC,2)?><br><?=$txtArrow?> (<?=Util::nf1($pmDataDay,2)?>%)</span></td>
						<td title="1달수익"><?=$v['pmDataMonth']?>%</td>
						<td title="3개월수익"><?=$v['pmDataMonth3']?>%</td>
						<td title="6개월수익"><?=$v['pmDataMonth6']?>%</td>
						<td title="1년그래프단순">
						<?
							$dataList = '';
							$xAxisList = '';

							$grow = sqlArray("select * from api_Stock_Candles_D where symbol='".$k1."' order by t desc limit 52");

							foreach($grow as $g){
								if($dataList){
									$dataList .= ",";
									$xAxisList .= ",";
								}

								$dataList .= $g['c'];								//그래프 value
								$xAxisList .= "'".date('n/d',$g['t'])."'";		//x축
							}

							$graphID = 'ymdRight'.$c;
							include 'analyst_graph.php';
						?>
						</td>
					</tr>
				<?
							$c++;
						}
					}
				}
				?>

				</tbody>
			</table>
		</div>
	</div>
</div>