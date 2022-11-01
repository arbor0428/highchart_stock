  <?
  class Msg
  {
	 function backMsg($msg){
		 echo "<script language=\"javascript\">";
		 echo "	alert(\"".$msg."\");";
		 echo "	history.back();";
		 echo "</script>";
	 }

	 function goNext($url){
		 echo "<script language=\"javascript\">";
		 echo "location.href=\"".$url."\";";
		 echo "</script>";
	 }

	 function goNext_New($url){
		 echo "<script language=\"javascript\">";
		 echo "location.replace(\"".$url."\");";
		 echo "</script>";
	 }

	 function goMsg($msg, $url){
		 echo "<script language=\"javascript\">";
		 echo "	alert(\"".$msg."\");";
		 echo "	location.href=\"".$url."\";";
		 echo "</script>";
	 }

	 function onlyMsg($msg){
		 echo "<script language=\"javascript\">";
		 echo "	alert(\"".$msg."\");";
		 echo "</script>";
	 }

	 function goMsgReload($msg){
		 echo "<script language=\"javascript\">";
		 echo "	alert(\"".$msg."\");";
		 echo "	parent.location.reload();";
		 echo "</script>";
	 }

	 function goWinCloseNext($url){
		 echo "<script language=\"javascript\">";
		 echo "	opener.location.href=\"".$url."\";";
		 echo " window.close();";
		 echo "</script>";
	 }

	 function goWinCloseNextMsg($url, $msg){
		 echo "<script language=\"javascript\">";
		 echo "	alert(\"".$msg."\");";
		 echo "	opener.location.href=\"".$url."\";";
		 echo " window.close();";
		 echo "</script>";
	 }

	 function goReload(){
		 echo "<script language=\"javascript\">";
		 echo "	opener.location.reload();";
		 echo " window.close();";
		 echo "</script>";
	 }

	 function alert($msg){
		 echo "<script language=\"javascript\">";
		 echo " alert(\"".$msg."\");";
		 echo " window.close();";
		 echo "</script>";
	 }

	 function backWinClose($msg){
		 echo "<script language=\"javascript\">";
		 echo "	alert(\"".$msg."\");";
		 echo " window.close();";
		 echo "</script>";
	 }

	 function goWinCloseNextMsgNew($msg){
		 echo "<script language=\"javascript\">";
		 echo "	alert(\"".$msg."\");";
		 echo "	parent.opener.location.reload();";
		 echo " window.close();";
		 echo "</script>";
	 }

	 function goKorea($url){
		 echo "<script language=\"javascript\">";
		 echo "	parent.location.href=\"".$url."\";";
		 echo "</script>";
	 }

	 function GblMsgBox($msg,$url){
		 echo "<script language=\"javascript\">";
		 echo "GblMsgBox(\"".$msg."\",\"".$url."\");";
		 echo "</script>";
	 }

	 function GblMsgBoxParent($msg,$url){
		 echo "<script language=\"javascript\">";
		 echo "parent.GblMsgBox(\"".$msg."\",\"".$url."\");";
		 echo "</script>";
	 }

	 function GblMsgBoxCloseParent($cname){
		 echo "<script language=\"javascript\">";
		 echo "window.parent.$('.".$cname."').click();";
		 echo "</script>";
	 }
	 
	 function goMagParent($url){
		 echo "<script language=\"javascript\">";
		 echo "	location.href=\"".$url."\";";
		 echo "</script>";
	 }
  }
  ?>