<?
include './head2.php';

$symbol = $_GET['symbol'];
$uid = $_GET['uid'];
$dataType = $_GET['dataType'];

$row = '';

//실적발표
if($dataType == 'earnings'){
	$row = sqlRow("select c.*, p.name from api_Earnings_Calendar as c left join ks_symbol as s on c.symbol=s.symbol left join api_Company_Profile as p on c.symbol=p.symbol where c.uid='".$uid."'");
	$fArr = Array('name','date','epsActual','epsEstimate','hour','revenueActual','revenueEstimate');

//배당
}elseif($dataType == 'dividends'){
	$row = sqlRow("select c.*, p.name from api_Dividends as c left join ks_symbol as s on c.symbol=s.symbol left join api_Company_Profile as p on c.symbol=p.symbol where c.uid='".$uid."'");
	$fArr = Array('name','date','amount','adjustedAmount','payDate','recordDate','declarationDate','currency');

//IPO
}elseif($dataType == 'ipo'){
	$row = sqlRow("select * from api_IPO_Calendar where uid='".$uid."'");
	$fArr = Array('date','exchange','name','numberOfShares','price','status','totalSharesValue');
}
?>


<?
if($row){
?>
<table cellpadding='0' cellspacing='0' border='0' width='100%' class='gTable'>
	<colgroup>
		<col style='width:25%;'>
		<col style='width:75%;'>
	</colgroup>
<?
	foreach($fArr as $v){
?>
	<tr>
		<th><?=$v?></th>
		<td><?=$row[$v]?></td>	
	</tr>
<?
	}
?>
</table>

<?
}else{
	echo 'No Data';
}
?>