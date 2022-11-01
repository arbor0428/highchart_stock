<div class="anal_tableWrap">
	<div class="analysis_table">
		<h3 class="sub_tit"><span class="bold"><?=$gbl_symbol?></span>는 이러한 종목입니다.</h3>
		<table class="subtable type2">
			<tbody>
				<tr>
					<th>ETF 이름</th>
					<td><?=$row01['name']?></td>
				</tr>
				<tr>
					<th>운용사</th>
					<td><?=$row01['etfCompany']?></td>
				</tr>
				<tr>
					<th>웹사이트</th>
					<td><a href="<?=$row01['website']?>" target="_blank"><?=$row01['website']?></a></td>
				</tr>
				<tr>
					<th>투자 자산군</th>
					<td><?=$row01['assetClass']?></td>
				</tr>
				<tr>
					<th>상장일</th>
					<td><?=$row01['inceptionDate']?></td>
				</tr>
				<tr>
					<th>추적 인덱스</th>
					<td><?=$row01['trackingIndex']?></td>
				</tr>
				<tr>
					<th>투자 세그먼트</th>
					<td><?=$row01['investmentSegment']?></td>
				</tr>
				<tr>
					<th>cusip</th>
					<td><?=$row01['cusip']?></td>
				</tr>
				<tr>
					<th>isin</th>
					<td><?=$row01['isin']?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="analysis_table">
		<h3 class="sub_tit">숫자로 보는 <span class="bold"><?=$gbl_symbol?></span></h3>
		<table class="subtable type2">
			<tbody>
				<tr>
					<th>AUM(총 운용자산)</th>
					<td><span><?=$aumHan?></span><br><span>(<?=number_format($aumRank)?>위 / <?=number_format($etfTotNum)?>)</span></td>
				</tr>
				<tr>
					<th>NAV</th>
					<td><?=number_format(round($nav,2),2)?></td>
				</tr>
				<tr>
					<th>수수료</th>
					<td><?=$row01['expenseRatio']?>%</td>
				</tr>
				<tr>
					<th>priceToBook</th>
					<td><?=$row01['priceToBook']?></td>
				</tr>
				<tr>
					<th>priceToEarnings</th>
					<td><?=$row01['priceToEarnings']?></td>
				</tr>
				<tr>
					<th>평균거래량</th>
					<td><?=round($avgVolume,2)?></td>
				</tr>
				<tr>
					<th>괴리율</th>
					<td><?=round($per01,2)?>%</td>
				</tr>
				<tr>
					<th>분배율</th>
					<td><?=round($per02,2)?>%</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>