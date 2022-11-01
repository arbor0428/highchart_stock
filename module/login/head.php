<?
session_cache_limiter('');
session_start();
Header("p3p: CP=\"CAO DSP AND SO ON\" policyref=\"/w3c/p3p.xml\"");

//글로벌 변수 설정
$GBL_USERID	= strtolower($_SESSION['ses_member_id']);
$GBL_NAME	= strtolower($_SESSION['ses_member_name']);
$GBL_MTYPE = $_SESSION['ses_member_type'];

$GBL_DATE = date('Y-m-d');	//오늘날짜
$GBL_TIME = time();		//현재시간 타임값
?>