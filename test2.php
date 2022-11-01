<?
include './module/class/class.DbCon.php';

$row = sqlArray("select * from sbChk where symbol='^GSPC' and uid>369 group by rTime");
foreach($row as $v){
	echo $v['rDate'].'<br>';
//	echo date('Y-m-d H:i:s',$v['t']).'<br>';
}
?>