<?
	$eDate = date('Y-m-d');
	$sDate = date('Y-m-d', strtotime('-1 month', strtotime($eDate)));
?>

			<div class="insider_searchBar">
				<input type="text" name="symbol" id="symbol" list="symbolList" placeholder="종목" onkeypress="if(event.keyCode==13){insiderData();}" style="text-transform: uppercase;">
				<datalist id="symbolList">
				<?
					foreach($slistArr as $v){
						echo "<option value='".$v['symbol']."'>".$v['symbol']."</option>";
					}
				?>
				</datalist>
				<input type="text" name="sDate" id="sDate" class='fpicker' value="<?=$sDate?>">
				<span style="display: block; line-height: 35px;">~</span>
				<input type="text" name="eDate" id="eDate" class='fpicker' value="<?=$eDate?>">
				<a class="insider_searchBtn" href="javascript:insiderData();">검색</a>
			<!--
				<a class="insider_addBtn" href="">내 관심종목 추가</a>
			-->
			</div>
			<div class="insider_searchTag">
			<!--
				<div class="searchTag"><span>AAPL</span><a class="minus" href="" title="제거">-</a></div>
				<div class="searchTag"><span>TSLA</span><a class="minus" href="" title="제거">-</a></div>
				<div class="searchTag"><span>JOBY</span><a class="minus" href="" title="제거">-</a></div>
			-->
			</div>

<script>
function insiderData(){
	symbol = $('#symbol').val();
	if(symbol == ''){
		GblMsgBox('종목을 입력해 주시기 바랍니다.','');
		return;
	}

	symbol = symbol.toUpperCase();		//입력한 티커를 대문자로..

	$(".searchTag").each(function() {
		s = $(this).children('span').text();
		if(s == symbol){
			GblMsgBox('중복된 종목입니다.','');
			symbol = '';
			return false;
		}
	});

	sDate = $('#sDate').val();
	eDate = $('#eDate').val();

	if(symbol && sDate && eDate){
		$.post('../module/json/insiderData.php',{'symbol':symbol,'sDate':sDate,'eDate':eDate}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("종목을 확인해 주시기 바랍니다.");
				return;

			}else if(code == '99'){
				$('#loading').show();
				s = parData['symbol'];
				arr = parData['insider'];
				if(arr){
					cName = 'symbol-'+s;	//삭제를 위한 클래스

					for(i=0; i<arr.length; i++){
						strHtml = "<tr class='"+cName+"'>";
						strHtml += "<td>"+arr[i]['name']+"</td>";
						strHtml += "<td>"+arr[i]['symbol']+"</td>";
						strHtml += "<td>"+arr[i]['share']+"</td>";
						strHtml += "<td>"+arr[i]['change']+"</td>";
						strHtml += "<td>"+arr[i]['transactionDate']+"</td>";
						strHtml += "<td>"+arr[i]['transactionPrice']+"</td>";
						strHtml += "<td>"+arr[i]['tradePrice']+"</td>";
						strHtml += "<td>"+arr[i]['marper']+"</td>";
						strHtml += "</tr>";
						$("#InnerTrade").append($(strHtml).fadeIn(200));
						$('#InnerTrade').trigger('update'); //append 할 때 tablesorter 플러그인 update 필요
					}
					
					symbolTag = "<div class='searchTag "+cName+"'><span>"+s+"</span><a class='minus' href='javascript://' title='"+cName+"'>-</a></div>";
					$(".insider_searchTag").append(symbolTag);

					$("#symbol").val('');

				}else{
					GblMsgBox("입력하신 종목의 데이터가 없습니다.","");
				}


				$("#loading").delay("200").fadeOut();

			}else{
				GblMsgBox("Error");
				return;
			}
		});	
	}
}

$(document).on('click', '.minus', function() {
	event.preventDefault();
	s = $(this).attr("title");
	$('.'+s).remove();
//	$(this).parent(".searchTag").hide();
});
</script>