<div id="cont1" class="dividend_box">
	<div class="kingBox_wrap">
		<div class="kingBox">
			<div class="help_wrap">
				<h3 class="sub_tit help_point"><?=date('Y')?>년 배당킹 목록 - Dividend King</h3>
				<div class="helpbox helpbox02">
					<p><span class="tit">배당킹(Dividend King) 이란?</span><br>
					최소 50년간 배당 늘린 종목들 뉴욕증권거래 상장기업
					</p>
<!-- 					<div class="closeBtn">
						<div></div>
						<div></div>
					</div> -->
				</div>
			</div>
			<table class="subtable">
				<tbody>
					<tr>
						<th>티커+회사이름</th>
						<th>섹터</th>
						<th>배당증가연수</th>
						<th>배당률</th>
					</tr>
				<?
					$row = sqlArray("select k.*, c.name, c.gsector from ks_Dividend_king as k left join api_Company_Profile as c on k.symbol=c.symbol order by k.uid");
					foreach($row as $v){
						$currentDividendYieldTTM = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$v['symbol']."'");
						if($currentDividendYieldTTM)	$cdy = number_format($currentDividendYieldTTM,2).'%';
						else									$cdy = '-';
				?>
					<tr>
						<td><a href="/sub06/sub01.php?gbl_symbol=<?=$v['symbol']?>"><?=$v['symbol']?> (<?=$v['name']?>)</a></td>
						<td><?=$v['gsector']?></td>
						<td><?=$v['year']?></td>
						<td><?=$cdy?></td>
					</tr>
				<?
					}
				?>
				</tbody>
			</table>
		</div>
		<div class="kingBox">
			<div class="help_wrap">
				<h3 class="sub_tit help_point"><?=date('Y')?>년 배당귀족주 목록 - Dividend 주</h3>
				<div class="helpbox helpbox02">
					<p><span class="tit">배당킹(Dividend King) 이란?</span><br>
					최소 50년간 배당 늘린 종목들 뉴욕증권거래 상장기업
					</p>
<!-- 					<div class="closeBtn">
						<div></div>
						<div></div>
					</div> -->
				</div>
			</div>
			<table class="subtable">
				<tbody>
					<tr>
						<th>티커+회사이름</th>
						<th>섹터</th>
						<th>배당증가연수</th>
						<th>배당률</th>
					</tr>
				<?
					$row = sqlArray("select k.*, c.name, c.gsector from ks_Dividend_vip as k left join api_Company_Profile as c on k.symbol=c.symbol order by k.uid");
					foreach($row as $v){
						$currentDividendYieldTTM = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$v['symbol']."'");
						if($currentDividendYieldTTM)	$cdy = number_format($currentDividendYieldTTM,2).'%';
						else									$cdy = '-';
				?>
					<tr>
						<td><a href="/sub06/sub01.php?gbl_symbol=<?=$v['symbol']?>"><?=$v['symbol']?> (<?=$v['name']?>)</a></td>
						<td><?=$v['gsector']?></td>
						<td><?=$v['year']?></td>
						<td><?=$cdy?></td>
					</tr>
				<?
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>