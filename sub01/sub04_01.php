<div id="cont1" class="whobetter">
	<h3 class="sub_tit">요즘 장 분위기를 대결하는 테마들로 파악해 보세요.</h3>
<?
	$n = 0;
	$item = sqlArray("select * from ks_thema order by uid asc");
	if($item){
		foreach($item as $v){
			$mod = $n % 2;
			if($mod == 0){
				echo ("<div class='joo_api_wrap'>");
				$bgClass = '';
			}else{
				$bgClass = 'bg_gry';
			}
?>
		<div class="joo_wrap modeBtn" style="overflow:hidden;" data-tid="<?=$v['uid']?>">
		<?
			$symbol01 = $v['symbol01'];
			$label01 = $v['label01'];
			$title01 = $v['title01'];
			$msg01 = $v['msg01'];						

			//우측 데이터
			$symbol02 = $v['symbol02'];
			$label02 = $v['label02'];
			$title02 = $v['title02'];
			$msg02 = $v['msg02'];
			
			$graphID = 'whosbetter'.$n;		//그래프ID

			include '../isGood.php';
		?>
		</div>
<?
			if($mod == 1){
				echo ("</div>");
			}
			$n++;
		}

		if($mod == 0){
			echo ("</div>");
		}
	}
?>
</div>

<script>
function tema(t){
	$("#multiBox").css({"width":"90%","max-width":"1280px"});
	//$('#multi_ttl').text('test');
	$('#multiFrame').html("<iframe src='/sub01/temaframe.php?uid="+t+"' name='' style='width:100%;height:650px;' frameborder='0' scrolling='auto'></iframe>");
	$('.multiBox_open').click();
}

$(".joo_api_wrap > .modeBtn").click(function(event){
	tid = $(this).data('tid');
	tema(tid);
	event.preventDefault();
});
</script>