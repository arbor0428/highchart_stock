<?
	include'../head2.php';

	$uid = $_GET['uid'];
	if(!$uid){
		Msg::backMsg('접근오류');
		exit;
	}
?>

<div class="modalTema_box">
	<div class="joo_wrap wid100">
	<?
		//관리자에서 데이터
		$row = sqlRow("select * from ks_thema where uid='".$uid."'");

		if($row){
			//좌측 데이터
			$symbol01 = $row['symbol01'];
			$label01 = $row['label01'];
			$title01 = $row['title01'];
			$msg01 = $row['msg01'];						

			//우측 데이터
			$symbol02 = $row['symbol02'];
			$label02 = $row['label02'];
			$title02 = $row['title02'];
			$msg02 = $row['msg02'];

			$graphID = 'whosbetter01';		//그래프ID
			$graphWidth = '100%';			//그래프 넓이
			$graphHeight = '240px';		//그래프 높이

			include '../isGood.php';
		}
	?>
	</div>
	<div class="tema_tableWrap" style="margin-top:80px;">
		<div class="tema_table">
			<h3 class="sub_tit help_point02"><?=$title01?> (<?=$symbol01?>)</h3>
			<table class="subtable">
				<tbody>
					<tr>
						<th>티커<br>+회사이름</th>
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

							$grow = sqlArray("(select * from api_Stock_Candles_D where symbol='".$v['symbol']."' order by t desc limit 52) order by t asc");

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
			<h3 class="sub_tit help_point02"><?=$title02?> (<?=$symbol02?>)</h3>
			<table class="subtable">
				<tbody>
					<tr>
						<th>티커<br>+회사이름</th>
						<th>현재가격<br>+1일가격변동폭<br>+퍼센트</th>
						<th>1달수익</th>
						<th>3개월수익</th>
						<th>6개월수익</th>
						<th>1년그래프단순</th>
					</tr>
				<?
					//ETFs Holdings 에서 상위 5개 주식심볼(ks_symbol에 없는 경우도 있으니 10개를 가져와서 심볼 데이터가 있는 5개를 노출)
					$item = sqlArray("select h.symbolTxt, p.*, c.c, c.pmDataDay, c.pmDataMonth, c.pmDataMonth3, c.pmDataMonth6 from api_ETFs_Holdings as h left join api_Company_Profile as p on h.symbolTxt=p.symbol left join Stock_Candles_Last as c on h.symbolTxt=c.symbol where h.symbol='".$symbol02."' order by h.uid asc limit 10");

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

							$graphID = 'ymdRight'.$c;
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
	</div>
</div>
