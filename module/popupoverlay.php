<!-- 알림 메세지 -->
<a id="GblNotice_open" class="GblNotice_open"></a>

<div id="GblNotice" class="popup_background" style="min-width:250px;display:none;">
	<div class="cls_buttonali2" id="alertCloseBtn"><button class="GblNotice_close close_button_pop"></button></div>
	<div class="popup_notice">
		<div class="clearfix"><div class="img_clear"><img src="/module/popupoverlay/ico_notice.gif"></div><div class="pop_ttl0">알림</div></div>
		<div class="pop_div_dotted"></div>
		<div class="write_it"><span id="alertTxt" class="txt_bold"></span></div>
		<div class="btn_ali_pop2" id="alertBtn"><input type="button" class="btn_notice_reg GblNotice_close" value="확인" /></div>
	</div>
</div>

<!-- confirm창 -->
<a id="conFirm_open" class="conFirm_open"></a>
<div id="conFirm" class="popup_background" style="min-width:250px;display:none;">
	<div class="cls_buttonali2"><button class="conFirm_close close_button_pop"></button></div>
	<div class="popup_notice">
		<div class="clearfix"><div class="img_clear"><img src="/module/popupoverlay/ico_notice.gif"></div><div class="pop_ttl0">확인</div></div>
		<div class="pop_div_dotted"></div>
		<div class="write_it"><span id="confirmTxt" class="txt_bold"></span></div>
		<a class="conFirm_close" href="#">
			<div class="btn2_wrap">
				<div class="btn_ali_pop3" id="confirmCancelBtn"><input type="button" class="btn_notice_reg_cancel" value="취소" /></div>
				<div class="btn_ali_pop3" id="confirmBtn"><input type="button" class="btn_notice_reg_add" value="확인"></div>
			</div>
		</a>
	</div>
</div>


<a id="titleBox_open" class="titleBox_open"></a>
<div id="titleBox" class="popup_background" style="min-width:250px;display:none;">
	<div class="popup_notice">
		<div class="clearfix">
			<div class="img_clear"><img src="/module/popupoverlay/ico_notice.gif"></div>
			<div class="pop_ttl0" id='title_ttl'>팝업제목</div>
			<div class="cls_buttonali"><button class="titleBox_close close_button_pop"></button></div>
		</div>
		<div class="pop_div_dotted"></div>
		<div class="write_it">
			<div id='titleFrame' style="background:#fff;overflow:hidden;position:relative;"></div>
		</div>
	</div>
</div>

<a id="multiBox_open" class="multiBox_open"></a>
<div id="multiBox" class="popup_background" style="min-width:250px;display:none;">
	<div class="popup_notice">
		<div class="clearfix"><div class="img_clear"><img src="/module/popupoverlay/ico_notice.gif"></div><div class="pop_ttl0" id='multi_ttl'>팝업제목</div><div class="cls_buttonali2"><button class="multiBox_close close_button_pop"></button></div></div>
		<div class="pop_div_dotted"></div>
		<div class="write_it">
			<div id='multiFrame' style="background:#fff;overflow:hidden;position:relative;"></div>
		</div>
	</div>
</div>

<a id="newsConsBox_open" class="newsConsBox_open"></a>
<div id="newsConsBox" class="popup_background" style="min-width:250px;display:none;">
	<div class="popup_notice">
		<div class="clearfix"><div class="img_clear"><img src="/module/popupoverlay/ico_notice.gif"></div><div class="pop_ttl0" id='newsCons_ttl'>팝업제목</div><div class="cls_buttonali2"><button class="newsConsBox_close close_button_pop"></button></div></div>
		<div class="pop_div_dotted"></div>
		<div class="write_it">
			<div id='newsConsFrame' style="background:#fff;overflow:hidden;position:relative;"></div>
		</div>
	</div>
</div>


<a id="newsListBox_open" class="newsListBox_open"></a>
<div id="newsListBox" class="popup_background" style="min-width:250px;display:none;">
	<div class="popup_notice">
		<div class="clearfix"><div class="img_clear"><img src="/module/popupoverlay/ico_notice.gif"></div><div class="pop_ttl0" id='newsList_ttl'>팝업제목</div><div class="cls_buttonali2"><button class="newsListBox_close close_button_pop"></button></div></div>
		<div class="pop_div_dotted"></div>
		<div class="write_it">
			<div id='newsListFrame' style="background:#fff;overflow:hidden;position:relative;"></div>
		</div>
	</div>
</div>

<a id="graphListBox_open" class="graphListBox_open"></a>
<div id="graphListBox" class="popup_background" style="min-width:250px;display:none;">
	<div class="popup_notice">
		<div class="clearfix"><div class="img_clear"><img src="/module/popupoverlay/ico_notice.gif"></div><div class="pop_ttl0" id='graphList_ttl'>팝업제목</div><div class="cls_buttonali2"><button class="graphListBox_close close_button_pop"></button></div></div>
		<div class="pop_div_dotted"></div>
		<div class="write_it">
			<div id='graphListBoxFrame' style="background:#fff;overflow:hidden;position:relative;"></div>
		</div>
	</div>
</div>

<a id="calEditMemo_open" class="calEditMemo_open"></a>
<div id="calEditMemo" class="popup_background" style="min-width:250px;display:none;">
	<div class="popup_notice">
		<div class="clearfix"><div class="img_clear"><img src="/module/popupoverlay/ico_notice.gif"></div><div class="pop_ttl0" id='graphList_ttl'>팝업제목</div><div class="cls_buttonali2"><button class="calEditMemo_close close_button_pop"></button></div></div>
		<div class="pop_div_dotted"></div>
		<div class="write_it">
			<div id='calEditMemoFrame' style="background:#fff;overflow:hidden;position:relative;"></div>
		</div>
	</div>
</div>

<!-- 팝업 스크립트 -->
<script>
$(document).ready(function () {
	$('#GblNotice,#conFirm').popup({
		transition: 'all 0.3s',
		blur: false,
		escape:false,
		scrolllock: false
	});

	$('#multiBox,#titleBox,#newsConsBox').popup({
		transition: 'all 0.3s',
		blur: false,
		escape:false,
		scrolllock: false
	});

	$('#newsListBox').popup({
		transition: 'all 0.3s',
		blur: false,
		escape:false,
		scrolllock: true
	});

	$('#graphListBox').popup({
		transition: 'all 0.3s',
		blur: false,
		escape:false,
		scrolllock: true
	});

	$('#calEditMemo').popup({
		transition: 'all 0.3s',
		blur: false,
		escape:false,
		scrolllock: true
	});

	$(document).on('click', '.newsConsBox_close', function(){
		$("#newsListBox").show();
	});

	//숫자만 입력받기
	$('input.numberOnly').keydown(function(e){
		fn_Number($(this),e);
	}).keyup(function(e){
		fn_Number($(this),e);
	}).css('imeMode','disabled');

	//input필드 자동완성기능
	jQuery('input').attr("autocomplete","off");
});
</script>
<!-- 팝업 스크립트 -->




<iframe name='ifra_gbl' src='about:blank' width='0' height='0' frameborder='0' scrolling='no' style='display:none;'></iframe>