<style>
.searchBoxWrap {margin: 100px 0 70px; width: 100%;}
.searchBoxWrap .searchBox {margin-right: 20px; border: 1px solid #efefef; height: 45px; box-shadow: rgb(149 157 165 / 20%) 0px 4px 24px; border-radius: 5px;}
.searchBoxWrap .searchADD {display: block; width: 40px; height: 40px; border-radius: 50%; background-color: #000; color: #fff; text-align: center; line-height: 40px; font-size: 28px; font-weight: 700;}
.searchBoxWrap input{width:100%;height:30px;}
.blueBtn {margin-left: 20px; display: block; border-radius: 45px; width: 150px; height: 45px; line-height: 45px; text-align: center; color: #fff; background-color: #0c1540;}
</style>

<script>
function groupAdd(){
	groupTitle = $('#groupTitle').val();
	if(groupTitle == ''){
		GblMsgBox("그룹명을 입력해 주시기 바랍니다.");
		return;
	}

	groupMemo = $('#groupMemo').val();
	if(groupMemo == ''){
		GblMsgBox("그룹 메모를 입력해 주시기 바랍니다.");
		return;
	}

	$.post('/module/json/userGroup.php',{'userid':'<?=$GBL_USERID?>','type':'write','groupTitle':groupTitle,'groupMemo':groupMemo}, function(result){
		parData = JSON.parse(result);
		code = parData['code'];

		if(code == '101'){
			GblMsgBox("그룹은 최대 10개까지 등록 가능합니다.");
			return;

		}else if(code == '99'){
			$('#emptyMsg').remove();

			strHtml = "<tr>";
			strHtml += "<td title='그룹명'>"+groupTitle+"</td>";
			strHtml += "<td title='그룹 메모'>"+groupMemo+"</td>";
			strHtml += "<td title='종목수'>0</td>";
			strHtml += "<td title='설정'><a href='' class='small cbtn blue'>종목 추가/편집</a></td>";
			strHtml += "</tr>";

			$("#groupListTable").append(strHtml);

			$('#groupTitle').val('');
			$('#groupMemo').val('');

		}else{
			GblMsgBox("Error");
			return;
		}
	});	
}

function groupDetail(gid){
	form = document.frm_group;
	form.type.value = 'detail';
	form.gid.value = gid;
	form.target = '';
	form.action = "<?=$_SERVER['PHP_SELF']?>";
	form.submit();
}
</script>

<form name='frm_group' id='frm_group' method='post' action="<?=$_SERVER['PHP_SELF']?>">
<input type='text' style='display:none;'>
<input type='hidden' name='type' value=''>
<input type='hidden' name='gid' value=''>

<div class="searchBoxWrap dp_f dp_cc dp_c">
	<div class="searchBox dp_f dp_c" style="padding: 0 10px; width: 250px;">
		<input type="text" name="groupTitle" id="groupTitle" value="" placeholder="그룹명 설정" onkeypress="if(event.keyCode==13){groupAdd();}">
	</div>
	<div class="searchBox dp_f dp_c" style="padding: 0 10px;  width: 400px;">
		<input type="text" name="groupMemo" id="groupMemo" value="" placeholder="그룹 메모 작성" onkeypress="if(event.keyCode==13){groupAdd();}">
	</div>
	<a class="searchADD" href="javascript:groupAdd();" title="추가">+</a>
</div>

<div class="dp_sb dp_c" style="margin-top: 30px;">
	<table class="subtable" id="groupListTable">
		<tbody>
			<tr>
				<th style="width:20%;">그룹명</th>
				<th style="width:*;">그룹 메모</th>
				<th style="width:10%;">종목수</th>
				<th style="width:10%;">관리</th>
			</tr>
		<?
			//등록된 그룹 확인
			$grow = sqlArray("select * from ks_userGroup where userid='".$GBL_USERID."' order by sortNum");

			if($grow){
				foreach($grow as $v){
					//종목정보
					$gsNum = sqlRowOne("select count(*) from ks_userGroupData where userid='".$GBL_USERID."' and gid=".$v['uid']."");
		?>
			<tr>
				<td title="그룹명"><?=$v['title']?></td>
				<td title="그룹 메모"><?=$v['memo']?></td>
				<td title="종목수"><?=$gsNum?></td>
				<td title="설정"><a href="javascript:groupDetail(<?=$v['uid']?>)" class="small cbtn blue">종목 추가/편집</a></td>
			</tr>
		<?
				}
			}else{
		?>
			<tr id='emptyMsg'>
				<td colspan='4' height='100'>등록된 그룹이 없습니다.</td>
			</tr>
		<?
			}
		?>
		</tbody>
	</table>
<!--
	<a class="blueBtn" href="sub03_search.php" title="종목 추가/편집">종목 추가/편집</a>
-->
</div>

</form>