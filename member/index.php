<?
include '../head.php';
include '../module/loading.php';

if($GBL_MTYPE != 'A'){
	header('Location:/');
	exit;
}
?>


<div id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">
		<?
			$sideArr[3] = 'active';
			include '../sidemenu.php';
		?>
		
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">
				<?
					include '../nav.php';
				?>
				<!-- Page Content -->
				<div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">
						<div class="col-sm mb-4">
							<div class="card shadow mb-4">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary"><i class="far fa-calendar-check"></i> 담당자관리</h6>
									<div style="float:right;">
										<a href="javascript:memberPop('w','');" class="btn btn-primary btn-icon-split">
											<span class="icon text-white-50">
												<i class="fas fa-flag"></i>
											</span>
											<span class="text">신규등록</span>
										</a>
									</div>
								</div>

								<div class="card-body">
								<?
									include 'list.php';
								?>
								</div>
							</div>
						</div>
                    </div>

				</div>
				<!-- End of Page Content -->
			</div>
			<!-- End of Main Content -->			

			<?
				include '../footer.php';
			?>
		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

</div>


