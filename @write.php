<?
	include 'head.php';
?>



<div id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

		<?
			include 'sidemenu.php';
		?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

				<?
					include 'nav.php';
				?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                  

                    <!-- Content Row -->

						
						<div class="card shadow mb-4">
							<div class="card-body">
								<p class="tit">과제정보</p>

								<div class="tbl-st">
									<div class="cols">
										<div class="cols_20 cols_ th">과제명</div>
										<div class="cols_80 cols_">산업정보 연계 주요국 특허 영-한 데이터</div>
									</div>
									<div class="cols">
										<div class="cols_20 cols_ th">과제기간</div>
										<div class="cols_80 cols_">
											<label>
												<input type="date" id="start" class="form-control" name="start" value="2021-08-01">
											</label>
											~ 
											<label>
												<input type="date" id="end" class="form-control" name="end" value="2021-08-31">
											</label>
										</div>
									</div>
								</div>

								<p class="tit">사업개요</p>

								<div class="tbl-st">
									<div class="cols">
										<div class="cols_20 cols_ th">사업목적</div>
										<div class="cols_80 cols_">
											<textarea id="txt02" class="form-control" name="txt" cols="50" rows="5" style="width:100%; resize:none;"></textarea>
										</div>
									</div>
									<div class="cols">
										<div class="cols_20 cols_ th">추진근거</div>
										<div class="cols_80 cols_">
											<textarea id="txt02" class="form-control" name="txt" cols="50" rows="5" style="width:100%; resize:none;"></textarea>
										</div>
									</div>

									<div class="cols">
										<div class="cols_20 cols_ th">추진경위</div>
										<div class="cols_80 cols_">
											<textarea id="txt03" class="form-control" name="txt" cols="50" rows="5" style="width:100%; resize:none;"></textarea>
										</div>
									</div>
								</div>

								<p class="tit">기관정보</p>
								
								<div class="mo-hand2 mo-hand" style="text-align:right;">
									<span class="scorll-hand">
										<img src="img/scroll_hand.gif" style="max-width:100%;">
									</span>
								</div>

								<div class="tbl-st-wrap">
									<div class="tbl-st-w tbl-st mb20 clearfix">
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">참여구분</div>
											<div class="cols_">
												<select class="custom-select custom-select-sm form-control form-control-sm">
													<option value="">총괄책임자</option>
													<option value="">관리자</option>
													<option value="">사원</option>
												</select>
											</div>
										</div>
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">이름</div>
											<div class="cols_">
												<label>
													<input type="text" id="name" class="form-control" name="name">
												</label>
											</div>
										</div>
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">시작일자</div>
											<div class="cols_">
												<label>
													<input type="text" id="date01" class="form-control" name="date" placeholder="20210101">
												</label>
											</div>
										</div>
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">종료일자</div>
											<div class="cols_">
												<label>
													<input type="text" id="date02" class="form-control" name="date" placeholder="20210101">
												</label>
											</div>
										</div>
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">참여율(%)</div>
											<div class="cols_">
												<label>
													<input type="text" id="" class="form-control" name="">
												</label>
											</div>
										</div>
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">이메일</div>
											<div class="cols_">
												<label>
													<input type="text" id="" class="form-control" name="">
												</label>
											</div>
										</div>
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">핸드폰번호</div>
											<div class="cols_">
												<label>
													<input type="text" id="" class="form-control" name="" placeholder="01012345678">
												</label>
											</div>
										</div>
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">성별</div>
											<div class="cols_">
												<input type="radio" id="gender01" name="gender" value="man">
												<label for="man">남자</label>

												&nbsp; <input type="radio" id="gender02" name="gender" value="woman">
												<label for="woman">여자</label>
											</div>
										</div>
										<div class="rows w10 br-r">
											<div class="cols_ th txt-c">생년월일</div>
											<div class="cols_">
												<label>
													<input type="text" id="" class="form-control" name="" placeholder="19900101">
												</label>
											</div>
										</div>
										<div class="rows w10">
											<div class="cols_ th txt-c">카드발급여부</div>
											<div class="cols_">
												<select class="custom-select custom-select-sm form-control form-control-sm">
													<option value="">예</option>
													<option value="">아니오</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


					<!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
				<?
					include 'footer.php';
				?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

</div>


