<?
	include '../head.php';

	if(!$GBL_USERID){
		Msg::backMsg('접근오류');
		exit;
	}else{
		$row = sqlRow("select * from ks_member where userid='".$GBL_USERID."'");
	}
?>

<style>
.gTable2 th{height:50px;}
</style>

<script>
function modifyChk(){
	form = document.frm01;

//	if(isFrmEmpty(form.name,"관리자명을 입력해 주십시오."))	return;

	n_pwd1 = $('#n_pwd1').val();
	n_pwd2 = $('#n_pwd2').val();
	if(n_pwd1 || n_pwd2){
		if(isFrmEmpty(form.n_pwd1,"신규 비밀번호를 입력해 주십시오."))	return;
		if(isFrmEmpty(form.n_pwd2,"신규 비밀번호를 한번더 입력해 주십시오."))	return;

		if(n_pwd1 != n_pwd2){
			alert('입력하신 신규 비밀번호를 확인해 주시기 바랍니다.');
			$('#n_pwd2').focus();
			return;
		}
	}

	if(isFrmEmpty(form.o_pwd,"현재 비밀번호를 입력해 주십시오."))	return;

	form.target = 'ifra_gbl';
	form.submit();
}
</script>

<form name='frm01' class="user" method='post' action='/module/common/modify_proc.php'>
<input type='text' style='display:none;'>
<input type='hidden' name='mem_id' value="<?=$row['userid']?>">

<table cellpadding='0' cellspacing='0' border='0' width='100%' class='gTable2'>
	<tr>
		<th width='30%'><span class='eqc'>*</span>아이디</th>
		<td width='70%'><?=$row['userid']?></td>
	</tr>

	<tr>
		<th>신규 비밀번호</th>
		<td><input type='password' name='n_pwd1' id='n_pwd1' style='width:100%;' class='textBox01' placeholder='비밀번호 변경시에만 입력'></td>
	</tr>

	<tr>
		<th>비밀번호 확인</th>
		<td><input type='password' name='n_pwd2' id='n_pwd2' style='width:100%;' class='textBox01' placeholder='비밀번호 변경시에만 입력'></td>
	</tr>

	<tr>
		<th><span class='eqc'>*</span>성 명</th>
		<td><input type='text' name='mem_name' id='mem_name' value='<?=$row['name']?>' style='width:100%;' class='textBox01'></td>
	</tr>

<?
	if($GBL_MTYPE == 'M'){
?>
	<tr>
		<th>연락처</th>
		<td><input type='text' name='mem_phone' id='mem_phone' value='<?=$row['phone']?>' style='width:100%;' class='textBox01' onkeyup="phoneChk(this);"></td>
	</tr>
<?
	}
?>

	<tr>
		<th><span class='eqc'>*</span>현재 비밀번호</th>
		<td><input type='password' name='o_pwd' id='o_pwd' value='' style='width:100%;' class='textBox01'></td>
	</tr>
</table>

<div style='width:100%;margin:20px 0;text-align:center;'>
	<a href="javascript:modifyChk();" class="big cbtn blue">저장</a>
</div>


<iframe name='ifra_gbl' src='about:blank' width='0' height='0' frameborder='0' scrolling='no' style='display:none;'></iframe>
