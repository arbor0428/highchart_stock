<?
	include '../header.php';
?>



<div id="sub_cont">
	<div class="sub_center">
	<?
		//종목 비중별 수익률 계산
		$myArr = Array("AAPL"=>"40","TSLA"=>"60");
		$revenue6m = 0;
		$revenue1y = 0;
		$revenue5y = 0;
		$dividend = 0;

		foreach($myArr as $k => $v){
			$row = sqlRow("select * from Stock_Candles_Last where symbol='".$k."'");

			$tmp6m = ($row['pmDataMonth6'] / 100) * $v;		//6개월 수익률
			$tmp1y = ($row['pmDataYear1'] / 100) * $v;		//1년 수익률
			$tmp5y = ($row['pmDataYear5'] / 100) * $v;		//5년 수익률

			$revenue6m += $tmp6m;
			$revenue1y += $tmp1y;
			$revenue5y += $tmp5y;

			$currentDividendYieldTTM = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$k."'");
			$tmpDividend = ($currentDividendYieldTTM / 100) * $v;		//배당률(현재)

			echo $tmpDividend.'<br>';

			$dividend += $tmpDividend;
		}

		echo $revenue6m.' / '.$revenue1y.' / '.$revenue5y.' / '.$dividend;
	?>
	</div>
</div>

<?
	include '../footer.php';
?>

