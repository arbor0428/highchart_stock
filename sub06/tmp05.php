<?
	include '../header.php';
?>

<style>
.pTable td{text-align:right;}
</style>

<form name='frm' id='frm' method='post' action="<?=$_SERVER['PHP_SELF']?>">

<div id="sub_cont">
	<div class="busiAnalWrap">
	<h3>영업현금흐름 / 기업부채</h3>
<?
	$gbl_symbol = 'AAPL';

	if(!$f_period)	$f_period = '10';
	if(!$f_type)		$f_type = 'quarter';
	if(!$f_debt)		$f_debt = 'short';	

	$eYear = date('Y');

	if($f_period == '1')			$sYear = $eYear - 1;
	elseif($f_period == '3')		$sYear = $eYear - 3;
	elseif($f_period == '5')		$sYear = $eYear - 5;
	elseif($f_period == '10')	$sYear = $eYear - 10;


	//분기
	if($f_type == 'quarter'){

		//영업현금흐름
		$row = sqlArray("select * from api_Financial_Statements_cf_quarterly where symbol='".$gbl_symbol."' and period>='".$sYear."' and period<='".$eYear."' order by period");

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

			$c++;
		}



		//기업부채
		$row = sqlArray("select * from api_Financial_Statements_bs_quarterly where symbol='".$gbl_symbol."' and period>='".$sYear."' and period<='".$eYear."' order by period");

		$items = Array();
		$c = 0;

		foreach($row as $v){
			if($f_debt == 'short')			$debt = $v['shortTermDebt'];		//단기부채
			elseif($f_debt == 'long')		$debt = $v['longTermDebt'];		//장기부채
			elseif($f_debt == 'total')		$debt = $v['totalDebt'];				//총부채

			$items[$c]['date'] = date('Y.m',strtotime($v['period']));
			$items[$c]['debt'] = $debt;

			if($c > 0){
				//이전값 대비 퍼센트
				$items[$c]['cashGap'] = Util::fnPercent($items[$c-1]['debt'],$debt);

			}else{
				$info = sqlRow("select * from api_Financial_Statements_bs_quarterly where symbol='".$gbl_symbol."' and period<'".$sYear."' order by period desc limit 1");
				if($info){
					if($f_debt == 'short')			$tmpDebt = $info['shortTermDebt'];		//단기부채
					elseif($f_debt == 'long')		$tmpDebt = $info['longTermDebt'];		//장기부채
					elseif($f_debt == 'total')		$tmpDebt = $info['totalDebt'];			//총부채

					$items[$c]['cashGap'] = Util::fnPercent($tmpDebt,$debt);
				}
			}

			$c++;
		}


	//연간
	}elseif($f_type == 'year'){

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

			$c++;
		}



		//기업부채
		$row = sqlArray("select * from api_Financial_Statements_bs_annual where symbol='".$gbl_symbol."' and period>='".$sYear."' and period<='".$eYear."' order by period");

		$items = Array();
		$c = 0;

		foreach($row as $v){
			if($f_debt == 'short')			$debt = $v['shortTermDebt'];		//단기부채
			elseif($f_debt == 'long')		$debt = $v['longTermDebt'];		//장기부채
			elseif($f_debt == 'total')		$debt = $v['totalDebt'];				//총부채

			$items[$c]['date'] = date('Y.m',strtotime($v['period']));
			$items[$c]['debt'] = $debt;

			if($c > 0){
				//이전값 대비 퍼센트
				$items[$c]['cashGap'] = Util::fnPercent($items[$c-1]['debt'],$debt);

			}else{
				$info = sqlRow("select * from api_Financial_Statements_bs_annual where symbol='".$gbl_symbol."' and period<'".$sYear."' order by period desc limit 1");
				if($info){
					if($f_debt == 'short')			$tmpDebt = $info['shortTermDebt'];		//단기부채
					elseif($f_debt == 'long')		$tmpDebt = $info['longTermDebt'];		//장기부채
					elseif($f_debt == 'total')		$tmpDebt = $info['totalDebt'];			//총부채

					$items[$c]['cashGap'] = Util::fnPercent($tmpDebt,$debt);
				}
			}

			$c++;
		}
	}
?>

		<select name='f_period' id='f_period' onchange="$('#frm').submit();">
			<option value='1' <?if($f_period == '1'){echo 'selected';}?>>1년</option>
			<option value='3' <?if($f_period == '3'){echo 'selected';}?>>3년</option>
			<option value='5' <?if($f_period == '5'){echo 'selected';}?>>5년</option>
			<option value='10' <?if($f_period == '10'){echo 'selected';}?>>10년</option>
		</select>

		<select name='f_type' id='f_type' onchange="$('#frm').submit();">
			<option value='quarter' <?if($f_type == 'quarter'){echo 'selected';}?>>분기</option>
			<option value='year' <?if($f_type == 'year'){echo 'selected';}?>>연간</option>
		</select>

		<select name='f_debt' id='f_debt' onchange="$('#frm').submit();">
			<option value='short' <?if($f_debt == 'short'){echo 'selected';}?>>단기부채</option>
			<option value='long' <?if($f_debt == 'long'){echo 'selected';}?>>장기부채</option>
			<option value='total' <?if($f_debt == 'total'){echo 'selected';}?>>총부채</option>
		</select>

		<table cellpadding='0' cellspacing='0' border='0' width='100%' class='subtable'>
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
					<th>영업현금흐름</th>
				<?
					foreach($item as $v){
						$cashGap = $v['cashGap'];
						if($cashGap < 0)			$cashGapTxt = "(<span class='blue'>".$cashGap."%</span>)";
						elseif($cashGap > 0)	$cashGapTxt = "(<span class='red'>+".$cashGap."%</span>)";
						else							$cashGapTxt = '';
				?>
					<td><?=number_format($v['netOperatingCashFlow'])?> <?=$cashGapTxt?></td>
				<?
					}
				?>
				</tr>
				<tr>
					<th>기업부채</th>
				<?
					foreach($items as $v){
						$cashGap = $v['cashGap'];
						if($cashGap < 0)			$cashGapTxt = "(<span class='blue'>".$cashGap."%</span>)";
						elseif($cashGap > 0)	$cashGapTxt = "(<span class='red'>+".$cashGap."%</span>)";
						else							$cashGapTxt = '';
				?>
					<td><?=number_format($v['debt'])?> <?=$cashGapTxt?></td>
				<?
					}
				?>
				</tr>
			</tbody>
		</table>
	</div>
</div>

</form>

<?
	include '../footer.php';
?>