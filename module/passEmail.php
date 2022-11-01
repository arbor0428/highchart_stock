<?
//보내는이
$from_email = 'iwebzone@naver.com';
$from_name = '장애인채용포털';

//메일제목
$subject = '고객님께서 요청하신 비밀번호에 대한 안내입니다.';

//실제전송파일
$file_name = 'passEmail.html';

if($buffer = file_exists($file_name)){

	$sMessage = '';

	$fp = fopen($file_name, "r");

	if ($fp != NULL) {
		while(!feof($fp)){
			$sMessage .=  fread($fp,100);
		}
	}


	$sMessage = str_replace("#name", $f_name, $sMessage);
	$sMessage = str_replace("#pwd", $send_passwd, $sMessage);



	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=euc-kr\r\n";
//	$headers .= "To: ".$to_name." <".$to_email.">\r\n";
	$headers .= "From: ".$from_name." <".$from_email.">\r\n";

	mail($to_email, $subject, $sMessage, $headers);
}
?>