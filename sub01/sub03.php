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

header .nav_sub_wrap .nav_sub:nth-child(2) .inner > ul > li:nth-child(3) .nav_depth3 {
	display: block;
}
</style>

<div id="sub_cont">
	<?
		include 'Sidebar.php';
	?>
	<div class="sub_center">
	<?
		//최근 투자의견 상향&하향 종목
		include 'sub03_01.php';
/*
		include 'sub03_02.php';
		include 'sub03_03.php';
		include 'sub03_04.php';
		include 'sub03_05.php';
*/
	?>
	</div>
</div>

<script>
    function fnMove(seq){
        var offset = $("#cont" + seq).offset();
        $('html, body').animate({scrollTop : offset.top - 250}, 400);
    }
</script>

<?
	include '../footer.php';
?>