<?
	include 'head.php';

	if($GBL_USERID){
		Msg::goNext('/member/');
		exit;
	}
?>

<script>
function masterLogin(){
	form = document.frmLogin;

	if(isFrmEmptyModal(form.userid,"아이디를 입력해 주십시오."))	return;
	if(isFrmEmptyModal(form.passwd,"비밀번호를 입력해 주십시오."))	return;

	form.target = 'ifra_gbl';
	form.submit();
}
</script>

<body class="bg-login-background">

    <div class="container">

        <!-- Outer Row -->
        <div class="row1 justify-content-center" style="width:100%; height:100%; align-items:center;">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5 pt-6 pb-6">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">고양시 코로나19 확진자<br>기초역학조사 설문시스템</h1>
                                    </div>
									<form name='frmLogin' class="user" method='post' action='/module/login/login_proc.php'>
									<input type='text' style='display:none;'>
									<input type='hidden' name='next_url' value="<?=$_SERVER['PHP_SELF']?>">

                                        <div class="form-group">
                                            <input type="text" name="userid" id="userid" class="form-control form-control-user" placeholder="아이디" onkeypress="if(event.keyCode==13){masterLogin();}">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="passwd" id="passwd" class="form-control form-control-user" placeholder="비밀번호" onkeypress="if(event.keyCode==13){masterLogin();}">
                                        </div>
									<!--
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">아이디 저장</label>
                                            </div>
                                        </div>
									-->
                                        <a href="javascript:masterLogin();" class="btn btn-primary btn-user btn-block">
                                            로그인
                                        </a>
										<!--
                                        <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
										-->
                                    </form>
									<!--
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
									
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
									-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</body>


<?
	$copyHide = true;
	include 'footer.php';
?>