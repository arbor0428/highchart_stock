<?
class Util
{
	//콤보 박스를 생성한다. Y-년, M-월, D-일 
	function getCboCalender($verYear, $verMonth, $verDay, $selYear="", $selMonth="", $selDay="", $mtype="D", $is_print="1", $class=''){
		$msg = "";

		//if($selYear == "")	$selYear	= date('Y');
		//if($selMonth == "")	$selMonth	= date('n');
		//if($selDay == "")	$selDay		= date('j');

		if($class!='')	$class = 'class='.$class;

		if($mtype == "Y" || $mtype == "M" || $mtype == "D"){		
			$msg = '<select name="'.$verYear.'" '.$class.'>';
			$msg .= '<option value="">====</option>';
			for($i=1997; $i<=2007; $i++){
				if($i == $selYear)
					$msg .= '<option value="'.$i.'" selected>'.$i.'</option>';
				else
					$msg .= '<option value="'.$i.'">'.$i.'</option>';
			}
			$msg .= "</select>년&nbsp;&nbsp;&nbsp;";
		}

		if($mtype == "M" || $mtype == "D"){		
			$msg .= '<select name="'.$verMonth.'" '.$class.'>';
			$msg .= '<option value="">==</option>';
			for($i=1; $i<=12; $i++){
				if($i == $selMonth)
					$msg .= '<option value="'.$i.'" selected>'.$i.'</option>';
				else
					$msg .= '<option value="'.$i.'">'.$i.'</option>';
			}
			$msg .= "</select>월&nbsp;&nbsp;&nbsp;";
		}

		if($mtype == "D"){		
			$msg .= '<select name="'.$verDay.'" '.$class.'>';
			$msg .= '<option value="">==</option>';
			for($i=1; $i<=31; $i++){
				if($i == $selDay)
					$msg .= '<option value="'.$i.'" selected>'.$i.'</option>';
				else
					$msg .= '<option value="'.$i.'">'.$i.'</option>';
			}
			$msg .= "</select>일&nbsp;&nbsp;&nbsp;";
		}

		if($is_print)
			echo $msg;
		else
			return $msg;
	}

	function getSelectBox($name, $arr_value, $arr_caption, $selected_value='', $class='', $function='', $print=true){
		$select_box = '<select name="'.$name.'" ';

		if($class!='')		$select_box .= ' class="'.$class.'" ';
		if($function!='')	$select_box .= ' onChange="javascript:'.$function.'"';

		$select_box .= '>';
		$select_box .= '<option value="">==</option>';

		//if($selected_value=="")	$selected_value = $arr_value[0];

		for($i=0; $i<count($arr_value); $i++){
			if($arr_value[$i]==$selected_value)	$selected='selected';	else $selected = '';
			$select_box .= '<option value="'.$arr_value[$i].'" '.$selected.'>'.$arr_caption[$i].'</option>';
		}
		$select_box .= '</select>';

		if($print)
			echo $select_box;
		else
			return $select_box;
	}

	/* 확장명 추출 하는 메소드 */
	function getExt($file_name){
		$_file_name = explode(".",$file_name);
		$ext = strtolower($_file_name[count($_file_name)-1]); 

		return $ext;
	}

	//특정 확장자의 아이콘을 링크테그형태로 만들어 주는 메소드 //
	function getLinkFileIcon($img_dir, $file_dir, $file_name){
		$_file_name = explode(".",$file_name);
		$ext = strtolower($_file_name[count($_file_name)-1]); 

		switch ($ext){
			case 'hwp':
				$img_name = "hwp.gif";
				break;

			case 'doc':
				$img_name = "doc.gif";
				break;

			case 'ppt':
				$img_name = "ppt.gif";
				break;

			case 'xls':
				$img_name = "xls.gif";
				break;

			case 'zip':
				$img_name = "zip.gif";
				break;

			case 'exe':
				$img_name = "exe.gif";
				break;

			case 'gif':
				$img_name = "gif.gif";
				break;

			case 'jpg':
				$img_name = "jpg.gif";
				break;

			case 'pdf':
				$img_name = "pdf.gif";
				break;

			default:
				$img_name = "txt.gif";
		}

		$linkImg = "<a href=javascript:downFile('".$file_dir."','".$file_name."')><img src='".$img_dir."/".$img_name."' border=0></a>";
		return $linkImg;
	}

	// 한글용 ksubstr //
	function ksubstr($string,$start,$length){
		if($length>=strlen($string)) return $string;
		$klen=$length-1;
		while(ord($string[$klen]) & 0x80) $klen--;
		return $add.substr($string,$start,$length-(($length+$klen+1)%2));
	}

	function delFile($dir, $file_name){
		if(file_exists($dir.'/'.$file_name)){
			unlink($dir.'/'.$file_name);
			return true;
		}
		else
			return false;
	}

	/* date1 과 date2의 차이를 날짜로 반환하는 메소드 */
	function dateDiff($date1, $date2){
		$_date1 = explode("-",$date1);
		$_date2 = explode("-",$date2);

		$tm1 = mktime(0,0,0,$_date1[1],$_date1[2],$_date1[0]);
		$tm2 = mktime(0,0,0,$_date2[1],$_date2[2],$_date2[0]);

		return ($tm1 - $tm2) / 86400;
	}

	/* date1 과 date2의 차이를 날짜로 반환하는 메소드 */
	function dateDiffTime($date){
		$date1 = date('Y-m-d');
		$date2 = date('Y-m-d',$date);

		$_date1 = explode("-",$date1);
		$_date2 = explode("-",$date2);

		$tm1 = mktime(0,0,0,$_date1[1],$_date1[2],$_date1[0]);
		$tm2 = mktime(0,0,0,$_date2[1],$_date2[2],$_date2[0]);

		return ($tm1 - $tm2) / 86400;
	}

	/* 코드를 리턴하는 메소드 */
	function getCode($db, $strTable, $strKey, $intLen, $strC){
		$intCLen = strlen($strC);
		$intLen -= $intCLen;

		$strZero = "";
		for($i=1; $i<=$intLen; $i++){
			$strZero .= "0";
		}

		
		$intCLen += 1;
		$strSql = "select right(concat('".$strZero."',(max(cast(substring(".$strKey.",".$intCLen.",".$intLen.") as SIGNED))+1)),".$intLen.") from ".$strTable;
		$result = mysql_query($strSql, $db);
		if($result){
			$db_code = mysql_result($result,0,0);
			if($db_code==0){

				$db_code = substr($strZero."1",-1*$intLen);
			}
		}
		else{
			$db_code = "";
		}

		if($db_code!=""){
			return $strC.$db_code;
		}
		else{
			return $strC.substr($strZero."1",-1*$intLen);
		}
	}




	function Shorten_String($str, $len, $tail='..'){
		//태그제거
		$noTag = strip_tags($str);

		$strlen = mb_strlen($noTag, 'UTF-8');

		$len = ceil($len/2);

		if($strlen > $len){
			$strTxt = iconv_substr($noTag, 0, $len, 'UTF-8').$tail;
			$cutTxt = str_replace($noTag, $strTxt, $str);
		}else{
			$cutTxt = $str;
		}

		return $cutTxt;
	}


	
	function cutStringWithTags($String, $MaxLen, $ShortenStr){ 
		
		$StringLen = strlen($String); // 원래 문자열의 길이를 구함 

			for ($i = 0, $count = 0, $tag = 0; $i <= $StringLen && $count < $MaxLen; $i++ ) { 
		$LastStr = substr($String, $i, 1); 
				if ($LastStr == '<') $tag = 1; // 태그 시작 
				if ($tag && $LastStr == '>') { $tag = 0; continue; } // 태그 끝 
				if ($tag) continue; 
		if ( ord($LastStr) > 127 ) { $count++; $i++; } 
				$count++; 
		// 2바이트문자라고 생각되면 $i를 1을 더 증가시켜 
		// 결국은 2가 증가하게 된다. 
		// 다음에 오는 1바이트는 당연 지금 바이트의 문자에 귀속되는 문자이다. 

			} 

		$RetStr = substr($String, 0, $i); 
		// 위에서 구한 문자열의 길이만큼으로 자른다. 
			if ($count<$MaxLen) 
				return $RetStr; 
			else 
				return $RetStr .= $ShortenStr; 
		// 여기에 말줄임문자를 붙여서 리턴해준다. 
	}



	function AutoImgSize($url, $w, $h){ 

		$size = getimagesize($url);

		if($size[0] > $w)	$width = $w; //임의로 정하는 넓이
		else	$width = $size[0];

		$height = $width*$size[1]/$size[0]; //원본 이미지의 넓이값 대비 높이와 같은 비율로 줄어든 높이값
		if($height > $h){$height = $h;}
		if($size[0] < $size[1]){$width = $height*$size[0]/$size[1];}

		$width = intval($width);
		$height = intval($height);

		$ReSize = "width='$width' height='$height'";

		return $ReSize;

	}




	function price_trans($price) {
			$ptxt = '';
			$trans_kor=array("","일","이","삼","사","오","육","칠","팔","구");
			$price_unit=array("","십","백","천","만","십만","백만","천만","억","십억","백억","천억","조","십조","백조");
			$value=strlen($price);
			for($i=0;$i<=$value;$i++) {
					$str[$i]=substr($price,$i,1);
			}
			$code=$value;
			for($i=0;$i<=$value;$i++) {
					$code=$code-1;
					if($trans_kor[$str[$i]] == "") {
							$price_unit[$code]="";
					}
					if($code>4) {
							$two=$i+1;
							if($trans_kor[$str[$two]] != "") {
									$price_unit[$code]=substr($price_unit[$code],0,2);
							}
					}
					$ptxt .= $trans_kor[$str[$i]].$price_unit[$code];
			}

			return $ptxt;
	}




	function NameCutStr($str, $skip, $suffix){ 
		preg_match_all( "/[\x80-\xff].|./", $str, $matches );

		for( ;$skip --; ) $h .= array_shift( $matches[0] ); 
		$b = str_repeat($suffix,  count( $matches[0] ) ); 
		return $h . $b; 
	}



	//처음과 마지막 문자를 제외한 모든문자 *표시
	function NameCutStr2($str){
		$nameTxt = '';

		mb_internal_encoding(mb_detect_encoding($str,'UTF-8,EUC-KR')); 
		$nameTxt = ($len=mb_strlen($str))>2 ? mb_substr($str,0,1).str_repeat('*',$len-2).mb_substr($str,-1,1) : $str;

		return $nameTxt;
	}


	function LoginChk($userid){
		if(!$userid){
			echo("<script language=javascript>");
			echo("top.location.href = '/';");
			echo("</script>");
		}
	}


	function ServiceChk($userid,$scode){
		if(!$userid || !$scode){
			echo("<script language=javascript>");
			echo("top.location.href = '/';");
			echo("</script>");
		}
	}






	function NumberSet($num01){	//num01:기준숫자
		$cno = explode('.',$num01);
		$clen = count($cno);

/*
		if($clen > 1)	$no = number_format($num01,1);
		else	$no = number_format($num01);
*/

		if($num01 != 0)	$no = number_format($num01,2);
		else	$no = $num01;

		return $no;
	}



	function NumberSet2($num01){	//num01:기준숫자
		$cno = explode('.',$num01);
		$clen = count($cno);
		$fno = $cno[$clen-1];

		$filter = false;

		if($num01 != 0){
			$filter = true;

			if(($clen > 1 && $fno == '00') || $clen == 1){
				$filter = false;
			}
		}

		if($filter)	$no = number_format($num01,2);
		else		$no = number_format($num01);

		return $no;
	}


	function NumberSet3($num01){	//num01:기준숫자
		$cno = explode('.',$num01);
		$clen = count($cno);
		$fno = $cno[$clen-1];

		$filter = false;

		if($num01 != 0){
			$filter = true;

			if(($clen > 1 && $fno == '000') || $clen == 1){
				$filter = false;
			}
		}

		if($filter)	$no = number_format($num01,3);
		else	$no = number_format($num01);

		if($no == '-0')	 $no = 0;

		return $no;
	}



	function NumberSet4($num01){	//num01:기준숫자
		$cno = explode('.',$num01);
		$clen = count($cno);
		$fno = $cno[$clen-1];

		$filter = false;

		if($num01 != 0){
			$filter = true;

			if(($clen > 1 && $fno == '000') || $clen == 1){
				$filter = false;
			}
		}

		$no = round($num01,3);

		if($no == '-0')	 $no = 0;

		return $no;
	}


	/* 타입값으로 변환 */
	function makeTime($date){
		$_date = explode("-",$date);

		$tm = mktime(0,0,0,$_date[1],$_date[2],$_date[0]);

		return $tm;
	}


	//textarea 인코딩
	function TextAreaEncodeing($str){
		if($str){
			$str = str_replace("<", "&lt;", $str);
			$str = str_replace(">", "&gt;", $str);
			$str = str_replace("\"", "&quot;", $str);
			$str = str_replace("\|", "&#124;", $str);
			$str = str_replace("\r\n\r\n", "<P>", $str);
			$str = str_replace("\r\n", "<BR>", $str);
		}

		return $str;
	}


	//textarea 디코딩
	function TextAreaDecodeing($str){
		if($str){
			$str = str_replace("&lt;", "<", $str);
			$str = str_replace("&gt;", ">", $str);
			$str = str_replace("&quot;", "\"", $str);
			$str = str_replace("&#124;", "\|", $str);
			$str = str_replace("<P>", "\r\n\r\n", $str);
			$str = str_replace("<BR>", "\r\n", $str);
		}

		return $str;
	}


	//날짜형식
	function chkDate($str){
		if(preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $str)){
			return true;
		}else{
			return false;
		}
	}

	//모바일형식
	function chkMobile($str){
		$ph = preg_replace("/[^0-9]*/s", "", $str);
		$ph_len = strlen($ph);
		
		if($ph_len >= '8' && $ph_len <= '11'){
			switch($ph_len){
				case 8:
					$ph = "010".$ph;
					$ph = substr($ph,0,3)."-".substr($ph,3,4)."-".substr($ph,7);
					break;

				case 9:
					$ph = "0".$ph;
					$ph = substr($ph,0,3)."-".substr($ph,3,3)."-".substr($ph,6);
					break;
					
				case 10:
					if(substr($ph,0,1) == '0'){
						$ph = substr($ph,0,3)."-".substr($ph,3,3)."-".substr($ph,6);
					}elseif(substr($ph,0,1) == '1'){
						$ph = "0".$ph;
						$ph = substr($ph,0,3)."-".substr($ph,3,4)."-".substr($ph,7);
					}
					break;
					
				case 11:
					$ph = substr($ph,0,3)."-".substr($ph,3,4)."-".substr($ph,7);
					break;
			}
			
			$pattern = "/^01[016789]-[0-9]{3,4}-[0-9]{4}$/";
			$rs = (preg_match($pattern, $ph)) ? true : false;
			return $ph;
		}
	}
	//비밀번호 초기화
	function rePassWord(){
		$str01 = "1234567890abcdefghijklmnopqrstuvwxyz";
		$str02 = "!@#$";

		$code = substr(str_shuffle($str01),0,5);
		$code .= substr(str_shuffle($str02),0,2);

		return $code;
	}



	//배열값에 콤마(,)를 구분자로 추가
	function makeText01($arr){
		$str = '';
		if(is_array($arr)){
			foreach($arr as $k => $v){
				if($v){
					if($str)	$str .= ', ';
					$str .= $v;
				}
			}
		}

		return $str;
	}

	//total값 기준 val값의 등락률
	static function fnPercent($total,$val){
		$num = '0.0';

		if($total && $val){
//			$num = number_format(round((($val / $total) - 1) * 100,2),2);
			$num = round((($val / $total) - 1) * 100,2);
		}

		return $num;
	}

	//total값 기준 val값의 비중
	static function fnPercent2($total,$val){
		$num = '0.0';

		if($total && $val){
			$num = round((($val / $total) * 100),2);
		}

		return $num;
	}


	//min값과 max값에서 v값의 %
	static function fnPercentage($min,$v,$max){		
		$num = '0.0';

		if($min && $v && $max){
			$num = round((($v - $min) / ($max - $min) * 100),2);
		}

		return $num;
	}


	//무한 소수점
	static function infiniteDecimal($num){		
		$tmp = explode('.',$num);
		$num = $tmp[0] + (substr($tmp[1],0,3) / 1000);	//무한소수점이 나오기 때문에 소수점 3자리까지만 가져옴

		return $num;
	}

	static function nf1($num,$limit){
		$n = number_format($num,$limit);
		if($n > 0)	$n = '+'.$n;
		return $n;
	}

	static function num_to_han_s($mny,$st=0){
		//숫자를 4단위로 한글 단위를 붙인다.
		//num_to_han_s('123456789') -> 1억2345만6789
		//num_to_han_s('123456789',4) -> 1억2345만
		//num_to_han_s('123456789',6) -> 1억2345만 //무조건 4단위로 끊음

		$mny = strval($mny);

		$j2 = array("만","억","조","경"); // 단위의 한글발음 (조 다음으로 계속 추가 가능)
		$arr=array();
		$m=strlen($mny);
		for($i=0;$i<$m;$i++){
			$arr[]=$mny{$i};
		}
		$arr = array_reverse($arr);
		$arrj1 = array();
		$arrj2 = array();
		for($i=0,$m=count($arr);$i<$m;$i++){
			$arrj1[] = $j1[$i%4];
			$arrj2[] = $j2[floor($i/4)];
		}
		$cu = '';
		$mstr = '';
		$st = floor($st/4)*4;
		for($i=$st,$m=count($arr);$i<$m;$i++){
			$t = $arr[$i];
			if($cu != $arrj2[$i]){
				$cu = $arrj2[$i];
				$t.=$cu;
			}
			$mstr = $t.$mstr;
		}

		//숫자 콤마추가
		preg_match_all('!\d+!', $mstr, $matches);
		foreach($matches[0] as $v){
			if(strlen($v) == 4){
				$mstr = str_replace($v,number_format($v),$mstr);
			}
		}

		return($mstr);
	}

	static function convertHan($num,$ex=0,$cut=1){
		$str = "";
		$arr = Array("", "만", "억", "조", "경");

		if($ex)	$num *= pow(10,$ex);

		$c = 0;

		for($i = count($arr) - 1; $i >= 0; --$i){
			$unit = pow(10000, $i);
			$part = floor($num / $unit);
			if($part > 0){
				$str .= number_format($part) . $arr[$i];
			}
			$num %= $unit;

			if($c == $cut){
				break;
			}

			$c++;
		}
		return $str;
	}

	//억단위 또는 만단위(소수점 2자리)
	static function unitNum($num){
		if($num){
			//1억 이상이면 억단위로 표시
			if(strlen($num) >= 9){
				$num = round(($num / 100000000),2);
				$unit = '억';

			//1억 미만이면 만단위로 표시
			}else{
				$num = round(($num / 10000),2);
				$unit = '만';
			}
		}

		$res = Array($num,$unit);
		return $res;
	}


	//실시간 환율정보
	function ExchangeRate(){
		////API Url
		$url = 'https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		if(curl_errno($ch)){
			throw new Exception(curl_error($ch));
		}
		curl_close($ch);

		$data = json_decode($result,ture);
		$data = $data[0];

		//echo $result;
		$_provider = $data['provider'];

		$_buying = $data['cashBuyingPrice'];
		$_selling = $data['cashSellingPrice'];
		$_ttselling = $data['ttSellingPrice'];
		$_ttbuyling = $data['ttBuyingPrice'];
		$_usd = $data['basePrice'];
		$_openusd = $data['openingPrice'];
		$_chusd = $data['changePrice'];
		$_openusd_o = $_usd - $_openusd;
		$_openusd_op = ($_chusd/$_usd)*100;
		$_openusd = round($_openusd,2);

		$tmpArr = Array();

		if($_openusd_o > 0){
//			$_openusd_p = '<font color="#ff0000">+'.sprintf('%0.2f',$_usd).' 원 <small>▲ +'.sprintf('%0.2f',$_chusd).'원 ('.sprintf('%0.2f',$_openusd_op).'%) </small></font>';
			$tmpArr[0] = '▲';
			$tmpArr[3] = '+'.number_format($_openusd_op,2);

		}elseif($_openusd_o < 0){
//			$_openusd_p = '<font color="#0051c7">'.$_usd.' 원 <small>▼ '.sprintf('%0.2f',$_chusd).'원 ('.sprintf('%0.2f',$_openusd_op).'%) </small></font>';
			$tmpArr[0] = '▼';
			$tmpArr[3] = '-'.number_format($_openusd_op,2);

		}else{
//			$_openusd_p = $_usd.' 원 '.sprintf('%0.2f',$_chusd).'원 ('.sprintf('%0.2f',$_openusd_op).'%)';
			$tmpArr[0] = '';
			$tmpArr[3] = number_format($_openusd_op,2);
		}

		$tmpArr[1] = number_format($_usd,2);
		$tmpArr[2] = number_format($_chusd,2);


//		return $_openusd_p;
		return $tmpArr;
	}
}
?>