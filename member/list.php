<script>
function memberPop(t,u){
	$("#multiBox").css({"width":"90%","max-width":"550px"});
	if(t == 'w'){
		$('#multi_ttl').text('담당자 등록');
		$('#multiFrame').html("<iframe src='form.php?type=write' name='memberFrame' style='width:100%;height:400px;' frameborder='0' scrolling='auto'></iframe>");
	}else if(t == 'e'){
		$('#multi_ttl').text('정보수정');
		$('#multiFrame').html("<iframe src='form.php?type=edit&uid="+u+"' name='memberFrame' style='width:100%;height:400px;' frameborder='0' scrolling='auto'></iframe>");
	}

	$('.multiBox_open').click();
}
</script>

<div class="mo-hand1 mo-hand" style="float:right;text-align:right;">
	<span class="scorll-hand">
		<img src="/img/scroll_hand.gif" style="max-width:100%;">
	</span>
</div>

<form name='frm01' method='post' action=''>
<input type='text' style='display:none;'>

<div class="table-responsive">
	<table cellpadding='0' cellspacing='0' border='0' width='100%' class='listTable' style='min-width:900px;margin:5px 0 250px 0;'>
		<tr>
			<th width='70'>번호</th>
			<th width='*'>아이디</th>
			<th width='*'>성 명</th>
			<th width='*'>연락처</th>
			<th width='180'>최근접속일시</th>
			<th width='150'>등록일</th>
		</tr>
<?	
$memberList = sqlArray("select * from ks_member where mtype='M' order by uid desc");
if($memberList){

	$n = count($memberList);
	foreach($memberList as $tmp => $row){
		$uid = $row['uid'];
		$userid = $row['userid'];
		$name = $row['name'];
		$phone = $row['phone'];
		$lastLogin = $row['lastLogin'];
		$rDate = date('Y-m-d',$row['rTime']);
?>
		<tr class='grayLine' onclick="memberPop('e','<?=$uid?>');" style="cursor:pointer;">
			<td><?=$n?></td>
			<td><?=$userid?></td>
			<td><?=$name?></td>
			<td><?=$phone?></td>
			<td>
			<?
				if($lastLogin == '0000-00-00 00:00:00')		echo '-';
				else														echo $lastLogin;
			?>
			</td>
			<td><?=$rDate?></td>
		</tr>


<?
		$n--;
	}
}else{
?>
		<tr>
			<td colspan='6' style='padding:50px 0;text-align:center;'>등록된 담당자가 없습니다.</td>
		</tr>
<?
}
?>
	</table>
</div>

</form>
