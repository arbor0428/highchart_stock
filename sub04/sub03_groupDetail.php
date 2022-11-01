<?
	include '../header.php';
?>
<style>
.blueBtn {display: block; margin: 150px auto 0; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
.blueBtn2 {display: inline-block; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
</style>

<script>
function groupType(t){
	form = document.frm_group;
	form.type.value = t;
	form.target = '';
	form.action = "<?=$_SERVER['PHP_SELF']?>";
	form.submit();
}

function groupDetail(){
	form = document.frm_group;
	form.type.value = 'detail';
	form.target = '';
	form.action = "/sub04/sub03.php";
	form.submit();
}

function newsList(s){
	$("#newsListBox").css({"width":"90%","max-width":"700px"});
	$('#newsList_ttl').text(s);
	$('#newsListFrame').html("<iframe name='newsList' id='newsList' src='../CompanyNewsList.php?newsSymbol="+s+"' style='width:100%;height:600px;' frameborder='0' scrolling='auto'></iframe>");
	$('.newsListBox_open').click();
}
</script>

<div id="sub_cont">
	<div class="sub_center">
		<?
			include 'investquote.php';

			if(!$type)	$type = 'default';
		?>

		<form name='frm_group' id='frm_group' method='post' action="<?=$_SERVER['PHP_SELF']?>">
		<input type='text' style='display:none;'>
		<input type='hidden' name='type' value='<?=$type?>'>

		<div class="interestList">
			<table class="subtable">
				<colgroup>
					<col style="width: 20%;">
					<col style="width: 30%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
					<col style="width: 10%;">
				</colgroup>
				<tbody>
					<tr>	
						<th>그룹명</th>
						<th>그룹 메모</th>
						<th>종목수</th>
						<th>6개월 수익률</th>
						<th>1년 수익률</th>
						<th>5년 수익률</th>
						<th>배당률</th>
					</tr>
					<tr>	
						<td>
						<?
							//등록된 관심종목
							$grow = sqlArray("select * from ks_userGroup where userid='".$GBL_USERID."' order by sortNum");
						?>
							<select name='gid' onchange="document.frm_group.submit();">
							<?
								foreach($grow as $v){
									if($v['uid'] == $gid)	$chk = 'selected';
									else						$chk = '';
							?>
								<option value="<?=$v['uid']?>" <?=$chk?>><?=$v['title']?></option>
							<?
								}
							?>
							</select>
						</td>
						<?
							//그룹정보
							$grow = sqlRow("select * from ks_userGroup where userid='".$GBL_USERID."' and uid=".$gid);

							//종목정보
							$row = sqlArray("select * from ks_userGroupData where userid='".$GBL_USERID."' and gid=".$gid." order by sortNum");

							$percentTot = sqlRowOne("select sum(percent) from ks_userGroupData where userid='".$GBL_USERID."' and gid=".$gid);
						?>
						<td><?=$grow['memo']?></td>
						<td><?=count($row)?></td>
					<?
						if($percentTot == '100'){
							$pData01 = 0;		//6개월 수익률
							$pData02 = 0;		//1년 수익률
							$pData03 = 0;		//5년 수익률
							$pData04 = 0;		//배당률 수익률

							foreach($row as $s){
								$percent = $s['percent'];
								$symbol = $s['symbol'];

								//종목별 수익률
								$item = sqlRow("select * from Stock_Candles_Last where symbol='".$symbol."'");

								$pData01 += (($item['pmDataMonth6'] / 100) * $percent);
								$pData02 += (($item['pmDataYear1'] / 100) * $percent);
								$pData03 += (($item['pmDataYear5'] / 100) * $percent);

								//배당률
								$currentDividendYieldTTM = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$symbol."'");
								$pData04 += (($currentDividendYieldTTM / 100) * $percent);
							}
					?>
						<td><?=number_format($pData01,2)?>%</td>
						<td><?=number_format($pData02,2)?>%</td>
						<td><?=number_format($pData03,2)?>%</td>
						<td><?=number_format($pData04,2)?>%</td>
					<?
						}else{
					?>
						<td colspan='4' style='color:#d1d1d1;'>종목 비중 합을 100%로 설정해 주세요.</td>
					<?
						}
					?>
					</tr>
				</tbody>
			</table>
		</div>

		</form>

		<ul class="g_tabBtn dp_f">
			<li><a class="dp_f dp_c dp_cc" href="javascript:groupType('default');">기본 보기</a></li>
			<li><a class="dp_f dp_c dp_cc" href="javascript:groupType('graph');">그래프로 보기</a></li>
		</ul>

		<div class="g_tabContWrap">
			<div class="g_tabCont">
			<?
				if($type == 'default'){

					//종목정보(주식)
					$srow = sqlArray("select * from ks_userGroupData where userid='".$GBL_USERID."' and gid=".$gid." and etf='N' order by sortNum");
					if($srow)		include 'detail_GTABBasic01.php';		//기본보기(주식)

					//종목정보(etf)
					$erow = sqlArray("select * from ks_userGroupData where userid='".$GBL_USERID."' and gid=".$gid." and etf='Y' order by sortNum");
					if($erow)		include 'detail_GTABBasic02.php';		//기본보기(etf)

				}elseif($type == 'graph'){
					include 'detail_GTABGraph.php';		//그래프로 보기(주식, etf)
				}
			?>
			</div>
		</div>


		<div style='width:305px;margin:0 auto;'>
			<a class="blueBtn2" href="sub03.php" title="그룹 목록" style="margin: 70px auto 0;">그룹 목록</a>
			<a class="blueBtn2" href="javascript:groupDetail();" title="종목 추가/편집" style="margin: 70px auto 0;">종목 추가/편집</a>
		</div>

	</div>
</div>

<?
	include '../footer.php';
?>