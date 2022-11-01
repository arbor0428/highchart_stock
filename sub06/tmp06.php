<?
	include '../header.php';

	$gbl_symbol = 'AAPL';
?>



<div id="sub_cont">
	<div class="inner">

<?
	//보유 주식수
	$share01 = sqlRowOne("select sum(share) from api_Ownership where symbol='".$gbl_symbol."'");					//주주(기관,내부자)
	$share02 = sqlRowOne("select sum(share) from api_Fund_Ownership where symbol='".$gbl_symbol."'");			//펀드, ETF 등
	$tmp03 = sqlRowOne("select shareOutstanding from api_Company_Profile where symbol='".$gbl_symbol."'");
	$shareTot = $tmp03 * 1000000;		//총 주식수
	$share03 = $shareTot - ($share01 + $share02);	//개인 투자자, 기타

	$sArr01 = Util::unitNum($share01);
	$sTxt01 = number_format($sArr01[0],2).$sArr01[1];

	$sArr02 = Util::unitNum($share02);
	$sTxt02 = number_format($sArr02[0],2).$sArr02[1];

	$sArr03 = Util::unitNum($share03);
	$sTxt03 = number_format($sArr03[0],2).$sArr03[1];

	$sArrTot = Util::unitNum($shareTot);
	$sTxtTot = number_format($sArrTot[0],2).$sArrTot[1];


	//시장가치
	$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$gbl_symbol."'");
	$value01 = $nowC * $share01;
	$value02 = $nowC * $share02;
	$value03 = $nowC * $share03;
	$valueTot = $nowC * $shareTot;

	$vArr01 = Util::unitNum($value01);
	$vTxt01 = number_format($vArr01[0],2).$vArr01[1];
	$won01 = $vArr01[0] * $exRate;
	$wTxt01 = Util::convertHan($won01,8,1);

	$vArr02 = Util::unitNum($value02);
	$vTxt02 = number_format($vArr02[0],2).$vArr02[1];
	$won02 = $vArr02[0] * $exRate;
	$wTxt02 = Util::convertHan($won02,8,1);

	$vArr03 = Util::unitNum($value03);
	$vTxt03 = number_format($vArr03[0],2).$vArr03[1];
	$won03 = $vArr03[0] * $exRate;
	$wTxt03 = Util::convertHan($won03,8,1);

	$vArrTot = Util::unitNum($valueTot);
	$vTxtTot = number_format($vArrTot[0],2).$vArrTot[1];
	$wonTot = $vArrTot[0] * $exRate;
	$wTxtTot = Util::convertHan($wonTot,8,1);


	//전체주식 대비 비중
	$per01 = Util::fnPercent2($vArrTot[0],$vArr01[0]);
	$per02 = Util::fnPercent2($vArrTot[0],$vArr02[0]);
	$per03 = Util::fnPercent2($vArrTot[0],$vArr03[0]);
?>
		<table cellpadding='0' cellspacing='0' border='0' width='100%' class='gTable'>
			<tr>
				<th>구분</th>
				<th>보유 주식수</th>
				<th>시장가치</th>
				<th>전제주식 대비 비중</th>
				<th>비율</th>
			</tr>
			<tr>
				<td title='구분'>주주(기관,내부자)</td>
				<td title='보유 주식수'><?=$sTxt01?> 주</td>
				<td title='시장가치'><?=$vTxt01?> 달러<br><?=$wTxt01?>원</td>
				<td title='전제주식 대비 비중'><?=$per01?>%</td>
				<td title='비율' rowspan='4'>
					그래프
				</td>
			</tr>
			<tr>
				<td title='구분'>펀드,ETF 등</td>
				<td title='보유 주식수'><?=$sTxt02?> 주</td>
				<td title='시장가치'><?=$vTxt02?> 달러<br><?=$wTxt02?>원</td>
				<td title='전제주식 대비 비중'><?=$per02?>%</td>
			</tr>
			<tr>
				<td title='구분'>개인 투자자, 기타</td>
				<td title='보유 주식수'><?=$sTxt03?> 주</td>
				<td title='시장가치'><?=$vTxt03?> 달러<br><?=$wTxt03?>원</td>
				<td title='전제주식 대비 비중'><?=$per03?>%</td>
			</tr>
			<tr>
				<td title='구분'>총합</td>
				<td title='보유 주식수'><?=$sTxtTot?> 주</td>
				<td title='시장가치'><?=$vTxtTot?> 달러<br><?=$wTxtTot?>원</td>
				<td title='전제주식 대비 비중'>100%</td>
			</tr>
		</table>
	</div>
</div>


<?
	include '../footer.php';
?>