<?php

require_once ('KISA_SEED_ECB.php');


function strToHex($string){
    $hex = '';
    if($string != '') {
       for ($i=0; $i<strlen($string); $i++){
           $ord = ord($string[$i]);
           $hexCode = dechex($ord);
           $hex .= substr('0'.$hexCode, -2);
       }
    }
    return strToUpper($hex);
}

function hexToStr($hex){
    $string='';
    if($hex != '') {
       for ($i=0; $i < strlen($hex)-1; $i+=2){
           $string .= chr(hexdec($hex[$i].$hex[$i+1]));
       }
    }
    return $string;
}

function addDelimeter($str) {
   $rtnStr = '';

   if($str != '') {
       for ($i=0; $i < strlen($str); $i+=2) {
           $rtnStr .= substr($str, $i, 2) . ",";
       }
       $rtnStr = substr($rtnStr, 0, -1); 
   }
   return $rtnStr;
}

function removeDelimiter($str) {
   $rtnStr = '';

   if($str != '') {
      $tmpChars = explode(',', $str);
      //echo print_r($tmpChars);

      foreach($tmpChars as $char) {
        $rtnStr .= $char;
      }
   } 
   return $rtnStr;
}

function encrypt($str) {
    //echo "in encrypt : " . $bszUser_key . ", " . $str;

    if($str != '') {
       $e_str = strToHex($str); 
       $e_str = addDelimeter($e_str);

       $bszUser_key = "1b,9e,67,12,09,ae,d2,a6,ab,f7,15,50,09,ca,10,6b";
	   $planBytes = explode(",",$e_str);
  	   $keyBytes  = explode(",",$bszUser_key);
	
	   for($i = 0; $i < 16; $i++)
	   {
	  	  $keyBytes[$i] = hexdec($keyBytes[$i]);
	   }

	   for ($i = 0; $i < count($planBytes); $i++) {
	   	  $planBytes[$i] = hexdec($planBytes[$i]);
	   }

	   if (count($planBytes) == 0) {
		  return $str;
	   }

	   $ret = null;
	   $bszChiperText = null;
	   $pdwRoundKey = array_pad(array(),32,0);



	   //諛⑸ 1
	   $bszChiperText = KISA_SEED_ECB::SEED_ECB_Encrypt($keyBytes, $planBytes, 0, count($planBytes));

       /*
	   for($i=0;$i< sizeof($bszChiperText);$i++) {
			$ret .=  sprintf("%02X", $bszChiperText[$i]).",";
	   }

	   return substr($ret,0,strlen($ret)-1);
       */
	   for($i=0;$i< sizeof($bszChiperText);$i++) {
			$ret .=  sprintf("%02X", $bszChiperText[$i]);
	   }
       return $ret;
    } else {
        return '';
    }
}


function decrypt($str) {
    if($str != '') {
       $bszUser_key = "1b,9e,67,12,09,ae,d2,a6,ab,f7,15,50,09,ca,10,6b";
       $d_str = addDelimeter($str);

	   $planBytes = explode(",",$d_str);
	   $keyBytes  = explode(",",$bszUser_key);
	
	   for($i = 0; $i < 16; $i++)
	   {
	  	  $keyBytes[$i] = hexdec($keyBytes[$i]);
	   }

   	   for ($i = 0; $i < count($planBytes); $i++) {
	  	  $planBytes[$i] = hexdec($planBytes[$i]);
	   }

   	   if (count($planBytes) == 0) {
	 	 return $str;
	   }

	   $pdwRoundKey = array_pad(array(),32,0);

	   $bszPlainText = null;
	   $planBytresMessage = null;
	
	   // 방법 1
	   $bszPlainText = KISA_SEED_ECB::SEED_ECB_Decrypt($keyBytes, $planBytes, 0, count($planBytes));
       /*
	   for($i=0;$i< sizeof($bszPlainText);$i++) {
	  	 $planBytresMessage .=  sprintf("%02X", $bszPlainText[$i]).",";
	   }

	   return substr($planBytresMessage,0,strlen($planBytresMessage)-1);
        */

	   for($i=0;$i< sizeof($bszPlainText);$i++) {
	  	 $planBytresMessage .=  sprintf("%02X", $bszPlainText[$i]);
	   }
       return hexToStr($planBytresMessage);
    } else {
       return '';
    }
}

/*
' mode -  N : Name   (홍*동)
'         P : Phone  (컬럼 3개)
'         E : Email
'         A : Mask All
'         "" : Mask None
*/

function maskString($mode, $encStr) {
   $tmpStr  = "";
   $maskStr = "";
    
   if ($mode == 'N') {
       $tmpStr = $encStr;  // 이름은 암호화 하지 않음
   } else {
       $tmpStr = decrypt($encStr);
   }

   if ($_SESSION['member_level'] < '9') {

       //echo "check : " . $_SESSION['SD_USERGRADE'] . ":" . $mode . ":" . $tmpStr . "\n";

       if ($tmpStr != '') {
          if ($mode == 'A') {
              for ($i=0; $i<strlen($tmpStr); $i++) {
                 $maskStr = $maskStr . '*';
              }
              $tmpStr = $maskStr;
          } elseif ($mode == 'N') {
              //echo "IN : " . strlen($tmpStr) . ", " . mb_strlen($tmpStr, "utf-8") . "\n";
              /* mb_detect_encoding
              if(mb_strlen($tmpStr, "utf-8") > 2) { 
                 for ($i=1; $i<mb_strlen($tmpStr, "utf-8")-1; $i++) {
                    $maskStr = $maskStr . '*';
                 }
                 $tmpStr = mb_substr($tmpStr,  0, 1, "utf-8") . $maskStr . 
                           mb_substr($tmpStr, -1, 1, "utf-8");
              } else {
                 $tmpStr = mb_substr($tmpStr,  0, 1, "utf-8") . "*";
              }
              */
              if(mb_strlen($tmpStr) > 4) { 
                 for ($i=2; $i<mb_strlen($tmpStr)-2; $i+=2) {
                    $maskStr = $maskStr . '*';
                 }
                 $tmpStr = mb_substr($tmpStr,  0, 2) . $maskStr . 
                           mb_substr($tmpStr, -2, 2);
              } else {
                 $tmpStr = mb_substr($tmpStr,  0, 2) . "*";
              }
              //echo "OUT : " . $maskStr . ", " . mb_substr($tmpStr, -1, 1, "utf-8") . "\n";
          } elseif ($mode == 'E') {
              $emailStr = explode("@", $tmpStr);

              if(count($emailStr) == 2) {
                  if(strlen($emailStr[0]) > 3) {
                      for($i=0; $i<strlen($emailStr[0]); $i++) {
                          $maskStr = $maskStr . "*";
                      }
                      $tmpStr = substr($emailStr[0], 0, 3) . $maskStr . "@" . $emailStr[1];
                  } else {
                      $tmpStr = substr($emailStr[0], 0, 2) .  "*@" . $emailStr[1];
                  }
              } else {
                 $tmpStr = $emailStr[0]; // no email format 
              }
          } elseif ($mode == 'P') {
              $phoneStr = explode("-", $tmpStr);
              if(count($phoneStr) == 3) {
                  $tmpStr = $phoneStr[0] . "-****-" . $phoneStr[2];
              } else {
                  $tmpStr = "******" . substr($tmpStr, -4,4);
              }
          }
       }
   }

   if ($mode != 'N') {
	   $tmpStr2 = iconv('euc-kr','utf-8',$tmpStr);
	   if($tmpStr2)	$tmpStr = $tmpStr2;
   }

   return $tmpStr;
}

?>
