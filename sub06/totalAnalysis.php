<div class="ticker_section">
	<?
		//그래프 & 이것만은 꼭 기업하세요!
		include 'stockChart.php';

		//description & 고평가/저평가...확인해 보셨나요? & 성장하고 있는 기업인가요? & 이익을 내고 있는 기업인가요? & 배당금을 주는 기업인가요?
		include 'reputation.php';

		//한눈에 분석이 되는 체크리스트
		include 'checkList.php';

		//피어그룹
		include 'peerGroup.php';
	?>


	<div id='etfGroup'>
		<?
			//연관 ETF
			include 'relationEtf.php';
		?>
	</div>

	<div id='detailGraph' style='margin:100px 0;'>		
	<?
		//Historical Market Cap
		include 'Detailgraph.php';
	?>
	</div>

</div>