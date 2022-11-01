<?
	include '../header.php';
?>



<div id="sub_cont">
	<div class="sub_center">
		<?
			include 'investquote.php';


			if(!$type)	$type = 'list';

			if($type == 'list')			include 'sub03_list.php';
			elseif($type == 'write')	include 'sub03_write.php';
			elseif($type == 'detail')	include 'sub03_detail.php';
		?>
	</div>
</div>

<?
	include '../footer.php';
?>