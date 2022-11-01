<?
	include '../header.php';
?>
<div id="sub_cont">
	<div class="sub_center">
		<div class="login_wrap">
			<div class="login_inner">
				<h3 class="mem_tit">Login</h3>
				<div class="idpassBox">
					<input type="text" name="" id="userid" class="input_text medium" placeholder="아이디" onkeypress="" autocomplete="off">
				</div>
				<div class="idpassBox">
					<input type="password" name="" id="passwd" class="input_text medium" placeholder='비밀번호' onkeypress="" autocomplete="off">
				</div>
				<div class="txt_c">
					<a href="search_id.php" class="member-btn">아이디를 잊으셨습니까?</a>
					<a href="search_pw.php" class="member-btn">비밀번호를 잊으셨습니까?</a>
				</div>
				<a href="javascript:login_check();" class="loginBtn">로그인</a>
				<a href="javascript:login_check();" class="loginBtn kakao">카카오로그인</a>
				<a href="javascript:login_check();" class="loginBtn naver">네이버로그인</a>
			</div>
		</div>	
	</div>
</div>
<?
	include '../footer.php';
?>