<?
class FileUpload
{
	var $directory;
	var $fileInfo;
	var $code;
	var $limitSize;
	var $extension;

	/* 클래스 생성자
	   @ $directory			: 파일업로드 디렉토리 경로,
	   @ $http_file_name	: $_FILES[file_name] 정보,
	   @ $code				: 파일명을 코드값을 기준으로 자동부여
	   @ $limit_size		: MB
	   @ $extension			: array 업로드 불가능한 확장자 
	   
	   @ return void */

	function FileUpload($directory, $http_file_name, $code='', $limit_size=15, $extension=array('gif','jpg','jpeg','bmp','png','swf','doc','docx','txt','pdf','xls','xlsx','hwp','ico','wmv','wma','mp3','mp4','dwg','dxf','ai','ppt','pptx','zip')){
		$directory = str_replace('//','/',$directory);
		if(substr($directory, -1)=="/"){
			$this->directory	= substr($directory, 0, -1);
		}else{
			$this->directory	= $directory;
		}

		$this->fileInfo		= $http_file_name;
		$this->code			= $code;
		$this->limit_size	= $limit_size;
		$this->extension	= $extension;
	}

	function delFile($file_name){
		if(file_exists($this->directory.'/'.$file_name)){
			unlink($this->directory.'/'.$file_name);
			return true;
		}
		else
			return false;
	}
	
	/* 확장자를 제거한 파일이름을 리턴하는 메소드 */
	function getFileName(){
		$_file_name = explode('.',$this->fileInfo['name']);
		return $_file_name[0];
	}
	
	/* 파일의 확장자 추출 메소드 */
	function getFileExtension($file_name=''){
		if($file_name=='')	$file_name = $this->fileInfo['name'];
		$_file_name = explode('.',strtolower($file_name));
		return $_file_name[count($_file_name)-1];
	}

	/* 업로드 가능한 확장자 인지 검사 하는 메소드 */
	function isValidExtension(){			
		$ext = $this->getFileExtension();
		$isExt = in_array($ext, $this->extension);

		if(!$isExt){
			$this->errorMsg("업로드할 수 없는 파일입니다.");
			return false;
		}
		else 
			return true;
	}

	/* 파일 사이즈가 업로드 가능한지 확인 하는 메소드 */
	function isLimitFileSize(){
		if($this->limit_size * 1024 * 1024 < $fileInfo['size']){
			$this->errorMsg("업로드 할 파일의 크기가 초과 하였습니다.");
			return false;

		}
		else 
			return true;
	}

	/* 중복된 파일이름이 있을경우 새로운 이름을 부여하는 메소드 */
	/* $auto_file_name : 자동파일명 부여 true/false */
	function getValidFileName(){

		$tmp_file_ext = $this->getFileExtension();

		if($this->code!=''){
			$file_name = $this->code.date('ymdHis').'.'.$tmp_file_ext;
			$tmp_file_name = $this->code.date('ymdHis');
		}
		else {
			$file_name = $this->fileInfo['name'];
			$tmp_file_name = $this->getFileName();
		}

		if(!is_dir($this->directory)){
			if(mkdir($this->directory))	chmod($this->directory,0777);
		}
		
		$i=1;
		while(file_exists($this->directory.'/'.$file_name)){
			$file_name = $tmp_file_name.'-'.$i.'.'.$tmp_file_ext;
			$i++;
		}

		return $file_name;
	}

	function makeDir($dir=''){
		if($dir=='')	$dir = $this->directory;

		$_dir = explode('/', $this->directory);
		for($i=0; $i<count($_dir); $i++){
			$now_dir .= '/'.$_dir[$i];
			if(!file_exists($now_dir)){
				mkdir($now_dir,0777);
				chmod($now_dir,0777);
			}
		}
	}

	/* 파일을 업로드 하는 메소드 */
	function uploadFile(){		
		if($this->isValidExtension() && $this->isLimitFileSize()){

			//디렉토리가 없을 경우 자동 생성
			// /file에 쓰기권한이 있어야 함
			if(!file_exists($this->directory))		$this->makeDir();

			$new_file_name = $this->getValidFileName();
			
			if(move_uploaded_file($this->fileInfo['tmp_name'],$this->directory.'/'.$new_file_name)){
				$this->fileInfo['rename'] = $new_file_name;
				return true;
			}
			else {
				$this->errorMsg("업로드를 실패했습니다. 다시 확인해 주세요");
				return false;
			}
		}
	}

	function errorMsg($msg){
		echo ('<script language="javascript">
					alert("'.$msg.'");
			   </script>');
	}
}
?>