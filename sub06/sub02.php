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
			$subBtn = 2;	//�������м�
			include 'tabMenu.php';
		?>	

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">
			<?
				include 'expertAnalysis.php';
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