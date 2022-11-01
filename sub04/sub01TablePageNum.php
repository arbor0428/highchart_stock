<style>
.pageNum *{-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}
.pageNum{padding:24px 0;text-align:center}
.pageNum a,.pageNum strong{display:inline-block;min-width:12px;height:24px;padding:0 6px;border:1px solid transparent;border-radius:2px;font:700 12px/2em Tahoma,AppleGothic,sans-serif;letter-spacing:-1px;*display:inline;*zoom:1}
.pageNum a{color:#999;text-decoration:none!important}
.pageNum .this,.pageNum a:hover{background:#F9F9F9;border-color:#AAA;color:#555}
.pageNum .frst_last{color:#555}
.pageNum .direction{margin:0 4px;color:#555;letter-spacing:0;font-weight:400}
.pageNum strong.direction{color:#999}
</style>

<script>
<?
	if($_GET['jQueryLoad']){
?>
$(document).ready(function(){
	offset = parent.$("#ifra_calendar").offset();
	parent.$('html, body').animate({scrollTop : offset.top + 1000}, 400);

	$("#loading").delay("200").fadeOut();
	parent.iFrameHeight('ifra_calendar');
});
<?
	}
?>

function listCall(rcID,rs){
	$('.loader').css('top','80%');
	$('#loading').show();

	rc = $('#'+rcID).val();

	$('#listTable').load('/sub04/<?=$act?>?jQueryLoad=1&cDate=<?=$cDate?>&year=<?=$year?>&month=<?=$month?>&maxdate=<?=$maxdate?>&record_count='+rc+'&record_start='+rs);
}
</script>


<div class="pageNum">
<?
if($total_record != '0'){
?>
	<select name='record_count' id='calendar_rc' class='form-control' style='float:left;' onchange="listCall('calendar_rc',0)">
		<option value='10' <?if($record_count == '10'){echo 'selected';}?>>10개씩 보기</option>
		<option value='30' <?if($record_count == '30'){echo 'selected';}?>>30개씩 보기</option>
		<option value='50' <?if($record_count == '50'){echo 'selected';}?>>50개씩 보기</option>
		<option value='100' <?if($record_count == '100'){echo 'selected';}?>>100개씩 보기</option>
	</select>
<?
	if($total_record > $record_count){
		
		if($current_page * $record_count > $record_count * $link_count) {
			$pre_group_start = ($group * $record_count * $link_count) - $record_count;
			echo ("<a href=javascript:listCall('calendar_rc','$pre_group_start');>≪</a> ");
		}else{
			echo ("<a href=javascript:listCall('calendar_rc','$pre_group_start');>≪</a> ");
		}


		if($total_page > 1 && ($record_start !=0 )) {
			$pre_page_start = $record_start - $record_count;
			echo ("<a href=javascript:listCall('calendar_rc','$pre_page_start'); class='direction'>Prev</a> ");
		}else{
			echo ("<a href=javascript:listCall('calendar_rc','$pre_page_start'); class='direction'>Prev</a> ");
		}







		for($i=0; $i<$link_count; $i++){
			$input_start = ($group * $link_count + $i) * $record_count; 

			$link = ($group * $link_count + $i) + 1;

			if($input_start < $total_record) {
				if($input_start != $record_start) {
					echo ("<a href=javascript:listCall('calendar_rc','$input_start');>$link</a> ");
				} else {
					echo ("<a href=javascript:listCall('calendar_rc','$input_start'); class='frst_last this'>$link</a> ");
				}
			}
		}





		if($total_page > 1 && ($record_start != ($total_page * $record_count - $record_count))) {
			$next_page_start = $record_start + $record_count;
			echo ("<a href=javascript:listCall('calendar_rc','$next_page_start'); class='direction'>Next</a> ");
		}else{
			$next_page_start = $record_start;
			echo ("<a href=javascript:listCall('calendar_rc','$next_page_start'); class='direction'>Next</a> ");
		}


		if($total_record > (($group + 1) * $record_count * $link_count)) {
			$next_group_start = ($group + 1) * $record_count* $link_count;
			echo("<a href=javascript:listCall('calendar_rc','$next_group_start');>≫</a>");
		}else{
			$next_group_start = $record_start;
			echo("<a href=javascript:listCall('calendar_rc','$next_group_start');>≫</a>");
		}



		  
	}else{
		echo ("<a href='#' class='frst_last this'>1</a>");
	}
}
?>
</div>