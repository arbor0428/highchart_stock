<?
	include 'head2.php';
	include './module/loading2.php';

	if(!$newsSymbol)	$newsSymbol = 'AAPL';
	$newEdate = date('Y-m-d');
	$newSdate = date('Y-m-d', strtotime('-10 day', strtotime($newEdate)));

    $finnhub = "https://finnhub.io/api/v1/company-news";
    $param = "?symbol=".$newsSymbol."&from=".$newSdate."&to=".$newEdate;

    //API 호출
    include './module/apiCall.php';

    $itemTmp = json_decode($req,JSON_UNESCAPED_UNICODE);
	$totCnt = count($itemTmp);
?>
					<!--
						<div class="search_box clearfix">
							<input type="text" name="newsSymbol" id="newsSymbol" value="<?=$newsSymbol?>">
							<button style="cursor:pointer;">
								<img src="./img/search_icon.png">
							</button>
						</div>
					-->

						<div class="board_wrap">
						<?
							if($totCnt){
								$i = 1;
								foreach($itemTmp as $item){
						?>
							<div class="row">
								<div class="sum_img">
									<img src="<?=$item['image']?>" onerror="this.style.display='none'">
								</div>
								<div class="b_title">
									<a href="javascript:newsSummary(<?=$i?>);"><?=$item['headline']?></a>
								</div>
								<div class="time"><?=date('Y-m-d',$item['datetime'])?></div>
							</div>

							<div style="display:none;">
								<span id="headline-<?=$i?>"><?=$item['headline']?></span>
								<span id="image-<?=$i?>"><?=$item['image']?></span>
								<span id="summary-<?=$i?>"><?=$item['summary']?></span>
								<span id="datetime-<?=$i?>"><?=date('Y-m-d H:i:s',$item['datetime'])?></span>
								<span id="url-<?=$i?>"><?=$item['url']?></span>
							</div>

						<?
									if($i == 10)	break;
									$i++;
								}
							}
						?>
						</div>

						<div class="clearfix">
							<a class="more_btn" href="javascript:newsList();" title="더 많은 뉴스보기" style="margin-top:15px; float:right;">
								<span>더 많은 뉴스보기</span>
								<span class="lnr lnr-chevron-right"></span>
							</a>
						</div>
<style>
.board_wrap {margin-top: 23px;}
.board_wrap .row {padding: 10px 10px; border-bottom: 1px solid #d1d1d1; display: flex; justify-content: space-between;}
.board_wrap .row:last-child {border-bottom: none;}
.board_wrap .row .sum_img {position:relative; margin-right: 20px; border-radius: 50%; width: 48px; height: 48px; background-color: #000; overflow:hidden; text-align: center;}
.board_wrap .row .sum_img > img {position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%); height:100%;}
.board_wrap .row .b_title {margin-right: 52px; width:350px; line-height: 48px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; font-size: 18px; font-weight: 600;}
.board_wrap .row .time {line-height: 48px; color: #666666;}
</style>

<script>
function newsSummary(i){
	parent.$("#newsConsBox").css({"width":"90%","max-width":"650px"});
	parent.$('#newsCons_ttl').text("<?=$newsSymbol?>");

	headline = $('#headline-'+i).text();
	image = $('#image-'+i).text();
	summary = $('#summary-'+i).text();
	datetime = $('#datetime-'+i).text();
	url = $('#url-'+i).text();

	strHtml = "<table cellpadding='0' cellspacing='0' border='0' width='100%' class='gTable' style='margin-bottom:10px;'>";
	strHtml += "<colgroup>";
	strHtml += "<col style='width:25%;'>";
	strHtml += "<col style='width:75%;'>";
	strHtml += "</colgroup>";
	strHtml += "<tr>";
	strHtml += "<th>headline</th>";
	strHtml += "<td>"+headline+"</td>";
	strHtml += "</tr>";
	strHtml += "<tr>";
	strHtml += "<th>image</th>";
	strHtml += "<td><img src='"+image+"' style='max-width:100px;' onerror=\"this.style.display='none'\"></td>";
	strHtml += "</tr>";
	strHtml += "<tr>";
	strHtml += "<th>summary</th>";
	strHtml += "<td>"+summary+"</td>";
	strHtml += "</tr>";
	strHtml += "<tr>";
	strHtml += "<th>datetime</th>";
	strHtml += "<td>"+datetime+"</td>";
	strHtml += "</tr>";
	strHtml += "</table>";

	strHtml += "<a href='"+url+"' target='_blank' class='small cbtn black'>원문보기</a>";

	parent.$('#newsConsFrame').html(strHtml);
	parent.$('.newsConsBox_open').click();
}

function newsList(){
	parent.$("#newsListBox").css({"width":"90%","max-width":"700px"});
	parent.$('#newsList_ttl').text("<?=$newsSymbol?>");
	parent.$('#newsListFrame').html("<iframe name='newsList' id='newsList' src='CompanyNewsList.php' style='width:100%;height:600px;' frameborder='0' scrolling='auto'></iframe>");
	parent.$('.newsListBox_open').click();
}
</script>