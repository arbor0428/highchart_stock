<?
	if(!$mddEdate)		$mddEdate = date('Y-m-d');
	if(!$mddSdate)		$mddSdate = date('Y-m-d', strtotime('-1 year', strtotime($mddEdate)));

//	$mddEdate = date('2022-03-01');
//	$mddSdate = date('2011-01-01');

	$mddEtime = strtotime($mddEdate) + 86399;
	$mddStime = strtotime($mddSdate);

	$mddSymbol = 'AAPL';
	$mddTable = 'api_Stock_Candles_D';

	$mddQuery = "where symbol='".$mddSymbol."' and t>='".$mddStime."' and t<='".$mddEtime."'";

	//기간내 최고값(c) & 데이터 수
	$row = sqlRow("select max(c) as HighC, count(*) as rNum from $mddTable $mddQuery");
	$HighC = $row['HighC'];
	$rNum = $row['rNum'];

	//HighChart x축값이 최대 1,000개이기 때문에(Stock_Candles_W) 테이블 사용
	if($rNum > 1000){
		$mddTable = 'api_Stock_Candles_W';

		//기간내 최고값(c) & 데이터 수
		$row = sqlRow("select max(c) as HighC, count(*) as rNum from $mddTable $mddQuery");
		$HighC = $row['HighC'];
		$rNum = $row['rNum'];
	}

	//최신값(c)
	$nowC = sqlRowOne("select c from Stock_Candles_Last where symbol='".$mddSymbol."'");

	//고점대비 하락률
	$nowPer = Util::fnPercent($HighC,$nowC);

	//상승확률(최신값(c) 보다 큰(c)값의 일수)
	$upDay = sqlRowOne("select count(*) from $mddTable $mddQuery and c>='".$nowC."'");
	$upPer = round(($upDay / $rNum) * 100,2);

//	echo $rNum.' / '.$upDay;


	//기간내 최저값(c) & 일자
	$minData = sqlRow("select * from $mddTable $mddQuery order by c asc limit 1");
	$LowC = $minData['c'];
	$LowT = $minData['t'];

	//최대낙폭
	$MaxPer = Util::fnPercent($HighC,$LowC);
?>


				<div class="mdd_box">
					<table class="tiker" id='mddTable'>
						<colgroup>
							<col style="width:12.5%;"></col>
							<col style="width:12.5%;"></col>
							<col style="width:12.5%;"></col>
							<col style="width:12.5%;"></col>
							<col style="width:12.5%;"></col>
							<col style="width:12.5%;"></col>
							<col style="width:12.5%;"></col>
							<col style="width:12.5%;"></col>
						</colgroup>
						<tbody>
							<tr>
								<th>티커</th>
								<th>From</th>
								<th>To</th>
								<th>현재주가</th>
								<th>고점대비<br>하락률</th>
								<th>상승확률</th>
								<th>최대낙폭일</th>
								<th>최대낙폭(MDD)</th>
							</tr>
							<tr id='mddTr1' style="background-color:rgb(255,196,208,0.7);">
								<td><?=$mddSymbol?></td>
								<td><?=date('Y/m/d',$mddStime)?></td>
								<td><?=date('Y/m/d',$mddEtime)?></td>
								<td><?=number_format($nowC,2)?></td>
								<td><?=$nowPer?>%</td>
								<td><?=$upPer?>%</td>
								<td><?=date('Y/m/d',$LowT)?></td>
								<td><?=$MaxPer?>%</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="mdd_box">
					<div class="jm_search">
						<div class="search_bar">
							<input type="text" name="mddSymbol" id="mddSymbol" value="" placeholder="이 종목 지금 사도될까? 종목을 검색하세요" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){mddChk();}">
							<a class="search_icon" href="javascript:mddChk();"><img src="./img/search_icon.png"></a>
						</div>
						<p id='mddMsg1' class='mddMsg'>* 현재 주가는 전고점대비 <span class="blue"><?=$nowPer?>%</span>이고, 과거 데이터를 기반으로<br>보았을 때 상승확률은 <span class="red"><?=$upPer?>%</span>입니다.</p>
					</div>
				</div>


<script>
function mddChk(){
	symbol = $('#mddSymbol').val().toUpperCase();
	if(symbol){
		$.post('./module/mddData.php',{'symbol':symbol,'mddStime':'<?=$mddStime?>','mddEtime':'<?=$mddEtime?>'}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("No Data");

			}else if(code == '99'){
				mddAdd(parData);

			}else{
				GblMsgBox("Error");
			}
		});	
	}
}

function mddAdd(parData){
	listNum = $("#mddTable tr").length;

	if(listNum > 3){
		GblMsgBox("최대 3개까지 확인이 가능합니다.",'');
		return;

	}else{
		//테이블 배경색
		trArr = new Array('','255,196,208,0.7','198,232,255,0.7','207,255,228,0.7');	//빨,파,초

		//그래프 색상
		lineArr = new Array('','#f86a87','#7cb5ec','#4bc0c0');	//빨,파,초
		bgArr = new Array('','248,106,135,0.7','57,161,232,0.7','64,255,149,0.7');	//빨,파,초

		for(i=1; i<=3; i++){
			if($("#mddTr"+i).length == 0){

				trColor = trArr[i];

				//테이블(티커, From ~ 최대낙폭) 추가
				strHtml = "<tr id='mddTr"+i+"' style='background-color:rgb("+trColor+");'>";
				strHtml += "<td>"+parData['symbol']+"</td>";
				strHtml += "<td><?=date('Y/m/d',$mddStime)?></td>";
				strHtml += "<td><?=date('Y/m/d',$mddEtime)?></td>";
				strHtml += "<td>"+parData['nowC']+"</td>";
				strHtml += "<td>"+parData['nowPer']+"%</td>";
				strHtml += "<td>"+parData['upPer']+"%</td>";
				strHtml += "<td>"+parData['LowT']+"</td>";
				strHtml += "<td>"+parData['MaxPer']+"%</td>";
				strHtml += "</tr>";
				$("#mddTable").append($(strHtml).fadeIn(200));

				strHtml = "<p id='mddMsg"+i+"' class='mddMsg'>* 현재 주가는 전고점대비 <span class='blue'>"+parData['nowPer']+"%</span>이고, 과거 데이터를 기반으로<br>보았을 때 상승확률은 <span class='red'>"+parData['upPer']+"%</span>입니다.</p>";
				$(".jm_search").append($(strHtml).fadeIn(200));


				lineColor = lineArr[i];
				bgColor = bgArr[i];

				//MDD 차트 추가(mddChart01.php)
				mdd = parData['cData01'].split(',');
				mddx = parData['cData01x'].split(',');

				let mddData = [];
				for (let i = 0; i < mdd.length; i++) {
					str = mddx[i];
					strArr = str.split('-');
					xData = new Date(strArr[0], strArr[1]-1, strArr[2]);

					mddprev = parseFloat(mdd[i]);
					mddData.push({x: xData, y: mddprev});
				}

				chart01 = $('#mddCompare').highcharts();
				chart01.addSeries({
					type: 'area',
					name: symbol,
					data: mddData, 
					color:lineColor,
					fillColor: {
						linearGradient: {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops: [
							[0, 'rgb('+bgColor+')'],
							[1, 'rgb(255,255,255,0.5)']
						]
					}
				});


				//상승확률 그래프 추가(mddChart02.php)
				hpp = parData['cData02'].split(',');

				let hppData = [];
				for (let i = 0; i < hpp.length; i++) {
				  hppprev = parseFloat(hpp[i]);
				  hppData.push({x: i, y: hppprev});
				}

				chart02 = $('#applCompare').highcharts();
				chart02.addSeries({
					name: symbol,
					data: hppData, 
					color:lineColor,
					marker: {
						enabled: true,
						radius: 3,
						symbol: 'dot'
					}
				});

				return;
			}
		}
	}
}

function mddDel(n){
	$("#add"+n).fadeOut(100, function() {
		$(this).remove();
	});	
}
</script>