<?
	include '../header.php';
?>

<style>
header .h_bot .nav > li:nth-child(2) > a {    
	background-color: #e26f12;
    color: #0c1540;
    font-weight: 700;
}
header .nav_sub_wrap .nav_sub:nth-child(2) {
	display: block;
}
header .nav_sub_wrap .nav_sub:nth-child(2) .depth3_bg {
	display: block;
}

header .nav_sub_wrap .nav_sub:nth-child(2) .inner > ul > li:nth-child(4) .nav_depth3 {
	display: block;
}
</style>

<div id="sub_cont">
	<?
		include 'Sidebar.php';
	?>
	<div class="sub_center">
	<?
		//요즘 장 분위기를 대결하는 테마들로 파악해 보세요.
		include 'sub04_01.php';

		//투자할 만한 테마 어디 없을까?
		include 'sub04_02.php';
	?>
	</div>
</div>

<script>
function fnMove(seq){
	var offset = $("#cont" + seq).offset();
	$('html, body').animate({scrollTop : offset.top - 250}, 400);
}

$(".nav_depth3 > li").on("click",function(event){

	event.preventDefault();

	$(".nav_depth3 > li").removeClass("on");
	$(this).addClass("on");

});

<?if($seq){?>
$(document).ready(function(){
	fnMove('<?=$seq?>');
});
<?}?>
</script>

<?
	include '../footer.php';
?>