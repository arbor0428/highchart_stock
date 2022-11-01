<?
function imgThumbo($filePath, $saveName, $sFactor, $saveDir = "./", $destroy="1"){

        if (!file_exists($saveDir)) { 
                @mkdir($saveDir); 
         @chmod($saveDir, 0777); 
		} 

        $sz = @getimagesize($filePath); // 이미지 사이즈구함
/*
        if($sz[0] > $sFactor || $sz[1] > $sFactor){        
                if($sz[0]>$sz[1]) $per=$sFactor/$sz[0]; 
                else $per=$sFactor/$sz[1]; 
                $imgW=ceil($sz[0]*$per); 
                $imgH=ceil($sz[1]*$per); 
        }else{
                $imgW=ceil($sz[0]);//width 값 
                $imgH=ceil($sz[1]);//height 값 
        }
*/       
        if($sz[0] > $sFactor){				
                $per=$sFactor/$sz[0]; 
                $imgW=ceil($sz[0]*$per); 
                $imgH=ceil($sz[1]*$per); 
		}else{
                $imgW=ceil($sz[0]);//width 값 
                $imgH=ceil($sz[1]);//height 값 
        }	

        switch ($sz[2]) {
        case 1:
                $src_img = imagecreatefromgif($filePath);
                $dst_img = imagecreate($imgW, $imgH); 
                //$dst_img = imagecreatetruecolor($imgW, $imgH); 
                ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]); 
                ImageInterlace($dst_img);
                ImageGIF($dst_img, $saveDir.$saveName);
                break;
        case 2:
                $src_img = imagecreatefromjpeg($filePath);
                $dst_img = imagecreatetruecolor($imgW, $imgH); 
                ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]); 
                ImageInterlace($dst_img);
                ImageJPEG($dst_img, $saveDir.$saveName);
                break;
        case 3:
                $src_img = imagecreatefrompng($filePath);
                $dst_img = imagecreatetruecolor($imgW, $imgH); 
                ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]); 
                ImageInterlace($dst_img);
                ImagePNG($dst_img, $saveDir.$saveName);
                break;
        default:
                return false;
                break;
        }
        
        return $saveAll = array($saveDir, $saveName, $imgW, $imgH);
        if($destroy){
                ImageDestroy($dst_img); // 제거
                ImageDestroy($src_img); //
        }
}
?>