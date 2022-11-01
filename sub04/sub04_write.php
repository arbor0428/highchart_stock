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
		GblMsgBox("포트폴리오명을 입력해 주시기 바랍니다.");
		return;
	}

	groupMemo = $('#groupMemo').val();
	if(groupMemo == ''){
		GblMsgBox("포트폴리오 메모를 입력해 주시기 바랍니다.");
		return;
	}

	$.post('/module/json/userPortfolio.php',{'userid':'<?=$GBL_USERID?>','type':'write','groupTitle':groupTitle,'groupMemo':groupMemo}, function(result){
		parData = JSON.parse(result);
		code = parData['code'];

		if(code == '101'){
			GblMsgBox("포트폴리오는 최대 10개까지 등록 가능합니다.");
			return;

		}else if(code == '99'){
			$('#emptyMsg').remove();

			strHtml = "<tr>";
			strHtml += "<td title='포트폴리오명'>"+groupTitle+"</td>";
			strHtml += "<td title='포트폴리오 메모'>"+groupMemo+"</td>";
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
		<input type="text" name="groupTitle" id="groupTitle" value="" placeholder="포트폴리오명 설정" onkeypress="if(event.keyCode==13){groupAdd();}">
	</div>
	<div class="searchBox dp_f dp_c" style="padding: 0 10px;  width: 400px;">
		<input type="text" name="groupMemo" id="groupMemo" value="" placeholder="포트폴리오 메모 작성" onkeypress="if(event.keyCode==13){groupAdd();}">
	</div>
	<a class="searchADD" href="javascript:groupAdd();" title="추가">+</a>
</div>

<div class="dp_sb dp_c" style="margin-top: 30px;">
	<table class="subtable" id="groupListTable">
		<tbody>
			<tr>
				<th style="width:20%;">포트폴리오명</th>
				<th style="width:*;">포트폴리오 메모</th>
				<th style="width:10%;">종목수</th>
				<th style="width:10%;">관리</th>
			</tr>
		<?
			//등록된 포트폴리오 확인
			$grow = sqlArray("select * from ks_userPortfolio where userid='".$GBL_USERID."' order by sortNum");

			if($grow){
				foreach($grow as $v){
					//종목정보
					$gsNum = sqlRowOne("select count(*) from ks_userPortfolioData where userid='".$GBL_USERID."' and gid=".$v['uid']."");
		?>
			<tr>
				<td title="포트폴리오명"><?=$v['title']?></td>
				<td title="포트폴리오 메모"><?=$v['memo']?></td>
				<td title="종목수"><?=$gsNum?></td>
				<td title="설정"><a href="javascript:groupDetail(<?=$v['uid']?>)" class="small cbtn blue">종목 추가/편집</a></td>
			</tr>
		<?
				}
			}else{
		?>
			<tr id='emptyMsg'>
				<td colspan='4' height='100'>등록된 포트폴리오가 없습니다.</td>
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