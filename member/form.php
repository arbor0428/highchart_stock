<?
	include '../head.php';

	if($GBL_MTYPE != 'A'){
		Msg::backMsg('접근오류');
		exit;
	}


	if($type == 'edit' && $uid){
		$row = sqlRow("select * from ks_member where uid='$uid'");

		if($row){
			foreach($row as $k => $v){
				${$k} = $v;
			}
		}
	}
?>

<style>
.input-50{width:50%;}
.form-group{margin-bottom:0 !important;}
.text-white-50{padding-top:10px !important;}

@media (max-width: 768px){
	.input-50{width:100% !important;}
}
</style>

<script>
function formChk(){
	form = document.frm01;

	type = $('#type').val();

	if(type == 'write'){
		if(isFrmEmpty(form.mem_id,"아이디를 입력해 주십시오."))	return;
		if(isFrmEmpty(form.mem_name,"성명을 입력해 주십시오."))	return;
		if(isFrmEmpty(form.pwd1,"비밀번호를 입력해 주십시오."))	return;
		if(isFrmEmpty(form.pwd2,"비밀번호를 한번더 입력해 주십시오."))	return;

		pwd1 = $('#pwd1').val();
		pwd2 = $('#pwd2').val();

		if(pwd1 != pwd2){
			alert('입력하신 비밀번호를 확인해 주시기 바랍니다.');
			$('#pwd2').focus();
			return;
		}

	}else{
		if(isFrmEmpty(form.mem_name,"성명을 입력해 주십시오."))	return;

		pwd1 = $('#pwd1').val();
		pwd2 = $('#pwd2').val();

		if(pwd1 || pwd2){
			if(isFrmEmpty(form.pwd1,"비밀번호를 입력해 주십시오."))	return;
			if(isFrmEmpty(form.pwd2,"비밀번호를 한번더 입력해 주십시오."))	return;

			if(pwd1 != pwd2){
				alert('입력하신 비밀번호를 확인해 주시기 바랍니다.');
				$('#pwd2').focus();
				return;
			}
		}
	}

	form.target = 'ifra_gbl';
	form.action = 'proc.php';
	form.submit();
}

function memberDel(){
	if(confirm('해당 아이디를 삭제하시겠습니까?')){
		form = document.frm01;
		form.type.value = 'del';
		form.target = 'ifra_gbl';
		form.action = '/module/common/member_proc.php';
		form.submit();
	}
}
</script>

<form name='frm01' class="user" method='post' action=''>
<input type='text' style='display:none;'>
<input type='hidden' name='uid' value='<?=$uid?>'>
<input type='hidden' name='type' id='type' value='<?=$type?>'>

<div class="tbl-st">
	<div class="cols">
		<div class="cols_30 cols_ th"><span class='eqc'>*</span>아이디</div>
		<div class="cols_70 cols_">
		<?
			if($type == 'write'){
		?>
			<div class="form-group">
				<input type="text" name="mem_id" id="mem_id" class="form-control input-50" value="">
			</div>
		<?
			}else{
				echo $userid;
			}
		?>
		</div>
	</div>

	<div class="cols">
		<div class="cols_30 cols_ th"><span class='eqc'>*</span>비밀번호</div>
		<div class="cols_70 cols_">
			<div class="form-group">
				<input type="password" name="pwd1" id="pwd1" class="form-control input-50" value="" <?if($type == 'edit'){?>placeholder="변경시에만 입력"<?}?>>
			</div>
		</div>
	</div>

	<div class="cols">
		<div class="cols_30 cols_ th"><span class='eqc'>*</span>비밀번호 확인</div>
		<div class="cols_70 cols_">
			<div class="form-group">
				<input type="password" name="pwd2" id="pwd2" class="form-control input-50" value="" <?if($type == 'edit'){?>placeholder="변경시에만 입력"<?}?>>
			</div>
		</div>
	</div>

	<div class="cols">
		<div class="cols_30 cols_ th"><span class='eqc'>*</span>성 명</div>
		<div class="cols_70 cols_">
			<div class="form-group">
				<input type="text" name="mem_name" id="mem_name" class="form-control input-50" value="<?=$name?>">
			</div>
		</div>
	</div>

	<div class="cols">
		<div class="cols_30 cols_ th">연락처</div>
		<div class="cols_70 cols_">
			<div class="form-group">
				<input type="text" name="mem_phone" id="mem_phone" class="form-control input-50" value="<?=$phone?>" onkeyup="phoneChk(this);">
			</div>
		</div>
	</div>


</div>

<div style='width:100%;margin:40px 0;text-align:center;'>
	<a href="javascript:formChk();" class="btn btn-secondary btn-icon-split">
		<span class="icon text-white-50">
			<i class="fas fa-check"></i>
		</span>
		<span class="text">저장하기</span>
	</a>
<?
	if($type == 'edit'){
?>
	<a href="javascript:memberDel();" class="btn btn-danger btn-icon-split" style="margin-left:20px;">
		<span class="icon text-white-50">
			<i class="fas fa-trash"></i>
		</span>
		<span class="text">삭제하기</span>
	</a>
<?
	}
?>
</div>


<iframe name='ifra_gbl' src='about:blank' width='0' height='0' frameborder='0' scrolling='no' style='display:none;'></iframe>
