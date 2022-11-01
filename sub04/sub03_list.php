<style>
/* 	.diary_nav_sub {display: block;} */
.jongmok_no {padding: 150px 0; border-top: 4px solid #eaebee; text-align: center;}
.jongmok_no p {font-size: 20px; font-weight: 500;}
.blueBtn {display: block; margin: 150px auto 0; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
</style>

<?
	//등록된 관심종목 확인
	$grow = sqlArray("select * from ks_userGroup where userid='".$GBL_USERID."' order by sortNum");

	if(!$grow){
?>


<div class="jongmok_no">
	<p>현재 관심종목이 없습니다.</p>
	<a class="blueBtn" href="<?=$_SERVER['PHP_SELF']?>?type=write" title="새로 작성하기">새로 작성하기</a>
</div>

<?
	}else{
?>
<script>
function groupDel(uid){
	GblMsgConfirmBox("해당 그룹을 삭제하시겠습니까?","groupDelOk("+uid+")");
}

function groupDelOk(uid){
	$.post('/module/json/userGroup.php',{'userid':'<?=$GBL_USERID?>','type':'del','uid':uid}, function(result){
		parData = JSON.parse(result);
		code = parData['code'];

		if(code == '99'){
			$('#groupList_'+uid).remove();

		}else{
			GblMsgBox("Error");
			return;
		}
	});	
}

function groupEdit(uid){
	$("#titleBox").css({"width":"90%","max-width":"700px"});
	$('#titleFrame').html("<iframe name='gEdit' id='gEdit' src='sub03_groupEdit.php?uid="+uid+"' style='width:100%;height:250px;' frameborder='0' scrolling='auto'></iframe>");
	$('.titleBox_open').click();
}

function groupDetail(gid){
	form = document.frm_group;
	form.type.value = '';
	form.gid.value = gid;
	form.target = '';
	form.action = "sub03_groupDetail.php";
	form.submit();
}
</script>

<form name='frm_group' id='frm_group' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type='text' style='display:none;'>
<input type='hidden' name='type' value=''>
<input type='hidden' name='gid' value=''>

<div class="interestList">
	<table class="subtable">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: 30%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
		</colgroup>
		<tbody>
			<tr>	
				<th>그룹명</th>
				<th>그룹 메모</th>
				<th>종목수</th>
				<th>6개월 수익률</th>
				<th>1년 수익률</th>
				<th>5년 수익률</th>
				<th>배당률<br>(현재)</th>
			</tr>
		<?
			foreach($grow as $v){
				//종목정보
				$row = sqlArray("select * from ks_userGroupData where userid='".$GBL_USERID."' and gid=".$v['uid']." order by sortNum");

				$percentTot = sqlRowOne("select sum(percent) from ks_userGroupData where userid='".$GBL_USERID."' and gid=".$v['uid']);
		?>
			<tr id="groupList_<?=$v['uid']?>">	
				<td>
					<div class="groupTit dp_sb dp_c" >
						<a class="editBtn dp_f dp_c" href="javascript:groupEdit('<?=$v['uid']?>')" title="수정"><span class="lnr lnr-pencil"></span></a>
						<a class="detailMove" href="javascript:groupDetail(<?=$v['uid']?>)"><?=$v['title']?></a>
						<a class="delbtn" href="javascript:groupDel('<?=$v['uid']?>')" title="제거">-</a>
					</div>
				</td>
				<td><?=$v['memo']?></td>
				<td><?=count($row)?></td>
			<?
				if($percentTot == '100'){
					$pData01 = 0;		//6개월 수익률
					$pData02 = 0;		//1년 수익률
					$pData03 = 0;		//5년 수익률
					$pData04 = 0;		//배당률 수익률

					foreach($row as $s){
						$percent = $s['percent'];
						$symbol = $s['symbol'];

						//종목별 수익률
						$item = sqlRow("select * from Stock_Candles_Last where symbol='".$symbol."'");

						$pData01 += (($item['pmDataMonth6'] / 100) * $percent);
						$pData02 += (($item['pmDataYear1'] / 100) * $percent);
						$pData03 += (($item['pmDataYear5'] / 100) * $percent);

						//배당률
						$currentDividendYieldTTM = sqlRowOne("select currentDividendYieldTTM from api_Basic_Financials where symbol='".$symbol."'");
						$pData04 += (($currentDividendYieldTTM / 100) * $percent);
					}
			?>
				<td><?=number_format($pData01,2)?>%</td>
				<td><?=number_format($pData02,2)?>%</td>
				<td><?=number_format($pData03,2)?>%</td>
				<td><?=number_format($pData04,2)?>%</td>
			<?
				}else{
			?>
				<td colspan='4' style='color:#d1d1d1;'>종목 비중 합을 100%로 설정해 주세요.</td>
			<?
				}
			?>
			</tr>
		<?
			}
		?>
		</tbody>
	</table>

	<a class="blueBtn" href="<?=$_SERVER['PHP_SELF']?>?type=write" title="그룹 추가하기" style="margin: 70px auto 0;">그룹 추가하기</a>
</div>

</form>

<?
	}
?>
	<!---그룹명 눌렀을 때 각각 나타나는 종목 상세 테이블
	<div class="jongmokList">
		<table class="subtable">
				<tr>
					<th>그룹명</th>
					<th>그룹 메모</th>
					<th>종목수</th>
				</tr>
				<tr>
					<td>10년 존버</td>
					<td>10배 가즈아 떨어질때만 분할매수하기 노매도</td>
					<td>2</td>
				</tr>
				<tr>
					<td colspan="3">
						<table class="subtable jong">
								<colgroup>
									<col style="width: 207px;">
								</colgroup>
								<tr>
									<th>종목명</th>
									<th>종목 메모</th>
									<th>
										<div class="optTit ">
											종목 비중(옵션)
										</div>
										<a class="sameR" href="" title="균등비중적용">균등비중적용</a>
									</th>
								</tr>
								<tr>
									<td>애플</td>
									<td>갓플!</td>
									<td>
										40%
									</td>
								</tr>
								<tr>
									<td>앤비디아</td>
									<td>코인은 갔지만 메타버스가 오겠지?</td>
									<td>
										60%
									</td>
								</tr>
						</table>
					</td>
				</tr>
		</table>
	</div>
--->

