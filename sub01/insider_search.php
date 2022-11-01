<?
	if($f_symbol)	$f_symbol = strtoupper($f_symbol);

	if(!$f_eDate)	$f_eDate = date('Y-m-d');
	if(!$f_sDate)	$f_sDate = date('Y-m-d', strtotime('-1 month', strtotime($f_eDate)));

	if(!$f_sortItem)		$f_sortItem = 'symbol';
	if(!$f_sortType)	$f_sortType = 'asc';


	//쿼리에 사용할 심볼목록
	$f_sTxt = '';
?>

<form name='frm_insider' id='frm_insider' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type="text" style="display: none;">  <!-- 텍스트박스 1개이상 처리.. 자동전송방지 -->
<input type='hidden' name='type' value=''>
<input type='hidden' name='record_count' value='<?=$record_count?>'>
<input type='hidden' name='record_start' value='<?=$record_start?>'>
<input type='hidden' name='next_url' value="<?=$_SERVER['PHP_SELF']?>">
<input type='hidden' name='f_sortItem' value='<?=$f_sortItem?>'>
<input type='hidden' name='f_sortType' value='<?=$f_sortType?>'>
<input type='hidden' name='gbl_symbol' value='<?=$gbl_symbol?>'>
<input type='hidden' name='insiderChk' value='1'><!-- 주식개별페이지에서 스크롤용 -->

			<div class="insider_searchBar">
				<input type="text" name="f_symbol" id="f_symbol" list="f_symbolList" placeholder="종목" onkeypress="if(event.keyCode==13){insiderData();}" style="text-transform: uppercase;">
				<?
					$datalist_ID = 'f_symbolList';
					include '../module/dataList.php';
				?>

				<input type="text" name="f_sDate" id="f_sDate" class='fpicker' value="<?=$f_sDate?>">
				<span style="display: block; line-height: 35px;">~</span>
				<input type="text" name="f_eDate" id="f_eDate" class='fpicker' value="<?=$f_eDate?>">
				<a class="insider_searchBtn" href="javascript:insiderData();">검색</a>
			<!--
				<a class="insider_addBtn" href="">내 관심종목 추가</a>
			-->
			</div>
			<div class="insider_searchTag">
			<?
				//기존에 추가된 심볼
				foreach($f_slist as $v){
					if($f_sTxt)	$f_sTxt .= ",";
					$f_sTxt .= "'".$v."'";
			?>
				<div class='searchTag symbol-<?=$v?>'>
					<span><?=$v?></span>
					<a class='minus' href='javascript://' title='symbol-<?=$v?>'>-</a>
					<input type='hidden' name='f_slist[]' value="<?=$v?>">
				</div>
			<?
				}
			?>

			<?
				//신규로 추가한 심볼
				if($f_symbol){
					if($f_sTxt)	$f_sTxt .= ",";
					$f_sTxt .= "'".$f_symbol."'";
			?>
				<div class='searchTag symbol-<?=$f_symbol?>'>
					<span><?=$f_symbol?></span>
					<a class='minus' href='javascript://' title='symbol-<?=$f_symbol?>'>-</a>
					<input type='hidden' name='f_slist[]' value="<?=$f_symbol?>">
				</div>
			<?
				}
			?>
			</div>

<input type='hidden' name='f_sTxt' id='f_sTxt' value="<?=$f_sTxt?>">



<script>
function insiderData(){
	form = document.frm_insider;

	f_symbol = $('#f_symbol').val();
	f_sTxt = $('#f_sTxt').val();

	//날짜만 변경해서 검색을 다시 하는 경우
	if(f_symbol == '' && f_sTxt){
		form.record_start.value = 0;
		form.submit();

	}else{
		if(isFrmEmptyModal(form.f_symbol,"종목을 입력해 주십시오."))	return;

		symbol = $('#f_symbol').val().toUpperCase();		//입력한 티커를 대문자로..
		sChk = true;

		$(".searchTag").each(function() {
			s = $(this).children('span').text();
			if(s == symbol){
				GblMsgBox('중복된 종목입니다.','');
				sChk = false;
				return false;
			}
		});

		if(sChk){
			$.post('../module/json/symbolChk.php',{'symbol':symbol}, function(result){
				parData = JSON.parse(result);
				code = parData['code'];

				if(code == '101'){
					GblMsgBox("종목을 확인해 주시기 바랍니다.");
					return;

				}else if(code == '99'){
					form.record_start.value = 0;
					form.submit();

				}else{
					GblMsgBox("Error");
					return;
				}
			});	

		}
	}
}

$(document).on('click', '.minus', function() {
	event.preventDefault();
	s = $(this).attr("title");
	$('.'+s).remove();

	$('#f_symbol').val('');

	form = document.frm_insider;
	form.record_start.value = 0;
	form.submit();
});
</script>