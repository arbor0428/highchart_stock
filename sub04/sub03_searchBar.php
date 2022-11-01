<script>
function groupStockCheck(){
	groupStock = $('#groupStock').val();

	if(groupStock == ''){
		GblMsgBox("종목명을 입력해 주시기 바랍니다.");
		return;

	}else{
		document.frm_group.type.value = 'write';

		id = setTimeout(function(){
			var params = jQuery("#frm_group").serialize();
			jQuery.ajax({
				url: '/module/json/userGroupStock.php',
				type: 'POST',
				data:params,
				dataType: 'html',
				success: function(result){
					if(result){
						parData = JSON.parse(result);
						code = parData.code;

						if(code == '99'){
							uid = parData['uid'];
							gsNum = parData['gsNum'];
							symbol = parData['symbol'];

							$('#groupStock').val('');
							$('#groupStock').blur();
							$('#gsNum').text(gsNum);

							strHtml = "<tr id='groupList_"+uid+"'>";
							strHtml += "<td>"+symbol+"</td>";
							strHtml += "<td><input type='text' name='msg_"+uid+"' value='' class='msgData'></td>";
							strHtml += "<td>";
							strHtml += "<input type='hidden' name='chk[]' value='"+uid+"'>";
							strHtml += "<input type='text' name='per_"+uid+"' value='' class='perData'>%";
							strHtml += "<a class='delbtn' href=\"javascript:groupStockDel('"+uid+"')\" title='제거'>-</a>";
							strHtml += "</td>";
							strHtml += "</tr>";

							$("#stockTable").append(strHtml);

						}else if(code == '101'){
							GblMsgBox('일치하는 종목을 찾을 수 없습니다.');
							return;

						}else if(code == '102'){
							GblMsgBox('이미 추가된 종목입니다.');
							return;

						}else{
							GblMsgBox('반환값오류');
							return;
						}

					}else{
						GblMsgBox('반환값오류');
						return;
					}
				},
				error: function(error){
					GblMsgBox('통신오류');
					return;
				}
			});
		}, 100);
	}
}

$(document).on('change', '#groupStock', function(){
    var options = $('#groupStockList')[0].options;
    var val = $(this).val();
    for (var i=0;i<options.length;i++){
       if (options[i].value === val) {
          groupStockCheck();
          break;
       }
    }
});

function search_popup(p){
	act = '';
	if(p == 'stock')				act = 'search_screener.php';
	else if(p == 'dividend')	act = 'search_dividend.php';
	else if(p == 'etf')			act = 'search_etf.php';

	if(act){
		$("#titleBox").css({"width":"1380px"});
		$('#titleFrame').html("<iframe name='spop' id='spop' src='"+act+"' style='width:100%;height:650px;' frameborder='0' scrolling='auto'></iframe>");
		$('.titleBox_open').click();
	}
}
</script>

<div class="jongSearchWrap dp_sb">
	<div class="search30">
		<p class="searchTit">이미 알고 있는 종목이라면?</p>
		<div class="search_box">
			<input type="text" name="groupStock" id="groupStock" list='groupStockList' placeholder="종목을 검색하세요 (기업명, 주식, etf ticker)" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){groupStockCheck();}" autocomplete="off">
			<?
				$datalist_ID = 'groupStockList';
				include '/home/myss/www/module/dataList.php';
			?>
			<button type='button' onclick='wordCheck();'>
				<img src="/img/search_icon.png">
			</button>
		</div>
	</div>
	<div class="search30">
		<p class="searchTit">원하는 조건의 주식을 찾는다면?</p>
		<div class="btnWrap dp_f">
			<a class="blueBtn dp_f dp_c dp_cc" href="javascript:search_popup('stock');" title="주식 스크리너">주식 스크리너</a>
			<a class="blueBtn dp_f dp_c dp_cc" href="javascript:search_popup('dividend');" title="배당주 스크리너">배당주 스크리너</a>
		</div>
	</div>
	<div class="search30">
		<p class="searchTit">원하는 조건의 ETF를 찾고 있다면?</p>
		<div class="btnWrap dp_f">
			<a class="blueBtn dp_f dp_c dp_cc" href="javascript:search_popup('etf');" title="ETF 스크리너">ETF 스크리너</a>
		</div>
	</div>
</div>