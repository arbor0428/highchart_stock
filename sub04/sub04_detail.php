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
.numberOnly{border:1px solid #d1d1d1;height:30px;width:80px;text-align:center;}
</style>

<script>
function groupStockDel(uid){
	GblMsgConfirmBox("해당 종목을 삭제하시겠습니까?","groupStockDelOk("+uid+")");
}

function groupStockDelOk(uid){
	$.post('/module/json/userPortfolioStock.php',{'userid':'<?=$GBL_USERID?>','type':'del','gid':'<?=$gid?>','uid':uid}, function(result){
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

	errMsg = '';
	focusID = '';

	$(".chklist").each(function() {
		uid = $(this).val();
		symbol = $('#symbol_'+uid).text();
		sNum = $('#sNum_'+uid).val();
		sAmt = $('#sAmt_'+uid).val();
		sExc = $('#sExc_'+uid).val();

		if(sNum == '' || sNum == 0){
			errMsg = symbol+" 종목의 보유 갯수를 입력해 주세요.";
			focusID = '#sNum_'+uid;
			return false;

		}else if(sAmt == '' || sAmt == 0){
			errMsg = symbol+" 종목의 보유 평단을 입력해 주세요.";
			focusID = '#sAmt_'+uid;
			return false;

		}else if(sExc == '' || sExc == 0){
			errMsg = symbol+" 종목의 매수환율을 입력해 주세요.";
			focusID = '#sExc_'+uid;
			return false;
		}
	});

	if(errMsg){
		GblMsgBox(errMsg);
		$(focusID).focus();
		return;

	}else{
		form = document.frm_group;
		form.type.value = 'save';
		form.target = 'ifra_gbl';
		form.action = '/module/json/userPortfolioStock.php';
		form.submit();
	}
}
</script>

<form name='frm_group' id='frm_group' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type='text' style='display:none;'>
<input type='hidden' name='type' value=''>
<input type='hidden' name='userid' value='<?=$GBL_USERID?>'>
<input type='hidden' name='gid' value='<?=$gid?>'>
<input type='hidden' name='exRate' id='exRate' value='<?=$exRate?>'><!-- 현재 환율 -->


		<div class="searchWrap">
			<?
				include 'sub04_searchBar.php';
			?>	
			<div class="dp_sb dp_c" style="margin-top: 30px;">
			<?
				//그룹정보
				$grow = sqlRow("select * from ks_userPortfolio where userid='".$GBL_USERID."' and uid=".$gid."");

				//종목정보
				$row = sqlArray("select * from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$gid." order by sortNum");
			?>
				<table class="subtable">
					<colgroup>
						<col style="width:20%;">
						<col style="width:*;">
						<col style="width:24%;">
						<col style="width:12%;">
					</colgroup>
					<tbody>
						<tr>
							<th>포트폴리오명</th>
							<th>포트폴리오 메모</th>
							<th>종목수</th>
							<th>현재환율</th>
						</tr>
						<tr>
							<td><?=$grow['title']?></td>
							<td><?=$grow['memo']?></td>
							<td><span id='gsNum'><?=count($row)?></span></td>
							<td><?=$exRate?></td>
						</tr>
						<tr>
							<td colspan="4">
								<table class="subtable jong" id="stockTable">
									<colgroup>
										<col style="width:20%;">
										<col style="width:*;">
										<col style="width:12%;">
										<col style="width:12%;">
										<col style="width:12%;">
									</colgroup>
									<tr>
										<th>종목명</th>
										<th>종목 메모</th>
										<th>보유 갯수</th>
										<th>보유 평단<br>(달러기준)</th>
										<th>매수환율</th>
									</tr>
								<?
									foreach($row as $v){
										$sAmt = str_replace('.00','',$v['sAmt']);
										$sExc = str_replace('.00','',$v['sExc']);
								?>
									<tr id="groupList_<?=$v['uid']?>">
										<td id='symbol_<?=$v['uid']?>'><?=$v['symbol']?></td>
										<td><input type='text' name='msg_<?=$v['uid']?>' value="<?=$v['memo']?>" class='msgData'></td>
										<td><input type='text' name='sNum_<?=$v['uid']?>' id='sNum_<?=$v['uid']?>' value="<?=$v['sNum']?>" class='numberOnly'>개</td>
										<td><input type='text' name='sAmt_<?=$v['uid']?>' id='sAmt_<?=$v['uid']?>' value="<?=$sAmt?>" class='numberOnly'>달러</td>
										<td>
											<input type='hidden' name='chk[]' value="<?=$v['uid']?>" class="chklist">
											<input type='text' name='sExc_<?=$v['uid']?>' id='sExc_<?=$v['uid']?>' value="<?=$sExc?>" class='numberOnly'>원
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
			<a class="blueBtn2" href="<?=$_SERVER['PHP_SELF']?>" title="포트폴리오 목록" style="margin: 70px auto 0;">포트폴리오 목록</a>
			<a class="blueBtn2" href="javascript:groupSave();" title="종목 저장" style="margin: 70px auto 0;">종목 저장</a>
		</div>

</form>