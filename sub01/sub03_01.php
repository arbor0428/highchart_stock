<?
	$eDate = date('Y-m-d');
	$sDate = date('Y-m-d', strtotime('-1 month', strtotime($eDate)));

	$eTime = strtotime($eDate) + 86399;
	$sTime = strtotime($sDate);

	$cutLine = 5;	//최초 보여지는 리스트 수
?>

<div id="cont1" class="feature_box">
	<div class="investOpi_wrap">


		<div class="investOpinion">
			<h3 class="sub_tit">최근 투자의견 상향 종목</h3>
			<table class="subtable">
				<colgroup>
					<col width="17%">
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="48%">
				</colgroup>
				<tr>
					<th>심볼(티커)<br>+회사명</th>
					<th>6개월<br>수익률퍼센트</th>
					<th>섹터</th>
					<th>투자의견 제시회사+날짜</th>
					<th>투자의견<br>(from - to)</th>
				</tr>

			<?
				$joinQuery = " left join Stock_Candles_Last as l on s.symbol=l.symbol";
				$joinQuery .= " left join api_Company_Profile as c on s.symbol=c.symbol";
				$joinQuery .= " left join Historical_Market_Cap_Last as m on s.symbol=m.symbol";
				$row = sqlArray("select s.*, l.pmDataMonth6, c.name, c.gsector from api_Stock_Up_Down as s ".$joinQuery." where s.gradeTime>='".$sTime."' and s.gradeTime<='".$eTime."' and s.action='up' and c.name!='' group by s.symbol order by m.marketCapitalization desc");

				foreach($row as $k => $v){
					if($k > ($cutLine-1))		$lineClass = 'cutLine';
					else							$lineClass = '';

					$udClass01 = UpDownClass($v['pmDataMonth6']);		//상승,하락 색상
			?>

				<tr class="<?=$lineClass?>">
					<td title="티커+회사명">
						<a href="/sub06/sub01.php?gbl_symbol=<?=$v['symbol']?>">
							<span class="blue bb"><?=$v['symbol']?></span><br>
							<span><?=$v['name']?></span>
						</a>
					</td>
					<td title="6개월 수익률퍼센트" class='<?=$udClass01?>'><?=$v['pmDataMonth6']?>%</td>
					<td title="섹터"><?=$v['gsector']?></td>
					<td title="투자의견 제시회사+날짜">
						<span class="bpurple bold"><?=$v['company']?></span><br>
						<span><?=date('Y/m/d',$v['gradeTime'])?></span>
					</td>
					<td title="투자의견"><div class="dp_f dp_c dp_cc"><span class="grybg"><?=$v['fromGrade']?></span> ▶ <span class="redbg"><?=$v['toGrade']?></span></div></td>
				</tr>
			<?
				}
			?>

			</table>
		</div>


		<div class="investOpinion">
			<h3 class="sub_tit">최근 투자의견 하향 종목</h3>
			<table class="subtable">
				<colgroup>
					<col width="17%">
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="48%">
				</colgroup>
				<tr>
					<th>심볼(티커)<br>+회사명</th>
					<th>6개월<br>수익률퍼센트</th>
					<th>섹터</th>
					<th>투자의견 제시회사+날짜</th>
					<th>투자의견<br>(from - to)</th>
				</tr>
			<?
				$joinQuery = " left join Stock_Candles_Last as l on s.symbol=l.symbol";
				$joinQuery .= " left join api_Company_Profile as c on s.symbol=c.symbol";
				$joinQuery .= " left join Historical_Market_Cap_Last as m on s.symbol=m.symbol";
				$row = sqlArray("select s.*, l.pmDataMonth6, c.name, c.gsector from api_Stock_Up_Down as s ".$joinQuery." where s.gradeTime>='".$sTime."' and s.gradeTime<='".$eTime."' and s.action='down' and c.name!='' group by s.symbol order by m.marketCapitalization desc");

				foreach($row as $k => $v){
					if($k > ($cutLine-1))		$lineClass = 'cutLine';
					else							$lineClass = '';

					$udClass01 = UpDownClass($v['pmDataMonth6']);		//상승,하락 색상
			?>

				<tr class="<?=$lineClass?>">
					<td title="티커+회사명">
						<span class="blue bb"><?=$v['symbol']?></span><br>
						<span><?=$v['name']?></span>
					</td>
					<td title="6개월 수익률퍼센트" class='<?=$udClass01?>'><?=$v['pmDataMonth6']?>%</td>
					<td title="섹터"><?=$v['gsector']?></td>
					<td title="투자의견 제시회사+날짜">
						<span class="bpurple bold"><?=$v['company']?></span><br>
						<span><?=date('Y/m/d',$v['gradeTime'])?></span>
					</td>
					<td title="투자의견"><div class="dp_f dp_cc dp_c"><span class="grybg"><?=$v['fromGrade']?></span> ▶ <span class="redbg"><?=$v['toGrade']?></span></div></td>
				</tr>
			<?
				}
			?>
			</table>
		</div>
	</div>
	<div class="moreBtn" onclick="cutLineChk();">
		<div class="plue_btn">
			<span class="pb">펼치기</span>
		</div>
	</div>

	<?
		//주식
		include 'stock.php';
	?>
</div>

<style>
	.subtable tr {height: 65px;}
	.investOpinion .subtable tr th,
	.investOpinion .subtable tr td {font-size: 14px;}
	.investOpinion .subtable tr td span {font-size: 14px;}
	.subtable tr td span {margin: 0;}
	.investOpi_wrap .investOpinion table tr td .grybg {margin-right: 5px;}
	.investOpi_wrap .investOpinion table tr td .redbg {margin-left: 5px;}
	.feature_box .moreBtn {margin-top: 10px; border-radius: 10px; background-color: #7c7c7c;}
	.feature_box .moreBtn .plue_btn {background-color: transparent;}
	.feature_box .moreBtn .plue_btn span {font-weight: 400; font-size: 20px;}
</style>

<script>
function cutLineChk(){
	if($(".cutLine").css("display") == "none"){
		$('.cutLine').show();
		$('.pb').text("접기");
	}else{
		$('.cutLine').hide();
		$('.pb').text("펼치기");
	}
}
</script>