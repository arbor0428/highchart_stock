<?
	include '../head2.php';

	$row = sqlRow("select * from ks_userPortfolio where userid='".$GBL_USERID."' and uid=".$uid."");
	if(!$row){
		Msg::backMsg('접근오류');
		exit;

	}else{
?>

<style>
.blueBtn {display: block; margin: 50px auto 0; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
</style>

<script>
function groupEdit(){
	groupTitle = $('#groupTitle').val();
	if(groupTitle == ''){
		alert("포트폴리오명을 입력해 주시기 바랍니다.");
		return;
	}

	groupMemo = $('#groupMemo').val();
	if(groupMemo == ''){
		alert("포트폴리오 메모를 입력해 주시기 바랍니다.");
		return;
	}

	id = setTimeout(function(){
		var params = jQuery("#frm01").serialize();
		jQuery.ajax({
			url: '/module/json/userPortfolio.php',
			type: 'POST',
			data:params,
			dataType: 'html',
			success: function(result){
				if(result){
					parData = JSON.parse(result);
					code = parData.code;

					if(code == '99'){
						parent.location.reload();

					}else{
						alert('undefined');
						return;
					}

				}else{
					alert('반환값오류');
					return;
				}
			},
			error: function(error){
				alert('통신오류');
				return;
			}
		});
	}, 100);
}
</script>

<form name='frm01' id='frm01' method='post'>
<input type='text' style='display:none;'>
<input type='hidden' name='uid' value='<?=$uid?>'>
<input type='hidden' name='type' value='edit'>
<input type='hidden' name='userid' value='<?=$GBL_USERID?>'>

<p style='padding-bottom:5px;'>* 포트폴리오명 및 포트폴리오메모를 수정할 수 있습니다.</p>
<table cellpadding='0' cellspacing='0' border='0' width='100%' class='gTable'>
	<tr>
		<th width='20%'>포트폴리오명</th>
		<td width='80%'><input type='text' name='groupTitle' id='groupTitle' value="<?=$row['title']?>" style='width:100%;border:1px solid #d1d1d1;padding:5px;'></th>
	</tr>
	<tr>
		<th>포트폴리오메모</th>
		<td><input type='text' name='groupMemo' id='groupMemo' value="<?=$row['memo']?>" style='width:100%;border:1px solid #d1d1d1;padding:5px;'></th>
	</tr>
</table>

</form>

<a class="blueBtn" href="javascript:groupEdit();" title="저장하기">저장하기</a>

<?
	}
?>