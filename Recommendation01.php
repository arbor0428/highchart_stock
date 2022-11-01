<?
$row = recomData($recomSymbol);

if($row){
	$strongSell = $row["strongSell"];		//강력매도
	$sell = $row["sell"];						//매도
	$hold = $row["hold"];					//중립
	$buy = $row["buy"];						//매수
	$strongBuy = $row["strongBuy"];	//강력매수
	$companyName = $row["name"];	//회사명
	$totNum = $row['totNum'];
	$totScore = $row['totScore'];
	$investment = $row['investment'];
	$pieColor = $row['pieColor'];
	$pieData = $row['pieData'];

	$targetMean = $row['targetMean'];
	$targetHigh = $row['targetHigh'];
	$targetLow = $row['targetLow'];
	$targetPer = $row['targetPer'];

	//그래프 데이터(graph10.php)
	$cateList = $row['cateList'];	//x축
	$dataList = $row['dataList'];	//Average
	$LowList = $row['LowList'];	//Lowest(마지막 2개값만 표시)
	$HighList = $row['HighList'];	//Highest(마지막 2개값만 표시)
?>
					<div class="ora_line"></div>					
					<h3>
						<p id="recomSymbolTxt"><?=$recomSymbol?> (<?=$companyName?>)</p>
						<span id="totalScoreTxt"><?=$totScore?></span> / 5.0 <span id="investTxt"><?=$investment?></span>
					</h3>
					<?
						include 'graph09.php';
					?>
					<ul class="targ_label">
						<li>
							<div class="line"></div>
							<span>강력매도 (<span id="strongSellTxt"><?=$strongSell?></span>)</span>
						</li>
						<li>
							<div class="line"></div>
							<span>매도 (<span id="sellTxt"><?=$sell?></span>)</span>
						</li>
						<li>
							<div class="line"></div>
							<span>중립 (<span id="holdTxt"><?=$hold?></span>)</span>
						</li>
						<li>
							<div class="line"></div>
							<span>매수 (<span id="buyTxt"><?=$buy?></span>)</span>
						</li>
						<li>
							<div class="line"></div>
							<span>강력매수 (<span id="strongBuyTxt"><?=$strongBuy?></span>)</span>
						</li>
					</ul>
					<div class="targ_bottom">
						<p>
							<span><span id="periodTxt"><?=$row['period']?></span>을 기준으로</span> <span class="companyNameTxt"><?=$companyName?></span>에 대해<br>
							<span>투자의견을 낸 <span class="totNumTxt"><?=number_format($totNum)?></span>명</span>의 애널리스트의 평가입니다.
						</p>
					</div>




<script>
//심볼 데이터 호출
function recomData(){
	symbol = $('#recomSymbol').val();

	if(symbol){
		$.post('./module/json/recomData.php',{'symbol':symbol}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("종목을 확인해 주시기 바랍니다.");
				return;

			}else if(code == '99'){
				//기존 파이 그래프 삭제
				chart01 = $('#investGraph').highcharts();
				chart01.series[0].remove();

				pieColor = parData['pieColor'];
				pieData = parData['pieData'];

				Highcharts.chart('investGraph', {
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						type: 'pie'
					},
					title: {
						text: ''
					},
					plotOptions: {
						pie: {
							innerSize: '50%',
							colors: pieColor,
							allowPointSelect: false,
							cursor: 'pointer',
							dataLabels: {
								distance: -30,
								format: '{y}%',
								color: '#fff',
								style: {
									fontSize:'16',
									fontWeight: 'bold',
									textOutline: 'none'
								}
							}
						}
					},
					exporting: {
						enabled: false
					},
					credits: {
						enabled: false
					},
					series: [{
						data: pieData
					}]
				});

				//기존 라인 그래프 삭제
				chart02 = $('#priceTargetGraph').highcharts();
				seriesLength = chart02.series.length;
				for(i = seriesLength -1; i > -1; i--) {
					chart02.series[i].remove();
				}

				cateList = new Array();
				tmpArr = parData['cateList'].split(',');
				for(i=0; i<tmpArr.length; i++){
					cateList[i] = tmpArr[i].replaceAll("'",'');
				}

				dataList = new Array();
				tmpArr = parData['dataList'].split(',');
				for(i=0; i<tmpArr.length; i++){
					dataList[i] = parseFloat(tmpArr[i]);
				}

				LowList = new Array();
				tmpArr = parData['LowList'].split(',');
				for(i=0; i<tmpArr.length; i++){
					LowList[i] = parseFloat(tmpArr[i]);
				}

				HighList = new Array();
				tmpArr = parData['HighList'].split(',');
				for(i=0; i<tmpArr.length; i++){
					HighList[i] = parseFloat(tmpArr[i]);
				}



				Highcharts.chart('priceTargetGraph', {
					chart: {
						type:'line',
					},
					title: {
						text: ''
					},
					xAxis: {
						categories: cateList
					},
					yAxis: {
						title: {
							text: ''
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					legend: {
						enabled: false
					},
					credits: {
						 enabled: false
					},
				  exporting: {
					enabled: false
				  },
					series: [{
						showInLegend: false,
						name: 'Lowest ',
						data: LowList,
						color: '#39a1e8',
						  marker: {
							enabled: true,
							radius: 3,
							symbol: 'dot'
						  }
					}, {
						name: 'Highest',
						data: HighList,
						color: '#4bc0c0',
						  marker: {
							enabled: true,
							radius: 3,
							symbol: 'dot'
						  }
					}, {
						name: 'Average',
						data: dataList,
						color: '#f86a87',
						  marker: {
							enabled: true,
							radius: 3,
							symbol: 'dot'
						  }
					}]
				});

				$('#recomSymbolTxt').text(parData['symbol']+' ('+parData['name']+')');
				$('#totalScoreTxt').text(parData['totScore']);
				$('#investTxt').text(parData['investment']);				
				$('#strongSellTxt').text(parData['strongSell']);
				$('#sellTxt').text(parData['sell']);
				$('#holdTxt').text(parData['hold']);
				$('#buyTxt').text(parData['buy']);
				$('#strongBuyTxt').text(parData['strongBuy']);

				$('#periodTxt').text(parData['period']);
				$('.companyNameTxt').text(parData['name']);
				$('.totNumTxt').text(parData['totNum']);

				$('.targetMeanTxt').text(parData['targetMean']);
				$('.targetHighTxt').text(parData['targetHigh']);
				$('.targetLowTxt').text(parData['targetLow']);
				$('.targetPerTxt').text(parData['targetPer']);

				$('#recomSymbol').blur();

			}else{
				GblMsgBox("Error");
				return;
			}
		});	
	}
}
</script>

<?
}else{
	echo "<div style='width:100%;height:300px;text-align:center;line-height:300px;'>전문가 분석정보가 없습니다.</div>";
}
?>