<?
	include '../header.php';

	//�ɺ�üũ
	include 'symbolCheck.php';

	//�޷�
	include '../module/datepicker/Calendar.php';
?>

<div id="sub_cont">
	<div class="inner">
		<?
			include 'ticker_top.php';

			$tabBtn = 1;	//��������
			$subBtn = 6;	//��������/�����ڰŷ�
			include 'tabMenu.php';
		?>	

		<div class="ticker_tabWrap">
			<div class="ticker_tabBox">

			<?
				//�� ���� �ֽ� �� �� �� ������ �տ� �ִ� �ɱ��?
				include 'stocksHand.php';
			?>

				<div id='insiderGroup'>
				<?
					if(!$f_symbol && !$f_sTxt)	$f_symbol = $gbl_symbol;

					if(!$f_sDate)	$f_sDate = date('Y-m-d', strtotime('-1 years'));

					//�˻�
					include '../sub01/insider_search.php';

					//����Ʈ
					include '../sub01/insider_list.php';
				?>
				</div>
			</div>
		</div>

	</div>
</div>
<style>
	.datepicker.dropdown-menu {margin-top: 130px;}
</style>

<?
//�����ڰŷ� ������ ��ũ��
if($insiderChk){
?>
<script>
$(document).ready(function(){
	var offset = $("#insiderGroup").offset();
	$('html, body').animate({scrollTop : offset.top - 400}, 400);
});
</script>
<?
}
?>

<?
	include '../footer.php';
?>