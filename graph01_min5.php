<?
	include 'head2.php';
?>

<style>
.slick-prev.slick-disabled, .slick-next.slick-disabled {opacity: 0.5;}

.slick_box {margin: 0 10px;}

.top_bnr_slick {padding: 15px 0; width: 1220px !important; height: 160px; box-sizing: border-box;}

.chart_txt {margin-bottom: 20px; display: flex !important; justify-content: space-between;}
.chart_txt h4{margin-bottom: 5px; color: #0048df; font-size: 13px; font-weight: 600;}
.chart_txt p, span {font-size: 13px; font-weight: 500;}

.top_bnr_slick .slick-next:focus:before, .slick-next:hover:before, .slick-prev:focus:before, .top_bnr_slick  .slick-prev:hover:before {
	opacity: 0;
}
.top_bnr_slick  .slick-prev:before {
	content: '';
}
.top_bnr_slick  .slick-next:before {
	content: '';
}
.top_bnr_slick  .slick-prev,
.top_bnr_slick  .slick-next
{	
	width: 25px;
	height: 25px;
}
.top_bnr_slick  .slick-prev {
	background:url('./img/arrow_left.png') center no-repeat; 
	left: 1226px;
}
.top_bnr_slick  .slick-next {
	background:url('./img/arrow_right.png') center no-repeat; 
	right: -55px;
}

.top_bnr_slick  .slick-prev:hover,
.top_bnr_slick  .slick-prev:focus
{
	background:url('./img/arrow_left.png') center no-repeat; 
}
.top_bnr_slick  .slick-next:hover,
.top_bnr_slick  .slick-next:focus
{
	background:url('./img/arrow_right.png') center no-repeat; 
}
</style>


<div class="top_bnr_slick clearfix">

<?
$i = 1;

$tableName = $_GET['tableName'];
if(!$tableName)	$tableName = 'spec5StockCandle';


$etcSymbol = Array("^GSPC"=>"S&P 500", "^NDX"=>"nasdaq 100", "^DJI"=>"Dow Jones", "^RUT"=>"Russell 2000", "^VIX"=>"VIX","XLK"=>"XLK","XLV"=>"XLV","XLP"=>"XLP","XLU"=>"XLU","XLY"=>"XLY","XLC"=>"XLC","XLB"=>"XLB","XLF"=>"XLF","XLI"=>"XLI","XLE"=>"XLE","XLRE"=>"XLRE");

foreach($etcSymbol as $s => $t){
	$row = sqlArray("select * from (select * from api_Stock_Candles_D where symbol='".$s."' order by t desc limit 20) as a order by t asc");

	$rowCnt = count($row);
	$dataList = '';
	$xAxisList = '';
	$v = '';

	$lastData = sqlRow("select * from Stock_Candles_Last where symbol='".$s."'");

	foreach($row as $v){
		if($dataList){
			$dataList .= ",";
			$xAxisList .= ",";
		}

		$dataList .= $v['c'];								//그래프 value
		$xAxisList .= "'".date('n/d',$v['t'])."'";		//x축
	}

	//quote 또는 StockCandle 데이터를 21번째로 추가
	$tmpC = $v['c'];

	$v = sqlRow("select * from ".$tableName." where symbol='".$s."'");
	if($v){
		if($dataList){
			$dataList .= ",";
			$xAxisList .= ",";
		}

		$dataList .= $v['c'];
		$xAxisList .= "'".date('n/d',$v['t'])."'";

		$v['pmDataDay'] = Util::fnPercent($tmpC,$v['c']);		//증감률

		$rowCnt += 1;
	}


	//마지막 1번값 - 2번값
	$tmpData = $v['c'] - $row[$rowCnt-2]['c'];

	$udClass = UpDownClass($tmpData);
?>
	<div class="slick_box clearfix">
		<a class="mordalBtn" href="javascript:graph('<?=$s?>');" title="">
			<div class="chart_txt">
				<h4><?=$t?></h4>
				<div>
					<p><?=number_format($v['c'],2)?></p>
					<span class='<?=$udClass?>'><?=Util::nf1($tmpData,2)?> (<?=Util::nf1($v['pmDataDay'],2)?>%)</span>
				</div>
			</div>
			<div class="slick_chart">
				<div id="smallChart<?=$i?>" style="width: 100%; height: 80px;"></div>
			</div>
			<script>
					Highcharts.chart('smallChart<?=$i?>', {
						chart: {
							type: 'spline',
							width: 224,
							spacingTop: 0,
							spacingRight: 0,
							spacingLeft: 0
						},
						title: {
							text: ''
						},
						xAxis: {
							categories: [<?=$xAxisList?>],
							labels: {
								style: {
									fontSize: '7'
								}
							}
						},
						yAxis: {
							title: {
								text: ''
							},
							labels: {
								style: {
									fontSize: '6'
								}
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
					  exporting: {
						enabled: false
					  },
						credits: {
							 enabled: false
						},
						series: [{
							showInLegend: false,
							name: '',
							data: [<?=$dataList?>],
							color: '#f86a87',
							  marker: {
								enabled: true,
								radius: 0,
								symbol: 'dot'
							  }
						}]
					});
			</script>
		</a>
	</div>

<?
		$i++;
	}
?>


</div>


<script>
//slick 
$('.top_bnr_slick').slick({ 
	infinite: true,
	slidesToShow: 5, 
	slidesToScroll: 5, 
	arrows: true
});

function graph(s){
	parent.$("#graphListBox").css({"width":"90%","max-width":"900px"});
	parent.$('#graphList_ttl').text('test');
	parent.$('#graphListBoxFrame').html("<iframe src='graphFrame.php?gbl_symbol="+s+"' style='width:100%; height:500px;' frameborder='0' scrolling='auto'></iframe>");
	parent.$('.graphListBox_open').click();
}
</script>