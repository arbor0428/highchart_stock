<?
//제이쿼리 로드함수를 이용해 페이지가 로딩된 경우
if($_GET['jQueryLoad']){
	include "../module/class/class.DbCon.php";
	include "../module/class/class.Util.php";
	include '../module/lib.php';
?>
<script>
$(document).ready(function(){
	$("#loading").delay("200").fadeOut();
});
</script>
<?
}

//그래프 데이터
$cashX = '';
$cashData01 = '';		//영업현금흐름
$cashData02 = '';		//증감율

$repayX = '';
$repayData01 = '';		//기업무채
$repayData02 = '';		//증감율

if(!$cash_period)		$cash_period = '3';
if(!$cash_type)		$cash_type = 'quarter';
if(!$cash_debt)		$cash_debt = 'short';	

$eYear = date('Y');

$cashGraphNum = 4;

if($cash_period == '1'){
	$sYear = $eYear - 1;

	if($cash_type == 'quarter')		$cashGraphNum = 4;
	else									$cashGraphNum = 1;

}elseif($cash_period == '3'){
	$sYear = $eYear - 3;

	if($cash_type == 'quarter')		$cashGraphNum = 8;
	else									$cashGraphNum = 3;

}elseif($cash_period == '5'){
	$sYear = $eYear - 5;

	if($cash_type == 'quarter')		$cashGraphNum = 8;
	else									$cashGraphNum = 5;

}elseif($cash_period == '10'){
	$sYear = $eYear - 10;

	if($cash_type == 'quarter')		$cashGraphNum = 8;
	else									$cashGraphNum = 8;
}

//분기
if($cash_type == 'quarter'){

	//영업현금흐름
	$row = sqlArray("select * from api_Financial_Statements_cf_quarterly where symbol='".$gbl_symbol."' and period>='".$sYear."' and period<='".($eYear+1)."' order by period");

	$item = Array();
	$c = 0;

	foreach($row as $v){
		$netOperatingCashFlow = $v['netOperatingCashFlow'];

		$item[$c]['date'] = date('Y.m',strtotime($v['period']));
		$item[$c]['netOperatingCashFlow'] = $netOperatingCashFlow;

		if($c > 0){
			//이전값 대비 퍼센트
			$item[$c]['cashGap'] = Util::fnPercent($item[$c-1]['netOperatingCashFlow'],$netOperatingCashFlow);

		}else{
			$info = sqlRow("select * from api_Financial_Statements_cf_quarterly where symbol='".$gbl_symbol."' and period<'".$sYear."' order by period desc limit 1");
			if($info){
				$item[$c]['cashGap'] = Util::fnPercent($info['netOperatingCashFlow'],$netOperatingCashFlow);
			}
		}

		//그래프 데이터
		if($c > 0){
			$cashX .= ',';
			$cashData01 .= ',';
			$cashData02 .= ',';
		}

		$y = date('Y',strtotime($v['period']));
		$m = date('m',strtotime($v['period']));

		if($m <= 3)			$cashX .= "'Q1 ".$y."'";
		elseif($m <= 6)	$cashX .= "'Q2 ".$y."'";
		elseif($m <= 9)	$cashX .= "'Q3 ".$y."'";
		elseif($m <= 12)	$cashX .= "'Q4 ".$y."'";

		if($item[$c]['cashGap'] > 0){
			$cashData01 .= "{y:".$netOperatingCashFlow.",dataLabels: {color: '#eb0828'}}";
			$cashData02 .= "+".$item[$c]['cashGap'];
		}else{
			$cashData01 .= "{y:".$netOperatingCashFlow.",dataLabels: {color: '#5689f5'}}";
			$cashData02 .= $item[$c]['cashGap'];
		}


		$c++;
	}



	//기업부채
	$row = sqlArray("select * from api_Financial_Statements_bs_quarterly where symbol='".$gbl_symbol."' and period>='".$sYear."' and period<='".($eYear+1)."' order by period");

	$items = Array();
	$c = 0;

	foreach($row as $v){
		if($cash_debt == 'short')			$debt = $v['shortTermDebt'];		//단기부채
		elseif($cash_debt == 'long')		$debt = $v['longTermDebt'];		//장기부채
		elseif($cash_debt == 'total')		$debt = $v['totalDebt'];				//총부채

		$items[$c]['date'] = date('Y.m',strtotime($v['period']));
		$items[$c]['debt'] = $debt;

		if($c > 0){
			//이전값 대비 퍼센트
			$items[$c]['repayGap'] = Util::fnPercent($items[$c-1]['debt'],$debt);

		}else{
			$info = sqlRow("select * from api_Financial_Statements_bs_quarterly where symbol='".$gbl_symbol."' and period<'".$sYear."' order by period desc limit 1");
			if($info){
				if($cash_debt == 'short')			$tmpDebt = $info['shortTermDebt'];		//단기부채
				elseif($cash_debt == 'long')		$tmpDebt = $info['longTermDebt'];		//장기부채
				elseif($cash_debt == 'total')		$tmpDebt = $info['totalDebt'];			//총부채

				$items[$c]['repayGap'] = Util::fnPercent($tmpDebt,$debt);
			}
		}


		//그래프 데이터
		if($c > 0){
			$repayX .= ',';
			$repayData01 .= ',';
			$repayData02 .= ',';
		}

		$y = date('Y',strtotime($v['period']));
		$m = date('m',strtotime($v['period']));

		if($m <= 3)			$repayX .= "'Q1 ".$y."'";
		elseif($m <= 6)	$repayX .= "'Q2 ".$y."'";
		elseif($m <= 9)	$repayX .= "'Q3 ".$y."'";
		elseif($m <= 12)	$repayX .= "'Q4 ".$y."'";

//		$repayData01 .= $debt;

		if($items[$c]['repayGap'] > 0){
			$repayData01 .= "{y:".$debt.",dataLabels: {color: '#eb0828'}}";
			$repayData02 .= "+".$items[$c]['repayGap'];
		}else{
			$repayData01 .= "{y:".$debt.",dataLabels: {color: '#5689f5'}}";
			$repayData02 .= $items[$c]['repayGap'];
		}

		$c++;
	}


//연간
}elseif($cash_type == 'year'){

	//영업현금흐름
	$row = sqlArray("select * from api_Financial_Statements_cf_annual where symbol='".$gbl_symbol."' and period>='".$sYear."' and period<='".$eYear."' order by period");

	$item = Array();
	$c = 0;

	foreach($row as $v){
		$netOperatingCashFlow = $v['netOperatingCashFlow'];

		$item[$c]['date'] = date('Y.m',strtotime($v['period']));
		$item[$c]['netOperatingCashFlow'] = $netOperatingCashFlow;

		if($c > 0){
			//이전값 대비 퍼센트
			$item[$c]['cashGap'] = Util::fnPercent($item[$c-1]['netOperatingCashFlow'],$netOperatingCashFlow);

		}else{
			$info = sqlRow("select * from api_Financial_Statements_cf_annual where symbol='".$gbl_symbol."' and period<'".$sYear."' order by period desc limit 1");
			if($info){
				$item[$c]['cashGap'] = Util::fnPercent($info['netOperatingCashFlow'],$netOperatingCashFlow);
			}
		}


		//그래프 데이터
		if($c > 0){
			$cashX .= ',';
			$cashData01 .= ',';
			$cashData02 .= ',';
		}

		$cashX .= date('Y',strtotime($v['period']));

		if($item[$c]['cashGap'] > 0){
			$cashData01 .= "{y:".$netOperatingCashFlow.",dataLabels: {color: '#eb0828'}}";
			$cashData02 .= "+".$item[$c]['cashGap'];
		}else{
			$cashData01 .= "{y:".$netOperatingCashFlow.",dataLabels: {color: '#5689f5'}}";
			$cashData02 .= $item[$c]['cashGap'];
		}

		$c++;
	}



	//기업부채
	$row = sqlArray("select * from api_Financial_Statements_bs_annual where symbol='".$gbl_symbol."' and period>='".$sYear."' and period<='".$eYear."' order by period");

	$items = Array();
	$c = 0;

	foreach($row as $v){
		if($cash_debt == 'short')			$debt = $v['shortTermDebt'];		//단기부채
		elseif($cash_debt == 'long')		$debt = $v['longTermDebt'];		//장기부채
		elseif($cash_debt == 'total')		$debt = $v['totalDebt'];				//총부채

		$items[$c]['date'] = date('Y.m',strtotime($v['period']));
		$items[$c]['debt'] = $debt;

		if($c > 0){
			//이전값 대비 퍼센트
			$items[$c]['repayGap'] = Util::fnPercent($items[$c-1]['debt'],$debt);

		}else{
			$info = sqlRow("select * from api_Financial_Statements_bs_annual where symbol='".$gbl_symbol."' and period<'".$sYear."' order by period desc limit 1");
			if($info){
				if($cash_debt == 'short')			$tmpDebt = $info['shortTermDebt'];		//단기부채
				elseif($cash_debt == 'long')		$tmpDebt = $info['longTermDebt'];		//장기부채
				elseif($cash_debt == 'total')		$tmpDebt = $info['totalDebt'];			//총부채

				$items[$c]['repayGap'] = Util::fnPercent($tmpDebt,$debt);
			}
		}


		//그래프 데이터
		if($c > 0){
			$repayX .= ',';
			$repayData01 .= ',';
			$repayData02 .= ',';
		}

		$repayX .= date('Y',strtotime($v['period']));
//		$repayData01 .= $debt;

		if($items[$c]['repayGap'] > 0){
			$repayData01 .= "{y:".$debt.",dataLabels: {color: '#eb0828'}}";
			$repayData02 .= "+".$items[$c]['repayGap'];
		}else{
			$repayData01 .= "{y:".$debt.",dataLabels: {color: '#5689f5'}}";
			$repayData02 .= $items[$c]['repayGap'];
		}

		$c++;
	}
}

if(!$cashGraphNum)	$cashGraphNum = 4;	//화면에 노출되는 x축 개수
$cashGraphNum -= 1;	//실제 적용은 -1개
?>

<script>
function cashCall(p,t,c){
	$('#loading').show();

	if(p == '')	p = $('#cash_period').val();
	if(t == '')		t = $('#cash_type').val();
	if(c == '')	c = $('#cash_debt').val();

	$('#cashGroup').load('cashData.php?jQueryLoad=1&gbl_symbol=<?=$gbl_symbol?>&cash_period='+p+'&cash_type='+t+'&cash_debt='+c);
//	var offset = $("#cashGroup").offset();
//	$('html, body').animate({scrollTop : offset.top - 300}, 400);
}
</script>

<input type='hidden' name='cash_period' id='cash_period' value='<?=$cash_period?>'>
<input type='hidden' name='cash_type' id='cash_type' value='<?=$cash_type?>'>


	<div class="btnsWrap dp_sb" style="margin-top: 150px;">
		<div class="twoKindWrap dp_f">
			<div id="quarterBtn02" class="<?if($cash_type == 'quarter'){echo 'on02';}?> dp_f dp_c dp_cc" onclick="cashCall('','quarter','');">분기</div>
			<div id="yearlyBtn02" class="<?if($cash_type == 'year'){echo 'on02';}?> dp_f dp_c dp_cc" onclick="cashCall('','year','');">연간</div>
		</div>
		<div class="yearKind dp_f">

			<select name='cash_debt' id='cash_debt' onchange="cashCall('','','');">
				<option value='short' <?if($cash_debt == 'short'){echo 'selected';}?>>단기부채</option>
				<option value='long' <?if($cash_debt == 'long'){echo 'selected';}?>>장기부채</option>
				<option value='total' <?if($cash_debt == 'total'){echo 'selected';}?>>총부채</option>
			</select>

			<div id="oneyear02" class="<?if($cash_period == '1'){echo 'on02';}?> dp_f dp_cc" onclick="cashCall('1','','');">1년</div>
			<div id="threeyear02" class="<?if($cash_period == '3'){echo 'on02';}?> dp_f dp_cc" onclick="cashCall('3','','');">3년</div>
			<div id="fiveyear02" class="<?if($cash_period == '5'){echo 'on02';}?> dp_f dp_cc" onclick="cashCall('5','','');">5년</div>
			<div id="tenyear02" class="<?if($cash_period == '10'){echo 'on02';}?> dp_f dp_cc" onclick="cashCall('10','','');">10년</div>
		</div>
	</div>

	<div class="busiFlowWrap dp_sb">
		<div class="busiFlowBx">
			<p class="sub_tit_det" style="margin-left: 0;">영업현금흐름</p>
			<div class="busiFlowGraph">
			<?
				include 'cashGraph.php';
			?>
			</div>
		</div>
		<div class="busiFlowBx">
			<p class="sub_tit_det" style="margin-left: 0;">기업부채</p>
			<div class="busiFlowGraph">
			<?
				include 'repayGraph.php';
			?>
			</div>
		</div>
	</div>

	<div class="busiAnalWrap">
		<table class="subtable">
			<tbody>
				<tr>
					<th>기업실적<br>재무정보</th>
				<?
					foreach($item as $v){
				?>
					<th><?=$v['date']?></th>
				<?
					}
				?>
				</tr>
				<tr>
					<th>영업현금흐름<br>전분기(전년)대비</th>
				<?
					foreach($item as $v){
						$cashGap = $v['cashGap'];
						if($cashGap < 0)			$cashGapTxt = "<br><span class='blue'>".$cashGap."%</span>";
						elseif($cashGap > 0)	$cashGapTxt = "<br><span class='red'>+".$cashGap."%</span>";
						else							$cashGapTxt = "<br>-";
				?>
					<td>
					<?
						if($v['netOperatingCashFlow']){
							echo number_format($v['netOperatingCashFlow']).' '.$cashGapTxt;
						}else{
							echo 'N/A';
						}
					?>
					</td>
				<?
					}
				?>
				</tr>
				<tr>
					<th>기업부채<br>전분기(전년)대비</th>
				<?
					foreach($items as $v){
						$repayGap = $v['repayGap'];
						if($repayGap < 0)			$repayGapTxt = "<br><span class='blue'>".$repayGap."%</span>";
						elseif($repayGap > 0)	$repayGapTxt = "<br><span class='red'>+".$repayGap."%</span>";
						else							$repayGapTxt = "<br>-";
				?>
					<td>
					<?
						if($v['debt']){
							echo number_format($v['debt']).' '.$repayGapTxt;
						}else{
							echo 'N/A';
						}
					?>
					</td>
				<?
					}
				?>
				</tr>
			</tbody>
		</table>
	</div>