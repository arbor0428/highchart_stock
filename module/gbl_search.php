<script>
function wordCheck(){
	gbl_word = $('#gbl_word').val();

	if(gbl_word){
		$.post('/module/json/wordSearch.php',{'gbl_word':gbl_word}, function(result){
			parData = JSON.parse(result);
			code = parData['code'];

			if(code == '101'){
				GblMsgBox("일치하는 종목을 찾을 수 없습니다.");
				return;

			}else if(code == '99'){
				url = parData['url'];
				location.href = url;

			}else{
				GblMsgBox("Error");
				return;
			}
		});	
	}
}

$(document).on('change', '#gbl_word', function(){
    var options = $('#gbl_wordList')[0].options;
    var val = $(this).val();
    for (var i=0;i<options.length;i++){
       if (options[i].value === val) {
          wordCheck();
          break;
       }
    }
});
</script>

<form name='frm_topSearch' id='frm_topSearch' method='post'>
<input type='text' style='display:none;'>
	<input type="text" name='gbl_word' id='gbl_word' list='gbl_wordList' placeholder="종목을 검색하세요 (기업명, 주식, etf ticker)" style="text-transform: uppercase;" onkeypress="if(event.keyCode==13){wordCheck();}" autocomplete="off">
	<?
		$datalist_ID = 'gbl_wordList';
		include '/home/myss/www/module/dataList.php';
	?>
	<button type='button' onclick='wordCheck();'>
		<img src="/img/search_icon.png">
	</button>
<!--
	<div class="showDown">
		<div class="item">hello<span class="searWord"></span></div>
		<div class="item">nice to meet<span class="searWord"></span></div>
		<div class="item">hello<span class="searWord"></span></div>
		<div class="item">nice to meet<span class="searWord"></span></div>
		<div class="item">hello<span class="searWord"></span></div>
		<div class="item">nice to meet<span class="searWord"></span></div>
	</div>
-->
</form>