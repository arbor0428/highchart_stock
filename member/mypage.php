<?
	include '../header.php';
?>
<div id="sub_cont">
	<div class="sub_center">
		<div class="login_wrap join">
			<div class="login_inner">
				<h3 class="mem_tit" style="margin-bottom: 100px;">내 정보 수정</h3>

				<div class="idpassBox">
					<label for="userid"><span class="c_red">*</span>아이디</label>
					<div class="dp_sb">
						<input type="text" name="userid" id="userid" class="input_text medium" value="myss" onkeypress="" autocomplete="off">
					</div>
				</div>

				<div class="idpassBox">
					<label for="userid"><span class="c_red">*</span>비밀번호</label>
					<input type="password" name="" id="passwd" class="input_text medium" value='' onkeypress="" autocomplete="off">
				</div>

				<div class="idpassBox">
					<label for="userid"><span class="c_red">*</span>비밀번호 확인</label>
					<input type="password" name="" id="passwd" class="input_text medium" value='' onkeypress="" autocomplete="off">
				</div>

				<div class="idpassBox">
					<label for="name"><span class="c_red">*</span>이름</label>
					<input type="text" name="" id="name" class="input_text medium" value='마이셀프스탁' onkeypress="" autocomplete="off">
				</div>

				<div class="idpassBox">
					<label for="phone"><span class="c_red">*</span>휴대폰번호</label>
					<input type="text" name="" id="phone" class="input_text medium" value='' onkeypress=""  maxlength='13'>
				</div>

				<div class="idpassBox">
					<label><span class="c_red">*</span>성별</label>
					<div class="genderChkWrap dp_f">
						<div class="genderChk side_choice">
							<input type="checkbox" name="" id="g1" class="input_text medium" onkeypress="" checked>
							<label for="g1">남자</label>
						</div>
						<div class="genderChk side_choice">
							<input type="checkbox" name="" id="g2" class="input_text medium" onkeypress="">
							<label for="g2">여자</label>
						</div>
					</div>
				</div>

				<div class="idpassBox">
					<label for="bDate"><span class="c_red">*</span>생년월일</label>
					<input type="text" name="bDate" id="bDate" value="2022-10-18" class="input_text medium fpicker" style="width:100%;">
				</div>

				<div class="idpassBox">
					<label><span class="c_red">*</span>이메일</label>
					<div class="dp_sb">
						<input type="text" name="email01" id="email01" value="myss" class="input_text medium" style="width:35%;ime-mode:disabled"> @
						<input type="text" name="email01" id="email02" value="naver.com" class="input_text medium" style="width:30%;ime-mode:disabled">
						<select style="width: 28%; height: 40px;">
							<option>:: 직접입력 ::</option>
						</select>
					</div>
				</div>

				<a class="loginBtn" href="" title="수정하기">수정하기</a>
			</div>
		</div>	
	</div>
</div>
<?
	include '../footer.php';
?>