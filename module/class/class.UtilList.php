<?
class UtilList {
	function getPage($page){
		if($page==""){
			return 1;
		}else{
			return $page;
		}
	}

	//문자열 길이 잘라내기 함수
	function getTitle($title, $length){
		if(strlen($title) > $length){
			return substr($title,0,$length)."..";
		}else{
			return $title;
		}
	}

	//신규아이콘을 출력하는 함수
	function getNewIcon($wdate, $newday, $icon){
		if(dateDiff($wdate, date('Y-m-d')) <= $nowday){
			return " <img src='".$icon."' align='absmiddle' border='0'>";
		}else{
			return "";
		}
	}

	//날짜 비교 함수
	function dateDiff($date1, $date2){
		$_date1 = explode("-",$date1);
		$_date2 = explode("-",$date2);

		$tm1 = mktime(0,0,0,$_date1[1],$_date1[2],$_date1[0]);
		$tm2 = mktime(0,0,0,$_date2[1],$_date2[2],$_date2[0]);

		return ($tm1 - $tm2) / 86400;
	}

	//날짜형식을 출력하는 함수 예) 2004-01-02 -> 
	function getDate2($wdate, $length, $division){
		if($length==2){
			$wdate = substr($wdate,2,10);
		}else{
			$wdate = substr($wdate,1,10);
		}
		
		return str_replace($wdate,"-",$division);
	}

	function getLinkFileIconEx($img_dir, $file_dir, $file_name, $bid, $idx, $num){
		$icon_img = UtilList::getIcon($img_dir, $file_name);
		return "<a href=javascript:downFile('".$file_dir."','".$file_name."','".$bid."','".$idx."','".$num."')>".$icon_img."</a>";
	}

	function getLinkFileIcon($img_dir, $file_dir, $file_name){
		$icon_img = UtilList::getIcon($img_dir, $file_name);
		return "<a href='/module/common/download.php?file_dir=".$file_dir."&file_name=".$file_name."'>".$icon_img."</a>";
	}

	function getExt($file_name){
		$arr_file = explode(".",$file_name);
		return $arr_file[count($arr_file)-1];
	}

	function getIcon($img_dir, $file_name){
		$ext = UtilList::getExt($file_name);

		switch(strtolower($ext)){
			case "hwp": $img_name = "hwp.gif"; break;
			case "doc":	$img_name = "doc.gif"; break;
			case "ppt":	$img_name = "ppt.gif"; break;
			case "xls":	$img_name = "xls.gif"; break;
			case "zip":	$img_name = "zip.gif"; break;
			case "exe":	$img_name = "exe.gif"; break;
			case "gif": $img_name = "gif.gif"; break;
			case "jpg":	$img_name = "jpg.gif"; break;
			case "pdf":	$img_name = "pdf.gif"; break;
			case "mp3":	$img_name = "mp3.gif"; break;
			case "avi":	$img_name = "avi.gif"; break;
			case "asf":	$img_name = "asf.gif"; break;
			case "mp3":	$img_name = "mp3.gif"; break;
			case "bmp":	$img_name = "bmp.gif"; break;
			case "mpg":
			case "mpeg":$img_name = "mpeg.gif"; break;
			case "txt":	$img_name = "txt.gif"; break;
			default:	$img_name = "txt.gif"; break;
		}

		return "<img src=".$img_dir.$img_name." border=0>";
	}

	/**
	 * 페이지 사이즈용 메소드
	 **/
	function printPageSize($sel_value){
		$arr_pagesize = array(20,30,40);

		for($i=0; $i<count($arr_pagesize); $i++){
			if($sel_value!=""){
				if(trim($arr_pagesize[$i])==trim($sel_value)) $selected = "selected"; else $selected = "";
			}
			echo("<OPTION value='".$arr_pagesize[$i]."' ".$selected.">".$arr_pagesize[$i]."</OPTION>\n");
		}
	}

	/**
	 * 파일 사이즈 출력 함수 
	 * $file_size : 파일 사이즈
	 * $file_type : 파일 사이즈 유형
	 * 소수점 사이즈
	 * 예) 1024, K -> 1K
	 **/
	function getFileSize($file_size, $file_type='B', $dot_size=0){
		$pos = 0;
		$arr_file_std = array('Byte','KB','MB','GB','TB');

		$tmp_file_size = $file_size;
		while($tmp_file_size >= 1024){
			$tmp_file_size = $tmp_file_size / 1024;
			$pos++;
		}

		$tmp_file_size = number_format(round($tmp_file_size, $dot_size), $dot_size);
		switch($file_type){
			case 'B': $pos_m = 0; break;
			case 'K': $pos_m = 1; break;
			case 'M': $pos_m = 2; break;
			case 'G': $pos_m = 3; break;
			case 'T': $pos_m = 4; break;
		}

		return $tmp_file_size.$arr_file_std[$pos + $pos_m];
	}

	
}
?>