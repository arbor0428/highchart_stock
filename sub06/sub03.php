<?
	include '../header.php';

	//�ɺ�üũ
	include 'symbolCheck.php';
?>

<div id="sub_cont">
	<div class="inner">
		<?
			include 'ticker_top.php';

			$tabBtn = 1;	//��������
			$subBtn = 3;	//�����ְ�/MDD
			include 'tabMenu.php';
		?>	

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">
			<?
				include 'properMDD.php';
			?>
			</div>
			<div class="ticker_tabBox">
				
			</div>
		</div>

	</div>
</div>


<?
	include '../footer.php';
?>