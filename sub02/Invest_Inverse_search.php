<script>
function investChk(){
	form = document.frm_invest;
//	if(isFrmEmptyModal(form.f_invest,"검색어를 입력해 주십시오."))	return;
	form.record_start.value = 0;
	form.submit();
}

$(function(){
	$('.fxType').click(function(){
		c = $(this).is(":checked");
		d = $(this).attr('id');

		if(c){
			$('.fxType').each(function(){
				if($(this).attr('id') != d){
					$(this).prop('checked', false);
				}
			});
		}		
	});
});
</script>
<form name='frm_invest' id='frm_invest' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type="text" style="display: none;">  <!-- 텍스트박스 1개이상 처리.. 자동전송방지 -->
<input type='hidden' name='type' value=''>
<input type='hidden' name='record_start' value='<?=$record_start?>'>
<input type='hidden' name='next_url' value="<?=$_SERVER['PHP_SELF']?>">

	<h3>관심 투자자산을 검색하세요!</h3>
	<img class="searchIcon" src="/img/no-resualt.png" alt="투자자산">
	<div class="search_box">
		<input type="text" name="f_invest" id="f_invest" list="investList" value="<?=$f_invest?>" placeholder="부동산 (Real Estate)" autocomplete="off" onkeypress="if(event.keyCode==13){investChk();}">
		<button type='button' onclick='investChk();'>
			<img src="/img/lnr-magnifier.png">
		</button>
		<datalist id="investList">
		<?
			$uArr = sqlArray("select distinct(investmentSegment) from api_ETFs_Profile order by investmentSegment");
			foreach($uArr as $k => $v){
		?>
			<option value="<?=$v['investmentSegment']?>"><?=$v['investmentSegment']?></option>
		<?
			}
		?>
		</datalist>
	</div>
	<div class="chkBox_wrap">
		<div class="chkBox">
			<input type="checkbox" name="fxType" id="f_x2" class='fxType' value="x2" <?if($fxType == 'x2'){echo 'checked';}?>>
			<label for="f_x2">2X</label>
		</div>
		<div class="chkBox">
			<input type="checkbox" name="fxType" id="f_x3" class='fxType' value="x3" <?if($fxType == 'x3'){echo 'checked';}?>>
			<label for="f_x3">3X</label>
		</div>
		<div class="chkBox">
			<input type="checkbox" name="fxType" id="f_inverse" class='fxType' value="inverse" <?if($fxType == 'inverse'){echo 'checked';}?>>
			<label for="f_inverse">인버스</label>
		</div>
		<div class="chkBox">
			<input type="checkbox" name="fxType" id="f_x2_inverse" class='fxType' value="x2_inverse" <?if($fxType == 'x2_inverse'){echo 'checked';}?>>
			<label for="f_x2_inverse">2X인버스</label>
		</div>
		<div class="chkBox">
			<input type="checkbox" name="fxType" id="f_x3_inverse" class='fxType' value="x3_inverse" <?if($fxType == 'x3_inverse'){echo 'checked';}?>>
			<label for="f_x3_inverse">3X인버스</label>
		</div>
	</div>

</form>