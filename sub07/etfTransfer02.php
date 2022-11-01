<div class="transferSecWrap dp_sb">

<?
	$item = SectorExposure($gbl_symbol);
	$items = $item['sectorExposure'];

	//티커가 없는 경우
	if(!$items){
		$items[0]['industry'] = '주식 외 자산';
		$items[0]['exposure'] = 100;
	}
?>
	<div class="transferSec">
		<p class="sub_tit"><?=$gbl_symbol?> 편입종목 섹터비중</p>
		<div class="cirGraphwrap02">
			<?
				include 'insertETF02.php';
			?>
		</div>
		<table class="subtable">
			<tbody>
				<tr>
					<th>섹터이름</th>
					<th>편입비중</th>
				</tr>
			<?
				foreach($items as $v){
			?>
				<tr>
					<td title='섹터이름'><?=$v['industry']?></td>
					<td title='편입비중'><?=$v['exposure']?>%</td>
				</tr>
			<?
				}
			?>
			</tbody>
		</table>
	</div>

<?
	$item = CountryExposure($gbl_symbol);
	$items = $item['countryExposure'];
?>
	<div class="transferSec">
		<p class="sub_tit"><?=$gbl_symbol?> 편입종목 국가비중</p>
		<div class="cirGraphwrap02">
			<?
				include 'insertETF03.php';
			?>
		</div>
		<table class="subtable">
			<tbody>
				<tr>
					<th>국가명</th>
					<th>국가코드</th>
					<th>편입비중</th>
				</tr>
			<?
				foreach($items as $v){
			?>
				<tr>
					<td title='국가명'><?=$v['country']?></td>
					<td title='국가코드'><?=$v['countryCode']?></td>
					<td title='편입비중'><?=$v['exposure']?>%</td>
				</tr>
			<?
				}
			?>
			</tbody>
		</table>
	</div>
</div>