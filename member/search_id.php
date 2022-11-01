<?
	include '../header.php';
?>

<div id="sub_cont">
	<div class="sub_center">
		<div class="login_wrap">
<!-- 			<div class="ora_line"></div> -->
			<div class="login_inner">
				<h3 class="mem_tit">아이디 찾기</h3>
				<div class="idpassBox">
					<input type="text" name="f_name" id="f_name" class="input_text medium" placeholder="이름" onkeypress="" autocomplete="off">
				</div>
				<div class="idpassBox">
					<input type="text" name="f_phone" id="f_phone" class="input_text medium" placeholder='연락처' onkeypress="" autocomplete="off">
				</div>
				<a href="javascript:login_check();" class="loginBtn">확인</a>
				<div class="txt_c" style=" justify-content: center;">
					<a href="search_pw.php" class="member-btn" style="padding-left:0; text-align: center;">비밀번호를 잊으셨습니까?</a>
				</div>
			</div>
		</div>	
	</div>
</div>

<?
	include '../footer.php';
?>