<?
	$gid = $_POST['gid'];
	if(!$gid){
		Msg::backMsg('접근오류');
		exit;
	}
?>

<style>
.blueBtn2 {display: inline-block; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
.msgData{border:1px solid #d1d1d1;height:30px;width:98%;padding:0 5px;}
.perData{border:1px solid #d1d1d1;height:30px;width:60px;text-align:center;}
</style>

<script>
function groupStockDel(uid){
	GblMsgConfirmBox("해당 종목을 삭제하시겠습니까?","groupStockDelOk("+uid+")");
}

function groupStockDelOk(uid){
	$.post('/module/json/userGroupStock.php',{'userid':'<?=$GBL_USERID?>','type':'del','gid':'<?=$gid?>','uid':uid}, function(result){
		parData = JSON.parse(result);
		code = parData['code'];

		if(code == '99'){
			$('#groupList_'+uid).remove();
			$('#gsNum').text(parData['gsNum']);

		}else{
			GblMsgBox("Error");
			return;
		}
	});	
}

function groupSave(){
	form = document.frm_group;
	form.type.value = 'save';
	form.target = 'ifra_gbl';
	form.action = '/module/json/userGroupStock.php';
	form.submit();
}

function equalChk(){
	len = $('.perData').length;
	p = 100 / len;
	p = parseFloat(p.toFixed(1));

	t = 0;

	$(".perData").each(function() {
		$(this).val(p);
		t += parseFloat(p);
	});

	if(t != 100){
		gap = 100 - parseFloat(t);
		gap = gap.toFixed(1);
		p += parseFloat(gap);
		p = parseFloat(p.toFixed(1));

		$('.perData').last().val(p);
	}
}
</script>

<form name='frm_group' id='frm_group' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type='text' style='display:none;'>
<input type='hidden' name='type' value=''>
<input type='hidden' name='userid' value='<?=$GBL_USERID?>'>
<input type='hidden' name='gid' value='<?=$gid?>'>

		<div class="searchWrap">
			<?
				include 'sub03_searchBar.php';
			?>	
			<div class="dp_sb dp_c" style="margin-top: 30px;">
			<?
				//그룹정보
				$grow = sqlRow("select * from ks_userGroup where userid='".$GBL_USERID."' and uid=".$gid."");

				//종목정보
				$row = sqlArray("select * from ks_userGroupData where userid='".$GBL_USERID."' and gid=".$gid." order by sortNum");
			?>
				<table class="subtable">
					<colgroup>
						<col style="width: 363px;">
						<col style="width: 657px;">
						<col style="width: 260px;">
					</colgroup>
					<tbody>
						<tr>
							<th>그룹명</th>
							<th>그룹 메모</th>
							<th>종목수</th>
						</tr>
						<tr>
							<td><?=$grow['title']?></td>
							<td><?=$grow['memo']?></td>
							<td><span id='gsNum'><?=count($row)?></span></td>
						</tr>
						<tr>
							<td colspan="3">
								<table class="subtable jong" id="stockTable">
									<colgroup>
										<col style="width: 363px;">
										<col style="width: 657px;">
										<col style="width: 260px;">
									</colgroup>
									<tr>
										<th>종목명</th>
										<th>종목 메모</th>
										<th>
											<div class="optTit dp_f dp_c dp_cc">
												<span style="font-weight: 700;">종목 비중(옵션)</span>
												<div class="help_wrap">
													<div class="excla_mark help_point">
														<span>?</span>
													</div>
													<div class="helpbox" style="display: none;">
														<p>종목 비중을 설정하면 관심그룹의 지난 수익률과 예상배당률 등을
														알 수 있어요 100%를 맞춰야 작동해요
														</p>
													</div>
												</div>
											</div>
											<a class="sameR" href="javascript:equalChk();" title="균등비중적용">균등비중적용</a>
										</th>
									</tr>
								<?
									foreach($row as $v){
										$percent = str_replace('.0','',$v['percent']);
								?>
									<tr id="groupList_<?=$v['uid']?>">
										<td><?=$v['symbol']?></td>
										<td><input type='text' name='msg_<?=$v['uid']?>' value="<?=$v['memo']?>" class='msgData'></td>
										<td>
											<input type='hidden' name='chk[]' value="<?=$v['uid']?>">
											<input type='text' name='per_<?=$v['uid']?>' value="<?=$percent?>" class='perData'>%
											<a class="delbtn" href="javascript:groupStockDel('<?=$v['uid']?>')" title="제거">-</a>
										</td>
									</tr>
								<?
									}
								?>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div style='width:305px;margin:0 auto;'>
			<a class="blueBtn2" href="<?=$_SERVER['PHP_SELF']?>" title="그룹 목록" style="margin: 70px auto 0;">그룹 목록</a>
			<a class="blueBtn2" href="javascript:groupSave();" title="종목 저장" style="margin: 70px auto 0;">종목 저장</a>
		</div>

</form>