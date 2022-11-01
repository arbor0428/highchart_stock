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

header .nav_sub_wrap .nav_sub:nth-child(2) .inner > ul > li:nth-child(2) .nav_depth3 {
	display: block;
}
</style>


<div id="sub_cont">
	<?
		include 'Sidebar.php';
	?>
	<div class="sub_center">
		<div class="dividend_wrap">
			<?
				include 'sub02_01.php';
			?>
			<?
				include 'sub02_02.php';
			?>
			<?
				include 'sub02_03.php';
			?>
		</div>
	</div>
</div>

<script>
    function fnMove(seq){
        var offset = $("#cont" + seq).offset();
		var menuHeight =$("header").offsetHeight;
        $('html, body').animate({scrollTop : offset.top - 250}, 400);
    }
</script>

<?
	include '../footer.php';
?>