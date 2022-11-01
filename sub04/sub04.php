<?
	include '../header.php';
?>



<div id="sub_cont">
	<div class="sub_center">
		<?
			include 'investquote.php';


			if(!$type)	$type = 'list';

			if($type == 'list')			include 'sub04_list.php';
			elseif($type == 'write')	include 'sub04_write.php';
			elseif($type == 'detail')	include 'sub04_detail.php';
		?>
	</div>
</div>

<?
	include '../footer.php';
?>